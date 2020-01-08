<?php
//testing base

use PHPUnit\Framework\TestCase;

final class ManagementTest extends TestCase
{
  
   public function testShouldSuccesslicense(): void
   {
      $this->assertInstanceOf(
         ManagementWeb\Management::class,
         ManagementWeb\Management::initialize()
      );
   }
}
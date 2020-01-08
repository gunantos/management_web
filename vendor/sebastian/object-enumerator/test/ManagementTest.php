<?php
//testing base

use PHPUnit\Framework\TestCase;

final class ManagementTest extends TestCase
{
  
   public function testShouldSuccesslicense(): void
   {
      $this->assertInstanceOf(
          morait\management_web\management::class,
          morait\management_web\management::initialize()
      );
   }
}
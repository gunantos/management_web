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
   public function testCanBeUsedAsString(): void
    {
        $this->assertEquals(
            'user@example.com',
            Email::fromString('user@example.com')
        );
    }
}
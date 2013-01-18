<?php

/*
 * This file is part of the Datum package.
 *
 * (c) Brian Nesbitt <brian@nesbot.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Datum\Datum;

class ConstructTest extends TestFixture
{
   public function testCreatesAnInstanceDefaultToNow()
   {
      $c = new Datum();
      $now = Datum::now();
      $this->assertEquals('Datum\Datum', get_class($c));
      $this->assertEquals($now->tzName, $c->tzName);
      $this->assertDatum($c, $now->year, $now->month, $now->day, $now->hour, $now->minute, $now->second);
   }

   public function testWithFancyString()
   {
      $c = new Datum('first day of January 2008');
      $this->assertDatum($c, 2008, 1, 1, 0, 0, 0);
   }

   public function testDefaultTimezone()
   {
      $c = new Datum('now');
      $this->assertSame('America/Toronto', $c->tzName);
   }

   public function testSettingTimezone()
   {
      $c = new Datum('now', new \DateTimeZone('America/Cayman'));
      $this->assertSame('America/Cayman', $c->tzName);
      $this->assertSame(-5, $c->offsetHours);
   }

   public function testSettingTimezoneWithString()
   {
      $c = new Datum('now', 'Asia/Tokyo');
      $this->assertSame('Asia/Tokyo', $c->tzName);
      $this->assertSame(9, $c->offsetHours);
   }
}

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

class CreateFromTimeTest extends TestFixture
{
   public function testCreateFromDateWithDefaults()
   {
      $d = Datum::createFromTime();
      $this->assertSame($d->timestamp, Datum::create(null, null, null, null, null, null)->timestamp);
   }

   public function testCreateFromDate()
   {
      $d = Datum::createFromTime(23, 5, 21);
      $this->assertDatum($d, Datum::now()->year, Datum::now()->month, Datum::now()->day, 23, 5, 21);
   }

   public function testCreateFromTimeWithHour()
   {
      $d = Datum::createFromTime(22);
      $this->assertSame(22, $d->hour);
      $this->assertSame(0, $d->minute);
      $this->assertSame(0, $d->second);
   }

   public function testCreateFromTimeWithMinute()
   {
      $d = Datum::createFromTime(null, 5);
      $this->assertSame(5, $d->minute);
   }

   public function testCreateFromTimeWithSecond()
   {
      $d = Datum::createFromTime(null, null, 21);
      $this->assertSame(21, $d->second);
   }

   public function testCreateFromTimeWithDateTimeZone()
   {
      $d = Datum::createFromTime(12, 0, 0, new \DateTimeZone('Europe/London'));
      $this->assertDatum($d, Datum::now()->year, Datum::now()->month, Datum::now()->day, 12, 0, 0);
      $this->assertSame('Europe/London', $d->tzName);
   }
   public function testCreateFromTimeWithTimeZoneString()
   {
      $d = Datum::createFromTime(12, 0, 0, 'Europe/London');
      $this->assertDatum($d, Datum::now()->year, Datum::now()->month, Datum::now()->day, 12, 0, 0);
      $this->assertSame('Europe/London', $d->tzName);
   }
}

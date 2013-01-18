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

class CreateFromDateTest extends TestFixture
{
   public function testCreateFromDateWithDefaults()
   {
      $d = Datum::createFromDate();
      $this->assertSame($d->timestamp, Datum::create(null, null, null, null, null, null)->timestamp);
   }

   public function testCreateFromDate()
   {
      $d = Datum::createFromDate(1975, 5, 21);
      $this->assertDatum($d, 1975, 5, 21);
   }

   public function testCreateFromDateWithYear()
   {
      $d = Datum::createFromDate(1975);
      $this->assertSame(1975, $d->year);
   }

   public function testCreateFromDateWithMonth()
   {
      $d = Datum::createFromDate(null, 5);
      $this->assertSame(5, $d->month);
   }

   public function testCreateFromDateWithDay()
   {
      $d = Datum::createFromDate(null, null, 21);
      $this->assertSame(21, $d->day);
   }

   public function testCreateFromDateWithTimezone()
   {
      $d = Datum::createFromDate(1975, 5, 21, 'Europe/London');
      $this->assertDatum($d, 1975, 5, 21);
      $this->assertSame('Europe/London', $d->tzName);
   }

   public function testCreateFromDateWithDateTimeZone()
   {
      $d = Datum::createFromDate(1975, 5, 21, new \DateTimeZone('Europe/London'));
      $this->assertDatum($d, 1975, 5, 21);
      $this->assertSame('Europe/London', $d->tzName);
   }
}

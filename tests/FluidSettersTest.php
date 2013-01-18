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

class FluidSettersTest extends TestFixture
{
   public function testFluidYearSetter()
   {
      $d = Datum::now();
      $this->assertTrue($d->year(1995) instanceof Datum);
      $this->assertSame(1995, $d->year);
   }

   public function testFluidMonthSetter()
   {
      $d = Datum::now();
      $this->assertTrue($d->month(3) instanceof Datum);
      $this->assertSame(3, $d->month);
   }
   public function testFluidMonthSetterWithWrap()
   {
      $d = Datum::createFromDate(2012, 8, 21);
      $this->assertTrue($d->month(13) instanceof Datum);
      $this->assertSame(1, $d->month);
   }

   public function testFluidDaySetter()
   {
      $d = Datum::now();
      $this->assertTrue($d->day(2) instanceof Datum);
      $this->assertSame(2, $d->day);
   }
   public function testFluidDaySetterWithWrap()
   {
      $d = Datum::createFromDate(2000, 1, 1);
      $this->assertTrue($d->day(32) instanceof Datum);
      $this->assertSame(1, $d->day);
   }

   public function testFluidSetDate()
   {
      $d = Datum::createFromDate(2000, 1, 1);
      $this->assertTrue($d->setDate(1995, 13, 32) instanceof Datum);
      $this->assertDatum($d, 1996, 2, 1);
   }

   public function testFluidHourSetter()
   {
      $d = Datum::now();
      $this->assertTrue($d->hour(2) instanceof Datum);
      $this->assertSame(2, $d->hour);
   }
   public function testFluidHourSetterWithWrap()
   {
      $d = Datum::now();
      $this->assertTrue($d->hour(25) instanceof Datum);
      $this->assertSame(1, $d->hour);
   }

   public function testFluidMinuteSetter()
   {
      $d = Datum::now();
      $this->assertTrue($d->minute(2) instanceof Datum);
      $this->assertSame(2, $d->minute);
   }
   public function testFluidMinuteSetterWithWrap()
   {
      $d = Datum::now();
      $this->assertTrue($d->minute(61) instanceof Datum);
      $this->assertSame(1, $d->minute);
   }

   public function testFluidSecondSetter()
   {
      $d = Datum::now();
      $this->assertTrue($d->second(2) instanceof Datum);
      $this->assertSame(2, $d->second);
   }
   public function testFluidSecondSetterWithWrap()
   {
      $d = Datum::now();
      $this->assertTrue($d->second(62) instanceof Datum);
      $this->assertSame(2, $d->second);
   }

   public function testFluidSetTime()
   {
      $d = Datum::createFromDate(2000, 1, 1);
      $this->assertTrue($d->setTime(25, 61, 61) instanceof Datum);
      $this->assertDatum($d, 2000, 1, 2, 2, 2, 1);
   }

   public function testFluidTimestampSetter()
   {
      $d = Datum::now();
      $this->assertTrue($d->timestamp(10) instanceof Datum);
      $this->assertSame(10, $d->timestamp);
   }
}

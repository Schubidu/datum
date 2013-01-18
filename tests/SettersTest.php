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

class SettersTest extends TestFixture
{
   public function testYearSetter()
   {
      $d = Datum::now();
      $d->year = 1995;
      $this->assertSame(1995, $d->year);
   }

   public function testMonthSetter()
   {
      $d = Datum::now();
      $d->month = 3;
      $this->assertSame(3, $d->month);
   }
   public function testMonthSetterWithWrap()
   {
      $d = Datum::now();
      $d->month = 13;
      $this->assertSame(1, $d->month);
   }

   public function testDaySetter()
   {
      $d = Datum::now();
      $d->day = 2;
      $this->assertSame(2, $d->day);
   }
   public function testDaySetterWithWrap()
   {
      $d = Datum::createFromDate(2012, 8, 5);
      $d->day = 32;
      $this->assertSame(1, $d->day);
   }

   public function testHourSetter()
   {
      $d = Datum::now();
      $d->hour = 2;
      $this->assertSame(2, $d->hour);
   }
   public function testHourSetterWithWrap()
   {
      $d = Datum::now();
      $d->hour = 25;
      $this->assertSame(1, $d->hour);
   }

   public function testMinuteSetter()
   {
      $d = Datum::now();
      $d->minute = 2;
      $this->assertSame(2, $d->minute);
   }
   public function testMinuteSetterWithWrap()
   {
      $d = Datum::now();
      $d->minute = 65;
      $this->assertSame(5, $d->minute);
   }

   public function testSecondSetter()
   {
      $d = Datum::now();
      $d->second = 2;
      $this->assertSame(2, $d->second);
   }
   public function testSecondSetterWithWrap()
   {
      $d = Datum::now();
      $d->second = 65;
      $this->assertSame(5, $d->second);
   }

   public function testTimestampSetter()
   {
      $d = Datum::now();
      $d->timestamp = 10;
      $this->assertSame(10, $d->timestamp);

      $d->setTimestamp(11);
      $this->assertSame(11, $d->timestamp);
   }

   public function testSetTimezoneWithInvalidTimezone()
   {
      $this->setExpectedException('InvalidArgumentException');
      $d = Datum::now();
      $d->setTimezone('sdf');
   }
   public function testTimezoneWithInvalidTimezone()
   {
      $this->setExpectedException('InvalidArgumentException');
      $d = Datum::now();
      $d->timezone = 'sdf';
   }
   public function testTzWithInvalidTimezone()
   {
      $this->setExpectedException('InvalidArgumentException');
      $d = Datum::now();
      $d->tz = 'sdf';
   }
   public function testSetTimezoneUsingString()
   {
      $d = Datum::now();
      $d->setTimezone('America/Toronto');
      $this->assertSame('America/Toronto', $d->tzName);
   }
   public function testTimezoneUsingString()
   {
      $d = Datum::now();
      $d->timezone = 'America/Toronto';
      $this->assertSame('America/Toronto', $d->tzName);
   }
   public function testTzUsingString()
   {
      $d = Datum::now();
      $d->tz = 'America/Toronto';
      $this->assertSame('America/Toronto', $d->tzName);
   }
   public function testSetTimezoneUsingDateTimeZone()
   {
      $d = Datum::now();
      $d->setTimezone(new \DateTimeZone('America/Toronto'));
      $this->assertSame('America/Toronto', $d->tzName);
   }
   public function testTimezoneUsingDateTimeZone()
   {
      $d = Datum::now();
      $d->timezone = new \DateTimeZone('America/Toronto');
      $this->assertSame('America/Toronto', $d->tzName);
   }
   public function testTzUsingDateTimeZone()
   {
      $d = Datum::now();
      $d->tz = new \DateTimeZone('America/Toronto');
      $this->assertSame('America/Toronto', $d->tzName);
   }

   public function testInvalidSetter()
   {
      $this->setExpectedException('InvalidArgumentException');
      $d = Datum::now();
      $d->doesNotExit = 'bb';
   }
}

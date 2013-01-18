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

class GettersTest extends TestFixture
{
   public function testGettersThrowExceptionOnUnknownGetter()
   {
      $this->setExpectedException('InvalidArgumentException');
      Datum::create(1234, 5, 6, 7, 8, 9)->sdfsdfss;
   }
   public function testYearGetter()
   {
      $d = Datum::create(1234, 5, 6, 7, 8, 9);
      $this->assertSame(1234, $d->year);
   }
   public function testMonthGetter()
   {
      $d = Datum::create(1234, 5, 6, 7, 8, 9);
      $this->assertSame(5, $d->month);
   }
   public function testDayGetter()
   {
      $d = Datum::create(1234, 5, 6, 7, 8, 9);
      $this->assertSame(6, $d->day);
   }
   public function testHourGetter()
   {
      $d = Datum::create(1234, 5, 6, 7, 8, 9);
      $this->assertSame(7, $d->hour);
   }
   public function testMinuteGetter()
   {
      $d = Datum::create(1234, 5, 6, 7, 8, 9);
      $this->assertSame(8, $d->minute);
   }
   public function testSecondGetter()
   {
      $d = Datum::create(1234, 5, 6, 7, 8, 9);
      $this->assertSame(9, $d->second);
   }
   public function testDayOfWeeGetter()
   {
      $d = Datum::create(2012, 5, 7, 7, 8, 9);
      $this->assertSame(Datum::MONDAY, $d->dayOfWeek);
   }
   public function testDayOfYearGetter()
   {
      $d = Datum::createFromDate(2012, 5, 7);
      $this->assertSame(127, $d->dayOfYear);
   }
   public function testDaysInMonthGetter()
   {
      $d = Datum::createFromDate(2012, 5, 7);
      $this->assertSame(31, $d->daysInMonth);
   }
   public function testTimestampGetter()
   {
      $d = Datum::create();
      $d->setTimezone('GMT');
      $this->assertSame(0, $d->setDateTime(1970, 1, 1, 0, 0, 0)->timestamp);
   }

   public function testGetAge()
   {
      $d = Datum::now();
      $this->assertSame(0, $d->age);
   }
   public function testGetAgeWithRealAge()
   {
      $d = Datum::createFromDate(1975, 5, 21);
      $age = intval(substr(date('Ymd') - date('Ymd', $d->timestamp), 0, -4));

      $this->assertSame($age, $d->age);
   }

   public function testGetQuarterFirst()
   {
      $d = Datum::createFromDate(2012, 1, 1);
      $this->assertSame(1, $d->quarter);
   }
   public function testGetQuarterFirstEnd()
   {
      $d = Datum::createFromDate(2012, 3, 31);
      $this->assertSame(1, $d->quarter);
   }
   public function testGetQuarterSecond()
   {
      $d = Datum::createFromDate(2012, 4, 1);
      $this->assertSame(2, $d->quarter);
   }
   public function testGetQuarterThird()
   {
      $d = Datum::createFromDate(2012, 7, 1);
      $this->assertSame(3, $d->quarter);
   }
   public function testGetQuarterFourth()
   {
      $d = Datum::createFromDate(2012, 10, 1);
      $this->assertSame(4, $d->quarter);
   }
   public function testGetQuarterFirstLast()
   {
      $d = Datum::createFromDate(2012, 12, 31);
      $this->assertSame(4, $d->quarter);
   }

   public function testGetDstFalse()
   {
      $this->assertFalse(Datum::createFromDate(2012, 1, 1, 'America/Toronto')->dst);
   }
   public function testGetDstTrue()
   {
      $this->assertTrue(Datum::createFromDate(2012, 7, 1, 'America/Toronto')->dst);
   }

   public function testOffsetForTorontoWithDST()
   {
      $this->assertSame(-18000, Datum::createFromDate(2012, 1, 1, 'America/Toronto')->offset);
   }
   public function testOffsetForTorontoNoDST()
   {
      $this->assertSame(-14400, Datum::createFromDate(2012, 6, 1, 'America/Toronto')->offset);
   }
   public function testOffsetForGMT()
   {
      $this->assertSame(0, Datum::createFromDate(2012, 6, 1, 'GMT')->offset);
   }
   public function testOffsetHoursForTorontoWithDST()
   {
      $this->assertSame(-5, Datum::createFromDate(2012, 1, 1, 'America/Toronto')->offsetHours);
   }
   public function testOffsetHoursForTorontoNoDST()
   {
      $this->assertSame(-4, Datum::createFromDate(2012, 6, 1, 'America/Toronto')->offsetHours);
   }
   public function testOffsetHoursForGMT()
   {
      $this->assertSame(0, Datum::createFromDate(2012, 6, 1, 'GMT')->offsetHours);
   }

   public function testIsLeapYearTrue()
   {
      $this->assertTrue(Datum::createFromDate(2012, 1, 1)->isLeapYear());
   }
   public function testIsLeapYearFalse()
   {
      $this->assertFalse(Datum::createFromDate(2011, 1, 1)->isLeapYear());
   }

   public function testWeekOfYearFirstWeek()
   {
      $this->assertSame(52, Datum::createFromDate(2012, 1, 1)->weekOfYear);
      $this->assertSame(1, Datum::createFromDate(2012, 1, 2)->weekOfYear);
   }
   public function testWeekOfYearLastWeek()
   {
      $this->assertSame(52, Datum::createFromDate(2012, 12, 30)->weekOfYear);
      $this->assertSame(1, Datum::createFromDate(2012, 12, 31)->weekOfYear);
   }

   public function testGetTimezone()
   {
      $dt = Datum::createFromDate(2000, 1, 1, 'America/Toronto');
      $this->assertSame('America/Toronto', $dt->timezone->getName());
   }
   public function testGetTz()
   {
      $dt = Datum::createFromDate(2000, 1, 1, 'America/Toronto');
      $this->assertSame('America/Toronto', $dt->tz->getName());
   }
   public function testGetTimezoneName()
   {
      $dt = Datum::createFromDate(2000, 1, 1, 'America/Toronto');
      $this->assertSame('America/Toronto', $dt->timezoneName);
   }
   public function testGetTzName()
   {
      $dt = Datum::createFromDate(2000, 1, 1, 'America/Toronto');
      $this->assertSame('America/Toronto', $dt->tzName);
   }

   public function testInvalidGetter()
   {
      $this->setExpectedException('InvalidArgumentException');
      $d = Datum::now();
      $bb = $d->doesNotExit;
   }
}

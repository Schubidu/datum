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

class DiffTest extends TestFixture
{
   public function testDiffInYearsPositive()
   {
      $dt = Datum::createFromDate(2000, 1, 1);
      $this->assertSame(1, $dt->diffInYears($dt->copy()->addYear()));
   }
   public function testDiffInYearsNegativeWithSign()
   {
      $dt = Datum::createFromDate(2000, 1, 1);
      $this->assertSame(-1, $dt->diffInYears($dt->copy()->subYear(), false));
   }
   public function testDiffInYearsNegativeNoSign()
   {
      $dt = Datum::createFromDate(2000, 1, 1);
      $this->assertSame(1, $dt->diffInYears($dt->copy()->subYear()));
   }
   public function testDiffInYearsVsDefaultNow()
   {
      $this->assertSame(1, Datum::now()->subYear()->diffInYears());
   }
   public function testDiffInYearsEnsureIsTruncated()
   {
      $dt = Datum::createFromDate(2000, 1, 1);
      $this->assertSame(1, $dt->diffInYears($dt->copy()->addYear()->addMonths(7)));
   }

   public function testDiffInMonthsPositive()
   {
      $dt = Datum::createFromDate(2000, 1, 1);
      $this->assertSame(13, $dt->diffInMonths($dt->copy()->addYear()->addMonth()));
   }
   public function testDiffInMonthsNegativeWithSign()
   {
      $dt = Datum::createFromDate(2000, 1, 1);
      $this->assertSame(-11, $dt->diffInMonths($dt->copy()->subYear()->addMonth(), false));
   }
   public function testDiffInMonthsNegativeNoSign()
   {
      $dt = Datum::createFromDate(2000, 1, 1);
      $this->assertSame(11, $dt->diffInMonths($dt->copy()->subYear()->addMonth()));
   }
   public function testDiffInMonthsVsDefaultNow()
   {
      $this->assertSame(12, Datum::now()->subYear()->diffInMonths());
   }
   public function testDiffInMonthsEnsureIsTruncated()
   {
      $dt = Datum::createFromDate(2000, 1, 1);
      $this->assertSame(1, $dt->diffInMonths($dt->copy()->addMonth()->addDays(16)));
   }

   public function testDiffInDaysPositive()
   {
      $dt = Datum::createFromDate(2000, 1, 1);
      $this->assertSame(366, $dt->diffInDays($dt->copy()->addYear()));
   }
   public function testDiffInDaysNegativeWithSign()
   {
      $dt = Datum::createFromDate(2000, 1, 1);
      $this->assertSame(-365, $dt->diffInDays($dt->copy()->subYear(), false));
   }
   public function testDiffInDaysNegativeNoSign()
   {
      $dt = Datum::createFromDate(2000, 1, 1);
      $this->assertSame(365, $dt->diffInDays($dt->copy()->subYear()));
   }
   public function testDiffInDaysVsDefaultNow()
   {
      $this->assertSame(7, Datum::now()->subWeek()->diffInDays());
   }
   public function testDiffInDaysEnsureIsTruncated()
   {
      $dt = Datum::createFromDate(2000, 1, 1);
      $this->assertSame(1, $dt->diffInDays($dt->copy()->addDay()->addHours(13)));
   }

   public function testDiffInHoursPositive()
   {
      $dt = Datum::createFromDate(2000, 1, 1);
      $this->assertSame(26, $dt->diffInHours($dt->copy()->addDay()->addHours(2)));
   }
   public function testDiffInHoursNegativeWithSign()
   {
      $dt = Datum::createFromDate(2000, 1, 1);
      $this->assertSame(-22, $dt->diffInHours($dt->copy()->subDay()->addHours(2), false));
   }
   public function testDiffInHoursNegativeNoSign()
   {
      $dt = Datum::createFromDate(2000, 1, 1);
      $this->assertSame(22, $dt->diffInHours($dt->copy()->subDay()->addHours(2)));
   }
   public function testDiffInHoursVsDefaultNow()
   {
      $this->assertSame(48, Datum::now()->subDays(2)->diffInHours());
   }
   public function testDiffInHoursEnsureIsTruncated()
   {
      $dt = Datum::createFromDate(2000, 1, 1);
      $this->assertSame(1, $dt->diffInHours($dt->copy()->addHour()->addMinutes(31)));
   }

   public function testDiffInMinutesPositive()
   {
      $dt = Datum::createFromDate(2000, 1, 1);
      $this->assertSame(62, $dt->diffInMinutes($dt->copy()->addHour()->addMinutes(2)));
   }
   public function testDiffInMinutesPositiveAlot()
   {
      $dt = Datum::createFromDate(2000, 1, 1);
      $this->assertSame(1502, $dt->diffInMinutes($dt->copy()->addHours(25)->addMinutes(2)));
   }
   public function testDiffInMinutesNegativeWithSign()
   {
      $dt = Datum::createFromDate(2000, 1, 1);
      $this->assertSame(-58, $dt->diffInMinutes($dt->copy()->subHour()->addMinutes(2), false));
   }
   public function testDiffInMinutesNegativeNoSign()
   {
      $dt = Datum::createFromDate(2000, 1, 1);
      $this->assertSame(58, $dt->diffInMinutes($dt->copy()->subHour()->addMinutes(2)));
   }
   public function testDiffInMinutesVsDefaultNow()
   {
      $this->assertSame(60, Datum::now()->subHour()->diffInMinutes());
   }
   public function testDiffInMinutesEnsureIsTruncated()
   {
      $dt = Datum::createFromDate(2000, 1, 1);
      $this->assertSame(1, $dt->diffInMinutes($dt->copy()->addMinute()->addSeconds(31)));
   }

   public function testDiffInSecondsPositive()
   {
      $dt = Datum::createFromDate(2000, 1, 1);
      $this->assertSame(62, $dt->diffInSeconds($dt->copy()->addMinute()->addSeconds(2)));
   }
   public function testDiffInSecondsPositiveAlot()
   {
      $dt = Datum::createFromDate(2000, 1, 1);
      $this->assertSame(7202, $dt->diffInSeconds($dt->copy()->addHours(2)->addSeconds(2)));
   }
   public function testDiffInSecondsNegativeWithSign()
   {
      $dt = Datum::createFromDate(2000, 1, 1);
      $this->assertSame(-58, $dt->diffInSeconds($dt->copy()->subMinute()->addSeconds(2), false));
   }
   public function testDiffInSecondsNegativeNoSign()
   {
      $dt = Datum::createFromDate(2000, 1, 1);
      $this->assertSame(58, $dt->diffInSeconds($dt->copy()->subMinute()->addSeconds(2)));
   }
   public function testDiffInSecondsVsDefaultNow()
   {
      $this->assertSame(3600, Datum::now()->subHour()->diffInSeconds());
   }
   public function testDiffInSecondsEnsureIsTruncated()
   {
      $dt = Datum::createFromDate(2000, 1, 1);
      $this->assertSame(1, $dt->diffInSeconds($dt->copy()->addSeconds(1.9)));
   }

   public function testDiffInSecondsWithTimezones()
   {
      $dtOttawa = Datum::createFromDate(2000, 1, 1, 'America/Toronto');
      $dtVancouver = Datum::createFromDate(2000, 1, 1, 'America/Vancouver');
      $this->assertSame(3*60*60, $dtOttawa->diffInSeconds($dtVancouver));
   }
   public function testDiffInSecondsWithTimezonesAndVsDefault()
   {
      $dt = Datum::now('America/Vancouver');
      $this->assertSame(0, $dt->diffInSeconds());
   }

   public function testDiffForHumansNowAndSecond()
   {
      $d = Datum::now();
      $this->assertSame('0 seconds ago', $d->diffForHumans());
   }
   public function testDiffForHumansNowAndSecondWithTimezone()
   {
      $d = Datum::now('America/Vancouver');
      $this->assertSame('0 seconds ago', $d->diffForHumans());
   }
   public function testDiffForHumansNowAndSeconds()
   {
      $d = Datum::now()->subSeconds(2);
      $this->assertSame('2 seconds ago', $d->diffForHumans());
   }
   public function testDiffForHumansNowAndMinute()
   {
      $d = Datum::now()->subMinute();
      $this->assertSame('1 minute ago', $d->diffForHumans());
   }
   public function testDiffForHumansNowAndMinutes()
   {
      $d = Datum::now()->subMinutes(2);
      $this->assertSame('2 minutes ago', $d->diffForHumans());
   }
   public function testDiffForHumansNowAndHour()
   {
      $d = Datum::now()->subHour();
      $this->assertSame('1 hour ago', $d->diffForHumans());
   }
   public function testDiffForHumansNowAndHours()
   {
      $d = Datum::now()->subHours(2);
      $this->assertSame('2 hours ago', $d->diffForHumans());
   }
   public function testDiffForHumansNowAndDay()
   {
      $d = Datum::now()->subDay();
      $this->assertSame('1 day ago', $d->diffForHumans());
   }
   public function testDiffForHumansNowAndDays()
   {
      $d = Datum::now()->subDays(2);
      $this->assertSame('2 days ago', $d->diffForHumans());
   }
   public function testDiffForHumansNowAndMonth()
   {
      $d = Datum::now()->subMonth();
      $this->assertSame('1 month ago', $d->diffForHumans());
   }
   public function testDiffForHumansNowAndMonths()
   {
      $d = Datum::now()->subMonths(2);
      $this->assertSame('2 months ago', $d->diffForHumans());
   }
   public function testDiffForHumansNowAndYear()
   {
      $d = Datum::now()->subYear();
      $this->assertSame('1 year ago', $d->diffForHumans());
   }
   public function testDiffForHumansNowAndYears()
   {
      $d = Datum::now()->subYears(2);
      $this->assertSame('2 years ago', $d->diffForHumans());
   }

   public function testDiffForHumansNowAndFutureSecond()
   {
      $d = Datum::now()->addSecond();
      $this->assertSame('1 second from now', $d->diffForHumans());
   }
   public function testDiffForHumansNowAndFutureSeconds()
   {
      $d = Datum::now()->addSeconds(2);
      $this->assertSame('2 seconds from now', $d->diffForHumans());
   }
   public function testDiffForHumansNowAndFutureMinute()
   {
      $d = Datum::now()->addMinute();
      $this->assertSame('1 minute from now', $d->diffForHumans());
   }
   public function testDiffForHumansNowAndFutureMinutes()
   {
      $d = Datum::now()->addMinutes(2);
      $this->assertSame('2 minutes from now', $d->diffForHumans());
   }
   public function testDiffForHumansNowAndFutureHour()
   {
      $d = Datum::now()->addHour();
      $this->assertSame('1 hour from now', $d->diffForHumans());
   }
   public function testDiffForHumansNowAndFutureHours()
   {
      $d = Datum::now()->addHours(2);
      $this->assertSame('2 hours from now', $d->diffForHumans());
   }
   public function testDiffForHumansNowAndFutureDay()
   {
      $d = Datum::now()->addDay();
      $this->assertSame('1 day from now', $d->diffForHumans());
   }
   public function testDiffForHumansNowAndFutureDays()
   {
      $d = Datum::now()->addDays(2);
      $this->assertSame('2 days from now', $d->diffForHumans());
   }
   public function testDiffForHumansNowAndFutureMonth()
   {
      $d = Datum::now()->addMonth();
      $this->assertSame('1 month from now', $d->diffForHumans());
   }
   public function testDiffForHumansNowAndFutureMonths()
   {
      $d = Datum::now()->addMonths(2);
      $this->assertSame('2 months from now', $d->diffForHumans());
   }
   public function testDiffForHumansNowAndFutureYear()
   {
      $d = Datum::now()->addYear();
      $this->assertSame('1 year from now', $d->diffForHumans());
   }
   public function testDiffForHumansNowAndFutureYears()
   {
      $d = Datum::now()->addYears(2);
      $this->assertSame('2 years from now', $d->diffForHumans());
   }

   public function testDiffForHumansOtherAndSecond()
   {
      $d = Datum::now()->addSecond();
      $this->assertSame('1 second before', Datum::now()->diffForHumans($d));
   }
   public function testDiffForHumansOtherAndSeconds()
   {
      $d = Datum::now()->addSeconds(2);
      $this->assertSame('2 seconds before', Datum::now()->diffForHumans($d));
   }
   public function testDiffForHumansOtherAndMinute()
   {
      $d = Datum::now()->addMinute();
      $this->assertSame('1 minute before', Datum::now()->diffForHumans($d));
   }
   public function testDiffForHumansOtherAndMinutes()
   {
      $d = Datum::now()->addMinutes(2);
      $this->assertSame('2 minutes before', Datum::now()->diffForHumans($d));
   }
   public function testDiffForHumansOtherAndHour()
   {
      $d = Datum::now()->addHour();
      $this->assertSame('1 hour before', Datum::now()->diffForHumans($d));
   }
   public function testDiffForHumansOtherAndHours()
   {
      $d = Datum::now()->addHours(2);
      $this->assertSame('2 hours before', Datum::now()->diffForHumans($d));
   }
   public function testDiffForHumansOtherAndDay()
   {
      $d = Datum::now()->addDay();
      $this->assertSame('1 day before', Datum::now()->diffForHumans($d));
   }
   public function testDiffForHumansOtherAndDays()
   {
      $d = Datum::now()->addDays(2);
      $this->assertSame('2 days before', Datum::now()->diffForHumans($d));
   }
   public function testDiffForHumansOtherAndMonth()
   {
      $d = Datum::now()->addMonth();
      $this->assertSame('1 month before', Datum::now()->diffForHumans($d));
   }
   public function testDiffForHumansOtherAndMonths()
   {
      $d = Datum::now()->addMonths(2);
      $this->assertSame('2 months before', Datum::now()->diffForHumans($d));
   }
   public function testDiffForHumansOtherAndYear()
   {
      $d = Datum::now()->addYear();
      $this->assertSame('1 year before', Datum::now()->diffForHumans($d));
   }
   public function testDiffForHumansOtherAndYears()
   {
      $d = Datum::now()->addYears(2);
      $this->assertSame('2 years before', Datum::now()->diffForHumans($d));
   }

   public function testDiffForHumansOtherAndFutureSecond()
   {
      $d = Datum::now()->subSecond();
      $this->assertSame('1 second after', Datum::now()->diffForHumans($d));
   }
   public function testDiffForHumansOtherAndFutureSeconds()
   {
      $d = Datum::now()->subSeconds(2);
      $this->assertSame('2 seconds after', Datum::now()->diffForHumans($d));
   }
   public function testDiffForHumansOtherAndFutureMinute()
   {
      $d = Datum::now()->subMinute();
      $this->assertSame('1 minute after', Datum::now()->diffForHumans($d));
   }
   public function testDiffForHumansOtherAndFutureMinutes()
   {
      $d = Datum::now()->subMinutes(2);
      $this->assertSame('2 minutes after', Datum::now()->diffForHumans($d));
   }
   public function testDiffForHumansOtherAndFutureHour()
   {
      $d = Datum::now()->subHour();
      $this->assertSame('1 hour after', Datum::now()->diffForHumans($d));
   }
   public function testDiffForHumansOtherAndFutureHours()
   {
      $d = Datum::now()->subHours(2);
      $this->assertSame('2 hours after', Datum::now()->diffForHumans($d));
   }
   public function testDiffForHumansOtherAndFutureDay()
   {
      $d = Datum::now()->subDay();
      $this->assertSame('1 day after', Datum::now()->diffForHumans($d));
   }
   public function testDiffForHumansOtherAndFutureDays()
   {
      $d = Datum::now()->subDays(2);
      $this->assertSame('2 days after', Datum::now()->diffForHumans($d));
   }
   public function testDiffForHumansOtherAndFutureMonth()
   {
      $d = Datum::now()->subMonth();
      $this->assertSame('1 month after', Datum::now()->diffForHumans($d));
   }
   public function testDiffForHumansOtherAndFutureMonths()
   {
      $d = Datum::now()->subMonths(2);
      $this->assertSame('2 months after', Datum::now()->diffForHumans($d));
   }
   public function testDiffForHumansOtherAndFutureYear()
   {
      $d = Datum::now()->subYear();
      $this->assertSame('1 year after', Datum::now()->diffForHumans($d));
   }
   public function testDiffForHumansOtherAndFutureYears()
   {
      $d = Datum::now()->subYears(2);
      $this->assertSame('2 years after', Datum::now()->diffForHumans($d));
   }
}

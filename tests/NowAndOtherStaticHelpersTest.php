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

class NowAndOtherStaticHelpersTest extends TestFixture
{
   public function testNow()
   {
      $dt = Datum::now();
      $this->assertSame(time(), $dt->timestamp);
   }
   public function testNowWithTimezone()
   {
      $dt = Datum::now('Europe/London');
      $this->assertSame(time(), $dt->timestamp);
      $this->assertSame('Europe/London', $dt->tzName);
   }

   public function testToday()
   {
      $dt = Datum::today();
      $this->assertSame(date('Y-m-d 00:00:00'), $dt->toDateTimeString());
   }
   public function testTodayWithTimezone()
   {
      $dt = Datum::today('Europe/London');
      $dt2 = new \DateTime('now', new \DateTimeZone('Europe/London'));
      $this->assertSame($dt2->format('Y-m-d 00:00:00'), $dt->toDateTimeString());
   }

   public function testTomorrow()
   {
      $dt = Datum::tomorrow();
      $dt2 = new \DateTime('tomorrow');
      $this->assertSame($dt2->format('Y-m-d 00:00:00'), $dt->toDateTimeString());
   }
   public function testTomorrowWithTimezone()
   {
      $dt = Datum::tomorrow('Europe/London');
      $dt2 = new \DateTime('tomorrow', new \DateTimeZone('Europe/London'));
      $this->assertSame($dt2->format('Y-m-d 00:00:00'), $dt->toDateTimeString());
   }

   public function testYesterday()
   {
      $dt = Datum::yesterday();
      $dt2 = new \DateTime('yesterday');
      $this->assertSame($dt2->format('Y-m-d 00:00:00'), $dt->toDateTimeString());
   }
   public function testYesterdayWithTimezone()
   {
      $dt = Datum::yesterday('Europe/London');
      $dt2 = new \DateTime('yesterday', new \DateTimeZone('Europe/London'));
      $this->assertSame($dt2->format('Y-m-d 00:00:00'), $dt->toDateTimeString());
   }
}

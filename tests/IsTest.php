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

class IsTest extends TestFixture
{
   public function testIsWeekdayTrue()
   {
      $this->assertTrue(Datum::createFromDate(2012, 1, 2)->isWeekday());
   }
   public function testIsWeekdayFalse()
   {
      $this->assertFalse(Datum::createFromDate(2012, 1, 1)->isWeekday());
   }
   public function testIsWeekendTrue()
   {
      $this->assertTrue(Datum::createFromDate(2012, 1, 1)->isWeekend());
   }
   public function testIsWeekendFalse()
   {
      $this->assertFalse(Datum::createFromDate(2012, 1, 2)->isWeekend());
   }

   public function testIsYesterdayTrue()
   {
      $this->assertTrue(Datum::now()->subDay()->isYesterday());
   }
   public function testIsYesterdayFalseWithToday()
   {
      $this->assertFalse(Datum::now()->endOfDay()->isYesterday());
   }
   public function testIsYesterdayFalseWith2Days()
   {
      $this->assertFalse(Datum::now()->subDays(2)->startOfDay()->isYesterday());
   }

   public function testIsTodayTrue()
   {
      $this->assertTrue(Datum::now()->isToday());
   }
   public function testIsTodayFalseWithYesterday()
   {
      $this->assertFalse(Datum::now()->subDay()->endOfDay()->isToday());
   }
   public function testIsTodayFalseWithTomorrow()
   {
      $this->assertFalse(Datum::now()->addDay()->startOfDay()->isToday());
   }
   public function testIsTodayWithTimezone()
   {
      $this->assertTrue(Datum::now('Asia/Tokyo')->isToday());
   }

   public function testIsTomorrowTrue()
   {
      $this->assertTrue(Datum::now()->addDay()->isTomorrow());
   }
   public function testIsTomorrowFalseWithToday()
   {
      $this->assertFalse(Datum::now()->endOfDay()->isTomorrow());
   }
   public function testIsTomorrowFalseWith2Days()
   {
      $this->assertFalse(Datum::now()->addDays(2)->startOfDay()->isTomorrow());
   }

   public function testIsFutureTrue()
   {
      $this->assertTrue(Datum::now()->addSecond()->isFuture());
   }
   public function testIsFutureFalse()
   {
      $this->assertFalse(Datum::now()->isFuture());
   }
   public function testIsFutureFalseInThePast()
   {
      $this->assertFalse(Datum::now()->subSecond()->isFuture());
   }

   public function testIsPastTrue()
   {
      $this->assertTrue(Datum::now()->subSecond()->isPast());
   }
   public function testIsPast()
   {
      $this->assertFalse(Datum::now()->addSecond()->isPast());
   }
}

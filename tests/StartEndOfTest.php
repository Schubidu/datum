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

class StartEndOfTest extends TestFixture
{
   public function testStartOfDay()
   {
      $dt = Datum::now();
      $this->assertTrue($dt->startOfDay() instanceof Datum);
      $this->assertDatum($dt, $dt->year, $dt->month, $dt->day, 0, 0, 0);
   }
   public function testEndOfDay()
   {
      $dt = Datum::now();
      $this->assertTrue($dt->endOfDay() instanceof Datum);
      $this->assertDatum($dt, $dt->year, $dt->month, $dt->day, 23, 59, 59);
   }

   public function testStartOfMonthIsFluid()
   {
      $dt = Datum::now();
      $this->assertTrue($dt->startOfMonth() instanceof Datum);
   }
   public function testStartOfMonthFromNow()
   {
      $dt = Datum::now()->startOfMonth();
      $this->assertDatum($dt, $dt->year, $dt->month, 1, 0, 0, 0);
   }
   public function testStartOfMonthFromLastDay()
   {
      $dt = Datum::create(2000, 1, 31, 2, 3, 4)->startOfMonth();
      $this->assertDatum($dt, 2000, 1, 1, 0, 0, 0);
   }

   public function testEndOfMonthIsFluid()
   {
      $dt = Datum::now();
      $this->assertTrue($dt->endOfMonth() instanceof Datum);
   }
   public function testEndOfMonth()
   {
      $dt = Datum::create(2000, 1, 1, 2, 3, 4)->endOfMonth();
      $this->assertDatum($dt, 2000, 1, 31, 23, 59, 59);
   }
   public function testEndOfMonthFromLastDay()
   {
      $dt = Datum::create(2000, 1, 31, 2, 3, 4)->endOfMonth();
      $this->assertDatum($dt, 2000, 1, 31, 23, 59, 59);
   }
}

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

class ComparisonTest extends TestFixture
{
   public function testEqualToTrue()
   {
      $this->assertTrue(Datum::createFromDate(2000, 1, 1)->eq(Datum::createFromDate(2000, 1, 1)));
   }
   public function testEqualToFalse()
   {
      $this->assertFalse(Datum::createFromDate(2000, 1, 1)->eq(Datum::createFromDate(2000, 1, 2)));
   }
   public function testEqualWithTimezoneTrue()
   {
      $this->assertTrue(Datum::create(2000, 1, 1, 12, 0, 0, 'America/Toronto')->eq(Datum::create(2000, 1, 1, 9, 0, 0, 'America/Vancouver')));
   }
   public function testEqualWithTimezoneFalse()
   {
      $this->assertFalse(Datum::createFromDate(2000, 1, 1, 'America/Toronto')->eq(Datum::createFromDate(2000, 1, 1, 'America/Vancouver')));
   }

   public function testNotEqualToTrue()
   {
      $this->assertTrue(Datum::createFromDate(2000, 1, 1)->ne(Datum::createFromDate(2000, 1, 2)));
   }
   public function testNotEqualToFalse()
   {
      $this->assertFalse(Datum::createFromDate(2000, 1, 1)->ne(Datum::createFromDate(2000, 1, 1)));
   }
   public function testNotEqualWithTimezone()
   {
      $this->assertTrue(Datum::createFromDate(2000, 1, 1, 'America/Toronto')->ne(Datum::createFromDate(2000, 1, 1, 'America/Vancouver')));
   }

   public function testGreaterThanTrue()
   {
      $this->assertTrue(Datum::createFromDate(2000, 1, 1)->gt(Datum::createFromDate(1999, 12, 31)));
   }
   public function testGreaterThanFalse()
   {
      $this->assertFalse(Datum::createFromDate(2000, 1, 1)->gt(Datum::createFromDate(2000, 1, 2)));
   }
   public function testGreaterThanWithTimezoneTrue()
   {
      $dt1 = Datum::create(2000, 1, 1, 12, 0, 0, 'America/Toronto');
      $dt2 = Datum::create(2000, 1, 1, 8, 59, 59, 'America/Vancouver');
      $this->assertTrue($dt1->gt($dt2));
   }
   public function testGreaterThanWithTimezoneFalse()
   {
      $dt1 = Datum::create(2000, 1, 1, 12, 0, 0, 'America/Toronto');
      $dt2 = Datum::create(2000, 1, 1, 9, 0, 1, 'America/Vancouver');
      $this->assertFalse($dt1->gt($dt2));
   }

   public function testGreaterThanOrEqualTrue()
   {
      $this->assertTrue(Datum::createFromDate(2000, 1, 1)->gte(Datum::createFromDate(1999, 12, 31)));
   }
   public function testGreaterThanOrEqualTrueEqual()
   {
      $this->assertTrue(Datum::createFromDate(2000, 1, 1)->gte(Datum::createFromDate(2000, 1, 1)));
   }
   public function testGreaterThanOrEqualFalse()
   {
      $this->assertFalse(Datum::createFromDate(2000, 1, 1)->gte(Datum::createFromDate(2000, 1, 2)));
   }

   public function testLessThanTrue()
   {
      $this->assertTrue(Datum::createFromDate(2000, 1, 1)->lt(Datum::createFromDate(2000, 1, 2)));
   }
   public function testLessThanFalse()
   {
      $this->assertFalse(Datum::createFromDate(2000, 1, 1)->lt(Datum::createFromDate(1999, 12, 31)));
   }

   public function testLessThanOrEqualTrue()
   {
      $this->assertTrue(Datum::createFromDate(2000, 1, 1)->lte(Datum::createFromDate(2000, 1, 2)));
   }
   public function testLessThanOrEqualTrueEqual()
   {
      $this->assertTrue(Datum::createFromDate(2000, 1, 1)->lte(Datum::createFromDate(2000, 1, 1)));
   }
   public function testLessThanOrEqualFalse()
   {
      $this->assertFalse(Datum::createFromDate(2000, 1, 1)->lte(Datum::createFromDate(1999, 12, 31)));
   }
}

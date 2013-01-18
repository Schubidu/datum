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

class StringsTest extends TestFixture
{
   public function testToString()
   {
      $d = Datum::now();
      $this->assertSame(Datum::now()->toDateTimeString(), ''.$d);
   }

   public function testToDateString()
   {
      $d = Datum::create(1975, 12, 25, 14, 15, 16);
      $this->assertSame('1975-12-25', $d->toDateString());
   }
   public function testToFormattedDateString()
   {
      $d = Datum::create(1975, 12, 25, 14, 15, 16);
      $this->assertSame('Dec 25, 1975', $d->toFormattedDateString());
   }
   public function testToTimeString()
   {
      $d = Datum::create(1975, 12, 25, 14, 15, 16);
      $this->assertSame('14:15:16', $d->toTimeString());
   }
   public function testToDateTimeString()
   {
      $d = Datum::create(1975, 12, 25, 14, 15, 16);
      $this->assertSame('1975-12-25 14:15:16', $d->toDateTimeString());
   }
   public function testToDateTimeStringWithPaddedZeroes()
   {
      $d = Datum::create(2000, 5, 2, 4, 3, 4);
      $this->assertSame('2000-05-02 04:03:04', $d->toDateTimeString());
   }
   public function testToDayDateTimeString()
   {
      $d = Datum::create(1975, 12, 25, 14, 15, 16);
      $this->assertSame('Thu, Dec 25, 1975 2:15 PM', $d->toDayDateTimeString());
   }

   public function testToATOMString()
   {
      $d = Datum::create(1975, 12, 25, 14, 15, 16);
      $this->assertSame('1975-12-25T14:15:16-05:00', $d->toATOMString());
   }
   public function testToCOOKIEString()
   {
      $d = Datum::create(1975, 12, 25, 14, 15, 16);
      $this->assertSame('Thursday, 25-Dec-75 14:15:16 EST', $d->toCOOKIEString());
   }
   public function testToISO8601String()
   {
      $d = Datum::create(1975, 12, 25, 14, 15, 16);
      $this->assertSame('1975-12-25T14:15:16-0500', $d->toISO8601String());
   }
   public function testToRC822String()
   {
      $d = Datum::create(1975, 12, 25, 14, 15, 16);
      $this->assertSame('Thu, 25 Dec 75 14:15:16 -0500', $d->toRFC822String());
   }
   public function testToRFC850String()
   {
      $d = Datum::create(1975, 12, 25, 14, 15, 16);
      $this->assertSame('Thursday, 25-Dec-75 14:15:16 EST', $d->toRFC850String());
   }
   public function testToRFC1036String()
   {
      $d = Datum::create(1975, 12, 25, 14, 15, 16);
      $this->assertSame('Thu, 25 Dec 75 14:15:16 -0500', $d->toRFC1036String());
   }
   public function testToRFC1123String()
   {
      $d = Datum::create(1975, 12, 25, 14, 15, 16);
      $this->assertSame('Thu, 25 Dec 1975 14:15:16 -0500', $d->toRFC1123String());
   }
   public function testToRFC2822String()
   {
      $d = Datum::create(1975, 12, 25, 14, 15, 16);
      $this->assertSame('Thu, 25 Dec 1975 14:15:16 -0500', $d->toRFC2822String());
   }
   public function testToRFC3339String()
   {
      $d = Datum::create(1975, 12, 25, 14, 15, 16);
      $this->assertSame('1975-12-25T14:15:16-05:00', $d->toRFC3339String());
   }
   public function testToRSSString()
   {
      $d = Datum::create(1975, 12, 25, 14, 15, 16);
      $this->assertSame('Thu, 25 Dec 1975 14:15:16 -0500', $d->toRSSString());
   }
   public function testToW3CString()
   {
      $d = Datum::create(1975, 12, 25, 14, 15, 16);
      $this->assertSame('1975-12-25T14:15:16-05:00', $d->toW3CString());
   }
}

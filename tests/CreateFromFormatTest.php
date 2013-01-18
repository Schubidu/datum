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

class CreateFromFormatTest extends TestFixture
{
   public function testCreateFromFormatReturnsDatum()
   {
      $d = Datum::createFromFormat('Y-m-d H:i:s', '1975-05-21 22:32:11');
      $this->assertDatum($d, 1975, 5, 21, 22, 32, 11);
      $this->assertTrue($d instanceof Datum);
   }

   public function testCreateFromFormatWithTimezoneString()
   {
      $d = Datum::createFromFormat('Y-m-d H:i:s', '1975-05-21 22:32:11', 'Europe/London');
      $this->assertDatum($d, 1975, 5, 21, 22, 32, 11);
      $this->assertSame('Europe/London', $d->tzName);
   }

   public function testCreateFromFormatWithTimezone()
   {
      $d = Datum::createFromFormat('Y-m-d H:i:s', '1975-05-21 22:32:11', new \DateTimeZone('Europe/London'));
      $this->assertDatum($d, 1975, 5, 21, 22, 32, 11);
      $this->assertSame('Europe/London', $d->tzName);
   }
}

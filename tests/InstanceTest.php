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

class InstanceTest extends TestFixture
{
   public function testInstanceFromDateTime()
   {
      $dating = Datum::instance(\DateTime::createFromFormat('Y-m-d H:i:s', '1975-05-21 22:32:11'));
      $this->assertDatum($dating, 1975, 5, 21, 22, 32, 11);
   }

   public function testInstanceFromDateTimeKeepsTimezoneName()
   {
      $dating = Datum::instance(\DateTime::createFromFormat('Y-m-d H:i:s', '1975-05-21 22:32:11')->setTimezone(new \DateTimeZone('America/Vancouver')));
      $this->assertSame('America/Vancouver', $dating->tzName);
   }
}

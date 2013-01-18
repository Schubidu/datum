<?php

/*
 * This file is part of the Datum package.
 *
 * (c) Brian Nesbitt <brian@nesbot.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require __DIR__.'/../vendor/autoload.php';

use Datum\Datum;

class TestFixture extends \PHPUnit_Framework_TestCase
{
   private $saveTz;

   protected function setUp()
   {
      //save current timezone
      $this->saveTz = @date_default_timezone_get();

      date_default_timezone_set('America/Toronto');
   }

   protected function tearDown()
   {
      date_default_timezone_set($this->saveTz);
   }

   protected function assertDatum(Datum $d, $year, $month, $day, $hour = null, $minute = null, $second = null)
   {
      $this->assertSame($year, $d->year, 'Datum->year');
      $this->assertSame($month, $d->month, 'Datum->month');
      $this->assertSame($day, $d->day, 'Datum->day');

      if ($hour !== null) {
         $this->assertSame($hour, $d->hour, 'Datum->hour');
      }

      if ($minute !== null) {
         $this->assertSame($minute, $d->minute, 'Datum->minute');
      }

      if ($second !== null) {
         $this->assertSame($second, $d->second, 'Datum->second');
      }
   }
}

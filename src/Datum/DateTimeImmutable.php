<?php
/*
 * This file is part of the Datum package.
 *
 * (c) Daniel Horrigan <me@dandoescode.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Datum;

use DateTime;
use DateInterval;
use DateTimeZone;

class DateTimeImmutable extends DateTime
{
    private static $immutable = true;

    public function add($interval)
    {
        return $this->immutableCall('add', array($interval));
    }

    public function modify($modify)
    {
        return $this->immutableCall('modify', array($modify));
    }

    public function setDate($year, $month, $day)
    {
        return $this->immutableCall('setDate', array($year, $month, $day));
    }

    public function setISODate($year, $week, $day = 1)
    {
        return $this->immutableCall('setISODate', array($year, $week, $day));
    }

    public function setTime($hour, $minute, $second = 0)
    {
        return $this->immutableCall('setTime', array($hour, $minute, $second));
    }

    public function setTimestamp($unixtimestamp)
    {
        return $this->immutableCall('setTimestamp', array($unixtimestamp));
    }

    public function setTimezone($timezone)
    {
        return $this->immutableCall('setTimezone', array($timezone));
    }

    public function sub($interval)
    {
        return $this->immutableCall('sub', array($interval));
    }

    /**
     * This is a bit of a hack, but it is the only way to make sure that we
     * call the correct DateTime method on the new object.
     *
     * @param  string $method
     * @param  array  $parameters
     * @return Datum\DateTimeImmutable
     */
    private function immutableCall($method, $parameters)
    {
        if ( ! self::$immutable) {
            return call_user_func_array('parent::'.$method, $parameters);
        }
        self::$immutable = false;
        $clone = clone $this;
        call_user_func_array(array($clone, $method), $parameters);
        self::$immutable = true;

        return $clone;
    }
}

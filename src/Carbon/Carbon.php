<?php

/*
 * This file is part of the Carbon package.
 *
 * (c) Brian Nesbitt <brian@nesbot.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Carbon;

use DateTime;
use DateInterval;
use DateTimeZone;
use InvalidArgumentException;

class Carbon extends DateTime
{
    const SUNDAY = 0;
    const MONDAY = 1;
    const TUESDAY = 2;
    const WEDNESDAY = 3;
    const THURSDAY = 4;
    const FRIDAY = 5;
    const SATURDAY = 6;

    const MONTHS_PER_YEAR = 12;
    const HOURS_PER_DAY = 24;
    const MINUTES_PER_HOUR = 60;
    const SECONDS_PER_MINUTE = 60;

    /**
     * Creates a new DateTimeZone object.  It will throw an exception if an
     * invalid TimeZone is given.
     *
     * @param  mixed $object Either a string rep. of the timezone or a DateTimeZone object
     * @return DateTimeZone
     */
    protected static function safeCreateDateTimeZone($object)
    {
        if ($object instanceof DateTimeZone) {
            return $object;
        }

        $tz = @timezone_open((string) $object);

        if ($tz === false) {
            throw new InvalidArgumentException('Unknown or bad timezone ('.$object.')');
        }

        return $tz;
    }

    /**
     * Construct the Object
     *
     * @param string $time A date/time string compatible with DateTime::__construct
     * @param mixed  $tz   Either a DateTimeZone object or a string rep. of the time zone
     */
    public function __construct($time = null, $tz = null)
    {
        if ($tz !== null) {
            parent::__construct($time, self::safeCreateDateTimeZone($tz));
        } else {
            parent::__construct($time);
        }
    }

    /**
     * Creates a new instance using the given DateTime object.
     *
     * @param  DateTime $dt The DateTime object to base the instance off of
     * @return Carbon
     */
    public static function instance(DateTime $dt)
    {
        return new self($dt->format('Y-m-d H:i:s'), $dt->getTimeZone());
    }

    /**
     * Creates a new Carbon object set to the current date/time.
     *
     * @param  mixed $tz Either a DateTimeZone object or a string rep. of the time zone
     * @return Carbon
     */
    public static function now($tz = null)
    {
        return new self(null, $tz);
    }

    /**
     * Creates a new Carbon object set to the start time of today.
     *
     * @param  mixed $tz Either a DateTimeZone object or a string rep. of the time zone
     * @return Carbon
     */
    public static function today($tz = null)
    {
        return self::now($tz)->startOfDay();
    }

    /**
     * Creates a new Carbon object set to the start time of today.
     *
     * @param  mixed $tz Either a DateTimeZone object or a string rep. of the time zone
     * @return Carbon
     */
    public static function tomorrow($tz = null)
    {
        return self::today($tz)->addDay();
    }

    /**
     * Creates a new Carbon object set to the start time of yesterday.
     *
     * @param  mixed $tz Either a DateTimeZone object or a string rep. of the time zone
     * @return Carbon
     */
    public static function yesterday($tz = null)
    {
        return self::today($tz)->subDay();
    }

    /**
     * Creates a new Carbon object with the given date/time information
     *
     * @param  int   $year   The year
     * @param  int   $month  The month
     * @param  int   $day    The day
     * @param  int   $hour   The hour
     * @param  int   $minute The minute
     * @param  int   $second The seconds
     * @param  mixed $tz     Either a DateTimeZone object or a string rep. of the time zone
     * @return Carbon
     */
    public static function create($year = null, $month = null, $day = null, $hour = null, $minute = null, $second = null, $tz = null)
    {
        $year = ($year === null) ? date('Y') : $year;
        $month = ($month === null) ? date('n') : $month;
        $day = ($day === null) ? date('j') : $day;

        if ($hour === null) {
            $hour = date('G');
            $minute = ($minute === null) ? date('i') : $minute;
            $second = ($second === null) ? date('s') : $second;
        } else {
            $minute = ($minute === null) ? 0 : $minute;
            $second = ($second === null) ? 0 : $second;
        }

        return self::createFromFormat('Y-n-j G:i:s', sprintf('%s-%s-%s %s:%02s:%02s', $year, $month, $day, $hour, $minute, $second), $tz);
    }

    /**
     * Creates a new Carbon object with the given date information
     *
     * @param  int   $year   The year
     * @param  int   $month  The month
     * @param  int   $day    The day
     * @return Carbon
     */
    public static function createFromDate($year = null, $month = null, $day = null, $tz = null)
    {
        return self::create($year, $month, $day, null, null, null, $tz);
    }

    /**
     * Creates a new Carbon object with the given time information
     *
     * @param  int   $hour   The hour
     * @param  int   $minute The minute
     * @param  int   $second The seconds
     * @param  mixed $tz     Either a DateTimeZone object or a string rep. of the time zone
     * @return Carbon
     */
    public static function createFromTime($hour = null, $minute = null, $second = null, $tz = null)
    {
        return self::create(null, null, null, $hour, $minute, $second, $tz);
    }

    /**
     * Creates a new Carbon object from the given valid date/time format.
     *
     * @param  string $format The date/time format
     * @param  string $time   String representation of the date/time
     * @param  mixed  $tz     Either a DateTimeZone object or a string rep. of the time zone
     * @return Carbon
     */
    public static function createFromFormat($format, $time, $tz = null)
    {
        if ($tz !== null) {
            $dt = parent::createFromFormat($format, $time, self::safeCreateDateTimeZone($tz));
        } else {
            $dt = parent::createFromFormat($format, $time);
        }

        if ($dt instanceof DateTime) {
            return self::instance($dt);
        }

        $errors = DateTime::getLastErrors();
        throw new InvalidArgumentException(implode(PHP_EOL, $errors['errors']));
    }

    /**
     * Creates a new Carbon object from the given timestamp and timezone.
     *
     * @param  int   $timestamp The timestamp
     * @param  mixed $tz        Either a DateTimeZone object or a string rep. of the time zone
     * @return Carbon
     */
    public static function createFromTimestamp($timestamp, $tz = null)
    {
        return self::now($tz)->setTimestamp($timestamp);
    }

    /**
     * Creates a new Carbon object from a given UTC Timestamp.
     *
     * @param  int $timestamp The UTC timestamp
     * @return Carbon
     */
    public static function createFromTimestampUTC($timestamp)
    {
        return new self('@'.$timestamp);
    }

    /**
     * Creates a copy of the Carbon object.
     *
     * @return Carbon
     */
    public function copy()
    {
        return self::instance($this);
    }

    /**
     * Gets the given value from this object.
     *
     * @param  string $name The value to get
     * @return mixed
     */
    public function __get($name)
    {
        switch ($name) {
            case 'year':
                return intval($this->format('Y'));
            case 'month':
                return intval($this->format('n'));
            case 'day':
                return intval($this->format('j'));
            case 'hour':
                return intval($this->format('G'));
            case 'minute':
                return intval($this->format('i'));
            case 'second':
                return intval($this->format('s'));
            case 'dayOfWeek':
                return intval($this->format('w'));
            case 'dayOfYear':
                return intval($this->format('z'));
            case 'weekOfYear':
                return intval($this->format('W'));
            case 'daysInMonth':
                return intval($this->format('t'));
            case 'timestamp':
                return intval($this->format('U'));
            case 'age':
                return intval($this->diffInYears());
            case 'quarter':
                return intval(($this->month - 1) / 3) + 1;
            case 'offset':
                return $this->getOffset();
            case 'offsetHours':
                return $this->getOffset() / self::SECONDS_PER_MINUTE / self::MINUTES_PER_HOUR;
            case 'dst':
                return $this->format('I') == '1';
            case 'timezone':
                return $this->getTimezone();
            case 'timezoneName':
                return $this->getTimezone()->getName();
            case 'tz':
                return $this->timezone;
            case 'tzName':
                return $this->timezoneName;

            default:
                throw new InvalidArgumentException(sprintf("Unknown getter '%s'", $name));
        }
    }

    /**
     * Checks if the given value is a valid one to get.
     *
     * @param  string  $name The name of the value to check
     * @return boolean
     */
    public function __isset($name)
    {
        try {
            $this->__get($name);
        } catch (InvalidArgumentException $e) {
            return false;
        }
        return true;
    }

    /**
     * Sets the given value for the given property.
     *
     * @param  string $name The property to set
     * @param  string $vaue The value
     * @return void
     */
    public function __set($name, $value)
    {
        switch ($name) {
            case 'year':
                parent::setDate($value, $this->month, $this->day);
                break;
            case 'month':
                parent::setDate($this->year, $value, $this->day);
                break;
            case 'day':
                parent::setDate($this->year, $this->month, $value);
                break;
            case 'hour':
                parent::setTime($value, $this->minute, $this->second);
                break;
            case 'minute':
                parent::setTime($this->hour, $value, $this->second);
                break;
            case 'second':
                parent::setTime($this->hour, $this->minute, $value);
                break;
            case 'timestamp':
                parent::setTimestamp($value);
                break;
            case 'timezone':
                $this->setTimezone($value);
                break;
            case 'tz':
                $this->setTimezone($value);
                break;
            default:
                throw new InvalidArgumentException(sprintf("Unknown setter '%s'", $name));
        }
    }

    /**
     * Sets the year and allows you to chain.
     *
     * @param  int $value The value to set
     * @return Carbon
     */
    public function year($value)
    {
        $this->year = $value;

        return $this;
    }

    /**
     * Sets the month and allows you to chain.
     *
     * @param  int $value The value to set
     * @return Carbon
     */
    public function month($value)
    {
        $this->month = $value;

        return $this;
    }

    /**
     * Sets the day and allows you to chain.
     *
     * @param  int $value The value to set
     * @return Carbon
     */
    public function day($value)
    {
        $this->day = $value;

        return $this;
    }

    /**
     * Sets the year, month, and day all at once and allows you to chain.
     *
     * @param  int $year  The year
     * @param  int $month The month
     * @param  int $day   The day
     * @return Carbon
     */
    public function setDate($year, $month, $day)
    {
        return $this->year($year)->month($month)->day($day);
    }

    /**
     * Sets the hour and allows you to chain.
     *
     * @param  int $value The value to set
     * @return Carbon
     */
    public function hour($value)
    {
        $this->hour = $value;

        return $this;
    }

    /**
     * Sets the minute and allows you to chain.
     *
     * @param  int $value The value to set
     * @return Carbon
     */
    public function minute($value)
    {
        $this->minute = $value;

        return $this;
    }

    /**
     * Sets the second and allows you to chain.
     *
     * @param  int $value The value to set
     * @return Carbon
     */
    public function second($value)
    {
        $this->second = $value;

        return $this;
    }

    /**
     * Sets the hour, minute, and second all at once and allows you to chain.
     *
     * @param  int $hour   The hour
     * @param  int $minute The minute
     * @param  int $second The second
     * @return Carbon
     */
    public function setTime($hour, $minute, $second = 0)
    {
        return $this->hour($hour)->minute($minute)->second($second);
    }

    /**
     * Sets the year, month, day, hour, minute, and second all at once and
     * allows you to chain.
     *
     * @param  int $year   The year
     * @param  int $month  The month
     * @param  int $day    The day
     * @param  int $hour   The hour
     * @param  int $minute The minute
     * @param  int $second The second
     * @return Carbon
     */
    public function setDateTime($year, $month, $day, $hour, $minute, $second)
    {
        return $this->setDate($year, $month, $day)->setTime($hour, $minute, $second);
    }

    /**
     * Sets the timestamp.
     *
     * @param  int $value The timestamp
     * @return Carbon
     */
    public function timestamp($value)
    {
        $this->timestamp = $value;

        return $this;
    }

    /**
     * Alias for setTimezone.
     *
     * @param  mixed $value Either a DateTimeZone object or a string rep. of the time zone
     * @return Carbon
     */
    public function timezone($value)
    {
        return $this->setTimezone($value);
    }

    /**
     * Alias for setTimezone.
     *
     * @param  mixed $value Either a DateTimeZone object or a string rep. of the time zone
     * @return Carbon
     */
    public function tz($value)
    {
        return $this->setTimezone($value);
    }

    /**
     * Sets the Time Zone to given time zone.
     *
     * @param  mixed $value Either a DateTimeZone object or a string rep. of the time zone
     * @return Carbon
     */
    public function setTimezone($value)
    {
        parent::setTimezone(self::safeCreateDateTimeZone($value));

        return $this;
    }

    /**
     * Returns the date/time in the MySQL DateTime format.
     *
     * Example: 2000-05-02 04:03:04
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toDateTimeString();
    }

    /**
     * Returns the date in the format 'Y-m-d'.
     *
     * Example: 1975-12-25
     *
     * @return string
     */
    public function toDateString()
    {
        return $this->format('Y-m-d');
    }

    /**
     * Returns the date in the format 'M j, Y'.
     *
     * Example: Dec 25, 1975
     *
     * @return string
     */
    public function toFormattedDateString()
    {
        return $this->format('M j, Y');
    }

    /**
     * Returns the time in the format 'H:i:s'.
     *
     * Example: 14:15:16
     *
     * @return string
     */
    public function toTimeString()
    {
        return $this->format('H:i:s');
    }

    /**
     * Returns the date/time in the MySQL DateTime format.
     *
     * Example: 2000-05-02 04:03:04
     *
     * @return string
     */
    public function toDateTimeString()
    {
        return $this->format('Y-m-d H:i:s');
    }

    /**
     * Returns the date/time in the format 'D, M j, Y g:i A'.
     *
     * Example: Thu, Dec 25, 1975 2:15 PM
     *
     * @return string
     */
    public function toDayDateTimeString()
    {
        return $this->format('D, M j, Y g:i A');
    }

    /**
     * Returns the date/time in the ATOM format.
     *
     * Example: 2005-08-15T15:52:01+00:00
     *
     * @return string
     */
    public function toATOMString()
    {
        return $this->format(DateTime::ATOM);
    }

    /**
     * Returns the date/time in the COOKIE format.
     *
     * Example: Monday, 15-Aug-05 15:52:01 UTC
     *
     * @return string
     */
    public function toCOOKIEString()
    {
        return $this->format(DateTime::COOKIE);
    }

    /**
     * Returns the date/time in the ISO8601 format.
     *
     * Example: 2005-08-15T15:52:01+0000
     *
     * @return string
     */
    public function toISO8601String()
    {
        return $this->format(DateTime::ISO8601);
    }

    /**
     * Returns the date/time in the RFC822 format.
     *
     * Example: Mon, 15 Aug 05 15:52:01 +0000
     *
     * @return string
     */
    public function toRFC822String()
    {
        return $this->format(DateTime::RFC822);
    }

    /**
     * Returns the date/time in the RFC850 format.
     *
     * Example: Monday, 15-Aug-05 15:52:01 UTC
     *
     * @return string
     */
    public function toRFC850String()
    {
        return $this->format(DateTime::RFC850);
    }

    /**
     * Returns the date/time in the RFC1036 format.
     *
     * Example: Mon, 15 Aug 05 15:52:01 +0000
     *
     * @return string
     */
    public function toRFC1036String()
    {
        return $this->format(DateTime::RFC1036);
    }

    /**
     * Returns the date/time in the RFC1123 format.
     *
     * Example: Mon, 15 Aug 2005 15:52:01 +0000
     *
     * @return string
     */
    public function toRFC1123String()
    {
        return $this->format(DateTime::RFC1123);
    }

    /**
     * Returns the date/time in the RFC2822 format.
     *
     * Example: Mon, 15 Aug 2005 15:52:01 +0000
     *
     * @return string
     */
    public function toRFC2822String()
    {
        return $this->format(DateTime::RFC2822);
    }

    /**
     * Returns the date/time in the RFC3339 format.
     *
     * Example: 2005-08-15T15:52:01+00:00
     *
     * @return string
     */
    public function toRFC3339String()
    {
        return $this->format(DateTime::RFC3339);
    }

    /**
     * Returns the date/time in the RSS format.
     *
     * Example: Mon, 15 Aug 2005 15:52:01 +0000
     *
     * @return string
     */
    public function toRSSString()
    {
        return $this->format(DateTime::RSS);
    }

    /**
     * Returns the date/time in the W3C format.
     *
     * Example: 2005-08-15T15:52:01+00:00
     *
     * @return string
     */
    public function toW3CString()
    {
        return $this->format(DateTime::W3C);
    }

    /**
     * Checks if this Carbon object is less equal to the given
     * object.
     *
     * @param  Carbon $dt The object to compare
     * @return boolean
     */
    public function eq(Carbon $dt)
    {
        return $this == $dt;
    }

    /**
     * Checks if this Carbon object is not equal to the given
     * object.
     *
     * @param  Carbon $dt The object to compare
     * @return boolean
     */
    public function ne(Carbon $dt)
    {
        return ( ! $this->eq($dt));
    }

    /**
     * Checks if this Carbon object is greater than to the given
     * object.
     *
     * @param  Carbon $dt The object to compare
     * @return boolean
     */
    public function gt(Carbon $dt)
    {
        return $this > $dt;
    }

    /**
     * Checks if this Carbon object is greater than or equal to the given
     * object.
     *
     * @param  Carbon $dt The object to compare
     * @return boolean
     */
    public function gte(Carbon $dt)
    {
        return $this >= $dt;
    }

    /**
     * Checks if this Carbon object is less than to the given
     * object.
     *
     * @param  Carbon $dt The object to compare
     * @return boolean
     */
    public function lt(Carbon $dt)
    {
        return $this < $dt;
    }

    /**
     * Checks if this Carbon object is less than or equal to the given
     * object.
     *
     * @param  Carbon $dt The object to compare
     * @return boolean
     */
    public function lte(Carbon $dt)
    {
        return $this <= $dt;
    }

    /**
     * Checks if the date is on a weekday.
     *
     * @return boolean
     */
    public function isWeekday()
    {
        return ($this->dayOfWeek != self::SUNDAY && $this->dayOfWeek != self::SATURDAY);
    }

    /**
     * Checks if the date is on a weekend.
     *
     * @return boolean
     */
    public function isWeekend()
    {
        return ( ! $this->isWeekDay());
    }

    /**
     * Checks if the date is yestarday.
     *
     * @return boolean
     */
    public function isYesterday()
    {
        return $this->toDateString() === self::now($this->tz)->subDay()->toDateString();
    }

    /**
     * Checks if the date is today.
     *
     * @return boolean
     */
    public function isToday()
    {
        return $this->toDateString() === self::now($this->tz)->toDateString();
    }

    /**
     * Checks if the date is tomorrow.
     *
     * @return boolean
     */
    public function isTomorrow()
    {
        return $this->toDateString() === self::now($this->tz)->addDay()->toDateString();
    }

    /**
     * Checks if the date/time is in the future.
     *
     * @return boolean
     */
    public function isFuture()
    {
        return $this->gt(self::now($this->tz));
    }

    /**
     * Checks if the date/time is in the past.
     *
     * @return boolean
     */
    public function isPast()
    {
        return ( ! $this->isFuture());
    }

    /**
     * Checks if the year is a leap year.
     *
     * @return boolean
     */
    public function isLeapYear()
    {
        return $this->format('L') == '1';
    }

    /**
     * Adds the given amount of years to the date
     *
     * @param  int $value The number of years to add
     * @return Carbon
     */
    public function addYears($value)
    {
        $interval = new DateInterval(sprintf("P%dY", abs($value)));
        if ($value >= 0) {
            $this->add($interval);
        } else {
            $this->sub($interval);
        }

        return $this;
    }

    /**
     * Adds 1 year to the date
     *
     * @return Carbon
     */
    public function addYear()
    {
        return $this->addYears(1);
    }

    /**
     * Subtracts 1 year from the date
     *
     * @return Carbon
     */
    public function subYear()
    {
        return $this->addYears(-1);
    }

    /**
     * Subtracts the given amount of years from the date
     *
     * @param  int $value The number of years to subtract
     * @return Carbon
     */
    public function subYears($value)
    {
        return $this->addYears(-1 * $value);
    }

    /**
     * Adds the given amount of months to the date
     *
     * @param  int $value The number of months to add
     * @return Carbon
     */
    public function addMonths($value)
    {
        $interval = new DateInterval(sprintf("P%dM", abs($value)));
        if ($value >= 0) {
            $this->add($interval);
        } else {
            $this->sub($interval);
        }

        return $this;
    }

    /**
     * Adds 1 month to the date
     *
     * @return Carbon
     */
    public function addMonth()
    {
        return $this->addMonths(1);
    }

    /**
     * Subtracts 1 month from the date
     *
     * @return Carbon
     */
    public function subMonth()
    {
        return $this->addMonths(-1);
    }

    /**
     * Subtracts the given amount of months from the date
     *
     * @param  int $value The number of months to subtract
     * @return Carbon
     */
    public function subMonths($value)
    {
        return $this->addMonths(-1 * $value);
    }

    /**
     * Adds the given amount of days to the date
     *
     * @param  int $value The number of days to add
     * @return Carbon
     */
    public function addDays($value)
    {
        $interval = new DateInterval(sprintf("P%dD", abs($value)));
        if ($value >= 0) {
            $this->add($interval);
        } else {
            $this->sub($interval);
        }

        return $this;
    }

    /**
     * Adds 1 day to the date
     *
     * @return Carbon
     */
    public function addDay()
    {
        return $this->addDays(1);
    }

    /**
     * Subtracts 1 day from the date
     *
     * @return Carbon
     */
    public function subDay()
    {
        return $this->addDays(-1);
    }

    /**
     * Subtracts the given amount of days from the date
     *
     * @param  int $value The number of days to subtract
     * @return Carbon
     */
    public function subDays($value)
    {
        return $this->addDays(-1 * $value);
    }

    /**
     * Adds the given amount of weekdays to the date
     *
     * @param  int $value The number of weekdays to add
     * @return Carbon
     */
    public function addWeekdays($value)
    {
        $absValue = abs($value);
        $direction = $value < 0 ? -1 : 1;

        while ($absValue > 0) {
            $this->addDays($direction);

            while ($this->isWeekend()) {
                $this->addDays($direction);
            }

            $absValue--;
        }

        return $this;
    }

    /**
     * Adds 1 weekday to the date
     *
     * @return Carbon
     */
    public function addWeekday()
    {
        return $this->addWeekdays(1);
    }

    /**
     * Subtracts 1 weekday from the date
     *
     * @return Carbon
     */
    public function subWeekday()
    {
        return $this->addWeekdays(-1);
    }

    /**
     * Subtracts the given amount of weekdays from the date
     *
     * @param  int $value The number of weekdays to subtract
     * @return Carbon
     */
    public function subWeekdays($value)
    {
        return $this->addWeekdays(-1 * $value);
    }

    /**
     * Adds the given amount of weeks to the date
     *
     * @param  int $value The number of weeks to add
     * @return Carbon
     */
    public function addWeeks($value)
    {
        $interval = new DateInterval(sprintf("P%dW", abs($value)));
        if ($value >= 0) {
            $this->add($interval);
        } else {
            $this->sub($interval);
        }

        return $this;
    }

    /**
     * Adds 1 weeks to the date
     *
     * @return Carbon
     */
    public function addWeek()
    {
        return $this->addWeeks(1);
    }

    /**
     * Subtracts 1 week from the date
     *
     * @return Carbon
     */
    public function subWeek()
    {
        return $this->addWeeks(-1);
    }

    /**
     * Subtracts the given amount of weeks from the date
     *
     * @param  int $value The number of weeks to subtract
     * @return Carbon
     */
    public function subWeeks($value)
    {
        return $this->addWeeks(-1 * $value);
    }

    /**
     * Adds the given amount of hours to the time
     *
     * @param  int $value The number of hours to add
     * @return Carbon
     */
    public function addHours($value)
    {
        $interval = new DateInterval(sprintf("PT%dH", abs($value)));
        if ($value >= 0) {
            $this->add($interval);
        } else {
            $this->sub($interval);
        }

        return $this;
    }

    /**
     * Adds 1 hour from the time
     *
     * @return Carbon
     */
    public function addHour()
    {
        return $this->addHours(1);
    }

    /**
     * Subtracts 1 hour from the time
     *
     * @return Carbon
     */
   public function subHour()
    {
        return $this->addHours(-1);
    }

    /**
     * Subtracts the given amount of hours from the time
     *
     * @param  int $value The number of hours to subtract
     * @return Carbon
     */
    public function subHours($value)
    {
        return $this->addHours(-1 * $value);
    }

    /**
     * Adds the given amount of minutes to the time
     *
     * @param  int $value The number of minutes to add
     * @return Carbon
     */
    public function addMinutes($value)
    {
        $interval = new DateInterval(sprintf("PT%dM", abs($value)));
        if ($value >= 0) {
            $this->add($interval);
        } else {
            $this->sub($interval);
        }

        return $this;
    }

    /**
     * Adds 1 minute to the time.
     *
     * @return Carbon
     */
    public function addMinute()
    {
        return $this->addMinutes(1);
    }

    /**
     * Subtracts 1 minute from the time.
     *
     * @return Carbon
     */
    public function subMinute()
    {
        return $this->addMinutes(-1);
    }

    /**
     * Subtracts the given amount of minutes from the time
     *
     * @param  int $value The number of minutes to subtract
     * @return Carbon
     */
    public function subMinutes($value)
    {
        return $this->addMinutes(-1 * $value);
    }

    /**
     * Adds the given amount of seconds to the time.
     *
     * @param  int $value The number of seconds to add
     * @return Carbon
     */
    public function addSeconds($value)
    {
        $interval = new DateInterval(sprintf("PT%dS", abs($value)));
        if ($value >= 0) {
            $this->add($interval);
        } else {
            $this->sub($interval);
        }

        return $this;
    }

    /**
     * Adds 1 second to the time.
     *
     * @return Carbon
     */
    public function addSecond()
    {
        return $this->addSeconds(1);
    }

    /**
     * Subtracts 1 second from the time.
     *
     * @return Carbon
     */
    public function subSecond()
    {
        return $this->addSeconds(-1);
    }

    /**
     * Subtracts the given amount of seconds from the time.
     *
     * @param  int $value Number of seconds to subtract
     * @return Carbon
     */
    public function subSeconds($value)
    {
        return $this->addSeconds(-1 * $value);
    }

    /**
     * Sets the time to 00:00:00
     *
     * @return Carbon
     */
    public function startOfDay()
    {
        return $this->hour(0)->minute(0)->second(0);
    }

    /**
     * Sets the time to 23:59:59
     *
     * @return Carbon
     */
    public function endOfDay()
    {
        return $this->hour(23)->minute(59)->second(59);
    }

    /**
     * Sets the date to the start of the first day of the current month.
     *
     * @return Carbon
     */
    public function startOfMonth()
    {
        return $this->startOfDay()->day(1);
    }

    /**
     * Sets the date to the end of the last day of the current month.
     *
     * @return Carbon
     */
    public function endOfMonth()
    {
        return $this->day($this->daysInMonth)->endOfDay();
    }

    /**
     * Gets the diff in years between this Carbon object and the given one.  If one is not given
     * then it will use the current date/time.
     *
     * @param  Carbon  $dt  The object to compare
     * @param  boolean $abs Whether to abs() the diff
     * @return int
     */
    public function diffInYears(Carbon $dt = null, $abs = true)
    {
        $dt = ($dt === null) ? self::now($this->tz) : $dt;
        $sign = ($abs) ? '' : '%r';

        return intval($this->diff($dt)->format($sign.'%y'));
    }

    /**
     * Gets the diff in months between this Carbon object and the given one.  If one is not given
     * then it will use the current date/time.
     *
     * @param  Carbon  $dt  The object to compare
     * @param  boolean $abs Whether to abs() the diff
     * @return int
     */
    public function diffInMonths(Carbon $dt = null, $abs = true)
    {
        $dt = ($dt === null) ? self::now($this->tz) : $dt;
        list($sign, $years, $months) = explode(':', $this->diff($dt)->format('%r:%y:%m'));
        $value = ($years * self::MONTHS_PER_YEAR) + $months;

        if ($sign === '-' && !$abs) {
            $value = $value * -1;
        }

        return $value;
    }

    /**
     * Gets the diff in days between this Carbon object and the given one.  If one is not given
     * then it will use the current date/time.
     *
     * @param  Carbon  $dt  The object to compare
     * @param  boolean $abs Whether to abs() the diff
     * @return int
     */
    public function diffInDays(Carbon $dt = null, $abs = true)
    {
        $dt = ($dt === null) ? self::now($this->tz) : $dt;
        $sign = ($abs) ? '' : '%r';

        return intval($this->diff($dt)->format($sign.'%a'));
    }

    /**
     * Gets the diff in hours between this Carbon object and the given one.  If one is not given
     * then it will use the current date/time.
     *
     * @param  Carbon  $dt  The object to compare
     * @param  boolean $abs Whether to abs() the diff
     * @return int
     */
    public function diffInHours(Carbon $dt = null, $abs = true)
    {
        $dt = ($dt === null) ? self::now($this->tz) : $dt;

        return intval($this->diffInMinutes($dt, $abs) / self::MINUTES_PER_HOUR);
    }

    /**
     * Gets the diff in minutes between this Carbon object and the given one.  If one is not given
     * then it will use the current date/time.
     *
     * @param  Carbon  $dt  The object to compare
     * @param  boolean $abs Whether to abs() the diff
     * @return int
     */
    public function diffInMinutes(Carbon $dt = null, $abs = true)
    {
        $dt = ($dt === null) ? self::now($this->tz) : $dt;

        return intval($this->diffInSeconds($dt, $abs) / self::SECONDS_PER_MINUTE);
    }

    /**
     * Gets the diff in second between this Carbon object and the given one.  If one is not given
     * then it will use the current date/time.
     *
     * @param  Carbon  $dt  The object to compare
     * @param  boolean $abs Whether to abs() the diff
     * @return int
     */
    public function diffInSeconds(Carbon $dt = null, $abs = true)
    {
        $dt = ($dt === null) ? self::now($this->tz) : $dt;
        list($sign, $days, $hours, $minutes, $seconds) = explode(':', $this->diff($dt)->format('%r:%a:%h:%i:%s'));
        $value = ($days * self::HOURS_PER_DAY * self::MINUTES_PER_HOUR * self::SECONDS_PER_MINUTE) +
                    ($hours * self::MINUTES_PER_HOUR * self::SECONDS_PER_MINUTE) +
                    ($minutes * self::SECONDS_PER_MINUTE) +
                    $seconds;

        if ($sign === '-' && !$abs) {
            $value = $value * -1;
        }

        return intval($value);
    }

    /**
     * Creates a human readable diff string from the current date to the one given.
     *
     * Examples:
     *     1 minute ago
     *     0 seconds ago
     *     1 hour from now
     *     1 hour after
     *     1 hour before
     *
     * @param  Carbon $other The date to compare
     * @return string
     */
    public function diffForHumans(Carbon $other = null)
    {
        $text = '';
        $intervals = array(
            12 * 30 * 24 * 60 * 60  =>  'year',
            30 * 24 * 60 * 60       =>  'month',
            24 * 60 * 60            =>  'day',
            60 * 60                 =>  'hour',
            60                      =>  'minute',
            1                       =>  'second'
        );

        $isNow = $other === null;

        if ($isNow) {
            $other = self::now();
        }

        $isFuture = $this->gt($other);
        $deltaTime = abs($other->diffInSeconds($this));

        if ($deltaTime < 1) {
            $text = '0 seconds';
        }

        foreach ($intervals as $secs => $str) {
            $diff = $deltaTime / $secs;
            if ($diff >= 1) {
                $diff = round($diff);
                $text = $diff.' '.$str.($diff > 1 ? 's' : '');
                break;
            }
        }

        if ($isNow) {
            if ($isFuture) {
                return $text.' from now';
            }

            return $text.' ago';
        }

        if ($isFuture) {
            return $text.' after';
        }

        return $text.' before';
    }
}

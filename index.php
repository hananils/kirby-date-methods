<?php

@include_once __DIR__ . '/vendor/autoload.php';

use Kirby\Cms\App as Kirby;

Kirby::plugin('hananils/date-methods', [
    'options' => [
        /**
         * The string used to separate a date range, e.g. `01.08.–05.08.2024`.
         *
         * @return string
         */
        'rangeseparator' => '–',
        /**
         * The string used to separate date and time, e.g. `01.08.2024, 10:00`.
         *
         * @return string
         */
        'datetimeseparator' => ', ',
        /**
         * The date format used, must be one of the [predefined constants in `IntlDateFormatter`](https://www.php.net/manual/en/class.intldateformatter.php#intldateformatter.constants.full).
         *
         * @return int IntlDateFormatter::LONG
         */
        'datetype' => IntlDateFormatter::LONG,
        /**
         * The time format used, must be one of the [predefined constants in `IntlDateFormatter`](https://www.php.net/manual/en/class.intldateformatter.php#intldateformatter.constants.full).
         *
         * @return int IntlDateFormatter::SHORT
         */
        'timetype' => IntlDateFormatter::SHORT
    ],
    'translations' => [
        'en' => [
            'hananils.date-methods.yearsPast' => '{count} years ago',
            'hananils.date-methods.yearPast' => 'a year ago',
            'hananils.date-methods.monthsPast' => '{count} months ago',
            'hananils.date-methods.weeksPast' => '{count} weeks ago',
            'hananils.date-methods.daysPast' => '{count} days ago',
            'hananils.date-methods.dayPast' => 'yesterday',
            'hananils.date-methods.todayPast' => 'today',
            'hananils.date-methods.hoursPast' => '{count} hours ago',
            'hananils.date-methods.hourPast' => 'an hour ago',
            'hananils.date-methods.minutesPast' => '{count} minutes ago',
            'hananils.date-methods.now' => 'just now',
            'hananils.date-methods.minutesFuture' => 'in {count} minutes',
            'hananils.date-methods.hourFuture' => 'in an hour',
            'hananils.date-methods.hoursFuture' => 'in {count} hours',
            'hananils.date-methods.yesterday' => 'tomorrow',
            'hananils.date-methods.daysFuture' => 'in {count} days',
            'hananils.date-methods.weeksFuture' => 'in {count} weeks',
            'hananils.date-methods.monthsFuture' => 'in {count} months',
            'hananils.date-methods.yearFuture' => 'in a year',
            'hananils.date-methods.yearsFuture' => 'in {count} years',
            'hananils.date-methods.calendarweek' => 'week {week}'
        ],
        'de' => [
            'hananils.date-methods.yearsPast' => 'vor {count} Jahren',
            'hananils.date-methods.yearPast' => 'vor einem Jahr',
            'hananils.date-methods.monthsPast' => 'vor {count} Monaten',
            'hananils.date-methods.weeksPast' => 'vor {count} Wochen',
            'hananils.date-methods.daysPast' => 'vor {count} Tagen',
            'hananils.date-methods.dayPast' => 'gestern',
            'hananils.date-methods.todayPast' => 'heute',
            'hananils.date-methods.hoursPast' => 'vor {count} Stunden',
            'hananils.date-methods.hourPast' => 'vor einer Stunde',
            'hananils.date-methods.minutesPast' => 'vor {count} Minuten',
            'hananils.date-methods.now' => 'gerade eben',
            'hananils.date-methods.minutesFuture' => 'in {count} Minuten',
            'hananils.date-methods.hourFuture' => 'in einer Stunde',
            'hananils.date-methods.hoursFuture' => 'in {count} Stunden',
            'hananils.date-methods.yesterday' => 'morgen',
            'hananils.date-methods.daysFuture' => 'in {count} Tagen',
            'hananils.date-methods.weeksFuture' => 'in {count} Wochen',
            'hananils.date-methods.monthsFuture' => 'in {count} Monaten',
            'hananils.date-methods.yearFuture' => 'in einem Jahr',
            'hananils.date-methods.yearsFuture' => 'in {count} Jahren',
            'hananils.date-methods.calendarweek' => 'KW {week}'
        ]
    ],
    'fieldMethods' => [
        /**
         * Returns a `DateTime` representation of the field value, see
         * [supported formats](https://www.php.net/manual/en/datetime.formats.php)
         */
        'toDateTime' => function ($field): DateTime {
            return datetime($field->value());
        },

        /**
         * Returns a `DateTimeImmutable` representation of the field value, see
         * [supported formats](https://www.php.net/manual/en/datetime.formats.php).
         */
        'toDateTimeImmutable' => function ($field): DateTimeImmutable {
            $datetime = new DateTimeImmutable($field->value());

            return $datetime;
        },

        /**
         * Returns a `DateInterval` representation of the field value, see
         * [supported formats](https://www.php.net/manual/en/dateinterval.construct.php).
         */
        'toDateInterval' => function ($field): DateInterval {
            $interval = new DateInterval($field->value());

            return $interval;
        },

        /**
         * Returns a `DateInterval` object representing the difference between
         * the field's date and the given date. The provided date can either be
         * a `DateTime` object or a PHP-readable string, defaults to the
         * difference to now.
         *
         * @param $to Date to compare the field value with. The provided date
         * can either be a `DateTime` object or a PHP-readable string, defaults
         * to `now`.
         */
        'toDateDiff' => function ($field, string $to = 'now'): DateInterval {
            $from = $field->toDateTime();
            $to = datetime($to);

            return $from->diff($to);
        },

        /**
         * Returns a `DateTime` representation of the field's value rounded the
         * given interval.
         *
         * @param $interval The interval to round the date to, defaults to
         * 5 minutes (`PT5M`).
         * @param $reference Reference date to start the interval from. Defaults
         * to the beginning of the century for year intervals, to the first day
         * of the year for month intervals, to the first day of the current
         * month for day intervals and to midnight for all smaller intervals.
         */
        'toDateRounded' => function (
            $field,
            string $interval = 'PT5M',
            string $reference = 'midnight'
        ): DateTime {
            return dateRounded($field->value(), $interval, $reference);
        },

        /**
         * Returns a localized, formatted date using `IntlDateFormatter`, see
         * [options](https://www.php.net/manual/de/intldateformatter.create.php).
         *
         * @param $datetype Format of the date determined by one of the [IntlDateFormatter constants](https://www.php.net/manual/de/class.intldateformatter.php#intl.intldateformatter-constants).
         * @param $timetype Format of the time determined by one of the [IntlDateFormatter constants](https://www.php.net/manual/de/class.intldateformatter.php#intl.intldateformatter-constants).
         * @param $timezone The timezone ID.
         * @param $calendar Calendar to use for formatting or parsing.
         * @param $pattern [Optional formatting pattern](https://unicode-org.github.io/icu/userguide/format_parse/datetime).
         */
        'toFormatted' => function (
            $field,
            int $datetype = IntlDateFormatter::LONG,
            int $timetype = IntlDateFormatter::NONE,
            IntlTimeZone|DateTimeZone|string|null $timezone = null,
            IntlCalendar|int|null $calendar = null,
            ?string $pattern = ''
        ): string {
            if (kirby()->language()) {
                $locale = kirby()->language()->locale();
            } else {
                $locale = option('locale', 'en');
            }

            if (is_array($locale)) {
                $values = array_values($locale);
                $locale = array_shift($values);
            }

            return dateFormatted(
                $locale,
                $field->toDateTime(),
                $datetype,
                $timetype,
                $timezone,
                $calendar,
                $pattern
            );
        },

        /**
         * Returns a localized date formatted by the given pattern, see
         * [symbol table](https://unicode-org.github.io/icu/userguide/format_parse/datetime/#date-field-symbol-table)
         * for reference. Shortcut to `toFormatted`.
         *
         * @param $pattern [The formatting pattern](https://unicode-org.github.io/icu/userguide/format_parse/datetime).
         */
        'toFormattedPattern' => function (
            $field,
            string $pattern = 'MMMM y'
        ): string {
            return $field->toFormatted(
                IntlDateFormatter::LONG,
                IntlDateFormatter::NONE,
                null,
                null,
                $pattern
            );
        },

        /**
         * Returns a human readable time difference to the given date, e. g.
         * `just now`, `2 years ago`, `in 5 minutes`. The given date can be a
         * `DateTime` object or any PHP-readable date string, see
         * [supported formats](https://www.php.net/manual/en/datetime.formats.php).
         *
         * @param $from The reference date to compare the field value to,
         * defaults to `now`.
         */
        'toRelative' => function (
            $field,
            DateTime|DateTimeImmutable|string $from = 'now'
        ): string {
            if (kirby()->language()) {
                $locale = kirby()->language()->locale();
            } else {
                $locale = option('locale', 'en');
            }

            return dateRelative($field->value(), $from, $locale);
        },

        /**
         * Returns the formatted time of the given field value.
         *
         * @param $format The time format, defaults to `H:i`.
         */
        'toTime' => function ($field, string $format = 'H:i'): string {
            return $field->toDateTime()->format($format);
        },

        /**
         * Creates a `DateTime` representation of the field value and returns it
         * with the year set to the current one.
         */
        'toCurrentYear' => function ($field) {
            $today = new DateTime();
            $date = $field->toDateTime();
            $current = new DateTime();
            $current->setDate(
                $today->format('Y'),
                $date->format('m'),
                $date->format('d')
            );

            return $current;
        },

        /**
         * Creates a `DateTime` representation of the field value and returns it
         * with the month set to the current one.
         */
        'toCurrentMonth' => function ($field): DateTime {
            $today = new DateTime();
            $date = $field->toDateTime();
            $current = new DateTime();
            $current->setDate(
                $date->format('Y'),
                $today->format('m'),
                $date->format('d')
            );

            return $current;
        },

        /**
         * Creates a `DateTime` representation of the field value and returns it
         * with the day set to the current one.
         */
        'toCurrentDay' => function ($field): DateTime {
            $today = new DateTime();
            $date = $field->toDateTime();
            $current = new DateTime();
            $current->setDate(
                $date->format('Y'),
                $date->format('m'),
                $today->format('d')
            );

            return $current;
        },

        /**
         * Calculates the difference difference between the field value and the
         * given date. Returns the difference in the given format, see
         * [format options](https://www.php.net/manual/de/dateinterval.format.php).
         * Useful to calculate the age of a person.
         *
         * @param $on Reference date for the age calculation, defaults to `today`.
         * @param $format Age format, defaults to `%y` (years).
         */
        'toAge' => function (
            $field,
            string $on = 'today',
            string $format = '%y'
        ): string {
            $birthday = new DateTime($field->value());
            $on = new DateTime($on);
            $diff = $birthday->diff($on);

            return $diff->format($format);
        },

        /**
         * Checks it the field value is earlier than or equal to the given date.
         *
         * @param $date The reference date, defaults to `now`.
         * @param $equal Flag to also accept equal dates, defaults to `false`.
         */
        'isEarlierThan' => function (
            $field,
            DateTime|DateTimeImmutable|string $date = 'now',
            bool $equal = false
        ): bool {
            if ($equal) {
                return $field->toDateTime() <= new DateTime($date);
            } else {
                return $field->toDateTime() < new DateTime($date);
            }
        },

        /**
         * Checks it the field value is later than or equal to the given date.
         *
         * @param $date The reference date, defaults to `now`.
         * @param $equal Flag to also accept equal dates, defaults to `false`.
         */
        'isLaterThan' => function (
            $field,
            DateTime|DateTimeImmutable|string $date = 'now',
            bool $equal = false
        ): bool {
            if ($equal) {
                return $field->toDateTime() >= new DateTime($date);
            } else {
                return $field->toDateTime() > new DateTime($date);
            }
        }
    ],
    'pageMethods' => [
        /**
         * Takes fields for start and end dates and converts their values to a
         * formatted date range string.
         *
         * @param $fieldStart Either a single field name containing the start
         * date or an array of fields containing the start date and time.
         * @param $fieldEnd Either a single field name containing the end
         * date or an array of fields containing the end date and time.
         */
        'toDateRange' => function (
            array|string $fieldStart = ['start', 'starttime'],
            array|string $fieldEnd = ['end', 'endtime']
        ): string {
            if (is_array($fieldStart)) {
                $start = $this->content()
                    ->get($fieldStart[0])
                    ->toDate('Y-m-d');
                $starttime = $this->content()
                    ->get($fieldStart[1])
                    ->toDate('H:i');
            } else {
                $start = $this->content()->get($fieldStart)->toDate('Y-m-d');
                $starttime = null;
            }

            if (is_array($fieldEnd)) {
                $end = $this->content()
                    ->get($fieldEnd[0])
                    ->toDate('Y-m-d');
                $endtime = $this->content()
                    ->get($fieldEnd[1])
                    ->toDate('H:i');
            } else {
                $end = $this->content()->get($fieldEnd)->toDate('Y-m-d');
                $endtime = null;
            }

            if (!$end) {
                $end = $start;
            }

            return dateRange([$start, $starttime], [$end, $endtime]);
        },
        /**
         * Takes fields for start and end dates and converts their values to a
         * `DatePeriod` instance.
         *
         * @param $fieldStart The name of the field containing the start date.
         * @param $fieldEnd The name of the field containing the end date.
         * @parem $interval The interval between recurrences within the period.
         */
        'toDatePeriod' => function (
            string $fieldStart = 'start',
            string $fieldEnd = 'end',
            string $interval = 'P1D'
        ): DatePeriod {
            $start = $this->content()->get($fieldStart)->toDateTime();
            $end = $this->content()->get($fieldEnd)->toDateTime();
            $interval = new DateInterval($interval);

            return new DatePeriod($start, $interval, $end);
        },

        /**
         * Takes fields for start and end dates and coverts them to an array of
         * dates based on the given date interval and format.
         *
         * @param $fieldStart The name of the field containing the start date.
         * @param $fieldEnd The name of the field containing the end date.
         * @param $interval The interval between recurrences within the period.
         * @param $format The date format.
         */
        'toDates' => function (
            string $fieldStart = 'start',
            string $fieldEnd = 'end',
            string $interval = 'P1D',
            string $format = 'Y-m-d'
        ): array {
            $period = $this->toDatePeriod($fieldStart, $fieldEnd, $interval);
            $dates = iterator_to_array($period);

            if ($format) {
                $dates = array_map(function ($date) use ($format) {
                    return $date->format($format);
                }, $dates);
            }

            return $dates;
        }
    ]
]);

/**
 * Returns a `DateTime` object from the given date and time string. Directly
 * returns the input if it's a `DateTime` object already.
 *
 * @param $datetime The date.
 */
function datetime(
    DateTime|DateTimeImmutable|string|null $datetime = 'now'
): DateTime|DateTimeImmutable {
    if (is_a($datetime, 'DateTime') || is_a($datetime, 'DateTimeImmutable')) {
        return $datetime;
    }

    if ($datetime === null) {
        $datetime = 'now';
    }

    return new DateTime($datetime);
}

/**
 * Returns a human readable time difference to the given date, e. g. `just now`,
 * `2 years ago`, `in 5 minutes`. The given date can be a `DateTime` object or
 * any PHP-readable date string, see [supported formats](https://www.php.net/manual/en/datetime.formats.php).
 *
 * @param $to The date.
 * @param $from The reference date.
 * @param $locale The locale.
 */
function dateRelative(
    DateTime|DateTimeImmutable|string $to,
    DateTime|DateTimeImmutable|string $from = 'now',
    string|null $locale = null
): string {
    $from = datetime($from);
    $to = datetime($to);
    $diff = $from->diff($to);
    $direction = $diff->invert ? 'Past' : 'Future';
    $count = null;

    if ($diff->y > 0) {
        $id = $diff->y === 1 ? 'year' : 'years';
        $count = $diff->y;
    } elseif ($diff->m > 1) {
        $id = 'months';
        $count = $diff->m;
    } elseif ($diff->days > 13) {
        $id = 'weeks';
        $count = round($diff->days / 7);
    } elseif ($diff->days > 1) {
        $id = 'days';
        $count = $diff->days;
    } elseif ($diff->days === 1 || $from->format('d') !== $to->format('d')) {
        $id = 'day';
    } elseif ($direction === 'Past' && $diff->h > 3) {
        $id = 'today';
    } elseif ($diff->h > 0) {
        $id = 'hours';
        $count = $diff->h;
    } elseif ($diff->h === 1) {
        $id = 'hour';
    } elseif ($diff->i > 5) {
        $id = 'minutes';
        $count = $diff->i;
    } else {
        $id = 'now';
        $direction = '';
    }

    return tt(
        'hananils.date-methods.' . $id . $direction,
        null,
        [
            'count' => $count
        ],
        $locale
    );
}

/**
 * Returns a localized, formatted date using `IntlDateFormatter`, see
 * [options](https://www.php.net/manual/de/intldateformatter.create.php).
 *
 * @param $locale Locale to use when formatting.
 * @param $datetime
 * @param $datetype Format of the date determined by one of the [IntlDateFormatter constants](https://www.php.net/manual/de/class.intldateformatter.php#intl.intldateformatter-constants).
 * @param $timetype Format of the time determined by one of the [IntlDateFormatter constants](https://www.php.net/manual/de/class.intldateformatter.php#intl.intldateformatter-constants).
 * @param $timezone The timezone ID.
 * @param $calendar Calendar to use for formatting or parsing.
 * @param $pattern [Optional formatting pattern](https://unicode-org.github.io/icu/userguide/format_parse/datetime).
 */
function dateFormatted(
    string $locale,
    DateTime|DateTimeImmutable|string $datetime,
    int $datetype = IntlDateFormatter::LONG,
    int $timetype = IntlDateFormatter::NONE,
    IntlTimeZone|DateTimeZone|string|null $timezone = null,
    IntlCalendar|int|null $calendar = null,
    ?string $pattern = null
): string {
    $formatter = new IntlDateFormatter(
        $locale,
        $datetype,
        $timetype,
        $timezone,
        $calendar,
        $pattern
    );

    return $formatter->format(datetime($datetime));
}

/**
 * Returns a `DateTime` representation of the given date rounded the given
 * interval.
 *
 * @param $datetime The date.
 * @param $interval The interval to round the date to.
 * @param $reference Reference date to start the interval from. Defaults
 * to the beginning of the century for year intervals, to the first day
 * of the year for month intervals, to the first day of the current
 * month for day intervals and to midnight for all smaller intervals.
 */
function dateRounded($datetime, $interval = 'PT5M', $reference = null): DateTime
{
    $date = new DateTimeImmutable($datetime);
    $interval = new DateInterval($interval);

    if (!$reference) {
        if ($interval->y > 0) {
            $century = floor($date->format('Y') / 100) * 100;
            $reference = '00:00:00 first day of January ' . $century;
        } elseif ($interval->m > 0) {
            $reference = '00:00:00 first day of January this year';
        } elseif ($interval->d > 0) {
            $reference = '00:00:00 first day of this month';
        } else {
            $reference = '00:00:00';
        }
    }

    $start = $date->modify($reference);
    $end = $date->add($interval);

    $period = new DatePeriod($start, $interval, $end);
    $timestamp = $date->getTimestamp();
    $normalized = null;
    foreach ($period as $occurence) {
        $current = $occurence->getTimestamp();
        if (
            !$normalized ||
            abs($timestamp - $current) < abs($timestamp - $normalized)
        ) {
            $normalized = $current;
        }
    }

    $result = new DateTime();

    return $result->setTimestamp($normalized);
}

/**
 * Takes start and end dates and converts their values to a formatted
 * date range string.
 *
 * @param $from Either a single start date or an array of the start date and time.
 * @param $to Either a single end date or an array of the end date and time.
 */
function dateRange($from = [null, null], $to = [null, null]): string
{
    if (kirby()->language()) {
        $locale = kirby()->language()->code();
    } else {
        $locale = option('locale', 'en');
    }

    $options = option('hananils.date-methods', [
        'rangeseparator' => '–',
        'datetimeseparator' => ', ',
        'datetype' => IntlDateFormatter::LONG,
        'timetype' => IntlDateFormatter::SHORT
    ]);

    $ranger = new OpenPsa\Ranger\Ranger($locale);
    $ranger->setRangeSeparator($options['rangeseparator']);
    $ranger->setDateTimeSeparator($options['datetimeseparator']);
    $ranger->setDateType($options['datetype']);
    $ranger->setTimeType($options['timetype']);

    if (!is_array($from)) {
        $from = [$from, null];
    }
    if (!is_array($to)) {
        $to = [$to, null];
    }

    $start = $end = datetime($from[0]);
    if ($to[0] !== null) {
        $end = datetime($to[0]);
    }

    if (!empty($from[1])) {
        $startTime = $endTime = datetime($from[1]);

        if (!empty($to[1])) {
            $endTime = datetime($to[1]);
        }

        $start->setTime($startTime->format('H'), $startTime->format('i'));
        $end->setTime($endTime->format('H'), $endTime->format('i'));

        $ranger->setTimeType(IntlDateFormatter::SHORT);
    } else {
        $ranger->setTimeType(IntlDateFormatter::NONE);
    }

    // Ranger doesn't correctly format same start and end dates with times.
    // This needs to be handled manually.
    if ($start == $end) {
        $result = dateFormatted(
            $locale,
            $start,
            $options['datetype'],
            IntlDateFormatter::NONE
        );

        if (!empty($from[1])) {
            $result .= $options['datetimeseparator'];
            $result .= dateFormatted(
                $locale,
                $start,
                IntlDateFormatter::NONE,
                $options['timetype']
            );
        }

        return $result;
    }

    $result = $ranger->format(
        $start->format('Y-m-d H:i'),
        $end->format('Y-m-d H:i')
    );

    if (str_starts_with($locale, 'de')) {
        $result = preg_replace(
            '/(\d.) – (\d)/',
            '$1&thinsp;–&thinsp;$2',
            $result
        );
    }

    return $result;
}

/**
 * Converts the given date string to `Y-m-d` format.
 *
 * @param $date The date to be normalized.
 */
function normalizeDate(string $date): string
{
    if (empty($date)) {
        return $date;
    }

    if (preg_match('/\d\d\d\d-\d\d-\d\d/', $date)) {
        return $date;
    }

    $formatter = new IntlDateFormatter(
        kirby()->language()
            ? kirby()->language()->locale()
            : option('locale', 'en'),
        IntlDateFormatter::SHORT,
        IntlDateFormatter::NONE
    );

    $timestamp = $formatter->parse($date);

    if ($timestamp === false) {
        return false;
    }

    return date('Y-m-d', $timestamp);
}

/**
 * Converts the given date string to `H:i` format.
 *
 * @param $time The time to be normalized.
 */
function normalizeTime(string $time): string
{
    if (empty($time)) {
        return $time;
    }

    $time = str_replace('.', ':', $time);
    $time = preg_replace('/[^0-9:]/', '', $time);

    if (preg_match('/\d\d:\d\d/', (string) $time)) {
        return $time;
    }

    $timestamp = strtotime((string) $time);

    if ($timestamp === false) {
        return false;
    }

    return date('H:i', $timestamp);
}

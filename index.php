<?php

@include_once __DIR__ . '/vendor/autoload.php';

Kirby::plugin('hananils/date-methods', [
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
        'toDateTime' => function ($field) {
            return datetime($field->value());
        },
        'toDateTimeImmutable' => function ($field) {
            $datetime = new DateTimeImmutable($field->value());

            return $datetime;
        },
        'toDateInterval' => function ($field) {
            $interval = new DateInterval($field->value());

            return $interval;
        },
        'toDateDiff' => function ($field, $to = 'now') {
            $from = $field->toDateTime();
            $to = datetime($to);

            return $from->diff($to);
        },
        'toDateRounded' => function (
            $field,
            $interval = 'PT5M',
            $reference = 'midnight'
        ) {
            return dateRounded($field->value(), $interval, $reference);
        },
        'toFormatted' => function (
            $field,
            $datetype = IntlDateFormatter::LONG,
            $timetype = IntlDateFormatter::NONE,
            $timezone = null,
            $calendar = null,
            $pattern = ''
        ) {
            if (kirby()->language()) {
                $locale = kirby()
                    ->language()
                    ->locale();
            } else {
                $locale = option('locale');
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
        'toFormattedPattern' => function ($field, $pattern = 'MMMM y') {
            return $field->toFormatted(
                IntlDateFormatter::LONG,
                IntlDateFormatter::NONE,
                null,
                null,
                $pattern
            );
        },
        'toRelative' => function ($field, $from = 'now') {
            if (kirby()->language()) {
                $locale = kirby()
                    ->language()
                    ->locale();
            } else {
                $locale = option('locale');
            }

            return dateRelative($field->value(), $from, $locale);
        },
        'toTime' => function ($field, $format = 'H:i') {
            return $field->toDateTime()->format($format);
        },
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
        'toCurrentMonth' => function ($field) {
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
        'toCurrentDay' => function ($field) {
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
        'toAge' => function ($field, $on = 'today', $format = '%y') {
            $birthday = new DateTime($field->value());
            $on = new DateTime($on);
            $diff = $birthday->diff($on);

            return $diff->format($format);
        },
        'isEarlierThan' => function ($field, $date = 'now', $equal = false) {
            if ($equal) {
                return $field->toDateTime() <= new DateTime($date);
            } else {
                return $field->toDateTime() < new DateTime($date);
            }
        },
        'isLaterThan' => function ($field, $date = 'now', $equal = false) {
            if ($equal) {
                return $field->toDateTime() >= new DateTime($date);
            } else {
                return $field->toDateTime() > new DateTime($date);
            }
        }
    ],
    'pageMethods' => [
        'toDateRange' => function (
            $fieldStart = ['start', 'starttime'],
            $fieldEnd = ['end', 'endtime']
        ) {
            if (is_array($fieldStart)) {
                $start = $this->content()
                    ->get($fieldStart[0])
                    ->toDate('Y-m-d');
                $starttime = $this->content()
                    ->get($fieldStart[1])
                    ->toDate('H:i');
            } else {
                $start = $this->content()
                    ->get($fieldStart)
                    ->toDate('Y-m-d');
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
                $end = $this->content()
                    ->get($fieldEnd)
                    ->toDate('Y-m-d');
                $endtime = null;
            }

            if (!$end) {
                $end = $start;
            }

            return dateRange([$start, $starttime], [$end, $endtime]);
        },
        'toDatePeriod' => function (
            $fieldStart = 'start',
            $fieldEnd = 'end',
            $interval = 'P1D'
        ) {
            $start = $this->content()
                ->get($fieldStart)
                ->toDateTime();
            $end = $this->content()
                ->get($fieldEnd)
                ->toDateTime();
            $interval = new DateInterval($interval);

            return new DatePeriod($start, $interval, $end);
        },
        'toDates' => function (
            $fieldStart = 'start',
            $fieldEnd = 'end',
            $interval = 'P1D',
            $format = 'Y-m-d'
        ) {
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
 * Helpers
 */

function datetime($datetime = 'now')
{
    if (is_a($datetime, 'DateTime') || is_a($datetime, 'DateTimeImmutable')) {
        return $datetime;
    }

    return new DateTime($datetime);
}

function dateRelative($to, $from = 'now', $locale = null)
{
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

function dateFormatted(
    $locale,
    $datetime,
    $datetype = IntlDateFormatter::LONG,
    $timetype = IntlDateFormatter::NONE,
    $timezone = null,
    $calendar = null,
    $pattern = ''
) {
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

function dateRounded($datetime, $interval = 'PT5M', $reference = null)
{
    $date = new DateTimeImmutable($date);
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

function dateRange($from = [null, null], $to = [null, null])
{
    $options = option('hananils.date-methods', [
        'code' => 'de',
        'rangeseparator' => '–',
        'datetimeseparator' => ', ',
        'datetype' => IntlDateFormatter::LONG,
        'timetype' => IntlDateFormatter::SHORT
    ]);

    $ranger = new OpenPsa\Ranger\Ranger($options['code']);
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
        [$hours, $minutes] = explode(':', $from[1]);
        $start->setTime($hours, $minutes);

        if (!empty($to[1])) {
            [$hours, $minutes] = explode(':', $to[1]);
        }

        $end->setTime($hours, $minutes);

        $ranger->setTimeType(IntlDateFormatter::SHORT);
    } else {
        $ranger->setTimeType(IntlDateFormatter::NONE);
    }

    // Ranger doesn't correctly format same start and end dates with times.
    // This needs to be handled manually.
    if ($start == $end) {
        $result = dateFormatted(
            $options['code'],
            $start,
            $options['datetype'],
            IntlDateFormatter::NONE
        );

        if (!empty($from[1])) {
            $result .= $options['datetimeseparator'];
            $result .= dateFormatted(
                $options['code'],
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

    if ($options['code'] === 'de') {
        $result = preg_replace(
            '/(\d.) – (\d)/',
            '$1&thinsp;–&thinsp;$2',
            $result
        );
    }

    return $result;
}

function normalizeDate($string)
{
    if (empty($string)) {
        return $string;
    }

    if (preg_match('/\d\d\d\d-\d\d-\d\d/', $string)) {
        return $string;
    }

    $formatter = new IntlDateFormatter(
        kirby()->language()
            ? kirby()
                ->language()
                ->locale()
            : option('locale'),
        IntlDateFormatter::SHORT,
        IntlDateFormatter::NONE
    );

    $timestamp = $formatter->parse($string);

    if ($timestamp === false) {
        return false;
    }

    return date('Y-m-d', $timestamp);
}

function normalizeTime($string)
{
    if (empty($string)) {
        return $string;
    }

    $string = str_replace('.', ':', $string);
    $string = preg_replace('/[^0-9:]/', '', $string);

    if (preg_match('/\d\d:\d\d/', $string)) {
        return $string;
    }

    $timestamp = strtotime($string);

    if ($timestamp === false) {
        return false;
    }

    return date('H:i', $timestamp);
}

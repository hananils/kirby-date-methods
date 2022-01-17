![Kirby Date Methods](.github/title.png)

Date Methods is a plugin for [Kirby 3](https://getkirby.com) that allows for advanced date and time parsing and formatting using PHP's core date objects. It offers methods for fields to handle single dates, methods for pages to handle multiple dates (ranges) and also provides helper functions to simplify working with dates and times in general.

## Overview

There are four types of methods:

### 1. Converters

Converters read a date string and convert it to PHP date and time objects like `DateTime`, `DateTimeImmutable` or `DateInterval` or arrays.

- [`toDateTime()`](#todatetime) or [`datetime()`](#datetimedatetime)
- [`toDateTimeImmutable()`](#todatetimeimmutable)
- [`toDateInterval()`](#todateinterval)
- [`toDateDiff()`](#todatediffto)
- [`toDatePeriod()`](#todateperiodfieldstart-fieldend-interval)
- [`toDates()`](#todatesfieldstart-fieldend-interval-format)

```php
// Get DateTime object
$datetime = $page->date()->toDateTime();

// Modify and format date
$page
  ->date()
  ->toDateTime()
  ->modify('+1 month')
  ->format('Y-m-d');

// Compare a date field to another date
$page
  ->date()
  ->toDateDiff('2000-01-01')
  ->format('The beginning of the century was %y ago.');
```

### 2. Formatters

Formatters read a date string and return a formatted and localized string, either absolute or relative.

- [`toFormatted()`](#toformatteddatetype-timetype-timezone-calendar-pattern) or [`dateFormatted()`](#dateformattedlocale-datetime-datetype-timetype-timezone-calendar-pattern)
- [`toFormattedPattern()`](#toformattedpatternpattern)
- [`toRelative()`](#torelativefrom) or [`dateRelative()`](#daterelativeto-from-locale)
- [`toTime()`](#totimeformat)
- [`toAge()`](#toageon-format)
- [`toDateRange()`](#todaterangefieldstart-fieldend) or [`dateRange()`](#daterangeto-from)

```php
// Get the date formatted in the current locale style, e. g.
// '2021-01-01' becomes '1. Januar 2021' in German
echo $page->date()->toFormatted();

// Get the date formatted with a specific pattern in the current
// locale style, e. g. '2021-01-01' becomes 'Januar 2021'
echo $page->date()->toFormattedPattern('MMMM y');

// Get the relative date like '5 days ago'
echo $page->date()->toRelative();

// Get the age of a person
echo 'Nils is now ' . $page->birthday()->toAge() . ' years old';

// Given a start and an end date field, return the localized
// formatted date range, e. g. for the field values '2021-07-17'
// and '2021-07-21' return '17. – 21. Juli 2021'
echo $page->toDateRange();
```

### 3. Modifiers

Modifiers adjust dates to the current day, month or year which is helpful when you need to display the birthday of a person this year.

- [`toDateRounded()`](#todateroundedinterval-reference) or [`dateRounded()`](#dateroundeddatetime-interval-reference)
- [`toCurrentYear()`](#tocurrentyear)
- [`toCurrentMonth()`](#tocurrentmonth)
- [`toCurrentDay()`](#tocurrentday)
- [`normalizeDate()`](#normalizedatestring)
- [`normalizeTime()`](#normalizetimestring)

```php
// Round a date to the next full 5 minutes, e. g.
// '2021-02-01 13:42' becomes '2021-02-01 13:45'
$published = $page->published()->toDateRounded();

// This can then be formatted automatically, e. g.
// '1. Februar 2021 13:45'
$published->toFormatted(IntlDateFormatter::LONG, IntlDateFormatter::SHORT);

// Get a user's birthday this year
echo 'Bastian’s birthday is on ' .
  $user
    ->birthday()
    ->toCurrentYear()
    ->toFormatted();
```

### 4. Validators

- [`isEarlierThan()`](#isearlierthandate-equal)
- [`isLaterThan()`](#islaterthandate-equal)

```php
// Check the given date
if ($page->published()->isEarlierThan('2010-01-01')) {
  echo 'This article is very old, please check if there are update available.'
}
```

## Installation

### Download

Download and copy this repository to `/site/plugins/date-methods`.

### Git submodule

```
git submodule add https://github.com/hananils/kirby-date-methods.git site/plugins/date-methods
```

### Composer

```
composer require hananils/kirby-date-methods
```

# Field methods

Field methods can be called on any field storing date information in a PHP-readable format.

## toDateTime()

Returns a `DateTime` representation of the field value, see [supported formats](https://www.php.net/manual/en/datetime.formats.php).

```php
$page->date()->toDateTime();
```

## toDateTimeImmutable()

Returns a `DateTimeImmutable` representation of the field value, see [supported formats](https://www.php.net/manual/en/datetime.formats.php).

```php
$page->date()->toDateTimeImmutable();
```

## toDateInterval()

Returns a `DateInterval` representation of the field value, see [supported formats](https://www.php.net/manual/en/dateinterval.construct.php).

```php
$page->date()->toDateInterval();
```

## toDateDiff($to)

Returns a `DateInterval` object representing the difference between the field's date and the given date. The provided date can either be a `DateTime` object or a PHP-readable string, defaults to the difference to now.

- **`$to`:** date to compare the field value with. The provided date can either be a `DateTime` object or a PHP-readable string, defaults to `now```.

```php
$page->date()->toDateDiff('+1 month');
```

## toDateRounded($interval, $reference)

Returns a `DateTime` representation of the field's value rounded the given interval.

- **`$interval`:** the interval to round the date to, defaults to 5 minutes (`PT5M`).
- **`$reference`:** reference date to start the interval from. Defaults to the beginning of the century for year intervals, to the first day of the year for month intervals, to the first day of the current month for day intervals and to midnight for all smaller intervals.

## toFormatted($datetype, $timetype, $timezone, $calendar, $pattern)

Returns a localized, formatted date using `IntlDateFormatter`, see [options](https://www.php.net/manual/de/intldateformatter.create.php).

- **`$datetype`:** the datetype, defaults to `IntlDateFormatter::LONG`.
- **`$timetype`:** the timetype, defaults to `IntlDateFormatter::NONE`.
- **`$timezone`:** the timezone, defaults to `null`.
- **`$calendar`:** the calendar, defaults to `null`.
- **`$pattern`:** the pattern, defaults to `''`.

```php
// Returns 1. Januar 2020 for 2020-01-01 and de_DE
$page->date()->toFormatted();
```

The locale is set based on the current Kirby language in a multilangual setup or on the `locale` config setting otherwise.

## toFormattedPattern($pattern)

Returns a localized date formatted by the given pattern, see [symbol table](https://unicode-org.github.io/icu/userguide/format_parse/datetime/#date-field-symbol-table) for reference. Shortcut to `toFormatted`.

- **`$pattern`:** the pattern, defaults to `MMMM y`.

## toRelative($from)

Returns a human readable time difference to the given date, e. g. `just now`, `2 years ago`, `in 5 minutes`. The given date can be a `DateTime` object or any PHP-readable date string, see [supported formats](https://www.php.net/manual/en/datetime.formats.php).

- **`$from`:** the reference date to compare the field value to, defaults to `now`.

```php
$page->date()->toRelative('next Monday');
```

## toTime($format)

Returns the formatted time of the given field value.

- **`$format`:** the time format, defaults to `H:i`.

```php
$page->date()->toTime();
```

## toCurrentYear()

Creates a `DateTime` representation of the field value and returns it with the year set to the current one.

```php
$page->date()->toCurrentYear();
```

## toCurrentMonth()

Creates a `DateTime` representation of the field value and returns it with the month set to the current one.

```php
$page->date()->toCurrentMonth();
```

## toCurrentDay()

Creates a `DateTime` representation of the field value and returns it with the day set to the current one.

```php
$page->date()->toCurrentDay();
```

## toAge($on, $format)

Calculates the difference difference between the field value and the given date. Returns the difference in the given format, see [format options](https://www.php.net/manual/de/dateinterval.format.php). Useful to calculate the age of a person.

- **`$on`:** reference date for the age calculation, defaults to `today`.
- **`$format`:** age format, defaults to `%y` (years).

```php
// Returns 10 given '2011-08-04'
$page->date()->toAge('2021-08-04');
```

## isEarlierThan($date, $equal)

Checks it the field value is earlier than or equal to the given date.

- **`$date`:** the reference date, defaults to `now`.
- **`$equal`:** flag to also accept equal dates, defaults to `false`.

## IsLaterThan($date, $equal)

Checks it the field value is later than or equal to the given date.

- **`$date`:** the reference date, defaults to `now`.
- **`$equal`:** flag to also accept equal dates, defaults to `false`.

# Pages methods

## toDateRange($fieldStart, $fieldEnd)

Returns a human-readable date range for the given dates:

- **`$fieldStart`:** the start date field name, defaults to 'start'.
- **`$fieldEnd`:** the end date field name, defaults to 'end'.

Returns a human-readable date range for the given dates and times:

- **`$fieldStart`:** an array of the start date and time field names, defaults to ['start', 'starttime'].
- **`$fieldEnd`:** the end date and time field names, defaults to ['end', 'endtime'].

The formatting is provided by [Ranger](https://github.com/flack/ranger).

## toDatePeriod($fieldStart, $fieldEnd, $interval)

Returns a `DatePeriod` object for the values of the given fields and interval.

- **`$fieldStart`:** the start date field name, defaults to 'start'.
- **`$fieldEnd`:** the end date field name, defaults to 'end'.
- **`$interval`:** the interval used for the period, defaults to `P1D` (one day).

## toDates($fieldStart, $fieldEnd, $interval, $format)

Returns the dates of the period for the values of the given fields and interval.

- **`$fieldStart`:** the start date field name, defaults to 'start'.
- **`$fieldEnd`:** the end date field name, defaults to 'end'.
- **`$interval`:** the interval used for the period, defaults to `P1D` (one day).
- **`$format`:** the format used for the returned dates, defaults to `Y-m-d`.

# Helpers

These helpers are used under the hood of the field and page methods and can be used outside of the field or pages context by passing date strings.

## datetime($datetime)

Returns a `DateTime` object from the given date and time string. Directly returns the input if it's a `DateTime` object already.

-**`$datetime`:** the date, defaults to `now`.

## dateRelative($to, $from, $locale)

Returns a human readable time difference to the given date, e. g. `just now`, `2 years ago`, `in 5 minutes`. The given date can be a `DateTime` object or any PHP-readable date string, see [supported formats](https://www.php.net/manual/en/datetime.formats.php).

- **`$to`:** the date to compare to.
- **`$from`:** the date to compare from, defaults to `now`.
- **`$locale`:** the locale used for formatting.

```php
dateRelative('2019-12-31', 'now');
```

## dateFormatted($locale, $datetime, $datetype, $timetype, $timezone, $calendar, $pattern)

Returns a localized, formatted date using `IntlDateFormatter`, see [options](https://www.php.net/manual/de/intldateformatter.create.php).

- **`$locale`:** the locale used for formatting.
- **`$datetime`:** the date in a PHP readable format.
- **`$datetype`:** the datetype, defaults to `IntlDateFormatter::LONG`.
- **`$timetype`:** the timetype, defaults to `IntlDateFormatter::NONE`.
- **`$timezone`:** the timezone, defaults to `null`.
- **`$calendar`:** the calendar, defaults to `null`.
- **`$pattern`:** the pattern, defaults to `''`.

```php
dateFormatted('de_DE', '2020-01-01');
```

## dateRounded($datetime, $interval, $reference)

Returns a `DateTime` representation of the field's value rounded the given interval.

- **`$datetime`:** the date in a PHP readable format.
- **`$interval`:** the interval to round the date to, defaults to 5 minutes (`PT5M`).
- **`$reference`:** reference date to start the interval from. Defaults to the beginning of the century for year intervals, to the first day of the year for month intervals, to the first day of the current month for day intervals and to midnight for all smaller intervals.

## dateRange($to, $from)

Returns a human-readable date range for the given dates and times:

- **`$to`:** an array of the start date and time field names, defaults to ['start', 'starttime'].
- **`$from`:** the end date and time field names, defaults to ['end', 'endtime'].

```php
dateRange('2020-01-01', '2020-07-01');
```

The formatting is provided by [Ranger](https://github.com/flack/ranger).

## normalizeDate($string)

Converts the given date string to `Y-m-d` format.

- **`$string`:** the date string to be normalized.

## normalizeTime($string)

Converts the given date string to `H:i` format.

- **`$string`:** the date string to be normalized.

# License

This plugin is provided freely under the [MIT license](LICENSE.md) by [hana+nils · Büro für Gestaltung](https://hananils.de).
We create visual designs for digital and analog media.

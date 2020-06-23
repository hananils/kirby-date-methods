# Kirby Date Methods

Kirby 3 plugin providing field and page methods for formatting dates and creating PHP date objects.

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

## Field methods

Field methods can be called on any field storing date information in a PHP-readable format.

### toDateTime()

Returns a `DateTime` representation of the field value, see [supported formats](https://www.php.net/manual/en/datetime.formats.php).

```php
$page->date()->toDateTime()
```

### toDateTimeImmutable()

Returns a `DateTimeImmutable` representation of the field value, see [supported formats](https://www.php.net/manual/en/datetime.formats.php).

```php
$page->date()->toDateTimeImmutable()
```

### toDateIntervale()

Returns a `DateInterval` representation of the field value, see [supported formats](https://www.php.net/manual/en/dateinterval.construct.php).

```php
$page->date()->toDateInterval()
```

### toDateDiff(\$to)

Returns a `DateInterval` object representing the difference between the field's date and the given date. The provided date can either be a `DateTime` object or a PHP-readable string, defaults to the difference to now.

```php
$page->date()->toDateDiff('+1 month')
```

### toFormatted($datetype, $timetype, $timezone, $calendar, \$pattern)

Returns a localized, formatted date using `IntlDateFormatter`, see [options](https://www.php.net/manual/de/intldateformatter.create.php). The locale is set based on the current Kirby language in a multilangual setup or on the `locale` config setting otherwise.

```php
// Returns 1. Januar 2020 for 2020-01-01 and de_DE
$page->date()->toFormatted();
```

### toRelative(\$from)

Returns a human readable time difference to the given date, e. g. `just now`, `2 years ago`, `in 5 minutes`. The given date can be a `DateTime` object or any PHP-readable date string, see [supported formats](https://www.php.net/manual/en/datetime.formats.php). Defaults to now.

```php
$page->date()->toRelative('next Monday');
```

### toCurrentYear()

Creates a `DateTime` representation of th field value and returns it with the year set to the current one.

```php
$page->date()->toCurrentYear();
```

### toCurrentMonth()

Creates a `DateTime` representation of th field value and returns it with the month set to the current one.

```php
$page->date()->toCurrentMonth();
```

### toCurrentDay()

Creates a `DateTime` representation of th field value and returns it with the day set to the current one.

```php
$page->date()->toCurrentDay();
```

### toAge($on, $format)

Calculates the difference difference between the field value and the given `on` date. Return the difference in the given format, defaults to years. See [format options](https://www.php.net/manual/de/dateinterval.format.php). Useful to calculate the age of a person.

```php
// Returns 10 given '2020-08-04'
$page->date()->toAge('2021-08-04')
```

## Pages methods

### toDateRange($fieldStart, $fieldEnd)

Returns a human-readable date range for the given dates:

- `$fieldStart`: the start date field name, defaults to 'start'
- `$fieldEnd`: the end date field name, defaults to 'end'

Returns a human-readable date range for the given dates and times:

- `$fieldStart`: an array of the start date and time field names, defaults to ['start', 'starttime']
- `$fieldEnd`: the end date and time field names, defaults to ['end', 'endtime']

The formatting is provided by [Ranger](https://github.com/flack/ranger).

## Helpers

### dateRelative($to, $from)

Returns a human readable time difference to the given dates, e. g. `just now`, `2 years ago`, `in 5 minutes`. The given dates can be `DateTime` objects or any PHP-readable date strings, see [supported formats](https://www.php.net/manual/en/datetime.formats.php).

```php
dateRelative('2019-12-31', 'now');
```

### dateFormatted($locale, $datetype, $timetype, $timezone, $calendar, $pattern)

Returns a localized, formatted date using `IntlDateFormatter`, see [options](https://www.php.net/manual/de/intldateformatter.create.php).

```php
dateFormatted('de_DE', '2020-01-01');
```

### dateRange($to, $from)

Returns a human readable time difference to the given dates, e. g. `just now`, `2 years ago`, `in 5 minutes`. The given dates can be `DateTime` objects or any PHP-readable date strings, see [supported formats](https://www.php.net/manual/en/datetime.formats.php).

```php
dateRange('2020-01-01', '2020-07-01');
```

### datetime(\$datetime)

Returns a `DateTime` object from the given date and time string. Directly returns the input if it's a `DateTime` object already.

## License

MIT

## Credits

[hana+nils · Büro für Gestaltung](https://hananils.de)

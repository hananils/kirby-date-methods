[![Date Methods for Kirby CMS](header.png)](https://kirby.hananils.de/plugins/date-methods)

Parsing and formatting dates can be difficult, especially if you deal with multilingual content. Date Methods aims to simplify date output by providing page and field methods to handle points in time as well as date ranges accurately in your snippets and templates.

## Features

Date Methods are available as page and field methods depending on their context. Where possible, helper functions are also provided.

> [!TIP]
> Check out the reference and learn more about field, page and helper methods.

### Parse dates

Parser methods read the field value and convert it to PHP date and time objects like `DateTime`, `DateTimeImmutable` or `DateInterval`.

- [ `$field->toDateTime()`](https://kirby.hananils.test/plugins/date-methods/3.2.0/field-methods#to-date-time)
- [ `$field->toDateTimeImmutable()`](https://kirby.hananils.test/plugins/date-methods/3.2.0/field-methods#to-date-time-immutable)
- [ `$field->toDateInterval()`](https://kirby.hananils.test/plugins/date-methods/3.2.0/field-methods#to-date-interval)
- [ `$field->toDateDiff()` ](https://kirby.hananils.test/plugins/date-methods/3.2.0/field-methods#to-date-diff)

- [ `$page->toDatePeriod()`](https://kirby.hananils.test/plugins/date-methods/3.2.0/page-methods#to-date-period)
- [ `$page->toDates()` ](https://kirby.hananils.test/plugins/date-methods/3.2.0/page-methods#to-dates)

### Modify dates

Modifier methods allow to round times or adjust dates to the current day, month or year:

- [ `$field->toCurrentYear()`](https://kirby.hananils.test/plugins/date-methods/3.2.0/field-methods#to-current-year)
- [ `$field->toCurrentMonth()`](https://kirby.hananils.test/plugins/date-methods/3.2.0/field-methods#to-current-month)
- [ `$field->toCurrentDay()` ](https://kirby.hananils.test/plugins/date-methods/3.2.0/field-methods#to-current-day)

Additionally, Date Methods provides the following helpers to modify date and times:

- [ `dateRounded()`](https://kirby.hananils.test/plugins/date-methods/3.2.0/helpers#date-rounded)
- [ `normalizeDate()`](https://kirby.hananils.test/plugins/date-methods/3.2.0/helpers#normalize-date)
- [ `normalizeTime()` ](https://kirby.hananils.test/plugins/date-methods/3.2.0/helpers#normalize-time)

### Format dates

Formatter field and page methods take a field value and convert it to a formatted and localized string, either absolute or relative.

- [ `$field->toFormatted()`](https://kirby.hananils.test/plugins/date-methods/3.2.0/field-methods#to-formatted)
- [ `$field->toFormattedPattern()`](https://kirby.hananils.test/plugins/date-methods/3.2.0/field-methods#to-formatted-pattern)
- [ `$field->toRelative()`](https://kirby.hananils.test/plugins/date-methods/3.2.0/field-methods#to-relative)
- [ `$field->toTime()`](https://kirby.hananils.test/plugins/date-methods/3.2.0/field-methods#to-time)
- [ `$field->toAge()` ](https://kirby.hananils.test/plugins/date-methods/3.2.0/field-methods#to-age)

- [ `$page->toDateRange()` ](https://kirby.hananils.test/plugins/date-methods/3.2.0/page-methods#to-date-range)

In addition to the field methods, the following helpers are available:

- [ `dateFormatted()`](https://kirby.hananils.test/plugins/date-methods/3.2.0/helpers#date-formatted)
- [ `dateRelative()`](https://kirby.hananils.test/plugins/date-methods/3.2.0/helpers#date-relative)
- [ `dateRange()` ](https://kirby.hananils.test/plugins/date-methods/3.2.0/helpers#date-range)

### Validate dates

The plugin offers two methods to validate if a date is ealier or later than a reference date:

- [ `$field->isEarlierThan()`](https://kirby.hananils.test/plugins/date-methods/3.2.0/field-methods#is-earlier-than)
- [ `$field->isLaterThan()` ](https://kirby.hananils.test/plugins/date-methods/3.2.0/field-methods#is-later-than)

Both method accept an optional flag to check for equality as well.

## Installation

By default, plugins in Kirby reside in a special folder located at `/site/plugins`. Each plugin is installed in its proprietary subfolder. This installation can be handled in four different ways: you can either install them manually or manage them using Kirby CLI, Git submodules or Composer. You can install Date Methods either way and should choose the method suiting your project best.

Please note that all examples given here assume you are using the default plugin root. [If you changed your plugin root](https://getkirby.com/docs/reference/system/roots/plugins), e. g. with a custom folder setup, you’ll also have to adjust the paths given in this guide. For further information on how to manage plugins, please read the [official Kirby plugin introduction](https://getkirby.com/docs/guide/plugins/plugin-basics).

### Download

Download and copy this repository to `/site/plugins/date-methods`.

### Kirby CLI

```shell
kirby plugin:install hananils/kirby-date-methods
```

### Git submodule

```bash
git submodule add \
    https://github.com/hananils/kirby-date-methods.git \
    site/plugins/date-methods
```

### Composer

```shell
composer require hananils/kirby-date-methods
```

## Documentation

[![Find all documentation at kirby.hananils.de](footer.png)](https://kirby.hananils.de/plugins/date-methods)

Where possible, files contain inline annotations. For extended documentation, please visit our dedicated plugin site at [kirby.hananils.de/​plugins/​date-methods](https://kirby.hananils.de/plugins/date-methods).

### Reference

- [Page Methods](https://kirby.hananils.de/plugins/date-methods/page-methods)
- [Field Methods](https://kirby.hananils.de/plugins/date-methods/field-methods)
- [Helpers](https://kirby.hananils.de/plugins/date-methods/helpers)

## License

This plugin is provided freely under the [MIT license](https://kirby.hananils.de/plugins/date-methods/license) by [hana+nils · Büro für Gestaltung](https://kirby.hananils.de). We create visual designs for digital and analog media.
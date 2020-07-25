## k3-date-extended
[![GitHub tag (latest by date)](https://img.shields.io/github/v/tag/Adspectus/k3-date-extended?style=flat-square&label=Version)](https://github.com/Adspectus/k3-date-extended/releases)
[![GitHub issues](https://img.shields.io/github/issues/Adspectus/k3-date-extended?style=flat-square&label=Issues)](https://github.com/Adspectus/k3-date-extended/issues)
[![GitHub license](https://img.shields.io/github/license/Adspectus/k3-date-extended?style=flat-square&label=License)](https://github.com/Adspectus/k3-date-extended/blob/master/LICENSE)
[![Kirby version](https://img.shields.io/static/v1?label=Kirby&message=3&color=yellow&style=flat-square)](https://getkirby.com/)


Kirby 3 plugin to provide additional date fields as epoch.

The rationale to use the epoch, which is the number of seconds starting from Jan. 1, 1970 0:00 GMT as a date/time field, is to have an universally valid piece of information about the date and time from which one can derive all other kind of information, i.e. the same point in time in different timezones. Moreover, it is easier to calculate or compare different dates or points in time using the epoch. The drawback is that it is not very human-friendly to read and write. However, there shouldn't be any serious programming or scripting language which does not contain built-in functions to convert back and forth between the epoch and a human-friendly date and time.

The epoch as it is written by the `time()` function used here, always refers to GMT, which can be used as being the same time as UTC, even though GMT and UTC are not the same. Thus, the value of the epoch is independent from the timezone setting in your `php.ini` file, but the formatted date as returned by the `date()` function will take that into account.

## Getting Started

### Prerequisites

* Kirby 3

### Installation

You can install this plugin via one of the following methods:

1. Composer

       composer require adspectus/date-extended

2. Manual

   Clone this repository or download the current release and extract the file `index.php` into a new folder `site/plugins/date-extended` of your Kirby installation.

## Usage

This plugin uses the `page.create:after` hook to store 2 additional fields into the page, the creation and modification date/time as a Unix Epoch. With the `page.update:after` and the `page.changeTitle:after` hooks only the modification date is updated.

In addition to that, the plugin provides a field method `epoch2date` to return this epoch in a formatted string. The default format of this string is set to `D, j M Y H:i:s T`, but this can be changed on a global level in site-config with

    'adspectus.date-extended.dateFormat' => string or constant

or as a parameter to the field method.

The fieldnames can be set with

    'adspectus.date-extended.dateCreated' => 'myCreationDate',
    'adspectus.date-extended.dateModified' => 'myModificationDate',

Otherwise they default to `dateCreatedEpoch` and `dateModifiedEpoch` resp.

## Examples

After installation of this plugin, when you create and afterwards change (text or title) a page, you will have these fields in your content file:

```
----

Datecreatedepoch: 1592831460

----

Datemodifiedepoch: 1592831953

----
```

Then, you can use this in your blueprint:

```
    fields:
      date_created_info:
        type: info
        label:
          en: Creation Date
          de: Erstellungsdatum
        theme: none
        text: "{{ page.dateCreatedEpoch.epoch2date }}"
      date_modified_info:
        type: info
        label:
          en: Last Modification
          de: Letzte Aktualisierung
        theme: none
        text: "{{ page.dateModifiedEpoch.epoch2date('c') }}"
```

and in the panel it will look like this:

![Screenshot Panel](panel01.png)

## License

[GNU General Public License v3.0](LICENSE)

## Acknowledgements

* [texnixe](https://forum.getkirby.com/u/texnixe/) for the basic stuff
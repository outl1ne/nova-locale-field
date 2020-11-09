# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [2.0.12] - 2020-11-09

### Changed

- Show LocaleButton on Create form, but disable it

## [2.0.11] - 2020-11-09

### Changed

- Added ability to change between locales using the locale button
- Updated packages

## [2.0.10] - 2020-04-24

### Changed

- Changed inline styling to tailwind classes to allow easier overriding
- Updated packages

## [2.0.9] - 2020-04-24

### Changed

- Fixed usage of reserved "class" prop
- Updated packages

## [2.0.8] - 2020-04-24

### Changed

- Fix locales not resolving on all field queries

## [2.0.7] - 2020-04-14

### Changed

- Fix Nova 3.3.1 support

## [2.0.6] - 2020-04-09

### Added

- Added `->defaultValue()` option to `LocaleFilter` to set the default value on a per-filter basis

## [2.0.5] - 2020-03-27

### Changed

- Improve models query
- Update packages (fix all vulnerabilities)

## [2.0.4] - 2020-03-19

### Changed

- Undo breaking change whilst still keeping support for Nova 3.1

## [2.0.3] - 2020-03-18

### Changed

- Fix incompatibility with Nova 3.1

## [2.0.2] - 2020-03-05

### Added

- Support Nova 3.0 in `composer.json` requirements

## [2.0.1] - 2020-02-27

### Changed

- Rework the way LocaleButton is positioned for better compatibility with `nova-page-manager` and `nova-drafts`
- Updated packages

## [2.0.0] - 2019-12-16

### Changed

- `LocaleField::getLocales()` is now in the config file as `nova-locale-field.locales`

### Removed

- `LocaleChildrenFilter` is now deprecated and replaced with just `LocaleFilter` which uses the first locale as the default value

## [1.1.4] - 2019-11-11

### Changed

- Updated all packages
- Removed `style` that broke modals

## [1.1.3] - 2019-11-05

### Changed

- Fixed `locale_parent_id` being given a wrong value when entering creation view from a locale child (thanks to [@KasparRosin](https://github.com/KasparRosin))

## [1.1.2] - 2019-10-21

### Changed

- The field field now displays validation errors (thanks to [@KasparRosin](https://github.com/KasparRosin))

## [1.1.1] - 2019-06-12

### Changed

- Fix crash due to type safety inconsistency in `loadLocales()`

## [1.1.0] - 2019-06-11

### Added

- Added locale filter (`LocaleFilter`)
- Added localisation children filter (`LocaleChildrenFilter`)

## [1.0.2] - 2019-05-31

### Changed

- Fixed not being able to set default locales

## [1.0.1] - 2019-05-30

### Changed

- Fixed child models displaying incorrect localisation options
- Componentised LocaleButton for future developments

## [1.0.0] - 2019-05-30

### Added

- Basic locale management functionality
- Locale field in Index, Form and Detail views
- Configuration file support
- Default locales support
- Value override support (locales, max locales on index)

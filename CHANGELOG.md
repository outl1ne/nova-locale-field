# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

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

[2.0.0]: https://github.com/optimistdigital/nova-locale-field/compare/1.1.4...2.0.0
[1.1.4]: https://github.com/optimistdigital/nova-locale-field/compare/1.1.3...1.1.4
[1.1.3]: https://github.com/optimistdigital/nova-locale-field/compare/1.1.2...1.1.3
[1.1.2]: https://github.com/optimistdigital/nova-locale-field/compare/1.1.1...1.1.2
[1.1.1]: https://github.com/optimistdigital/nova-locale-field/compare/1.1.0...1.1.1
[1.1.0]: https://github.com/optimistdigital/nova-locale-field/compare/1.0.2...1.1.0
[1.0.2]: https://github.com/optimistdigital/nova-locale-field/compare/1.0.1...1.0.2
[1.0.1]: https://github.com/optimistdigital/nova-locale-field/compare/1.0.0...1.0.1
[1.0.0]: https://github.com/optimistdigital/nova-locale-field/releases/tag/1.0.0

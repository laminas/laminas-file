# Changelog

All notable changes to this project will be documented in this file, in reverse chronological order by release.

## 2.8.3 - 2019-02-06

### Added

- Nothing.

### Changed

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [zendframework/zend-file#46](https://github.com/zendframework/zend-file/pull/46) fixes a unit test assertion for `Laminas\File\Transfer\Adapter\Http`.

## 2.8.2 - 2018-10-15

### Added

- Nothing.

### Changed

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [zendframework/zend-file#45](https://github.com/zendframework/zend-file/pull/45) fixes compatibility
  issue with php 7.3 with deprecated continue keyword usage in switch statements

## 2.8.1 - 2018-05-01

### Added

- Nothing.

### Changed

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [zendframework/zend-file#44](https://github.com/zendframework/zend-file/pull/44) fixes an issue where
  ClassFileLocator would skip the file (otherwise valid class file) containing a
  `use function` declaration.

## 2.8.0 - 2018-04-25

### Added

- [zendframework/zend-file#43](https://github.com/zendframework/zend-file/pull/43) adds support for PHP 7.1 and 7.2.

### Changed

- Nothing.

### Deprecated

- Nothing.

### Removed

- [zendframework/zend-file#43](https://github.com/zendframework/zend-file/pull/43) removes support for PHP 5.5.

- [zendframework/zend-file#43](https://github.com/zendframework/zend-file/pull/43) removes support for HHVM.

### Fixed

- [zendframework/zend-file#41](https://github.com/zendframework/zend-file/pull/41) fixes an issue in PHP 7.1 and up with false-positive detection of classes,
  interfaces, and traits when class methods are named after these keywords.

## 2.7.1 - 2017-01-11

### Added

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [zendframework/zend-file#34](https://github.com/zendframework/zend-file/pull/34) ensures that
  anonymous classes are ignored by the `ClassFileLocator` when identifying files
  with class declarations.

## 2.7.0 - 2016-04-28

### Added

- [zendframework/zend-file#25](https://github.com/zendframework/zend-file/pull/25) adds and publishes
  documentation to https://docs.laminas.dev/laminas-file/

### Deprecated

- [zendframework/zend-file#25](https://github.com/zendframework/zend-file/pull/25) deprecates the
  `Laminas\File\Transfer` subcomponent. Its functionality is now split between each
  of:
  - laminas-filter, for moving uploaded files to their final location, renaming
    them, and potentially transforming them.
  - laminas-validator, for validating upload succes, file type, hash, etc.
  - laminas-progressbar, for managing upload status.

### Removed

- Nothing.

### Fixed

- Nothing.

## 2.6.1 - 2016-03-02

### Added

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [zendframework/zend-file#21](https://github.com/zendframework/zend-file/pull/21) updates the codebase
  to re-enable tests against laminas-progressbar, and fixes static calls inside
  `Laminas\File\Transfer\Adapter\Http::getProgress` for testing APC and/or
  uploadprogress availability to ensure they work correctly.

## 2.6.0 - 2016-02-17

### Added

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [zendframework/zend-file#18](https://github.com/zendframework/zend-file/pull/18) updates the codebase
  to be forwards compatible with laminas-servicemanager and laminas-stdlib v3.

## 2.5.2 - 2016-02-16

### Added

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [zendframework/zend-file#13](https://github.com/zendframework/zend-file/pull/13) fixes the behavior
  of the `Laminas\File\Transfer` component when multiple uploads using the same
  client name are provided, and no filename filtering is performed; the code now
  ensures that unique names are used in such situations.
- [zendframework/zend-file#14](https://github.com/zendframework/zend-file/pull/14) updates the
  `FilterPluginManager` to work with the updated laminas-filter 2.6.0 changes,
  fixing an issue where the laminas-file filters were replacing (instead of
  merging) with those in the parent laminas-filter implementation.

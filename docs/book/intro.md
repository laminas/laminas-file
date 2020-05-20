# Introduction

laminas-file provides two specific pieces of functionality:

- a `ClassFileLocator`, which can be used to find PHP class files under a given
  tree.
- a `Transfer` subcomponent, for managing file uploads and reporting upload
  progress.

**The `Transfer` subcomponent is deprecated**, and we recommend using the
file-related functionality in:

- [laminas-filter](https://docs.laminas.dev/laminas-filter/), which provides
  functionality around moving uploaded files to their final locations, renaming
  uploaded files, and encrypting and decrypting uploaded files.
- [laminas-validator](https://github.com/laminas/laminas-validator/), which
  provides functionality around validating uploaded files based on: number of
  files uploaded, MIME types and/or extensions, upload status, compression,
  hashing, and more.
- [laminas-progressbar](https://github.com/laminas/laminas-progressbar/), which
  provides functionality for providing file upload status.

If you are determined to use the `Transfer` subcomponent, despite its
deprecation, please see the [Laminas 1 documentation on the component](https://getlaminas.org/manual/1.12/en/laminas.file.transfer.introduction.html);
you can substitute `Underscore_Separated_Names` for their namespaced equivalents
to adapt the examples to this component.

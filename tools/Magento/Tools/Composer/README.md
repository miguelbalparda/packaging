Composer Tools
==============

A set of tools that allows creating or maintaining `composer.json` files.

Root composer.json Creator
---

Creates contents of a root `composer.json` file that aggregates all Magento components as Composer packages.

```shell
> php -f create-root.php -- [--skeleton] [--wildcard] [--source-dir=<path>] [--target-file=<path>] [--set=<option:value>]
--skeleton - whether to render the result as a project skeleton.
--wildcard - in the skeleton, whether to set 'require' versions to wildcard
--source-dir=/path/to/magento/dir - path to a Magento root directory. By default will use current working copy
  this directory must contain a root composer.json which is going to be used as template.
--target-file=/path/to/composer.json - render output to the specified file. If not specified, render into STDOUT.
--set='path->to->node:value' - set a value to the specified node. Use colon to separate node path and value.
  Overrides anything that was before in the template or in default values.
  May be used multiple times to specify multiple values. For example:
  --set='name:vendor/package' --set='extra->branch-alias->dev-master:2.0-dev'
```

Archiver
---

Breaks down a working copy into packages (zip-archives) with Magento components. Each component must already contain a `composer.json` file in its root directory.

```shell
> php -f archiver.php
Usage: archiver.php [ options ]
--output|-o <string> Generation dir. Default value _packages
--dir|-d    <string> Working directory of build. Default current code base.

```

A package for Magento edition will also be created, if there is a `composer.json` file in the root directory of Magento code base. This package will contain everything except stuff that was packaged into other packages.


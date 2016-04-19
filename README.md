How to use:
------------
1. Clone https://github.com/magento/magento2 to directory ./magento
2. Prepare composer.json for base package: 
    `php ./tools/Magento/Tools/Composer/create-root.php --edition=ce --type=base --source-dir=./magento --target-file=./magento/composer.json --wildcard --package-repo-url=https://repo.magento.com`
3. Generate composer.json for product package (create directory ./tmp/product): 
    `php ./tools/Magento/Tools/Composer/create-root.php --edition=ce --type=product --source-dir=./magento --target-file=./tmp/product/composer.json --wildcard --package-repo-url=https://repo.magento.com`
4. Generate product package:
    `php ./tools/Magento/Tools/Composer/archiver.php --dir=./tmp/product --output=./packages`
5. Generate composer.json for product package (create directory ./tmp/project): 
    `php ./tools/Magento/Tools/Composer/create-root.php --edition=ce --type=project --source-dir=./magento --target-file=./tmp/project/composer.json --wildcard --package-repo-url=https://repo.magento.com`
6. Checkout and install updater application (if needed) to ./tmp/project/update from https://github.com/magento/magento2-updater or download it from repo.magento.com package magento/updater
7. Generate project package:
    `php ./tools/Magento/Tools/Composer/archiver.php --dir=./tmp/project --output=./packages`
8. Generate packages: 
   `php ./tools/Magento/Tools/Composer/archiver.php --dir=./magento --output=./packages`
All packages will be generated to directory `./packages`

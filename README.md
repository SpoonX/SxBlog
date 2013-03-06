# SxBlog

This is a very simple blog module. It should suffice for those with simple wishes.

Installation
-------------
1. add the requirement to your composer.json file by either...

    ... Adding it through the command line,

    ```
    ./composer.phar require spoonx/sxblog
    When asked for a version, type: "dev-master"
    ```

    or, adding it manually to your composer.json file and then running ./composer.phar install to install the dependencies

    {
        "require": {
            "spoonx/sxblog": "dev-master"
        }
    }

2. Copy the database config

    `cp vendor/spoonx/sxblog/config/database.local.php.dist config/autoload/database.local.php`

    Next up, open the file and change the params to fit your needs.

3. Update the database

    `./vendor/bin/doctrine-module orm:schema-tool:update --force`

Todo
--------
* Write actual readme

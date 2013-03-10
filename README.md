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

    ```
    {
        "require": {
            "spoonx/sxblog": "dev-master"
        }
    }
    ```

2. Enable the newly added modules in `config/application.config.php`

    ```php
    <?php
    return array(
        'modules' => array(

            /* ... */
            'ZfcUser',
            'ZfcUserDoctrineORM',
            'DoctrineModule',
            'DoctrineORMModule',
            'SxBlog',
            /* ... */

        ),
    );
    ```

3. Copy the config files to your autoload dir

    `cp vendor/spoonx/sxblog/config/database.local.php.dist config/autoload/database.local.php`
    `cp vendor/spoonx/sxblog/config/sxblog.global.php.dist config/autoload/sxblog.global.php`

    Next up, open the files and change the params to fit your needs.

4. Update the database

    `./vendor/bin/doctrine-module orm:schema-tool:update --force`

Todo
--------
* Write actual readme

# SxBlog

This is a very simple blog module. It should suffice for those with simple wishes.

Installation
-------------
1. Installing this applications is pretty simple. Checkout the project, and install it.

    git clone git@github.com:Ratus/CrazyWebcam.git crazywebcam.com; cd $_; composer install

2. Copy the database config

    `cp vendor/spoonx/sxblog/config/database.local.php.dist config/autoload/database.local.php`

    Next up, open the file and change the params to fit your needs.
    
3. Update the database

    `./vendor/bin/doctrine-module orm:schema-tool:update --force`

Todo
--------
* Write actual readme

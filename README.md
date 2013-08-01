TBL CMS
=========

TBL Cms based on Yii Framework

Read the /documentation/index.html for more information

Setup:
------
Get Yii Framework using Composer:
Inside protected directory run: php composer.phar install

Get database from: /protected/data/

Note: Make sure following directories are writable to 0777:
/files
/cache
/protected/runtime

For local environment change database config in:
/protected/config/dev.php

For live environment change database config in:
/protected/config/web.php

Login to Admin Panel by visiting: www.yoursite.com/admin/login and
logins are: admin / admin

Know Issues / ToDo
------------------
- solution for sysphus for multi editors
- fix htaccess with some servers
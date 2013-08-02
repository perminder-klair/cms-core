TBL CMS
=========

TBL Cms based on Yii Framework

Read the /documentation/index.html for more information

Setup:
------
Get Yii Framework using Composer:

Inside protected directory run: php composer.phar install

(For beta in Fortabitt use: git commit --allow-empty -m 'Just run composer [trigger:composer]')

Get database from: /protected/data/

Note: Make sure following directories are writable to 0777:
/files
/cache
/protected/runtime

For local environment change database config in:
/protected/config/dev.php

For beta environment change database config in:
/protected/config/beta.php

For live environment change database config in:
/protected/config/web.php

Login to Admin Panel by visiting: www.yoursite.com/admin/login and
logins are: admin / admin

Know Issues / ToDo
------------------
- Change PHP short tags to full
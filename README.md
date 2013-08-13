# TBL CMS

TBL Cms based on Yii Framework

Read the /documentation/index.html for more information

## Setup
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

## Extenstions included in CMS
* [YiiBooster](https://github.com/clevertech/YiiBooster)
* [EAjaxUpload](https://github.com/valums/file-uploader)
* [yii-easyimage](https://github.com/zhdanovartur/yii-easyimage)
* [efeed](https://github.com/2amigos/efeed)
* [Mobile_Detect](https://github.com/serbanghita/Mobile-Detect/)
* [yii-tinymce](https://bitbucket.org/z_bodya/yii-tinymce)
* [XReadMore](http://www.yiiframework.com/extension/xreadmore/)
* [Yii Debug Toolbar](https://github.com/malyshev/yii-debug-toolbar)
* [YiiMailer](https://github.com/vernes/YiiMailer)
* [backup](http://www.yiiframework.com/extension/backup/)

## Bug tracker
If you find any bugs, please create an issue at [issue tracker for project Github repository](https://github.com/TBL-CMS/Core/issues).

## Know Issues / ToDo
* media upload from media tab

## License
This work is licensed under a MIT license. Full text is included in the `LICENSE` file in the root of codebase.
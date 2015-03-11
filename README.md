yii2-flex
===========

FlexWiget - a Yii 2.0 Widget for Flex application

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

    composer.phar require fproject/yii2-flex:"*"

Usage
-----

See the following sample code of view file:

 ```
     FlexWidget::begin([
         'name'=>'MyFlexApp', //Name of your Flex application file without SWF extension
         'baseUrl'=>'/flexapps/myflexapp', //Relative path to your flex app dir
         'rslBaseUrl'=>'/flexapps/rsls', //Relative path to your flex RSLs dir
         'moduleBaseUrl'=>'/flexapps/myflexapp/modules', //Relative path to your module dir
         'width'=>'100%',
         'height'=>'100%',
         'align'=>'left',
         'enableHistory'=>'false',
         'allowFullScreen'=>'true',
         'allowFullScreenInteractive'=>'true',
         'flashVars'=>[ //The variables you want to pass to Flex application
             'loginUserId'=>'my_user_id_xxx', //The logged in User ID
             'userToken'=>'the_login_token', //The auth token that will be used for Flex's RPC authentication
         ],
     ]);
     FlexWidget::end();
 ```
Links
-----

- [GitHub](https://github.com/fproject/yii2-flex)
- [Packagist](https://packagist.org/packages/fproject/yii2-flex)

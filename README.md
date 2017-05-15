yii2-flex
===========

FlexWiget - a Yii 2.0 Widget for Flex application

[![Latest Stable Version](https://poser.pugx.org/fproject/yii2-flex/v/stable)](https://packagist.org/packages/fproject/yii2-flex)
[![Total Downloads](https://poser.pugx.org/fproject/yii2-flex/downloads)](https://packagist.org/packages/fproject/yii2-flex)
[![Latest Unstable Version](https://poser.pugx.org/fproject/yii2-flex/v/unstable)](https://packagist.org/packages/fproject/yii2-flex)
[![Build](https://travis-ci.org/fproject/yii2-flex.svg?branch=master)](https://travis-ci.org/fproject/yii2-flex)
[![License](https://poser.pugx.org/fproject/yii2-flex/license)](https://packagist.org/packages/fproject/yii2-flex)

##Requirements

Yii 2.0 or above

##Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

    composer.phar require fproject/yii2-flex:"*"

##Usage

See the following sample code of view file:


     FlexWidget::begin([
         'name'=>'MyFlexApp', //Name of your Flex application file without SWF extension
         'baseUrl'=>'/flexapps/myflexapp', //Relative path to your flex app dir
         'rslBaseUrl'=>'/flexapps/rsls', //Relative path to your flex RSLs dir
         'moduleBaseUrl'=>'/flexapps/myflexapp/modules', //Relative path to your module dir
         'logoUrl' => 'url_to_your_logo',
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


Links
-----

- [GitHub](https://github.com/fproject/yii2-flex)
- [Packagist](https://packagist.org/packages/fproject/yii2-flex)

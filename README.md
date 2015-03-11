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
 
     $this->registerJs("
     $('#w0').remove();
     $('.wrap').css('width','100%').css('height','100%').css('top','0px').css('bottom','0px').css('left','0px').css('right','0px').css('padding-top','0px').css('padding-right','0px').css('padding-left','0px').css('padding-bottom','0px');
     $('#MyFlexApp').closest('div').css('width','100%').css('height','100%').css('top','0px').css('bottom','0px').css('left','0px').css('right','0px').css('padding-top','0px').css('padding-right','0px').css('padding-left','0px').css('padding-bottom','0px');
     ",\yii\web\View::POS_READY, 'flex.app');
 
     $baseUrl = Yii::getAlias("@web");
     $userToken = 'usertoken_00_000';
     $loginUserId = '1001';
     FlexWidget::begin([
         'name'=>'MyFlexApp',
         'baseUrl'=>$baseUrl.Yii::$app->params['flexAppBasePath'],
         'rslBaseUrl'=>$baseUrl.Yii::$app->params['flexRSLBasePath'],
         'moduleBaseUrl'=>$baseUrl.Yii::$app->params['flexModuleBasePath'],
         'width'=>'100%',
         'height'=>'100%',
         'align'=>'left',
         'enableHistory'=>'false',
         'allowFullScreen'=>'true',
         'allowFullScreenInteractive'=>'true',
         'flashVars'=>[
             'loginUserId'=>$loginUserId,
             'userToken'=>str_replace('"', '\\"', $userToken),
         ],
     ]);
     FlexWidget::end();
 ```
Links
-----

- [GitHub](https://github.com/fproject/yii2-flex)
- [Packagist](https://packagist.org/packages/fproject/yii2-flex)

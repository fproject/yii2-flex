<?php
///////////////////////////////////////////////////////////////////////////////
//
// Licensed Source Code - Property of f-project.net
//
// © Copyright f-project.net 2015. All Rights Reserved.
//
///////////////////////////////////////////////////////////////////////////////

namespace fproject\widgets;
use yii\base\Exception;
use yii\base\Widget;
use Yii;
use yii\web\View;

/**
 * FlexWidget embeds a Flex 4.x application into a page.
 *
 * To use FlexWidget, set {@link name} to be the Flex application name
 * (without the .swf suffix), and set {@link baseUrl} to be URL (without the ending slash)
 * of the directory containing the SWF file of the Flex application.
 *
 * @property string $flashVarsAsString The flash parameter string.
 *
 * @author Bui Sy Nguyen <nguyenbs@f-project.net>
 * @package fproject\widgets
 */
class FlexWidget extends Widget{
    /**
     * @var string name of the Flex application.
     * This should be the SWF file name without the ".swf" suffix.
     */
    public $name;
    /**
     * @var string the base URL of the Flex application.
     * This refers to the URL of the directory containing the SWF file.
     */
    public $baseUrl;

    /**
     * @var string the base URL of the Flex modules.
     * This refers to the URL of the directory containing the module SWF file.
     */
    public $moduleBaseUrl;

    /**
     * @var string the base URL of the Flex RSLs.
     * This refers to the URL of the directory containing the module SWF file.
     */
    public $rslBaseUrl;

    /**
     * @var string width of the application region. Defaults to 450.
     */
    public $width='100%';
    /**
     * @var string height of the application region. Defaults to 300.
     */
    public $height='100%';
    /**
     * @var string quality of the animation. Defaults to 'high'.
     */
    public $quality='high';
    /**
     * @var string background color of the application region. Defaults to '#FFFFFF', meaning white.
     */
    public $bgColor='#FFFFFF';
    /**
     * @var string align of the application region. Defaults to 'middle'.
     */
    public $align='middle';
    /**
     * @var string the access method of the script. Defaults to 'sameDomain'.
     */
    public $allowScriptAccess='sameDomain';
    /**
     * @var boolean whether to allow running the Flash in full screen mode. Defaults to false.
     */
    public $allowFullScreen=false;
    /**
     * @var boolean whether to allow running the Flash in full screen mode. Defaults to false.
     */
    public $allowFullScreenInteractive=false;
    /**
     * @var string the HTML content to be displayed if Flash player is not installed.
     */
    public $altHtmlContent;
    /**
     * @var boolean whether history should be enabled. Defaults to true.
     */
    public $enableHistory=true;
    /**
     * @var boolean whether history should be enabled. Defaults to true.
     */
    public $flashVersion='11.3.0';
    /**
     * @var array parameters to be passed to the Flex application.
     */
    public $flashVars=array();

    /**
     * Renders the widget.
     */
    public function run()
    {
        if(empty($this->name))
            throw new Exception(Yii::t('yii','FlexWidget.name cannot be empty.'));
        if(empty($this->baseUrl))
            throw new Exception(Yii::t('yii','FlexWidget.baseUrl cannot be empty.'));
        if($this->altHtmlContent===null)
            $this->altHtmlContent=Yii::t('yii','This content requires the <a href="http://www.adobe.com/go/getflash/">Adobe Flash Player</a>.');

        $this->registerClientScript();

        return $this->render('flexWidget', [
            'name' => $this->name,
            'flashVersion' => $this->flashVersion,
            'baseUrl' => $this->baseUrl,
            'flashVarsAsString' => $this->flashVarsAsString,
            'quality' => $this->quality,
            'bgColor' => $this->bgColor,
            'allowScriptAccess' => $this->allowScriptAccess,
            'allowFullScreen' => $this->allowFullScreen,
            'allowFullScreenInteractive' => $this->allowFullScreenInteractive,
            'width' => $this->width,
            'height' => $this->height,
            'align' => $this->align,
        ]);
    }

    /**
     * Registers the needed CSS and JavaScript.
     */
    public function registerClientScript()
    {
        $view = $this->getView();
        $view->registerJsFile($this->baseUrl.'/swfobject.js',['position'=>View::POS_BEGIN]);
        if($this->enableHistory)
        {
            $view->registerCssFile($this->baseUrl.'/history/history.css');
            $view->registerJsFile($this->baseUrl.'/history/history.js');
        }
    }

    /**
     * Generates the properly quoted flash parameter string.
     * @return string the flash parameter string.
     */
    public function getFlashVarsAsString()
    {
        $params=array();
        foreach($this->flashVars as $k=>$v)
            $params[] = $k.':"'.urlencode($v).'"';
        if(!array_key_exists('baseUrl', $params))
            $params[] = 'baseUrl:"'.urlencode($this->baseUrl).'"';
        if(!array_key_exists('moduleBaseUrl', $params))
            $params[] = 'moduleBaseUrl:"'.urlencode($this->moduleBaseUrl).'"';
        if(!array_key_exists('rslBaseUrl', $params))
            $params[] = 'rslBaseUrl:"'.urlencode($this->rslBaseUrl).'"';
        if(!array_key_exists('locale', $params))
            $params[] = 'locale:"'.urlencode(Yii::$app->language).'"';
        return implode(',',$params);
    }
}
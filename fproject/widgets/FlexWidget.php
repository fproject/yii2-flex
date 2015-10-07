<?php
///////////////////////////////////////////////////////////////////////////////
//
// © Copyright f-project.net 2015. All Rights Reserved.
//
// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at
//
//     http://www.apache.org/licenses/LICENSE-2.0
//
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.
//
///////////////////////////////////////////////////////////////////////////////

namespace fproject\widgets;
use yii\base\Exception;
use yii\base\Widget;
use Yii;
use yii\helpers\ArrayHelper;
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
class FlexWidget extends Widget
{
    const LANGUAGUE_SEPARATOR = "_";

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
     * @var bool allow WebSocket bridge access. Defaults to 'false'
     */
    public $allowWsBridge=false;

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
            'allowScriptAccess' => $this->b2s($this->allowScriptAccess),
            'allowFullScreen' => $this->b2s($this->allowFullScreen),
            'allowFullScreenInteractive' => $this->b2s($this->allowFullScreenInteractive),
            'width' => $this->width,
            'height' => $this->height,
            'align' => $this->align,
        ]);
    }

    /**
     * Convert boolean to string
     * @param bool $b
     * @return string
     */
    private function b2s($b)
    {
        return $b ? 'true' : 'false';
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
        if($this->allowWsBridge)
        {
            $view->registerJsFile($this->baseUrl.'/ws_bridge.js',['position'=>View::POS_END]);
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
        {
            if(!is_string($v))
                $v = json_encode($v);
            $params[] = $k.':"'.urlencode($v).'"';
        }

        if(!array_key_exists('baseUrl', $this->flashVars))
            $params[] = 'baseUrl:"'.urlencode($this->baseUrl).'"';

        if(!array_key_exists('moduleBaseUrl', $this->flashVars))
            $params[] = 'moduleBaseUrl:"'.urlencode($this->moduleBaseUrl).'"';

        if(!array_key_exists('rslBaseUrl', $this->flashVars))
            $params[] = 'rslBaseUrl:"'.urlencode($this->rslBaseUrl).'"';

        if(!array_key_exists('locale', $this->flashVars))
            $params[] = 'locale:"'.urlencode($this->getFlexLocale(Yii::$app->language)).'"';

        return implode(',',$params);
    }

    /**
     * Returns locale with format for flex application
     * @param string $language the app language
     * @return string
     */
    private function getFlexLocale($language) {
        if(!empty($language))
        {
            $split = explode("-", $language, 2);

            if(count($split) == 2 && $split[1] != "") {
                $split[1] = strtoupper($split[1]);
            } else {
                $split = null;
            }
        }

        if(empty($split))
            $split = ['en', 'US'];

        return $split[0] . self::LANGUAGUE_SEPARATOR . $split[1];
    }
}
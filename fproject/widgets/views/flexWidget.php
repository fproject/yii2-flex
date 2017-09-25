<?php
///////////////////////////////////////////////////////////////////////////////
//
// © Copyright f-project.net 2010-present. All Rights Reserved.
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

use yii\web\View;

/**
 * The view file for FlexWidget.
 *
 * @var View $this
 * @var string $flashVersion
 * @var string $baseUrl
 * @var string $flashVarsAsString
 * @var string $quality
 * @var string $bgColor
 * @var string $allowScriptAccess
 * @var string $allowFullScreen
 * @var string $allowFullScreenInteractive
 * @var string $width
 * @var string $height
 * @var string $align
 * @var string $logoUrl
 *
 * @author Bui Sy Nguyen <nguyenbs@f-project.net>
 *
 */

$this->registerJs("
    function isMSIE()
    {
        var ua = window.navigator.userAgent;
        var msie = ua.indexOf('MSIE ');

        if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\\:11\\./))
            return true;

        return false;
    };

    window.onbeforeunload = function() {
        var warning='';
        var fxControl = document.$name || window.$name;
        if (typeof fxControl.onAppClosing=='function') {
            warning = fxControl.onAppClosing();
        }
        if (warning!='')
            return warning;
        else
            return;
    };

    if(isMSIE())
        window.onload = function() {
            var fxControl = document.$name || window.$name;
            fxControl.focus();
        };

", View::POS_READY, 'widgets.flexWidget');
?>
<head>
    <meta name="google" content="notranslate"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <!-- Include CSS to eliminate any default margins/padding and set the height of the html element and
         the body element to 100%, because Firefox, or any Gecko based browser, interprets percentage as
         the percentage of the height of its parent container, which has to be set explicitly.  Fix for
         Firefox 3.6 focus border issues.  Initially, don't display flashContent div so it won't show
         if JavaScript disabled.
    -->
    <style type="text/css" media="screen">
        html, body  { height:100%; }
        body { margin:0; padding:0; overflow:auto; text-align:center;
            background-color: #ffffff; }
        object:focus { outline:none; }
        #flashContent { display:none; }
    </style>

    <script type="text/javascript">
        // For version detection, set to min. required Flash Player version, or 0 (or 0.0.0), for no version detection.
        var swfVersionStr = "<?php echo $flashVersion; ?>";
        // To use express install, set to expressInstall.swf, otherwise the empty string.
        var xiSwfUrlStr = "<?php echo $baseUrl ?>/expressInstall.swf";
        var flashvars = {<?php echo $flashVarsAsString; ?>};
        var params = {};
        params.quality = "<?php echo $quality; ?>";
        params.bgcolor = "<?php echo $bgColor; ?>";
        params.allowscriptaccess = "<?php echo $allowScriptAccess ?>";
        params.allowfullscreen = "<?php echo $allowFullScreen ?>";
        params.allowFullScreenInteractive = "<?php echo $allowFullScreenInteractive ?>";
        var attributes = {};
        attributes.id = "<?php echo $name; ?>";
        attributes.name = "<?php echo $name; ?>";
        attributes.align = "<?php echo $align; ?>";
        attributes.margin = "0px";
        swfobject.embedSWF(
            "<?php echo $baseUrl ?>/<?php echo $name ?>.swf", "flashContent",
            "<?php echo $width; ?>", "<?php echo $height; ?>",
            swfVersionStr, xiSwfUrlStr,
            flashvars, params, attributes);
        // JavaScript enabled so display the flashContent div in case it is not replaced with a swf object.
        swfobject.createCSS("#flashContent", "display:block !important;text-align:left;");
    </script>
</head>
<body>
<!-- SWFObject's dynamic embed method replaces this alternative HTML content with Flash content when enough
     JavaScript and Flash plug-in support is available. The div is initially hidden so that it doesn't show
     when JavaScript is disabled.
-->
<div id="flashContent" style="text-align: center; margin-top: 50px; font-size: 15.5px; font-family: Arial, Helvetica, sans-serif;">
    <img class="flash-msg-logo" src="<?= $logoUrl ?>"
         height="70" alt="ProjectKit logo">
    <p class="flash-msg-large">
        <?= Yii::t('fproject/yii2-flex', 'Some features of {name} need Adobe Flash Player installed.', [
            'name' => $name,
        ]) ?>
    </p>
    <p>
        <a class="flash-msg-btn" href="https://get.adobe.com/flashplayer/" target="_blank" style="text-decoration: none; background-color: #337ab7;color: #fff;border: #2e6da4 solid 1px;padding: 8px 70px;border-radius: 5px;font-size: 20px;">
            <?= Yii::t('fproject/yii2-flex', 'Click here to enable Adobe Flash Player') ?>
        </a>
    </p>
    <p style="line-height: 1.5em;">
        <?= Yii::t('fproject/yii2-flex', 'We are working to release all of our features running in native browser in 2018.') ?>
        <br />
        <?= Yii::t('fproject/yii2-flex', 'If you are still having trouble loading {name}, contact us at <a href="mailto:{email}">{email}</a> for quick help.', [
            'name' => 'ProjectKit',
            'email' => 'support@projectkit.net'
        ]) ?>
    </p>
</div>

<noscript>
    <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="100%" height="100%" id="ProjectKit">
        <param name="movie" value="<?php echo $baseUrl ?>/<?php echo $name ?>.swf"/>
        <param name="quality" value="<?php echo $quality; ?>"/>
        <param name="bgcolor" value="<?php echo $bgColor; ?>"/>
        <param name="allowScriptAccess" value="<?php echo $allowScriptAccess ?>"/>
        <param name="allowFullScreen" value="<?php echo $allowFullScreen ?>"/>
        <param name="allowFullScreenInteractive" value="<?php echo $allowFullScreenInteractive ?>"/>
        <!--[if !IE]>-->
        <object type="application/x-shockwave-flash" data="<?php echo $baseUrl ?>/<?php echo $name ?>.swf" width="100%"
                height="100%">
            <param name="quality" value="<?php echo $quality; ?>"/>
            <param name="bgcolor" value="<?php echo $bgColor; ?>"/>
            <param name="allowScriptAccess" value="<?php echo $allowScriptAccess ?>"/>
            <param name="allowFullScreen" value="<?php echo $allowFullScreen ?>"/>
            <param name="allowFullScreenInteractive" value="<?php echo $allowFullScreenInteractive ?>"/>
            <!--<![endif]-->
            <!--[if gte IE 6]>-->
            <p>
                <?= Yii::t('fproject/yii2-flex', 'Either scripts and active content are not permitted to run or Adobe Flash Player version {version} or greater is not installed.', [
                    'version' => $flashVersion
                ]) ?>
            </p>
            <!--<![endif]-->
            <a href="http://www.adobe.com/go/getflashplayer">
                <img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif"
                     alt="Get Adobe Flash Player"/>
            </a>
            <!--[if !IE]>-->
        </object>
        <!--<![endif]-->
    </object>
</noscript>
</body>
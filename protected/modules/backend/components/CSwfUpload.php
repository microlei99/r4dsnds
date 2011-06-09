<?php
class CSwfUpload extends CWidget
{
    public $jsHandlerUrl;
    public $postParams=array();
    public $config=array();

    public function run()
    {
        $url = Yii::app()->params['backendPath'];
        Yii::app()->clientScript->registerScriptFile($url.'swfupload/swfupload.js', CClientScript::POS_HEAD);

        if(isset($this->jsHandlerUrl))
        {
            Yii::app()->clientScript->registerScriptFile($this->jsHandlerUrl);
            unset($this->jsHandlerUrl);
        }
        $postParams = array('PHPSESSID'=>session_id());
        if(isset($this->postParams))
        {
            $postParams = array_merge($postParams, $this->postParams);
        }
        
        $config = array('post_params'=> $postParams, 'flash_url'=>$url.'swfupload/swfupload.swf');
        $config = array_merge($config, $this->config);
        $config = CJavaScript::encode($config);
        Yii::app()->getClientScript()->registerScript(__CLASS__, "
		var swfu;
			swfu = new SWFUpload($config);
                ");
    }
}
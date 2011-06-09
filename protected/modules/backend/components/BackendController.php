<?php
class BackendController extends CController
{
    public $layout = '/layouts/column1';

    public $sideView;
    public $menu=array();
    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs=array();

    public  $htmlOption=array('class'=>'head-dashboard','header'=>"Dashboard");

    public $menu_active = 0;

    public function  __construct($id,$module='backend')
    {
        parent::__construct($id,$module);
        $this->registerAssets();
    }

    protected function registerAssets()
    {
        $cs = Yii::app()->clientScript;
        $cs->registerCoreScript('jquery');
        $cs->registerCssFile(Yii::app()->params['backendPath'] . 'reset.css', 'all');
        $cs->registerCssFile(Yii::app()->params['backendPath'] . 'boxes.css', 'all');
        $cs->registerCssFile(Yii::app()->params['backendPath'] . 'print.css', 'print');
        $cs->registerCssFile(Yii::app()->params['backendPath'] . 'menu.css', 'screen,projection');
        $cs->registerScriptFile(Yii::app()->params['backendPath'] . 'js/menu.js', CClientScript::POS_END);
        $script = "$('#nav li.level0:eq($this->menu_active)').addClass('active');$('nav li.level0>a').click(function(){ return false;});";
        $cs->registerScript('active',$script,  CClientScript::POS_END);
    }

    public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array(
                'allow',
                'expression' => 'Yii::app()->user->getIsAdmin()',
            ),
            array('deny',
                'users' => array('*'),
                'message' => 'Access Denied.',
            ),
        );
    }
}
?>

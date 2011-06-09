<?php
class MsgController extends BackendController
{
	public $menu_active = 6;

	public function actionAlert()
	{
		$this->htmlOption=array('class'=>'icon-head head-products','header'=>"通知信息");
        $model = new AlertMessage();

        if(isset($_GET['AlertMessage']))
        {
            $model->attributes = $_GET['AlertMessage'];
        }

        $this->render('msg',array('model'=>$model));
	}

	public function actionConfig()
	{
		$this->htmlOption=array('class'=>'icon-head head-products','header'=>"参数设置",'button'=>array(
                  array(
                        'class'=>'scalable save',
                        'id'=>'config-save',
                        'header'=>'保存',
                       'click'=>"$('#config_form').submit()",
                  ),
        ));
		$this->sideView ='sidebar/config';
        $this->layout = '/layouts/column2';

		if(isset($_POST['email']))
		{
			foreach($_POST['email'] as $key=>$val)
			{
				$model = Config::model()->findByAttributes(array('config_type'=>'email','config_item'=>$key));
				$model->config_code = $val;
				$model->save();
			}
		}
		
		if(isset($_POST['stock']))
		{
			foreach($_POST['stock'] as $key=>$val)
			{
				$model = Config::model()->findByAttributes(array('config_type'=>'stock','config_item'=>$key));
				$model->config_code = $val;
				$model->save();
			}
		}

		if(isset($_POST['ship']))
		{
			foreach($_POST['ship'] as $key=>$val)
			{
				$model = Config::model()->findByAttributes(array('config_type'=>'ship','config_item'=>$key));
				$model->config_code = $val;
				$model->save();
			}
		}

		if(isset($_POST['coupon']))
		{
			foreach($_POST['coupon'] as $key=>$val)
			{
				$model = Config::model()->findByAttributes(array('config_type'=>'coupon','config_item'=>$key));
				$model->config_code = $val;
				$model->save();
			}
		}

        if(isset($_POST['system']))
        {
            foreach($_POST['system'] as $key=>$val)
			{
				$model = Config::model()->findByAttributes(array('config_type'=>'system','config_item'=>$key));
                $model->config_code = $val;
                $model->save();
			}
        }

		$email = Config::items('email');
		$stock = Config::items('stock');
		$payment = Payment::items();
		$ship = Config::items('ship');
        $system = Config::items('system');

		$this->render('config',array('email'=>$email,'stock'=>$stock,'payment'=>$payment,'ship'=>$ship,'system'=>$system));
	}

    public function actionSearch()
	{   
        $this->htmlOption = array('class' => 'icon-head head-products', 'header' => "搜索监控", 'button' => array(
                array(
                    'class' => 'scalable save',
                    'id' => 'config-save',
                    'header' => '设置搜索热词',
                    'click' => "location.href='/backend/config/sethotsearch'",
                ),
        ));
		$model = new SearchItem();

		if(isset($_GET['SearchItem']))
			$model->attributes = $_GET['SearchItem'];

		$this->render('search',array('model'=>$model));
	}

    
}
?>
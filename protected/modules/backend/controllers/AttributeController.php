<?php

class AttributeController extends BackendController
{
    public $menu_active = 2;
	public function actionIndex()
	{
	    $this->htmlOption=array(
			'class'=>'icon-head head-products',
			'header'=>"新建属性组",
			'button'=>array(
                        array(
                            'class'=>'scalable save',
                            'id'=>'category-save',
                            'header'=>'新建属性组',
							'click'=>"location.href='/backend/attribute/addattrGroup'",
                        ),
        ));
		$model = new AttributeGroup();
        if(isset($_GET['AttributeGroup']))
            $model->attributes = $_GET['AttributeGroup'];

		$this->render('attr_group',array('model'=>$model));
	}

    public function actionAddattrGroup()
    {
        $this->layout = 'column2';
        $this->sideView = 'sidebar/attr_group';
        $this->htmlOption=array(
			'class'=>'icon-head head-products',
			'header'=>"新建属性组",
            'button' => array(
                array(
                    'class' => 'scalable save',
                    'id' => 'category-save',
                    'header' => '保存',
                    'click' => "$('#attribute_form').submit()",
                ),
        ));
        $model = new AttributeGroup();

        if(isset($_POST['AttributeGroup']))
        {
            $model->attributes = $_POST['AttributeGroup'];
            if($model->save())
                $this->redirect(array('index'));
        }
        $this->render('opt_group',array('model'=>$model));
    }

    public function actionUpdateattrGroup()
    {
        $this->layout = 'column2';
        $this->sideView = 'sidebar/attr_group';
        $this->htmlOption=array(
			'class'=>'icon-head head-products',
			'header'=>"更新属性组",
            'button' => array(
                array(
                    'class' => 'scalable save',
                    'id' => 'category-save',
                    'header' => '保存',
                    'click' => "$('#attribute_form').submit()",
                ),
        ));
        $model = $this->loadModel('AttributeGroup', $_GET['group']);
        if(isset($_POST['AttributeGroup']))
        {
            $model->attributes = $_POST['AttributeGroup'];
            if($model->save())
                $this->redirect (array('index'));
        }

        $this->render('opt_group',array('model'=>$model));
    }

    public function actionDeleteattrGroup()
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $model = $this->loadModel('AttributeGroup',$_GET['group']);
            $model->delete();
        }
    }

    /** --------------------------------------------**/
    public function actionAttr()
    {
        if(!isset($_GET['group']))
            $this->redirect(array('index'));

        $groupModel = $this->loadModel('AttributeGroup', $_GET['group']);
        $this->htmlOption=array(
			'class'=>'icon-head head-products',
			'header'=>'查看属性组('.CHtml::link($groupModel->group_name,'/backend/attribute/updateattrGroup/group/'.$groupModel->group_id).')',
            'button' => array(
                array(
                    'class' => 'scalable save',
                    'id' => 'category-save',
                    'header' => '添加属性',
                    'click' => "location.href='/backend/attribute/addattr/group/$groupModel->group_id'",
                ),
        ));
        $model = new Attribute();
        $model->attribute_group_id = $groupModel->group_id;
        
        if(isset($_GET['Attribute']))
            $model->attributes = $_GET['Attribute'];

        $this->render('attr',array('model'=>$model));
    }
    
	public function actionAddattr()
	{
        $this->layout = 'column2';
        $this->sideView = 'sidebar/attr';

        $model = new Attribute();
        if(isset($_GET['group']))
            $model->attribute_group_id = $_GET['group'];
        
        $this->htmlOption=array(
			'class'=>'icon-head head-products',
			'header'=>"添加属性",
            'button' => array(
                array(
                    'class' => 'scalable save',
                    'id' => 'category-save',
                    'header' => '保存',
                    'click' => "$('#attribute_form').submit()",
                ),
        ));
        
        if(isset($_POST['Attribute']))
        {
            $model->attributes = $_POST['Attribute'];
            if($model->save())
                $this->redirect (array('attr','group'=>$model->attribute_group_id));
        }

        $this->render('opt_attr',array('model'=>$model));
	}

    public function actionUpdateattr()
    {
        $this->layout = 'column2';
        $this->sideView = 'sidebar/attr';

        $model = $this->loadModel('Attribute', $_GET['attr']);

        $this->htmlOption=array(
			'class'=>'icon-head head-products',
			'header'=>"更新属性",
            'button' => array(
                array(
                    'class' => 'scalable save',
                    'id' => 'category-save',
                    'header' => '保存',
                    'click' => "$('#attribute_form').submit()",
                ),
        ));
        
        if(isset($_POST['Attribute']))
        {
            $model->attributes = $_POST['Attribute'];
            if($model->save())
                $this->redirect (array('attr','group'=>$model->attribute_group_id));
        }

        $this->render('opt_attr',array('model'=>$model));
    }

    public function actionDeleteattr()
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $model = $this->loadModel('Attribute',$_GET['attr']);
            $model->delete();
        }
    }

    /* ----------------  */

    public function actionAttrValue()
    {
         if(!isset($_GET['attr']))
            $this->redirect(array('index'));
         
        $attrModel = $this->loadModel('Attribute', $_GET['attr']);
        $this->htmlOption=array(
			'class'=>'icon-head head-products',
			'header'=>'查看属性('.CHtml::link($attrModel->attribute_name,'/backend/attribute/updateattr/attr/'.$attrModel->attribute_id).')',
            'button' => array(
                array(
                    'class' => 'scalable save',
                    'id' => 'category-save',
                    'header' => '增加属性值',
                    'click' => "location.href='/backend/attribute/addattrValue/attr/{$attrModel->attribute_id}'",
                ),
        ));
        $model = new AttributeValue();
        $model->attribute_id = $attrModel->attribute_id;
        
        if(isset($_GET['AttributeValue']))
            $model->attributes = $_GET['AttributeValue'];

        $this->render('attr_value',array('model'=>$model));
    }
    
    public function actionAddattrValue()
    {
        $this->layout = 'column2';
        $this->sideView = 'sidebar/attr_value';

        $model = new AttributeValue();
        if(isset($_GET['attr']))
            $model->attribute_id = $_GET['attr'];

        $this->htmlOption=array(
			'class'=>'icon-head head-products',
			'header'=>"添加属性值",
            'button' => array(
                array(
                    'class' => 'scalable save',
                    'id' => 'category-save',
                    'header' => '保存',
                    'click' => "$('#attribute_form').submit()",
                ),
        ));

        if(isset($_POST['AttributeValue']))
        {
            $model->attributes = $_POST['AttributeValue'];
            if($model->save())
                $this->redirect (array('attrValue','attr'=>$model->attribute_id));
        }

        $this->render('opt_attr_value',array('model'=>$model));
    }

    public function actionUpdateattrValue()
    {
        $this->layout = 'column2';
        $this->sideView = 'sidebar/attr_value';

        $model = $this->loadModel('AttributeValue', $_GET['id']);

        $this->htmlOption=array(
			'class'=>'icon-head head-products',
			'header'=>"更新属性值",
            'button' => array(
                array(
                    'class' => 'scalable save',
                    'id' => 'category-save',
                    'header' => '保存',
                    'click' => "$('#attribute_form').submit()",
                ),
        ));

        if(isset($_POST['AttributeValue']))
        {
            $model->attributes = $_POST['AttributeValue'];
            if($model->save())
                $this->redirect (array('attrValue','attr'=>$model->attribute_id));
        }

        $this->render('opt_attr_value',array('model'=>$model));
    }

    public function actionDeleteattrValue()
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            AttributeValue::model()->deleteByPk($_GET['id']);
        }
    }

    /**
     * ajax载入属性值
     * @param group_id
     * @return array
     */
    public function actionDynamicAttribute()
    {
        $data = Attribute::model()->findAll('attribute_group_id=:id',array(':id'=>(int)$_POST['group_id']));
        $data = CHtml::listData($data,'attribute_id','attribute_name');
        foreach($data as $key=>$value)
        {
            echo CHtml::tag('option',array('value'=>$key),CHtml::encode($value),true);
        }
    }

    public function actionDynamicAttributeValue()
    {
        $data = AttributeValue::model()->findAll('attribute_id=:id',array(':id'=>(int)$_POST['attribute_id']));
        $data = CHtml::listData($data,'attribute_value_id','attribute_value');
        foreach($data as $key=>$value)
        {
            echo CHtml::tag('option',array('value'=>$key),CHtml::encode($value),true);
        }
    }

    protected function loadModel($class,$pk)
    {
        if($model==null)
        {
            if(class_exists($class))
            {
                if($class=='Attribute')
                    $model = Attribute::model()->findByPk($pk);
                else if($class=='AttributeValue')
                    $model = AttributeValue::model()->findByPk ($pk);
                else if($class=='AttributeGroup')
                    $model = AttributeGroup::model()->findByPk ($pk);
            }
            if($model==null)
                throw new CHttpException(404,"The requested page does not exist!");
        }
        return $model;
    }
}
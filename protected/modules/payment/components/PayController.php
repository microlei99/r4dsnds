<?php

class PayController extends CController
{
	public $layout = 'payment';
	
    public function  __construct($id,$module)
    {
        parent::__construct($id,$module);
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
            array('allow',
                'users'=>array('@'),
            ),
            array('deny',
                'users' => array('*'),
                'message' => 'Access Denied.',
            ),
        );
    }
}

?>
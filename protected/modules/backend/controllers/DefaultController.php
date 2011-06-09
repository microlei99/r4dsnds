<?php
class DefaultController extends BackendController
{
    public function accessRules()
    {
        return array(
            array(
                'allow',
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        if (!Yii::app()->user->getIsAdmin())
        {
            $this->redirect(array('login'));
        }
        $this->render('index');
    }

    public function actionLogin()
    {
        $model = new AdminForm;

        if (isset($_POST['AdminForm']))
        {
            $model->attributes = $_POST['AdminForm'];
            if ($model->validate() && $model->login())
                $this->redirect(array('index'));
        }
        $this->layout = 'login';
        $this->render('login', array('model' => $model));
    }

    public function actionLogout()
    {
        Yii::app()->user->adminout();
        $this->redirect('/backend');
    }

    public function actionGetSalePrice()
    {
        if (Yii::app()->request->isAjaxRequest)
        {
            $id = $_POST['id'];
            switch ($id)
            {
                case 1:
                    $saleID = 1;
                    break;
                case 2:
                    $saleID = 2;
                    break;
                case 3:
                    $saleID = 3;
                    break;
                case 4:
                    $saleID = 4;
                    break;
                case 5:
                    $saleID = 5;
                    break;
                default:
                    $saleID = 1;
            }

            echo  '$'.Order::getStatisticSale($saleID);
            exit;
        }
    }
}
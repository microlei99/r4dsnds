<?php

class SiteController extends Controller
{   
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
         $this->_seo(array(
            'seo_title' => 'R4DS,DS R4,R4 DS,R4 DSi,R4i Gold,R4 SDHC,R4i SDHC,R4i Ultra Online Top provider',
            'seo_keyword' => 'r4 ,r4 ds ,r4 sdhc,r4i gold,ps3 games,ps3 hdd,acekard,micro sd',
            'seo_description' => 'R4dsnds.com provides nintendo ds r4(r4 ds,r4 sdhc,r4i gold) ,acekards and ps3 games ( ps3 controller,ps3 games hdd,ps3 hdd)for sale in Global market.All our products tested before dispatch.'
        ));
        
		$this->render('index');
	}

    public function actionCurrency()
    {
        if(isset($_GET['currency']))
        {
            $c = Currency::model()->findByAttributes(array('currency_code'=>$_GET['currency'],'currency_active'=>1));
            if($c)
            {
                Yii::app()->user->setState('currency',$c->currency_id);
                $cookie = new CHttpCookie('currency',$c->currency_id);
                $cookie->expire = time()+60*60*24*30;
                Yii::app()->request->cookies['currency'] = $cookie;
            }
            else{
                Yii::app()->user->setState('currency',Yii::app()->params['currency']);
            }
        }
        $this->redirect(Yii::app()->request->urlReferrer==null ? '/shoppingcart' : Yii::app()->request->urlReferrer);
    }

    public function actionLogin()
    {
        $this->layout = 'column1';
        $this->breadcrumbs = array(
            'Login',
        );
        $model = new LoginForm();

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if(isset($_POST['LoginForm']))
        {
            $model->attributes = $_POST['LoginForm'];
            if($model->validate() && $model->login())
            {
                $this->redirect(Yii::app()->user->returnUrl);
            }
        }

        $this->render('login',array('model'=>$model,'sign'=>$_GET['s']));
    }

    public function actionRegister()
    {
        $this->layout = 'column1';
        $this->breadcrumbs = array(
            'Register',
        );
        $model = new RegisterForm();

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'register-form')
        {
            header('Content-Type:text/html;charset=utf-8');
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if(isset($_POST['RegisterForm']) && strcmp($_POST['key'],Yii::app()->user->getState('key'))==0)
        {
            $model->attributes = $_POST['RegisterForm'];

            if($model->validate() && $model->register())
            {
                Yii::app()->user->setState('key',NULL);
                $login = new LoginForm();
                $login->email = $model->email;
                $login->password = $model->password;
                if($login->login()){
                    $this->redirect(Yii::app()->user->returnUrl);
                }
            }
        }

        Yii::app()->user->setState('key',randomName(10,'syo'));
        $this->render('register',array('model'=>$model,'key'=>Yii::app()->user->getState('key')));
    }

    public function actionForget()
    {
        $this->layout = 'column1';
        $this->breadcrumbs = array('Forget');
        $model = new LoginForm ;
  
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'register-form'){
            echo "OK";
            echo CActiveForm::validate($model);    
            Yii::app()->end();   
        }
        
        if (Yii::app()->request->isPostRequest)
        {
            $model->email = $_POST['LoginForm']['email'];
            if ($model->validate(array('email')))
            {
                $customer = Customer::model()->findByAttributes(array('customer_email'=>$model->email));
                if($customer)
                {
                     $pwd = $customer->resetPassword();
                     $message = 'An Email has sent to your { '.$model->email.' },you can get the new reset password from this email.';
                     Yii::app()->user->setFlash('password',$message);
                     $model->email = '';
                }
                else{
                    $model->addError('email', "{$model->email} have not register yet!");
                }
            }          
        }

        $this->render('forget', array('model'=>$model));
    }

    public function actionSearch()
    {
        $searchKeyword = $_POST['search'] ;

        if (isset($_GET['search'])) {
            $searchKeyword = $_GET['search'];
        }

        if (isset($searchKeyword))
        {
            $this->breadcrumbs = array('Search');
            $this->_seo(array(
                'seo_title' => $searchKeyword,
                'seo_keyword' => $searchKeyword,
                'seo_description' => $searchKeyword,
            ));

            $criteria = new CDbCriteria(array(
                 'select'=>array('product_id','product_name','product_url','product_status','product_active','product_base_price','product_orig_price','product_special_price',
                            'product_promotion','product_wholesale','product_status','product_short_description'),
                'condition' => 'product_active=1 AND (product_name LIKE :p OR product_sku LIKE :p OR product_short_description LIKE :p)',
                'params'=>array(':p'=>"%%{$searchKeyword}%%"),
            ));
            $count = Product::model()->count($criteria);
            
            $pages = new CPagination($count);


            $pages->pageSize = 16;
            $pages->params = array('search'=>$searchKeyword);
            $criteria->order = 'product_last_update DESC';
            $pages->applyLimit($criteria);


            $searchResult = Product::model()->findAll($criteria);

			$p = new CHtmlPurifier();
			$p->options = array('URI.AllowedSchemes' => array(
					'http' => true,
					'https' => true,
					));
			$text = $p->purify($searchKeyword);

			if($text!='')
            {
                $search = SearchItem::model()->findByAttributes(array('search_query'=>$searchKeyword));
				if (!$search)
                {
                    $search = new SearchItem();
                    $search->search_query = $searchKeyword;
				}
				$search->search_update_at = new CDbExpression('NOW()');
				$search->search_times+=1;
				$search->search_result = count($searchResult);
				$search->search_user += 1;
				$search->save();
			}
            Yii::app()->clientScript->registerCssFile('/css/pager.css');
			$this->render('search',array('data'=>$searchResult,'keyword'=>CHtml::encode($searchKeyword),'pages'=>$pages));
        }
       else
       {
           $this->redirect('/');
       }
    }


   public function actionPromotion()
   {
       $this->breadcrumbs = array('Promotion');
       
       $criteria = Product::model()->promotion()->getDbCriteria();

       $count=Product::model()->count($criteria);

       $pages = new CPagination($count);
       $pages->pageSize = 16;
      
       $pages->applyLimit($criteria);

      $data = Product::model()->findAll($criteria);

      Yii::app()->clientScript->registerCssFile('/css/pager.css');
      $this->render('promotion',array('data'=>$data,'pages'=>$pages));
   }
    public function actionWholesale()
   {
       $this->breadcrumbs = array('Wholesale');
       
       $criteria = Product::model()->wholesale()->getDbCriteria();

       $count=Product::model()->count($criteria);

       $pages = new CPagination($count);
       $pages->pageSize = 16;
      
       $pages->applyLimit($criteria);

      $data = Product::model()->findAll($criteria);

      Yii::app()->clientScript->registerCssFile('/css/pager.css');
      $this->render('promotion',array('data'=>$data,'pages'=>$pages));
   }

   public function actionHot()
   {
       $this->breadcrumbs = array('Hot Sale');
       $data = Product::model()->hotSale(16)->findAll();

      $this->render('hotsale',array('data'=>$data));
   }

   public function actionNewarrival()
   {
       $this->breadcrumbs = array('New Arrival');
       $data = Product::model()->newarrivial(16)->findAll();

      $this->render('newarrival',array('data'=>$data));
   }

   public function actionSubscription()
   {
       if(Yii::app()->request->isPostRequest)
       {
           $email = $_POST['email'];
           if($email==''){
               $message = 'Subscription email is empty';
           }
           else
           {
               $subscription = new Subscription();
               $subscription->email = $email;
               if($subscription->save())
               {
                   $message = 'success';
               }
               else
               {
                   $message = $subscription->getError('email');
               }
           }
       }
       else
           $this->redirect('/');
   }
   
	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
        $this->layout = 'column1';
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

}
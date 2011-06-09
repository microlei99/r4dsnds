<?php

class HelpController extends Controller
{
    public $layout = 'column1';
    public $breadcrumbs = array('Help');
    
    public function actionIndex()
    {
        $this->redirect(array('about'));
    }
    
    public function actionAbout()
    {
        $this->render('about');
    }

    public function actionShipping()
    {
        $this->render('shipping');
    }

    public function actionReturn()
    {
        $this->render('return');
    }

	public function actionContact()
    {
        $this->render('contact');
    }

    public function actionPrivacy()
    {
        $this->render('privacy');
    }

    public function actionTerms()
    {
        $this->render('terms');
    }
}
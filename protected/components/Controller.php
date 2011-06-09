<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column2';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs = array();

    public $description;

    public $keywords;

    public $scripts = array(
            '/script/jquery-1.4.2.min.js',
            '/script/common.js',
            '/script/tabs.js',
       
        );

    protected  function _registerJsScript($script)
    {
        if(!in_array($script,$this->scripts))
        {
            $this->scripts[] = $script;
        }
    }

    protected  function _registerJsScripts($scripts)
    {
        $this->scripts = array();
        if(is_array($scripts) && !empty($scripts))
        {
            foreach($scripts as $script)
            {
                $this->_registerJsScript($script);
            }
        }
    }

    protected  function _seo($model)
    {
        $this->pageTitle = $model['seo_title'];
        $this->keywords = $model['seo_keyword'];
        $this->description = $model['seo_description'];
    }
}
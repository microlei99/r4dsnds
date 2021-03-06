<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'www.r4dsnds.com',
    // preloading 'log' component
    'preload' => array('log'),
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.modules.backend.models.*',
        'ext.cart.*'
    ),
    'modules' => array(
        'backend' => array(
            'defaultController' => 'default'
        ),
        'payment',
        'gii' => array(
                'class' => 'system.gii.GiiModule',
                'password' => '123456',
                // If removed, Gii defaults to localhost only. Edit carefully to taste.
                'ipFilters' => array('127.0.0.1', '172.16.0.11'),
            ), 
    ),
    // application components
    'components' => array(
        'user' => array(
            // enable cookie-based authentication
            'class' => 'SyoUser',
            'allowAutoLogin' => true,
        ),
        'cache'=>array(
            'class'=>'system.caching.CFileCache',
            'keyPrefix'=>'syo',
        ),

        'newscache'=>array(
            'class'=>'system.caching.CFileCache',
            'cachePath'=>'protected/runtime/cache/news',
            'directoryLevel'=>2
        ),

        'urlManager' => array(
            'class' => 'ext.DbUrlManager.EDbUrlManager',
            'urlFormat' => 'path',
            'connectionID' => 'db',
            'showScriptName' => false,
            'rules' => array(
			    'wholesale'=>'site/wholesale',
                'currency/<id:USD|GBP|EUR|CAD|AUD|CNY>' => 'site/currency/currency/<id>',
                'news/<url:[a-zA-Z0-9\-]+>'=>array('news/read/url/<url>','urlSuffix'=>'.html','caseSensitive'=>false),
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                'category'=>'category',
                '<category:[a-zA-z0-9-]+>/<page:\d+>' => array(
                    'category/view',
                    'type' => 'db',
                    'fields' => array(
                        'category' => array(
                            'table' => 'syo_product_category',
                            'field' => 'category_url'
                        ),
                    ),
                    'caseSensitive' => false,
                ),
                '<category:[a-zA-z0-9-]+>' => array(
                    'category/view',
                    'type' => 'db',
                    'fields' => array(
                        'category' => array(
                            'table' => 'syo_product_category',
                            'field' => 'category_url'
                        ),
                    ),
                    'caseSensitive' => false,
                ),
                '<product:[a-zA-z0-9-]+>' => array(
                    'product/view',
                    'type' => 'db',
                    'fields' => array(
                        'product' => array(
                            'table' => 'syo_product',
                            'field' => 'product_url'
                        ),
                    ),
                    'urlSuffix' => '.html',
                    'caseSensitive' => false,
                ),
            ),
        ),
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=r4dsnds',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '123456',
            'tablePrefix' => 'syo_',
            'charset' => 'utf8',
        ),
        'cart' => array(
            'class' => 'ext.cart.Shoppingcart'
        ),
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error',
                ),
             /*array(
              'class'=>'CWebLogRoute',
              ),*/
            ),
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        'backendPath' => '/assets/default/',
        'urlSuffix' => '.html',
        'currency' => 1,
        'newscategoryPath'=>'protected/runtime/cache/news/cachednewscategory.php',
    ),
);
<?php

class NewsController extends Controller
{
    /*public function filters()
    {
        return array(
            array(
                'COutputCache',
                'cacheID'=>'newscache',
                'varyByParam'=>array(
                    'url'
                ),
                'dependency' => array(
                    'class' => 'CDbCacheDependency',
                    'sql' => 'SELECT news_updateat FROM {{news}} WHERE news_url=:url',
                )
            )
        );
    }*/

	public function actionRead()
    {
        $sql = "SELECT news_id FROM {{news}} WHERE news_url=:url";
        $id = Yii::app()->db->createCommand($sql)->bindValue(':url',$_GET['url'])->queryScalar();
        if($id)
        {
            $filename = 'protected/runtime/cache/news/readtime.php';
            if(!is_file($filename)){
                $this->saveToFile($filename, array());
            }
            $newsReadtime = $this->loadFromFile($filename);
            if(array_key_exists($id, $newsReadtime))
            {
                $newsReadtime[$id]++;
                if($newsReadtime[$id]>=10)
                {
                    Yii::app()->db->createCommand("UPDATE {{news}} SET news_readtimes=:n")->execute(array(':n'=>$newsReadtime[$id]));
                    $newsReadtime[$id] = 0;
                }
            }
            else{
                $newsReadtime[$id] = 1;
            }
            $this->saveToFile($filename, $newsReadtime);
            $this->render('index',array('id'=>$id));
        }
        else{
            throw new CHttpException(404, "The requested page does not exist!");
        }
        
    }

    protected function loadFromFile($file)
	{
		if(is_file($file))
			return require($file);
		else
			return array();
	}
    
    protected function saveToFile($file,$data)
    {
        file_put_contents($file,"<?php\nreturn ".var_export($data,true).";\n");
    }
}
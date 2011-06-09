<?php
class SeoBehavior extends CBehavior
{
    public function addSeo($seoFlage=false,$seoAttr=array())
    {
       $model = new Seo();
       if($seoFlage)
       {
           $model->attributes = $seoAttr;
           $model->save();
       }
       return $model;
    }

    public function updateSeo($pk,$seoFlage=false,$seoAttr=array())
    {
        $model = Seo::model()->findByPk($pk);
        if($model == null)
            throw new CHttpException(404,"The requested page does not exist!");

        if($seoFlage)
        {
            $model->attributes = $seoAttr;
            $model->save();
        }
        return $model;
    }
}
?>

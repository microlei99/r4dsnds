<?php
$this->breadcrumbs=array(
	'News',
);?>

<?php
    if(!News::checkNewsIsCached($id))
    {
        $data = Yii::app()->db->createCommand('SELECT * FROM {{news}} WHERE news_id='.$id)->queryRow();
        $news = <<<NEWS
            <div id="right-content" class="grid_9">
                <div class="product_list">
                    <div class="p_c_intr">
                    <h1 style="color: #FF3300;">{$data['news_title']}</h1>
                    <p><span style="margin-right: 30px;">Post By {$data['news_author']}</span><span>Date:{$data['news_updateat']}</span></p>
                    {$data['news_content']}
                    </div>
                </div>
             </div>
NEWS;
        Yii::app()->newscache->set('news_'.$id,$news);
        News::changeNewsCache($id);
        unset($news);
    }
    echo Yii::app()->newscache->get('news_'.$id);
?>
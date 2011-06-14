<div id="right-content" class='grid_9'>
    <div class="product_list">
        <h2><?php echo $model->category_name;?></h2>
        <div class="p_c_intr">
            <h1><?php echo $model->seo->seo_title;?></h1>
            <p><?php echo $model->category_introduce;?></p>

            <?php
            $relate = $model->getRalateCategory();
            $relateCategory = '';
            foreach ($relate as $index => $item){
                $relateCategory .= '<a href="' . $item['url'] . '">' . $item['name'] . '</a>' . str_repeat('&nbsp;', 3);
            }
            ?>
            <div class="p_rellinks">
                Relate Links: <?php echo rtrim($relateCategory); ?>
            </div>
        </div>
        <div id="pagenavi" class="pagenavi alignright">
            <?php $this->widget('CLinkPager', array(
                        'pages' => $pages,
                        'cssFile'=>'/css/pager.css',
                        'prevPageLabel'=>'<< prev',
                        'nextPageLabel'=>'next >>'
                     ));?>
        </div>
        <div class="clear"></div>
        <?php
        $this->renderPartial('//widget/_list_product_widget', array(
            'data' => $data,
        ));
        ?>
        <div class="clear"></div>


        <div id="pagenavi" class="pagenavi alignright">
            <?php $this->widget('CLinkPager', array(
                        'pages' => $pages,
                        'cssFile'=>'/css/pager.css',
                        'prevPageLabel'=>'<< prev',
                        'nextPageLabel'=>'next >>'
                     ));?>
        </div><!-- end pagenavi -->
        <div class="clear"></div>
    </div>
    
    <div class="info-in">
        <div class="info-box info-box2">
            <div class="info-box-title"><h3>Relate News</h3></div>
            <div class="info-box-list">
                <ul>
                <?php
                 
                foreach($news as $row):
                ?>
                    <li>
                        <dl>
                            <dd class="d2"><a href="<?php echo $row->getNewsUrl($row->news_url);?>"><?php echo $row->news_title;?></a></dd>
                            <dd><span><?php echo $row->news_updateat;?></span></dd>
                        </dl>
                    </li>
                <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
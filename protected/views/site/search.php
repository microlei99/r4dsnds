<div id="right-content" class='grid_9'>

    <div class="product_list">
        <h2><?php echo "Search for:" .$keyword; ?></h2>
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
</div>
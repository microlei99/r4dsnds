<div class="categories-side-col">
    <div class="content-header">
        <h3 class="icon-head head-categories">Categories</h3>
        <button style="" class="scalable add" type="button" id="add_root_category_button"><span>添加根分类</span></button><br/>
        <button style=""class="scalable add" type="button" id="add_subcategory_button"><span>添加子分类</span></button><br/>
       
    </div>
      <?php           
             $this->widget('CTreeView',array(
                            'url'=>array('ajaxtree'),
                            'htmlOptions'=>array('class'=>"treeview-red",'id'=>'attribute_treeview')
                        ));
        ?>
</div>



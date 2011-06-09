<div class="content_box">
    <div class="pop_box" style="padding:12px;">
        <h1>All Categories</h1>
        <?php
        $roots = ProductCategory::model()->rootLevel()->findAll();
        foreach($roots as $root)
        {
          echo "<h2><a href='{$root->getUrl()}'>{$root['category_name']}</a></h2> <ul class='nav1'>";
          foreach ($root->directChildren()->findAll() as $item)
          {
              echo "<li><a href='{$item->getUrl()}'>{$item['category_name']}</a></li>";
          }
         echo " </ul><div class='fix'></div>";
        }
        ?>
    </div>
</div>
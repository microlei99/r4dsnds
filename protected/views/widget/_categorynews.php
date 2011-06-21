<div class="info-in">
        <div class="info-box info-box2">
            <div class="info-box-title"><h3>Relate News</h3></div>
            <div class="info-box-list">
                <?php
                $news = News::getNewsByCategory($categoryIDS);
                foreach($news as $row):
                ?>
                <div class="news-title">
                    <h2><a href="<?php echo News::getNewsUrl($row['news_url']);?>" target="_blank"><?php echo $row['news_title'];?></a><span>Date:<?php echo $row['news_updateat'];?></span></h2>

                        <?php
                        if(preg_match('/<p>(.|\r|\n)*<\/p>/iU',$row['news_content'],$paragraph)){
                            echo $paragraph[0];
                        }
                        else{
                            echo $row['news_content'];
                        }
                        ?>

                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
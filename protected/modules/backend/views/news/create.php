<?php
$form=$this->beginWidget('CActiveForm', array(
    'id'=>'news_form'
 ));
?>
<div style="" id="news_content" class="content_col">
    <div class="entry-edit">
        <?php if($model->hasErrors()):?>
        <div id="messages">
            <ul class="messages">
                <li class="error-msg">
                <?php
                foreach($model->getErrors() as $category=>$errors)
                {
                    echo '<span>'.$model->getAttributeLabel($category).'</span><ul style="padding-left: 20px;">';
                    foreach($errors as $error){
                        echo '<li style="list-style-type:decimal;">'.$error.'</li>';
                    }
                    echo '</ul>';
                }
                ?>
                </li>
            </ul>
        <?php endif;?>
        </div>
        <div class="entry-edit-head">
            <h4 class="icon-head head-edit-form fieldset-legend">新闻</h4>
        </div>
        <div id="group_3fieldset_group_3" class="fieldset fieldset-wide">
            <div class="hor-scroll" id="promotion_form">
                <table cellspacing="0" class="form-list">
                    <tbody>
                        <tr>
                            <td class="label">
                                <label for="news_author">作者<span class="required">*</span></label>
                            </td>
                            <td class="value">
                            <?php
                            echo $form->textField($model,'news_author',array(
                                      'class'=>'required-entry input-text',
                                      'id'=>'news_author',
                                  ));
                            ?>
                            </td>
                            <td class="scope-label"><span class="nobr"></span></td>
                            <td><small>&nbsp;</small></td>
                        </tr>
                        <tr>
                            <td class="label">
                                <label for="news_title">标题<span class="required">*</span></label>
                            </td>
                            <td class="value">
                            <?php
                            echo $form->textField($model,'news_title',array(
                                      'class'=>'required-entry input-text',
                                      'id'=>'news_title'
                                  ));
                            ?>
                            </td>
                            <td class="scope-label"><span class="nobr"></span></td>
                            <td><small>&nbsp;</small></td>
                        </tr>

                        <tr>
                            <td class="label">
                                <label for="news_url">Url<span class="required">*</span></label>
                            </td>
                            <td class="value">
                            <?php
                            echo Yii::app()->getRequest()->hostInfo.'/news/'.
                                $form->textField($model,'news_url',array(
                                      'class'=>'required-entry input-text',
                                      'id'=>'news_url',
                                  ));
                            ?>
                            </td>
                            <td class="scope-label"><span class="nobr"></span></td>
                            <td><small>&nbsp;</small></td>
                        </tr>

                        <tr>
                            <td class="label"><label for="newscontent">内容<span class="required">*</span></label></td>
                            <td class="value">
                                <?php
                                $this->widget('ext.dxheditor.DxhEditor', array(
                                        'model'=>$model,
                                        'attribute'=>'news_content',
                                        'htmlOptions'=>array(
                                            'class'=>'required-entry required-entry textarea',
                                            'id'=>'newscontent',
                                            'style'=>'height:600px;'
                                        ),
                                        //'language'=>'en',
                                        'language' => 'zh-cn',
                                        'options' => array(
                                            'upMultiple' => 5,
                                            'upLinkUrl' => '{editorRoot}upload.php',
                                            'upLinkExt' => 'zip,rar,7z,txt,doc,xls,ppt,docx,xlsx,pptx',
                                            'upImgUrl' => '{editorRoot}upload.php',
                                            'tools' => 'full', //// mini, simple, full
                                         ),
                                ));
                                ?>
                            </td>
                            <td class="scope-label"><span class="nobr"></span></td>
                            <td><small></small></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- category start-->
<div style="" id="product_category_content" class="content_col">
    <div class="entry-edit">
        <div class="entry-edit-head">
            <h4 class="icon-head head-edit-form fieldset-legend">分类</h4>
        </div>
        <fieldset id="grop_fields">
            <?php
            $this->widget('CTreeView',array(
                'data' =>$tree,
                'htmlOptions'=>array('class'=>"treeview-famfamfam")
            ));
            ?>
        </fieldset>
    </div>
</div>
<!-- category end-->
<?php $this->endWidget(); ?>
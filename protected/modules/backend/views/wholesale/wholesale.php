<?php $form=$this->beginWidget('CActiveForm', array('id'=>'wholesale_form',));?>
<div style="display: none;"></div>
<!-- promotion start -->
<div style="" id="product_promotion_content" class="content_col">
    <div class="entry-edit">
        <div class="entry-edit-head">
            <h4 class="icon-head head-edit-form fieldset-legend">促销信息</h4>
        </div>
        <div id="group_3fieldset_group_3" class="fieldset fieldset-wide">
            <div class="hor-scroll" id="promotion_form">
                <table cellspacing="0" class="form-list">
                    <tbody>
                        <tr>
                            <td class="label"><label for="">产品SKU</label></td>
                            <td class="value"><?php echo CHtml::dropDownList('product_id', $wholesale->wholesale_product_id,  Product::getAllProductSku());?></td>
                            <td class="scope-label"></td>
                            <td><small>&nbsp;</small></td>
                        </tr>

                        <tr>
                            <td class="label"><label for="promotion_status">批发状态<span class="required">*</span></label></td>
                            <td class="value"><?php echo $form->dropDownList($wholesale,'wholesale_active',array(1=>'Yes',0=>'No'));?></td>
                            <td class="scope-label"></td>
                            <td><small>&nbsp;</small></td>
                        </tr>

                        <tr>
                            <td class="label"><label for="wholesale_type">批发类型<span class="required">*</span></label></td>
                            <td class="value"><?php echo $form->dropDownList($wholesale,'wholesale_type',array(1=>'By Amount',2=>'By %'),array('id'=>'wholesale_type'));?></td>
                            <td class="scope-label"></td>
                            <td><small>&nbsp;</small></td>
                        </tr>

                        <tr>
                            <td class="label"><label for="wholesale_product_interval1">批发下限<span class="required">*</span></label></td>
                            <td class="value"><?php echo $form->textField($wholesale,'wholesale_product_interval1',array('class'=>'required-entry input-text','id'=>'wholesale_product_interval1','style'=>'width: 110px ! important;')); ?></td>
                            <td class="scope-label"><span class="nobr"><?php echo $form->error($wholesale,'wholesale_product_interval1'); ?></span></td>
                            <td><small>&nbsp;</small></td>
                        </tr>

                        <tr>
                            <td class="label"><label for="wholesale_product_interval2">批发上限<span class="required">*</span></label></td>
                            <td class="value"><?php echo $form->textField($wholesale,'wholesale_product_interval2',array('class'=>'required-entry input-text','id'=>'wholesale_product_interval2','style'=>'width: 110px ! important;')); ?></td>
                            <td class="scope-label"><span class="nobr"><?php echo $form->error($wholesale,'wholesale_product_interval2'); ?></span></td>
                            <td><small>&nbsp;</small></td>
                        </tr>

                        <tr>
                            <td class="label"><label for="wholesale_product_price">批发价格<span class="required">*</span></label></td>
                            <td class="value"><?php echo $form->textField($wholesale,'wholesale_product_price',array('class'=>'required-entry input-text','id'=>'wholesale_product_price','style'=>'width: 110px ! important;')); ?></td>
                            <td class="scope-label"><span class="nobr"><?php echo $form->error($wholesale,'wholesale_product_price'); ?></span></td>
                            <td><small>&nbsp;</small></td>
                        </tr>

                        <tr>
                            <td class="label"><label for="wholesale_product_percent">折扣(%)<span class="required">*</span></label></td>
                            <td class="value"><?php echo $form->textField($wholesale,'wholesale_product_percent',array('class'=>'required-entry input-text','id'=>'wholesale_product_percent','style'=>'width: 110px ! important;')); ?></td>
                            <td class="scope-label"><span class="nobr"><?php echo $form->error($wholesale,'wholesale_product_percent'); ?></span></td>
                            <td><small>&nbsp;</small></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- promotion end -->
<?php $this->endWidget(); ?>
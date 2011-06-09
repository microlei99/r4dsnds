<?php $url = Yii::app()->params['backendPath'];?>
<script type="text/javascript" src="<?php echo $url.'JSCal/js/jscal2.js';?>"></script>
<script type="text/javascript" src="<?php echo $url.'JSCal/js/lang/cn.js';?>"></script>
<link  type="text/css" rel="stylesheet"  href="<?php echo $url.'JSCal/css/jscal2.css';?>" />
<link  type="text/css" rel="stylesheet"  href="<?php echo $url.'JSCal/css/border-radius.css';?>" />
<?php $form=$this->beginWidget('CActiveForm', array('id'=>'promotion_form',));?>
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
                            <td class="label"><label for="">产品SKU<span class="required">*</span></label></td>
                            <td class="value"><?php echo CHtml::dropDownList('product_id', $promotion->promotion_product_id,  Product::getAllProductSku());?></td>
                            <td class="scope-label"><span class="nobr"><?php echo $form->error($promotion,'promotion_product_id'); ?></span></td>
                            <td><small>&nbsp;</small></td>
                        </tr>

                        <tr>
                            <td class="label"><label for="promotion_status">促销状态<span class="required">*</span></label></td>
                            <td class="value"><?php echo $form->dropDownList($promotion,'promotion_status',array(1=>'过期',2=>'正常',3=>'关闭'));?></td>
                            <td class="scope-label"></td>
                            <td><small>&nbsp;</small></td>
                        </tr>

                        <tr>
                            <td class="label"><label for="promotion_type">促销类型<span class="required">*</span></label></td>
                            <td class="value"><?php echo $form->dropDownList($promotion,'promotion_type',array(1=>'By Amount',2=>'By %'),array('id'=>'promotion_type'));?></td>
                            <td class="scope-label"></td>
                            <td><small>&nbsp;</small></td>
                        </tr>

                        <tr>
                            <td class="label"><label for="promotion_price">促销价格<span class="required">*</span></label></td>
                            <td class="value"><?php echo $form->textField($promotion,'promotion_price',array('class'=>'required-entry input-text','id'=>'promotion_price','style'=>'width: 110px ! important;')); ?></td>
                            <td class="scope-label"><span class="nobr"><?php echo $form->error($promotion,'promotion_price'); ?></span></td>
                            <td><small>&nbsp;</small></td>
                        </tr>

                        <tr>
                            <td class="label"><label for="promotion_percent">折扣(%)<span class="required">*</span></label></td>
                            <td class="value"><?php echo $form->textField($promotion,'promotion_percent',array('class'=>'required-entry input-text','id'=>'promotion_percent','style'=>'width: 110px ! important;')); ?></td>
                            <td class="scope-label"><span class="nobr"><?php echo $form->error($promotion,'promotion_percent'); ?></span></td>
                            <td><small>&nbsp;</small></td>
                        </tr>

                         <tr>
                            <td class="label"><label for="promotion_start_at">促销开始时间<span class="required">*</span></label></td>
                            <td class="value">
                                <?php echo $form->textField($promotion,'promotion_start_at',array('class'=>'required-entry input-text','id'=>'promotion_start_at','style'=>'width: 110px ! important;')); ?>
                                 <img style="" title="Select Date" id="special_from_date_trig" class="v-middle" alt="" src="<?php echo $url.'images/grid-cal.gif';?>">
                            </td>
                            <td class="scope-label"><span class="nobr"><?php echo $form->error($promotion,'promotion_start_at'); ?></span></td>
                            <td><small>&nbsp;</small></td>
                        </tr>


                        <tr>
                            <td class="label"><label for="promotion_end_at">促销结束时间<span class="required">*</span></label></td>
                            <td class="value"><?php echo $form->textField($promotion,'promotion_end_at',array('class'=>'required-entry input-text','id'=>'promotion_end_at','style'=>'width: 110px ! important;')); ?>
                                <img style="" title="Select Date" id="special_to_date_trig" class="v-middle" alt="" src="<?php echo $url.'images/grid-cal.gif';?>">
                            </td>
                            <td class="scope-label"><span class="nobr"><?php echo $form->error($promotion,'promotion_end_at'); ?></span></td>
                            <td><small>&nbsp;</small></td>
                        </tr>

                        <tr>
                            <td class="label"><label for="promotion_group_id">促销成员组<span class="required">*</span></label></td>
                            <td class="value"><?php echo CHtml::activeDropDownList($promotion,'promotion_group_id',  CustomerGroup::items(),array('id'=>'promotion_group_id',));?></td>
                            <td class="scope-label"><span class="nobr"><?php echo $form->error($promotion,'promotion_group_id'); ?></span></td>
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
<script type="text/javascript">
     var cal = Calendar.setup({
        onSelect: function(cal) { cal.hide() },
        showTime: true
    });
    cal.manageFields("special_from_date_trig", "promotion_start_at", "%Y-%m-%d");
    cal.manageFields("special_to_date_trig", "promotion_end_at", "%Y-%m-%d");
</script>
<?php
    $form = $this->beginWidget('CActiveForm', array(
            'id' => 'carrier_form',
        ));
?>

<div style="display: none;"></div>
<div  id="product_general_content" class="content_col">
        <div class="entry-edit">
            <div class="entry-edit-head">
                <h4 class="icon-head head-edit-form fieldset-legend">主要信息</h4>
            </div>
            <div id="group_fields4" class="fieldset fieldset-wide">

                <div class="hor-scroll">
                    <table cellspacing="0" class="form-list">
                        <tbody>
                            <tr>
                                <td class="label"><label for="carrier_active">是否激活 <span class="required">*</span></label></td>
                                <td class="value">
                                <?php
                                    echo $form->dropDownList($model, 'carrier_active', array(1=>'Yes',0=>'No'), array(
                                        'class' => 'required-entry required-entry input-select',
                                        'id' => 'carrier_active',
                                    ));
                                ?>
                                </td>
                                <td class="scope-label"><span class="nobr"></span></td>
                                <td><small>&nbsp;</small></td>
                            </tr>
                            <tr>
                                <td class="label"> <label for="carrier_name">名称<span class="required">*</span></label></td>
                                <td class="value">
                                <?php
                                    echo $form->textField($model, 'carrier_name', array(
                                        'class' => 'required-entry required-entry input-text',
                                        'id' => 'carrier_name',
                                    ));
                                ?>

                                </td>
                                <td class="scope-label">
                                    <span class="nobr"><?php echo $form->error($model, 'carrier_name'); ?></span>
                                </td>
                                <td><small></small></td>
                            </tr>

                            <tr>
                                <td class="label"> <label for="carrier_fee">运费<span class="required">*</span></label></td>
                                <td class="value">
                                <?php
                                    echo $form->textField($model, 'carrier_fee', array(
                                        'class' => 'required-entry required-entry input-text',
                                        'id' => 'carrier_fee',
                                    ));
                                ?>

                                </td>
                                <td class="scope-label">
                                    <span class="nobr"><?php echo $form->error($model, 'carrier_fee'); ?></span>
                                </td>
                                <td><small></small></td>
                            </tr>

                            <tr>
                                <td class="label"> <label for="carrier_url">跟踪地址<span class="required">*</span></label></td>
                                <td class="value">
                                <?php
                                    echo $form->textField($model, 'carrier_url', array(
                                        'class' => 'required-entry required-entry input-text',
                                        'id'=>'carrier_url',
                                    ));
                                ?>
                                    @符号指代跟踪码
                                </td>
                                <td class="scope-label">
                                    <span class="nobr"><?php echo $form->error($model, 'carrier_url'); ?></span>
                                </td>
                                <td><small></small></td>
                            </tr>
                              <tr>
                                <td class="label"> <label for="carrier_description">渠道简介</label></td>
                                <td class="value">
                                <?php
                                    echo $form->textArea($model, 'carrier_description', array(
                                        'class' => 'required-entry required-entry input-text',
                                        'id' => 'carrier_description',
                                    ));
                                ?>
                                </td>
                                <td class="scope-label">
                                    <span class="nobr"><?php echo $form->error($model, 'carrier_description'); ?></span>
                                </td>
                                <td><small></small></td>
                            </tr>

                            <tr>
                                <td class="label"><label for="carrier_zone">区域挂接 <span class="required">*</span></label></td>
                                <td class="value">
                                    <select multiple="multiple" name="carrier_zone[]" id="product_satus" class="required-entry input-text multiselect">
                                    <?php
                                        foreach (Zone::items() as $key => $row)
                                        {
                                            $sel = "";
                                            if (isset($zones) && !empty($zones))
                                            {
                                                foreach ($zones as $item)
                                                {
                                                    if ($key == $item)
                                                    {
                                                        $sel = "selected='true'";
                                                        break;
                                                    }
                                                }
                                            }

                                            echo "<option value='{$key}'{$sel}>{$row}</option>";
                                        }
                                    ?>
                                    </select>
                                </td>
                                <td class="scope-label"><span class="nobr"></span></td>
                                <td><small>&nbsp;</small></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</div>
<?php $this->endWidget() ?>
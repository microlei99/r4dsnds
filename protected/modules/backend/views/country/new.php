<?php
    $form = $this->beginWidget('CActiveForm', array(
                'id' => 'country_form',
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
                                <td class="label"><label for="active">是否激活 <span class="required">*</span></label></td>
                                <td class="value">
                                <?php
                                    echo $form->dropDownList($model, 'active', array(1=>'Yes',2=>'No'), array(
                                        'class' => 'required-entry required-entry input-select',
                                        'id' => 'active',
                                    ));
                                ?>
                                </td>
                                <td class="scope-label"><span class="nobr"></span></td>
                                <td><small>&nbsp;</small></td>
                            </tr>
                                <tr>
                                    <td class="label"> <label for="name">名称<span class="required">*</span></label></td>
                                    <td class="value">
                                <?php
                                        echo $form->textField($model, 'name', array(
                                            'class' => 'required-entry required-entry input-text',
                                            'id' => 'name',
                                        ));
                                ?>

                                    </td>
                                    <td class="scope-label">
                                        <span class="nobr"><?php echo $form->error($model, 'name'); ?></span>
                                    </td>
                                    <td><small></small></td>
                                </tr>
                                   <tr>
                                    <td class="label"> <label for="ISO_code">ISO 代码<span class="required">*</span></label></td>
                                    <td class="value">
                                <?php
                                        echo $form->textField($model, 'ISO_code', array(
                                            'class' => 'required-entry required-entry input-text',
                                            'id' => 'ISO_code',
                                        ));
                                ?>
                                    </td>
                                    <td class="scope-label">
                                        <span class="nobr"><?php echo $form->error($model, 'ISO_code'); ?></span>
                                    </td>
                                    <td><small></small></td>
                                </tr>
                                 <tr>
                                <td class="label"><label for="zone">区域 <span class="required">*</span></label></td>
                                <td class="value">
                                <?php
                                    echo $form->dropDownList($model, 'zone_id', zone::items(), array(
                                        'class' => 'required-entry required-entry input-select',
                                        'id' => 'zone',
                                    ));
                                ?>
                                </td>
                                <td class="scope-label"><span class="nobr"></span></td>
                                <td><small>&nbsp;</small></td>
                            </tr>
                              <tr>
                                <td class="label"><label for="contain_states">是否包含州 <span class="required">*</span></label></td>
                                <td class="value">
                                <?php
                                    echo $form->dropDownList($model, 'contain_states', array(1=>'Yes',2=>'No'), array(
                                        'class' => 'required-entry required-entry input-select',
                                        'id' => 'contain_states',
                                    ));
                                ?>
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
<?php $this->endWidget()?>
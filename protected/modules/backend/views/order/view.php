<div  id="product_general_content" class="content_col">
    <div class="box-left">
        <!--Order Information-->
        <div class="entry-edit">
            <div class="entry-edit-head">
                <h4 class="icon-head head-account">订单历史</h4>
            </div>
            <div class="fieldset">
                <table cellspacing="0" class="form-list" width="100%">
                    <tbody>
                    <?php

                    $history = OrderHistory::model()->findByAttributes(array('history_order_id'=>$model->order_id));
                    if($history)
                    {
                        if ($history->history_employee_id == 0 OR !$employee = Employee::model()->findByPk($history->history_employee_id))
                            $employeeName = '';
                        else
                            $employeeName=$employee->employee_name;
                        
                        $state = Lookup::item('payment_status', $history->history_state);

                        echo "
                            <tr><td><strong>操作时间：{$history->history_create}</strong></td></tr>
                            <tr><td><strong>当前状态：{$state}</strong></td></tr>
                            <tr> <td><strong>操作人员：{$employeeName}</strong></td></tr>";
                    }
                    ?>
                    </tbody>
                </table>
                <?php 
                    $form = $this->beginWidget('CActiveForm', array('id' => 'order_form'));
                    echo $form->dropDownList($model, 'order_status', Lookup::items('payment_status'),array('id'=>'order_status'));
                ?>
                <div>
                    <?php
                    $display = $model->order_status==Order::Shipped ? '':'display:none';
                    echo $form->textField($ship,'ship_code',array(
                            'class'=>'required-entry required-entry input-text',
                            'id'=>'ship_code',
                            'style'=>$display,
                        ));
                    echo CHtml::submitButton('提交', array('class' => 'scalable save'));
                    ?>

                </div>
                    <?php $this->endWidget();?>
                </div>
            </div>
        </div>
        <div class="box-right">
            <div class="entry-edit">
                <div class="entry-edit-head">
                    <h4 class="icon-head head-account">订单留言</h4>
                </div>
                <div class="fieldset">
                    <?php echo $model->order_comment;?>
                </div>
            </div>
        </div>
        <div class="clear"></div>

        <div class="box-left">
            <!--Order Information-->
            <div class="entry-edit">
                <div class="entry-edit-head">
                    <h4 class="icon-head head-account"> <?php echo $model->customer->customer_email . '#' . sprintf('%010d', $model->order_id); ?></h4>
                </div>
                <div class="fieldset">
                    <table cellspacing="0" class="form-list">
                        <tbody>
                            <tr>
                                <td class="label"><label>订单号</label></td>
                                <td><strong><?php echo $model->getInvoice(); ?></strong></td>
                            </tr>
                            <tr>
                                <td class="label"><label>下单时间</label></td>
                                <td><strong><?php echo $model->order_create_at; ?></strong></td>
                            </tr>
                            <tr>
                                <td class="label"><label>订单状态</label></td>
                                <td><strong><span id="order_status"><?php echo Lookup::item('payment_status', $model->order_status) ?></span></strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="box-right">
            <!--Account Information-->
            <div class="entry-edit">
                <div class="entry-edit-head">
                    <h4 class="icon-head head-account">客户信息</h4>
                </div>
                <div class="fieldset">
                    <div class="hor-scroll">
                        <table cellspacing="0" class="form-list">
                            <tbody>
                                <tr>
                                    <td class="label"><label>客户姓名</label></td>
                                    <td>
                                        <a href="/backend/customer/view/id/<?php echo $model->customer->customer_id; ?>" target="_blank">
                                            <strong><?php echo $model->customer->customer_name; ?></strong>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label"><label>Email</label></td>
                                    <td><a href="mailto:<?php echo $model->customer->customer_email; ?>"><strong><?php echo $model->customer->customer_email; ?></strong></a></td>
                                </tr>
                                <tr>
                                    <td class="label"><label>注册时间:</label></td>
                                    <td><strong><?php echo $model->customer->customer_create_at; ?></strong></td>
                                </tr>
                                <tr>
                                    <td class="label"><label>有效订单数:</label></td>
                                    <td><strong><?php echo Order::getCustomerValidOrders($model->customer_id); ?></strong></td>
                                </tr>
                                <tr>
                                    <td class="label"><label>总计金额:</label></td>
                                    <td><strong>$<?php echo Order::getCustomerTotalAmount($model->customer_id); ?></strong></td>
                                </tr>
                                <tr>
                                    <td class="label"><label>客户组</label></td>
                                    <td><strong><?php echo $model->customer->group->group_name; ?></strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <div class="box-left">
            <!--Order Billing-->
            <div class="entry-edit">
                <div class="entry-edit-head">
                    <h4 class="icon-head head-account">货运地址</h4>
                </div>
                <?php $address = CustomerAddress::model()->findByPk($model->order_address_id);?>
                <div class="fieldset">
                    <address>
                        姓名：<?php echo $address->customer_firstname . ' ' . $address->customer_lastname; ?><br/>
                        地址1：<?php echo $address->address_street; ?><br/>
                        地址2：<?php //echo $address->address_address2 ?><br/>
                        邮编/城市：<?php echo $address->address_postcode . ' ' . $address->address_city; ?><br/>
                        <?php
                        //if ($address->address_state_ID)
                           // echo "州：" . State::item($address->address_state_ID) . '<br/>';
                        ?>
                        国家：<?php echo Country::item($address->address_country); ?><br/>
                    电话：<?php echo $address->address_phonenumber; ?>
                </address>
            </div>
        </div>
    </div>
    <div class="box-right">
        <div class="entry-edit">
            <div class="entry-edit-head">
                <h4 class="icon-head head-account">货运</h4>
            </div>
            <div class="fieldset">
                <div class="hor-scroll">
                    <table cellspacing="0" class="form-list">
                        <tbody>
                            <tr>
                                <td class="label"><label>货运方式</label></td>
                                <td>
                                    <strong><?php echo $model->carrier->carrier_name ?></strong>
                                </td>
                            </tr>
                            <tr>
                                <td class="label"><label>货运跟踪</label></td>
                                <td>
                                    <strong><a href="<?php echo $ship->trackUrl($ship->ship_code,$model->carrier->carrier_url); ?>" target="_blank">
                                    <?php echo $ship->ship_code; ?></a></strong>
                                </td>
                            </tr>
                            <tr>
                                <td class="label"><label>总重量</label></td>
                                <td>
                                    <strong><?php echo round($model->getWeightTotal(), 4); ?> g</strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="clear"></div>
    <div class="entry-edit">
        <div class="entry-edit-head">
            <h4 class="icon-head head-products">订单产品</h4>
        </div>
    </div>
    <div class="grid np">
        <div class="hor-scroll">
            <table cellspacing="0" class="data order-tables">
                <thead>
                    <tr class="headings">
                        <th>商品</th>
                        <th>SKU</th>
                        <th>重量</th>
                        <th><span class="nobr">价格</span></th>
                        <th class="a-center">数量</th>
                        <th><span class="nobr">小计</span></th>
                        <th class="last"></th>
                    </tr>
                </thead>
                <tbody class="even">
                <?php
                    $products = OrderItem::model()->findAllByAttributes(array('order_id'=>$model->order_id));
                    $sign = Currency::getCurrencySymbol($model->order_currency_id);
                    foreach ($products as $product)
                    {
                        $price = floatval(substr(sprintf("%.10f", $product->item_price), 0, -9));
                        $subtotal = floatval($price * $product->item_qty);
                        echo <<<HTML
                                <tr class="border">
                                <td class="giftmessage-single-item a-center"> <h5 class="title">{$product->item_product_name}</h5></td>
                                <td class="a-center"><span>{$product->product->product_sku}</span></td>
                                <td class="a-center"><span>{$product->product->product_weight}</span></td>
                                <td class="a-center"><span class="price">{$sign}{$product->item_price}</span></td>
                                <td class="a-center"><span>{$product->item_qty}</span></td>
                                <td class="a-center"><span class="price">{$sign}{$subtotal}</span></td>
                                <td class="a-center last"></td></tr>
HTML;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="clear"></div>
    <br/>
    <div class="entry-edit">
        <div class="entry-edit-head">
            <h4 class="icon-head head-products">订单优惠</h4>
        </div>
    </div>
    <div class="grid np">
        <div class="hor-scroll">
            <table cellspacing="0" class="data order-tables">
                <thead>
                    <tr class="headings">
                        <th>优惠券</th>
                        <th><span class="nobr">优惠</span></th>
                        <th class="last"></th>
                    </tr>
                </thead>
                <tbody class="even">
                    <?php
                    /*$discount = order_discount::model()->findAllByAttributes(array('order_ID' => $model->order_ID));
                    foreach ($discount as $row)
                    {
                        echo <<<HTML
                                <tr class="border">
                                <td class="a-left"><span>{$row->discount_name}</span></td>
                                <td class="a-left"><span class="price">{$sign}-{$row->discount_value}</span></td>
                                <td class="a-left last"></td></tr>
HTML;
                    }*/
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="clear"></div>
    <br/>
    <div class="box-left entry-edit">
        <div class="entry-edit-head"><h4>订单统计</h4></div>
        <div class="order-totals">
            <table width="100%" cellspacing="0">
                <col />
                <col width="1" />
                <tbody>
                    <tr>
                        <td class="label">支付方式</td>
                        <td> <strong><?php echo $model->payment->payment_name; ?></strong></td>
                    </tr>
                </tbody>

                <tfoot>
                    <tr>
                        <td class="label">
                            <strong>物品总计</strong>
                        </td>
                        <td class="emph">
                            <strong><span class="price"><?php echo $sign . $model->order_subtotal; ?></span></strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">
                            <strong>优惠打折</strong>
                        </td>
                        <td class="emph">
                            <strong><span class="price"><?php //echo $sign . $model->order_total_discount ?></span></strong>
                        </td>
                    </tr>

                    <tr>
                        <td class="label">
                            <strong>跟踪号费用</strong>
                        </td>
                        <td class="emph">
                            <strong><span class="price"><?php echo $sign . $model->order_trackingtotal; ?></span></strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">
                            <strong>总计</strong>
                        </td>
                        <td class="emph">
                            <strong><span class="price"><?php echo $sign . $model->order_grandtotal; ?></span></strong>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <div class="clear"></div>
</div>
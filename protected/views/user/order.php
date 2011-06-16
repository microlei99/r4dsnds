<div class="sunmm_box">
    <h3>Unpaid Orders</h3>
    <table class="table1" width="100%">
        <thead>
            <tr>
                <th width="23%">Order Num</th>
                <th width="17%">Order Time</th>
                <th width="19%">Order Status</th>
                <th width="18%">Price</th>
                <th width="23%" class="thlast">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($orders as $key=>$order):?>
            <tr>
                <td><a href="/user/viewOrder/salt/<?php echo $order->order_salt; ?>"><?php echo Order::getPrefix().$order->invoice_id;?></a></td>
                <td><span class="gray"><?php echo date('Y/n/j',strtotime($order->order_create_at));?></span></td>
                <?php
                if($order->order_status==Order::Risk){
				    $order->order_status = Order::PaymentAccepted;
				}
                ?>
                <td><span class="green"><?php echo Lookup::item('payment_status', $order->order_status);?></span></td>
                <td><span class="orange"><?php echo Currency::getCurrencySymbol($order->order_currency_id) . $order->order_grandtotal; ?></span></td>
                <td>
                    <a href="/user/vieworder/salt/<?php echo $order->order_salt; ?>" class="button ubutton button_view" ></a>
                </td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>
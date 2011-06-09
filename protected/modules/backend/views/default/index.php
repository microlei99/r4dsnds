<table width="100%" cellspacing="25">
    <tbody>
        <tr>
            <td style="width:600px;">
                <div class="entry-edit">
                    <div class="entry-edit-head"><h4>总销售额</h4></div>
                    <fieldset class="a-center bold">
                        <span class="nowrap" style="font-size:18px;color:#2F2F2F"><span class="price"><?php echo '$' . Order::getLifeTimeTotal(); ?></span></span>
                    </fieldset>
                </div>
                <div class="entry-edit">
                    <div class="entry-edit-head"><h4>平均成交金额</h4></div>
                    <fieldset class="a-center bold">
                        <span style="font-size: 18px;color:#2F2F2F" class="nowrap"><span class="price"><?php echo '$' . Order::getOrderAvg(); ?></span></span>
                    </fieldset>
                </div>
                <div class="entry-edit">
                    <div class="entry-edit-head"><h4>最近10个成交订单</h4></div>
                    <fieldset class="np"><div class="grid np">
                            <table cellspacing="0" id="lastOrdersGrid_table" style="border: 0pt none;">
                                <col>
                                <col>
                                <col width="60">
                                <thead>
                                    <tr class="headings">
                                        <th class=" no-link" style="width:100px;"><span class="nobr2">客户</span></th>
                                        <th class=" no-link" style="width:200px;"><span class="nobr2">产品  |  购买数量</span></th>
                                        <th class=" no-link last"><span class="nobr2">成交金额</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $orders = Order::model()->findAll(array(
                                            'condition' => 'order_status=' . Order::PaymentAccepted,
                                            'order' => 'order_id DESC',
                                            'limit' => 10,
                                        ));
                                    foreach ($orders as $key => $order):
                                    ?>
                                        <tr class="<?php echo ($key % 2 == 0) ? 'even' : ''; ?>">
                                            <td><a href="<?php echo '/backend/customer/view/id/' . $order->customer->customer_id; ?>"><?php echo $order->customer->customer_email; ?></a></td>
                                            <td>
                                                <table width="100%">
                                                    <tbody>
                                                    <?php foreach ($order->items as $item): ?>
                                                        <tr>
                                                            <td><?php echo $item->item_product_name; ?></td>
                                                            <td><?php echo $item->item_qty; ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </td>
                                            <td class="a-center a-center last"><span class="price" style="font-size: 18px;"><?php echo $order->currency->currency_symbol . $order->order_grandtotal; ?></span></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                 </table>
                               </div>

                              </fieldset>
                                </div>
                                    <div class="entry-edit">
                                        <div class="entry-edit-head"><h4>最近5个搜索关键词</h4></div>
                                        <fieldset class="np"><div class="grid np">
                                                <table cellspacing="0" id="lastSearchGrid_table" style="border: 0pt none;">
                                                    <col>
                                                    <col width="100">
                                                    <col width="100">
                                                    <thead>
                                                        <tr class="headings">
                                                            <th class=" no-link"><span class="nobr2">关键词</span></th>
                                                            <th class=" no-link"><span class="nobr2">搜索结果数</span></th>
                                                            <th class=" no-link last"><span class="nobr2">用户数</span></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $querys = SearchItem::model()->rcently()->findAll();
                                                        foreach ($querys as $key => $query):
                                                        ?>
                                                            <tr class="<?php echo ($key % 2 == 0) ? 'even' : ''; ?>">
                                                                <td class="a-center"><?php echo $query->search_query; ?></td>
                                                                <td class="a-center"><?php echo $query->search_result; ?></td>
                                                                <td class="a-center last"><?php echo $query->search_user; ?></td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>

                                        </fieldset>
                                    </div>
                                    <div class="entry-edit">
                                        <div class="entry-edit-head"><h4>搜索量最多的五个关键词</h4></div>
                                        <fieldset class="np"><div class="grid np">
                                                <table cellspacing="0" id="topSearchGrid_table" style="border: 0pt none;">
                                                    <col>
                                                    <col width="100">
                                                    <col width="100">
                                                    <thead>
                                                        <tr class="headings">
                                                            <th class=" no-link"><span class="nobr2">关键词</span></th>
                                                            <th class=" no-link"><span class="nobr2">搜索结果数</span></th>
                                                            <th class=" no-link last"><span class="nobr2">用户数</span></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $querys = SearchItem::model()->popular()->findAll();
                                                        foreach ($querys as $key => $query):
                                                        ?>
                                                            <tr class="<?php echo ($key % 2 == 0) ? 'even' : ''; ?>">
                                                                <td class="a-center"><?php echo $query->search_query; ?></td>
                                                                <td class="a-center"><?php echo $query->search_result; ?></td>
                                                                <td class="a-center last"><?php echo $query->search_user; ?></td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>

                                        </fieldset>
                                    </div>
                                </td>
                                <!-- right start -->
                                <td>
                                    <div class="entry-edit">
                                        <div class="entry-edit-head">
                                            <h4>
                                                <select name="" class="required-entry required-entry input-select" style="width:150px;" id="statisticsSale">
                                                    <option value="1">最近24小时内销售</option>
                                                    <option value="2">最近1周内销售</option>
                                                    <option value="3">最近1月内销售</option>
                                                    <option value="4">最近3月内销售</option>
                                                    <option value="5">最近半年内销售</option>
                                                </select>
                                            </h4>
                                        </div>
                                        <fieldset class="a-center bold">
                                            <span class="nowrap" style="font-size:18px;color:#2F2F2F"><span class="price" id="statisticsSalePrice"><?php echo '$' . Order::getStatisticSale(1); ?></span></span>
                                        </fieldset>
                                    </div>

                                    <div style="border: 1px solid rgb(204, 204, 204);" class="entry-edit">
                                        <div style="margin: 20px;">
                                            <!--  -->
                                            <ul class="tabs-horiz" id="index_grid_tab">
                                                <li>
                                                    <a class="tab-item-link active" title="Bestsellers" id="sell_products" href="#">
                                                        <span><span title="The information in this tab has been changed." class="changed"></span><span title="This tab contains invalid data. Please solve the problem before saving." class="error"></span>畅销</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="tab-item-link ajax notloaded" title="Most Viewed Products" id="view_products" href="#">
                                                        <span><span title="The information in this tab has been changed." class="changed"></span><span title="This tab contains invalid data. Please solve the problem before saving." class="error"></span>最多浏览</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="tab-item-link ajax notloaded" title="Most Viewed Products" id="review_products" href="#">
                                                        <span><span title="The information in this tab has been changed." class="changed"></span><span title="This tab contains invalid data. Please solve the problem before saving." class="error"></span>最多评论</span>
                                                    </a>
                                                </li>

                                            </ul>

                                            <div id="grid_tab_content">
                                                <div class="content_col" id="sell_products_content">
                                                    <div class="grid np">
                                                                        <table cellspacing="0" id="productsOrderedGrid_table" style="border: 0pt none;">
                                                                            <col>
                                                                            <col width="80">
                                                                            <col width="80">
                                                                            <thead>
                                                                                <tr class="headings">
                                                                                    <th class=" no-link"><span class="nobr2">商品名</span></th>
                                                                                    <th class=" no-link"><span class="nobr2">售价</span></th>
                                                                                    <th class=" no-link last"><span class="nobr2">成交量</span></th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                <?php
                                                                $popular = ProductStatistic::model()->popular(10)->findAll();
                                                                foreach ($popular as $key => $product):
                                                                ?>
                                                                    <tr class="<?php echo ($key % 2 == 0) ? 'even' : ''; ?>">
                                                                        <td>
                                                                            <a href="<?php echo '/backend/product/update/id/' . $product->product_id; ?>">
                                                                            <?php echo $product->product->product_name; ?>
                                                                        </a>
                                                                    </td>
                                                                    <td><?php echo '$'.$product->product->product_base_price; ?></td>
                                                                    <td><?php echo $product->product_buyed; ?></td>
                                                                </tr>
                                                                <?php endforeach; ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                        </div>
                                        <div style="display: none;" class="content_col" id="view_products_content">
                                            <div class="grid np">
                                                <table cellspacing="0" id="productsOrderedGrid_table" style="border: 0pt none;">
                                                    <col>
                                                    <col width="80">
                                                    <col width="80">
                                                    <thead>
                                                        <tr class="headings">
                                                            <th class=" no-link"><span class="nobr2">商品名</span></th>
                                                            <th class=" no-link"><span class="nobr2">售价</span></th>
                                                            <th class=" no-link last"><span class="nobr2">浏览数</span></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $viewed = ProductStatistic::model()->viewed(10)->findAll();
                                                        foreach ($viewed as $key => $product):
                                                        ?>
                                                            <tr class="<?php echo ($key % 2 == 0) ? 'even' : ''; ?>">
                                                                <td>
                                                                    <a href="<?php echo '/backend/product/update/id/' . $product->product_id; ?>">
                                                                    <?php echo $product->product->product_name; ?>
                                                                </a>
                                                            </td>
                                                            <td><?php echo '$'.$product->product->product_base_price; ?></td>
                                                            <td><?php echo $product->product_viewed; ?></td>
                                                        </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div style="display: none;" class="content_col" id="review_products_content">
                                            <div class="grid np">
                                                <table cellspacing="0" id="productsOrderedGrid_table" style="border: 0pt none;">
                                                    <col>
                                                    <col width="80">
                                                    <col width="80">
                                                    <thead>
                                                        <tr class="headings">
                                                            <th class=" no-link"><span class="nobr2">商品名</span></th>
                                                            <th class=" no-link"><span class="nobr2">售价</span></th>
                                                            <th class=" no-link last"><span class="nobr2">评论数</span></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $viewed = ProductStatistic::model()->reviewed(10)->findAll();
                                                        foreach ($viewed as $key => $product):
                                                        ?>
                                                            <tr class="<?php echo ($key % 2 == 0) ? 'even' : ''; ?>">
                                                                <td>
                                                                    <a href="<?php echo '/backend/product/update/id/' . $product->product_id; ?>">
                                                                    <?php echo $product->product->product_name; ?>
                                                                </a>
                                                            </td>
                                                            <td><?php echo '$'.$product->product->product_base_price; ?></td>
                                                            <td><?php echo $product->product_reviewed; ?></td>
                                                        </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
            <!-- right end -->
        </tr>
    </tbody>
</table>
<script type="text/javascript">
    $('#statisticsSale').change(function(){
        $.post('/backend/default/getSalePrice',{'id':$(this).val()},function(data){
            $('#statisticsSalePrice').html(data);
        });
    });
</script>
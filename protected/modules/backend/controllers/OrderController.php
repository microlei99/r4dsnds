<?php

class OrderController extends BackendController
{
    public $menu_active = 1;

	public function actionIndex()
	{
		$this->htmlOption=array('class'=>'icon-head head-products','header'=>"订单列表");

        $model = new Order();

        if(isset($_GET['Order']))
        {
            $model->attributes = $_GET['Order'];
            $model->customer_name = $_GET['Order']['customer_name'];
            $model->paypal_txnid = $_GET['Order']['paypal_txnid'];
            $model->customer_email = $_GET['Order']['customer_email'];
        }
		$this->render('index',array('model'=>$model));
	}

    public function actionView()
    {
        $this->htmlOption = array('class' => 'icon-head head-products', 'header' => "订单详细");

        $model = $this->_load_model();
        if(!$ship = OrderShip::model()->findByAttributes(array('ship_order_id'=>$model->order_id))){
            $ship = new OrderShip();
        }

        if (isset($_POST['Order']))
        {
            $model->order_status = $_POST['Order']['order_status'];
            if ($model->order_status == Order::Shipped)
            {
                $day = Config::item('ship', 'cycle');
                $ship->ship_order_id = $model->order_id;
                $ship->ship_start_at = date('Y-m-d H:i:s');
                $ship->ship_end_at = date('Y-m-d H:i:s', strtotime("+$day day"));
                $ship->ship_from = 'China';
                $ship->ship_to = $model->order_address_id;
                $ship->ship_code = str_replace(' ','',$_POST['OrderShip']['ship_code']);
                
                if($ship->save()){
                    $model->order_ship_id = $ship->ship_id;
                }
            }

            if($model->order_status == Order::PaymentAccepted)
            {
                $model->order_export = 0;
            }

            $model->save(false);

            if (!$history = OrderHistory::model()->findByAttributes(array('history_order_id' => $model->order_id)))
            {
                $history = new OrderHistory();
            }
            $history->history_employee_id = Yii::app()->user->getAdmin();
            $history->history_order_id = $model->order_id;
            $history->history_state = $model->order_status;
            $history->history_create = new CDbExpression("NOW()");
            $history->save();
            $history->informEmail($model->customer_id);
        }

        $script="$('#order_status').change(function(){
                     if($(this).val()==3){
                         $('#ship_code').show();
                      }else{
                          $('#ship_code').hide();
                      }
                 });";
        Yii::app()->clientScript->registerScript('ship_code',$script,  CClientScript::POS_READY);
        $this->render('view', array('model' => $model,'ship'=>$ship));
    }

    public function actionExport()
    {
        $this->htmlOption = array('class' => 'icon-head head-products', 'header' => "导出订单");
        Yii::import('application.vendors.*');
        require_once 'PHPExcel/PHPExcel.php';
        require_once 'PHPExcel/PHPExcel/IOFactory.php';
        $sql = "select t1.*,t2.*,t3.customer_email,t4.carrier_name,t5.response_txn_id
                from syo_order AS t1
                LEFT JOIN {{customer_address}} AS t2 ON t1.order_address_id=t2.address_id
                LEFT JOIN {{customer}} AS t3 ON t1.customer_id=t3.customer_id
                LEFT JOIN {{carrier}} AS t4 ON t1.order_carrier_id=t4.carrier_id
                LEFT JOIN {{paypal_response}} AS t5 ON t1.order_id=t5.order_id
                WHERE t1.order_valid=1 AND t1.order_status=".Order::PaymentAccepted." AND t1.order_export=0
                ORDER BY order_payment_at ASC";
        $orders = Yii::app()->db->createCommand($sql)->queryAll();
        if ($orders)
        {
            $orderPrefix = Config::item('system', 'order_export_prefix');
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', '订单编号')->setCellValue('B1', '数量')
                ->setCellValue('C1', '下单时间')->setCellValue('D1', '商品名')
                ->setCellValue('E1', 'SKU')->setCellValue('F1', '客户姓名')
                ->setCellValue('G1', '国家')->setCellValue('H1', '省/州')
                ->setCellValue('I1', '城市')->setCellValue('J1', '地址一')
                ->setCellValue('K1', '地址二')->setCellValue('L1', '邮编')
                ->setCellValue('M1', '电话')->setCellValue('N1', '货运方式')
                ->setCellValue("O1", 'Email')->setCellValue("P1", "交易号");
            $objPHPExcel->getActiveSheet(0)->setTitle('订单输出');
            $index = 2;
            foreach ($orders as $key => $order)
            {
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValueExplicit('A' . $index, '('.$orderPrefix.')'.$order['invoice_id'], PHPExcel_Cell_DataType::TYPE_STRING)
                    ->setCellValueExplicit('C' . $index, $order['order_create_at'], PHPExcel_Cell_DataType::TYPE_STRING)
                    ->setCellValueExplicit('F' . $index, $order['customer_firstname'] . ' ' . $order['customer_lastname'], PHPExcel_Cell_DataType::TYPE_STRING)
                    ->setCellValueExplicit('G' . $index, Country::item($order['address_country']), PHPExcel_Cell_DataType::TYPE_STRING)
                    ->setCellValueExplicit('H' . $index, $order['address_state'], PHPExcel_Cell_DataType::TYPE_STRING)
                    ->setCellValueExplicit('I' . $index, $order['address_city'], PHPExcel_Cell_DataType::TYPE_STRING)
                    ->setCellValueExplicit('J' . $index, $order['address_street'], PHPExcel_Cell_DataType::TYPE_STRING)
                    ->setCellValueExplicit('K' . $index, '', PHPExcel_Cell_DataType::TYPE_STRING)
                    ->setCellValueExplicit('L' . $index, $order['address_postcode'], PHPExcel_Cell_DataType::TYPE_STRING)
                    ->setCellValueExplicit('M' . $index, $order['address_phonenumber'], PHPExcel_Cell_DataType::TYPE_STRING)
                    ->setCellValueExplicit('N' . $index, $order['carrier_name'], PHPExcel_Cell_DataType::TYPE_STRING)
                    ->setCellValueExplicit('O' . $index, $order['customer_email'], PHPExcel_Cell_DataType::TYPE_STRING)
                    ->setCellValueExplicit('P' . $index, $order['response_txn_id'], PHPExcel_Cell_DataType::TYPE_STRING);

                $sql = "SELECT t1.*,t2.product_name AS pname,t2.product_sku FROM {{order_item}} as t1
                        LEFT JOIN {{product}} as t2 ON t1.item_product_id=t2.product_id
                        where t1.order_id={$order['order_id']}";
                $productList = Yii::app()->db->createCommand($sql)->queryAll();
                $i = 0;
                foreach ($productList as $row)
                {
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('B' . ($index + $i), $row['item_qty'])
                        ->setCellValueExplicit('D' . ($index + $i), $row['pname'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('E' . ($index + $i), $row['product_sku'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $i++;
                }
                $index += $i;
                $sql = "UPDATE {{order}} SET order_export=1, order_status=".Order::PreparationProgress." where order_id={$order['order_id']}";
                Yii::app()->db->createCommand($sql)->execute();
            }
            $objPHPExcel->setActiveSheetIndex(0);
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="OrderDump.xls"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
        }
        $this->render('export');
    }

    private function _load_model()
    {
        if (isset($_GET['id']))
        {
            $model = Order::model()->findByPk($_GET['id']);
        }
        if ($model == null)
        {
            throw new CHttpException(404, "The requested page does not exist!");
        }
        return $model;
    }
}
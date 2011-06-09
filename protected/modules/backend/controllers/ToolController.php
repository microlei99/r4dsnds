<?php

class ToolController extends BackendController
{
	public function actionImport()
	{
        $this->htmlOption = array(
            'class' => 'icon-head head-products',
            'header' => "批量载入",
        );
        $message = '';
        
        if(isset($_POST['yt0']) && isset($_FILES['uploadFile']))
        {
            $file = CUploadedFile::getInstanceByName('uploadFile');
            if ($file->extensionName == 'xls')
            {
                $filename = 'media/upload/product_' . date('Y-m-d') . '.' . $file->extensionName;
                $file->saveAs($filename);

                Yii::import('application.vendors.*');
                require_once 'PHPExcel/PHPExcel.php';
                require_once 'PHPExcel/PHPExcel/IOFactory.php';
                $reader = PHPExcel_IOFactory::createReader('Excel5'); // 读取 excel 文件
                $reader->setReadDataOnly(true);
                if($reader = $reader->load($filename))
                {
                    $data = $reader->getSheet(0)->toArray();
                    $data = array_filter(array_slice($data, 1));
                    $model = new ImportProduct();
                    $success = $model->verify($data);
                    if($success)
                    {
                        $model->save($data);
                        $objPHPExcel = new PHPExcel();
                        $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A1', '产品SKU')->setCellValue('B1', 'ID');
                        $objPHPExcel->getActiveSheet(0)->setTitle("产品ID");
                        $index = 2;
                        foreach($model->productsID as $id => $sku)
                        {
                            $objPHPExcel->setActiveSheetIndex(0)
                                ->setCellValueExplicit('A' . $index, $sku, PHPExcel_Cell_DataType::TYPE_STRING)
                                ->setCellValueExplicit('B' . $index, $id, PHPExcel_Cell_DataType::TYPE_STRING);
                            $index++;
                        }
                        header('Content-Type: application/vnd.ms-excel');
                        header('Content-Disposition: attachment;filename="id.xls"');
                        header('Cache-Control: max-age=0');
                        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                        $objWriter->save('php://output');
                    }
                    else{
                        $message = $model->errorMessage;
                    }
                }
            }
            else{
                $message = '文件格式只能为xls';
            }
        }
		$this->render('import',array('message'=>$message));
	}

    public function actionGenerateImage()
    {
        $productImagesID = Yii::app()->db->createCommand("SELECT DISTINCT image_product_id FROM {{product_image}}")->queryColumn();
        $sql = 'SELECT product_id,product_name FROM {{product}} AS t1 where t1.product_active=0 AND
                t1.product_id NOT IN ('.implode(',',$productImagesID).')';
        $message = '没有产品图片需要生成';
        $productsID = Yii::app()->db->createCommand($sql)->queryAll();
        if(!empty($productsID))
        {
            $model = new ImportProduct();
            foreach($productsID as $row){
                $model->productsID[$row['product_id']] = $row['product_name'];
            }

            $message = $model->saveImage();
            $message = $message ? $message : '生成图片成功';
        }
        $this->render('import',array('message'=>$message));
    }

    public function actionImportWholesale()
    {
        $this->htmlOption = array('
                    class' => 'icon-head head-products', 'header' => "导入批发",
            );

        if(isset($_POST['yt0']) && isset($_FILES['uploadFile']))
        {
            $file = CUploadedFile::getInstanceByName('uploadFile');
            if ($file->extensionName == 'xls')
            {
                $filename = 'media/upload/product_wholesale_' . date('Y-m-d') . '.' . $file->extensionName;
                $file->saveAs($filename);
                Yii::import('application.vendors.*');
                require_once 'PHPExcel/PHPExcel.php';
                require_once 'PHPExcel/PHPExcel/IOFactory.php';
                $reader = PHPExcel_IOFactory::createReader('Excel5'); // 读取 excel 文件
                $reader->setReadDataOnly(true);
                $reader = $reader->load($filename);
                if($reader)
                {
                    $message = '';
                    $qty = array();
                    $data = $reader->getSheet(0)->toArray();

                    $index = 2;
                    $end = $data[1][$index];
                    while($end != '#')
                    {
                        $down = $data[1][$index];
                        $up = ($data[1][$index+1] != '#') ? $data[1][$index+1]-1 : 1000;
                        $qty[$down.'_'.$up]['index'] = $index;
                        $end = $data[1][++$index];
                    }

                    foreach ($data as $row => $item)
                    {
                        if (!empty($item) && $row > 1)
                        {
                            $message .= '第'.$row.'行';
                            $model = Product::model()->findByAttributes(array('product_sku'=>$item[1]));
                            if($model)
                            {
                                
                                //从数据库读取批发区间，检查重复
                                $sql = 'SELECT wholesale_id,CONCAT(wholesale_product_interval1,"_",wholesale_product_interval2) AS qty_interval'
                                        .' FROM {{wholesale}}'
                                        ." WHERE wholesale_product_id={$model->product_id}";
                                $wholesales = Yii::app()->db->createCommand($sql) ->queryAll();

                                foreach($wholesales as $wholesale)
                                {
                                    if(array_key_exists($wholesale['qty_interval'], $qty)){
                                        Yii::app()->db->createCommand("DELETE FROM {{wholesale}} WHERE wholesale_id=".$wholesale['wholesale_id'])->execute();
                                    }
                                }
                                unset($wholesales,$wholesale);

                                
                                foreach($qty as $key => $q)
                                {
                                    $wholesale = new Wholesale();
                                    $wholesale->wholesale_active = 1;
                                    $wholesale->wholesale_type = 1;
                                    $wholesale->wholesale_product_id = $model->product_id;
                                    $wholesale->wholesale_product_price = substr(sprintf("%.10f", $item[$q['index']]), 0, -8);
                                    list($wholesale->wholesale_product_interval1,$wholesale->wholesale_product_interval2) = explode('_',$key);
                                    $wholesale->wholesale_product_percent = 0;
                                    if($wholesale->save()){
                                        $message .= '导入成功<br>';
                                    }
                                    else{
                                        $message .= '导入失败<br>';
                                    }
                                }
                                
                            }
                            else{
                                $message .= 'SKU{'.$item[1].'}对应商品不存在<br>';
                            }
                        }
                    }
                }
            }
            else{
                $message = '文件格式只能为xls';
            }
        }
        $this->render('import',array('message'=>$message));
    }
}
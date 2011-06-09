<?php

class ShoppingcartController extends Controller {

    public $layout = 'column1';

    public function actionIndex() {
        //Yii::app()->cart->removeAll();exit;

        $this->breadcrumbs = array('Shoppingcart');

        $items = $this->_get_cart_state();
        Yii::app()->user->setState('cart', $items);

        $priceSummury = array(
            'subtotal' => Yii::app()->cart->getCost(),
            'discount' => Yii::app()->cart->getDiscount(),
            'total' => Yii::app()->cart->getCost(true),
        );
        Yii::app()->user->setState('priceSummury', $priceSummury);

        $this->_registerJsScript('/script/shoppingcart.js');
        $this->render('index', array(
            'cart' => $items,
            'priceSummury' => $priceSummury,
            'symbol' => Currency::getCurrencySymbol(),
        ));
    }

    public function actionAddtocart() {
        if (isset($_GET['qty']) && preg_match('/^\d*$/', $_GET['qty']) && $_GET['qty'] > 0) {
            $qty = $_GET['qty'];
            $model = $this->_load_model();
            $option = $this->_load_option(true);
            $key = $this->_get_key($model, $option);

            $addqty = $qty;
            if ($itemOfCart = Yii::app()->cart->itemAt($key)) {
                $addqty = $qty + $itemOfCart['item']->getQuantity();
            }

            $message = $this->_detect_stock($addqty, $model);
            if (!$message) {
                $message = 'The product ' . $model->product_name . ' add to shopping cart successfully';
                Yii::app()->cart->put($model, $option, $qty);

                $this->_update_db_cart($qty, array(
                    'product_id' => $model->product_id,
                    'option_id' => ($option == null) ? 0 : $option->getID(),
                ));
                ProductStatistic::Statistic($model->product_id, array('carted' => 1));
            }

            Yii::app()->user->setFlash('cartMessage', $message);
        }
        $this->redirect('/shoppingcart');
    }

    public function actionUpcart() {
        if (Yii::app()->request->isPostRequest && isset($_POST['qty']) && is_array($_POST['qty'])) {

            $error = true;
            foreach ($_POST['qty'] as $key => $qty) {
                if (preg_match('/^\d*$/', $qty) && $qty >= 1) {
                    if ($itemOfCart = Yii::app()->cart->itemAt($key)) {
                        $id = explode('-', $key);
                        $model = $this->_load_model(intval($id[0]));
                        $option = $this->_load_option(true);
                        $upqty = $qty;
                        $message = $this->_detect_stock($upqty, $model);
                        if (!$message) {
                            Yii::app()->cart->update($itemOfCart, $upqty);
                            $this->_update_db_cart($upqty, array(
                                'product_id' => $model->product_id,
                                'option_id' => ($option == null) ? 0 : $option->getID(),
                                    ), true);
                            $error = false;
                        }
                    }
                }
            }

            if (!$error) {
                Yii::app()->user->setFlash('cartMessage', 'Product Quantity Update Successfully.');
            }
        }

        $this->redirect('/shoppingcart');
    }

    public function actionRemove() {
        if (isset($_GET['cid'])) {
            $key = $_GET['cid'];
            $id = explode('-', $key);
            $model = $this->_load_model(intval($id[0]));
            $option = $this->_load_option(true);
            $key = $this->_get_key($model, $option);
            Yii::app()->cart->remove($key);
            $this->_remove_db_cart(array(
                'product_id' => $id[0],
                'option_id' => ($option == null) ? 0 : $option->getID(),
            ));
            $message = 'delete item successfully.';
            Yii::app()->user->setFlash('cartMessage', $message);
        }

        $this->redirect('/shoppingcart');
    }

    public function actionAjaxRemove() {
        if (Yii::app()->request->isAjaxRequest) {
            $key = $_POST['cid'];
            $id = explode('-', $key);
            $model = $this->_load_model(intval($id[0]));
            $option = $this->_load_option(true);
            $key = $this->_get_key($model, $option);
            Yii::app()->cart->remove($key);
            $this->_remove_db_cart(array(
                'product_id' => $id[0],
                'option_id' => ($option == null) ? 0 : $option->getID(),
            ));
            $symbol = Currency::getCurrencySymbol();
            $priceSummury = array(
                'subtotal' => $symbol . Yii::app()->cart->getCost(),
                'discount' => $symbol . Yii::app()->cart->getDiscount(),
                'total' => $symbol . Yii::app()->cart->getCost(true),
            );
            echo CTreeView::saveDataAsJson($priceSummury);
        }
    }

    private function _update_db_cart($qty, $data=array(), $upflage=false) {
        if (!empty($data)) {
            if (!Yii::app()->user->isGuest) {
                $customerID = Yii::app()->user->getId();
                $cart = Cart::model()->findByAttributes(array(
                            'product_id' => $data['product_id'],
                            'attribute_id' => $data['option_id'],
                            'customer_id' => $customerID
                        ));
                if ($cart) {
                    if ($upflage) {
                        $cart->product_qty = $qty;
                    } else {
                        $cart->product_qty+=$qty;
                    }
                    $cart->saveAttributes(array('product_qty'));
                } else {
                    $cart = new Cart();
                    $cart->customer_id = $customerID;
                    $cart->product_id = $data['product_id'];
                    $cart->attribute_id = $data['option_id'];
                    $cart->product_qty = $qty;
                    $cart->save();
                }
            }
        }
    }

    private function _remove_db_cart($data=array()) {
        if (!empty($data)) {
            if (!Yii::app()->user->isGuest) {
                Cart::model()->deleteAllByAttributes(array(
                    'product_id' => $data['product_id'],
                    'attribute_id' => $data['option_id'],
                    'customer_id' => Yii::app()->user->getId(),
                ));
            }
        }
    }

    private function _detect_stock($qty, $model) {
        if (is_object($model) && get_class($model) == 'Product') {
            $message = '';
            // In Stock
            if ($model->product_stock_status == Product::IN_STOCK) {
                if ($qty < $model->product_stock_cart_min) {
                    $message = 'Sorry,the product ' . $model->product_name . ' quantity can\'t less than ' . $model->product_stock_cart_min . '.';
                }
                if ($model->product_stock_cart_max != -1 && $qty > $model->product_stock_cart_max) {  // -1 means the product has no max limitation
                    $message = 'Sorry,the product ' . $model->product_name . ' quantity can\'t more than ' . $model->product_stock_cart_max . '.';
                }
            } else {
                $message = 'Sorry,the product ' . $model->product_name . ' has alreday out of stock.';
            }
        } else {
            $message = 'Sorry,there is an error occured,please contact our customer service.';
        }

        return $message;
    }

    private function _get_key($item, $option) {
        return $option === null ? $item->getID() . '-0' : $item->getID() . '-' . $option->getID();
    }

    private function _get_cart_state() {
        $items = array();
        $currency = Currency::getCurrency();
      
            foreach (Yii::app()->cart->getCart() as $key => $item) {
                $items[$key]['name'] = $item['item']->product_name;
                $items[$key]['qty'] = $item['item']->getQuantity();
                $items[$key]['url'] = $item['item']->getUrl();
                $items[$key]['simage'] = $item['item']->baseimage->getImage('_small');
                $items[$key]['option'] = $item['option'] == null ? '' : $item['option']->attrvalue->attribute_value;
                $items[$key]['orig_price'] = Product::decoratePrice($item['item']->getPrice('orig'), true, $currency);
                if ($wholesale = $item['item']->isWholesaleActive($items[$key]['qty'])) {
                    $items[$key]['price'] = Product::decoratePrice($item['item']->getPrice('wholesale', $wholesale['wholesale_id']), false, $currency);
                } else {
                    $items[$key]['price'] = Product::decoratePrice($item['item']->getPrice('promotion'), false, $currency);
                }
            }
         
   
        return $items;
    }

    private function _load_model($id=0) {
        if (isset($_GET['pid'])) {
            $model = Product::model()->findByPk($_GET['pid']);
        } else if ($id != 0) {
            $model = Product::model()->findByPk($id);
        } elseif (isset($_GET['product'])) {
            $model = Product::model()->findByAttributes(array('product_url' => $_GET['product']));
        }

        if ($model == null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    private function _load_option($optional=false, $id=0) {
        if ($optional) {
            return null;
        }

        $model = ProductAttribute::model()->findByPk(isset($_GET['aid']) ? $_GET['aid'] : $id);
        if ($model == null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
    }

}
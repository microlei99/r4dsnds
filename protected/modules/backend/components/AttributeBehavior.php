<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class AttributeBehavior extends CBehavior
{

    public function validateAttributes($attributes)
    {
        $attr['error'] = true;
        foreach ($attributes as $key => $value)
        {
            if ($value[0] != '')
            {
                $v = AttributeValue::item($key);
                $flip = array_flip($v);
                foreach (explode(',', $value[0]) as $item)
                {
                    $attr[$key]['value'] .= $item . ',';
                    $attr[$key]['valueID'] .= $flip[$item] . ',';
                }

                $attr[$key]['value'] = substr($attr[$key]['value'], 0, -1);
                $attr[$key]['valueID'] = substr($attr[$key]['valueID'], 0, -1);
            }
            else
            {
                $attr[$key]['error'] = $attr[$key]['attribute'] . '不能为空';
                $attr['error'] = false;
            }
        }
        return $attr;
    }
    
    public function compareAttributes($attributes,$productID)
    {
        $attrValue = Yii::app()->db->createCommand("SELECT attribute_id,attribute_value_id FROM {{product_attribute}} WHERE attribute_product_id={$productID}")->queryAll();
        foreach ($attrValue as $key){
            $old[$key['attribute_id']][] = $key['attribute_value_id'];
        }

        $comparedAttribute = array();
        foreach ($attributes as $key => $value)
        {
            $arr = explode(',', $value['valueID']);
            $interdiff = array_merge(array_diff($arr, $old[$key]), array_diff($old[$key], $arr));
            if ($interdiff)
            {
                foreach ($interdiff as $j)
                {
                    if (in_array($j, $arr)){
                        $comparedAttribute['add'][$key][] = $j;
                    }
                    else if (in_array($j, $old[$key])){
                        $comparedAttribute['sub'][$key][] = $j;
                    }
                }
            }
        }
        return $comparedAttribute;
    }

}

?>

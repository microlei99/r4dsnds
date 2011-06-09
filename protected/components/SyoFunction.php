<?php
/**
 * 通用函数集
 */

function randomName($length=10,$prefix='')
{
    $char = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
    $max = strlen($char) - 1;
    mt_srand((double) microtime() * 1000000);
    for ($i = 0; $i < $length; $i++) {
        $prefix .= $char[mt_rand(0, $max)];
    }
    return $prefix;
}

function hashPwd($pwd,$prefix='syo_'){
    return md5($prefix.$pwd);
}

function fixedPrice($price){
    return floatval(substr(sprintf("%.10f", $price), 0, -9));
}

function getCurrencySymbol($code=false)
{
    switch(getCurrency())
    {
        case 1:
            $symbol = $code ? 'USD':'$';
            break;
        case 2:
            $symbol = $code ? 'CNY':'￥';
            break;
        case 3:
            $symbol = $code ? 'EUR':'€';
            break;
        case 4:
            $symbol = $code ? 'GBP':'￡';
            break;
        case 5:
            $symbol = $code ? 'CAD':'$';
            break;
        case 6:
            $symbol = $code ? 'AUD':'$';
            break;
        default :
            $symbol = $code ? 'USD':'$';
    }
    return $symbol;
}
?>

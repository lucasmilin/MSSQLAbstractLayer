<?php

/**
 * Created by Version10.
 */
namespace MSSQLAbstractLayer\Helper;

/**
 * Class CharsetHelper
 * @package MSSQLAbstractLayer\Helper
 */
class CharsetHelper
{
    /**
     * @param $array
     * @return mixed
     */
    public static function utf8Converter($array = array())
    {
        if(!empty($array) && $array != null) {
            array_walk_recursive($array, function(&$item, $key){
                if(!mb_detect_encoding($item, 'utf-8', true)){
                    $item = utf8_encode($item);
                }
            });
        }

        return $array;
    }
}
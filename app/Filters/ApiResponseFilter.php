<?php

namespace App\Filters;

abstract class ApiResponseFilter {

    // A list of remappable attributes
    protected $remapAttrs = [];
    
    /* Transforms snake_case to camelCase
    *
    *
    * @params array $post
    * @return array $post
    */
    function transform($arr) {
        foreach($this->remapAttrs as $key=>$newKey) {
            if(array_key_exists($key, $arr)) {
                $arr[$newKey] = $arr[$key];
                unset($arr[$key]);
            }
        }
        return $arr;
    }
}
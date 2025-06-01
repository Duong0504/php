<?php
$sessionKey =  Session::isInvalid();
$error = Session::flash($sessionKey.'_errors');
$old   = Session::flash($sessionKey.'_old');
// function thông báo error
if(!function_exists('form_error')){
    function form_error($fieldName, String $before = '', String $after = '')
    {  
        global $error;
        if(!empty($error) && array_key_exists($fieldName, $error)){
            if(!empty($before) && !empty($after)){
                return $before.$error[$fieldName].$after;
            }else{
                return '<span style="color:red; font-style:italic">'.$error[$fieldName].'</span>';
            }
        }else{
            return false;
        }
    }
}

if(!function_exists('old_form')){
    function old_form($fieldName){
        global $old;
        if(!empty($old[$fieldName])){
            return $old[$fieldName];
        }
        return false;
    }
}


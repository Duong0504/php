<?php
/**
 * Sau khi thực hiện việc j đó thì đưa tới 1 tranh nhất định
 */

 class Response {
     public function redirect($uri=''){
         if(preg_match('~^(http|https)~is', $uri)){
             $url = $uri;
         }else {
             $url = _WEB_ROOT.'/'.$uri;
         } 
         header('Location:'.$url);
         exit();
     }
 }
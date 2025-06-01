<?php
/*
    data($key, $value) => set session
    data($key) => get session
*/
class Session {
    static public function data($key='', $value='') {
        $sessionKey = self::isInvalid();
        if(!empty($value) && !empty($key)){
            $_SESSION[$sessionKey][$key] =  $value;
            return true;
        }else{
            if(empty($key)){
                if(isset($_SESSION[$sessionKey])){
                    return $_SESSION[$sessionKey];
                }
            }else{
                if(isset( $_SESSION[$sessionKey][$key])){
                    return $_SESSION[$sessionKey][$key];
                }
            }
        }
        return false;
    }
    /*
        delete($key) => delete session theo key
        delete() => delete toàn bộ session
    */
    static public function delete($key=''){
        $sessionKey = self::isInvalid();
        if(!empty($key)){
            if(isset($_SESSION[$sessionKey][$key])){
                unset($_SESSION[$sessionKey][$key]);
                return true;
            }
            return false;
        }else {
            unset($_SESSION[$sessionKey]);
            return true;
        }
        return false;
    }
    static public function flash($key, $value=''){
        $dataFlash = self::data($key, $value);
        if(empty($value)){
            self::delete($key);
        }
        return $dataFlash;
    }
    static public function showErrors($messages){
         App::$app->loadErrors('exception', $messages);
         die();
    }

    static public function isInvalid(){
        global $config;
        if(!empty($config['session'])){
            $sessionConfig =  $config['session'];
            if(!empty($sessionConfig['session_key'])){
                $sessionKey = $sessionConfig['session_key'];
                return $sessionKey;
            }else {
                self::showErrors('Thiếu cấu hình session_key');
            }
        }else {
           self::showErrors('Thiếu cấu hình session');
        }
        return false;
    }
}
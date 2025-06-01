<?php
// Request : Browser => Routes => Controller
// + Import model   => 
class Request {
    private $__rules = [], $__message = [], $errors = [];
    public $dbRequest;
    public function __construct()
    {
        $this->dbRequest = new Database;
    }
    public function getMethod()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function isPost(){
        if($this->getMethod() == "post"){
            return true;
        }
        return false;
    }

    public function isGet() {
        if($this->getMethod() == 'get'){
            return true;
        }
        return false;
    }

    public function getFields(){
        $dataFileds = [];
        if($this->isGet()){
            if(!empty($_GET)){
                foreach($_GET as $key=>$value){
                    if(is_array($value)){
                        $dataFileds[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                    }else{
                        $dataFileds[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                }
            }
        }
        if($this->isPost()){
            if(!empty($_POST)){
                foreach($_POST as $key=>$value){
                    if(is_array($value)){
                        $dataFileds[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                    }else{
                        $dataFileds[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                    }   
                }
            }
        }
        return $dataFileds;
    }

    public function rules($rules=[]) {
        $this->__rules = $rules; 
    }
    public function message($message= []){
        $this->__message = $message;
    }

    public function validate(){
        $this->__rules = array_filter($this->__rules);
        $checkValidate = true;
        if(!empty($this->__rules)){
            $dataFileds = $this->getFields();       
            foreach($this->__rules as $fieldName => $fieldValue){
                $ruleItemArr  = explode('|', $fieldValue);
                foreach($ruleItemArr as $item){
                    $ruleName = null;
                    $ruleValue = null;
                    $ruleArr =  explode(':', $item);
                    $ruleName = reset($ruleArr);
                    if(count($ruleArr)>1){
                        $ruleValue = end($ruleArr);
                    }
                    if(count($ruleArr) > 2){
                        $ruleTable = $ruleArr[1];
                    }
                    // echo 'field: '. $fieldName. ' name: '.$ruleName . '+ giá trị: '. $ruleValue. '<br/>';
                    if($ruleName == 'required'){
                        if(empty($dataFileds[$fieldName])){
                            $this->setError($fieldName, $ruleName);
                            $checkValidate = false;
                        } 
                    }
                    if($ruleName == 'min'){
                        if(mb_strlen(trim($dataFileds[$fieldName]), 'utf8') < $ruleValue){
                            $this->setError($fieldName, $ruleName);
                            $checkValidate = false;
                        }
                    } 
                    if($ruleName == 'max'){
                        if(mb_strlen(trim($dataFileds[$fieldName]), 'utf8') > $ruleValue){
                            $this->setError($fieldName, $ruleName);
                            $checkValidate = false;
                        }
                    }
                    if($ruleName == 'email'){
                        if(!filter_var($dataFileds[$fieldName], FILTER_VALIDATE_EMAIL)){
                            $this->setError($fieldName, $ruleName);
                            $checkValidate = false;
                        }
                    }
                    if($ruleName == 'match'){
                        if(trim($dataFileds[$fieldName]) != trim($dataFileds[$ruleValue])){
                            $this->setError($fieldName, $ruleName);
                            $checkValidate = false;
                        }
                    }
                    if($ruleName == 'unique'){
                        $tableName =  null;
                        $fieldCheck = null;
                        if(!empty($ruleArr[1])){
                            $tableName = $ruleArr[1];
                        }
                        if(!empty($ruleArr[2])){
                            $fieldCheck = $ruleArr[2];
                        }
                        if(!empty($tableName) && !empty($fieldCheck)){
                            if(count($ruleArr) == 3){
                               $sql = "SELECT * FROM $tableName WHERE $fieldCheck = '$dataFileds[$fieldCheck]'"; 
                               $data = $this->dbRequest->getRows($sql);
                            }else if(count($ruleArr) == 4) {
                                if(!empty($ruleArr[3]) && preg_match('~.+?\=.+?~is',$ruleArr[3])){
                                    $conditionWhere =  $ruleArr[3];
                                    $conditionWhere = str_replace('=', '<>', $conditionWhere);
                                    $sql = "SELECT * FROM $tableName WHERE $fieldCheck = '$dataFileds[$fieldCheck]' AND $conditionWhere"; 
                                    $data = $this->dbRequest->getRows($sql);
                                }
                            }
                            if($data > 0){
                                $this->setError($fieldName, $ruleName);
                                $checkValidate = false;
                            }
                        }
                    }
                    // callback
                    if(preg_match('~^callback_(.+)~is', $ruleName, $callbackArr)){   
                        if(!empty($callbackArr[1])){
                            $callbackName = $callbackArr[1];
                            $controller = App::$app->getCurrentController();
                            if(method_exists($controller, $callbackName)){
                                $checkCallback = call_user_func_array([$controller, $callbackName], [trim($dataFileds[$fieldName])]);
                                if(!$checkCallback){
                                    $this->setError($fieldName, $ruleName);
                                    $checkValidate = false;
                                }
                            }
                        }
                    }
                }
            }
        }
        if(!$checkValidate){
            // set luôn flashdata ở validate
            $sessionKey = Session::isInvalid();
            Session::flash($sessionKey.'_errors', $this->error());
            Session::flash($sessionKey.'_old', $this->getFields());
        }
        return $checkValidate;
    }
    public function error($fieldName=''){
        if(!empty($this->errors)){
            if(empty($fieldName)){
                $errorArr = [];
                foreach($this->errors as $key=>$error) {
                    $errorArr[$key] =  reset($error);
                }
                return $errorArr;
            }
            return reset($this->errors[$fieldName]);
        }
        return false;
    }
    public function setError($fieldName, $ruleName)
    {
        $this->errors[$fieldName][$ruleName] = $this->__message[$fieldName.'.'.$ruleName];
    }
}

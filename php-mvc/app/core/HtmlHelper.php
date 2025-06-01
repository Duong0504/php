<?php
// Custom Class
class HtmlHelper {
    static function formOpen($method ='get', $action=''){
        echo '<form action="'.$action.'" method="'.$method.'">'; 
    }
    
    static function formClose(){
        echo '</form>';
    }
    static function input($wrapperBefor= '', $wrapperAfter='',$type='text', $name, $value ='', $class='', $id='', $placeholder='', $required='false'){
        echo $wrapperBefor;
        echo '<input type="'.$type.'" name="'.$name.'" value="'.$value.'" id="'.$id.'" placeholder="'.$placeholder.'" class="'.$class.'">';
        echo $wrapperAfter;
    }
    static function button($type='',$lable='', $class= false){
        echo '<button type="'.$type.'" class="'.$class.'">'.$lable.'</button>';
    }
}
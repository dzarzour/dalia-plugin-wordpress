<?php
/**
 * @package daliaplugin
 */
namespace Inc\Api\Callbacks;
use Inc\Base\BaseController;
class MangerCallbacks extends BaseController{

   
    public function checkboxSanitize($input){

        //return filter_var($input,FILTER_SANITIZE_NUMBER_INT);
       // return (isset($input)?true:false);
       $output=array();
       foreach($this->mangers as $key->$value){
           $output[$key]=isset ($input[$key])?true:false;
          // echo $output;
       }
       return $output;
    }
    public function adminSectionManger(){
        echo "Manger Settings Sections By activating  checkboxs from following list";
    }
    public function checkboxField($args){

        $name    =$args['label-for'];
        $class   =$args['class'];
        $option_name=$args['option_name'];
        $checkbox=get_option($option_name );
        $checked=isset($checkbox[$name])?($checkbox[$name]?true:false) :false;
        
        echo '<div class="'.$class.'"><input type="checkbox"  id="'.$name.'"  name="'.$option_name.'['.$name.']'.'" value="1" class=" " '.($checked?"checked" :" ").'><label for="'.$name.'"><div></div></label></div>';
       
    }
   

}
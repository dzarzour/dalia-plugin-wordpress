<?php 
/**
 * @package daliaplugin
 */
namespace Inc\Base;
class  BaseController
{
    public $plugin_path;

    public $mangers=array();
    public function __construct(){
        $this->plugin_path=plugin_dir_path( dirname( __FILE__ ,2) );
        $this->plugin_url=plugin_dir_url( dirname( __FILE__ ,2) );
        $this->plugin=plugin_basename( dirname( __FILE__ ,3) )."/dalia-plugin.php";

        $this->mangers=array(
            'cpt_manager'           =>'Activate CPT Manger',
            'taxonomy_manger'      =>'Activate Taxonomy Manger',
            'widget_manger'        =>'Activate Widget Manger',
            'gallery_manager'       =>'Activate Gallery Manger',
            'testimonial_manager'   =>'Activate Testimonial Manger',
            'templates_manager'     =>'Activate Templates Manger',
            'login_manager'         =>'Activate Login Manger',
            'membership_manager'    =>'Activate Membership Manger',
            'chat_manger'          =>'Activate Chat Manger',



        );
        
    }
    public function activated( string $key){
        $option=get_option( 'dalia_plugin');
        
       // return isset($option[$key])?:false;
        //return isset( $option[ $key ] ) ? $option[ $key ] : false;
        

		return isset( $option[ $key ] ) ? $option[ $key ] : false;

    }
    
}


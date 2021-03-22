<?php
/**
 * @package daliaplugin */ 
namespace Inc\Base;


class Activate{
    public static function activate(){
        flush_rewrite_rules();

        $default=array();
        if(! get_option( 'dalia_plugin')){
            update_option( 'dalia_plugin', $default );
        }
        if( !get_option( 'dalia_plugin_cpt')){
            update_option( 'dalia_plugin_cpt', $default );
        }
        
      
    }

}

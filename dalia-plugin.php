<?php 
/**
 * Plugin Name:       Dalia Plugin
 * Plugin URI:        https://eng-dalia.sy/
 * Description:       the plugin was developed by dalaia.
 * Version:           1.0/0
 * Author:            Dalia Zarzour
 * Author URI:        https://eng-dalia.sy/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       dalia-plugin
 */
defined( 'ABSPATH' ) or die('Hey , what are you doing here ? you are selly man');

if(file_exists(dirname(__FILE__).'/vendor/autoload.php')){
    require_once dirname(__FILE__).'/vendor/autoload.php';
}

//define('PLUGIN_PATH',plugin_dir_path( __FILE__ ));
//define('PLUGIN_URL',plugin_dir_url(__FILE__ ));
//define('PLUGIN',plugin_basename( __FILE__ ));
if(class_exists('Inc\\Init')){
    Inc\Init::register_services();
}


use Inc\Base\Activate;
use Inc\Base\Deactivate;
/**
 * plugin Activation
 */
function activate_dalia_plugin(){
    Activate::activate();
}
/**
 * plugin deactivation
 */
function deactivate_dalia_plugin(){
    Deactivate::deactivate();
}
register_activation_hook( __FILE__, 'activate_dalia_plugin' );
register_deactivation_hook( __FILE__, 'deactivate_dalia_plugin' );

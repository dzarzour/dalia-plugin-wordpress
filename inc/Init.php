<?php 
/**
 * @package daliaplugin
 */

 namespace Inc;

 class Init{
     /**
      * Store all the classes inside an array
      * @return array full list of classes
      */

    public static function get_services(){
        return array(
            pages\Dashboard::class,
            Base\Enqueue::class,
            Base\SettingsLinks::class,
            Base\BaseController::class,
            Base\CustomPostTypeController::class,
            Base\CustomTaxonomyController::class,
            Base\AuthController::class,
            Base\ChatController::class,
            Base\GalleryController::class,
            Base\MembershipController::class,
		 	Base\WidgetController::class,
			Base\TestimonialController::class,
			Base\TemplateController::class,
			
			
			

        );
    }
     /**
      * Initialize the class
      *
      * @param //class  $class class from the service array 
      * @return //class instance  new instance of the class
      */
      private static function instantiate($class){
        $service =new $class;
        return $service;

    }
    /**
     * loop through the classes ,initialize them,and call the register ()method if it exists
     *
     * @return 
     */
     public static function register_services(){
            foreach (self::get_services() as $class){
                $service=self::instantiate($class);
                if(method_exists($service,'register')){
                    $service->register();
                }
            }
     } 
    

 }



 /*
 
use Inc\Base\Activate;
use Inc\Base\deactivate;
use INC\Pages\AdminPges;
class DaliaPlugin {

    public $plugin;

    function __construct(){
        $this->plugin= plugin_basename( __FILE__ );
        add_action( 'init', array($this,'custom_post_type') );
    }
    function register(){
        add_action( 'admin_enqueue_scripts', array($this, 'enqueue') );
        add_action( 'admin_menu', array($this,'add_admin_pages') );
       
        add_filter( "plugin_action_links_$this->plugin", array($this,'settings_link') );
        echo $this->plugin;
    }
    public function settings_link($link){
        //add custom settings link
        $settings_link='<a href="admin.php?page=dalia_plugin">Settings</a>';
        array_push($link,$settings_link);
        return $link;


    }
    public function add_admin_pages(){
        add_menu_page( 'Dalia Plugin', 'Dalia', 'manage_options', 'dalia_plugin', array($this,'admin_index'), 'dashicons-store', 110 );
    }
    public function admin_index(){
        require_once plugin_dir_path( __FILE__ ).'templates/admin.php';
    }

    function activate(){
        //generate CPT
        $this->custom_post_type();
        Activate::activate();
    }
    //function deactivate(){
      //  Deactivate::deactivate();
    //}
    function uninstall(){
        //Delete CPT
        //DELETE ALLTHE PLUGIN DATA FROM DB
    }
    function custom_post_type(){

        register_post_type( 'book', array('public' =>true, 'label'=>'BOOKS') );
     
    }

    function enqueue(){
        wp_enqueue_style( 'mypluginstyle', plugins_url( '/assets/mystyle.css', __FILE__ ), array(), false, 'all' );
        wp_enqueue_script( 'mypluginscript',plugins_url( '/assets/myscript.js', __FILE__ ));
        
    }
    
}

if(class_exists('DaliaPlugin')){
    $daliaPlugin=new DaliaPlugin();
    $daliaPlugin->register();
}

//  activation

register_activation_hook( __FILE__, array($daliaPlugin,'activate') );
//  deactivation
register_deactivation_hook( __FILE__, array('Deactivate','deactivate') );
//  Uninstall

 


*/
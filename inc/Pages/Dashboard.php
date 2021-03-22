<?php 
/**
 * @package  daliaPlugin
 */
namespace Inc\Pages;


use \Inc\Api\SettingsApi;
use \Inc\Base\BaseController;
use \Inc\Api\Callbacks\AdminCallbacks;
use \Inc\Api\Callbacks\MangerCallbacks;

/**
* 
*/
class Dashboard extends BaseController
{
	public $settings;
	public $callbacks;
	public $MangerCallbacks;

    public $pages = array();
   // public $subpages = array();

	public function register() 
	{
		$this->settings 		= new SettingsApi();
		$this->callbacks		=new AdminCallbacks();
		$this->callbacks_mngr   =new MangerCallbacks(); 


		$this-> setPages();
	//	$this-> setSubPages();

		$this->setSettings();
		$this->setSections();
		$this->setFields();
        $this->settings->addPages( $this->pages )->withSubPage('Dashboard')->register();
        
	}
	public function  setPages(){

		
		$this->pages = array(
			array(
				'page_title' => 'dalia Plugin', 
				'menu_title' => 'dalia', 
				'capability' => 'manage_options', 
				'menu_slug' => 'dalia_plugin', 
				'callback' =>  array($this->callbacks,'adminDashboard'), 
				'icon_url' => 'dashicons-store', 
				'position' => 110
            ),
            
        );
        
        

	}
	/*public function setSubPages(){
		$this->subpages = array(
			array(
				'parent_slug' => 'dalia_plugin', 
				'page_title' => 'Custom Post Types', 
				'menu_title' => 'CPT', 
				'capability' => 'manage_options', 
				'menu_slug' => 'dalia_cpt', 
				'callback' => array($this->callbacks, 'adminCpt'),
			),
			array(
				'parent_slug' =>'dalia_plugin', 
				'page_title' => 'Custom Taxonomies', 
				'menu_title' => 'Taxonomies', 
				'capability' => 'manage_options', 
				'menu_slug' => 'dalia_taxonomies', 
				'callback' => array($this->callbacks, 'adminTaxonomy'),
			),
			array(
				'parent_slug' => 'dalia_plugin', 
				'page_title' => 'Custom Widgets', 
				'menu_title' => 'Widgets', 
				'capability' => 'manage_options', 
				'menu_slug' => 'dalia_widgets', 
				'callback' =>array($this->callbacks, 'adminWidget'),
			)
        );

	}
	*/
	public function setSettings(){
		$args=array(	
				array(
				'option_group'    =>'dalia_plugin_settings',
				'option_name'     =>'dalia_plugin',
				'callback'        =>array($this->callbacks_mngr,'checkboxSanitize')
				)
		);

	/*	$args=array();
		foreach($this->mangers as  $key =>$value ){
			$args[]=array(
				'option_group'    =>'dalia_plugin_settings',
				'option_name'     =>$key,
				'callback'        =>array($this->callbacks_mngr,'checkboxSanitize')
			);
			
		}
	*/
		
		$this->settings->setSettings($args);
	}
	public function setSections(){
		$args=array(
			array(
				'id'          => 'dalia_admin_index',
				'title'       => 'Settings Manger',
				'callback'    => array($this->callbacks_mngr, 'adminSectionManger'),
				'page'        =>'dalia_plugin'
			)
			
		);
		$this->settings->setSections($args);
	}

	public function setFields(){
		$args=array();
		foreach($this->mangers as $key =>$value){
			$args[]=array(
				'id'       => $key,
				'title'    =>$value,
				'callback' =>array($this->callbacks_mngr,'checkboxField'),
				'page'     =>'dalia_plugin',
				'section'  =>'dalia_admin_index',
				'args'     =>array(
					'option_name' =>'dalia_plugin',
					'label-for'   =>  $key,
					'class'       => 'ui-toggle'
						)
				);

		}

		$this->settings->setFields($args);
		
	}
}
<?php 
/**
 * @package daliaplugin
 */
namespace Inc\Base;
use \Inc\Api\settingsApi;
use \Inc\Base\BaseController;
use \Inc\Api\Callbacks\AdminCallbacks;

class CustomTaxonomyController extends BaseController{
    public $settings;
    public $callbacks;
    public $subpages=array();

    public function register(){
        
        if(  ! $this->activated( 'taxonomy_manger' )) return;
        $this->settings    =new settingsApi();
        $this->callbacks   =new AdminCallbacks();
        $this->setSubpages();

        $this->settings->addSubPages($this->subpages)->register();

    }
    public function setSubPages(){
        $this->subpages=array(
            array(
                'parent_slug'    => 'dalia_plugin',
                'page_title'     => 'Taxonomy ',
                'menu_title'     => 'Taxonomy Manger',
                'capability'     => 'manage_options', 
                'menu_slug'      =>'dalia_taxonomy',
                'callback'       =>array($this->callbacks,'adminTaxonomy'),

            )
        );
    }
}
<?php
/**
 * @package daliaplugin
 */
namespace Inc\Api\Callbacks;

use Inc\Base\BaseController;
 class TestimonialCallbacks extends BaseController{
    public function shortcaodePage(){
        return require_once("$this->plugin_path/templates/testimonial.php");
    }
 }
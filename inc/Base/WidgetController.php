<?php 
/**
 * @package  daliaPlugin
 */
namespace Inc\Base;

use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Widgets\MediaWidget;

/**
* 
*/
class WidgetController extends BaseController
{
	public $media_widget;

	public function register()
	{
		if ( ! $this->activated( 'widget_manger' ) ) return;

		$media_widget =new MediaWidget();
		$media_widget->register();
	}

	
}
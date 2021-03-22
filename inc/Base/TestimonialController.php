<?php 
/**
 * @package  daliaPlugin
 */
namespace Inc\Base;

use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\TestimonialCallbacks;

/**
* 
*/
class TestimonialController extends BaseController
{
	public $settings;
	public $callbacks;
	public function register()
	
	{

		
		if ( ! $this->activated( 'testimonial_manager' ) ) return;
		$this->settings=new settingsApi();
		$this->callbacks=new TestimonialCallbacks();

		add_action(	'init',array($this,'testimonial_cpt'));
		add_action( 'add_meta_boxes', array($this,'dalia_add_meta_boxes'));	
		add_action('save_post',array($this,'save_meta_box'));
		add_action('manage_testimonial_posts_columns',array($this,'set_custom_columns'));
		add_action('manage_testimonial_posts_custom_column',array($this,'set_custom_column_data'),10,2);
		add_filter('manage_edit-testimonial_sortable_columns',array($this,'set_custom_columns_sortable'));
		
		$this->setShortPage();
	}

	public function setShortPage(){

		$subPage=array(
			array(
				'parent_slug'    =>   'edit.php?post_type=testimonial',
				'page_title'     =>'ShortCode',
				'menu_title'     =>'ShortCode',
				'capability'     =>'manage_options',
				'menu_slug'      =>'dalia_testimonial_shortcode',
				'callback'       =>array($this->callbacks,'shortcaodePage'),
			)


		);

		$this->settings->addSubPages($subPage)->register();		

		add_shortcode( 'testimonial-form', array($this,'testimonial_form') );
		add_shortcode('testimonial-slideshow', array($this,'testimonial_slideshow'));
		add_action('wp_ajax_submit_testmionial',array($this, 'submit_testmionial' ));
		add_action( 'wp_ajax_nopriv_submit_testmionial',array($this, 'submit_testmionial' ));


	}

	public function submit_testmionial(){

		if(! DOING_AJAX || !check_ajax_referer( 'testimonial-action', 'nonce' )){
			return $this->return_json('error');
		}
		
		//sanitize th data
		$name	=sanitize_text_field( $_POST['name'] );
		$email	=sanitize_email( $_POST['email'] );
		$message=sanitize_textarea_field( $_POST['message'] );

		//store the data  into testimonial cpt
		$data=array(
			'name'   	=>$name,
			'email'  	=>$email,
			'message'	=>$message,
			'approved'  =>0,
			'featured'  =>0
		);
		$args=array(

			'post_title'   =>'from :'. $name,
			'post_content' =>$message,
			'post_type'    =>'testimonial',
			'post_author'  =>1,
			'post_status'  =>'publish',
			'meta_input'   =>array(
				'_dalia_testimonial_key'  => $data  
			)

		);


		$postID=wp_insert_post( $args);
		if( $postID){
			return $this->return_json('success');
		}
		return $this->return_json('error');


		//send response
		wp_die();
	}
	public function return_json($status) {
		$return=array(
			'status'    => $status,
		);
		wp_send_json( $return);
		wp_die();

	}
	public function testimonial_slideshow(){
		wp_enqueue_style( 'mypluginstyle', $this->plugin_url .'assets/mystyle.css', __FILE__ );
		ob_start();
		require_once("$this->plugin_path/templates/slider.php");
		echo "<script src=\"$this->plugin_url/assets/slider.js\"></script>";
		
		return ob_get_clean();

	}

	public function testimonial_form(){
		wp_enqueue_style( 'mypluginstyle', $this->plugin_url .'assets/mystyle.css', __FILE__ );
		ob_start();
		require_once("$this->plugin_path/templates/contact-form.php");
		echo "<script src=\"$this->plugin_url/assets/form.js\"></script>";
		
		return ob_get_clean();

	}

	public function testimonial_cpt(){
		$labels=array(
			'name'      	=>'Testimonials',
			'singular_name' =>'testimonial',

		);

		$args=array(
			'labels'     	=>$labels,
			'public'    	=>true,
			'has_Archived'  =>false,
			'menu_icon'     =>'dashicons-testimonial',
			'exclude_from_search'=>true,
			'publicly_queryable' =>false,
			'support'            =>array('title','editor'),




		);
		register_post_type( 'testimonial', $args );
	}

	public function dalia_add_meta_boxes(){
		add_meta_box( 
			'testimonial_author', 
			'Testimonial Options',
			array($this,'render_features_box'),
			'testimonial',
			'side',
			'default', 
		);

	}
	public function render_features_box($post){
		//AUTHOR
		wp_nonce_field( 'dalia_testimonial', 'dalia_testimonial_nonce' );
		$data=get_post_meta( $post->ID, '_dalia_testimonial_key', true );
		$name=isset($data['name'])?$data['name']:'';
		$email=isset($data['email'])?$data['email']:'';
		$approved=isset($data['approved'])?$data['approved']:false;
		$featured=isset($data['featured'])?$data['featured']:false;
		//author name	
		?>	
		<p>
			<label class="meta-label "for="dalia_testimonial_author"> Author </label>
			<input type="text" name="dalia_testimonial_author" id="dalia_testimonial_author" class="widefat"value="<?php echo esc_attr( $name );?>">
		</p>
		<?php

		//EMAIL
		?>
		<p>
			<label class="meta-label"for="'dalia_testimonial_email'">Email</label>
			<input type="email" name="dalia_testimonial_email" id="'dalia_testimonial_email'" class="widefat" value= "<?php echo esc_attr( $email ); ?>">
		</p>
		<div class="meta-container">
			<label class="meta-label w-50 text-left "for="dalia_testimonial_approved">Approved</label>
			<div class="text-right w-50 inline">
				<div class="ui-toggle inline"><input type="checkbox" id="dalia_testimonial_approved" name="dalia_testimonial_approved" value="1" <?php echo $approved ? 'checked' : ''; ?>>
					<label for="dalia_testimonial_approved"><div></div></label>
				</div>
			</div>	
		</div>	
		<div class="meta-container">
			<label class="meta-label w-50 text-left" for="dalia_testimonial_featured">Featured</label>
			<div class="text-right w-50 inline">
				<div class="ui-toggle inline"><input type="checkbox" id="dalia_testimonial_featured" name="dalia_testimonial_featured" value="1" <?php echo $featured ? 'checked' : ''; ?>>
					<label for="dalia_testimonial_featured"><div></div></label>
				</div>
			</div>	
		<?
		
	}
	public function save_meta_box($post_id){

		if(!isset($_POST['dalia_testimonial_nonce'])){
			return $post_id;
		}
		
		$nonce=$_POST['dalia_testimonial_nonce'];
		if(! wp_verify_nonce( $nonce, 'dalia_testimonial' )){
			return $post_id;
		}
		

		if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){
			return $post_id;
		}
		if( !current_user_can( 'edit_post', $post_id )){
			return $post_id;
		}
		$data=
		array(
			'name'     =>sanitize_text_field( $_POST['dalia_testimonial_author'] ),
			'email'	   =>sanitize_text_field( $_POST['dalia_testimonial_email'] ),
			'approved' => isset($_POST['dalia_testimonial_approved']) ? 1 : 0,
			'featured' => isset($_POST['dalia_testimonial_featured']) ? 1 : 0,
		
		);
		
		update_post_meta( $post_id,'_dalia_testimonial_key',$data );
	}

	public function set_custom_columns($columns){
	
		$title=$columns['title'];
		$date=$columns['date'];
		unset($columns['title'],$columns['date']);
		
		$columns['name']='Author name';
		$columns['title']=$title;
		$columns['approved']='Approved';
		$columns['featured']='Featured';
		$columns['date']=$date;
		return $columns;
	}
	public function set_custom_column_data($column,$post_id){
		$data=get_post_meta( $post_id, '_dalia_testimonial_key', true );
		$name=isset($data['name'])?$data['name']:'';
		$email=isset($data['email'])?$data['email']:'';
		$approved=isset($data['approved']) && $data['approved']===1?'<strong>YES</strong>':'NO';
		$featured=isset($data['featured']) && $data['featured']===1?'<strong>YES</strong>':'NO';
		
		switch ($column) {
			case 'name':
				echo '<strong>'.$name.'</strong><br><a href="mailto">'.$email.'</a>';
				break;
			case 'approved':
				echo $approved;
				break;	
			case 'featured':
				echo $featured;
				break;	
				

			
			default:
				# code...
				break;
		}

	}
	public function set_custom_columns_sortable($columns){
		$columns['name']='name';
		$columns['approved']='approved';
		$columns['featured']='featured';

		return $columns;
	}

}





<?php
/**
 * @package daliaplugin
 */
?>
<div class="warp">
    <h1>CPT MANGER</h1>
    <?php settings_errors() ;?>
    <ul class="nav nav-tabs">
		<li class="active"><a href="#tab-1">Manage custom post type</a></li>
		<li><a href="#tab-2">Add new custom post type</a></li>
		<li><a href="#tab-3">Export</a></li>
	</ul>

    <div class="tab-content">
        <div id="tab-1" class="tab-pane active">
            <h3>Manage custom post type</h3>
                
            <?php
            
                $options=get_option( 'dalia_plugin_cpt');
               echo  $options['plural_name'];
              // echo  $options['post_Type'];
            //  var_dump($options);
                //foreach($options as $option){
                  
                   
                
            ?>
        
        
        
        
        
        
        </div>





        <div id="tab-2" class="tab-pane">
            <form method="post" action="options.php">
            <?php 
            settings_fields( 'dalia_plugin_cpt_settings' );
            do_settings_sections( 'dalia_cpt' );
            submit_button();
            
            ?>
        
        
        </form>
		</div>
        <div id="tab-3" class="tab-pane">
			<h3>Export</h3>
		</div>



    </div>










   
</div>
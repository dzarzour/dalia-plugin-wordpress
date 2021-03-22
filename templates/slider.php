
<?php 

$args=array(

    'post_status'   =>'publish',
    'post_type'     =>'testimonial',
    'posts_per_page' => 5,
    'meta_query'    =>array(
        array(
            'key'       =>'_dalia_testimonial_key',
            'compare'   =>'LIKE',
            'value'     => 's:8:"approved";i:1;s:8:"featured";i:1;'         
        )
    )

);


$query=new WP_Query($args);

if($query->have_posts()): 

    echo "<ul>";
    while($query->have_Posts()):
    $query->the_post();

    echo '<li>'. get_the_title().'<p>'.get_the_content().'</p></li>';
    endwhile;
    echo "</ul>";
endif;

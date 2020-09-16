<?php
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
function my_theme_enqueue_styles() {
 
    $parent_style = 'twentyseventeen'; // This is 'twentyfifteen-style' for the Twenty Fifteen theme.
 
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
}

//Start Custom Code for Random Tag Clouds
add_filter( 'tag_cloud_sort', 'shuffle_tags', 10, 2 );
function shuffle_tags( $tags, $args ) {
    shuffle( $tags );
    return $tags;
}
//End Custom Code for Random Tag Clouds

//Start Custom code for 3 widget footer
function twentyseventeen_child_setup() {
	
	add_action( 'widgets_init', 'twentyseventeen_child_widgets_init' );

}
function twentyseventeen_child_widgets_init() {

	register_sidebar(
		array(
			'name'          => __( 'Footer 3', 'twentyseventeen' ),
			'id'            => 'sidebar-4',
			'description'   => __( 'Add widgets here to appear in your footer.', 'twentyseventeen' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'after_setup_theme', 'twentyseventeen_child_setup' );
//End Custom Code for 3 widget footer
?>

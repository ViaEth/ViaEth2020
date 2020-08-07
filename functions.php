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

//Start Custom Code for a Random Endpoints
function random_endpoint() {
	    add_rewrite_endpoint( 'random', EP_ROOT );
}
add_action( 'init', 'random_endpoint' );
function random_redirect() {
// If we have accessed our /random/ endpoints.
$post_type = get_query_var( 'random' );
if ( $post_type == '' ) {
	$post_type = [ 'post', 'page', 'product' ];
}
$query_string = "";
$arr = explode("?",$_SERVER['REQUEST_URI']);
if (count($arr) == 2){
	$query_string = "?".end($arr);
}
if ( get_query_var( 'random', false ) !== false ) {
	// Get a random post.
	$random_post = get_posts( [
            'numberposts' => 1,
            'post_type'   => $post_type,
            'orderby'     => 'rand',
        ] );
        // If we found one.
        if ( ! empty( $random_post ) ) {
            // Get its URL.
            $url = esc_url_raw( get_the_permalink( $random_post[0] ) );
            // Escape it.
            $url = esc_url_raw($url.$query_string);
            // Redirect to it.
            wp_safe_redirect( $url, 302 );
            exit;
        }
    }
}
add_action( 'template_redirect', 'random_redirect' );
//End Custom Code for a Random Endpoints

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

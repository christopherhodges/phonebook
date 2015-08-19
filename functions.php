<?PHP

################################
#	START people
################################
function spark_register_people() {

	$cpt_single = 'Person';
	$cpt_plural = 'People';
	$cpt_icon = 'dashicons-nametag';
	$rewrite =  array('slug' => 'people', 'with_front' => true);
	$exclude_from_search = true;

	// Admin Labels
  	$labels = array(
            'name'               => __( $cpt_plural,                                'spark' ),
            'singular_name'      => __( $cpt_single,                                'spark' ),
            'add_new'            => __( 'Add New '.$cpt_single,                     'spark' ),
            'add_new_item'       => __( 'Add New '.$cpt_single,                     'spark' ),
            'edit_item'          => __( 'Edit '.$cpt_single,                        'spark' ),
            'new_item'           => __( 'New '.$cpt_single,                         'spark' ),
            'all_items'          => __( 'All '.$cpt_plural,                         'spark' ),
            'view_item'          => __( 'View '.$cpt_single.' Page',                'spark' ),
            'search_items'       => __( 'Search '.$cpt_plural,                      'spark' ),
            'not_found'          => __( 'No '.$cpt_plural.' found',                 'spark' ),
            'not_found_in_trash' => __( 'No '.$cpt_plural.' found in the Trash',    'spark' ),
            'parent_item_colon'  => '',
            'menu_name'          => $cpt_plural
        );

  	// Arguments
	$args = array(
        'labels'        	  => $labels,
        'description'   	  => __('Manage '.$cpt_plural,                      'spark'),
        'public'        	  => true,
        'menu_position' 	  => 10,
        'hierarchical'		  => true,
        'supports'      	  => array( 'title', 'editor', 'page-attributes', 'thumbnail', 'excerpt' ),
        'has_archive'   	  => true,
        'menu_icon'			  => $cpt_icon,
        'rewrite'       	  => $rewrite,
        'exclude_from_search' => $exclude_from_search
    );

	// Just do it
	register_post_type( 'people', $args );
}

// Hook into the 'init' action
add_action( 'init', 'spark_register_people', 0 );

################################
#	END people
################################

function _scripts(){
	if (!is_admin()) {

		// Deregister WordPress jQuery
		wp_deregister_script('jquery');

		//wp_register_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js', array(), '1.11.1', false);
		wp_register_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js', array(), '2.1.0', false);
		wp_enqueue_script('jquery');

        // Google Font
		wp_register_style('font-css', '//fonts.googleapis.com/css?family=Montserrat:400,700', false, '1.0');
		wp_enqueue_style('font-css');

		// Main Stylsheet
		wp_register_style('css', get_stylesheet_directory_uri() . '/style.css', false, '1.0');
		wp_enqueue_style('css');


		// Main Scripts
		wp_register_script('scripts', get_stylesheet_directory_uri() . '/scripts.js', array('jquery'), '1.0', true);
		wp_enqueue_script('scripts');


        // Ajax URL
        wp_localize_script(
            'scripts',
            'localized_vars',
            array(
                'ajax_url' => 	admin_url( 'admin-ajax.php' )
            )
        );


	}
}

add_action('wp_enqueue_scripts','_scripts');



### AJAX
add_action( 'wp_ajax_phonebook_add_person', 'atlantic_phonebook_add_person' );
add_action( 'wp_ajax_nopriv_phonebook_add_person', 'atlantic_phonebook_add_person' );

function atlantic_phonebook_add_person() {

	$post = array(
				'post_type'    => 'people',
				'post_status'  => 'publish',
				'post_title'   => $_POST['last'] . ', ' . $_POST['first'],
				'post_content' => $_POST['phone']
			);

	// Create New Post
	$new_post = wp_insert_post( $post );

	echo $new_post;

	die();
}


add_action( 'wp_ajax_phonebook_remove_person', 'atlantic_phonebook_remove_person' );
add_action( 'wp_ajax_nopriv_phonebook_remove_person', 'atlantic_phonebook_remove_person' );

function atlantic_phonebook_remove_person() {

	wp_delete_post( $_POST['id'], true );

	echo "Deleted post id " . $_POST['id'];

	die();
}

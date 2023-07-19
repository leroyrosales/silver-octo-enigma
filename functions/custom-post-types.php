<?php

/**
 * Register Post Types
 * - Events
 * WordPress documentation: https://developer.wordpress.org/plugins/post-types/
 */

// if ( ! function_exists( 'fix_no_editor_on_posts_page' ) ) {
// 	/**
// 	 * Add the wp-editor back into WordPress after it was removed in 4.2.2.
// 	 *
// 	 * @param $post
// 	 * @return void
// 	 */
// 	function fix_no_editor_on_posts_page( $post ) {
// 		if ( get_option( 'page_for_posts' ) !== $post->ID )
// 			return;

// 		remove_action( 'edit_form_after_title', '_wp_posts_page_notice' );
// 		add_post_type_support( 'page', 'editor' );
// 	}
// 	add_action( 'edit_form_after_title', 'fix_no_editor_on_posts_page', 0 );
// }

function ig_grit_events_cpt() {

	// Events
	register_post_type( 'events',
		array(
			'labels' => array(
				'name' => 'Events',
				'singular_name' => 'Event',
				'add_new_item' => 'Add new Event',
				'all_items' => 'All Events',
				'edit_item' => 'Edit Event',
				'new_item' => 'New Event',
				'view_item' => 'View Event',
				'search_items' => 'Search Events',
				'not_found' => 'No Events found',
				'not_found_in_trash' => 'No Events found in Trash',
			),
			'show_in_rest' => true,
			'rewrite' => true,
			'public' => true,
			'has_archive' => false,
			'menu_position' => 5,
			'menu_icon' => 'dashicons-calendar-alt',  // https://developer.wordpress.org/resource/dashicons
			'supports' => array(
				'title',
				'editor',
				'thumbnail',
			)
		)
	);
}
add_action( 'init', 'ig_grit_events_cpt' );

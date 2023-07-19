<?php

// Theme enqueues and dequeues

// 01/30/2023 -- Re-enabling jQuery for Customizer API
// Dequeue core jquery
// add_action( 'wp_enqueue_scripts', function(){
// 	if ( is_admin() ) return; // don't dequeue on the backend
// 	wp_dequeue_script( 'jquery' );
// 	wp_deregister_script( 'jquery' );
// });

// Enqueues
function ig_grit_enqueues() {

	// Fonts
	wp_enqueue_style( 'Poppins', '//fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300&display=swap' );

	wp_enqueue_style( 'ig-grit-styles', get_template_directory_uri() . '/assets/dist/main.css', array(), microtime(), 'all' );
	wp_enqueue_script( 'ig-grit-scripts', get_template_directory_uri() . '/assets/dist/main.bundle.js', array( 'wp-blocks', 'wp-editor', 'wp-dom' ), microtime(), true );

}
add_action( 'wp_enqueue_scripts', 'ig_grit_enqueues' );

function ig_grit_gutenberg_scripts() {
	wp_enqueue_script( 'ig-grit-editor', get_stylesheet_directory_uri() . '/assets/admin/editor.js', array( 'wp-blocks', 'wp-dom' ), filemtime( get_stylesheet_directory() . '/assets/admin/editor.js' ), true );
}
add_action( 'enqueue_block_editor_assets', 'ig_grit_gutenberg_scripts' );

// Registers an editor stylesheet for the theme.
add_theme_support( 'editor-styles' );
add_editor_style( '/assets/admin/editor-styles.css' );

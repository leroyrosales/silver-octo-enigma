<?php

/**
 * Filter Timber Context
 *
 * @param  array $context
 * @return array $context
 */
add_filter( 'timber_context', function ( $context ) {

	// Primary Nav CTAs
	$context['primary_ctas'] = get_field( 'ctas', 'menu_2' );

	// Social Accounts
	$context['social_accounts'] = get_field( 'social_accounts', 'option' );

	// Is search query
	$context['is_search'] = is_search();

	// Is front page of site
	$context['is_front_page'] = is_front_page();

	$context['is_single'] = is_single();

	// Is contact page;
	$context['is_legal_page'] = is_page( array( 240, 3, 695 ) );

	// Is blog post
	$context['is_post'] = is_single() && 'post' == get_post_type();

	// Sidebar
	$context['sidebar'] = Timber::get_widgets('sidebar');

	// Is default template
	$context['default_template'] = is_page_template('default');

	// Post page link
	$context['page_for_posts_link'] = get_permalink( get_option('page_for_posts', true) );

	// Footer contact info
	$context['contact_email'] = get_field( 'contact_email', 'option' );
	$context['contact_phone'] = get_field( 'contact_phone', 'option' );
	$context['address'] = get_field( 'address', 'option' );

	// HubSpot Psortal ID embed
	$context['hubspot_portal_id'] = get_field( 'hubspot_portal_id', 'option' );

	// 404 copy
	$context['fourofour_copy'] = get_field( 'fourofour_copy', 'option' );

	return $context;


} );

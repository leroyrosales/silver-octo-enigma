<?php

/**
 * Adds functionality to Twig.
 *
 * @param \Twig\Environment $twig The Twig environment.
 * @return \Twig\Environment
 */

// Define the previous post
function ig_grit_get_previous_post() {
	$prev_post = get_previous_post();
	if ( ! $prev_post ) {
		return false;
	}
	$prev_post_title = $prev_post->post_title;
	$prev_post_permalink = get_permalink( $prev_post->ID );
	$prev_post_category = get_the_category( $prev_post->ID )[0]->name;
	$output = '<div class="prev-post-button flex flex-col h-full align-start items-start lg:grid lg:grid-cols-[25px_auto] gap-8 bg-off-white py-[22px] px-[30px] lg:px-[55px] lg:py-[64px] relative hover:bg-secondary"><i class="fal fa-long-arrow-left fa-2xl max-w-full"></i><div><span class="pt-[4px] pb-4 font-poppins uppercase not-italic text-[14px] lg:text-base block tracking-[.2em]">' . $prev_post_category . '</span><a class="inline no-underline gap-4 font-poppins not-italic text-[17px] lg:text-[40px]" href="' . $prev_post_permalink . '">' . $prev_post_title . '</a></div></div>';
	return $output;
}

// Define the next post
function ig_grit_get_next_post() {
	$next_post = get_next_post();
	if ( ! $next_post ) {
		return false;
	}
	$next_post_title = $next_post->post_title;
	$next_post_permalink = get_permalink( $next_post->ID );
	$next_post_category = get_the_category( $next_post->ID )[0]->name;
	$output = '<div class="next-post-button flex flex-col-reverse h-full justify-end lg:grid lg:grid-cols-[auto_25px] gap-8 bg-off-white py-[22px] px-[30px] lg:px-[55px] lg:py-[64px] relative hover:bg-secondary"><div><span class="pt-[4px] pb-4 font-poppins uppercase not-italic text-[14px] lg:text-base block tracking-[.2em]">' . $next_post_category . '</span><a class="inline no-underline gap-4 font-poppins not-italic text-[17px] lg:text-[40px]" href="' . $next_post_permalink . '">' . $next_post_title . '</a></div> <i class="fal fa-long-arrow-right fa-2xl max-w-full ml-auto"></i></div>';
	return $output;
}

add_filter( 'timber/twig', 'add_to_twig' );

function add_to_twig( $twig ) {
	// Adding a function.
	$twig->addFunction( new Timber\Twig_Function( 'ig_grit_get_previous_post', 'ig_grit_get_previous_post' ) );
	$twig->addFunction( new Timber\Twig_Function( 'ig_grit_get_next_post', 'ig_grit_get_next_post' ) );
	$twig->addFilter( new Timber\Twig_Filter( 'abbreviate_month', 'ig_grit_abbreviate_month' ) );
	$twig->addFunction( new Timber\Twig_Function( 'breadcrumbs', 'breadcrumbs' ) );

	return $twig;
}

// Blows up string like "April 27 - 28" and returns as "Apr. 27 - 28"
function ig_grit_abbreviate_month( $text ) {
	$parts = explode(' ', $text);
	$month = $parts[0];
	$dateRange = $parts[1] . ' ' . $parts[2] . ' ' . $parts[3];

	$abbreviateMonth = date('M', strtotime( $month )) . '.';
	return $abbreviateMonth . ' ' . $dateRange;
}


function breadcrumbs() {
	global $post;

	if( ! function_exists('yoast_breadcrumb') || ! $post ) { return; }

	if ( function_exists( 'yoast_breadcrumb' ) && ! is_front_page() ) {
		if ( $post ) {
			$parent_title = get_the_title( $post->post_parent );
			$parent_link = get_permalink( $post->post_parent );
		}

		// Desktop breadcrumbs
		if ( $post->post_parent || is_single() ) { ?>
			<section class="ig-breadcrumbs">
				<div class="wrapper">
					<?php yoast_breadcrumb( '<nav class="hidden xl:block" role="navigation" aria-label="breadcrumb">','</nav>' ); ?>
					<!-- Mobile breadcrumbs -->
					<nav class="text-left block xl:hidden" role="navigation" aria-label="breadcrumb">
						<?php
						if ( $post->post_parent && ! is_single() ) {
							echo '<a href="'. $parent_link .'"><i class="fal fa-angle-left"></i> See ' . $parent_title . '</a>';
						} elseif ( is_single() ) {
							echo '<a data-breadcrumbs-url="'. get_site_url() . '/' . get_the_category()[0]->slug .'"><i class="fal fa-angle-left"></i> See ' . get_the_category()[0]->name . '</a>';
						} ?>
					</nav>
				</div>
			</section>
		<?php }
	}
}

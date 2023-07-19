<?php
/**
 *
 * Shortcodes
 *
 */

// Events query shortcode
add_shortcode( 'ig_grit_events', 'ig_grit_events_query_events' );
function ig_grit_events_query_events( $atts ) {
	ob_start();

	global $paged, $post;

	$default = shortcode_atts( array(
		'num_of_events' => '9',
	), $atts );

	if ( get_query_var( 'paged' ) ) {
		$paged = get_query_var( 'paged' );
	} elseif ( get_query_var( 'page' ) ) {
		$paged = get_query_var( 'page' );
	} else {
		$paged = 1;
	}

	$date = new DateTime( date( 'Y-m-d g:i a' ), new DateTimeZone('UTC'));
	$date->setTimezone(new DateTimeZone('America/New_York'));

	$date_args = array(
		'post_type'      => 'events',
		'meta_key'       => 'date_and_time',
		'orderby'        => 'meta_value meta_value_num',
		'posts_per_page' => $default['num_of_events'],
		'order'          => 'ASC',
		'meta_query'     => array(
			array(
				'key'     => 'date_and_time',
				'compare' => '>=',
				'value'   => $date->format('Y-m-d H:i:s'),
				'type'    => 'DATE',
			),
		),
		'paged' => $paged,
	);

	$date_query = new WP_Query( $date_args );
	?>

	<ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 grid-rows-1 gap-8 py-16">
		<?php
		while ( $date_query->have_posts() ) : $date_query->the_post();

			// Get the custom fields
			$current_post_id = get_the_ID();
			$post_thumbnail_id     = get_post_thumbnail_id( $current_post_id );
			$post_thumbnail_srcset = wp_get_attachment_image_srcset( $post_thumbnail_id );
			$post_title = get_the_title( $current_post_id );
			$post_date = get_field( 'date_and_time', $current_post_id );
			$event_month = date( "M", strtotime( $post_date ) );
			$event_day = date( "j", strtotime( $post_date ) );
			$event_time = date( "g:i a", strtotime( $post_date ) );
			$post_thumbnail_alt = get_post_meta( get_post_thumbnail_id( $current_post_id ), '_wp_attachment_image_alt', true );

			?>

			<li class="flex flex-col gap-0">
				<figure class="grid isolate mb-0 max-h-[13.75rem]">
					<picture class="col-span-full row-span-full max-h-[13.75rem]">
						<img class="w-full h-full object-cover" srcset="<?php echo $post_thumbnail_srcset; ?>" alt="<?php echo $post_thumbnail_alt; ?>">
					</picture>
					<div class="col-span-full row-span-full p-4 ">
						<time class="bg-off-white align-middle rounded-full text-center font-sans leading-none w-24 h-24 flex flex-col justify-center bg-opacity-90">
							<span class="font-poppins text-base tracking-[.2rem] uppercase block"><?php echo $event_month; ?></span>
							<span class="font-poppins text-[3.125rem]"><?php echo $event_day; ?></span>
						</time>
					</div>
				</figure>
				<div class="bg-off-white p-8 flex flex-col h-full">
					<h2 class="text-[1.875rem]"><?php echo $post_title; ?></h2>
					<h3 class="h4 text-base"><?php echo $event_time; ?> EST</h3>
					<p class="mb-4"><?php echo get_the_excerpt( $current_post_id ); ?></p>
					<a class="text-white no-underline inline-block rounded-full mt-auto px-10 py-4 bg-primary font-poppins not-italic tracking-[.2em] uppercase border-solid border-2 border-primary hover:text-primary hover:bg-white w-max" href="<?php echo get_permalink( $current_post_id ); ?>">Sign Up</a>
				</div>

			</li>
		<?php endwhile; ?>
	</ul>

	<?php if ( $date_query->max_num_pages > 1 ) { ?>
		<nav class="pt-4">
			<div class="nav-previous"><?php previous_posts_link( '&laquo; Previous' ); ?></div>
			<div class="nav-next"><?php next_posts_link( 'Next &raquo;', $date_query->max_num_pages ); ?></div>
		</nav>
	<?php }
	wp_reset_postdata();

	return ob_get_clean();
}

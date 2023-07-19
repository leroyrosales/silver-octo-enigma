<?php
/**
 * Block Name: Culture Tap Card
 *
 * Description: Card view for Culture Tap blogroll.
 */

?>

<article class="flex flex-col py-2 md:py-8">
	<picture class="grid isolate overflow-hidden aspect-square">
		<?php echo get_the_post_thumbnail( '', 'large', array( 'class' => 'h-full w-full object-cover col-span-full row-span-full' ) ); ?>
		<?php if ( get_the_category()[0]->cat_name === 'Video' ) { ?>
			<div class="col-span-full row-span-full p-4">
				<svg class="" width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
					<circle cx="34" cy="30" r="18" fill="#192800"/>
					<path d="M30 0C13.4605 0 0 13.4605 0 30C0 46.5395 13.4605 60 30 60C46.5395 60 60 46.5395 60 30C60 13.4605 46.5395 0 30 0ZM23.8198 39.8056C25.1784 33.2636 25.1341 26.5887 23.7903 20.1871L40.6399 30L23.8198 39.7982V39.8056Z" fill="#FFFF00"/>
				</svg>
			</div>
		<?php } ?>
	</picture>
	<div class="py-4">
		<?php if ( has_category() ) { ?>
			<span class="text-[13px] lg:text-[16px] font-poppins uppercase tracking-[.2em] block pb-4"><?php echo get_the_category()[0]->cat_name; ?></span>
		<?php } ?>
		<h3 class="text-[35px] lg:text-[40px] pb-6 mb-0"><a class="font-poppins not-italic no-underline mb-0" href="<?php echo the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<?php the_excerpt(); ?>
		<a class="inline-block mt-4" href="<?php echo the_permalink(); ?>">Read More</a>
	</div>
</article>

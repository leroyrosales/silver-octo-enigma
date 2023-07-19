<?php

/* Template Name: Portfolio */

$context = Timber::context();
$timber_post     = new Timber\Post();
$context['post'] = $timber_post;

// Get all content fields
global $paged;
if (!isset($paged) || !$paged){
    $paged = 1;
}

$args = array(
    'posts_per_page' => 9,
    'paged' => $paged,
    'post_type' => 'projects',
);

$context['projects'] = new Timber\PostQuery($args);


Timber::render( 'page-portfolio.twig', $context );

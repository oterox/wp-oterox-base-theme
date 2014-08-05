<?php 
/**
 * index.php
 *
 * Main template file
 */
?>

<?php get_header(); ?>

<div class="main-content col-md-8" role="main">

<?php 
	if(have_posts()) : while(have_posts()) : the_post();
		get_template_part('content',get_post_format());
	endwhile;

	ox_paging_nav(); 

	else:
		get_template_part('content','none');
	endif;
?>
</div><!-- end main-content -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
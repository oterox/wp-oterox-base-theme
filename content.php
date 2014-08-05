<?php 
/**
  * content.php
  *
  * Default template for content
  */ 
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
	<?php 
		//If the post has a thumbnail and it's not password protected
		//display the thumbnail
		if(has_post_thumbnail() && !post_password_required()):?>
			<figure class="entry-thumbnail"><?php the_post_thumbnail(); ?></figure>
		<?php endif;
		
		//if single page, display the title
		//else display link
		if(is_single()): ?>
		<h1><?php the_title(); ?></h1>
	<?php else :?>
		<h1><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
	<?php endif; ?>

	<p class="entry-meta">
		<?php 
			ox_post_meta();
		?>
	</p>
	</header>

	<!-- Article content -->
	<div class="entry-content">
		<?php
		if(is_search())
			the_excerpt();
		else{
			the_content( __('Continue reading &rarr;','ox'));
			
			wp_link_pages();
		}
		?>
	</div><!-- end entry-content -->

	<footer class="entry-footer">
		<?php
			// If we have a single page and the author bio exists, display it
			if(is_single() && get_the_author_meta('description')){
				echo '<h2>' . __('Written by ', 'ox') . get_the_author() . '</h2>';
				echo '<p>' . the_author_meta('description') . '</p>';
			}
		?>
	</footer><!-- end entry-footer -->


</article>
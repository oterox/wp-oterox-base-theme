<?php 
/**
  * content-link.php
  *
  * Default template for post format link
  */ 
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>


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
		<p class="entry-meta">
			<?php 
				ox_post_meta();
			?>
		</p>
		<?php
			// If we have a single page and the author bio exists, display it
			if(is_single() && get_the_author_meta('description')){
				echo '<h2>' . __('Written by ', 'ox') . get_the_author() . '</h2>';
				echo '<p>' . the_author_meta('description') . '</p>';
			}
		?>
	</footer><!-- end entry-footer -->


</article>
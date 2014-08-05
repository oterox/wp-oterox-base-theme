<?php 
/**
  * content-quote.php
  *
  * Default template for post format Quote
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
	</footer><!-- end entry-footer -->


</article>
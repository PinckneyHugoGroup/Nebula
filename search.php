<?php
/**
 * The template for displaying Search Results pages.
 */

if ( !defined('ABSPATH') ){ //Redirect (for logging) if accessed directly
	header('Location: http://' . $_SERVER['HTTP_HOST'] . substr($_SERVER['PHP_SELF'], 0, strpos($_SERVER['PHP_SELF'], "wp-content/")) . '?ndaat=' . basename($_SERVER['PHP_SELF']));
	http_response_code(403);
	die();
}

do_action('nebula_preheaders');
get_header(); ?>

<section id="bigheadingcon">
	<div class="container title-desc-con">
		<div class="row">
			<div class="col">
				<?php if ( have_posts() ): ?>
					<h1 class="page-title">Search Results</h1>
					<p>
						Your search for <span class="search-term">"<?php echo get_search_query(); ?>"</span> returned
						<?php
							if ( file_exists(WP_PLUGIN_DIR . '/relevanssi') && $wp_query->found_posts ){ //If Relevanssi is enabled
								echo $wp_query->found_posts;
							} else {
								$search_results = new WP_Query("s=$s&showposts=-1");
								echo $search_results->post_count;
								wp_reset_query();
							}
						?>
						results.
					</p>
				<?php else: ?>
					<h1 class="page title">No Results Found</h1>
					<p>Your search for <span class="search-term">"<?php echo get_search_query(); ?>"</span> returned 0 results.</p>
					<script>
						ga('send', 'event', 'Internal Search', 'No Results', jQuery('#s').val(), {'nonInteraction': true});
					</script>
					<?php nebula()->append_visitor_data(array('no_search_results' => get_search_query()), false); ?>
				<?php endif; ?>

				<?php nebula()->append_visitor_data(array('internal_search' => get_search_query())); ?>
				<?php echo nebula()->search_form(); ?>
			</div><!--/cols-->
		</div><!--/row-->
	</div><!--/container-->

	<div id="breadcrumb-section" class="full inner dark">
		<div class="container">
			<div class="row">
				<div class="col">
					<?php nebula()->breadcrumbs(); ?>
				</div><!--/col-->
			</div><!--/row-->
		</div><!--/container-->
	</div><!--/breadcrumb-section-->
</section>

<?php get_template_part('inc/nebula_drawer'); ?>

<div id="content-section">
	<div class="container">
		<div class="row">
			<div class="col-md" role="main">
				<?php if ( have_posts() ): ?>
					<div id="searchresults">
						<?php get_template_part('loop', 'search'); ?>
					</div><!--/#searchresults-->
				<?php else: ?>
					<p>No search results.</p>
				<?php endif; ?>
			</div><!--/col-->
			<div class="col-md-3 <?php echo ( get_theme_mod('sidebar_position') === 'left' )? 'flex-first' : 'offset-md-1'; ?>" role="complementary">
				<?php get_sidebar(); ?>
			</div><!--/col-->
		</div><!--/row-->
	</div><!--/container-->
</div><!--/content-section-->

<?php get_footer(); ?>

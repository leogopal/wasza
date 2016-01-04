<?php /* Template Name: FAQ */
get_header(); ?>
	
	<div id="content" class="container">
		<div class="row">
			<div id="page" class="col-lg-9">
				<?php if ( function_exists('yoast_breadcrumb') ) {yoast_breadcrumb('<div id="breadcrumbs">','</div>');} ?>
				
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					<h1><?php the_title(); ?></h1>
					<div class="thecontent"><?php the_content(); ?></div>
				<?php endwhile; endif; ?>
				
				<div id="thefaqs">
					<?php $count=0; $thefaqs = get_posts('order=ASC&post_type=page&post_parent='.$post->ID.'&child_of='.$post->ID); foreach($thefaqs as $page) { ?>
						<div class="faqs">
							<h3><?php echo get_the_title($page->ID); ?></h3>
							
							<?php $questions = get_field('faq', $page->ID); foreach($questions as $q) { $count++;  ?>
								<div id="faq-<?php echo $count; ?>" class="aquestion thecontent">
									<h5><a href="#" data-answer="<?php echo $count; ?>"><?php echo $q['question']; ?></a> <span class="square"><i class="square-plus">&plus;</i><i class="square-minus">&minus;</i></span></h5>
									<div id="answer-<?php echo $count; ?>" class="answer collapse"><?php echo wpautop($q['answer']); ?></div>
								</div>
							<?php } ?>
						</div>
					<?php } ?>
				</div>
			</div><!-- page -->

			<?php get_sidebar(); ?>
		</div>
	</div><!-- content -->
	
<?php get_footer(); ?>

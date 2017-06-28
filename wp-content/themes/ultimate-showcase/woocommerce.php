<?php
/* Main page template */
get_header();
?>
	
		
		<div class="singlePage">
			<section class="titleArea">
				<div class="wrapper">
					<div class="container">
						<h1><?php the_title(); ?></h1>
					</div> <!-- container -->
				</div> <!-- wrapper -->				
			</section>
			<div class="clear"></div>
			<section class="panel">
				<div class="wrapper">
					<div class="container">
						<?php woocommerce_content(); ?>
					</div> <!-- container -->
				</div> <!-- wrapper -->
			</section>
		</div> <!-- singlePage -->	
		
		<div class="clear"></div>
		
<?php
get_footer();
?>		
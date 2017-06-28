<?php /* Footer */

$copyrightText = '&copy; ';
$copyrightText .= date('Y');
if (get_option("EWD_UPCP_Theme_Copyright_Text_Label") == "") {$Copyright_Text_Label = $copyrightText;}
else {$Copyright_Text_Label = get_option("EWD_UPCP_Theme_Copyright_Text_Label");}
?>

		<div class="clear"></div>

		<section class="panel blackPanel" id="footer">
			<div class="wrapper">
				<div class="container">
					<?php if ( dynamic_sidebar('footer_widget') ) : else : endif; ?>
				</div> <!-- container -->
			</div> <!-- wrapper -->			
		</section> <!-- footer -->

		<div class="clear"></div>

		<section class="panel blackPanel" style="padding: 32px 0;">
			<div class="wrapper">
				<div class="container">
					<div class="copyright"><?php echo esc_html($Copyright_Text_Label); ?></div>
				</div> <!-- container -->
			</div> <!-- wrapper -->
		</section>
	<?php wp_footer(); ?>			
	</body>
</html>
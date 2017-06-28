<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Company_Elite
 */

	/**
	 * Hook - company_elite_action_after_content.
	 *
	 * @hooked company_elite_content_end - 10
	 */
	do_action( 'company_elite_action_after_content' );
?>

	<?php
	/**
	 * Hook - company_elite_action_before_footer.
	 *
	 * @hooked company_elite_add_footer_widgets - 5
	 * @hooked company_elite_footer_start - 10
	 */
	do_action( 'company_elite_action_before_footer' );
	?>
	<?php
	  /**
	   * Hook - company_elite_action_footer.
	   *
	   * @hooked company_elite_footer_copyright - 10
	   */
	  do_action( 'company_elite_action_footer' );
	?>
	<?php
	/**
	 * Hook - company_elite_action_after_footer.
	 *
	 * @hooked company_elite_footer_end - 10
	 */
	do_action( 'company_elite_action_after_footer' );
	?>

<?php
	/**
	 * Hook - company_elite_action_after.
	 *
	 * @hooked company_elite_page_end - 10
	 * @hooked company_elite_footer_goto_top - 20
	 */
	do_action( 'company_elite_action_after' );
?>

<?php wp_footer(); ?>
</body>
</html>

<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Company_Elite
 */

?><?php
	/**
	 * Hook - company_elite_action_doctype.
	 *
	 * @hooked company_elite_doctype - 10
	 */
	do_action( 'company_elite_action_doctype' );
?>
<head>
	<?php
	/**
	 * Hook - company_elite_action_head.
	 *
	 * @hooked company_elite_head - 10
	 */
	do_action( 'company_elite_action_head' );
	?>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php
	/**
	 * Hook - company_elite_action_before.
	 *
	 * @hooked company_elite_page_start - 10
	 * @hooked company_elite_skip_to_content - 15
	 */
	do_action( 'company_elite_action_before' );
	?>

	<?php
	  /**
	   * Hook - company_elite_action_before_header.
	   *
	   * @hooked company_elite_header_start - 10
	   */
	  do_action( 'company_elite_action_before_header' );
	?>
		<?php
		/**
		 * Hook - company_elite_action_header.
		 *
		 * @hooked company_elite_site_branding - 10
		 * @hooked company_elite_add_sub_header - 12
		 */
		do_action( 'company_elite_action_header' );
		?>
	<?php
	  /**
	   * Hook - company_elite_action_after_header.
	   *
	   * @hooked company_elite_header_end - 10
	   * @hooked company_elite_add_primary_navigation - 20
	   */
	  do_action( 'company_elite_action_after_header' );
	?>

	<?php
	/**
	 * Hook - company_elite_action_before_content.
	 *
	 * @hooked company_elite_add_custom_header - 6
	 * @hooked company_elite_content_start - 10
	 */
	do_action( 'company_elite_action_before_content' );
	?>
	<?php
	  /**
	   * Hook - company_elite_action_content.
	   */
	  do_action( 'company_elite_action_content' );

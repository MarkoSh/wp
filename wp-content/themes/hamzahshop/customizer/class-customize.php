<?php
/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
final class HamzahshopCustomize {

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	 */
	public function sections( $manager ) {


		// Load custom sections.
		//require_once( trailingslashit( get_template_directory() ) . 'customizer/section-pro.php' );

		get_template_part('customizer/section-pro');
		
		/*
		Start hamzahshop Options
		=====================================================
		*/
		$manager->add_section( 'hamzahshop_options', array(
			 'title'    => esc_attr__( 'Lite Theme Options', 'hamzahshop' ),
			 'priority' => 35,
		) );
		
		
		/*
		Show Page Layout
		=====================================================
		*/
		$manager->add_setting('hamzahshop_theme_page_layout', array(
			'default'    => 'sidebar',
			'type'       => 'theme_mod',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => array( $this,'hamzahshop_sanitize_select')
		) );
		
		$manager->add_control('hamzahshop_theme_page_layout', array(
			'label'      => esc_attr__( 'Page Layout', 'hamzahshop' ),
			'section'    => 'hamzahshop_options',
			'settings'   => 'hamzahshop_theme_page_layout',
			'type'       => 'select',
			'choices' => array(
				'sidebar' => esc_attr__( 'Sidebar', 'hamzahshop'),
				'no_sidebar' => esc_html__( 'Without Sidebar', 'hamzahshop'),
				
			),
		) );
		
		
		/*
		Blog Layout
		=====================================================
		*/
		$manager->add_setting('hamzahshop_theme_blog_layout', array(
			'default'    => 'sidebar',
			'type'       => 'theme_mod',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => array( $this,'hamzahshop_sanitize_select')
		) );
		
		$manager->add_control('hamzahshop_theme_blog_layout', array(
			'label'      => esc_attr__( 'Blog Layout', 'hamzahshop' ),
			'section'    => 'hamzahshop_options',
			'settings'   => 'hamzahshop_theme_blog_layout',
			'type'       => 'select',
			'choices' => array(
				'sidebar' => esc_attr__( 'Sidebar', 'hamzahshop'),
				'no_sidebar' => esc_html__( 'Without Sidebar', 'hamzahshop'),
				
			),
		) );
		
		/*
		Shop Layout
		=====================================================
		*/
		$manager->add_setting('hamzahshop_theme_shop_layout', array(
			'default'    => 'sidebar',
			'type'       => 'theme_mod',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => array( $this,'hamzahshop_sanitize_select')
		) );
		
		$manager->add_control('hamzahshop_theme_shop_layout', array(
			'label'      => esc_attr__( 'Shop Layout', 'hamzahshop' ),
			'section'    => 'hamzahshop_options',
			'settings'   => 'hamzahshop_theme_shop_layout',
			'type'       => 'select',
			'choices' => array(
				'sidebar' => esc_attr__( 'Sidebar', 'hamzahshop'),
				'no_sidebar' => esc_html__( 'Without Sidebar', 'hamzahshop'),
				
			),
		) );
	
		/*
		Show full post or excerpt
		=====================================================
		*/
		$manager->add_setting('hamzahshop_theme_options_postshow', array(
			'default'    => 'excerpt',
			'type'       => 'theme_mod',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => array( $this,'hamzahshop_sanitize_select')
		) );
		
		$manager->add_control('hamzahshop_theme_options_postshow', array(
			'label'      => esc_attr__( 'Post show', 'hamzahshop' ),
			'section'    => 'hamzahshop_options',
			'settings'   => 'hamzahshop_theme_options_postshow',
			'type'       => 'select',
			'choices' => array(
				'excerpt' => esc_attr__( 'Show excerpt', 'hamzahshop'),
				'full' => esc_html__( 'Show full post', 'hamzahshop'),
				
			),
		) );
		
		
		
		
		$hamzahshop_options=array();
		
		
		
		/*
		Footer
		*/
		$hamzahshop_options['footer']['copyright']= array(
			'default' =>'',
			'label' => esc_attr__('Copyright Text', 'hamzahshop')
		);
		 /*
		 Blog Heading Text
		 */
		$manager->add_setting('hamzahshop_theme_options[blog][heading]', array(
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
			'type'     => 'theme_mod',
		));
		$manager->add_control('hamzahshop_theme_options_blog' , 
			array(
				'label' => esc_html__('Blog Posts List Page Title', 'hamzahshop'),
				'section'    => 'hamzahshop_options',
				'settings' =>'hamzahshop_theme_options[blog][heading]',
			)
		);
		 /*
		 Blog Heading Text
		 */
		$manager->add_setting('hamzahshop_theme_options[blog][sub_heading]', array(
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
			'type'     => 'theme_mod',
			
		));
		$manager->add_control('hamzahshop_theme_options_sub_heading' , 
			array(
				'label' => esc_html__('Blog Posts List Page Sub Title', 'hamzahshop'),
				'section'    => 'hamzahshop_options',
				'settings' =>'hamzahshop_theme_options[blog][sub_heading]',
			)
		);
		
		foreach( $hamzahshop_options as $key => $options ):
			foreach( $options as $k => $val ):
				// SETTINGS
				$manager->add_setting('hamzahshop_theme_options['.$key .']['. $k .']',
					array(
						'default' => $val['default'],
						'capability'     => 'edit_theme_options',
						'sanitize_callback' => 'sanitize_text_field',
						'type'     => 'theme_mod',
					)
				);
				// CONTROLS
				$manager->add_control('hamzahshop_theme_options_text_field_' . $k , 
					array(
						'label' => $val['label'], 
						'section'    => 'hamzahshop_options',
						'settings' =>'hamzahshop_theme_options['.$key .']['. $k .']',
					)
				);
			
			endforeach;
		endforeach;

		// Register custom section types.
		$manager->register_section_type( 'HamzahshopCustomize_Section_Pro' );
		// Register sections.
		$manager->add_section(
			new HamzahshopCustomize_Section_Pro(
				$manager,
				'apple',
				
				array(
					'title'    => esc_html__( 'Hamzah Shop Pro', 'hamzahshop' ),
					'pro_text' => esc_html__( 'Go Pro',         'hamzahshop' ),
					'pro_url'  => esc_url_raw('http://edatastyle.com/product/hamzahshop/')
				)
			)
		);
	}

	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_control_scripts() {

		wp_enqueue_script( 'hamzahshop-customize-controls', trailingslashit( get_template_directory_uri() ) . 'customizer/customize-controls.js', array( 'customize-controls' ) );

		wp_enqueue_style( 'hamzahshop-customize-controls', trailingslashit( get_template_directory_uri() ) . 'customizer/customize-controls.css' );
	}
	
	public function hamzahshop_sanitize_checkbox( $input ) {
		if ( $input == 1 ) {
			return 1;
		} else {
			return '';
		}
	}
	function hamzahshop_sanitize_select( $input ) {
		return wp_filter_nohtml_kses( $input );
	}
}

// Doing this customizer thang!
HamzahshopCustomize::get_instance();

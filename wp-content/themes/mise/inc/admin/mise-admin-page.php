<?php
/**
 * Mise Admin Class.
 * @author  CrestaProject
 * @package Mise
 * @since   1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( 'Mise_Admin' ) ) :
/**
 * Mise_Admin Class.
 */
class Mise_Admin {
	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'wp_loaded', array( __CLASS__, 'hide_notices' ) );
		add_action( 'load-themes.php', array( $this, 'admin_notice' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
	}
	/**
	 * Add admin menu.
	 */
	public function admin_menu() {
		$theme = wp_get_theme( get_template() );
		global $mise_adminpage;
		$mise_adminpage = add_theme_page( esc_html__( 'About', 'mise' ) . ' ' . $theme->display( 'Name' ), esc_html__( 'About', 'mise' ) . ' ' . $theme->display( 'Name' ), 'activate_plugins', 'mise-welcome', array( $this, 'welcome_screen' ) );
	}
	/**
	 * Enqueue styles.
	 */
	public function enqueue_admin_scripts() {
		global $mise_adminpage;
		$screen = get_current_screen();
		if ( $screen->id != $mise_adminpage ) {
			return;
		}
		wp_enqueue_style( 'mise-welcome', get_template_directory_uri() . '/inc/admin/welcome.css', array(), '1.0' );
		wp_enqueue_script( 'mise-admin-panel', get_template_directory_uri() . '/inc/admin/admin-panel.js', array('jquery'), '1.0', true );
	}
	
	/**
	 * Add admin notice.
	 */
	public function admin_notice() {
		global $pagenow;
		wp_enqueue_style( 'mise-message', get_template_directory_uri() . '/inc/admin/message.css', array(), '1.0' );
		// Let's bail on theme activation.
		if ( 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {
			add_action( 'admin_notices', array( $this, 'welcome_notice' ) );
			update_option( 'mise_admin_notice_welcome', 1 );
		// No option? Let run the notice wizard again..
		} elseif( ! get_option( 'mise_admin_notice_welcome' ) ) {
			add_action( 'admin_notices', array( $this, 'welcome_notice' ) );
		}
	}
	/**
	 * Hide a notice if the GET variable is set.
	 */
	public static function hide_notices() {
		if ( isset( $_GET['mise-hide-notice'] ) && isset( $_GET['_mise_notice_nonce'] ) ) {
			if ( ! wp_verify_nonce( sanitize_key($_GET['_mise_notice_nonce'] ), 'mise_hide_notices_nonce' ) ) {
				wp_die( esc_html__( 'Action failed. Please refresh the page and retry.', 'mise' ) );
			}
			if ( ! current_user_can( 'manage_options' ) ) {
				wp_die( esc_html__( 'Cheatin&#8217; huh?', 'mise' ) );
			}
			$hide_notice = sanitize_text_field( wp_unslash($_GET['mise-hide-notice'] ));
			update_option( 'mise_admin_notice_' . $hide_notice, 1 );
		}
	}
	/**
	 * Show welcome notice.
	 */
	public function welcome_notice() {
		?>
		<div id="message" class="updated cresta-message">
			<a class="cresta-message-close notice-dismiss" href="<?php echo esc_url( wp_nonce_url( remove_query_arg( array( 'activated' ), add_query_arg( 'mise-hide-notice', 'welcome' ) ), 'mise_hide_notices_nonce', '_mise_notice_nonce' ) ); ?>"><?php esc_html_e( 'Dismiss', 'mise' ); ?></a>
			<p>
			<?php
			/* translators: 1: start option panel link, 2: end option panel link */
			printf( esc_html__( 'Welcome! Thank you for choosing Mise theme! To fully take advantage of the best our theme can offer and read the documentation please make sure you visit our %1$swelcome page%2$s.', 'mise' ), '<a href="' . esc_url( admin_url( 'themes.php?page=mise-welcome' ) ) . '">', '</a>' );
			?>
			</p>
			<p class="submit">
				<a class="button-secondary" href="<?php echo esc_url( admin_url( 'themes.php?page=mise-welcome' ) ); ?>"><?php esc_html_e( 'Get started with Mise', 'mise' ); ?></a>
			</p>
		</div>
		<?php
	}
	/**
	 * Intro text/links shown to all about pages.
	 *
	 * @access private
	 */
	private function intro() {
		$theme = wp_get_theme( get_template() );
		?>
		<div class="cresta-theme-info">
			<h1>
				<?php esc_html_e('About', 'mise'); ?>
				<?php echo esc_html($theme->get( 'Name' )) ." ". esc_html($theme->get( 'Version' )); ?>
			</h1>
			<div class="welcome-description-wrap">
				<div class="about-text"><?php echo esc_html($theme->display( 'Description' )); ?>
				<p class="cresta-actions">
					<a href="<?php echo esc_url( apply_filters( 'mise_pro_theme_url', 'https://crestaproject.com/downloads/mise/' ) ); ?>" class="button button-secondary" target="_blank"><?php esc_html_e( 'Theme Info', 'mise' ); ?></a>

					<a href="<?php echo esc_url( apply_filters( 'mise_pro_theme_url', 'http://crestaproject.com/demo/mise/' ) ); ?>" class="button button-secondary docs" target="_blank"><?php esc_html_e( 'View Demo', 'mise' ); ?></a>
					
					<a href="<?php echo esc_url( apply_filters( 'mise_pro_theme_url', 'http://crestaproject.com/demo/mise-pro/' ) ); ?>" class="button button-primary docs" target="_blank"><?php esc_html_e( 'View PRO version Demo', 'mise' ); ?></a>
					
					<a href="<?php echo esc_url( apply_filters( 'mise_pro_theme_url', 'https://wordpress.org/support/theme/mise/reviews/' ) ); ?>" class="button button-secondary docs" target="_blank"><?php esc_html_e( 'Rate this theme', 'mise' ); ?></a>
				</p>
				</div>
				<div class="cresta-screenshot">
					<img src="<?php echo esc_url( get_template_directory_uri() ) . '/screenshot.png'; ?>" />
				</div>
			</div>
		</div>
		<h2 class="nav-tab-wrapper">
			<a class="nav-tab <?php if ( empty( $_GET['tab'] ) && isset( $_GET['page'] ) && $_GET['page'] == 'mise-welcome' ) echo 'nav-tab-active'; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'mise-welcome' ), 'themes.php' ) ) ); ?>">
				<?php echo esc_html($theme->display( 'Name' )); ?>
			</a>
			<a class="nav-tab <?php if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'free_vs_pro' ) echo 'nav-tab-active'; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'mise-welcome', 'tab' => 'free_vs_pro' ), 'themes.php' ) ) ); ?>">
				<?php esc_html_e( 'Free Vs PRO', 'mise' ); ?>
			</a>
			<a class="nav-tab <?php if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'documentation' ) echo 'nav-tab-active'; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'mise-welcome', 'tab' => 'documentation' ), 'themes.php' ) ) ); ?>">
				<?php esc_html_e( 'Documentation', 'mise' ); ?>
			</a>
			<a class="nav-tab <?php if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'changelog' ) echo 'nav-tab-active'; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'mise-welcome', 'tab' => 'changelog' ), 'themes.php' ) ) ); ?>">
				<?php esc_html_e( 'Changelog', 'mise' ); ?>
			</a>
		</h2>
		<?php
	}
	/**
	 * Welcome screen page.
	 */
	public function welcome_screen() {
		$current_tab = empty( $_GET['tab'] ) ? 'about' : sanitize_title( wp_unslash($_GET['tab']) );
		// Look for a {$current_tab}_screen method.
		if ( is_callable( array( $this, $current_tab . '_screen' ) ) ) {
			return $this->{ $current_tab . '_screen' }();
		}
		// Fallback to about screen.
		return $this->about_screen();
	}
	/**
	 * Output the about screen.
	 */
	public function about_screen() {
		$theme = wp_get_theme( get_template() );
		?>
		<div class="wrap about-wrap">
			<?php $this->intro(); ?>
			<div class="changelog point-releases">
				<div class="under-the-hood two-col">
					<div class="col">
						<h3><?php esc_html_e( 'Theme Customizer', 'mise' ); ?></h3>
						<p><?php esc_html_e( 'All Theme Options are available via Customize screen.', 'mise' ) ?></p>
						<p><a href="<?php echo esc_url(admin_url( 'customize.php' )); ?>" class="button button-secondary"><?php esc_html_e( 'Customize', 'mise' ); ?></a></p>
					</div>
					<div class="col">
						<h3><?php esc_html_e( 'Got theme support question?', 'mise' ); ?></h3>
						<p><?php esc_html_e( 'Please put it in our support forum.', 'mise' ) ?></p>
						<p><a target="_blank" href="<?php echo esc_url( 'https://wordpress.org/support/theme/mise/' ); ?>" class="button button-secondary"><?php esc_html_e( 'Support', 'mise' ); ?></a></p>
					</div>
					<div class="col">
						<h3><?php esc_html_e( 'Need more features?', 'mise'); ?></h3>
						<p><?php esc_html_e( 'Upgrade to PRO version for more exciting features.', 'mise' ) ?></p>
						<p><a target="_blank" href="<?php echo esc_url( 'https://crestaproject.com/downloads/mise/' ); ?>" class="button button-secondary"><?php esc_html_e( 'Info about PRO version', 'mise' ); ?></a></p>
					</div>
					<div class="col">
						<h3>
							<?php
							esc_html_e( 'Translate', 'mise' );
							echo ' ' . esc_html($theme->display( 'Name' ));
							?>
						</h3>
						<p><?php esc_html_e( 'Click below to translate this theme into your own language.', 'mise' ) ?></p>
						<p>
							<a target="_blank" href="<?php echo esc_url( 'http://translate.wordpress.org/projects/wp-themes/mise/' ); ?>" class="button button-secondary">
								<?php
								esc_html_e( 'Translate', 'mise' );
								echo ' ' . esc_html($theme->display( 'Name' ));
								?>
							</a>
						</p>
					</div>
				</div>
			</div>
			<div class="return-to-dashboard cresta">
				<?php if ( current_user_can( 'update_core' ) && isset( $_GET['updated'] ) ) : ?>
					<a href="<?php echo esc_url( self_admin_url( 'update-core.php' ) ); ?>">
						<?php is_multisite() ? esc_html_e( 'Return to Updates', 'mise' ) : esc_html_e( 'Return to Dashboard &rarr; Updates', 'mise' ); ?>
					</a> |
				<?php endif; ?>
				<a href="<?php echo esc_url( self_admin_url() ); ?>"><?php is_blog_admin() ? esc_html_e( 'Go to Dashboard &rarr; Home', 'mise' ) : esc_html_e( 'Go to Dashboard', 'mise' ); ?></a>
			</div>
		</div>
		<?php
	}
	/**
	 * Output the changelog screen.
	 */
	public function changelog_screen() {
		global $wp_filesystem;
		?>
		<div class="wrap about-wrap">
			<?php $this->intro(); ?>
			<p class="about-description"><?php esc_html_e( 'View changelog below:', 'mise' ); ?></p>
			<?php
				$changelog_file = apply_filters( 'mise_changelog_file', get_template_directory() . '/readme.txt' );

				// Check if the changelog file exists and is readable.
				if ( $changelog_file && is_readable( $changelog_file ) ) {
					WP_Filesystem();
					$changelog = $wp_filesystem->get_contents( $changelog_file );
					$changelog_list = $this->parse_changelog( $changelog );

					echo wp_kses_post( $changelog_list );
				}
			?>
		</div>
		<?php
	}
	/**
	 * Parse changelog from readme file.
	 * @param  string $content
	 * @return string
	 */
	private function parse_changelog( $content ) {
		$matches   = null;
		$regexp    = '~==\s*Changelog\s*==(.*)($)~Uis';
		$changelog = '';
		if ( preg_match( $regexp, $content, $matches ) ) {
			$changes = explode( '\r\n', trim( $matches[1] ) );

			$changelog .= '<pre class="changelog">';

			foreach ( $changes as $index => $line ) {
				$changelog .= wp_kses_post( preg_replace( '~(=\s*Version\s*(\d+(?:\.\d+)+)\s*=|$)~Uis', '<span class="title">${1}</span>', $line ) );
			}

			$changelog .= '</pre>';
		}
		return wp_kses_post( $changelog );
	}
	/**
	 * Output the documentation screen.
	 */
	public function documentation_screen() {
		?>
		<div class="wrap about-wrap">
			<?php $this->intro(); ?>
			<p class="about-description"><?php esc_html_e( 'Mise WordPress Theme Documentation', 'mise' ); ?></p>
			<div class="option-panel-toggle">
				<div class="singleToggle">
					<span class="dashicons dashicons-arrow-right"></span><div class="toggleTitle"><?php esc_html_e( 'How to set the "one page" template in the home page', 'mise' ); ?></div>
					<div class="toggleText">
						<ul>
							<li>
								<div class="miseDocText">
									<?php esc_html_e( '1) Create a new page and name it as you like (eg. Home). In the "Page Attributes" section choose the template called "One Page Website" and save the page.', 'mise' ); ?>
								</div>
								<div class="miseDocImage">
									<img src="<?php echo esc_url( get_template_directory_uri() ) . '/inc/admin/images/mise-documentation-1.png'; ?>" />
								</div>
							</li>
							<li>
								<div class="miseDocText">
									<?php esc_html_e( '2) Go in your WordPress Dashboard under "Settings-> Reading". Set the "Front page displays" on "Static Page" and choose the page you previously created as Front page (eg. Home).', 'mise' ); ?>
								</div>
								<div class="miseDocImage">
									<img src="<?php echo esc_url( get_template_directory_uri() ) . '/inc/admin/images/mise-documentation-2.png'; ?>" />
								</div>
							</li>
							<li>
								<div class="miseDocText">
									<?php esc_html_e( '3) Perfect! Now you can go in your WordPress Dashboard under "Appearance-> Customize" and you\'ll see the section called "Mise Onepage" in which you can customize the home page.', 'mise' ); ?>
								</div>
								<div class="miseDocImage">
									<img src="<?php echo esc_url( get_template_directory_uri() ) . '/inc/admin/images/mise-documentation-3.png'; ?>" />
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="option-panel-toggle">
				<div class="singleToggle">
					<span class="dashicons dashicons-arrow-right"></span><div class="toggleTitle"><?php esc_html_e( 'One Page: how to scroll to section using the menu', 'mise' ); ?></div>
					<div class="toggleText">
						<ul>
							<li>
								<div class="miseDocText">
									<?php esc_html_e( '1) Go to your WordPress Dashboard under "Appearance-> Customize-> Mise Onepage" and choose one section (eg. Skills) and add a section ID (eg. skills) for this section. Save the options.', 'mise' ); ?>
								</div>
								<div class="miseDocImage">
									<img src="<?php echo esc_url( get_template_directory_uri() ) . '/inc/admin/images/mise-documentation-4.png'; ?>" />
								</div>
							</li>
							<li>
								<div class="miseDocText">
									<?php esc_html_e( '2) Now go to your WordPress Dashboard under "Appearance-> Menus" and create a new custom link with the URL of your home page followed the ID created for the section (eg. yoursite.com/#skills). Add this custom link to your menu and save the options.', 'mise' ); ?>
								</div>
								<div class="miseDocImage">
									<img src="<?php echo esc_url( get_template_directory_uri() ) . '/inc/admin/images/mise-documentation-5.png'; ?>" />
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="option-panel-toggle">
				<div class="singleToggle">
					<span class="dashicons dashicons-arrow-right"></span><div class="toggleTitle"><?php esc_html_e( 'One Page: how to set "About Us" section, "Features" section, "Services" section and "Team" section', 'mise' ); ?></div>
					<div class="toggleText">
						<ul>
							<li>
								<div class="miseDocText">
									<?php esc_html_e( '1) These sections (About Us, Features, Services and Team) work in the same way and with the same procedure. To insert the content create a new page, and insert the title, content and featured image. The featured image is only valid for the "About Us" and "Team" section but is not mandatory.', 'mise' ); ?>
								</div>
								<div class="miseDocImage">
									<img src="<?php echo esc_url( get_template_directory_uri() ) . '/inc/admin/images/mise-documentation-10.png'; ?>" />
								</div>
							</li>
							<li>
								<div class="miseDocText">
									<?php esc_html_e( '2) Now go to "Appearance-> Customize-> Mise Onepage" and choose the section you want to edit (About Us, Features or Services). Find the option called "Choose the page to display" and search the page you just created.', 'mise' ); ?>
								</div>
								<div class="miseDocImage">
									<img src="<?php echo esc_url( get_template_directory_uri() ) . '/inc/admin/images/mise-documentation-11.png'; ?>" />
								</div>
							</li>
							<li>
								<div class="miseDocText">
									<?php esc_html_e( '3) Now the section will show the content of the page previously created and the layout will be like the example image. The "Features", "Services" and "Team" sections work in the same way but will have a different layout.', 'mise' ); ?>
								</div>
								<div class="miseDocImage">
									<img src="<?php echo esc_url( get_template_directory_uri() ) . '/inc/admin/images/mise-documentation-12.png'; ?>" />
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="option-panel-toggle">
				<div class="singleToggle">
					<span class="dashicons dashicons-arrow-right"></span><div class="toggleTitle"><?php esc_html_e( 'One Page: how to re-order sections', 'mise' ); ?></div>
					<div class="toggleText">
						<ul>
							<li>
								<div class="miseDocText">
									<?php esc_html_e( 'Re-order sections is available in Mise PRO version. With this feature you can choose the position of each section using drag and drop. Click on the button below for more information:', 'mise' ); ?>
									<br/><a href="<?php echo esc_url( apply_filters( 'mise_pro_theme_url', 'https://crestaproject.com/downloads/mise/' ) ); ?>" class="button button-primary" target="_blank"><?php esc_html_e( 'More Info About PRO Version', 'mise' ); ?></a>
								</div>
								<div class="miseDocImage">
									<img src="<?php echo esc_url( get_template_directory_uri() ) . '/inc/admin/images/mise-documentation-13.png'; ?>" />
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="option-panel-toggle">
				<div class="singleToggle">
					<span class="dashicons dashicons-arrow-right"></span><div class="toggleTitle"><?php esc_html_e( 'How to add social icons', 'mise' ); ?></div>
					<div class="toggleText">
						<ul>
							<li>
								<div class="miseDocText">
									<?php esc_html_e( 'Go to your WordPress Dashboard under "Appearance-> Customize-> Mise Theme Options-> Social Network". Here you can choose which social network to show and where show them (in the footer section or in float position or both).', 'mise' ); ?>
								</div>
								<div class="miseDocImage">
									<img src="<?php echo esc_url( get_template_directory_uri() ) . '/inc/admin/images/mise-documentation-6.png'; ?>" />
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="option-panel-toggle">
				<div class="singleToggle">
					<span class="dashicons dashicons-arrow-right"></span><div class="toggleTitle"><?php esc_html_e( 'How to add custom logo', 'mise' ); ?></div>
					<div class="toggleText">
						<ul>
							<li>
								<div class="miseDocText">
									<?php esc_html_e( 'Go to your WordPress Dashboard under "Appearance-> Customize-> Site Identity". Here you can upload your custom logo (size 250x60px).', 'mise' ); ?>
								</div>
								<div class="miseDocImage">
									<img src="<?php echo esc_url( get_template_directory_uri() ) . '/inc/admin/images/mise-documentation-7.png'; ?>" />
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="option-panel-toggle">
				<div class="singleToggle">
					<span class="dashicons dashicons-arrow-right"></span><div class="toggleTitle"><?php esc_html_e( 'How to change theme colors', 'mise' ); ?></div>
					<div class="toggleText">
						<ul>
							<li>
								<div class="miseDocText">
									<?php esc_html_e( 'Go to your WordPress Dashboard under "Appearance-> Customize-> Mise Theme Options-> Theme Colors". Here you can change the theme colors according to sections of the site (header, content, sidebars and footer).', 'mise' ); ?>
								</div>
								<div class="miseDocImage">
									<img src="<?php echo esc_url( get_template_directory_uri() ) . '/inc/admin/images/mise-documentation-8.png'; ?>" />
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="option-panel-toggle">
				<div class="singleToggle">
					<span class="dashicons dashicons-arrow-right"></span><div class="toggleTitle"><?php esc_html_e( 'How to display page loader', 'mise' ); ?></div>
					<div class="toggleText">
						<ul>
							<li>
								<div class="miseDocText">
									<?php esc_html_e( 'Go to your WordPress Dashboard under "Appearance-> Customize-> Mise Theme Options-> General Settings", find the option called "Display page loader" and check it. The background will be the same of "Content background color" and the loader icon the same color of "Link color".', 'mise' ); ?>
								</div>
								<div class="miseDocImage">
									<img src="<?php echo esc_url( get_template_directory_uri() ) . '/inc/admin/images/mise-documentation-9.png'; ?>" />
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
	/**
	 * Output the free vs pro screen.
	 */
	public function free_vs_pro_screen() {
		?>
		<div class="wrap about-wrap">
			<?php $this->intro(); ?>
			<p class="about-description"><?php esc_html_e( 'Upgrade to PRO version for more exciting features.', 'mise' ); ?></p>
			<table>
				<thead>
					<tr>
						<th class="table-feature-title"><h3><?php esc_html_e('Features', 'mise'); ?></h3></th>
						<th><h3><?php esc_html_e('Mise', 'mise'); ?></h3></th>
						<th><h3><?php esc_html_e('Mise PRO', 'mise'); ?></h3></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><h3><?php esc_html_e('Theme Options made with the WP Customizer', 'mise'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Responsive Design', 'mise'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Logo Upload', 'mise'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Unlimited Text and Background Color', 'mise'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Choose Social Icons', 'mise'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span> <?php esc_html_e('+ more social buttons', 'mise'); ?></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('WooCommerce Compatibility', 'mise'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('WPML Multilingual ready', 'mise'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('RTL Support', 'mise'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Sidebar and Footer Widgets', 'mise'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Loading Page', 'mise'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span> <?php esc_html_e('1 loader', 'mise'); ?></td>
						<td><span class="dashicons dashicons-yes"></span> <?php esc_html_e('7 loaders', 'mise'); ?></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('One Page Template', 'mise'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span> <?php esc_html_e('+ more sections', 'mise'); ?></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('One Page additional sections', 'mise'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span> <?php esc_html_e('Portfolio, Google Map, Numbers, Newsletter, Clients, Testimonials, Video and more...', 'mise'); ?></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('One Page Section Reorder', 'mise'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('One Page Template scroll animations', 'mise'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('One Page choose Slider Height', 'mise'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Portfolio Template', 'mise'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Parallax Effect', 'mise'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Choose Header Height', 'mise'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Google Fonts switcher', 'mise'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Manage sidebar position', 'mise'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Sticky Sidebar', 'mise'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Post views counter', 'mise'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('6 Shortcodes', 'mise'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('8 Exclusive Widgets', 'mise'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Related Posts Box', 'mise'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Information About Author Box', 'mise'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('PowerTip, LightBox, Custom Copyright Text and much more...', 'mise'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td class="btn-wrapper">
							<a href="<?php echo esc_url( apply_filters( 'mise_pro_theme_url', 'http://crestaproject.com/demo/mise-pro/' ) ); ?>" class="button button-secondary" target="_blank"><?php esc_html_e( 'View PRO version demo', 'mise' ); ?></a>
							<a href="<?php echo esc_url( apply_filters( 'mise_pro_theme_url', 'https://crestaproject.com/downloads/mise/' ) ); ?>" class="button button-secondary" target="_blank"><?php esc_html_e( 'Get Mise PRO', 'mise' ); ?></a>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<?php
	}
}
endif;
return new Mise_Admin();
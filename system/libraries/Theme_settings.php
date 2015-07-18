<?php
/**
 * Calibrefx Theme Setting Class
 *
 */
class CFX_Theme_Settings extends Calibrefx_Admin {

	/**
	 * Constructor - Initializes
	 */
	public function __construct() {
		parent::__construct( 'calibrefx-settings' );

		$this->page_id = 'calibrefx';
		$this->default_settings = apply_filters( 'calibrefx_theme_settings_defaults', array(
			'update' => 1,
			'blog_title' => 'text',
			'header_right' => 0,
			'layout_type' => 'static',
			'calibrefx_layout_width' => 1160,
			'calibrefx_layout_wrapper_fixed' => 0,
			'site_layout' => calibrefx_get_default_layout(),
			'sidebar_width' => 4,
			'feature_image_layout' => 'full',
			'nav' => 1,
			'subnav' => 0,
			'post_date' => 1,
			'post_author' => 1,
			'post_comment' => 1,
			'post_category' => 1,
			'post_tags' => 1,
			'breadcrumb_home' => 1,
			'breadcrumb_single' => 1,
			'breadcrumb_page' => 1,
			'breadcrumb_archive' => 1,
			'breadcrumb_404' => 1,
			'comments_pages' => 0,
			'comments_posts' => 1,
			'trackbacks_pages' => 0,
			'trackbacks_posts' => 1,
			'custom_css' => '',
			'content_archive' => 'full',
			'content_archive_limit' => 0,
			'posts_nav' => 'older-newer',
			'header_scripts' => '',
			'footer_scripts' => '',
			'enable_mobile' => 0,
			'log_threshold' => 4,
			'log_date_format' => 'Y-m-d H:i:s',
			'log_path' => '',
			'calibrefx_version' => FRAMEWORK_VERSION,
			'calibrefx_db_version' => FRAMEWORK_DB_VERSION)
		);

		//Initializing hooks
		$this->initialize();

		if( current_user_can( 'edit_theme_options' ) ){
			add_action( 'admin_init', array( $this, 'manage_modules' ) );
			add_action( 'admin_init', array( $this, 'handle_export_import' ) );
		}
	}

	/**
	 * Register Our Security Filters
	 *
	 * $return void
	 */
	public function security_filters() {
		global $calibrefx;

		$calibrefx->security->add_sanitize_filter(
			'one_zero', $this->settings_field, array(
					'update',
					'calibrefx_layout_wrapper_fixed',
					'header_right',
					'nav',
					'subnav',
					'post_date',
					'post_author',
					'post_comment',
					'post_category',
					'post_tags',
					'breadcrumb_home',
					'breadcrumb_single',
					'breadcrumb_page',
					'breadcrumb_archive',
					'breadcrumb_404',
					'comments_posts',
					'comments_pages',
					'trackbacks_posts',
					'trackbacks_pages' )
		);

		$calibrefx->security->add_sanitize_filter(
			'safe_text', $this->settings_field, array(
					'blog_title',
					'calibrefx_version',
					'calibrefx_db_version',
					'posts_nav',
					'content_archive',
					'layout_type',
					'site_layout',
					'feature_image_layout', 
				)
		);

		$calibrefx->security->add_sanitize_filter(
			'integer', $this->settings_field, array(
					'calibrefx_layout_width',
					'content_archive_limit',
					'calibrefx_db_version',
					'sidebar_width'
				)
		);
	}

	public function manage_modules(){
		add_action( 'load-' . $this->pagehook, array( $this, 'module_activation' ) );
	}

	public function handle_export_import(){

		if ( ! isset( $_SERVER['REQUEST_METHOD'] ) OR 'POST' !== esc_attr( $_SERVER['REQUEST_METHOD'] ) ) {
			return;
		}

		if ( ! empty( $_POST['calibrefx_do_export'] ) ) { 
			$this->do_export();
		} elseif ( ! empty( $_POST['calibrefx_do_import'] ) ) {
			$this->do_import();
		}

		return;
	}

	public function meta_sections() {
		global $calibrefx_current_section, $calibrefx_target_form;

		$calibrefx_target_form = apply_filters( 'calibrefx_target_form', 'options.php' );

		calibrefx_clear_meta_section();

		calibrefx_add_meta_section( 'general', __( 'General Settings', 'calibrefx' ), $calibrefx_target_form, 1, 'cfxicon-generalsetting' );
		calibrefx_add_meta_section( 'layout', __( 'Layout Settings', 'calibrefx' ), $calibrefx_target_form, 2, 'cfxicon-layoutsetting' );
		calibrefx_add_meta_section( 'social', __( 'Social Settings', 'calibrefx' ), $calibrefx_target_form, 10, 'cfxicon-share2' );

		calibrefx_add_meta_section( 'system', __( 'System Information', 'calibrefx' ), $calibrefx_target_form, 60, 'fa fa-cogs' );
		if( current_user_can( 'edit_theme_options' ) ){
			calibrefx_add_meta_section( 'modules', __( 'Available Modules', 'calibrefx' ), '', 50 );
			calibrefx_add_meta_section( 'tosgen', __( 'Legal Generator', 'calibrefx' ), '', 70, 'fa fa-rocket' );
			calibrefx_add_meta_section( 'importexport', __( 'Import / Export Settings', 'calibrefx' ), '', 80, 'fa fa-share-square-o' );
		}

		do_action( 'calibrefx_theme_settings_meta_section' );

		$calibrefx_current_section = 'general';
		if ( ! empty( $_GET['section']) ) {
			$calibrefx_current_section = sanitize_text_field( $_GET['section'] );
		}
	}

	public function meta_boxes() {
		calibrefx_add_meta_box( 'general', 'basic', 'calibrefx-theme-settings-brand', __( 'Brand Settings', 'calibrefx' ), array( $this, 'branding_box' ), $this->pagehook, 'main', 'high' );
		calibrefx_add_meta_box( 'general', 'basic', 'calibrefx-theme-settings-navigation', __( 'Navigation Settings', 'calibrefx' ), array( $this, 'navigation_box' ), $this->pagehook, 'main', 'high' );
		calibrefx_add_meta_box( 'general', 'basic', 'calibrefx-theme-settings-content', __( 'Content Setting', 'calibrefx' ), array( $this, 'content_setting' ), $this->pagehook, 'main' );
		calibrefx_add_meta_box( 'general', 'basic', 'calibrefx-theme-settings-comment', __( 'Post Comment Setting', 'calibrefx' ), array( $this, 'comment_setting' ), $this->pagehook, 'main' );
		calibrefx_add_meta_box( 'general', 'basic', 'calibrefx-theme-settings-tracking', __( 'Website Tracking Setting', 'calibrefx' ), array( $this, 'tracking_setting' ), $this->pagehook, 'main' );

		calibrefx_add_meta_box( 'layout', 'basic', 'calibrefx-theme-settings-layout', __( 'Website Layout Settings', 'calibrefx' ), array( $this, 'layout_box' ), $this->pagehook, 'main', 'high' );
		calibrefx_add_meta_box( 'layout', 'basic', 'calibrefx-theme-settings-custom-script', __( 'Themes Advanced Customization', 'calibrefx' ), array( $this, 'custom_script_box' ), $this->pagehook, 'main', 'low' );

		calibrefx_add_meta_box( 'social', 'basic', 'calibrefx-theme-settings-socials', __( 'Social Integration', 'calibrefx' ), array( $this, 'socials_integrated_box' ), $this->pagehook, 'main' );

		calibrefx_add_meta_box( 'system', 'basic', 'calibrefx-about-version', __( 'Information', 'calibrefx' ), array( $this, 'info_box' ), $this->pagehook, 'main', 'high' );
		if( current_user_can( 'edit_theme_options' ) ){
			calibrefx_add_meta_box( 'modules', 'basic', 'calibrefx-render-page', __( 'Modules Available', 'calibrefx' ), array( $this, 'render_page' ), $this->pagehook, 'main', 'high' );
			calibrefx_add_meta_box( 'tosgen', 'basic', 'calibrefx-other-settings-tosgen', __( 'Legal Generator', 'calibrefx' ), array( $this, 'tos_generator' ), $this->pagehook, 'main', 'high' );
			calibrefx_add_meta_box( 'importexport', 'basic', 'calibrefx-import-settings', __( 'Import Settings', 'calibrefx' ), array( $this, 'import_settings' ), $this->pagehook, 'main', 'high' );
			calibrefx_add_meta_box( 'importexport', 'basic', 'calibrefx-export-settings', __( 'Export Settings', 'calibrefx' ), array( $this, 'export_settings' ), $this->pagehook, 'main', 'high' );
		}

		do_action( 'calibrefx_theme_settings_meta_box' );
	}

	public function hidden_fields() {
		$calibrefx_version = calibrefx_get_option( 'calibrefx_version' );
		$calibrefx_db_version = calibrefx_get_option( 'calibrefx_db_version' );

		$_version = empty( $calibrefx_version ) ? FRAMEWORK_VERSION : $calibrefx_version;
		$_db_version = empty( $calibrefx_db_version ) ? FRAMEWORK_DB_VERSION : $calibrefx_db_version;
		?>
        <input type="hidden" name="<?php echo $this->settings_field; ?>[calibrefx_version]>" value="<?php echo esc_attr( $_version ); ?>" />
        <input type="hidden" name="<?php echo $this->settings_field; ?>[calibrefx_db_version]>" value="<?php echo esc_attr( $_db_version ); ?>" />
        <?php
	}

	//Meta Boxes Sections
	function branding_box(){
		global $calibrefx;

		calibrefx_add_meta_group( 'themebranding-settings', 'branding-settings', __( 'Brand Settings', 'calibrefx' ) );

		add_action( 'themebranding-settings_options', function() {
			calibrefx_add_meta_option(
				'branding-settings',  // group id
				'header_logo_desc', // field id and option name
				__( 'Set logo', 'calibrefx' ),
				array(
					'option_type' => 'blank',
					'option_description' => __( 'You can upload configure your logo using from the Appereance > Header.', 'calibrefx' ),
				), // Settings config
				1 //Priority
			);

			calibrefx_add_meta_option(
				'branding-settings',  // group id
				'favicon', // field id and option name
				__( 'Set Favicon', 'calibrefx' ),
				array(
					'option_type' => 'upload',
					'option_default' => '',
					'option_filter' => 'safe_url',
					'option_description' => __( 'You can upload your favicon. Best size 32x32px in .ico format', 'calibrefx' ),
				), // Settings config
				5 //Priority
			);
		});

		calibrefx_do_meta_options( $calibrefx->theme_settings, 'themebranding-settings' );
	}
	/**
	 * Show navigation setting box
	 */
	function navigation_box() {
		global $calibrefx;

		calibrefx_add_meta_group( 'themenavigation-settings', 'navigation-settings', __( 'Menu Settings', 'calibrefx' ) );

		add_action( 'themenavigation-settings_options', function() {
			calibrefx_add_meta_option(
				'navigation-settings',  // group id
				'nav', // field id and option name
				apply_filters( 'primary_menu_text', __( 'Primary Navigation Menu', 'calibrefx' ) ),
				array(
					'option_type' => 'checkbox',
					'option_items' => '1',
					'option_default' => '',
					'option_filter' => 'integer',
					'option_description' => __( 'You can assign primary menu from the Apperances > Menu', 'calibrefx' ),
				), // Settings config
				1 //Priority
			);

			calibrefx_add_meta_option(
				'navigation-settings',  // group id
				'subnav', // field id and option name
				apply_filters( 'secondary_menu_text', __( 'Secondary Navigation Menu', 'calibrefx' ) ),
				array(
					'option_type' => 'checkbox',
					'option_items' => '1',
					'option_default' => '',
					'option_filter' => 'integer',
					'option_description' => __( 'You can assign secondary menu from the Apperances > Menu', 'calibrefx' ),
				), // Settings config
				1 //Priority
			);
		});

		calibrefx_do_meta_options( $calibrefx->theme_settings, 'themenavigation-settings' );
	}

	/**
	 * Show google analytic setting box
	 */
	function tracking_setting() {
		global $calibrefx;

		calibrefx_add_meta_group( 'themetracking-settings', 'google-analytics-settings', __( 'Google Anlytic Settings', 'calibrefx' ) );
		calibrefx_add_meta_group( 'themetracking-settings', 'facebook-tracking-settings', __( 'Facebook Tracking Settings', 'calibrefx' ) );

		add_action( 'themetracking-settings_options', function() {
			calibrefx_add_meta_option(
				'google-analytics-settings',  // group id
				'analytic_id', // field id and option name
				__( 'Google Analytics ID', 'calibrefx' ), // Label
				array(
					'option_type' => 'textinput',
					'option_default' => '',
					'option_filter' => 'no_html',
					'option_description' => __( 'Enter your google analytics ID, example: <strong>UA-xxxxxxxx-x</strong>', 'calibrefx' ),
				), // Settings config
				1 //Priority
			);

			calibrefx_add_meta_option(
				'google-analytics-settings',  // group id
				'google_tagmanager_code', // field id and option name
				__( 'Paste your Google Tag Manager Script', 'calibrefx' ), // Label
				array(
					'option_type' => 'textarea',
					'option_default' => '',
					'option_filter' => 'no_filter',
					'option_description' => __( "Learn more about Google Tag Manager <a href='http://www.google.com/tagmanager/get-started.html' target='_blank'>here</a>", 'calibrefx' ),
				), // Settings config
				5 //Priority
			);
		});

		add_action( 'themetracking-settings_options', function() {
			calibrefx_add_meta_option(
				'facebook-tracking-settings',  // group id
				'facebook_tracking_code', // field id and option name
				__( 'Paste your Facebook conversion pixels', 'calibrefx' ), // Label
				array(
					'option_type' => 'textarea',
					'option_default' => '',
					'option_filter' => 'no_filter',
					'option_description' => __( "Learn more about Facebook conversion pixel <a href='https://www.facebook.com/help/435189689870514/' target='_blank'>here</a>", 'calibrefx' ),
				), // Settings config
				1 //Priority
			);
		});

		calibrefx_do_meta_options( $calibrefx->theme_settings, 'themetracking-settings' );
	}

	/**
	 * Show content box
	 */
	function content_setting() {
		global $calibrefx;

		calibrefx_add_meta_group( 'content-settings', 'postinfo-settings', __( 'Post Info Settings', 'calibrefx' ) );
		calibrefx_add_meta_group( 'content-settings', 'breadcrumb-settings', __( 'Breadcrumb Settings', 'calibrefx' ) );
		calibrefx_add_meta_group( 'content-settings', 'content-archives-settings', __( 'Category Page Settings', 'calibrefx' ) );
		calibrefx_add_meta_group( 'content-settings', 'post-navigation-settings', __( 'Post Navigation Settings', 'calibrefx' ) );

		//For postinfo settings
		add_action( 'content-settings_options', function() {
			calibrefx_add_meta_option(
				'postinfo-settings',  // group id
				'post_date', // field id and option name
				__( 'Show Post Published Date', 'calibrefx' ), // Label
				array(
					'option_type' => 'checkbox',
					'option_items' => '1',
					'option_default' => '1',
					'option_filter' => 'integer',
				), // Settings config
				1 //Priority
			);

			calibrefx_add_meta_option(
				'postinfo-settings',  // group id
				'post_author', // field id and option name
				__( 'Show Post Author', 'calibrefx' ), // Label
				array(
					'option_type' => 'checkbox',
					'option_items' => '1',
					'option_default' => '1',
					'option_filter' => 'integer',
				), // Settings config
				5 //Priority
			);

			calibrefx_add_meta_option(
				'postinfo-settings',  // group id
				'post_comment', // field id and option name
				__( 'Show Post Comment Count', 'calibrefx' ), // Label
				array(
					'option_type' => 'checkbox',
					'option_items' => '1',
					'option_default' => '1',
					'option_filter' => 'integer',
				), // Settings config
				5 //Priority
			);

			calibrefx_add_meta_option(
				'postinfo-settings',  // group id
				'post_category', // field id and option name
				__( 'Show Post Category', 'calibrefx' ), // Label
				array(
					'option_type' => 'checkbox',
					'option_items' => '1',
					'option_default' => '1',
					'option_filter' => 'integer',
				), // Settings config
				10 //Priority
			);

			calibrefx_add_meta_option(
				'postinfo-settings',  // group id
				'post_tags', // field id and option name
				__( 'Show Post Tags', 'calibrefx' ), // Label
				array(
					'option_type' => 'checkbox',
					'option_items' => '1',
					'option_default' => '1',
					'option_filter' => 'integer',
				), // Settings config
				15 //Priority
			);
		});

		//For breadcrumb settings
		add_action( 'content-settings_options', function() {
			calibrefx_add_meta_option(
				'breadcrumb-settings',  // group id
				'breadcrumb_home', // field id and option name
				__( 'Show Breadcrumb on Homepage', 'calibrefx' ), // Label
				array(
					'option_type' => 'checkbox',
					'option_items' => '1',
					'option_default' => '',
					'option_filter' => 'integer',
				), // Settings config
				1 //Priority
			);

			calibrefx_add_meta_option(
				'breadcrumb-settings',  // group id
				'breadcrumb_single', // field id and option name
				__( 'Show Breadcrumb on Blog Post','calibrefx' ), // Label
				array(
					'option_type' => 'checkbox',
					'option_items' => '1',
					'option_default' => '',
					'option_filter' => 'integer',
				), // Settings config
				5 //Priority
			);

			calibrefx_add_meta_option(
				'breadcrumb-settings',  // group id
				'breadcrumb_page', // field id and option name
				__( 'Show Breadcrumb on Static Page', 'calibrefx' ), // Label
				array(
					'option_type' => 'checkbox',
					'option_items' => '1',
					'option_default' => '',
					'option_filter' => 'integer',
				), // Settings config
				10 //Priority
			);

			calibrefx_add_meta_option(
				'breadcrumb-settings',  // group id
				'breadcrumb_archive', // field id and option name
				__( 'Show Breadcrumb on Archive / Category Page','calibrefx' ), // Label
				array(
					'option_type' => 'checkbox',
					'option_items' => '1',
					'option_default' => '',
					'option_filter' => 'integer',
				), // Settings config
				15 //Priority
			);

			calibrefx_add_meta_option(
				'breadcrumb-settings',  // group id
				'breadcrumb_404', // field id and option name
				__( 'Show Breadcrumb on 404 Page','calibrefx' ), // Label
				array(
					'option_type' => 'checkbox',
					'option_items' => '1',
					'option_default' => '',
					'option_filter' => 'integer',
				), // Settings config
				20 //Priority
			);

			calibrefx_add_meta_option(
				'breadcrumb-settings',  // group id
				'breadcrumb_description', // field id and option name
				__( 'Check it if you want to show breadcrumb in any of thoses pages.', 'calibrefx' ), // Label
				array(
					'option_type' => 'description',
				), // Settings config
				99 //Priority
			);
		});

		//For content archive settings
		add_action( 'content-settings_options', function() {
			calibrefx_add_meta_option(
				'content-archives-settings',  // group id
				'content_archive', // field id and option name
				__( 'How do you want to show the excerpt of the content on blog post list?', 'calibrefx' ), // Label
				array(
					'option_type' => 'select',
					'option_items' => apply_filters(
						'calibrefx_archive_display_options', array(
									'full' => __( 'Display post content', 'calibrefx' ),
									'excerpts' => __( 'Display post excerpts', 'calibrefx' ),
								)
					),
					'option_default' => 'full',
					'option_filter' => 'safe_text',
				), // Settings config
				1 //Priority
			);

			calibrefx_add_meta_option(
				'content-archives-settings',  // group id
				'content_archive_limit', // field id and option name
				__( 'Limit total characters for your content excerpt', 'calibrefx' ), // Label
				array(
					'option_type' => 'textinput',
					'option_default' => '500',
					'option_filter' => 'integer',
					'option_description' => __( 'To show all contents fill with <code>0</code>', 'calibrefx' ),
					'option_attr' => array('class' => 'calibrefx_content_limit_setting'),
				), // Settings config
				5 //Priority
			);
		});

		//For post navigation settings
		add_action( 'content-settings_options', function() {
			calibrefx_add_meta_option(
				'post-navigation-settings',  // group id
				'posts_nav', // field id and option name
				__( 'How do you want to show the post navigation?', 'calibrefx' ), // Label
				array(
					'option_type' => 'select',
					'option_items' => apply_filters(
						'calibrefx_post_navigation_options', array(
							'older-newer' => __( 'Older/Newer', 'calibrefx' ),
							'prev-next' => __( 'Previous/Next', 'calibrefx' ),
							'numeric' => __( 'Numeric', 'calibrefx' ),
							'disabled' => __( 'Don\'t show navigation' , 'calibrefx' ),
							)
					),
					'option_default' => 'older-newer',
					'option_filter' => 'safe_text',
					'option_description' => __( 'There are 3 types of pagination available. Choose which one is the best for you.', 'calibrefx' ),
				), // Settings config
				1 //Priority
			);
		});

		calibrefx_do_meta_options( $calibrefx->theme_settings, 'content-settings' );
	}

	/**
	 * Show Comment Settings Box
	 */
	function comment_setting() {
		global $calibrefx;

		calibrefx_add_meta_group( 'comment-settings', 'comment-display-settings', __( 'Comments', 'calibrefx' ) );
		calibrefx_add_meta_group( 'comment-settings', 'trackback-display-settings', __( 'Trackbacks', 'calibrefx' ) );
		calibrefx_add_meta_group( 'comment-settings', 'comment-social-settings', __( 'Social Comment Integration', 'calibrefx' ) );

		//For Comment Display settings
		add_action( 'comment-settings_options', function() {
			calibrefx_add_meta_option(
				'comment-display-settings',  // group id
				'comments_posts', // field id and option name
				__( 'Show comment on post?', 'calibrefx' ), // Label
				array(
					'option_type' => 'checkbox',
					'option_items' => '1',
					'option_default' => '',
					'option_filter' => 'integer',
				), // Settings config
				1 //Priority
			);
			calibrefx_add_meta_option(
				'comment-display-settings',  // group id
				'comments_pages', // field id and option name
				__( 'Show comment on page?', 'calibrefx' ), // Label
				array(
					'option_type' => 'checkbox',
					'option_items' => '1',
					'option_default' => '',
					'option_filter' => 'integer',
				), // Settings config
				5 //Priority
			);

			calibrefx_add_meta_option(
				'comment-display-settings',  // group id
				'comments_description', // field id and option name
				__( 'You can generally disabled comment on posts or pages. Uncheck it if you want to disable comment box.', 'calibrefx' ), // Label
				array(
					'option_type' => 'description',
				), // Settings config
				99 //Priority
			);
		});

		//For Trackback Display settings
		add_action( 'comment-settings_options', function() {
			calibrefx_add_meta_option(
				'trackback-display-settings',  // group id
				'trackbacks_posts', // field id and option name
				__( 'Show trackbacks on posts?', 'calibrefx' ), // Label
				array(
					'option_type' => 'checkbox',
					'option_items' => '1',
					'option_default' => '',
					'option_filter' => 'integer',
				), // Settings config
				1 //Priority
			);
			calibrefx_add_meta_option(
				'trackback-display-settings',  // group id
				'trackbacks_pages', // field id and option name
				__( 'Show trackbacks on pages?', 'calibrefx' ), // Label
				array(
					'option_type' => 'checkbox',
					'option_items' => '1',
					'option_default' => '',
					'option_filter' => 'integer',
				), // Settings config
				5 //Priority
			);

			calibrefx_add_meta_option(
				'trackback-display-settings',  // group id
				'trackbacks_description', // field id and option name
				__( 'You can generally disabled trackback / pingbacks on posts or pages. Uncheck it if you want to disable comment box. <br/>
					 Learn more about WordPress Trackbacks and Pingbacks <a href="https://make.wordpress.org/support/user-manual/building-your-wordpress-community/trackbacks-and-pingbacks/" target="_blank">here</a>', 'calibrefx' ), // Label
				array(
					'option_type' => 'description',
				), // Settings config
				99 //Priority
			);
		});

		//For Social Comment Integration
		add_action( 'comment-settings_options', function() {
			calibrefx_add_meta_option(
				'comment-social-settings',  // group id
				'facebook_comments', // field id and option name
				__( 'Use Facebook comment instead of WordPress Default Comment', 'calibrefx' ), // Label
				array(
					'option_type' => 'checkbox',
					'option_items' => '1',
					'option_default' => '',
					'option_filter' => 'integer',
					'option_description' => __( 'You can override WordPress default comment to use Facebook comment box. Please check it if you would like to activate it.', 'calibrefx' ),
				), // Settings config
				1 //Priority
			);
		});

		calibrefx_do_meta_options( $calibrefx->theme_settings, 'comment-settings' );
	}

	/**
	 * Show default layout box
	 */
	function layout_box() {
		global $calibrefx;

		calibrefx_add_meta_group( 'layout-settings', 'layout-general-settings', __( 'Layout Settings', 'calibrefx' ) );
		calibrefx_add_meta_group( 'layout-settings', 'layout-type-settings', __( 'General Layout Settings', 'calibrefx' ) );
		calibrefx_add_meta_group( 'layout-settings', 'feature-image-settings', __( 'Feature Image Settings', 'calibrefx' ) );

		 //For Layout Settings
		add_action( 'layout-settings_options', function() {
			calibrefx_add_meta_option(
				'layout-general-settings',  // group id
				'layout_type', // field id and option name
				__( 'How would you like the main layout of the website?', 'calibrefx' ), // Label
				array(
					'option_type' => 'select',
					'option_items' => apply_filters(
						'calibrefx_layout_type_options', array(
								'static' => __( 'Fix Width Layout', 'calibrefx' ),
								'fluid' => __( 'Fluid Layout', 'calibrefx' ),
							)
					),
					'option_default' => 'static',
					'option_filter' => 'safe_text',
				), // Settings config
				1 //Priority
			);

			calibrefx_add_meta_option(
				'layout-general-settings',  // group id
				'calibrefx_layout_width', // field id and option name
				__( 'Layout Width (pixels)', 'calibrefx' ), // Label
				array(
					'option_type' => 'textinput',
					'option_default' => '940',
					'option_filter' => 'integer',
					'option_attr' => array('class' => 'calibrefx_layout_width'),
				), // Settings config
				5 //Priority
			);

			calibrefx_add_meta_option(
				'layout-general-settings',  // group id
				'calibrefx_layout_wrapper_fixed', // field id and option name
				__( 'Use Wrapper Border Box', 'calibrefx' ), // Label
				array(
					'option_type' => 'checkbox',
					'option_items' => '1',
					'option_default' => '',
					'option_filter' => 'integer',
					'option_description' => __( 'Check this if you want to have wrapper box layout.', 'calibrefx' ),
					'option_attr' => array('class' => 'calibrefx_layout_width'),
				), // Settings config
				6 //Priority
			);

			calibrefx_add_meta_option(
				'layout-general-settings',  // group id
				'responsive_disabled', // field id and option name
				__( 'Check this to disable responsive', 'calibrefx' ), // Label
				array(
					'option_type' => 'checkbox',
					'option_items' => '1',
					'option_default' => '0',
					'option_filter' => 'integer',
					'option_description' => __( 'Check this if you want to disable mobile responsive feature', 'calibrefx' ),
				), // Settings config
				15 //Priority
			);
		});

		//For General Layout Settings
		add_action( 'layout-settings_options', function() {
			calibrefx_add_meta_option(
				'layout-type-settings',  // group id
				'site_layout', // field id and option name
				__( 'Pick your general layout column','calibrefx' ), // Label
				array(
					'option_type' => 'custom',
					'option_custom' => calibrefx_layout_selector(array(
							'name' => 'calibrefx-settings[site_layout]',
							'selected' => calibrefx_get_option( 'site_layout' ),
							'echo' => false ) ),
					'option_default' => '',
					'option_filter' => '',
					'option_attr' => array('class' => 'calibrefx-layout-selector'),
					'option_description' => __( 'You can choose your Website layout. You can override per post / page later.', 'calibrefx' ),
				), // Settings config
				1 //Priority
			);

			calibrefx_add_meta_option(
				'layout-type-settings',  // group id
				'sidebar_width', // field id and option name
				__( 'Customize Your Sidebar Width','calibrefx' ), // Label
				array(
					'option_type' => 'select',
					'option_items' => array(
								'2' => __( '2/12 of total columns', 'calibrefx' ),
								'3' => __( '3/12 of total columns', 'calibrefx' ),
								'4' => __( '4/12 of total columns', 'calibrefx' ),
								'5' => __( '5/12 of total columns', 'calibrefx' ),
								'6' => __( '6/12 of total columns', 'calibrefx' ),
							),
					'option_default' => '4',
					'option_attr' => array('class' => 'calibrefx-sidebar-width'),
					'option_filter' => 'safe_text',
				), // Settings config
				1 //Priority
			);
		});

		//For Feature Image Layout Settings
		add_action( 'layout-settings_options', function() {
			calibrefx_add_meta_option(
				'feature-image-settings',  // group id
				'feature_image_layout', // field id and option name
				__( 'How do you want to show the feature image?','calibrefx' ), // Label
				array(
					'option_type' => 'select',
					'option_items' => apply_filters(
						'calibrefx_layout_type_options', array(
								'thumbnail' => __( 'Square Thumbnail', 'calibrefx' ),
								'full' => __( 'Full Width', 'calibrefx' ),
								'none' => __( 'None', 'calibrefx' ),
							)
					),
					'option_default' => 'full',
					'option_filter' => 'safe_text',
				), // Settings config
				1 //Priority
			);
		});

		calibrefx_do_meta_options( $calibrefx->theme_settings, 'layout-settings' );

	}

	/**
	 * Show setting box inside Theme Settings
	 */
	function custom_script_box() {
		global $calibrefx;

		calibrefx_add_meta_group( 'themelayout-script-settings', 'custom-css-settings', __( 'Style Customization', 'calibrefx' ) );
		calibrefx_add_meta_group( 'themelayout-script-settings', 'custom-script-settings', __( 'Javascript Customization', 'calibrefx' ) );

		add_action( 'themelayout-script-settings_options', function() {
			calibrefx_add_meta_option(
				'custom-css-settings',  // group id
				'custom_css', // field id and option name
				__( 'Custom CSS code will be output at <code>wp_head()</code>', 'calibrefx' ), // Label
				array(
					'option_type' => 'textarea',
					'option_default' => '',
					'option_filter' => 'no_html',
					'option_description' => __( 'You can add your custom css codes here. Example: <code>a.hover {color:#ffffff}</code>.', 'calibrefx' ),
				), // Settings config
				1 //Priority
			);

			calibrefx_add_meta_option(
				'custom-script-settings',  // group id
				'header_scripts', // field id and option name
				__( 'Header script will be output at <code>wp_head()</code>', 'calibrefx' ), // Label
				array(
					'option_type' => 'textarea',
					'option_default' => '',
					'option_filter' => 'no_filter',
					'option_description' => __( 'You can add your javascript at the head of the page. For example Google analytics code. <br/>Samples: <code>&lt;script type="text/javascript">alert("Hello World");&lt;/script></code>.', 'calibrefx' ),
				), // Settings config
				1 //Priority
			);

			calibrefx_add_meta_option(
				'custom-script-settings',  // group id
				'footer_scripts', // field id and option name
				__( 'Footer scripts will be output at <code>wp_footer()</code>', 'calibrefx' ), // Label
				array(
					'option_type' => 'textarea',
					'option_default' => '',
					'option_filter' => 'no_filter',
					'option_description' => __( 'You can add your javascript at the footer of the page. For example Google analytics code. <br/>Samples: <code>&lt;script type="text/javascript">alert("Hello World");&lt;/script></code>.', 'calibrefx' ),
				), // Settings config
				5 //Priority
			);
		});

		calibrefx_do_meta_options( $calibrefx->theme_settings, 'themelayout-script-settings' );
	}

	/**
	 * This function socials_integrated_box is to show social media setting
	 */
	function socials_integrated_box() {
		global $calibrefx;

		calibrefx_add_meta_group( 'themesocial-settings', 'facebook-settings', __( 'Facebook Settings', 'calibrefx' ) );
		calibrefx_add_meta_group( 'themesocial-settings', 'social-settings', __( 'Social URL Settings', 'calibrefx' ) );
		calibrefx_add_meta_group( 'themesocial-settings', 'feed-settings', __( 'RSS Feed Settings', 'calibrefx' ) );

		add_action( 'themesocial-settings_options', function() {
			calibrefx_add_meta_option(
				'facebook-settings',  // group id
				'facebook_admins', // field id and option name
				__( 'Facebook Admin ID', 'calibrefx' ), // Label
				array(
					'option_type' => 'textinput',
					'option_default' => 'anyvalue',
					'option_filter' => 'safe_text',
					'option_description' => __( "This will be use for Facebook Insight. <br/>This will output: <code>&lt;meta property=\"fb:admins\" content=\"YOUR ADMIN ID HERE\"/></code> Read More about this <a href='https://developers.facebook.com/docs/insights/' target='_blank'>here</a>.", 'calibrefx' ),
				), // Settings config
				1 //Priority
			);

			calibrefx_add_meta_option(
				'facebook-settings',  // group id
				'facebook_og_type', // field id and option name
				__( 'Facebook Page Type', 'calibrefx' ), // Label
				array(
						'option_type' => 'select',
						'option_items' => apply_filters(
							'calibrefx_facebook_og_types', array(
										'article' => 'Article',
										'website' => 'Website',
										'blog' => 'Blog',
										'movie' => 'Movie',
										'song' => 'Song',
										'product' => 'Product',
										'book' => 'Book',
										'food' => 'Food',
										'drink' => 'Drink',
										'activity' => 'Activity',
										'sport' => 'Sport',
										)
						),
						'option_default' => 'website',
						'option_filter' => 'safe_text',
						'option_description' => __( 'This is open graph protocol that helo to identify your content. <br/>This will output: <code>&lt;meta property="og:type" content="TYPE"/></code>', 'calibrefx' ),
					), // Settings config
				5 //Priority
			);
		} );

		add_action( 'themesocial-settings_options', function() {
			calibrefx_add_meta_option(
				'social-settings',  // group id
				'gplus_profile', // field id and option name
				__( 'Google+ Profile URL', 'calibrefx' ), // Label
				array(
						'option_type' => 'textinput',
						'option_default' => '',
						'option_filter' => 'safe_url',
						'option_description' => __( 'This will output <code>&lt;link rel="author" href="YOUR GOOGLE+ URL HERE"/></code> in html head.', 'calibrefx' ),
						'option_attr' => array('class' => 'fullwidth'),
					), // Settings config
				1 //Priority
			);

			calibrefx_add_meta_option(
				'social-settings',  // group id
				'gplus_page', // field id and option name
				__( 'Google+ Page URL', 'calibrefx' ), // Label
				array(
						'option_type' => 'textinput',
						'option_default' => '',
						'option_filter' => 'safe_url',
						'option_description' => __( 'This will use for Google Page For Business url, and it will show if using the Social Widget', 'calibrefx' ),
						'option_attr' => array('class' => 'fullwidth'),
					), // Settings config
				5 //Priority
			);

			calibrefx_add_meta_option(
				'social-settings',  // group id
				'facebook_fanpage', // field id and option name
				__( 'Facebook Page URL', 'calibrefx' ), // Label
				array(
						'option_type' => 'textinput',
						'option_default' => '',
						'option_filter' => 'safe_url',
						'option_description' => __( 'This will use for Facebook Page url, and it will show if using the Social Widget', 'calibrefx' ),
						'option_attr' => array('class' => 'fullwidth'),
					), // Settings config
				10 //Priority
			);

			calibrefx_add_meta_option(
				'social-settings',  // group id
				'twitter_profile', // field id and option name
				__( 'Twitter Profile URL', 'calibrefx' ), // Label
				array(
						'option_type' => 'textinput',
						'option_default' => '',
						'option_filter' => 'safe_url',
						'option_description' => __( 'This will use for Twitter url, and it will show if using the Social Widget', 'calibrefx' ),
						'option_attr' => array('class' => 'fullwidth'),
					), // Settings config
				15 //Priority
			);

			calibrefx_add_meta_option(
				'social-settings',  // group id
				'youtube_channel', // field id and option name
				__( 'Youtube Channel URL', 'calibrefx' ), // Label
				array(
						'option_type' => 'textinput',
						'option_default' => '',
						'option_filter' => 'safe_url',
						'option_description' => __( 'This will use for Youtube Channel url, and it will show if using the Social Widget', 'calibrefx' ),
						'option_attr' => array('class' => 'fullwidth'),
					), // Settings config
				20 //Priority
			);

			calibrefx_add_meta_option(
				'social-settings',  // group id
				'linkedin_profile', // field id and option name
				__( 'Linkedin Profile URL', 'calibrefx' ), // Label
				array(
						'option_type' => 'textinput',
						'option_default' => '',
						'option_filter' => 'safe_url',
						'option_description' => __( 'This will use for Linkedin url, and it will show if using the Social Widget', 'calibrefx' ),
						'option_attr' => array('class' => 'fullwidth'),
					), // Settings config
				25 //Priority
			);

			calibrefx_add_meta_option(
				'social-settings',  // group id
				'pinterest_profile', // field id and option name
				__( 'Pinterest Profile URL', 'calibrefx' ), // Label
				array(
						'option_type' => 'textinput',
						'option_default' => '',
						'option_filter' => 'safe_url',
						'option_description' => __( 'This will use for Pinterest url, and it will show if using the Social Widget', 'calibrefx' ),
						'option_attr' => array('class' => 'fullwidth'),
					), // Settings config
				30 //Priority
			);

			calibrefx_add_meta_option(
				'social-settings',  // group id
				'instagram_profile', // field id and option name
				__( 'Instagram Profile URL', 'calibrefx' ), // Label
				array(
						'option_type' => 'textinput',
						'option_default' => '',
						'option_filter' => 'safe_url',
						'option_description' => __( 'This will use for Instagram url, and it will show if using the Social Widget', 'calibrefx' ),
						'option_attr' => array('class' => 'fullwidth'),
					), // Settings config
				35 //Priority
			);

			calibrefx_add_meta_option(
				'social-settings',  // group id
				'github_profile', // field id and option name
				__( 'Github Profile URL', 'calibrefx' ), // Label
				array(
						'option_type' => 'textinput',
						'option_default' => '',
						'option_filter' => 'safe_url',
						'option_description' => __( 'This will use for Github url, and it will show if using the Social Widget', 'calibrefx' ),
						'option_attr' => array('class' => 'fullwidth'),
					), // Settings config
				40 //Priority
			);
		} );

		add_action( 'themesocial-settings_options', function() {
			calibrefx_add_meta_option(
				'feed-settings',  // group id
				'feed_uri', // field id and option name
				__( 'Main Feed URL', 'calibrefx' ), // Label
				array(
						'option_type' => 'textinput',
						'option_default' => '',
						'option_filter' => 'safe_text',
						'option_description' => __( 'You can replace WordPress builtin Feed URL using this options. For sample you want to use feedburner instead. <br/>Sample: <code>http://feeds2.feedburner.com/calibrefx.</code>', 'calibrefx' ),
						'option_attr' => array('class' => 'fullwidth'),
					), // Settings config
				1 //Priority
			);

			calibrefx_add_meta_option(
				'feed-settings',  // group id
				'comments_feed_uri', // field id and option name
				__( 'Comment Feed URL', 'calibrefx' ), // Label
				array(
						'option_type' => 'textinput',
						'option_default' => '',
						'option_filter' => 'safe_text',
						'option_description' => __( 'You can replace WordPress builtin Feed URL using this options. For sample you want to use feedburner instead. <br/>Sample: <code>http://feeds2.feedburner.com/calibrefxcomment.</code>', 'calibrefx' ),
						'option_attr' => array('class' => 'fullwidth'),
					), // Settings config
				2 //Priority
			);
		} );

		calibrefx_do_meta_options( $calibrefx->theme_settings, 'themesocial-settings' );
	}

	public function render_page() {
		$list_table = Calibrefx_Modules_List_Table::get_instance();

		?>
        <div class="page-content configure">
            <div class="frame top hide-if-no-js">
                <div class="wrap">
                    <div class="manage-left">
                        <form class="calibrefx-modules-list-table-form" onsubmit="return false;">
                        <table class="<?php echo implode( ' ', $list_table->get_table_classes() ); ?>">
                            <tbody id="the-list">
                                <?php $list_table->display_rows_or_placeholder(); ?>
                            </tbody>
                        </table>
                        </form>
                    </div>
                </div><!-- /.wrap -->
            </div><!-- /.frame -->
        </div>
        <?php
	}

	public function module_activation(){
		$list_table = Calibrefx_Modules_List_Table::get_instance();

		$action = $list_table->current_action();
		if ( $action ) {
			switch ( $action ) {
				case 'activate':
					$module = stripslashes( $_GET['module'] );
					check_admin_referer( "calibrefx_activate-$module" );
					Calibrefx::activate_module( $module );

					wp_safe_redirect( Calibrefx::admin_url( 'page=calibrefx&section=modules' ) );
					exit;
				case 'deactivate':
					$modules = stripslashes( $_GET['module'] );
					check_admin_referer( "calibrefx_deactivate-$modules" );
					foreach ( explode( ',', $modules ) as $module ) {
						Calibrefx::deactivate_module( $module );
					}
					wp_safe_redirect( Calibrefx::admin_url( 'page=calibrefx&section=modules' ) );
					exit;
			}
		}
	}

	public function info_box() { ?>
        <p>
            <span class="description">
            Below is the CalibreFx Framework Informations. All the codes and informations is copyrighted by <a href="http://www.calibreworks.com" target="_blank">Calibreworks</a>. 
            CalibreFx is released under the GPL v2. For license information please refer to the license.txt in themes folder.
            </span>
        </p>
        <p><strong><?php _e( 'Framework Name: ', 'calibrefx' ); ?></strong><?php echo FRAMEWORK_NAME; ?> (<?php _e( 'Codename: ', 'calibrefx' ); echo FRAMEWORK_CODENAME; ?>)</p>
        <p><strong><?php _e( 'Version:', 'calibrefx' ); ?></strong> <?php echo FRAMEWORK_VERSION; ?> <?php echo '&middot;'; ?> <strong><?php _e( 'Released:', 'calibrefx' ); ?></strong> <?php echo FRAMEWORK_RELEASE_DATE; ?></p>
        <p><strong><?php _e( 'DB Version: ', 'calibrefx' ); ?></strong><?php echo FRAMEWORK_DB_VERSION; ?></p>
        <?php

		if ( is_child_theme() ) { ?>
            <hr class="div" />
            <h4>Themes Information</h4>
            <p><strong><?php _e( 'Themes Name: ', 'calibrefx' ); ?></strong><?php echo CHILD_THEME_NAME; ?> </p>
            <p><strong><?php _e( 'Version:', 'calibrefx' ); ?></strong> <?php echo CHILD_THEME_VERSION; ?> </p>
            <p><strong><?php _e( 'Themes Author URL:', 'calibrefx' ); ?></strong> <?php echo CHILD_THEME_URL; ?> </p>
        <?php
		}
	}

	public function tos_generator() {
		$name = '';
		$url = '';
		$info = '';

		$asp = '';
		$cn = '';
		$disclaimer = '';
		$dmca = '';
		$federal = '';
		$privacy = '';
		$social = '';
		$terms = '';

		if ( isset( $_POST['name']) && isset( $_POST['url']) ) {

			$name = $_POST['name'];
			$url = $_POST['url'];
			$info = $_POST['info'];

			$response = wp_remote_post( 'http://www.calibreworks.com/tosgen/api.php', array(
				'method' => 'POST',
				'timeout' => 60,
				'redirection' => 5,
				'httpversion' => '1.0',
				'blocking' => true,
				'headers' => array(),
				'body' => array(
				'company_name' => $_POST['name'],
				'company_url' => $_POST['url'],
				'company_info' => $_POST['info'],
				),
				'cookies' => array(),
				)
			);

			$json = json_decode( $response['body'] );

			$asp = $json->data->asp;
			$cn = $json->data->cn;
			$disclaimer = $json->data->disclaimer;
			$dmca = $json->data->dmca;
			$federal = $json->data->federal;
			$privacy = $json->data->privacy;
			$social = $json->data->social;
			$terms = $json->data->terms;

		}
	?>
        <h3 class="section-title">Your Company Information</h3>
        <div class="option-item">
			<p class="calibrefx_legal_generator" style="">
				<label for="name">Company Name</label>
				<input type="text" id="name" name="name" value="<?php echo $name;?>" class="form-control calibrefx_legal_generator" style="">
			</p>
			<p class="description">
				Type your company name
			</p>
        </div>
        <div class="option-item">
			<p class="calibrefx_legal_generator" style="">
				<label for="url">Company Website URL</label>
				<input type="text" id="url" name="url" value="<?php echo $url;?>" class="form-control calibrefx_legal_generator" style="">
			</p>
			<p class="description">
				Type your company website url
			</p>
        </div>
        <div class="option-item">
			<p>
				<label for="info">Company Complete Address</label>
				<textarea id="info" name="info" class="form-control "><?php echo $info;?></textarea>
			</p>
			<p class="description">
				Type your company address
			</p>
        </div>

        <div class="calibrefx-legal-button">
            <div class="clear"></div>
            <button type="submit" class="calibrefx-h2-button calibrefx-settings-submit-button"><i class="fa fa-legal fa-2"></i> Generate Legal Content</button>
        </div>
        <p class="description">Note: by pressing this button won't save anything in your content nor your settings. It's just to generate the content below.</p>

        <hr class="div" />

        <h3 class="section-title">Legal Page Content</h3>
        <p class="description">
        	Please copy and paste the content according to your need. Or use the generate button after each section to create the page automatically
        </p>
        
        <div class="option-item">
			<p>
				<label for="privacy">Privacy Policy</label>
				<textarea id="privacy" name="privacy" class="form-control "><?php echo $privacy;?></textarea>
			</p>
			<p class="description">Please press the button to create the page <button class="button button-secondary button-large button-ajax" data-action="create-legal-page" data-param="privacy" data-nonce="<?php echo wp_create_nonce( 'cfx_create-legal-page_privacy' ); ?>">Create Privacy Policy Page</button> </p>
        </div>

        <div class="option-item">
			<p>
				<label for="terms">Terms Of Service &amp; Conditions Of Use</label>
				<textarea id="terms" name="terms" class="form-control "><?php echo $terms;?></textarea>
			</p>
			<p class="description">Please press the button to create the page <button class="button button-secondary button-large button-ajax" data-action="create-legal-page" data-param="tos" data-nonce="<?php echo wp_create_nonce( 'cfx_create-legal-page_tos' ); ?>">Create TOS Page</button> </p>
        </div>

        <div class="option-item">
			<p>
				<label for="asp">Anti-Spam Policy</label>
				<textarea id="asp" name="asp" class="form-control "><?php echo $asp;?></textarea>
			</p>
			<p class="description">Please press the button to create the page <button class="button button-secondary button-large button-ajax" data-action="create-legal-page" data-param="asp" data-nonce="<?php echo wp_create_nonce( 'cfx_create-legal-page_asp' ); ?>">Create Anti Spam Policy Page</button> </p>
        </div>
		
		<div class="option-item">
			<p>
				<label for="cn">Copyright Notice</label>
				<textarea id="cn" name="cn" class="form-control "><?php echo $cn;?></textarea>
			</p>
			<p class="description">Please press the button to create the page <button class="button button-secondary button-large button-ajax" data-action="create-legal-page" data-param="cn" data-nonce="<?php echo wp_create_nonce( 'cfx_create-legal-page_cn' ); ?>">Copyright Notice Page</button> </p>
        </div>
		
		<div class="option-item">
			<p>
				<label for="disclaimer">Disclaimer</label>
				<textarea id="disclaimer" name="disclaimer" class="form-control "><?php echo $disclaimer;?></textarea>
			</p>
			<p class="description">Please press the button to create the page <button class="button button-secondary button-large button-ajax" data-action="create-legal-page" data-param="disclaimer" data-nonce="<?php echo wp_create_nonce( 'cfx_create-legal-page_disclaimer' ); ?>">Create Disclaimer Page</button> </p>
        </div>
       	
       	<div class="option-item">
			<p>
				<label for="dmca">DMCA Compliance</label>
				<textarea id="dmca" name="dmca" class="form-control "><?php echo $dmca;?></textarea>
			</p>
			<p class="description">Please press the button to create the page <button class="button button-secondary button-large button-ajax" data-action="create-legal-page" data-param="dmca" data-nonce="<?php echo wp_create_nonce( 'cfx_create-legal-page_dmca' ); ?>">Create DMCA Page</button> </p>
        </div>

        <div class="option-item">
			<p>
				<label for="federal">Federal Trade Commission Compliance</label>
				<textarea id="federal" name="federal" class="form-control "><?php echo $federal;?></textarea>
			</p>
			<p class="description">Please press the button to create the page <button class="button button-secondary button-large button-ajax" data-action="create-legal-page" data-param="federal" data-nonce="<?php echo wp_create_nonce( 'cfx_create-legal-page_federal' ); ?>">Create Federal Compliance Page</button> </p>
        </div>
        
        <div class="option-item">
			<p>
				<label for="social">Social Media Disclosure</label>
				<textarea id="social" name="social" class="form-control "><?php echo $social;?></textarea>
			</p>
			<p class="description">Please press the button to create the page <button class="button button-secondary button-large button-ajax" data-action="create-legal-page" data-param="social" data-nonce="<?php echo wp_create_nonce( 'cfx_create-legal-page_social' ); ?>">Create Social Media Disclosure Page</button> </p>
        </div>
        
        <script type="text/javascript">tos_bind_events();</script>
    <?php
	}

	public function import_settings() {
	?>
        <p><?php _e( 'Upload the data file (<code>.json</code>) from your computer and we\'ll import your settings.', 'calibrefx' ); ?></p>
        <p><?php _e( 'Choose the file from your computer and click "Upload file and Import"', 'calibrefx' ); ?></p>
        <p>
            <input type="hidden" name="calibrefx-import" value="1" />
            <label for="calibrefx-import-upload"><?php sprintf( __( 'Upload File: (Maximum Size: %s)', 'calibrefx' ), ini_get( 'post_max_size' ) ); ?></label>
            <input type="file" id="calibrefx-import-upload" name="calibrefx-import-upload" size="25" />
            <!-- <input type="hidden" name="calibrefx_do_import" value="1" /> -->
            <br/><br/>
            <input type="submit" name="calibrefx_do_import" class="button-primary calibrefx-h2-button" value="<?php _e( 'Import Settings', 'calibrefx' ) ?>" />
        </p>
    <?php
	}

	public function export_settings() {
	?>
        <p><span class="description"><?php _e( 'Press the download button below to export all the settings to file', 'calibrefx' ); ?></span></p>
        <p>
            <input type="submit" name="calibrefx_do_export" class="button-primary calibrefx-h2-button" value="<?php _e( 'Export Settings', 'calibrefx' ) ?>" />
        </p>
        
    <?php
	}

	protected function get_export_options() {
		global $calibrefx;

		$options = array(
			'theme_settings' => array(
				'label'          => __( 'Theme Settings', 'calibrefx' ),
				'settings-field' => 'calibrefx-settings',
			),
		);

		return (array) apply_filters( 'calibrefx_export_options', $options );

	}

	public function do_export() {
		
		$options = $this->get_export_options();

		$settings = array();

		foreach ( $options as $option ) {
			/** Grab settings field name (key) */
			$settings_field = $option['settings-field'];

			/** Grab all of the settings from the database under that key */
			$settings[$settings_field] = get_option( $settings_field );
		}

		/** Check there's something to export */
		if ( empty( $settings ) ) {
			return; 
		}

		$output = json_encode( (array) $settings );

		/** Prepare and send the export file to the browser */
		header( 'Content-Description: File Transfer' );
		header( 'Cache-Control: public, must-revalidate' );
		header( 'Pragma: hack' );
		header( 'Content-Type: text/plain' );
		header( 'Content-Disposition: attachment; filename="calibrefx-' . date( 'Ymd-His' ) . '.json"' );
		header( 'Content-Length: ' . strlen( $output ) );
		echo $output;
		exit;
	}

	public function do_import() {

		$url       = wp_nonce_url( admin_url( 'admin.php?page=calibrefx-other&section=importexport' ), 'calibrefx-import' );
		$tools_url = admin_url( 'admin.php?page=calibrefx-other&section=importexport' );

		if ( ! isset( $_REQUEST['_wpnonce'] ) && wp_verify_nonce( $_REQUEST['_wpnonce'], 'debug_action' ) ) {
			wp_redirect( $tools_url );
			exit;
		}

		if ( false === ( $creds = request_filesystem_credentials( $url, '', false, false, null ) ) ) {
			wp_redirect( $tools_url );
			exit;
		}

		if ( ! WP_Filesystem( $creds ) ) {
			request_filesystem_credentials( $url, '', true, false, null );

			wp_redirect( $tools_url );
			exit;
		}

		global $wp_filesystem;

		/** Extract file contents */
		$upload = $wp_filesystem->get_contents( $_FILES['calibrefx-import-upload']['tmp_name'] );

		/** Decode the JSON */
		$options = json_decode( $upload, true );

		/** Check for errors */
		if ( ! $options || $_FILES['calibrefx-import-upload']['error'] ) {
			$redir_url = admin_url( 'admin.php?page=' . $this->page_id . '&section=importexport&error=true' );
			wp_redirect( esc_url_raw( $redir_url ) );
			exit;
		}

		/** Cycle through data, import settings */
		foreach ( (array) $options as $key => $settings ) {
			update_option( $key, $settings );
		}

		/** Redirect, add success flag to the URI */
		$redir_url = admin_url( 'admin.php?page=' . $this->page_id . '&section=importexport&import=true' );
		wp_redirect( esc_url_raw( $redir_url ) );
		exit;
	}
}


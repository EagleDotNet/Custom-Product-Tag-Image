<?php
/**
 * Main class start.
 *
 * @package : email
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Main custom image function start.
 */
class KA_Custom_Image_Tag {
	/**
	 * Main constucter function start.
	 *
	 * @param int $plugin_name First item.
	 * @var missing variable.
	 * missing short description.
	 */
	public $plugin_name;
	/**
	 * Main constucter function start.
	 *
	 * @param intb $zci_placeholder First item.
	 * @var missing variable.
	 * missing short description.
	 */
	private $zci_placeholder;
	/**
	 * Main constucter function start.
	 */
	public function __construct() {

		add_action( 'admin_init', array( $this, 'ka_admin_init' ) );

		// save our taxonomy image while edit or create term.
		add_action( 'edit_term', array( $this, 'z_save_taxonomy_image' ) );
		add_action( 'create_term', array( $this, 'z_save_taxonomy_image' ) );
		// add submenu in woocommerce.
		add_action( 'admin_menu', array( $this, 'k_a_custom_image_tag_submenu' ) );

		add_action( 'admin_init', array( $this, 'new_action' ) );

		add_action( 'admin_enqueue_scripts', array( $this, 'ka_font_scripts' ) );

	}
	/**
	 * Main submenu funtion start.
	 */
	public function k_a_custom_image_tag_submenu() {
		add_submenu_page(
			'woocommerce', // parent slug.
			'Custom Product Tag Image', // Page title.
			esc_html__( 'Custom Product Tag Image', ' koalaapps_tag' ), // Title.
			'manage_options', // Capability.
			'ka_settings', // slug.
			array( $this, 'create_setting_page' )
		);
	}
	/**
	 * Main class start.
	 */
	public function create_setting_page() {
		global $active_tab;
		if ( isset( $_GET['tab'] ) ) {
			$active_tab = sanitize_text_field( wp_unslash( $_GET['tab'] ) );
		} else {
			$active_tab = 'general_settings';
		}
		?>
		<div class="wrap">
		<!-- Title above Tabs  -->
		<h2> <?php echo esc_html__( 'Custom Product Tag Image Settings', 'koalaapps_tag' ); ?></h2>
		<h2 class="nav-tab-wrapper">
		<!-- General Setting Tab -->
		<a href="?post_type=ka_settings&page=ka_settings&tab=general_settings" class="nav-tab  <?php echo esc_attr( $active_tab ) === 'general_settings' ? ' nav-tab-active' : ''; ?>" > <?php esc_html_e( 'General Settings', 'koalaapps_tag' ); ?> </a>
		</h2>
	<form method="post" action="options.php">
		<?php
		if ( isset( $_POST['_wpnonce'] ) ) {
			$nonce = sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) );
			if ( ! wp_verify_nonce( $nonce, '_wpnonce' ) ) {
				die( 'Failed Security check' );
			}
		}
		// General Setting Tab.
		if ( 'general_settings' === $active_tab ) {
			settings_fields( 'ka_product_general_setting' );
			do_settings_sections( 'ka_product_description_settings_page' );
		}

		settings_fields( 'ka_product_style_setting' );
		do_settings_sections( 'ka_product_settings_page' );

		echo '<div class= "div2">';
		submit_button( esc_html__( 'Save Settings', 'koalaapps_tag' ), 'primary' );
		echo '</div>';
		?>
</form>

		<?php
	}
	/**
	 * Main class start.
	 */
	public function new_action() {

		add_settings_section(
			'ka_product_section', // ID used to identify this section and with which to register options.
			'',  // Title to be displayed on the administration page.
			array( $this, 'settings_section_c_b' ), // Callback used to render the description of the section.
			'ka_product_settings_page'      // Page on which to add this section of options.
		);
			add_settings_field(
				'ka_product_field', // ID used to identify the field throughout the theme.
				esc_html__( 'Visibility ', ' koalaapps_tag' ), // The label to the left of the option interface element.
				array( $this, 'product_setting_field_callback' ),   // The name of the function responsible for rendering the option interface.
				'ka_product_settings_page', // The page on which this option will be displayed.
				'ka_product_section' // The name of the section to which this field belongs.
			);
			register_setting(
				'ka_product_style_setting',
				'ka_product_field'
			);

		add_settings_section(
			'ka_position_section', // ID used to identify this section and with which to register options.
			'',  // Title to be displayed on the administration page.
			array( $this, 'settings_section_p_t' ), // Callback used to render the description of the section.
			'ka_product_settings_page'      // Page on which to add this section of options.
		);
			add_settings_field(
				'ka_position_field', // ID used to identify the field throughout the them.
				esc_html__( 'Tag Position on Product Page', ' koalaapps_tag' ), // The label to the left of the option interface element.
				array( $this, 'position_setting_field_callback' ),   // The name of the function responsible for rendering the option interface.
				'ka_product_settings_page', // The page on which this option will be displayed.
				'ka_position_section' // The name of the section to which this field belongs.
			);
			register_setting(
				'ka_product_style_setting',
				'ka_position_field'
			);

		add_settings_section(
			'ka_Archive_section', // ID used to identify this section and with which to register options.
			'',  // Title to be displayed on the administration page.
			array( $this, 'settings_section_ar_s' ), // Callback used to render the description of the section.
			'ka_product_settings_page'      // Page on which to add this section of options.
		);
			add_settings_field(
				'ka_Archive_field', // ID used to identify the field throughout the theme.
				esc_html__( 'Tag Position on Archive Page', ' koalaapps_tag' ), // The label to the left of the option interface element.
				array( $this, 'archive_setting_field_callback' ),   // The name of the function responsible for rendering the option interface.
				'ka_product_settings_page', // The page on which this option will be displayed.
				'ka_Archive_section' // The name of the section to which this field belongs.
			);
			register_setting(
				'ka_product_style_setting',
				'ka_Archive_field'
			);




			add_settings_section(
			'ka_short_code_section', // ID used to identify this section and with which to register options.
			'',  // Title to be displayed on the administration page.
			array( $this, 'settings_section_tage' ), // Callback used to render the description of the section.
			'ka_product_settings_page' // Page on which to add this section of options.
		);
			add_settings_field(
				'ka_shortcode_field', // ID used to identify the field throughout the theme.
				esc_html__( 'Tags Page Shortcode ', ' koalaapps_tag' ), // The label to the left of the option interface element.
				array( $this, 'page_shordcode_tags_call_back' ),   // The name of the function responsible for rendering the option interface.
				'ka_product_settings_page', // The page on which this option will be displayed.
				'ka_short_code_section' // The name of the section to which this field belongs.
			);
			register_setting(
				'ka_product_style_setting',
				'ka_shortcode_field'
			);



		add_settings_section(
			'ka_format_section', // ID used to identify this section and with which to register options.
			'',  // Title to be displayed on the administration page.
			array( $this, 'settings_section_f_s' ), // Callback used to render the description of the section.
			'ka_product_settings_page' // Page on which to add this section of options.
		);
			add_settings_field(
				'ka_format_field', // ID used to identify the field throughout the theme.
				esc_html__( 'Display Format ', ' koalaapps_tag' ), // The label to the left of the option interface element.
				array( $this, 'format_setting_field_callback' ),   // The name of the function responsible for rendering the option interface.
				'ka_product_settings_page', // The page on which this option will be displayed.
				'ka_format_section' // The name of the section to which this field belongs.
			);
			register_setting(
				'ka_product_style_setting',
				'ka_format_field'
			);

			add_settings_section(
				'ka_new_format_section', // ID used to identify this section and with which to register options.
				'',  // Title to be displayed on the administration page.
				array( $this, 'settings_section_nf_s' ), // Callback used to render the description of the section.
				'ka_product_settings_page'      // Page on which to add this section of options.
			);
			add_settings_field(
				'ka_new_format_field', // ID used to identify the field throughout the theme.
				esc_html__( 'Display Icon as', ' koalaapps_tag' ), // The label to the left of the option interface element.
				array( $this, 'new_format_setting_field_callback' ),   // The name of the function responsible for rendering the option interface.
				'ka_product_settings_page', // The page on which this option will be displayed.
				'ka_new_format_section' // The name of the section to which this field belongs.
			);
			register_setting(
				'ka_product_style_setting',
				'ka_new_format_field'
			);

			add_settings_section(
				'ka_colour_section', // ID used to identify this section and with which to register options.
				'',  // Title to be displayed on the administration page.
				array( $this, 'settings_section_c_s' ), // Callback used to render the description of the section.
				'ka_product_settings_page'      // Page on which to add this section of options.
			);
			add_settings_field(
				'ka_colour_field', // ID used to identify the field throughout the theme.
				esc_html__( 'Text Colour ', ' koalaapps_tag' ), // The label to the left of the option interface element.
				array( $this, 'colour_setting_field_callback' ),   // The name of the function responsible for rendering the option interface.
				'ka_product_settings_page', // The page on which this option will be displayed.
				'ka_colour_section' // The name of the section to which this field belongs.
			);
			register_setting(
				'ka_product_style_setting',
				'ka_colour_field'
			);

		add_settings_section(
			'ka_font_size_section', // ID used to identify this section and with which to register options.
			'',  // Title to be displayed on the administration page.
			array( $this, 'settings_section_fs_s' ), // Callback used to render the description of the section.
			'ka_product_settings_page'      // Page on which to add this section of options.
		);
			add_settings_field(
				'ka_font_size_field', // ID used to identify the field throughout the theme.
				esc_html__( 'Display Font Size ', ' koalaapps_tag' ), // The label to the left of the option interface element.
				array( $this, 'font_size_setting_field_callback' ),   // The name of the function responsible for rendering the option interface.
				'ka_product_settings_page', // The page on which this option will be displayed.
				'ka_font_size_section' // The name of the section to which this field belongs.
			);
			register_setting(
				'ka_product_style_setting',
				'ka_font_size_field'
			);

			add_settings_section(
				'ka_border_section', // ID used to identify this section and with which to register options.
				'',  // Title to be displayed on the administration page.
				array( $this, 'settings_section_b_s' ), // Callback used to render the description of the section.
				'ka_product_settings_page'      // Page on which to add this section of options.
			);
			add_settings_field(
				'ka_border_field', // ID used to identify the field throughout the theme.
				esc_html__( 'Display Text Border ', ' koalaapps_tag' ), // The label to the left of the option interface element.
				array( $this, 'border_setting_field_callback' ),   // The name of the function responsible for rendering the option interface.
				'ka_product_settings_page', // The page on which this option will be displayed.
				'ka_border_section' // The name of the section to which this field belongs.
			);
			register_setting(
				'ka_product_style_setting',
				'ka_border_field'
			);

			add_settings_section(
				'ka_font_family_section', // ID used to identify this section and with which to register options.
				'',  // Title to be displayed on the administration page.
				array( $this, 'settings_section_fm_s' ), // Callback used to render the description of the section.
				'ka_product_settings_page'      // Page on which to add this section of options.
			);
			add_settings_field(
				'ka_font_family_field', // ID used to identify the field throughout the theme.
				esc_html__( 'Display Font Family ', ' koalaapps_tag' ), // The label to the left of the option interface element.
				array( $this, 'font_family_setting_field_callback' ),   // The name of the function responsible for rendering the option interface.
				'ka_product_settings_page', // The page on which this option will be displayed.
				'ka_font_family_section' // The name of the section to which this field belongs.
			);
			register_setting(
				'ka_product_style_setting',
				'ka_font_family_field'
			);

			add_settings_section(
				'ka_custom_section', // ID used to identify this section and with which to register options.
				'',  // Title to be displayed on the administration page.
				array( $this, 'settings_section_di_s' ), // Callback used to render the description of the section.
				'ka_product_settings_page'      // Page on which to add this section of options.
			);
			add_settings_field(
				'ka_custom_field', // ID used to identify the field throughout the theme.
				esc_html__( 'Display Custom Font Family ', ' koalaapps_tag' ), // The label to the left of the option interface element.
				array( $this, 'custom_font_field_callback' ),   // The name of the function responsible for rendering the option interface.
				'ka_product_settings_page', // The page on which this option will be displayed.
				'ka_custom_section' // The name of the section to which this field belongs.
			);
			register_setting(
				'ka_product_style_setting',
				'ka_custom_field'
			);
	}


	/**
	 * Enable Ajax.
	 */
	public function page_shordcode_tags_call_back() {
		?>
		<input type="text" width="400" class ="ka_shortcode_field" name="ka_shortcode_field" value="[ka_tag_display]" readonly></br>
		<i>
		<label><?php echo esc_html__( 'Shortcode will apply on Product page' ); ?></label></i>
		<?php
	}
	/**
	 * Main custom image function start.
	 */
	public function product_setting_field_callback() {
		?>
		<input type="checkbox" name="ka_product_field" id="checbox" value="on"
		<?php
		if ( get_option( 'ka_product_field' ) === 'on' ) {
			echo 'checked';}
		?>
		>	  
		<label for="checbox"> <?php esc_html_e( 'ON', 'koalaapps_tag' ); ?></label>
		<?php
	}
	/**
	 * Main custom image function start.
	 */
	public function settings_section_c_b() {

	}
	/**
	 * Main custom image function start.
	 */
	public function position_setting_field_callback() {
		?>
		<select name="ka_position_field" >
				<option  value="none_value"
			<?php
			if ( 'none_value' === get_option( 'ka_position_field' ) ) {
				echo 'selected';}

			?>
			> 
			<?php esc_html_e( 'None', 'koalaapps_tag' ); ?>  </option>
				<option  value="before_title"
			<?php
			if ( 'before_title' === get_option( 'ka_position_field' ) ) {
				echo 'selected';}

			?>
			> 
			<?php esc_html_e( 'Before product price', 'koalaapps_tag' ); ?>  </option>
				<option value="after_title"
				<?php
				if ( 'after_title' === get_option( 'ka_position_field' ) ) {
					echo 'selected'; }
				?>
				> <?php esc_html_e( 'After product price', 'koalaapps_tag' ); ?> </option>
				<option  value="before_price"

				<?php
				if ( 'before_price' === get_option( 'ka_position_field' ) ) {
					echo 'selected';}
				?>
				> <?php esc_html_e( 'Before product description', 'koalaapps_tag' ); ?>  </option>
				<option value="after_price"
				<?php
				if ( 'after_price' === get_option( 'ka_position_field' ) ) {
					echo 'selected'; }
				?>
				><?php esc_html_e( 'After product description', 'koalaapps_tag' ); ?></option>
				<option  value="ADD_CART"

				<?php
				if ( 'ADD_CART' === get_option( 'ka_position_field' ) ) {
					echo 'selected';}
				?>
				> <?php esc_html_e( 'Before product "Add to cart" button', 'koalaapps_tag' ); ?>  </option>
				<option value="After_cart"
				<?php
				if ( 'After_cart' === get_option( 'ka_position_field' ) ) {
					echo 'selected'; }
				?>
				><?php esc_html_e( 'After product "Add to cart" button', 'koalaapps_tag' ); ?></option>

			</select>
			<?php
	}
	/**
	 * Main custom image function start.
	 */
	public function settings_section_p_t() {

	}
	/**
	 * Main custom image function start.
	 */
	public function archive_setting_field_callback() {
		?>
			<select name="ka_Archive_field" >
				<option  value="no_value"
			<?php
			if ( 'no_value' === get_option( 'ka_Archive_field' ) ) {
				echo 'selected';}
			?>
				> <?php esc_html_e( 'None', 'koalaapps_tag' ); ?>  </option>
				<option  value="before_title"
			<?php
			if ( 'before_title' === get_option( 'ka_Archive_field' ) ) {
				echo 'selected';}
			?>
				> <?php esc_html_e( 'Before product price', 'koalaapps_tag' ); ?>  </option>
				<option value="after_title"
				<?php
				if ( 'after_title' === get_option( 'ka_Archive_field' ) ) {
					echo 'selected'; }
				?>
				> <?php esc_html_e( 'After product price', 'koalaapps_tag' ); ?> </option>
				<option  value="ADD_CART"
				<?php
				if ( 'ADD_CART' === get_option( 'ka_Archive_field' ) ) {
					echo 'selected';}
				?>
				> <?php esc_html_e( 'Before product "Add to cart" button', 'koalaapps_tag' ); ?>  </option>
				<option value="After_cart"
				<?php
				if ( 'After_cart' === get_option( 'ka_Archive_field' ) ) {
					echo 'selected'; }
				?>
				><?php esc_html_e( 'After product "Add to cart" button', 'koalaapps_tag' ); ?></option>

			</select>
			<?php
	}
	/**
	 * Main custom image function start.
	 */
	public function settings_section_ar_s() {

	}
	/**
	 * Main custom image function start.
	 */
	public function format_setting_field_callback() {
		?>

<select name="ka_format_field">

	<option  value="text_icon"
			<?php
			if ( 'text_icon' === get_option( 'ka_format_field' ) ) {
				echo 'selected';}
			?>
				> <?php esc_html_e( 'Text & Icon', 'koalaapps_tag' ); ?>  </option>

				<option value="text"
				<?php
				if ( 'text' === get_option( 'ka_format_field' ) ) {
					echo 'selected';}
				?>
				> <?php esc_html_e( 'Text', 'koalaapps_tag' ); ?>  </option>

				<option value="icon"
				<?php
				if ( 'icon' === get_option( 'ka_format_field' ) ) {
					echo 'selected';}
				?>
				> <?php esc_html_e( 'Icon', 'koalaapps_tag' ); ?>  </option>

	</select>
			<?php

	}

	/**
	 * Main custom image function start.
	 */
	public function settings_section_tage() {

	}
	
	/**
	 * Main custom image function start.
	 */
	public function settings_section_f_s() {

	}
	/**
	 * Main custom image function start.
	 */
	public function new_format_setting_field_callback() {
		?>

<select name="ka_new_format_field">

	<option  value="circle_icon"
			<?php
			if ( 'circle_icon' === get_option( 'ka_new_format_field' ) ) {
				echo 'selected';}
			?>
				> <?php esc_html_e( 'Circle', 'koalaapps_tag' ); ?>  </option>
				<option value="rectangle_icon"
				<?php
				if ( 'rectangle_icon' === get_option( 'ka_new_format_field' ) ) {
					echo 'selected';}
				?>
				> <?php esc_html_e( 'Square', 'koalaapps_tag' ); ?>  </option>
			<option value="default_value"
				<?php
				if ( 'default_value' === get_option( 'ka_new_format_field' ) ) {
					echo 'selected';}
				?>
				> <?php esc_html_e( 'Default Image Icon', 'koalaapps_tag' ); ?>  </option>

	</select>
		<?php

	}
	/**
	 * Main custom image function start.
	 */
	public function settings_section_nf_s() {

	}
	/**
	 * Main custom image function start.
	 */
	public function colour_setting_field_callback() {
		?>

		<input type="color" id="favcolor" name="ka_colour_field" value="<?php echo esc_attr( get_option( 'ka_colour_field' ) ); ?>">
		<?php
	}
	/**
	 * Main custom image function start.
	 */
	public function settings_section_c_s() {

	}
	/**
	 * Main custom image function start.
	 */
	public function font_size_setting_field_callback() {
		?>

	<select name="ka_font_size_field" >
			<option  value="1"
			<?php
			if ( '1' === get_option( 'ka_font_size_field' ) ) {
				echo 'selected';}
			?>
			> <?php esc_html_e( '1', 'koalaapps_tag' ); ?>  </option>
			<option  value="2"
			<?php
			if ( '2' === get_option( 'ka_font_size_field' ) ) {
				echo 'selected';}
			?>
			> <?php esc_html_e( '2', 'koalaapps_tag' ); ?>  </option>
			<option  value="3"
			<?php
			if ( '3' === get_option( 'ka_font_size_field' ) ) {
				echo 'selected';}
			?>
			> <?php esc_html_e( '3', 'koalaapps_tag' ); ?>  </option>
			<option  value="4"
			<?php
			if ( '4' === get_option( 'ka_font_size_field' ) ) {
				echo 'selected';}
			?>
			> <?php esc_html_e( '4', 'koalaapps_tag' ); ?>  </option>
			<option  value="5"
			<?php
			if ( '5' === get_option( 'ka_font_size_field' ) ) {
				echo 'selected';}
			?>
			> <?php esc_html_e( '5', 'koalaapps_tag' ); ?>  </option>
			<option  value="6"
			<?php
			if ( '6' === get_option( 'ka_font_size_field' ) ) {
				echo 'selected';}
			?>
			> <?php esc_html_e( '6', 'koalaapps_tag' ); ?>  </option>
			<option  value="7"
			<?php
			if ( '7' === get_option( 'ka_font_size_field' ) ) {
				echo 'selected';}
			?>
			> <?php esc_html_e( '7', 'koalaapps_tag' ); ?>  </option>
			<option  value="8"
			<?php
			if ( '8' === get_option( 'ka_font_size_field' ) ) {
				echo 'selected';}
			?>
			> <?php esc_html_e( '8', 'koalaapps_tag' ); ?>  </option>
			<option  value="9"
			<?php
			if ( '9' === get_option( 'ka_font_size_field' ) ) {
				echo 'selected';}
			?>
			> <?php esc_html_e( '9', 'koalaapps_tag' ); ?>  </option>
			<option  value="10"
			<?php
			if ( '10' === get_option( 'ka_font_size_field' ) ) {
				echo 'selected';}
			?>
			> <?php esc_html_e( '10', 'koalaapps_tag' ); ?>  </option>
			<option  value="11"
			<?php
			if ( '11' === get_option( 'ka_font_size_field' ) ) {
				echo 'selected';}
			?>
			> <?php esc_html_e( '11', 'koalaapps_tag' ); ?>  </option>
			<option  value="12"
			<?php
			if ( '12' === get_option( 'ka_font_size_field' ) ) {
				echo 'selected';}
			?>
			><?php esc_html_e( '12', 'koalaapps_tag' ); ?>  </option>
			<option  value="13"
			<?php
			if ( '13' === get_option( 'ka_font_size_field' ) ) {
				echo 'selected';}
			?>
		> <?php esc_html_e( '13', 'koalaapps_tag' ); ?>  </option>
		<option  value="14"
			<?php
			if ( '14' === get_option( 'ka_font_size_field' ) ) {
				echo 'selected';}
			?>
		> <?php esc_html_e( '14', 'koalaapps_tag' ); ?>  </option>
		<option  value="15"
			<?php
			if ( '15' === get_option( 'ka_font_size_field' ) ) {
				echo 'selected';}
			?>
		> <?php esc_html_e( '15', 'koalaapps_tag' ); ?>  </option>
		<option  value="16"
			<?php
			if ( '16' === get_option( 'ka_font_size_field' ) ) {
				echo 'selected';}
			?>
		> <?php esc_html_e( '16', 'koalaapps_tag' ); ?>  </option>
		<option  value="17"
			<?php
			if ( '17' === get_option( 'ka_font_size_field' ) ) {
				echo 'selected';}
			?>
		> <?php esc_html_e( '17', 'koalaapps_tag' ); ?>  </option>
		<option  value="18"
			<?php
			if ( '18' === get_option( 'ka_font_size_field' ) ) {
				echo 'selected';}
			?>
		> <?php esc_html_e( '18', 'koalaapps_tag' ); ?>  </option>
		<option  value="19"
			<?php
			if ( '19' === get_option( 'ka_font_size_field' ) ) {
				echo 'selected';}
			?>
		> <?php esc_html_e( '19', 'koalaapps_tag' ); ?>  </option>
		<option  value="20"
			<?php
			if ( '20' === get_option( 'ka_font_size_field' ) ) {
				echo 'selected';}
			?>
		> <?php esc_html_e( '20', 'koalaapps_tag' ); ?>  </option>
	</select>

		<?php
	}
	/**
	 * Main custom image function start.
	 */
	public function settings_section_fs_s() {

	}
	/**
	 * Main custom image function start.
	 */
	public function border_setting_field_callback() {
		?>
		<input type="checkbox" name="ka_border_field" id="checbox" value="on"
		<?php
		if ( get_option( 'ka_border_field' ) === 'on' ) {
			echo 'checked';}
		?>
		>	  
		<p> <?php echo esc_html__( 'Enable this to show the border across names of tags.', 'koalaapps_tag' ); ?> </p>
		<?php
	}
	/**
	 * Main custom image function start.
	 */
	public function settings_section_b_s() {

	}
	/**
	 * Main custom image function start.
	 */
	public function font_family_setting_field_callback() {
		?>
	<select name="ka_font_family_field" id="ka_font_family_field"  onchange="ka_hide_fld(this.value);">
				<option value="custom_font" id="hid_font"
			<?php
			if ( 'custom_font' === get_option( 'ka_font_family_field' ) ) {
					echo 'selected'; }
			?>
			><?php esc_html_e( 'Custom Font', 'koalaapps_tag' ); ?> </option>
				<option  value="Arial"
			<?php
			if ( 'Arial' === get_option( 'ka_font_family_field' ) ) {
				echo 'selected';}
			?>
			> <?php esc_html_e( 'Arial', 'koalaapps_tag' ); ?>  </option>
				<option  value="Serif"
			<?php
			if ( 'Serif' === get_option( 'ka_font_family_field' ) ) {
				echo 'selected';}
			?>
			> <?php esc_html_e( 'Serif', 'koalaapps_tag' ); ?>  </option>

				<option value="Arial Verdana"
				<?php
				if ( 'Arial Verdana' === get_option( 'ka_font_family_field' ) ) {
					echo 'selected'; }
				?>
				> <?php esc_html_e( 'Arial Verdana', 'koalaapps_tag' ); ?> </option>
				<option  value="Times New Roman"
				<?php
				if ( 'Times New Roman' === get_option( 'ka_font_family_field' ) ) {
					echo 'selected';}
				?>
				> <?php esc_html_e( 'Times New Roman', 'koalaapps_tag' ); ?>  </option>
				<option value="Times"
				<?php
				if ( 'Times' === get_option( 'ka_font_family_field' ) ) {
					echo 'selected'; }
				?>
				><?php esc_html_e( 'Times', 'koalaapps_tag' ); ?></option>
				<option value="Monospace"
				<?php
				if ( 'Monospace' === get_option( 'ka_font_family_field' ) ) {
					echo 'selected'; }
				?>
				><?php esc_html_e( 'Monospace', 'koalaapps_tag' ); ?></option>
				<option value="Courier"
				<?php
				if ( 'Courier' === get_option( 'ka_font_family_field' ) ) {
					echo 'selected'; }
				?>
				><?php esc_html_e( 'Courier', 'koalaapps_tag' ); ?></option>
				<option value="Lucida Console"
				<?php
				if ( 'Lucida Console' === get_option( 'ka_font_family_field' ) ) {
					echo 'selected'; }
				?>
				><?php esc_html_e( 'Lucida Console', 'koalaapps_tag' ); ?></option>
				<option value="Helvetica"
				<?php
				if ( 'Helvetica' === get_option( 'ka_font_family_field' ) ) {
					echo 'selected'; }
				?>
				><?php esc_html_e( 'Helvetica', 'koalaapps_tag' ); ?></option>
				<option value="Arial, Helvetica, sans-serif"
				<?php
				if ( 'Arial, Helvetica, sans-serif' === get_option( 'ka_font_family_field' ) ) {
					echo 'selected'; }
				?>
				><?php esc_html_e( 'Arial, Helvetica, sans-serif', 'koalaapps_tag' ); ?></option>
			</select>
		<?php
	}
	/**
	 * Main custom image function start.
	 */
	public function custom_font_field_callback() {
		?>
			<div class="hide_div">
			<input type="text" name="ka_custom_field" title="Enter a valid font family" pattern="^[ A-Za-z_,-]*$" value="<?php echo esc_attr( get_option( 'ka_custom_field' ) ); ?>">
			</div>
		<?php
	}
	/**
	 * Main custom image function start.
	 */
	public function settings_section_di_s() {

	}
	/**
	 * Main custom image function start.
	 */
	public function settings_section_fm_s() {

	}
	/**
	 * Main custom image function start.
	 */
	public function ka_admin_init() {
		$z_taxonomies = get_taxonomies();
		if ( is_array( $z_taxonomies ) ) {
			$zci_options = get_option( 'zci_options' );

			if ( ! is_array( $zci_options ) ) {
				$zci_options = array();
			}

			if ( empty( $zci_options['excluded_taxonomies'] ) ) {
				$zci_options['excluded_taxonomies'] = array();
			}

			foreach ( $z_taxonomies as $z_taxonomy ) {
				if ( in_array( $z_taxonomy, $zci_options['excluded_taxonomies'], true ) ) {
					continue;
				}
				add_action( $z_taxonomy . '_add_form_fields', array( $this, 'taxonomy_field' ) );
				add_action( $z_taxonomy . '_edit_form_fields', array( $this, 'ka_texonomy_edit_field' ) );
				add_filter( 'manage_edit-' . $z_taxonomy . '_columns', array( $this, 'z_Taxonomy_Columns' ) );
				add_filter( 'manage_' . $z_taxonomy . '_custom_column', array( $this, 'z_Taxonomy_Columnn' ), 10, 3 );
				// If tax is deleted.
				add_action(
					"delete_{$z_taxonomy}",
					function( $tt_id ) {
						delete_option( 'z_taxonomy_image' . $tt_id );
					}
				);
			}
		}
		if ( isset( $_SERVER['SCRIPT_NAME'] ) ) {
			if ( strpos( sanitize_text_field( wp_unslash( $_SERVER['SCRIPT_NAME'] ) ), 'edit-tags.php' ) > 0 || strpos( sanitize_text_field( wp_unslash( $_SERVER['SCRIPT_NAME'] ) ), 'term.php' ) > 0 ) {
				add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue' ) );
				add_action( 'quick_edit_custom_box', array( $this, 'zQuickEditCustomBox' ), 10, 3 );
			}
		}
		// Register settings.
		register_setting( 'zci_options', 'zci_options' );
		add_settings_section( 'zci_settings', __( 'Categories Images settings', 'categories-images' ), array( $this, 'zSectionText' ), 'zci-options' );
		add_settings_field( 'z_excluded_taxonomies', __( 'Excluded Taxonomies', 'categories-images' ), array( $this, 'zExcludedTaxonomies' ), 'zci-options', 'zci_settings' );
	}
	/**
	 * Main admin_enqueue function start.
	 */
	public function admin_enqueue() {
		wp_enqueue_style( 'categories-images-styles', plugins_url( '/assets/css/zci-styles.css', __FILE__ ), false, '1.0.0' );
		wp_enqueue_script( 'categories-images-scripts', plugins_url( '/assets/js/zci-scripts.js', __FILE__ ), array( 'jquery' ), '1.0.0', false );

		$zci_js_config = array(
			'wordpress_ver' => get_bloginfo( 'version' ),
			'placeholder'   => $this->zci_placeholder,
		);
		wp_localize_script( 'categories-images-scripts', 'zci_config', $zci_js_config );
	}
	/**
	 * Main custom image function start.
	 */
	public function taxonomy_field() {
		if ( get_bloginfo( 'version' ) >= 3.5 ) {
			wp_enqueue_media();
		} else {
			wp_enqueue_style( 'thickbox' );
			wp_enqueue_script( 'thickbox' );
		}

		echo '<div class="form-field">
	            <label for="zci_taxonomy_image">' . esc_html__( 'Image', 'koalaapps_tag' ) . '</label>
	            <input type="text" name="zci_taxonomy_image" id="zci_taxonomy_image" value="" />
	            <br/>
	            <button class="z_upload_image_button button">' . esc_html__( 'Upload/Add image', 'koalaapps_tag' ) . '</button>
	        </div>';
	}
	/**
	 * Main custom image function start.
	 *
	 * @param int $taxonomy First item.
	 */
	public function ka_texonomy_edit_field( $taxonomy ) {
		if ( get_bloginfo( 'version' ) >= 3.5 ) {
			wp_enqueue_media();
		} else {
			wp_enqueue_style( 'thickbox' );
			wp_enqueue_script( 'thickbox' );
		}

		if ( $this->z_taxonomy_image_url( $taxonomy->term_id, null, true ) === $this->zci_placeholder ) {
			$image_url = '';
		} else {
			$image_url = $this->z_taxonomy_image_url( $taxonomy->term_id, null, true );
		}
		echo '<tr class="form-field">
	            <th scope="row" valign="top"><label for="zci_taxonomy_image">' . esc_html__( 'Image', 'categories-images' ) . '</label></th>
	            <td><img class="zci-taxonomy-image" src="' . esc_url( $image_url ) . '"/><br/><input type="text" name="zci_taxonomy_image" id="zci_taxonomy_image" value="' . esc_url( $image_url ) . '" /><br />
	            <button class="z_upload_image_button button">' . esc_html__( 'Upload/Add image', 'categories-images' ) . '</button>
	            <button class="z_remove_image_button button">' . esc_html__( 'Remove image', 'categories-images' ) . '</button>
	            </td>
	        </tr>';
	}

	/**
	 * Thumbnail column added to category admin.
	 *
	 * @param int $columns First item.
	 */
	public function z_taxonomy_columns( $columns ) {
		$new_columns          = array();
		$new_columns['cb']    = $columns['cb'];
		$new_columns['thumb'] = __( 'Image', 'categories-images' );

		unset( $columns['cb'] );

		return array_merge( $new_columns, $columns );
	}
	/**
	 * Thumbnail column value added to category admin.
	 *
	 * @param int $columns First item.
	 *
	 * @param int $column First item.
	 *
	 * @param int $id First item.
	 */
	public function z_taxonomy_columnn( $columns, $column, $id ) {
		if ( 'thumb' === $column ) {
			$img_url = $this->z_taxonomy_image_url( $id, 'thumbnail', true );
			if ( ! empty( $img_url ) ) {
				$columns = '<span><img src="' . $img_url . '" alt="' . __( 'Thumbnail', 'categories-images' ) . '" class="wp-post-image" /></span>';
			}
		}

		return $columns;
	}
	/**
	 * Main custom image function start.
	 *
	 * @param int $column_name First item.
	 *
	 * @param int $screen First item.
	 *
	 * @param int $name First item.
	 */
	public function zquickeditcustombox( $column_name, $screen, $name ) {
		if ( 'thumb' === $column_name ) {
			echo '<fieldset>
	            <div class="thumb inline-edit-col">
	                <label>
	                    <span class="title"><img src="" alt="Thumbnail"/></span>
	                    <span class="input-text-wrap"><input type="text" name="zci_taxonomy_image" value="" class="tax_list" /></span>
	                    <span class="input-text-wrap">
	                      <button class="z_upload_image_button button">' . esc_html__( 'Upload/Add image', 'categories-images' ) . '</button>
	                        <button class="z_remove_image_button button">' . esc_html__( 'Remove image', 'categories-images' ) . '</button>
	                    </span>
	                </label>
	            </div>
	        </fieldset>';
		}
	}
	/**
	 * Main custom image function start.
	 *
	 * @param int $term_id First item.
	 */
	public function z_save_taxonomy_image( $term_id ) {
		if ( isset( $_POST['taxonomy_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['taxonomy_nonce'], 'imag_nonce' ) ) )
		) {
			print 'Sorry, your nonce did not verify.';
			exit;
		}
		if ( isset( $_POST['zci_taxonomy_image'] ) ) {
			update_option( 'z_taxonomy_image' . $term_id, ( sanitize_text_field( wp_unslash( $_POST['zci_taxonomy_image'], false ) ) ) );
		}
	}
	/**
	 * Main custom image function start.
	 *
	 * @param int $image_src First item.
	 */
	public function z_get_attachment_id_by_url( $image_src ) {
		global $wpdb;

		$id = attachment_url_to_postid( $image_src );
		return ( ! empty( $id ) ) ? $id : null;
	}
	/**
	 * Main custom image function start.
	 *
	 * @param int $term_id  First item.
	 *
	 * @param int $size First item.
	 *
	 * @param int $return_placeholder First item.
	 */
	public function z_taxonomy_image_url( $term_id = null, $size = 'full', $return_placeholder = true ) {
		if ( ! $term_id ) {
			if ( is_category() ) {
				$term_id = get_query_var( 'cat' );
			} elseif ( is_tag() ) {
				$term_id = get_query_var( 'tag_id' );
			} elseif ( is_tax() ) {
				$current_term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
				$term_id      = $current_term->term_id;
			}
		}

		$taxonomy_image_url = get_option( 'z_taxonomy_image' . $term_id );
		if ( ! empty( $taxonomy_image_url ) ) {
			$attachment_id = $this->z_get_attachment_id_by_url( $taxonomy_image_url );
			if ( ! empty( $attachment_id ) ) {
				$taxonomy_image_url = wp_get_attachment_image_src( $attachment_id, $size );
				$taxonomy_image_url = $taxonomy_image_url[0];
			}
		}

		if ( $return_placeholder ) {
			return ( '' !== $taxonomy_image_url ) ? $taxonomy_image_url : $this->zci_placeholder;
		} else {
			return $taxonomy_image_url;
		}
	}
	/**
	 * Main custom image function start.
	 *
	 * @param int $term_id First item.
	 *
	 * @param int $size First item.
	 *
	 * @param int $attr First item.
	 *
	 * @param int $echo First item.
	 */
	public function z_taxonomy_image( $term_id = null, $size = 'full', $attr = null, $echo = true ) {
		if ( ! $term_id ) {
			if ( is_category() ) {
				$term_id = get_query_var( 'cat' );
			} elseif ( is_tag() ) {
				$term_id = get_query_var( 'tag_id' );
			} elseif ( is_tax() ) {
				$current_term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
				$term_id      = $current_term->term_id;
			}
		}

		$taxonomy_image_url = get_option( 'z_taxonomy_image' . $term_id );
		if ( ! empty( $taxonomy_image_url ) ) {
			$attachment_id = $this->z_get_attachment_id_by_url( $taxonomy_image_url );
			if ( ! empty( $attachment_id ) ) {
				$taxonomy_image = wp_get_attachment_image( $attachment_id, $size, false, $attr );
			} else {
				$image_attr = '';
				if ( is_array( $attr ) ) {
					if ( ! empty( $attr['class'] ) ) {
						$image_attr .= ' class="' . $attr['class'] . '" ';
					}
					if ( ! empty( $attr['alt'] ) ) {
						$image_attr .= ' alt="' . $attr['alt'] . '" ';
					}
					if ( ! empty( $attr['width'] ) ) {
						$image_attr .= ' width="' . $attr['width'] . '" ';
					}
					if ( ! empty( $attr['height'] ) ) {
						$image_attr .= ' height="' . $attr['height'] . '" ';
					}
					if ( ! empty( $attr['title'] ) ) {
						$image_attr .= ' title="' . $attr['title'] . '" ';
					}
				}
				$taxonomy_image = '<img src="' . $taxonomy_image_url . '" ' . $image_attr . '/>';
			}
		} else {
			$taxonomy_image = '';
		}

		if ( $echo ) {
			echo esc_attr( $taxonomy_image );
		} else {
			return $taxonomy_image;
		}
	}
		/**
		 * Main custom image function start.
		 */
	public function z_settings_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html_e( 'You do not have sufficient permissions to access this page.', 'categories-images' ) );
		}
		require_once plugin_dir_path( __FILE__ ) . 'templates/admin.php';
	}
		/**
		 * Main custom image function start.
		 */
	public function z_section_text() {
		echo '<p>' . esc_html_e( 'Please select the taxonomies you want to exclude it from Categories Images plugin', 'categories-images' ) . '</p>';
	}
		/**
		 * Main custom image function start.
		 */
	public function z_excluded_taxonomies() {
		$options             = get_option( 'zci_options' );
		$disabled_taxonomies = array( 'nav_menu', 'link_category', 'post_format' );
		foreach ( get_taxonomies() as $tax ) :
			if ( in_array( $tax, $disabled_taxonomies, true ) ) {
					continue;
			}
			?>

		<input type="checkbox" name="zci_options[excluded_taxonomies][<?php echo esc_attr( $tax ); ?>]" value="<?php echo esc_attr( $tax ); ?>"
			<?php checked( isset( $options['excluded_taxonomies'][ $tax ] ) ); ?> />
			<?php wp_nonce_field( 'imag_nonce', 'taxonomy_nonce' ); ?>
			<?php echo esc_attr( $tax ); ?><br>
			<?php

		endforeach;
	}
	/**
	 * Main function startgg
	 */
	public function ka_font_scripts() {
		wp_enqueue_script( 'tag_images', plugins_url( 'assets/js/font-family.js', __FILE__ ), false, '1.0' );
	}

}
new KA_Custom_Image_tag();



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
 * Main class start.
 */
class KA_Custom_Image_Tag_Front {

	/**
	 * Main constucter start.
	 */
	public function __construct() {

		add_action( 'woocommerce_before_main_content', array( $this, 'ka_check_setting' ) );

		add_action( 'woocommerce_before_main_content', array( $this, 'ka_archive_setting' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'ka_hide_script' ) );
		add_shortcode('ka_tag_display' , array( $this, 'shortcode_custom_tags' ));

	}


	/**
	 * Main function start.
	 */
	public function shortcode_custom_tags() {
		if ( is_product() || is_shop() ) {

			ob_start();

		
			global $product;
			//var_dump($product);
			$product_tags = get_the_terms( $product->get_id(), 'product_tag' );

			if ( ! is_array( $product_tags ) ) {
				return $product_tags;

			}
			?>
		<div class="img-listings">
			<ul>
				<?php
				foreach ( $product_tags as $product_tag ) {
					$img_url = get_option( 'z_taxonomy_image' . $product_tag->term_id );

					$this->format_setting( $product_tag->name, $img_url, $product_tag->term_id );

				}
				?>
			</ul></div>
				<?php
		} else {
			return;
		}
		return ob_get_clean();
	}

	/**
	 * Main function start.
	 */
	public function title_price_display() {
		 
		
			global $product;
			//var_dump($product);
			$product_tags = get_the_terms( $product->get_id(), 'product_tag' );

		if ( ! is_array( $product_tags ) ) {
			return $product_tags;

		}
		?>
		<div class="img-listings">
			<ul>
				<?php
				foreach ( $product_tags as $product_tag ) {
					$img_url = get_option( 'z_taxonomy_image' . $product_tag->term_id );

					$this->format_setting( $product_tag->name, $img_url, $product_tag->term_id );

				}
				?>
			</ul></div>
				<?php
		 
	}
	/**
	 * Main function startgg
	 */
	public function ka_check_setting() {

		if ( 'on' === get_option( 'ka_product_field' ) ) {

			// show on product page in product tag.
			if ( is_product() ) {

				if ( 'before_title' === get_option( 'ka_position_field' ) ) {

					add_action( 'woocommerce_single_product_summary', array( $this, 'title_price_display' ), 9 );
				}

				if ( 'after_title' === get_option( 'ka_position_field' ) ) {

					add_action( 'woocommerce_single_product_summary', array( $this, 'title_price_display' ), 11 );
				}

				if ( 'before_price' === get_option( 'ka_position_field' ) ) {
					add_action( 'woocommerce_single_product_summary', array( $this, 'title_price_display' ), 11 );
				}
				if ( 'after_price' === get_option( 'ka_position_field' ) ) {
					add_action( 'woocommerce_before_add_to_cart_button', array( $this, 'title_price_display' ), 11 );
				}

				if ( 'ADD_CART' === get_option( 'ka_position_field' ) ) {
					add_action( 'woocommerce_before_add_to_cart_button', array( $this, 'title_price_display' ), 9 );

				}
				if ( 'After_cart' === get_option( 'ka_position_field' ) ) {
					add_action( 'woocommerce_after_add_to_cart_button', array( $this, 'title_price_display' ), 11 );
				}
			}
		}
	}
	/**
	 * Main function start.
	 *
	 * @param int $term_id Second item.
	 */
	public function before_title_archive_display( $term_id ) {
		global $product;
		$product_tags = get_the_terms( $product->get_id(), 'product_tag' );

		if ( ! is_array( $product_tags ) ) {
			return $product_tags;

		}
		?>
	<div class="img-listing">
	<ul>
		<?php
		foreach ( $product_tags as $product_tag ) {
			$img_url = get_option( 'z_taxonomy_image' . $product_tag->term_id );

			$this->format_setting( $product_tag->name, $img_url, $product_tag->term_id );

		}
		?>
	</ul></div>
		<?php
	}

	/**
	 * Main function startgg
	 */
	public function ka_archive_setting() {

		if ( 'on' === get_option( 'ka_product_field' ) ) {

			// show on shop page in product tag.
			if ( is_shop() || is_product_tag() || is_product_category() || is_archive() ) {

				if ( 'before_title' === get_option( 'ka_Archive_field' ) ) {

					add_action( 'woocommerce_after_shop_loop_item_title', array( $this, 'before_title_archive_display' ), 1 );
				}

				if ( 'after_title' === get_option( 'ka_Archive_field' ) ) {
					add_action( 'woocommerce_after_shop_loop_item_title', array( $this, 'before_title_archive_display' ), 15 );

				}

				if ( 'ADD_CART' === get_option( 'ka_Archive_field' ) ) {
					add_action( 'woocommerce_after_shop_loop_item', array( $this, 'before_title_archive_display' ), 1 );

				}
				if ( 'After_cart' === get_option( 'ka_Archive_field' ) ) {

					add_action( 'woocommerce_after_shop_loop_item', array( $this, 'before_title_archive_display' ), 11 );
				}
			}
		}
	}
	/**
	 * Main function startgg
	 *
	 * @param int $name First item.
	 * @param int $img_url Second item.
	 * @param int $term_id Second item.
	 */
	public function format_setting( $name, $img_url, $term_id ) {
		?>
		<style type="text/css">
			.ka_tag_name{
			font-family: <?php echo esc_attr( get_option( 'ka_font_family_field' ) ); ?> !important;
			font-size: <?php echo esc_attr( get_option( 'ka_font_size_field' ) ); ?>px !important;
			color:<?php echo esc_attr( get_option( 'ka_colour_field' ) ); ?> !important;
			border:2px soild black !important;
			margin:0px;
			padding: 2px 0px 3px;
			}
			<?php
			if ( 'on' === get_option( 'ka_border_field' ) ) {
				?>
				.name_class{
					border: 2px solid #00000036
				}
			<?php } ?>
			<?php
			if ( 'default_value' === get_option( 'ka_new_format_field' ) ) {
				?>
				.img-listings ul li img{
				width: 100%;
				margin:5px auto 10px !important;
				max-width:50;
				height:45;
				object-fit: cover;
				}
			.img-listing ul li img{
				width: 100%;
				margin:5px auto 10px !important;
				max-width: 50px;
				height: 45px;
				object-fit: cover;
	}
				}
			<?php } ?>
		</style>
		<?php
		if ( 'text_icon' === get_option( 'ka_format_field' ) ) {
			if ( 'circle_icon' === get_option( 'ka_new_format_field' ) ) {

				?>
					<li>
						<a href="<?php echo esc_url( get_term_link( $term_id ) ); ?>" >
				<?php if ( ! empty( esc_url( $img_url ) ) ) { ?>	
								<img class="ka_icon_circle" src="<?php echo esc_url( $img_url ); ?>" >
							<?php } else { ?>

								<img class="ka_icon_circle" src="<?php echo esc_url( plugins_url( 'assets\css\icon.jpg', __FILE__ ) ); ?>">
							<?php } ?>
						</a>		
						<div class="name_class">
							<h1 class="ka_tag_name"><?php echo esc_attr( $name ); ?></h1>
						</div>
					</li>
				<?php
			} elseif ( 'rectangle_icon' === get_option( 'ka_new_format_field' ) ) {
				?>
						<li>
							<a href="<?php echo esc_url( get_term_link( $term_id ) ); ?>" >
								<?php if ( ! empty( esc_url( $img_url ) ) ) { ?>

									<style type="text/css">
										
									</style>
									<img class="KA_rectangle_icon" src="<?php echo esc_url( $img_url ); ?>" >
								<?php } else { ?>

									<img class="KA_rectangle_iconn" src="<?php echo esc_url( plugins_url( 'assets\css\icon.jpg', __FILE__ ) ); ?>">
								<?php } ?>
							</a>
							<div class="name_class">
								<h1 class="ka_tag_name"><?php echo esc_attr( $name ); ?></h1>
							</div>
						</li>
					<?php

			} else {
				?>
					<li>
						<a href="<?php echo esc_url( get_term_link( $term_id ) ); ?>" >
							<?php
							if ( ! empty( esc_url( $img_url ) ) ) {
								?>
							<img src="<?php echo esc_url( $img_url ); ?>" >
								<?php
							} else {
								?>
							<img  src="<?php echo esc_url( plugins_url( 'assets\css\icon.jpg', __FILE__ ) ); ?>">
								<?php

							}

							?>
						</a>
						<div class="name_class">
							<h1 class="ka_tag_name"><?php echo esc_attr( $name ); ?></h1>
						</div>
					</li>
				<?php
			}
		}

		if ( 'icon' === get_option( 'ka_format_field' ) ) {
			if ( 'circle_icon' === get_option( 'ka_new_format_field' ) ) {

				?>
					<li>
						<a href="<?php echo esc_url( get_term_link( $term_id ) ); ?>" >
				<?php if ( ! empty( esc_url( $img_url ) ) ) { ?>	
								<img class="ka_icon_circle" src="<?php echo esc_url( $img_url ); ?>" >
							<?php } else { ?>

								<img class="ka_icon_circle" src="<?php echo esc_url( plugins_url( 'assets\css\icon.jpg', __FILE__ ) ); ?>">
							<?php } ?>
						</a>			 
					</li>
				<?php
			} elseif ( 'rectangle_icon' === get_option( 'ka_new_format_field' ) ) {
				?>
						<li>
							<a href="<?php echo esc_url( get_term_link( $term_id ) ); ?>" >
								<?php if ( ! empty( esc_url( $img_url ) ) ) { ?>

									<style type="text/css">
										 
									</style>
									<img class="KA_rectangle_icon" src="<?php echo esc_url( $img_url ); ?>" >
								<?php } else { ?>

									<img class="KA_rectangle_iconn" src="<?php echo esc_url( plugins_url( 'assets\css\icon.jpg', __FILE__ ) ); ?>">
								<?php } ?>
							</a>
							 
						</li>
					<?php

			} else {
				?>
					<li>
						<a href="<?php echo esc_url( get_term_link( $term_id ) ); ?>" >
							<?php
							if ( ! empty( esc_url( $img_url ) ) ) {
								?>
							<img src="<?php echo esc_url( $img_url ); ?>" >
								<?php
							} else {
								?>
							<img  src="<?php echo esc_url( plugins_url( 'assets\css\icon.jpg', __FILE__ ) ); ?>">
								<?php

							}

							?>
						</a>
						 
					</li>
				<?php
			}
		}
		if ( 'text' === get_option( 'ka_format_field' ) ) {
			?>
			<li>
				<a href="<?php echo esc_url( get_term_link( $term_id ) ); ?>" >
				<div class="name_class">
					<h1 class="ka_tag_name"><?php echo esc_attr( $name ); ?></h1>
				</div>
			</li>
			<?php
		}

		 

	}
	/**
	 * Main function startgg
	 */
	public function ka_hide_script() {

		wp_enqueue_style( 'tag_images-styles', plugins_url( 'assets\css\img.css', __FILE__ ), false, '1.0' );
		wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap', false, '1.0' );
	}
}
new KA_Custom_Image_Tag_Front();


?>

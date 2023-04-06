<?php
/**
 * Main constucter function start.
 *
 * @package : email
 */

?>
<div class="wrap">
<h2> <?php esc_html_e( 'Categories Images', 'categories-images' ); ?> </h2>
	<form method="post" action="options.php">
		<?php settings_fields( 'zci_options' ); ?>
		<?php do_settings_sections( 'zci-options' ); ?>
		<?php submit_button(); ?>
	</form>
</div>


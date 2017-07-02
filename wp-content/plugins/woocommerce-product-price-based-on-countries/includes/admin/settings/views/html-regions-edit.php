<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="settings-panel wcpbc-region-settings">	
	<h3><?php echo ( isset($_GET['add_region'] ) ? __( 'Add Zone', 'wc-price-based-country' ) : __( 'Edit Zone', 'wc-price-based-country' ) ) ; ?></h3>
	<table class="form-table">

		<!-- Region name -->
		<tr valign="top">
			<th scope="row" class="titledesc">
				<label for="name"><?php _e( 'Zone Name', 'wc-price-based-country' ); ?></label>
				<?php //echo $tip; ?>
			</th>
	        <td class="forminp forminp-text">
	        	<input name="name" id="name" type="text" value="<?php echo esc_attr( $region['name'] ); ?>"/> 
	        	<?php //echo $description; ?>
	        </td>
		</tr>

		<!-- Country multiselect -->			
		<tr valign="top">
			<th scope="row" class="titledesc">
				<label for="countries"><?php _e( 'Countries', 'wc-price-based-country' ); ?></label>
			</th>
			<td class="forminp">
				<select multiple="multiple" name="countries[]" style="width:350px" data-placeholder="<?php _e( 'Choose countries&hellip;', 'woocommerce' ); ?>" title="Country" class="chosen_select">
					<?php 																			
	        			foreach ( $allowed_countries as $country_code ) {	        				
	        				echo '<option value="' . esc_attr( $country_code ) . '" ' . selected( in_array( $country_code, $region['countries'] ), true, false ).'>' . WC()->countries->countries[$country_code] . '</option>';	        				
	        			}
					?>
				</select></br><a class="select_all button" href="#"><?php _e( 'Select all', 'woocommerce' ); ?></a> <a class="select_none button" href="#"><?php _e( 'Select none', 'woocommerce' ); ?></a>				
			</td>
		</tr>

		<!-- Currency select -->			
		<tr valign="top">
			<th scope="row" class="titledesc">
				<label for="currency"><?php _e( 'Currency', 'woocommerce' ); ?></label>
				<?php //echo $tip; ?>
			</th>
			<td class="forminp forminp-select">
				<select name="currency" id="currency" class="chosen_select">
					<?php
						foreach ( get_woocommerce_currencies() as $code => $name ) {
							echo '<option value="' . esc_attr( $code ) . '" ' . selected( $region['currency'], $code ) .'>' . $name . ' (' . get_woocommerce_currency_symbol( $code ) . ')' . '</option>';
						}
					?>
				</select>
			</td>
		</tr>
				

		<!-- Exchange rate -->			
		<tr valign="top">
			<th scope="row" class="titledesc">
				<label for="exchange_rate"><?php _e( 'Exchange Rate', 'wc-price-based-country' ); ?></label>				
			</th>
	        <td class="forminp forminp-text">                	
	        	1 <?php echo get_option( 'woocommerce_currency' );	?> = <input name="exchange_rate" id="exchange_rate" type="text" class="short wc_input_decimal" value="<?php echo wc_format_localized_decimal( $region['exchange_rate'] ); ?>"/> 
	        	<?php //echo $description; ?>
	        </td>
		</tr>

		<?php do_action( 'wc_price_based_country_admin_region_fields', $region ); ?>			

	</table>
	
	
	<input type="hidden" name="page" value="wc-settings" />
	<input type="hidden" name="tab" value="wc_price_based_country" />
	<input type="hidden" name="section" value="zones" />	
				
	<p class="submit">
		<?php submit_button( __( 'Save Changes', 'woocommerce' ), 'primary', 'update_region', false ); ?>
		<?php if ( ! is_null($region_key) ) { ?>
		<a style="color: #a00; text-decoration: none; margin-left: 10px;" href="<?php echo esc_url( wp_nonce_url( add_query_arg( array( 'remove_region' => $region_key ), admin_url( 'admin.php?page=wc-settings&tab=price-based-country&section=zones' ) ), 'wc-price-based-country-remove-region' ) ); ?>"><?php _e( 'Remove zone', 'wc-price-based-country' ); ?></a>
		<input type="hidden" name="edit_region" value="<?php echo $region_key ?>" />		
		<?php } else { ?>
		<input type="hidden" name="add_region" value="1" />				
		<?php } ?>
	</p>

</div>
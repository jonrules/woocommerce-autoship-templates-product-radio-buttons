<?php
/* @var $product WC_Product */
?>

<div class="wc-autoship-container">

	<div class="wc-autoship-options">
		<?php 
		$autoship_min_frequency = get_post_meta( $product->id, '_wc_autoship_min_frequency', true );
		$autoship_max_frequency = get_post_meta( $product->id, '_wc_autoship_max_frequency', true );
		
		// Frequency options
		$frequency_options = array(
			'Weekly' => 7,
			'Monthly' => 30,
			'Quarterly' => 90
		);
		
		?>
	
		<fieldset>
			<legend class="wc-autoship-add-to-autoship"><?php echo __( 'Add to Auto-Ship', 'wc-autoship' ); ?></legend>
			<h3 class="wc-autoship-price" style="display: none"><?php echo __( 'Auto-Ship price:', 'wc-autoship'); ?> <span class="currency-symbol"><?php echo get_woocommerce_currency_symbol(); ?></span><span class="price"></span></h3>
			<p class="wc-autoship-select-frequency"><?php echo __( 'Select an Auto-Ship Frequency to add this item to auto-ship.', 'wc-autoship' ); ?></p>
			<div class="wc-autoship-frequency wc-autoship-frequency-radio-options">
				<?php foreach ( $frequency_options as $name => $days ): ?>
					<?php if ( $days < $autoship_min_frequency || $days > $autoship_max_frequency ) continue; ?>
					<div class="wc-autoship-frequency-radio radio">
						<label for="wc_autoship_frequency_<?php echo esc_html( $days ); ?>">
							<input type="radio" name="wc_autoship_frequency" class="wc-autoship-frequency-input-radio"
								id="wc_autoship_frequency_<?php echo esc_html( $days ); ?>" 
								value="<?php echo esc_html( $days ); ?>" /> 
							<?php echo esc_html( $name ), ' ', __( "(Every $days days)", 'wc-autoship' ); ?>
						</label>
					</div>
				<?php endforeach; ?>
				<div id="wc-autoship-frequency-radio-no-autoship" class="wc-autoship-frequency-radio radio" style="display: none">
					<label for="wc_autoship_frequency_<?php echo esc_html( $days ); ?>">
						<input type="radio" name="wc_autoship_frequency" class="wc-autoship-frequency-input-radio"
							id="wc_autoship_frequency_no_autoship" 
							value="" /> 
						<?php echo __( "No auto-ship. Make this a one-time purchase.", 'wc-autoship' ); ?>
					</label>
				</div>
			</div>
		</fieldset>
	</div>
	
</div>

<script>
jQuery(function ($) {
	$('.wc-autoship-frequency-input-radio').click(function () {
		$('#wc-autoship-frequency-radio-no-autoship').show();
	});
});
</script>
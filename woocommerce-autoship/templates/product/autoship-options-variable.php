<?php
/* @var $product WC_Product */
?>

<div class="wc-autoship-container">

	<div class="wc-autoship-options">
		<?php 
		$autoship_min_frequency = get_post_meta( $product->id, '_wc_autoship_min_frequency', true );
		$autoship_max_frequency = get_post_meta( $product->id, '_wc_autoship_max_frequency', true );
		$autoship_default_frequency = get_post_meta( $product->id, '_wc_autoship_default_frequency', true );
		$autoship_price = '';
		$default_attributes = $product->get_variation_default_attributes();
		if ( ! empty( $default_attributes ) ) {
			$variations = $product->get_available_variations();
			foreach ( $variations as $variation ) {
				foreach ( $default_attributes as $name => $value ) {
					if ( isset( $variation['attributes'][ 'attribute_' . $name ] ) && $variation['attributes'][ 'attribute_' . $name ] == '' ) {
						continue;
					} elseif ( ! isset( $variation['attributes'][ 'attribute_' . $name ] ) || $variation['attributes'][ 'attribute_' . $name ] != $value ) {
						continue 2;
					}
				}
				$autoship_price = get_post_meta( $variation['variation_id'], '_wc_autoship_price', true );
				break;
			}
		}

		// Frequency options
		$frequency_options = array(
			'Weekly' => 7,
			'Monthly' => 30,
			'Bi-Monthly' => 60,
			'Quarterly' => 90
		);
		
		?>
	
		<div class="panel panel-default">
			<div class="panel-body">
				<p class="wc-autoship-select-frequency"><?php echo __( 'Select an Auto-Ship Frequency to add this item to auto-ship.', 'wc-autoship' ); ?></p>
				<h3 class="wc-autoship-price" <?php if ( empty( $autoship_price ) ) echo 'style="display:none"'; ?>><?php echo __( 'Auto-Ship price:', 'wc-autoship'); ?> <?php echo wc_price( $autoship_price ); ?></h3>
				<div class="wc-autoship-frequency wc-autoship-frequency-radio-options">
					<?php foreach ( $frequency_options as $name => $days ): ?>
						<?php if ( $days < $autoship_min_frequency || $days > $autoship_max_frequency ) continue; ?>
						<div class="wc-autoship-frequency-radio radio">
							<label for="wc_autoship_frequency_<?php echo esc_html( $days ); ?>">
								<input type="radio" name="wc_autoship_frequency" class="wc-autoship-frequency-input-radio"
									id="wc_autoship_frequency_<?php echo esc_html( $days ); ?>" 
									value="<?php echo esc_html( $days ); ?>"
									<?php echo checked( $days, $autoship_default_frequency ); ?> /> 
								<?php echo esc_html( $name ), ' ', __( "(Every $days days)", 'wc-autoship' ); ?>
							</label>
						</div>
					<?php endforeach; ?>
					<div id="wc-autoship-frequency-radio-no-autoship" class="wc-autoship-frequency-radio radio" <?php if ( empty( $autoship_default_frequency ) ) echo 'style="display: none"'; ?>>
						<label for="wc_autoship_frequency_no_autoship">
							<input type="radio" name="wc_autoship_frequency" class="wc-autoship-frequency-input-radio"
								id="wc_autoship_frequency_no_autoship" 
								value="" /> 
							<?php echo __( "No auto-ship. Make this a one-time purchase.", 'wc-autoship' ); ?>
						</label>
					</div>
				</div>
			</div>
		</div>
	</div>
	
</div>

<script>
jQuery(function ($) {
	$('.wc-autoship-frequency-input-radio').click(function () {
		$('#wc-autoship-frequency-radio-no-autoship').show();
	});
});
</script>

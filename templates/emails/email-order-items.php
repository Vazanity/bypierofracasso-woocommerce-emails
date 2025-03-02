<?php
/**
 * Email Order Items
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-order-items.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates/Emails
 * @version 3.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<?php
foreach ( $items as $item_id => $item ) :
	$product       = $item->get_product();
	$sku           = '';
	$purchase_note = '';
	$image         = '';

	if ( ! apply_filters( 'woocommerce_order_item_visible', true, $item ) ) {
		continue;
	}

	if ( is_object( $product ) ) {
		$sku           = $product->get_sku();
		$purchase_note = $product->get_purchase_note();
		$image         = $product->get_image( $image_size );
	}

?>

<!-- Contents : Product Info -->
<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" class="table-100pc">
	<tr>
		<td align="center" valign="middle" bgcolor="#F1F1F1" class="bg-F1F1F1">

			<!-- 600 -->
			<table border="0" width="600" align="center" cellpadding="0" cellspacing="0" class="row table-600">
				<tr>
					<td align="center" bgcolor="#FFFFFF" class="bg-FFFFFF">

						<!-- 520 -->
						<table border="0" width="520" align="center"  cellpadding="0" cellspacing="0" class="row table-520">
							<tr>
								<td align="center" class="container-padding">

									<!-- Content -->
									<table border="0" width="100%" cellpadding="0" cellspacing="0" align="center" class="table-100pc">
										<tr>
											<td class="spacer-15">&nbsp;</td>
										</tr>

										<tr>
											<td align="center" valign="middle">

												<!--[if (gte mso 9)|(IE)]><table border="0" cellpadding="0" cellspacing="0"><tr><td><![endif]-->
												
												<!-- Columns 1 OF 3 -->
												<table width="100" border="0" cellpadding="0" cellspacing="0" align="left" class="row table-100 table-left">
													<tr>
														<td align="center" valign="middle">

															<a href="<?php echo $url = get_permalink( $item['product_id'] ); ?>">
																<?php
																	echo apply_filters( 'woocommerce_order_item_thumbnail', '<img src="' . ( $product->get_image_id() ? current( wp_get_attachment_image_src( $product->get_image_id(), 'medium' ) ) : wc_placeholder_img_src() ) . '" alt="' . esc_attr__( 'Product image', 'woocommerce' ) . '" class="border-radius-8" width="100" style="max-width:100px"', $item);
																?>
															</a>

														</td>
													</tr>
												</table>

												<!--[if (gte mso 9)|(IE)]></td><td><![endif]-->

												<!-- Columns 20px Gaps -->
												<table width="20" border="0" cellpadding="0" cellspacing="0" align="left" class="row table-20 table-left">
													<tr>
														<td valign="middle" align="center" height="20"></td>
													</tr>
												</table>

												<!--[if (gte mso 9)|(IE)]></td><td><![endif]-->

												<!-- Columns 2 OF 3 -->
												<table width="300" border="0" cellpadding="0" cellspacing="0" align="left" class="row table-300 table-left">
													<tr>
														<td valign="middle" align="center" class="autoheight" height="10"></td>
													</tr>

													<tr>
														<td align="left" valign="middle" class="center-text font-primary font-191919 font-18 font-weight-600 font-space-0 pb-5 small">
															<a href="<?php echo $url = get_permalink( $item['product_id'] ); ?>" class="font-191919 capitalize">
																<?php echo wp_kses_post( apply_filters( 'woocommerce_order_item_name', $item->get_name(), $item, false ) );
																?>
															</a>
														</td>
													</tr>

													<tr>
														<td align="left" valign="middle" class="center-text font-primary font-595959 font-16 font-weight-400 font-space-0 small capitalize">
															<?php 
																echo apply_filters( 'woocommerce_email_order_item_quantity', ' Qty: ' . $item->get_quantity(), $item ) . ' , Price: ';
																if ($product->get_sale_price() != '') {
																	echo wc_price($product->get_sale_price());
																} else {
																	echo wc_price($product->get_regular_price());
																}
															?>
														</td>
													</tr>
												</table>

												<!--[if (gte mso 9)|(IE)]></td><td><![endif]-->

												<!-- Columns 10px Gaps -->
												<table width="10" border="0" cellpadding="0" cellspacing="0" align="left" class="row table-10 table-left">
													<tr>
														<td valign="middle" align="center" height="10"></td>
													</tr>
												</table>

												<!--[if (gte mso 9)|(IE)]></td><td><![endif]-->

												<!-- Columns 3 OF 3 -->
												<table width="90" border="0" cellpadding="0" cellspacing="0" align="left" class="row table-90 table-left">
													<tr>
														<td valign="middle" align="center" class="autoheight" height="10"></td>
													</tr>

													<tr>
														<td align="right" valign="middle" class="center-text font-primary font-191919 font-20 font-weight-600 font-space-0 small">
															<?php echo $order->get_formatted_line_subtotal( $item ); ?>
														</td>
													</tr>
												</table>

												<!--[if (gte mso 9)|(IE)]></td></tr></table><![endif]-->

											</td>
										</tr>

										<tr>
											<td class="spacer-15">&nbsp;</td>
										</tr>
									</table>

								</td>
							</tr>
						</table>
						<!-- End 520 -->

					</td>
				</tr>
			</table>
			<!-- End 600 -->
			
		</td>
	</tr>
</table>
<!-- Contents : Product Info -->

<!-- Dividers : Divider -->
<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" class="table-100pc">
	<tr>
		<td align="center" valign="middle" bgcolor="#F1F1F1" class="bg-F1F1F1">

			<!-- 600 -->
			<table border="0" width="600" align="center" cellpadding="0" cellspacing="0" class="row table-600">
				<tr>
					<td align="center" bgcolor="#FFFFFF" class="bg-FFFFFF">

						<!-- 520 -->
						<table border="0" width="520" align="center" cellpadding="0" cellspacing="0" class="row table-520">
							<tr>
								<td align="center" class="container-padding">

									<!-- Content -->
									<table border="0" width="100%" cellpadding="0" cellspacing="0" align="center" class="table-100pc">
										<tr>
											<td class="spacer-15">&nbsp;</td>
										</tr>

										<tr>
											<td class="bg-F1F1F1 spacer-1">&nbsp;</td>
										</tr>

										<tr>
											<td class="spacer-15">&nbsp;</td>
										</tr>
									</table>

								</td>
							</tr>
						</table>
						<!-- End 520 -->

					</td>
				</tr>
			</table>
			<!-- End 600 -->
			
		</td>
	</tr>
</table>
<!-- Dividers : Divider -->


<?php endforeach; ?>

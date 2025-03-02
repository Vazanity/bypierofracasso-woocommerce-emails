<?php
/**
 * Order details table shown in emails.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-order-details.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates/Emails
 * @version 3.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$text_align = is_rtl() ? 'right' : 'left';

if(isset($order_type) == false ) {
	$order_type = 'order';
}

do_action( 'woocommerce_email_before_order_table', $order, $sent_to_admin, $plain_text, $email ); 

?>

<?php
	echo wc_get_email_order_items( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		$order,
		array(
			'show_sku'      => $sent_to_admin,
			'show_image'    => true,
			'image_size'    => array( 150, 150 ),
			'plain_text'    => $plain_text,
			'sent_to_admin' => $sent_to_admin,
		)
	);
?>

<?php do_action( 'woocommerce_email_after_order_table', $order, $sent_to_admin, $plain_text, $email ); ?>

<!-- Contents : Order Summary -->
<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" class="table-100pc">
	<tr>
		<td align="center" valign="middle" bgcolor="#F1F1F1" class="bg-F1F1F1">

			<!-- 600 -->
			<table border="0" width="600" align="center" cellpadding="0" cellspacing="0" class="row table-600">
				<tr>
					<td align="center" bgcolor="#FFFFFF" class="bg-FFFFFF">

						<!-- 520 -->
						<table width="520" border="0" cellpadding="0" cellspacing="0" align="center" class="row table-520">
							<tr>
								<td align="center" class="container-padding">

									<!-- Content -->
									<table border="0" width="100%" cellpadding="0" cellspacing="0" align="center" class="table-100pc">
										<tr>
											<td class="spacer-15">&nbsp;</td>
										</tr>

										<?php 
											$item_totals = $order->get_order_item_totals();
											$numItems = count($item_totals);
											if ( $item_totals ) {
												$i = 0;
												foreach ( $item_totals as $total ) {
													$i++;
										?>
										
										<tr>
											<td align="center" valign="middle">

												<!--[if (gte mso 9)|(IE)]><table border="0" cellpadding="0" cellspacing="0"><tr><td><![endif]-->
												
												<!-- Columns 1 OF 2 -->
												<table width="255" border="0" cellpadding="0" cellspacing="0" align="left" class="row table-255 table-left">
													<?php if ( $i === $numItems ) { ?>
														<tr>
															<td class="spacer-15 hide-mobile">&nbsp;</td>
														</tr>

														<tr>
															<td class="bg-F1F1F1 spacer-1">&nbsp;</td>
														</tr>

														<tr>
															<td class="spacer-30">&nbsp;</td>
														</tr>

														<tr>
															<td align="left" valign="middle" class="center-text font-primary font-191919 font-22 font-weight-600 font-space-0 small capitalize">
																<?php echo wp_kses_post( $total['label'] ); ?>
															</td>
														</tr>
													<?php } else { ?>
														<tr>
															<td align="left" valign="middle" class="center-text font-primary font-595959 font-18 font-weight-400 font-space-0 small capitalize">
																<?php echo wp_kses_post( $total['label'] ); ?>
															</td>
														</tr>
													<?php } ?>
												</table>

												<!--[if (gte mso 9)|(IE)]></td><td><![endif]-->

												<!-- Columns 10px Gaps -->
												<table width="10" border="0" cellpadding="0" cellspacing="0" align="left" class="row table-10 table-left">
													<?php if ( $i === $numItems ) { ?>
														<tr>
															<td class="spacer-15 hide-mobile">&nbsp;</td>
														</tr>

														<tr>
															<td class="bg-F1F1F1 spacer-1 hide-mobile">&nbsp;</td>
														</tr>

														<tr>
															<td class="spacer-30 hide-mobile">&nbsp;</td>
														</tr>
													<?php } ?>
														<tr>
															<td valign="middle" align="center" height="10"></td>
														</tr>
												</table>

												<!--[if (gte mso 9)|(IE)]></td><td><![endif]-->

												<!-- Columns 2 OF 2 -->
												<table width="255" border="0" cellpadding="0" cellspacing="0" align="left" class="row table-255 table-left">
													<?php if ( $i === $numItems ) { ?>
														<tr>
															<td class="spacer-15 hide-mobile">&nbsp;</td>
														</tr>

														<tr>
															<td class="bg-F1F1F1 spacer-1 hide-mobile">&nbsp;</td>
														</tr>

														<tr>
															<td class="spacer-30 hide-mobile">&nbsp;</td>
														</tr>

														<tr>
															<td align="right" valign="middle" class="center-text font-primary font-191919 font-22 font-weight-600 font-space-0 small small-br capitalize">
																<?php echo wp_kses_post( $total['value'] ); ?>
															</td>
														</tr>
														
														<?php } else { ?>
														<tr>
															<td align="right" valign="middle" class="center-text font-primary font-595959 font-18 font-weight-600 font-space-0 small capitalize">
																<?php echo wp_kses_post( $total['value'] ); ?>
															</td>
														</tr>
														<?php } ?>
												</table>

												<!--[if (gte mso 9)|(IE)]></td></tr></table><![endif]-->

											</td>
										</tr>
										<tr>
											<td class="spacer-15">&nbsp;</td>
										</tr>
										<?php } } ?>
										
										<tr>
											<td class="spacer-5">&nbsp;</td>
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
<!-- Contents : Order Summary -->

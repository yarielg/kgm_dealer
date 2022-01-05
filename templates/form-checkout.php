<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
    echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
    return;
}

$flag_require_dealer = false;

foreach (WC()->cart->get_cart() as $car_item){
    if(get_field('require_dealer',$car_item['product_id'])){
        $flag_require_dealer = true;
    }
}
?>
<div class="row">
    <div class="col-12 d-flex justify-content-between mb-4 top-images">
        <img src="<?php echo KGM_PLUGIN_URL . 'assets/images/logo.png' ?>" alt="">
        <img src="<?php echo KGM_PLUGIN_URL . 'assets/images/secure.png' ?>" alt="">
    </div>
</div>
<br>
<?php
include  KGM_PLUGIN_PATH . '/templates/partials/step_bar.php';

?>

<form id="regForm" name="checkout" method="post" class="checkout woocommerce-checkout mt-5 pt-5" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
    <div class="container">

        <div class="row">
            <div class="col-md-6 billing-4-checkout" data-hide="<?php echo $flag_require_dealer ? 4 : 2 ?>">
                <?php if ( $checkout->get_checkout_fields() ) : ?>

                    <?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

                    <input type="hidden" id="dealer_selected" value="">

                    <div class="col2-set step step-1" id="customer_details">
                        <div class="">
                            <?php do_action( 'woocommerce_checkout_billing' ); ?>
                        </div>

                        <!--<div class="col-2">
                            <?php /*do_action( 'woocommerce_checkout_shipping' ); */?>
                        </div>-->

                    </div>

                    <?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

                    <?php if($flag_require_dealer){ ?>
                        <div class="col2-set step step-2" id="ffl_locators">
                            <!--<div class="dealer_selection_options">
                                <input checked class="dealer_selection_radio choose" id="choose" type="radio" name="select_type_dealer_selection">
                                <label class="label_dealer_radio" for="choose">Select a dealer</label>
                                <input class="dealer_selection_radio enter" id="enter" type="radio" name="select_type_dealer_selection">
                                <label class="label_dealer_radio" for="enter">Enter Your Dealer</label>
                            </div>-->

                            <!-- Adding dealer if field -->
                            <input type="hidden" name="dealer_ffl_id" id="dealer_ffl_id" value="">
                            <div class="enter_your_dealer" style="display: none">
                                <?php include KGM_PLUGIN_PATH . '/templates/partials/enter_dealer_info.php' ?>
                            </div>
                            <div id="enter_dealer_msg_success" style="display: none">
                                <button id="change_dealer_btn" type="button">Change Dealer</button>
                            </div>

                            <button type="button" id="get_location_btn" onclick="window.Kgm.MapHandler.getLocation()">Use Current Location</button>
                            <div id="zipcode-fields">
                                <input type="number" placeholder="Enter zipcode" id="enter_zipcode">
                                <button type="button" onclick="window.Kgm.MapHandler.getLocationZipCode()"  id="enter_zipcode_btn">Use Zipcode</button>
                            </div>
                            <div class="dealer_selection">
                                <div id="map_id_wrapper"></div>
                                <br>
                                <h3><strong>FFL DEALERS</strong></h3>
                                <div id="fll_dealer_list"></div>
                            </div>
                        </div>

                        <div class="col2-set step step-3" id="nfa_agreements">
                            <?php include KGM_PLUGIN_PATH . '/templates/partials/terms_check.php' ?>
                        </div>
                    <?php } ?>

                <?php endif; ?>
            </div>

            <div class="col-md-6 step step-4 shipping-4-checkout">
                    <?php do_action( 'woocommerce_checkout_shipping' ); ?>

            </div>

            <div class="col-md-6">
                <?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>

                <?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

                <div id="order_review" class="woocommerce-checkout-review-order">
                    <?php do_action( 'woocommerce_checkout_order_review' ); ?>
                </div>

                <?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
            </div>

        </div>
    </div>
    <!-- Circles which indicates the steps of the form: -->


</form>
<button id="go_back" class="btn-step footer go_back" >Go Back</button>
<button class="btn-step footer continue">Continue <img class="icon_triangle" src="<?php echo KGM_PLUGIN_URL . 'assets/images/triangle.png' ?>" alt=""></button>
<button style="display: none" class="continue" id="place_an_order">COMPLETE ORDER <img class="icon_triangle" src="<?php echo KGM_PLUGIN_URL . 'assets/images/triangle.png' ?>" alt=""></button>


</div>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>

<?php

/*
*
* @package Yariko
*
*/

namespace Kgm\Inc\Base;

class Settings{

    public function register(){

        /**
         * Override woocommerce template from plugin
         */

        add_filter( 'woocommerce_locate_template', array($this, 'kgm_locate_template'), 10, 3 );

        /**
         * Add custom meta field to store the dealer id
         */
        add_action( 'woocommerce_checkout_update_order_meta', array($this, 'kgm_update_dealer_id_field_on_checkout'), 10, 1 );

        /**
         * Display dealer info on admin order single
         */
        add_action( 'woocommerce_admin_order_data_after_order_details', array($this, 'kgm_show_dealer_info_on_single_order_admin') );
    }

    function kgm_locate_template( $template, $template_name, $template_path ) {
        $basename = basename( $template );

        switch ($basename){
            case 'review-order.php':
                $template = KGM_PLUGIN_PATH . 'templates/review-order.php';
                break;
            case 'payment.php':
                $template = KGM_PLUGIN_PATH . 'templates/payment.php';
                break;
            case 'form-checkout.php':
                $template = KGM_PLUGIN_PATH . 'templates/form-checkout.php';
                break;
        }

        return $template;
    }

    function kgm_update_dealer_id_field_on_checkout($order_id){
        if ( $_POST['dealer_ffl_id'] && !empty($_POST['dealer_ffl_id'])){
            update_post_meta( $order_id, 'dealer_ffl_id', esc_attr($_POST['dealer_ffl_id']) );
        }
    }

    function kgm_show_dealer_info_on_single_order_admin( $order ){
        $ffl_id = get_post_meta( $order->get_id(), 'dealer_ffl_id', true );
        $city = '';
        $country = '';
        $state = '';
        $zip = '';
        $name = '';
        $address = '';
        if(!empty($ffl_id)){
            $city = get_post_meta($ffl_id,'wpsl_city',true);
            $country = get_post_meta($ffl_id,'wpsl_country',true);
            $state = get_post_meta($ffl_id,'wpsl_state',true);
            $zip = get_post_meta($ffl_id,'wpsl_zip',true);
            $name = get_the_title($ffl_id);
            $address = get_post_meta($ffl_id,'wpsl_address',true);
            $phone = get_post_meta($ffl_id,'wpsl_phone',true);
        }
        ?>
        <div class="order_data_column dealer_info_order">
            <h3><?php _e( 'FFL Dealer Info' ); ?></h3>
            <?php
            echo '<p>Name: <strong> ' . $name . '</strong></p>';
            echo '<p>Phone: <strong> ' . $phone . '</strong></p>';
            echo '<p>Address:<strong> ' . $address . '</strong></p>';
            echo '<p><strong>' . $city . ', ' . $state . ' ' . $zip . '</strong></p>';
            ?>
        </div>
    <?php }

}
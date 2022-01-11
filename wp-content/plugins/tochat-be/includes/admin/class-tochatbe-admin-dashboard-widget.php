<?php
defined( 'ABSPATH' ) || exit;

class TOCHATBE_Admin_Dashboard_Widget {

    public function __construct() {
        add_action( 'wp_dashboard_setup', array( $this, 'add_dashboard_widgets' ) );
        add_action( 'admin_head', array( $this, 'admin_head_css' ) );
    }

    public function add_dashboard_widgets() {
        wp_add_dashboard_widget(
            'tochatbe_log_dashboard_widget',
            'TOCHAT.BE Analytics',
            array( $this, 'dashboard_analytics' )
        );

        wp_add_dashboard_widget(
            'tochatbe_dashboard_recent_orders_widget',
            'TOCHAT.BE Recent Orders',
            array( $this, 'dashboard_recent_orders' )
        ); 
    }

    public function dashboard_analytics() {
        ?>
        <img class="tochatbe-dashboard-widget-logo" src="<?php echo TOCHATBE_PLUGIN_URL . 'assets/images/logo-full.png' ?>" alt="//" width="140">
        <p>Contacts you have generated with the WhatsApp Widget. <br>Click <a href="<?php echo admin_url( 'admin.php?page=to-chat-be-whatsapp_click-log' ); ?>">here</a> to see full click log.</p>
        <hr>
        <div class="tochatbe-dashboard-widget">
            <div>
                <p>Today</p><span><?php echo esc_html( TOCHATBE_Log::get_total_day_click() ); ?></span>
            </div>
            <div>
                <p>Last Week</p><span><?php echo esc_html( TOCHATBE_Log::get_this_week_click() ); ?></span>
            </div>
            <div>
                <p>Last Month</p><span><?php echo esc_html( TOCHATBE_Log::get_this_month_click() ); ?></span>
            </div>
            <div>
                <p>Total</p><span><?php echo esc_html( TOCHATBE_Log::get_total_click() ); ?></span>
            </div>
        </div>
        <hr>
        <p>Learn to sell with <a href="https://tochat.be/click-to-chat/whatsapp-academy/" target="_blank">WhatsApp Academy</a></p>
        <p>Make your <a href="https://tochat.be/click-to-chat/2020/01/25/how-the-whatsapp-plugin-works-in-wordpress/" target="_blank">WhatsApp Widget Amazing</a></p>
        <?php
    }

    public function dashboard_recent_orders() {
        ?>
            <p>Send a thank you note or reminder.</p>

            <?php
                $args = array(
                    'post_type'      => 'shop_order',
                    'posts_per_page' => '10',
                    'post_status'    => 'any'
                );
                
                $orders = get_posts( $args );
            ?>

            <?php if ( $orders ) : ?>
                <table class="tochatbe-dashboard-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Order Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ( $orders as $order ) : ?>
                        <?php $order = wc_get_order( $order->ID ); ?>
                        <?php
                            $order_message = '';
                            $order_status  = $order->get_status();
                
                            if ( 'processing' === $order_status ) {
                                $order_message = tochatbe_woo_order_button_option( 'pre_message_processing_order' );
                            } else if ( 'cancelled' === $order_status ) {
                                $order_message = tochatbe_woo_order_button_option( 'pre_message_canceled_order' );
                            } else if ( 'completed' === $order_status ) {
                                $order_message = tochatbe_woo_order_button_option( 'pre_message_completed_order' );
                            }
                        ?>
                        <tr>
                            <td><?php echo $order->get_formatted_billing_full_name(); ?></td>
                            <td><?php echo $order->get_status(); ?></td>
                            <td>
                                <div 
                                    class="tochatbe-woo-order-btn" 
                                    data-tochat-order-billing-number="<?php echo $order->get_billing_phone(); // WPCS: XSS ok. ?>"
                                    data-tochat-order-message="<?php echo esc_textarea( $order_message ); ?>"
                                    data-tochat-order-id="<?php echo $order->get_id(); ?>"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                        <path fill="currentColor" d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"></path>
                                    </svg>
                                    <p>Click to chat</p>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="tochatbe-woo-order-popup">
                    <form action="#" method="post">
                        <input type="hidden" name="order_id" value="<?php echo get_the_ID(); ?>">
                        <div>
                            <label>Phone Number</label>
                            <input type="number" step="1" name="number" value="">
                            <p class="desc">Please add the country code before sending the message. Edit the user profile to keep the country code in the number. Just add numbers, no + sign.</p>
                        </div>
                        <div>
                            <label>Message</label>
                            <textarea name="message"></textarea>
                        </div>
                        <div>
                            <input type="submit" value="SEND">
                            <a href="javascript:;">CANCEL</a>
                        </div>
                    </form>
                    <p>
                        <a href="https://tochat.be/click-to-chat/2020/11/08/messages-to-recover-clients-from-wordpress-with-whatsapp/" tagret="_blank">Check out messages you can use to recover your clients.</a>
                    </p>
                </div>
                <script>
                    jQuery( document ).ready( function() {
                        // Open popup
                        jQuery( '.tochatbe-woo-order-btn' ).on( 'click', function( e ) {
                            e.preventDefault();
                            
                            var contactNumber = jQuery( this ).data( 'tochat-order-billing-number' );
                            var orderID       = jQuery( this ).data( 'tochat-order-id' );
                            var orderMessage  = jQuery( this ).data( 'tochat-order-message' );
                            
                            jQuery( '.tochatbe-woo-order-popup' ).find( '[name="number"]' ).val( contactNumber );
                            jQuery( '.tochatbe-woo-order-popup' ).find( '[name="order_id"]' ).val( orderID );
                            jQuery( '.tochatbe-woo-order-popup' ).find( '[name="message"]' ).val( orderMessage );
                            jQuery( '.tochatbe-woo-order-popup' ).show();
                        } );

                        // Close popup
                        jQuery( '.tochatbe-woo-order-popup form a' ).on( 'click', function() {
                            jQuery( '.tochatbe-woo-order-popup' ).hide();
                        } );

                        // Send message
                        jQuery( '.tochatbe-woo-order-popup form' ).on( 'submit', function( event )  {
                            event.preventDefault();
                            
                            var number  = jQuery( '[name="number"]' ).val();
                            var message = jQuery( '[name="message"]' ).val();
                            var ordeID = jQuery( '[name="order_id"]' ).val();

                            jQuery.ajax( {
                                url: tochatbeAdmin.ajax_url,
                                type: 'post',
                                data: {
                                    'action': 'tochatbe_save_order_message',
                                    'message' : message,
                                    'security_token': tochatbeAdmin.security_token,
                                    'order_id': ordeID
                                }
                            } );

                            window.open( 'https://api.whatsapp.com/send?phone=' + number + '&text=' + message + '' );

                            jQuery( '.tochatbe-woo-order-popup' ).hide();
                        } );

                    } );
                </script>
            <?php else : ?>
                <p style="text-align: center">No order found!</p>
            <?php endif; ?>
        <?php
    }

    public function admin_head_css() {
        $current_Screen = get_current_screen();
        
        if ( 'dashboard' !== $current_Screen->id ) {
            return;
        }

        ?>
        <style>
            .tochatbe-dashboard-widget {
                display: flex;
            }

            .tochatbe-dashboard-widget > div {
                width: 25%;
                border-right: 1px solid #ccc;
            }

            .tochatbe-dashboard-widget > div:last-child {
                border-right: 1px solid transparent;
            }

            .tochatbe-dashboard-widget > div > p {
                font-weight: 700;
                text-align: center;
            }

            .tochatbe-dashboard-widget > div > span{
                display: block;
                text-align: center;
            }

            .tochatbe-dashboard-widget-logo {
                display: block;
                margin: 0 auto;
            }

            .tochatbe-dashboard-table {
                table-layout: fixed;
                width: 100%;
            }

            .tochatbe-dashboard-table th,
            .tochatbe-dashboard-table td {
                text-align: left;
                padding-bottom: 10px;
            }

            .tochatbe-woo-order-btn {
                background-color: #25D366;
                color: #fff;
                padding: 5px 10px;
                display: inline-flex;
                border-radius: 2px;
                cursor: pointer !important;
            }

            .tochatbe-woo-order-btn svg {
                width: 14px;
                margin-right: 5px;
            }

            .tochatbe-woo-order-btn p {
                color: #fff !important;
                padding: 0;
                margin: 0;
                font-size: 14px;
            }

            .tochatbe-woo-order-popup {
                width: 400px;
                max-width: 98%;
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate( -50%, -50% );
                background-color: #fff;
                z-index: 9999;
                padding: 15px;
                border: 1px solid #ccc;
                border-radius: 4px;
                box-shadow: 0 0 30px rgba( 0,0,0,.2 );
                display: none;
            }

            .tochatbe-woo-order-popup form > div {
                margin-bottom: 10px;
            }

            .tochatbe-woo-order-popup form > div > label {
                display: block;
                margin-bottom: 5px;
            }

            .tochatbe-woo-order-popup form input[type="number"],
            .tochatbe-woo-order-popup form textarea {
                width: 100%;
            }

            .tochatbe-woo-order-popup form textarea {
                height: 100px;
            }

            .tochatbe-woo-order-popup form input[type="submit"] {
                padding: 5px 10px;
                background-color: #25D366;
                border: 1px solid #25D366;
                color: #fff;
                font-weight: 700;
                cursor: pointer;
            }

            .tochatbe-woo-order-popup form a {
                text-decoration: none;
                padding: 5px 10px;
                color: #333 !important;
                font-weight: 700;
                cursor: pointer;
            }

            .tochatbe-woo-order-popup form .desc {
                color: #999;
                padding: 0;
                margin: 0;
                font-style: italic;
            }
        </style>
        <?php
    }

}

new TOCHATBE_Admin_Dashboard_Widget;
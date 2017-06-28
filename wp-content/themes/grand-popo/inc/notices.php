<?php

function grand_popo_get_review_suggestion_notice()
{
    $ignore_notices=  get_option( 'grand-popo_free_admin_notice_ignore' );
    $dismiss_transient=get_transient( 'grand-popo_notice_dismiss' );
    if($ignore_notices||$dismiss_transient!==false)
        return;
    $two_week_review_ignore = add_query_arg( array( 'grand-popo_free_admin_notice_ignore' => '1' ) );
    $two_week_review_temp = add_query_arg( array( 'grand-popo_free_admin_notice_temp_ignore' => '1', 'grand-popo_int' => 14 ) );
    $one_week_support = add_query_arg( array( 'grand-popo_free_admin_notice_ignore' => '1' ) );
    ?>
    <div class="update-nag grand-popo-admin-notice notice is-dismissible">
        <div class="grand-popo-notice-logo"></div> 
        <p class="grand-popo-notice-title"><?php _e("Leave A Review?", "grand-popo");?></p> 
        <p class="grand-popo-notice-body"><?php _e("We hope you've enjoyed using our theme Grand-Popo! Would you consider leaving us a review on wordpress.org? ", "grand-popo");?></p>
        <ul class="grand-popo-notice-body grand-popo-red">
            <li> <span class="dashicons dashicons-smiley"></span><a href="<?php echo $two_week_review_ignore;?>"><?php _e("I've already left a review", "grand-popo");?></a></li>
            <li><span class="dashicons dashicons-calendar-alt"></span><a href="<?php echo $two_week_review_temp;?>"><?php _e("Maybe Later", "grand-popo");?></a></li>
            <li><span class="dashicons dashicons-editor-help"></span><a href="http://static.orionorigin.com/how-to-review-gp-free.png" target="_blank"><?php _e("Show me how", "grand-popo");?></a></li>
            <li><span class="dashicons dashicons-external"></span><a href="https://wordpress.org/support/theme/grand-popo/reviews/#new-post?ref=orionorigin&utm_source=Ratings&utm_medium=cpc&utm_campaign=Grand-Popo" target="_blank"><?php _e("Sure! I'd love to!", "grand-popo");?></a></li>
        </ul>
    </div>
    <?php
}
add_action( 'admin_notices', 'grand_popo_get_review_suggestion_notice' );    
// Ignore function that gets ran at admin init to ensure any messages that were dismissed get marked
function grand_popo_admin_notice_ignore() {

    // If user clicks to ignore the notice, update the option to not show it again
    if ( isset($_GET['grand-popo_free_admin_notice_ignore']) && current_user_can( 'manage_product_terms' ) ) {
            update_option( 'grand-popo_free_admin_notice_ignore', true );
            $query_str = remove_query_arg( 'grand-popo_free_admin_notice_ignore' );
            wp_redirect( $query_str );
            exit;
    }
}
// Runs the admin notice ignore function incase a dismiss button has been clicked
add_action( 'admin_init', 'grand_popo_admin_notice_ignore' );
// Temp Ignore function that gets ran at admin init to ensure any messages that were temp dismissed get their start date changed
function grand_popo_admin_notice_temp_ignore() {

    // If user clicks to temp ignore the notice, update the option to change the start date - default interval of 14 days
    if ( isset($_GET['grand-popo_free_admin_notice_temp_ignore']) && current_user_can( 'manage_product_terms' ) ) {            
        $interval = ( isset( $_GET[ 'grand-popo_int' ] ) ? $_GET[ 'grand-popo_int' ] : 14 );
        set_transient( 'grand-popo_notice_dismiss', true, MINUTE_IN_SECONDS*$interval * DAY_IN_SECONDS );
        $query_str = remove_query_arg( array( 'grand-popo_free_admin_notice_temp_ignore', 'grand-popo_int' ) );
        wp_redirect( $query_str );
        exit;
    }
}
// Runs the admin notice temp ignore function incase a temp dismiss link has been clicked
add_action( 'admin_init', 'grand_popo_admin_notice_temp_ignore' );
<?php
/**
 * Displays Footer
 *
 */

?>

<div class="row">

<div class="col-md-12">
    <div class="currency-language">
        
        
        <div class="account-menu">
        
                 <?php
                    wp_nav_menu(
                        array(
                           'theme_location' => is_user_logged_in() ? 'account_after_log' : 'account_before_log',
                            'fallback_cb'    => false,
                            'container' 	 => '',
                           
                        )
                    );
                  ?>
            
        </div>
        
        
    </div>
</div>
</div>
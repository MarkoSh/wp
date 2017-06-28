<?php
/**
 * Displays Main Navigation
 *
 */

?>
<div class="mainmenu-area hidden-sm hidden-xs">
                <div id="sticker"> 
                    <div class="container">
                        <div class="row">   
                            <div class="col-lg-12 col-md-12 hidden-sm">
                                <div class="mainmenu">
                                   <nav>
                                       <ul id="nav">
                                             <?php
                                                wp_nav_menu(
                                                    array(
                                                        'theme_location' => 'primary',
                                                        'container' 	 => '',
                                                        
                                                        'items_wrap' => '%3$s'
                                                    )
                                                );
                                              ?>
                                       </ul>  
                                   </nav>  
                                </div>        
                            </div>
                        </div>
                    </div>
                </div>      
            </div>
            
              <!-- Mobile Menu Area start -->
                <div class="mobile-menu-area">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="mobile-menu">
                                    <nav id="dropdown">
										<?php
                                        wp_nav_menu(
                                            array(
                                                'theme_location' => 'primary',
                                                'container' 	 => '',
                                               
                                                
                                            )
                                        );
                                        ?>
                                    </nav>
                                </div>					
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Mobile Menu Area end -->
         
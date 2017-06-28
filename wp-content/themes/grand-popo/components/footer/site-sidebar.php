<?php
?>
<div>
        <?php

        if (is_active_sidebar('footer-sidebar') || is_active_sidebar('footer-sidebar-2') || is_active_sidebar('footer-sidebar-3') || is_active_sidebar('footer-sidebar-4') || is_active_sidebar('footer-sidebar-5') || is_active_sidebar('footer-sidebar-6') || is_active_sidebar('footer-sidebar-7') || is_active_sidebar('footer-sidebar-8') ) {
           global $grand_popo_options;
            $col_nbr= grand_popo_get_proper_value($grand_popo_options,'footer-sidebar-column','4');
            
            ?>
            <div class="bottom-footer-wrap secondary-footer">
                     
                    <div class="o-wrap xl-gutter-24 lg-gutter-24 md-gutter-12 sm-gutter-0">
                        <?php

                            if (is_active_sidebar('footer-sidebar')) {
                            ?>
                            <div id="footer-sidebar-1" class="sidebar col xl-1-<?php echo esc_attr($col_nbr); ?> lg-1-<?php echo esc_attr($col_nbr); ?> md-1-<?php echo esc_attr($col_nbr); ?> sm-1-1 " role="complementary">
                                <?php
                                dynamic_sidebar('footer-sidebar');
                                ?></div><?php
                            }
                            ?>

                            <?php
                            if (is_active_sidebar('footer-sidebar-2')) {
                                ?>
                                <div id="footer-sidebar-2" class="sidebar col xl-1-<?php echo esc_attr($col_nbr); ?> lg-1-<?php echo esc_attr($col_nbr); ?> md-1-<?php echo esc_attr($col_nbr); ?> sm-1-1 " role="complementary">
                                    <?php
                                    dynamic_sidebar('footer-sidebar-2');
                                    ?></div><?php
                            }
                            ?>

                            <?php
                            if (is_active_sidebar('footer-sidebar-3')) {
                                ?>
                                <div id="footer-sidebar-3" class="sidebar col xl-1-<?php echo esc_attr($col_nbr); ?> lg-1-<?php echo esc_attr($col_nbr); ?> md-1-<?php echo esc_attr($col_nbr); ?> sm-1-1 " role="complementary">
                                    <?php
                                    dynamic_sidebar('footer-sidebar-3');
                                    ?></div><?php
                            }
                            ?>
                            <?php
                            if (is_active_sidebar('footer-sidebar-4')) {
                                ?>
                                <div id="footer-sidebar-4" class="sidebar col xl-1-<?php echo esc_attr($col_nbr); ?> lg-1-<?php echo esc_attr($col_nbr); ?> md-1-<?php echo esc_attr($col_nbr); ?> sm-1-1 " role="complementary">
                                    <?php
                                    dynamic_sidebar('footer-sidebar-4');
                                    ?></div><?php
                            }
                            ?>
                            <?php
                            if (is_active_sidebar('footer-sidebar-5')) {
                                ?>
                                <div id="footer-sidebar-5" class="sidebar col xl-1-<?php echo esc_attr($col_nbr); ?> lg-1-<?php echo esc_attr($col_nbr); ?> md-1-<?php echo esc_attr($col_nbr); ?> sm-1-1 " role="complementary">
                                    <?php
                                    dynamic_sidebar('footer-sidebar-5');
                                    ?></div><?php
                            }
                            ?>
                            <?php
                            if (is_active_sidebar('footer-sidebar-6')) {
                                ?>
                                <div id="footer-sidebar-6" class="sidebar col xl-1-<?php echo esc_attr($col_nbr); ?> lg-1-<?php echo esc_attr($col_nbr); ?> md-1-<?php echo esc_attr($col_nbr); ?> sm-1-1 " role="complementary">
                                    <?php
                                    dynamic_sidebar('footer-sidebar-6');
                                    ?></div><?php
                            }
                            ?>
                            <?php
                            if (is_active_sidebar('footer-sidebar-7')) {
                                ?>
                                <div id="footer-sidebar-7" class="sidebar col xl-1-<?php echo esc_attr($col_nbr); ?> lg-1-<?php echo esc_attr($col_nbr); ?> md-1-<?php echo esc_attr($col_nbr); ?> sm-1-1 " role="complementary">
                                    <?php
                                    dynamic_sidebar('footer-sidebar-7');
                                    ?></div><?php
                            }
                            ?>
                            <?php
                            if (is_active_sidebar('footer-sidebar-8')) {
                                ?>
                                <div id="footer-sidebar-8" class="sidebar col xl-1-<?php echo esc_attr($col_nbr); ?> lg-1-<?php echo esc_attr($col_nbr); ?> md-1-<?php echo esc_attr($col_nbr); ?> sm-1-1 " role="complementary">
                                    <?php
                                    dynamic_sidebar('footer-sidebar-8');
                                    ?></div><?php
                            }
                            ?>
                        </div>
                </div>
            <?php
                }
                ?>
                    
    </div>


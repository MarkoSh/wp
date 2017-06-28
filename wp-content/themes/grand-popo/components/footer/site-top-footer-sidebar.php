<?php
if (is_active_sidebar('top-footer-sidebar')) {
    ?>
    <div class="top-footer-wrap">

        <div class="site-wrap">

            <div class="o-wrap">

                <div id="top-footer-sidebar" class="sidebar col xl-1-1 lg-1-1 md-1-1 sm-1-1 " role="complementary">
                    <?php dynamic_sidebar('top-footer-sidebar'); ?>
                </div>    

            </div>
        </div>

    </div>
    <?php
}


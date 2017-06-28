<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 09/06/17
 * Time: 17:48
 */
get_header();

?>

<div class="container-fluid">

    <div class="container">
        <div class="row">
            <div class="col-md-12">
            <?php woocommerce_content(); ?>
            </div>
        </div>
    </div>

</div>


<?php

get_footer();
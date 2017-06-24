<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 09/06/17
 * Time: 17:56
 */
get_header();

while ( have_posts() ) : the_post();

    the_content();

endwhile; // End of the loop.

get_footer();
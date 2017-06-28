<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Grand-Popo
 */
?>
</div>
</div>

    <?php get_template_part('components/footer/site', 'sidebar'); ?>

    <a class="to-top-btn <?php grand_popo_get_scroll_to_top() ?>" href="#top"><i class="fa fa-chevron-up" ></i></a>

    <footer id="colophon" class="site-footer" >
        <div class="site-wrap">
    <?php
    get_template_part('components/footer/site', 'info');

    grand_popo_get_social_link();
    ?>

        </div>
    </footer>
       
</div>
<?php wp_footer(); ?>

</body>
</html>

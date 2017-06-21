<?php
/*
Plugin Name: Duplicate Page and Post
Plugin URI: http://www.hisysinfotech.com/
Description: This plugin quickly creates a clone of page or post
Author: Arjun Thakur
Author URI: http://www.hisysinfotech.com/
Version: 1.0.1
License: GPLv2 or later
Text Domain: dpp_wpp_page
*/
if ( ! defined( 'ABSPATH' ) ) exit;
if (!defined("dpp_wpp_page_directory-dn")) define("dpp_wpp_page_directory-dn", plugin_basename(dirname(__FILE__)));
if(!class_exists('dcc_dpp_wpp_page')):
  class dpp_wpp_page
  {

    /*AutoLoad Hooks*/
    public function __construct()
       {
        register_activation_hook(__FILE__, array(&$this, 'dpp_wpp_page_install'));
        add_action( 'admin_action_dt_dpp_post_as_draft', array(&$this,'dt_dpp_post_as_draft') ); 
        add_filter( 'post_row_actions', array(&$this,'dt_dpp_post_link'), 10, 2);
        add_filter( 'page_row_actions', array(&$this,'dt_dpp_post_link'), 10, 2);
        add_action( 'post_submitbox_misc_actions', array(&$this,'dpp_wpp_page_custom_button'));
        add_action( 'wp_before_admin_bar_render', array(&$this, 'dpp_wpp_page_admin_bar_link'));
       }
    
    /*Activation Hook*/
    public function dpp_wpp_page_install()
        {
        $defaultsettings = array('dpp_post_status' => 'draft',
                                  'dpp_post_redirect' => 'to_list',
                                  'dpp_post_suffix' => '' );
                               $opt = get_option('dpp_wpp_page_options');
                               if(!$opt['dpp_post_status'])
                                {
                                 update_option('dpp_wpp_page_options', $defaultsettings);
                                 } 
    }
   
    /*Important function*/
     public function dt_dpp_post_as_draft()
        {
              global $wpdb;
   
              /*sanitize_GET POST REQUEST*/
              $post_copy = sanitize_text_field( $_POST["post"] );
              $get_copy = sanitize_text_field( $_GET['post'] );
              $request_copy = sanitize_text_field( $_REQUEST['action'] );
 
              $opt = get_option('dpp_wpp_page_options');
              $suffix = !empty($opt['dpp_post_suffix']) ? ' -- '.$opt['dpp_post_suffix'] : '';
              $post_status = !empty($opt['dpp_post_status']) ? $opt['dpp_post_status'] : 'draft';
              $redirectit = !empty($opt['dpp_post_redirect']) ? $opt['dpp_post_redirect'] : 'to_list';

                if (! ( isset( $get_copy ) || isset( $post_copy ) || ( isset($request_copy) && 'dt_dpp_post_as_draft' == $request_copy ) ) ) {
                wp_die('No post!');
                }
                $returnpage = '';
   
                /* Get post id */
                $post_id = (isset($get_copy) ? $get_copy : $post_copy );

                $post = get_post( $post_id );
                
                $current_user = wp_get_current_user();
                $new_post_author = $current_user->ID;
   
                /*Create the post Copy */
                if (isset( $post ) && $post != null) {
                    /* Post data array */
                    $args = array('comment_status' => $post->comment_status,
                    'ping_status' => $post->ping_status,
                    'post_author' => $new_post_author,
                    'post_content' => $post->post_content,
                    'post_excerpt' => $post->post_excerpt,
                    'post_name' => $post->post_name,
                    'post_parent' => $post->post_parent,
                    'post_password' => $post->post_password,
                    'post_status' => $post_status,
                    'post_title' => $post->post_title.$suffix,
                    'post_type' => $post->post_type,
                    'to_ping' => $post->to_ping,
                    'menu_order' => $post->menu_order

                   );
                   $new_post_id = wp_insert_post( $args );
                   
                   $taxonomies = get_object_taxonomies($post->post_type);
                   if(!empty($taxonomies) && is_array($taxonomies)):
                   foreach ($taxonomies as $taxonomy) {
                      $post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
                      wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);}
                   endif;
                      
                   $post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");
                   if (count($post_meta_infos)!=0) {
                   $sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
                   foreach ($post_meta_infos as $meta_info) {
                      $meta_key = $meta_info->meta_key;
                      $meta_value = addslashes($meta_info->meta_value);
                      $sql_query_sel[]= "SELECT $new_post_id, '$meta_key', '$meta_value'";
                      }
                        $sql_query.= implode(" UNION ALL ", $sql_query_sel);
                        $wpdb->query($sql_query);
                      }

                     /*choice redirect */
                     if($post->post_type != 'post'):$returnpage = '?post_type='.$post->post_type;  endif;
                     if(!empty($redirectit) && $redirectit == 'to_list'):wp_redirect( admin_url( 'edit.php'.$returnpage ) );
                     elseif(!empty($redirectit) && $redirectit == 'to_page'):wp_redirect( admin_url( 'post.php?action=edit&post=' . $new_post_id ) );
                     else:
                     wp_redirect( admin_url( 'edit.php'.$returnpage ) );
                     endif;
                     exit;
                     } else {
                     wp_die('Error! Post creation failed: ' . $post_id);
                     }
       }

    /*Add link to action*/
    public function dt_dpp_post_link( $actions, $post ) {
      $opt = get_option('dpp_wpp_page_options');
      $post_status = !empty($opt['dpp_post_status']) ? $opt['dpp_post_status'] : 'draft';
      if (current_user_can('edit_posts')) {
         $actions['dpp'] = '<a href="admin.php?action=dt_dpp_post_as_draft&amp;post=' . $post->ID . '" title="Clone this as '.$post_status.'" rel="permalink">Click here to Clone</a>';
          }
          return $actions;
      }
    
    /*Add link to edit Post*/
    public function dpp_wpp_page_custom_button(){
       $opt = get_option('dpp_wpp_page_options');
       $post_status = !empty($opt['dpp_post_status']) ? $opt['dpp_post_status'] : 'draft';
       global $post;
       $html  = '<div id="major-publishing-actions">';
       $html .= '<div id="export-action">';
       $html .= '<a href="admin.php?action=dt_dpp_post_as_draft&amp;post=' . $post->ID . '" title="dpp this as '.$post_status.'" rel="permalink">Click here to Clone</a>';
       $html .= '</div>';
       $html .= '</div>';
       echo $html;
     }
    
    /*Click here to clone Admin Bar*/
    public function dpp_wpp_page_admin_bar_link()
      {
        global $wp_admin_bar;
        global $post;
        $opt = get_option('dpp_wpp_page_options');
        $post_status = !empty($opt['dpp_post_status']) ? $opt['dpp_post_status'] : 'draft';
        $current_object = get_queried_object();
        if ( empty($current_object) )
         return;
         if ( ! empty( $current_object->post_type )	&& ( $post_type_object = get_post_type_object( $current_object->post_type ) )&& ( $post_type_object->show_ui || $current_object->post_type  == 'attachment') )
          {
            $wp_admin_bar->add_menu( array('parent' => 'edit',
            'id' => 'dpp_this',
            'title' => __("dpp this as ".$post_status."", 'dpp_wpp_page'),
            'href' => admin_url().'admin.php?action=dt_dpp_post_as_draft&amp;post=' . $post->ID
          ) );
      }
    }

    /*WP Url Redirect*/	
    static function dp_redirect($url)
    {
     echo '<script>window.location.href="'.$url.'"</script>';
    }
    }
new dpp_wpp_page;
endif;
?>
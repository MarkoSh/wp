<?php
if( ! function_exists( 'hamzahshop_comment_list_template' ) ):
function hamzahshop_comment_list_template($comment, $args, $depth) {
  ?>
     <li <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
     
   		<div id="div-comment-<?php comment_ID() ?>" class="single-reply">
        <?php if ( $args['avatar_size'] != 0 ) echo '<div class="comment-author">'.get_avatar( $comment, 60 ) . '</div>'; ?>
                <div class="comment-info">
                    <div class="comment-author-info">
                       
                         <?php printf( '<cite class="fn">%s</cite> ' , get_comment_author_link() ); ?> 
                       
                         					 <?php comment_reply_link() ?>  <span class="pull-right"> / </span>
                        <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>" class="pull-right">
        <?php
        /* translators: 1: date, 2: time */
        printf( esc_html__('%1$s at %2$s','hamzahshop'), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)','hamzahshop' ), '  ', '' );
        ?>
                       
                    </div>
					<?php if ( $comment->comment_approved == '0' ) : ?>
                    <p><em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.','hamzahshop' ); ?></em></p>
                    <br />
                    <?php endif; ?>
                    <p> <?php comment_text(); ?></p>
                </div>
            </div>
  	 </li>
   
<?php
        }
endif;

if( ! function_exists( 'hamzahshop_comment_form_fields' ) ):
    add_filter( 'comment_form_default_fields', 'hamzahshop_comment_form_fields' );
    function hamzahshop_comment_form_fields( $fields ) {
        $commenter = wp_get_current_commenter();
        
        $req      = get_option( 'require_name_email' );
        $aria_req = ( $req ? " aria-required='true'" : '' );
        $html5    = current_theme_supports( 'html5', 'comment-form' ) ? 1 : 0;
        
        $fields   =  array(
            'author' => '<div class="form-group comment-form-author">' . '<label for="author">' . __( 'Name' , 'hamzahshop' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
                        '<input class="form-control" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></div>',
            'email'  => '<div class="form-group comment-form-email"><label for="email">' . __( 'Email'  , 'hamzahshop' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
                        '<input class="form-control" id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></div>',
            'url'    => '<div class="form-group comment-form-url"><label for="url">' . __( 'Website'  , 'hamzahshop' ) . '</label> ' .
                        '<input class="form-control" id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></div>'        
        );
        
        return $fields;
    }
endif;
if( ! function_exists( 'hamzahshop_comment_form' )):	
	add_filter( 'comment_form_defaults', 'hamzahshop_comment_form' );
    function hamzahshop_comment_form( $args ) {
        $args['comment_field'] = '<div class="form-group comment-form-comment">
                <label for="comment">' . __( 'Comment', 'hamzahshop' ) . '</label> 
                <textarea class="form-control" id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea>
            </div>';
        $args['class_submit'] = 'btn btn-default'; // since WP 4.1
        
        return $args;
    }
endif;
?>
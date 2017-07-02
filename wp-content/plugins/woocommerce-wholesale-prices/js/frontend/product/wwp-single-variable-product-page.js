jQuery( document ).ready( function ( $ ) {

    function update_variation_price_html() {

        var $variations_form  = $( ".variations_form" ),
            variation_id      = $variations_form.find( ".single_variation_wrap .variation_id" ).attr( 'value' ),
            $single_variation = $variations_form.find( ".single_variation" );

        for ( var i = 0 ; i < WWPVariableProductPageVars.variations.length ; i++ ) {

            if ( WWPVariableProductPageVars.variations[ i ][ 'variation_id' ] == variation_id ) {

                // There is this case where if a variable product has variations has the same regular price
                // WooCommerce won't spit out the mark up that shows price for each variation on the front end
                // Which makes sense coz they all have the same price, so they will just refer tot he price printed on the variable level
                // ( Note: I am talking here about single variable product page on the front end )
                // Now the prob with this is, the wholesale price won't be displayed too on the front end, coz we are hooking on the function
                // that displays the price of each variation on the front end but remember that function won't get triggered coz of the
                // condition above right? So we need an alternative way of displaying the wholesale price on the front end then.
                // That's the purpose of the code below. We check if there is no tag inside the .single_variation tag with a class of price
                // This means that no price mark up was printed out
                // If indeed true , we manually output the price html
                // And by price html I mean either the regular price or the regular price crossed out with wholesale price
                // Note, you should prepend, not override the entire html of .single_variation as it may contain other markup

                if ( $single_variation.find( ".price" ).length <= 0 )
                    $single_variation.prepend( WWPVariableProductPageVars.variations[ i ][ 'price_html' ] );

            }

        }

    }
    
    $( "body" ).on( "woocommerce_variation_has_changed" , ".variations_form" , update_variation_price_html );
    $( "body" ).on( "found_variation" , ".variations_form" , update_variation_price_html ); // Only triggered on ajax complete

} );
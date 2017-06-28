( function( api ) {

    // Extends our custom "customizer-info" section.
    api.sectionConstructor['customizer-info'] = api.Section.extend( {

        // No events for this type of section.
        attachEvents: function () {},

        // Always make the section active.
        isContextuallyActive: function () {
            return true;
        }
    } );

    // Extends our custom "hestia_info_jetpack" section.
    api.sectionConstructor.hestia_info_woocommerce = api.Section.extend( {

        // No events for this type of section.
        attachEvents: function () {},

        // Always make the section active.
        isContextuallyActive: function () {
            return true;
        }
    } );

} )( wp.customize );
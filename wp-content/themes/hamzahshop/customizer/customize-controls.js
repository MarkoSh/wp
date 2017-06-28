( function( api ) {

	// Extends our custom "hamzahshop" section.
	api.sectionConstructor['hamzahshop'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );

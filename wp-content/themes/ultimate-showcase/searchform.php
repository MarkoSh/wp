<?php
$search_text = __('Search', 'ultimate-showcase');
$submit_text = __('Submit', 'ultimate-showcase');
?>
<form role="search" method="get" id="searchform" action="<?php echo esc_url( home_url('/') ); ?>">
	<input type="text" id="s" name="s" value="" placeholder="<?php echo esc_attr($search_text); ?>">
	<!-- 
	uncomment this code, including this line, if you'd like to add a button to the header search box
	<div class="clear"></div>
	<input type="submit" id="searchsubmit" class="searchInputSubmit" value="<?php echo esc_attr($submit_text); ?>"> -->
</form>

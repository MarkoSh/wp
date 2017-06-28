<form role='search' method='get' class='search-form' action='<?php echo esc_url(home_url('/')) ;?>' >
    <input type='search' class='search-field' placeholder='<?php echo esc_attr_x("Search... ", "placeholder", "grand-popo") ;?> ' value='<?php echo esc_attr(get_search_query());?>' name='s'> 
    <i class='fa fa-search search-icon'></i>
</form>
<?php
/*
 * this file showing existing meta group
* in admin
*/

global $nmpersonalizedproduct;

$export_url = add_query_arg(array('nm_export' => 'ppom'));
$import_url = add_query_arg(array('nm_import' => 'ppom','page' => 'nm-personalizedproduct'));

echo '<hr/>';
echo '<div class="wrapper">';
echo '<div class="col col-4">';
echo '<h3  style="text-align: center; margin: 5px;">'.__('Export & Import Meta :', 'nm-personalizedproduct').'</h3>';
echo '</div>';
echo '<div class="col col-3">';
echo '<a class="btn btn-primary btn-sm" href="' . $export_url . '">' . __ ( 'Export All Meta', 'nm-personalizedproduct' ) . '</a>';
echo '</div>';
echo '<div class="col col-5">';
echo '<form method="post" action="admin-post.php" enctype="multipart/form-data">';
echo '<input type="hidden" name="action" value="nm_importing_file_ppom" />';
echo '<label for="file-upload" class="btn btn-success btn-sm custom-file-upload" style="margin-right: 5px;">';
echo '<span>Choose a file…</span>';
echo '<input id="file-upload" type="file" name="ppom_csv" style="display: none;">';
echo '</label>';
echo '<input type="submit" class="btn btn-primary btn-sm" value="'.__ ( 'Import Meta', 'nm-personalizedproduct' ).'">';
echo '</form>';
echo '</div>'; //col-5 end
echo '<div class="clear" ></div>';
echo '</div>'; //wrapper end

echo '<hr>';
echo '<div class="wrapper">';
echo '<h2  style="text-align: center;">'.__('Existing Product Meta', 'nm-personalizedproduct').'</h2>';
echo '</div>'; //wrapper end
?>


<table border="0" class="wp-list-table widefat plugins">
	<thead>
		<tr>
			<th style="width: 300px;"><?php _e('Name.', 'nm-personalizedproduct')?></th>
			<th style="width: 500px;"><?php _e('Meta.', 'nm-personalizedproduct')?></th>
			<th style="width: 300px;"><?php _e('How to link?', 'nm-personalizedproduct')?></th>
			<th><?php _e('Delete.', 'nm-personalizedproduct')?></th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th><?php _e('Name.', 'nm-personalizedproduct')?></th>
			<th><?php _e('Meta.', 'nm-personalizedproduct')?></th>
			<th><?php _e('How to link?', 'nm-personalizedproduct')?></th>
			<th><?php _e('Delete.', 'nm-personalizedproduct')?></th>
		</tr>
	</tfoot>
	
	<?php 
	$all_forms = $nmpersonalizedproduct -> get_product_meta_all();
	
	foreach ($all_forms as $productmeta):
	
	$url_edit = add_query_arg(array('productmeta_id'=> $productmeta ->productmeta_id, 'do_meta'=>'edit'));
	$url_clone = add_query_arg(array('productmeta_id'=> $productmeta ->productmeta_id, 'do_meta'=>'clone'));
	$url_products = admin_url( 'edit.php?post_type=product', (is_ssl() ? 'https' : 'http') );
	$product_link = '<a href="'.esc_url($url_products).'">Products</a>';
	?>
	<tr>
		<td><a href="<?php echo $url_edit?>"><?php echo stripcslashes($productmeta -> productmeta_name)?></a><br>
		<a href="<?php echo $url_edit?>"><?php _e('Edit', 'nm-personalizedproduct')?></a> |
		<a href="<?php echo $url_clone?>"><?php _e('Clone', 'nm-personalizedproduct')?></a><br> 
		</td>
		<td><?php echo $nmpersonalizedproduct -> simplify_meta($productmeta -> the_meta)?></td>
		<td><?php printf(__("To link this meta with %s, open any product and you see these meta on right side. Select and Save product", 'nm-personalizedproduct'), $product_link);?></td>
		<td><a href="javascript:are_sure(<?php echo $productmeta -> productmeta_id?>)"><img id="del-file-<?php echo $productmeta -> productmeta_id?>" src="<?php echo $nmpersonalizedproduct -> plugin_meta['url'].'/images/delete_16.png'?>" border="0" /></a></td>
	</tr>
	<?php 
	endforeach;
	?>
</table>

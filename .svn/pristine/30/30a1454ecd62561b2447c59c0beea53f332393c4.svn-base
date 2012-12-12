<p>Product category list</p>

<a href = "<?php echo base_url(); ?>admin/product_category/add_product_category">Add Product</a> 

<table>
<thead>
	<tr>
		<th>Image</th>
		<th>Category Name</th>
		<th>Action</th>
	</tr>
	<?php foreach ($product_category_list as $list):?>
	<tr>
		
		<td><?php echo $list->mboos_product_category_image;?></td>
		<td><?php echo $list->mboos_product_category_name;?></td>
		<td><a href = "<?php echo base_url() . 'admin/product_category/edit_product_category/' . $list->mboos_product_category_id; ?> "> Edit </a><a href = "<?php echo base_url() . 'admin/product_category/delete_product_category_validate/' . $list->mboos_product_category_id; ?> "> Delete </a> </td>
	
	</tr><?php endforeach;?>
</table>
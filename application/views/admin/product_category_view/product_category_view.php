<p>Product category list</p>
<html>
<body>
<a href = "<?php echo base_url(); ?>admin/product_category/add_product_category">Add Product Category</a> 

<table>
<thead>
	<tr>
		<th>Category Name</th>
		<th>Action</th>
	</tr>
	<?php foreach ($product_category_list as $list):?>
	<tr>
		<td><?php echo $list->mboos_product_category_name;?></td>
		<td><a href = "<?php echo base_url() . 'admin/product_category/edit_product_category/' . $list->mboos_product_category_id; ?> "> Edit </a><a href = "<?php echo base_url() . 'admin/product_category/delete_product_category_validate/' . $list->mboos_product_category_id; ?> "> Delete </a> </td>
	
	</tr><?php endforeach;?>
</table>
<a href = "<?php echo base_url(); ?>admin/product_category/print_preview">Print Preview</a> 
</body>
<div name="button_back">
<form action="<?php echo base_url();?>admin/dashboard" method="POST">
<input name="add_category_back" type="submit" value="Back" />
</form>
</div>
</html>
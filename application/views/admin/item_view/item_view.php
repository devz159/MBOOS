<p>Item list</p>

<a href = "<?php echo base_url(); ?>admin/item/add_item">Add Item</a> 

<table>
<thead>
	<tr>
    	<th>Item ID</th>
		<th>Image</th>
		<th>Item Name</th>
		<th>Item Description</th>
		<th>Item Supplier</th>		
		<th>Item Category</th>
		<th>Action</th>
	</tr>
	<?php foreach ($products as $list):?>
	<tr>
		<td><?php echo $list->mboos_product_id;?></td>
		<td><img src="<?php echo site_url() . 'uploads/item_images/' . $list->mboos_product_image; ?>" width="50" height="50" /></td>
		<td><?php echo $list->mboos_product_name;?></td>
		<td><?php echo $list->mboos_product_desc;?></td>
		<td><?php echo $list->mboos_product_supplier;?></td>
		<td><?php echo $list->mboos_product_category_name;?></td>
		<td><a href = "<?php echo base_url() . 'admin/item/edit_item/' . $list->mboos_product_id; ?> "> Edit </a><a href = "<?php echo base_url() . 'admin/item/delete_item/' . $list->mboos_product_id; ?> "> Delete </a> </td>
	
	</tr><?php endforeach;?>
</table>

<div name="button_back">
<form action="<?php echo base_url();?>admin/dashboard" method="POST">
<input name="add_category_back" type="submit" value="Back" />
</form>
</div>
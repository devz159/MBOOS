<div name="add_category">
<form action="<?php echo base_url();?>item/item/add_item" method="POST">
<input name='add_item' type="submit" value="Add Item" />
</form>
</div>

<div name="add_category_back">
<form action="<?php echo base_url();?>admin/dashboard" method="POST">
<input name="add_category_back" type="submit" value="Back" />
</form>
</div>

<table>
<td><?php
						
		 
		
		 foreach ($records as $rec) {	
		 	echo '<tr><td><br />Product Name:'. $rec->mboos_product_name . '</td>'; 
			echo '<td><a href="'. base_url() .'item/item/edit_item/'. $rec->mboos_product_id .'">Edit</a></td>';
			echo '<td><a href="'. base_url() .'item/item/delete_item/'. $rec->mboos_product_id .'">Delete</a></td>'; } 
	?>
</td>
</table>
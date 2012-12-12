<div name="edit_item">

	<h3>Edit Item</h3>
    
    <?php
		foreach ($user_info as $rec) {
			$iname = $rec->mboos_product_name;
			$isupplier = $rec->mboos_product_supplier;
			$iid = $rec->mboos_product_id;
			} 
	?>
    
	<form action="<?php echo base_url(); ?>item/item/edit_item_validate" method="POST">
		<p><label>Product Name:</label><input name="product_name" type="text" value="<?php echo $iname ?>" /></p>
		<p><label>Product Supplier:</label><input name="supplier_name" type="type" value="<?php echo $isupplier ?>"/></p>
        <p><input name="product_id" type="hidden" value="<?php echo $iid ?>" /></p>
		<p><input name="submit" type="submit" value="Save Changes" /></p>    
	</form>
    
</div>

<div name="back_to_item_view">
	<form action="<?php echo base_url(); ?>item/item/back_item" method="POST">
    	<p><input name="submit" type="submit" value="Back" /></p>
	</form>
</div>
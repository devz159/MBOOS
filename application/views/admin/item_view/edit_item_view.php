<p>Edit Items</p>

<?php echo form_open_multipart('admin/item/edit_item_validate');?>
<?php foreach ($edit_items as $rec):?>

<input type="hidden" name="item_id" value="<?php echo $rec->mboos_product_id;?>"/>
<input type="hidden" name="item_image" value="<?php echo $rec->mboos_product_image;?>"/>

<p><label>Item name: <input type="text" name="item_name" value="<?php echo $rec->mboos_product_name;?>" /></label></p>
<p><label>Item Description</label><textarea name="item_desc" ><?php echo $rec->mboos_product_desc;?></textarea></p>
<p><label>Item supplier: <input type="text" name="item_supplier" value="<?php echo $rec->mboos_product_supplier;?>" /></label></p>
<p><label>Item availability: <input type="text" name="item_availability" value="<?php echo $rec->mboos_product_availability;?>" /></label></p>
<p><label>Item Category</label><select name='product_category'>    
									<?php foreach ($edit_items as $row):?>
									<option value="<?php echo $row->mboos_product_category_id;?>"><?php echo $row->mboos_product_category_name;?></option>
									
									<?php endforeach;?>
								</select>
<p><label>Item Image:</p>
<p><img src="<?php echo site_url() . 'uploads/item_images/' . $rec->mboos_product_image; ?>" width="50" height="50" /></p>
<p><input type="file" name="item_image" value="<?php echo $rec->mboos_product_image;?>" size="12" /> </label></p>
<p><input type="submit" value="submit"></p>
<?php endforeach;?>
</form>

<div name="button_back">
<form action="<?php echo base_url();?>admin/item" method="POST">
<input name="button_back" type="submit" value="Back" />
</form>
</div>
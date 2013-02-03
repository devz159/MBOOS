<p>Edit Items</p>
<?php  echo validation_errors();  ?>
<?php echo form_open_multipart('admin/item/edit_item_validate');?>
<?php foreach ($edit_items as $rec):?>

<?php $edit_item_id = $this->uri->segment(4); ?>
<input type="hidden" name="item_id" value="<?php echo $edit_item_id;?>"/>

<p><label>Item name: <input type="text" name="item_name" value="<?php echo $rec->mboos_product_name;?>" /></label></p>
<p><label>Item Description</label><textarea name="item_desc" ><?php echo $rec->mboos_product_desc;?></textarea></p>
<p><label>Item supplier: <input type="text" name="item_supplier" value="<?php echo $rec->mboos_product_supplier;?>" /></label></p>
<p><label>Item Category</label><select name='product_category'> 
   
									<?php foreach ($edit_items as $row):?>
										<option selected="selected" value="<?php echo $row->mboos_product_category_id;?>">--<?php echo $row->mboos_product_category_name;?>--</option>
									<?php endforeach;?>
									
                                    <?php foreach ($all_category as $cat):?>
										<option value="<?php echo $cat->mboos_product_category_id;?>"><?php echo $cat->mboos_product_category_name;?></option>							
									<?php endforeach;?>
                                    
								</select>
<?php foreach ($item_price as $price):?>
<p><label>Item Price: <input type="text" name="item_price" value="<?php echo $price->mboos_product_price;?>" /></label></p>
<?php endforeach;?>
<p><label>Item Image:</p>
<p><img src="<?php echo site_url() . 'uploads/item_images/' . $rec->mboos_product_image; ?>" width="50" height="50" /></p>
<p><input type="file" name="item_image" value="<?php echo $rec->mboos_product_image;?>" size="12" /> </label></p>
<p><input type="submit" value="submit"></p>

<table>
	<tr>
    	<th>Item Price</th>
        <th>Price Date</th>
        <th>Set Price</th>
    </tr><?php foreach ($item_price as $price):?>
    <tr>
    	<td><?php echo $price->mboos_product_price;?></td>
        <td><?php echo $price->mboos_product_price_date;?></td>
        <td><?php if($price->mboos_product_price_status == "1"){
						print '<input type="radio" name="price_status" value="Active" checked="checked">';
						
                        }else{
							print '<input type="radio" name="price_status" value="Active">';
						 } ?>
		
			
        </td>
    </tr><?php endforeach;?>
</table>

<?php endforeach;?>
</form>

<div name="button_back">
<form action="<?php echo base_url();?>admin/item" method="POST">
<input name="button_back" type="submit" value="Back" />
</form>
</div>
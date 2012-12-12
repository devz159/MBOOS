<p>Edit</p>
<?php  echo validation_errors();  ?>
<form method="POST"  action="<?php echo base_url(); ?>admin/product_category/edit_product_category_validate">
<?php foreach ($edit_category as $rec):?>
<input type="hidden" name="product_category_id" value="<?php echo $rec->mboos_product_category_id;?>"/>
<input type="hidden" name="product_category_image" value="<?php echo $rec->mboos_product_category_image;?>"/>
<p><label>Item category name: <input type="text" name="product_category_name" value="<?php echo $rec->mboos_product_category_name;?>" /></label></p>
<p><label>Product Image: <input type="file" name="product_category_image" value="<?php echo $rec->mboos_product_category_image;?>" size="12" /> </label></p>
<p><input type="submit" value="submit"></p>
<?php endforeach;?>
</form>
<p>Edit</p>
<?php  echo validation_errors();  ?>
<?php echo form_open_multipart('admin/product_category/edit_product_category_validate');?>
<?php foreach ($edit_category as $rec):?>

<p><label>Item category name: <input type="text" name="product_category_name" value="<?php echo $rec->mboos_product_category_name;?>" /></label></p>

<p><input type="submit" value="submit"></p>
<?php endforeach;?>
</form>
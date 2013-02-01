<p>Add</p>

<?php echo form_open_multipart('admin/product_category/add_product_category_validate');?>
<p><label>Item category name: <input type="text" name="product_category_name" value="" /></label></p>
<p><label>Category Image: <input type="file" name="product_category_image" size="12" /> </label></p>
<p><input type="submit" value="submit"></p>
</form>
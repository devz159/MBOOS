
<?php echo form_open_multipart('admin/item/upload_image_validate');?>
<?php $image_name = $this->uri->segment(4); ?>
<input type="hidden" name="item_name" value="<?php echo $image_name; ?>"/>
<p><input type="file" name="userfile" value="" size="12" /></p>

<input type="submit" name="value"/>
</form>
<p>Edit Stocks</p>
<?php  echo validation_errors();  ?>
<form action="<?php echo base_url(); ?>admin/stocks/add_stock_validate" method="POST">

	<?php $product_id = $this->uri->segment(4); ?>
	<input type="hidden" name="item_id" value="<?php echo $product_id; ?>" />
	<input name="stock_date" type="hidden" value="<?php echo date("Y-m-d"); ?>" /></p>
	
	<?php foreach ($stock_number as $rec):?>
	<p><label>Quantity: <input type="text" name="quantity_number" value="<?php echo $rec->mboos_inStocks_quantity;?>" size="5" /></label></p>
	<?php endforeach; ?>
	
	<input type="submit" value="submit" />
	
</form>
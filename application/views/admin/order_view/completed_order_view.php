<h3>Completed Orders</h3>

<table>
	<tr>
    	<th>Order ID</th>
		<th>Order date</th>
		<th>Pick-up sched</th>
		<th>Price</th>
		<th>Customer ID</th>		
		<th>Order Status</th>
	</tr>
	<?php foreach ($completed as $list):?>
	<tr>
		<td><?php echo $list->mboos_order_id;?></td>
		<td><?php echo $list->mboos_order_date;?></td>
		<td><?php echo $list->mboos_order_pick_schedule;?></td>
		<td><?php echo $list->mboos_orders_total_price;?></td>
		<td><?php echo $list->mboos_customer_id;?></td>
		<td>Completed</td>
	</tr><?php endforeach;?>
</table>

<div name="button_back">
<form action="<?php echo base_url();?>admin/orders" method="POST">
<input name="order_back" type="submit" value="Back" />
</form>
</div>

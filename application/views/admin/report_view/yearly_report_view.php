<h3>Yearly Report</h3>

<table>
	<tr>
		<th>Order ID</th>
		<th>Order date and time</th>
		<th>Order date pick-up schedule</th>
		<th>Order total price</th>
		<th>Customer ID</th>
	</tr>
	<?php foreach ($yearly_order_list as $list):?>
	<tr>
		<td><?php echo $list->mboos_order_id;?></td>
		<td><?php echo $list->mboos_order_date;?></td>
		<td><?php echo $list->mboos_order_pick_schedule;?></td>
		<td><?php echo $list->mboos_orders_total_price;?></td>
		<td><?php echo $list->mboos_customer_id;?></td>
	</tr>
	<?php endforeach;?>
</table>
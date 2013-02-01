<h3>Daily Report</h3>

<table>
	<tr>
		<th>Order ID</th>
		<th>Order Date</th>
		<th>Order Pick Schedule</th>
		<th>Order Status</th>
		<th>Customer ID</th>
	</tr>
	<?php foreach ($daily_order_list as $list):?>
	<tr>
		<td><?php echo $list->mboos_order_id;?></td>
		<td><?php echo $list->mboos_order_date;?></td>
		<td><?php echo $list->mboos_order_pick_schedule;?></td>
		<td><?php echo $list->mboos_order_status;?></td>
		<td><?php echo $list->mboos_customer_id;?></td>
	</tr>
	<?php endforeach;?>
</table>
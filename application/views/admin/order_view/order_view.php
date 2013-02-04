<h3>Orders</h3>

<a href="<?php echo base_url();?>admin/orders/manage_order"><br />Manage orders</a>
<a href="<?php echo base_url();?>admin/orders/completed_order"><br />View completed orders</a>

<form action="<?php echo base_url();?>admin/dashboard" method="POST">
<p><input name="order_view_back" type="submit" value="Back" /></p>
</form>
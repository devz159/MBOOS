<h3>Yearly report</h3>

<form action="<?php echo base_url();?>admin/reports/yearly_report_query" method="POST">

<label>From: </label>
<select name="year_ordered_start">
	<option value="2010">2010</option>
	<option value="2011">2011</option>
	<option value="2012">2012</option>
	<option value="2013">2013</option>
</select>

<label>To: </label>
<select name="year_ordered_end">
	<option value="0000">N/A</option>
	<option value="2010">2010</option>
	<option value="2011">2011</option>
	<option value="2012">2012</option>
	<option value="2013">2013</option>
</select>

<input type="submit" value="Search" name="yearly_report_submit"/>
</form>
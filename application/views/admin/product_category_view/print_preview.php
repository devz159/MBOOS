<p>Product category list</p>
<html>
<head>
<script>

   function printTable(){
    var head = "about:<html><head></head><body onLoad='this.print()'>";
    var body = document.getElementById('printTable').innerHTML;
    var foot = "</body></html>";

    window.open(head + body + foot,'','');}
  </script>
  
</head>
<body>
<table>
	<tr>
		<th>Category Name</th>
	</tr>
	<?php foreach ($product_category_list as $list):?>
	<tr>

		<td><?php echo $list->mboos_product_category_name;?></td>
	
	</tr><?php endforeach;?>
</table>

<a href=# onClick="printTable();">Print Table</a>
</body >
</html>
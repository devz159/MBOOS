<div id="homePage" data-role="page">

<div data-role="header" data-position="fixed" data-theme="b">
		<p>Place Order to PayPal</p>
</div><!-- /header -->

<div data-role="content">	
  
  <?php echo form_open(/*'https://www.sandbox.paypal.com/cgi-bin/webscr'*/ paypalsettings::env(), array('method' => 'post', 'class' => 'newpaypal')); ?>
 		
        
        <input type="hidden" name="cmd" value="_cart">
        <input type="hidden" name="upload" value="1">
        <input type="hidden" name="business" value="seller_1359486610_biz@gmail.com">
      	<input type="hidden" name="email" value="<?php echo $paypal_email; ?>" />
      
<?php foreach ($order as $key => $val) :?>
        <?php $key++; ?>
 		<input type="hidden" name="item_name_<?php echo $key?>" value="<?php echo $val['name']; ?>">
 		<input type="hidden" name="item_number_<?php echo $key?>" value="<?php echo $val['item_id']?>">
 		<input type="hidden" name="amount_<?php echo $key?>" value="<?php echo $val['price']?>">
 		<input type="hidden" name="quantity_<?php echo $key?>" value="<?php echo $val['qty']?>"> 
<?php endforeach; ?>
        
            
        <input type="hidden" name="currency_code" value="PHP">
        <input type="hidden" name="lc" value="US">
        <input type="hidden" name="rm" value="2">
        <input type="hidden" name="shipping_1" value="0.00">
        <input type="hidden" name="return" value="<?php echo base_url(); ?>paypal/paypal/thankyou">
        <input type="hidden" name="cancel_return" value="">
        <input type="hidden" name="notify_url" value="">
        <input type="submit" name="pay_now" value="Place Order Through PayPal" />
        
    </form>
    
	</div>
	
	<div data-role="footer" data-id="foo1" data-position="fixed" data-theme="b">

	</div><!-- /footer -->	
</div><!-- /page -->
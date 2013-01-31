<form class="paypal" method="GET" action="<?php echo base_url(); ?>paypalx/paypal_success_view" id="paypal_form">    
	<input type="hidden" name="cmd" value="_xclick" /> 
    <input type="hidden" name="no_note" value="1" />
    <input type="hidden" name="lc" value="UK" />
    <input type="hidden" name="currency_code" value="GBP" />
    <input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest" />
    <input type="hidden" name="first_name" value="paul"  />
    <input type="hidden" name="last_name" value="janubas"  />
	
	<label>Email: </label>
    <input type="text" name="login_email" value=""  />
    <p><input type="hidden" name="item_number" value="654321" / ></p>
    <input type="submit"  value="Submit Payment"/>
</form>
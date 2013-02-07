$(document).ready(function(){

	var l = window.location;
	var base_url = l.protocol + "//" + l.host + "/" + l.pathname.split('/')[1] + "/";
	
	$('#reg_back_btn').click(function(){
		
		history.back(-1);
		
	});
	
	$('#addNewPrice_btn').click(function() {
		
				//alert("wroking");
				var item_id = $('#item_id').val();
				var price = $('#item_price_new').val();
				
				//alert(price);
				var request = $.ajax({
					error		: function (req, status, error) {
								if(status == "timeout")
		
										alert("error");
								},
				
					url			: base_url + "admin/item/add_price_validate/",
					type		: "POST",
					data		: { item_id: item_id, item_price_new : price },
					dataType	: "html",
					success		: 	function(data) {
												
									$('.modal').empty();
									location.reload();
										
									}
						
			});
			
			request.done(function(msg) {
				
				$('.modal').hide();
					
			});
				
			request.fail(function(jqXHR, textStatus) {
				
				alert("fail");
					
			});
	
	});
	
	//    $("input[name=radio-choice-1]:checked").val(); 
	$('input#price_radio_btn').click(function() {
		

		$(this).each(function(){
			$(this).removeAttr("checked");
		});
		
		$(this).attr("checked", true);
		
		
	});

});
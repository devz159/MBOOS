/* Script for Registration Page*/
$('#domainPage').live("pageshow", function(event){
	
	$('.saveDomainBtn').click(function() {
		
		setTimeout(function (){
			
			
			if($('.dName').val().length == 0) {

					$('.dName').addClass("error").focus();
		
			} else {
	        	
				var domain_name = $('.dName').val();
				
				$("#savingDomainMsg").popup('open');
				window.setTimeout(function() {$("#savingDomainMsg").popup('close')}, 1000);
				
				
				window.localStorage.setItem("domain_name", domain_name);
				window.localStorage.setItem("domain_setup", "1");
				window.location.href = 'login.html';
	        	
	        }
	    }, 3000)
	});
	
});

/* Script for login Page*/
$('#loginPage').live("pageshow", function(event){
	
	var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
	var domainName = window.localStorage.getItem("domain_name");
	var serviceURL = "http://"+ domainName +"/MBOOS/mobile_ajax/login/";
	
	$('.email').change(function() {
		
		$(this).removeClass("error");
		
	});
	
	$('.password').change(function() {
		
		$(this).removeClass("error");
		
	});
	
	
	$('.loginBtn').click(function() {
		
		if($('.email').val().length == 0 ) {
			
			$('.email').addClass("error");
			
			$("#requiredEmail").popup('open');
			window.setTimeout(function() {$("#requiredEmail").popup('close')}, 3000);
			
			
		} else if(!$('.email').val().match(emailExp)) {
			
			$('.email').addClass("error");
			$("#invalidEmail").popup('open');
			window.setTimeout(function() {$("#invalidEmail").popup('close')}, 3000);
			
		} else if ($('.password').val().length == 0) {
			
			$('.password').addClass("error");
			$("#requiredPassword").popup('open');
			window.setTimeout(function() {$("#requiredPassword").popup('close')}, 3000);
			
		} else {
			
			$('.email').removeClass("error");
			$('.password').removeClass("error");
			
			$.ajax({
				url			:	serviceURL,	
				type		: 	"post",
				data		:	{email: $('.email').val(), pword: $('.password').val() },
				success		: 	function(data) {
					
									//alert(data);
									if(data == "1") {
										
					        			
										$.mobile.changePage( "index.html", { transition: "slideup"} );
										$("#loginInfoMsg").popup('open');
										
										window.localStorage.setItem("is_logged_in", "1");
										window.localStorage.setItem("user_email", $('.email').val());
										
					        			window.setTimeout(function() {$("#loginErrorMsg").popup('close')}, 1000);
										
										
									} else {
										
										$("#loginErrorMsg").popup('open');
					        			window.setTimeout(function() {$("#loginErrorMsg").popup('close')}, 3000);
										
									}
									

									
								}
			});
			
		}
		
		
	});
	
});

/* Script for Home Page Page*/
$('#homePage').live("pageshow", function(event){
	
	var is_logged_id = window.localStorage.getItem("is_logged_in");

	if(is_logged_id == 1) {
		
		categoryPage();
		searchPage();
	
	} else {
		
		$.mobile.changePage( "login.html", { transition: "slideup"} );
		
		}
	
	$('.signoutBtn').click(function() {
		
		
		window.localStorage.removeItem("is_logged_in");
		$.mobile.changePage( "login.html", { transition: "slideup"} );
		
	});
	
});

$(document).live("pageinit", function(event){
	
	setTimeout(function (){
		
		var domainChecker = window.localStorage.getItem("domain_setup");
		
		if(domainChecker == 1) {
			
			categoryPage();
			searchPage();
			
		} else {
        	
        	$.mobile.changePage( "domain.html", { transition: "slideup"} );
        	
        }
    }, 3000)


});


$('#detailsPage').live("pageshow", function(event){

	get_info();
	
    /*Add to Cart Script*/
	
    $('.addCartBtn').click(function() {
    		
    		var item_availability = parseInt(localStorage.getItem("item_availability"));
    		var qtyVal = parseInt($('input.qtyForm').val());
    		
    		var regInt =  /^([\d]+[\d]+\b|[\d]+\b)$/;
    		
    		if($('input.qtyForm').val().match(regInt)) {
    			
    			if(qtyVal <= item_availability) {
    				
        		//'id'=>'1','name'=>'ian','item_id'=>'0001','qty'=>'5','price'=>'100.00' ||'id'=>'2','name'=>'paul','item_id'=>'0002','qty'=>'3','price'=>'10.00'
    				
            	var item = [$('input.item_id').val() + ","+ $('input.item_name_val').val() + ","+ $('input.item_price_val').val() + ","+ $('input.qtyForm').val() + ""];
            	
            	var strItem = item.toString();
            	var items = strItem.split(",");
            	
            	setupDB();
            	addItem(items[0], items[1], items[2], items[3]);
            	
            	$("#popupDialog").popup('open');
            	
    			} else {
            		
        			$("#aCheckMsg").popup('open');
        			window.setTimeout(function() {$("#aCheckMsg").popup('close')}, 3000);	
        			return false;
        			
            	}
            	
    		} else {
    			
    			$("#intChecker").popup('open');
    			window.setTimeout(function() {$("#intChecker").popup('close')}, 3000);	
    			return false;
    			
    		}

    		
	
    });
   
	
});

/* Script for Registration Page*/
$('#regPage').live("pageshow", function(event){
	
	//var domainName = window.localStorage.getItem("domain_name");
	var domainName = "192.168.1.103";
	
	var serviceURL = "http://"+ domainName +"/MBOOS/mobile_ajax/register/";
	
	var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;

	$('.regBtn').click(function() {
		
		
		
		if($('.fname').val().length == 0) {
			
			$('.fname').addClass("error").focus();
			
		} else if($('.email').val().length == 0 ) {
			
			$('.fname').removeClass("error");
			$('.email').addClass("error").focus();
			
			$("#emailRequired").popup('open');
			window.setTimeout(function() {$("#emailRequired").popup('close')}, 3000);
			
		} else if(!$('.email').val().match(emailExp)) {
			
			$('.fname').removeClass("error");
			$('.email').addClass("error").focus();
			
			$("#emailExistMsg").popup('open');
			window.setTimeout(function() {$("#emailExistMsg").popup('close')}, 3000);
			
		} else if($('.password').val().length == 0) {
			
			$('.email').removeClass("error");
			$('.password').addClass("error").focus();
			
		} else if($('.address').val().length == 0) {
			
			$('.password').removeClass("error");
			$('.address').addClass("error").focus();
			
		} else if($('.cNumber').val().length == 0) {
			
			$('.address').removeClass("error");
			$('.cNumber').addClass("error").focus();
			
		} else {
		
			$("#savingInfoMsg").popup('open');
			window.setTimeout(function() {$("#savingInfoMsg").popup('close')}, 3000);
		
			var name = $('.fname').val();
			var addr = $('.address').val();
			var email = $('.email').val();
			var number = $('.cNumber').val();
			var password = $('.password').val();
			
			
			
					
			
			var request = $.ajax({
				
					url: serviceURL,
					type: "POST",
					data: { cname: name, address: addr, email: email, cpnumber: number, pword: password },
					dataType: "html"
						
			});
			
			request.done(function(msg) {
					
					window.location.href = 'login.html';
					
			});
				
			request.fail(function(jqXHR, textStatus) {
				
					alert( "Request failed: " + textStatus );
					
			});
			
			

			
		}
	});
	
});

/* Script for Category Item Page*/
$('#categoryPage').live("pageshow", function(event){

	get_cat_info();
	
});

/* function for Category Page */
function get_cat_info() {
	
	var domainName = window.localStorage.getItem("domain_name");
	
	var serviceURL = "http://"+ domainName +"/MBOOS/mobile_ajax/mobile/";
	
	var id;
	
	id = getUrlVars()["id"];
		
	
	$.getJSON(serviceURL + 'getByCategory?id='+id, function(data) {
	$('#category_data li').remove();
	cat_item = data.cat_item_list;
	
		$.each(cat_item, function(index, info) {
			$('#category_data').append('<li><a class="id_item" href="buy_item.html?id=' + info.mboos_product_id + '">' +
					'<h4>' + info.mboos_product_name +'</h4>' + '<p>' + info.mboos_product_price + '</p>' +
					"</a><a class='id_link' href='buy_item.html?id=" + info.mboos_product_id + "'  data-transition='slideup'>Add to Cart</a></li>");
					    			
		});
		
		$('#category_data').listview('refresh');
	});
	
} 

/* Script for Category Item Page*/
$('#categoriesPage').live("pageshow", function(event){

	categoryPage();
	
});

/* Get the ID from URL */
function getUrlVars() {
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    
		for(var i = 0; i < hashes.length; i++) {
		    hash = hashes[i].split('=');
		        vars.push(hash[0]);
		        vars[hash[0]] = hash[1];
		    }
		    return vars;
		   
		}  

/* Get Item Info from Search List*/
function get_info() {
	
	var domainName = window.localStorage.getItem("domain_name");
	
	var serviceURL = "http://"+ domainName +"/MBOOS/mobile_ajax/mobile/";
	
	var id = getUrlVars()["id"];
	
	$.getJSON(serviceURL + 'get_info?id='+id, function(data) {
		
	item_info = data.item_info;
	
		$.each(item_info, function(index, info) {
			
			$('label.item_name').append(info.mboos_product_name);
			$('label.item_price').append("PHP"+info.mboos_product_price);
			$('p.item_image').append('<img src="http://'+ domainName +'/MBOOS/images/item_images/' + info.mboos_product_image + '" height="100" width="100">');
			$('li.item_availability').append(info.mboos_product_availability);
			$('p.item_desc').append(info.mboos_product_desc);
			$('input.item_id').val(info.mboos_product_id);
			$('input.item_name_val').val(info.mboos_product_name);
			$('input.item_price_val').val(info.mboos_product_price);
				
			localStorage.setItem('item_availability', info.mboos_product_availability );	
			});
		
	
	});
	
}    

function categoryPage() {
	
	var domainName = window.localStorage.getItem("domain_name");
	
	var serviceURL = "http://"+ domainName +"/MBOOS/mobile_ajax/mobile/";
	
	$.getJSON(serviceURL + 'get_categories', function(data) {
		
	$('#categoryList li').remove();
	categories = data.categories;
	
		$.each(categories, function(index, category) {
			$('#categoryList').append('<li><a class="id_item" href="category_item.html?id=' + category.mboos_product_category_id + '">' +
					'<h4>' + category.mboos_product_category_name +'</h4>' +
					'</a></li>');
		});
	
	$('#categoryList').listview('refresh');

	});
}

function searchPage() {
	
	var domainName = window.localStorage.getItem("domain_name");
	
	var serviceURL = "http://"+ domainName +"/MBOOS/mobile_ajax/mobile/";
	
	$.getJSON(serviceURL + 'search', function(data) {
	$('#search_data li').remove();
	products = data.products;
	
		$.each(products, function(index, product) {
			$('#search_data').append('<li><a class="id_item" href="buy_item.html?id=' + product.mboos_product_id + '">' +
					'<h4>' + product.mboos_product_name +'</h4>' +
					"</a><a class='id_link' href='buy_item.html?id=" + product.mboos_product_id + "'  data-transition='slideup'>Add to Cart</a></li>");
					    			
		});
		
	$('#search_data').listview('refresh');
});

	
}


$(".sRefreshBtn").live( "click", function(event, ui) {
	
	$("#sRefreshMsg").popup('open');
	window.setTimeout(function() {$("#sRefreshMsg").popup('close')}, 1000);
	searchPage();
	
	});

$(".cRefreshBtn").live( "click", function(event, ui) {
	
	$("#cRefreshMsg").popup('open');
	window.setTimeout(function() {$("#cRefreshMsg").popup('close')}, 1000);
	categoryPage();
	
	});

$('#cartPage').live("pageshow", function(event){

	setupDB();
	
	$('.cartRefreshBtn').click(function() {
		
		setupDB();
		
		$("#refreshingMsg").popup('open');
		window.setTimeout(function() {$("#refreshingMsg").popup('close')}, 1000);
		
	});
	
	$('.checkoutBtn').click(function() {
		
		var cart_items = localStorage.getItem("cart_items")
		
		if(cart_items == 0) {
			
			$("#cartCheckerMsg").popup('open');
			window.setTimeout(function() {$("#cartCheckerMsg").popup('close')}, 2000);
			return false;	
			
		} else {
			
			return true;
			
		}		
	});
	
});



$('#checkoutPage').live("pageshow", function(event) {
	
	var cart_items = localStorage.getItem("cart_items")
	
	if(cart_items == 0) {
		
		$.mobile.changePage( "index.html", { transition: "slideup"} );
		
	} else {
		
		
		$('.paypalBtn').click(function() {
			
			var username = $('#username').val();
			var pword = $('#password').val();
			var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
			if(username == "") { 
				
				$("#uValidationMsg").popup('open');
				window.setTimeout(function() {$("#uValidationMsg").popup('close')}, 3000);
				return false;
				
			} else if(!username.match(emailExp)) {
				
				$("#eValidationMsg").popup('open');
				window.setTimeout(function() {$("#eValidationMsg").popup('close')}, 3000);
				return false;
				
				
			} else {
				
				return true;
				
			}
			
		});
		query_cart();
		
		
	}

	
	
});

$('#profilePage').live("pageshow", function(event) {
	
	var currUser = window.localStorage.getItem("user_email");
	var getCurrDomain = window.localStorage.getItem("domain_name");
	$('#dName').val(getCurrDomain);
	
	
	
	var serviceURL = "http://"+ getCurrDomain +"/MBOOS/mobile_ajax/customer/";
	
	$.getJSON(serviceURL + 'customer_info?email='+currUser, function(data) {
	
		cust_info = data.customer_info;
	
		$.each(cust_info, function(index, info) {
			
			
			$('#cName').val(info.mboos_customer_complete_name);
			$('#address').val(info.mboos_customer_addr);
			$('#email').val(info.mboos_customer_email);
			$('#cNumber').val(info.mboos_customer_phone);
			$('.cust_id').val(info.mboos_customer_id);
			
		});

	});

	
	$('.profileSaveBtn').click(function() {
		
		var customer_id = $('.cust_id').val();
		var cname = $('#cName').val();
		var addr = $('#address').val();
		var email = $('#email').val();
		var cnumber = $('#cNumber').val();
		
		
		var request = $.ajax({
			
				url: serviceURL + "customer_edit",
				type: "POST",
				data: {cust_id : customer_id, name : cname, address : addr, email : email, number : cnumber },
				dataType: "html"
				
			});
		
			request.done(function(msg) {
				
				$("#popupInfo").popup('open');
				window.setTimeout(function() {$("#popupInfo").popup('close')}, 3000);
			
			});
			
			request.fail(function(jqXHR, textStatus) {
				
				$("#enableToUpdateMsg").popup('open');
				window.setTimeout(function() {$("#enableToUpdateMsg").popup('close')}, 3000);
				
				
			});
		

		
	});
	
	$('.updatingDomainBtn').click(function() { 
		
		var getCurrDomain = window.localStorage.getItem("domain_name");
		
		var domain_name = $('#dName').val();
		
		window.localStorage.setItem("domain_name", domain_name);
		
		$("#updatingDomainMsg").popup('open');
		window.setTimeout(function() {$("#updatingDomainMsg").popup('close')}, 2000);
	});
});

$('#confirmationPage').live("pageshow", function(event) {
	
	emptyDB();
	var datas = localStorage.getItem("all_items");
	var subtotal = window.localStorage.getItem("subtotal");
	
	window.plugins.childBrowser.showWebPage('http://192.168.1.103/MBOOS/paypal/paypal?stringOrder='+ datas +'', { showLocationBar: true });	
		
});

function query_cart() {
	
	var db = window.openDatabase("Database", "1.0", "PhoneGap Demo", 200000);
	db.transaction(function(tx) {
	
		tx.executeSql('SELECT * FROM CART', [], cart_serps, errorCB);
	
	}, dbErrorHandler);
}

function cart_serps(tx, results) {
	
var len = results.rows.length;
var item_lists = [];

	for (var i=0; i<len; i++){
		
		order = ["||'item_id' => '" + results.rows.item(i).item_id + "'", "'name' => '"+ results.rows.item(i).item_name  +"'", "'price' => '"+ results.rows.item(i).item_price +"'", "'qty' => '" + results.rows.item(i).item_qty + "'"]
		
		item_lists.push(order);			
	
	    }
	
	var strItem_list = item_lists.toString();
	localStorage.setItem('all_items', strItem_list);
	
	
}


function emptyDB() {
	
	var db = window.openDatabase("Database", "1.0", "PhoneGap Demo", 200000);
	db.transaction(function(tx) {
	
		tx.executeSql('DROP TABLE CART');
	
	}, dbErrorHandler);
}

	    
function populateDB(tx) {
		
        tx.executeSql('CREATE TABLE IF NOT EXISTS CART (id INTEGER PRIMARY KEY, item_id, item_name, item_price DOUBLE(3,2), item_qty, price_total DOUBLE(16,2))');


}

// Query the database

function queryDB(tx) {
	
    tx.executeSql('SELECT * FROM CART', [], querySuccess, errorCB);
    tx.executeSql('SELECT SUM(price_total) AS itemSubtotal FROM CART', [], querySubTotalSuccess, errorCB);
    
}

// Query the success callback
function querySuccess(tx, results) {

	var len = results.rows.length;
	
	// var for checking the Cart
	localStorage.setItem('cart_items', len);
	
	$("#numItems").empty().append(len);
	$('#cart_data').empty();
	
	for (var i=0; i<len; i++){
		
			$('#cart_data').append('<li><a class="cart_edit_item" href="cart_edit_item.html?id=' + results.rows.item(i).id + '&item_id='+ results.rows.item(i).item_id  +'">' +
							'<h4>' + results.rows.item(i).item_name  +'</h4>' + 
							'<p>PHP ' + results.rows.item(i).item_price + '</p>' +
							'<a class="deleteBtn" href="item_delete.html?id=' + results.rows.item(i).id + '" data-role="button" data-icon="delete" data-iconpos="notext">Delete</a> ' +
							'</a><span class="ui-li-count">'+ results.rows.item(i).item_qty +'</span></li>'); 
			
			$("#cart_data").listview("refresh");
			
	    }

    
}

function querySubTotalSuccess(tx, results) {
	
	if(results.rows.item(0).itemSubtotal == null) {
		
		$('#subtotalVal').empty().append("PHP 0.00");
		
	} else {
		
		var num = results.rows.item(0).itemSubtotal;
		var result = Math.round(num*100)/100;
		
		// saving the subtotal
		localStorage.setItem('subtotal', result);
		
		$('#subtotalVal').empty().append("PHP " + result + "");
	}
	
	

}

// Transaction error callback

function errorCB(err) {
	
    console.log("Error processing SQL: "+err.code);
    
}

// Transaction success callback
//
function successCB() {
	
    var db = window.openDatabase("Database", "1.0", "PhoneGap Demo", 200000);
    db.transaction(queryDB, errorCB);
    
}

//PhoneGap is ready
function createDB() {
	
    var db = window.openDatabase("Database", "1.0", "PhoneGap Demo", 200000);
    db.transaction(populateDB, errorCB);
    
}
// PhoneGap is ready
function setupDB() {
	
    var db = window.openDatabase("Database", "1.0", "PhoneGap Demo", 200000);
    db.transaction(populateDB, errorCB, successCB);
    
}


function addItem(id, name, price, qty) {
	
	var total_price = price * qty;
	
	var db = window.openDatabase("Database", "1.0", "PhoneGap Demo", 200000);
	db.transaction(function(tx) {
	
		tx.executeSql('INSERT INTO CART (item_id, item_name, item_price, item_qty, price_total) VALUES ("' + id + '","' + name +'","' + price +'","' + qty +'","' + total_price + '")');
	
	}, dbErrorHandler);
}

function dbErrorHandler(err){
    alert("DB Error: "+err.message + "\nCode="+err.code);
}

/* Cart Features Script */

$('#delete_itemPage').live("pageshow", function(event){

	delete_item(); 
	
	$.mobile.changePage( "cart.html", { transition: "slideup"} );
	
});

/* function for Category Page */
function delete_item() {
	
	var id = getUrlVars()["id"];
	
	del_table(id);
	
} 


function del_table(id) {
	
	var db = window.openDatabase("Database", "1.0", "PhoneGap Demo", 200000);
	db.transaction(function(tx) {
	
		tx.executeSql('DELETE FROM CART WHERE id ="' + id + '"');
	
	}, dbErrorHandler);
}

$('#editPage').live("pageshow", function(event){

	var domainName = window.localStorage.getItem("domain_name");
	
	var serviceURL = "http://"+ domainName +"/MBOOS/mobile_ajax/mobile/";
	
	var id = getUrlVars()["id"];
	var item_id = getUrlVars()["item_id"];
	
	select_table(id);
	
	$.getJSON(serviceURL + 'get_info?id='+item_id, function(data) {
		
		item_info = data.item_info;
		
			$.each(item_info, function(index, info) {
				
				
				$('.item_available').append(info.mboos_product_availability);
				$('.item_total_qty').val(info.mboos_product_availability);
				
				});
			
		
		});
	
	$('.saveBtn').click(function() {
	    	
	    	var tempItem_availability = parseInt($('.item_total_qty').val());
	    	var qtyVal = parseInt($('input.qtyForm').val());
	    	
    		var regInt =  /^([\d]+[\d]+\b|[\d]+\b)$/;
    		
    		if($('input.qtyForm').val().match(regInt)) {
   	
		    	if(qtyVal <= tempItem_availability) {
		    		
			        	var name = $('.item_name_val').val();
			        	var price = $('.item_price_val').val();
			        	var qty = $('.qtyForm').val();
			        	var cart_id = $('.cart_id').val();
			        	var item_id = $('.item_id').val();
			        	var total_price = qty * price;
			        	
			        	update_table(cart_id,qty, total_price);
		
			        	
			    	} else {
			    		
			    		$("#cartEditMsg").popup('open');
			    		window.setTimeout(function() {$("#cartEditMsg").popup('close')}, 2000);	
			    		return false;
			    		
			    	} 
    		} else {
	    		
    			
    			$("#qtyChecker").popup('open');
    			window.setTimeout(function() {$("#qtyChecker").popup('close')}, 3000);	
    			return false;
	    	
	    	}
		
	    });
	
});

function select_table(id) {
	
	var db = window.openDatabase("Database", "1.0", "PhoneGap Demo", 200000);
	db.transaction(function(tx) {
	
		tx.executeSql('SELECT * FROM CART WHERE id="' + id + '"', [], selected_query, errorCB);
	
	}, dbErrorHandler);
}

//Query the success callback
function selected_query(tx, results) {
	
	var len = results.rows.length;
	
	for (var i=0; i<len; i++){
		
		$('.item_name').append(results.rows.item(i).item_name);
		$('.item_price').append(results.rows.item(i).item_price);		
		$('.qtyForm').val(results.rows.item(i).item_qty);
		$('.cart_id').val(results.rows.item(i).id);
		$('.item_id').val(results.rows.item(i).item_id);
		$('.item_name_val').val(results.rows.item(i).item_name);	
		$('.item_price_val').val(results.rows.item(i).item_price);
			
	    }  
}


function update_table(id, qty, ttl_price) {
	
	var db = window.openDatabase("Database", "1.0", "PhoneGap Demo", 200000);
	db.transaction(function(tx) {
		//item_id, item_name, item_price, item_qty
		tx.executeSql('UPDATE CART SET item_qty='+ qty +', price_total='+ ttl_price +' WHERE id="'+ id +'"', [], errorCB);
	
	}, dbErrorHandler);
}

$(document).ready(function() {

	var myURL = '/iq2/index.php/';
	var qty_available_selected = $('#table_AddToQuote > caption > span:nth-child(2)').html(); 


    // ----------------------------------------------------------------------------- Any Qty Input
    $('input[id^=qty_]').on('focus',function() {}).on('blur', function() {
        console.log('qty_  focus/blur' );
        var elementID = this.id;

        var id = /qty_(.+)$/i.exec( elementID );  id = RegExp.$1;
        var q  = $(this).val();
        var cp = '';

        if (id=='Custom') {
            cp = $('#price_'+id).val();
        }
        else {
            cp = $('#price_'+id).html();
        }

        if ( isNaN(q) ) {
            $(this).val('');
            $('#subTotal_'+id).html('');
            return false;
        }
        
        if ( overMaxAvailable() ) {
            alert("That's more than what's available; try again." );
            $(this).val('');
            $('#subTotal_'+id).html('');
            return false;
        }
        else {
            $('#subTotal_'+id).html( toCurrency(getSubTotal(cp,q)) );
        }
    });


    function overMaxAvailable() {
        var max = qty_available_selected.replace(',','');
        var total = 0;
        $('input[id^=qty_]').each(function(k, v) {
            // console.log("adding value: ["+$(this).val()+"]");
            total += +$(this).val(); // plus sign in front of $(this).val() is needed (make it a number)
        });
        console.log("total=["+total+"], max=["+max+"]");
        return total>max ? true : false;
    }


	function toCurrency(n)  {   
		if ( !n || isNaN(n) ) {
			return '';
		}
		var currency = '$';
		n1 = parseFloat(n);
		var tmp = currency + " " + n1.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
	   		return tmp; 
	}


	// ----------------------------------------------------------------------------- Custom Price
	$('input#price_Custom').focus(function() {  // enter
		$(this).val('');
	});

	$('input#price_Custom').blur(function() {  // leave
		var cp = $(this).val();
		var q = $('#qty_Custom').val();    

		checkCustomPrice(cp);

		if ( isNaN(cp) ) {
			$(this).val('');
			$('#subTotal_Custom').html('');
			return false;
		}

		$('#subTotal_Custom').html( toCurrency(getSubTotal(cp, q)) );
		$('input#price_Custom').val(toCurrency(cp));
	});

	function nothingToQuote() {
		var total = 0;
		$('input[id^=qty_]').each(function(k, v) { 
			total += +$(this).val();
		});
		return total===0 ? true : false;
    }


	function checkCustomPrice(cp) {
		var buttonText = '';
		var form_PartPricing = $( "#form_PartPricing" );
		var msg = '';
		var quoteID = $('#form_QuoteID').val();

		console.log('** dialog.js:checkCustomPrice() - distributor_price_floor=' + $('#distributor_price_floor').val() );

		var min_custom_price = $('#min_custom_price').html().substring(1).trim(); // ignore first character of '$' and leading spaces...
		var diff =  parseFloat(min_custom_price) - parseFloat(cp);
		var approvalNeeded =  ( diff > 0 ? 1 : 0 );
		
		if ( approvalNeeded ) {
			console.log('Quote approval needed.' );
			buttonText = 'Get Approval';
			msg = 'This quote is being submitted for approval.';
			// - set button to read 'Get Approval'
			// - set hidden variable on form 'approvalNeeded'
		}
		else {
			console.log('Quote approval NOT needed.' );
			buttonText = 'Add to Quote';  
			msg = 'Adding this part to quote: ' + quoteID;
			// - set button to read 'Add to Quote'
			// - clear hidden variable on form 'approvalNeeded'
		}

		form_PartPricing.dialog({
			buttons :  [{
							text: "Cancel",
							id: "button_Cancel",
							click: function(){
								form_PartPricing.dialog( "close" );  
			 					return false; 
							}
						}, 
						{
							text: buttonText,
							id: "button_AddToQuote",
							click: function(){
								// alert(msg);
								if ( nothingToQuote() ) {
				             		alert("Nothing to quote.");
				             		return false;
				             	}

								var info = {
									quote_id:			quoteID,
									part_no: 			$('#part_no').text(),
									approval_needed: 	approvalNeeded,

									manufacturer: 		$('#manufacturer').val(),	
									qty_Available:      $('#total_qty_for_part').val(),

									qty_1_24: 			$('#qty_1_24').val(),		// val == inputs
									qty_25_99: 			$('#qty_25_99').val(),
									qty_100_499: 		$('#qty_100_499').val(),
									qty_500_999: 		$('#qty_500_999').val(),
									qty_1000_Plus: 		$('#qty_1000_Plus').val(),	
									qty_Base: 			$('#qty_Base').val(),
									qty_Custom: 		$('#qty_Custom').val(),	

									price_1_24: 		$('#price_1_24').text().replace('$', ''),		// text == spans
									price_25_99: 		$('#price_25_99').text().replace('$', ''),	
									price_100_499: 		$('#price_100_499').text().replace('$', ''),
									price_500_999: 		$('#price_500_999').text().replace('$', ''),		
									price_1000_Plus: 	$('#price_1000_Plus').text().replace('$', ''),			
									price_Base: 		$('#price_Base').text().replace('$', ''),	

									price_Custom: 		$('#price_Custom').val().replace('$', ''),		
									comments: 			$('#comments').val()
								};

								// dialog.js
								$.ajax({
										url: myURL + 'quotes/partsUpdate?from=dialog_js',
										type: 'POST',
										data: info, 
										dataType: "json",
									  	success: function(data) {
								  			console.log("dialog_js, AJAX Post: Success - item_id=" + data.item_id);
									  		alert("Your Customer Quote has been updated.");
									  	}
									  	//,
									  //	error: function (jqXHR, textStatus, errorThrown)  {
									  		// console.log("dialog_js, AJAX Post: jqXHR:"+jqXHR);
									  		// console.log("dialog_js, AJAX Post: errorThrown:"+errorThrown);
									  		// alert("Your Customer Quote could NOT be updated - see Admin (dialog_js)\n\nERROR=" + errorThrown);
									  //	} 
								});

								form_PartPricing.dialog( "close" );  
								return false;
							}
						} ]
		});	
	}

	// ------------------------------------------------------------- sub total 
	function getSubTotal(pr,q) {
		if (pr) {
			pr = pr.replace('$',''); 	pr = pr.replace(',',''); 
		}
		if (q) {
			q = q.replace('$',''); 	q = q.replace(',',''); q = Math.floor(q);
		}

		return Number(pr) * Number(q);
	}


});


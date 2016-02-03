$(document).ready(function() {

   // var myURL           = getAbsolutePath();  
    var customerPrefill = true;
    var contactPrefill  = true;
    var myURL           = '/iq2/index.php/';
    var searchURL       = myURL + 'quotes/search';

    console.log('myURL=['+myURL+']');
    console.log('returnUrl=[' + $('#returnUrl').val() + ']' );

    // quick and dirt funtion for truncating text with ellipses...
    String.prototype.trunc = function(n) { return this.substr(0,n-1)+(this.length>n?'&hellip;':''); };
    function truncateWithEllipses(text, max) {
        return text.substr(0,max-1)+(text.length>max?'&hellip;':''); 
    }


    // -----------------------------------------------
	// ---------- set up UI Dialogs ------------------
	// -----------------------------------------------
	var dialog_PartPricing = $( "#form_PartPricing" ).dialog({
		autoOpen: false,
		height: 1100,
		width: 500,
		modal: true,
		resizable: false,
		close: function() { }
	});

    $('#reset_form').on('click', function() {
        location.reload();
    });

    $('#add_quote').on('click', function() {
        window.location = myURL + 'quotes/create' ;
    });

    // set up DataTable
    var QuotesTable  = $('#quotes_table').DataTable({"iDisplayLength": 10 }); 
    var ResultsTable = null;
	
	//---------------------------------------------------------------------------------------------------------------------
    //-------- Event Handlers  --------------------------------------------------------------------------------------------    
    //---------------------------------------------------------------------------------------------------------------------

    $('#addPartToQuote').on('click', function() {
        $('#div_PartsLookup').show();





    });

    $('#clearContactFields').on('click', function() {
        $('[id^=Contact_]').val('');
        $('[id^=Contact_]').removeAttr('readOnly');
    });


    $('#button_Home').on('click', function() {
        window.location = myURL + 'quotes/index';
    });

    $('#button_CancelQuoteChanges').on('click', function() { 
        window.location = myURL + 'quotes/view/' + $('#Quote_id'.val());
    });

    $('#quoteUpdateForm').submit(function( e ) {  // click "Save Changes"
        e.preventDefault();

        var quoteID = $('#Quote_id').val(); 
        var postData = $(this).serialize();
        var returnURL = $('#return_URL').val();

        $.ajax({
                type: "POST",
                    url: myURL + 'quotes/update/' + quoteID,
                    data: postData,
                    success: function(results)  {
                        console.log('results from quote update=['+results+']');

                        if ( results == 0  ) { // update succeeded
                            //alert('Update succeeded');
                            window.location = myURL + 'quotes/view/'+quoteID;
                        }
                        else {
                            alert('Missing required fields...');
                            return false;
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown)  {
                        alert("Couldn't update quote " + quoteID + "; error=\n\n" + errorThrown);
                    }
        });

    });


    $('#quoteForm').submit(function( e ) {  //  click "Continue"
    	e.preventDefault();
    	if ( formValidated() ) { 		
    		// console.log('formValidated() = TRUE');

    		var postData = $(this).serialize();
    		$.ajax({
	            type: "POST",
		            url: myURL + 'quotes/create',
		            data: postData,
		            success: function(results)  {
		            	var q = results.split('|');
		            	quoteId = q[0];
		            	quoteNo = q[1];
		            	console.log('quoteId=['+quoteId+'], quoteNo=['+quoteNo+']');
		            	$('#form_QuoteID').val(quoteId);
		            	continueQuote(quoteNo);
		            }
	        });
    	}
    	else {
    			alert("Missing required field(s)...");
    	}
	});

    // ------------------------------------------------------------------
    $('#div_SubmitDone > input').on('click', function () {

        $(window).unbind('beforeunload');

        var quoteID = $('#form_QuoteID').val();

        var data = {
            quote_Terms:       $('#quote_Terms').val(),
            quote_CustAck:     $('#quote_CustAck').val(),
            quote_RISL:        $('#quote_RISL').val(),
            quote_MfgLeadTime: $('#quote_MfgLeadTime').val(),
            quote_Notes:       $('#quote_Notes').val()
        };

       // var postData = data.serialize();
        $.ajax({
            type: "POST",
                url: myURL + 'quotes/update/' + quoteID ,
                //data: postData,
                data: data,
                success: function(results)  {
                  
                }
        });

         window.location = myURL + 'quotes/index' ;

    });









	// // ----------------------------------------------------------------------------- Custom Price
	// $('input#price_Custom').focus(function() {  // enter
	// 	$(this).val('');
	// });

	// $('input#price_Custom').blur(function() {  // leave
	// 	var cp = $(this).val();
	// 	var q = $('#qty_Custom').val();

	// 	if ( isNaN(cp) ) {
	// 		$(this).val('');
	// 		$('#subTotal_Custom').html('');
	// 		return false;
	// 	}

	// 	$('#subTotal_Custom').html( toCurrency(getSubTotal(cp, q)) );
	// 	$('input#price_Custom').val(toCurrency(cp));

	// });


    // ----------------------------------------------------- delete item
    $('[id^=item_trash_]').on('click', function() {
        var itemID = getID($(this));
        if ( confirm("Are you sure you want to delete this item?" ) ) {
            $.ajax({
                  url: myURL + 'stockItems/delete/' + itemID ,
                  type: 'POST',
                  success: function(data, textStatus, jqXHR) {
                    location.reload(true);
                  },
                  error: function (jqXHR, textStatus, errorThrown)  {
                    alert("Couldn't delete item " + itemID + " from this quote; error=\n\n" + errorThrown);
                  }
            });
        }
        return false;z
    });




    // ----------------------------------------------------- edit item
    $('[id^=item_edit_]').on('click', function() {
        var itemID = getID($(this));  

        var returnUrl = $('#returnUrl').val();
        var u = myURL + "stockItems/update/" + itemID + '?returnUrl=' + returnUrl ;

        console.log('url=' +  u);
        window.location.replace(u);
    });


	function getID(that) {
			var tmp =  $(that).attr('id');
			var thisId = /\w+[_delete_|_edit_]\w+_(.+)$/i.exec( tmp );
			return RegExp.$1;
		}


    $('#Customer_select').on('change', function () { //  Select from available customers
        var custID = $(this).val();
        $.ajax({
            type: 'GET',
            url: myURL + 'customers/find?id='+custID ,
            success: function (ret) {
                display_Customer(ret);
            }
        });
    });
   
    $('#Contact_select').on('change', function () { //  Select from available contact
        var contactID = $(this).val();
        $.ajax({
            type: 'GET',
            url: myURL + 'contacts/find?id='+contactID ,
            success: function (ret) {
                display_Contact(ret);
            }
        });
    });

    $('[id^=view_quote_]').on('click', function() { //   View quote  
    	var quoteID = getThisID( $(this) ); 
    	window.location = myURL + 'quotes/view?id='+quoteID ;
    })

    $('[id^=quote_edit_]').on('click', function() { //   Edit quote  
        var quoteID = getThisID( $(this) ); 
        window.location = myURL + 'quotes/update/' + quoteID ; 
    })



    $('[id^=quote_trash_]').on('click', function() { //   Delete quote  
        var quoteID = getThisID( $(this) ); 
        if ( confirm("Are you sure you want to delete this quote?" ) ) {
            $.ajax({
                  url: myURL + 'quotes/delete/' + quoteID ,
                  type: 'POST',
                  data: { data: quoteID },
                  success: function(data, textStatus, jqXHR) {
                    window.location = myURL + 'quotes/index' ;
                  },
                  error: function (jqXHR, textStatus, errorThrown)  {
                    alert("Couldn't delete quote " + quoteID + "; error=\n\n" + errorThrown);
                  }
            });
        }
        return false;

    })
  
    $('#quotes_table').on('click', function() {  //  re-attach event handler 
    	// have to attach click event handler; after paging, 
    	// dataTables reloads the tableBody and all attached event handlers

    	// do this for view_quote_xx, edit_quote_xx, delete_quote_xx

		$('[id^=view_quote_]').on('click', function() {
	    	var quoteID = getThisID( $(this) ); 
	    	window.location = myURL + 'quotes/view?id='+quoteID ;
	    })

    });

 	$('input').keypress(function(event) {   // make 'Enter' key act like Find button
       if (event.which == 13) {
           event.preventDefault();
           $('#parts_Searchbutton').trigger('click');
       }
    });

    $('#parts_Searchbutton').click(function() {
  		var searchFor = $('#parts_Searchfield').val();
  		var searchBy  = $('#parts_SearchBy').val();
  		var parts     = '';
      var url = encodeURIComponent( myURL + 'parts/search?item=' + searchFor.trim().toUpperCase() + '&by=' + searchBy);      // >>>>>>>  THE ONLY PLACE WE NEED TO USE "encodeURIComponent()"

  		if ( searchFor.trim( && searchBy ) {
  			$.ajax({
	                type: 'GET',
	                url: url,
	                success: function (results) {
	                	displayPartLookupResults(results);
	                }
            });
  		}
  	});

    $('#section_Parts > div.quote_section_heading > span.open_close').on('click', function() {  // toggle  section
        if ( $(this).html() == '+') {
            $(this).html('−'); 
        }
        else {
            $(this).html('+');
        }
        $('#section_Parts > div.my_container').fadeToggle(250);   // toggle();
    })


    $('#section_CustomerContact > div.quote_section_heading > span.open_close').on('click', function() {  // toggle  section
		if ( $(this).html() == '+') {
			$(this).html('−'); 
		}
		else {
			$(this).html('+');
		}
		$('#section_CustomerContact > div.my_container').fadeToggle(250);   // toggle();
   	})

    $('#section_TermsConditions > div.quote_section_heading > span.open_close').on('click', function() {  // toggle  section
        if ( $(this).html() == '+') {
            $(this).html('−'); 
        }
        else {
            $(this).html('+');
        }
        $('#section_TermsConditions > div.my_container').fadeToggle(250);   // toggle();
    })
    $('#section_TermsConditions > div.quote_section_heading > span.open_close').trigger('click'); // default=closed


    //---------------------------------------------------------------------------------------------------------------------
    //-------- Functions --------------------------------------------------------------------------------------------------    
    //---------------------------------------------------------------------------------------------------------------------



    function toCurrency(n)  {   
        if ( !n || isNaN(n) ) {
            return '';
        }
        var currency = '$';
        n1 = parseFloat(n);
        var tmp = currency + " " + n1.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
            return tmp; 
    }




    $(function() {  // Search for either Customer or Contact using typeahead, autocompletion 
        $( "#search_typeahead" ).autocomplete({
            source: searchURL,
            minLength: 4, 
            close: function() {
                $('#search_typeahead').val("");  
            },
            select: function(event,ui) {
                var selectID = ui.item.value;
                
                if ( ui.item.label.match(/\(\d+\)/) == null ) {   // found a contact 
                    $.ajax({
                        type: 'GET',
                        url: myURL + 'contacts/find?id='+selectID ,
                        success: function (contact_details) {
                        	$('[id^=Customer_]').val('');
                        	display_Contact(contact_details)

                            $.ajax({
                                type: 'GET',
                                url: myURL + 'customers/findbycontact?id='+selectID ,
                                success: function (customer_list) {
                                   display_CustomerSelect(customer_list);
                                }
                            });
                        },
                        error: function (jqXHR, textStatus, errorThrown)  {
                            console.log('Error in searching for contact id: '+selectID+', msg= '+errorThrown);
                        } 
                    });
                }
                else {     //  found a customer
                    $.ajax({
                        type: 'GET',
                        url:  myURL + 'customers/find?id='+selectID ,
                        success: function (customer_details) {
                        	$('[id^=Contact_]').val('');
                        	display_Customer(customer_details)

                            $.ajax({
                                type: 'GET',
                                url: myURL + 'contacts/findbycust?id='+selectID ,
                                success: function (contact_list) {
                                    display_ContactSelect(contact_list);
                                }
                            });
                        },
                        error: function (jqXHR, textStatus, errorThrown)  {
                            console.log('Error in searching for customer id: '+selectID+', msg= '+errorThrown);
                        } 
                    });
                }


            }
        });
    });


	function nothingToQuote() {
		var total = 0;
		$('input[id^=qty_]').each(function(k, v) { 
		//$('input[id^=subTotal_]').each(function(k, v) { 
			total += +$(this).val();
		});
		return total===0 ? true : false;
	
    }


    function appendTable_CurrentParts( info, itemID) {

        var images   = "<td style='font-size: .9em; padding: 2px;'><img id='item_edit_"+itemID+"' title='Edit this item' src='/iq2/images/New/edit.png' width='16' height='16' /><img id='item_trash_"+itemID+"' title='Delete this item'  src='/iq2/images/New/trash.png' width='16' height='16' />";
        var quantity = 0;
        var volume   = 0;
        var price    = 0; 
        var total    = 0;  // num.toFixed(2)

        var comments = truncateWithEllipses(info.comments,100);

        if ( info.qty_1_24 > 0 ) {
            $('#table_CurrentParts').append( "<tr>"+images+"<td>"+info.part_no+"</td><td>"+info.manufacturer+"</td><td>"+info.qty_1_24+"</td><td><span class='volume'>1_24</span>$ "+info.price_1_24+"</td><td>$ "+(info.qty_1_24*info.price_1_24).toFixed(2).toString()+"</td><td>"+comments+"</td></tr>" );
        }
        if ( info.qty_25_99 > 0 ) {
            $('#table_CurrentParts').append( "<tr>"+images+"<td>"+info.part_no+"</td><td>"+info.manufacturer+"</td><td>"+info.qty_25_99+"</td><td><span class='volume'>25_99</span>$ "+info.price_25_99+"</td><td>$ "+(info.qty_25_99*info.price_25_99).toFixed(2).toString()+"</td><td>"+comments+"</td></tr>" );
        }
        if ( info.qty_100_499 > 0 ) {
            $('#table_CurrentParts').append( "<tr>"+images+"<td>"+info.part_no+"</td><td>"+info.manufacturer+"</td><td>"+info.qty_100_499+"</td><td><span class='volume'>100_499</span>$ "+info.price_100_499+"</td><td>$ "+(info.qty_100_499*info.price_100_499).toFixed(2).toString()+"</td><td>"+comments+"</td></tr>" );
        }
        if ( info.qty_500_999 > 0 ) {
            $('#table_CurrentParts').append( "<tr>"+images+"<td>"+info.part_no+"</td><td>"+info.manufacturer+"</td><td>"+info.qty_500_999+"</td><td><span class='volume'>500_999</span>$ "+info.price_500_999+"</td><td>$ "+(info.qty_500_999*info.price_500_999).toFixed(2).toString()+"</td><td>"+comments+"</td></tr>" );
        }
        if ( info.qty_1000_Plus > 0 ) {
            $('#table_CurrentParts').append( "<tr>"+images+"<td>"+info.part_no+"</td><td>"+info.manufacturer+"</td><td>"+info.qty_1000_Plus+"</td><td><span class='volume'>1000_Plus</span>$ "+info.price_1000_Plus+"</td><td>$ "+(info.qty_1000_Plus*info.price_1000_Plus).toFixed(2).toString()+"</td><td>"+comments+"</td></tr>" );
        }
        if ( info.qty_Base > 0 ) {
            $('#table_CurrentParts').append( "<tr>"+images+"<td>"+info.part_no+"</td><td>"+info.manufacturer+"</td><td>"+info.qty_Base+"</td><td><span class='volume'>Base</span>$ "+info.price_Base+"</td><td>$ "+(info.qty_Base*info.price_Base).toFixed(2).toString()+"</td><td>"+comments+"</td></tr>" );
        }
        if ( info.qty_Custom > 0 ) {
            $('#table_CurrentParts').append( "<tr>"+images+"<td>"+info.part_no+"</td><td>"+info.manufacturer+"</td><td>"+info.qty_Custom+"</td><td><span class='volume'>Custom</span>$ "+info.price_Custom+"</td><td>$ "+(info.qty_Custom*info.price_Custom).toFixed(2).toString()+"</td><td>"+comments+"</td></tr>" );
        }

        // ----------------------------------------------------- delete item
        $('[id^=item_trash_]').on('click', function() {
            var itemID = getID($(this));
            if ( confirm("Are you sure you want to delete this item?" ) ) {
                $.ajax({
                      url: myURL + 'stockItems/delete/' + itemID ,
                      type: 'POST',
                      success: function(data, textStatus, jqXHR) {
                        location.reload(true);
                      },
                      error: function (jqXHR, textStatus, errorThrown)  {
                        alert("Couldn't delete item " + itemID + " from this quote; error=\n\n" + errorThrown);
                      }
                });
            }
            return false;z
        });

        // ----------------------------------------------------- edit item
        $('[id^=item_edit_]').on('click', function() {
            var itemID = getID($(this));  

            var returnUrl = $('#returnUrl').val();
            var u = myURL + "stockItems/update/" + itemID + '?returnUrl=' + returnUrl ;

            console.log('url=' +  u);
            window.location.replace(u);
        });


    }


	function openQuoteDialog(results) {
		$('#form_PartPricing').html(results);

		var quoteID = $('#form_QuoteID').val();
		var msg     = 'Adding this part to Quote No. [' + quoteID + ']';
        var info    = '';

		dialog_PartPricing.dialog('option', 'title', 'Inventory Part Pricing Details'); 
		dialog_PartPricing.dialog({
			buttons :  [{
							text: "Cancel",
							id: "button_Cancel",
							click: function(){
								dialog_PartPricing.dialog( "close" );  
			 					return false; 
							}
						}, 
						{
							text: "Add to Quote",
							id: "button_AddToQuote",
							click: function(){
								//alert(msg);
								if ( nothingToQuote() ) {
				             		alert("Nothing to quote.");
				             		return false;
				             	}
								
								info = {
        									quote_id:			quoteID,
        									part_no: 			$('#part_no').text(),
        									approval_needed: 	null,

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

								// iq2_main.js
								$.ajax({ 
										url: myURL + 'quotes/partsUpdate' ,
										type: 'POST',
										data: info, 
										dataType: "json",
										success: function(item_id, textStatus, jqXHR) {
											console.log("AJAX Post: Success!");
											//alert("Your Customer Quote has been updated; item_id:" + item_id);

                                            if ( $('#selectedParts').html() == '' ) {
                                                $('#selectedParts').html(  'Item(s) added to quote: ' + $('#part_no').text());
                                            }
                                            else {
                                                $('#selectedParts').append(  ', ' + $('#part_no').text());
                                            }

                                            appendTable_CurrentParts(info, item_id);
                                            //alert('insert new part '+ info.part_no + manufacturer + ' into table...');

										},
										error: function (jqXHR, textStatus, errorThrown)  {
											console.log("AJAX Post: FAIL! error:"+errorThrown);
											alert("Your Customer Quote could NOT be updated - see Admin");
										} 
								});

								dialog_PartPricing.dialog( "close" );  
								return false;
							}
						} ]
		});
	
		dialog_PartPricing.dialog( "open" );
	}



								// //var info = {};
								// var info = new Array();

								// info['Parts'] = new Array();
				    //          	info['Parts']['quote_id']       = quoteID;
				    //          	info['Parts']['part_no']        = $('#part_no').html(); 
				    //          	info['Parts']['approvalNeeded'] = approvalNeeded;

				    //          	// info['manufacturer'] = p.manufacturer;  // where is this coming from?


				    //          	// info['date_code']    = date_code_selected;  // maybe for later functionality

				    //          	//info['qty'] = {};
				    //          	info['qty'] = new Array();

				    //          	info['qty']['1_24']      = $('#qty_1_24').val();
				    //          	info['qty']['25_99']     = $('#qty_25_99').val();
				    //          	info['qty']['100_499']   = $('#qty_100_499').val();
				    //          	info['qty']['500_999']   = $('#qty_500_999').val();
				    //          	info['qty']['1000_Plus'] = $('#qty_1000_Plus').val();
				    //          	info['qty']['Base']      = $('#qty_Base').val();
				    //          	info['qty']['Custom']    = $('#qty_Custom').val();
				    //          // info['qty']['Available'] = qty_available_selected;

				    //          	//info['price'] = {};
				    //          	info['price'] = new Array();

				    //          	info['price']['1_24']      = $('#price_1_24').val();
				    //          	info['price']['25_99']     = $('#price_25_99').val();
				    //          	info['price']['100_499']   = $('#price_100_499').val();
				    //          	info['price']['500_999']   = $('#price_500_999').val();
				    //          	info['price']['1000_Plus'] = $('#price_1000_Plus').val();
				    //      		info['price']['Base']      = $('#price_Base').val();
								// info['price']['Custom']    = $('#price_Custom').val();

								//submit_QuotePricingUpdate(info);
								//submit_QuotePricingUpdate();
				


	// function submit_QuotePricingUpdate() {
	// 	var quoteID = $('#form_QuoteID').val();

	// 	var info = {};

	// 	info['Parts'] = new Array();
 //     	info['Parts']['quote_id']       = quoteID;
 //     	info['Parts']['part_no']        = $('#part_no').html(); 
 //     	info['Parts']['approvalNeeded'] = approvalNeeded;

 //     	// info['manufacturer'] = p.manufacturer;  // where is this coming from?


 //     	// info['date_code']    = date_code_selected;  // maybe for later functionality

 //     	info['qty'] = {};
 //     	//info['qty'] = new Array();

 //     	info['qty']['1_24']      = $('#qty_1_24').val();
 //     	info['qty']['25_99']     = $('#qty_25_99').val();
 //     	info['qty']['100_499']   = $('#qty_100_499').val();
 //     	info['qty']['500_999']   = $('#qty_500_999').val();
 //     	info['qty']['1000_Plus'] = $('#qty_1000_Plus').val();
 //     	info['qty']['Base']      = $('#qty_Base').val();
 //     	info['qty']['Custom']    = $('#qty_Custom').val();
 //     // info['qty']['Available'] = qty_available_selected;

 //     	info['price'] = {};
 //     	// info['price'] = new Array();

 //     	info['price']['1_24']      = $('#price_1_24').val();
 //     	info['price']['25_99']     = $('#price_25_99').val();
 //     	info['price']['100_499']   = $('#price_100_499').val();
 //     	info['price']['500_999']   = $('#price_500_999').val();
 //     	info['price']['1000_Plus'] = $('#price_1000_Plus').val();
 // 		info['price']['Base']      = $('#price_Base').val();
	// 	info['price']['Custom']    = $('#price_Custom').val();

	// 	console.log('Submitting: ' + info);

	// 	$.ajax({
	// 			url: '../quotes/partsUpdate/' + $('#form_QuoteID').val(),
	// 			// url: '../quotes/update',
	// 			type: 'POST',
	// 			//data: {data: info}, 
	// 			data: JSON.stringify(info),
	// 			dataType:'json',

	// 			success: function(data, textStatus, jqXHR) {
	// 				console.log("AJAX Post: Success!");
	// 				alert("Your Customer Quote has been updated.");
	// 				window.location.replace("../quotes/" + quoteID );
	// 			},
	// 			error: function (jqXHR, textStatus, errorThrown)  {
	// 				console.log("AJAX Post: FAIL! error:"+errorThrown);
	// 				alert("Your Customer Quote could NOT be updated.");
	// 			} 
	// 	});

	// }


	function displayPartDetails(that) {
		var tmp = /^rowID_(.+)$/.exec( that[0].id);
		var partNo = tmp[1];
        var url = encodeURIComponent( myURL + 'parts/search?item=' + partNo.trim().toUpperCase() + '&dialog=1' );      // >>>>>>>  THE ONLY PLACE WE NEED TO USE "encodeURIComponent()"
        console.log('url=' + url);

		$.ajax({
                type: 'GET',
                url: url,
                success: function (results) {
                	openQuoteDialog(results);
                }
        });
	}

    function displayPartLookupResults(res) {
    	var a          = JSON.parse(res);
    	var partsCount = a.parts.length; 

    	// if ( partsCount == 0 ) {
    	// 	alert('Part not found; \n\nWant to create a Manufacturing Quote?');
    	// }

  		if ( ResultsTable ) {
  			ResultsTable.destroy();
  		}

    	$('#results_table tbody').empty();
    	var rows       = '';
    	for( var i=0; i<partsCount; i++ ) {
    		rows += "<tr id='rowID_"+a.parts[i].part_number+"'>";
    		rows += "<td>"+ a.parts[i].part_number + "</td>";
    		rows += "<td>"+ ( a.parts[i].manufacturer ? a.parts[i].manufacturer : 'n/a' )+"</td>";
    		rows += "<td>"+ ( a.parts[i].supplier ? a.parts[i].supplier : 'n/a' )+"</td>";
	   		rows += "<td>"+ ( a.parts[i].se_data.Lifecycle ? a.parts[i].se_data.Lifecycle : 'n/a' )+"</td>";
    		rows += "<td>"+ ( a.parts[i].drawing ? a.parts[i].drawing : 'n/a' )+"</td>";
    		rows += "<td>"+ ( a.parts[i].carrier_type ? a.parts[i].carrier_type : 'n/a' )+"</td>";
    		rows += "<td>"+ ( a.parts[i].mpq ? a.parts[i].mpq : 'n/a' )+"</td>";
    		rows += "<td>"+ ( a.parts[i].total_qty_for_part ? a.parts[i].total_qty_for_part : 'n/a' )+"</td>";
    		rows += "</tr>";
    	}

    	$('#results_table thead').after('<tbody>'+rows+'</tbody>');
    	ResultsTable = $('#results_table').DataTable({
			"iDisplayLength": 10,
			drawCallback: function() {
		        var api = this.api();
		        api.$('#results_table > tbody > tr').click(function() {
		        	console.log( "Ready to display part details: ", $(this) );







		            displayPartDetails( $(this) );  //alert('from displayPartLookupResults: parts row click...');
		        });
		    }
		});

        $('#section_TermsConditions').show();
    }

    function continueQuote( quote_no ) {
    	$('#header_PageTitle').html('Quote No. ');
    	$('#header_QuoteNo').html(quote_no);

    	$('#heading_container').hide();
    	$('#selection_container').hide();
    	$('#div_ContinueReset').hide();
        $('#section_PartsLookup').show();

        $('#div_SubmitDone').show();

        $('#section_CustomerContact > div.quote_section_heading > span.open_close').show()
        $('#section_TermsConditions > div.quote_section_heading > span.open_close').show()
		$('#section_PartsLookup     > div.quote_section_heading > span.open_close').show()
    }

    function formValidated() {
        console.log("Customer_id=" + $('#Customer_id').val() );
        console.log("Contact_id=" + $('#Contact_id').val() );
        console.log("Quote_source_id=" + $('#Quote_source_id').val() );


    	if ( $('#Customer_id').val() && $('#Contact_id').val() && $('#Quote_source_id').val()  > 0  ) {
    		return true;
    	}
    	return false;
    }

    function getAbsolutePath() {
        var loc = window.location;
        var pathName = loc.pathname.substring(0, loc.pathname.lastIndexOf('/') + 1);
        return loc.href.substring(0, loc.href.length - ((loc.pathname + loc.search + loc.hash).length - pathName.length));
    }

    function display_Customer(data) {
 		var o = JSON.parse(data);    
        $.each( o, function( k, v ) {
        	//console.log("display_Customer_: k=["+k+"], v=["+v+"]");
           	$('#Customer_'+k).html( v );
            $('#Customer_'+k).val( v );
        });
    }

    function display_Contact(data) {
    	var o = JSON.parse(data);    
        $.each( o, function( k, v ) {
        	 // console.log("Contact_: k=["+k+"], v=["+v+"]");
           	$('#Contact_'+k).html( v );
            $('#Contact_'+k).val( v );
        });
    }

    function display_CustomerSelect( data ) {	// ok
    	$('#Customer_select').empty();
    	$('#Customer_select').append( $('<option></option>' ).val(0).html('') );;

    	var o = JSON.parse(data); 
    	$.each( o, function(k,v) {
            $('#Customer_select').append( $('<option></option>' ).val(v.id).html(v.label) );
            // console.log("display_CustomerSelect() - id=["+ v.id + "], label=[" + v.label + "]");
        });

    	$('#heading_container').show();
    	$('#span_SelectCustomer').show();
    	$('#span_SelectContact').hide();  
    }

 	function display_ContactSelect( data ) {	// ok
 		$('#Contact_select').empty();
 		$('#Contact_select').append( $('<option></option>' ).val(0).html('') );

 		var o = JSON.parse(data); 
    	$.each( o, function(k,v) {
            $('#Contact_select').append( $('<option></option>' ).val(v.id).html(v.label) );
            // console.log("display_ContactSelect() - id=["+ v.id + "], label=[" + v.label + "]");
        });

    	$('#heading_container').show();
    	$('#span_SelectCustomer').hide();
    	$('#span_SelectContact').show(); 
    }

	function getThisID( that ) {
        return /\d+$/.exec( $(that).attr('id') );
    }

});

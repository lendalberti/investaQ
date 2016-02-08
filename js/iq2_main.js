$(document).ready(function() {

   // var myURL           = getAbsolutePath();  
    var customerPrefill = true;
    var contactPrefill  = true;
    var myURL           = '/iq2/index.php/';
    var searchURL       = myURL + 'quotes/search';

    var SUCCESS      = '0';
    var FAILURE      = '1';

    var STATUS_DRAFT   = 1;
    var STATUS_PENDING = 2;

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



    $('#changeStatus').on('click', function() {
        dialog_status.dialog( "open" );
    });


    dialog_status = $( "#dialog_status_form" ).dialog({
        autoOpen: false,
        height: 160,
        width: 350,
        modal: true,
        buttons: {
            "Change": function() {
                var newStatus =  $('#newQuoteStatus').val();
                console.log( "new status = " + newStatus + ", form: " + $('#new_status_form').serialize() );
                var postData = $('#new_status_form').serialize();
                var quoteID = $('#Quotes_id').val();

                $.ajax({
                        type: "POST",
                        url: myURL + 'quotes/update/' + quoteID,
                        data: postData,
                        success: function(results)  {
                            console.log('results from quote update=['+results+']');
                            location.reload();
                        }
                });

                dialog_status.dialog( "close" );
                return false;
            },
            Cancel: function() {
                dialog_status.dialog( "close" );
            }
        }
    });

    $('#addPartToQuote').on('click', function() {
        $('#div_PartsLookup').show();
    });

    $('#span_NewContact').on('click', function() {
        $('[id^=Contacts_]').val('');
        $('[id^=Contacts_]').removeAttr('readOnly');

$('#Contacts_state_id').replaceWith('<select                  name="Contacts[state_id]" id="Contacts_state_id"></select>');
        $.ajax({
            type: 'GET',
            url: myURL + 'quotes/select?q=us_states',
            success: function (data) {
                var o = JSON.parse(data); 
                $.each( o, function(k,v) {
                    $('#Contacts_state_id').append( $('<option></option>' ).val(v.id).html(v.label) );
                });
            }
        });

        $('#Contacts_country_id').replaceWith('<select                name="Contacts[country_id]" id="Contacts_country_id"></select>');
        $.ajax({
            type: 'GET',
            url: myURL + 'quotes/select?q=countries',
            success: function (data) {
                var o = JSON.parse(data); 
                $.each( o, function(k,v) {
                    $('#Contacts_country_id').append( $('<option></option>' ).val(v.id).html(v.label) );
                });
            }
        });


    });

    $('#span_NewCustomer').on('click', function() {
        $('[id^=Customers_]').val('');
        $('[id^=Customers_]').removeAttr('readOnly');

        $('#Customers_state_id').replaceWith('<select                 name="Customers[state_id]" id="Customers_state_id"></select>');
        $.ajax({
            type: 'GET',
            url: myURL + 'quotes/select?q=us_states',
            success: function (data) {
                var o = JSON.parse(data); 
                $.each( o, function(k,v) {
                    $('#Customers_state_id').append( $('<option></option>' ).val(v.id).html(v.label) );
                });
            }
        });


        $('#Customers_country_id').replaceWith('<select               name="Customers[country_id]" id="Customers_country_id"></select>');
        $.ajax({
            type: 'GET',
            url: myURL + 'quotes/select?q=countries',
            success: function (data) {
                var o = JSON.parse(data); 
                $.each( o, function(k,v) {
                    $('#Customers_country_id').append( $('<option></option>' ).val(v.id).html(v.label) );
                });
            }
        });

        $('#Customers_region_id').replaceWith('<select                name="Customers[region_id]" id="Customers_region_id"></select>');
        $.ajax({
            type: 'GET',
            url: myURL + 'quotes/select?q=regions',
            success: function (data) {
                var o = JSON.parse(data); 
                $.each( o, function(k,v) {
                    $('#Customers_region_id').append( $('<option></option>' ).val(v.id).html(v.label) );
                });
            }
        });

        $('#Customers_customer_type_id').replaceWith('<select         name="Customers[customer_type_id]" id="Customers_customer_type_id"></select>');
        $.ajax({
            type: 'GET',
            url: myURL + 'quotes/select?q=customer_types',
            success: function (data) {
                var o = JSON.parse(data); 
                $.each( o, function(k,v) {
                    $('#Customers_customer_type_id').append( $('<option></option>' ).val(v.id).html(v.label) );
                });
            }
        });

        $('#Customers_outside_salesperson_id').replaceWith('<select   name="Customers[outside_salesperson_id]" id="Customers_outside_salesperson_id"></select>');
        $('#Customers_inside_salesperson_id').replaceWith('<select    name="Customers[nside_salesperson_id]" id="Customers_inside_salesperson_id"></select>');
        $.ajax({
            type: 'GET',
            url: myURL + 'quotes/select?q=users',
            success: function (data) {
                var o = JSON.parse(data); 
                $.each( o, function(k,v) {
                    $('#Customers_inside_salesperson_id').append( $('<option></option>' ).val(v.id).html(v.label) );
                    $('#Customers_outside_salesperson_id').append( $('<option></option>' ).val(v.id).html(v.label) );
                });
            }
        });
        
        $('#Customers_parent_id').replaceWith('<select                name="Customers[parent_id]" id="Customers_parent_id"></select>');
        $.ajax({
            type: 'GET',
            url: myURL + 'quotes/select?q=customers',
            success: function (data) {
                var o = JSON.parse(data); 
                $.each( o, function(k,v) {
                    $('#Customers_parent_id').append( $('<option></option>' ).val(v.id).html(v.label) );
                });
            }
        });

        $('#Customers_tier_id').replaceWith('<select                  name="Customers[tier_id]" id="Customers_tier_id"></select>');
        $.ajax({
            type: 'GET',
            url: myURL + 'quotes/select?q=tiers',
            success: function (data) {
                var o = JSON.parse(data); 
                $.each( o, function(k,v) {
                    $('#Customers_tier_id').append( $('<option></option>' ).val(v.id).html(v.label) );
                });
            }
        });

        $('#Customers_territory_id').replaceWith('<select             name="Customers[territory_id]" id="Customers_territory_id"></select>');
        $.ajax({
            type: 'GET',
            url: myURL + 'quotes/select?q=territories',
            success: function (data) {
                var o = JSON.parse(data); 
                $.each( o, function(k,v) {
                    $('#Customers_territory_id').append( $('<option></option>' ).val(v.id).html(v.label) );
                });
            }
        });



    });







    // $('#button_Home').on('click', function() {
    //     window.location = myURL + 'quotes/index';
    // });

    $('#button_CancelQuoteChanges').on('click', function() { 
        window.location = myURL + 'quotes/view/' + $('#Quotes_id').val();
    });

    $('#quoteUpdateForm').submit(function( e ) {  // click "Save Changes"
        e.preventDefault();

        if ( $('#header_QuoteNo > span').text().match(/Rejected/) ) {
            $('#Quotes_status_id').val(STATUS_PENDING);
            consoleDisplayFormFields($('#quoteUpdateForm'));
            console.log('Setting quote status to "Pending Approval"');
        }

        var quoteID = $('#Quotes_id').val(); 
        var postData = $(this).serialize();
        var returnURL = $('#return_URL').val();

        $.ajax({
                type: "POST",
                    url: myURL + 'quotes/update/' + quoteID,
                    data: postData,
                    success: function(results)  {
                        console.log('results from quote update=['+results+']');

                        if ( results == SUCCESS ) { // update succeeded
                            alert('Quote updated...');
                            window.location = myURL + 'quotes/view/'+quoteID;
                        }
                        else {
                            alert('Server Validation: missing required field(s)...');
                            return false;
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown)  {
                        alert("Couldn't update quote " + quoteID + "; error=\n\n" + errorThrown);
                    }
        });

    });


    $('#quoteForm').submit(function( e ) {                          //  click "Continue" 
    	e.preventDefault();
        var postData = $(this).serialize();

    	if ( formValidated() ) { 		
    		$.ajax({
	            type: "POST",
		            url: myURL + 'quotes/create',
		            data: postData,
		            success: function(results)  {
                        if ( results != FAILURE ) {
    		            	var q = results.split('|');
    		            	quoteId = q[0];
    		            	quoteNo = q[1];
                            $('#quoteForm_Terms_QuoteID').val(quoteId); // for Terms form...

    		            	console.log('quoteId=['+quoteId+'], quoteNo=['+quoteNo+']');
                            alert('New quote created - no. '+quoteNo);

    		            	$('#form_QuoteID').val(quoteId);
    		            	continueQuote(quoteNo);
                        }
		            }
	        });
    	}
    	else {
    			alert("Client Validation: missing required field(s)...");
    	}
	});



     $('#quoteForm_Terms').submit(function( event ) {           //  click "Save Quote" 
        event.preventDefault();
        // var postData = $(this).serialize();

        var quoteID = $('#form_QuoteID').val();
        var postData = $('#quoteForm_Terms').serialize();
        console.log('quoteForm_Terms serialized: ' + postData);

        $.ajax({
        type: "POST",
            url: myURL + 'quotes/update/' + quoteID ,
            data: postData,
            success: function(results)  {
                if ( results == SUCCESS ) {
                    console.log('Quote terms updated.');
                    alert('Quote has been updated.');
                }
                else {
                    console.log('Quote terms NOT updated...');
                }
            }
        });

        window.location = myURL + 'quotes/index' ;




    });





    
    // $( "#quoteForm" ).on( "submit", function( event ) {
    //     var quoteID = $('#form_QuoteID').val();
    //     event.preventDefault();

    //     var myData = $( this ).serialize();
    //     console.log( "Serialize form data: " + myData );

    //     $.ajax({
    //         type: "POST",

    //             url: myURL + 'quotes/update/' + quoteID,
    //             data: myData,

    //             success: function(results)  {
    //                 alert("Quote has been created AND updated with terms...");
    //             }
    //     });

    //      window.location = myURL + 'quotes/index' ;





    // });


    // $('#quoteForm_Terms').submit(function( event ) {
    //       alert('via submit() - Savings terms...');
    //       event.preventDefault();

    //       var postData = $(this).serialize();
    //       console.log('quoteForm_Terms serialized from submit: ' + postData);


    // });



    // // ------------------------------------------------------------------
    // $('#div_SubmitDone > input').on('click', function () {
    //     $(window).unbind('beforeunload');
    //     alert('Savings terms...');


    //     var quoteID = $('#form_QuoteID').val();

    //     var data = {
    //         TermsUpdate:       1,
    //         quote_Terms:       $('#quote_Terms').val(),
    //         quote_CustAck:     $('#quote_CustAck').val(),
    //         quote_RISL:        $('#quote_RISL').val(),
    //         quote_MfgLeadTime: $('#quote_MfgLeadTime').val(),
    //         quote_Notes:       $('#quote_Notes').val()
    //     };

    //     var postData = $('#quoteForm_Terms').serialize();
    //     console.log('quoteForm_Terms serialized: ' + postData);
    //     console.log('data: ' + data);
    //     return false;




    //     $.ajax({
    //         type: "POST",
    //             url: myURL + 'quotes/update/' + quoteID ,
    //             data: postData,
    //             //data: data,
    //             success: function(results)  {
                  
    //             }
    //     });

    //      window.location = myURL + 'quotes/index' ;

    // });





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
        return false;
    });




    // ----------------------------------------------------- edit item
    $('[id^=item_edit_]').on('click', function() {
        var itemID = getID($(this));  

        var returnUrl = $('#returnUrl').val();
        var u = myURL + "stockItems/update/" + itemID + '?returnUrl=' + returnUrl ;

        console.log('url=' +  u);
        window.location.replace(u);
    });




    // ----------------------------------------------------- Select from available customers
    $('#Customers_select').on('change', function () { 
        var custID = $(this).val();
        resetCustomerForm();

        $.ajax({
            type: 'GET',
            url: myURL + 'customers/find?id='+custID ,
            success: function (ret) {
                display_Customer(ret);
            }
        });
    });
   
    // ----------------------------------------------------- Select from available contacts
    $('#Contacts_select').on('change', function () { 
        var contactID = $(this).val();
        resetContactForm();
       
        $.ajax({
            type: 'GET',
            url: myURL + 'contacts/find?id='+contactID ,
            success: function (ret) {
                display_Contact(ret);
            }
        });
    });


    $('[id^=quote_approve_]').on('click', function() { //   Approve quote  
        var quoteID = getThisID( $(this) ); 

        if ( confirm("Are you sure you want to approve this quote?" ) ) {
            $.ajax({
                type: 'GET',
                url: myURL + 'quotes/approve?id='+quoteID ,
                success: function (ret) {
                    if ( ret == SUCCESS) {
                       // alert('Quote approved.');
                        window.location = myURL + 'quotes/index?a=1'; 
                    }
                    else {
                        alert('Error: could not approve quote - see Admin. (ret=['+ret+']');
                    }
                }
            });
        }
    });


    $('[id^=quote_reject_]').on('click', function() { //   Reject quote  
        var quoteID = getThisID( $(this) ); 


        if ( confirm("Are you sure you want to reject this quote?" ) ) {
            $.ajax({
                type: 'GET',
                url: myURL + 'quotes/reject?id='+quoteID ,
                success: function (ret) {
                    if ( ret == SUCCESS ) {
                       // alert('Quote rejected.');
                        window.location = myURL + 'quotes/index?a=1'; 
                    }
                    else {
                        alert('Error: could not reject quote - see Admin. (ret=['+ret+']');
                    }
                }
            });
        }
    });

    $('[id^=quote_view_]').on('click', function() { //   View quote  
    	var quoteID = getThisID( $(this) ); 
    	window.location = myURL + 'quotes/view?id='+quoteID ;
    });

    $('[id^=quote_edit_]').on('click', function() { //   Edit quote  
        var quoteID = getThisID( $(this) ); 
        window.location = myURL + 'quotes/update/' + quoteID ; 
    });



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

    });
  
    $('#quotes_table').on('click', function() {  //  re-attach event handler 
    	// have to attach click event handler; after paging, 
    	// dataTables reloads the tableBody and all attached event handlers

    	// do this for quote_view_xx, edit_quote_xx, delete_quote_xx

		$('[id^=quote_view_]').on('click', function() {
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
  		var item      = encodeURIComponent(searchFor.trim().toUpperCase() );  // >>>>>>>  THE ONLY PLACE WE NEED TO USE "encodeURIComponent()"

        var url       =  myURL + 'parts/search?item=' + item + '&by=' + searchBy; 
        console.log('url=' + url);    

  		if ( searchFor.trim() && searchBy ) {
  			$('#ajax_loading_image').show();
            $.ajax({
	                type: 'GET',
	                url: url,
	                success: function (results) {
	                	displayPartLookupResults(results);
                        $('#ajax_loading_image').hide();
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
    });


    $('#section_CustomerContact > div.quote_section_heading > span.open_close').on('click', function() {  // toggle  section
		if ( $(this).html() == '+') {
			$(this).html('−'); 
		}
		else {
			$(this).html('+');
		}
		$('#section_CustomerContact > div.my_container').fadeToggle(250);   // toggle();
   	});

    $('#section_TermsConditions > div.quote_section_heading > span.open_close').on('click', function() {  // toggle  section
        if ( $(this).html() == '+') {
            $(this).html('−'); 
        }
        else {
            $(this).html('+');
        }
        $('#section_TermsConditions > div.my_container').fadeToggle(250);   // toggle();
    });

   // $('#section_TermsConditions > div.quote_section_heading > span.open_close').trigger('click'); // default=closed





    //---------------------------------------------------------------------------------------------------------------------
    //-------- Functions --------------------------------------------------------------------------------------------------    
    //---------------------------------------------------------------------------------------------------------------------


    function getID(that) {
        var tmp =  $(that).attr('id');
        var thisId = /\w+[_delete_|_edit_]\w+_(.+)$/i.exec( tmp );
        return RegExp.$1;
    }


    function resetCustomerForm() {
        $('#Customers_state_id').replaceWith("<input type='text'               id='Customers_state_id'               name='Customers[state_id]'                readonly='readonly'>");
        $('#Customers_country_id').replaceWith("<input type='text'             id='Customers_country_id'             name='Customers[country_id]'              readonly='readonly'>");
        $('#Customers_region_id').replaceWith("<input type='text'              id='Customers_region_id'              name='Customers[region_id]'               readonly='readonly'>");
        $('#Customers_customer_type_id').replaceWith("<input type='text'       id='Customers_customer_type_id'       name='Customers[customer_type_id]'        readonly='readonly'>");
        $('#Customers_inside_salesperson_id').replaceWith("<input type='text'  id='Customers_inside_salesperson_id'  name='Customers[inside_salesperson_id]'   readonly='readonly'>");
        $('#Customers_outside_salesperson_id').replaceWith("<input type='text' id='Customers_outside_salesperson_id' name='Customers[outside_salesperson_id]'  readonly='readonly'>");
        $('#Customers_parent_id').replaceWith("<input type='text'              id='Customers_parent_id'              name='Customers[parent_id]'               readonly='readonly'>");
        $('#Customers_tier_id').replaceWith("<input type='text'                id='Customers_tier_id'                name='Customers[tier_id]'                 readonly='readonly'>");
        $('#Customers_territory_id').replaceWith("<input type='text'           id='Customers_territory_id'           name='Customers[territory_id]'            readonly='readonly'>");

        $('[id^=Customers_]').val('');
        $('[id^=Customers_]').attr('readOnly', 'readonly');
    }

    function resetContactForm() {
        $('#Contacts_state_id').replaceWith("<input type='text'   id='Contacts_state_id'     name='Contacts[state_id]'   readonly='readonly'>");
        $('#Contacts_country_id').replaceWith("<input type='text' id='Contacts_country_id'   name='Contacts[country_id]' readonly='readonly'>");

        $('[id^=Contacts_]').val('');
        $('[id^=Contacts_]').attr('readOnly', 'readonly');
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
                                    quote_id:           quoteID,
                                    part_no:            $('#part_no').text(),
                                    approval_needed:    approvalNeeded,

                                    manufacturer:       $('#manufacturer').val(),   
                                    qty_Available:      $('#total_qty_for_part').val(),

                                    qty_1_24:           $('#qty_1_24').val(),       // val == inputs
                                    qty_25_99:          $('#qty_25_99').val(),
                                    qty_100_499:        $('#qty_100_499').val(),
                                    qty_500_999:        $('#qty_500_999').val(),
                                    qty_1000_Plus:      $('#qty_1000_Plus').val(),  
                                    qty_Base:           $('#qty_Base').val(),
                                    qty_Custom:         $('#qty_Custom').val(), 

                                    price_1_24:         $('#price_1_24').text().replace('$', ''),       // text == spans
                                    price_25_99:        $('#price_25_99').text().replace('$', ''),  
                                    price_100_499:      $('#price_100_499').text().replace('$', ''),
                                    price_500_999:      $('#price_500_999').text().replace('$', ''),        
                                    price_1000_Plus:    $('#price_1000_Plus').text().replace('$', ''),          
                                    price_Base:         $('#price_Base').text().replace('$', ''),   

                                    price_Custom:       $('#price_Custom').val().replace('$', ''),      
                                    comments:           $('#comments').val()
                                };

                                // dialog.js
                                $.ajax({
                                        url: myURL + 'quotes/partsUpdate?from=iq2_main_js',
                                        type: 'POST',
                                        data: info, 
                                        dataType: "json",
                                        success: function(data) {
                                            console.log("iq2_main_js, AJAX Post: Success - item_id=" + data.item_id);
                                            alert("Your Customer Quote has been updated.");
                                        },
                                        error: function (jqXHR, textStatus, errorThrown)  {
                                            console.log("iq2_main_js, AJAX Post: FAIL! error:"+errorThrown);
                                            alert("Your Customer Quote could NOT be updated - see Admin (iq2_main_js)\n\nERROR=" + errorThrown);
                                        } 
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
            pr = pr.replace('$','');    pr = pr.replace(',',''); 
        }
        if (q) {
            q = q.replace('$','');  q = q.replace(',',''); q = Math.floor(q);
        }

        return Number(pr) * Number(q);
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


    $(function() {  // Search for either Customer or Contact using typeahead, autocompletion 
        $( "#search_typeahead" ).autocomplete({
            source: searchURL,
            minLength: 4, 
            close: function() {
                $('#search_typeahead').val(""); 
            },
            select: function(event,ui) {
                var selectID = ui.item.value;
                
                if ( ui.item.label.match(/\(\d+\)/) === null ) {   // found a contact 
                    resetContactForm();

                    $.ajax({
                        type: 'GET',
                        url: myURL + 'contacts/find?id='+selectID ,
                        success: function (contact_details) {
                        	$('[id^=Customers_]').val('');
                        	display_Contact(contact_details);

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
                    resetCustomerForm();

                    $.ajax({
                        type: 'GET',
                        url:  myURL + 'customers/find?id='+selectID ,
                        success: function (customer_details) {
                        	$('[id^=Contacts_]').val('');
                        	display_Customer(customer_details);

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


    function appendTable_CurrentParts( info, data ) {
        var images        = '';
        var itemID        = data.item_id;
        var updatingQuote =  window.location.href.match(/update/);

        if ( updatingQuote ) {
           images = "<td style='font-size: .9em; padding: 2px;'><img id='item_edit_"+itemID+"' title='Edit this item' src='/iq2/images/New/edit.png' width='16' height='16' /><img id='item_trash_"+itemID+"' title='Delete this item'  src='/iq2/images/New/trash.png' width='16' height='16' />";
       }
       else {
            images = "<td style='font-size: .9em; padding: 2px;'><img src='/iq2/images/New/blank_20x20.png' width='16' height='16' /><img src='/iq2/images/New/blank_20x20.png' width='16' height='16' />";
       }

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
            return false;
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

        console.log('** iq2_main.js:openQuoteDialog() - distributor_price_floor=' + $('#distributor_price_floor').val() );

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
										url: myURL + 'quotes/partsUpdate?from=iq2_main_js' ,
										type: 'POST',
										data: info, 
										dataType: "json",
										success: function(data, textStatus, jqXHR) {
											console.log("iq2_main_js(), AJAX Post: Success - item_id=" + data.item_id);
                                            if ( $('#selectedParts').html() === '' ) {
                                                $('#selectedParts').html(  'Item(s) added to quote: ' + $('#part_no').text());
                                            }
                                            else {
                                                $('#selectedParts').append(  ', ' + $('#part_no').text());
                                            }

                                            appendTable_CurrentParts(info, data);
										},
										error: function (data, textStatus, errorThrown)  {
											console.log("AJAX Post: FAIL! error:"+errorThrown);
                                            alert("Your Customer Quote could NOT be updated ("+data.item_id+") - see Admin (iq2_main_js)\n\nERROR=" + errorThrown);
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
        var item   = encodeURIComponent(partNo.trim().toUpperCase());    // >>>>>>>  THE ONLY PLACE WE NEED TO USE "encodeURIComponent()"
        var url    = myURL + 'parts/search?item=' +  item + '&dialog=1';    
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

        // this is where a click on 'rowID_' is detected...
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

    	$('#heading_container_left').hide();
    	$('#selection_container').hide();
    	$('#div_ContinueReset').hide();
        $('#section_PartsLookup').show();

        $('#div_SubmitDone').show();

        $('#section_CustomerContact > div.quote_section_heading > span.open_close').show()
        $('#section_TermsConditions > div.quote_section_heading > span.open_close').show()
		$('#section_PartsLookup     > div.quote_section_heading > span.open_close').show()
    }


    function consoleDisplayFormFields(f) {
        $.each( f, function(i,f) {
            $.each( f, function( k,v) {
               // console.log("k=["+k+"], id=["+v.id+"], name=["+v.name+"], value=["+v.value+"]");
                console.log(v.id+" =\t["+v.value+"]");
            });
        });
    }


    function formValidated() {
        consoleDisplayFormFields($('#quoteForm'));

    	if (   $('#Customers_name').val()       != '' && 
               $('#Customers_address1').val()   != '' && 
               $('#Customers_city').val()       != '' && 
               $('#Customers_country_id').val() != '' && 
               $('#Quotes_source_id').val()      > 0  && 
               $('#Contacts_first_name').val()  != '' && 
               $('#Contacts_last_name').val()   != '' && 
               $('#Contacts_email').val()       != '' && 
               $('#Contacts_title').val()       != '' &&
               $('#Contacts_phone1').val()      != '' ) {
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
        	//console.log("display_Customers_: k=["+k+"], v=["+v+"]");
           	$('#Customers_'+k).html( v );
            $('#Customers_'+k).val( v );
        });
    }

    function display_Contact(data) {
    	var o = JSON.parse(data);    
        $.each( o, function( k, v ) {
        	 // console.log("Contacts_: k=["+k+"], v=["+v+"]");
           	$('#Contacts_'+k).html( v );
            $('#Contacts_'+k).val( v );
        });
    }

    // function toggleHeading() {
    //     $('#heading_container_left').toggle();
    //     $('#span_SelectCustomer').toggle();
    //     $('#span_SelectContact').toggle();  
    //     $('#span_NewCustomer').toggle();
    //     $('#span_NewContact').toggle();
    // }

    function display_CustomerSelect( data ) {	// ok
    	$('#Customers_select').empty();
    	$('#Customers_select').append( $('<option></option>' ).val(0).html('') );;

    	var o = JSON.parse(data); 
    	$.each( o, function(k,v) {
            $('#Customers_select').append( $('<option></option>' ).val(v.id).html(v.label) );
            // console.log("display_CustomerSelect() - id=["+ v.id + "], label=[" + v.label + "]");
        });

    	$('#heading_container_left').show();
    	$('#span_SelectCustomer').show();
    	$('#span_SelectContact').hide();  
        $('#span_NewCustomer').show();
        $('#span_NewContact').hide();
        // toggleHeading();

    }

 	function display_ContactSelect( data ) {	// ok
 		$('#Contacts_select').empty();
 		$('#Contacts_select').append( $('<option></option>' ).val(0).html('') );

 		var o = JSON.parse(data); 
    	$.each( o, function(k,v) {
            $('#Contacts_select').append( $('<option></option>' ).val(v.id).html(v.label) );
            // console.log("display_ContactSelect() - id=["+ v.id + "], label=[" + v.label + "]");
        });

    	$('#heading_container_left').show();
    	$('#span_SelectCustomer').hide();
    	$('#span_SelectContact').show(); 
        $('#span_NewCustomer').hide();
        $('#span_NewContact').show();
        // toggleHeading();
    }

	function getThisID( that ) {
        return /\d+$/.exec( $(that).attr('id') );
    }

});

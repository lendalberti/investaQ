
$(document).ready(function() {

    var myURL = getAbsolutePath();      //alert('myURL=['+myURL+']');
    
    function getAbsolutePath() {
        var loc = window.location;
        var pathName = loc.pathname.substring(0, loc.pathname.lastIndexOf('/') + 1);
        return loc.href.substring(0, loc.href.length - ((loc.pathname + loc.search + loc.hash).length - pathName.length));
    }

    function autoSelectIsEnabled() {
    	return true;  // TODO: $('#autoSelect').prop("checked") == true ? true : false;	
    } 

	disableCustomerForm();
	disableContactForm();


	  //  set up UI Dialogs 
    var dialog_ViewQuoteDetails = $( "#form_ViewQuoteDetails" ).dialog({
        autoOpen: false,
        height: 820,
        width: 700,
        modal: true,
        resizable: false,
        close: function() { }
    });


    $('#reset_form').on('click', function() {
    	location.reload();
    });



    function restoreCustomerList() {

    }


    function saveCustomerList() {

    	// clone customer dropdowns
	    // save to 'lastDiv' 


	    var from = $('#customer_select');
	    var to = from.clone().prop('id', 'customer_select_ORIG');
	    $('#lastDiv').after(to);


	    // --------------------------------------------------------------------------- original
		//		    var $div = $('div[id^="klon"]:last');
						
						// Read the Number from that DIV's ID (i.e: 3 from "klon3")
						// And increment that number by 1
		//		    var num = parseInt( $div.prop("id").match(/\d+/g), 10 ) +1;
		//		    if (isNaN(num) ) {
		//		      num = 0;
		//		    }
						
						// Clone it and assign the new ID (i.e: from num 4 to ID "klon4")
		//				var $klon = $div.clone().prop('id', 'klon'+num );
						
						// Finally insert $klon wherever you want
				    //$div.after( $klon.text('klon'+num) );
		//		    $div.after( $klon );
	    // --------------------------------------------------------------------------- original
    }
   
































	// set up quote details form based on quote type
	$('#Quote_quote_type_id').on('change', function() {
		var quoteTypeID = $(this).val();
		console.log('quoteTypeID='+quoteTypeID);

		if ( quoteTypeID == 1 ) {
			$('#form_stock_details').show();
			$('#form_mfg_details').hide();
			$('#form_srf_details').hide();
		}
		else if ( quoteTypeID == 2 ) {
			$('#form_stock_details').hide();
			$('#form_mfg_details').show();
			$('#form_srf_details').hide();
		}
		else if ( quoteTypeID == 3 ) {
			$('#form_stock_details').hide();
			$('#form_mfg_details').hide();
			$('#form_srf_details').show();
		}




	});




    $('#formCustomer').submit(function( e ) {
        e.preventDefault();

        // makeSelectReadOnly('Quote_quote_type_id');
        //makeFormSelectsReadOnly();

        var url = myURL + 'create';

        if ( formValidated() ) {
        	$.ajax({
	            type: "POST",
	            url: url,
	            data: $(this).serialize(), // serializes the form's elements.
	            success: function(quoteNo)  {
	            	//alert('Ajax response - ' + quoteNo);
	            	if ( quoteNo ) {
	            		// makeFormSelectsReadOnly();
	            		continueQuote(quoteNo);
	            		// $('#showHide_form_customer_contact').trigger('click');
	            	}
	            	else {
	            		alert("Unable to continue quote process...\nCan't retrieve Quote No. - see Admin");
	            	}
	                
	            }
	        });
        }
        else {
        	alert("Missing required field(s)...");
        }
        
        return false;
    });



	function makeSelectReadOnly(s) {
		var selectValue = $('#'+s+' option:selected').text();
    	console.log('selectValue='+selectValue);

    	$('#'+s).replaceWith( "<span class='select_replacement'>"+selectValue+"</span>" );
	}

   
    function makeFormSelectsReadOnly() {
    	// get selected value, hide select, display text

    	$.each( $('select[id^=Customer_]'), function() {
    		var re = /^Customer_(.+)$/;
    		var selectName = $(this).attr('id').replace(re, '$1');
    		console.log('selectName='+selectName);
    		console.log('selected text: ' + this.selectedOptions[0].text );

    		var selectText = this.selectedOptions[0].text;
    		console.log('selected text: ' + selectText);
    		$(this).replaceWith( "<span class='select_replacement'>"+selectText+"</span>" );


    	});

/*
			var re = /(\w+)\s(\w+)/;
			var str = 'John Smith';
			var newstr = str.replace(re, '$2, $1');
			console.log(newstr);  // Smith, John
*/


  //   	$( "[id^=Customer_] option:selected" ).each(function( index ) {
  //   		var selectValue =  $( this ).text();
		//   	console.log( "selectValue: " + selectValue );

		//   	$(this).replaceWith( "<span class='select_replacement'>"+selectValue+"</span>" );
		// });

    }


    function resetCustomers() {







    }









    function continueQuote( quote_no ) {
    	$('#form_details').show();
        $('#form_parts_lookup').show();
        $('#showHide_form_customer_contact').show();
        $('.quote_section_heading').show();

		$('#button_continue').hide();
		disableCustomerForm();
		disableContactForm();

		$('#enableAutoSelect').hide();
		$('#reset_form').hide();

		$('#createNewCustomer').hide();
		$('#createNewContact').hide();
		$('#customer_select').hide();
		$('#contact_select').hide();
		$('span.select_existing').hide();

		//$('#header_QuoteNo').html('Quote No. '+quote_no);
		$('#header_PageTitle').html('Quote No. '+quote_no);
    }






    $('[id^=showHide_]').on('click', function() {
        // form_cutomer_contact  form_details form_parts_lookup  
        //var thisID = /showHide_(.+)$/.exec( $(that).attr('id') );

        var tmp = $(this).attr('id').match(/showHide_(.+)$/);
        var formName = tmp[1];
        var formID = '#'+formName;

        console.log('formID='+formID);

        if ( $(this).html() == '+') {
            $(this).html('−'); 
            $(formID).show(250);
        }
        else {
            $(this).html('+');
            $(formID).hide(250);
        }
    });
   

	$('#createNewCustomer').on('click',function() {
		// clear out all Customer_xxx fields
	    $("[id^=Customer_]").each(function() {
	    	$(this).val('');
		});
	  	enableCustomerForm(); 
	  	// assume we need to create a new contact when creating a new customer when autoSelectIsEnabled... 
	  	if ( autoSelectIsEnabled() ) {
	  		$('#createNewContact').trigger('click');
	  		$('#contact_select').hide();
	  		$('#createNewContact').hide();
	  	}

	});

	$('#createNewContact').on('click',function() {
		// clear out all Contact_xxx fields
	    $("[id^=Contact_]").each(function() {
	    	$(this).val('');
		});
		enableContactForm(); 
	});


	// -------------------------------- enable/disable Customer form
	function disableCustomerForm() {
		$("[id^=Customer_]").each(function() {
            $(this).prop('readonly', true);
            $(this).css('background-color', '#F0F0F0');  // TODO: hide dropdown and show just text
		});
	}
	function enableCustomerForm() {
		$("[id^=Customer_]").each(function() {
            if ( $(this).is('select') ) {
             	$(this).prop('disabled', false);
            }
            else {
            	$(this).prop('readonly', false);
             	$(this).css('background-color', 'white');  // TODO: hide text and show dropdown 
            }
		});
	}
	
	// -------------------------------- enable/disable Contact form
	function disableContactForm() {
		$("[id^=Contact_]").each(function() {
            $(this).prop('readonly', true);
            $(this).css('background-color', '#F0F0F0'); // TODO: hide dropdown and show just text
		});

	}
	function enableContactForm() {
		$("[id^=Contact_]").each(function() {
            if ( $(this).is('select') ) {
             	$(this).prop('disabled', false);
            }
            else {
            	$(this).prop('readonly', false);
             	$(this).css('background-color', 'white');  // TODO: hide text and show dropdown 
            }
		});
	}



    function getThisID( that ) {
        return /\d+$/.exec( $(that).attr('id') );
    }



    // prefill out customer form everytime customer is selected
    $('#customer_select').on('change', function() {
    	if ( this.selectedIndex > 0 ) {
			$('#contact_select').show();
		  	$('#createNewContact').show();

		  	if ( autoSelectIsEnabled() ) {
		  		$("[id^=Contact_]").each(function() {
		    		$(this).val('');
				});
		  	}

		  	disableContactForm();

    		var custID = $(this).val();
    		var find_cust_url     = myURL + '../customers/find?id=' + custID;
    		var find_contacts_url = myURL + '../contacts/findbycust?id=' + custID;
    		this.selectedIndex = 0;

			$.ajax({
			    url: find_cust_url,
			    type: 'GET',
			    success: function(result) {
				    var r = JSON.parse(result);
			        $.each( r, function(k,v) {
			        	$('#Customer_'+k).val(v);

			        	if ( $('#Customer_'+k).is('select') ) {
			        		var selectedVal = $('#Customer_'+k+' option:selected').val();
			        		$('#Customer_'+k).prop('disabled', 'disabled');
			        		$('#Customer_'+k).append("<input type='hidden' id='Customer_"+k+"' name='Customer["+k+"]' value='"+selectedVal+"' >");
			        	}

			        	//console.log('Disabling customer form field: '+k);
			        	$('#Customer_'+k).prop('readonly', true);
        				$('#Customer_'+k).css('background-color', '#F0F0F0');  
			        });
			        // prefill Contact dropdown with contacts for this customer ONLY if AutoSelect_Enabled
				    if ( autoSelectIsEnabled() ) {
				    	$.ajax({
						    url: find_contacts_url,
						    type: 'GET',
						    success: function(result) {
						        var r = JSON.parse(result);

						        $('#contact_select').empty();
						        $('#contact_select').append( $('<option></option>' ).val(0).html('Select contact'));
						        if ( r ) {
							        $.each( r, function(kk,rr) {
							        	$.each( rr, function(k,v) {
							        		$('#contact_select').append( $('<option></option>' ).val(k).html(v));
							        	})
							        });
							        if ( r.length == 1 ) {   // if only 1 contact, prefill form fields...
							        	$("#contact_select").prop("selectedIndex", 1);
						        		$("#contact_select").trigger('change');
							        }
							    }
						    }
						});
				    }
			    }
			});
    	}
    	
    });


  	// fill out contact form everytime contact is selected
    $('#contact_select').on('change', function() {
    	if ( this.selectedIndex > 0 ) {
	    	var contactID = $(this).val();
	    	// var url = myURL + '../contacts/find?id=' + contactID;
	    	
	    	var find_contact_url  = myURL + '../contacts/find?id=' + contactID;
    		var find_cust_url     = myURL + '../customers/findbycontact?id=' + contactID;

	    	this.selectedIndex = 0;

			$.ajax({
			    url: find_contact_url,
			    type: 'GET',
			    success: function(result) {
			        var r = JSON.parse(result);
			        $.each( r, function(k,v) {
			        	$('#Contact_'+k).val(v);

			        	if ( $('#Contact_'+k).is('select') ) {
			        		var selectedVal = $('#Contact_'+k+' option:selected').val();
			        		$('#Contact_'+k).prop('disabled', 'disabled');
			        		$('#Contact_'+k).append("<input type='hidden' id='Contact_"+k+"' name='Contact["+k+"]' value='"+selectedVal+"' >");
			        	}

			        	//console.log('Disabling Contact form field: '+k);
			        	$('#Contact_'+k).prop('readonly', true);
        				$('#Contact_'+k).css('background-color', '#F0F0F0');  
			        });
			        // prefill Customer dropdown with customers for this Contact ONLY if AutoSelect_Enabled
			        if ( autoSelectIsEnabled() ) {
					    $.ajax({
						    url: find_cust_url,
						    type: 'GET',
						    success: function(result) {
						        var r = JSON.parse(result);

						       // saveCustomerList();  // clone it

						        $('#customer_select').empty();
						        $('#customer_select').append( $('<option></option>' ).val(0).html('Select customer'));
						        if ( r ) {
							        $.each( r, function(kk,rr) {
							        	$.each( rr, function(k,v) {
							        		$('#customer_select').append( $('<option></option>' ).val(k).html(v));
							        	})
							        });
							    }
							    if ( r.length == 1 ) {   // if only 1 contact, prefill form fields...
							        $("#customer_select").prop("selectedIndex", 1);
						        	$("#customer_select").trigger('change');
							    }
						    }
						});
					}
			    }
			});
		}
    });



    // ----------------------------------------------------------------
    function formValidated() {
    	if (  	$('#Customer_name').val() &&
			    $('#Customer_address1').val() &&
			    $('#Customer_city').val() &&
			    $('#Customer_country_id').val() > 0 &&
			    $('#Customer_region_id').val() > 0 &&
			    $('#Customer_customer_type_id').val() > 0 &&
			    $('#Customer_territory_id').val() > 0   &&
	    		$('#Contact_first_name').val()   &&
	    		$('#Contact_last_name').val()   &&
	    		$('#Contact_email').val()   &&
	    		$('#Contact_title').val()   &&
	    		$('#Contact_phone1').val()  &&
	    		$('#Quote_quote_type_id').val()  > 0   &&
	    		$('#Quote_source_id').val()  > 0  &&
	    		$('#Quote_level_id').val()  )   {
    		return true;
    	}
    	return false;
    }





    // ---------------------------------------------------- Create Quote
    $('#add_quote').on('click', function() {
        window.location = myURL + 'create';
    });


    // ---------------------------------------------------- View Quote
    $('[id^=view_quote_]').on('click', function() {
        var quoteID = getThisID( $(this) ); 
        var quoteNo = $(this).closest('td').next('td').html();

        console.log('Viewing quote number = ' + quoteNo);
        console.log('url='+myURL + '../quotes/view?id=' + quoteID);

		$.ajax({
		    url:  myURL + '../quotes/view?id=' + quoteID,
		    type: 'GET',
		    success: function(result) {
		    	$('#form_ViewQuoteDetails').html(result);
		    },
            error: function (jqXHR, textStatus, errorThrown)  {
                $('#form_ViewQuoteDetails').html("Can't view quote details; error=" + errorThrown);
            }
        });

        dialog_ViewQuoteDetails.dialog('option', 'title', 'Quote No. ' + quoteNo); 
        dialog_ViewQuoteDetails.dialog( "open" );
        return false; 
    });

    // ---------------------------------------------------- Edit Quote
    $('[id^=edit_quote_]').on('click', function() {
        var quoteID = getThisID( $(this) ); 
        window.location = myURL + 'update?id='+quoteID;
    });

    // ---------------------------------------------------- Delete Quote
    $('[id^=delete_quote_]').on('click', function() {
        var quoteID = getThisID( $(this) ); 

        if ( confirm('Are you sure you want to delete this quote?') ) {
                    $.ajax({
                        url: myURL +  'delete/' + quoteID,
                        type: 'POST',
                        success: function(data, textStatus, jqXHR) {
                            window.location.replace( myURL + 'index');
                        },
                        error: function (jqXHR, textStatus, errorThrown)  {
                            alert("Couldn't delete quote " + quoteID + "; error=\n\n" + errorThrown);
                        }
                    });
        }

        return false;
       
    });


});





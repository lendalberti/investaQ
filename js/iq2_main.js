
$(document).ready(function() {

    var myURL = getAbsolutePath();      //alert('myURL=['+myURL+']');

    function getAbsolutePath() {
        var loc = window.location;
        var pathName = loc.pathname.substring(0, loc.pathname.lastIndexOf('/') + 1);
        return loc.href.substring(0, loc.href.length - ((loc.pathname + loc.search + loc.hash).length - pathName.length));
    }

	disableCustomerForm();
	disableContactForm();


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












    function continueQuote( quote_no ) {
    	$('#form_details').show();
        $('#form_parts_lookup').show();
        $('#showHide_form_customer_contact').show();
        $('.quote_section_heading').show();

		$('#button_continue').hide();
		disableCustomerForm();
		disableContactForm();  
		//makeFormSelectsReadOnly();

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
	  	// assume we need to create a new contact when creating a new customer... 
	  	$('#createNewContact').trigger('click');
	  	$('#contact_select').hide();
	  	$('#createNewContact').hide();

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

            if ( $(this).is('select') ) { 
            	console.log*
            }
            else {

            }
           
		});
	}
	function enableCustomerForm() {
		$("[id^=Customer_]").each(function() {
            $(this).prop('readonly', false);
             if ( !$(this).is('select') ) {
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
            $(this).prop('readonly', false);
           
            if ( !$(this).is('select') ) {
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

		  	$("[id^=Contact_]").each(function() {
		    	$(this).val('');
			});
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
			        	console.log('Disabling customer form fields...');
			        	disableCustomerForm();  
			        });
			        // prefill Contact dropdown with contacts for this customer ONLY
				    $.ajax({
					    url: find_contacts_url,
					    type: 'GET',
					    success: function(result) {
					        console.log("result="+result);
					        var r = JSON.parse(result);

					        $('#contact_select').empty();
					        $('#contact_select').append( $('<option></option>' ).val(0).html('Select contact'));
					        $.each( r, function(kk,rr) {
					        	$.each( rr, function(k,v) {
					        		console.log("k=["+k+"], v=["+v+"]");
					        		$('#contact_select').append( $('<option></option>' ).val(k).html(v));
					        	})
					        	
					        });
					    }
					});


			    }
			});
    	}
    	
    });


  	// fill out contact form everytime contact is selected
    $('#contact_select').on('change', function() {
    	if ( this.selectedIndex > 0 ) {
	    	var contactID = $(this).val();
	    	var url = myURL + '../contacts/find?id=' + contactID;
	    	this.selectedIndex = 0;

			$.ajax({
			    url: url,
			    type: 'GET',
			    success: function(result) {
			        var r = JSON.parse(result);
			        $.each( r, function(k,v) {
			        	$('#Contact_'+k).val(v);
			        	disableContactForm();  

			        	// prefill Customer dropdown with contacts for this contact ONLY







			        });
			    }
			});
		}
    });






    $('#button_continue_NEW').on('click', function( event ) {
       alert( "form submitted: " +  $( this ).serialize() );
        event.preventDefault();

         // var url = myURL + 'create' ; // the script where you handle the form input.
         // console.log('submit create to: ' + url);
         // console.log( "form serializeArray: " +  $( this ).serializeArray() );
         return false;

        $.ajax({
               type: "POST",
               url: url,
               data: $("#idForm").serialize(), // serializes the form's elements.
               success: function(data)
               {
                   alert(data); // show response from the php script.
               }
             });

        e.preventDefault(); // avoid to execute the actual submit of the form.
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





    // ----------------------------------------------------------------
   //  function continueQuote_OLD() {
   //      //$('#button_continue').on('click', function() {

	  //   	if ( $('#customer_select').val() > 0 ) { // existing customer...
	  //   		//alert('EXISTING: customer id=' + $('#Customer_id').val() + ' and contact id=' + $('#Contact_id').val() );

   //              // data = fields from "form_cutomer_contact"
   //              var formData = $('#cust_form').serialize();
   //              console.dir("formData=" + formData);

   //              // $.ajax({
   //              //       url: myURL + 'create',
   //              //       type: 'POST',
   //              //       data: formData,  // {customer_id:$('#Customer_id').val(), contact_id:$('#Contact_id').val()  },  
   //              //       success: function(data, textStatus, jqXHR) {
   //              //             // console.log("AJAX quote submitted for approval: Success!");
   //              //             // window.location.replace( URL + "index");
   //              //       },
   //              //       error: function (jqXHR, textStatus, errorThrown)  {
   //              //             // console.log("AJAX quote submitted for approval: Fail");
   //              //             // alert("Sorry - could NOT submit this quote for approval; see Admin.");
   //              //       } 
   //              // });
                
	  //   	}
	  //   	else {                                    // NEW customer
	  //   		alert('NEW: customer (need to make ajax call first to record this quote)' );

	  //   	}

   //          $('#form_details').show();
   //          $('#form_parts_lookup').show();
   //          $('#showHide_form_customer_contact').show();
   //          $('.quote_section_heading').show();

			// $('#button_continue').hide();
			// disableCustomerForm();
			// disableContactForm();  

			// $('#createNewCustomer').hide();
			// $('#createNewContact').hide();
			// $('#customer_select').hide();
			// $('#contact_select').hide();
			// $('span.select_existing').hide();
	  //   }

   //      // create quote record with just customer & contact information...

   //  	return false;
   //      // });
   //  }



    // ---------------------------------------------------- Create Quote
    $('#add_quote').on('click', function() {
        window.location = myURL + 'create';
    });


    // ---------------------------------------------------- View Quote
    $('[id^=view_quote_]').on('click', function() {
        var quoteID = getThisID( $(this) ); 

        alert('viewing quote id: ' + quoteID);
        return false;


        var quoteNo = $(this).closest('td').next('td').html();
        console.log('Viewing quote number = ' + quoteNo);

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





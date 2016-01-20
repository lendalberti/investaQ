$(document).ready(function() {
    var myURL = getAbsolutePath();    // quotes: Path = [ http://localhost/iq2/index.php/quotes/ ]


    function getAbsolutePath() {
        var loc = window.location;
        var pathName = loc.pathname.substring(0, loc.pathname.lastIndexOf('/') + 1);
        return loc.href.substring(0, loc.href.length - ((loc.pathname + loc.search + loc.hash).length - pathName.length));
    }

	disableCustomerForm();
	disableContactForm();



    //$('#formCustomer').submit(function( e ) {
    $('form').submit(function( e ) {
        e.preventDefault();
        var url = myURL + 'create';
        $.ajax({
            type: "POST",
            url: url,
            data: $(this).serialize(), // serializes the form's elements.
            success: function(response)  {
               continueQuote();
               alert(response); 
            }
        });

        
        return false;
    });








    $('[id^=showHide_]').on('click', function() {
        // form_cutomer_contact  form_details form_parts_lookup  
        //var thisID = /showHide_(.+)$/.exec( $(that).attr('id') );

        var tmp = $(this).attr('id').match(/showHide_(.+)$/);
        var formName = tmp[1];
        var formID = '#'+formName;



        console.log('formID='+formID);

        if ( $(this).html() == '+') {
            $(this).html('−'); 
            $(formID).show();
        }
        else {
            $(this).html('+');
            $(formID).hide();
        }
    });
   

	$('#createNewCustomer').on('click',function() {
	    $("[id^=Customer_]").each(function() {
	    	$(this).val('');
	    	$('#customer_select').val('');
		  	enableCustomerForm(); 
		});
	});

	$('#createNewContact').on('click',function() {
	    $("[id^=Contact_]").each(function() {
	    	$(this).val('');
	    	$('#contact_select').val('');
		  	enableContactForm(); 
		});
	});

	function disableCustomerForm() {
		$("[id^=Customer_]").each(function() {
	  		// $(this).prop('disabled', 'disabled'); 
            $(this).prop('readonly', true);
		});

	}
	function enableCustomerForm() {
		$("[id^=Customer_]").each(function() {
	  		//$(this).prop('disabled', false);
            $(this).prop('readonly', false);
		});
	}


	function disableContactForm() {
		$("[id^=Contact_]").each(function() {
	  		// $(this).prop('disabled', 'disabled');
            $(this).prop('readonly', true);
		});

	}
	function enableContactForm() {
		$("[id^=Contact_]").each(function() {
	  		// $(this).prop('disabled', false);
            $(this).prop('readonly', false);
		});
	}



    //  set up UI Dialogs 
    var dialog_ViewQuoteDetails = $( "#form_ViewQuoteDetails" ).dialog({
        autoOpen: false,
        height: 820,
        width: 700,
        modal: true,
        resizable: false,
        close: function() { }
    });


    function getThisID( that ) {
        return /\d+$/.exec( $(that).attr('id') );
    }



    // fill out customer form everytime customer is selected
    $('#customer_select').on('change', function() {
    	var custID = $(this).val();
    	var url = myURL + '../customers/find?id=' + custID;
		$.ajax({
		    url: url,
		    type: 'GET',
		    success: function(result) {
		        var r = JSON.parse(result);
		        $.each( r, function(k,v) {
		        	$('#Customer_'+k).val(v);
		        	disableCustomerForm();  
		        });
		    }
		});
    });


  	// fill out contact form everytime contact is selected
    $('#contact_select').on('change', function() {
    	var contactID = $(this).val();
    	var url = myURL + '../contacts/find?id=' + contactID;
		$.ajax({
		    url: url,
		    type: 'GET',
		    success: function(result) {
		        var r = JSON.parse(result);
		        $.each( r, function(k,v) {
		        	$('#Contact_'+k).val(v);
		        	disableContactForm();  
		        });
		    }
		});
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


   
    function continueQuote() {
        //$('#button_continue').on('click', function() {

	    if ( $('#Customer_name').val() &&
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
	    		$('#Contact_phone1').val()  )   {

	    	if ( $('#customer_select').val() > 0 ) { // existing customer...
	    		//alert('EXISTING: customer id=' + $('#Customer_id').val() + ' and contact id=' + $('#Contact_id').val() );




                // data = fields from "form_cutomer_contact"
                var formData = $('#cust_form').serialize();
                console.dir("formData=" + formData);

                // $.ajax({
                //       url: myURL + 'create',
                //       type: 'POST',
                //       data: formData,  // {customer_id:$('#Customer_id').val(), contact_id:$('#Contact_id').val()  },  
                //       success: function(data, textStatus, jqXHR) {
                //             // console.log("AJAX quote submitted for approval: Success!");
                //             // window.location.replace( URL + "index");
                //       },
                //       error: function (jqXHR, textStatus, errorThrown)  {
                //             // console.log("AJAX quote submitted for approval: Fail");
                //             // alert("Sorry - could NOT submit this quote for approval; see Admin.");
                //       } 
                // });
                




	    	}
	    	else {                                    // NEW customer
	    		alert('NEW: customer (need to make ajax call first to record this quote)' );

	    	}

            $('#form_details').show();
            $('#form_parts_lookup').show();
            $('#showHide_form_cutomer_contact').show();
            $('.quote_section_heading').show();

			$(this).hide();
			disableCustomerForm();
			disableContactForm();  

			$('#createNewCustomer').hide();
			$('#createNewContact').hide();
			$('#customer_select').hide();
			$('#contact_select').hide();
			$('span.select_existing').hide();
	    }
	    else {
	    	alert('Missing required Customer and/or Contact fields...');
	    }

        // create quote record with just customer & contact information...




    	return false;
        // });
    }



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



    // set up DataTable
    var quotes_table  = $('#quotes_table').DataTable({"iDisplayLength": 10 }); 
    var results_table = $('#results_table').DataTable({"iDisplayLength": 10 }); 

        

            // dialog_ViewPartDetails.dialog('option', 'title', 'Inventory Part Lookup Details'); 
            // setupOnQuoteHistoryClick();

            // var q = JSON.parse('<?php echo $data["my_quotes"] ? $data["my_quotes"] : ""; ?>');

            // var buttons = { 
            //   "Cancel": function() { 
            //      dialog_ViewPartDetails.dialog( "close" );  
            //      return false; 
            //   },
            //   "Quote This Part": function() {
            //     if ( $('#myQuotesSelect').val() == '0' ) {
            //         alert("Select a customer quote first");
            //     }
            //     else {
            //         addToQuote(p,$('#myQuotesSelect option:selected').text());
            //     }
                
            //     return false;
            //   },
            // }

            // dialog_ViewPartDetails.dialog("option", "buttons", buttons);
            // dialog_ViewPartDetails.dialog( "open" );
            // return false; 














});

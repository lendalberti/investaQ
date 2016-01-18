$(document).ready(function() {

    var base_url = $('#base_url').val();

	disableCustomerForm();
	disableContactForm();
   

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
	  		$(this).prop('disabled', 'disabled');
		});

	}
	function enableCustomerForm() {
		$("[id^=Customer_]").each(function() {
	  		$(this).prop('disabled', false);
		});
	}


	function disableContactForm() {
		$("[id^=Contact_]").each(function() {
	  		$(this).prop('disabled', 'disabled');
		});

	}
	function enableContactForm() {
		$("[id^=Contact_]").each(function() {
	  		$(this).prop('disabled', false);
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
    	var URL = base_url + '/index.php/customers/find?id=' + custID;
		$.ajax({
		    url: URL,
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
    	var URL = base_url + '/index.php/contacts/find?id=' + contactID;
		$.ajax({
		    url: URL,
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


    $('#button_continue').on('click', function() {
    	/*
    		* Verify that customer and contact forms have been filled out...

			required customer fields: name, address1, city, country_id, region_id, customer_type_id, territory_id
			required contact fields:  first_name, last_name, email, title, phone1     

    	*/

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

		    	// when verified

		    	if ( $('#customer_select').val() > 0 ) {
		    		alert('continue with existing customer id=' + $('#Customer_id').val() + ' and contact id=' + $('#Contact_id').val() );
		    	}
		    	else {
		    		alert('continue with NEW customer (need to make ajax call first to record this quote)' );













		    	}

				$('.form_parts').show();
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






















    	
    	

    	return false;
    });



    // ---------------------------------------------------- Create Quote
    $('#add_quote').on('click', function() {
        window.location = base_url + '/index.php/quotes/create';
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
        window.location = base_url + '/index.php/quotes/update?id='+quoteID;
    });

    // ---------------------------------------------------- Delete Quote
    $('[id^=delete_quote_]').on('click', function() {
        var quoteID = getThisID( $(this) ); 
        if ( confirm("Are you sure you want to delete this quote?") ) {
            var URL = base_url + '/index.php/quotes/delete?id='+quoteID;

            $.ajax({
                url: URL,
                type: 'DELETE',
                success: function(result) {
                    alert('Quote deleted.');
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












  
// --------------------------------------------------TODO: need to fix, as this is not working for some reason; breaks the search function...

	// ------Apply the filters
	//  table.columns().every( function () {
	//      var that = this;
	//      $( 'input', this.footer() ).on( 'keyup change', function () {  
	//     // $( '#filterRow input' ).on( 'keyup change', function () { 
	//      	if ( that.search() !== this.value ) {
	//           that
	//               .search( this.value )
	//               .draw();
	//          }
	//          console.log('value='+this.value);
	// setupOnRowClick(); 
	//      });
	//  });
    // ------ Setup, add a text input to each footer cell  -- NOTE: css change puts this row at TOP of each column
    // $('#quotes_table tfoot th').each( function () {
    //     var title = $('#quotes_table thead th').eq( $(this).index() ).text();
    //     $(this).html( '<input style="width: 40px; font-size: .9em; background-color: lightgray;" type="text" />' );  
    // } );





















});

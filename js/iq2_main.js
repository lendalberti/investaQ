$(document).ready(function() {

    var myURL           = getAbsolutePath();   console.log('myURL=['+myURL+']');
    var customerPrefill = true;
    var contactPrefill  = true;
    var searchURL       = myURL + 'search';
             

    $('#reset_form').on('click', function() {
        location.reload();
    });

    $('#add_quote').on('click', function() {
        window.location = myURL + 'create';
    });

    // set up DataTable
    var QuotesTable  = $('#quotes_table').DataTable({"iDisplayLength": 10 }); 
	var ResultsTable = $('#results_table').DataTable({"iDisplayLength": 10 });

	//---------------------------------------------------------------------------------------------------------------------
    //-------- Event Handlers  --------------------------------------------------------------------------------------------    
    //---------------------------------------------------------------------------------------------------------------------
    $('#quoteForm').submit(function( e ) {  //  click "Continue"
    	e.preventDefault();
    	if ( formValidated() ) { 		
    		// console.log('formValidated() = TRUE');

    		var postData = $(this).serialize();
    		$.ajax({
	            type: "POST",
		            url: myURL + 'create',
		            data: postData,
		            success: function(quoteNo)  {
		            	// console.log('quoteNo=['+quoteNo+']');
		            	continueQuote(quoteNo);
		            }
	        });
    	}
    	else {
    			alert("Missing required field(s)...");
    	}
	});

    $('#Customer_select').on('change', function () { //  Select from available customers
        var custID = $(this).val();
        $.ajax({
            type: 'GET',
            url: '../customers/find?id='+custID,
            success: function (ret) {
                display_Customer(ret);
            }
        });
    });
   
    $('#Contact_select').on('change', function () { //  Select from available contact
        var contactID = $(this).val();
        $.ajax({
            type: 'GET',
            url: '../contacts/find?id='+contactID,
            success: function (ret) {
                display_Contact(ret);
            }
        });
    });

    $('[id^=view_quote_]').on('click', function() { //   View quote  
    	var quoteID = getThisID( $(this) ); 
    	window.location = myURL + 'view?id='+quoteID;
    })

    $('[id^=edit_quote_]').on('click', function() { //   Edit quote  
    })

    $('[id^=delete_quote_]').on('click', function() { //   Delete quote  
    })
    
    $('#quotes_table').on('click', function() {  //  re-attach event handler 
    	// have to attach click event handler; after paging, 
    	// dataTables reloads the tableBody and all attached event handlers

    	// do this for view_quote_xx, edit_quote_xx, delete_quote_xx

		$('[id^=view_quote_]').on('click', function() {
	    	var quoteID = getThisID( $(this) ); 
	    	window.location = myURL + 'view?id='+quoteID;
	    })

	    $('[id^=edit_quote_]').on('click', function() {
	    })

	    $('[id^=delete_quote_]').on('click', function() {
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

  		if ( searchFor.trim() && searchBy ) {
  			$.ajax({
	                type: 'GET',
	                url: '../parts/search?item=' + searchFor.trim().toUpperCase() + '&by=' + searchBy,
	                success: function (results) {
	                	displayPartLookupResults(results);
	                }
            });
  		}
  	})

   	$('#section_CustomerContact > div.quote_section_heading > span.open_close').on('click', function() {  // toggle Customer section
		if ( $(this).html() == '+') {
			$(this).html('−'); 
		}
		else {
			$(this).html('+');
		}
		$('#section_CustomerContact > div.my_container').toggle();
   	})

	$('#section_PartsLookup > div.quote_section_heading > span.open_close').on('click', function() {  // toggle Part Lookup section
		if ( $(this).html() == '+') {
			$(this).html('−'); 
		}
		else {
			$(this).html('+');
		}
   		$('#section_PartsLookup > div.my_container').toggle();
   	})

  



    //---------------------------------------------------------------------------------------------------------------------
    //-------- Functions --------------------------------------------------------------------------------------------------    
    //---------------------------------------------------------------------------------------------------------------------
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
                        url: '../contacts/find?id='+selectID,  // lookup details for this contact
                        success: function (contact_details) {
                        	$('[id^=Customer_]').val('');
                        	display_Contact(contact_details)

                            $.ajax({
                                type: 'GET',
                                url: '../customers/findbycontact?id='+selectID, // find contacts for this customer
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
                        url: '../customers/find?id='+selectID, // lookup details for this customer
                        success: function (customer_details) {
                        	$('[id^=Contact_]').val('');
                        	display_Customer(customer_details)

                            $.ajax({
                                type: 'GET',
                                url: '../contacts/findbycust?id='+selectID,  // find contacts for this customer
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

    function displayPartLookupResults(res) {
    	var a          = JSON.parse(res);
    	var partsCount = a.parts.length; 

    	if ( partsCount == 0 ) {
    		alert('Part not found; \n\nWant to create a Manufacturing Quote?');
    	}

  		ResultsTable.destroy();

    	$('#results_table tbody').empty();
    	var rows       = '';
    	for( var i=0; i<partsCount; i++ ) {
    		rows += "<tr>";
    		rows += "<td>"+ ( a.parts[i].part_number ? a.parts[i].part_number : 'n/a' )+"</td>";
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
    	ResultsTable = $('#results_table').DataTable({"iDisplayLength": 10 });
    }

    function continueQuote( quote_no ) {
    	$('#header_PageTitle').html('Quote No. '+quote_no);
    	$('#heading_container').hide();
    	$('#selection_container').hide();
    	$('#div_ContinueReset').hide();
    	$('#section_PartsLookup').show();

		$('#section_CustomerContact > div.quote_section_heading > span.open_close').show()
		$('#section_PartsLookup > div.quote_section_heading > span.open_close').show()
    }

    function formValidated() {
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
        	 // console.log("Customer_: k=["+k+"], v=["+v+"]");
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
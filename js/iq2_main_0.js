
$(document).ready(function() {

    var myURL           = getAbsolutePath();      //alert('myURL=['+myURL+']');
    var customerPrefill = true;
    var contactPrefill  = true;
    var searchURL       = myURL + 'search';

	resetCustomerForm();
	resetContactForm();
	disableCustomerForm();
	disableContactForm();

    
    function getAbsolutePath() {
        var loc = window.location;
        var pathName = loc.pathname.substring(0, loc.pathname.lastIndexOf('/') + 1);
        return loc.href.substring(0, loc.href.length - ((loc.pathname + loc.search + loc.hash).length - pathName.length));
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


    $('#reset_form').on('click', function() {
    	location.reload();
    });



	function resetCustomerForm() {
		$('[id^=Customer_]').val('');
        $('span[id^=Customer_]').remove();
        $('select[id^=Customer_]').each( function() {
			$(this).show();
			$(this).prop('disabled', 'disabled');
		});

	}



	function resetContactForm() {
		$('[id^=Contact_]').val('');
        $('span[id^=Contact_]').remove();
        $('select[id^=Contact_]').each( function() {
			$(this).show();
			$(this).prop('disabled', 'disabled');
		});
	}





    $(function() {
        $( "#search_typeahead" ).autocomplete({
            source: searchURL,
            minLength: 4, 
            close: function() {
            	$('#search_typeahead').val("");  
            },
            select: function(event,ui) {
                var selectID = ui.item.value;
                
                // if ui.item.label contains (\d+) then selectID is a customer id, else it's a contact id
                //console.log("match? " + ui.item.label.match(/\(\d+\)/) );

                if ( ui.item.label.match(/\(\d+\)/) == null ) {   // contact id
                    $.ajax({
                        type: 'GET',
                        url: '../contacts/find?id='+selectID,
                        success: function (ret) {
                    		$('#customer_span_text').hide();
                    		$('#customer_span_select').show();
                    		$('#contact_span_text').show();
							$('#contact_span_select').hide();
                            fillOutContactFields(ret);
                        },
                        error: function (jqXHR, textStatus, errorThrown)  {
                            console.log('Error in searching for contact id: '+selectID+', msg= '+errorThrown);
                        } 
                    });
                }
                else {					// customer id
                    $.ajax({
                        type: 'GET',
                        url: '../customers/find?id='+selectID,
                        success: function (ret) {
                        	$('#contact_span_text').hide();
                    		$('#contact_span_select').show();
                    		$('#customer_span_text').show();
							$('#customer_span_select').hide();
                            fillOutCustomerFields(ret);
                        },
                        error: function (jqXHR, textStatus, errorThrown)  {
                            console.log('Error in searching for customer id: '+selectID+', msg= '+errorThrown);
                        } 
                    });
                }


            }
        });
    });


	// just a temp event for testing
	$('#contact_span_select').on('click', function() {
		alert('clicked on cc...');
		showCustomerLabels(false);

		// clear all customer fields
        $('[id^=Customer_]').val('');


	});


	// function clearCustomerForm() {

	// 	console.log('clearCustomerForm()');
	// 	showCustomerLabels(false);

 //        $('[id^=Customer_]').val('');
 //        $('span[id^=Customer_]').remove();
	// }

	// function clearContactForm() {

	// 	console.log('clearContactForm()');
	// 	showContactLabels(false);

 //        $('[id^=Contact_]').val('');
 //        $('span[id^=Contact_]').remove();
	// }



	function showCustomerLabels(flag) {
		console.log('showCustomerLabels('+flag+')');
		if (flag == true) {
			// hide selects, display labels
			$('select[id^=Customer_]').each( function() {
				$(this).hide();
			});
			$('span[id^=Customer_]').each( function() {
				$(this).show();
			});
		}
		else {
			// hide labels, display selects
			$('select[id^=Customer_]').each( function() {
				$(this).show();
			});
			$('span[id^=Customer_]').each( function() {
				$(this).hide();
			});
		}
	}

	function showContactLabels(flag) {
		console.log('showContactLabels('+flag+')');
		if (flag == true) {
			// hide selects, display labels
			$('select[id^=Contact_]').each( function() {
				$(this).hide();
			});
			$('span[id^=Contact_]').each( function() {
				$(this).show();
			});
		}
		else {
			// hide labels, display selects
			$('select[id^=Contact_]').each( function() {
				$(this).show();
			});
			$('span[id^=Contact_]').each( function() {
				$(this).hide();
			});
		}
	}


    // --------------------------------------------------------
    function fillOutCustomerFields(data) {
    	console.log('fillOutCustomerFields()');
    	// clearCustomerForm();

    	resetContactForm();
    	resetCustomerForm();

        var o = JSON.parse(data);
        $.each( o, function( k, v ) {
            if ( $('#Customer_'+k).is('select') ) {
            	var selectedLabel = $('#Customer_'+k+' > option[value='+v+']').html();
            	$("<span style='font-size: .8em;' display='none;' id='Customer_"+k+"_label'>"+selectedLabel+"</span>").insertAfter('#Customer_'+k);
        	}
        	else {
        		$('#Customer_'+k).html( v );
            	$('#Customer_'+k).val( v );
        	}
        });

    	showCustomerLabels(true);
    	showContactLabels(false);
    }  


    // --------------------------------------------------------
    function fillOutContactFields(data) {
    	console.log('fillOutContactFields()');
    	// clearContactForm();

    	resetContactForm();
    	resetCustomerForm();

        var o = JSON.parse(data);
        $.each( o, function( k, v ) {
            //console.log("Contact: k=["+k+"], v=["+v+"]");

            if ( $('#Contact_'+k).is('select') ) {
            	var selectedLabel = $('#Contact_'+k+' > option[value='+v+']').html();
            	$("<span style='font-size: .8em;' display='none;' id='Contact_"+k+"_label'>"+selectedLabel+"</span>").insertAfter('#Contact_'+k);

        		// var selectedVal = $('#Contact_'+k+' option:selected').val();
        		// $('#Contact_'+k).prop('disabled', 'disabled');
        		// $('#Contact_'+k).append("<input type='hidden' id='Contact_"+k+"' name='Contact["+k+"]' value='"+selectedVal+"' >");
        	}
        	else {
        		$('#Contact_'+k).html( v );
            	$('#Contact_'+k).val( v );
        	}

        });

    	showContactLabels(true);
    	showCustomerLabels(false);
    }  






/*
    from http://www.simonbattersby.com/blog/jquery-ui-autocomplete-with-a-remote-database-and-php/



I spent some time last night struggling with jQuery UI Autocomplete. I was trying to use a remote data source, and was calling a php script to interrogate the database, no ajax. During the course of getting it to work properly, I discovered a couple of things that aren’t very clear in the documentation.

The basic javascript, lifted straight from the jQuery UI demo is:

        $("#autocomplete").autocomplete({
            source: "search.php",
            minLength: 2,       //search after two characters
            select: function(event,ui) {
                //do something
            }
        });

Fine so far. There was one major thing that fooled me. If, instead of using a php script, you use a local source, something like:

        source: [{"value":"Some Name","id":1},{"value":"Some Othername","id":2}]

then this local data is queried each time a character is entered in the required field. I assumed, therefore, 
that all I had to replicate in my search.php script, was a query to return all the values from my database. 
Wrong! I need to pass a search term to my php script in order to return only the correct subset of data. I further 
discovered that jQuery UI Autocomplete passes this data as a GET entitled ‘term’ (didn’t see this anywhere in the examples). 
So, armed with this knowledge, my php script looks like this:

        //connect to your database

        $term = trim(strip_tags($_GET['term']));             //retrieve the search term that autocomplete sends

        $qstring = "SELECT description as value,id FROM test WHERE description LIKE '%".$term."%'";
        $result = mysql_query($qstring);//query the database for entries containing the term

        while ($row = mysql_fetch_array($result,MYSQL_ASSOC))//loop through the retrieved values
        {
                $row['value']=htmlentities(stripslashes($row['value']));
                $row['id']=(int)$row['id'];
                $row_set[] = $row;//build an array
        }
        echo json_encode($row_set);//format the array into json data


Hope this explanation is useful. No demo this time, because it doesn’t seem very interesting. You can have a look 
at an integration of jQuery UI Autocomplete with a vertical slider here and see a demo here.


*/






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

		$('#reset_form').hide();

		$('#createNewCustomer').hide();
		$('#createNewContact').hide();
		$('#customer_select').hide();

        var src = $('#Quote_source_id').val();
        $('#Quote_source_id').prop('disabled', 'disabled');
        $('#Quote_source_id').append("<input type='hidden' id='Quote_source_id' name='Quote[source_id]' value='"+src+"' >");


		$('#contact_select').hide();
        $('#refresh_contacts').hide();
        $('#refresh_customers').hide();

		$('span.select_existing').hide();

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

        $('#refresh_contacts').hide();

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



    $('#refresh_customers').on('click', function() {
        $.ajax({
            url: myURL + '../customers/list',
            type: 'GET',
            success: function(result) {
                var r = JSON.parse(result);
                $('#customer_select').empty();
                $.each( r, function(k,v) {
                    $('#customer_select').append( $('<option></option>' ).val(v.id).html(v.name+', '+v.address1+', '+v.city+', '+v.country));
                });
            }
        });
    })

    $('#refresh_contacts').on('click', function() {
        $.ajax({
            url: myURL + '../contacts/list',
            type: 'GET',
            success: function(result) {
                var r = JSON.parse(result);
                $('#contact_select').empty();
                $.each( r, function(k,v) {
                    $('#contact_select').append( $('<option></option>' ).val(v.id).html(v.name));
                });
            }
        });
    })





    // prefill out customer form everytime customer is selected
    $('#customer_select').on('change', function() {
    	if ( this.selectedIndex > 0 ) {
            $('#contact_select').show();
            $('#refresh_contacts').show();
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

			        	if ( $('#Customer_'+k).is('select') ) {
			        		var selectedVal = $('#Customer_'+k+' option:selected').val();
			        		$('#Customer_'+k).prop('disabled', 'disabled');
			        		$('#Customer_'+k).append("<input type='hidden' id='Customer_"+k+"' name='Customer["+k+"]' value='"+selectedVal+"' >");
			        	}

			        	//console.log('Disabling customer form field: '+k);
			        	$('#Customer_'+k).prop('readonly', true);
        				$('#Customer_'+k).css('background-color', '#F0F0F0');  
			        });
			        // prefill Contact dropdown with contacts for this customer
                    if ( contactPrefill ) {
    			    	$.ajax({
    					    url: find_contacts_url,
    					    type: 'GET',
    					    success: function(result) {
    					        var r = JSON.parse(result);

    					        $('#contact_select').empty();
    					        $('#contact_select').append( $('<option></option>' ).val(0).html('Select contact'));
    					        if ( r ) {
                                    console.log('# of contacts found: ' + r.length);

    						        $.each( r, function(kk,rr) {
    						        	$.each( rr, function(k,v) {
    						        		$('#contact_select').append( $('<option></option>' ).val(k).html(v));
    						        	})
    						        });

    						        if ( r.length == 1 ) {   // if only 1 contact, prefill form fields...
    						        	customerPrefill = false;
                                        $("#contact_select").prop("selectedIndex", 1);
    					        		$("#contact_select").trigger('change');
    						        }
    						    }
                                else {
                                    console.log('No contacts found...');
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
			        var r = JSON.parse(result);      console.log('result from finding contact='+result);
			        $.each( r, function(k,v) {
			        	$('#Contact_'+k).val(v);
                        console.log("k=["+k+"], v=["+v+"]");

			        	if ( $('#Contact_'+k).is('select') ) {
			        		var selectedVal = $('#Contact_'+k+' option:selected').val();
			        		$('#Contact_'+k).prop('disabled', 'disabled');
			        		$('#Contact_'+k).append("<input type='hidden' id='Contact_"+k+"' name='Contact["+k+"]' value='"+selectedVal+"' >");
			        	}

			        	console.log('Disabling Contact form field: '+k);
			        	$('#Contact_'+k).prop('readonly', true);
        				$('#Contact_'+k).css('background-color', '#F0F0F0');  
			        });
			        // prefill Customer dropdown with customers for this Contact
                    if ( customerPrefill ) {
					    $.ajax({
						    url: find_cust_url,
						    type: 'GET',
						    success: function(result) {
						        var r = JSON.parse(result);

						        $('#customer_select').empty();
						        $('#customer_select').append( $('<option></option>' ).val(0).html('Select customer'));
						        if ( r ) {
                                    console.log('# of customers found: ' + r.length);

							        $.each( r, function(kk,rr) {
							        	$.each( rr, function(k,v) {
							        		$('#customer_select').append( $('<option></option>' ).val(k).html(v));
							        	})
							        });
    							    
                                    if ( r.length == 1 ) {   // if only 1 contact, prefill form fields...
                                        contactPrefill = false;
                                        $("#customer_select").prop("selectedIndex", 1);
                                       	$("#customer_select").trigger('change');
                                    }
                                }
                                else {
                                    console.log('No customers found...');
                                    alert('No customers found...');
                                }
						    }
						});
                    }
                    else {
                        console.log('No customer prefill');
                        alert('No customer prefill');
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





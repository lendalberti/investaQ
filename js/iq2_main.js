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
    var table_1 = $('#quotes_table').DataTable({"iDisplayLength": 10 }); 
	var table_2 = $('#results_table').DataTable({"iDisplayLength": 10 });

    // ---------------------------------------------------- click "Continue"
    $('#quoteForm').submit(function( e ) {
    	e.preventDefault();
    	if ( formValidated() ) { 		
    		console.log('formValidated() = TRUE');

    		var postData = $(this).serialize();
    		$.ajax({
	            type: "POST",
		            url: myURL + 'create',
		            data: postData,
		            success: function(quoteNo)  {
		            	console.log('quoteNo=['+quoteNo+']');
		            	continueQuote(quoteNo);
		            }
	        });
    	}
    	else {
    			alert("Missing required field(s)...");
    	}
	});

    // ---------------------------------------------------- Select from available customers
    $('#Customer_select').on('change', function () {
        var custID = $(this).val();
        $.ajax({
            type: 'GET',
            url: '../customers/find?id='+custID,
            success: function (ret) {
                display_Customer(ret);
            }
        });
    });

    // ---------------------------------------------------- Select from available contact
    $('#Contact_select').on('change', function () {
        var contactID = $(this).val();
        $.ajax({
            type: 'GET',
            url: '../contacts/find?id='+contactID,
            success: function (ret) {
                display_Contact(ret);
            }
        });
    });

    // ----------------------------------------------------  View quote
    $('[id^=view_quote_]').on('click', function() {
    	var quoteID = getThisID( $(this) ); 
    	window.location = myURL + 'view?id='+quoteID;
    })

 	$('input').keypress(function(event) {   // 'Enter' key acts like Go button
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
	                	// parts = JSON.parse(results);
	                	// console.log( 'Total quantity for part: ' + parts.parts[0].total_qty_for_part );
	                	displayPartLookupResults(results);
	                }
            });
  		}
  	})

   





    //---------------------------------------------------------------------------------------------------------------------
    //-------- Functions --------------------------------------------------------------------------------------------------    
    //---------------------------------------------------------------------------------------------------------------------

    function displayPartLookupResults(res) {
    	var a          = JSON.parse(res);
    	var partsCount = a.parts.length; 
    	var rows       = '';


    	$.each( a.parts, function(index,value) {
    		console.log( index,value );
    	});

    	for( var i=0; i<partsCount; i++ ) {
    		// console.log( "************** part_number: "        + a.parts[i].part_number + ", index="+i);

    		// console.log( "manufacturer: "       + a.parts[i].manufacturer );
    		// console.log( "supplier: "           + a.parts[i].supplier );
    		// console.log( "total_qty_for_part: " + a.parts[i].total_qty_for_part );

    		// console.log( "over_1000: " + a.parts[i].prices.over_1000 );
    		// console.log( "p1_24: "     + a.parts[i].prices.p1_24 );
    		// console.log( "p25_99: "    + a.parts[i].prices.p25_99 );

    		// console.log( "p100_499: "  + a.parts[i].prices.p100_499 );
    		// console.log( "p500_999: "  + a.parts[i].prices.p500_999 );

    		// console.log( "distributor_price: "  + a.parts[i].distributor_price );

    		rows += "<tr>";
    		rows += "<td>"+a.parts[i].part_number+"</td>";
    		rows += "<td>"+a.parts[i].manufacturer+"</td>";
    		rows += "<td>"+a.parts[i].supplier+"</td>";
    		rows += "<td>"+a.parts[i].total_qty_for_part +"</td>";

    		rows += "<td>"+accounting.formatMoney(a.parts[i].prices.over_1000)+"</td>";
    		rows += "<td>"+accounting.formatMoney(a.parts[i].prices.p1_24) +"</td>";
    		rows += "<td>"+accounting.formatMoney(a.parts[i].prices.p25_99) +"</td>";
    		rows += "<td>"+accounting.formatMoney(a.parts[i].prices.p100_499) +"</td>";
    		rows += "<td>"+accounting.formatMoney(a.parts[i].prices.p500_999) +"</td>";
    		rows += "<td>"+accounting.formatMoney(a.parts[i].distributor_price) +"</td>";
    		rows += "</tr>";
    	}

    	$('#results_table tr:last').after(rows);



	/* 
			< ? php 
					setlocale(LC_MONETARY, 'en_US.UTF-8');    // accounting.formatMoney(12345678)
					$i = 0;
					foreach( $data['parts'] as $p ) {   
						echo "<tr id='res_$i'>";
						echo "<td>". trim($p->part_number)   . "</td>";
						echo "<td>". trim($p->manufacturer)  . "</td>";
						echo "<td>". $p->supplier            . "</td>";
						echo "<td>". number_format($p->total_qty_for_part)  . "</td>";

						echo "<td>". money_format("%6.2n", trim($p->prices->p1_24)) . "</td>";
						echo "<td>". money_format("%6.2n", trim($p->prices->p25_99)) . "</td>";
						echo "<td>". money_format("%6.2n", trim($p->prices->p100_499)) . "</td>";
						echo "<td>". money_format("%6.2n", trim($p->prices->p500_999)) . "</td>";
						echo "<td>". money_format("%6.2n", trim($p->prices->over_1000)) . "</td>";
						echo "<td>". money_format("%6.2n", trim($p->distributor_price)) . "</td>"; 
						echo "</tr>";

						$i++;
					}
					
				?>
					 -->

*/




/*

part_number
manufacturer
supplier
total_qty_for_part

prices.over_1000: 11.39
p1_24: 14.02
p25_99: 13.01
p100_499: 12.48
p500_999: 11.99
distributor_price

*/

    	// console.log( "part_number: "+a.parts[0].part_number );
    	// console.log( "distributor_price: "+a.parts[0].distributor_price );
    	// console.log( "price for 500-999: "+a.parts[0].prices.p500_999 ); 

    	// $.each( a, function( index, value ) {
    	// 	console.log('displayPartLookupResults() -  index=' + index + ", value=" + value );
    	// 	console.log('...');
    	// });




    }












    function continueQuote( quote_no ) {
    	$('#header_PageTitle').html('Quote No. '+quote_no);
    	$('#heading_container').hide();
    	$('#selection_container').hide();
    	$('#div_ContinueReset').hide();
    	$('#section_PartsLookup').show();









    }













    function formValidated() {
    	return true;









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
        	 console.log("Customer_: k=["+k+"], v=["+v+"]");
           	$('#Customer_'+k).html( v );
            $('#Customer_'+k).val( v );
        });
    }

    function display_Contact(data) {
    	var o = JSON.parse(data);    
        $.each( o, function( k, v ) {
        	 console.log("Contact_: k=["+k+"], v=["+v+"]");
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
            console.log("display_CustomerSelect() - id=["+ v.id + "], label=[" + v.label + "]");
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
            console.log("display_ContactSelect() - id=["+ v.id + "], label=[" + v.label + "]");
        });

    	$('#heading_container').show();
    	$('#span_SelectCustomer').hide();
    	$('#span_SelectContact').show(); 
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

	function getThisID( that ) {
        return /\d+$/.exec( $(that).attr('id') );
    }

});
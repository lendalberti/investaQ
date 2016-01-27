$(document).ready(function() {

    var myURL           = getAbsolutePath();   console.log('myURL=['+myURL+']');
    var customerPrefill = true;
    var contactPrefill  = true;
    var searchURL       = myURL + 'search';

    // -----------------------------------------------
	// ---------- set up UI Dialogs ------------------
	// -----------------------------------------------
	var dialog_PartPricing = $( "#form_PartPricing" ).dialog({
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

    $('#add_quote').on('click', function() {
        window.location = myURL + 'create';
    });

    // set up DataTable
    var QuotesTable  = $('#quotes_table').DataTable({"iDisplayLength": 10 }); 
    var ResultsTable = null;
	
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
		            	console.log('quoteNo=['+quoteNo+']');
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
		$('#section_CustomerContact > div.my_container').fadeToggle(250);   // toggle();
   	})

    // not sure we need this...
    //
	// $('#section_PartsLookup > div.quote_section_heading > span.open_close').on('click', function() {  // toggle Part Lookup section
	// 	if ( $(this).html() == '+') {
	// 		$(this).html('−'); 
	// 	}
	// 	else {
	// 		$(this).html('+');
	// 	}
    //   		$('#section_PartsLookup > div.my_container').fadeToggle(500);  // toggle();  // .fadeToggle(1000);
    //   	})

  



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


	function OLD_displayDialog_ViewPartDetails(p) {


        // ******************************************************************************
        // ******************************************************************************
        // *********                                                             ********
        // *********      Use this as template to be followed on the server      ********
        // *********      side in PartsController::formatDialog()                ********
        // *********      and return the formatted data in ajax call in          ********
        // *********      openQuoteDialog()                                      ********
        // *********                                                             ********
        // ******************************************************************************
        // ******************************************************************************


		var hiddenTechNotes = '';
		var spacingDiv      = "<div style='height: 20px; border: 0px solid lightblue;'></div>";
		var techNotes       = 'n/a';
		

		selected_part_number = p.part_number;  // TODO: do we need this now?

		tHeader  = "<div id='containerDiv'>";
		tHeader += "<div id='leftDiv'><span>Part Number: </span><span>"+ selected_part_number +"</span><br /></div>";
		tHeader += "<div id='rightDiv'><span>Total Qty Available: </span><span>"+ p.total_qty_for_part.toLocaleString() +"</span><br /></div>";
		tHeader += "</div>";

				// --------------------------------------------- Stock Codes table -- ORIGINAL
				var fixedHeading = "<table id='table_fixedHeading'><tr>";
				fixedHeading += "<th>Stock Code</th> ";
				fixedHeading += "<th>Warehouse</th>"; 
				fixedHeading += "<th>Date Code</th>";
				fixedHeading += "<th>&#10004;</th>";
				fixedHeading += "<th>Tech Notes</th>";
				fixedHeading += "<th>Qty Available</th>";  
				fixedHeading += "</tr></table>";		
				tStart = fixedHeading+"<div id='div_StockCodes'><table id='table_StockCodes'>"; 
				tEnd = "</table></div>";
				rows = '';
				$.each(p.stock_codes, function(i,v) {
					$.each(v.warehouses, function(ii,vv) {
						var display = ii===0 ? '' : display = 'style="color: lightgray;"';
						rows += '<tr><td class="stock_code_selected" '+display+'>'+ v.stock_code+'</td>';
						rows += '<td class="warehouse_selected">'+vv.warehouse+'</td>';
						rows += '<td class="date_code_selected">'+vv.date_code+'</td>';
						rows += '<td class="row_selected"></td>';
						if ( vv.notes == 'T' ) {
							var note = '<span class="view_tech_notes">view</span>';
							techNotes = v.tech_notes.toString();
							console.log('Tech Notes: ' + techNotes);
							hiddenTechNotes += "<input type='hidden' value='[StockCode="+v.stock_code+"]<br />"+techNotes+"' id='tech_note_"+v.stock_code+"' />"
						}
						else {
							var note = 'n/a';
						}
						rows += '<td class="notes_selected">'+note+'</td>';
						rows += '<td class="qty_available_selected">'+ vv.qty_available.toLocaleString() +'</td></tr>';
					});
				});
				tableStockCodes = tStart + rows + tEnd + hiddenTechNotes;
				// --------------------------------------------- Stock Codes table  -- ORIGINAL



		// ---------------------------------------------Pricing table 
		tStart = "<table id='table_Pricing'><caption>Pricing<caption>"; 
		tEnd = "</table>";
		rows = '';
		rows += "<tr> <th>1-24</th>  <th>25-99</th>  <th>100-499</th>  <th>500-999</th>  <th>1000+</th>  <th>Base</th> </tr>";
		rows += "<tr> <td>"+ accounting.formatMoney(p.prices.p1_24) +"</td> <td>"+accounting.formatMoney(p.prices.p25_99)+"</td> <td>"+accounting.formatMoney(p.prices.p100_499)+"</td> <td>"+accounting.formatMoney(p.prices.p500_999)+"</td> <td>"+accounting.formatMoney(p.prices.over_1000)+"</td><td>"+accounting.formatMoney(p.distributor_price)+"</td></tr>";
		tablePricing = tStart + rows + tEnd;
		
		var drawing    = p.drawing              ? p.drawing              : "<span class='tbd'>n/a</span>";
		var tech_note  = 'n/a';
		var test_level = p.se_data.test_level   ? p.se_data.test_level   : "<span class='tbd'>n/a</span>";
		var mpq        = p.mpq                  ? p.mpq                  : "<span class='tbd'>n/a</span>";
		var carrier    = p.carrier_type         ? p.carrier_type         : "<span class='tbd'>n/a</span>";


		// --------------------------------------------- Details table 
		if ( p.se_data ) {
			var pack = '';
			var pins = '';
			var desc = p.se_data.Description;
			var fam  = p.se_data.Family;
			var rohs = p.se_data.RoHS;
			var href = " href='"+p.se_data.Datasheet+"'";
			var target = " target='_blank'";
			var lifeCycle = p.se_data.Lifecycle.trim() ? "<span id='lifeCycle'>" + p.se_data.Lifecycle.trim() + "</span>" : "<span class='tbd'>n/a</span>";

			if ( typeof  p.se_data.StandardPackageName !== 'undefined') {
				pack = p.se_data.StandardPackageName.Value;
			}
			else {
				pack = "<span class='missingSEData'>No SE Data</span>";
			}
			if ( typeof  p.se_data.PinCount !== 'undefined') {
				pins = p.se_data.PinCount.Value;
			}
			else {
				pins = "<span class='missingSEData'>No SE Data</span>";
			}
		}
		else {
			desc = fam = pack = pins = rohs = lifeCycle = "<span class='missingSEData'>No SE Data</span>";
			href = " href='#' ";
			target = " ";
		}

		links = "<span id='link_QuoteHistory'><a href='#'>Quote History</a></span>";
		links +=    "<span id='link_SalesHistory'><a href='#'>Sales History</a></span>";     
		links +=    "<span id='link_DataSheet'><a " + href + target + " >DataSheet</a></span>";

		tStart = links + "<table id='table_Details'>"; 
		tEnd = "</table>";
		rows = '';
		rows += "<tr> <td>Tech Note:</td><td><span id='tech_note_span' class='tn'>"     + tech_note      + "</span></td> </tr>";		
		rows += "<tr> <td>Lifecycle:</td><td>"     + lifeCycle      + "</td> </tr>";
		rows += "<tr> <td>Manufacturer:</td><td>"  + p.manufacturer + "</td> </tr>";
		rows += "<tr> <td>Supplier:</td><td>"      + p.supplier     + "</td> </tr>";
		rows += "<tr> <td>Drawing:</td><td>"       + drawing        + "</td> </tr>";				
		rows += "<tr> <td>Description:</td><td>"   + desc           + "</td> </tr>";
		
		rows += "<tr> <td>Product Family:</td><td>"+ fam            + "</td> </tr>";
		rows += "<tr> <td>Test Level:</td><td>"    + test_level     + "</td> </tr>";	
		rows += "<tr> <td>MPQ:</td><td>"           + mpq            + "</td> </tr>";
		rows += "<tr> <td>Carrier Type:</td><td>"  + carrier        + "</td> </tr>";

		tableDetails = tStart + rows + tEnd;

		$('#form_ViewPartDetails').html( tHeader + tableStockCodes + tablePricing + spacingDiv + tableDetails);

		$('#new_quote_control_cancel').on('click', function() {
			// $('#create_customer_quote_div').toggle();
			$('#customerQuoteSelect_div').toggle();
			$('body > div.ui-dialog.ui-widget.ui-widget-content.ui-corner-all.ui-front.ui-draggable.ui-dialog-buttons > div.ui-dialog-buttonpane.ui-widget-content.ui-helper-clearfix > div').show();

		});

		$( "#Quotes_expiration_date" ).datepicker({
			dateFormat: "yy-mm-dd ",
			defaultDate: 30
		});

		// ---------------------------------------------------------- controls for new quote control popup
		dialog_ViewPartDetails.dialog('option', 'title', 'Inventory Part Lookup Details'); 
		setupOnQuoteHistoryClick();
		setupOnSalesHistoryClick();

		var buttons = { 
			"Cancel": function() { 
				dialog_ViewPartDetails.dialog( "close" );  
				return false; 
			},
			"Quote This Part": function() {
				if ( $('#myQuotesSelect').val() == '0' ) {
					alert("Select a customer quote first");
				}
				else {
					addToQuote(p);
				}
				return false;
			},
		}

		dialog_ViewPartDetails.dialog("option", "buttons", buttons);
		dialog_ViewPartDetails.dialog( "open" );
	} // end_of_function OLD_displayDialog_ViewPartDetails



	function openQuoteDialog(results) {

		$('#form_PartPricing').html(results);

		dialog_PartPricing.dialog('option', 'title', 'Inventory Part Pricing Details'); 
	
		var buttons = { 
			"Cancel": function() { 
			 dialog_PartPricing.dialog( "close" );  
			 return false; 
			},
			"Quote This Part": function() {
				alert("Adding this part to your quote...");
			  	// if ( $('#myQuotesSelect').val() == '0' ) {
			  	// 	alert("Select a customer quote first");
			  	// }
			  	// else {
			  	// 	addToQuote(p,$('#myQuotesSelect option:selected').text());
			  	// }
                 dialog_PartPricing.dialog( "close" );  
				return false;
			},
		}

		dialog_PartPricing.dialog("option", "buttons", buttons);
		dialog_PartPricing.dialog( "open" );
	}


	function displayPartDetails(that) {
		var tmp = /^rowID_(.+)$/.exec( that[0].id);
		var partNo = tmp[1];
		$.ajax({
                type: 'GET',
                url: '../parts/search?item=' + partNo.trim().toUpperCase() + '&dialog=1',
                success: function (results) {
                	openQuoteDialog(results);
                }
        });
	}

    function displayPartLookupResults(res) {
    	var a          = JSON.parse(res);
    	var partsCount = a.parts.length; 

    	if ( partsCount == 0 ) {
    		alert('Part not found; \n\nWant to create a Manufacturing Quote?');
    	}

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
		            displayPartDetails( $(this) );  //alert('from displayPartLookupResults: parts row click...');
		        });
		    }
		});
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
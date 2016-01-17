$(document).ready(function() {


    // -----------------------------------------------
    // ---------- set up UI Dialogs ------------------
    // -----------------------------------------------
    var dialog_ViewQuoteDetails = $( "#form_ViewQuoteDetails" ).dialog({
        autoOpen: false,
        height: 820,
        width: 700,
        modal: true,
        resizable: false,
        close: function() { }
    });


    // ---------------------------------------------------- Create Quote
    $('#add_quote').on('click', function() {
        alert('adding a new quote...');
    });


    // ---------------------------------------------------- View Quote
    $('[id^=view_quote_]').on('click', function() {
        var quoteNo = $(this).closest('td').next('td').html();
        console.log('Viewing quote number = ' + quoteNo);

        dialog_ViewQuoteDetails.dialog('option', 'title', 'Quote No. ' + quoteNo); 
        dialog_ViewQuoteDetails.dialog( "open" );
        return false; 
    });

    // ---------------------------------------------------- Edit Quote
    $('[id^=edit_quote_]').on('click', function() {
        var quoteNo = $(this).closest('td').next('td').html();
        console.log('Editing quote number = ' + quoteNo);

    });

    // ---------------------------------------------------- Delete Quote
    $('[id^=delete_quote_]').on('click', function() {
        var quoteNo = $(this).closest('td').next('td').html();
        console.log('Deleting quote number = ' + quoteNo);

    });

        

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













    // DataTable
    var table = $('#quotes_table').DataTable({"iDisplayLength": 10 });
    // Apply the filters
/*    

    TODO: need to fix, as this is not working for some reason...
                    table.columns().every( function () {
                        var that = this;
                        $( 'input', this.footer() ).on( 'keyup change', function () {  
                       // $( '#filterRow input' ).on( 'keyup change', function () { 
                            if ( that.search() !== this.value ) {
                                that
                                    .search( this.value )
                                    .draw();
                            }
                            console.log('value='+this.value);
                            //setupOnRowClick(); 
                        });
                            
                    });


                    // Setup - add a text input to each footer cell  -- NOTE: css change puts this row at TOP of each column
                    $('#quotes_table tfoot th').each( function () {
                        var title = $('#quotes_table thead th').eq( $(this).index() ).text();
                        $(this).html( '<input style="width: 40px; font-size: .9em; background-color: lightgray;" type="text" />' );  
                    } );
*/





















});

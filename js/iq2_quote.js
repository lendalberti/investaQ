

    //  set up UI Dialogs 
    // var dialog_ViewQuoteDetails = $( "#form_ViewQuoteDetails" ).dialog({
    //     autoOpen: false,
    //     height: 820,
    //     width: 700,
    //     modal: true,
    //     resizable: false,
    //     close: function() { }
    // });




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

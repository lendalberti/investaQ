$(document).ready(function() {

    var customerPrefill = true;
    var contactPrefill  = true;
    var myURL           = '/iq2/index.php/';
    var searchURL       = myURL + 'quotes/search';

    var dialog_PartPricing = '';
    var QuotesTable        = '';
    var tabs               = '';

    var SUCCESS      = 0;
    var FAILURE      = 1;

    var STATUS_DRAFT   = 1;
    var STATUS_PENDING = 2;

    var ItemPricing    = new Object();

    var selected_ItemQuantity     = '';
    var selected_ItemPrice        = '';
    var selected_ItemTotal        = '';
    var selected_ItemPartNo       = '';
    var selected_ItemMaxAvailable = '';
    var selected_part_number      = '';

    var lifeCycle_ACTIVE   = 'Active';
    var lifeCycle_OBSOLETE = 'Obsolete';
    var ResultsTable       = null;

    var currentItemID = '';
    // see QuoteTypes.php for these constants
    var TBD_QUOTE              = 1;
    var STOCK_QUOTE            = 2;
    var MANUFACTURING_QUOTE    = 3;
    var SUPPLIER_REQUEST_FORM  = 4;

    var TAB_Customer  = 1;
    var TAB_Terms     = 2;
    var TAB_Items     = 3;
    var TAB_Details   = 4;
    var TAB_Approvals = 5;
    var TAB_Coordinators = 6;

    // ----------------------------------------------------------------
    // these should line up with constants in Roles.php 
    //   - TODO: figure out a better way of doing this; ok for now
    // ----------------------------------------------------------------
    var ROLES_ADMIN        = 1;
    var ROLES_USER         = 2;
    var ROLES_MGR          = 3;
    var ROLES_APPROVER     = 4;
    var ROLES_PROPOSAL_MGR = 5;
    var ROLES_COORDINATOR  = 6;

    console.log('*** myURL=['+myURL+']');
    console.log('*** returnUrl=[' + $('#returnUrl').val() + ']' );
    console.log('*** current url:' + window.location.href );
    console.log('*** Cookies:' + JSON.stringify(Cookies.get()) );



    // quick and dirt funtion for truncating text with ellipses...
    String.prototype.trunc = function(n) { return this.substr(0,n-1)+(this.length>n?'&hellip;':''); };
    function truncateWithEllipses(text, max) {
        return text.substr(0,max-1)+(text.length>max?'&hellip;':''); 
    }

   
    // ----------------------------------------------------------------------------------------------
    // ---------- set up Accordian ------------------------------------------------------------------
    // ----------------------------------------------------------------------------------------------
    $(function() {
        $( "#coordinators_accordion" ).accordion({
          collapsible: true,
          heightStyle: "content"
        });
    });
    

    // ----------------------------------------------------------------------------------------------
    // ---------- set up Tabs -----------------------------------------------------------------------
    // ----------------------------------------------------------------------------------------------
    $(function() {
        $( "#QuoteView_Tabs" ).tabs({ });
    });

    $('#QuoteView_Tabs').on('tabsactivate', function(event, ui) {
        var newIndex = ui.newTab.index();
        console.log('Switched to tab '+newIndex);
        Cookies.set('current_tab', newIndex );
        $('#item_details').hide();
        $('[id^=item_row_]').find('td').removeClass('highlight_row'); 

        // if ( newIndex === TAB_Approvals-1 ) {
        //     $('#coordinators_accordion').show();
        //     // $(function() {
        //     //     $( "#coordinators_accordion" ).accordion({
        //     //       collapsible: true,
        //     //       heightStyle: "content"
        //     //     });
        //     // });
        // }
        // else {
        //     $('#coordinators_accordion').hide();
        // }

    });

    function showStockTabs() {
        $('#QuoteView_Tabs > ul > li:nth-child(1)').show();     // "Customer & Contact Information" 0
        $('#QuoteView_Tabs > ul > li:nth-child(2)').show();     // "Quote Terms"                    1
        $('#QuoteView_Tabs > ul > li:nth-child(3)').show();     // "Inventory Items"                2
        $('#QuoteView_Tabs > ul > li:nth-child(4)').hide();     // --------
        $('#QuoteView_Tabs > ul > li:nth-child(5)').hide();     // --------
        $('#QuoteView_Tabs > ul > li:nth-child(6)').hide();     // --------
    }

    function showManufacturingTabs() {
        $('#QuoteView_Tabs > ul > li:nth-child(1)').show();     // "Customer & Contact Information" 0
        $('#QuoteView_Tabs > ul > li:nth-child(2)').show();     // "Quote Terms"                    1
        $('#QuoteView_Tabs > ul > li:nth-child(3)').hide();     // --------
        $('#QuoteView_Tabs > ul > li:nth-child(4)').show();     // "Manufacturing Details"          3
        $('#QuoteView_Tabs > ul > li:nth-child(5)').show();     // "Process Approvals"              4
        $('#QuoteView_Tabs > ul > li:nth-child(6)').show();     // "Coordinators"                   5
    }


    function showTab( index ) {
        $('#QuoteView_Tabs > ul > li:nth-child('+index+')').show(); 
    }

    function hideTab( index ) {
        $('#QuoteView_Tabs > ul > li:nth-child('+index+')').hide(); 
    }

    function activateTab( index ) {
        // activate is 0 based, so use index-1
        $('#QuoteView_Tabs').tabs({ active: index-1 });
    }


    function hideAllTabs() {
        $('#QuoteView_Tabs > ul > li:nth-child(1)').hide();
        $('#QuoteView_Tabs > ul > li:nth-child(2)').hide();
        $('#QuoteView_Tabs > ul > li:nth-child(3)').hide();
        $('#QuoteView_Tabs > ul > li:nth-child(4)').hide();
        $('#QuoteView_Tabs > ul > li:nth-child(5)').hide();
    }

    var quoteID       = $('#Quotes_id').val(); 
    var quoteTypeID   = $('#quoteTypeID').val();
    var quoteTypeName = $('#quoteTypeName').val();

    console.log('*** quoteID=' + quoteID + ', quoteTypeID=' + quoteTypeID + ', quoteTypeName=' + quoteTypeName);

    if ( quoteTypeID == MANUFACTURING_QUOTE ) {
        showManufacturingTabs();
    }
    else {
        showStockTabs();
    }


    // -----------------------------------------------
	// ---------- set up UI Dialogs ------------------
	// -----------------------------------------------
	if ($("#form_PartPricing").length == 1) {
        dialog_PartPricing = $( "#form_PartPricing" ).dialog({
    		autoOpen: false,
    		// height: 1100,
    		width: 500,
    		modal: true,
    		resizable: false,
    		close: function() { }
    	});
    }

    var dialog_SalesHistory = $( "#form_SalesHistory" ).dialog({
            autoOpen: false,
            height: 500,
            width: 1200,
            modal: true,
            resizable: false,
            close: function() { }
    });



    $('#reset_form').on('click', function() {
        location.reload();
    });

    $('#add_quote').on('click', function() {
        window.location = myURL + 'quotes/create' ;
    });

    // set up DataTable on Quotes table - on home page 
    if ($("#quotes_table").length == 1) {
        QuotesTable  = $('#quotes_table').DataTable({"iDisplayLength": 10 }); 
        // ResultsTable = null;
    }

    if ( window.location.href.match(/quotes\/update/ ) || window.location.href.match(/quotes\/view/ )) {   // show original tab if cookie is set

        if ( Cookies.get('quote_added') ) {
            Cookies.remove('quote_added');
            showTab(TAB_Customer);
            showTab(TAB_Items);
            hideTab(TAB_Terms);
            activateTab(TAB_Items);
        }
        else if ( Cookies.get('current_tab') ) {
            var tabIndex = Cookies.get('current_tab');
            Cookies.remove('current_tab');

            // select tab
            $('#QuoteView_Tabs').tabs({ active: tabIndex });
            
        }
        else if ( Cookies.get('item_updated') ) {  // show Inventory Items tab if cookie is set
            Cookies.remove('item_updated');

            $('#QuoteView_Tabs').tabs({ active: 2 });
            $('#table_CurrentParts > caption').show();
        }
        else if ( Cookies.get('item_added') ) { 
            Cookies.remove('item_added');

            $('#QuoteView_Tabs').tabs({ active: 2 });
            $('#table_CurrentParts > caption').text('Item added.');
            $('#table_CurrentParts > caption').show();
        }
        else if ( Cookies.get('item_removed') ) { 
            Cookies.remove('item_removed');

            $('#QuoteView_Tabs').tabs({ active: 2 });
            $('#table_CurrentParts > caption').text('Item removed.');
            $('#table_CurrentParts > caption').show();
        }
        else if ( Cookies.get('item_cancel') ) { 
            Cookies.remove('item_cancel');

            $('#QuoteView_Tabs').tabs({ active: 2 });
            $('#table_CurrentParts > caption').text('');
            $('#table_CurrentParts > caption').show();
        }

    }

    var itemID = $('#itemID').val();

                    // <input type='hidden' id='assembly_coordinator' value='<?php echo $assembly_coordinator;  ?>'>
                    // <input type='hidden' id='test_coordinator' value='<?php echo $test_coordinator;  ?>'>
                    // <input type='hidden' id='' value='<?php echo $quality_coordinator;  ?>'>

    // -----------------------------------------------
    // ---------- set up minimal protection ----------
    // -----------------------------------------------

    if ( window.location.href.match(/quotes\/view/ ) ) {
        var myRoleIDs  = $('#myRoleIDs').val();
        var myGroup = $('#coordinatorGroup').val();

        var assembly_coordinator = $('#assembly_coordinator').val();
        var test_coordinator     = $('#test_coordinator').val();
        var quality_coordinator  = $('#quality_coordinator').val();
        var loggedInAs           = $('#logged_in_as').val();

        var re = RegExp(ROLES_PROPOSAL_MGR, 'g');
        var notProposalMgr = !myRoleIDs.match(re);

        re = RegExp(ROLES_ADMIN, 'g');
        var notAdmin = !myRoleIDs.match(re);

        // approveItem_ $owner_id _ $item_id _ Groups::ASSEMBLY

        $.each( ['approveItem_', 'rejectItem_', 'holdItem_', 'saveItemChanges_'], function(i,val) {
            //console.log("********** val=["+val+"]");
            $.each( $('[id^='+val+']'), function() {
                var tmp     =  $(this).attr('id');
                var match   = /^\w+_(\d+)_(\d+)_(\d+)$/.exec(tmp);
                var owner = RegExp.$1;
                var item  = RegExp.$2;
                var group = RegExp.$3;
                //console.log("tmp=["+tmp+"], loggedInAs=["+loggedInAs+"], owner=["+owner+"], item=["+item+"], group=["+group+"]");
                if ( owner != loggedInAs ) {
                    $(this).hide();
                }
            });
        });

        if ( notProposalMgr && notAdmin ) {
            $.each( ['select_UpdateQuoteStatus', 'link_SendMesage', 'saveItemChanges' ], function(i,val) {
                $.each( $('#'+val), function() {
                    // var tmp     =  $(this).attr('id');
                    // var match   = /^.+_(\d+)$/.exec(tmp);
                    // if ( myGroup != RegExp.$1 ) {
                    //     $(this).hide();
                    // }
                    var tmp     =  $(this).attr('id');
                    var match   = /^\w+_(\d+)_(\d+)_(\d+)$/.exec(tmp);
                    var owner = RegExp.$1;
                    var item  = RegExp.$2;
                    var group = RegExp.$3;
                    console.log("loggedInAs=["+loggedInAs+"], owner=["+owner+"], item=["+item+"], group=["+group+"]");

                    if ( owner != loggedInAs ) {
                        $(this).hide();
                    }
                });
            });
        }
    }





	
	// ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    // -------- Event Handlers  -----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------    
    // ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------


    $('[id^=saveItemChanges_]').on('click', function() {
        var tmp     =  $(this).attr('id');
        var match   = /^\w+_(\d+)_(\d+)_(\d+)$/.exec(tmp);
        var owner = RegExp.$1;
        var item  = RegExp.$2;
        var group = RegExp.$3;

        var postData = $('#form_'+owner+'_'+item+'_'+group).serialize();
        console.log( 'Form data: ' +  postData ); 

        $.ajax({
            type: "POST",
            url: myURL + 'quotes/updateMfg',
            data: postData,
            success: function(results)  {
                if ( results == SUCCESS ) {
                    console.log('Mfg Quote updated.' ); 

                    // Cookies.set('current_tab', TAB_Approvals-1);  // 0-indexed 
                    // location.reload();
                }
                else {
                    alert('Could not update mfg quote - See Admin.');
                }
            },
            error: function (jqXHR, textStatus, errorThrown)  {
                alert("Could not update mfg quote; error=\n\n" + errorThrown + ", jqXHR="+jqXHR);
            }
        });


    });




    $('#select_UpdateQuoteStatus').on('change', function() {
       // var quoteID  = $('#Quotes_id').val(); 
        var new_id   = $('#select_UpdateQuoteStatus option:selected').val();
        var new_text = $('#select_UpdateQuoteStatus option:selected').text();
        console.log('Changing quote status:  id=['+new_id+'], text=['+new_text+']');

        var postData = {
                quote_id:        quoteID,
                new_status_id:   new_id,
                new_status_text: new_text,
        }

        $.ajax({
            type: "POST",
            url: myURL + 'quotes/updateStatus',
            data: postData,
            success: function(results)  {
                if ( results == SUCCESS ) {
                    console.log('Quote status set to '+ new_text ); 

                    Cookies.set('current_tab', TAB_Approvals-1);  // 0-indexed 
                    location.reload();
                }
                else {
                    alert('Could not change quote status - See Admin.');
                }
            },
            error: function (jqXHR, textStatus, errorThrown)  {
                alert("Could not change quote status; error=\n\n" + errorThrown + ", jqXHR="+jqXHR);
            }
        });
    });



    // ---------------------------------------------------------------- 
    $('[id^=approveItem_]').on('click', function() {
        var tmp    =  $(this).attr('id');
        var match  = /^.+_(\d+)_(\w+)$/.exec(tmp);
        var itemID = RegExp.$1;
        var groupID = RegExp.$2;
        var action = 'Approve';

        console.log('Approved item: ' + itemID + ', group=' + groupID + ', action=' + action);
        var postData = { itemID: itemID, groupID: groupID, action: action };
        $.ajax({
            type: "POST",
            url: myURL + 'quotes/itemStatus',
            data: postData,
            success: function(results)  {
                if ( results == SUCCESS ) {
                    console.log('Item status set to Approved.'); 

                    Cookies.set('current_tab', TAB_Approvals-1);  // 0-indexed 
                    location.reload();
                }
                else {
                    alert('Could not set status to Approved - See Admin.');
                }
            },
            error: function (jqXHR, textStatus, errorThrown)  {
                alert("Could not set status to Approved; error=\n\n" + errorThrown + ", jqXHR="+jqXHR);
            }
        });
    });

    // ---------------------------------------------------------------- 
    $('[id^=holdItem_]').on('click', function() {
        var tmp    =  $(this).attr('id');
        var match  = /^.+_(\d+)_(\w+)$/.exec(tmp);
        var itemID = RegExp.$1;
        var groupID = RegExp.$2;
        var action = 'Hold';

        console.log('Approved item: ' + itemID + ', group=' + groupID + ', action=' + action);
        var postData = { itemID: itemID, groupID: groupID, action: action };
        $.ajax({
            type: "POST",
            url: myURL + 'quotes/itemStatus',
            data: postData,
            success: function(results)  {
                if ( results == SUCCESS ) {
                    console.log('Item status set to Pending.');

                    Cookies.set('current_tab', TAB_Approvals-1);  // 0-indexed 
                    location.reload();
                }
                else {
                    alert('Could not set status to Pending - See Admin.'); 
                }
            },
            error: function (jqXHR, textStatus, errorThrown)  {
                alert("Could not set status to Pending; error=\n\n" + errorThrown + ", jqXHR="+jqXHR);
            }
        });

    });

    // ---------------------------------------------------------------- 
    $('[id^=rejectItem_]').on('click', function() {
        var tmp    =  $(this).attr('id');
        var match  = /^.+_(\d+)_(\w+)$/.exec(tmp);
        var itemID = RegExp.$1;
        var groupID = RegExp.$2;
        var action = 'Reject';

        console.log('Approved item: ' + itemID + ', group=' + groupID + ', action=' + action);
        var postData = { itemID: itemID, groupID: groupID, action: action };
        $.ajax({
            type: "POST",
            url: myURL + 'quotes/itemStatus',
            data: postData,
            success: function(results)  {
                if ( results == SUCCESS ) {
                    console.log('Item status set to Rejected.');

                    Cookies.set('current_tab', TAB_Approvals-1);  // 0-indexed 
                    location.reload();
                }
                else {
                    alert('Could not set status to Rejected - See Admin.');
                }
            },
            error: function (jqXHR, textStatus, errorThrown)  {
                alert("Could not set status to Rejected; error=\n\n" + errorThrown + ", jqXHR="+jqXHR);
            }
        });
    });




    $('#link_SendMesage').on('click', function() {
        $('#div_SendMessage').toggle();
    });

    
    $('#button_AddMessage').on('click', function() {
        var postData = {
            quoteID:             $('#Quotes_id').val(),
            text_Subject:        $('#text_Subject').val(),
            text_Message:        $('#text_Message').val(),
            coordinator_Assembly:   $('#coordinator_Assembly').val(),
            coordinator_Test:       $('#coordinator_Test').val(),
            coordinator_Quality:    $('#coordinator_Quality').val(),
        }
        
        if ( $('#text_Subject').val().trim() == '' || $('#text_Message').val().trim() == '' ) {
            alert('Missing subject and/or message...');
        }
        else {

            console.log('button_AddMessage: Post Data=' + postData);
            $.ajax({
                    type: "POST",
                    url: myURL + 'quotes/addMessage',
                    data: postData,
                    success: function(results)  {
                        if ( results == SUCCESS ) {
                           // alert('Message has been added.'); 

                            Cookies.set('current_tab', TAB_Approvals-1);  // 0-indexed 
                            location.reload();
                        }
                        else {
                            alert('Could not add message - See Admin.');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown)  {
                        alert("Could not add message; error=\n\n" + errorThrown + ", jqXHR="+jqXHR);
                    }
            });
        }

    });


    $('#button_SendMessage').on('click', function() {
        var postData = {
            quoteID:             $('#Quotes_id').val(),
            text_Subject:        $('#text_Subject').val(),
            text_Message:        $('#text_Message').val(),
            coordinator_Assembly:   $('#coordinator_Assembly').val(),
            coordinator_Test:       $('#coordinator_Test').val(),
            coordinator_Quality:    $('#coordinator_Quality').val(),
        }
        
        if ( $('#text_Subject').val().trim() == '' || $('#text_Message').val().trim() == '' ) {
            alert('Missing subject and/or message...');
        }
        else if ( $('#coordinator_Assembly').val()==='' && $('#coordinator_Test').val()==='' && $('#coordinator_Quality').val()==='' ) {
            alert('Need to select a least 1 coordinator...');
        }
        else {

            console.log('button_SendMessage: Post Data=' + postData);
            $.ajax({
                    type: "POST",
                    url: myURL + 'quotes/notifyCoordinators',
                    data: postData,
                    success: function(results)  {
                        if ( results == SUCCESS ) {
                            //alert('Process coordinators have been notified.'); 

                            Cookies.set('current_tab', TAB_Approvals-1);  // 0-indexed 
                            location.reload();
                        }
                        else {
                            alert('Could not send notification - see Admin.');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown)  {
                        alert("Could not send notification; error=\n\n" + errorThrown + ", jqXHR="+jqXHR);
                    }
            });
        }

    });





    // $('#button_NotifyApprovers').on('click', function() {
    //     // var quoteID     = $('#Quotes_id').val(); 
    //     var msg        = $('#coordinator_notification_message').val();
    //     var assembly   = $('#coordinator_Assembly').val();
    //     var test       = $('#coordinator_Test').val();
    //     var quality    = $('#coordinator_Quality').val();


    //     if ( $('#coordinator_notification_message').val().trim() == '' ) {
    //         alert('Missing notification message...');
    //     }
    //     else if ( assembly===''                      && test==='' && quality==='' ) {
    //         alert('Need to select a least 1 coordinator...');
    //     }
    //     else {
    //         var postData = { 
    //                 quoteID:    quoteID,
    //                 msg:        msg,
    //                 assembly:   assembly,
    //                 test:       test,
    //                 quality:    quality
    //         };
    //         $.ajax({
    //                 type: "POST",
    //                 url: myURL + 'quotes/notifyMfgApprovers',
    //                 data: postData,
    //                 success: function(results)  {
    //                     if ( results == SUCCESS ) {
    //                         alert('Manufacturing Approvers have been notified.'); 

    //                         Cookies.set('current_tab', TAB_Approvals-1);  // 0-indexed 
    //                         location.reload();
    //                     }
    //                     else {
    //                         alert('Could not notify coordinators - see Admin.');
    //                     }
    //                 },
    //                 error: function (jqXHR, textStatus, errorThrown)  {
    //                     alert("Could not notify coordinators; error=\n\n" + errorThrown + ", jqXHR="+jqXHR);
    //                 }
    //         });
    //     }
    // });








    $('#submitProcessApproval').on('click', function() {
        // var quoteID = $('#Quotes_id').val(); 
        console.log('Submitting for process approval...');
        
        var postData = { quote_id: quoteID };
        $.ajax({
                type: "POST",
                url: myURL + 'btoItems/process',
                data: postData,
                success: function(results)  {
                    alert('Quote has been submitted to Proposal Manager.'); 
                     if ( results == SUCCESS ) {
                        console.log('Approval is pending...');
                        location.reload();
                    }
                    else {
                        alert('Could not submit this quote for process approval - see Admin.');
                    }
                }
        });
        return false;
    });






    $('#back_to_index').on('click', function () {
         window.location = myURL + 'quotes/index';
    });


    $('#button_ApproveItem').on('click', function() {
        // var quoteID = $('#Quotes_id').val(); 
        if ( confirm( "Are you sure you want to approve this item?") ) {
            var postData = {
                    item_id:           currentItemID,
                    item_disposition:  'Approve'
            };

            $.ajax({
                    type: "POST",
                    url: myURL + 'quotes/disposition?id=' + quoteID,
                    data: postData,
                    success: function(results)  {
                        console.log('results from quote disposition=['+results+']');
                        location.reload();
                    }
            });
        }

        return false;
    });



    $('#button_RejectItem').on('click', function() {
        // var quoteID = $('#Quotes_id').val(); 
        if ( confirm( "Are you sure you want to reject this item?") ) {
           var postData = {
                    item_id:           currentItemID,
                    item_disposition:  'Reject'
            };

            $.ajax({
                    type: "POST",
                    url: myURL + 'quotes/disposition?id=' + quoteID,
                    data: postData,
                    success: function(results)  {
                        console.log('results from quote disposition=['+results+']');
                        location.reload();
                    }
            });
        }

        return false;
    });


    // in View mode, click on item
    $('[id^=item_row_]').on('click', function() {

        if ( window.location.href.match(/quotes\/update/ ) ) {
            return false;
        }

        $('#button_ApproveItem').hide();
        $('#button_RejectItem').hide();

        var tmp    =  $(this).attr('id');
        var match  = /^.+_(\d+)$/.exec(tmp);
        var itemID = RegExp.$1;

        if ( currentItemID == itemID ) {
            $('#item_details').toggle();
            if ($(this).find('td').hasClass('highlight_row') ) {
                $(this).find('td').removeClass('highlight_row'); 
            }
            else {
                $(this).find('td').addClass('highlight_row'); 
            }
        }
        else {
            $('#item_details').show();
            $('[id^=item_row_]').find('td').removeClass('highlight_row'); 
            $(this).find('td').addClass('highlight_row'); 

            $('#item_details').html('');
            $('#ajax_loading_image').show();
            $.ajax({
                type: 'GET',
                url: myURL + 'parts/showDetails?id=' + itemID,
                success: function (data) {
                    $('#item_details').html(data);
                    currentItemID = itemID;

                    $('#ajax_loading_image').hide();


                    console.log("itemID=" + itemID + ", title=" + $( "#item_status_"+itemID ).attr('title') );

                    // check if item needs approval; if so, display 'button_ApproveItem' and 'button_RejectItem'
                    if ( $( "#item_status_"+itemID ).attr('title') == 'Pending approval' ) {
                        $('#button_ApproveItem').show();
                        $('#button_RejectItem').show();
                    }
                    else {
                       $('#button_ApproveItem').hide();
                       $('#button_RejectItem').hide();
                    }
                }
            });
        }
        return false;
    });





    $('#cancel_NewQuote').on('click', function() {
        window.location = myURL + 'quotes/index';
    });

    $('a[id^=section]').on('click', function() {
        console.log('click on tab...');
    })

    $('#changeStatus').on('click', function() {
        dialog_status.dialog( "open" );
    });

    if ( $("#dialog_status_form").length == 1 ) {
        dialog_status = $( "#dialog_status_form" ).dialog({
            autoOpen: false,
            height: 160,
            width: 350,
            modal: true,
            buttons: {
                "Change": function() {
                    var newStatus =  $('#newQuoteStatus').val();
                    console.log( "new status = " + newStatus + ", form: " + $('#new_status_form').serialize() );
                    var postData = $('#new_status_form').serialize();
                    // var quoteID = $('#Quotes_id').val();

                    $.ajax({
                            type: "POST",
                            url: myURL + 'quotes/update/' + quoteID,
                            data: postData,
                            success: function(results)  {
                                console.log('results from quote update=['+results+']');
                                location.reload();
                            }
                    });

                    dialog_status.dialog( "close" );
                    return false;
                },
                Cancel: function() {
                    dialog_status.dialog( "close" );
                }
            }
        });
    }

    $('#addPartToQuote').on('click', function() {
        $('#div_PartsLookup').show();
        
        // console.log('********** ResultsTable.destroy() - #addPartToQuote).on(click) ' + ResultsTable);
        // if ( ResultsTable ) {
        //     ResultsTable.destroy();
        // }

        $('#table_CurrentParts > caption').hide();
    });

    $('#span_NewContact').on('click', function() {
        $('[id^=Contacts_]').val('');
        $('[id^=Contacts_]').removeAttr('readOnly');


        if ( $('#Customer_name').val() != '' ) {
            $('#check_SameAsCustomer').show();
            $('#check_SameAsCustomer > input[type="checkbox"]').removeAttr('checked');
        }

        $('#Contacts_state_id').replaceWith('<select                  name="Contacts[state_id]" id="Contacts_state_id"></select>');
        $.ajax({
            type: 'GET',
            url: myURL + 'quotes/select?q=us_states',
            success: function (data) {
                var o = JSON.parse(data); 
                $('#Contacts_state_id').append( $('<option></option>' ).val(0).html('') );
                $.each( o, function(k,v) {
                    $('#Contacts_state_id').append( $('<option></option>' ).val(v.id).html(v.label) );
                });
            }
        });

        $('#Contacts_country_id').replaceWith('<select                name="Contacts[country_id]" id="Contacts_country_id"></select>');
        $.ajax({
            type: 'GET',
            url: myURL + 'quotes/select?q=countries',
            success: function (data) {
                var o = JSON.parse(data); 
                $('#Contacts_country_id').append( $('<option></option>' ).val(0).html('') );
                $.each( o, function(k,v) {
                    $('#Contacts_country_id').append( $('<option></option>' ).val(v.id).html(v.label) );
                });
            }
        });


    });

    $('#span_NewCustomer').on('click', function() {
        $('[id^=Customers_]').val('');
        $('[id^=Customers_]').removeAttr('readOnly');
        
        if ( $('#Contacts_first_name').val() != '' ) {
            $('#check_SameAsContact').show();
            $('#check_SameAsContact > input[type="checkbox"]').removeAttr('checked');

        }


        $('#Customers_state_id').replaceWith('<select                 name="Customers[state_id]" id="Customers_state_id"></select>');
        $.ajax({
            type: 'GET',
            url: myURL + 'quotes/select?q=us_states',
            success: function (data) {
                var o = JSON.parse(data); 
                $('#Customers_state_id').append( $('<option></option>' ).val(0).html('') );
                $.each( o, function(k,v) {
                    $('#Customers_state_id').append( $('<option></option>' ).val(v.id).html(v.label) );
                });
            }
        });


        $('#Customers_country_id').replaceWith('<select               name="Customers[country_id]" id="Customers_country_id"></select>');
        $.ajax({
            type: 'GET',
            url: myURL + 'quotes/select?q=countries',
            success: function (data) {
                var o = JSON.parse(data);
                $('#Customers_country_id').append( $('<option></option>' ).val(0).html('') ); 
                $.each( o, function(k,v) {
                    $('#Customers_country_id').append( $('<option></option>' ).val(v.id).html(v.label) );
                });
            }
        });

        $('#Customers_region_id').replaceWith('<select                name="Customers[region_id]" id="Customers_region_id"></select>');
        $.ajax({
            type: 'GET',
            url: myURL + 'quotes/select?q=regions',
            success: function (data) {
                var o = JSON.parse(data); 
                $('#Customers_region_id').append( $('<option></option>' ).val(0).html('') ); 
                $.each( o, function(k,v) {
                    $('#Customers_region_id').append( $('<option></option>' ).val(v.id).html(v.label) );
                });
            }
        });

        $('#Customers_customer_type_id').replaceWith('<select         name="Customers[customer_type_id]" id="Customers_customer_type_id"></select>');
        $.ajax({
            type: 'GET',
            url: myURL + 'quotes/select?q=customer_types',
            success: function (data) {
                var o = JSON.parse(data); 
                $('#Customers_customer_type_id').append( $('<option></option>' ).val(0).html('') ); 
                $.each( o, function(k,v) {
                    $('#Customers_customer_type_id').append( $('<option></option>' ).val(v.id).html(v.label) );
                });
            }
        });

        $('#Customers_outside_salesperson_id').replaceWith('<select   name="Customers[outside_salesperson_id]" id="Customers_outside_salesperson_id"></select>');
        $('#Customers_inside_salesperson_id').replaceWith('<select    name="Customers[nside_salesperson_id]" id="Customers_inside_salesperson_id"></select>');
        $.ajax({
            type: 'GET',
            url: myURL + 'quotes/select?q=users',
            success: function (data) {
                var o = JSON.parse(data); 
                $('#Customers_inside_salesperson_id').append( $('<option></option>' ).val(0).html('') ); 
                $('#Customers_outside_salesperson_id').append( $('<option></option>' ).val(0).html('') ); 
                $.each( o, function(k,v) {
                    $('#Customers_inside_salesperson_id').append( $('<option></option>' ).val(v.id).html(v.label) );
                    $('#Customers_outside_salesperson_id').append( $('<option></option>' ).val(v.id).html(v.label) );
                });
            }
        });
        
        $('#Customers_parent_id').replaceWith('<select                name="Customers[parent_id]" id="Customers_parent_id"></select>');
        $.ajax({
            type: 'GET',
            url: myURL + 'quotes/select?q=customers',
            success: function (data) {
                var o = JSON.parse(data); 
                $('#Customers_parent_id').append( $('<option></option>' ).val(0).html('') ); 
                $.each( o, function(k,v) {
                    $('#Customers_parent_id').append( $('<option></option>' ).val(v.id).html(v.label) );
                });
            }
        });

        $('#Customers_tier_id').replaceWith('<select                  name="Customers[tier_id]" id="Customers_tier_id"></select>');
        $.ajax({
            type: 'GET',
            url: myURL + 'quotes/select?q=tiers',
            success: function (data) {
                var o = JSON.parse(data); 
                $('#Customers_tier_id').append( $('<option></option>' ).val(0).html('') ); 
                $.each( o, function(k,v) {
                    $('#Customers_tier_id').append( $('<option></option>' ).val(v.id).html(v.label) );
                });
            }
        });

        $('#Customers_territory_id').replaceWith('<select             name="Customers[territory_id]" id="Customers_territory_id"></select>');
        $.ajax({
            type: 'GET',
            url: myURL + 'quotes/select?q=territories',
            success: function (data) {
                var o = JSON.parse(data); 
                $('#Customers_territory_id').append( $('<option></option>' ).val(0).html('') ); 
                $.each( o, function(k,v) {
                    $('#Customers_territory_id').append( $('<option></option>' ).val(v.id).html(v.label) );
                });
            }
        });



    });







    // $('#button_Home').on('click', function() {
    //     window.location = myURL + 'quotes/index';
    // });

    $('#cancelQuoteChanges').on('click', function() { 
        window.location = myURL + 'quotes/view/' + $('#Quotes_id').val();
    });

    $('#quoteUpdateForm').submit(function( e ) {                        // click "Save Changes"
        e.preventDefault();

        // TODO - not sure we need this now...
        //
        // if ( $('#header_QuoteNo > span').text().match(/Rejected/) ) {
        //     $('#Quotes_status_id').val(STATUS_PENDING);
        //     consoleDisplayFormFields($('#quoteUpdateForm'));
        //     console.log('Setting quote status to "Pending Approval"');
        // }

        // var quoteID = $('#Quotes_id').val(); 
        var postData = $(this).serialize();
        var returnURL = $('#return_URL').val();

        $.ajax({
                type: "POST",
                    url: myURL + 'quotes/update/' + quoteID,
                    data: postData,
                    success: function(results)  {

                        if ( results == SUCCESS ) { // update succeeded
                            alert('Quote updated...');
                            window.location = myURL + 'quotes/view/'+quoteID;
                        }
                        else {
                            alert('Server Validation: missing required field(s)...');
                            return false;
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown)  {
                        alert("Couldn't update quote " + quoteID + "; error=\n\n" + errorThrown + ", jqXHR="+jqXHR);
                    }
        });

        Cookies.remove('current_tab');

    });


    $('#quoteAddForm').submit(function( e ) {                          //  click "Continue" 
    	e.preventDefault();
        var postData = $(this).serialize();

    	if ( formValidated() ) { 		
    		$.ajax({
	            type: "POST",
		            url: myURL + 'quotes/create',
		            data: postData,
		            success: function(results)  {
                        if ( results != FAILURE ) {
    		            	var q = results.split('|');
    		            	quoteId = q[0];
    		            	quoteNo = q[1];
                            $('#quoteForm_Terms_QuoteID').val(quoteId); // for Terms form...

    		            	console.log('quoteId=['+quoteId+'], quoteNo=['+quoteNo+']');
                            alert('New quote created - No. '+quoteNo);

                            Cookies.set('quote_added', 1);

    		            	$('#form_QuoteID').val(quoteId);
                            window.location.href = myURL + 'quotes/update?id=' + quoteId + '&n=' + Math.floor((Math.random() * 100000000) + 1);
                          

                            // var postData = {
                            //         newQuoteTypeID: MANUFACTURING_QUOTE,
                            // };

                            // $.ajax({
                            //         type: "POST",
                            //         url: myURL + 'quotes/update?id=' + quoteId,
                            //         data: postData,
                            //         success: function(results)  {
                            //             console.log('results from update quote status: ['+results+']');
                            //             location.reload();
                            //         }
                            // });


                        }
		            }
	        });
    	}
    	else {
    			alert("Client Validation: missing required field(s)...");
    	}

        Cookies.remove('current_tab');
	});



    //  $('#quoteForm_Terms').submit(function( event ) {                   //  click "Save Quote" 
    //     event.preventDefault();
    //     // var postData = $(this).serialize();

        // var quoteID = $('#form_QuoteID').val();
    //     var postData = $('#quoteForm_Terms').serialize();
    //     console.log('quoteForm_Terms serialized: ' + postData);

    //     $.ajax({
    //     type: "POST",
    //         url: myURL + 'quotes/update/' + quoteID ,
    //         data: postData,
    //         success: function(results)  {
    //             if ( results == SUCCESS ) {
    //                 console.log('Quote terms updated.');
    //                 alert('Quote has been updated.');
    //             }
    //             else {
    //                 console.log('Quote terms NOT updated...');
    //             }
    //         }
    //     });

    //     window.location = myURL + 'quotes/index' ;




    // });





    
    // $( "#quoteForm" ).on( "submit", function( event ) {
    //     var quoteID = $('#form_QuoteID').val();
    //     event.preventDefault();

    //     var myData = $( this ).serialize();
    //     console.log( "Serialize form data: " + myData );

    //     $.ajax({
    //         type: "POST",

    //             url: myURL + 'quotes/update/' + quoteID,
    //             data: myData,

    //             success: function(results)  {
    //                 alert("Quote has been created AND updated with terms...");
    //             }
    //     });

    //      window.location = myURL + 'quotes/index' ;





    // });


    // $('#quoteForm_Terms').submit(function( event ) {
    //       alert('via submit() - Savings terms...');
    //       event.preventDefault();

    //       var postData = $(this).serialize();
    //       console.log('quoteForm_Terms serialized from submit: ' + postData);


    // });



    // // ------------------------------------------------------------------
    // $('#div_SubmitDone > input').on('click', function () {
    //     $(window).unbind('beforeunload');
    //     alert('Savings terms...');


    //     var quoteID = $('#form_QuoteID').val();

    //     var data = {
    //         TermsUpdate:       1,
    //         quote_Terms:       $('#quote_Terms').val(),
    //         quote_CustAck:     $('#quote_CustAck').val(),
    //         quote_RISL:        $('#quote_RISL').val(),
    //         quote_MfgLeadTime: $('#quote_MfgLeadTime').val(),
    //         quote_Notes:       $('#quote_Notes').val()
    //     };

    //     var postData = $('#quoteForm_Terms').serialize();
    //     console.log('quoteForm_Terms serialized: ' + postData);
    //     console.log('data: ' + data);
    //     return false;




    //     $.ajax({
    //         type: "POST",
    //             url: myURL + 'quotes/update/' + quoteID ,
    //             data: postData,
    //             //data: data,
    //             success: function(results)  {
                  
    //             }
    //     });

    //      window.location = myURL + 'quotes/index' ;

    // });





	// ----------------------------------------------------------------------------- Custom Price
    $('input#price_Custom').focus(function() {  // enter
        $(this).val('');
    });

    $('input#price_Custom').blur(function() {  // leave
        var cp = $(this).val();
        var q = $('#qty_Custom').val();    

        checkCustomPrice(cp);

        if ( isNaN(cp) ) {
            $(this).val('');
            $('#subTotal_Custom').html('');
            return false;
        }

        $('#subTotal_Custom').html( toCurrency(getSubTotal(cp, q)) );
        $('input#price_Custom').val(toCurrency(cp));
    });




    $('#item_SelectVolume').on('change', function() {
        var key = $(this).val();
        var selected_Price = '$ 0.00';

        if ( key != 0 ) {
            selected_Price = ItemPricing[key];
        }

        $('#item_price').text( accounting.formatMoney(selected_Price) );
        var qty   = $('#item_qty').val();
        $('#item_total').text( accounting.formatMoney( parseInt(qty) * parseFloat(selected_Price) ) ); 
    });




    // ----------------------------------------------------------------------------- Change Quantity Input
    $('#item_qty').on('focus',function() {}).on('blur', function() {
        var volume  = '';
        var new_qty = parseInt($(this).val());
        var new_price = '';

        if ( isNaN(new_qty) ) {  
            $("#item_SelectVolume").val('0'); 
            $('#item_qty').val('');
        }
        else {

            if ( overMaxAvailable(new_qty) ) {
                alert("That's more than what's available; try again." );
                $('#item_total').text('');
                $("#item_SelectVolume").val('0'); 
                $('#item_qty').val('');
                $('#item_price').text('');
                return;
            }
            else if ( new_qty < 25 ) {
                console.log('less than 25');
                $("#item_SelectVolume").val('item_price_1_24'); 
                new_price = ItemPricing['item_price_1_24'];
            }
            else if ( new_qty < 100 )  {
                console.log('less than 100');
                $("#item_SelectVolume").val('item_price_25_99');
                new_price = ItemPricing['item_price_25_99']; 
            }
            else if ( new_qty < 500 )  {
                console.log('less than 500');
                $("#item_SelectVolume").val('item_price_100_499');
                new_price = ItemPricing['item_price_100_499'];
            }
            else if ( new_qty < 1000 )  {
                console.log('less than 1000');
                $("#item_SelectVolume").val('item_price_500_999');
                new_price = ItemPricing['item_price_500_999'];
            }
            else {
                console.log('MORE than 999');
                $("#item_SelectVolume").val('item_price_1000_Plus');
                new_price = ItemPricing['item_price_1000_Plus']; 
            }
        }
       
        $("#item_SelectVolume").trigger('change');
        $('#item_total').text( accounting.formatMoney( parseInt(new_qty) * parseFloat(new_price) ) ); 

    });


    function overMaxAvailable(new_qty) {
        return ( parseInt(new_qty) > parseInt(selected_ItemMaxAvailable) ? true : false );
    }



    function overMaxAvailable_Dialog() {
        var qty_available_selected = $('#table_AddToQuote > caption > span:nth-child(2)').html(); 

        var max = qty_available_selected.replace(',','');
        var total = 0;
        $('input[id^=qty_]').each(function(k, v) {
            console.log("adding value: ["+$(this).val()+"]");
            total += +$(this).val(); // plus sign in front of $(this).val() is needed (make it a number)
        });
        console.log("total=["+total+"], max=["+max+"]");
        return total>max ? true : false;
    }

   


    function toCurrency(n)  {   
        if ( !n || isNaN(n) ) {
            return '';
        }
        var currency = '$';
        n1 = parseFloat(n);
        var tmp = currency + " " + n1.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
            return tmp; 
    }















     // ----------------------------------------------------- save editing changes
    $('#button_SaveItemChanges').on('click', function() {
        console.log( 'button_SaveItemChanges() - ' + $('#item_SelectVolume').val() );

        if ( $('#item_SelectVolume').val() == 0 ) {
            alert('Missing required field(s)...');
            return false;
        }

        var itemID  = $('#item_id').val();
        // var quoteID = $('#Quotes_id').val();
        var URL     = myURL + 'quotes/partsUpdate';
        console.log('quoteID=' + quoteID + ", URL=" + URL);

        // do ajax save of item and screen update
        var info =  {
                item_qty:       $('#item_qty').val(),
                item_price:     $('#item_price').text(),
                item_total:     $('#item_total').text(),
                item_comments:  $('#item_comments').val(),
                item_id:        itemID,
                item_volume:    $('#item_SelectVolume').val(),
                quote_id:       quoteID
        };
                                /*
                                    Create a cookie, valid across the entire site:
                                        Cookies.set('`', 1);

                                    Read cookie:
                                        Cookies.get('current_tab');     // => 'value'
                                        Cookies.get('nothing');             // => undefined

                                    Delete cookie:
                                        Cookies.remove('current_tab');
                                */
        $.ajax({
                url: URL,
                type: 'POST',
                data: info, 
                dataType: "json",
                success: function(data) {
                    console.log("Inventory Item update success.");
                    Cookies.set('item_updated', 1);
                    location.reload();
                },
                error: function (jqXHR, textStatus, errorThrown)  {
                    console.log("iq2_main_js, AJAX Post: FAIL! error:"+errorThrown);
                    alert("Your Inventory Item could NOT be updated - see Admin (button_SaveItemChanges)\n\nERROR=" + errorThrown);
                } 
        });
    });
                                





















    // ----------------------------------------------------- cancel editing
    $('#button_CancelItemChanges').on('click', function() {
        // reset elements back to what they were
        $('#div_EditItem').hide();
        $('[id^=item_edit_]').show();
        $('[id^=item_trash_]').show();

        $('#addPartToQuote').show();
        $('#button_SaveQuoteChanges').show();
        $('#cancelQuoteChanges').show();

        $('#table_CurrentParts > tbody > tr').css('background-color', '');

        $('#item_SelectVolume').val(0);
        $('#item_qty').val('');
    });




    // ----------------------------------------------------- Select from available customers
    $('#Customers_select').on('change', function () { 
        var custID = $(this).val();
        resetCustomerForm();

        $.ajax({
            type: 'GET',
            url: myURL + 'customers/find?id='+custID ,
            success: function (ret) {
                display_Customer(ret);
            }
        });
    });
   
    // ----------------------------------------------------- Select from available contacts
    $('#Contacts_select').on('change', function () { 
        var contactID = $(this).val();
        resetContactForm();
       
        $.ajax({
            type: 'GET',
            url: myURL + 'contacts/find?id='+contactID ,
            success: function (ret) {
                display_Contact(ret);
            }
        });
    });


    $('[id^=quote_approve_]').on('click', function() { //   Approve quote  
        var quoteID = getThisID( $(this) ); 

        if ( confirm("Are you sure you want to approve this quote?" ) ) {
            $.ajax({
                type: 'GET',
                url: myURL + 'quotes/approve?id='+quoteID ,
                success: function (ret) {
                    if ( ret == SUCCESS) {
                       // alert('Quote approved.');
                        window.location = myURL + 'quotes/index?a=1'; 
                    }
                    else {
                        alert('Error: could not approve quote - see Admin. (ret=['+ret+']');
                    }
                }
            });
        }
    });


    $('[id^=quote_reject_]').on('click', function() { //   Reject quote  
        var quoteID = getThisID( $(this) ); 


        if ( confirm("Are you sure you want to reject this quote?" ) ) {
            $.ajax({
                type: 'GET',
                url: myURL + 'quotes/reject?id='+quoteID ,
                success: function (ret) {
                    if ( ret == SUCCESS ) {
                       // alert('Quote rejected.');
                        window.location = myURL + 'quotes/index?a=1'; 
                    }
                    else {
                        alert('Error: could not reject quote - see Admin. (ret=['+ret+']');
                    }
                }
            });
        }
    });

    $('[id^=quote_view_]').on('click', function() { //   View quote  
    	var quoteID = getThisID( $(this) ); 
    	window.location = myURL + 'quotes/view?id='+quoteID ;
    });

    $('[id^=quote_edit_]').on('click', function() { //   Edit quote  
        var quoteID = getThisID( $(this) ); 
        window.location = myURL + 'quotes/update/' + quoteID ; 
    });




    $('[id^=quote_attach_]').on('click', function() { //   Attach to quote 
        var quoteID = getThisID( $(this) ); 
        window.location = myURL + 'attachments/upload/' + quoteID ; 
    });


    $('[id^=quote_trash_]').on('click', function() { //   Delete quote  
        var quoteID = getThisID( $(this) ); 
        if ( confirm("Are you sure you want to delete this quote?" ) ) {
            $.ajax({
                url: myURL + 'quotes/delete/' + quoteID ,
                type: 'POST',
                data: { data: quoteID },
                success: function(ret) {
                    if ( ret == SUCCESS ) {
                        window.location = myURL + 'quotes/index';
                    }
                    else {
                        alert("Couldn't delete quote " + quoteID + "; see Admin");
                    }
                },
                error: function (jqXHR, textStatus, errorThrown)  {
                    alert("Couldn't delete quote " + quoteID + "; error=\n\n" + errorThrown);
                }
            });
        }
        return false;

    });
  
    $('#quotes_table').on('click', function() {  //  re-attach event handler 
    	// have to attach click event handler; after paging, 
    	// dataTables reloads the tableBody and all attached event handlers

    	// do this for quote_view_xx, edit_quote_xx, delete_quote_xx

		$('[id^=quote_view_]').on('click', function() {
	    	var quoteID = getThisID( $(this) ); 
	    	window.location = myURL + 'quotes/view?id='+quoteID ;
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
  		var item      = encodeURIComponent(searchFor.trim().toUpperCase() );  // >>>>>>>  THE ONLY PLACE WE NEED TO USE "encodeURIComponent()"

        var url       =  myURL + 'parts/search?item=' + item + '&by=' + searchBy; 
        console.log('url=' + url);    

  		if ( searchFor.trim() && searchBy ) {
  			$('#ajax_loading_image').show();
            $('#results_table').hide();
            $('#results_table_wrapper').hide();
            $.ajax({
	                type: 'GET',
	                url: url,
	                success: function (results) {
	                	displayPartLookupResults(results);
                        $('#ajax_loading_image').hide();
                        $('#results_table').show();
                        $('#results_table_wrapper').show();

	                }
            });
  		}
  	});

    $('#check_SameAsCustomer > input[type="checkbox"]').on('click', function() {
        console.log('check clicked...');

        if ( $(this).is(":checked") ) {
            var address1 = $('#Customers_address1').val();
            var address2 = $('#Customers_address2').val();
            var city     = $('#Customers_city').val();
            var zip      = $('#Customers_zip').val();

            var state   = $('#Customers_state_id').val();
            var country = $('#Customers_country_id').val();
          
            $('#Contacts_address1').val( address1 );
            $('#Contacts_address2').val( address2 );
            $('#Contacts_city').val( city );
            $('#Contacts_zip').val( zip );

            $("#Contacts_state_id option:contains('"+state+"')").attr('selected', 'selected');
            $("#Contacts_country_id option:contains('"+country+"')").attr('selected', 'selected');
        }
        else {
            $('#Contacts_address1').val( '' );
            $('#Contacts_address2').val( '' );
            $('#Contacts_city').val( '' );
            $('#Contacts_zip').val( '' );
            $("#Contacts_state_id option:first").attr('selected','selected');
            $("#Contacts_country_id option:first").attr('selected','selected');
        }
    });

    $('#check_SameAsContact > input[type="checkbox"]').on('click', function() {
        if ( $(this).is(":checked") ) {
            var address1 = $('#Contacts_address1').val();
            var address2 = $('#Contacts_address2').val();
            var city     = $('#Contacts_city').val();
            var zip      = $('#Contacts_zip').val();

            var state   = $('#Contacts_state_id').val();
            var country = $('#Contacts_country_id').val();
          
            $('#Customers_address1').val( address1 );
            $('#Customers_address2').val( address2 );
            $('#Customers_city').val( city );
            $('#Customers_zip').val( zip );

            $("#Customers_state_id option:contains('"+state+"')").attr('selected', 'selected');
            $("#Customers_country_id option:contains('"+country+"')").attr('selected', 'selected');
        }
        else {
            $('#Customers_address1').val( '' );
            $('#Customers_address2').val( '' );
            $('#Customers_city').val( '' );
            $('#Customers_zip').val( '' );
            $("#Customers_state_id option:first").attr('selected','selected');
            $("#Customers_country_id option:first").attr('selected','selected');
        }
    });

    addEventsToItems();


    // ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    // -------- Functions -----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------    
    // ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

    function addEventsToItems() {
        // ----------------------------------------------------- delete item
        $('[id^=item_trash_]').on('click', function() {
            $('#table_CurrentParts > caption').hide();

            var itemID = getID($(this));
            if ( confirm("Are you sure you want to delete this item?" ) ) {
                $.ajax({
                      url: myURL + 'stockItems/delete/' + itemID ,
                      type: 'POST',
                      success: function(data, textStatus, jqXHR) {
                        Cookies.set('item_removed', 1);
                        location.reload();
                      },
                      error: function (jqXHR, textStatus, errorThrown)  {
                        alert("Couldn't delete item " + itemID + " from this quote; error=\n\n" + errorThrown);
                      }
                });
            }
            return false;
        });

        //  #table_CurrentParts > tbody > tr:nth-child(1) > td:nth-child(4)

        // ----------------------------------------------------- edit item
        $('[id^=item_edit_]').on('click', function() {
            $('#table_CurrentParts > caption').hide();
            
            $(this).closest('tr').css('background-color', '#FEF1E9'); // hightlight row when clicked

            var itemID = getID($(this));
            console.log('Editing item: ' + itemID);

            selected_ItemPartNo       = $(this).closest('tr').find('td:nth-child(2)').text();
            selected_ItemLifecycle    = $(this).closest('tr').find('td:nth-child(4)').text();
            selected_ItemMaxAvailable = $(this).closest('tr').find('td:nth-child(5)').text();
            selected_ItemQuantity     = $(this).closest('tr').find('td:nth-child(6)').text();
            selected_ItemPrice        = $(this).closest('tr').find('td:nth-child(7)').text();
            selected_ItemVolume       = $(this).closest('tr').find('td:nth-child(8)').text();
            selected_ItemTotal        = $(this).closest('tr').find('td:nth-child(9)').text();
            selected_ItemComments     = $(this).closest('tr').find('td:nth-child(10)').text();

            //console.log('selected_ItemVolume=' + selected_ItemVolume);

            $('#span_PartNo').text(selected_ItemPartNo);

            $('#item_id').val(itemID);

            $('#item_qty').val(selected_ItemQuantity);
            
            console.log('Volume: ' + 'item_price_' + selected_ItemVolume );
            $('#item_SelectVolume').val( 'item_price_' + selected_ItemVolume);

            $('#item_price').text(selected_ItemPrice);
            $('#item_total').text(selected_ItemTotal);
            $('#item_comments').val(selected_ItemComments);

            /*
                TODO:
                        if stock item, url = stockItems/find
                        if build, url = btoItems/find

                        use parts/lookup for now
            */

            var url =  myURL + 'parts/lookup?id=' + itemID; 

            $.ajax({
                    type: 'GET',
                    url: url,
                    success: function (res) {
                        d = JSON.parse(res);
                        //console.log('parts lookup results='+res);

                        $.each( [ '1_24','25_99','100_499','500_999','1000_Plus','Base' ], function(k,v) {
                            if ( $('#item_qty_'+v).val() != '' ) {
                                $('#item_qty_'+v+'_comments').val( d.comments );
                            }
                        });

                        // accounting.formatMoney(12345678); // $12,345,678.00  -->

                        ItemPricing.item_price_1_24 = d.price_1_24;
                        ItemPricing.item_price_25_99 = d.price_25_99;
                        ItemPricing.item_price_100_499 = d.price_100_499;
                        ItemPricing.item_price_500_999 = d.price_500_999;
                        ItemPricing.item_price_1000_Plus = d.price_1000_Plus;
                        ItemPricing.item_price_Base = d.price_Base;

                        $('#item_qty_1_24').val( d.qty_1_24 );
                        $('#item_qty_25_99').val( d.qty_25_99 );
                        $('#item_qty_100_499').val( d.qty_100_499 );
                        $('#item_qty_500_999').val( d.qty_500_999 );
                        $('#item_qty_1000_Plus').val( d.qty_1000_Plus );
                        $('#item_qty_Base').val( d.qty_Base );

                        $('#previous_comments').val( d.comments );
                    }
            });


            $('#div_EditItem').show();
            $('[id^=item_edit_]').hide();
            $('[id^=item_trash_]').hide();

            $('#div_PartsLookup').hide();
            $('#addPartToQuote').hide();

            //console.log('********** ResultsTable.destroy() - addEventsToItems() - ResultsTable=' + ResultsTable);
            // if ( ResultsTable ) {
            //     ResultsTable.destroy();
            // }

            $('#button_SaveQuoteChanges').hide();
            $('#cancelQuoteChanges').hide();
        });
    }



    function getID(that) {
        var tmp =  $(that).attr('id');
        var thisId = /\w+[_delete_|_edit_]\w+_(.+)$/i.exec( tmp );
        return RegExp.$1;
    }


    function resetCustomerForm() {
        $('#Customers_state_id').replaceWith("<input type='text'               id='Customers_state_id'               name='Customers[state_id]'                readonly='readonly'>");
        $('#Customers_country_id').replaceWith("<input type='text'             id='Customers_country_id'             name='Customers[country_id]'              readonly='readonly'>");
        $('#Customers_region_id').replaceWith("<input type='text'              id='Customers_region_id'              name='Customers[region_id]'               readonly='readonly'>");
        $('#Customers_customer_type_id').replaceWith("<input type='text'       id='Customers_customer_type_id'       name='Customers[customer_type_id]'        readonly='readonly'>");
        $('#Customers_inside_salesperson_id').replaceWith("<input type='text'  id='Customers_inside_salesperson_id'  name='Customers[inside_salesperson_id]'   readonly='readonly'>");
        $('#Customers_outside_salesperson_id').replaceWith("<input type='text' id='Customers_outside_salesperson_id' name='Customers[outside_salesperson_id]'  readonly='readonly'>");
        $('#Customers_parent_id').replaceWith("<input type='text'              id='Customers_parent_id'              name='Customers[parent_id]'               readonly='readonly'>");
        $('#Customers_tier_id').replaceWith("<input type='text'                id='Customers_tier_id'                name='Customers[tier_id]'                 readonly='readonly'>");
        $('#Customers_territory_id').replaceWith("<input type='text'           id='Customers_territory_id'           name='Customers[territory_id]'            readonly='readonly'>");

        $('[id^=Customers_]').val('');
        $('[id^=Customers_]').attr('readOnly', 'readonly');

        $('#check_SameAsCustomer > input[type="checkbox"]').removeAttr('checked');
        $('#check_SameAsContact > input[type="checkbox"]').removeAttr('checked');

        $('#check_SameAsCustomer').hide();
        $('#check_SameAsContact').hide();
    }

    function resetContactForm() {
        $('#Contacts_state_id').replaceWith("<input type='text'   id='Contacts_state_id'     name='Contacts[state_id]'   readonly='readonly'>");
        $('#Contacts_country_id').replaceWith("<input type='text' id='Contacts_country_id'   name='Contacts[country_id]' readonly='readonly'>");

        $('[id^=Contacts_]').val('');
        $('[id^=Contacts_]').attr('readOnly', 'readonly');

        $('#check_SameAsCustomer').hide();
        $('#check_SameAsContact').hide();
    }



    function checkCustomPrice(cp) {
        var buttonText              = '';
        var form_PartPricing        = $( "#form_PartPricing" );
        var msg                     = '';
        var quoteID                 = $('#form_QuoteID').val();
        var distributor_price       = $('#distributor_price').val();
        var distributor_price_floor = $('#distributor_price_floor').val();  // 75% usually - make this configurable
        var lifeCycle               = $('#lifeCycle').text();
        var approvalNeeded          = 0;

        console.log('checkCustomPrice() - cp=['+cp+'], distributor_price=['+distributor_price+'], lifecycle=['+lifeCycle+']');
        /*
            if item is "Active", needs Approval if "cp" less than 'distributor_price'
            if item is 'Obsolete', needs Approval if "cp" less than 75% of 'distributor_price'
        */

        if ( lifeCycle == lifeCycle_ACTIVE )  {
            if ( parseFloat(cp) < parseFloat(distributor_price) ) {
                approvalNeeded = 1;
            }
        }
        else if ( lifeCycle == lifeCycle_OBSOLETE )  {
            if ( parseFloat(cp) < (parseFloat(distributor_price) * parseFloat(distributor_price_floor)) ) {
                approvalNeeded = 1;
            }
        }
        else {
            // nothing defined here...

        }
        console.log('Approval needed? ' + approvalNeeded);

        // var min_custom_price = $('#min_custom_price').html().substring(1).trim(); // ignore first character of '$' and leading spaces...
        // var diff =  parseFloat(min_custom_price) - parseFloat(cp);
        // console.log('checking diff between: [ ' + min_custom_price + ' ] and [ ' + parseFloat(cp) + ' ]');
        // var approvalNeeded =  ( diff > 0 ? 1 : 0 );
        
        if ( approvalNeeded ) {
            buttonText = 'Get Approval';
            msg = 'This quote is being submitted for approval.';
            // - set button to read 'Get Approval'
            // - set hidden variable on form 'approvalNeeded'
        }
        else {
            buttonText = 'Add to Quote';  
            msg = 'Adding this part to quote: ' + quoteID;
            // - set button to read 'Add to Quote'
            // - clear hidden variable on form 'approvalNeeded'
        }

        form_PartPricing.dialog({
            buttons :  [{
                            text: "Cancel",
                            id: "button_Cancel",
                            click: function(){
                                form_PartPricing.dialog( "close" );  
                                return false; 
                            }
                        }, 
                        {
                            text: buttonText,
                            id: "button_AddToQuote",   // checkCustomPrice
                            click: function(){
                                // alert(msg);
                                if ( nothingToQuote() ) {
                                    alert("Nothing to quote.");
                                    return false;
                                }

                                var info = {
                                    quote_id:           quoteID,
                                    part_no:            $('#part_no').text(),
                                    approval_needed:    approvalNeeded,

                                    lifecycle:          lifeCycle, 
                                    manufacturer:       $('#manufacturer').val(),   
                                    qty_Available:      $('#total_qty_for_part').val(),

                                    qty_1_24:           $('#qty_1_24').val(),       // val == inputs
                                    qty_25_99:          $('#qty_25_99').val(),
                                    qty_100_499:        $('#qty_100_499').val(),
                                    qty_500_999:        $('#qty_500_999').val(),
                                    qty_1000_Plus:      $('#qty_1000_Plus').val(),  
                                    qty_Base:           $('#qty_Base').val(),
                                    qty_Custom:         $('#qty_Custom').val(), 

                                    price_1_24:         $('#price_1_24').text().replace('$', ''),       // text == spans
                                    price_25_99:        $('#price_25_99').text().replace('$', ''),  
                                    price_100_499:      $('#price_100_499').text().replace('$', ''),
                                    price_500_999:      $('#price_500_999').text().replace('$', ''),        
                                    price_1000_Plus:    $('#price_1000_Plus').text().replace('$', ''),          
                                    price_Base:         $('#price_Base').text().replace('$', ''),   

                                    price_Custom:       $('#price_Custom').val().replace('$', ''),      
                                    comments:           $('#comments').val()
                                };

                                $.ajax({
                                        url: myURL + 'quotes/partsUpdate',
                                        type: 'POST',
                                        data: info, 
                                        dataType: "json",
                                        success: function(data) {
                                            console.log("openQuoteDialog() - AJAX Post: Success - item_id=[" + data.item_id + "] added to Quote.");
                                            Cookies.set('item_added', 1);
                                            location.reload();
                                        },
                                        error: function (jqXHR, textStatus, errorThrown)  {

                                            // for some reason we always come here... doesn't sweem to like the ajax data 
                                            // coming back (see actionPartsUpdate() in QuotesController) - but it's working
                                            // so, we'll just ignore it for now... TODO

                                            console.log("Your Customer Quote could NOT be updated - see Admin (checkCustomPrice)\n\nERROR=" + errorThrown);
                                            console.log("jqXHR" + JSON.stringify(jqXHR) );
                                            Cookies.set('item_added', 1);
                                            location.reload();
                                        } 
                                });

                                form_PartPricing.dialog( "close" );  
                                return false;
                            }
                        } ]
        }); 
    }


    // ------------------------------------------------------------- sub total 
    function getSubTotal(pr,q) {
        if (pr) {
            pr = pr.replace('$','');    pr = pr.replace(',',''); 
        }
        if (q) {
            q = q.replace('$','');  q = q.replace(',',''); q = Math.floor(q);
        }

        return Number(pr) * Number(q);
    }



    function toCurrency(n)  {   
        if ( !n || isNaN(n) ) {
            return '';
        }
        var currency = '$';
        n1 = parseFloat(n);
        var tmp = currency + " " + n1.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
            return tmp; 
    }

    if ( $("#search_typeahead").length == 1 ) {
        $(function() {  // Search for either Customer or Contact using typeahead, autocompletion 
            $( "#search_typeahead" ).autocomplete({
                source: searchURL,
                minLength: 4, 
                close: function() {
                    $('#search_typeahead').val(""); 
                },
                select: function(event,ui) {
                    var selectID = ui.item.value;
                    
                    if ( ui.item.label.match(/\(\d+\)/) === null ) {   // found a contact 
                        resetContactForm();

                        $.ajax({
                            type: 'GET',
                            url: myURL + 'contacts/find?id='+selectID ,
                            success: function (contact_details) {
                            	$('[id^=Customers_]').val('');
                            	display_Contact(contact_details);

                                $.ajax({
                                    type: 'GET',
                                    url: myURL + 'customers/findbycontact?id='+selectID ,
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
                        resetCustomerForm();

                        $.ajax({
                            type: 'GET',
                            url:  myURL + 'customers/find?id='+selectID ,
                            success: function (customer_details) {
                            	$('[id^=Contacts_]').val('');
                            	display_Customer(customer_details);

                                $.ajax({
                                    type: 'GET',
                                    url: myURL + 'contacts/findbycust?id='+selectID ,
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
    }


	function nothingToQuote() {
		var total = 0;
		$('input[id^=qty_]').each(function(k, v) { 
		//$('input[id^=subTotal_]').each(function(k, v) { 
			total += +$(this).val();
		});
		return total===0 ? true : false;
    }

    // ----------------------------------------------------------------------------- Any Qty Input in Dialog
    $('input[id^=qty_]').on('focus',function() {}).on('blur', function() {
        console.log( 'qty_  focus/blur' );
        var elementID = this.id;

        var id = /qty_(.+)$/i.exec( elementID );  id = RegExp.$1;
        var q  = $(this).val();
        var cp = '';

        if (id=='Custom') {
            cp = $('#price_'+id).val();
        }
        else {
            cp = $('#price_'+id).html();
        }

        if ( isNaN(q) ) {
            $(this).val('');
            $('#subTotal_'+id).html('');
            return false;
        }
        
        if ( overMaxAvailable_Dialog( q ) ) {
            alert("That's more than what's available; try again." );
            $(this).val('');
            $('#subTotal_'+id).html('');
            return false;
        }
        else {
            $('#subTotal_'+id).html( toCurrency(getSubTotal(cp,q)) );
        }
    });




    // function appendTable_CurrentParts( info, data ) {
    //     var images        = '';
    //     var itemID        = data.item_id;
    //     var updatingQuote =  window.location.href.match(/update/);

    //     // if ( updatingQuote ) {
    //     //    images =  "<td style='font-size: .9em; padding: 2px;'><img id='item_edit_"+itemID+"' title='Edit this item' src='/iq2/images/New/edit.png' width='16' height='16' /><img id='item_trash_"+itemID+"' title='Delete this item'  src='/iq2/images/New/trash.png' width='16' height='16' />";
    //     // }
    //     // else {
    //     //     images = "<td style='font-size: .9em; padding: 2px;'><img src='/iq2/images/New/blank_20x20.png' width='16' height='16' /><img src='/iq2/images/New/blank_20x20.png' width='16' height='16' />";
    //     // }

    //    images = "<td style='font-size: .9em; padding: 2px;'><img id='item_edit_"+itemID+"' title='Edit this item' src='/iq2/images/New/edit.png' width='16' height='16' /><img id='item_trash_"+itemID+"' title='Delete this item'  src='/iq2/images/New/trash.png' width='16' height='16' />";
    //    //images = "<td style='font-size: .9em; padding: 2px;'><img src='/iq2/images/New/blank_20x20.png' width='16' height='16' /><img src='/iq2/images/New/blank_20x20.png' width='16' height='16' />";

    //     var quantity = 0;
    //     var volume   = 0;
    //     var price    = 0; 
    //     var total    = 0;  // num.toFixed(2)

    //     var comments = truncateWithEllipses(info.comments,100);

    //     if ( info.qty_1_24 > 0 ) {
    //         $('#table_CurrentParts').append( "<tr>"+images+"<td>"+info.part_no+"</td><td>"+info.manufacturer+"</td>  <td>Active</td>  <td>999999</td>     <td>"+info.qty_1_24+"</td><td>$ "+info.price_1_24+"</td>     <td><span class='volume'>1_24</span></td>       <td>$ "+(info.qty_1_24*info.price_1_24).toFixed(2).toString()+"</td><td>"+comments+"</td></tr>" );
    //     }
    //     if ( info.qty_25_99 > 0 ) {
    //         $('#table_CurrentParts').append( "<tr>"+images+"<td>"+info.part_no+"</td><td>"+info.manufacturer+"</td>  <td>Active</td>  <td>999999</td>     <td>"+info.qty_25_99+"</td><td>$ "+info.price_25_99+"</td>    <td><span class='volume'>25_99</span></td>     <td>$ "+(info.qty_25_99*info.price_25_99).toFixed(2).toString()+"</td><td>"+comments+"</td></tr>" );
    //     }
    //     if ( info.qty_100_499 > 0 ) {
    //         $('#table_CurrentParts').append( "<tr>"+images+"<td>"+info.part_no+"</td><td>"+info.manufacturer+"</td>  <td>Active</td>  <td>999999</td>     <td>"+info.qty_100_499+"</td><td>$ "+info.price_100_499+"</td>    <td><span class='volume'>100_499</span></td>     <td>$ "+(info.qty_100_499*info.price_100_499).toFixed(2).toString()+"</td><td>"+comments+"</td></tr>" );
    //     }
    //     if ( info.qty_500_999 > 0 ) {
    //         $('#table_CurrentParts').append( "<tr>"+images+"<td>"+info.part_no+"</td><td>"+info.manufacturer+"</td>  <td>Active</td>  <td>999999</td>     <td>"+info.qty_500_999+"</td><td>$ "+info.price_500_999+"</td>    <td><span class='volume'>500_999</span></td>     <td>$ "+(info.qty_500_999*info.price_500_999).toFixed(2).toString()+"</td><td>"+comments+"</td></tr>" );
    //     }
    //     if ( info.qty_1000_Plus > 0 ) {
    //         $('#table_CurrentParts').append( "<tr>"+images+"<td>"+info.part_no+"</td><td>"+info.manufacturer+"</td>  <td>Active</td>  <td>999999</td>     <td>"+info.qty_1000_Plus+"</td><td>$ "+info.price_1000_Plus+"</td>    <td><span class='volume'>1000_Plus</span></td>     <td>$ "+(info.qty_1000_Plus*info.price_1000_Plus).toFixed(2).toString()+"</td><td>"+comments+"</td></tr>" );
    //     }
    //     if ( info.qty_Base > 0 ) {
    //         $('#table_CurrentParts').append( "<tr>"+images+"<td>"+info.part_no+"</td><td>"+info.manufacturer+"</td>  <td>Active</td>  <td>999999</td>     <td>"+info.qty_Base+"</td><td>$ "+info.price_Base+"</td>    <td><span class='volume'>Base</span></td>     <td>$ "+(info.qty_Base*info.price_Base).toFixed(2).toString()+"</td><td>"+comments+"</td></tr>" );
    //     }
    //     if ( info.qty_Custom > 0 ) {
    //         $('#table_CurrentParts').append( "<tr>"+images+"<td>"+info.part_no+"</td><td>"+info.manufacturer+"</td>  <td>Active</td>  <td>999999</td>     <td>"+info.qty_Custom+"</td><td>$ "+info.price_Custom+"</td>    <td><span class='volume'>Custom</span></td>     <td>$ "+(info.qty_Custom*info.price_Custom).toFixed(2).toString()+"</td><td>"+comments+"</td></tr>" );
    //     }
    // }



    // -------------------------------------------
    // set up sales history click on paginate
    // -------------------------------------------
    function setupOnSalesHistoryClick( pn ) {
        $('#link_SalesHistory').on('click', function() {
            $.ajax({
                  url: '../quotes/sales?ajax=1&pn=' + pn,
                  type: 'GET',
                  success: function(jData, textStatus, jqXHR) {
                        var data = JSON.parse(jData);
                        console.log('link_SalesHistory, data=' + data);

                        $('#form_SalesHistory').html( data );

                        dialog_SalesHistory.dialog('option', 'title', 'Sales History for Part No. ' + pn ); 

                        var buttons = { 
                          "Done": function() { 
                             dialog_SalesHistory.dialog( "close" );  
                             return false; 
                          },
                        }

                        dialog_SalesHistory.dialog("option", "buttons", buttons);
                        dialog_SalesHistory.dialog( "open" );
                        return false; 

                  },
                  error: function (jqXHR, textStatus, errorThrown)  {
                        console.log("Couldn't retrieve sales history for this part; error=" + errorThrown);
                        alert("Couldn't retrieve sales history for this part; error=" + errorThrown);
                  } 
            });

            return false;

        });
    }




    // -------------------------------------------
    // set up quote history click on paginate
    // -------------------------------------------
    function setupOnQuoteHistoryClick( pn ) {
        $('#link_DataSheet > a').on('click', function() {
            var href = $(this).attr('href');
            if ( href == '#' ) {
                alert('No datasheet available for this part');
            }
        });

        $('#link_QuoteHistory').on('click', function() {
            $.ajax({
                  url: '../quotes/history?ajax=1&pn=' + pn,
                  type: 'GET',
                  success: function(jData, textStatus, jqXHR) {
                        console.log('link_QuoteHistory data=' + jData);
                        //return false;
                        
                        var data = JSON.parse(jData);
                        console.log('data=' + data);

                        $('#form_QuoteHistory').html( data );

                        dialog_QuoteHistory.dialog('option', 'title', 'Quote History for Part No. ' + pn ); 

                        var buttons = { 
                          "Done": function() { 
                             dialog_QuoteHistory.dialog( "close" );  
                             return false; 
                          },
                        }

                        dialog_QuoteHistory.dialog("option", "buttons", buttons);
                        dialog_QuoteHistory.dialog( "open" );
                        return false; 

                  },
                  error: function (jqXHR, textStatus, errorThrown)  {
                        console.log("Couldn't retrieve quote history for this part; error=" + errorThrown);
                        alert("Couldn't retrieve quote history for this part; error=" + errorThrown);
                  } 
            });
            return false;
        });
    }




	function openQuoteDialog(results) {
		$('#form_PartPricing').html(results);

		var quoteID    = $('#form_QuoteID').val();
		var msg        = 'Adding this part to Quote No. [' + quoteID + ']';
        var info       = '';
        var lifeCycle  = $('#lifeCycle').text();
        var dist_price = $('#price_Base').text(); 
        var partNo     = $('#part_no').text();

        var floor      = $('#distributor_price_floor').val();  // 75% usually - make this configurable

        console.log('** openQuoteDialog() - lifeCycle=['+lifeCycle+'], floor=['+floor+'],  dist_price=['+dist_price+']');



        // var min_custom_price = $('#min_custom_price').html().substring(1).trim(); // ignore first character of '$' and leading spaces...
        // var diff =  parseFloat(min_custom_price) - parseFloat(cp);
        // console.log('checking diff between: [ ' + min_custom_price + ' ] and [ ' + parseFloat(cp) + ' ]');
        // var approvalNeeded =  ( diff > 0 ? 1 : 0 );


        /*
            if item is "Active", needs Approval if "cp" less than 'distributor_price'
            if item is 'Obsolete', needs Approval if "cp" less than 75% of 'distributor_price'
        */

        if ( lifeCycle == lifeCycle_ACTIVE )  {
            console.log('Part is Active');
            $('#dialog_min_custom_price').text( dist_price ); 
            $('#dialog_min_custom_price_comment').text( '(Distributor Price)' );
        }
        else if ( lifeCycle == lifeCycle_OBSOLETE )  {
            var new_min = parseFloat(floor) * parseFloat(dist_price.substring(1).trim());
            console.log('Part is Obsolete');
            $('#dialog_min_custom_price').text( toCurrency(new_min) );
            $('#dialog_min_custom_price_comment').text(  '(' + floor*100  + '% of Distributor Price)'  );
        }
        else {
             $('#special_note').hide(); 
        }

		dialog_PartPricing.dialog('option', 'title', 'Inventory Part Pricing Details'); 
        setupOnQuoteHistoryClick( partNo );
        setupOnSalesHistoryClick( partNo );

		dialog_PartPricing.dialog({
			buttons :  [{
							text: "Cancel",
							id: "button_Cancel",
							click: function(){
                                // Cookies.set('item_cancel', 1);
                                // location.reload();
								dialog_PartPricing.dialog( "close" );  
			 				   	return false; 
							}
						}, 
						{
							text: "Add to Quote",
							id: "button_AddToQuote",  // openQuoteDialog
							click: function(){
								//alert(msg);
								if ( nothingToQuote() ) {
				             		alert("Nothing to quote.");
				             		return false;
				             	}
								
								info = {
        									quote_id:			quoteID,
        									part_no: 			partNo,
        									approval_needed: 	0,

        									manufacturer: 		$('#manufacturer').val(),
                                            lifecycle:          $('#lifeCycle').text(),	
        									qty_Available:      $('#total_qty_for_part').val(),

        									qty_1_24: 			$('#qty_1_24').val(),		// val == inputs
        									qty_25_99: 			$('#qty_25_99').val(),

        									qty_100_499: 		$('#qty_100_499').val(),
        									qty_500_999: 		$('#qty_500_999').val(),
        									
                                            qty_1000_Plus: 		$('#qty_1000_Plus').val(),	
        									qty_Base: 			$('#qty_Base').val(),
        									
                                            qty_Custom: 		$('#qty_Custom').val(),	

        									price_1_24: 		$('#price_1_24').text().replace('$', ''),		// text == spans
        									price_25_99: 		$('#price_25_99').text().replace('$', ''),	
        									price_100_499: 		$('#price_100_499').text().replace('$', ''),
        									price_500_999: 		$('#price_500_999').text().replace('$', ''),		
        									price_1000_Plus: 	$('#price_1000_Plus').text().replace('$', ''),			
        									price_Base: 		$('#price_Base').text().replace('$', ''),	

        									price_Custom: 		$('#price_Custom').val().replace('$', ''),
        									comments: 			$('#comments').val()				
								};

								// iq2_main.js
								$.ajax({ 
										url: myURL + 'quotes/partsUpdate' ,
										type: 'POST',
										data: info, 
										dataType: "json",
										success: function(data, textStatus, jqXHR) {
											console.log("openQuoteDialog() - AJAX Post: Success - item_id=[" + data.item_id + "] added to Quote.");
                                            Cookies.set('item_added', 1);
                                            location.reload();






                                            // if ( $('#selectedParts').html() === '' ) {
                                            //     $('#selectedParts').html(  'Item(s) added to quote: ' + $('#part_no').text());
                                            // }
                                            // else {
                                            //     $('#selectedParts').append(  ', ' + $('#part_no').text());
                                            // }

                                            // appendTable_CurrentParts(info, data);
                                            // $('#div_PartsLookup').hide();
                                            // addEventsToItems();
										},
										error: function (data, textStatus, errorThrown)  {
											console.log("AJAX Post: FAIL! error:"+errorThrown);
                                            alert("Your Customer Quote could NOT be updated ("+data.item_id+") - see Admin (openQuoteDialog)\n\nERROR=" + errorThrown);
										} 
								});

								dialog_PartPricing.dialog( "close" );  
								return false;
							}
						} ]
		});
	
		dialog_PartPricing.dialog( "open" );
	}


	function displayPartDetails(that) {
		var tmp = /^rowID_(.+)$/.exec( that[0].id);
		var partNo = tmp[1];
        var item   = encodeURIComponent(partNo.trim().toUpperCase());       // >>>>>>>  THE ONLY PLACE WE NEED TO USE "encodeURIComponent()"
        var url    = myURL + 'parts/search?item=' +  item + '&dialog=1';   
        console.log('url=['+url+']'); 

		$.ajax({
                type: 'GET',
                url: url,
                success: function (results) {
                	openQuoteDialog(results);
                }
        });
	}

    function displayPartLookupResults(res) {
    	var a          = JSON.parse(res);
    	var partsCount = a.parts.length; 
    	var rows       = '';
        // var quoteID    = $('#Quotes_id').val(); 

    	for( var i=0; i<partsCount; i++ ) {
    		rows += "<tr id='rowID_"+a.parts[i].part_number+"'>";

            rows += "<td>"+ a.parts[i].part_number + "</td>";
            rows += "<td>"+ ( a.parts[i].build == 1 ? 'Build to Order' : 'Stock') + "</td>"; 
    		rows += "<td>"+ ( a.parts[i].manufacturer ? a.parts[i].manufacturer : 'n/a' )+"</td>";
    		rows += "<td>"+ ( a.parts[i].supplier ? a.parts[i].supplier : 'n/a' )+"</td>";
	   		
            rows += "<td>"+ ( a.parts[i].se_data.Lifecycle ? a.parts[i].se_data.Lifecycle : 'n/a' )+"</td>";

    		rows += "<td>"+ ( a.parts[i].drawing ? a.parts[i].drawing : 'n/a' )+"</td>";
    		rows += "<td>"+ ( a.parts[i].carrier_type ? a.parts[i].carrier_type : 'n/a' )+"</td>";
    		rows += "<td>"+ ( a.parts[i].mpq ? a.parts[i].mpq : 'n/a' )+"</td>";
    		rows += "<td>"+ ( a.parts[i].total_qty_for_part ? a.parts[i].total_qty_for_part : 'n/a' )+"</td>";
    		rows += "</tr>";
    	}

        // this is where a click on 'rowID_' is detected...
    	$('#results_table thead').after('<tbody>'+rows+'</tbody>');

        if ( ResultsTable === null ) {  // don't reinitilaize more than once 
            // set up DataTable on Results table - from parts lookup
        	ResultsTable = $('#results_table').DataTable({
    			"iDisplayLength": 10,
    			drawCallback: function() {
    		        var api = this.api();
    		        api.$('#results_table > tbody > tr').click(function() {                       // #rowID_55551\2f BXA
                        var inventoryStatus = $(this).find('td:nth-child(2)').text();
                        console.log('Inventory Status: ' + inventoryStatus );

                        var partNo      = $(this).find('td:nth-child(1)').text();
                        var mfg         = $(this).find('td:nth-child(3)').text();
                        var quoteTypeID = $('#quoteTypeID').val();

                        if ( inventoryStatus === 'Build to Order' ) {
                            if ( quoteTypeID == STOCK_QUOTE ) {
                                alert("Part No. "+partNo+" is Build to Order only; you cannot add this to a Stock Quote.");
                                location.reload();
                                return false;
                            }
                            else if ( confirm("Part No. "+partNo+" is Build to Order only; continue?") ) {

                                var postData = {
                                        requested_part_number:  partNo,
                                        mfg:                    mfg,
                                        quote_id:               quoteID,
                                };

                                $.ajax({
                                        type: "POST",
                                        url: myURL + 'btoItems/create',
                                        data: postData,
                                        success: function(results)  {
                                            console.log('results from create BtoItem: ['+results+']');
                                            Cookies.set('current_tab', TAB_Details-1);  // 0-indexed 
                                            location.reload();
                                        }
                                });



                                // Old code... leaving here for now for reference
                                /*
                                        showManufacturingTabs();
                                        $('#QuoteView_Tabs').tabs({ active: 3 });
                                        //$('#header_PageTitle').text('Updating Manufacturing Quote No.');

                                        var postData = {
                                                newQuoteTypeID:         MANUFACTURING_QUOTE,
                                                requested_part_number:  partNo,
                                                mfg:                    mfg,
                                        };
                                         $.ajax({
                                                type: "POST",
                                                url: myURL + 'quotes/update?id=' + quoteID,
                                                data: postData,
                                                success: function(results)  {
                                                    console.log('results from update quote type: ['+results+']');
                                                    //$('#mfg_quote_details').html("results from update quote type: " + results);
                                                    location.reload();
                                                }
                                        });
                                */


                            }
                            else {
                                location.reload();
                            }

                                                // var partNo = $(this).find('td:nth-child(1)').text();

                                                // if ( confirm("Part No. "+partNo+" is Build to Order only.\nContinue processing as a Manufacturing Quote?") ) {
                                                //     Cookies.remove('item_added');
                                                //     showManufacturingTabs();
                                                   
                                                //     $('#header_PageTitle').text('Updating Manufacturing Quote No.');
                                                //     console.log('current url: ' + window.location.href);
                                                //     //window.location = window.location.href + '?i=' + Math.floor((Math.random() * 100000000) + 1) + '&bto';

                                                //     // update quote type to 'Manufacturing'
                                                //     var postData = {
                                                //             newQuoteTypeID: MANUFACTURING_QUOTE,
                                                //     };

                                                //     $.ajax({
                                                //             type: "POST",
                                                //             url: myURL + 'quotes/update?id=' + quoteID,
                                                //             data: postData,
                                                //             success: function(results)  {
                                                //                 console.log('results from update quote status: ['+results+']');
                                                //                 Cookies.set('current_tab', 0); 
                                                //                 location.reload();
                                                //             }
                                                //     });
                                                // }
                        }
                        else {
                            displayPartDetails( $(this) ); 
                        }
    		        });
    		    }
    		});
        }
        console.log('ResultsTable is NOT null...');



    }    // END_OF_FUNCTION displayPartLookupResults()





    function consoleDisplayFormFields(f) {
        $.each( f, function(i,f) {
            $.each( f, function( k,v) {
               // console.log("k=["+k+"], id=["+v.id+"], name=["+v.name+"], value=["+v.value+"]");
                console.log(v.id+" =\t["+v.value+"]");
            });
        });
    }


    function formValidated() {
        consoleDisplayFormFields($('#quoteAddForm'));

    	if (   $('#Customers_name').val()       != '' && 
               $('#Customers_address1').val()   != '' && 
               $('#Customers_city').val()       != '' && 
               $('#Customers_country_id').val() != '' && 
               $('#Quotes_source_id').val()      > 0  && 
               $('#Contacts_first_name').val()  != '' && 
               $('#Contacts_last_name').val()   != '' && 
               $('#Contacts_email').val()       != '' && 
               $('#Contacts_title').val()       != '' &&
               $('#Contacts_phone1').val()      != '' ) {
            return true;
    	}
    	return false;
    }

    function display_Customer(data) {
      var o = JSON.parse(data);    
        $.each( o, function( k, v ) {
        	//console.log("display_Customers_: k=["+k+"], v=["+v+"]");
           	$('#Customers_'+k).html( v );
            $('#Customers_'+k).val( v );
        });
    }

    function display_Contact(data) {
    	var o = JSON.parse(data);    
        $.each( o, function( k, v ) {
        	 // console.log("Contacts_: k=["+k+"], v=["+v+"]");
           	$('#Contacts_'+k).html( v );
            $('#Contacts_'+k).val( v );
        });
    }

    // function toggleHeading() {
    //     $('#heading_container_left').toggle();
    //     $('#span_SelectCustomer').toggle();
    //     $('#span_SelectContact').toggle();  
    //     $('#span_NewCustomer').toggle();
    //     $('#span_NewContact').toggle();
    // }

    function display_CustomerSelect( data ) {	// ok
    	$('#Customers_select').empty();
    	$('#Customers_select').append( $('<option></option>' ).val(0).html('') );;

    	var o = JSON.parse(data); 
        $('#Customers_select').append( $('<option></option>' ).val(0).html('') );
    	$.each( o, function(k,v) {
            $('#Customers_select').append( $('<option></option>' ).val(v.id).html(v.label) );
            // console.log("display_CustomerSelect() - id=["+ v.id + "], label=[" + v.label + "]");
        });

    	$('#heading_container_left').show();
    	$('#span_SelectCustomer').show();
    	$('#span_SelectContact').hide();  
        $('#span_NewCustomer').show();
        $('#span_NewContact').hide();
        // toggleHeading();

    }

 	function display_ContactSelect( data ) {	// ok
 		$('#Contacts_select').empty();
 		$('#Contacts_select').append( $('<option></option>' ).val(0).html('') );

 		var o = JSON.parse(data); 
        $('#Contacts_select').append( $('<option></option>' ).val(0).html('') );
    	$.each( o, function(k,v) {
            $('#Contacts_select').append( $('<option></option>' ).val(v.id).html(v.label) );
            // console.log("display_ContactSelect() - id=["+ v.id + "], label=[" + v.label + "]");
        });

    	$('#heading_container_left').show();
    	$('#span_SelectCustomer').hide();
    	$('#span_SelectContact').show(); 
        $('#span_NewCustomer').hide();
        $('#span_NewContact').show();
        // toggleHeading();
    }

	function getThisID( that ) {
        return /\d+$/.exec( $(that).attr('id') );
    }

});

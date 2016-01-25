$(document).ready(function() {

    var myURL           = getAbsolutePath();      //alert('myURL=['+myURL+']');
    var customerPrefill = true;
    var contactPrefill  = true;
    var searchURL       = myURL + 'search';
    var CUSTOMER = 1;
    var CONTACT  = 2;

    resetCustomerForm();
    resetContactForm();
    disableCustomerForm();
    disableContactForm();


    $('#reset_form').on('click', function() {
        location.reload();
    });

    $('#add_quote').on('click', function() {
        window.location = myURL + 'create';
    });



    // ---------------------------------------------------- Select from available customers
    $('#Customer_select').on('change', function () {
        var custID = $(this).val();
        $.ajax({
            type: 'GET',
            url: '../customers/find?id='+custID,
            success: function (ret) {
                displayCustomer(ret);
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
                displayContact(ret)
            }
        });
    });






    //---------------------------------------------------------------------------------------------------------------------
    //-------- Functions --------------------------------------------------------------------------------------------------    
    //---------------------------------------------------------------------------------------------------------------------
    function getAbsolutePath() {
        var loc = window.location;
        var pathName = loc.pathname.substring(0, loc.pathname.lastIndexOf('/') + 1);
        return loc.href.substring(0, loc.href.length - ((loc.pathname + loc.search + loc.hash).length - pathName.length));
    }

    function resetCustomerForm() {
        $('[id^=Customer_]').val('');
        $('span[id^=Customer_]').remove();
        $('select[id^=Customer_]').each( function() {
            $(this).show();
            //$(this).prop('disabled', 'disabled');
        });
    }

    function resetContactForm() {
        $('[id^=Contact_]').val('');
        $('span[id^=Contact_]').remove();
        $('select[id^=Contact_]').each( function() {
            $(this).show();
           // $(this).prop('disabled', 'disabled');
        });
    }

    $(function() {  // typeahead, autocompletion 
        $( "#search_typeahead" ).autocomplete({
            source: searchURL,
            minLength: 4, 
            close: function() {
                $('#search_typeahead').val("");  
            },
            select: function(event,ui) {
                var selectID = ui.item.value;
                
                if ( ui.item.label.match(/\(\d+\)/) == null ) {   // contact id
                    $.ajax({
                        type: 'GET',
                        url: '../contacts/find?id='+selectID,
                        success: function (ret) {
                            $.ajax({
                                type: 'GET',
                                url: '../customers/findbycontact?id='+selectID,
                                success: function (res) {
                                    fillCustomerSelect(res);
                                    // displayContact(ret);
                                }
                            });
                        },
                        error: function (jqXHR, textStatus, errorThrown)  {
                            console.log('Error in searching for contact id: '+selectID+', msg= '+errorThrown);
                        } 
                    });
                }
                else {                  // customer id
                    $.ajax({
                        type: 'GET',
                        url: '../customers/find?id='+selectID,
                        success: function (ret) {
                            $.ajax({
                                type: 'GET',
                                url: '../contacts/findbycust?id='+selectID,
                                success: function (res) {
                                    fillContactSelect(res); 
                                    // displayCustomer(ret);
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


    function fillCustomerSelect(data) {
        console.log('Customer select options: '+data);
        var o = JSON.parse(data); 

        $.each( o, function(k,v) {
            $('#Customer_select').append( $('<option></option>' ).val(v.id).html(v.label) );
            console.log("id=["+ v.id + "], label=[" + v.label + "]");
        });

        $('#customer_span_text').hide();
        $('#customer_span_select').show();
       
        $('#contact_heading').hide();
        $('#customer_heading').show();
    }



 
   function fillContactSelect(data) {
        console.log('Contact select options: '+data);
        var o = JSON.parse(data); 

        $.each( o, function(k,v) {
            $('#Contact_select').append( $('<option></option>' ).val(v.id).html(v.label) );
            console.log("id=["+ v.id + "], label=[" + v.label + "]");
        });

        $('#contact_span_text').hide();
        $('#contact_span_select').show();

        $('#customer_heading').hide();
        $('#contact_heading').show();
    }


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

    function displayCustomer(data) {
        // refactor this
        $('#contact_span_text').hide();
        $('#contact_span_select').show();

        $('#customer_heading').hide();
        $('#contact_heading').show();

        // $('#customer_span_text').show();
        // $('#customer_span_select').hide();



        resetContactForm();
        resetCustomerForm();

        var o = JSON.parse(data);       // get select names from o.state_id_text, o.territory_id_text, etc.
        $.each( o, function( k, v ) {

            $('#Customer_select').append( $('<option></option>' ).val(v.id).html(v.label) );


            if ( $('#Customer_'+k).is('select') ) {
                var selectedText =  o[k+'_text']; 
                $("<span style='font-size: .8em;' id='Customer_"+k+"_label'>"+selectedText+"<input type='hidden' id='Customer_"+k+"' name='Customer_"+k+"' value='"+v+"'></input></span>").insertAfter('#Customer_'+k);
            }
            else {
                $('#Customer_'+k).html( v );
                $('#Customer_'+k).val( v );
            }
        });

        showCustomerLabels(true);
        showContactLabels(false);
    }  

    function displayContact(data) {
        // refactor this
        $('#customer_span_text').hide();
        $('#customer_span_select').show();
       
        $('#contact_heading').hide();
        $('#customer_heading').show();

        // $('#contact_span_text').show();
        // $('#contact_span_select').hide();


        resetCustomerForm();

        var o = JSON.parse(data);      // get select names from o.state_id_text, o.territory_id_text, etc.
        $.each( o, function( k, v ) {

            $('#Contact_select').append( $('<option></option>' ).val(v.id).html(v.label) );

            if ( $('#Contact_'+k).is('select') ) {
                var selectedText =  o[k+'_text']; 
                $("<span style='font-size: .8em;' id='Contact_"+k+"_label'>"+selectedText+"<input type='hidden' id='Contact_"+k+"' name='Contact_"+k+"' value='"+v+"'></input></span>").insertAfter('#Contact_'+k);
            }
            else {
                $('#Contact_'+k).html( v );
                $('#Contact_'+k).val( v );
            }
        });

        showContactLabels(true);
        showCustomerLabels(false);
    }  

    function getThisID( that ) {
        return /\d+$/.exec( $(that).attr('id') );
    }

    // refactor into 1 function ? 
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





});

















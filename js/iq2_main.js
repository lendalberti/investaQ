$(document).ready(function() {

	$('#add_quote').on('click', function() {
		alert('adding a new quote...');
	});


	// DataTable
    var table = $('#quotes_table').DataTable({"iDisplayLength": 10 });
    // Apply the filters
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




















});

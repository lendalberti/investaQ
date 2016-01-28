
<div style='height: 50px; border: 0px solid gray;'>
	<div style='color: #2C6371;  font-size: 2em; border: 0px solid green; float: left; padding-right: 10px;' id='header_PageTitle'>Start a New Quote</div>
	<!-- <div style='color: #a31128;  font-size: 1.8em; border: 0px solid red; float: right;' id='header_QuoteNo'> </div> -->
	<div style='color: #a31128;  font-size: 1.5em; border: 0px solid red; font-family: courier.;padding-top:  5px; font-family: courier.;padding-top:  5px;' id='header_QuoteNo'> </div>

	<input type='hidden' id='form_QuoteID' name='form_QuoteID' value=''>

</div>





<p class="note">Fields with <span class="required">*</span> are required.</p>

<?php echo $this->renderPartial( '_form', array('data'=>$data) ); ?> 
<!-- < ?php echo $this->renderPartial( '_test_form', array('data'=>$data) ); ?>  -->


<!-- 
< ?php echo $this->renderPartial( '_formCustomer', array('modelCustomers'=>$data['modelCustomers']) ); ?> 
< ?php echo $this->renderPartial( '_formContact', array('modelContacts'=>$data['modelContacts']) ); ?> 
< ?php echo $this->renderPartial( '_formQuote', array('modelQuotes'=>$data['modelQuotes']) ); ?>  
-->

<div style='height: 50px; border: 0px solid gray;'>
	<div style='color: #2C6371;  font-size: 2em; border: 0px solid green; float: left;' id='header_PageTitle'>Start a New Quote</div>
	<div style='color: #a31128;  font-size: 1.8em; border: 0px solid red;float: right;' id='header_QuoteNo'> </div>
</div>





<p class="note">Fields with <span class="required">*</span> are required.</p>

<?php echo $this->renderPartial( '_form', array('data'=>$data) ); ?> 
<!-- < ?php echo $this->renderPartial( '_test_form', array('data'=>$data) ); ?>  -->


<!-- 
< ?php echo $this->renderPartial( '_formCustomer', array('modelCustomers'=>$data['modelCustomers']) ); ?> 
< ?php echo $this->renderPartial( '_formContact', array('modelContacts'=>$data['modelContacts']) ); ?> 
< ?php echo $this->renderPartial( '_formQuote', array('modelQuotes'=>$data['modelQuotes']) ); ?>  
-->
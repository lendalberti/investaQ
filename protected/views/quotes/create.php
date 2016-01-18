<h1>Start a New Quote</h1>
<p class="note">Fields with <span class="required">*</span> are required.</p>

<?php echo $this->renderPartial( '_form', array('data'=>$data) ); ?> 


<!-- 
< ?php echo $this->renderPartial( '_formCustomer', array('modelCustomers'=>$data['modelCustomers']) ); ?> 
< ?php echo $this->renderPartial( '_formContact', array('modelContacts'=>$data['modelContacts']) ); ?> 
< ?php echo $this->renderPartial( '_formQuote', array('modelQuotes'=>$data['modelQuotes']) ); ?>  
-->
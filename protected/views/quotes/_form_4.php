<?php $this->layout = '//layouts/column1'; ?>


<style>

div.my_container {
	padding: 5px;
	border-top: 1px solid gray;
	height: 100%; 
	overflow: auto;
}

div.my_container > div {
	float: left;
	padding: 10px;
	width: 25%;
	margin: 2px;
}

div.my_container > div > table > tbody > tr > td {
	font-size: .8em;
}

div.my_container > div > table > tbody > tr > td:nth-child(odd) {
	text-align: right;
	font-weight: bold;
}

#box1 {
   border: 0px solid orange;
   width: 30%;
}

#box2 {
	border: 0px solid green;
	width: 30%;
}

#box3 {
		border-left: 1px solid lightgray; 	
	/*border: 1px solid blue;*/
	margin-left: 30px;
	width: 28%;
}




</style>

<div style='padding: 10px 0px 10px 0px;'>
	<span style='padding-left: 50px;'><span class='required'> * </span>Contact Source
		<select name='Quote[source_id]' id='Quote_source_id'>
			<?php
				echo "<option value='0'></option>";
				foreach( $data['sources'] as $c ) {
					echo "<option value='".$c->id."'>".$c->name."</option>";
				}
			?>
		</select>
	</span>
	<span style='padding-left: 120px;'><input type='text' name='Search[typeahead]' id='search_typeahead' size='40' placeholder='Search for...'/> </span>
</div>


<div class='my_container'>

	<span style='text-align: center; float: left;  width: 60%; font-weight: bold; '> Customer </span>
	<span style='text-align: center; float: right; width: 30%; font-weight: bold;'> Contact </span>

   <div id="box1">
      <table>
      	<tr>  <td>Name</td>  			<td><input type='text'></td> </tr>
      	<tr>  <td>Address1</td>  		<td><input type='text'></td> </tr>
      	<tr>  <td>Address2</td>  		<td><input type='text'></td> </tr>
      	<tr>  <td>City</td>  			<td><input type='text'></td> </tr>
      	<tr>  <td>US State</td> 	    <td><input type='text'></td> </tr>
      	<tr>  <td>Country</td>     	    <td><input type='text'></td> </tr>
      	<tr>  <td>Zip/Postal Code</td>  <td><input type='text'></td> </tr>
      	<tr>  <td>Region</td>  		    <td><input type='text'></td> </tr>
      	<tr>  <td>Customer Type</td>  	<td><input type='text'></td> </tr>
      	<tr>  <td>Territory</td> 	    <td><input type='text'></td> </tr>
      </table>
   </div>

   <div id="box2">
       <table>
       		<tr>  <td>Vertical Market</td>  	<td><input type='text'></td> </tr>
	      	<tr>  <td>Parent</td>  				<td><input type='text'></td> </tr>
	      	<tr>  <td>Company Link</td>  		<td><input type='text'></td> </tr>
	      	<tr>  <td>SYSPRO Account Code</td>  <td><input type='text'></td> </tr>
	      	<tr>  <td>Xmas List</td>  			<td><input type='text'></td> </tr>
	      	<tr>  <td>Candy List</td>  			<td><input type='text'></td> </tr>
	      	<tr>  <td>Strategic</td>  			<td><input type='text'></td> </tr>
	      	<tr>  <td>Tier</td>  				<td><input type='text'></td> </tr>
	      	<tr>  <td>Inside Salesperson</td>  	<td><input type='text'></td> </tr>
	      	<tr>  <td>Outside Salesperson</td>  <td><input type='text'></td> </tr>
      </table>
   </div>

 	<div id="box3">
      <table>
      	<tr>  <td>First Name</td>  		<td><input type='text'></td> </tr>
      	<tr>  <td>Last Name</td>  		<td><input type='text'></td> </tr>
      	<tr>  <td>Email</td>  			<td><input type='text'></td> </tr>
      	<tr>  <td>Title</td>  			<td><input type='text'></td> </tr>
      	<tr>  <td>Phone1</td>  			<td><input type='text'></td> </tr>
      	<tr>  <td>Phone2</td>  			<td><input type='text'></td> </tr>
      	<tr>  <td>Address1</td>  		<td><input type='text'></td> </tr>
      	<tr>  <td>Address2</td>  		<td><input type='text'></td> </tr>
      	<tr>  <td>City</td>  			<td><input type='text'></td> </tr>
      	<tr>  <td>State</td>  			<td><input type='text'></td> </tr>
      	<tr>  <td>Zip/Postal Code</td>  <td><input type='text'></td> </tr>
      	<tr>  <td>Country</td>  		<td><input type='text'></td> </tr>
      </table>	
   </div>


</div>


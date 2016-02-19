
<!-- <div id='mfg_quote_details'>mfg details go here...</div> -->

<!--  make 2 columns  -->


	<div style='border: 0px solid blue; height: 100%; overflow: auto; '>

		<div style='border: 0px solid green; margin: 20px 0px 0px 60px; float: left; width: 40%;'>

			<table id='mfg_details'>
				<tr>   <td>Business Class</td>     		<td><input id='' name='' /></td> </tr>
				<tr>   <td>Priority</td>     			<td><input id='' name='' /></td> </tr>
				<tr>   <td>Order Probability</td>     	<td><input id='' name='' /></td> </tr>
				<tr>   <td>Requested Part Number</td>   <td><input id='' name='' /></td> </tr>
				<tr>   <td>Generic Part Number</td>     <td><input id='' name='' /></td> </tr>
				<tr>   <td>Quantity</td>     			<td><input id='' name='' /></td> </tr>
				<tr>   <td>Die Manufacturer</td>     	<td><input id='' name='' /></td> </tr>
				<tr>   <td>Package Type</td>     		<td><input id='' name='' /></td> </tr>
				<tr>   <td>Lead Count</td>     			<td><input id='' name='' /></td> </tr>
			</table>

		</div>

		<div style='border: 0px solid orange; margin: 20px 60px 0px 0px; float: right; width: 40%;'>

			<table id='mfg_details'>
				<tr>   <td>Temp Low</td>     <td><input id='' name='' /></td> </tr>
				<tr>   <td>Temp High</td>     <td><input id='' name='' /></td> </tr>
				<tr>   <td>Process Flow</td>     <td><input id='' name='' /></td> </tr>
				<tr>   <td>Testing</td>     <td><input id='' name='' /></td> </tr>
				<tr>   <td>NCNR</td>     <td><input id='' name='' /></td> </tr>
				<tr>   <td>ITAR</td>     <td><input id='' name='' /></td> </tr>
				<tr>   <td>Have Die</td>     <td><input id='' name='' /></td> </tr>
				<tr>   <td>SPA</td>     <td><input id='' name='' /></td> </tr>
				<tr>   <td>Recreation</td>     <td><input id='' name='' /></td> </tr>
				<tr>   <td>Wip Product</td>     <td><input id='' name='' /></td> </tr>
			</table>

		</div>
	</div>


<!-- 

<pre>

	Business Class			Broker
	Priority				Low Medium High
	Order Probability		(Low) 5% 10% 15% 20% 25% 30% 35% 40% 45% 50% ... 100% (high) 

	Requested Part Number	MC68HC711E9CFS2
	Generic Part Number		MC68HC711E9CFS2
	Quantity				500000

	Die Manufacturer		ADG (Analog Devices)            //  min 3 char search, autocompletion?
	Package Type			BGA
	Lead Count				128

	Process Flow			/B
	Testing					Datasheet

	Temp Low				35 (Celsius/Fahrenheit)
	Temp High				80

	NCNR					Yes/No
	ITAR					Yes/No
	Have Die				Yes/No
	SPA						Yes/No
	Recreation				Yes/No
	Wip Product				Yes/No

</pre>


< ?php

	$mfgs = 'http://lenscentos/iq2/protected/data/mfgs.inc'; //Yii::app()->baseUrl . '/protected/data/mfgs.inc';
	$m = json_decode( file_get_contents( $mfgs ) );
	$arrIt = new RecursiveIteratorIterator(new RecursiveArrayIterator($m));

	$searchFor = 'Panasonic';

	foreach ($arrIt as $sub) {
		$subArray = $arrIt->getSubIterator();
		// if ($subArray['mfgId'] === $searchFor) {

		if ( strlen(stristr($subArray['mfgId'] ,$searchFor)) > 0  ) {
			$outputArray[] = iterator_to_array($subArray);
		}
	}

	//if ( count( $outputArray ) === 0 ) {
		foreach ($arrIt as $sub) {
			$subArray = $arrIt->getSubIterator();
			//if ($subArray['mfgName'] === $searchFor) {
			if ( strlen(stristr($subArray['mfgName'] ,$searchFor)) > 0  ) {
				$outputArray[] = iterator_to_array($subArray);
			}
		}
	//}

	echo '<pre>['; print_r( $outputArray ); echo ']</pre>';

?>
 -->
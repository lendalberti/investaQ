<?php
require('rotation.php');

class PDF extends PDF_Rotate {
	function Header() {
		//Put the watermark
		$this->SetFont('Arial','B',50);
		$this->SetTextColor(255,192,203);
		$this->RotatedText(35,190,'P e n d i n g   A p p r o v a l',45);
	}

	function RotatedText($x, $y, $txt, $angle) {
		//Text rotated around its origin
		$this->Rotate($angle,$x,$y);
		$this->Text($x,$y,$txt);
		$this->Rotate(0);
	}
}

?>
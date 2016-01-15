<?php
// define('FPDF_FONTPATH','fpdf17/font');
// require('fpdf17/fpdf.php');

class PDF extends FPDF {

    const   BLACK         = 0,
            ROCHESTER_RED = 1,
            DEEP_BLUE     = 2,
            ACTION_BLUE   = 3,
            BRIGHT_RED    = 4,
            COOL_GRAY     = 5,
            CHARCOAL      = 6;

    public $userProfile = '';
    private $pallette = array();
    private $widths;
    private $aligns;
    private $quote_expiration_date; 

    // ---------------------------------------------------- Alpha transparency
        var $extgstates = array();

        // alpha: real value from 0 (transparent) to 1 (opaque)
        // bm:    blend mode, one of the following:
        //          Normal, Multiply, Screen, Overlay, Darken, Lighten, ColorDodge, ColorBurn,
        //          HardLight, SoftLight, Difference, Exclusion, Hue, Saturation, Color, Luminosity
        function SetAlpha($alpha, $bm='Normal')
        {
            // set alpha for stroking (CA) and non-stroking (ca) operations
            $gs = $this->AddExtGState(array('ca'=>$alpha, 'CA'=>$alpha, 'BM'=>'/'.$bm));
            $this->SetExtGState($gs);
        }

        function AddExtGState($parms)
        {
            $n = count($this->extgstates)+1;
            $this->extgstates[$n]['parms'] = $parms;
            return $n;
        }

        function SetExtGState($gs)
        {
            $this->_out(sprintf('/GS%d gs', $gs));
        }

        function _enddoc()
        {
            if(!empty($this->extgstates) && $this->PDFVersion<'1.4')
                $this->PDFVersion='1.4';
            parent::_enddoc();
        }

        function _putextgstates()
        {
            for ($i = 1; $i <= count($this->extgstates); $i++)
            {
                $this->_newobj();
                $this->extgstates[$i]['n'] = $this->n;
                $this->_out('<</Type /ExtGState');
                $parms = $this->extgstates[$i]['parms'];
                $this->_out(sprintf('/ca %.3F', $parms['ca']));
                $this->_out(sprintf('/CA %.3F', $parms['CA']));
                $this->_out('/BM '.$parms['BM']);
                $this->_out('>>');
                $this->_out('endobj');
            }
        }

        function _putresourcedict()
        {
            parent::_putresourcedict();
            $this->_out('/ExtGState <<');
            foreach($this->extgstates as $k=>$extgstate)
                $this->_out('/GS'.$k.' '.$extgstate['n'].' 0 R');
            $this->_out('>>');
        }

        function _putresources()
        {
            $this->_putextgstates();
            parent::_putresources();
        }
    // ---------------------------------------------------- Alpha transparency

    // ------------------------------------------------------ Watermark
        function Rotate($angle,$x=-1,$y=-1)  {
            if($x==-1)
                $x=$this->x;
            if($y==-1)
                $y=$this->y;
            if($this->angle!=0)
                $this->_out('Q');
            $this->angle=$angle;
            if($angle!=0)         {
                $angle*=M_PI/180;
                $c=cos($angle);
                $s=sin($angle);
                $cx=$x*$this->k;
                $cy=($this->h-$y)*$this->k;
                $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
            }
        }
        function _endpage() {
            if ( $this->angle!=0 )  {
                $this->angle=0;
                $this->_out('Q');
            }
            parent::_endpage();
        }
        function addWatermark() {
            $x = 20;
            $y = 210;
            $txt = 'P e n d i n g   A p p r o v a l';
            $angle = 45;

            $this->SetFont('Arial','B',60);
            $this->mySetTextColor(self::BRIGHT_RED); 

            $this->SetAlpha(0.2);
                $this->Rotate($angle,$x,$y);
                $this->Text($x,$y,$txt);
                $this->Rotate(0);
            $this->SetAlpha(1);

        }
    // ------------------------------------------------------ Watermark

   


    // ----------------------------------------------
    function mySetTextColor($c) {
        $p = $this->pallette;
        $this->SetTextColor($p[$c]['R'],$p[$c]['G'],$p[$c]['B'] );
    }

    // ----------------------------------------------
    function SetWidths($w)
    {
        //Set the array of column widths
        $this->widths=$w;
    }

    // ----------------------------------------------
    function SetAligns($a)
    {
        //Set the array of column alignments
        $this->aligns=$a;
    }

    // ----------------------------------------------
    function Row($data)
    {
        $align = 'C';
        //Calculate the height of the row
        $nb=0;
        for($i=0;$i<count($data);$i++)
            $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
        $h=5*$nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for($i=0;$i<count($data);$i++)
        {
            $w=$this->widths[$i];
            if ($i==count($data)-1) $align = 'R';  // align only last cell
            $a=isset($this->aligns[$i]) ? $this->aligns[$i] : $align;
            //Save the current position
            $x=$this->GetX();
            $y=$this->GetY();
            //Draw the border
            $this->Rect($x,$y,$w,$h);
            //Print the text
            $this->MultiCell($w,5,$data[$i],0,$a);
            //Put the position to the right of the cell
            $this->SetXY($x+$w,$y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    // ----------------------------------------------
    function CheckPageBreak($h)
    {
        //If the height h would cause an overflow, add a new page immediately
        if($this->GetY()+$h>$this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    // ----------------------------------------------
    function NbLines($w,$txt)
    {
        //Computes the number of lines a MultiCell of width w will take
        $cw=&$this->CurrentFont['cw'];
        if($w==0)
            $w=$this->w-$this->rMargin-$this->x;
        $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
        $s=str_replace("\r",'',$txt);
        $nb=strlen($s);
        if($nb>0 and $s[$nb-1]=="\n")
            $nb--;
        $sep=-1;
        $i=0;
        $j=0;
        $l=0;
        $nl=1;
        while($i<$nb)
        {
            $c=$s[$i];
            if($c=="\n")
            {
                $i++;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
                continue;
            }
            if($c==' ')
                $sep=$i;
            $l+=$cw[$c];
            if($l>$wmax)
            {
                if($sep==-1)
                {
                    if($i==$j)
                        $i++;
                }
                else
                    $i=$sep+1;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
            }
            else
                $i++;
        }
        return $nl;
    }

    // --------------------------------------------------------------------- 
    function Header()   {
       // $this->Image('../images/rei_1.png',20, 10, 55);
        $this->Image( getcwd() . '/images/rei_1.png',20, 10, 55);
    }

    // --------------------------------------------------------------------- 
    function Footer()  {
        $this->SetY(-35);
        $this->SetFont('helvetica','I',8);
        $this->Image( getcwd() . '/images/rei_footer_1.png',null,null,185);
        $this->Cell(0,10,'Page '.$this->PageNo().' of {nb}',0,0,'C');
    }

    // --------------------------------------------------------------------- 
    function RoundedRect($x, $y, $w, $h, $r, $style = '')   {
        $k = $this->k;
        $hp = $this->h;
        if($style=='F')
            $op='f';
        elseif($style=='FD' || $style=='DF')
            $op='B';
        else
            $op='S';
        $MyArc = 4/3 * (sqrt(2) - 1);
        $this->_out(sprintf('%.2F %.2F m',($x+$r)*$k,($hp-$y)*$k ));
        $xc = $x+$w-$r ;
        $yc = $y+$r;
        $this->_out(sprintf('%.2F %.2F l', $xc*$k,($hp-$y)*$k ));

        $this->_Arc($xc + $r*$MyArc, $yc - $r, $xc + $r, $yc - $r*$MyArc, $xc + $r, $yc);
        $xc = $x+$w-$r ;
        $yc = $y+$h-$r;
        $this->_out(sprintf('%.2F %.2F l',($x+$w)*$k,($hp-$yc)*$k));
        $this->_Arc($xc + $r, $yc + $r*$MyArc, $xc + $r*$MyArc, $yc + $r, $xc, $yc + $r);
        $xc = $x+$r ;
        $yc = $y+$h-$r;
        $this->_out(sprintf('%.2F %.2F l',$xc*$k,($hp-($y+$h))*$k));
        $this->_Arc($xc - $r*$MyArc, $yc + $r, $xc - $r, $yc + $r*$MyArc, $xc - $r, $yc);
        $xc = $x+$r ;
        $yc = $y+$r;
        $this->_out(sprintf('%.2F %.2F l',($x)*$k,($hp-$yc)*$k ));
        $this->_Arc($xc - $r, $yc - $r*$MyArc, $xc - $r*$MyArc, $yc - $r, $xc, $yc - $r);
        $this->_out($op);
    }

    // --------------------------------------------------------------------- 
    function _Arc($x1, $y1, $x2, $y2, $x3, $y3)    {
        $h = $this->h;
        $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c ', $x1*$this->k, ($h-$y1)*$this->k,
            $x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
    }


    // -------------------------------------------------
    function displayPageHeading() {
        $this->SetFont('helvetica','',12);
        $this->mySetTextColor(self::BLACK); 
        $this->SetFillColor(777);
        $this->RoundedRect(120, 25, 85, 8, 3.5, 'DF');
        $this->RoundedRect( 20, 40, 95, 25, 3.5, 'DF');
        $this->RoundedRect(120, 40, 85, 25, 3.5, 'DF');

        $this->SetFont('helvetica','B',10);
        $this->Text(120,17, "Email:");
        $this->Text(120,21, "Visit us online at:");

        $this->SetFont('helvetica','',10);  
        $this->mySetTextColor(self::BRIGHT_RED); 
        $this->Text(132,17, $this->userProfile['email']);

        $this->SetFont('helvetica','U',10);
        $this->mySetTextColor(self::COOL_GRAY);   
        $this->Text(150,21,"http://www.rocelec.com");
    }

    // -------------------------------------------------
    function definePallette() {
        // define colors
        $this->pallette[PDF::ROCHESTER_RED]['R'] = 163;
        $this->pallette[PDF::ROCHESTER_RED]['G'] = 17;
        $this->pallette[PDF::ROCHESTER_RED]['B'] = 40;
        
        $this->pallette[PDF::DEEP_BLUE]['R'] = 46;
        $this->pallette[PDF::DEEP_BLUE]['G'] = 59;
        $this->pallette[PDF::DEEP_BLUE]['B'] = 78;
        
        $this->pallette[PDF::ACTION_BLUE]['R'] = 20;
        $this->pallette[PDF::ACTION_BLUE]['G'] = 133;
        $this->pallette[PDF::ACTION_BLUE]['B'] = 204;

        $this->pallette[PDF::BRIGHT_RED]['R'] = 210;
        $this->pallette[PDF::BRIGHT_RED]['G'] = 63;
        $this->pallette[PDF::BRIGHT_RED]['B'] = 62;

        $this->pallette[PDF::COOL_GRAY]['R'] = 94;
        $this->pallette[PDF::COOL_GRAY]['G'] = 110;
        $this->pallette[PDF::COOL_GRAY]['B'] = 120;

        $this->pallette[PDF::CHARCOAL]['R'] = 46;
        $this->pallette[PDF::CHARCOAL]['G'] = 42;
        $this->pallette[PDF::CHARCOAL]['B'] = 42;
        
        $this->pallette[PDF::BLACK]['R'] = 0;
        $this->pallette[PDF::BLACK]['G'] = 0;
        $this->pallette[PDF::BLACK]['B'] = 0;
    }
   

    // -------------------------------------------------
    function displayCompanyInfo($co) {
        $this->SetFont('helvetica','B',10);
        $this->mySetTextColor(self::BLACK); 
        $this->Text(23,45, "COMPANY");

        $this->SetFont('helvetica','',10);
        $this->mySetTextColor(self::ACTION_BLUE);
        $this->Text(23,50, $co['name'] );
        $this->Text(23,54, $co['address1'] );
        $this->Text(23,58, $co['address2'] );
        $this->Text(23,62, $co['city'] . ", " . $co['state'] . ' ' . $co['zip'] . '       ' .$co['country']);

        $this->SetFont('helvetica','B',10);
        $this->mySetTextColor(self::BLACK); 
        $this->Text(123,45, "CONTACT");

        $this->SetFont('helvetica','',10);
        $this->mySetTextColor(self::ACTION_BLUE);  
        $this->Text(123,50, $co['contact']['name'] );
        $this->Text(123,54, $co['contact']['email'] );
        $this->Text(123,58, $co['contact']['phone1'] );
        $this->Text(123,62, $co['contact']['phone2'] );

        $this->SetFont('helvetica','B',10);
        $this->mySetTextColor(self::BLACK); 
        $this->Text(125,30, "Quote No.");

        $this->SetFont('helvetica','',10);
        $this->mySetTextColor(self::ACTION_BLUE);  
        $this->Text(145,30, $co['quote_no'] );

        $this->SetFont('helvetica','',9);
        $this->mySetTextColor(self::BLACK);  
        $this->Text(173,30, "Expires:" );

        
    }

    // -------------------------------------------------
    function displayLetterIntro($let) {
        $this->mySetTextColor(self::BLACK); 
        $this->SetFont('helvetica','',10);
        $this->SetXY(20, 70);
        $this->Write(4, $let);
        $this->SetXY(20, $this->GetY()+10); 
    }


    // -------------------------------------------------
    function displayQuoteDetails($d) {
        $this->mySetTextColor(self::BLACK); 
        $this->SetWidths(array(10,40,10,20,20,25,25,25));
        $this->SetLineWidth(.1);

        $line_number = 0;

        foreach( $d as $i => $arr ) {
            if( count($arr) == 3 ) {  // continuation of previous item
                array_unshift($arr, $rows[$line_number][4]); 
                array_unshift($arr, $rows[$line_number][3]); 
                array_unshift($arr, $rows[$line_number][2]); 
                array_unshift($arr, $rows[$line_number][1]); 
                array_unshift($arr, ++$line_number); 
            }
            else {
                $line_number = $arr[0];
            }
            $rows[$line_number] = $arr;
        }

        foreach( $rows as $i => $row ) { 
            if ( $i==0 ) {
                $this->SetFont('helvetica','B',10);
                $this->SetFillColor(100);
            }
            else {
               $this->SetFont('helvetica','',8); 
               $this->mySetTextColor(self::COOL_GRAY); 
            }
            if ( in_array('Order Total', $row) ) {
                $this->mySetTextColor(self::ROCHESTER_RED); 
            }
            $this->Row($row);
        }
        $this->SetXY(20, $this->GetY()); 
    }

    // -------------------------------------------------
    function displayNotes($notes) {
        $this->SetFont('helvetica','I',8);
        $this->mySetTextColor(self::BLACK); 
        foreach( $notes as $n => $arr ) {
            foreach( $arr as $k => $v ) {
                if ( strpos( $k, 'Expiration' ) === false ) {
                    $this->SetFont('helvetica','BI',9);
                    $this->Ln(6);
                    $this->Cell(10, 4, $k);
                    $this->SetFont('helvetica','I',8);
                    $this->Ln(4);
                    $this->Write(4, $v);
                }
                else {
                    $ts = strtotime($v);
                    $this->SetFont('helvetica','',8);
                    $this->mySetTextColor(self::BRIGHT_RED);  
                    $this->Text(185,30, date('M d Y', $ts) );
                    $this->SetFont('helvetica','I',8);
                    $this->mySetTextColor(self::BLACK); 
                }
            }
        }
        $this->SetXY(20, $this->GetY()+10);
    }

    // -------------------------------------------------
    function displayLetterConclusion($let) {
        $this->SetFont('helvetica','',10);
        $this->mySetTextColor(self::BLACK); 
        $this->Write(4, $let);
        $this->SetXY(20, $this->GetY()+5);
    }


    // -------------------------------------------------
    function displayProfile() {

        $image_file = getcwd() . '/images/Signatures/user'.Yii::app()->user->id . ".png";
        if ( $this->userProfile['sig'] && file_exists($image_file) ) {
            $this->Image( $image_file, $this->GetX(), $this->GetY(),null,null ); 
        }
        else {
            $this->SetFont('helvetica','B',14);
            $this->SetXY(20, $this->GetY()+5);
            $this->mySetTextColor(self::ROCHESTER_RED); 
            $this->Write(4, $this->userProfile['name']); $this->Ln(4);

            $this->SetFont('helvetica','',10);
            $this->mySetTextColor(self::BLACK); 

            $this->Write(4, $this->userProfile['title']);$this->Ln(4);
            $this->Write(4, $this->userProfile['phone']);$this->Ln(4);
            $this->Write(4, $this->userProfile['fax']);$this->Ln(4);
            $this->Write(4, $this->userProfile['email']);$this->Ln(4);
        }
    }

}  ///////////////////////////////////////////////////////////////////////////////////// END_OF_CLASS PDF


//function hex2dec
//returns an associative array (keys: R,G,B) from
//a hex html code (e.g. #3FE5AA)
function hex2dec($couleur = "#000000"){
    $R = substr($couleur, 1, 2);
    $rouge = hexdec($R);
    $V = substr($couleur, 3, 2);
    $vert = hexdec($V);
    $B = substr($couleur, 5, 2);
    $bleu = hexdec($B);
    $tbl_couleur = array();
    $tbl_couleur['R']=$rouge;
    $tbl_couleur['G']=$vert;
    $tbl_couleur['B']=$bleu;
    return $tbl_couleur;
}

//conversion pixel -> millimeter in 72 dpi
function px2mm($px){
    return $px*25.4/72;
}

function txtentities($html){
    $trans = get_html_translation_table(HTML_ENTITIES);
    $trans = array_flip($trans);
    return strtr($html, $trans);
}





?>

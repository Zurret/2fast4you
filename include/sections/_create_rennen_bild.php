<?
//vars definieren
$v=$rennen['rennergebnis'];

$array_strecke = array();
$anzahl_fahrer=count($tmp_fahrer);

$Diagrammbreite=400;
$Diagrammhoehe=210;

$HintergrundfarbeR=1;
$HintergrundfarbeG=68;
$HintergrundfarbeB=29;

$Strecke_laenge=4000;
$Strecken_richtung=0;
$Strecke_aktuell=0;

$x_minus=0;
$y_plus=0;
$strecke_mom=0;

$Grafik = imagecreatetruecolor($Diagrammbreite, $Diagrammhoehe);
$i_copy = imagecreatetruecolor(1, 1);
//strecke filtern


$s_pos=strpos($v,"*");
if($s_pos!==FALSE){
	$v = substr($v,0,$s_pos);
}
    $tmp = explode("#", $v);
    for($x=0;$x!=count($tmp);$x++) {
        $info = explode("|", $tmp[$x]);
        $array_strecke[$x]['feld'] = $info[0];
        $array_strecke[$x]['km'] = $info[4];
    }
// farben erstellen
$Hindergrundfarbe = imagecolorallocate($Grafik, $HintergrundfarbeR, $HintergrundfarbeG, $HintergrundfarbeB);


//bild erstellen

imagefill($Grafik, 0, 0, $Hindergrundfarbe);

$img_tmp_start = imagecreatefrompng('templates/images/rennen/strasse_start.png'); 
$img_tmp = imagecreatefrompng('templates/images/rennen/strasse.png'); 
$img_tmp_no = imagecreatefrompng('templates/images/rennen/strasse_no.png'); 
$img_tmp_0 = imagecreatefrompng('templates/images/rennen/strasse_kurfe.png'); 
$img_tmp_1 = imagecreatefrompng('templates/images/rennen/strasse_steigung.png'); 
$img_tmp_2 = imagecreatefrompng('templates/images/rennen/strasse_kreuzung.png'); 
$img_tmp_3 = imagecreatefrompng('templates/images/rennen/strasse_bruecke.png'); 
$img_tmp_4 = imagecreatefrompng('templates/images/rennen/strasse_tunnel.png'); 
$img_tmp_5 = imagecreatefrompng('templates/images/rennen/strasse_s-kurfe.png'); 
$img_tmp_6 = imagecreatefrompng('templates/images/rennen/strasse_hindernis.png'); 
$img_tmp_ziel = imagecreatefrompng('templates/images/rennen/strasse_ziel.png'); 

$w_tmp_start = imagesx($img_tmp_start); 
$h_tmp_start = imagesy($img_tmp_start);
$w_tmp = imagesx($img_tmp); 
$h_tmp = imagesy($img_tmp); 
$w_tmp_0 = imagesx($img_tmp_0); 		//kurfe
$h_tmp_0 = imagesy($img_tmp_0); 		//kurfe
$w_tmp_1 = imagesx($img_tmp_1); 		//steigung
$h_tmp_1 = imagesy($img_tmp_1); 		//steigung
$w_tmp_2 = imagesx($img_tmp_2); 		//kreuzung
$h_tmp_2 = imagesy($img_tmp_2); 		//kreuzung
$w_tmp_3 = imagesx($img_tmp_3); 		//brücke
$h_tmp_3 = imagesy($img_tmp_3); 		//brücke
$w_tmp_4 = imagesx($img_tmp_4); 		//tunnel
$h_tmp_4 = imagesy($img_tmp_4); 		//tunnel
$w_tmp_5 = imagesx($img_tmp_5); 		//S-Kufe
$h_tmp_5 = imagesy($img_tmp_5); 		//S-Kufe
$w_tmp_6 = imagesx($img_tmp_6); 		//hindernis
$h_tmp_6 = imagesy($img_tmp_6); 		//hindernis

$Strecke_aktuell=$w_tmp_start;
$strecke_mom=$w_tmp_start;

imagecopy($Grafik,$img_tmp_start,0,2,0,0,$w_tmp_start,$h_tmp_start);
$z=14;
//gerade mit wechsel
for($q=0;$q<count($array_strecke);$q=$q+$anzahl_fahrer){
	for($i=0;$i<=($array_strecke[$q]['km']-$Strecke_aktuell)/5;$i++){
		if($strecke_mom>$Diagrammbreite){
			$strecke_mom=0;
			$y_plus+=21;
		}
		if($z<=8){
			$i_copy=$img_tmp;
		}else{
			$i_copy=$img_tmp_no;
			if($z>=16){
				$z=0;
			}	
		}
		imagecopy($Grafik,$i_copy,$strecke_mom,2+$y_plus,0,0,$w_tmp,$h_tmp);
		$z++;
		$strecke_mom++;
	}
	$Strecke_aktuell=$array_strecke[$q]['km'];
	$tmp_v="img_tmp_".$array_strecke[$q]['feld'];
	$tmp_w="w_tmp_".$array_strecke[$q]['feld'];
	$tmp_h="h_tmp_".$array_strecke[$q]['feld'];
	imagecopy($Grafik,$$tmp_v,$strecke_mom,2+$y_plus,0,0,$$tmp_w,$$tmp_h);
	$strecke_mom+=$$tmp_w;
	$Strecke_aktuell+=$$tmp_w;
}
for($i=0;$i<=20;$i++){
		if($strecke_mom>$Diagrammbreite){
			$strecke_mom=0;
			$y_plus+=21;
		}
		if($z<=8){
			$i_copy=$img_tmp;
		}else{
			$i_copy=$img_tmp_no;
			if($z>=16){
				$z=0;
			}	
		}
		imagecopy($Grafik,$i_copy,$strecke_mom,2+$y_plus,0,0,$w_tmp,$h_tmp);
		$z++;
		$strecke_mom++;
}
imagecopy($Grafik,$img_tmp_ziel,$strecke_mom,2+$y_plus,0,0,$w_tmp_start,$h_tmp_start);

imagepng($Grafik,"temp/strecke_".$FormVars['rid'].".png");
imagedestroy($Grafik);
?>
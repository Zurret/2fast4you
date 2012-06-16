<? 
include("../include/defaults.php");
//initialiesierung
$t=0;
$preise=array();
$datum=array();
$abfrage=@mysql_query("SELECT preis,datum FROM game_sprit_preise ORDER BY id")or die(mysql_error());
while ($check = mysql_fetch_object($abfrage)) {
	$preise[$t]=$check->preis;
	$datum[$t]=$check->datum;
	$t++;
}
$ar_sort_preise=array();
$ar_sort_preise=$preise;


$Diagrammbreite=496;
$Diagrammhoehe=400;

$HintergrundfarbeR=29;
$HintergrundfarbeG=29;
$HintergrundfarbeB=29;

$HintergrunddiagrammfarbeR=17;
$HintergrunddiagrammfarbeG=17;
$HintergrunddiagrammfarbeB=17;

$AchsenfarbeR=102;
$AchsenfarbeG=102;
$AchsenfarbeB=102;

$BalkenfarbeR=165;
$BalkenfarbeG=1;
$BalkenfarbeB=34;

$Grafik = imagecreatetruecolor($Diagrammbreite, $Diagrammhoehe);

$Abstand_Oben=0;
$Abstand_Unten=100;
$Abstand_Link=50;
$Abstand_Rechts=0;

$Abstand_Hilfslinien=30;
$Anzahl_Hilfslinien=10;

$Hilfslinien_groesse_x_achse=6;

$x_achsen_abstand=30;
$x_achsen_wiederholung=14;

$fontgroesse=1;

$preis_alt=NULL;

// Farben festlegen

$Hindergrundfarbe = imagecolorallocate($Grafik, $HintergrundfarbeR, $HintergrundfarbeG, $HintergrundfarbeB);
$Hindergrundfarbediagramm = imagecolorallocate($Grafik, $HintergrunddiagrammfarbeR, $HintergrunddiagrammfarbeG, $HintergrunddiagrammfarbeB);
$Achsenfarbe = imagecolorallocate($Grafik, $AchsenfarbeR, $AchsenfarbeG, $AchsenfarbeB);
$Balkenfarbe = imagecolorallocate($Grafik, $BalkenfarbeR, $BalkenfarbeG, $BalkenfarbeB); 

// Einfärben
imagefill($Grafik, 0, 0, $Hindergrundfarbe);
imagefilledrectangle($Grafik,$Abstand_Link,$Abstand_Oben,$Diagrammbreite-$Abstand_Rechts,$Diagrammhoehe-$Abstand_Unten,$Hindergrundfarbediagramm);

//hilfslinien
rsort($ar_sort_preise);
$hilfsline_bezeichung=round($ar_sort_preise[0]/$Anzahl_Hilfslinien,3);
for($i=1;$i<$Anzahl_Hilfslinien;$i++){
	imagesetstyle($Grafik, array($Achsenfarbe, $Achsenfarbe, IMG_COLOR_TRANSPARENT, IMG_COLOR_TRANSPARENT));
	imageline($Grafik,$Abstand_Link,$i*$Abstand_Hilfslinien+$Abstand_Oben,$Diagrammbreite-$Abstand_Rechts,$i*$Abstand_Hilfslinien+$Abstand_Oben,IMG_COLOR_STYLED);
	imagestring($Grafik,$fontgroesse,$Abstand_Link-imagefontwidth($fontgroesse)*strlen($hilfsline_bezeichung*($Anzahl_Hilfslinien-$i)." EUR")-2,$Abstand_Hilfslinien*$i-imagefontheight($fontgroesse)/2,$hilfsline_bezeichung*($Anzahl_Hilfslinien-$i)." EUR",$Achsenfarbe);
}
imageline($Grafik,$Abstand_Link,$Diagrammhoehe-$Abstand_Unten,$Diagrammbreite-$Abstand_Rechts,$Diagrammhoehe-$Abstand_Unten,$Achsenfarbe);
imagestring($Grafik,$fontgroesse,$Abstand_Link-imagefontwidth($fontgroesse)*strlen("0 EUR")-2,$Diagrammhoehe-$Abstand_Unten-imagefontheight($fontgroesse)/2,"0 EUR",$Achsenfarbe);
//ausgabe x bezeichung

for($i=1;$i<=$x_achsen_wiederholung;$i++){
	imagestringup($Grafik,$fontgroesse,$Abstand_Link+$x_achsen_abstand*$i-imagefontheight($fontgroesse)/2,$Diagrammhoehe-imagefontwidth($fontgroesse)*strlen($datum[$i-1])+5,$datum[$i-1],$Achsenfarbe);
	imageline($Grafik,$Abstand_Link+$x_achsen_abstand*$i,$Diagrammhoehe-$Abstand_Unten-$Hilfslinien_groesse_x_achse/2,$Abstand_Link+$x_achsen_abstand*$i,$Diagrammhoehe-$Abstand_Unten+$Hilfslinien_groesse_x_achse/2,$Achsenfarbe);
	//punkte ausgabe bzw ausgabe
	$preis_prozent=$preise[$i-1]/$ar_sort_preise[0];
	$y_achsen_weg=($Diagrammhoehe-$Abstand_Unten)-($Diagrammhoehe-$Abstand_Unten)*$preis_prozent;
	imagefilledellipse($Grafik,$Abstand_Link+$x_achsen_abstand*$i,$y_achsen_weg,6,6,$Balkenfarbe);
	if($i>=2){
			$preis_prozent_alt=$preise[$i-2]/$ar_sort_preise[0];
			$y_achsen_weg_alt=($Diagrammhoehe-$Abstand_Unten)-($Diagrammhoehe-$Abstand_Unten)*$preis_prozent_alt;
			imageline($Grafik,$Abstand_Link+$x_achsen_abstand*($i-1),$y_achsen_weg_alt,$Abstand_Link+$x_achsen_abstand*$i,$y_achsen_weg,$Balkenfarbe);
	}
}

// Ausgabe des Bildes und Freigabe des belegten Speichers

imagepng($Grafik,"../templates/images/diagramme/t_p.png");
imagedestroy($Grafik);

?>
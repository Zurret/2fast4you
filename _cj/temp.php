<? 
include("../include/mysql.php");
include("_inc.php");

$a= array(
		'1' => array(
				'1' => array(
				'max' => 1,
				'min' => -2
				),
				'2' => array(
				'max' => 2,
				'min' => -1
				),
				'3' => array(
				'max' => 3,
				'min' => -2
				), 
				'max_temp' => 8,
				'min_temp' => -13
		),
		'2' => array(
				'1' => array(
				'max' => 2,
				'min' => -3
				),
				'2' => array(
				'max' => 3,
				'min' => -2
				),
				'3' => array(
				'max' => 3,
				'min' => 0
				),  
				'max_temp' => 18,
				'min_temp' => -4
		),
		'3' => array(
				'1' => array(
				'max' => 1,
				'min' => -2
				),
				'2' => array(
				'max' => 3,
				'min' => -2
				),
				'3' => array(
				'max' => 3,
				'min' => -1
				), 
				'max_temp' => 32,
				'min_temp' => 19
		),
		'4'=> array(
				'1' => array(
				'max' => 1,
				'min' => -2
				),
				'2' => array(
				'max' => 2,
				'min' => -1
				),
				'3' => array(
				'max' => 3,
				'min' => -2
				), 
				'max_temp' => 20,
				'min_temp' => 8
		),
);

$jahrezeit=monat2jahrezeit(date("n"));
$tageszeit=stunde2tageszeit(date("G"));

$w=rand($a[$jahrezeit][$tageszeit]['min'],$a[$jahrezeit][$tageszeit]['max']);
$qry = mysql_query("SELECT temp FROM game_wetter WHERE id=1");
$ab = mysql_fetch_array($qry);

if(($ab['temp']+$w)>$a[$jahrezeit]['max_temp']){
	$t=$a[$jahrezeit]['max_temp'];
}elseif(($ab['temp']+$w)<$a[$jahrezeit]['min_temp']){
	$t=$a[$jahrezeit]['min_temp'];
}else{
	$t=$ab['temp']+$w;
}

mysql_query('UPDATE game_wetter SET temp="'.$t.'" WHERE id=1');
mysql_close($tmp_connection)
?>
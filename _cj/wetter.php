<? 
include("../include/mysql.php");
include("_inc.php");

$a =array(
		'1'=>array(
				'sonne' 	=> 20,
				'wolken'	=> 50,
				'regen'		=> 100,
				'nebel'		=> 0
		),
		'2'=>array(
				'sonne' 	=> 25,
				'wolken'	=> 60,
				'regen'		=> 90,
				'nebel'		=> 100
		),
		'3'=>array(
				'sonne' 	=> 45,
				'wolken'	=> 75,
				'regen'		=> 95,
				'nebel'		=> 100
		),
		'4'=>array(
				'sonne' 	=> 35,
				'wolken'	=> 60,
				'regen'		=> 85,
				'nebel'		=> 100
		),
);


$jahrezeit=monat2jahrezeit(date("n"));
$r=rand(0,100);
if($r<=$a[$jahrezeit]['sonne']){
	$w=1;
}elseif($r<=$a[$jahrezeit]['wolken']){
	$w=rand(2,3);
}elseif($r<=$a[$jahrezeit]['regen']){
		$qry = mysql_query("SELECT temp FROM game_wetter WHERE id=1");
		$ab = mysql_fetch_array($qry);
		if($ab['temp']<=-5){
			$w=7;
		}elseif($ab['temp']<=4 && $ab['temp']>=-4){
			$w=6;
		}else{
			$w=rand(4,5);
		}
}elseif($r<=$a[$jahrezeit]['nebel']){
	$w=8;
}
mysql_query('UPDATE game_wetter SET wetter="'.$w.'" WHERE id=1');
mysql_close($tmp_connection)
?>
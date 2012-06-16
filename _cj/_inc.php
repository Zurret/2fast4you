<? 

function monat2jahrezeit($m){
	if($m<=2 || $m==12){
		$j=1;
	}elseif($m>=3 && $m<=5){
		$j=2;
	}elseif($m>=6 && $m<=8){
		$j=3;
	}elseif($m>=9 && $m<=11){
		$j=4;
	}
	return $j;
}

function stunde2tageszeit($m){
	if(($m>=20 && $m<=23) || $m<=3){
		$t=1;
	}elseif($m>=4 && $m<=11){
		$t=2;
	}elseif($m>=12&& $m<=19){
		$t=3;
	}
	return $t;
}
function geld2zinsen($g){
	if($g<=10000){
		$z=0.00067;
	}elseif($g<=30000){
		$z=0.001;
	}elseif($g<=80000){
		$z=0.00134;
	}elseif($g<=150000){
		$z=0.00167;
	}else{
		$z=0.002;
	}
	return $g+($g*$z);
}
?>
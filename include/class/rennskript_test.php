<?php

require_once( '../mysql.php' );

// Dafür sorgen das Rennen gefahren werden und man auch zuschauen kann
$sql = 'SELECT * FROM game_rennen WHERE time<="' . time() . '"';
$result = @mysql_query($sql);
$anzahl = @mysql_num_rows($result);

$hindernisse    =   array(
                            "Hinderniss-Text-1",
                            "Hinderniss-Text-2",
                            "Hinderniss-Text-3"
                         );

$unfaelle       =   array(
                            "Unfall-Text-1",
                            "Unfall-Text-2",
                            "Unfall-Text-3"
                         );

$delays         =   array(
                            "0" => "0.2",
                            "1" => "0.2",
                            "2" => "0.2",
                            "3" => "0.2",
                            "4" => "0.2",
                            "5" => "0.2",
                            "6" => "0.2",
                            "7" => "0.2"
                         );

if(!empty($anzahl)) {
    require_once( 'racingscript.class' );
    while($dt = @mysql_fetch_array($result)) {

        // Renndaten initialisieren
        $tmp_sql    = array();
        $wetter     = array();
        $fahrer     = array();
        $strecke    = array();

        // Wetterstatus abfragen
        $wtr_rlt = @mysql_query('SELECT temp, wetter FROM game_wetter ORDER BY id DESC LIMIT 1');
        $wetter  = @mysql_fetch_array($wtr_rlt);

        // Streckeninfos laden
        $stk_rlt = @mysql_query('SELECT * FROM game_strecken WHERE id="' . $dt['strecken_id'] . '" LIMIT 1');
        $strecke = @mysql_fetch_array($stk_rlt);

        // Renninformationen übergeben
        $rennen  = $dt;

        // Alle Fahrerinfos laden und Skript übergeben
        $tmp = explode("#", $dt['drivers']);
        if(count($tmp) >= 2) {
            for($x=0;$x!=count($tmp);$x++) {
                $tmpi = explode(";", $tmp[$x]);
                $rk_user_info       = @mysql_fetch_array(@mysql_query('SELECT * FROM game_user WHERE id="' . $tmpi[0] . '" LIMIT 1'));
                $rk_garage_info     = @mysql_fetch_array(@mysql_query('SELECT * FROM game_garage WHERE id="' . $tmpi[1] . '" LIMIT 1'));
                $rk_tune_info       = @mysql_fetch_array(@mysql_query('SELECT * FROM game_incars WHERE garage_id="' . $tmpi[1] . '" LIMIT 1'));
                $rk_car_info        = @mysql_fetch_array(@mysql_query('SELECT * FROM game_cars WHERE id="' . $rk_garage_info['car_id'] . '" LIMIT 1'));
                $rk_skill_info      = @mysql_query('SELECT * FROM game_userskills WHERE user_id="' . $tmpi[0] . '"');
                $fahrer[] =     array(
                                        'user_info'     => $rk_user_info,
                                        'garage_info'   => $rk_garage_info,
                                        'tune_info'     => $rk_tune_info,
                                        'car_info'      => $rk_car_info,
                                        'skill_info'    => $rk_skill_info
                                     );
            }
            // Wenn alle Fahreinfos geladen wurden das rennen starten
            if(count($tmp) == count($fahrer)) {
                echo "<font color='red'><b>Skriptaufruf:</b></font><BR /><BR />";
                // Rennskript initialisieren
                $rskript = new racingScript();
                $rskript->setRennen($rennen);
                $rskript->setWetter($wetter);
                $rskript->setFahrer($fahrer);
                $rskript->setUnfaelle($unfaelle);
                $rskript->setDelays($delays);
                $rskript->setStrecke($strecke);
                $rskript->setHindernisse($hindernisse);
                $rskript->startRace();




            } else {
                echo "Zu wenig Fahrerinfo!";
            }
        } else {
            echo "Zu wenige Fahrer!";
        }
    }
}

?>

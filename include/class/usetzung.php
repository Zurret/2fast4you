<?php

    if(empty($_POST['check'])) {
        echo '<form action="" method="POST"><input type="hidden" name="check" value="1"><input type="submit" value="Werte berechnen und eintragen!"></form>';

    } else {
        require_once( '../mysql.php' );

        $result = @mysql_query('SELECT * FROM game_cars');
        while($data = @mysql_fetch_array($result)) {
            $ps = $data['ps'];
            $sec = $data['go_speed'];
            $gewicht = $data['gewicht'];
            $usetz = (($ps * 0.73549875 * 1000) / (2 * pi()) / 3000) / (100 / $sec * $gewicht);
            if(@mysql_query('UPDATE game_cars SET usetzung="' . $usetz . '" WHERE id="' . $data['id'] . '"')) {
                $tok = '<font color="green">successful</font>';
            } else {
                $tok = '<font color="red">failed</font>';
            }
            echo 'PS: <b>' . $ps . '</b> | 0-100: <b>' . $sec . '</b> | Gewicht: <b>' . $gewicht . '</b> | ‹bersetzung: <b>' . $usetz . '</b> | MySQL-Query: <b>' . $tok . '</b><BR />';
        }
    }
?>
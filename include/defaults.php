<?php

// Die Standardeinstellungen der Hauptseite
$DEFAULTS['main']       =       array(
                                        'language'          => 'de',                            
                                        'max_user'          => '500',
                                        '' => '',
                                        '' => ''
                                     );

// Die Standardeinstellungen des Spiel
$DEFAULTS['game']       =       array(
                                        'language'          => 'de',
                                        'start_money'       => '12500',
                                        'start_garagen'     => '1',
                                        'avatar_max_size'   => (15 * 1024),     // In KiloBytes!
                                        'avatar_max_w'      => '90',            // In Pixel!
                                        'avatar_max_h'      => '90',            // In Pixel!
                                        'clublogo_max_size' => (50 * 1024),     // In KiloBytes!
                                        'clublogo_max_w'    => '400',           // In Pixel!
                                        'clublogo_max_h'    => '200',           // In Pixel!
                                        'car_zustellen'     => (15 * 60),       // In Sekunden
                                        'start_buddys'      => '10',
                                        'start_nachrichten' => '20',
                                        'race_gebuehr'      => '10',            // In EUR
                                        'miet_gebuehr'      => '10',            // In EUR
                                        'spritverb_min'     => '5',             // Min. Spritverbrauch PRO Km
                                        'spritverb_max'     => '10',            // Max. Spritverbrauch PRO Km
                                        'waehrung'          => ' €',
                                        'new_garage'        => '15000',         // Stellplatzkosten
                                        'systemname'        => 'System',
                                        'free_jobs'         => '25',            // Anzahl der freien Jobs
                                        'free_sponsors'     => '40',            // Anzahl der freien Sponsoren
                                        'exp_hour'          => '5',             // Anzahl der Erfahrungspunte pro h
                                        'bonus'             => '1500',          // Betrag in €
                                        'founding'          => '1000',          // Club-Gründungsbetrag in €
                                        'founding_bonus'    => '250',           // Startkapital der Clubkasse in €
                                        'club_editing'      => '500',           // Clubname/-tagänderungsosten in €
                                        'account_delete'    => (3600 * 24),     // Sekunden!
                                        'online_user'       => 5                // Minuten!
                                     );

$ORIGINAL_CASH_TUNING    =      array(  '100',          // Ansaugrohr
                                        '65',           // Antenne
                                        '300',          // Auspuffanlage
                                        '150',          // Bremsen
                                        '95',           // Chip
                                        '370',          // Fahrwerk
                                        '100',          // Felgen
                                        '140',          // Frontscheinwerfer
                                        '390',          // Getriebe
                                        '80',           // Heckspoiler
                                        '500',          // Karosserie
                                        '160',          // Kupplung
                                        '135',          // Lachgas
                                        '50',           // Lenkrad
                                        '55',           // Luftfilter
                                        '1500',         // Motor
                                        '190',          // Motorhaube
                                        '85',           // Motorsteuergerät
                                        '100',          // Nockenwellen
                                        '50',           // Reifen
                                        '85',           // Rückleuchten
                                        '25',           // Scheibentönung
                                        '70',           // Schwungrad
                                        '160',          // Seitenschweller
                                        '85',           // Seitenspiegel
                                        '100',          // Sitze
                                        '40',           // Spurverbreiterung
                                        '25',           // Tribals
                                        '1200',         // Turbolader
                                        '20',           // Unterbodenbeleuchtung
                                        '200'           // Zündanlage
                                     );

// Einige Session überprüfungen und definitioen
if(!empty($_SESSION['language'])) { $tmp_language = $_SESSION['language']; } else { $tmp_language = $DEFAULTS['main']['language']; }
if($_SESSION['logged'] == true) { $tmp_position = $DEFAULTS['game']['position']; } else { $tmp_position = $DEFAULTS['main']['position']; }

?>

<?php

// Session starten
session_start();

// Einige wichtige Dateien laden
include_once( 'include/mysql.php' );                                     // MySQL-Daten laden ..
include_once( 'include/functions.php' );                                 // Funktionen laden ..
include_once( 'include/settings.php' );                                  // Einstellungen laden ..
include_once( 'include/msgsystem.php' );                                 // Betreff-Nachrichten laden ..
include_once( 'include/busy.php' );                                      // Beschäftigungsskript laden ..
include_once( 'include/wetter.php' );                                    // Wetterinformationen laden ..
include_once( 'include/club.php' );                                      // Club laden ..
include_once( 'include/shops.php' );                                     // Shops laden ..
include_once( 'include/sonstiges.php' );                                 // Sonstiges laden ..
include_once( 'include/stadt.php' );                                     // Stadt laden ..
include_once( 'include/player.php' );                                    // Spielermenü laden ..
include_once( 'include/lohn.php' );                                      // Joblöhne laden ..
include_once( 'include/tune.php' );                                      // Namen/Kategorien der Tuningteile laden ..
include_once( 'include/sponsoren.php' );                                 // Sponsoren laden ..
include_once( 'include/privat.php' );                                    // Privatbereich laden ..
include_once( 'include/skills.php' );                                    // Fähigkeiten laden ..
include_once( 'include/userinfo.php' );                                  // Benutzerinfos laden ..
include_once( 'include/buddys.php' );                                    // Benutzerinfos laden ..
include_once( 'include/action.php' );                                    // Actions laden ..
include_once( 'include/event.php' );                                     // Hinweisskript laden ..
include_once( DIR_LANGUAGE . PAGE_LANGUAGE . '/root.php' );              // Quellseitensprachdatei laden ..
include_once( DIR_LANGUAGE . PAGE_LANGUAGE . '/streckennames.php' );     // Streckentypnamen laden ..

// Bereich überprüfen und
switch($FormVars['c']) {
    case 'beispiel':
        #
        # Hier steht ein einsamer PHP-Code oder Kommentar
        #
        break;

    case 'werkstatt':
        // Sprachdatei laden
        require( DIR_LANGUAGE . PAGE_LANGUAGE . '/werkstatt' . EXT_CODE );
        // Position angeben
        $tmp_position = $LANG['game']['werkstatt']['position'];
        // Sectiondatei laden
        include( DIR_INC_SECTIONS . 'werkstatt' . EXT_CODE );
        // Subnavigation Ein-/Ausschalten
        $SUBNAVI['power']       = false;
        $SUBNAVI['filename']    = NULL;
        break;

    case 'rennen':
        // Sprachdatei laden
        require( DIR_LANGUAGE . PAGE_LANGUAGE . '/rennen' . EXT_CODE );
        require( DIR_LANGUAGE . PAGE_LANGUAGE . '/rennen_unfall' . EXT_CODE );
        require( DIR_LANGUAGE . PAGE_LANGUAGE . '/rennen_hindernis' . EXT_CODE );
        // Position angeben
        $tmp_position = $LANG['game']['rennen']['position'];
        // Renndateien laden
        include( DIR_INCLUDE . 'delays' . EXT_CODE );
        include( DIR_INCLUDE . 'schaden' . EXT_CODE );
        // Sectiondatei laden
        include( DIR_INC_SECTIONS . 'rennen' . EXT_CODE );
        // Subnavigation Ein-/Ausschalten
        $SUBNAVI['power']       = false;
        $SUBNAVI['filename']    = NULL;
        break;

    case 'mygarage':
        // Sprachdatei laden
        require( DIR_LANGUAGE . PAGE_LANGUAGE . '/garage' . EXT_CODE );
        // Position angeben
        $tmp_position = $LANG['game']['garage']['position'];
        // Sectiondatei laden
        include( DIR_INC_SECTIONS . 'garage' . EXT_CODE );
        // Subnavigation Ein-/Ausschalten
        $SUBNAVI['power']       = false;
        $SUBNAVI['filename']    = NULL;
        break;

    case 'lehrgang':
        // Sprachdatei laden
        require( DIR_LANGUAGE . PAGE_LANGUAGE . '/schule' . EXT_CODE );
        require( DIR_LANGUAGE . PAGE_LANGUAGE . '/schule_typ' . EXT_CODE );
        // Position angeben
        $tmp_position = $LANG['game']['schule']['position'];
        // Sectiondatei laden
        include( DIR_INC_SECTIONS . 'schule' . EXT_CODE );
        // Subnavigation Ein-/Ausschalten
        $SUBNAVI['power']       = false;
        $SUBNAVI['filename']    = NULL;
        break;

    case 'myskills':
        // Sprachdatei laden
        require( DIR_LANGUAGE . PAGE_LANGUAGE . '/skills' . EXT_CODE );
        // Position angeben
        $tmp_position = $LANG['game']['skills']['position'];
        // Sectiondatei laden
        include( DIR_INC_SECTIONS . 'skills' . EXT_CODE );
        // Subnavigation Ein-/Ausschalten
        $SUBNAVI['power']       = false;
        $SUBNAVI['filename']    = NULL;
        break;

    case 'arbeit':
        // Sprachdatei laden
        require( DIR_LANGUAGE . PAGE_LANGUAGE . '/arbeit' . EXT_CODE );
        // Position angeben
        $tmp_position = $LANG['game']['arbeit']['position'];
        // Sectiondatei laden
        include( DIR_INC_SECTIONS . 'arbeit' . EXT_CODE );
        // Subnavigation Ein-/Ausschalten
        $SUBNAVI['power']       = false;
        $SUBNAVI['filename']    = NULL;
        break;

    case 'sponsoren':
        // Sprachdatei laden
        require( DIR_LANGUAGE . PAGE_LANGUAGE . '/sponsoren' . EXT_CODE );
        // Position angeben
        $tmp_position = $LANG['game']['sponsoren']['position'];
        // Sectiondatei laden
        include( DIR_INC_SECTIONS . 'sponsoren' . EXT_CODE );
        // Subnavigation Ein-/Ausschalten
        $SUBNAVI['power']       = false;
        $SUBNAVI['filename']    = NULL;
        break;

    case 'jobboerse':
        // Sprachdatei laden
        require( DIR_LANGUAGE . PAGE_LANGUAGE . '/jobboerse' . EXT_CODE );
        // Position angeben
        $tmp_position = $LANG['game']['jobs']['position'];
        // Sectiondatei laden
        include( DIR_INC_SECTIONS . 'jobboerse' . EXT_CODE );
        // Subnavigation Ein-/Ausschalten
        $SUBNAVI['power']       = false;
        $SUBNAVI['filename']    = NULL;
        break;

    case 'tuningshop':
        // Sprachdatei laden
        require( DIR_LANGUAGE . PAGE_LANGUAGE . '/tuningshop' . EXT_CODE );
        // Position angeben
        $tmp_position = $LANG['game']['tuningshop']['position'];
        // Sectiondatei laden
        include( DIR_INC_SECTIONS . 'tuningshop' . EXT_CODE );
        // Subnavigation Ein-/Ausschalten
        $SUBNAVI['power']       = false;
        $SUBNAVI['filename']    = NULL;
        break;

    case 'ubay':
        // Sprachdatei laden
        require( DIR_LANGUAGE . PAGE_LANGUAGE . '/ubay' . EXT_CODE );
        // Position angeben
        $tmp_position = $LANG['game']['ubay']['position'];
        // Sectiondatei laden
        include( DIR_INC_SECTIONS . 'ubay' . EXT_CODE );
        // Subnavigation Ein-/Ausschalten
        $SUBNAVI['power']       = false;
        $SUBNAVI['filename']    = NULL;
        break;

    case 'club':
        // Sprachdatei laden
        require( DIR_LANGUAGE . PAGE_LANGUAGE . '/club' . EXT_CODE );
        require( DIR_LANGUAGE . PAGE_LANGUAGE . '/club_other' . EXT_CODE );
        // Position angeben
        $tmp_position = $LANG['game']['club']['position'];
        // Sectiondatei laden
        include( DIR_INC_SECTIONS . 'club' . EXT_CODE );
        // Subnavigation Ein-/Ausschalten
        $SUBNAVI['power']       = false;
        $SUBNAVI['filename']    = NULL;
        break;

	case 'autohaus':
        // Sprachdatei laden
        require( DIR_LANGUAGE . PAGE_LANGUAGE . '/autohaus' . EXT_CODE );
        // Position angeben
        $tmp_position = $LANG['game']['autohaus']['position'];
        // Sectiondatei laden
        include( DIR_INC_SECTIONS . 'autohaus' . EXT_CODE );
        // Subnavigation Ein-/Ausschalten
        $SUBNAVI['power']       = false;
        $SUBNAVI['filename']    = NULL;
        break;

    case 'screenshots':
        // Sprachdatei laden
        require( DIR_LANGUAGE . PAGE_LANGUAGE . '/screenshots' . EXT_CODE );
        // Position angeben
        $tmp_position = $LANG['main']['screenshots']['position'];
        // Sectiondatei laden
        include( DIR_INC_SECTIONS . 'screenshots' . EXT_CODE );
        // Subnavigation Ein-/Ausschalten
        $SUBNAVI['power']       = false;
        $SUBNAVI['filename']    = NULL;
        break;

    case 'clubprofil':
        // Sprachdatei laden
        require( DIR_LANGUAGE . PAGE_LANGUAGE . '/clubprofil' . EXT_CODE );
        require( DIR_LANGUAGE . PAGE_LANGUAGE . '/club_other' . EXT_CODE );
        // Position angeben
        $tmp_position = $LANG['game']['clubprofil']['position'];
        // Sectiondatei laden
        include( DIR_INC_SECTIONS . 'clubprofil' . EXT_CODE );
        // Subnavigation Ein-/Ausschalten
        $SUBNAVI['power']       = false;
        $SUBNAVI['filename']    = NULL;
        break;

    case 'profil':
        // Sprachdatei laden
        require( DIR_LANGUAGE . PAGE_LANGUAGE . '/profil' . EXT_CODE );
        // Position angeben
        $tmp_position = $LANG['game']['profil']['position'];
        // Sectiondatei laden
        include( DIR_INC_SECTIONS . 'profil' . EXT_CODE );
        // Subnavigation Ein-/Ausschalten
        $SUBNAVI['power']       = false;
        $SUBNAVI['filename']    = NULL;
        break;

    case 'rekorde':
        // Sprachdatei laden
        require( DIR_LANGUAGE . PAGE_LANGUAGE . '/rekorde' . EXT_CODE );
        // Position angeben
        $tmp_position = $LANG['game']['rekorde']['position'];
        // Sectiondatei laden
        include( DIR_INC_SECTIONS . 'rekorde' . EXT_CODE );
        // Subnavigation Ein-/Ausschalten
        $SUBNAVI['power']       = false;
        $SUBNAVI['filename']    = NULL;
        break;

	case 'tanke':
        // Sprachdatei laden
        require( DIR_LANGUAGE . PAGE_LANGUAGE . '/tankstelle' . EXT_CODE );
        // Position angeben
        $tmp_position = $LANG['tankstelle']['position'];
        // Sectiondatei laden
        include( DIR_INC_SECTIONS . 'tankstelle' . EXT_CODE );
        // Subnavigation Ein-/Ausschalten
        $SUBNAVI['power']       = false;
        $SUBNAVI['filename']    = NULL;
        break;

    case 'rangliste':
        // Sprachdatei laden
        require( DIR_LANGUAGE . PAGE_LANGUAGE . '/rangliste' . EXT_CODE );
        // Position angeben
        $tmp_position = $LANG['game']['rangliste']['position'];
        // Sectiondatei laden
        include( DIR_INC_SECTIONS . 'rangliste' . EXT_CODE );
        // Subnavigation Ein-/Ausschalten
        $SUBNAVI['power']       = false;
        $SUBNAVI['filename']    = NULL;
        break;

	case 'bank':
        // Sprachdatei laden
        require( DIR_LANGUAGE . PAGE_LANGUAGE . '/bank' . EXT_CODE );
        // Position angeben
        $tmp_position = $LANG['bank']['position'];
        // Sectiondatei laden
        include( DIR_INC_SECTIONS . 'bank' . EXT_CODE );
        // Subnavigation Ein-/Ausschalten
        $SUBNAVI['power']       = false;
        $SUBNAVI['filename']    = NULL;
        break;

    case 'statistik':
        // Sprachdatei laden
        require( DIR_LANGUAGE . PAGE_LANGUAGE . '/statistik' . EXT_CODE );
        // Position angeben
        $tmp_position = $LANG['game']['statistik']['position'];
        // Sectiondatei laden
        include( DIR_INC_SECTIONS . 'statistik' . EXT_CODE );
        // Subnavigation Ein-/Ausschalten
        $SUBNAVI['power']       = false;
        $SUBNAVI['filename']    = NULL;
        break;

    case 'online':
        // Sprachdatei laden
        require( DIR_LANGUAGE . PAGE_LANGUAGE . '/user_online' . EXT_CODE );
        // Position angeben
        $tmp_position = $LANG['game']['user_online']['position'];
        // Sectiondatei laden
        include( DIR_INC_SECTIONS . 'user_online' . EXT_CODE );
        // Subnavigation Ein-/Ausschalten
        $SUBNAVI['power']       = false;
        $SUBNAVI['filename']    = NULL;
        break;

	case 'anleitung':
        // Sprachdatei laden
        require( DIR_LANGUAGE . PAGE_LANGUAGE . '/anleitung' . EXT_CODE );
        // Position angeben
        $tmp_position = $LANG['anleitung']['position'];
        // Sectiondatei laden
        include( DIR_INC_SECTIONS . 'anleitung' . EXT_CODE );
        // Subnavigation Ein-/Ausschalten
        $SUBNAVI['power']       = false;
        $SUBNAVI['filename']    = NULL;
        break;

	case 'updates':
        // Sprachdatei laden
        require( DIR_LANGUAGE . PAGE_LANGUAGE . '/update' . EXT_CODE );
        // Position angeben
        $tmp_position = $LANG['update']['position'];
        // Sectiondatei laden
        include( DIR_INC_SECTIONS . 'update' . EXT_CODE );
        // Subnavigation Ein-/Ausschalten
        $SUBNAVI['power']       = false;
        $SUBNAVI['filename']    = NULL;
        break;

	case 'home_lesen':
        // Sprachdatei laden
        require( DIR_LANGUAGE . PAGE_LANGUAGE . '/home' . EXT_CODE );
        // Position angeben
        $tmp_position = $LANG['main']['position'];
        // Sectiondatei laden
        include( DIR_INC_SECTIONS . 'home_lesen' . EXT_CODE );
        // Subnavigation Ein-/Ausschalten
        $SUBNAVI['power']       = false;
        $SUBNAVI['filename']    = NULL;
        break;

    case 'agb':
        // Sprachdatei laden
        require( DIR_LANGUAGE . PAGE_LANGUAGE . '/agb' . EXT_CODE );
        // Position angeben
        $tmp_position = $LANG['main']['agb']['position'];
        // Sectiondatei laden
        include( DIR_INC_SECTIONS . 'agb' . EXT_CODE );
        // Subnavigation Ein-/Ausschalten
        $SUBNAVI['power']       = false;
        $SUBNAVI['filename']    = NULL;
        break;

    case 'regeln':
        // Sprachdatei laden
        require( DIR_LANGUAGE . PAGE_LANGUAGE . '/regeln' . EXT_CODE );
        // Position angeben
        $tmp_position = $LANG['main']['regeln']['position'];
        // Sectiondatei laden
        include( DIR_INC_SECTIONS . 'regeln' . EXT_CODE );
        // Subnavigation Ein-/Ausschalten
        $SUBNAVI['power']       = false;
        $SUBNAVI['filename']    = NULL;
        break;

    case 'impressum':
        // Sprachdatei laden
        require( DIR_LANGUAGE . PAGE_LANGUAGE . '/impressum' . EXT_CODE );
        // Position angeben
        $tmp_position = $LANG['main']['impressum']['position'];
        // Sectiondatei laden
        include( DIR_INC_SECTIONS . 'impressum' . EXT_CODE );
        // Subnavigation Ein-/Ausschalten
        $SUBNAVI['power']       = false;
        $SUBNAVI['filename']    = NULL;
        break;

    case 'usertools':
        if(!empty($FormVars['cancel']) && !empty($FormVars['id']) && !empty($FormVars['code'])) {
            $sql = 'SELECT game_user.id AS id, game_delete.id AS did, game_delete.del_code FROM game_user INNER JOIN game_delete ON game_user.id=game_delete.user_id WHERE game_user.id="'.$FormVars['id'].'"';
            $result = mysql_query($sql);
            $anzahl = mysql_num_rows($result);
            if(!empty($anzahl)) {
                $data = mysql_fetch_array($result);
                    if(strtolower($data['del_code']) == strtolower($FormVars['code'])) {
                        $sql = 'DELETE FROM game_delete WHERE id="'.$data['did'].'"';
                        if(@mysql_query($sql)) {
                            $ERROR['power'] = true; $tmp_nr = "06";
                        } else { $ERROR['power'] = true; $tmp_nr = "05"; }
                    } else { $ERROR['power'] = true; $tmp_nr = "04"; }
            } else { $ERROR['power'] = true; $tmp_nr = "03"; }
            $vars['error'] = array( '{ERROR_MESSAGE}' => '{USERTOOLS_ACCOUNT_DELETE_ERROR_' . $tmp_nr . '}');
            $vars['content']        =   array( '{CONTENT}' => '');
            $vars['content']        =   array_merge( $vars['content'], $LANG['game']['usertools']);
        }
        if(!empty($FormVars['email']) && !empty($FormVars['id']) && !empty($FormVars['code']) && empty($FormVars['cancel'])) {
            $sql = 'SELECT game_user.id AS id, email, game_delete.del_code FROM game_user INNER JOIN game_delete ON game_user.id=game_delete.user_id WHERE game_user.id="'.$FormVars['id'].'"';
            $result = mysql_query($sql);
            $anzahl = mysql_num_rows($result);
            if(!empty($anzahl)) {
                $data = mysql_fetch_array($result);
                if(strtolower($data['email']) == strtolower($FormVars['email'])) {
                    if(strtolower($data['del_code']) == strtolower($FormVars['code'])) {
                        $sql1 = 'DELETE FROM game_user WHERE id="'.$_SESSION['userid'].'"';
                        $sql2 = 'DELETE FROM game_delete WHERE user_id="'.$_SESSION['userid'].'"';
                        if(mysql_query($sql1) && mysql_query($sql2)) {
                            $ERROR['power'] = true; $tmp_nr = "11";
                        } else { $ERROR['power'] = true; $tmp_nr = "10"; }
                    } else { $ERROR['power'] = true; $tmp_nr = "09"; }
                } else { $ERROR['power'] = true; $tmp_nr = "08"; }
            } else { $ERROR['power'] = true; $tmp_nr = "07"; }
            $vars['error'] = array( '{ERROR_MESSAGE}' => '{USERTOOLS_ACCOUNT_DELETE_ERROR_' . $tmp_nr . '}');
            $vars['content']        =   array( '{CONTENT}' => '');
            $vars['content']        =   array_merge( $vars['content'], $LANG['game']['usertools']);
        }
        // Sprachdatei laden
        require( DIR_LANGUAGE . PAGE_LANGUAGE . '/usertools' . EXT_CODE );
        // Position angeben
        $tmp_position = $LANG['game']['usertools']['position'];
        // Sectiondatei laden
        if(empty($FormVars['email'])) {include( DIR_INC_SECTIONS . 'usertools' . EXT_CODE ); }
        // Subnavigation Ein-/Ausschalten
        $SUBNAVI['power']       = false;
        $SUBNAVI['filename']    = NULL;
        break;

    case 'nachrichten':
        // Sprachdatei laden
        require( DIR_LANGUAGE . PAGE_LANGUAGE . '/nachrichten' . EXT_CODE );
        // Position angeben
        $tmp_position = $LANG['game']['nachrichten']['position'];
        // Sectiondatei laden
        include( DIR_INC_SECTIONS . 'nachrichten' . EXT_CODE );
        // Subnavigation Ein-/Ausschalten
        $SUBNAVI['power']       = false;
        $SUBNAVI['filename']    = NULL;
        break;

    case 'vpasswort':
        // Sprachdatei laden
        require( DIR_LANGUAGE . PAGE_LANGUAGE . '/vpasswort' . EXT_CODE );
        // Position angeben
        $tmp_position = $LANG['main']['vpasswort']['position'];
        // Sectiondatei laden
        include( DIR_INC_SECTIONS . 'vpasswort' . EXT_CODE );
        // Subnavigation Ein-/Ausschalten
        $SUBNAVI['power']       = false;
        $SUBNAVI['filename']    = NULL;
        break;

    case 'freischaltung':
        // Sprachdatei laden
        require( DIR_LANGUAGE . PAGE_LANGUAGE . '/freischaltung' . EXT_CODE );
        // Position angeben
        $tmp_position = $LANG['main']['freischaltung']['position'];
        // Sectiondatei laden
        include( DIR_INC_SECTIONS . 'freischaltung' . EXT_CODE );
        // Subnavigation Ein-/Ausschalten
        $SUBNAVI['power']       = false;
        $SUBNAVI['filename']    = NULL;
        break;

    case 'registration':
        // Sprachdatei laden
        require( DIR_LANGUAGE . PAGE_LANGUAGE . '/registration' . EXT_CODE );
        // Position angeben
        $tmp_position = $LANG['main']['registration']['position'];
        // Sectiondatei laden
        include( DIR_INC_SECTIONS . 'registration' . EXT_CODE );
        // Subnavigation Ein-/Ausschalten
        $SUBNAVI['power']       = false;
        $SUBNAVI['filename']    = NULL;
        break;

    case 'login':
        // Sprachdatei laden
        require( DIR_LANGUAGE . PAGE_LANGUAGE . '/login' . EXT_CODE );
        // Position angeben
        $tmp_position = $LANG['main']['login']['position'];
        // Sectiondatei laden
        include( DIR_INC_SECTIONS . 'login' . EXT_CODE );
        // Subnavigation Ein-/Ausschalten
        $SUBNAVI['power']       = false;
        $SUBNAVI['filename']    = NULL;
        break;

    case 'logout':
        // Sprachdatei laden
        require( DIR_LANGUAGE . PAGE_LANGUAGE . '/logout' . EXT_CODE );
        // Position angeben
        $tmp_position = $LANG['game']['logout']['position'];
        // Sectiondatei laden
        include( DIR_INC_SECTIONS . 'logout' . EXT_CODE );
        // Subnavigation Ein-/Ausschalten
        $SUBNAVI['power']       = false;
        $SUBNAVI['filename']    = NULL;
        break;

    default:
        // Spieler Besucht die seite über einen Werbelink?
        if(!empty($FormVars['adid'])) {
            // Sprachdatei laden
            require( DIR_LANGUAGE . PAGE_LANGUAGE . '/werbung' . EXT_CODE );
            // Position angeben
            $tmp_position = $LANG['main']['werbung']['position'];
            // Sectiondatei laden
            include( DIR_INC_SECTIONS . 'werbung' . EXT_CODE );
            // Subnavigation Ein-/Ausschalten
            $SUBNAVI['power']       = false;
            $SUBNAVI['filename']    = NULL;
        } else {
            // Sprachdatei laden
            require( DIR_LANGUAGE . PAGE_LANGUAGE . '/home' . EXT_CODE );
            // Position angeben
            $tmp_position = $LANG['root']['main_position'];
            // Sectiondatei laden
            include( DIR_INC_SECTIONS . 'home' . EXT_CODE );
            // Subnavigation Ein-/Ausschalten
            $SUBNAVI['power']       = false;
            $SUBNAVI['filename']    = NULL;
        }
        break;
}

// Seite zusammenbauen und ausgeben ..
include( 'include/design.php' );

// MySQL Datenbanverbindung schliessen ..
mysql_close($tmp_connection)

?>

<?php

// Die Standardspieleinstellungen laden
require_once( 'defaults.php' );

// Formulardaten prüfen
$FormVars = checkFormdata();

// Serveradresse
define( 'SERVER',               'http://www.2f4y-thegame.de/');

// Ordnerstruktur
define( 'ROOT',                 '' );
define( 'DIR_ADMIN',            ROOT . 'admin/' );
define( 'DIR_AVATARS',          ROOT . 'avatars/' );
define( 'DIR_BACKUP',           ROOT . 'backup/' );
define( 'DIR_INCLUDE',          ROOT . 'include/' );
define( 'DIR_INC_SECTIONS',     DIR_INCLUDE . 'sections/' );
define( 'DIR_INC_CLASS',        DIR_INCLUDE . 'class/' );
define( 'DIR_LANGUAGE',         ROOT . 'language/' );
define( 'DIR_SCREENSHOTS',      ROOT . 'screenshots/' );
define( 'DIR_TEMP',             ROOT . 'temp/' );
define( 'DIR_TEMPLATES',        ROOT . 'templates/' );
define( 'DIR_T_HTMLS',          DIR_TEMPLATES . 'htmls/' );
define( 'DIR_T_H_DESIGN',       DIR_T_HTMLS . 'design/' );
define( 'DIR_T_H_MAIN',         DIR_T_HTMLS . 'main/' );
define( 'DIR_T_H_GAME',         DIR_T_HTMLS . 'game/' );
define( 'DIR_T_IMAGES',         DIR_TEMPLATES . 'images/' );
define( 'DIR_T_I_DESIGN',       DIR_T_IMAGES . 'design/' );
define( 'DIR_T_I_ICONS',        DIR_T_IMAGES . 'icons/' );
define( 'DIR_T_I_SIGNS',        DIR_T_IMAGES . 'signs/' );
define( 'DIR_T_I_SMILIES',      DIR_T_IMAGES . 'smilies/' );
define( 'DIR_T_STYLES',         DIR_TEMPLATES . 'styles/' );
define( 'DIR_UPDATE',           ROOT . 'update/' );

// Seiteneinstellungen
define( 'PAGE_LANGUAGE',        $tmp_language );
define( 'PAGE_CSS_TAG',         '<link rel="stylesheet" type="text/css" href="' . DIR_T_STYLES . 'default.css" media="screen">' );
define( 'PAGE_ICON_TAG',        '<link rel="shortcut icon" type="image/x-icon" href="' . DIR_T_I_ICONS . 'working.ico">' );
define( 'PAGE_META_TAG',        '<meta name="description" content="2 Fast 4 You ist ein Browsergame indem man Autos kaufen, tunen und damit auch Rennen fahren kann.">' );
define( 'PAGE_REGISTRATION',    TRUE );

// Dateiendungen
define( 'EXT_TEMPS',            '.tpl'      );
define( 'EXT_HTMLS',            '.htm'      );
define( 'EXT_CODE',             '.php'      );
define( 'EXT_TEXT',             '.txt'      );
define( 'EXT_AVAIMG1',          '.jpg'      );
define( 'EXT_AVAIMG2',          '.gif'      );
define( 'EXT_CLASS',            '.class'    );

// Platzhaltervariabeln erstellen/definieren
$vars['page']                   = array();
$vars['navigation']             = array();
$vars['stadt']                  = array();
$vars['shop']                   = array();
$vars['club']                   = array();
$vars['sonstige']               = array();
$vars['error']                  = array();
$vars['busy']                   = array();
$vars['event']                  = array();
$vars['content']                = array();
$vars['wetter']                 = array();
$vars['rennen']                 = array();
$vars['userinfo']               = array();
$vars['privat']                 = array();
$vars['usertools']              = array();
$vars['buddys']                 = array();
$vars['footer']                 = array();
$vars['other']                  = array();

// Wagennamen laden
include( DIR_INCLUDE . 'carnames' . EXT_CODE );
include( DIR_INCLUDE . 'worktime' . EXT_CODE );

?>

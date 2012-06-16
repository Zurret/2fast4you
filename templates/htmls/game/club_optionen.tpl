<tr>
  <td width="100%" align="center">
  <table border="0" cellpadding="2" cellspacing="0" width="400">
    <tr>
      <td width="100%">
      <form action="index.php?c=club&d=optionen" method="POST">
      <input type="hidden" name="check" value="1">
      <fieldset style="padding: 2; border: 1px solid #747474;">
      <legend>{CLUB_OPTION_NNAME}</legend>
      <table border="0" cellpadding="2" cellspacing="0" width="100%">
        <tr>
          <td width="50%" align="left">{CLUB_OPTION_NAME}</td>
          <td width="50%" align="left"><input type="text" name="p_clubname" style="width: 150px;" value="{CLUB_VLU_NAME}" class="txtfeld"></td>
        </tr>
        <tr>
          <td width="50%" align="left">{CLUB_OPTION_TAG}</td>
          <td width="50%" align="left"><input type="text" name="p_clubtag" style="width: 150px;" value="{CLUB_VLU_TAG}" class="txtfeld"></td>
        </tr>
        <tr>
          <td width="100%" colspan="2" height="10"></td>
        </tr>
        <tr>
          <td width="50%" align="left">{CLUB_OPTION_KOSTEN}</td>
          <td width="50%" align="left">{CLUB_VLU_NAME_KOSTEN}</td>
        </tr>
        <tr>
          <td width="100%" colspan="2" height="10"></td>
        </tr>
        <tr>
          <td width="50%" align="center">&nbsp;</td>
          <td width="50%" align="right"><input type="submit" value="{CLUB_OPTION_BTN_SAVE}" class="button"></td>
        </tr>
      </table>
      </fieldset>
      </form>
      </td>
    </tr>
    <tr>
      <td width="100%">
      <fieldset style="padding: 2; border: 1px solid #747474;">
      <legend>{CLUB_OPTION_GEBAEUDE}</legend>
      <table border="0" cellpadding="2" cellspacing="0" width="100%">
        <form action="index.php?c=club&d=optionen" method="POST" name="gebaeude">
        <tr>
          <td width="50%" align="left">{CLUB_OPTION_VERWALTUNG}</td>
          <td width="50%" align="left"><select name="p_geb_verwaltung" style="width: 150px;" class="dropdown" OnChange="JavaScript:document.forms.gebaeude.submit();">{CLUB_VLU_VERW_OP}</select></td>
        </tr>
        <tr>
          <td width="50%" align="left">{CLUB_OPTION_TRESOR}</td>
          <td width="50%" align="left"><select size="1" name="p_geb_tresor" style="width: 150px;" class="dropdown" OnChange="JavaScript:document.forms.gebaeude.submit();">{CLUB_VLU_TRESOR_OP}</select></td>
        </tr>
        </form>
        <tr>
          <td width="100%" colspan="2" height="10"></td>
        </tr>
        <tr>
          <td width="50%" align="left">{CLUB_OPTION_KOSTEN}</td>
          <td width="50%" align="left">{CLUB_VLU_GEB_KOSTEN}</td>
        </tr>
        <tr>
          <td width="100%" colspan="2" height="10"></td>
        </tr>
        <form action="index.php?c=club&d=optionen" method="POST">
        <input type="hidden" name="check" value="2">
        <input type="hidden" name="p_geb_verwaltung" value="{CLUB_VLU_GEB_VERW}">
        <input type="hidden" name="p_geb_tresor" value="{CLUB_VLU_GEB_TRESOR}">
        <tr>
          <td width="50%" align="center">&nbsp;</td>
          <td width="50%" align="right"><input type="submit" value="{CLUB_OPTION_AUSBAUEN}" class="button"></td>
        </tr>
        </form>
      </table>
      </fieldset>
      </td>
    </tr>
    <tr>
      <td width="100%">
      <form action="index.php?c=club&d=optionen" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="check" value="3">
      <fieldset style="padding: 2; border: 1px solid #747474;">
      <legend>{CLUB_OPTION_LOGO_TOPIC}</legend>
      <table border="0" cellpadding="2" cellspacing="0" width="100%">
        <tr>
          <td width="50%" align="left">{CLUB_OPTION_LOGO}</td>
          <td width="50%" align="center">&nbsp;</td>
        </tr>
        <tr>
          <td width="100%" colspan="2" align="center"><input type="file" name="p_logo" class="txtfeld"></td>
        </tr>
        <tr>
          <td width="100%" colspan="2" align="center"><font color="red">{CLUB_OPTION_MAXES_LOGO}</font></td>
        </tr>
        <tr>
          <td width="100%" colspan="2" height="10"></td>
        </tr>
        <tr>
          <td width="50%" align="left">{CLUB_OPTION_KOSTEN}</td>
          <td width="50%" align="left">{CLUB_VLU_LOGO_KOSTEN}</td>
        </tr>
        <tr>
          <td width="100%" colspan="2" height="10"></td>
        </tr>
        <tr>
          <td width="50%" align="center">&nbsp;</td>
          <td width="50%" align="right"><input type="submit" value="{CLUB_OPTION_BTN_UPLOAD}" class="button"></td>
        </tr>
      </table>
      </fieldset>
      </form>
      </td>
    </tr>
    <tr>
      <td width="100%">
      <form action="index.php?c=club&d=optionen" method="POST">
      <input type="hidden" name="check" value="5">
      <fieldset style="padding: 2; border: 1px solid #747474;">
      <legend>{CLUB_OPTION_OPT_TOPIC}</legend>
      <table border="0" cellpadding="2" cellspacing="0" width="100%">
        <tr>
          <td width="50%" align="left">{CLUB_OPTION_OPT_ABOUT}</td>
          <td width="50%" align="center">&nbsp;</td>
        </tr>
        <tr>
          <td width="100%" colspan="2" align="center"><textarea name="p_beschreibung" style="width:390px; height:155px;" class="txtarea">{CLUB_VLU_ABOUT}</textarea></td>
        </tr>
        <tr>
          <td width="100%" colspan="2" height="10" valign="middle"><input type="checkbox" name="p_accept_apply" value="1" class="checkbox"{CLUB_VLU_APPLY}>&nbsp;{CLUB_OPTION_OPT_APPLY}</td>
        </tr>
        <tr>
          <td width="100%" colspan="2" height="10"></td>
        </tr>
        <tr>
          <td width="50%" align="left">&nbsp;</td>
          <td width="50%" align="right"><input type="submit" value="{CLUB_OPTION_OPT_BTN_SAVE}" class="button"></td>
        </tr>
      </table>
      </fieldset>
      </form>
      </td>
    </tr>
    <tr>
      <form action="index.php?c=club&d=optionen" method="POST">
      <input type="hidden" name="check" value="4">
      <td width="100%">
      <fieldset style="padding: 2; border: 1px solid #747474;">
      <legend>{CLUB_OPTION_DEL_TOPIC}</legend>
      <table border="0" cellpadding="2" cellspacing="0" width="100%">
        <tr>
          <td width="100%" colspan="2" height="10"></td>
        </tr>
        <tr>
          <td width="70%" align="center"><input type="checkbox" name="p_delete" value="1" class="checkbox">Club Abmelden und endgültig Löschen!</td>
          <td width="30%" align="center"><input type="submit" value="{CLUB_OPTION_BTN_DELETE}" class="button"></td>
        </tr>
        <tr>
          <td width="100%" colspan="2" height="10"></td>
        </tr>
      </table>
      </fieldset>
      </td>
      </form>
    </tr>
  </table>
  </td>
</tr>
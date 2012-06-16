<tr>
  <td width="100%" align="center">{CLUB_VLU_READ}</td>
</tr>
<tr>
  <td width="100%" align="center">
  <table border="0" cellpadding="0" cellspacing="0" width="100%">
  <form action="index.php?c=club&d=bewerbungen" method="POST">
  <input type="hidden" name="check" value="1">
    <tr>
      <td width="35%" align="center"><i>{CLUB_BEWERB_TIME}</i></td>
      <td width="30%" align="center"><i>{CLUB_BEWERB_FROM}</i></td>
      <td width="35%" align="center"><i>{CLUB_BEWERB_AKTION}</i></td>
    </tr>
    {CLUB_VLU_BEWERBUNGEN}
    <tr>
      <td width="100%" colspan="3" align="center">&nbsp;</td>
    </tr>
    <tr>
      <td width="100%" colspan="3" align="center"><input type="submit" value="{CLUB_BEWERB_BTN}" onClick="return confirm('Aktion/en wirklich durchführen?'); submit();" class="button"{CLUB_BEWERB_ACTIVE}></td>
    </tr>
    <tr>
      <td width="100%" colspan="3" align="center">&nbsp;</td>
    </tr>
    </form>
  </table>
  </td>
</tr>
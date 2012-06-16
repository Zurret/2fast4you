  <table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="black">
    <tr>
      <td width="100%" align="center" class="ueberschift" height="26">{WERKSTATT_TOPIC}</td>
    </tr>
  </table>
  <table border="0" cellpadding="0" cellspacing="0" width="100%" height="100%" bordercolor="black" class="innen">
  <tr>
    <td height="5" class="space"></td>
  </tr>
  <tr>
    <td width="100%" align="center" valign="top">
    <table border="0" cellpadding="0" cellspacing="0" width="400" height="136">
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" align="center" width="100%">
          <table width="400" border="1" cellspacing="0" cellpadding="0" bordercolor="black" height="200">
            <tr>
              <td width="100%" align="center" background="templates/images/design/werkstatt.jpg">&nbsp;</td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td width="100%" colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td width="60%" align="left">{WERKSTATT_GESSCHADEN}{WERKSTATT_VLU_CARDEMAGE}</td>
        <td width="40%" align="left">{WERKSTATT_GESTUNING}{WERKSTATT_VLU_CARTUNING}</td>
      </tr>
      <tr>
        <td width="100%" colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td width="60%" height="19">{WERKSTATT_KATEGORIE}</td>
        <td width="40%" height="19">{WERKSTATT_AKTION}</td>
      </tr>
      <tr>
        <form action="index.php?c=werkstatt" name="kat" method="POST"><td width="60%" height="22"><select size="1" name="p_kat" class="txtfeld" OnChange="JavaScript:document.forms.kat.submit();">{WERKSTATT_VLU_KATEGORIE}</select></td></form>
        <form action="index.php?c=werkstatt" name="aktion" method="POST"><input type="hidden" name="p_kat" value="{WERKSTATT_VLU_KAT}"><input type="hidden" name="p_teil" value="{WERKSTATT_VLU_TEIL}"><td width="40%" height="22"><select size="1" name="p_aktion" class="txtfeld" OnChange="JavaScript:document.forms.aktion.submit();">{WERKSTATT_VLU_AKTIONEN}</select></td></form>
      </tr>
      <tr>
        <td width="60%" height="19">&nbsp;</td>
        <td width="40%" height="19">&nbsp;</td>
      </tr>
      <tr>
        <td width="60%" height="19">{WERKSTATT_LAGER}</td>
        <td width="40%" height="19">{WERKSTATT_ZUSTAND}</td>
      </tr>
      <tr>
        <form action="index.php?c=werkstatt" method="POST" name="teil"><input type="hidden" name="p_kat" value="{WERKSTATT_VLU_KAT}"><td width="60%" height="19"><select size="1" name="p_teil" class="txtfeld" OnChange="JavaScript:document.forms.teil.submit();">{WERKSTATT_VLU_DRIN}</select><br />{WERKSTATT_INFO}</td></form>
        <td width="40%" height="19" align="left">
        <table border="1" bordercolor="#333333" cellpadding="0" cellspacing="0" width="60%">
          <tr>
            <td width="{WERKSTATT_ZST_GREEN}%" bgcolor="#008000" height="10"></td>
            <td width="{WERKSTATT_ZST_ROT}%" bgcolor="#FF6037" height="10"></td>
          </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td width="100%" colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td width="50%" height="19">{WERKSTATT_KOSTEN}</td>
        <td width="50%" height="19">{WERKSTATT_DAUER}</td>
      </tr>
      <tr>
        <td width="50%" height="19">&nbsp;{WERKSTATT_VLU_KOSTEN}</td>
        <td width="50%" height="19">&nbsp;{WERKSTATT_VLU_DAUER}</td>
      </tr>
      <form action="index.php?c=werkstatt" method="POST" name="aktion">
      <tr>
        <td width="100%" colspan="2">&nbsp;</td>
      </tr>
      <input type="hidden" name="check" value="1">
      <input type="hidden" name="p_kat" value="{WERKSTATT_VLU_KAT}">
      <input type="hidden" name="p_teil" value="{WERKSTATT_VLU_TEIL}">
      <input type="hidden" name="p_aktion" value="{WERKSTATT_VLU_AKTION}">
      <tr>
        <td width="100%" height="19" colspan="2" align="center"><input type="submit" onClick="return confirm('Aktion wirklich durchführen?'); submit();" value="{WERKSTATT_BUTTON}" class="button"{WERKSTATT_VLU_BTN_DAB}></td>
      </tr>
      </form>
      <tr>
        <td width="100%" colspan="2">&nbsp;</td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td height="5" class="space"></td>
  </tr>
</table><br />

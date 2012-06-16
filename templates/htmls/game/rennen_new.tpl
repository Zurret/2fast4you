<table border="0" cellpadding="0" cellspacing="0" width="95%">
  <tr>
    <td width="100%" align="center">
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
      <tr>
        <td width="100%" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td width="100%" align="center">
        <table border="1" cellpadding="0" cellspacing="0" width="400" bordercolor="black" height="200">
          <tr>
            <td width="100%" align="center">{RENNEN_NEW_BILD}</td>
          </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td width="100%" align="center">
        <table border="0" cellpadding="0" cellspacing="0" width="400">
          <tr>
            <td width="100%" colspan="2">&nbsp;</td>
          </tr>
          <form action="index.php?c=rennen&d=new" name="strecke" method="POST">
          <tr>
            <td width="50%">{RENNEN_NEW_STRECKE}</td>
            <td width="50%"><select size="1" name="p_strecke" class="txtfeld" OnChange="JavaScript:document.forms.strecke.submit();">
            {RENNEN_VLU_STRECKE_OP}
            </select></td>
          </tr>
          </form>
          <form action="index.php?c=rennen&d=new" method="POST">
          <input type="hidden" name="check" value="1">
          <input type="hidden" name="p_strecke" value="{RENNEN_VLU_STRECKE}">
          <tr>
            <td width="50%">{RENNEN_NEW_TYPE}</td>
            <td width="50%">{RENNEN_VLU_TYPE}</td>
          </tr>
          <tr>
            <td width="50%">{RENNEN_NEW_LENGHT}</td>
            <td width="50%">{RENNEN_VLU_LENGHT}</td>
          </tr>
          <tr>
            <td width="50%">{RENNEN_NEW_TRAFFIC}</td>
            <td width="50%">{RENNEN_VLU_TRAFFIC}</td>
          </tr>
          <tr>
            <td width="100%" colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td width="50%">{RENNEN_NEW_START}</td>
            <td width="50%"><select size="1" name="p_hour" class="txtfeld"{RENNEN_VLU_SLCT}>{RENNEN_VLU_HOUR_OP}</select>:<select size="1" name="p_min" class="txtfeld"{RENNEN_VLU_SLCT}>{RENNEN_VLU_MINS_OP}</select>{RENNEN_NEW_UHR}</td>
          </tr>
          <tr>
            <td width="50%">{RENNEN_NEW_PLATZ}</td>
            <td width="50%"><select size="1" name="p_platz" class="txtfeld"{RENNEN_VLU_SLCT}>{RENNEN_VLU_PLATZ_OP}</select></td>
          </tr>
          <tr>
            <td width="50%">{RENNEN_NEW_RUNDEN}</td>
            <td width="50%"><select size="1" name="p_runden" class="txtfeld"{RENNEN_VLU_SLCT}>{RENNEN_VLU_RUNDEN_OP}</select></td>
          </tr>
          <tr>
            <td width="50%">{RENNEN_NEW_EINSATZ}</td>
            <td width="50%"><input type="text" name="p_einsatz" size="9" maxlength="5" class="txtfeld"{RENNEN_VLU_SLCT}>{RENNEN_VLU_EXT}&nbsp;{RENNEN_NEW_MIN_EINSATZ}</td>
          </tr>
          <tr>
            <td width="100%" colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td width="50%">{RENNEN_NEW_MAXRUF}</td>
            <td width="50%"><select size="1" name="p_maxruf" class="txtfeld"{RENNEN_VLU_SLCT}>{RENNEN_VLU_MRUF_OP}</select></td>
          </tr>
          <tr>
            <td width="50%">{RENNEN_NEW_MAXANSEHEN}</td>
            <td width="50%"><select size="1" name="p_maxansehen" class="txtfeld"{RENNEN_VLU_SLCT}>{RENNEN_VLU_MANSEHEN_OP}</select></td>
          </tr>
          <tr>
            <td width="50%">{RENNEN_NEW_MAXSTYLE}</td>
            <td width="50%"><select size="1" name="p_maxstyle" class="txtfeld"{RENNEN_VLU_SLCT}>{RENNEN_VLU_MSTYLE_OP}</select></td>
          </tr>
          <tr>
            <td width="50%">{RENNEN_NEW_KLASSE}</td>
            <td width="50%"><select size="1" name="p_klasse" class="txtfeld"{RENNEN_VLU_SLCT}>{RENNEN_VLU_KLASSE_OP}</select></td>
          </tr>
          <tr>
            <td width="100%" colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td width="100%" colspan="2">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
              <tr>
                <td width="10%" align="center" valign="top"><input type="checkbox" name="p_schnellstart" value="1" class="checkbox"{RENNEN_VLU_SLCT}></td>
                <td width="90%" align="left" valign="top">{RENNEN_NEW_SCHNELLSTART}</td>
              </tr>
            </table>
            </td>
          </tr>
          <tr>
            <td width="100%" colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td width="100%" colspan="2" align="center"><font color="red">{RENNEN_NEW_KOSTEN}{RENNEN_VLU_MIETGEBUEHR}</font></td>
          </tr>
          <tr>
            <td width="100%" colspan="2">&nbsp;</td>
          </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td width="100%" align="center"><input type="submit" value="{RENNEN_BTN_MIETEN}" class="button"{RENNEN_VLU_SLCT}></td>
      </tr>
      <tr>
        <td width="100%" colspan="2">&nbsp;</td>
      </tr>
      </form>
    </table>
    </td>
  </tr>
</table>

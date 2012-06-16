    <table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="black">
      <tr>
        <td width="100%" align="center" class="ueberschift" height="26">{SCHULE_TOPIC}</td>
      </tr>
    </table>
    <table border="1" cellpadding="0" cellspacing="0" bordercolor="black" width="100%" class="innen">
      <tr>
     <td height="5" class="space"></td>
    </tr>
  <tr>
    <td width="100%" align="center">
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
      <tr>
        <td width="100%" align="center">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
          <tr>
            <td width="100%" align="center" valign="top">
            <table border="0" cellpadding="0" cellspacing="0" width="80%">
              <tr>
                <td width="100%" align="right" colspan="2">&nbsp;</td>
              </tr>
              <tr>
                <td width="100%" align="center">
                <table border="1" cellpadding="0" cellspacing="0" bordercolor="#111111" width="400" height="200">
                  <tr>
                    <td width="100%" align="center">{SCHULE_NO_BILD}</td>
                  </tr>
                </table>
                </td>
              </tr>
              <tr>
                <td width="100%" align="center">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                  <tr>
                    <td width="100%" align="right" colspan="2">&nbsp;</td>
                  </tr>
                  <form action="index.php?c=lehrgang" name="bereich" method="POST">
                  <tr>
                    <td width="40%" align="right" height="20">{SCHULE_BEREICH}</td>
                    <td width="60%" align="left" height="20">&nbsp;<select size="1" name="p_bereich" OnChange="JavaScript:document.forms.bereich.submit();" class="txtfeld">
                    {SCHULE_VLU_BEREICHE}
                    </select></td>
                  </tr>
                  </form>
                  <form action="index.php?c=lehrgang" name="typ" method="POST">
                  <input type="hidden" name="p_bereich" value="{SCHULE_VLU_HBEREICH}">
                  <tr>
                    <td width="40%" align="right" height="20">{SCHULE_TYP}</td>
                    <td width="60%" align="left" height="20">&nbsp;<select size="1" name="p_typ" OnChange="JavaScript:document.forms.typ.submit();"  class="txtfeld" {SCHULE_VLU_HDROPDOWN}>
                    {SCHULE_VLU_TYP}
                    </select></td>
                  </tr>
                  </form>
                  <form action="index.php?c=lehrgang" method="POST">
                  <input type="hidden" name="p_bereich" value="{SCHULE_VLU_HBEREICH}">
                  <input type="hidden" name="p_typ" value="{SCHULE_VLU_HTYP}">
                  <input type="hidden" name="check" value="1">
                  <tr>
                    <td width="40%" align="right" height="20">{SCHULE_DAUER}</td>
                    <td width="60%" align="left" height="20">&nbsp;{SCHULE_DAUERTXT}</td>
                  </tr>
                  <tr>
                    <td width="40%" align="right" height="20"><font color="red">{SCHULE_GEBUEHR}</font></td>
                    <td width="60%" align="left" height="20">&nbsp;<font color="red">{SCHULE_VLU_GEBUEHR}</font></td>
                  </tr>
                  <tr>
                    <td width="100%" colspan="2" align="center">&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="100%" colspan="2" align="center">{SCHULE_VLU_BUTTON}</td>
                  </tr>
                  <tr>
                    <td width="100%" colspan="2" align="center">&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="100%" colspan="2" align="center">{SCHULE_HINWEIS}</td>
                  </tr>
                  <tr>
                    <td width="100%" align="right" colspan="2">&nbsp;</td>
                  </tr>
                  </form>
                </table>
                </td>
              </tr>
            </table>
            </td>
          </tr>
        </table>
        </td>
      </tr>
    </table>
    </td>
  </tr>
        <tr>
     <td height="5" class="space"></td>
    </tr>
</table><br />

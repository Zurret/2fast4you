    <table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="black">
      <tr>
        <td width="100%" align="center" class="ueberschift" height="26">{GARAGE_TOPIC}</td>
      </tr>
    </table>
    <table border="1" cellpadding="0" cellspacing="0" bordercolor="black" width="100%" height="150" class="innen">
      <tr>
       <td height="5" class="space"></td>
      </tr>
      <tr>
        <td width="100%" align="center">
        <table border="1" cellpadding="0" cellspacing="0" bordercolor="#111111" width="100%">
          <tr>
            <td width="100%" height="300" valign="top" align="center">
            <table border="0" cellpadding="0" cellspacing="0" width="90%">
              <tr>
                <td width="100%" align="center">&nbsp;</td>
              </tr>
              <tr>
                <td width="100%" align="center">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                  <tr>
                    <td width="100%" colspan="2">&nbsp;</td>
                  </tr>
                  <form action="index.php?c=mygarage" name="stellplatz" method="POST">
                  <tr>
                    <td width="50%" align="left">{GARAGE_STELLPLATZ}<select size="1" name="p_stellplatz" class="txtfeld" OnChange="JavaScript:document.forms.stellplatz.submit();">{GARAGE_VLU_OPTIONS}</select></td>
                    <td width="50%" align="center">{GARAGE_VLU_ACTIVATE}</td>
                  </tr>
                  </form>
                  <tr>
                    <td width="100%" colspan="2" height="175" align="center">
                    {GARAGE_VLU_CONTENT}
                    </td>
                  </tr>
                  <tr>
                    <td width="100%" colspan="2"><fieldset style="border: 1px solid #7D7D7D; padding: 2">
                    <legend>Optionen</legend>
                    <table border="0" cellpadding="0" cellspacing="0" width="100%" align="right">
                      <tr>
                        <td width="33%" align="center">{GARAGE_VLU_BUY_NEW}</td>
                        <td width="33%" align="center">{GARAGE_VLU_SELL_CAR}</td>
                        <td width="34%" align="center">{GARAGE_VLU_SELL_GARAGE}</td>
                      </tr>
                    </table>
                    </fieldset></td>
                  </tr>
                  <tr>
                    <td width="100%" colspan="2">&nbsp;</td>
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

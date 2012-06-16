<tr>
  <td width="100%" align="center">
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
      <tr>
        <td width="50%" align="right"><div style="margin-right: 5px;">{CLUB_VLU_BILD}</div></td>
        <td width="50%" valign="top">
        <table border="0" cellpadding="0" cellspacing="0" bordercolor="#111111" width="100%">
          <tr>
            <td width="100%">{CLUB_KASSE_VORHANDEN}</td>
          </tr>
          <tr>
            <td width="100%">&nbsp;{CLUB_VLU_KASSENOW} / {CLUB_VLU_KASSEMAX}</td>
          </tr>
          <tr>
            <td width="100%" height="10"></td>
          </tr>
          <form action="index.php?c=club&d=kasse" method="POST" name="auszahlen">
          <tr>
            <td width="100%">{CLUB_KASSE_OUTPUT}</td>
          </tr>
          <tr>
            <td width="100%">&nbsp;<select size="1" name="p_member" class="dropdown" OnChange="JavaScript:document.forms.auszahlen.submit();"{CLUB_VLU_KASSERECHT}>{CLUB_VLU_MEMBER_OP}</select></td>
          </tr>
          </form>
          <form action="index.php?c=club&d=kasse" method="POST">
          <input type="hidden" name="check" value="1">
          <input type="hidden" name="p_member" value="{CLUB_VLU_MEMBER}">
          <tr>
            <td width="100%">&nbsp;<input type="text" name="p_auszahlen" style="width: 50px;" maxlength="5" class="txtfeld"{CLUB_ACTIVE_OUT}> €</td>
          </tr>
          <tr>
            <td width="100%">&nbsp;<input type="submit" value="{CLUB_KASSE_OUTPUT}"  onClick="return confirm('Wirklich auszahlen?'); submit();" class="button"{CLUB_ACTIVE_OUT}></td>
          </tr>
          </form>
          <tr>
            <td width="100%" height="10"></td>
          </tr>
          <form action="index.php?c=club&d=kasse" method="POST">
          <input type="hidden" name="check" value="2">
          <tr>
            <td width="100%">{CLUB_KASSE_INPUT}</td>
          </tr>
          <tr>
            <td width="100%">&nbsp;<input type="text" name="p_einzahlen" style="width: 50px;" maxlength="5" class="txtfeld"> €</td>
          </tr>
          <tr>
            <td width="100%">&nbsp;<input type="submit" value="{CLUB_KASSE_INPUT}" class="button"></td>
          </tr>
          </form>
          <tr>
            <td width="100%" height="10"></td>
          </tr>
        </table>
        </td>
      </tr>
    </table>
  </td>
</tr>
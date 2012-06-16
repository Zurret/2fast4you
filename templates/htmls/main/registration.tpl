<table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="black">
      <tr>
        <td width="100%" align="center" class="ueberschift" height="26">{REGISTRATION_TOPIC}</td>
      </tr>
</table>
<table border="1" cellpadding="0" cellspacing="0" width="100%" height="100%" class="innen" bordercolor="black">
  <tr>
     <td height="5" class="space"></td>
  </tr>
  <tr>
    <td width="100%" align="left" valign="top">
    <table border="1" cellpadding="0" cellspacing="0" bordercolor="#111111" width="100%">
      <tr>
        <td width="100%" height="300">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
          <form action="index.php?c=registration&check=1" method="POST">
          <tr>
            <td width="50%" align="right" valign="top">{REGISTRATION_NICKNAME}</td>
            <td width="50%" align="left" valign="top">&nbsp;<input type="text" name="p_nick" size="20" maxlength="20" class="txtfeld"></td>
          </tr>
          <tr>
            <td width="50%" align="right" valign="top">{REGISTRATION_KENNWORT}</td>
            <td width="50%" align="left" valign="top">&nbsp;<input type="password" name="p_pass" size="20" maxlength="10" class="txtfeld"></td>
          </tr>
          <tr>
            <td width="50%" align="right" valign="top">{REGISTRATION_KENNWORT_WH}</td>
            <td width="50%" align="left" valign="top">&nbsp;<input type="password" name="p_pass_wh" size="20" maxlength="10" class="txtfeld"></td>
          </tr>
          <tr>
            <td width="50%" align="right" valign="top">{REGISTRATION_EMAIL}</td>
            <td width="50%" align="left" valign="top">&nbsp;<input type="text" name="p_email" size="20" maxlength="30" class="txtfeld"></td>
          </tr>
          <tr>
            <td width="50%" align="right" valign="top">{REGISTRATION_SECURITY}</td>
            <td width="50%" align="left" valign="top">&nbsp;<input type="text" name="p_security" size="20" maxlength="15" class="txtfeld"><br />{REGISTRATION_SECURITY_CODE}</td>
          </tr>
          <tr>
            <td width="50%" align="right" valign="middle" height="30">{REGISTRATION_MAXUSER}</td>
            <td width="50%" align="left" valign="middle" height="30">&nbsp;{VALUE_NOW_USER}/{VALUE_MAX_USER}</td>
          </tr>
          <tr>
            <td width="100%" align="right" colspan="2" height="40">
            <p align="center"><input type="submit" value="{REGISTRATION_BTN_REGISTER}" class="button"></td>
          </tr>
          <tr>
            <td width="100%" align="center" colspan="2" height="40">{REGISTRATION_HINWEIS}</td>
          </tr>
          </form>
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

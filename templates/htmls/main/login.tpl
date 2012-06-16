<table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="black">
      <tr>
        <td width="100%" align="center" class="ueberschift" height="26">{LOGIN_TOPIC}</td>
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
          <form action="index.php?c=login&check=1" method="POST">
          <tr>
            <td width="100%" align="center">&nbsp;</td>
          </tr>
          <tr>
            <td width="100%" align="center">
            <table border="0" cellpadding="0" cellspacing="0" width="400">
              <tr>
                <td width="50%" align="right" valign="top">{LOGIN_NICKNAME}</td>
                <td width="50%" align="left" valign="top"><input type="text" name="p_nick" size="20" class="txtfeld"></td>
              </tr>
              <tr>
                <td width="50%" align="right">{LOGIN_PASSWORT}</td>
                <td width="50%" align="left" valign="top"><input type="password" name="p_pass" size="20" class="txtfeld"></td>
              </tr>
            </table>
            </td>
          </tr>
          <tr>
            <td width="100%" align="center" height="40">
            <input type="submit" value="{LOGIN_BTN_LOGIN}" name="login" class="button"></td>
          </tr>
          <tr>
            <td width="100%" align="center"><a href="index.php?c=registration">{LOGIN_REGISTRATION}</a> | <a href="index.php?c=freischaltung">{LOGIN_ACTIVATION}</a> | <a href="index.php?c=vpasswort">{LOGIN_VPASSWORT}</a></td>
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

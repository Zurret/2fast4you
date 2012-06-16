<table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="black">
      <tr>
        <td width="100%" align="center" class="ueberschift" height="26">{NACHRICHTEN_WRITE_TOPIC}</td>
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
        <td width="100%" height="300" valign="top">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
		<form action="index.php?c=nachrichten&d=write&check=1" method="POST">
          <tr>
            <td width="100%" height="25" align="center"><a href="index.php?c=nachrichten">{NACHRICHTEN_OVERVIEW}</a></td>
          </tr>
          <tr>
            <td width="100%" align="center">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
              <tr>
                <td width="25%" align="right" valign="top">{NACHRICHTEN_TO}</td>
                <td width="75%" valign="top">&nbsp;<input class="txtfeld" type="text" value="{VALUE_EMPFAENGER}" name="p_empfaenger" size="20" maxlength="20"></td>
              </tr>
              <tr>
                <td width="25%" align="right" valign="top">{NACHRICHTEN_BETREFF}</td>
                <td width="75%" valign="top">&nbsp;<input class="txtfeld" type="text" value="{VALUE_BETREFF}" name="p_betreff" size="20" maxlength="20"></td>
              </tr>
              <tr>
                <td width="25%" align="right" valign="top">{NACHRICHTEN_MESSAGE}</td>
                <td width="75%" valign="top">&nbsp;<textarea class="txtarea" name="p_message" style="width: 275px; height: 200px;"></textarea></td>
              </tr>
            </table>
            </td>
          </tr>
          <tr>
            <td width="100%" height="40">
            <p align="center">
            <input class="button" type="submit" value="{NACHRICHTEN_WRITE_BTN_SEND}"></td>
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

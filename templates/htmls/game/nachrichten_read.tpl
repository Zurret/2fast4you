<table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="black">
      <tr>
        <td width="100%" align="center" class="ueberschift" height="26">{NACHRICHTEN_READ_TOPIC}</td>
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
          <tr>
            <td width="100%" height="25" align="center"><a href="index.php?c=nachrichten">{NACHRICHTEN_OVERVIEW}</a></td>
          </tr>
          <tr>
            <td width="100%" align="center">
            <table border="0" cellpadding="0" cellspacing="0" width="400">
              <tr>
                <td width="100%">{NACHRICHTEN_FROM} <b>{MESSAGE_FROM}</b></td>
              </tr>
              <tr>
                <td width="100%">{NACHRICHTEN_EMPFANGEN} <b>{MESSAGE_ZEITPUNKT}</b></td>
              </tr>
              <tr>
                <td width="100%">{NACHRICHTEN_BETREFF} <b>{MESSAGE_BETREFF}</b></td>
              </tr>
              <tr>
                <td width="100%"><textarea class="txtarea" rows="12" readonly cols="45">{MESSAGE_NACHRICHT}</textarea></td>
              </tr>
            </table>
            </td>
          </tr>
          <tr>
            <td width="100%" height="40" align="center"><a href="index.php?c=nachrichten&d=melden&id={MESSAGE_ID}">{NACHRICHTEN_READ_BTN_MELDEN}</a> | <a href="index.php?c=nachrichten&d=delete&id={MESSAGE_ID}">{NACHRICHTEN_READ_BTN_DELETE}</a> | <a href="index.php?c=nachrichten&d=write&id={MESSAGE_ID}">{NACHRICHTEN_READ_BTN_ANSWER}</a></td>
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

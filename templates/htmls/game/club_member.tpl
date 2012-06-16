<tr>
  <td width="100%" align="center">
  <table border="0" cellpadding="0" cellspacing="0" bordercolor="#111111" width="90%">
    <tr>
      <td width="100%" align="center" colspan="4">{CLUB_MEMBER_SIZE}{CLUB_SIZE_NOW}/{CLUB_SIZE_MAX}{CLUB_MEMBER_MEMBERS}</td>
    </tr>
    <tr>
      <td width="100%" align="center" colspan="4">&nbsp;</td>
    </tr>
    <form action="index.php?c=club&d=member" method="POST">
    <input type="hidden" name="check" value="1">
    <tr>
      <td width="10%" align="right">&nbsp;</td>
      <td width="30%" align="left"><i>{CLUB_MEMBER_NAME}</i></td>
      <td width="30%" align="left"><i>{CLUB_MEMBER_RANG}</i></td>
      <td width="30%" align="left"><i>{CLUB_MEMBER_AKTIONEN}</i></td>
    </tr>
    {CLUB_MEMBER_CONTENT}
    <tr>
      <td width="100%" align="center" colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td width="100%" align="center" colspan="4">{CLUB_VLU_BUTTON}</td>
    </tr>
    </form>
  </table>
  </td>
</tr>
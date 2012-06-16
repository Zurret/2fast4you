<table border="0" cellpadding="0" cellspacing="0" bordercolor="#111111" width="400">
  <form action="index.php?c=clubprofil&d=apply&cid={CLUBPROFIL_VLU_CID}" method="POST">
  <input type="hidden" name="check" value="1">
  <tr>
    <td width="100%" align="center">
    <table border="0" cellpadding="0" cellspacing="0" bordercolor="#111111" width="100%">
      <tr>
        <td width="100%" colspan="2">{CLUBPROFIL_BEWERBUNG}</td>
      </tr>
      <tr>
        <td width="100%" colspan="2"><textarea rows="10" name="p_bewerbungstext" style="width:400px; height:100px;" class="txtarea"></textarea></td>
      </tr>
      <tr>
        <td width="60%" align="right">{CLUBPROFIL_VLU_APPLY_HINWEIS}</td>
        <td width="40%" align="right"><input type="submit" value="{CLUBPROFIL_BEWR_BTN_SEND}" class="button" onClick="return confirm('Bewerbung wirklich abschicken?\nAlte Bewerbungen gehen dabei verloren!'); submit();"></td>
      </tr>
    </table>
    </td>
  </tr>
  </form>
</table>
<table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="black">
  <tr>
    <td width="100%" align="center" class="ueberschift" height="26">{BANK_TOPIC}</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="innen" bordercolor="black">
  <tr>
    <td height="5" class="space" colspan="2"></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center" width="100%">
      <table width="400" border="1" cellspacing="0" cellpadding="0" bordercolor="black" height="200">
        <tr>
          <td width="100%" align="center" background="templates/images/design/bank.jpg">&nbsp;</td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><div align="center">{BANK_KONTO} {BANK_INHALT} {BANK_WAEHRUNG}</div></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
  <form action="index.php?c=bank" method="POST">
    <td width="45%" align="right"><input type="text" name="g"  class="txtfeld" style="width: 75px;" maxlength="5"/> € </td>
    <td width="55%" align="left">&nbsp;<input type="submit" name="e" value="{BANK_EINZAHLEN}" class="button"  onClick="return confirm('Wirklich einzahlen?\nAbheben kann man erst 24h später!'); submit();"/><input type="submit" name="a" value="{BANK_ABHEBEN}" class="button" /></td>
  </form>
  </tr>
  <tr>
    <td align="center"colspan="2"><br />{BANK_TEXT}</td>
  </tr>
  <tr>
    <td height="5" class="space" colspan="2"></td>
  </tr>
</table><br />


  <table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="black">
    <tr>
      <td width="100%" align="center" class="ueberschift" height="26">{TANKSTELLE_TOPIC}</td>
    </tr>
    <tr>
     <td height="5" class="space"></td>
    </tr>
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="innen" bordercolor="black">
    <tr>
      <td width="100%" align="center" colspan="2">&nbsp;</td>
    </tr>
	<tr>
      <td colspan="2" align="center">
      <table width="400" border="1" cellspacing="0" cellpadding="0" bordercolor="black" height="200">
        <tr>
          <td width="100%" align="center" background="templates/images/design/tankstelle.jpg">&nbsp;</td>
        </tr>
      </table>
      </td>
    </tr>
    <tr>
      <td width="100%" align="center" colspan="2">&nbsp;</td>
    </tr>
	<tr>
      <td width="100%" align="center" colspan="2">{TANKSTELLE_SPRIT_ANZEIGE}</td>
    </tr>
    <tr>
      <td width="100%" align="center" colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td width="100%" align="center" colspan="2">{TANKSTELLE_AKTPPREIS}</td>
    </tr>
    <tr>
      <td width="100%" align="center" colspan="2">&nbsp;</td>
    </tr>
    <tr>
    <form action="index.php?c=tanke" method="POST">
      <td width="50%" align="right"><input type="text" name="s" class="txtfeld" style="width: 25px;" maxlength="2"/> Liter </td>
      <td width="50%" align="left">&nbsp;<input type="submit" name="t" value="{TANKSTELLE_TANKEN}" class="button"/></td>
    </form>
    </tr>
    <tr>
      <td width="100%" align="center" colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" align="center">{TANKSTELLE_TEXT}<br />{TANKSTELLE_DIAGRAMM}<br /><br /></td>
    </tr>
	<tr>
     <td height="5" class="space" colspan="2"></td>
    </tr>
</table>
<br />

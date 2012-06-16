<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <form action="index.php?c=ubay&d=sell" method="POST" name="artikel">
  <tr>
    <td width="50%" align="right">{SHOP_UBAY_SELL_ARTIKEL}</td>
    <td width="50%">&nbsp;<select  class="txtfeld" style="width: 175;" name="id" OnChange="JavaScript:document.forms.artikel.submit();">{SHOP_UBAY_SELL_VLU_TEILE}</select></td>
  </tr>
  </form>
  <form action="index.php?c=ubay&d=sell&id={SHOP_UBAY_VLU_ID}" method="POST" name="dauer">
  <tr>
    <td width="50%" align="right">{SHOP_UBAY_SELL_AUKTIONSDAUER}</td>
    <td width="50%">&nbsp;<select class="txtfeld" size="1" name="p_dauer" {SHOP_UBAY_VLU_DAUER_DBL} OnChange="JavaScript:document.forms.dauer.submit();">{SHOP_UBAY_SELL_VLU_DAUER}</select>{SHOP_UBAY_SELL_DAYS}</td>
  </tr>
  </form>
  <form action="index.php?c=ubay&d=sell&id={SHOP_UBAY_VLU_ID}" method="POST">
  <input type="hidden" name="p_dauer" value="{SHOP_UBAY_VLU_DAUER}">
  <input type="hidden" name="check" value="1">
  <tr>
    <td width="50%" align="right">{SHOP_UBAY_SELL_STARTPREIS}</td>
    <td width="50%">&nbsp;<input class="txtfeld" type="text" name="p_startpreis" size="5" maxlength="7" {SHOP_UBAY_VLU_START_DBL}>{SHOP_UBAY_SELL_MINSTART}{SHOP_UBAY_VLU_MINSTART}</td>
  </tr>
  <tr>
    <td width="100%" align="right" colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td width="100%" colspan="2" align="center">
    <table border="1" cellpadding="0" cellspacing="0" width="125" height="100">
      <tr>
        <td width="100%" align="center" valign="middle">{SHOP_UBAY_SELL_VLU_BILD}</td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td width="50%" align="right">{SHOP_UBAY_SELL_KETEGORIE}</td>
    <td width="50%">&nbsp;{SHOP_UBAY_VLU_KATEGORIE}</td>
  </tr>
  <tr>
    <td width="50%" align="right">{SHOP_UBAY_SELL_ARTIKELNAME}</td>
    <td width="50%">&nbsp;{SHOP_UBAY_VLU_ARTIKELNAME}</td>
  </tr>   <tr>
    <td width="50%" align="right">{SHOP_UBAY_SELL_ZUSTAND}</td>
    <td width="50%">&nbsp;{SHOP_UBAY_VLU_ZUSTAND}</td>
  </tr>
  <tr>
    <td width="50%" align="right">{SHOP_UBAY_SELL_GEWICHT}</td>
    <td width="50%">&nbsp;{SHOP_UBAY_VLU_GEWICHT}</td>
  </tr>
  <tr>
    <td width="50%" align="right">{SHOP_UBAY_SELL_PS}</td>
    <td width="50%">&nbsp;{SHOP_UBAY_VLU_PS}</td>
  </tr>
  <tr>
    <td width="50%" align="right">{SHOP_UBAY_SELL_KMH}</td>
    <td width="50%">&nbsp;{SHOP_UBAY_VLU_KMH}</td>
  </tr>
  <tr>
    <td width="50%" align="right">{SHOP_UBAY_SELL_0100}</td>
    <td width="50%">&nbsp;{SHOP_UBAY_VLU_0100}</td>
  </tr>
  <tr>
    <td width="100%" align="center" colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td width="50%" align="right"><font color="red"><b>{SHOP_UBAY_SELL_GEBUEHR}</b></font></td>
    <td width="50%" align="left">&nbsp;<font color="red"><b>{SHOP_UBAY_VLU_GEBUEHR}</b></font></td>
  </tr>
  <tr>
    <td width="100%" align="center" colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td width="100%" colspan="2" align="center"><input type="submit" value="{SHOP_UBAY_SELL_BTN_SEND}" class="button" onClick="return confirm('Wirlich ins uBay einstellen?'); submit();"></td>
  </tr>
  <tr>
    <td width="100%" align="center" colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td width="100%" align="center" colspan="2">{SHOP_UBAY_SELL_HINWEIS}</td>
  </tr>
  </form>
</table>

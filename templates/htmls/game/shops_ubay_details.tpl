<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr>
    <td width="100%" colspan="2" height="20">&nbsp;</td>
  </tr>
  <tr>
    <td width="100%" colspan="2" align="center">
    <table border="1" cellpadding="0" cellspacing="0" width="125" height="100">
      <tr>
        <td width="100%" align="center" valign="middle">{SHOP_UBAY_VLU_BILD}</td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td width="50%" align="right" valign="top">{SHOP_UBAY_DT_KATEGORIE}</td>
    <td width="50%">&nbsp;{SHOP_UBAY_VLU_KATEGORIE}</td>
  </tr>
  <tr>
    <td width="50%" align="right" valign="top">{SHOP_UBAY_DT_NAME}</td>
    <td width="50%">&nbsp;{SHOP_UBAY_VLU_NAME}</td>
  </tr>
  <tr>
    <td width="50%" align="right" valign="top">{SHOP_UBAY_DT_NOWPREIS}</td>
    <td width="50%">&nbsp;{SHOP_UBAY_VLU_NOWPREIS}</td>
  </tr>
  <tr>
    <td width="50%" align="right" valign="top">{SHOP_UBAY_DT_HIGHBITTER}</td>
    <td width="50%">&nbsp;{SHOP_UBAY_VLU_HIGHBITTER}</td>
  </tr>
  <tr>
    <td width="50%" align="right" valign="top">{SHOP_UBAY_DT_ENDED}</td>
    <td width="50%">&nbsp;{SHOP_UBAY_VLU_ENDED}</td>
  </tr>
  <tr>
    <td width="50%" align="right" valign="top">{SHOP_UBAY_DT_ZUSTAND}</td>
    <td width="50%">&nbsp;{SHOP_UBAY_VLU_ZUSTAND}</td>
  </tr>
  <tr>
    <td width="50%" align="right" valign="top">{SHOP_UBAY_DT_WEIGHT}</td>
    <td width="50%">&nbsp;{SHOP_UBAY_VLU_WEIGHT}</td>
  </tr>
  <tr>
    <td width="50%" align="right" valign="top">{SHOP_UBAY_DT_PS}</td>
    <td width="50%">&nbsp;{SHOP_UBAY_VLU_PS}</td>
  </tr>
  <tr>
    <td width="50%" align="right" valign="top">{SHOP_UBAY_DT_KMH}</td>
    <td width="50%">&nbsp;{SHOP_UBAY_VLU_KMH}</td>
  </tr>
  <tr>
    <td width="50%" align="right" valign="top">{SHOP_UBAY_DT_0100}</td>
    <td width="50%">&nbsp;{SHOP_UBAY_VLU_0100}</td>
  </tr>
  <tr>
    <td width="100%" colspan="2" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td width="100%" colspan="2" align="center"><b>{SHOP_UBAY_DT_NOT4CAR}</b></td>
  </tr>
  <tr>
    <td width="100%" colspan="2" align="center">{SHOP_UBAY_VLU_NOT4CAR}</td>
  </tr>
  <tr>
    <td width="100%" colspan="2" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td width="100%" align="right" colspan="2">
    <fieldset style="border: 1px solid #747474; padding: 2px;">
    <legend>{SHOP_UBAY_DT_MYBIT}</legend>
    <table border="0" cellpadding="0" cellspacing="0"  width="100%">
      <form action="index.php?c=ubay&d=details&id={SHOP_UBAY_VLU_UBAYID}" method="POST">
      <input type="hidden" name="check" value="1">
      <tr>
        <td width="50%" align="right"><input class="txtfeld" type="text" name="p_biete" maxlength="6"></td>
        <td width="50%"><input type="submit" value="{SHOP_UBAY_DT_BTN_SEND}" onClick="return confirm('Wirklich mitbieten?'); submit();" class="button" {SHOP_UBAY_VLU_SPERRE}>{SHOP_UBAY_DT_MINBIT}</td>
      </tr>
      </form>
    </table>
    </fieldset></td>
  </tr>
  <tr>
    <td width="100%" colspan="2" align="center">&nbsp;</td>
  </tr>
</table>

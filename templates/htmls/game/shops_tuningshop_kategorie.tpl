        <table border="0" cellpadding="0" cellspacing="0" width="80%">
          <tr>
            <td width="100%" align="center">&nbsp;</td>
          </tr>
          <tr>
            <td width="100%">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
              <tr>
                <td width="100%" align="left" colspan="3">&nbsp;<b>{SHOP_TSHOP_VLU_ARTIKELNAME}</b></td>
              </tr>
              <tr>
                <td width="40%" rowspan="9" align="center">
                <table border="1" cellpadding="0" cellspacing="0" {SHOP_TSHOP_VLU_BILD_GR}>
                  <tr>
                    <td width="100%" align="center">{SHOP_TSHOP_VLU_BILD}</td>
                  </tr>
                </table>
                </td>
              </tr>
              <tr>
                <td width="25%" align="right">{SHOP_TSHOP_MIN_ANSEHEN}</td>
                <td width="30%">&nbsp;{SHOP_TSHOP_VLU_ANSEHEN}</td>
              </tr>
              <tr>
                <td width="25%" align="right">{SHOP_TSHOP_MIN_RUF}</td>
                <td width="30%">&nbsp;{SHOP_TSHOP_VLU_RUF}</td>
              </tr>
              <tr>
                <td width="25%" align="right">{SHOP_TSHOP_MIN_KLASSE}</td>
                <td width="30%">&nbsp;{SHOP_TSHOP_VLU_KLASSE}</td>
              </tr>
              <tr>
                <td width="25%" align="right">{SHOP_TSHOP_STYLE}</td>
                <td width="30%">&nbsp;{SHOP_TSHOP_VLU_STYLE}</td>
              </tr>
              <tr>
                <td width="25%" align="right">{SHOP_TSHOP_GEWICHT}</td>
                <td width="30%">&nbsp;{SHOP_TSHOP_VLU_GEWICHT}</td>
              </tr>
              <tr>
                <td width="25%" align="right">{SHOP_TSHOP_PS}</td>
                <td width="30%">&nbsp;{SHOP_TSHOP_VLU_PS}</td>
              </tr>
              <tr>
                <td width="25%" align="right">{SHOP_TSHOP_KMH}</td>
                <td width="30%">&nbsp;{SHOP_TSHOP_VLU_KMH}</td>
              </tr>
              <tr>
                <td width="25%" align="right">{SHOP_TSHOP_0100}</td>
                <td width="30%">&nbsp;{SHOP_TSHOP_VLU_0100}</td>
              </tr>
              <tr>
                <td width="100%" align="center" colspan="3" height="30"><font color="red">{SHOP_TSHOP_NOT_FOR}{SHOP_TSHOP_VLU_NOT_FOR}</font></td>
              </tr>
              <form action="index.php?c=tuningshop&d=buy&tid={SHOP_TSHOP_VLU_ARTID}" method="POST">
              <input type="hidden" name="check" value="1">
              <tr>
                <td width="40%" align="center">{SHOP_TSHOP_PREIS}{SHOPT_TSHOP_VLU_PREIS}</td>
                <td width="67%" align="center" colspan="2"><input class="button" onClick="return confirm('Dieses Tuningteil wirklich kaufen?'); submit();" type="submit" {SHOP_TSHOP_VLU_BUTTON}value="{SHOP_TSHOP_BTN_BUY}"></td>
              </tr>
              </form>
            </table>
            </td>
          </tr>
          <tr>
            <td width="100%">&nbsp;</td>
          </tr>
        </table>

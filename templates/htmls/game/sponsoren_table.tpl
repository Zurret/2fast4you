              <td width="100%" align="center" valign="top">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                  <tr>
                    <td width="100%" align="center">{SPONSOR_VLU_NAME}</td>
                  </tr>
                  <tr>
                    <td width="100%" height="105" align="center">
                    <table border="1" cellpadding="0" cellspacing="0" width="175" height="100">
                      <tr>
                        <td width="100%" align="center">{SPONSOR_VLU_BILD}</td>
                      </tr>
                    </table>
                    </td>
                  </tr>
                  <tr>
                    <td width="100%">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <form action="index.php?c=sponsoren&d=getsponsor&sid={SPONSOR_VLU_SID}" method="POST">   
                      <tr>
                        <td width="50%" align="right">{SPONSOR_BASIS}</td>
                        <td width="50%" align="left">&nbsp;{SPONSOR_VLU_BASIS}</td>
                      </tr>
                      <tr>
                        <td width="50%" align="right">{SPONSOR_BONUS}</td>
                        <td width="50%" align="left">&nbsp;{SPONSOR_VLU_BONUS}</td>
                      </tr>
                      <tr>
                        <td width="50%" align="right">{SPONSOR_DAUER}</td>
                        <td width="50%" align="left">&nbsp;{SPONSOR_VLU_DAUER}{SPONSOR_WOCHEN}</td>
                      </tr>
                      <tr>
                        <td width="100%" align="center" colspan="2" height="30"><input type="submit" value="{SPONSOR_BTN_VERTRAG}" {SPONSOR_VLU_DISABLED} class="button"></td>
                      </tr>
                      </form>
                    </table>
                    </td>
                  </tr>
                </table>
              </td>

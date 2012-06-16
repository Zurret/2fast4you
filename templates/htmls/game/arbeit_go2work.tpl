          <tr>
            <td width="100%">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
              <tr>
                <td width="50%"><i>{ARBEIT_WORK}</i></td>
                <td width="50%"><i>{ARBEIT_FIRE}</i></td>
              </tr>
              <form action="index.php?c=arbeit" method="POST">
              <input type="hidden" name="check" value="1">
              <tr>
                <td width="50%">{ARBEIT_DAUER}<select size="1" name="p_work" class="txtfeld">{ARBEIT_VLU_ARBEITSZEIT}</select><input type="submit" value="{ARBEIT_GO2WORK}" class="button"></td>
                <td width="50%" align="center"><b><font color="#FF0000">{ARBEIT_FIRE_WARN}</font></b></td>
              </tr>
              <tr>
                <td width="50%" align="center">&nbsp;</td></form>
                <form action="index.php?c=jobboerse&d=fireit" method="POST"><td width="50%" align="center"><input type="submit" value="{ARBEIT_FIREIT}" class="button" onClick="return confirm('Wirklich Kündigen?'); submit();"></td></form>
              </tr>
            </table>
            </td>
          </tr>
          <tr>
            <td width="100%">&nbsp;</td>
          </tr>
          <tr>
            <td width="100%" align="center">{ARBEIT_HINWEIS}</td>
          </tr>

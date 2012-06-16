    <tr>
      <td width="100%" align="center">
      <table border="0" cellspacing="0" width="400" align="center">
      <form action="index.php?c=club&d=board&b=write" method="POST">
      <input type="hidden" name="check" value="1">
        <tr>
          <td width="100%" align="left" colspan="2">
          <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
              <td width="100%">{CLUB_BOARD_BETREFF}</td>
            </tr>
            <tr>
              <td width="100%"><input type="text" name="p_betreff" style="width: 395px;" maxlength="20" class="txtfeld"></td>
            </tr>
          </table>
          </td>
        </tr>
        <tr>
          <td width="100%" align="left" colspan="2">
          <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
              <td width="100%">{CLUB_BOARD_MSG}</td>
            </tr>
            <tr>
              <td width="100%"><textarea rows="11" name="p_nachricht" style="width: 395px;" cols="47" class="txtarea"></textarea></td>
            </tr>
          </table>
          </td>
        </tr>
        <tr>
          <td width="75%" align="left">{CLUB_BOARD_WRT_OK}</td>
          <td width="25%" align="right"><input type="submit" value="{CLUB_BOARD_WRT_BTN}" class="button"></td>
        </tr>
        </form>
      </table>
      </td>
    </tr>
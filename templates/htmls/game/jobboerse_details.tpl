<table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="black">
  <tr>
    <td width="100%" align="center" class="ueberschift" height="26">{JOBS_TOPIC}</td>
  </tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="100%" height="100%" class="innen">
    <tr>
      <td height="5" class="space"></td>
    </tr>
    <tr>
    <td width="100%" align="left" valign="top">
    <table border="1" cellpadding="0" cellspacing="0" bordercolor="#111111" width="100%">
      <tr>
        <td width="100%" height="300" valign="top" align="center">
        <table border="0" cellpadding="0" cellspacing="0" width="80%">
          <tr>
            <td width="100%" align="center">&nbsp;</td>
          </tr>
          <tr>
            <td width="100%" align="center" valign="middle">
            <table border="1" cellpadding="0" cellspacing="0" {JOBS_VLU_BILDWH}>
              <tr>
                <td width="100%" align="center">{JOBS_VLU_BERUFBILD}</td>
              </tr>
            </table>
            </td>
          </tr>
          <tr>
            <td width="50%" align="center">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <form action="index.php?c=jobboerse&d=getit&jid={JOBS_VLU_JOBID}" method="POST">
              <tr>
                <td width="50%" align="right">{JOBS_BERUFNAME}</td>
                <td width="50%">&nbsp;{JOBS_VLU_NAME}</td>
              </tr>
              <tr>
                <td width="50%" align="right">{JOBS_HOURLOHN}</td>
                <td width="50%">&nbsp;{JOBS_VLU_HOURLOHN}</td>
              </tr>
              <tr>
                <td width="50%" align="right">{JOBS_DAYLOHN}</td>
                <td width="50%">&nbsp;{JOBS_VLU_TAGESLOHN}</td>
              </tr>
              <tr>
                <td width="100%" align="center" colspan="2" height="30"><input type="submit" value="{JOBS_GETJOB}" {JOBS_VLU_DISABLED} class="button"></td>
              </tr>
              <tr>
                <td width="100%" align="center" colspan="2">&nbsp;</td>
              </tr>
              <tr>
                <td width="100%" align="center" colspan="2">{JOBS_FIREFRIST}</td>
              </tr>
              </form>
            </table>
            </td>
          </tr>
          </table>
        </td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td height="5" class="space"></td>
  </tr>
</table><br />

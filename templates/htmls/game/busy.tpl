<script language="Javascript">
<!--
var cdown = "{BUSY_WORKTIME}";
function doCounter() {
 if (cdown > 0){
    cdown--;
 } else {        
    location.href = '{BUSY_FINISH_URL}';
 }
 var s = cdown;
 var h = Math.floor(s / 3600);
 var m = Math.floor((s - (h * 3600)) / 60);
 s = (s - (h * 3600)) % 60;
 if(h <= 9) {h = "0" + h;}
 if(m <= 9) {m = "0" + m;}
 if(s <= 9) {s = "0" + s;}
 document.getElementById('verybusy').innerHTML = h + ":" + m + ":" + s;
 window.setTimeout("doCounter()", 1000);
}
 window.setTimeout("doCounter()", 2);
//-->
</script>
<table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="black">
      <tr>
        <td width="100%" align="center" class="ueberschift" height="26">{BUSY_TOPIC}</td>
      </tr>
</table>
<table border="1" cellpadding="0" cellspacing="0" bordercolor="black" width="100%" class="innen">
      <tr>
     <td height="5" class="space"></td>
    </tr>
  <tr>
    <td width="100%" align="center">
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
      <tr>
        <td width="15%" align="center" height="25"><p id="verybusy">--:--:--</p></td>
        <td width="85%" align="left">{BUSY_TEXT}</td>
      </tr>
    </table>
    </td>
  </tr>
        <tr>
     <td height="5" class="space"></td>
    </tr>
</table><br />

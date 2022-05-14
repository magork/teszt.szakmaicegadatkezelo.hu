<h3>Regisztráció</h3>
<form action="index.php?do=send_reg" method="post" enctype="multipart/form-data">
<table width="500" border="0" cellpadding="0" cellspacing="5">
  <tr>
    <td colspan="2">Ha szeretn&eacute; a v&aacute;llalkoz&aacute;s&aacute;t az adatb&aacute;zisunkban megjelen&iacute;tettni,akkor<br>
k&eacute;rj&uuml;k,hogy minden mez&#337;t pontosan t&ouml;lts&ouml;n ki.Koll&eacute;g&aacute;ink hamarosan<br>
megkeresik.<br></td>
  </tr>
  <tr>
    <td width="142" align="right">C&eacute;gn&eacute;v:</td>
    <td width="348"><input name="comp" type="text" size="40"></td>
  </tr>
  <tr>
    <td align="right">Az &Ouml;n neve:</td>
    <td><input name="user" type="text" size="40"></td>
  </tr>
  <tr>
    <td align="right">Telefonsz&aacute;m:</td>
    <td><input name="tel" type="text" size="40">
      </td>
  </tr>
      <tr>
        <td align="left">Ellen&#337;rz&#337; kód:</td>
        <td><img src="/captcha.php"> megismétlése: <input id="security_code" name="security_code" type="text" size="30">
          </td>
      </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td><input type="submit" name="Submit" value="Regisztr&aacute;lok" style="width:95px "></td>
  </tr>
</table>
</form>

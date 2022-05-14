<h3>Részletes kereső</h3>

<form action="index.php?do=comp_search" method="get">		
<input type="hidden" name="do" value="comp_search" />
<input type="hidden" name="type" value="adv" />
<table width="500" border="0" cellpadding="5" id="sf">
  <tr>
    <td valign="top">
		Keresés cégnévre
		<input type="text" id="q1"name="cname" /></td>
    <td valign="bottom">&nbsp;</td>
	
    <td valign="top">
		Keresés tevékenységre<br>
		<input type="text" id="q6" name="cat" /></td>
    <td valign="bottom">&nbsp; </td>
  </tr>

  <tr>
    <td valign="top">
		Keresés városra
		<input type="text" id="q2" name="city" /></td>
    <td valign="bottom">&nbsp;</td>

    <td valign="top">
		Keresés minősítésre<br>
		<input type="text"id="q4" name="iso"  />
	</td>
    <td valign="bottom">&nbsp;</td>
  </tr>

  <tr>
    <td valign="top">
		Keresés márkanévre
		<input type="text" id="q5" name="brand" /></td>
    <td valign="bottom">&nbsp;</td>

    <td valign="top">
	Keresés régióra
	<select name="region" id='q3'>
      <option value="">Válasszon megyét</option>
      <option value="12">B&#225;cs-Kiskun megye</option>
      <option value="16">Baranya megye</option>
      <option value="11">B&#233;k&#233;s megye</option>
      <option value="7">Borsod-Aba&#250;j-Zempl&#233;n megye</option>
      <option value="13">Csongr&#225;d megye</option>
      <option value="4">Fej&#233;r megye</option>
      <option value="19">Győr-Moson-Sopron megye</option>
      <option value="8">Hajd&#250;-Bihar megye</option>
      <option value="6">Heves megye</option>
      <option value="10">J&#225;sz-Nagykun-Szolnok megye</option>
      <option value="3">Kom&#225;rom-Esztergom megye</option>
      <option value="5">N&#243;gr&#225;d megye</option>
      <option value="2">Pest megye</option>
      <option value="15">Somogy megye</option>
      <option value="9">Szabolcs-Szatm&#225;r-Bereg megye</option>
      <option value="14">Tolna megye</option>
      <option value="20">Vas megye</option>
      <option value="17">Veszpr&#233;m megye</option>
      <option value="18">Zala megye</option>
    </select> </td>
    <td valign="bottom"></td>
  </tr>
</table>
<h3><button type="submit">Mehet</button></h3>
</form>

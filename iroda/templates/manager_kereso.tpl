<h2>Keresés cégek között</h2>
<form id=kereso name=kereso method=POST action='manager_kereso.php'>

<table> 
	<tr>
		<th width=80> </th>
		<th> Keresési feltételek </th>
	</tr>	
	<tr>
	{if ($admin)}
		<td > Üzletkötő neve: </td>
		<td> <input type=text id='usname' name='usname' value='{$k_usname}' size=70> </td>
	
	</tr>
	<tr>
		<td> Cég azonosítószáma: </td>
		<td> <input type=text id='cid' name='cid' value='{$k_cid}' size=70> </td>
	
	</tr>
	{/if}
	<tr>
		<td> Cég neve: </td>
		<td> <input type=text id='cegnev' name='cegnev' value='{$k_cegnev}'  size=70> </td>
	</tr>
	<tr>
		<td> Cég címe: </td>
		<td> <input type=text id='cim' name='cim' value='{$k_cim}'  size=70> </td>
	
	</tr>
	{if ($admin)}
	<tr>
		<td> Szűrés: </td>
		<td>
			<select name=szur id=szur>
				<option value=-1> Nincs szűrés </option>
				<option value=0> Még nem hívott </option>
				<option value=2> Visszahívni </option>
				<option value=4> Sztornó </option>
				<option value=5> Regisztrált </option>
				<option value=6> Regisztráció alatt </option>
				<option value=7> Ajánlat küldve </option>		
			</select>
		</td>
	</tr>
	<tr>
		<td>Státusz beállítás dátuma: </td>
		<td> 
			<input type=text id='regdatK' name='regdatK' value='{$k_regk}'> -tól <input type=text id='regdatV' name='regdatV' value='{$k_regv}'> -ig
			(éééé-hh-nn / pl: 2007-01-01)
		</td>
	
	</tr>
	{/if}
	<tr>
		<td> </td>
		<td> <input type=submit value='Keres' onClick="return G_isNum('cid','Cégazonosító csak szám lehet!')"> </td>
	</tr>
</table>

</form>

<script>
   document.getElementById('szur').value='{$szuro}';
</script>

{if ($sorok == 0)}
	<h3> 0 Találat </h3>
{else}

<h3> Találatok összesen: {$sorok} db</h3>

<table id="test">
	<tr>
		<th>ID</th>
		<th>Cégnév</th>
		<th>Üzletkötő</th>
		<th>Cím</th>
		<th>Telefon</th>
		<th>Állapot</th>
		<th>Felvitel napja</th>
		<th>Utolsó módosítás napja</th>
		<th>Megjegyzés</th>
		<th style="width: 100px">Műveletek</th>
	</tr>

	{ foreach value=d from=$db }
		<tr id="list{ $d.cid }">
			<td> {$d.cid}</td>
	        	<td height=60 align="center">{$d.cegnev}</td>
	        	<td> <a href='mailto:{$d.usemail}'>{$d.usname}</a> </td>
	        	<td> {$d.cim} </td>
			<td> {$d.tel}</td>
			<td> {$d.allapot} <br> {$d.adstatdat} </td>
		        <td> {$d.felvdat} </td>
		        <td> {$d.moddat} </td>        	        	
		        <td> {$d.megj} </td>        	
		        <td>	
				{if (($d.editable) and (!$admin)) }
					<img src="images/pick.gif" align="absmiddle"><a style="font-weight: bold" href='manager_cegeim.php?event=felvesz&cid={$d.cid}'>Felvesz</a>
				{/if}
				{if ($admin)}
					<a href='manager_cedit.php?id={$d.cid}' class="edit"><img src="images/icons/edit.png" align="absmiddle">Szerkeszt</a>
					<br>
			        	<a href="manager_caedit.php?event=del&cid={$d.cid}" onClick="return confirm('Tényleg törljem az adatbázisból?')"><img src="images/icons/delete.png" align="absmiddle">Törlés végleg</a> <br>
					 

				{/if}
	        	</td>
		</tr>
	{ /foreach }

</table>

<p align="center">
	{ if $pager }
		{ if $pager.prevenabled }
				<a href="manager_kereso.php?tol={ $pager.prev }">Előző</a>
		{ /if }
		
		{ foreach from=$pager.tolok value=tol } 
		
				{ if $tol.selected }
					<span>{ $tol.szam }</span>
				{ else }
					<a href="manager_kereso.php?tol={ $tol.tol }"><strong>{ $tol.szam }</strong></a>
				{ /if }
				
		{ /foreach }
		
		{ if $pager.nextenabled }
					<a href="manager_kereso.php?tol={ $pager.next }">Következő</a>
		{ /if }
	{ /if }
</p>
{/if}	

<h2>Üzletkötők menüpontja (Munkakosár)</h2>
<br>
{if ($lehet)}	<img src="images/action_go.gif" align="absmiddle"><a href='manager_cedit.php' style='font-weight: bold'> Új Cég hozzáadása </a>
{else}
	Jelenleg nincs lehetősége több cég felvitelére.
{/if}
<br><br>
<form id=szuro name=szuro method=POST action='manager_cegeim.php'>
Szűrés: 
	<select name=szur id=szur>
		<option value=-1> Nincs szűrés </option>
		<option value=4> Sztornó </option>
		<option value=5> Regisztrált </option>
		<option value=6> Regisztráció alatt </option>
		<option value=7> Ajánlat elküldve </option>	
	</select>
	<input type=submit value='Szűkít'>
</form>
<script>
   document.getElementById('szur').value='{$szuro}';
</script>

<table id="test">
	<tr>	<th>ID</th>
		<th>Cégnév</th>
		<th>Cím</th>
		<th>Telefonszám</th>
		<th>Állapot</th>
		<th>Felvitel napja</th>
		<th>Utolsó módosítás napja</th>
		<th>Megjegyzés</th>
		<th style="width: 150px">Műveletek</th>
	</tr>

	{ foreach value=d from=$db }
		<tr id="list{ $d.usid }">
			<td>{$d.cid}</td>
	        	<td height=60 align="center">{$d.cegnev}</td>
	        	<td> {$d.cim} </td>
			<td> {$d.telszam} </td>
			<td> {$d.allapot}  <br> {$d.adstatdat} </td>
		        <td> {$d.felvdat} </td>
		        <td> {$d.moddat} </td>        	        	
		        <td> {$d.megj} </td>        	
		        <td>	
				{if ($d.editable) }
					{if ($d.torl)}
			        		<a href="?event=del&cid={$d.cid}" onClick="return confirm('Tényleg törljem az adatbázisból?')"><img src="images/icons/delete.png" align="absmiddle">Törlés végleg</a> <br>
					{/if} 
					{if ($d.torl1)}
				        <a href="?event=del1&cid={$d.cid}" onClick="return confirm('Tényleg törljem a munkakosárból?')"><img src="images/icons/delete.png" align="absmiddle">Törlés a munkakosárból</a> <br>
					{/if}
					<a href="manager_cedit.php?id={$d.cid}" class="edit"><img src="images/icons/edit.png" align="absmiddle">Szerkeszt</a>
				{else}  

					Nem szerkeszthető

				{/if}
	        	</td>
		</tr>
	{ /foreach }

</table>

<p align="center">
	{ if $pager }
		{ if $pager.prevenabled }
				<a href="manager_cegeim.php?tol={ $pager.prev }">Előző</a>
		{ /if }
		
		{ foreach from=$pager.tolok value=tol } 
		
				{ if $tol.selected }
					<span>{ $tol.szam }</span>
				{ else }
					<a href="manager_cegeim.php?tol={ $tol.tol }"><strong>{ $tol.szam }</strong></a>
				{ /if }
				
		{ /foreach }
		
		{ if $pager.nextenabled }
					<a href="manager_cegeim.php?tol={ $pager.next }">Következő</a>
		{ /if }
	{ /if }
</p>
	

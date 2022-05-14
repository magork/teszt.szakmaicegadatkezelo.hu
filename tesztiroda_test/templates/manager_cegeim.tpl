<h2>Üzletkötők menüpontja (Munkakosár)</h2>
<br>
{if ($lehet)}	<img src="images/action_go.gif" align="absmiddle"><a href='manager_cedit.php' style='font-weight: bold'> Új Cég hozzáadása </a>
{else}
	Jelenleg nincs lehetősége több cég felvitelére.
{/if}
<br><br>
<form id=szuro name=szuro method=POST action='manager_cegeim.php'>
Szűrés: <br/>
	Cégnév:
	<input name="szurnev" value="{$szurnev}" />
	<select name=szur id=szur>
		<option value=-1> --Állapot-- </option>
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
		<th>Portál</th>
		<th>Cím</th>
		<th>Telefonszám</th>
		<th>Állapot</th>
		<th>Utolsó módosítás napja</th>
		<th>Megjegyzés</th>
		<th style="width: 150px">Műveletek</th>
	</tr>

	{ foreach value=d from=$db }
		<tr id="list{ $d.usid }" style="border-top:solid 2px #888 !important;">
			<td { if ($d.portal|@count > 1 ) }valign="bottom"{ /if }>{$d.cid}</td>
        	<td height=60 align="center" { if ($d.portal|@count > 1 ) }valign="bottom"{ /if } >{$d.cegnev}</td>
        	<td> 					
					<strong>{$d.portal[0].name}</strong><br/>
					{$d.portal[0].date}					
			</td>
        	<td> {$d.cim} </td>
			<td> {$d.telszam} </td>
			<td> 
				{$d.portal[0].allapot}<br/>
				{$d.portal[0].adstatdat}
			</td>
			<td> {$d.moddat} </td>       
			<td><strong>[{ $d.portal[0].name }]</strong><br/> {$d.portal[0].megj}  <br></td>
			<td>	
				{if ($d.not_editable|@count < $d.p_connects|@count) }
					{if ($d.not_torl|@count < $d.p_connects|@count) }
			        	<a href="javascript:void(0)" class="cegeim_torl"  alt='{ $d.not_torl|@json_encode }' value="{$d.cid}" rel='{ $d.p_connects|@json_encode }' ><img src="images/icons/delete.png" align="absmiddle">Törlés végleg</a> <br>
					{/if} 
					{if ($d.not_torl1|@count < $d.p_connects|@count) }
				        <a href="javascript:void(0)" class="cegeim_torl1"  alt='{ $d.not_torl1|@json_encode }' value="{$d.cid}" rel='{ $d.p_connects|@json_encode }' ><img src="images/icons/delete.png" align="absmiddle">Törlés a munkakosárból</a> <br>
					{/if}
					<a href=javascript:void(0)" class="cegeim_edit" alt='{ $d.not_editable|@json_encode }' value="{$d.cid}" rel='{ $d.p_connects|@json_encode }'><img src="images/icons/edit.png" align="absmiddle">Szerkeszt</a>
				{else}  

					Nem szerkeszthető

				{/if}
	        	</td>
			</tr> 	        	

			{ foreach from=$d.portal value=ii key=kk }
			{ if ($kk>0) } 
			<tr> 				
				<td> </td>		        		       
				<td> </td>
				<td>
					<strong>{$ii.name}</strong><br/>
						{$ii.date}				
				</td>
				<td> </td>
				<td> </td>
				<td>
					{$ii.allapot}<br/>
					{$ii.adstatdat}
				</td>
				<td> </td>
				<td><strong>[{ $ii.name }]</strong><br/> {$ii.megj}</td>
				<td> </td>
			</tr>
			{ /if }
			{ /foreach }
		{ /foreach }

</table>
<script>
  var portalok = { $portal_list|@json_encode };
  $(function(){ldelim}
  		create_portal_dialog('torl1','.cegeim_torl1','manager_cegeim.php?event=del1','Cég Törlése a Munkakosárból','Válassza ki melyik melyik portálon szeretné eltávolítani a munkakosarából!');
  		create_portal_dialog('torl','.cegeim_torl','manager_cegeim.php?event=del','Cég Végleges Törlése a Portálról','Válassza ki melyik melyik portálon szeretné véglegesen törölni a céget!');
  		create_portal_dialog('edit','.cegeim_edit','manager_cedit.php','Cég Szerkesztése','Válassza ki melyik melyik portálon szeretné szerkeszteni a céget!',true);
  {rdelim});
</script>
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
	

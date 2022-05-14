<h2>Keresés cégek között</h2>
<form id=kereso name=kereso method=POST action='manager_kereso.php'>

<table> 
	<tr>
		<th width=80> </th>
		<th {if ($admin)}colspan="2"{ /if } > Keresési feltételek </th>
	</tr>	
	<tr>
	{if ($admin)}
		<td > Üzletkötő neve: </td>
		<td> <input type=text id='usname' name='usname' value='{$k_usname}' size=70> </td>
		<td rowspan="7">
			{ foreach from=$portalok value=i key=k }
				<input type="checkbox" id="portalok_{$k}" name="portalok_{$k}" value="1" { if ($k|in_array:$portal_ids) }checked="checked"{ /if } />
				&nbsp;
				{ $i }
				<br/>
			{ /foreach }
		</td>
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
		<td> <input type=submit value='Keres' name='kereses_esemeny' onClick="return G_isNum('cid','Cégazonosító csak szám lehet!')"> </td>
	</tr>
</table>

</form>

<script>
   if(document.getElementById('szur'))document.getElementById('szur').value='{$szuro}';
</script>

{if ($sorok == 0)}
	<h3> 0 Találat </h3>
{else}

<h3> Találatok összesen: {$sorok} db</h3>

<table id="test">
	<tr>
		<th>ID</th>
		<th>Cégnév</th>
	
			<th width="150">Portál</th>

		<th>Üzletkötő</th>
		<th>Cím</th>
		<th>Telefon</th>
		<th width="300" >Állapot</th>	
		<th style="width:15%">Megjegyzés</th>
		<th style="width: 100px">Műveletek</th>
	</tr>

	{ foreach value=d from=$db }
		<tr id="list{ $d.cid }" style="border-top:solid 2px #888 !important;">
			<td { if ($d.portal|@count > 1 ) }valign="bottom"{ /if }  > {$d.cid}</td>
        	<td { if ($d.portal|@count  > 1 ) }valign="bottom"{ /if } height=60 align="center">{$d.cegnev}</td>	     
			<td> 
				
					<strong>{$d.portal[0].name}</strong><br/> <i>{ $d.portal[0].date }</i> <br>
				
			</td>		
        	<td> 
        		<a href='mailto:{$d.portal[0].usemail}'>{$d.portal[0].usname}</a> 
        	</td>
        	<td { if ($d.portal|@count > 1) }valign="bottom"{ /if }> {$d.cim} </td>
			<td { if ($d.portal|@count > 1) }valign="bottom"{ /if }> {$d.tel}</td>
			<td> 		
				
					{$d.portal[0].allapot} [ <i>{ $d.portal[0].name }</i> ] <br/><i>{ $d.portal[0].adstatdat }</i>  <br>
				
		 	</td>
		             	        	
	        <td>  
	        	
	        		<strong>[{ $d.portal[0].name }]</strong><br/> {$d.portal[0].megj}  <br>
	        	
	        </td>        	
	        <td { if ($d.portal|@count > 1 ) }valign="bottom"{ /if }>	
<!--
Kovge kód
			{if (( $d.not_editable|@count < $portalok|@count ) and (!$admin)) }
			{/if}
-->
			{if (( $d.portal[0].allapot == '<b>Sztornó</b>' ) and (!$admin)) }
				<img src="images/pick.gif" align="absmiddle"><a href='javascript:void()' style="font-weight: bold" class="felvesz_link" alt='{ $d.not_editable|@json_encode }' value="{$d.cid}" >Felvesz</a>
			{/if}
			{if ($admin)}
				<a href='manager_cedit.php?id={$d.cid}' class="edit"><img src="images/icons/edit.png" align="absmiddle">Szerkeszt</a>
				<br>
		        <a href="manager_caedit.php?event=del&cid={$d.cid}" onClick="return confirm('Tényleg törljem az adatbázisból?')"><img src="images/icons/delete.png" align="absmiddle">Törlés végleg</a> <br>					 
			{/if}
        	</td>
		</tr>
		{ foreach from=$d.portal key=kk value=ii }
			{ if ($kk!=0) }					
			<tr> 
				
				<td> </td>
				<td> </td>
				<td>
					<strong>{$ii.name}</strong><br/> <i>{ $ii.date }</i> 			
				</td>
				<td>
					<a href='mailto:{$ii.usemail}'>{$ii.usname}</a>  			
				</td>
				<td> </td>
				<td> </td>
				<td>
					{$ii.allapot} [ <i>{ $ii.name }</i> ] <br/><i>{ $ii.adstatdat }</i> 
				</td>
				<td>
					<strong>[{ $ii.name }]</strong><br/> {$ii.megj}
				</td>
				<td> </td>
			</tr>
			{ /if }
		{ /foreach }
	{ /foreach }

</table>
<!-- 
<div id="dialog-form" title="Cég felvétele" style="height:90px">	
	<p class="validateTips">Válassza ki melyik melyik portálon szeretné felvenni a céget!</p>
	<form>
	<fieldset>
		<input type="hidden" name="ceg_felvesz" id="ceg_felvesz" value="0" />
		<label for="portal">Portál:</label>
		<select type="text" name="portal_felvesz" id="portal_felvesz" class="select ui-widget-content ui-corner-all" >
			<option value="0"> --Válasszon-- </option>
		</select>
		
	</fieldset>
	</form>
</div>
-->
<script>
  var portalok = { $portalok|@json_encode };
  $(function(){ldelim}
  		create_portal_dialog('felvesz','.felvesz_link','manager_cegeim.php?event=felvesz','Cég felvétele','Válassza ki melyik melyik portálon szeretné felvenni a céget!');
  {rdelim});
</script>
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

{if ($admin)}
<h2>Cég szerkesztése</h2>
{else}
<h2>Üzletkötők menüpontja</h2>
{/if}
{if !($admin)}
	<form id='new' name='new' method = POST action='manager_cegeim.php?event={$event}'>
{else}
	<form id='new' name='new' method = POST action='manager_caedit.php?event={$event}'>
{/if}
	<table>
	<tr >	
		<th width=80 >   </th>
		<th> 
			{if $cid == 0} 
				Új cég felvétele 
			{else}
				{$cid}-as azonosítójú cég szerkesztése
				<input type=hidden name='cid' id='cid' value='{$cid}'>
				<input type=hidden name='pid' id='cid' value='{$pid}'>
			{/if}
		</th>
		
	</tr>
	<tr>
		<td >Cégnév:</td>
		<td ><input {if (!($admin) and ($nem)) } disabled  {/if} type=text name=cegnev id=cegnev value = '{$cegnev}' size=100></td>         
	</tr>	
	<tr>
		<td >Cim:</td>
		<td><input {if (!($admin) and ($nem)) } disabled  {/if} type=text name=cim id=cim value = '{$cim}' size=100></td>
	</tr>
	<tr>
		<td >Telefon:</td>
		<td ><input {if (!($admin) and ($nem)) } disabled  {/if} type=text name=telszam id=telszam value = '{$telszam}'></td>
	</tr>	
	
	</table>
	<table>
	<tr>		
		<th valign="top">
			Portál:
		</th>
		<th valign="top">
			Állapot:
		</th>
		<th valign="top">
			Megjegyzés:
		</th>
		{ if ($admin) }
		<th valign="top">
			Üzletkötő:
		</th>
		{ /if }			
	</tr>
	{ foreach from=$portalok value=i key=k }	
	{ if ($admin || $k==$pid || $event=='add' )  }
	<tr>		
		<td valign="top">
			{ if ($admin || $event=='add') }
				<input type="checkbox" id="portalok_{$k}" name="portalok_{$k}" value="1" { if ($k|in_array:$portal_ids) }checked="checked"{ /if } />
			{ /if }
			&nbsp;<strong>{ $i }</strong>
		</td>
		<td valign="top">
			<select name='allapot_{$k}' { if (!$admin && !$ceg_data[$k].editable ) }readonly{ /if } >
				<option value=0 { if ($ceg_data[$k].allapot==0) }selected="selected"{ /if }> Még nem hívott </option>
				<option value=2 { if ($ceg_data[$k].allapot==2) }selected="selected"{ /if }> Visszahívni </option>
				{if ($admin)}
					<option value=4 { if ($ceg_data[$k].allapot==4) }selected="selected"{ /if } > Sztornó </option>
					<option value=5 { if ($ceg_data[$k].allapot==5) }selected="selected"{ /if } > Regisztrált </option>
					<option value=6 { if ($ceg_data[$k].allapot==6) }selected="selected"{ /if } > Regisztráció alatt </option>
					<option value=7 { if ($ceg_data[$k].allapot==7) }selected="selected"{ /if } > Ajánlat küldve </option>		
				{/if}			
			</select>
			<br/>
			{ $ceg_data[$k].adstatdat }
		</td>
		<td valign="top">
			<textarea name="megj_{$k}" cols=32 rows=5>{$ceg_data[$k].megj}</textarea>
		</td>		
		{ if ($admin) }			
		<td valign="top">
			{if ($admin)and($cid!=0)}
				<select name='uzletkid_{$k}' style="width:200px;">
					<option value=0> Senki </option>
					{foreach from=$userek item=i}
						<option value='{ $i.id }' { if ($ceg_data[$k].uzletkid==$i.id) }selected="selected"{ /if } >{ $i.usname }</option>
					{/foreach}
				</select>
			{/if}
		</td>     	
		{ /if }		
	</tr>
	{ /if }
	{ /foreach }
	<tr>
		<td colspan="2">
			
		</td>
		
		<td colspan="2">
		<input type=submit value='Mehet' name='save_ceg' onClick="return G_isntEmpty('telszam','Telefonszám megadása kötelező!')&&G_isntEmpty('cegnev','Cégnév megadása kötelező!')&&G_isntEmpty('cim','Cím megadása kötelező!')">
		
		</td>
		
	</table>	
	{if (!($admin) and ($nem)) }
		<input type=hidden name='cegnev' id='cegnev' value='{$cegnev}'>	
		<input type=hidden name='cim' id='cim' value='{$cim}'>
		<input type=hidden name='telszam' id='telszam' value='{$telszam}'>		
	{/if}
	
</form>


{if !($admin)}
	<img src="images/page_left.gif" align="absmiddle"><a href = 'manager_cegeim.php'> Vissza </a>
{else}
	<img src="images/page_left.gif" align="absmiddle"><a href = 'manager_kereso.php'> Vissza </a>
{/if}

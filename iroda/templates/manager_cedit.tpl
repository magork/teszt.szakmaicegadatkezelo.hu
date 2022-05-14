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
	<tr >	<th width=80>   </th>
		<th > 
			{if $cid == 0} 
				Új cég felvétele 
			{else}
				{$cid}-as azonosítójú cég szerkesztése
				<input type=hidden name='cid' id='cid' value='{$cid}'>
			{/if}
		</th>
		
	</tr>
	<tr>
		<td>Cégnév:</td>
		<td><input {if (!($admin) and ($nem)) } disabled  {/if} type=text name=cegnev id=cegnev value = '{$cegnev}' size=100></td>         
	</tr>
	{if ($admin)and($cid!=0)}
	<tr>
		<td>Üzletkötő</td>
		<td>
			<select name='uzletkid' id='uzletkid'>
				<option value=0> Senki </option>
				{foreach from=$userek item=i}
					<option value='{ $i.id }'>{ $i.usname }</option>
				{/foreach}
			</select>
		</td>         
	</tr>
	{/if}
	<tr>
		<td>Cim:</td>
		<td><input {if (!($admin) and ($nem)) } disabled  {/if} type=text name=cim id=cim value = '{$cim}' size=100></td>
	</tr>
	<tr>
		<td>Telefon:</td>
		<td><input {if (!($admin) and ($nem)) } disabled  {/if} type=text name=telszam id=telszam value = '{$telszam}'></td>
	</tr>
	
	<tr>
		<td>Állapot:</td>
		<td>
		<select name=allapot id=allapot>
			<option value=0> Még nem hívott </option>
			<option value=2> Visszahívni </option>
			{if ($admin)}
				<option value=4> Sztornó </option>
				<option value=5> Regisztrált </option>
				<option value=6> Regisztráció alatt </option>
				<option value=7> Ajánlat küldve </option>		
			{/if}
			
		</select>
		</td>
	</tr>
	<tr>
		<td>Megjegyzés:</td>
		<td><textarea name=megj id=megj cols=32 rows=5>{$megj}</textarea>
		</td>
	</tr>
	<tr>
		</td>
		<td> 
		<td>
		<input type=submit value='Mehet' onClick="return G_isntEmpty('telszam','Telefonszám megadása kötelező!')&&G_isntEmpty('cegnev','Cégnév megadása kötelező!')&&G_isntEmpty('cim','Cím megadása kötelező!')">
		
		</td>
		
	</table>
	{if (!($admin) and ($nem)) }
		<input type=hidden name='cegnev' id='cegnev' value='{$cegnev}'>	
		<input type=hidden name='cim' id='cim' value='{$cim}'>
		<input type=hidden name='telszam' id='telszam' value='{$telszam}'>		
	{/if}
	
</form>

<script>
	document.getElementById('allapot').value='{$allapot}';
</script>
{if !($admin)}
	<img src="images/page_left.gif" align="absmiddle"><a href = 'manager_cegeim.php'> Vissza </a>
{else}
	<script>
		document.getElementById('uzletkid').value='{$uzletkid}';
	</script>
	<img src="images/page_left.gif" align="absmiddle"><a href = 'manager_kereso.php'> Vissza </a>
{/if}

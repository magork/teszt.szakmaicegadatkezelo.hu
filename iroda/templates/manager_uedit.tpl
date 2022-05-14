<h2>Üzletkötők szerkesztése</h2>


<form id='new' name='new' method = POST action='manager_user.php?event={$event}'>
	<table>
	<tr >	<th width=80>   </th>
		<th > 
			{if $usid == 0} 
				Új üzletkötő felvétele 
			{else}
				{$usid}-as azonosítójú üzletkötő szerkesztése
				<input type=hidden name='usid' is='usid' value='{$usid}'>
			{/if}
		</th>
		
	</tr>
	<tr>
		<td>Usernév:</td>
		<td><input type=text name=usname id=usname value = '{$usname}'></td>
	</tr>
	<tr>
		<td>Email:</td>
		<td><input type=text name=usemail id=usemail value = '{if !$usemail}dolgozo@uzleticegtudakozo.hu{else}{$usemail}{/if}'></td>
	</tr>
	<tr>
		<td>Jelszó:</td>
		<td><input type=password name=uspass id=uspass value ='{$uspass}'></td>
	</tr>
	<tr>
		<td>Limit:</td>
		<td><input type=text name=uslim id=uslim value = '{$uslim}'></td>
	</tr>
	<tr>
		</td>
		<td> 
		<td>
		<input type=submit value='Mehet' onClick="return G_isntEmpty('usname','Usernév megadása kötelező!')&&G_isntEmpty('usemail','Email megadása kötelező!')&&G_reqLen('uspass',5,'Jelszó minimum 5 karakter legyen!')&&G_isntEmpty('uslim','Limit megadása kötelező!')&&G_isNum('uslim','A Limitnek számnak kell lennie')">
		
		</td>
		
	</table>
</form>

<img src="images/page_left.gif" align="absmiddle"><a href = 'manager_user.php'> Vissza </a>

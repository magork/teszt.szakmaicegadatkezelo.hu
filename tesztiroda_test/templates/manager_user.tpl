<h2>Üzletkötők szerkesztése</h2>
<br><img src="images/action_go.gif" align="absmiddle"><a href='manager_uedit.php'> Új Üzletkötő hozzáadása </a>

<table id="test">
	<tr>
		<th>Azonosító</th>
		<th width="220">Email</th>
		<th>Usernév</th>
		<th>Jelszó</th>
		<th>Limit</th>
		<th style="width: 150px">Műveletek</th>
	</tr>

	{ foreach value=d from=$db }
		<tr id="list{ $d.id }">
	        	<td align="center">{$d.usid}</td>
	        	<td> {$d.usemail}</td>
		        <td>{$d.usname}</td>
			<td>{$d.uspass}</td>
		        <td>{$d.uslim}</td>        	
		        <td>
	        		<a href="?event=del&id={$d.usid}" onClick="return confirm('Tényleg törljem?')"><img src="images/icons/delete.png" align="absmiddle">Törlés</a> <br>
				<a href="manager_uedit.php?id={$d.usid}" class="edit"><img src="images/icons/edit.png" align="absmiddle">Szerkeszt</a>
	        	</td>
		</tr>
	{ /foreach }

</table>

<p align="center">
	{ if $pager }
		{ if $pager.prevenabled }
				<a href="manager_user.php?tol={ $pager.prev }">Előző</a>
		{ /if }
		
		{ foreach from=$pager.tolok value=tol } 
		
				{ if $tol.selected }
					<span>{ $tol.szam }</span>
				{ else }
					<a href="manager_user.php?tol={ $tol.tol }"><strong>{ $tol.szam }</strong></a>
				{ /if }
				
		{ /foreach }
		
		{ if $pager.nextenabled }
					<a href="manager_user.php?tol={ $pager.next }">Következő</a>
		{ /if }
	{ /if }
</p>
	

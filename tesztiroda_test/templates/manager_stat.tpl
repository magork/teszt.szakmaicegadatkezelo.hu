<h2>Statisztikák</h2>


<form id=mirefoem name=mireform method=POST action='manager_stat.php'>
Üzletkötők akiknek legtöbb  
	<select name=mire id=mire>
		<option value=4> Sztornó </option>
		<option value=5> Regisztrált </option>
		<option value=6> Regisztráció alatt </option>
	</select>
	állapotú cége van,
	<br>
	ahol a státuszba helyezés dátuma:
	<input type=text id='regdatK' name='regdatK' value='{$k_regk}'> és <input type=text id='regdatV' name='regdatV' value='{$k_regv}'>között van
	<br>(dátum alakja: éééé-hh-nn / pl: 2007-01-01)<br>

	<input type=submit value='Mehet'>
</form>
<script>
   document.getElementById('mire').value='{$mire}';
</script>
<br>
<h3> Eredmények </h3>


<hr width=80%>


	{ foreach value=d from=$db }
		<table id="test">
			<tr>
				<th style='width:60px'>Darabszám</th>
				<th>Usernév</th>
			</tr>
			<tr>
				<td> {$d.db} </td>
		      		<td> <b><a href='mailto:{$d.usemail}'>{$d.usname}</a></b> <br> </td>
			</tr>
		</table>
		<table id='cg'>
		<tr>	
			<th>ID</th>
			<th>Cégnév</th>
			<th>Portál</th>
			<th>Cím</th>
			<th>Telefonszám</th>
			<th>Felvitel napja</th>
			<th>Státuszba helyezés dátuma</th>
			<th>Utolsó módosítás napja</th>
			<th>Megjegyzés</th>
		</tr>
		{foreach from=$d.cegek item=j}
			<tr>
				<td>{$j.cid}</td>
	        		<td height=60 align="center">{$j.cegnev}</td>
	        		<td> <b>{$j.portal_name}</b> <br> <i>{$j.pc_date}</i> </td>
	        		<td> {$j.cim} </td>
				<td> {$j.telszam} </td>
		        	<td> {$j.felvdat} </td>
				<td> {$j.adstatdat}</td>
		        	<td> {$j.moddat} </td>        	        	
		        	<td> {$j.megj} </td>        	
		        	
			</tr>
		{/foreach}		</table>
		<hr width=80%>	
	{ /foreach }



<p align="center">
	{ if $pager }
		{ if $pager.prevenabled }
				<a href="manager_stat.php?tol={ $pager.prev }">Előző</a>
		{ /if }
		
		{ foreach from=$pager.tolok value=tol } 
		
				{ if $tol.selected }
					<span>{ $tol.szam }</span>
				{ else }
					<a href="manager_stat.php?tol={ $tol.tol }"><strong>{ $tol.szam }</strong></a>
				{ /if }
				
		{ /foreach }
		
		{ if $pager.nextenabled }
					<a href="manager_stat.php?tol={ $pager.next }">Következő</a>
		{ /if }
	{ /if }
</p>
	

<?php /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2010-08-24 13:51:43 CEST */ ?><h2>Keresés cégek között</h2>
<form id=kereso name=kereso method=POST action='manager_kereso.php'>

<table> 
	<tr>
		<th width=80> </th>
		<th> Keresési feltételek </th>
	</tr>	
	<tr>
	<?php if (( $this->_vars['admin'] )): ?>
		<td > Üzletkötő neve: </td>
		<td> <input type=text id='usname' name='usname' value='<?php echo $this->_vars['k_usname']; ?>
' size=70> </td>
	
	</tr>
	<tr>
		<td> Cég azonosítószáma: </td>
		<td> <input type=text id='cid' name='cid' value='<?php echo $this->_vars['k_cid']; ?>
' size=70> </td>
	
	</tr>
	<?php endif; ?>
	<tr>
		<td> Cég neve: </td>
		<td> <input type=text id='cegnev' name='cegnev' value='<?php echo $this->_vars['k_cegnev']; ?>
'  size=70> </td>
	</tr>
	<tr>
		<td> Cég címe: </td>
		<td> <input type=text id='cim' name='cim' value='<?php echo $this->_vars['k_cim']; ?>
'  size=70> </td>
	
	</tr>
	<?php if (( $this->_vars['admin'] )): ?>
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
			<input type=text id='regdatK' name='regdatK' value='<?php echo $this->_vars['k_regk']; ?>
'> -tól <input type=text id='regdatV' name='regdatV' value='<?php echo $this->_vars['k_regv']; ?>
'> -ig
			(éééé-hh-nn / pl: 2007-01-01)
		</td>
	
	</tr>
	<?php endif; ?>
	<tr>
		<td> </td>
		<td> <input type=submit value='Keres' onClick="return G_isNum('cid','Cégazonosító csak szám lehet!')"> </td>
	</tr>
</table>

</form>

<script>
   document.getElementById('szur').value='<?php echo $this->_vars['szuro']; ?>
';
</script>

<?php if (( $this->_vars['sorok'] == 0 )): ?>
	<h3> 0 Találat </h3>
<?php else: ?>

<h3> Találatok összesen: <?php echo $this->_vars['sorok']; ?>
 db</h3>

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

	<?php if (count((array)$this->_vars['db'])): foreach ((array)$this->_vars['db'] as $this->_vars['d']): ?>
		<tr id="list<?php echo $this->_vars['d']['cid']; ?>
">
			<td> <?php echo $this->_vars['d']['cid']; ?>
</td>
	        	<td height=60 align="center"><?php echo $this->_vars['d']['cegnev']; ?>
</td>
	        	<td> <a href='mailto:<?php echo $this->_vars['d']['usemail']; ?>
'><?php echo $this->_vars['d']['usname']; ?>
</a> </td>
	        	<td> <?php echo $this->_vars['d']['cim']; ?>
 </td>
			<td> <?php echo $this->_vars['d']['tel']; ?>
</td>
			<td> <?php echo $this->_vars['d']['allapot']; ?>
 <br> <?php echo $this->_vars['d']['adstatdat']; ?>
 </td>
		        <td> <?php echo $this->_vars['d']['felvdat']; ?>
 </td>
		        <td> <?php echo $this->_vars['d']['moddat']; ?>
 </td>        	        	
		        <td> <?php echo $this->_vars['d']['megj']; ?>
 </td>        	
		        <td>	
				<?php if (( ( $this->_vars['d']['editable'] ) && ( ! $this->_vars['admin'] ) )): ?>
					<img src="images/pick.gif" align="absmiddle"><a style="font-weight: bold" href='manager_cegeim.php?event=felvesz&cid=<?php echo $this->_vars['d']['cid']; ?>
'>Felvesz</a>
				<?php endif; ?>
				<?php if (( $this->_vars['admin'] )): ?>
					<a href='manager_cedit.php?id=<?php echo $this->_vars['d']['cid']; ?>
' class="edit"><img src="images/icons/edit.png" align="absmiddle">Szerkeszt</a>
					<br>
			        	<a href="manager_caedit.php?event=del&cid=<?php echo $this->_vars['d']['cid']; ?>
" onClick="return confirm('Tényleg törljem az adatbázisból?')"><img src="images/icons/delete.png" align="absmiddle">Törlés végleg</a> <br>
					 

				<?php endif; ?>
	        	</td>
		</tr>
	<?php endforeach; endif; ?>

</table>

<p align="center">
	<?php if ($this->_vars['pager']): ?>
		<?php if ($this->_vars['pager']['prevenabled']): ?>
				<a href="manager_kereso.php?tol=<?php echo $this->_vars['pager']['prev']; ?>
">Előző</a>
		<?php endif; ?>
		
		<?php if (count((array)$this->_vars['pager']['tolok'])): foreach ((array)$this->_vars['pager']['tolok'] as $this->_vars['tol']): ?> 
		
				<?php if ($this->_vars['tol']['selected']): ?>
					<span><?php echo $this->_vars['tol']['szam']; ?>
</span>
				<?php else: ?>
					<a href="manager_kereso.php?tol=<?php echo $this->_vars['tol']['tol']; ?>
"><strong><?php echo $this->_vars['tol']['szam']; ?>
</strong></a>
				<?php endif; ?>
				
		<?php endforeach; endif; ?>
		
		<?php if ($this->_vars['pager']['nextenabled']): ?>
					<a href="manager_kereso.php?tol=<?php echo $this->_vars['pager']['next']; ?>
">Következő</a>
		<?php endif; ?>
	<?php endif; ?>
</p>
<?php endif; ?>	

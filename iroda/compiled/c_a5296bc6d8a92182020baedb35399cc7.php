<?php /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2010-09-27 17:20:04 CEST */  if (( $this->_vars['admin'] )): ?>
<h2>Cég szerkesztése</h2>
<?php else: ?>
<h2>Üzletkötők menüpontja</h2>
<?php endif;  if (! ( $this->_vars['admin'] )): ?>
	<form id='new' name='new' method = POST action='manager_cegeim.php?event=<?php echo $this->_vars['event']; ?>
'>
<?php else: ?>
	<form id='new' name='new' method = POST action='manager_caedit.php?event=<?php echo $this->_vars['event']; ?>
'>
<?php endif; ?>
	<table>
	<tr >	<th width=80>   </th>
		<th > 
			<?php if ($this->_vars['cid'] == 0): ?> 
				Új cég felvétele 
			<?php else: ?>
				<?php echo $this->_vars['cid']; ?>
-as azonosítójú cég szerkesztése
				<input type=hidden name='cid' id='cid' value='<?php echo $this->_vars['cid']; ?>
'>
			<?php endif; ?>
		</th>
		
	</tr>
	<tr>
		<td>Cégnév:</td>
		<td><input <?php if (( ! ( $this->_vars['admin'] ) && ( $this->_vars['nem'] ) )): ?> disabled  <?php endif; ?> type=text name=cegnev id=cegnev value = '<?php echo $this->_vars['cegnev']; ?>
' size=100></td>         
	</tr>
	<?php if (( $this->_vars['admin'] ) && ( $this->_vars['cid'] != 0 )): ?>
	<tr>
		<td>Üzletkötő</td>
		<td>
			<select name='uzletkid' id='uzletkid'>
				<option value=0> Senki </option>
				<?php if (count((array)$this->_vars['userek'])): foreach ((array)$this->_vars['userek'] as $this->_vars['i']): ?>
					<option value='<?php echo $this->_vars['i']['id']; ?>
'><?php echo $this->_vars['i']['usname']; ?>
</option>
				<?php endforeach; endif; ?>
			</select>
		</td>         
	</tr>
	<?php endif; ?>
	<tr>
		<td>Cim:</td>
		<td><input <?php if (( ! ( $this->_vars['admin'] ) && ( $this->_vars['nem'] ) )): ?> disabled  <?php endif; ?> type=text name=cim id=cim value = '<?php echo $this->_vars['cim']; ?>
' size=100></td>
	</tr>
	<tr>
		<td>Telefon:</td>
		<td><input <?php if (( ! ( $this->_vars['admin'] ) && ( $this->_vars['nem'] ) )): ?> disabled  <?php endif; ?> type=text name=telszam id=telszam value = '<?php echo $this->_vars['telszam']; ?>
'></td>
	</tr>
	
	<tr>
		<td>Állapot:</td>
		<td>
		<select name=allapot id=allapot>
			<option value=0> Még nem hívott </option>
			<option value=2> Visszahívni </option>
			<?php if (( $this->_vars['admin'] )): ?>
				<option value=4> Sztornó </option>
				<option value=5> Regisztrált </option>
				<option value=6> Regisztráció alatt </option>
				<option value=7> Ajánlat küldve </option>		
			<?php endif; ?>
			
		</select>
		</td>
	</tr>
	<tr>
		<td>Megjegyzés:</td>
		<td><textarea name=megj id=megj cols=32 rows=5><?php echo $this->_vars['megj']; ?>
</textarea>
		</td>
	</tr>
	<tr>
		</td>
		<td> 
		<td>
		<input type=submit value='Mehet' onClick="return G_isntEmpty('telszam','Telefonszám megadása kötelező!')&&G_isntEmpty('cegnev','Cégnév megadása kötelező!')&&G_isntEmpty('cim','Cím megadása kötelező!')">
		
		</td>
		
	</table>
	<?php if (( ! ( $this->_vars['admin'] ) && ( $this->_vars['nem'] ) )): ?>
		<input type=hidden name='cegnev' id='cegnev' value='<?php echo $this->_vars['cegnev']; ?>
'>	
		<input type=hidden name='cim' id='cim' value='<?php echo $this->_vars['cim']; ?>
'>
		<input type=hidden name='telszam' id='telszam' value='<?php echo $this->_vars['telszam']; ?>
'>		
	<?php endif; ?>
	
</form>

<script>
	document.getElementById('allapot').value='<?php echo $this->_vars['allapot']; ?>
';
</script>
<?php if (! ( $this->_vars['admin'] )): ?>
	<img src="images/page_left.gif" align="absmiddle"><a href = 'manager_cegeim.php'> Vissza </a>
<?php else: ?>
	<script>
		document.getElementById('uzletkid').value='<?php echo $this->_vars['uzletkid']; ?>
';
	</script>
	<img src="images/page_left.gif" align="absmiddle"><a href = 'manager_kereso.php'> Vissza </a>
<?php endif; ?>

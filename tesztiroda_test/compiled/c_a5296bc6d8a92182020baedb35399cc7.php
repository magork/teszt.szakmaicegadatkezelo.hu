<?php /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2011-01-16 13:01:20 CET */  if (( $this->_vars['admin'] )): ?>
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
	<tr >	
		<th width=80 >   </th>
		<th> 
			<?php if ($this->_vars['cid'] == 0): ?> 
				Új cég felvétele 
			<?php else: ?>
				<?php echo $this->_vars['cid']; ?>
-as azonosítójú cég szerkesztése
				<input type=hidden name='cid' id='cid' value='<?php echo $this->_vars['cid']; ?>
'>
				<input type=hidden name='pid' id='cid' value='<?php echo $this->_vars['pid']; ?>
'>
			<?php endif; ?>
		</th>
		
	</tr>
	<tr>
		<td >Cégnév:</td>
		<td ><input <?php if (( ! ( $this->_vars['admin'] ) && ( $this->_vars['nem'] ) )): ?> disabled  <?php endif; ?> type=text name=cegnev id=cegnev value = '<?php echo $this->_vars['cegnev']; ?>
' size=100></td>         
	</tr>	
	<tr>
		<td >Cim:</td>
		<td><input <?php if (( ! ( $this->_vars['admin'] ) && ( $this->_vars['nem'] ) )): ?> disabled  <?php endif; ?> type=text name=cim id=cim value = '<?php echo $this->_vars['cim']; ?>
' size=100></td>
	</tr>
	<tr>
		<td >Telefon:</td>
		<td ><input <?php if (( ! ( $this->_vars['admin'] ) && ( $this->_vars['nem'] ) )): ?> disabled  <?php endif; ?> type=text name=telszam id=telszam value = '<?php echo $this->_vars['telszam']; ?>
'></td>
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
		<?php if (( $this->_vars['admin'] )): ?>
		<th valign="top">
			Üzletkötő:
		</th>
		<?php endif; ?>			
	</tr>
	<?php if (count((array)$this->_vars['portalok'])): foreach ((array)$this->_vars['portalok'] as $this->_vars['k'] => $this->_vars['i']): ?>	
	<?php if (( $this->_vars['admin'] || $this->_vars['k'] == $this->_vars['pid'] || $this->_vars['event'] == 'add' )): ?>
	<tr>		
		<td valign="top">
			<?php if (( $this->_vars['admin'] || $this->_vars['event'] == 'add' )): ?>
				<input type="checkbox" id="portalok_<?php echo $this->_vars['k']; ?>
" name="portalok_<?php echo $this->_vars['k']; ?>
" value="1" <?php if (( $this->_run_modifier($this->_vars['k'], 'in_array', 'PHP', 1, $this->_vars['portal_ids']) )): ?>checked="checked"<?php endif; ?> />
			<?php endif; ?>
			&nbsp;<strong><?php echo $this->_vars['i']; ?>
</strong>
		</td>
		<td valign="top">
			<select name='allapot_<?php echo $this->_vars['k']; ?>
' <?php if (( ! $this->_vars['admin'] && ! $this->_vars['ceg_data'][$this->_vars['k']]['editable'] )): ?>readonly<?php endif; ?> >
				<option value=0 <?php if (( $this->_vars['ceg_data'][$this->_vars['k']]['allapot'] == 0 )): ?>selected="selected"<?php endif; ?>> Még nem hívott </option>
				<option value=2 <?php if (( $this->_vars['ceg_data'][$this->_vars['k']]['allapot'] == 2 )): ?>selected="selected"<?php endif; ?>> Visszahívni </option>
				<?php if (( $this->_vars['admin'] )): ?>
					<option value=4 <?php if (( $this->_vars['ceg_data'][$this->_vars['k']]['allapot'] == 4 )): ?>selected="selected"<?php endif; ?> > Sztornó </option>
					<option value=5 <?php if (( $this->_vars['ceg_data'][$this->_vars['k']]['allapot'] == 5 )): ?>selected="selected"<?php endif; ?> > Regisztrált </option>
					<option value=6 <?php if (( $this->_vars['ceg_data'][$this->_vars['k']]['allapot'] == 6 )): ?>selected="selected"<?php endif; ?> > Regisztráció alatt </option>
					<option value=7 <?php if (( $this->_vars['ceg_data'][$this->_vars['k']]['allapot'] == 7 )): ?>selected="selected"<?php endif; ?> > Ajánlat küldve </option>		
				<?php endif; ?>			
			</select>
			<br/>
			<?php echo $this->_vars['ceg_data'][$this->_vars['k']]['adstatdat']; ?>

		</td>
		<td valign="top">
			<textarea name="megj_<?php echo $this->_vars['k']; ?>
" cols=32 rows=5><?php echo $this->_vars['ceg_data'][$this->_vars['k']]['megj']; ?>
</textarea>
		</td>		
		<?php if (( $this->_vars['admin'] )): ?>			
		<td valign="top">
			<?php if (( $this->_vars['admin'] ) && ( $this->_vars['cid'] != 0 )): ?>
				<select name='uzletkid_<?php echo $this->_vars['k']; ?>
' style="width:200px;">
					<option value=0> Senki </option>
					<?php if (count((array)$this->_vars['userek'])): foreach ((array)$this->_vars['userek'] as $this->_vars['i']): ?>
						<option value='<?php echo $this->_vars['i']['id']; ?>
' <?php if (( $this->_vars['ceg_data'][$this->_vars['k']]['uzletkid'] == $this->_vars['i']['id'] )): ?>selected="selected"<?php endif; ?> ><?php echo $this->_vars['i']['usname']; ?>
</option>
					<?php endforeach; endif; ?>
				</select>
			<?php endif; ?>
		</td>     	
		<?php endif; ?>		
	</tr>
	<?php endif; ?>
	<?php endforeach; endif; ?>
	<tr>
		<td colspan="2">
			
		</td>
		
		<td colspan="2">
		<input type=submit value='Mehet' name='save_ceg' onClick="return G_isntEmpty('telszam','Telefonszám megadása kötelező!')&&G_isntEmpty('cegnev','Cégnév megadása kötelező!')&&G_isntEmpty('cim','Cím megadása kötelező!')">
		
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


<?php if (! ( $this->_vars['admin'] )): ?>
	<img src="images/page_left.gif" align="absmiddle"><a href = 'manager_cegeim.php'> Vissza </a>
<?php else: ?>
	<img src="images/page_left.gif" align="absmiddle"><a href = 'manager_kereso.php'> Vissza </a>
<?php endif; ?>

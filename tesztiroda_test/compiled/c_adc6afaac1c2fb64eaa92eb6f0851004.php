<?php /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2011-01-16 13:01:14 CET */ ?><h2>Üzletkötők menüpontja (Munkakosár)</h2>
<br>
<?php if (( $this->_vars['lehet'] )): ?>	<img src="images/action_go.gif" align="absmiddle"><a href='manager_cedit.php' style='font-weight: bold'> Új Cég hozzáadása </a>
<?php else: ?>
	Jelenleg nincs lehetősége több cég felvitelére.
<?php endif; ?>
<br><br>
<form id=szuro name=szuro method=POST action='manager_cegeim.php'>
Szűrés: <br/>
	Cégnév:
	<input name="szurnev" value="<?php echo $this->_vars['szurnev']; ?>
" />
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
   document.getElementById('szur').value='<?php echo $this->_vars['szuro']; ?>
';
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

	<?php if (count((array)$this->_vars['db'])): foreach ((array)$this->_vars['db'] as $this->_vars['d']): ?>
		<tr id="list<?php echo $this->_vars['d']['usid']; ?>
" style="border-top:solid 2px #888 !important;">
			<td <?php if (( $this->_run_modifier($this->_vars['d']['portal'], 'count', 'PHP', 0) > 1 )): ?>valign="bottom"<?php endif; ?>><?php echo $this->_vars['d']['cid']; ?>
</td>
        	<td height=60 align="center" <?php if (( $this->_run_modifier($this->_vars['d']['portal'], 'count', 'PHP', 0) > 1 )): ?>valign="bottom"<?php endif; ?> ><?php echo $this->_vars['d']['cegnev']; ?>
</td>
        	<td> 					
					<strong><?php echo $this->_vars['d']['portal'][0]['name']; ?>
</strong><br/>
					<?php echo $this->_vars['d']['portal'][0]['date']; ?>
					
			</td>
        	<td> <?php echo $this->_vars['d']['cim']; ?>
 </td>
			<td> <?php echo $this->_vars['d']['telszam']; ?>
 </td>
			<td> 
				<?php echo $this->_vars['d']['portal'][0]['allapot']; ?>
<br/>
				<?php echo $this->_vars['d']['portal'][0]['adstatdat']; ?>

			</td>
			<td> <?php echo $this->_vars['d']['moddat']; ?>
 </td>       
			<td><strong>[<?php echo $this->_vars['d']['portal'][0]['name']; ?>
]</strong><br/> <?php echo $this->_vars['d']['portal'][0]['megj']; ?>
  <br></td>
			<td>	
				<?php if (( $this->_run_modifier($this->_vars['d']['not_editable'], 'count', 'PHP', 0) < $this->_run_modifier($this->_vars['d']['p_connects'], 'count', 'PHP', 0) )): ?>
					<?php if (( $this->_run_modifier($this->_vars['d']['not_torl'], 'count', 'PHP', 0) < $this->_run_modifier($this->_vars['d']['p_connects'], 'count', 'PHP', 0) )): ?>
			        	<a href="javascript:void(0)" class="cegeim_torl"  alt='<?php echo $this->_run_modifier($this->_vars['d']['not_torl'], 'json_encode', 'PHP', 0); ?>
' value="<?php echo $this->_vars['d']['cid']; ?>
" rel='<?php echo $this->_run_modifier($this->_vars['d']['p_connects'], 'json_encode', 'PHP', 0); ?>
' ><img src="images/icons/delete.png" align="absmiddle">Törlés végleg</a> <br>
					<?php endif; ?> 
					<?php if (( $this->_run_modifier($this->_vars['d']['not_torl1'], 'count', 'PHP', 0) < $this->_run_modifier($this->_vars['d']['p_connects'], 'count', 'PHP', 0) )): ?>
				        <a href="javascript:void(0)" class="cegeim_torl1"  alt='<?php echo $this->_run_modifier($this->_vars['d']['not_torl1'], 'json_encode', 'PHP', 0); ?>
' value="<?php echo $this->_vars['d']['cid']; ?>
" rel='<?php echo $this->_run_modifier($this->_vars['d']['p_connects'], 'json_encode', 'PHP', 0); ?>
' ><img src="images/icons/delete.png" align="absmiddle">Törlés a munkakosárból</a> <br>
					<?php endif; ?>
					<a href=javascript:void(0)" class="cegeim_edit" alt='<?php echo $this->_run_modifier($this->_vars['d']['not_editable'], 'json_encode', 'PHP', 0); ?>
' value="<?php echo $this->_vars['d']['cid']; ?>
" rel='<?php echo $this->_run_modifier($this->_vars['d']['p_connects'], 'json_encode', 'PHP', 0); ?>
'><img src="images/icons/edit.png" align="absmiddle">Szerkeszt</a>
				<?php else: ?>  

					Nem szerkeszthető

				<?php endif; ?>
	        	</td>
			</tr> 	        	

			<?php if (count((array)$this->_vars['d']['portal'])): foreach ((array)$this->_vars['d']['portal'] as $this->_vars['kk'] => $this->_vars['ii']): ?>
			<?php if (( $this->_vars['kk'] > 0 )): ?> 
			<tr> 				
				<td> </td>		        		       
				<td> </td>
				<td>
					<strong><?php echo $this->_vars['ii']['name']; ?>
</strong><br/>
						<?php echo $this->_vars['ii']['date']; ?>
				
				</td>
				<td> </td>
				<td> </td>
				<td>
					<?php echo $this->_vars['ii']['allapot']; ?>
<br/>
					<?php echo $this->_vars['ii']['adstatdat']; ?>

				</td>
				<td> </td>
				<td><strong>[<?php echo $this->_vars['ii']['name']; ?>
]</strong><br/> <?php echo $this->_vars['ii']['megj']; ?>
</td>
				<td> </td>
			</tr>
			<?php endif; ?>
			<?php endforeach; endif; ?>
		<?php endforeach; endif; ?>

</table>
<script>
  var portalok = <?php echo $this->_run_modifier($this->_vars['portal_list'], 'json_encode', 'PHP', 0); ?>
;
  $(function(){
  		create_portal_dialog('torl1','.cegeim_torl1','manager_cegeim.php?event=del1','Cég Törlése a Munkakosárból','Válassza ki melyik melyik portálon szeretné eltávolítani a munkakosarából!');
  		create_portal_dialog('torl','.cegeim_torl','manager_cegeim.php?event=del','Cég Végleges Törlése a Portálról','Válassza ki melyik melyik portálon szeretné véglegesen törölni a céget!');
  		create_portal_dialog('edit','.cegeim_edit','manager_cedit.php','Cég Szerkesztése','Válassza ki melyik melyik portálon szeretné szerkeszteni a céget!',true);
  });
</script>
<p align="center">
	<?php if ($this->_vars['pager']): ?>
		<?php if ($this->_vars['pager']['prevenabled']): ?>
				<a href="manager_cegeim.php?tol=<?php echo $this->_vars['pager']['prev']; ?>
">Előző</a>
		<?php endif; ?>
		
		<?php if (count((array)$this->_vars['pager']['tolok'])): foreach ((array)$this->_vars['pager']['tolok'] as $this->_vars['tol']): ?> 
		
				<?php if ($this->_vars['tol']['selected']): ?>
					<span><?php echo $this->_vars['tol']['szam']; ?>
</span>
				<?php else: ?>
					<a href="manager_cegeim.php?tol=<?php echo $this->_vars['tol']['tol']; ?>
"><strong><?php echo $this->_vars['tol']['szam']; ?>
</strong></a>
				<?php endif; ?>
				
		<?php endforeach; endif; ?>
		
		<?php if ($this->_vars['pager']['nextenabled']): ?>
					<a href="manager_cegeim.php?tol=<?php echo $this->_vars['pager']['next']; ?>
">Következő</a>
		<?php endif; ?>
	<?php endif; ?>
</p>
	

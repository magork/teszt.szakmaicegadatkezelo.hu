<?php /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2011-03-21 02:23:14 CET */ ?><h2>Keresés cégek között</h2>
<form id=kereso name=kereso method=POST action='manager_kereso.php'>

<table> 
	<tr>
		<th width=80> </th>
		<th <?php if (( $this->_vars['admin'] )): ?>colspan="2"<?php endif; ?> > Keresési feltételek </th>
	</tr>	
	<tr>
	<?php if (( $this->_vars['admin'] )): ?>
		<td > Üzletkötő neve: </td>
		<td> <input type=text id='usname' name='usname' value='<?php echo $this->_vars['k_usname']; ?>
' size=70> </td>
		<td rowspan="7">
			<?php if (count((array)$this->_vars['portalok'])): foreach ((array)$this->_vars['portalok'] as $this->_vars['k'] => $this->_vars['i']): ?>
				<input type="checkbox" id="portalok_<?php echo $this->_vars['k']; ?>
" name="portalok_<?php echo $this->_vars['k']; ?>
" value="1" <?php if (( $this->_run_modifier($this->_vars['k'], 'in_array', 'PHP', 1, $this->_vars['portal_ids']) )): ?>checked="checked"<?php endif; ?> />
				&nbsp;
				<?php echo $this->_vars['i']; ?>

				<br/>
			<?php endforeach; endif; ?>
		</td>
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
		<td> <input type=submit value='Keres' name='kereses_esemeny' onClick="return G_isNum('cid','Cégazonosító csak szám lehet!')"> </td>
	</tr>
</table>

</form>

<script>
   if(document.getElementById('szur'))document.getElementById('szur').value='<?php echo $this->_vars['szuro']; ?>
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
	
			<th width="150">Portál</th>

		<th>Üzletkötő</th>
		<th>Cím</th>
		<th>Telefon</th>
		<th width="300" >Állapot</th>	
		<th style="width:15%">Megjegyzés</th>
		<th style="width: 100px">Műveletek</th>
	</tr>

	<?php if (count((array)$this->_vars['db'])): foreach ((array)$this->_vars['db'] as $this->_vars['d']): ?>
		<tr id="list<?php echo $this->_vars['d']['cid']; ?>
" style="border-top:solid 2px #888 !important;">
			<td <?php if (( $this->_run_modifier($this->_vars['d']['portal'], 'count', 'PHP', 0) > 1 )): ?>valign="bottom"<?php endif; ?>  > <?php echo $this->_vars['d']['cid']; ?>
</td>
        	<td <?php if (( $this->_run_modifier($this->_vars['d']['portal'], 'count', 'PHP', 0) > 1 )): ?>valign="bottom"<?php endif; ?> height=60 align="center"><?php echo $this->_vars['d']['cegnev']; ?>
</td>	     
			<td> 
				
					<strong><?php echo $this->_vars['d']['portal'][0]['name']; ?>
</strong><br/> <i><?php echo $this->_vars['d']['portal'][0]['date']; ?>
</i> <br>
				
			</td>		
        	<td> 
        		<a href='mailto:<?php echo $this->_vars['d']['portal'][0]['usemail']; ?>
'><?php echo $this->_vars['d']['portal'][0]['usname']; ?>
</a> 
        	</td>
        	<td <?php if (( $this->_run_modifier($this->_vars['d']['portal'], 'count', 'PHP', 0) > 1 )): ?>valign="bottom"<?php endif; ?>> <?php echo $this->_vars['d']['cim']; ?>
 </td>
			<td <?php if (( $this->_run_modifier($this->_vars['d']['portal'], 'count', 'PHP', 0) > 1 )): ?>valign="bottom"<?php endif; ?>> <?php echo $this->_vars['d']['tel']; ?>
</td>
			<td> 		
				
					<?php echo $this->_vars['d']['portal'][0]['allapot']; ?>
 [ <i><?php echo $this->_vars['d']['portal'][0]['name']; ?>
</i> ] <br/><i><?php echo $this->_vars['d']['portal'][0]['adstatdat']; ?>
</i>  <br>
				
		 	</td>
		             	        	
	        <td>  
	        	
	        		<strong>[<?php echo $this->_vars['d']['portal'][0]['name']; ?>
]</strong><br/> <?php echo $this->_vars['d']['portal'][0]['megj']; ?>
  <br>
	        	
	        </td>        	
	        <td <?php if (( $this->_run_modifier($this->_vars['d']['portal'], 'count', 'PHP', 0) > 1 )): ?>valign="bottom"<?php endif; ?>>	
<!--
Kovge kód
			<?php if (( ( $this->_run_modifier($this->_vars['d']['not_editable'], 'count', 'PHP', 0) < $this->_run_modifier($this->_vars['portalok'], 'count', 'PHP', 0) ) && ( ! $this->_vars['admin'] ) )): ?>
			<?php endif; ?>
-->
			<?php if (( ( $this->_vars['d']['portal'][0]['allapot'] == '<b>Sztornó</b>' ) && ( ! $this->_vars['admin'] ) )): ?>
				<img src="images/pick.gif" align="absmiddle"><a href='javascript:void()' style="font-weight: bold" class="felvesz_link" alt='<?php echo $this->_run_modifier($this->_vars['d']['not_editable'], 'json_encode', 'PHP', 0); ?>
' value="<?php echo $this->_vars['d']['cid']; ?>
" >Felvesz</a>
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
		<?php if (count((array)$this->_vars['d']['portal'])): foreach ((array)$this->_vars['d']['portal'] as $this->_vars['kk'] => $this->_vars['ii']): ?>
			<?php if (( $this->_vars['kk'] != 0 )): ?>					
			<tr> 
				
				<td> </td>
				<td> </td>
				<td>
					<strong><?php echo $this->_vars['ii']['name']; ?>
</strong><br/> <i><?php echo $this->_vars['ii']['date']; ?>
</i> 			
				</td>
				<td>
					<a href='mailto:<?php echo $this->_vars['ii']['usemail']; ?>
'><?php echo $this->_vars['ii']['usname']; ?>
</a>  			
				</td>
				<td> </td>
				<td> </td>
				<td>
					<?php echo $this->_vars['ii']['allapot']; ?>
 [ <i><?php echo $this->_vars['ii']['name']; ?>
</i> ] <br/><i><?php echo $this->_vars['ii']['adstatdat']; ?>
</i> 
				</td>
				<td>
					<strong>[<?php echo $this->_vars['ii']['name']; ?>
]</strong><br/> <?php echo $this->_vars['ii']['megj']; ?>

				</td>
				<td> </td>
			</tr>
			<?php endif; ?>
		<?php endforeach; endif; ?>
	<?php endforeach; endif; ?>

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
  var portalok = <?php echo $this->_run_modifier($this->_vars['portalok'], 'json_encode', 'PHP', 0); ?>
;
  $(function(){
  		create_portal_dialog('felvesz','.felvesz_link','manager_cegeim.php?event=felvesz','Cég felvétele','Válassza ki melyik melyik portálon szeretné felvenni a céget!');
  });
</script>
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

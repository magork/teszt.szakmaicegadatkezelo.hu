<?php /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2010-08-24 13:51:40 CEST */ ?><h2>Üzletkötők menüpontja (Munkakosár)</h2>
<br>
<?php if (( $this->_vars['lehet'] )): ?>	<img src="images/action_go.gif" align="absmiddle"><a href='manager_cedit.php' style='font-weight: bold'> Új Cég hozzáadása </a>
<?php else: ?>
	Jelenleg nincs lehetősége több cég felvitelére.
<?php endif; ?>
<br><br>
<form id=szuro name=szuro method=POST action='manager_cegeim.php'>
Szűrés: 
	<select name=szur id=szur>
		<option value=-1> Nincs szűrés </option>
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
		<th>Cím</th>
		<th>Telefonszám</th>
		<th>Állapot</th>
		<th>Felvitel napja</th>
		<th>Utolsó módosítás napja</th>
		<th>Megjegyzés</th>
		<th style="width: 150px">Műveletek</th>
	</tr>

	<?php if (count((array)$this->_vars['db'])): foreach ((array)$this->_vars['db'] as $this->_vars['d']): ?>
		<tr id="list<?php echo $this->_vars['d']['usid']; ?>
">
			<td><?php echo $this->_vars['d']['cid']; ?>
</td>
	        	<td height=60 align="center"><?php echo $this->_vars['d']['cegnev']; ?>
</td>
	        	<td> <?php echo $this->_vars['d']['cim']; ?>
 </td>
			<td> <?php echo $this->_vars['d']['telszam']; ?>
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
				<?php if (( $this->_vars['d']['editable'] )): ?>
					<?php if (( $this->_vars['d']['torl'] )): ?>
			        		<a href="?event=del&cid=<?php echo $this->_vars['d']['cid']; ?>
" onClick="return confirm('Tényleg törljem az adatbázisból?')"><img src="images/icons/delete.png" align="absmiddle">Törlés végleg</a> <br>
					<?php endif; ?> 
					<?php if (( $this->_vars['d']['torl1'] )): ?>
				        <a href="?event=del1&cid=<?php echo $this->_vars['d']['cid']; ?>
" onClick="return confirm('Tényleg törljem a munkakosárból?')"><img src="images/icons/delete.png" align="absmiddle">Törlés a munkakosárból</a> <br>
					<?php endif; ?>
					<a href="manager_cedit.php?id=<?php echo $this->_vars['d']['cid']; ?>
" class="edit"><img src="images/icons/edit.png" align="absmiddle">Szerkeszt</a>
				<?php else: ?>  

					Nem szerkeszthető

				<?php endif; ?>
	        	</td>
		</tr>
	<?php endforeach; endif; ?>

</table>

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
	

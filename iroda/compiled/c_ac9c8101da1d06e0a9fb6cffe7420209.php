<?php /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2011-05-24 13:04:58 CEST */ ?><h2>Statisztikák</h2>


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
	<input type=text id='regdatK' name='regdatK' value='<?php echo $this->_vars['k_regk']; ?>
'> és <input type=text id='regdatV' name='regdatV' value='<?php echo $this->_vars['k_regv']; ?>
'>között van
	<br>(dátum alakja: éééé-hh-nn / pl: 2007-01-01)<br>

	<input type=submit value='Mehet'>
</form>
<script>
   document.getElementById('mire').value='<?php echo $this->_vars['mire']; ?>
';
</script>
<br>
<h3> Eredmények </h3>


<hr width=80%>


	<?php if (count((array)$this->_vars['db'])): foreach ((array)$this->_vars['db'] as $this->_vars['d']): ?>
		<table id="test">
			<tr>
				<th style='width:60px'>Darabszám</th>
				<th>Usernév</th>
			</tr>
			<tr>
				<td> <?php echo $this->_vars['d']['db']; ?>
 </td>
		      		<td> <b><a href='mailto:<?php echo $this->_vars['d']['usemail']; ?>
'><?php echo $this->_vars['d']['usname']; ?>
</a></b> <br> </td>
			</tr>
		</table>
		<table id='cg'>
		<tr>	
			<th>ID</th>
			<th>Cégnév</th>
			<th>Cím</th>
			<th>Telefonszám</th>
			<th>Felvitel napja</th>
			<th>Státuszba helyezés dátuma</th>
			<th>Utolsó módosítás napja</th>
			<th>Megjegyzés</th>
		</tr>
		<?php if (count((array)$this->_vars['d']['cegek'])): foreach ((array)$this->_vars['d']['cegek'] as $this->_vars['j']): ?>
			<tr>
				<td><?php echo $this->_vars['j']['cid']; ?>
</td>
	        		<td height=60 align="center"><?php echo $this->_vars['j']['cegnev']; ?>
</td>
	        		<td> <?php echo $this->_vars['j']['cim']; ?>
 </td>
				<td> <?php echo $this->_vars['j']['telszam']; ?>
 </td>
		        	<td> <?php echo $this->_vars['j']['felvdat']; ?>
 </td>
				<td> <?php echo $this->_vars['j']['adstatdat']; ?>
</td>
		        	<td> <?php echo $this->_vars['j']['moddat']; ?>
 </td>        	        	
		        	<td> <?php echo $this->_vars['j']['megj']; ?>
 </td>        	
		        	
			</tr>
		<?php endforeach; endif; ?>		</table>
		<hr width=80%>	
	<?php endforeach; endif; ?>



<p align="center">
	<?php if ($this->_vars['pager']): ?>
		<?php if ($this->_vars['pager']['prevenabled']): ?>
				<a href="manager_stat.php?tol=<?php echo $this->_vars['pager']['prev']; ?>
">Előző</a>
		<?php endif; ?>
		
		<?php if (count((array)$this->_vars['pager']['tolok'])): foreach ((array)$this->_vars['pager']['tolok'] as $this->_vars['tol']): ?> 
		
				<?php if ($this->_vars['tol']['selected']): ?>
					<span><?php echo $this->_vars['tol']['szam']; ?>
</span>
				<?php else: ?>
					<a href="manager_stat.php?tol=<?php echo $this->_vars['tol']['tol']; ?>
"><strong><?php echo $this->_vars['tol']['szam']; ?>
</strong></a>
				<?php endif; ?>
				
		<?php endforeach; endif; ?>
		
		<?php if ($this->_vars['pager']['nextenabled']): ?>
					<a href="manager_stat.php?tol=<?php echo $this->_vars['pager']['next']; ?>
">Következő</a>
		<?php endif; ?>
	<?php endif; ?>
</p>
	

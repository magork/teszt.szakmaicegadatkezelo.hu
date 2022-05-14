<?php /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2011-01-16 13:00:32 CET */ ?><h2>Üzletkötők szerkesztése</h2>
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

	<?php if (count((array)$this->_vars['db'])): foreach ((array)$this->_vars['db'] as $this->_vars['d']): ?>
		<tr id="list<?php echo $this->_vars['d']['id']; ?>
">
	        	<td align="center"><?php echo $this->_vars['d']['usid']; ?>
</td>
	        	<td> <?php echo $this->_vars['d']['usemail']; ?>
</td>
		        <td><?php echo $this->_vars['d']['usname']; ?>
</td>
			<td><?php echo $this->_vars['d']['uspass']; ?>
</td>
		        <td><?php echo $this->_vars['d']['uslim']; ?>
</td>        	
		        <td>
	        		<a href="?event=del&id=<?php echo $this->_vars['d']['usid']; ?>
" onClick="return confirm('Tényleg törljem?')"><img src="images/icons/delete.png" align="absmiddle">Törlés</a> <br>
				<a href="manager_uedit.php?id=<?php echo $this->_vars['d']['usid']; ?>
" class="edit"><img src="images/icons/edit.png" align="absmiddle">Szerkeszt</a>
	        	</td>
		</tr>
	<?php endforeach; endif; ?>

</table>

<p align="center">
	<?php if ($this->_vars['pager']): ?>
		<?php if ($this->_vars['pager']['prevenabled']): ?>
				<a href="manager_user.php?tol=<?php echo $this->_vars['pager']['prev']; ?>
">Előző</a>
		<?php endif; ?>
		
		<?php if (count((array)$this->_vars['pager']['tolok'])): foreach ((array)$this->_vars['pager']['tolok'] as $this->_vars['tol']): ?> 
		
				<?php if ($this->_vars['tol']['selected']): ?>
					<span><?php echo $this->_vars['tol']['szam']; ?>
</span>
				<?php else: ?>
					<a href="manager_user.php?tol=<?php echo $this->_vars['tol']['tol']; ?>
"><strong><?php echo $this->_vars['tol']['szam']; ?>
</strong></a>
				<?php endif; ?>
				
		<?php endforeach; endif; ?>
		
		<?php if ($this->_vars['pager']['nextenabled']): ?>
					<a href="manager_user.php?tol=<?php echo $this->_vars['pager']['next']; ?>
">Következő</a>
		<?php endif; ?>
	<?php endif; ?>
</p>
	

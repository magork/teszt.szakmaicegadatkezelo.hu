<?php /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2011-03-08 10:11:30 CET */ ?><h2>Üzletkötők szerkesztése</h2>


<form id='new' name='new' method = POST action='manager_user.php?event=<?php echo $this->_vars['event']; ?>
'>
	<table>
	<tr >	<th width=80>   </th>
		<th > 
			<?php if ($this->_vars['usid'] == 0): ?> 
				Új üzletkötő felvétele 
			<?php else: ?>
				<?php echo $this->_vars['usid']; ?>
-as azonosítójú üzletkötő szerkesztése
				<input type=hidden name='usid' is='usid' value='<?php echo $this->_vars['usid']; ?>
'>
			<?php endif; ?>
		</th>
		
	</tr>
	<tr>
		<td>Usernév:</td>
		<td><input type=text name=usname id=usname value = '<?php echo $this->_vars['usname']; ?>
'></td>
	</tr>
	<tr>
		<td>Email:</td>
		<td><input type=text name=usemail id=usemail value = '<?php if (! $this->_vars['usemail']): ?>dolgozo@uzleticegtudakozo.hu<?php else:  echo $this->_vars['usemail'];  endif; ?>'></td>
	</tr>
	<tr>
		<td>Jelszó:</td>
		<td><input type=password name=uspass id=uspass value ='<?php echo $this->_vars['uspass']; ?>
'></td>
	</tr>
	<tr>
		<td>Limit:</td>
		<td><input type=text name=uslim id=uslim value = '<?php echo $this->_vars['uslim']; ?>
'></td>
	</tr>
	<tr>
		</td>
		<td> 
		<td>
		<input type=submit value='Mehet' onClick="return G_isntEmpty('usname','Usernév megadása kötelező!')&&G_isntEmpty('usemail','Email megadása kötelező!')&&G_reqLen('uspass',5,'Jelszó minimum 5 karakter legyen!')&&G_isntEmpty('uslim','Limit megadása kötelező!')&&G_isNum('uslim','A Limitnek számnak kell lennie')">
		
		</td>
		
	</table>
</form>

<img src="images/page_left.gif" align="absmiddle"><a href = 'manager_user.php'> Vissza </a>

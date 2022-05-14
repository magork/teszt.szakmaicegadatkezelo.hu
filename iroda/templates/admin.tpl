<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta http-equiv="content-language" content="hu" />
 		<meta name="robots" content="all" />
 		<meta name="robots" content="noarchive" />
 		<meta name="revisit-after" content="1 day" />
 		<meta name="keywords" content="" />
		<meta name="description" content="" />
		
		<title>Magyar üzleti tudakozó - Intranet</title>

		{if $richEditor }<script type="text/javascript" src="js/fckeditor/fckeditor.js"></script>{/if}

		<link rel="stylesheet" href="css/admin_style.css" type="text/css">
		{if $niceTable}<link rel="stylesheet" href="css/tablecloth.css" type="text/css" media="screen" />{/if}
		<link rel="stylesheet" href="css/dhtmlXTree.css" type="text/css" >	
		<link rel="stylesheet" href="css/lytebox.css" type="text/css" >	
		
		<script type="text/javascript" src="js/common.js"></script>
		<script type="text/javascript" src="js/gergo.js"></script>
		<script type="text/javascript" src="js/mootools.js"></script>
		<script type="text/javascript" src="js/lytebox.js"></script>
		<script type="text/javascript" src="js/gen_validatorv2.js"></script>
		<script type="text/javascript" src="js/dhtmlXCommon.js"></script>
		<script type="text/javascript" src="js/dhtmlXTree.js"></script>	
		{if $niceTable}<script type="text/javascript" src="js/tablecloth.js"></script>{/if}
	</head>
	
	<body{if $autoload} onload="{ $autoload }"{/if}>

	<div class="header">
		<img src="images/skycms.png">
{if $auth == true}

		<div id="tabs">
		  <ul>	{if $admin == true}
				<li><a href="manager_stat.php" title="Statisztikák"><span>Statisztika</span></a></li>
			{/if}
				<li><a href="manager_kereso.php" title="Kereshet cégek között"><span>Céglista/Kereső</span></a></li>
			{if $admin == true}
				<li><a href="manager_cedit.php" title="Új cég hozzáadása a céglistához"><span>Cég felvitele</span></a></li>					
				<li><a href="manager_user.php" title="Üzletkötők adminisztrálása"><span>Üzletkötők szerkesztése</span></a></li>				
			{else}
				<li><a href="manager_cegeim.php" title="Cégek felvitele szerkesztése"><span>Üzletkötők menüpontja</span></a></li>				
			{/if}
			<li><a href="manager_logout.php" title="Kilépés"><span>Kijelentkezés</span></a></li>
		  </ul>
		</div>
{/if}
	</div>

{if $auth == true}

		<div id="content">
				<!-- tartalom -->
		</div>	

{else}

<br>
<br>
<br>
<br>

	<form action="manager_login.php" method="post">

	<table>
	  <tr>
		<td>Felhasználó:</td>
		<td><input type="text" name="user"></td>
	  </tr>

	  <tr>
		<td>Pass:</td>
		<td><input type="password" name="pass"></td>
	  </tr>

	  <tr>
		<td></td>
		<td><input type="submit" name="eee" value="Bejelentkezés"></td>
	  </tr>

	</form>
{/if}
	</body>
</html>

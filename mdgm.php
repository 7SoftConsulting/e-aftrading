<?php
	
	include dirname(__FILE__)."/lib/Application.class.php" ;
	
	$clt = new ClientMdgm() ;
	
	
	echo "<pre>" ;
	
	$clt->Connecte() ;
	$not = $clt->Notation(1390634) ;
	print_r($not) ;
	echo "</pre>" ;
	
?>
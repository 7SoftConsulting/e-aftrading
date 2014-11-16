<?php
	
	if(! defined('FOURN_EXPRS_TRAD_PLATF'))
	{
		define('FOURN_EXPRS_TRAD_PLATF', 1) ;
		
		class FournExprsPublTradPlatf extends PvObjet
		{
			public $LibLienDemarrNegoc = "N&eacute;gocier" ;
			public $TitrFenDemarrNegoc = "N&eacute;gocier operation de change" ;
			public $LibLienAjustNegoc = "N&eacute;gocier" ;
			public $TitrFenAjustNegoc = "N&eacute;gocier operation de change" ;
			public $LibLienConfirmNegoc = "Confirmer" ;
			public $TitrFenDemarrNegocAchatDevise = "N&eacute;gocier achat de devise" ;
			public $TitrFenDemarrNegocVenteDevise = "N&eacute;gocier vente de devise" ;
			public $MsgInteretAchatDevise = 'Voulez-vous confirmer votre int&eacute;r&ecirc;t pour cet achat de devise ?' ;
			public $MsgInteretVenteDevise = 'Voulez-vous confirmer votre int&eacute;r&ecirc;t pour cette vente de devise ?' ;
			public $TitrFenDemarrNegocPlacement = "N&eacute;gocier achat de devise" ;
			public $TitrFenDemarrNegocEmprunt = "N&eacute;gocier vente de devise" ;
			public $MsgInteretPlacement = 'Voulez-vous confirmer votre int&eacute;r&ecirc;t pour ce placement ?' ;
			public $MsgInteretEmprunt = 'Voulez-vous confirmer votre int&eacute;r&ecirc;t pour cet emprunt ?' ;
		}
	}
	
?>
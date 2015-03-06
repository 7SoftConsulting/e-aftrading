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
			public $LibLienDemarrNegocOpInter = "N&eacute;gocier" ;
			public $TitrFenDemarrNegocOpInter = "N&eacute;gocier operation Inter" ;
			public $LibLienAjustNegocOpInter = "N&eacute;gocier" ;
			public $TitrFenAjustNegocOpInter = "N&eacute;gocier operation Inter" ;
			public $LibLienConfirmNegoc = "Confirmer" ;
			public $TitrFenDemarrNegocAchatDevise = "N&eacute;gocier achat de devise" ;
			public $TitrFenDemarrNegocVenteDevise = "N&eacute;gocier vente de devise" ;
			public $MsgInteretAchatDevise = 'Voulez-vous confirmer votre int&eacute;r&ecirc;t pour cet achat de devise ?' ;
			public $MsgInteretVenteDevise = 'Voulez-vous confirmer votre int&eacute;r&ecirc;t pour cette vente de devise ?' ;
			public $TitrFenDemarrNegocPlacement = "N&eacute;gocier achat de devise" ;
			public $TitrFenDemarrNegocEmprunt = "N&eacute;gocier vente de devise" ;
			public $MsgInteretPlacement = 'Voulez-vous confirmer votre int&eacute;r&ecirc;t pour ce placement ?' ;
			public $MsgInteretEmprunt = 'Voulez-vous confirmer votre int&eacute;r&ecirc;t pour cet emprunt ?' ;
			public $TitrFenPublierEmissBonTresor = 'Publication &eacute;mission bon de tr&eacute;sor' ;
			public $TitrFenConsultEmissBonTresor = 'Consultation &eacute;mission bon de tr&eacute;sor' ;
			public $TitrFenProposEmissBonTresor = 'Propositions &eacute;mission bon de tr&eacute;sor' ;
			public $TitrFenDetailProposEmissBonTresor = 'D&eacute;tails  proposition &eacute;mission bon de tr&eacute;sor' ;
			public $TitrFenAjoutEmissBonTresor = 'Ajout &eacute;mission bon de tr&eacute;sor' ;
			public $TitrFenModifEmissBonTresor = 'Modification &eacute;mission bon de tr&eacute;sor' ;
			public $TitrFenSupprEmissBonTresor = 'Suppression &eacute;mission bon de tr&eacute;sor' ;
			public $TitrFenListReservEmissBonTresor = 'Liste des r&eacute;servations &eacute;mission bon de tr&eacute;sor' ;
			public $TitrFenAjoutReservEmissBonTresor = 'R&eacute;server &eacute;mission bon de tr&eacute;sor' ;
			public $TitrFenModifReservEmissBonTresor = 'Modifier r&eacute;serv . &eacute;mission bon de tr&eacute;sor' ;
			public $TitrFenSupprReservEmissBonTresor = 'Supprimer r&eacute;serv. &eacute;mission bon de tr&eacute;sor' ;
			public $TitrFenPublierEmissObligation = 'Publication &eacute;mission obligation' ;
			public $TitrFenConsultEmissObligation = 'Consultation &eacute;mission obligation' ;
			public $TitrFenProposEmissObligation = 'Propositions &eacute;mission obligation' ;
			public $TitrFenDetailProposEmissObligation = 'D&eacute;tails  proposition &eacute;mission obligation' ;
			public $TitrFenAjoutEmissObligation = 'Ajout &eacute;mission obligation' ;
			public $TitrFenModifEmissObligation = 'Modification &eacute;mission obligation' ;
			public $TitrFenSupprEmissObligation = 'Suppression &eacute;mission obligation' ;
			public $TitrFenListReservEmissObligation = 'Liste des r&eacute;servations &eacute;mission obligation' ;
			public $TitrFenAjoutReservEmissObligation = 'R&eacute;server &eacute;mission obligation' ;
			public $TitrFenModifReservEmissObligation = 'Modifier r&eacute;serv . &eacute;mission obligation' ;
			public $TitrFenSupprReservEmissObligation = 'Supprimer r&eacute;serv. &eacute;mission obligation' ;
			public $TitrFenPublierCotationTransfDev = 'Publication cotations de transfert devise' ;
			public $TitrFenConsultCotationTransfDev = 'Consultation cotations de transfert devise' ;
			public $TitrFenProposCotationTransfDev = 'Propositions cotations de transfert devise' ;
			public $TitrFenDetailProposCotationTransfDev = 'D&eacute;tails proposition cotations de transfert devise' ;
			public $TitrFenAjoutCotationTransfDev = 'Ajout cotation de transfert devise' ;
			public $TitrFenModifCotationTransfDev = 'Modification cotation de transfert devise' ;
			public $TitrFenSupprCotationTransfDev = 'Suppression cotation de transfert devise' ;
			public $TitrFenListReservCotationTransfDev = 'Liste des r&eacute;servations cotation de transfert devise' ;
			public $TitrFenAjoutReservCotationTransfDev = 'R&eacute;server cotation de transfert devise' ;
			public $TitrFenModifReservCotationTransfDev = 'Modifier cotation de transfert devise' ;
			public $TitrFenSupprReservCotationTransfDev = 'Supprimer cotation de transfert devise' ;
			public $TitrFenPublierCotationDepotTerme = 'Publication cotation de dep&ocirc;ts &agrave; terme' ;
			public $TitrFenConsultCotationDepotTerme = 'Consultation cotation de dep&ocirc;ts &agrave; terme' ;
			public $TitrFenProposCotationDepotTerme = 'Propositions cotation de dep&ocirc;ts &agrave; terme' ;
			public $TitrFenDetailProposCotationDepotTerme = 'D&eacute;tails proposition cotation de dep&ocirc;ts &agrave; terme' ;
			public $TitrFenAjoutCotationDepotTerme = 'Ajout cotation de dep&ocirc;t &agrave; terme' ;
			public $TitrFenModifCotationDepotTerme = 'Modification cotation de dep&ocirc;t &agrave; terme' ;
			public $TitrFenSupprCotationDepotTerme = 'Suppression cotation de dep&ocirc;t &agrave; terme' ;
			public $TitrFenListReservCotationDepotTerme = 'Liste des r&eacute;servations cotation de dep&ocirc;t &agrave; terme' ;
			public $TitrFenAjoutReservCotationDepotTerme = 'R&eacute;server cotation de dep&ocirc;t &agrave; terme' ;
			public $TitrFenModifReservCotationDepotTerme = 'Modifier cotation de dep&ocirc;t &agrave; terme' ;
			public $TitrFenSupprReservCotationDepotTerme = 'Supprimer cotation de dep&ocirc;t &agrave; terme' ;
		}
	}
	
?>
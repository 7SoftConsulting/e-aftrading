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
			public $TitrFenDemarrNegocOpInter = "N&eacute;gocier Interbancaire" ;
			public $LibLienAjustNegocOpInter = "N&eacute;gocier" ;
			public $TitrFenAjustNegocOpInter = "N&eacute;gocier Interbancaire" ;
			public $LibLienConfirmNegoc = "Confirmer" ;
			public $LibLienRefusNegoc = "Refuser" ;
			public $TitrFenDemarrNegocAchatDevise = "N&eacute;gocier achat de devises" ;
			public $TitrFenDemarrNegocVenteDevise = "N&eacute;gocier vente de devises" ;
			public $MsgInteretAchatDevise = 'Voulez-vous confirmer votre int&eacute;r&ecirc;t pour cet achat de devises ?' ;
			public $MsgInteretVenteDevise = 'Voulez-vous confirmer votre int&eacute;r&ecirc;t pour cette vente de devises ?' ;
			public $TitrFenDemarrNegocPlacement = "N&eacute;gocier placement" ;
			public $TitrFenDemarrNegocEmprunt = "N&eacute;gocier emprunt" ;
			public $MsgInteretPlacement = 'Voulez-vous confirmer votre int&eacute;r&ecirc;t pour ce placement ?' ;
			public $MsgInteretEmprunt = 'Voulez-vous confirmer votre int&eacute;r&ecirc;t pour cet emprunt ?' ;
			public $TitrFenPublierEmissBonTresor = 'Publication &Eacute;mission Bon du Tr&eacute;sor' ;
			public $TitrFenConsultEmissBonTresor = 'Consultation &Eacute;mission Bon du Tr&eacute;sor' ;
			public $TitrFenProposEmissBonTresor = 'Propositions &Eacute;mission Bon du Tr&eacute;sor' ;
			public $TitrFenDetailProposEmissBonTresor = 'D&eacute;tails  proposition &Eacute;mission Bon du Tr&eacute;sor' ;
			public $TitrFenAjoutEmissBonTresor = 'Ajout &Eacute;mission Bon du Tr&eacute;sor' ;
			public $TitrFenModifEmissBonTresor = 'Modification &Eacute;mission Bon du Tr&eacute;sor' ;
			public $TitrFenSupprEmissBonTresor = 'Suppression &Eacute;mission Bon du Tr&eacute;sor' ;
			public $TitrFenListReservEmissBonTresor = 'Liste des r&eacute;servations &eacute;mission Bon du Tr&eacute;sor' ;
			public $TitrFenAjoutReservEmissBonTresor = 'R&eacute;server &eacute;mission Bon du Tr&eacute;sor' ;
			public $TitrFenModifReservEmissBonTresor = 'Modifier r&eacute;serv . &eacute;mission Bon du Tr&eacute;sor' ;
			public $TitrFenSupprReservEmissBonTresor = 'Supprimer r&eacute;serv. &eacute;mission Bon du Tr&eacute;sor' ;
			public $TitrFenPublierRachatBonTresor = 'Publication Rachat &Eacute;mission Bon du Tr&eacute;sor' ;
			public $TitrFenConsultRachatBonTresor = 'Consultation Rachat &Eacute;mission Bon du Tr&eacute;sor' ;
			public $TitrFenAjoutRachatBonTresor = 'Ajout Rachat &Eacute;mission Bon du Tr&eacute;sor' ;
			public $TitrFenModifRachatBonTresor = 'Modification Rachat &Eacute;mission Bon du Tr&eacute;sor' ;
			public $TitrFenSupprRachatBonTresor = 'Suppression Rachat &Eacute;mission Bon du Tr&eacute;sor' ;
			public $TitrFenPublierEmissObligation = 'Publication &Eacute;mission d\'Obligations' ;
			public $TitrFenConsultEmissObligation = 'Consultation &Eacute;mission d\'Obligations' ;
			public $TitrFenProposEmissObligation = 'Propositions &Eacute;mission d\'Obligations' ;
			public $TitrFenDetailProposEmissObligation = 'D&eacute;tails  proposition &Eacute;mission d\'Obligations' ;
			public $TitrFenAjoutEmissObligation = 'Ajout &Eacute;mission d\'Obligations' ;
			public $TitrFenModifEmissObligation = 'Modification &Eacute;mission d\'Obligations' ;
			public $TitrFenSupprEmissObligation = 'Suppression &Eacute;mission d\'Obligations' ;
			public $TitrFenListReservEmissObligation = 'Liste des r&eacute;servations &Eacute;mission d\'Obligations' ;
			public $TitrFenAjoutReservEmissObligation = 'R&eacute;server &Eacute;mission d\'Obligations' ;
			public $TitrFenModifReservEmissObligation = 'Modifier r&eacute;serv . &Eacute;mission d\'Obligations' ;
			public $TitrFenSupprReservEmissObligation = 'Supprimer r&eacute;serv. &Eacute;mission d\'Obligations' ;
			public $TitrFenPublierCotationTransfDev = 'Publication contation transfert en devises' ;
			public $TitrFenConsultCotationTransfDev = 'Consultation contation transfert en devises' ;
			public $TitrFenProposCotationTransfDev = 'Propositions contation transfert en devises' ;
			public $TitrFenDetailProposCotationTransfDev = 'D&eacute;tails proposition contation transfert en devises' ;
			public $TitrFenAjoutCotationTransfDev = 'Ajout cotation transfert en devises' ;
			public $TitrFenModifCotationTransfDev = 'Modification cotation transfert en devises' ;
			public $TitrFenSupprCotationTransfDev = 'Suppression cotation transfert en devises' ;
			public $TitrFenListReservCotationTransfDev = 'Liste des r&eacute;servations cotation transfert en devises' ;
			public $TitrFenAjoutReservCotationTransfDev = 'R&eacute;server cotation de transfert devise' ;
			public $TitrFenModifReservCotationTransfDev = 'Modifier cotation transfert en devises' ;
			public $TitrFenSupprReservCotationTransfDev = 'Supprimer transfert en devises' ;
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
			public $TitrFenPublierReventeBonTresor = 'Publication Revente &Eacute;mission Bon du Tr&eacute;sor' ;
			public $TitrFenConsultReventeBonTresor = 'Consultation Revente &Eacute;mission Bon du Tr&eacute;sor' ;
			public $TitrFenAjoutReventeBonTresor = 'Ajout Revente &Eacute;mission Bon du Tr&eacute;sor' ;
			public $TitrFenModifReventeBonTresor = 'Modification Revente &Eacute;mission Bon du Tr&eacute;sor' ;
			public $TitrFenSupprReventeBonTresor = 'Suppression Revente &Eacute;mission Bon du Tr&eacute;sor' ;
			public $TitrFenPublierRachatObligation = 'Publication Rachat &Eacute;mission Obligation' ;
			public $TitrFenConsultRachatObligation = 'Consultation Rachat &Eacute;mission Obligation' ;
			public $TitrFenAjoutRachatObligation = 'Ajout Rachat &Eacute;mission Obligation' ;
			public $TitrFenModifRachatObligation = 'Modification Rachat &Eacute;mission Obligation' ;
			public $TitrFenSupprRachatObligation = 'Suppression Rachat &Eacute;mission Obligation' ;
			public $TitrFenPublierReventeObligation = 'Publication Revente &Eacute;mission Obligation' ;
			public $TitrFenConsultReventeObligation = 'Consultation Revente &Eacute;mission Obligation' ;
			public $TitrFenAjoutReventeObligation = 'Ajout Revente &Eacute;mission Obligation' ;
			public $TitrFenModifReventeObligation = 'Modification Revente &Eacute;mission Obligation' ;
			public $TitrFenSupprReventeObligation = 'Suppression Revente &Eacute;mission Obligation' ;
		}
	}
	
?>
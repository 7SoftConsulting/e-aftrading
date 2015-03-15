<?php
	
	if(! defined('ZONE_PUBL_TRAD_PLATF'))
	{
		if(! defined('CLIENT_MDGM'))
		{
			include dirname(__FILE__)."/ClientMdgm.class.php" ;
		}
		if(! defined('MEMBERSHIP_TRAD_PLATF'))
		{
			include dirname(__FILE__)."/Membership.class.php" ;
		}
		if(! defined('FOURN_EXPRS_TRAD_PLATF'))
		{
			include dirname(__FILE__)."/FournExprs.class.php" ;
		}
		if(! defined('SCRIPT_PUBL_TRAD_PLATF'))
		{
			include dirname(__FILE__)."/ScriptPubl.class.php" ;
		}
		if(! defined('OP_CHANGE_TRAD_PLATF'))
		{
			include dirname(__FILE__)."/OpChange.class.php" ;
		}
		if(! defined('OP_INTER_TRAD_PLATF'))
		{
			include dirname(__FILE__)."/OpInter.class.php" ;
		}
		if(! defined('EMISS_BON_TRESOR_TRAD_PLATF'))
		{
			include dirname(__FILE__)."/EmissBonTresor.class.php" ;
		}
		if(! defined('EMISS_OBLIGATION_TRAD_PLATF'))
		{
			include dirname(__FILE__)."/EmissObligation.class.php" ;
		}
		if(! defined('COTATION_TRANSF_DEV_TRAD_PLATF'))
		{
			include dirname(__FILE__)."/CotationTransfDev.class.php" ;
		}
		if(! defined('COTATION_DEPOT_TERME_TRAD_PLATF'))
		{
			include dirname(__FILE__)."/CotationDepotTerme.class.php" ;
		}
		define('ZONE_PUBL_TRAD_PLATF', 1) ;
		
		class ZonePublTradPlatf extends PvZoneWebAdminDirecte
		{
			public $MessageIntroduction = "Bienvenue sur Trading Platform, la plateforme d'echange de tresorerie. Pour acc&eacute;der à votre espace, veuillez vous connecter" ;
			public $ContenuPiedDocument = "Trading Platform 2014 &copy; tous droits r&eacute;serv&eacute;s." ;
			public $NomClasseMembership = "MembershipTradPlatf" ;
			public $NomClasseRemplisseurConfigMembership = "RemplisseurConfigMembershipTradPlatf" ;
			public $LibelleMenuMembership = "Administration" ;
			public $LibelleMenuChangeMotPasse = "Changer mot de passe" ;
			public $LibelleMenuListeMembres = "Tr&eacute;soriers" ;
			public $LibelleMenuAjoutMembre = "Ajout tr&eacute;sorier" ;
			public $LibelleMenuListeRoles = "Tous les roles" ;
			public $LibelleMenuAjoutRole = "Ajout role" ;
			public $LibelleMenuListeProfils = "Profils tr&eacute;soriers" ;
			public $LibelleMenuAjoutProfil = "Ajouter un profil" ;
			public $InscrireMenuDeconnexion = 0 ;
			public $InscrireMenuChangeMotPasse = 0 ;
			public $InscrireMenuAjoutMembre = 0 ;
			public $ContenuRenduEntete = '<table style="background:white" align="center"><tr><td><img src="images/logo.png" height="60" /></td></tr></table>' ;
			public $ImageArrierePlanDocument = "" ;
			public $EtirerImageArrierePlanDocument = 0 ;
			public $CouleurArrierePlanDocument = "white" ;
			public $ScriptAccueil ;
			public $ScriptBienvenue ;
			public $ScriptActivationMembre ;
			public $ScriptChStatutMembre ;
			public $ScriptListeEntites ;
			public $ScriptAjoutEntite ;
			public $ScriptModifEntite ;
			public $ScriptRattachEntite ;
			public $ScriptLiaisonsEntite ;
			public $ScriptParamOpChange ;
			public $ScriptParamOpInter ;
			public $ScriptSupprEntite ;
			public $ScriptListeTypesEntite ;
			public $ScriptAjoutTypeEntite ;
			public $ScriptModifTypeEntite ;
			public $ScriptSupprTypeEntite ;
			public $ScriptListeBanques ;
			public $ScriptListeEtabsFinanc ;
			public $ScriptListeCiesAssurance ;
			public $ScriptListeGdEntreprises ;
			public $ScriptListeTresorsPubl ;
			public $ScriptListePays ;
			public $ScriptAjoutPays ;
			public $ScriptModifPays ;
			public $ScriptSupprPays ;
			public $ScriptListeZonePays ;
			public $ScriptAjoutZonePays ;
			public $ScriptModifZonePays ;
			public $ScriptSupprZonePays ;
			public $ScriptListeDevises ;
			public $ScriptAjoutDevise ;
			public $ScriptModifDevise ;
			public $ScriptSupprDevise ;
			public $ScriptSoumissAchatDevise ;
			public $ScriptInteretAchatDevise ;
			public $ScriptListeAchatsDevise ;
			public $ScriptConsultAchatsDevise ;
			public $ScriptAjoutAchatDevise ;
			public $ScriptModifAchatDevise ;
			public $ScriptEditAchatsDevise ;
			public $ScriptReservAchatsDevise ;
			public $ScriptRepsAchatDevise ;
			public $ScriptReponseAchatDevise ;
			public $ScriptAjustAchatDevise ;
			public $ScriptNegocAchatDevise ;
			public $ScriptSupprAchatDevise ;
			public $ScriptSoumissVenteDevise ;
			public $ScriptListeVentesDevise ;
			public $ScriptConsultVentesDevise ;
			public $ScriptAjoutVenteDevise ;
			public $ScriptModifVenteDevise ;
			public $ScriptEditVentesDevise ;
			public $ScriptReservVentesDevise ;
			public $ScriptPostulsVenteDevise ;
			public $ScriptReponseVenteDevise ;
			public $ScriptNegocVenteDevise ;
			public $ScriptInteretVenteDevise ;
			public $ScriptAjustVenteDevise ;
			public $ScriptSupprVenteDevise ;
			public $ScriptValPostulVenteDevise ;
			public $ScriptSoumissOpChange ;
			public $ScriptModifOpChangeSoumis ;
			public $MenuBanqEtabFinanc ;
			public $MenuEtabBanq ;
			public $MenuCiesAssurance ;
			public $MenuGdEntreprise ;
			public $MenuTresorPubl ;
			public $MenuListeTransacts ;
			public $MenuListeOpBancaires ;
			public $MenuParamTransactEntites ;
			public $MenuParamOpChange ;
			public $MenuLiaisonOpChange ;
			public $MenuListeAchatsDevise ;
			public $MenuListeVentesDevise ;
			public $MenuReference ;
			public $MenuListeEntites ;
			public $MenuListePays ;
			public $MenuListeZonesPays ;
			public $MenuActivationMembre ;
			public $ScriptSoumissPlacement ;
			public $ScriptInteretPlacement ;
			public $ScriptListePlacements ;
			public $ScriptConsultPlacements ;
			public $ScriptAjoutPlacement ;
			public $ScriptModifPlacement ;
			public $ScriptEditPlacements ;
			public $ScriptReservPlacements ;
			public $ScriptRepsPlacement ;
			public $ScriptReponsePlacement ;
			public $ScriptAjustPlacement ;
			public $ScriptNegocPlacement ;
			public $ScriptSupprPlacement ;
			public $ScriptSoumissEmprunt ;
			public $ScriptListeEmprunts ;
			public $ScriptConsultEmprunts ;
			public $ScriptAjoutEmprunt ;
			public $ScriptModifEmprunt ;
			public $ScriptEditEmprunts ;
			public $ScriptReservEmprunts ;
			public $ScriptPostulsEmprunt ;
			public $ScriptReponseEmprunt ;
			public $ScriptNegocEmprunt ;
			public $ScriptInteretEmprunt ;
			public $ScriptAjustEmprunt ;
			public $ScriptSupprEmprunt ;
			public $ScriptValPostulEmprunt ;
			public $ScriptSoumissOpInter ;
			public $ScriptModifOpInterSoumis ;
			public $ScriptConsultEmissBonTresor ;
			public $ScriptPublierEmissBonTresor ;
			public $ScriptAjoutEmissBonTresor ;
			public $ScriptModifEmissBonTresor ;
			public $ScriptSupprEmissBonTresor ;
			public $ScriptProposEmissBonTresor ;
			public $ScriptDetailProposEmissBonTresor ;
			public $ScriptDetailReservEmissBonTresor ;
			public $ScriptListReservEmissBonTresor ;
			public $ScriptAjoutReservEmissBonTresor ;
			public $ScriptModifReservEmissBonTresor ;
			public $ScriptSupprReservEmissBonTresor ;
			public $ScriptConsultEmissObligation ;
			public $ScriptPublierEmissObligation ;
			public $ScriptAjoutEmissObligation ;
			public $ScriptModifEmissObligation ;
			public $ScriptSupprEmissObligation ;
			public $ScriptProposEmissObligation ;
			public $ScriptDetailProposEmissObligation ;
			public $ScriptDetailReservEmissObligation ;
			public $ScriptListReservEmissObligation ;
			public $ScriptAjoutReservEmissObligation ;
			public $ScriptModifReservEmissObligation ;
			public $ScriptSupprReservEmissObligation ;
			public $ScriptConsultCotationTransfDev ;
			public $ScriptPublierCotationTransfDev ;
			public $ScriptAjoutCotationTransfDev ;
			public $ScriptModifCotationTransfDev ;
			public $ScriptSupprCotationTransfDev ;
			public $ScriptProposCotationTransfDev ;
			public $ScriptDetailProposCotationTransfDev ;
			public $ScriptDetailReservCotationTransfDev ;
			public $ScriptListReservCotationTransfDev ;
			public $ScriptAjoutReservCotationTransfDev ;
			public $ScriptModifReservCotationTransfDev ;
			public $ScriptSupprReservCotationTransfDev ;
			public $MenuParamOpInter ;
			public $MenuLiaisonOpInter ;
			public $MenuListePlacements ;
			public $MenuTresorier ;
			public $MenuEmissBonTresor ;
			public $MenuEmissObligation ;
			public $RemplisseurConfig ;
			public $DetectIconeCorresp = 1 ;
			public $FournExprs ;
			public $PrivilegesMenuMembership = array("admin_operator", "admin_members") ;
			public $PrivilegesPassePartout = array("admin_members") ;
			protected function InitConfig()
			{
				parent::InitConfig() ;
				$this->FournExprs = new FournExprsPublTradPlatf() ;
			}
			protected function ChargeBarreMenuSuperfish()
			{
				if(! $this->PossedeMembreConnecte())
				{
					return ;
				}
				$this->MenuBanqEtabFinanc = $this->BarreMenuSuperfish->MenuRacine->InscritSousMenuFige("etabFinanc") ;
				$this->MenuBanqEtabFinanc->Privileges = array("admin_members") ;
				$this->MenuBanqEtabFinanc->CheminIcone = "images/icones/listeEtabFinanc.png" ;
				$this->MenuBanqEtabFinanc->Titre = "Entit&eacute;s financi&egrave;res" ;
				$this->MenuEtabBanq = $this->MenuBanqEtabFinanc->InscritSousMenuScript("listeBanques") ;
				$this->MenuEtabBanq->Titre = "Etablissements bancaires" ;
				$this->MenuEtabFinanc = $this->MenuBanqEtabFinanc->InscritSousMenuScript("listeEtabsFinanc") ;
				$this->MenuCiesAssurance = $this->MenuBanqEtabFinanc->InscritSousMenuScript("listeCiesAssurance") ;
				$this->MenuCiesAssurance->Titre = "Compagnies d'assurance" ;
				$this->MenuGdEntreprise = $this->MenuBanqEtabFinanc->InscritSousMenuScript("listeGdEntreprises") ;
				$this->MenuGdEntreprise->Titre = "Entreprises" ;
				$this->MenuTresorsPubl = $this->MenuBanqEtabFinanc->InscritSousMenuScript("listeTresorsPubl") ;
				$this->MenuTresorsPubl->Titre = "SGI" ;
				$this->MenuParamTransactEntites = $this->BarreMenuSuperfish->MenuRacine->InscritSousMenuFige("paramOpInter") ;
				$this->MenuParamTransactEntites->Privileges[] = "admin_operator" ;
				$this->MenuParamTransactEntites->Titre = "Param&eacute;trage transaction entre entit&eacute;" ;
				$this->MenuParamTransactEntites->CheminIcone = "images/icones/paramEtabFinanc.png" ;
				if($this->PossedePrivilege('admin_members'))
				{
					$this->MenuParamOpChange = $this->MenuParamTransactEntites->InscritSousMenuScript("paramOpChange") ;
					$this->MenuParamOpInter = $this->MenuParamTransactEntites->InscritSousMenuScript("paramOpInter") ;
				}
				else
				{
					$this->MenuParamOpChange = $this->MenuParamTransactEntites->InscritSousMenuFenetreScript("rattachEntite") ;
					$this->MenuParamOpChange->ParamsScript["idEnCours"] = $this->Membership->MemberLogged->RawData["ID_ENTITE_MEMBRE"] ;
					$this->MenuLiaisonOpChange = $this->MenuParamTransactEntites->InscritSousMenuFenetreScript("liaisonsEntite") ;
					$this->MenuLiaisonOpChange->ParamsScript["idEnCours"] = $this->Membership->MemberLogged->RawData["ID_ENTITE_MEMBRE"] ;
					$this->MenuLiaisonOpChange->Largeur = 725 ;
					$this->MenuLiaisonOpChange->Titre = "Liaisons op&eacute;ration change devise (Achat/Vente devise)" ;
					$this->MenuParamOpInter = $this->MenuParamTransactEntites->InscritSousMenuFenetreScript("rattachOpInter") ;
					$this->MenuParamOpInter->ParamsScript["idEnCours"] = $this->Membership->MemberLogged->RawData["ID_ENTITE_MEMBRE"] ;
					$this->MenuLiaisonOpInter = $this->MenuParamTransactEntites->InscritSousMenuFenetreScript("liaisonsOpInter") ;
					$this->MenuLiaisonOpInter->ParamsScript["idEnCours"] = $this->Membership->MemberLogged->RawData["ID_ENTITE_MEMBRE"] ;
					$this->MenuLiaisonOpInter->Largeur = 725 ;
					$this->MenuLiaisonOpInter->Titre = "Liaisons op&eacute;ration interbancaire (Placement/Emprunt)" ;
				}
				$this->MenuParamOpChange->Titre = "Echange op&eacute;ration change devise (Achat/Vente devise)" ;
				$this->MenuParamOpInter->Titre = "Echange op&eacute;ration interbancaire (Placement/Emprunt)" ;
				$this->MenuListeTransacts = $this->BarreMenuSuperfish->MenuRacine->InscritSousMenuFige("listeTransacts") ;
				$this->MenuListeTransacts->Titre = "Op&eacute;rations bancaires" ;
				$this->MenuListeTransacts->Privileges[] = "post_op_change" ;
				$this->MenuOpChangeDevise = $this->MenuListeTransacts->InscritSousMenuFige("transactsOpChangeDevise") ;
				$this->MenuOpChangeDevise->Titre = "Op&eacute;ration change devise" ;
				$this->MenuListeAchatsDevise = $this->MenuOpChangeDevise->InscritSousMenuScript("listeAchatsDevise") ;
				$this->MenuListeAchatsDevise->Titre = "Achat de devise" ;
				$this->MenuListeVentesDevise = $this->MenuOpChangeDevise->InscritSousMenuScript("listeVentesDevise") ;
				$this->MenuListeVentesDevise->Titre = "Vente de devise" ;
				$this->MenuOpInterbancaire = $this->MenuListeTransacts->InscritSousMenuFige("transactsOpInterbancaires") ;
				$this->MenuOpInterbancaire->Titre = "Op&eacute;ration interbancaire" ;
				$this->MenuOpInterbancaire->Privileges[] = "post_op_change" ;
				$this->MenuListePlacements = $this->MenuOpInterbancaire->InscritSousMenuScript("listePlacements") ;
				$this->MenuListePlacements->Titre = "Placements" ;
				$this->MenuListeEmprunts = $this->MenuOpInterbancaire->InscritSousMenuScript("listeEmprunts") ;
				$this->MenuListeEmprunts->Titre = "Emprunts" ;
				if(! $this->PossedePrivilege("post_doc_entreprise"))
				{
					$this->MenuOpEntreprise = $this->MenuListeTransacts->InscritSousMenuFige("transactsOpEntreprises") ;
					$this->MenuOpEntreprise->Titre = "Op&eacute;ration entreprise/assurance" ;
					$this->MenuOpCotationTransfDev = $this->MenuOpEntreprise->InscritSousMenuScript("consultCotationTransfDev") ;
					$this->MenuOpCotationTransfDev->Titre = "Cotation transfert de devise" ;
					$this->MenuOpCotationDepotTerme = $this->MenuOpEntreprise->InscritSousMenuScript("consultCotationDepotTerme") ;
					$this->MenuOpCotationDepotTerme->Titre = "Cotation d&eacute;p&ocirc;t &agrave; terme" ;
				}
				$this->MenuNegociations = $this->BarreMenuSuperfish->MenuRacine->InscritSousMenuFige('negociations') ;
				$this->MenuNegociations->Privileges[] = "post_op_change" ;
				$this->MenuNegociations->Titre = "N&eacute;gociations" ;
				$this->MenuSoumissOpChange = $this->MenuNegociations->InscritSousMenuScript("soumissOpChange") ;
				$this->MenuSoumissOpChange->Titre = "Op&eacute;rations de change" ;
				$this->MenuSoumissOpChange->Privileges[] = "post_op_change" ;
				$this->MenuSoumissOpInter = $this->MenuNegociations->InscritSousMenuScript("soumissOpInter") ;
				$this->MenuSoumissOpInter->Titre = "Op&eacute;rations interbancaires" ;
				$this->MenuSoumissOpInter->Privileges[] = "post_op_change" ;
				$this->MenuTresorier = $this->BarreMenuSuperfish->MenuRacine->InscritSousMenuFige('tresorier') ;
				$this->MenuTresorier->Titre = "SGI" ;
				$this->MenuEmissBonTresor = $this->MenuTresorier->InscritSousMenuScript(! $this->PossedePrivilege('post_doc_tresorier') ? 'consultEmissBonTresor' : 'publierEmissBonTresor') ;
				$this->MenuEmissBonTresor->Titre = "Bons de tresor" ;
				$this->MenuEmissObligation = $this->MenuTresorier->InscritSousMenuScript(! $this->PossedePrivilege('post_doc_tresorier') ? 'consultEmissObligation' : 'publierEmissObligation') ;
				$this->MenuEmissObligation->Titre = "Obligations" ;
				if($this->PossedePrivilege('post_doc_entreprise'))
				{
					$this->MenuEmissObligation->Titre = "Obligations" ;
					$this->MenuEntreprise = $this->BarreMenuSuperfish->MenuRacine->InscritSousMenuFige('entreprise') ;
					$this->MenuEntreprise->Titre = "Entreprise" ;
					$this->MenuCotationTransfDev = $this->MenuEntreprise->InscritSousMenuScript('publierCotationTransfDev') ;
					$this->MenuCotationTransfDev->Titre = "Cotation transfert en devise" ;
					$this->MenuCotationDepotTerme = $this->MenuEntreprise->InscritSousMenuScript('publierCotationDepotTerme') ;
					$this->MenuCotationDepotTerme->Titre = "Cotation d&eacute;p&ocirc;t &agrave; terme" ;
				}
			}
			protected function ChargeAvantMenusMembership()
			{
				$this->MenuReference = $this->MenuAuthentification->InscritSousMenuFige("references") ;
				$this->MenuReference->Privileges = $this->PrivilegesPassePartout ;
				$this->MenuReference->CheminIcone = "images/icones/reference.png" ;
				$this->MenuReference->Titre = "R&eacute;f&eacute;rences" ;
				$this->MenuListeDevises = $this->MenuReference->InscritSousMenuScript("listeDevises") ;
				$this->MenuListeDevises->Titre = "Devises" ;
				$this->MenuListePays = $this->MenuReference->InscritSousMenuScript("listePays") ;
				$this->MenuListePays->Titre = "Pays" ;
				$this->MenuListeZonesPays = $this->MenuReference->InscritSousMenuScript("listeZonesPays") ;
				$this->MenuListeZonesPays->Titre = "Zones" ;
				$this->MenuListeTypesEntite = $this->MenuReference->InscritSousMenuScript("listeTypesEntite") ;
				$this->MenuListeTypesEntite->Titre = "Types d'entit&eacute;" ;
			}
			protected function ChargeAutresMenus()
			{
				parent::ChargeAutresMenus() ;
				if($this->EstPasNul($this->MenuAjoutMembre))
				{
					$this->MenuAjoutMembre->Largeur = 725 ;
					$this->MenuAjoutMembre->Hauteur = 450 ;
					$this->MenuAjoutMembre->BoutonFermer = 0 ;
					$this->MenuAjoutProfil->Hauteur = 300 ;
					$this->MenuAjoutProfil->BoutonFermer = 0 ;
					$this->MenuAjoutRole->Hauteur = 300 ;
					$this->MenuAjoutRole->BoutonFermer = 0 ;
					$this->MenuAuthentification->CheminIcone = "images/icones/authentification.png" ;
				}
			}
			protected function ChargeAutresMenusMembres()
			{
				$this->MenuActivationMembre = $this->MenuAuthentification->InscritSousMenuScript("activationMembre") ;
			}
			public function ChargeScripts()
			{
				$this->RemplisseurConfig = new RemplisseurConfigPublTradPlatf() ;
				parent::ChargeScripts() ;
				$this->CompAvantEspaceTravail = new CompBarreInfosMembreTradPlatf() ;
				$this->CompAvantEspaceTravail->AdopteZone("barreInfosMembre", $this) ;
				$this->ScriptActivationMembre = new ScriptActivationMembrePublTradPlatf() ;
				$this->InscritScript("activationMembre", $this->ScriptActivationMembre) ;
				$this->ScriptChStatutMembre = new ScriptChStatutMembreTradPlatf() ;
				$this->InscritScript("changeStatutMembre", $this->ScriptChStatutMembre) ;
				$this->ScriptAccueil = new ScriptAccueilPublTradPlatf() ;
				$this->InscritScript($this->NomScriptParDefaut, $this->ScriptAccueil) ;
				$this->ScriptBienvenue = new ScriptAccueilPublTradPlatf() ;
				$this->InscritScript("bienvenue", $this->ScriptBienvenue) ;
				$this->ScriptListeEntites = new ScriptListeEntitesTradPlatf() ;
				$this->InscritScript("listeEntites", $this->ScriptListeEntites) ;
				$this->ScriptListeBanques = new ScriptListeBanquesTradPlatf() ;
				$this->InscritScript("listeBanques", $this->ScriptListeBanques) ;
				$this->ScriptListeEtabsFinanc = new ScriptListeEtabsFinancTradPlatf() ;
				$this->InscritScript("listeEtabsFinanc", $this->ScriptListeEtabsFinanc) ;
				$this->ScriptListeCiesAssurance = new ScriptListeCiesAssuranceTradPlatf() ;
				$this->InscritScript("listeCiesAssurance", $this->ScriptListeCiesAssurance) ;
				$this->ScriptListeGdEntreprises = new ScriptListeGdEntreprisesTradPlatf() ;
				$this->InscritScript("listeGdEntreprises", $this->ScriptListeGdEntreprises) ;
				$this->ScriptListeTresorsPubl = new ScriptListeTresorsPublTradPlatf() ;
				$this->InscritScript("listeTresorsPubl", $this->ScriptListeTresorsPubl) ;
				$this->ScriptParamOpChange = new ScriptParamOpChangeTradPlatf() ;
				$this->InscritScript("paramOpChange", $this->ScriptParamOpChange) ;
				$this->ScriptParamOpInter = new ScriptParamOpInterTradPlatf() ;
				$this->InscritScript("paramOpInter", $this->ScriptParamOpInter) ;
				$this->ScriptAjoutEntite = new ScriptAjoutEntiteTradPlatf() ;
				$this->InscritScript("ajoutEntite", $this->ScriptAjoutEntite) ;
				$this->ScriptModifEntite = new ScriptModifEntiteTradPlatf() ;
				$this->InscritScript("modifEntite", $this->ScriptModifEntite) ;
				$this->ScriptRattachEntite = new ScriptRattachEntiteTradPlatf() ;
				$this->InscritScript("rattachEntite", $this->ScriptRattachEntite) ;
				$this->ScriptLiaisonsEntite = new ScriptLiaisonsEntiteTradPlatf() ;
				$this->InscritScript("liaisonsEntite", $this->ScriptLiaisonsEntite) ;
				$this->ScriptRattachOpInter = new ScriptRattachOpInterTradPlatf() ;
				$this->InscritScript("rattachOpInter", $this->ScriptRattachOpInter) ;
				$this->ScriptLiaisonsOpInter = new ScriptLiaisonsOpInterTradPlatf() ;
				$this->InscritScript("liaisonsOpInter", $this->ScriptLiaisonsOpInter) ;
				$this->ScriptSupprEntite = new ScriptSupprEntiteTradPlatf() ;
				$this->InscritScript("supprEntite", $this->ScriptSupprEntite) ;
				$this->ScriptListeTypesEntite = new ScriptListeTypesEntiteTradPlatf() ;
				$this->InscritScript("listeTypesEntite", $this->ScriptListeTypesEntite) ;
				$this->ScriptAjoutTypeEntite = new ScriptAjoutTypeEntiteTradPlatf() ;
				$this->InscritScript("ajoutTypeEntite", $this->ScriptAjoutTypeEntite) ;
				$this->ScriptModifTypeEntite = new ScriptModifTypeEntiteTradPlatf() ;
				$this->InscritScript("modifTypeEntite", $this->ScriptModifTypeEntite) ;
				$this->ScriptSupprTypeEntite = new ScriptSupprTypeEntiteTradPlatf() ;
				$this->InscritScript("supprTypeEntite", $this->ScriptSupprTypeEntite) ;
				$this->ScriptListePays = new ScriptListePaysTradPlatf() ;
				$this->InscritScript("listePays", $this->ScriptListePays) ;
				$this->ScriptAjoutPays = new ScriptAjoutPaysTradPlatf() ;
				$this->InscritScript("ajoutPays", $this->ScriptAjoutPays) ;
				$this->ScriptModifPays = new ScriptModifPaysTradPlatf() ;
				$this->InscritScript("modifPays", $this->ScriptModifPays) ;
				$this->ScriptSupprPays = new ScriptSupprPaysTradPlatf() ;
				$this->InscritScript("supprPays", $this->ScriptSupprPays) ;
				$this->ScriptListeDevises = new ScriptListeDevisesTradPlatf() ;
				$this->InscritScript("listeDevises", $this->ScriptListeDevises) ;
				$this->ScriptAjoutDevise = new ScriptAjoutDeviseTradPlatf() ;
				$this->InscritScript("ajoutDevise", $this->ScriptAjoutDevise) ;
				$this->ScriptModifDevise = new ScriptModifDeviseTradPlatf() ;
				$this->InscritScript("modifDevise", $this->ScriptModifDevise) ;
				$this->ScriptSupprDevise = new ScriptSupprDeviseTradPlatf() ;
				$this->InscritScript("supprDevise", $this->ScriptSupprDevise) ;
				$this->ScriptListeZonesPays = new ScriptListeZonesPaysTradPlatf() ;
				$this->InscritScript("listeZonesPays", $this->ScriptListeZonesPays) ;
				$this->ScriptAjoutZonePays = new ScriptAjoutZonePaysTradPlatf() ;
				$this->InscritScript("ajoutZonePays", $this->ScriptAjoutZonePays) ;
				$this->ScriptModifZonePays = new ScriptModifZonePaysTradPlatf() ;
				$this->InscritScript("modifZonePays", $this->ScriptModifZonePays) ;
				$this->ScriptSupprZonePays = new ScriptSupprZonePaysTradPlatf() ;
				$this->InscritScript("supprZonePays", $this->ScriptSupprZonePays) ;
				$this->ScriptListeAchatsDevise = new ScriptListeAchatsDeviseTradPlatf() ;
				$this->InscritScript("listeAchatsDevise", $this->ScriptListeAchatsDevise) ;
				$this->ScriptConsultAchatsDevise = new ScriptConsultAchatsDeviseTradPlatf() ;
				$this->InscritScript("consultAchatsDevise", $this->ScriptConsultAchatsDevise) ;
				$this->ScriptEditAchatsDevise = new ScriptEditAchatsDeviseTradPlatf() ;
				$this->InscritScript("editAchatsDevise", $this->ScriptEditAchatsDevise) ;
				$this->ScriptReservAchatsDevise = new ScriptReservAchatsDeviseTradPlatf() ;
				$this->InscritScript("reservAchatsDevise", $this->ScriptReservAchatsDevise) ;
				$this->ScriptAjoutAchatDevise = new ScriptAjoutAchatDeviseTradPlatf() ;
				$this->InscritScript("ajoutAchatDevise", $this->ScriptAjoutAchatDevise) ;
				$this->ScriptPostulsAchatDevise = new ScriptPostulsAchatDeviseTradPlatf() ;
				$this->InscritScript("postulsAchatDevise", $this->ScriptPostulsAchatDevise) ;
				$this->ScriptReponseAchatDevise = new ScriptReponseAchatDeviseTradPlatf() ;
				$this->InscritScript("reponseAchatDevise", $this->ScriptReponseAchatDevise) ;
				$this->ScriptNegocAchatDevise = new ScriptNegocAchatDeviseTradPlatf() ;
				$this->InscritScript("negocAchatDevise", $this->ScriptNegocAchatDevise) ;
				$this->ScriptInteretAchatDevise = new ScriptInteretAchatDeviseTradPlatf() ;
				$this->InscritScript("interetAchatDevise", $this->ScriptInteretAchatDevise) ;
				$this->ScriptAjustAchatDevise = new ScriptAjustAchatDeviseTradPlatf() ;
				$this->InscritScript("ajustAchatDevise", $this->ScriptAjustAchatDevise) ;
				$this->ScriptModifAchatDevise = new ScriptModifAchatDeviseTradPlatf() ;
				$this->InscritScript("modifAchatDevise", $this->ScriptModifAchatDevise) ;
				$this->ScriptSupprAchatDevise = new ScriptSupprAchatDeviseTradPlatf() ;
				$this->InscritScript("supprAchatDevise", $this->ScriptSupprAchatDevise) ;
				$this->ScriptListeVentesDevise = new ScriptListeVentesDeviseTradPlatf() ;
				$this->InscritScript("listeVentesDevise", $this->ScriptListeVentesDevise) ;
				$this->ScriptConsultVentesDevise = new ScriptConsultVentesDeviseTradPlatf() ;
				$this->InscritScript("consultVentesDevise", $this->ScriptConsultVentesDevise) ;
				$this->ScriptAjoutVenteDevise = new ScriptAjoutVenteDeviseTradPlatf() ;
				$this->InscritScript("ajoutVenteDevise", $this->ScriptAjoutVenteDevise) ;
				$this->ScriptModifVenteDevise = new ScriptModifVenteDeviseTradPlatf() ;
				$this->InscritScript("modifVenteDevise", $this->ScriptModifVenteDevise) ;
				$this->ScriptSupprVenteDevise = new ScriptSupprVenteDeviseTradPlatf() ;
				$this->InscritScript("supprVenteDevise", $this->ScriptSupprVenteDevise) ;
				$this->ScriptEditVentesDevise = new ScriptEditVentesDeviseTradPlatf() ;
				$this->InscritScript("editVentesDevise", $this->ScriptEditVentesDevise) ;
				$this->ScriptReservVentesDevise = new ScriptReservVentesDeviseTradPlatf() ;
				$this->InscritScript("reservVentesDevise", $this->ScriptReservVentesDevise) ;
				$this->ScriptReponseVenteDevise = new ScriptReponseVenteDeviseTradPlatf() ;
				$this->InscritScript("reponseVenteDevise", $this->ScriptReponseVenteDevise) ;
				$this->ScriptInteretVenteDevise = new ScriptInteretVenteDeviseTradPlatf() ;
				$this->InscritScript("interetVenteDevise", $this->ScriptInteretVenteDevise) ;
				$this->ScriptNegocVenteDevise = new ScriptNegocVenteDeviseTradPlatf() ;
				$this->InscritScript("negocVenteDevise", $this->ScriptNegocVenteDevise) ;
				$this->ScriptAjustVenteDevise = new ScriptAjustVenteDeviseTradPlatf() ;
				$this->InscritScript("ajustVenteDevise", $this->ScriptAjustVenteDevise) ;
				$this->ScriptPostulsVenteDevise = new ScriptPostulsVenteDeviseTradPlatf() ;
				$this->InscritScript("postulsVenteDevise", $this->ScriptPostulsVenteDevise) ;
				$this->ScriptValPostulVenteDevise = new ScriptValPostulVenteDeviseTradPlatf() ;
				$this->InscritScript("valPostulVenteDevise", $this->ScriptValPostulVenteDevise) ;
				$this->ScriptListePlacements = new ScriptListePlacementsTradPlatf() ;
				$this->InscritScript("listePlacements", $this->ScriptListePlacements) ;
				$this->ScriptConsultPlacements = new ScriptConsultPlacementsTradPlatf() ;
				$this->InscritScript("consultPlacements", $this->ScriptConsultPlacements) ;
				$this->ScriptEditPlacements = new ScriptEditPlacementsTradPlatf() ;
				$this->InscritScript("editPlacements", $this->ScriptEditPlacements) ;
				$this->ScriptReservPlacements = new ScriptReservPlacementsTradPlatf() ;
				$this->InscritScript("reservPlacements", $this->ScriptReservPlacements) ;
				$this->ScriptAjoutPlacement = new ScriptAjoutPlacementTradPlatf() ;
				$this->InscritScript("ajoutPlacement", $this->ScriptAjoutPlacement) ;
				$this->ScriptModifPlacement = new ScriptModifPlacementTradPlatf() ;
				$this->InscritScript("modifPlacement", $this->ScriptModifPlacement) ;
				$this->ScriptSupprPlacement = new ScriptSupprPlacementTradPlatf() ;
				$this->InscritScript("supprPlacement", $this->ScriptSupprPlacement) ;
				$this->ScriptPostulsPlacement = new ScriptPostulsPlacementTradPlatf() ;
				$this->InscritScript("postulsPlacement", $this->ScriptPostulsPlacement) ;
				$this->ScriptReponsePlacement = new ScriptReponsePlacementTradPlatf() ;
				$this->InscritScript("reponsePlacement", $this->ScriptReponsePlacement) ;
				$this->ScriptNegocPlacement = new ScriptNegocPlacementTradPlatf() ;
				$this->InscritScript("negocPlacement", $this->ScriptNegocPlacement) ;
				$this->ScriptInteretPlacement = new ScriptInteretPlacementTradPlatf() ;
				$this->InscritScript("interetPlacement", $this->ScriptInteretPlacement) ;
				$this->ScriptAjustPlacement = new ScriptAjustPlacementTradPlatf() ;
				$this->InscritScript("ajustPlacement", $this->ScriptAjustPlacement) ;
				$this->ScriptModifPlacement = new ScriptModifPlacementTradPlatf() ;
				$this->InscritScript("modifPlacement", $this->ScriptModifPlacement) ;
				$this->ScriptSupprPlacement = new ScriptSupprPlacementTradPlatf() ;
				$this->InscritScript("supprPlacement", $this->ScriptSupprPlacement) ;
				$this->ScriptListeEmprunts = new ScriptListeEmpruntsTradPlatf() ;
				$this->InscritScript("listeEmprunts", $this->ScriptListeEmprunts) ;
				$this->ScriptConsultEmprunts = new ScriptConsultEmpruntsTradPlatf() ;
				$this->InscritScript("consultEmprunts", $this->ScriptConsultEmprunts) ;
				$this->ScriptAjoutVenteDevise = new ScriptAjoutVenteDeviseTradPlatf() ;
				$this->InscritScript("ajoutVenteDevise", $this->ScriptAjoutVenteDevise) ;
				$this->ScriptModifVenteDevise = new ScriptModifVenteDeviseTradPlatf() ;
				$this->InscritScript("modifVenteDevise", $this->ScriptModifVenteDevise) ;
				$this->ScriptSupprVenteDevise = new ScriptSupprVenteDeviseTradPlatf() ;
				$this->InscritScript("supprVenteDevise", $this->ScriptSupprVenteDevise) ;
				$this->ScriptSoumissAchatDevise = new ScriptSoumissAchatDeviseTradPlatf() ;
				$this->InscritScript("soumissAchatDevise", $this->ScriptSoumissAchatDevise) ;
				$this->ScriptSoumissVenteDevise = new ScriptSoumissVenteDeviseTradPlatf() ;
				$this->InscritScript("soumissVenteDevise", $this->ScriptSoumissVenteDevise) ;
				$this->ScriptSoumissOpChange = new ScriptSoumissOpChangeTradPlatf() ;
				$this->InscritScript("soumissOpChange", $this->ScriptSoumissOpChange) ;
				$this->ScriptSoumissOpInter = new ScriptSoumissOpInterTradPlatf() ;
				$this->InscritScript("soumissOpInter", $this->ScriptSoumissOpInter) ;
				$this->ScriptEditEmprunts = new ScriptEditEmpruntsTradPlatf() ;
				$this->InscritScript("editEmprunts", $this->ScriptEditEmprunts) ;
				$this->ScriptReservEmprunts = new ScriptReservEmpruntsTradPlatf() ;
				$this->InscritScript("reservEmprunts", $this->ScriptReservEmprunts) ;
				$this->ScriptReponseEmprunt = new ScriptReponseEmpruntTradPlatf() ;
				$this->InscritScript("reponseEmprunt", $this->ScriptReponseEmprunt) ;
				$this->ScriptInteretEmprunt = new ScriptInteretEmpruntTradPlatf() ;
				$this->InscritScript("interetEmprunt", $this->ScriptInteretEmprunt) ;
				$this->ScriptNegocEmprunt = new ScriptNegocEmpruntTradPlatf() ;
				$this->InscritScript("negocEmprunt", $this->ScriptNegocEmprunt) ;
				$this->ScriptAjustEmprunt = new ScriptAjustEmpruntTradPlatf() ;
				$this->InscritScript("ajustEmprunt", $this->ScriptAjustEmprunt) ;
				$this->ScriptPostulsEmprunt = new ScriptPostulsEmpruntTradPlatf() ;
				$this->InscritScript("postulsEmprunt", $this->ScriptPostulsEmprunt) ;
				$this->ScriptValPostulEmprunt = new ScriptValPostulEmpruntTradPlatf() ;
				$this->InscritScript("valPostulEmprunt", $this->ScriptValPostulEmprunt) ;
				$this->ScriptSoumissPlacement = new ScriptSoumissPlacementTradPlatf() ;
				$this->InscritScript("soumissPlacement", $this->ScriptSoumissPlacement) ;
				$this->ScriptSoumissEmprunt = new ScriptSoumissEmpruntTradPlatf() ;
				$this->InscritScript("soumissEmprunt", $this->ScriptSoumissEmprunt) ;
				$this->ScriptSoumissPlacement = new ScriptSoumissPlacementTradPlatf() ;
				$this->InscritScript("soumissPlacement", $this->ScriptSoumissPlacement) ;
				$this->ScriptModifOpChangeSoumis = new ScriptModifOpChangeSoumisTradPlatf() ;
				$this->InscritScript("modifOpChangeSoumis", $this->ScriptModifOpChangeSoumis) ;
				$this->ScriptModifOpInterSoumis = new ScriptModifOpInterSoumisTradPlatf() ;
				$this->InscritScript("modifOpInterSoumis", $this->ScriptModifOpInterSoumis) ;
				$this->ScriptAjoutEmprunt = new ScriptAjoutEmpruntTradPlatf() ;
				$this->InscritScript("ajoutEmprunt", $this->ScriptAjoutEmprunt) ;
				$this->ScriptModifEmprunt = new ScriptModifEmpruntTradPlatf() ;
				$this->InscritScript("modifEmprunt", $this->ScriptModifEmprunt) ;
				$this->ScriptSupprEmprunt = new ScriptSupprEmpruntTradPlatf() ;
				$this->InscritScript("supprEmprunt", $this->ScriptSupprEmprunt) ;
				$this->ScriptPublierEmissBonTresor = $this->InsereScript('publierEmissBonTresor', new ScriptPublierEmissBonTresorTradPlatf()) ;
				$this->ScriptConsultEmissBonTresor = $this->InsereScript('consultEmissBonTresor', new ScriptConsultEmissBonTresorTradPlatf()) ;
				$this->ScriptProposEmissBonTresor = $this->InsereScript('proposEmissBonTresor', new ScriptProposEmissBonTresorTradPlatf()) ;
				$this->ScriptAjoutEmissBonTresor = $this->InsereScript('ajoutEmissBonTresor', new ScriptAjoutEmissBonTresorTradPlatf()) ;
				$this->ScriptModifEmissBonTresor = $this->InsereScript('modifEmissBonTresor', new ScriptModifEmissBonTresorTradPlatf()) ;
				$this->ScriptSupprEmissBonTresor = $this->InsereScript('supprEmissBonTresor', new ScriptSupprEmissBonTresorTradPlatf()) ;
				$this->ScriptDetailProposEmissBonTresor = $this->InsereScript('detailProposEmissBonTresor', new ScriptDetailProposEmissBonTresorTradPlatf()) ;
				$this->ScriptListReservEmissBonTresor = $this->InsereScript('listReservEmissBonTresor', new ScriptListReservEmissBonTresorTradPlatf()) ;
				$this->ScriptAjoutReservEmissBonTresor = $this->InsereScript('ajoutReservEmissBonTresor', new ScriptAjoutReservEmissBonTresorTradPlatf()) ;
				$this->ScriptModifReservEmissBonTresor = $this->InsereScript('modifReservEmissBonTresor', new ScriptModifReservEmissBonTresorTradPlatf()) ;
				$this->ScriptSupprReservEmissBonTresor = $this->InsereScript('supprReservEmissBonTresor', new ScriptSupprReservEmissBonTresorTradPlatf()) ;
				$this->ScriptDetailReservEmissBonTresor = $this->InsereScript('detailReservEmissBonTresor', new ScriptDetailReservEmissBonTresorTradPlatf()) ;
				$this->ScriptPublierEmissObligation = $this->InsereScript('publierEmissObligation', new ScriptPublierEmissObligationTradPlatf()) ;
				$this->ScriptConsultEmissObligation = $this->InsereScript('consultEmissObligation', new ScriptConsultEmissObligationTradPlatf()) ;
				$this->ScriptProposEmissObligation = $this->InsereScript('proposEmissObligation', new ScriptProposEmissObligationTradPlatf()) ;
				$this->ScriptAjoutEmissObligation = $this->InsereScript('ajoutEmissObligation', new ScriptAjoutEmissObligationTradPlatf()) ;
				$this->ScriptModifEmissObligation = $this->InsereScript('modifEmissObligation', new ScriptModifEmissObligationTradPlatf()) ;
				$this->ScriptSupprEmissObligation = $this->InsereScript('supprEmissObligation', new ScriptSupprEmissObligationTradPlatf()) ;
				$this->ScriptDetailProposEmissObligation = $this->InsereScript('detailProposEmissObligation', new ScriptDetailProposEmissObligationTradPlatf()) ;
				$this->ScriptListReservEmissObligation = $this->InsereScript('listReservEmissObligation', new ScriptListReservEmissObligationTradPlatf()) ;
				$this->ScriptAjoutReservEmissObligation = $this->InsereScript('ajoutReservEmissObligation', new ScriptAjoutReservEmissObligationTradPlatf()) ;
				$this->ScriptModifReservEmissObligation = $this->InsereScript('modifReservEmissObligation', new ScriptModifReservEmissObligationTradPlatf()) ;
				$this->ScriptSupprReservEmissObligation = $this->InsereScript('supprReservEmissObligation', new ScriptSupprReservEmissObligationTradPlatf()) ;
				$this->ScriptDetailReservEmissObligation = $this->InsereScript('detailReservEmissObligation', new ScriptDetailReservEmissObligationTradPlatf()) ;
				// Cotation transf devise
				$this->ScriptPublierCotationTransfDev = $this->InsereScript('publierCotationTransfDev', new ScriptPublierCotationTransfDevTradPlatf()) ;
				$this->ScriptConsultCotationTransfDev = $this->InsereScript('consultCotationTransfDev', new ScriptConsultCotationTransfDevTradPlatf()) ;
				$this->ScriptProposCotationTransfDev = $this->InsereScript('proposCotationTransfDev', new ScriptProposCotationTransfDevTradPlatf()) ;
				$this->ScriptAjoutCotationTransfDev = $this->InsereScript('ajoutCotationTransfDev', new ScriptAjoutCotationTransfDevTradPlatf()) ;
				$this->ScriptModifCotationTransfDev = $this->InsereScript('modifCotationTransfDev', new ScriptModifCotationTransfDevTradPlatf()) ;
				$this->ScriptSupprCotationTransfDev = $this->InsereScript('supprCotationTransfDev', new ScriptSupprCotationTransfDevTradPlatf()) ;
				$this->ScriptDetailProposCotationTransfDev = $this->InsereScript('detailProposCotationTransfDev', new ScriptDetailProposCotationTransfDevTradPlatf()) ;
				$this->ScriptListReservCotationTransfDev = $this->InsereScript('listReservCotationTransfDev', new ScriptListReservCotationTransfDevTradPlatf()) ;
				$this->ScriptAjoutReservCotationTransfDev = $this->InsereScript('ajoutReservCotationTransfDev', new ScriptAjoutReservCotationTransfDevTradPlatf()) ;
				$this->ScriptModifReservCotationTransfDev = $this->InsereScript('modifReservCotationTransfDev', new ScriptModifReservCotationTransfDevTradPlatf()) ;
				$this->ScriptSupprReservCotationTransfDev = $this->InsereScript('supprReservCotationTransfDev', new ScriptSupprReservCotationTransfDevTradPlatf()) ;
				$this->ScriptDetailReservCotationTransfDev = $this->InsereScript('detailReservCotationTransfDev', new ScriptDetailReservCotationTransfDevTradPlatf()) ;
				// Cotation depot terme
				$this->ScriptPublierCotationDepotTerme = $this->InsereScript('publierCotationDepotTerme', new ScriptPublierCotationDepotTermeTradPlatf()) ;
				$this->ScriptConsultCotationDepotTerme = $this->InsereScript('consultCotationDepotTerme', new ScriptConsultCotationDepotTermeTradPlatf()) ;
				$this->ScriptProposCotationDepotTerme = $this->InsereScript('proposCotationDepotTerme', new ScriptProposCotationDepotTermeTradPlatf()) ;
				$this->ScriptAjoutCotationDepotTerme = $this->InsereScript('ajoutCotationDepotTerme', new ScriptAjoutCotationDepotTermeTradPlatf()) ;
				$this->ScriptModifCotationDepotTerme = $this->InsereScript('modifCotationDepotTerme', new ScriptModifCotationDepotTermeTradPlatf()) ;
				$this->ScriptSupprCotationDepotTerme = $this->InsereScript('supprCotationDepotTerme', new ScriptSupprCotationDepotTermeTradPlatf()) ;
				$this->ScriptDetailProposCotationDepotTerme = $this->InsereScript('detailProposCotationDepotTerme', new ScriptDetailProposCotationDepotTermeTradPlatf()) ;
				$this->ScriptListReservCotationDepotTerme = $this->InsereScript('listReservCotationDepotTerme', new ScriptListReservCotationDepotTermeTradPlatf()) ;
				$this->ScriptAjoutReservCotationDepotTerme = $this->InsereScript('ajoutReservCotationDepotTerme', new ScriptAjoutReservCotationDepotTermeTradPlatf()) ;
				$this->ScriptModifReservCotationDepotTerme = $this->InsereScript('modifReservCotationDepotTerme', new ScriptModifReservCotationDepotTermeTradPlatf()) ;
				$this->ScriptSupprReservCotationDepotTerme = $this->InsereScript('supprReservCotationDepotTerme', new ScriptSupprReservCotationDepotTermeTradPlatf()) ;
				$this->ScriptDetailReservCotationDepotTerme = $this->InsereScript('detailReservCotationDepotTerme', new ScriptDetailReservCotationDepotTermeTradPlatf()) ;
				// $this->ScriptBienvenue->Titre = "Trading Platform" ;
				$this->ScriptAccueil->TitreDocument = "Trading Platform" ;
				// $this->ChargeScriptsMembershipSuppl() ;
			}
			protected function ChargeScriptsMembership()
			{
				parent::ChargeScriptsMembership() ;
				if($this->PossedeMembreConnecte())
				{
					$privsEditMembership = array("admin_members") ;
					$this->ScriptListeProfils->DeclarePrivileges($privsEditMembership) ;
					$this->ScriptAjoutProfil->DeclarePrivileges($privsEditMembership) ;
					$this->ScriptListeRoles->DeclarePrivileges($privsEditMembership) ;
					$this->ScriptAjoutRole->DeclarePrivileges($privsEditMembership) ;
				}
				// print get_class($this->ScriptListeProfils) ;
			}
			protected function ObtientContenuCSSNonConnecte()
			{
				$ctn = parent::ObtientContenuCSSNonConnecte().PHP_EOL ;
				$ctn .= '#espaceTravail {
	background-image:url(images/pied-accueil.png) ;
	background-repeat:no-repeat;
	padding-top:72px ;
	background-position: center top ;
}' ;
				return $ctn ;
			}
			protected function ObtientContenuCSSScript()
			{
				$ctn = parent::ObtientContenuCSSScript().PHP_EOL ;
				$ctn .= '	.LiensRangee a:link { color : white; }
	.lien-act-001 { background-image:url(images/bg-lien-01.png) ; }
	.lien-act-002 { background-image:url(images/bg-lien-02.png) ; }
	.lien-act-003 { background-image:url(images/bg-lien-03.png) ; }
	.lien-act-004 { background-image:url(images/bg-lien-04.png) ; }
	.lien-act-005 { background-image:url(images/bg-lien-05.png) ; }
	.lien-act-001, .lien-act-002, .lien-act-003, .lien-act-004, .lien-act-005 { background-position: top center ; background-repeat:no-repeat; padding : 6px; padding-left:20px; padding-right:20px; text-decoration:none ; }
	.lien-act-001:link, .lien-act-002:link, .lien-act-003:link, .lien-act-004:link, .lien-act-005:link, .lien-act-001:visited, .lien-act-002:visited, .lien-act-003:visited, .lien-act-004:visited, .lien-act-005:visited { color:white ; }
	.lien-act-001:hover, .lien-act-002:hover, .lien-act-003:hover, .lien-act-004:hover { color:#ededed ; }' ;
				return $ctn ;
			}
			protected function RenduCorpsDocumentNonConnecte()
			{
				$ctn = '' ;
				$ctn .= '<script type="text/javascript">
	jQuery(function() {
		if(window.top != window)
		{
			window.top.location.href = window.location ;
		}
	}) ;
</script>' ;
				$ctn .= '<body id="corps_document">' ;
				$ctn .= '<div align="center"><img src="images/logo-accueil.png" width="375" /></div>'.PHP_EOL ;
				if($this->ScriptPourRendu->NomElementZone == $this->NomScriptDeconnexion)
				{
					$ctn .= '<table id="espaceTravail" cellspacing="0" cellpadding="0" align="center">
	<tr>
	<td align="center">' ;
					$ctn .= $this->RenduContenuCorpsDocument() ;
					$ctn .= '</td>
	</tr>
</table>' ;
				}
				else
				{
					$ctn .= '<table id="espaceTravail" cellspacing="0" cellpadding="0" align="center">
	<tr>
	<td align="center">' ;
					$ctn .= '<p><a href="javascript:ouvreFenetreConnexion() ;"><img src="images/btn-acces-platf.png" border="0" width="250" /></a></p>
	</td>
	</tr>
	</table>'.PHP_EOL ;
					$ctn .= '<div id="fenetreConnexion" title="Authentification">
		<form id="formulaireConnexion" action="'.$this->ScriptConnexion->ObtientUrl().'" method="post">' ;
					if($this->ScriptConnexion->TentativeConnexionEnCours && $this->ScriptConnexion->TentativeConnexionValidee == 0)
					{
						$ctn .= '<div class="erreur ui-state-error">'.$this->ScriptConnexion->MessageConnexionEchouee.'</div>'.PHP_EOL ;
					}
					$ctn .= $this->ScriptConnexion->RenduTableauParametres().'
		</form>
	</div>'.PHP_EOL ;
				}
				$ctn .= '<div id="pied">'.$this->ContenuPiedDocument.'</div>'.PHP_EOL ;
				$ctn .= '</body>' ;
				return $ctn ;
			}
			protected function RenduCorpsDocumentParDefaut()
			{
				$ctn = parent::RenduCorpsDocumentParDefaut() ;
				$ctn .= '<script src="js/jquery.backstretch.js" type="text/javascript"></script>
<script type="text/javascript">
	jQuery.backstretch(["images/bg-body.png"]);
</script>' ;
				$ctn .= '<style type="text/css">
	body { margin:0px; padding:0px ; }
	#entete, #pied { background : white; color:#016095 ; }
	#entete { margin-bottom:10px ; }
	#pied { margin-top:10px ; }
	.btn-princ { background-image:url(images/btn-princ-moyen.png) ; background-repeat:no-repeat ; background-position:center top ; width : 140px ; height:22px; color:white ; padding-top : 4px; }
</style>' ;
				return $ctn ;
			}
		}
		
		class RemplisseurConfigPublTradPlatf
		{
			public $FltIdEntiteEnCours ;
			public $FltCodeEntite ;
			public $FltSwiftRegEntite ;
			public $FltNomCourtEntite ;
			public $FltNomEntite ;
			public $FltNomCompteEntite ;
			public $FltAdrPostEntite ;
			public $FltTelEntite ;
			public $FltFaxEntite ;
			public $FltRegistrCommEntite ;
			public $FltTypeEntite ;
			public $FltPaysEntite ;
			public $FltIdTypeEntiteEnCours ;
			public $FltLibTypeEntite ;
			public $FltIdDeviseEnCours ;
			public $FltCodeDevise ;
			public $FltLibDevise ;
			public $FltIdPaysEnCours ;
			public $FltCodePays ;
			public $FltLibPays ;
			public $FltIdZonePaysEnCours ;
			public $FltLibZonePays ;
			public $CritereTypeDeviseNonVide ;
			public $CritereDeviseNonVide ;
			public $CritereDeviseUnique ;
			protected function CorrigeIdTypeEntite($idTypeEntite, & $form)
			{
				$idTypeEntite = intval($idTypeEntite) ;
				$bd = & $form->ApplicationParent->BDPrincipale ;
				$lig = $bd->FetchSqlRow('select * from type_entite where idtype_entite='.$bd->ParamPrefix.'idTypeEntite', array('idTypeEntite' => $idTypeEntite)) ;
				$id = 1 ;
				if(count($lig))
				{
					$id = $lig['idtype_entite'] ;
				}
				return $id ;
			}
			public function ObtientTypeTaux($ligne)
			{
				$typeTaux = ($ligne["commiss_ou_taux"] == 0) ? 0 : (($ligne["type_taux"] == 0) ? 1 : 2) ;
				return $typeTaux ;
			}
			public function ObtientValeurTaux($ligne)
			{
				$valTaux = ($ligne["commiss_ou_taux"] == 0) ? $ligne["mtt_commiss"] : (($ligne["type_taux"] == 0) ? $ligne["taux_change"] : $ligne["ecran_taux"]) ;
				return $valTaux ;
			}
			public function AppliqueCompComissOuTaux(& $filtre, $ligne=array(), $renseigneDefaut=1, $changeParam=0)
			{
				$typeTaux = $this->ObtientTypeTaux($ligne) ;
				// print "Type taux : ".$typeTaux ;
				if($renseigneDefaut)
				{
					$valTaux = $this->ObtientTypeTaux($ligne) ;
					$filtre->ValeurParDefaut = $valTaux ;
				}
				switch($typeTaux)
				{
					case 0 : { $this->AppliqueCompMttComiss($filtre) ; if($changeParam) { $filtre->DefinitColLiee('mtt_commiss') ; } } break ;
					case 1 : { $this->AppliqueCompValeurTaux($filtre) ;if($changeParam) { $filtre->DefinitColLiee('taux_change') ; } } break ;
					case 2 : { $this->AppliqueCompEcranTaux($filtre) ; if($changeParam) { $filtre->DefinitColLiee('ecran_taux') ; } } break ;
				}
			}
			public function AppliqueCompMttComiss(& $filtre)
			{
			}
			public function AppliqueCompValeurTaux(& $filtre)
			{
				$filtre->DeclareComposant("PvZoneTexteHtml") ;
			}
			public function AppliqueCompEcranTaux(& $filtre)
			{
				$valBase = 5 ;
				if($filtre->ValeurParDefaut == '')
					$filtre->ValeurParDefaut = 5 ;
				$filtre->DeclareComposant("PvZoneBoiteSelectHtml") ;
				$comp1 = & $filtre->Composant ;
				$comp1->NomColonneLibelle = "val" ;
				$comp1->NomColonneValeur = "val" ;
				$comp1->FournisseurDonnees = new PvFournisseurDonneesDirect() ;
				$comp1->FournisseurDonnees->Valeurs["req"] = array() ;
				for($i=1; $i<= 10; $i++)
				{
					$comp1->FournisseurDonnees->Valeurs["req"][] = array('val' => $i) ;
				}
				
			}
			public function AppliqueFormTypeEntite(& $form)
			{
				$form->RemplaceCommandeAnnuler("PvCmdFermeFenetreActiveAdminDirecte") ;
				$form->FournisseurDonnees = new PvFournisseurDonneesSql() ;
				$form->FournisseurDonnees->BaseDonnees = $form->ApplicationParent->BDPrincipale ;
				$form->FournisseurDonnees->RequeteSelection = "type_entite" ;
				$form->FournisseurDonnees->TableEdition = "type_entite" ;
				$this->FltIdTypeEntiteEnCours = $form->InsereFltLgSelectHttpGet("idEnCours", 'idtype_entite = <self>') ;
				$this->FltLibTypeEntite = $form->InsereFltEditHttpPost("lib_type_entite", 'lib_type_entite') ;
				$this->FltLibTypeEntite->Libelle = "Libelle" ;
				$this->FltLibTypeEntite->Obligatoire = 1 ;
				$this->CritereTypeDeviseNonVide = $form->CommandeExecuter->InsereNouvCritere(new PvCritereNonVide(), array('lib_type_entite')) ;
			}
			public function AppliqueFormDevise(& $form)
			{
				$form->RemplaceCommandeAnnuler("PvCmdFermeFenetreActiveAdminDirecte") ;
				$form->FournisseurDonnees = new PvFournisseurDonneesSql() ;
				$form->FournisseurDonnees->BaseDonnees = $form->ApplicationParent->BDPrincipale ;
				$form->FournisseurDonnees->RequeteSelection = "devise" ;
				$form->FournisseurDonnees->TableEdition = "devise" ;
				$this->FltIdDeviseEnCours = $form->InsereFltLgSelectHttpGet("idEnCours", 'id_devise = <self>') ;
				$this->FltCodeDevise = $form->InsereFltEditHttpPost("code_devise", 'code_devise') ;
				$this->FltCodeDevise->Libelle = "Code" ;
				$this->FltLibDevise = $form->InsereFltEditHttpPost("lib_devise", 'lib_devise') ;
				$this->FltLibDevise->Libelle = "Libelle" ;
				$comp = $this->FltLibDevise->DeclareComposant("PvZoneTexteHtml") ;
				$comp->Largeur = "200px" ;
				if($form->Editable == 1)
				{
					$this->CritereDeviseNonVide = $form->CommandeExecuter->InsereNouvCritere(new PvCritereNonVide(), array('code_devise', 'lib_devise')) ;
					$this->CritereDeviseUnique = $form->CommandeExecuter->InsereNouvCritere(new CritereDeviseUnique()) ;
				}
			}
			public function AppliqueFormPays(& $form)
			{
				$form->RemplaceCommandeAnnuler("PvCmdFermeFenetreActiveAdminDirecte") ;
				$form->FournisseurDonnees = new PvFournisseurDonneesSql() ;
				$form->FournisseurDonnees->BaseDonnees = $form->ApplicationParent->BDPrincipale ;
				$form->FournisseurDonnees->RequeteSelection = "pays" ;
				$form->FournisseurDonnees->TableEdition = "pays" ;
				$this->FltIdPaysEnCours = $form->InsereFltLgSelectHttpGet("idEnCours", 'idpays = <self>') ;
				$this->FltCodePays = $form->InsereFltEditHttpPost("code_pays", 'codepays') ;
				$this->FltCodePays->Libelle = "Code" ;
				$this->FltLibPays = $form->InsereFltEditHttpPost("lib_pays", 'libpays') ;
				$this->FltLibPays->Libelle = "Libelle" ;
				$this->FltZonePays = $form->InsereFltEditHttpPost("id_region") ;
				$this->FltZonePays->Libelle = "Zone" ;
				$this->FltZonePays->NomParametreDonnees = "id_region" ;
				$this->FltZonePays->NomColonneLiee = "id_region" ;
				$this->AppliqueCompListeZonePays($this->FltZonePays, 0) ;
				if($form->Editable == 1)
				{
					$this->CriterePaysNonVide = $form->CommandeExecuter->InsereNouvCritere(new PvCritereNonVide(), array('code_pays', 'lib_pays')) ;
					$this->CriterePaysUnique = $form->CommandeExecuter->InsereNouvCritere(new CriterePaysUnique()) ;
				}
			}
			public function AppliqueFormZonePays(& $form)
			{
				$form->RemplaceCommandeAnnuler("PvCmdFermeFenetreActiveAdminDirecte") ;
				$form->FournisseurDonnees = new PvFournisseurDonneesSql() ;
				$form->FournisseurDonnees->BaseDonnees = $form->ApplicationParent->BDPrincipale ;
				$form->FournisseurDonnees->RequeteSelection = "region_pays" ;
				$form->FournisseurDonnees->TableEdition = "region_pays" ;
				$this->FltIdZonePaysEnCours = $form->InsereFltLgSelectHttpGet("idEnCours", 'id = <self>') ;
				$this->FltLibZonePays = $form->InsereFltEditHttpPost("libelle", 'libelle') ;
				$this->FltLibZonePays->Libelle = "Libelle" ;
				if($form->Editable == 1)
				{
					$this->CritereZonePaysNonVide = $form->CommandeExecuter->InsereNouvCritere(new PvCritereNonVide(), array('libelle')) ;
					$this->CritereZonePaysUnique = $form->CommandeExecuter->InsereNouvCritere(new CritereZonePaysUnique()) ;
				}
			}
			public function AppliqueFormEntite(& $form)
			{
				$form->RemplaceCommandeAnnuler("PvCmdFermeFenetreActiveAdminDirecte") ;
				$this->FltIdEntiteEnCours = $form->ScriptParent->CreeFiltreHttpGet("idEnCours") ;
				$this->FltIdEntiteEnCours->ExpressionDonnees = "id_entite = <self>" ;
				$form->FiltresLigneSelection[] = & $this->FltIdEntiteEnCours ;
				$this->FltCodeEntite = $form->ScriptParent->CreeFiltreHttpPost("code") ;
				$this->FltCodeEntite->Libelle = "Code" ;
				$this->FltCodeEntite->NomParametreDonnees = "code" ;
				$this->FltCodeEntite->NomColonneLiee = "code" ;
				$form->FiltresEdition[] = & $this->FltCodeEntite ;
				$this->FltSwiftRegEntite = $form->ScriptParent->CreeFiltreHttpPost("swiftreg") ;
				$this->FltSwiftRegEntite->Libelle = "Swift Reg" ;
				$this->FltSwiftRegEntite->NomParametreDonnees = "swiftreg" ;
				$this->FltSwiftRegEntite->NomColonneLiee = "swiftreg" ;
				$form->FiltresEdition[] = & $this->FltSwiftRegEntite ;
				$this->FltNomCourtEntite = $form->ScriptParent->CreeFiltreHttpPost("shortname") ;
				$this->FltNomCourtEntite->Libelle = "Abr&eacute;viation" ;
				$this->FltNomCourtEntite->NomParametreDonnees = "shortname" ;
				$this->FltNomCourtEntite->NomColonneLiee = "shortname" ;
				$form->FiltresEdition[] = & $this->FltNomCourtEntite ;
				$this->FltNomCompteEntite = $form->ScriptParent->CreeFiltreHttpPost("accountcode") ;
				$this->FltNomCompteEntite->Libelle = "Code Compte" ;
				$this->FltNomCompteEntite->NomParametreDonnees = "accountcode" ;
				$this->FltNomCompteEntite->NomColonneLiee = "accountcode" ;
				$form->FiltresEdition[] = & $this->FltNomCompteEntite ;
				$this->FltNomEntite = $form->ScriptParent->CreeFiltreHttpPost("name") ;
				$this->FltNomEntite->Libelle = "Nom" ;
				$this->FltNomEntite->NomParametreDonnees = "name" ;
				$this->FltNomEntite->NomColonneLiee = "name" ;
				$form->FiltresEdition[] = & $this->FltNomEntite ;
				$this->FltRegistrCommEntite = $form->ScriptParent->CreeFiltreHttpPost("registcomm") ;
				$this->FltRegistrCommEntite->Libelle = "RC" ;
				$this->FltRegistrCommEntite->NomParametreDonnees = "registcomm" ;
				$this->FltRegistrCommEntite->NomColonneLiee = "registcomm" ;
				$form->FiltresEdition[] = & $this->FltRegistrCommEntite ;
				$this->FltTelEntite = $form->ScriptParent->CreeFiltreHttpPost("Tel") ;
				$this->FltTelEntite->NomParametreDonnees = "Tel" ;
				$this->FltTelEntite->NomColonneLiee = "Tel" ;
				$form->FiltresEdition[] = & $this->FltTelEntite ;
				$this->FltFaxEntite = $form->ScriptParent->CreeFiltreHttpPost("fax") ;
				$this->FltFaxEntite->Libelle = "Fax" ;
				$this->FltFaxEntite->NomParametreDonnees = "fax" ;
				$this->FltFaxEntite->NomColonneLiee = "fax" ;
				$form->FiltresEdition[] = & $this->FltFaxEntite ;
				$this->FltAdrPostEntite = $form->ScriptParent->CreeFiltreHttpPost("adresspost") ;
				$this->FltAdrPostEntite->Libelle = "Adresse Postale" ;
				$this->FltAdrPostEntite->NomParametreDonnees = "adresspost" ;
				$this->FltAdrPostEntite->NomColonneLiee = "adresspost" ;
				$form->FiltresEdition[] = & $this->FltAdrPostEntite ;
				if($form->ScriptParent->InclureChoixTypeEntite || $form->ZoneParent->PossedePrivilege('admin_members'))
				{
					$this->FltTypeEntite = $form->ScriptParent->CreeFiltreHttpPost("idtype_entite") ;
					$this->FltTypeEntite->Libelle = "Type entit&eacute;" ;
					$this->FltTypeEntite->DeclareComposant("PvZoneBoiteSelectHtml") ;
					$comp = & $this->FltTypeEntite->Composant ;
					$comp->FournisseurDonnees = new PvFournisseurDonneesSql() ;
					$comp->FournisseurDonnees->BaseDonnees = & $form->ApplicationParent->BDPrincipale ;
					$comp->FournisseurDonnees->RequeteSelection = "type_entite" ;
					$comp->NomColonneValeur = "idtype_entite" ;
					$comp->NomColonneLibelle = "lib_type_entite" ;
				}
				else
				{
					$this->FltTypeEntite = $form->ScriptParent->CreeFiltreHttpGet("idTypeEntite", $form->ScriptParent->IdTypeEntiteParDefaut) ;
					$this->FltTypeEntite->LectureSeule = 1 ;
					$this->FltTypeEntite->Lie() ;
					if(! $form->ScriptParent->PourLigneEntite)
					{
						$this->FltTypeEntite->ValeurParametre = $this->CorrigeIdTypeEntite($this->FltTypeEntite->ValeurParametre, $form) ;
					}
				}
				$this->FltTypeEntite->NomParametreDonnees = "idtype_entite" ;
				$this->FltTypeEntite->NomColonneLiee = "idtype_entite" ;
				$form->FiltresEdition[] = & $this->FltTypeEntite ;
				$this->FltPaysEntite = $form->ScriptParent->CreeFiltreHttpPost("idpays") ;
				$this->FltPaysEntite->Libelle = "Pays" ;
				$this->FltPaysEntite->NomParametreDonnees = "idpays" ;
				$this->FltPaysEntite->NomColonneLiee = "idpays" ;
				$this->FltPaysEntite->DeclareComposant("PvZoneBoiteSelectHtml") ;
				$comp = & $this->FltPaysEntite->Composant ;
				$comp->FournisseurDonnees = new PvFournisseurDonneesSql() ;
				$comp->FournisseurDonnees->BaseDonnees = & $form->ApplicationParent->BDPrincipale ;
				$comp->FournisseurDonnees->RequeteSelection = "pays" ;
				$comp->NomColonneValeur = "idpays" ;
				$comp->NomColonneLibelle = "libpays" ;
				$form->FiltresEdition[] = & $this->FltPaysEntite ;
				$form->InscrireCommandeExecuter = 1 ;
				$form->InscrireCommandeAnnuler = 1 ;
				$form->NomClasseCommandeAnnuler = "PvCmdFermeFenetreActiveAdminDirecte" ;
				$form->ChargeConfig() ;
				$form->FournisseurDonnees = new PvFournisseurDonneesSql() ;
				$form->FournisseurDonnees->BaseDonnees = & $form->ApplicationParent->BDPrincipale ;
				$form->FournisseurDonnees->RequeteSelection = TXT_SQL_SELECT_ENTITE_TRAD_PLATF ;
				$form->FournisseurDonnees->TableEdition = "entite" ;
				if($form->Editable == 1)
				{
					$this->CritereEntiteNonVide = $form->CommandeExecuter->InsereNouvCritere(new PvCritereNonVide(), array('code', 'name')) ;
					$this->CritereEntiteUnique = $form->CommandeExecuter->InsereNouvCritere(new CritereEntiteUnique()) ;
				}
			}
			public function AppliqueSommEntite(& $form)
			{
				$form->Editable = 0 ;
				$this->FltIdEntiteEnCours = $form->ScriptParent->CreeFiltreHttpGet("idEnCours") ;
				$this->FltIdEntiteEnCours->ExpressionDonnees = "id_entite = <self>" ;
				$form->FiltresLigneSelection[] = & $this->FltIdEntiteEnCours ;
				$this->FltCodeEntite = $form->ScriptParent->CreeFiltreHttpPost("code") ;
				$this->FltCodeEntite->Libelle = "Code" ;
				$this->FltCodeEntite->NomParametreDonnees = "code" ;
				$this->FltCodeEntite->NomColonneLiee = "code" ;
				$form->FiltresEdition[] = & $this->FltCodeEntite ;
				$this->FltNomCompteEntite = $form->ScriptParent->CreeFiltreHttpPost("accountcode") ;
				$this->FltNomCompteEntite->Libelle = "Code Compte" ;
				$this->FltNomCompteEntite->NomParametreDonnees = "accountcode" ;
				$this->FltNomCompteEntite->NomColonneLiee = "accountcode" ;
				$form->FiltresEdition[] = & $this->FltNomCompteEntite ;
				$this->FltNomEntite = $form->ScriptParent->CreeFiltreHttpPost("name") ;
				$this->FltNomEntite->Libelle = "Nom" ;
				$this->FltNomEntite->NomParametreDonnees = "name" ;
				$this->FltNomEntite->NomColonneLiee = "name" ;
				$form->FiltresEdition[] = & $this->FltNomEntite ;
				$this->FltTypeEntite = $form->ScriptParent->CreeFiltreHttpPost("type_entite") ;
				$this->FltTypeEntite->Libelle = "Type entit&eacute;" ;
				$this->FltTypeEntite->NomParametreDonnees = "nom_type_entite" ;
				$form->FiltresEdition[] = & $this->FltTypeEntite ;
				$this->FltPaysEntite = $form->ScriptParent->CreeFiltreHttpPost("idpays") ;
				$this->FltPaysEntite->Libelle = "Pays" ;
				$this->FltPaysEntite->NomParametreDonnees = "nom_pays" ;
				$form->FiltresEdition[] = & $this->FltPaysEntite ;
				$form->InscrireCommandeExecuter = 0 ;
				$form->InscrireCommandeAnnuler = 0 ;
				$form->NomClasseCommandeAnnuler = "PvCmdFermeFenetreActiveAdminDirecte" ;
				$form->ChargeConfig() ;
				$form->FournisseurDonnees = new PvFournisseurDonneesSql() ;
				$form->FournisseurDonnees->BaseDonnees = & $form->ApplicationParent->BDPrincipale ;
				$form->FournisseurDonnees->RequeteSelection = TXT_SQL_SELECT_ENTITE_TRAD_PLATF ;
				$form->DessinateurFiltresEdition = new PvDessinateurRenduHtmlFiltresDonnees() ;
				$form->DessinateurFiltresEdition->MaxFiltresParLigne = 1 ;
			}
			public function AppliqueCompListeTypeEntite(& $flt)
			{
				$flt->DeclareComposant('PvZoneBoiteSelectHtml') ;
				$composant = & $flt->Composant ;
				$composant->FournisseurDonnees = new PvFournisseurDonneesSql() ;
				$composant->FournisseurDonnees->BaseDonnees = $flt->ApplicationParent->BDPrincipale ;
				$composant->FournisseurDonnees->RequeteSelection = "type_entite" ;
				$composant->NomColonneLibelle = "lib_type_entite" ;
				$composant->NomColonneValeur = "idtype_entite" ;
				$composant->InclureElementHorsLigne = 1 ;
			}
			public function AppliqueCompListePays(& $flt)
			{
				$flt->DeclareComposant('PvZoneBoiteSelectHtml') ;
				$composant = & $flt->Composant ;
				$composant->FournisseurDonnees = new PvFournisseurDonneesSql() ;
				$composant->FournisseurDonnees->BaseDonnees = $flt->ApplicationParent->BDPrincipale ;
				$composant->FournisseurDonnees->RequeteSelection = "pays" ;
				$composant->NomColonneLibelle = "libpays" ;
				$composant->NomColonneValeur = "idpays" ;
				$composant->InclureElementHorsLigne = 1 ;
			}
			public function AppliqueCompListeZonePays(& $flt, $incElemHorsLigne=1)
			{
				$flt->DeclareComposant('PvZoneBoiteSelectHtml') ;
				$composant = & $flt->Composant ;
				$composant->FournisseurDonnees = new PvFournisseurDonneesSql() ;
				$composant->FournisseurDonnees->BaseDonnees = $flt->ApplicationParent->BDPrincipale ;
				$composant->FournisseurDonnees->RequeteSelection = "region_pays" ;
				$composant->NomColonneLibelle = "libelle" ;
				$composant->NomColonneValeur = "id" ;
				$composant->InclureElementHorsLigne = $incElemHorsLigne ;
			}
		}
		
		class CritereDeviseUnique extends PvCritereBase
		{
			public $FormatMessageErreur = 'Il existe une devise avec le même code ou le même libelle' ;
			public function EstRespecte()
			{
				$bd = $this->FormulaireDonneesParent->ApplicationParent->BDPrincipale ;
				$ligneSimil = $bd->FetchSqlRow(
					'select * from devise where (code_devise = '.$bd->ParamPrefix.'code_devise or lib_devise='.$bd->ParamPrefix.'lib_devise) and id_devise <> '.$bd->ParamPrefix.'id_devise',
					array(
						'id_devise' => $this->ZoneParent->RemplisseurConfig->FltIdDeviseEnCours->Lie(),
						'code_devise' => $this->ZoneParent->RemplisseurConfig->FltCodeDevise->Lie(),
						'lib_devise' => $this->ZoneParent->RemplisseurConfig->FltLibDevise->Lie(),
					)
				) ;
				if(! is_array($ligneSimil) || count($ligneSimil) > 0)
				{
					$this->MessageErreur = $this->FormatMessageErreur ;
					return 0 ;
				}
				return 1 ;
			}
		}
		class CriterePaysUnique extends PvCritereBase
		{
			public $FormatMessageErreur = 'Il existe une pays avec le même code ou le même libelle' ;
			public function EstRespecte()
			{
				$bd = $this->FormulaireDonneesParent->ApplicationParent->BDPrincipale ;
				$ligneSimil = $bd->FetchSqlRow(
					'select * from pays where (codepays = '.$bd->ParamPrefix.'code_pays or libpays='.$bd->ParamPrefix.'lib_pays) and idpays <> '.$bd->ParamPrefix.'id_pays',
					array(
						'id_pays' => $this->ZoneParent->RemplisseurConfig->FltIdPaysEnCours->Lie(),
						'code_pays' => $this->ZoneParent->RemplisseurConfig->FltCodePays->Lie(),
						'lib_pays' => $this->ZoneParent->RemplisseurConfig->FltLibPays->Lie(),
					)
				) ;
				if(! is_array($ligneSimil) || count($ligneSimil))
				{
					$this->MessageErreur = $this->FormatMessageErreur ;
					return 0 ;
				}
				return 1 ;
			}
		}
		class CritereEntiteUnique extends PvCritereBase
		{
			public $FormatMessageErreur = 'Il existe une entite avec le même code ou le même nom' ;
			public function EstRespecte()
			{
				$bd = $this->FormulaireDonneesParent->ApplicationParent->BDPrincipale ;
				$ligneSimil = $bd->FetchSqlRow(
					'select * from entite where (code = '.$bd->ParamPrefix.'code_entite or name='.$bd->ParamPrefix.'nom_entite) and id_entite <> '.$bd->ParamPrefix.'id_entite',
					array(
						'id_entite' => $this->ZoneParent->RemplisseurConfig->FltIdEntiteEnCours->Lie(),
						'code_entite' => $this->ZoneParent->RemplisseurConfig->FltCodeEntite->Lie(),
						'nom_entite' => $this->ZoneParent->RemplisseurConfig->FltNomEntite->Lie(),
					)
				) ;
				if(! is_array($ligneSimil) || count($ligneSimil) > 0)
				{
					$this->MessageErreur = $this->FormatMessageErreur ;
					return 0 ;
				}
				return 1 ;
			}
		}
		class CritereZonePaysUnique extends PvCritereBase
		{
			public $FormatMessageErreur = 'Il existe une region avec le m&ecirc;me libell&eacute;' ;
			public function EstRespecte()
			{
				$bd = $this->FormulaireDonneesParent->ApplicationParent->BDPrincipale ;
				$ligneSimil = $bd->FetchSqlRow(
					'select * from region_pays where (upper(libelle) = upper('.$bd->ParamPrefix.'libelle)) and id <> '.$bd->ParamPrefix.'id',
					array(
						'id' => $this->ZoneParent->RemplisseurConfig->FltIdZonePaysEnCours->Lie(),
						'libelle' => $this->ZoneParent->RemplisseurConfig->FltLibZonePays->Lie()
					)
				) ;
				if(! is_array($ligneSimil) || count($ligneSimil) > 0)
				{
					$this->MessageErreur = $this->FormatMessageErreur ;
					return 0 ;
				}
				return 1 ;
			}
		}
		
		class ScriptAccueilPublTradPlatf extends PvScriptWebSimple
		{
			public $Titre = 'Bienvenue' ;
			public $TitreDocument = 'Bienvenue' ;
			public $MessageBienvenue = 'Bienvenue sur l\'application e-AFTrading.' ;
			public $CheminIcone = "images/icones/house.png" ;
			public $TablNotations1Mdgm ;
			public $BlocNotations1Mdgm ;
			public $TablNotations2Mdgm ;
			public $BlocNotations2Mdgm ;
			public function DetermineEnvironnement()
			{
				parent::DetermineEnvironnement() ;
				$this->TablNotations1Mdgm = new TablNotationsMdgm() ;
				$this->TablNotations1Mdgm->AdopteScript("tabl", $this) ;
				// $this->TablNotations1Mdgm->IdNotations = array(1390634, 3895009, 1619898, 1171295, 991341, 1292138, 415007, 1361925) ;
				$this->TablNotations1Mdgm->IdNotations = array(1390634, 3895009, 1619898, 1171295, 991341, 1292138, 415007, 1361925, 
				356488, 8326535, 8326536, 8326537, 8326540, 8326546, 8326547, 8326549, 8326976, 8326977, 8326978, 8326981, 8326988, 8326990, 8327199, 8327200, 8327201, 8327204, 8327211, 8327213, 8327379, 8327380, 8327381, 8327384, 8327390, 8327391, 8327393, 8327854, 8327855, 8327856, 8327859, 8327866, 8327868, 8354343, 8354344, 8354345, 8354346, 8354349, 8354350, 8354352, 8354593, 8354597, 8354598, 8354601, 8327189) ;
				$this->BlocNotations1Mdgm = new PvBlocAjax() ;
				$this->BlocNotations1Mdgm->AdopteScript("brr", $this) ;
				$this->BlocNotations1Mdgm->DelaiRafraich = 10 ;
				$this->BlocNotations1Mdgm->DelaiExpiration = 120 ;
				$this->BlocNotations1Mdgm->AutoRafraich = true ;
				$this->BlocNotations1Mdgm->Support = & $this->TablNotations1Mdgm ;
				// 2
				$this->TablNotations2Mdgm = new TablNotationsMdgm() ;
				$this->TablNotations2Mdgm->AdopteScript("tabl2", $this) ;
				$this->TablNotations2Mdgm->IdNotations = array(1031430, 1031431, 1326189, 4062566, 8328001) ;
				$this->BlocNotations2Mdgm = new PvBlocAjax() ;
				$this->BlocNotations2Mdgm->AdopteScript("brr2", $this) ;
				$this->BlocNotations2Mdgm->DelaiRafraich = 10 ;
				$this->BlocNotations2Mdgm->DelaiExpiration = 120 ;
				$this->BlocNotations2Mdgm->AutoRafraich = true ;
				$this->BlocNotations2Mdgm->Support = & $this->TablNotations2Mdgm ;
			}
			public function RenduSpecifique()
			{
				$ctn = '' ;
				$ctn .= '<p>'.$this->MessageBienvenue.'</p>'.PHP_EOL ;
				$ctn .= '<div id="grpNotations">'.PHP_EOL ;
				$ctn .= '<ul>'.PHP_EOL ;
				$ctn .= '<li><a href="#devises">Devises</a></li>'.PHP_EOL ;
				$ctn .= '<li><a href="#matieres">Mati&egrave;res premi&egrave;res</a></li>'.PHP_EOL ;
				$ctn .= '</ul>'.PHP_EOL ;
				$ctn .= '<div id="devises">'.PHP_EOL ;
				$ctn .= $this->BlocNotations1Mdgm->RenduDispositif() ;
				$ctn .= '</div>'.PHP_EOL ;
				$ctn .= '<div id="matieres">'.PHP_EOL ;
				$ctn .= $this->BlocNotations2Mdgm->RenduDispositif() ;
				$ctn .= '</div>'.PHP_EOL ;
				$ctn .= '</div>'.PHP_EOL ;
				$ctn .= '<script language="javascript">
	jQuery(function () {
		jQuery("#grpNotations").tabs() ;
	}) ;
</script>'.PHP_EOL ;
				return $ctn ;
			}
		}
		
		class CompBarreInfosMembreTradPlatf extends PvComposantIUBase
		{
			public $InclureIconeLiens = 1 ;
			public $CheminIconeLienDecnx = "images/miniatures/deconnexion.png" ;
			public $LibelleLienDecnx = "Deconnexion" ;
			public $CheminIconeLienChMP = "images/miniatures/changeMP.png" ;
			public $LibelleLienChMP = "Changer mot de passe" ;
			protected function RenduDispositifBrut()
			{
				$membreConnecte = $this->ZoneParent->ObtientMembreConnecte() ;
				if($membreConnecte == null)
					return '' ;
				$ctn = '' ;
				$ctn .= '<div id="'.$this->IDInstanceCalc.'" class="ui-wigdet ui-widget-content ui-state-active" style="margin:2px">'.PHP_EOL ;
				$ctn .= '<table width="100%" cellspacing="0" cellpadding=4>'.PHP_EOL ;
				$ctn .= '<tr>'.PHP_EOL ;
				$ctn .= '<td width="50%">Utilisateur : '.htmlentities($membreConnecte->FirstName.' '.$membreConnecte->LastName).' ('.htmlentities($membreConnecte->Login).') / '.htmlentities($membreConnecte->Profile->Title).PHP_EOL ;
				$ctn .= '</td>'.PHP_EOL ;
				$ctn .= '<td width="*" align="right" rowspan="2">'.PHP_EOL ;
				$ctn .= '<div align="center" style="float:right"><a href="'.$this->ZoneParent->ObtientUrlScript($this->ZoneParent->NomScriptDeconnexion).'">' ;
				if($this->InclureIconeLiens)
				{
					$ctn .= '<div><img src="'.$this->CheminIconeLienDecnx.'" border="0" /></div>' ;
				}
				$ctn .= '<div class="btn-princ">'.$this->LibelleLienDecnx.'</div>' ;
				$ctn .= '</a></div>' ;
				$ctn .= '<div style="float:right; padding-right:16px;" align="center"><a href="javascript:ouvreFenetreCadre(\'changeMotPasse\', \'\',\'Change mot de passe\', '.htmlentities(svc_json_encode($this->ZoneParent->ObtientUrlScript($this->ZoneParent->NomScriptChangeMotPasse))).', { Hauteur : 225, Largeur : 450, Modal : 1, BoutonFermer : 0}) ;">' ;
				if($this->InclureIconeLiens)
				{
					$ctn .= '<div><img src="'.$this->CheminIconeLienChMP.'" border="0" /></div>' ;
				}
				$ctn .= '<div class="btn-princ">'.$this->LibelleLienChMP.'</div>' ;
				$ctn .= '</a></div>' ;
				$ctn .= '</td>'.PHP_EOL ;
				$ctn .= '</tr>'.PHP_EOL ;
				$ctn .= '<tr>'.PHP_EOL ;
				$bd = $this->ApplicationParent->BDPrincipale ;
				$ligBanq = $bd->FetchSqlRow(
					'select t2.*, t3.codepays, t3.libpays from '.$this->ZoneParent->Membership->MemberTable.' t1 left join entite t2 on t1.id_entite = t2.id_entite left join pays t3 on t3.idpays = t2.idpays where numop='.$bd->ParamPrefix.'idMembre',
					array(
						'idMembre' => $membreConnecte->Id
					)
				) ;
				$ctn .= '<td width="50%">Banque : '.htmlentities($ligBanq["code"]." - ".$ligBanq["name"]." (".$ligBanq["libpays"].")").PHP_EOL ;
				$ctn .= '</td>'.PHP_EOL ;
				$ctn .= '</tr>'.PHP_EOL ;
				$ctn .= '</table>'.PHP_EOL ;
				$ctn .= '</div>'.PHP_EOL ;
				return $ctn ;
			}
		}
		
		class SymboleAft
		{
			public $Id ;
			public $InstrumentName ;
			public function __construct($id, $instrumentName)
			{
				$this->Id = $id ;
				$this->InstrumentName = $instrumentName ;
			}
		}
		class ReferenceNotationsMdgm
		{
			public static $Symboles = array() ;
			protected static $SymbolesCharges = 0 ;
			public static function ChargeSymboles()
			{
				if(ReferenceNotationsMdgm::$SymbolesCharges == 1)
					return ;
				ReferenceNotationsMdgm::$Symboles[1390634] = new SymboleAft(1390634, 'EUR / USD') ;
				ReferenceNotationsMdgm::$Symboles[3895009] = new SymboleAft(1390634, 'EUR / GBP') ;
				ReferenceNotationsMdgm::$Symboles[1619898] = new SymboleAft(1619898, 'EUR / CHF') ;
				ReferenceNotationsMdgm::$Symboles[1171295] = new SymboleAft(1171295, 'EUR / CAD') ;
				ReferenceNotationsMdgm::$Symboles[991341] = new SymboleAft(991341, 'EUR / JPY') ;
				ReferenceNotationsMdgm::$Symboles[1292138] = new SymboleAft(1292138, 'EUR / ZAR') ;
				ReferenceNotationsMdgm::$Symboles[415007] = new SymboleAft(415007, 'EUR / SAR') ;
				ReferenceNotationsMdgm::$Symboles[1361925] = new SymboleAft(1361925, 'USD / NGN') ;
				ReferenceNotationsMdgm::$Symboles[356488] = new SymboleAft(356488, 'EURIBOR FIXING (ACT/360) 10M') ;
				ReferenceNotationsMdgm::$Symboles[8326535] = new SymboleAft(8326535, 'CHF LIBOR FIXING 1M') ;
				ReferenceNotationsMdgm::$Symboles[8326536] = new SymboleAft(8326536, 'CHF LIBOR FIXING 2M') ;
				ReferenceNotationsMdgm::$Symboles[8326537] = new SymboleAft(8326537, 'CHF LIBOR FIXING 3M') ;
				ReferenceNotationsMdgm::$Symboles[8326540] = new SymboleAft(8326540, 'CHF LIBOR FIXING 6M') ;
				ReferenceNotationsMdgm::$Symboles[8326546] = new SymboleAft(8326546, 'CHF LIBOR FIXING SN') ;
				ReferenceNotationsMdgm::$Symboles[8326547] = new SymboleAft(8326547, 'CHF LIBOR FIXING 1W') ;
				ReferenceNotationsMdgm::$Symboles[8326549] = new SymboleAft(8326549, 'CHF LIBOR FIXING 12M') ;
				ReferenceNotationsMdgm::$Symboles[8326976] = new SymboleAft(8326976, 'GBP LIBOR FIXING 1M') ;
				ReferenceNotationsMdgm::$Symboles[8326977] = new SymboleAft(8326977, 'GBP LIBOR FIXING 2M') ;
				ReferenceNotationsMdgm::$Symboles[8326978] = new SymboleAft(8326978, 'GBP LIBOR FIXING 3M') ;
				ReferenceNotationsMdgm::$Symboles[8326981] = new SymboleAft(8326981, 'GBP LIBOR FIXING 6M') ;
				ReferenceNotationsMdgm::$Symboles[8326988] = new SymboleAft(8326988, 'GBP LIBOR FIXING 1W') ;
				ReferenceNotationsMdgm::$Symboles[8326990] = new SymboleAft(8326990, 'GBP LIBOR FIXING 12M') ;
				ReferenceNotationsMdgm::$Symboles[8327199] = new SymboleAft(8327199, 'EUR LIBOR FIXING 1M') ;
				ReferenceNotationsMdgm::$Symboles[8327200] = new SymboleAft(8327200, 'EUR LIBOR FIXING 2M') ;
				ReferenceNotationsMdgm::$Symboles[8327201] = new SymboleAft(8327201, 'EUR LIBOR FIXING 3M') ;
				ReferenceNotationsMdgm::$Symboles[8327204] = new SymboleAft(8327204, 'EUR LIBOR FIXING 6M') ;
				ReferenceNotationsMdgm::$Symboles[8327211] = new SymboleAft(8327211, 'EUR LIBOR FIXING 1W') ;
				ReferenceNotationsMdgm::$Symboles[8327213] = new SymboleAft(8327213, 'EUR LIBOR FIXING 12M') ;
				ReferenceNotationsMdgm::$Symboles[8327379] = new SymboleAft(8327379, 'JPY LIBOR FIXING 1M') ;
				ReferenceNotationsMdgm::$Symboles[8327380] = new SymboleAft(8327380, 'JPY LIBOR FIXING 2M') ;
				ReferenceNotationsMdgm::$Symboles[8327381] = new SymboleAft(8327381, 'JPY LIBOR FIXING 3M') ;
				ReferenceNotationsMdgm::$Symboles[8327384] = new SymboleAft(8327384, 'JPY LIBOR FIXING 6M') ;
				ReferenceNotationsMdgm::$Symboles[8327390] = new SymboleAft(8327390, 'JPY LIBOR FIXING SN') ;
				ReferenceNotationsMdgm::$Symboles[8327391] = new SymboleAft(8327391, 'JPY LIBOR FIXING 1W') ;
				ReferenceNotationsMdgm::$Symboles[8327393] = new SymboleAft(8327393, 'JPY LIBOR FIXING 12M') ;
				ReferenceNotationsMdgm::$Symboles[8327854] = new SymboleAft(8327854, 'USD LIBOR FIXING 1M') ;
				ReferenceNotationsMdgm::$Symboles[8327855] = new SymboleAft(8327855, 'USD LIBOR FIXING 2M') ;
				ReferenceNotationsMdgm::$Symboles[8327856] = new SymboleAft(8327856, 'USD LIBOR FIXING 3M') ;
				ReferenceNotationsMdgm::$Symboles[8327859] = new SymboleAft(8327859, 'USD LIBOR FIXING 6M') ;
				ReferenceNotationsMdgm::$Symboles[8327866] = new SymboleAft(8327866, 'USD LIBOR FIXING 1W') ;
				ReferenceNotationsMdgm::$Symboles[8327868] = new SymboleAft(8327868, 'USD LIBOR FIXING 12M') ;
				ReferenceNotationsMdgm::$Symboles[8354343] = new SymboleAft(8354343, 'UNITED KINGDOM BANK RATE (SINCE 06.03.2009)') ;
				ReferenceNotationsMdgm::$Symboles[8354344] = new SymboleAft(8354344, 'HONG KONG PRIME RATE') ;
				ReferenceNotationsMdgm::$Symboles[8354345] = new SymboleAft(8354345, 'JAPAN OVERNIGHT CALL RATE') ;
				ReferenceNotationsMdgm::$Symboles[8354346] = new SymboleAft(8354346, 'CANADA OVERNIGHT RATE (SINCE 21.01.2015)') ;
				ReferenceNotationsMdgm::$Symboles[8354349] = new SymboleAft(8354349, 'SOUTH AFRICA PRIME RATE (18.07.2014)') ;
				ReferenceNotationsMdgm::$Symboles[8354350] = new SymboleAft(8354350, 'SINGAPORE PRIME RATE') ;
				ReferenceNotationsMdgm::$Symboles[8354352] = new SymboleAft(8354352, 'UNITED STATES DISCOUNT RATE') ;
				ReferenceNotationsMdgm::$Symboles[8354593] = new SymboleAft(8354593, 'GERMANY') ;
				ReferenceNotationsMdgm::$Symboles[8354597] = new SymboleAft(8354597, 'FRANCE') ;
				ReferenceNotationsMdgm::$Symboles[8354598] = new SymboleAft(8354598, 'GREAT BRITAIN') ;
				ReferenceNotationsMdgm::$Symboles[8354601] = new SymboleAft(8354601, 'JAPAN') ;
				ReferenceNotationsMdgm::$Symboles[8327189] = new SymboleAft(8327189, 'EURIBOR FIXING (ACT/360) 6M') ;
				ReferenceNotationsMdgm::$Symboles[1031430] = new SymboleAft(1031430, 'PLATINUM / US DOLLAR (XPT/USD)') ;
				ReferenceNotationsMdgm::$Symboles[1031431] = new SymboleAft(1031431, 'PALLADIUM / US DOLLAR (XPD/USD)') ;
				ReferenceNotationsMdgm::$Symboles[1326189] = new SymboleAft(1326189, 'GOLD / US DOLLAR (XAU/USD)') ;
				ReferenceNotationsMdgm::$Symboles[4062566] = new SymboleAft(4062566, 'BRENT CRUDE OIL SPOT') ;
				ReferenceNotationsMdgm::$Symboles[8328001] = new SymboleAft(8328001, 'WTI SPOT') ;
				ReferenceNotationsMdgm::$SymbolesCharges = 1 ;
			}
		}
		class TablNotationsMdgm extends PvComposantIUBase
		{
			public $IdNotations = array() ;
			protected $Client ;
			protected function InitClient()
			{
				ReferenceNotationsMdgm::ChargeSymboles() ;
				$this->Client = new ClientMdgm() ;
			}
			protected function RenduDispositifBrut()
			{
				$ctn = '' ;
				$this->InitClient() ;
				if(! $this->Client->Connecte())
				{
					$ctn .= '<div class="ui-state-error">Impossible de se connecter a la plateforme des notations</div>' ;
				}
				else
				{
					$ctn .= '<table width="100%" cellspacing="0" cellpadding="4" class="ui-widget ui-content">'.PHP_EOL ;
					$ctn .= '<tr class="ui-widget ui-widget-content ui-state-active">' ;
					$ctn .= '<th>DATE</th>' ;
					$ctn .= '<th>PAIRE DE DEVISE</th>' ;
					$ctn .= '<th>COURS</th>' ;
					$ctn .= '<th>BAS</th>' ;
					$ctn .= '<th>HAUT</th>' ;
					$ctn .= '</tr>'.PHP_EOL ;
					foreach($this->IdNotations as $i => $id)
					{
						$not = $this->Client->Notation($id) ;
						$classeAlt = ($i % 2 == 0) ? "ui-priority-primary" : "ui-priority-secondary" ;
						$ctn .= '<tr class="ui-widget ui-widget-content '.$classeAlt.'">' ;
						$ctn .= '<td align="center">'.htmlentities($this->ExtraitDate($not->DATETIME_PRICE)).'</td>' ;
						$ctn .= '<td align="center">'.htmlentities(ReferenceNotationsMdgm::$Symboles[$id]->InstrumentName).'</td>' ;
						$ctn .= '<td align="center">'.htmlentities($not->PRICE).'</td>' ;
						$ctn .= '<td align="center">'.htmlentities($not->LOW).'</td>' ;
						$ctn .= '<td align="center">'.htmlentities($not->HIGH).'</td>' ;
						$ctn .= '</tr>'.PHP_EOL ;
					}
					$ctn .= '</table>' ;
				}
				return $ctn ;
			}
			protected function ExtraitDate($dateBrute)
			{
				$timestamp = strtotime(str_replace("T", "", $dateBrute)) ;
				if($timestamp == 0)
					return '' ;
				return date("d/m/Y H:i:s", $timestamp) ;
			}
		}
	}
	
?>
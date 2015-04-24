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
		if(! defined('ARCH_OP_CHANGE_TRAD_PLATF'))
		{
			include dirname(__FILE__)."/ArchOpChange.class.php" ;
		}
		if(! defined('ARCH_OP_INTER_TRAD_PLATF'))
		{
			include dirname(__FILE__)."/ArchOpInter.class.php" ;
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
			public $ScriptParamRelEntreprise ;
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
			public $ScriptConsultArchVenteDevise ;
			public $ScriptConsultArchAchatDevise ;
			public $ScriptConsultArchOpChange ;
			public $ScriptConsultArchPlacement ;
			public $ScriptConsultArchEmprunt ;
			public $ScriptConsultArchOpInter ;
			public $ScriptSoumissOpChange ;
			public $ScriptModifOpChangeSoumis ;
			public $ScriptLiaisonsOpInter ;
			public $ScriptRattachOpInter ;
			public $ScriptLiaisonsRelEntreprise ;
			public $ScriptRattachRelEntreprise ;
			public $ScriptDetailArchOpChange ;
			public $ScriptDetailArchOpInter ;
			public $MenuArchOpChange ;
			public $MenuArchOpInter ;
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
			public $MenuParamOpInter ;
			public $MenuLiaisonOpInter ;
			public $MenuParamRelEntreprise ;
			public $MenuLiaisonRelEntreprise ;
			public $MenuListeAchatsDevise ;
			public $MenuListeVentesDevise ;
			public $MenuReference ;
			public $MenuStats ;
			public $MenuListeEntites ;
			public $MenuListePays ;
			public $MenuListeZonesPays ;
			public $MenuActivationMembre ;
			public $MenuListePlacements ;
			public $MenuTresorier ;
			public $MenuEmissBonTresor ;
			public $MenuEmissObligation ;
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
					$this->MenuParamRelEntreprise = $this->MenuParamTransactEntites->InscritSousMenuScript("paramRelEntreprise") ;
				}
				else
				{
					$idTypeEntite = $this->Membership->MemberLogged->RawData["ID_TYPE_ENTITE_MEMBRE"] ;
					switch($idTypeEntite)
					{
						case 1 :
						case 2 :
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
						break ;
						case 4 :
						{
							$this->MenuParamRelEntreprise = $this->MenuParamTransactEntites->InscritSousMenuFenetreScript("rattachRelEntreprise") ;
							$this->MenuParamRelEntreprise->ParamsScript["idEnCours"] = $this->Membership->MemberLogged->RawData["ID_ENTITE_MEMBRE"] ;
							$this->MenuLiaisonRelEntreprise = $this->MenuParamTransactEntites->InscritSousMenuFenetreScript("liaisonsRelEntreprise") ;
							$this->MenuLiaisonRelEntreprise->ParamsScript["idEnCours"] = $this->Membership->MemberLogged->RawData["ID_ENTITE_MEMBRE"] ;
							$this->MenuLiaisonRelEntreprise->Largeur = 725 ;
							$this->MenuLiaisonRelEntreprise->Titre = "Liaisons entreprise (cotation/transfert devise)" ;
						}
						break ;
					}
				}
				if($this->EstPasNul($this->MenuParamOpChange))
				{
					$this->MenuParamOpChange->Titre = "Echange op&eacute;ration change devise (Achat/Vente devise)" ;
				}
				if($this->EstPasNul($this->MenuParamOpInter))
				{
					$this->MenuParamOpInter->Titre = "Echange op&eacute;ration interbancaire (Placement/Emprunt)" ;
				}
				if($this->EstPasNul($this->MenuParamRelEntreprise))
				{
					$this->MenuParamRelEntreprise->Titre = "Echange entreprise (Cotation/transfert devise)" ;
				}
				$this->MenuListeTransacts = $this->BarreMenuSuperfish->MenuRacine->InscritSousMenuFige("listeTransacts") ;
				$this->MenuListeTransacts->Titre = "Op&eacute;rations bancaires" ;
				$this->MenuListeTransacts->Privileges[] = "post_op_change" ;
				$this->MenuOpChangeDevise = $this->MenuListeTransacts->InscritSousMenuFige("transactsOpChangeDevise") ;
				$this->MenuOpChangeDevise->Titre = "Op&eacute;ration change devise" ;
				$this->MenuListeAchatsDevise = $this->MenuOpChangeDevise->InscritSousMenuScript("listeAchatsDevise") ;
				$this->MenuListeAchatsDevise->Titre = "Achat de devise" ;
				$this->MenuListeVentesDevise = $this->MenuOpChangeDevise->InscritSousMenuScript("listeVentesDevise") ;
				$this->MenuListeVentesDevise->Titre = "Vente de devise" ;
				$this->MenuArchOpChange = $this->MenuOpChangeDevise->InscritSousMenuScript("consultArchOpChange") ;
				$this->MenuArchOpChange->Titre = "Archives" ;
				$this->MenuOpInterbancaire = $this->MenuListeTransacts->InscritSousMenuFige("transactsOpInterbancaires") ;
				$this->MenuOpInterbancaire->Titre = "Op&eacute;ration interbancaire" ;
				$this->MenuOpInterbancaire->Privileges[] = "post_op_change" ;
				$this->MenuListePlacements = $this->MenuOpInterbancaire->InscritSousMenuScript("listePlacements") ;
				$this->MenuListePlacements->Titre = "Placements" ;
				$this->MenuListeEmprunts = $this->MenuOpInterbancaire->InscritSousMenuScript("listeEmprunts") ;
				$this->MenuListeEmprunts->Titre = "Emprunts" ;
				$this->MenuArchOpInter = $this->MenuOpInterbancaire->InscritSousMenuScript("consultArchOpInter") ;
				$this->MenuArchOpInter->Titre = "Archives" ;
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
				$this->MenuStats = $this->BarreMenuSuperfish->MenuRacine->InscritSousMenuFige('stats') ;
				$this->MenuStats->Titre = "Statistiques" ;
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
				$this->ScriptRattachRelEntreprise = new ScriptRattachRelEntrepriseTradPlatf() ;
				$this->InscritScript("rattachRelEntreprise", $this->ScriptRattachRelEntreprise) ;
				$this->ScriptLiaisonsRelEntreprise = new ScriptLiaisonsRelEntrepriseTradPlatf() ;
				$this->InscritScript("liaisonsRelEntreprise", $this->ScriptLiaisonsRelEntreprise) ;
				$this->ScriptParamRelEntreprise = new ScriptParamRelEntrepriseTradPlatf() ;
				$this->InscritScript("paramRelEntreprise", $this->ScriptParamRelEntreprise) ;
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
				$this->ScriptConsultArchOpChange = $this->InsereScript('consultArchOpChange', new ScriptConsultArchOpChangeTradPlatf()) ;
				$this->ScriptConsultArchAchatDevise = $this->InsereScript('consultArchAchatDevise', new ScriptConsultArchAchatDeviseTradPlatf()) ;
				$this->ScriptConsultArchVenteDevise = $this->InsereScript('consultArchVenteDevise', new ScriptConsultArchVenteDeviseTradPlatf()) ;
				$this->ScriptDetailArchOpChange = $this->InsereScript('detailArchOpChange', new ScriptDetailArchOpChangeTradPlatf()) ;
				$this->ScriptConsultArchOpInter = $this->InsereScript('consultArchOpInter', new ScriptConsultArchOpInterTradPlatf()) ;
				$this->ScriptConsultArchPlacement = $this->InsereScript('consultArchPlacement', new ScriptConsultArchPlacementTradPlatf()) ;
				$this->ScriptConsultArchEmprunt = $this->InsereScript('consultArchEmprunt', new ScriptConsultArchEmpruntTradPlatf()) ;
				$this->ScriptDetailArchOpInter = $this->InsereScript('detailArchOpInter', new ScriptDetailArchOpInterTradPlatf()) ;
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
			public $TablNotations3Mdgm ;
			public $BlocNotations3Mdgm ;
			public $CompBondPricing ;
			public function DetermineEnvironnement()
			{
				// $this->TablNotations1Mdgm->IdNotations = array(1390634, 3895009, 1619898, 1171295, 991341, 1292138, 415007, 1361925) ;
				parent::DetermineEnvironnement() ;
				$this->TablNotations1Mdgm = new TablNotationsMdgm() ;
				$this->TablNotations1Mdgm->AdopteScript("tabl", $this) ;
				$this->TablNotations1Mdgm->IdNotations = array(1390634, 3895009, 1619898, 1171295, 991341, 1292138, 415007, 1361925) ;
				$this->BlocNotations1Mdgm = new PvBlocAjax() ;
				$this->BlocNotations1Mdgm->AdopteScript("brr", $this) ;
				$this->BlocNotations1Mdgm->DelaiRafraich = 10 ;
				$this->BlocNotations1Mdgm->DelaiExpiration = 120 ;
				$this->BlocNotations1Mdgm->AutoRafraich = true ;
				$this->BlocNotations1Mdgm->Support = & $this->TablNotations1Mdgm ;
				// 2
				$this->TablNotations2Mdgm = new TablNotationsMdgm() ;
				$this->TablNotations2Mdgm->AdopteScript("tabl2", $this) ;
				$this->TablNotations2Mdgm->IdNotations = array(8326535, 8326536, 8326537, 8326540, 8326546, 8326547, 8326549, 8326976, 8326977, 8326978, 8326981, 8326988, 8326990, 8327199, 8327200, 8327201, 8327204, 8327211, 8327213, 8327379, 8327380, 8327381, 8327384, 8327390, 8327391, 8327393, 8327854, 8327855, 8327856, 8327859, 8327866, 8327868, 8354343, 8354344, 8354345, 8354346, 8354349, 8354350, 8354352, 8354593, 8354597, 8354598, 8354601, 8327189) ;
				$this->TablNotations2Mdgm->TitreNotation = "TAUX D'INTERET" ;
				$this->BlocNotations2Mdgm = new PvBlocAjax() ;
				$this->BlocNotations2Mdgm->AdopteScript("brr2", $this) ;
				$this->BlocNotations2Mdgm->DelaiRafraich = 10 ;
				$this->BlocNotations2Mdgm->DelaiExpiration = 120 ;
				$this->BlocNotations2Mdgm->AutoRafraich = true ;
				$this->BlocNotations2Mdgm->Support = & $this->TablNotations2Mdgm ;
				// 3
				$this->TablNotations3Mdgm = new TablNotationsMdgm() ;
				$this->TablNotations3Mdgm->AdopteScript("tabl3", $this) ;
				$this->TablNotations3Mdgm->IdNotations = array(1031430, 1031431, 1326189, 4062566, 8328001) ;
				$this->TablNotations3Mdgm->TitreNotation = "MATIERE" ;
				$this->BlocNotations3Mdgm = new PvBlocAjax() ;
				$this->BlocNotations3Mdgm->AdopteScript("brr3", $this) ;
				$this->BlocNotations3Mdgm->DelaiRafraich = 10 ;
				$this->BlocNotations3Mdgm->DelaiExpiration = 120 ;
				$this->BlocNotations3Mdgm->AutoRafraich = true ;
				$this->BlocNotations3Mdgm->Support = & $this->TablNotations3Mdgm ;
				
				$this->CompBondPricing = new CompBondPricing() ;
				$this->CompBondPricing->AdopteScript('bondPrice', $this) ;
				$this->CompBondPricing->ChargeConfig() ;
			}
			public function RenduSpecifique()
			{
				$ctn = '' ;
				$ctn .= '<p>'.$this->MessageBienvenue.'</p>'.PHP_EOL ;
				$ctn .= '<div id="grpNotations">'.PHP_EOL ;
				$ctn .= '<ul>'.PHP_EOL ;
				$ctn .= '<li><a href="#devises">Devises</a></li>'.PHP_EOL ;
				$ctn .= '<li><a href="#taux">Taux</a></li>'.PHP_EOL ;
				$ctn .= '<li><a href="#matieres">Mati&egrave;res premi&egrave;res</a></li>'.PHP_EOL ;
				$ctn .= '<li><a href="#indicesTitreUEMOA">Indices Titres UEMOA</a></li>'.PHP_EOL ;
				$ctn .= '</ul>'.PHP_EOL ;
				$ctn .= '<div id="devises">'.PHP_EOL ;
				$ctn .= $this->BlocNotations1Mdgm->RenduDispositif() ;
				$ctn .= '</div>'.PHP_EOL ;
				$ctn .= '<div id="taux">'.PHP_EOL ;
				$ctn .= $this->BlocNotations2Mdgm->RenduDispositif() ;
				$ctn .= '</div>'.PHP_EOL ;
				$ctn .= '<div id="matieres">'.PHP_EOL ;
				$ctn .= $this->BlocNotations3Mdgm->RenduDispositif() ;
				$ctn .= '</div>'.PHP_EOL ;
				$ctn .= '<div id="indicesTitreUEMOA">'.PHP_EOL ;
				$ctn .= $this->CompBondPricing->RenduDispositif() ;
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
			public $TitreNotation = "PAIRE DE DEVISE" ;
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
					$ctn .= '<th>'.$this->TitreNotation.'</th>' ;
					$ctn .= '<th>COURS</th>' ;
					$ctn .= '<th>BAS</th>' ;
					$ctn .= '<th>HAUT</th>' ;
					$ctn .= '</tr>'.PHP_EOL ;
					foreach($this->IdNotations as $i => $id)
					{
						$not = $this->Client->Notation($id) ;
						$classeAlt = ($i % 2 == 0) ? "ui-priority-primary" : "ui-priority-secondary ui-state-active" ;
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
		
		class CompBondPricing extends PvComposantIUBase
		{
			protected function RenduDispositifBrut()
			{
				$ctn = '<table width="100%" cellspacing="0" cellpadding="4" class="ui-widget ui-widget-content">
<tr class="ui-widget ui-widget-header ui-state-active"><th>BondID</th><th>ISIN/LocalID</th><th>InstrumentType</th><th>Issuer</th><th>Coupon</th><th>Maturity</th><th>Nominal (XOF) </th><th>FirstSettlementDate</th><th>AccruedInterest</th><th>Price</th><th>Yield</th></tr>
<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
<tr><td>58796</td><td>C60047145</td><td>Bill</td><td>Burkina Faso</td><td>0</td><td>07/01/2015</td><td> 33 000 000 000 </td><td>10/07/2014</td><td>0,00</td><td>99,68</td><td>3,52</td></tr>
<tr><td>61444</td><td>C60048143</td><td>Bill</td><td>Burkina Faso</td><td>0</td><td>11/03/2015</td><td> 38 423 000 000 </td><td>11/09/2014</td><td>0,00</td><td>98,98</td><td>3,92</td></tr>
<tr><td>18779</td><td></td><td>Bond</td><td>Burkina Faso</td><td>6,5</td><td>19/09/2016</td><td> 40 955 000 000 </td><td>21/09/2009</td><td>1,37</td><td>99,74</td><td>6,58</td></tr>
<tr><td>18781</td><td>BF0000000166</td><td>Bond</td><td>Burkina Faso</td><td>6,5</td><td>27/12/2016</td><td> 60 600 000 000 </td><td>27/12/2011</td><td>6,11</td><td>99,11</td><td>6,92</td></tr>
<tr><td>18780</td><td>C600252F4OTA-B</td><td>Bond</td><td>Burkina Faso</td><td>6,5</td><td>20/05/2017</td><td> 43 283 000 000 </td><td>21/05/2010</td><td>3,54</td><td>98,04</td><td>7,33</td></tr>
<tr><td>18777</td><td></td><td>Bond</td><td>Burkina Faso</td><td>5,5</td><td>30/07/2017</td><td> 41 300 000 000 </td><td>31/07/2007</td><td>1,93</td><td>95,14</td><td>7,53</td></tr>
<tr><td>21680</td><td>C600382E2</td><td>Bond</td><td>Burkina Faso</td><td>6,5</td><td>25/10/2017</td><td> 32 353 690 000 </td><td>29/10/2012</td><td>0,73</td><td>96,81</td><td>7,72</td></tr>
<tr><td>63724</td><td>BF0000000182</td><td>Bond</td><td>Burkina Faso</td><td>6,5</td><td>29/11/2020</td><td> 121 600 000 000 </td><td>29/11/2013</td><td>0,11</td><td>88,08</td><td>9,15</td></tr>
<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
<tr><td>50279</td><td>B600451A9</td><td>Bill</td><td>Republic of Benin</td><td>0</td><td>14/01/2015</td><td> 30 000 000 000 </td><td>16/01/2014</td><td>0,00</td><td>99,61</td><td>3,61</td></tr>
<tr><td>50824</td><td>B600461A4</td><td>Bill</td><td>Republic of Benin</td><td>0</td><td>26/02/2015</td><td> 25 000 000 000 </td><td>28/02/2014</td><td>0,00</td><td>99,13</td><td>3,88</td></tr>
<tr><td>58142</td><td>B600481A2</td><td>Bill</td><td>Republic of Benin</td><td>0</td><td>23/04/2015</td><td> 46 000 000 000 </td><td>25/04/2014</td><td>0,00</td><td>98,42</td><td>4,22</td></tr>
<tr><td>58356</td><td>B600491A1</td><td>Bill</td><td>Republic of Benin</td><td>0</td><td>21/05/2015</td><td> 20 985 000 000 </td><td>23/05/2014</td><td>0,00</td><td>98,03</td><td>4,38</td></tr>
<tr><td>58697</td><td>B600501A7</td><td>Bill</td><td>Republic of Benin</td><td>0</td><td>18/06/2015</td><td> 40 000 000 000 </td><td>20/06/2014</td><td>0,00</td><td>97,62</td><td>4,54</td></tr>
<tr><td>63722</td><td>B600521A5</td><td>Bill</td><td>Republic of Benin</td><td>0</td><td>27/08/2015</td><td> 40 000 000 000 </td><td>29/08/2014</td><td>0,00</td><td>96,53</td><td>4,92</td></tr>
<tr><td>55671</td><td>B600471B1</td><td>Bill</td><td>Republic of Benin</td><td>0</td><td>17/03/2016</td><td> 30 710 000 000 </td><td>21/03/2014</td><td>0,00</td><td>92,83</td><td>5,95</td></tr>
<tr><td>58797</td><td>B600511B4</td><td>Bill</td><td>Republic of Benin</td><td>0</td><td>08/07/2016</td><td> 40 000 000 000 </td><td>11/07/2014</td><td>0,00</td><td>90,54</td><td>6,41</td></tr>
<tr><td>62398</td><td>B600541B1</td><td>Bill</td><td>Republic of Benin</td><td>0</td><td>20/10/2016</td><td> 40 000 000 000 </td><td>24/10/2014</td><td>0,00</td><td>88,34</td><td>6,78</td></tr>
<tr><td>18741</td><td>B600042F1OTA</td><td>Bond</td><td>Republic of Benin</td><td>6,5</td><td>22/10/2016</td><td> 14 653 796 000 </td><td>23/10/2009</td><td>0,78</td><td>47,94</td><td>6,24</td></tr>
<tr><td>18742</td><td></td><td>Bond</td><td>Republic of Benin</td><td>6,5</td><td>01/11/2016</td><td> 6 381 037 000 </td><td>01/11/2011</td><td>0,61</td><td>99,40</td><td>6,77</td></tr>
<tr><td>18739</td><td>B600022G7OTA</td><td>Bond</td><td>Republic of Benin</td><td>5,5</td><td>08/07/2017</td><td> 41 922 000 000 </td><td>08/07/2007</td><td>2,26</td><td>95,27</td><td>7,52</td></tr>
<tr><td>18740</td><td>B600062G7OTA</td><td>Bond</td><td>Republic of Benin</td><td>6</td><td>16/09/2018</td><td> 15 000 000 000 </td><td>17/09/2008</td><td>1,32</td><td>61,54</td><td>7,52</td></tr>
<tr><td>63723</td><td>B600532F1</td><td>Bond</td><td>Republic of Benin</td><td>6,5</td><td>10/10/2021</td><td> 56 716 000 000 </td><td>10/10/2014</td><td>1,00</td><td>98,78</td><td>8,90</td></tr>
<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
<tr><td>18928</td><td>A600D32C6OTA</td><td>Bond</td><td>Republic of Côte d\'Ivoire</td><td>5</td><td>09/12/2014</td><td> 169 767 120 000 </td><td>09/12/2011</td><td>2,45</td><td>100,02</td><td>3,19</td></tr>
<tr><td>18929</td><td>CI0000001079</td><td>Bond</td><td>Republic of Côte d\'Ivoire</td><td>6,25</td><td>02/01/2015</td><td> 10 153 666 667 </td><td>02/01/2012</td><td>2,65</td><td>17,09</td><td>3,35</td></tr>
<tr><td>50234</td><td>A600F41A6</td><td>Bill</td><td>Republic of Côte d\'Ivoire</td><td>0</td><td>14/01/2015</td><td> 43 700 000 000 </td><td>16/01/2014</td><td>0,00</td><td>99,63</td><td>3,43</td></tr>
<tr><td>28950</td><td>A600E11B0</td><td>Bill</td><td>Republic of Côte d\'Ivoire</td><td>0</td><td>17/02/2015</td><td> 26 500 000 000 </td><td>20/02/2013</td><td>0,00</td><td>99,27</td><td>3,64</td></tr>
<tr><td>57846</td><td></td><td>Bill</td><td>Republic of Côte d\'Ivoire</td><td>0</td><td>22/03/2015</td><td> 24 780 000 000 </td><td>24/03/2014</td><td>0,00</td><td>98,89</td><td>3,84</td></tr>
<tr><td>18931</td><td>A600D52C4OTA</td><td>Bond</td><td>Republic of Côte d\'Ivoire</td><td>6,25</td><td>22/05/2015</td><td> 71 945 000 000 </td><td>23/05/2012</td><td>0,22</td><td>100,94</td><td>4,20</td></tr>
<tr><td>50037</td><td></td><td>Bill</td><td>Republic of Côte d\'Ivoire</td><td>0</td><td>20/10/2015</td><td> 50 986 000 000 </td><td>23/10/2013</td><td>0,00</td><td>95,76</td><td>5,01</td></tr>
<tr><td>34020</td><td>A600F21B6</td><td>Bill</td><td>Republic of Côte d\'Ivoire</td><td>0</td><td>11/11/2015</td><td> 77 467 000 000 </td><td>14/11/2013</td><td>0,00</td><td>95,38</td><td>5,12</td></tr>
<tr><td>35895</td><td>A600F31B5</td><td>Bill</td><td>Republic of Côte d\'Ivoire</td><td>0</td><td>01/12/2015</td><td> 40 885 000 000 </td><td>04/12/2013</td><td>0,00</td><td>95,03</td><td>5,22</td></tr>
<tr><td>57940</td><td>A600F81B0</td><td>Bill</td><td>Republic of Côte d\'Ivoire</td><td>0</td><td>12/04/2016</td><td> 41 850 000 000 </td><td>16/04/2014</td><td>0,00</td><td>92,54</td><td>5,88</td></tr>
<tr><td>58654</td><td>A600G01B6</td><td>Bill</td><td>Republic of Côte d\'Ivoire</td><td>0</td><td>21/06/2016</td><td> 73 839 000 000 </td><td>25/06/2014</td><td>0,00</td><td>91,14</td><td>6,16</td></tr>
<tr><td>63275</td><td>CI0000001103</td><td>Bond</td><td>Republic of Côte d\'Ivoire</td><td>6</td><td>08/07/2016</td><td> 120 881 000 000 </td><td>08/07/2013</td><td>2,45</td><td>99,81</td><td>6,18</td></tr>
<tr><td>18925</td><td>A600012F6OTA</td><td>Bond</td><td>Republic of Côte d\'Ivoire</td><td>7</td><td>09/09/2016</td><td> 73 985 000 000 </td><td>09/09/2009</td><td>1,68</td><td>101,04</td><td>6,40</td></tr>
<tr><td>50035</td><td>CI0000001038</td><td>Bond</td><td>Republic of Côte d\'Ivoire</td><td>6,5</td><td>15/09/2016</td><td> 160 235 670 000 </td><td>12/09/2011</td><td>1,45</td><td>100,19</td><td>6,42</td></tr>
<tr><td>18927</td><td>A600D42E1OTA</td><td>Bond</td><td>Republic of Côte d\'Ivoire</td><td>5,25</td><td>09/12/2016</td><td> 169 767 120 000 </td><td>09/12/2011</td><td>2,57</td><td>97,38</td><td>6,77</td></tr>
<tr><td>18926</td><td>A600322F9OTA</td><td>Bond</td><td>Republic of Côte d\'Ivoire</td><td>7</td><td>19/02/2017</td><td> 36 788 000 000 </td><td>19/02/2010</td><td>2,05</td><td>100,27</td><td>6,96</td></tr>
<tr><td>18930</td><td>CI0000001087</td><td>Bond</td><td>Republic of Côte d\'Ivoire</td><td>6</td><td>07/03/2017</td><td> 25 755 500 000 </td><td>07/03/2012</td><td>1,48</td><td>105,10</td><td>6,34</td></tr>
<tr><td>58852</td><td>A600G12C1</td><td>Bond</td><td>Republic of Côte d\'Ivoire</td><td>6</td><td>15/07/2017</td><td> 27 200 000 000 </td><td>15/07/2014</td><td>2,35</td><td>100,66</td><td>6,90</td></tr>
<tr><td>50036</td><td>CI0000001012</td><td>Bond</td><td>Republic of Côte d\'Ivoire</td><td>7</td><td>01/10/2017</td><td> 22 915 120 000 </td><td>30/09/2010</td><td>1,25</td><td>98,94</td><td>7,52</td></tr>
<tr><td>63276</td><td></td><td>Bond</td><td>Republic of Côte d\'Ivoire</td><td>6,4</td><td>10/07/2018</td><td> 43 749 000 000 </td><td>10/07/2013</td><td>2,57</td><td>103,02</td><td>7,44</td></tr>
<tr><td>61140</td><td>A600G22E6</td><td>Bond</td><td>Republic of Côte d\'Ivoire</td><td>6</td><td>05/08/2019</td><td> 70 085 350 000 </td><td>05/08/2014</td><td>2,01</td><td>101,43</td><td>7,89</td></tr>
<tr><td>62329</td><td>A600G32E5</td><td>Bond</td><td>Republic of Côte d\'Ivoire</td><td>5,8</td><td>16/10/2019</td><td> 57 402 520 000 </td><td>16/10/2014</td><td>0,80</td><td>96,64</td><td>8,24</td></tr>
<tr><td>62481</td><td>A600G42E4</td><td>Bond</td><td>Republic of Côte d\'Ivoire</td><td>5,8</td><td>29/10/2019</td><td> 43 200 000 000 </td><td>29/10/2014</td><td>0,59</td><td>96,52</td><td>8,26</td></tr>
<tr><td>28928</td><td>A600E22F8</td><td>Bond</td><td>Republic of Côte d\'Ivoire</td><td>6,5</td><td>29/03/2020</td><td> 152 196 100 000 </td><td>29/03/2013</td><td>1,20</td><td>101,81</td><td>8,24</td></tr>
<tr><td>63277</td><td></td><td>Bond</td><td>Republic of Côte d\'Ivoire</td><td>6,3</td><td>03/12/2020</td><td> 97 685 000 000 </td><td>03/12/2013</td><td>0,03</td><td>168,33</td><td>8,59</td></tr>
<tr><td>50825</td><td>A600F52F2</td><td>Bond</td><td>Republic of Côte d\'Ivoire</td><td>6,5</td><td>26/02/2021</td><td> 241 767 670 000 </td><td>25/02/2014</td><td>1,78</td><td>106,18</td><td>8,31</td></tr>
<tr><td>51505</td><td>A600F62F1</td><td>Bond</td><td>Republic of Côte d\'Ivoire</td><td>6,5</td><td>07/03/2021</td><td> 29 256 000 000 </td><td>07/03/2014</td><td>1,60</td><td>106,10</td><td>8,31</td></tr>
<tr><td>58143</td><td>A600F92T9</td><td>Bond</td><td>Republic of Côte d\'Ivoire</td><td>6,55</td><td>29/04/2022</td><td> 124 000 000 000 </td><td>29/04/2014</td><td>3,95</td><td>104,97</td><td>8,64</td></tr>
<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
<tr><td>28959</td><td>S600031B7</td><td>Bill</td><td>Republic of Guinea-Bissau</td><td>0</td><td>27/04/2015</td><td> 10 000 000 000 </td><td>30/04/2013</td><td>0,00</td><td>98,40</td><td>4,14</td></tr>
<tr><td>61279</td><td></td><td>Bill</td><td>Republic of Guinea-Bissau</td><td>0</td><td>22/07/2015</td><td> 15 000 000 000 </td><td>23/07/2014</td><td>0,00</td><td>97,17</td><td>4,62</td></tr>
<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
<tr><td>58885</td><td>D60039141</td><td>Bill</td><td>Republic of Mali</td><td>0</td><td>22/01/2015</td><td> 26 000 000 000 </td><td>25/07/2014</td><td>0,00</td><td>99,52</td><td>3,67</td></tr>
<tr><td>61178</td><td>D60040149</td><td>Bill</td><td>Republic of Mali</td><td>0</td><td>09/02/2015</td><td> 32 000 000 000 </td><td>12/08/2014</td><td>0,00</td><td>99,32</td><td>3,78</td></tr>
<tr><td>58541</td><td>D60038150</td><td>Bill</td><td>Republic of Mali</td><td>0</td><td>12/03/2015</td><td> 43 950 000 000 </td><td>13/06/2014</td><td>0,00</td><td>98,96</td><td>3,97</td></tr>
<tr><td>57845</td><td></td><td>Bill</td><td>Republic of Mali</td><td>0</td><td>12/03/2015</td><td> 45 500 000 000 </td><td>14/03/2014</td><td>0,00</td><td>98,96</td><td>3,97</td></tr>
<tr><td>63742</td><td>D60045184</td><td>Bill</td><td>Republic of Mali</td><td>0</td><td>25/05/2015</td><td> 45 000 000 000 </td><td>25/11/2014</td><td>0,00</td><td>97,97</td><td>4,41</td></tr>
<tr><td>61600</td><td>D600421A4</td><td>Bill</td><td>Republic of Mali</td><td>0</td><td>29/09/2015</td><td> 45 500 000 000 </td><td>01/10/2014</td><td>0,00</td><td>95,97</td><td>5,10</td></tr>
<tr><td>62510</td><td>D600441A2</td><td>Bill</td><td>Republic of Mali</td><td>0</td><td>04/11/2015</td><td> 30 000 000 000 </td><td>06/11/2014</td><td>0,00</td><td>95,34</td><td>5,28</td></tr>
<tr><td>18957</td><td>D600162E6OTA</td><td>Bond</td><td>Republic of Mali</td><td>6,5</td><td>21/12/2015</td><td> 19 000 000 000 </td><td>22/12/2010</td><td>6,22</td><td>45,28</td><td>5,15</td></tr>
<tr><td>61471</td><td>D600411B3</td><td>Bill</td><td>Republic of Mali</td><td>0</td><td>12/09/2016</td><td> 40 000 000 000 </td><td>16/09/2014</td><td>0,00</td><td>89,14</td><td>6,66</td></tr>
<tr><td>18955</td><td>D600102G7OTA</td><td>Bond</td><td>Republic of Mali</td><td>6</td><td>21/07/2018</td><td> 16 094 060 000 </td><td>22/07/2008</td><td>2,25</td><td>61,44</td><td>7,42</td></tr>
<tr><td>63694</td><td>D600432E3</td><td>Bond</td><td>Republic of Mali</td><td>6,25</td><td>22/10/2019</td><td> 44 110 000 000 </td><td>22/10/2014</td><td>0,75</td><td>101,08</td><td>8,21</td></tr>
<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
<tr><td>50439</td><td>H600211A0</td><td>Bill</td><td>Republic of Niger</td><td>0</td><td>29/01/2015</td><td> 41 000 000 000 </td><td>31/01/2014</td><td>0,00</td><td>99,45</td><td>3,68</td></tr>
<tr><td>62480</td><td>H60025146</td><td>Bill</td><td>Republic of Niger</td><td>0</td><td>30/04/2015</td><td> 34 800 000 000 </td><td>31/10/2014</td><td>0,00</td><td>98,33</td><td>4,23</td></tr>
<tr><td>18972</td><td>H600102F0OTA</td><td>Bond</td><td>Republic of Niger</td><td>6,5</td><td>24/11/2016</td><td> 6 640 000 000 </td><td>26/11/2009</td><td>0,20</td><td>48,21</td><td>6,33</td></tr>
<tr><td>50586</td><td>H600202E1</td><td>Bond</td><td>Republic of Niger</td><td>6,25</td><td>20/11/2018</td><td> 25 000 000 000 </td><td>21/11/2013</td><td>0,26</td><td>104,34</td><td>7,62</td></tr>
<tr><td>57775</td><td>H600222E9</td><td>Bond</td><td>Republic of Niger</td><td>6,25</td><td>03/04/2019</td><td> 63 300 000 000 </td><td>03/04/2014</td><td>4,21</td><td>103,12</td><td>7,85</td></tr>
<tr><td>61270</td><td>H600242E7</td><td>Bond</td><td>Republic of Niger</td><td>6,25</td><td>22/08/2019</td><td> 30 000 000 000 </td><td>22/08/2014</td><td>1,80</td><td>101,77</td><td>8,08</td></tr>
<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
<tr><td>50162</td><td>K600621A4</td><td>Bill</td><td>Republic of Senegal</td><td>0</td><td>07/01/2015</td><td> 22 405 000 000 </td><td>09/01/2014</td><td>0,00</td><td>99,70</td><td>3,32</td></tr>
<tr><td>19014</td><td>K600352C2OTA</td><td>Bond</td><td>Republic of Senegal</td><td>6,25</td><td>24/01/2015</td><td> 6 036 666 667 </td><td>24/01/2012</td><td>5,39</td><td>34,00</td><td>2,02</td></tr>
<tr><td>28972</td><td>K600531B3</td><td>Bill</td><td>Republic of Senegal</td><td>0</td><td>19/02/2015</td><td> 25 950 000 000 </td><td>22/02/2013</td><td>0,00</td><td>99,26</td><td>3,59</td></tr>
<tr><td>19015</td><td>K600382C9OTA</td><td>Bond</td><td>Republic of Senegal</td><td>6,25</td><td>30/03/2015</td><td> 9 690 000 000 </td><td>30/03/2012</td><td>4,28</td><td>34,83</td><td>3,33</td></tr>
<tr><td>28966</td><td>K600571B9</td><td>Bill</td><td>Republic of Senegal</td><td>0</td><td>13/05/2015</td><td> 29 844 000 000 </td><td>16/05/2013</td><td>0,00</td><td>98,25</td><td>4,09</td></tr>
<tr><td>28967</td><td>K600581B8</td><td>Bill</td><td>Republic of Senegal</td><td>0</td><td>28/05/2015</td><td> 17 520 000 000 </td><td>31/05/2013</td><td>0,00</td><td>98,04</td><td>4,17</td></tr>
<tr><td>19187</td><td>K600442C1</td><td>Bond</td><td>Republic of Senegal</td><td>6,25</td><td>13/07/2015</td><td> 2 084 126 667 </td><td>13/07/2012</td><td>2,48</td><td>36,07</td><td>4,28</td></tr>
<tr><td>19359</td><td>K600482C7</td><td>Bond</td><td>Republic of Senegal</td><td>6,25</td><td>14/09/2015</td><td> 11 691 666 667 </td><td>14/09/2012</td><td>1,40</td><td>36,76</td><td>4,70</td></tr>
<tr><td>19009</td><td></td><td>Bond</td><td>Republic of Senegal</td><td>6,75</td><td>02/11/2015</td><td> 75 000 000 000 </td><td>02/11/2010</td><td>0,61</td><td>101,43</td><td>5,00</td></tr>
<tr><td>50060</td><td>SN0000000183</td><td>Bond</td><td>Republic of Senegal</td><td>6,75</td><td>16/11/2015</td><td> 15 360 000 000 </td><td>15/11/2010</td><td>0,35</td><td>25,15</td><td>5,06</td></tr>
<tr><td>50280</td><td>K600631B1</td><td>Bill</td><td>Republic of Senegal</td><td>0</td><td>21/01/2016</td><td> 20 250 000 000 </td><td>24/01/2014</td><td>0,00</td><td>94,17</td><td>5,46</td></tr>
<tr><td>28925</td><td>K600562C6</td><td>Bond</td><td>Republic of Senegal</td><td>6</td><td>12/04/2016</td><td> 16 545 333 333 </td><td>12/04/2013</td><td>3,90</td><td>71,33</td><td>5,31</td></tr>
<tr><td>58311</td><td>K600671B7</td><td>Bill</td><td>Republic of Senegal</td><td>0</td><td>18/05/2016</td><td> 25 267 000 000 </td><td>22/05/2014</td><td>0,00</td><td>91,91</td><td>5,96</td></tr>
<tr><td>61542</td><td>K600681B6</td><td>Bill</td><td>Republic of Senegal</td><td>0</td><td>15/09/2016</td><td> 40 020 000 000 </td><td>19/09/2014</td><td>0,00</td><td>89,46</td><td>6,41</td></tr>
<tr><td>31605</td><td>K600602C0</td><td>Bond</td><td>Republic of Senegal</td><td>6</td><td>20/09/2016</td><td> 28 573 333 333 </td><td>20/09/2013</td><td>1,25</td><td>71,78</td><td>5,88</td></tr>
<tr><td>57844</td><td></td><td>Bond</td><td>Republic of Senegal</td><td>6</td><td>06/03/2017</td><td> 35 000 000 000 </td><td>06/03/2014</td><td>4,50</td><td>101,76</td><td>6,45</td></tr>
<tr><td>58165</td><td>K600662C4</td><td>Bond</td><td>Republic of Senegal</td><td>6</td><td>07/05/2017</td><td> 30 895 000 000 </td><td>08/05/2014</td><td>3,48</td><td>101,32</td><td>6,67</td></tr>
<tr><td>19016</td><td>K600412E0OTA</td><td>Bond</td><td>Republic of Senegal</td><td>6,25</td><td>25/05/2017</td><td> 17 635 200 000 </td><td>25/05/2012</td><td>3,32</td><td>68,59</td><td>6,39</td></tr>
<tr><td>19004</td><td>K600022G2</td><td>Bond</td><td>Republic of Senegal</td><td>5,5</td><td>27/06/2017</td><td> 58 709 000 000 </td><td>28/06/2007</td><td>2,43</td><td>95,93</td><td>7,24</td></tr>
<tr><td>19186</td><td>K600432E8</td><td>Bond</td><td>Republic of Senegal</td><td>6,25</td><td>29/06/2017</td><td> 13 807 800 000 </td><td>29/06/2012</td><td>2,72</td><td>68,68</td><td>6,48</td></tr>
<tr><td>28923</td><td>K600552E3</td><td>Bond</td><td>Republic of Senegal</td><td>6,25</td><td>22/03/2018</td><td> 27 873 600 000 </td><td>22/03/2013</td><td>4,42</td><td>88,79</td><td>6,98</td></tr>
<tr><td>19006</td><td>K600082G6</td><td>Bond</td><td>Republic of Senegal</td><td>7</td><td>17/06/2018</td><td> 25 000 000 000 </td><td>19/06/2008</td><td>3,28</td><td>97,00</td><td>7,95</td></tr>
<tr><td>63732</td><td></td><td>Bond</td><td>Republic of Senegal</td><td>6,25</td><td>21/07/2018</td><td> 100 000 000 000 </td><td>21/07/2014</td><td>2,35</td><td>102,17</td><td>7,39</td></tr>
<tr><td>28926</td><td>K600592E9</td><td>Bond</td><td>Republic of Senegal</td><td>6,25</td><td>23/08/2018</td><td> 24 304 000 000 </td><td>23/08/2013</td><td>1,78</td><td>88,35</td><td>7,23</td></tr>
<tr><td>32829</td><td>K600612E5</td><td>Bond</td><td>Republic of Senegal</td><td>6,25</td><td>25/10/2018</td><td> 29 197 520 000 </td><td>25/10/2013</td><td>0,70</td><td>88,13</td><td>7,35</td></tr>
<tr><td>61281</td><td></td><td>Bond</td><td>Republic of Senegal</td><td>6,25</td><td>10/04/2019</td><td> 37 166 000 000 </td><td>10/04/2014</td><td>4,09</td><td>107,11</td><td>7,52</td></tr>
<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
<tr><td>50005</td><td>T600211A5</td><td>Bill</td><td>Togolese Republic</td><td>0</td><td>16/12/2014</td><td> 25 000 000 000 </td><td>18/12/2013</td><td>0,00</td><td>99,89</td><td>3,57</td></tr>
<tr><td>50233</td><td>T600221A4</td><td>Bill</td><td>Togolese Republic</td><td>0</td><td>15/01/2015</td><td> 25 000 000 000 </td><td>17/01/2014</td><td>0,00</td><td>99,58</td><td>3,77</td></tr>
<tr><td>58711</td><td>T60024152</td><td>Bill</td><td>Togolese Republic</td><td>0</td><td>17/02/2015</td><td> 35 000 000 000 </td><td>21/05/2014</td><td>0,00</td><td>99,20</td><td>3,98</td></tr>
<tr><td>19028</td><td></td><td>Bond</td><td>Togolese Republic</td><td>7</td><td>24/02/2015</td><td> 17 107 000 000 </td><td>25/02/2010</td><td>5,45</td><td>100,61</td><td>3,69</td></tr>
<tr><td>61282</td><td></td><td>Bill</td><td>Togolese Republic</td><td>0</td><td>16/04/2015</td><td> 20 600 000 000 </td><td>18/04/2014</td><td>0,00</td><td>98,46</td><td>4,33</td></tr>
<tr><td>61698</td><td>T600271A9</td><td>Bill</td><td>Togolese Republic</td><td>0</td><td>12/10/2015</td><td> 25 000 000 000 </td><td>14/10/2014</td><td>0,00</td><td>95,63</td><td>5,31</td></tr>
<tr><td>19029</td><td>TG0000000207</td><td>Bond</td><td>Togolese Republic</td><td>6,5</td><td>15/03/2016</td><td> 30 000 000 000 </td><td>15/03/2011</td><td>4,72</td><td>55,63</td><td>5,58</td></tr>
<tr><td>19030</td><td>T600102E8OA-B</td><td>Bond</td><td>Togolese Republic</td><td>6,5</td><td>27/01/2017</td><td> 13 074 000 000 </td><td>30/01/2012</td><td>5,56</td><td>98,51</td><td>7,21</td></tr>
<tr><td>19188</td><td>T600122E6</td><td>Bond</td><td>Togolese Republic</td><td>6,5</td><td>18/06/2017</td><td> 26 250 000 000 </td><td>19/06/2012</td><td>3,03</td><td>82,37</td><td>6,86</td></tr>
<tr><td>19027</td><td>K600012G4OTA-BTRESTG</td><td>Bond</td><td>Togolese Republic</td><td>6</td><td>17/07/2017</td><td> 20 000 000 000 </td><td>17/07/2007</td><td>2,32</td><td>96,00</td><td>7,68</td></tr>
<tr><td>28927</td><td>T600182E0</td><td>Bond</td><td>Togolese Republic</td><td>6,5</td><td>23/08/2018</td><td> 29 968 800 000 </td><td>23/08/2013</td><td>1,85</td><td>88,42</td><td>7,63</td></tr>
<tr><td>35208</td><td>T600202E6</td><td>Bond</td><td>Togolese Republic</td><td>6,5</td><td>29/11/2018</td><td> 28 000 000 000 </td><td>29/11/2013</td><td>0,11</td><td>104,68</td><td>7,81</td></tr>
<tr><td>58853</td><td>T600252E1</td><td>Bond</td><td>Togolese Republic</td><td>6,5</td><td>18/07/2019</td><td> 38 000 000 000 </td><td>18/07/2014</td><td>2,49</td><td>102,54</td><td>8,20</td></tr>
<tr><td>63729</td><td>T600262E0</td><td>Bond</td><td>Togolese Republic</td><td>6,5</td><td>05/09/2019</td><td> 40 000 000 000 </td><td>05/09/2014</td><td>1,62</td><td>102,08</td><td>8,28</td></tr>
<tr><td>63730</td><td>T600282E8</td><td>Bond</td><td>Togolese Republic</td><td>6,25</td><td>14/11/2019</td><td> 39 209 000 000 </td><td>14/11/2014</td><td>0,36</td><td>100,43</td><td>8,39</td></tr>
</table>' ;
				return $ctn ;
			}
		}
		
	}
	
?>
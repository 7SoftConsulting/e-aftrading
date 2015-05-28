<?php
	
	if(! defined('COTATION_TRANSF_DEV_TRAD_PLATF'))
	{
		define('COTATION_TRANSF_DEV_TRAD_PLATF', 1) ;
		
		class ScriptBaseCotationTransfDevTradPlatf extends ScriptTransactBaseTradPlatf
		{
			public $OptsFenetreEdit = array("Largeur" => 450, 'Hauteur' => 325, 'Modal' => 1, "BoutonFermer" => 0) ;
			public $OptsFenetreDetail = array("Largeur" => 675, 'Hauteur' => 525, 'Modal' => 1, "BoutonFermer" => 0) ;
			public $OptsFenetrePropos = array("Largeur" => 800, 'Hauteur' => 525, 'Modal' => 1, "BoutonFermer" => 0) ;
			protected function BDPrinc()
			{
				return $this->ApplicationParent->BDPrincipale ;
			}
			protected function CreeFournDonneesPrinc()
			{
				$fourn = new PvFournisseurDonneesSql() ;
				$fourn->BaseDonnees = $this->ApplicationParent->BDPrincipale ;
				return $fourn ;
			}
			public function AdopteZone($nom, & $zone)
			{
				parent::AdopteZone($nom, $zone) ;
				$this->DefinitExprs() ;
			}
			protected function DefinitExprs()
			{
			}
		}

		class ScriptListCotationTransfDevTradPlatf extends ScriptBaseCotationTransfDevTradPlatf
		{
			public $TablPrinc ;
			public function DetermineEnvironnement()
			{
				$this->DetermineTablPrinc() ;
			}
			protected function DetermineTablPrinc()
			{
				$this->TablPrinc = $this->CreeTablPrinc() ;
				$this->TablPrinc->AdopteScript('tablPrinc', $this) ;
				$this->TablPrinc->ChargeConfig() ;
				$this->ChargeTablPrinc() ;
			}
			protected function CreeTablPrinc()
			{
				return new TableauDonneesOperationTradPlatf() ;
			}
			protected function ChargeTablPrinc()
			{
				$this->FournDonneesPrinc = $this->CreeFournDonneesPrinc() ;
				$this->TablPrinc->FournisseurDonnees = & $this->FournDonneesPrinc ;
			}
			protected function RenduDispositifBrut()
			{
				$ctn = '' ;
				$ctn .= $this->TablPrinc->RenduDispositif() ;
				return $ctn ;
			}
		}
		class ScriptEditCotationTransfDevTradPlatf extends ScriptBaseCotationTransfDevTradPlatf
		{
			public $FormPrinc ;
			public function DetermineEnvironnement()
			{
				$this->DetermineFormPrinc() ;
			}
			protected function DetermineFormPrinc()
			{
				$this->FormPrinc = $this->CreeFormPrinc() ;
				$this->InitFormPrinc() ;
				$this->FormPrinc->AdopteScript('formPrinc', $this) ;
				$this->FormPrinc->ChargeConfig() ;
				$this->ChargeFormPrinc() ;
			}
			protected function CreeFormPrinc()
			{
				return new FormulaireDonneesBaseTradPlatf() ;
			}
			protected function InitFormPrinc()
			{
				$this->FormPrinc->NomClasseCommandeAnnuler = "PvCmdFermeFenetreActiveAdminDirecte" ;
			}
			protected function ChargeFormPrinc()
			{
				$this->FournDonneesPrinc = $this->CreeFournDonneesPrinc() ;
				$this->FormPrinc->FournisseurDonnees = & $this->FournDonneesPrinc ;
			}
			protected function RenduDispositifBrut()
			{
				$ctn = '' ;
				$ctn .= $this->FormPrinc->RenduDispositif() ;
				return $ctn ;
			}
		}
		
		class Script1CotationTransfDevTradPlatf extends ScriptListCotationTransfDevTradPlatf
		{
			public $BarreMenu ;
			public $SousMenuPublier ;
			public $SousMenuConsult ;
			public $SousMenuPropos ;
			public function DetermineEnvironnement()
			{
				parent::DetermineEnvironnement() ;
				$this->DetermineBarreMenu() ;
			}
			protected function DetermineBarreMenu()
			{
				$this->BarreMenu = new PvTablMenuHoriz() ;
				$this->BarreMenu->NomClasseCSSCellSelect = "ui-widget ui-widget-header ui-state-focus" ;
				$this->BarreMenu->AdopteScript("barreMenu", $this) ;
				$this->BarreMenu->ChargeConfig() ;
				// Consultation
				if($this->ZoneParent->PossedePrivilege('post_op_change'))
				{
					$this->SousMenuConsult = $this->BarreMenu->MenuRacine->InscritSousMenuScript('consultCotationTransfDev') ;
					$this->SousMenuConsult->CheminMiniature = "images/miniatures/consulte_achat_devise.png" ;
					$this->SousMenuConsult->Titre = "Consultation" ;
				}
				if($this->ZoneParent->PossedePrivilege('post_doc_entreprise'))
				{
					// Publication
					$this->SousMenuPublier = $this->BarreMenu->MenuRacine->InscritSousMenuScript('publierCotationTransfDev') ;
					$this->SousMenuPublier->CheminMiniature = "images/miniatures/consulte_achat_devise.png" ;
					$this->SousMenuPublier->Titre = "Publications" ;
					// Propositions
					$this->SousMenuPropos = $this->BarreMenu->MenuRacine->InscritSousMenuScript('proposCotationTransfDev') ;
					$this->SousMenuPropos->CheminMiniature = "images/miniatures/consulte_achat_devise.png" ;
					$this->SousMenuPropos->Titre = "consultation cotation" ;
				}
			}
			protected function RenduDispositifBrut()
			{
				$ctn = '' ;
				$ctn .= $this->BarreMenu->RenduDispositif() ;
				$ctn .= parent::RenduDispositifBrut() ;
				// print_r($this->TablPrinc->FournisseurDonnees->BaseDonnees) ;
				return $ctn ;
			}
		}
		
		class ScriptPublierCotationTransfDevTradPlatf extends Script1CotationTransfDevTradPlatf
		{
			public $Privileges = array('post_doc_entreprise') ;
			public $CmdAjout ;
			public $LienModif ;
			public $LienSuppr ;
			public $FournDonneesPrinc ;
			public $DefColId ;
			public $DefColNumOp ;
			public $DefColDateOper ;
			public $DefColMontant ;
			public $DefColDevise ;
			public $DefColDateValeur ;
			public $FltDateDebut ;
			public $FltDateFin ;
			public $FltNumOpPubl ;
			protected function ChargeTablPrinc()
			{
				parent::ChargeTablPrinc() ;
				$bd = $this->BDPrinc() ;
				$this->FltDateDebut = $this->TablPrinc->InsereFltSelectHttpGet("dateDebut", "date_valeur >= <self>") ;
				$this->FltDateFin = $this->TablPrinc->InsereFltSelectHttpGet("dateFin", "date_valeur <= <self>") ;
				$this->FltNumOpPubl = $this->TablPrinc->InsereFltSelectFixe("numOpPublieur", $this->ZoneParent->IdMembreConnecte(), "numop_publieur = <self>") ;
				$this->FltDateDebut->Libelle = "Periode du" ;
				$this->FltDateDebut->DeclareComposant("PvCalendarDateInput") ;
				$this->FltDateFin->Libelle = "au" ;
				$this->FltDateFin->DeclareComposant("PvCalendarDateInput") ;
				$this->TablPrinc->SensColonneTri = "desc" ;
				$this->TablPrinc->AccepterTriColonneInvisible = 1 ;
				$this->DefColId = $this->TablPrinc->InsereDefColCachee('id') ;
				$this->DefColNumOp = $this->TablPrinc->InsereDefColCachee('numop_publieur') ;
				$this->DefColDateOper = $this->TablPrinc->InsereDefCol('date_operation', 'Date operation') ;
				$this->DefColDateOper->AliasDonnees = $bd->SqlDateToStrFr("date_operation", 0) ;
				$this->DefColMontant = $this->TablPrinc->InsereDefColMoney('montant', 'Montant') ;
				$this->DefColDevise = $this->TablPrinc->InsereDefCol('code_devise', 'Devise') ;
				$this->DefColDateValeur = $this->TablPrinc->InsereDefCol('date_valeur', 'Date valeur') ;
				$this->DefColDateValeur->AliasDonnees = $bd->SqlDateToStrFr("date_valeur", 0) ;
				$this->FournDonneesPrinc->RequeteSelection = '(SELECT t1.*, d1.code_devise
FROM cotation_transf_devise t1
left join devise d1 on t1.id_devise = d1.id_devise)' ;
				$this->DefColActs = $this->TablPrinc->InsereDefColActions("Actions") ;
				$this->LienModif = $this->TablPrinc->InsereLienOuvreFenetreAction($this->DefColActs, '?appelleScript=modifCotationTransfDev&id=${id}', 'Modifier', 'modif_emiss_obligation_${id}', 'Modifier cotation transfert de devise #${id}', $this->OptsFenetreEdit, "") ;
				$this->LienModif->ClasseCSS = "lien-act-001" ;
				$this->LienModif->DefinitScriptOnglActifSurFerm($this) ;
				$this->LienSuppr = $this->TablPrinc->InsereLienOuvreFenetreAction($this->DefColActs, '?appelleScript=supprCotationTransfDev&id=${id}', 'Supprimer', 'suppr_emiss_obligation_${id}', 'Supprimer cotation transfert de devise #${id}', $this->OptsFenetreEdit, "") ;
				$this->LienSuppr->ClasseCSS = "lien-act-002" ;
				$this->LienModif->DefinitScriptOnglActifSurFerm($this) ;
				$this->CmdAjout = $this->TablPrinc->InsereCmdOuvreFenetreScript("ajoutCotationTransfDev", '?appelleScript=ajoutCotationTransfDev', 'Ajouter', 'ajoutCotationTransfDev', "Poster une cotation transfert de devise", $this->OptsFenetreEdit, "") ;
				$this->CmdAjout->DefinitScriptOnglActifSurFerm($this) ;
			}
			protected function DefinitExprs()
			{
				$this->Titre = $this->ZoneParent->FournExprs->TitrFenPublierCotationTransfDev ;
			}
		}
		class ScriptConsultCotationTransfDevTradPlatf extends Script1CotationTransfDevTradPlatf
		{
			public $Privileges = array('post_op_change') ;
			public $LienReserv ;
			public $FournDonneesPrinc ;
			public $DefColId ;
			public $DefColNumOp ;
			public $DefColLoginOp ;
			public $DefColDateValeur ;
			public $DefColMontant ;
			public $DefColTaux ;
			public $DefColDevise ;
			public $FltDateDebut ;
			public $FltDateFin ;
			public $FltNumOpPubl ;
			public $FltNumOpRep ;
			public $FltRelActive ;
			protected function ChargeTablPrinc()
			{
				parent::ChargeTablPrinc() ;
				$bd = $this->BDPrinc() ;
				$this->FltNumOpRep = $this->TablPrinc->InsereFltSelectFixe("fltNumOpRep", $this->ZoneParent->IdMembreConnecte(), "numop_repondeur = <self>") ;
				if(! $this->ZoneParent->PossedePrivilege("super_admin"))
				{
					$this->FltRelActive = $this->TablPrinc->InsereFltSelectFixe("fltRelActive", 1, "top_active = <self>") ;
				}
				$this->FltDateDebut = $this->TablPrinc->InsereFltSelectHttpGet("dateDebut", "date_valeur >= <self>") ;
				$this->FltDateFin = $this->TablPrinc->InsereFltSelectHttpGet("dateFin", "date_valeur <= <self>") ;
				$this->FltNumOpPubl = $this->TablPrinc->InsereFltSelectFixe("numOpPublieur", $this->ZoneParent->IdMembreConnecte(), "numop_publieur <> <self>") ;
				$this->FltDateDebut->Libelle = "Periode du" ;
				$this->FltDateDebut->DeclareComposant("PvCalendarDateInput") ;
				$this->FltDateFin->Libelle = "au" ;
				$this->FltDateFin->DeclareComposant("PvCalendarDateInput") ;
				$this->TablPrinc->AccepterTriColonneInvisible = 1 ;
				$this->TablPrinc->SensColonneTri = "desc" ;
				$this->DefColId = $this->TablPrinc->InsereDefColCachee('id') ;
				$this->DefColNumOp = $this->TablPrinc->InsereDefColCachee('numop_publieur') ;
				$this->DefColLogin = $this->TablPrinc->InsereDefCol('login', 'Entreprise') ;
				$this->DefColMontant = $this->TablPrinc->InsereDefColMoney('montant', 'Montant') ;
				$this->DefColDevise = $this->TablPrinc->InsereDefCol('code_devise', 'Devise') ;
				$this->DefColDateValeur = $this->TablPrinc->InsereDefCol('date_valeur', 'Date valeur') ;
				$this->DefColDateValeur->AliasDonnees = $bd->SqlDateToStrFr("date_valeur", 0) ;
				$this->FournDonneesPrinc->RequeteSelection = '(SELECT distinct t1.*, d1.code_devise, o1.login, t4.numop numop_repondeur, t4.id_entite, t3.top_active
FROM cotation_transf_devise t1
left join devise d1 on t1.id_devise = d1.id_devise
left join operateur o1 on t1.numop_publieur = o1.numop
left join rel_entreprise t3 on o1.id_entite = t3.id_entite_source
left join operateur t4 on t3.id_entite_dest = t4.id_entite)' ;
				$this->DefColActs = $this->TablPrinc->InsereDefColActions("Actions") ;
				$this->LienReserv = $this->TablPrinc->InsereLienOuvreFenetreAction($this->DefColActs, '?appelleScript=ajoutReservCotationTransfDev&id_cotation=${id}', 'R&eacute;ponse', 'bordereau_decpte_transf_${id}', 'Bordereau d&eacute;compte transfert de devises #${id}', $this->OptsFenetrePropos) ;
				$this->LienReserv->ClasseCSS = "lien-act-004" ;
				$this->LienReserv->DefinitScriptOnglActifSurFerm($this) ;
			}
			protected function DefinitExprs()
			{
				$this->Titre = $this->ZoneParent->FournExprs->TitrFenConsultCotationTransfDev ;
			}
		}
		class ScriptProposCotationTransfDevTradPlatf extends Script1CotationTransfDevTradPlatf
		{
			public $Privileges = array('post_doc_entreprise') ;
			public $LienReserv ;
			public $FournDonneesPrinc ;
			public $DefColId ;
			public $DefColNumOp ;
			public $DefColRefTransact ;
			public $DefColDateValeur ;
			public $DefColMontant ;
			public $DefColTaux ;
			public $DefColDevise ;
			public $DefColDateEcheance ;
			public $FltDateDebut ;
			public $FltDateFin ;
			public $FltNumOpPubl ;
			protected function ChargeTablPrinc()
			{
				parent::ChargeTablPrinc() ;
				$bd = $this->BDPrinc() ;
				$this->FltDateDebut = $this->TablPrinc->InsereFltSelectHttpGet("dateDebut", "date_valeur >= <self>") ;
				$this->FltDateDebut->ValeurParDefaut = date("Y-m-d", date("u") - 86400 * 90) ;
				$this->FltDateFin = $this->TablPrinc->InsereFltSelectHttpGet("dateFin", "date_valeur <= <self>") ;
				$this->FltNumOpPubl = $this->TablPrinc->InsereFltSelectFixe("numOpPublieur", $this->ZoneParent->IdMembreConnecte(), "numop_publieur = <self>") ;
				$this->FltDateDebut->Libelle = "Periode du" ;
				$this->FltDateDebut->DeclareComposant("PvCalendarDateInput") ;
				$this->FltDateFin->Libelle = "au" ;
				$this->FltDateFin->DeclareComposant("PvCalendarDateInput") ;
				$this->DefColId = $this->TablPrinc->InsereDefColCachee('id') ;
				$this->DefColNumOp = $this->TablPrinc->InsereDefColCachee('numop_publieur') ;
				$this->DefColDateValeur = $this->TablPrinc->InsereDefCol('date_valeur', 'Date valeur') ;
				$this->DefColDateValeur->AliasDonnees = $bd->SqlDateToStrFr("date_valeur", 0) ;
				$this->DefColMontant = $this->TablPrinc->InsereDefColMoney('montant', 'Montant') ;
				$this->DefColDevise = $this->TablPrinc->InsereDefCol('code_devise', 'Devise') ;
				$this->FournDonneesPrinc->RequeteSelection = '(select t1.*, t2.total total_reserv, d1.code_devise from cotation_transf_devise t1
inner join (select id_cotation, count(0) total from bordereau_decpte_transf group by id_cotation) t2
on t1.id = t2.id_cotation
left join devise d1 on t1.id_devise = d1.id_devise)' ;
				$this->DefColActs = $this->TablPrinc->InsereDefColActions("Actions") ;
				$this->LienReserv = $this->TablPrinc->InsereLienOuvreFenetreAction($this->DefColActs, '?appelleScript=detailProposCotationTransfDev&id=${id}', 'Consultation', 'liste_reserv_transf_dev_${id}', 'Bordereaux de d&eacute;compte transfert #${id}', $this->OptsFenetrePropos) ;
				$this->LienReserv->ClasseCSS = "lien-act-004" ;
				$this->LienReserv->DefinitScriptOnglActifSurFerm($this) ;
			}
			protected function DefinitExprs()
			{
				$this->Titre = $this->ZoneParent->FournExprs->TitrFenProposCotationTransfDev ;
			}
		}
		
		class ScriptLgn1CotationTransfDevTradPlatf extends ScriptEditCotationTransfDevTradPlatf
		{
			public $FltId ;
			public $FltRefTransact ;
			public $FltDateOper ;
			public $FltMontant ;
			public $FltTaux ;
			public $FltDevise ;
			public $FltDateValeur ;
			public $FltDateEcheance ;
			public $CompDevise ;
			public $FltNumOp ;
			public $CompDateValeur ;
			public $CompDateEcheance ;
			public $NomClasseCmdExecFormPrinc = "PvCommandeAjoutElement" ;
			public $PourAjout = 1 ;
			public $PourDetail = 0 ;
			public $FormPrincEditable = 1 ;
			public $CritrNonVidePrinc ;
			public $CritrValidPrinc ;
			protected function DefinitExprs()
			{
				$this->Titre = $this->ZoneParent->FournExprs->TitrFenAjoutCotationTransfDev ;
			}
			protected function InitFormPrinc()
			{
				parent::InitFormPrinc() ;
				$this->FormPrinc->NomClasseCommandeExecuter = $this->NomClasseCmdExecFormPrinc ;
				$this->FormPrinc->InclureElementEnCours = ($this->PourAjout) ? 0 : 1 ;
				$this->FormPrinc->InclureTotalElements = ($this->PourAjout) ? 0 : 1 ;
				$this->FormPrinc->Editable = $this->FormPrincEditable ;
			}
			protected function ChargeFormPrinc()
			{
				parent::ChargeFormPrinc() ;
				$this->FltId = $this->FormPrinc->InsereFltLgSelectHttpGet('id', 'id = <self>') ;
				$this->FltNumOp = $this->FormPrinc->InsereFltEditFixe('numop', $this->ZoneParent->IdMembreConnecte(), 'numop_publieur') ;
				$this->FltDateOper = $this->FormPrinc->InsereFltEditHttpPost('date_operation', 'date_operation') ;
				$this->FltDateOper->Libelle = "Date operation" ;
				$this->FltDateOper->DeclareComposant("PvCalendarDateInput") ;
				$this->FltMontant = $this->FormPrinc->InsereFltEditHttpPost('montant', 'montant') ;
				$this->FltMontant->Libelle = "Montant" ;
				$this->FltDevise = $this->FormPrinc->InsereFltEditHttpPost('id_devise', 'id_devise') ;
				$this->FltDevise->Libelle = "Devise" ;
				$this->CompDevise = $this->FltDevise->DeclareComposant("PvZoneBoiteSelectHtml") ;
				$this->CompDevise->FournisseurDonnees = $this->CreeFournDonneesPrinc() ;
				$this->CompDevise->FournisseurDonnees->RequeteSelection = 'devise' ;
				$this->CompDevise->NomColonneValeur = 'id_devise' ;
				$this->CompDevise->NomColonneLibelle = 'code_devise' ;
				$this->FltDateValeur = $this->FormPrinc->InsereFltEditHttpPost('date_valeur', 'date_valeur') ;
				$this->FltDateValeur->Libelle = "Date valeur" ;
				$this->FltDateValeur->DeclareComposant("PvCalendarDateInput") ;
				$this->FournDonneesPrinc->RequeteSelection = "cotation_transf_devise" ;
				$this->FournDonneesPrinc->TableEdition = "cotation_transf_devise" ;
				$this->FormPrinc->MaxFiltresEditionParLigne = 1 ;
				if($this->FormPrinc->Editable == 1)
				{
					$this->CritrValidPrinc = $this->FormPrinc->CommandeExecuter->InsereNouvCritere(new CritrValidCotationTransfDevTradPlatf()) ;
					$this->CritrNonVidePrinc = $this->FormPrinc->CommandeExecuter->InsereNouvCritere(new PvCritereNonVide()) ;
					$this->CritrNonVidePrinc->FiltresCibles = array(&$this->FltMontant)  ;
				}
			}
			protected function AccesPossibleFormPrinc()
			{
				$ok = 0 ;
				if($this->PourAjout || $this->PourDetail)
					return 1 ;
				$bd = $this->BDPrinc() ;
				$total = $bd->FetchSqlValue('select count(0) total from bordereau_decpte_transf t1 where id_cotation=:id', array('id' => $this->FltId->Lie()), 'total') ;
				if(is_numeric($total))
				{
					if($total == 0)
					{
						$ok = 1 ;
					}
				}
				return $ok ;
			}
			protected function RenduDispositifBrut()
			{
				$ctn = '' ;
				if($this->AccesPossibleFormPrinc())
				{
					$ctn .= parent::RenduDispositifBrut() ;
				}
				else
				{
					$ctn .= '<div class="ui-widget ui-state-error">Cette &eacute;mission a &eacute;t&eacute; r&eacute;serv&eacute;e au moins une fois</div>' ;
				}
				return $ctn ;
			}
		}
		class ScriptAjoutCotationTransfDevTradPlatf extends ScriptLgn1CotationTransfDevTradPlatf
		{
			protected function DefinitExprs()
			{
				$this->Titre = $this->ZoneParent->FournExprs->TitrFenModifCotationTransfDev ;
			}
		}
		class ScriptModifCotationTransfDevTradPlatf extends ScriptLgn1CotationTransfDevTradPlatf
		{
			public $NomClasseCmdExecFormPrinc = "PvCommandeModifElement" ;
			public $PourAjout = 0 ;
			protected function DefinitExprs()
			{
				$this->Titre = $this->ZoneParent->FournExprs->TitrFenModifCotationTransfDev ;
			}
		}
		class ScriptSupprCotationTransfDevTradPlatf extends ScriptModifCotationTransfDevTradPlatf
		{
			public $NomClasseCmdExecFormPrinc = "PvCommandeSupprElement" ;
			public $FormPrincEditable = 0 ;
			protected function DefinitExprs()
			{
				$this->Titre = $this->ZoneParent->FournExprs->TitrFenSupprCotationTransfDev ;
			}
		}
		
		class ScriptDetailProposCotationTransfDevTradPlatf extends ScriptModifCotationTransfDevTradPlatf
		{
			public $PourDetail = 1 ;
			public $LienModifSecond ;
			public $LienSupprSecond ;
			public $TablSecond ;
			public $CmdAjoutSecond ;
			public $FltNumOpTablSecond ;
			public $FltIdTablSecond ;
			public $DefColIdTablSecond ;
			public $DefColLoginTablSecond ;
			public $DefColNomEntiteTablSecond ;
			public $DefColActsTablSecond ;
			public function DetermineEnvironnement()
			{
				parent::DetermineEnvironnement() ;
				$this->FormPrinc->Editable = 0 ;
				$this->FormPrinc->CacherBlocCommandes = 1 ;
				$this->DetermineTablSecond() ;
			}
			protected function CreeTablSecond()
			{
				return new TableauDonneesOperationTradPlatf() ;
			}
			protected function DetermineTablSecond()
			{
				$this->TablSecond = $this->CreeTablSecond() ;
				$this->TablSecond->AdopteScript('tablSecond', $this) ;
				$this->TablSecond->ChargeConfig() ;
				$this->ChargeTablSecond() ;
			}
			protected function ChargeTablSecond()
			{
				$this->FltIdTablSecond = $this->TablSecond->InsereFltSelectHttpGet('id', 'id_cotation = <self>') ;
				// $this->FltNumOpTablSecond = $this->TablSecond->InsereFltSelectFixe('numOpDemandeur', $this->ZoneParent->IdMembreConnecte(), 'numop_demandeur = <self>') ;
				$this->TablSecond->CacherFormulaireFiltres = 1 ;
				$this->DefColIdTablSecond = $this->TablSecond->InsereDefColCachee('id') ;
				$this->DefColLoginTablSecond = $this->TablSecond->InsereDefCol('login') ;
				$this->DefColNomEntiteTablSecond = $this->TablSecond->InsereDefCol('nom_entite') ;
				$this->DefColActsTablSecond = $this->TablSecond->InsereDefColActions('Actions') ;
				$this->FournDonneesSecond = $this->CreeFournDonneesPrinc() ;
				$this->FournDonneesSecond->RequeteSelection = '(select t1.*, t2.login, t3.name nom_entite from bordereau_decpte_transf t1 left join operateur t2 on t1.numop_demandeur = t2.numop left join entite t3 on t2.id_entite = t3.id_entite)' ;
				$this->TablSecond->FournisseurDonnees = & $this->FournDonneesSecond ;
				$this->LienModifSecond = $this->TablSecond->InsereLienOuvreFenetreAction($this->DefColActsTablSecond, '?appelleScript=modifReservCotationTransfDev&id=${id}', 'Consultation', 'modif_reserv_emiss_obligation_${id}', 'D&eacute;tails bordereau de d&eacute;compte #${id}', $this->OptsFenetreDetail) ;
				$this->LienModifSecond->ClasseCSS = "lien-act-001" ;
			}
			protected function DefinitExprs()
			{
				$this->Titre = $this->ZoneParent->FournExprs->TitrFenDetailProposCotationTransfDev ;
			}
			protected function RenduDispositifBrut()
			{
				$ctn = parent::RenduDispositifBrut() ;
				if($this->FormPrinc->ElementEnCoursTrouve == 1)
				{
					$ctn .= '<div class="ui-widget ui-widget-content">' ;
					$ctn .= $this->TablSecond->RenduDispositif() ;
					// print_r($this->TablSecond->FournisseurDonnees) ;
					$ctn .= '</div>' ;
				}
				return $ctn ;
			}
		}
		
		class ScriptListReservCotationTransfDevTradPlatf extends ScriptModifCotationTransfDevTradPlatf
		{
			public $PourDetail = 1 ;
			public $TablSecond ;
			public $FltNumOpTablSecond ;
			public $FltIdTablSecond ;
			public $DefColIdTablSecond ;
			public $DefColEntiteTablSecond ;
			public $DefColCodeEntiteTablSecond ;
			public $DefColMontantTablSecond ;
			public $DefColActsTablSecond ;
			public $LienDetailsTablSecond ;
			public function DetermineEnvironnement()
			{
				parent::DetermineEnvironnement() ;
				$this->FormPrinc->Editable = 0 ;
				$this->FormPrinc->CacherBlocCommandes = 1 ;
				$this->DetermineTablSecond() ;
			}
			protected function CreeTablSecond()
			{
				return new TableauDonneesOperationTradPlatf() ;
			}
			protected function DetermineTablSecond()
			{
				$this->TablSecond = $this->CreeTablSecond() ;
				$this->TablSecond->AdopteScript('tablSecond', $this) ;
				$this->TablSecond->ChargeConfig() ;
				$this->ChargeTablSecond() ;
			}
			protected function ChargeTablSecond()
			{
				$this->FltIdTablSecond = $this->TablSecond->InsereFltSelectHttpGet('id', 'id_cotation = <self>') ;
				$this->TablSecond->CacherFormulaireFiltres = 1 ;
				$this->DefColIdTablSecond = $this->TablSecond->InsereDefColCachee('id') ;
				$this->DefColIdEmissTablSecond = $this->TablSecond->InsereDefColCachee('id_cotation') ;
				$this->DefColNumOpTablSecond = $this->TablSecond->InsereDefColCachee('numop') ;
				$this->DefColLoginTablSecond = $this->TablSecond->InsereDefCol('login', "Login") ;
				$this->DefColLoginTablSecond->AlignElement = "center" ;
				$this->DefColCodeEntiteTablSecond = $this->TablSecond->InsereDefCol('code_entite', "Code entit&eacute;") ;
				$this->DefColCodeEntiteTablSecond->AlignElement = "center" ;
				$this->DefColEntiteTablSecond = $this->TablSecond->InsereDefCol('nom_entite', "Entit&eacute;") ;
				$this->DefColMontantTablSecond = $this->TablSecond->InsereDefColMoney('montant', "Montant") ;
				$this->DefColMontantTablSecond->AlignElement = "right" ;
				/*
				$this->DefColActsTablSecond = $this->TablSecond->InsereDefColActions("Actions") ;
				$this->LienDetailsTablSecond = $this->TablSecond->InsereLienOuvreFenetreAction($this->DefColActsTablSecond, '?appelleScript=detailReservCotationTransfDev&id=${id_cotation}&numop=${numop}', 'D&eacute;tails', 'details_reserv_emiss_obligation_${id}_${numop}', 'Details cotation transfert de devise #${login}', $this->OptsFenetreDetail) ;
				*/
				$this->FournDonneesSecond = $this->CreeFournDonneesPrinc() ;
				$this->FournDonneesSecond->RequeteSelection = '(select t1.*, t2.numop, t2.login, t2.nomop, t2.prenomop, t3.name nom_entite, t3.code code_entite
from bordereau_decpte_transf t1
left join operateur t2
on t1.numop_demandeur = t2.numop
left join entite t3
on t2.id_entite = t3.id_entite)' ;
				$this->TablSecond->FournisseurDonnees = & $this->FournDonneesSecond ;
			}
			protected function RenduDispositifBrut()
			{
				$ctn = parent::RenduDispositifBrut() ;
				if($this->FormPrinc->ElementEnCoursTrouve == 1)
				{
					$ctn .= '<div class="ui-widget ui-widget-content">' ;
					$ctn .= $this->TablSecond->RenduDispositif() ;
					// print_r($this->TablSecond->FournisseurDonnees) ;
					$ctn .= '</div>' ;
				}
				return $ctn ;
			}
			protected function DefinitExprs()
			{
				$this->Titre = $this->ZoneParent->FournExprs->TitrFenListReservCotationTransfDev ;
			}
		}
		class ScriptDetailReservCotationTransfDevTradPlatf extends ScriptListCotationTransfDevTradPlatf
		{
			public $DefColLogin ;
			public $DefColEntite ;
			public $DefColMontant ;
			public $DefColTaux ;
			public $FltId ;
			public $FltNumOp ;
			protected function DetermineTablPrinc()
			{
				parent::DetermineTablPrinc() ;
				$this->FltId = $this->TablPrinc->InsereFltSelectHttpGet('id', 'id_cotation = <self>') ;
				$this->FltId->Obligatoire = 1 ;
				$this->FltNumOp = $this->TablPrinc->InsereFltSelectHttpGet('numop', 'numop= <self>') ;
				$this->FltNumOp->Obligatoire = 1 ;
				$this->TablPrinc->CacherFormulaireFiltres = 1 ;
				$this->TablPrinc->CacherBlocCommandes = 1 ;
				$this->TablPrinc->ToujoursAfficher = 1 ;
				$this->DefColEntite = $this->TablPrinc->InsereDefCol('nom_entite', 'Entit&eacute;') ;
				$this->DefColLogin = $this->TablPrinc->InsereDefCol('login', 'Login') ;
				$this->DefColMontant = $this->TablPrinc->InsereDefCol('montant', 'Montant') ;
				$this->DefColTaux = $this->TablPrinc->InsereDefCol('taux', 'Taux') ;
				$this->FournDonneesPrinc->RequeteSelection = '(select t1.*, t2.numop, t2.login, t2.nomop, t2.prenomop, t3.name nom_entite
from bordereau_decpte_transf t1
left join operateur t2
on t1.numop_demandeur = t2.numop
left join entite t3
on t2.id_entite = t3.id_entite)' ;
			}
		}
		
		class ScriptLng1ReservCotationTransfDevTradPlatf extends ScriptEditCotationTransfDevTradPlatf
		{
			public $FltId ;
			public $FltIdCotation ;
			public $FltNumOp ;
			public $FltContreValeurDev ;
			public $FltValDevise ;
			public $FltTaxeTransf ;
			public $FltCommissTransf ;
			public $FltFraisFixes ;
			public $FltFraisDossier ;
			public $FltCommissFinex ;
			public $FltFraisTelex ;
			public $FltTPS ;
			public $FltDevise ;
			public $FltTauxDevise ;
			public $FltTauxTaxeTransf ;
			public $FltTauxCommTransf ;
			public $NomClasseCmdExecFormPrinc = "CmdAjoutReservCotationTransfDevTradPlatf" ;
			public $PourAjout = 1 ;
			public $FormPrincEditable = 1 ;
			public $LgnParDefaut = array() ;
			protected function DefinitExprs()
			{
				$this->Titre = $this->ZoneParent->FournExprs->TitrFenAjoutReservCotationTransfDev ;
			}
			protected function InitFormPrinc()
			{
				parent::InitFormPrinc() ;
				$this->FormPrinc->NomClasseCommandeExecuter = $this->NomClasseCmdExecFormPrinc ;
				$this->FormPrinc->InclureElementEnCours = ($this->PourAjout) ? 0 : 1 ;
				$this->FormPrinc->InclureTotalElements = ($this->PourAjout) ? 0 : 1 ;
				$this->FormPrinc->Editable = $this->FormPrincEditable ;
			}
			protected function ChargeFormPrinc()
			{
				parent::ChargeFormPrinc() ;
				$this->FltId = $this->FormPrinc->InsereFltLgSelectHttpGet('id', 'id = <self>') ;
				$this->FltIdCotation = $this->FormPrinc->InsereFltEditHttpGet('id_cotation', 'id_cotation') ;
				$this->FltIdCotation->LectureSeule = 1 ;
				$this->FltNumOp = $this->FormPrinc->InsereFltEditFixe('numop', $this->ZoneParent->IdMembreConnecte(), 'numop_demandeur') ;
				$this->FltContreValeurDev = $this->FormPrinc->InsereFltEditHttpPost('contre_valeur_devise', 'contre_valeur_devise') ;
				$this->FltContreValeurDev->Libelle = "Contrevaleur devise" ;
				$this->FltTaxeTransf = $this->FormPrinc->InsereFltEditHttpPost('taxe_transf', 'taxe_transf') ;
				$this->FltValDevise = $this->FormPrinc->InsereFltEditHttpPost('valeur_devise', 'valeur_devise') ;
				$this->FltValDevise->ObtientComposant()->Largeur = "30px" ;
				$this->FltTaxeTransf->Libelle = "Taxe de transfert" ;
				$this->FltCommissTransf = $this->FormPrinc->InsereFltEditHttpPost('commiss_transf', 'commiss_transf') ;
				$this->FltCommissTransf->Libelle = "Commission de transfert" ;
				$this->FltFraisFixes = $this->FormPrinc->InsereFltEditHttpPost('frais_fixes', 'frais_fixes') ;
				$this->FltFraisFixes->Libelle = "Frais Fixes" ;
				$this->FltFraisDossier = $this->FormPrinc->InsereFltEditHttpPost('frais_dossier', 'frais_dossier') ;
				$this->FltFraisDossier->Libelle = "Frais de dossiers" ;
				$this->FltCommissFinex = $this->FormPrinc->InsereFltEditHttpPost('commiss_finex', 'commiss_finex') ;
				$this->FltCommissFinex->Libelle = "Commission de FINEX" ;
				$this->FltFraisTelex = $this->FormPrinc->InsereFltEditHttpPost('frais_telex', 'frais_telex') ;
				$this->FltFraisTelex->Libelle = "Frais de T&eacute;lex" ;
				$this->FltTPS = $this->FormPrinc->InsereFltEditHttpPost('tps', 'tps') ;
				$this->FltTPS->Libelle = "TPS 10%" ;
				$this->FltDevise = $this->FormPrinc->InsereFltEditHttpPost('id_devise', 'id_devise') ;
				$this->FltDevise->Libelle = "Devise" ;
				$this->CompDevise = $this->FltDevise->DeclareComposant("PvZoneBoiteSelectHtml") ;
				$this->CompDevise->FournisseurDonnees = $this->CreeFournDonneesPrinc() ;
				$this->CompDevise->FournisseurDonnees->RequeteSelection = 'devise' ;
				$this->CompDevise->NomColonneValeur = 'id_devise' ;
				$this->CompDevise->NomColonneLibelle = 'code_devise' ;
				$this->FltTauxDevise = $this->FormPrinc->InsereFltEditHttpPost('taux_devise', 'taux_devise') ;
				$this->FltTauxDevise->Libelle = "Taux devise" ;
				$this->FltTauxTaxeTransf = $this->FormPrinc->InsereFltEditHttpPost('taux_taxe_transf', 'taux_taxe_transf') ;
				$this->FltTauxTaxeTransf->Libelle = "Taux taxe transfert" ;
				$this->FltTauxCommTransf = $this->FormPrinc->InsereFltEditHttpPost('taux_comm_transf', 'taux_comm_transf') ;
				$this->FltTauxCommTransf->Libelle = "Taux comm. transfert" ;
				$this->FournDonneesPrinc->RequeteSelection = "bordereau_decpte_transf" ;
				$this->FournDonneesPrinc->TableEdition = "bordereau_decpte_transf" ;
				$this->FormPrinc->MaxFiltresEditionParLigne = 1 ;
				$this->FormPrinc->DessinateurFiltresEdition = new DessinFltsBordereauDecpteTransf() ;
			}
			protected function AccesPossibleFormPrinc()
			{
				$ok = 1 ;
				return $ok ;
			}
			protected function CalculeLgnParDefaut()
			{
				if(! $this->PourAjout)
					return ;
				$idLgnEmiss = $this->FltIdCotation->Lie() ;
				// print 'MM : '.$idLgnEmiss ;
				$bd = $this->BDPrinc() ; ;
				$lgn = $bd->FetchSqlRow('select * from bordereau_decpte_transf where id_cotation='.$bd->ParamPrefix.'id and numop_demandeur='.$bd->ParamPrefix.'numop', array('id' => $idLgnEmiss, 'numop' => $this->ZoneParent->IdMembreConnecte())) ;
				if(is_array($lgn) && count($lgn) > 0)
				{
					$this->FltContreValeurDev->ValeurParDefaut = $lgn["contre_valeur_devise"] ;
					$this->FltValDevise->ValeurParDefaut = $lgn["valeur_devise"] ;
					$this->FltTaxeTransf->ValeurParDefaut = $lgn["taxe_transf"] ;
					$this->FltCommissTransf->ValeurParDefaut = $lgn["commiss_transf"] ;
					$this->FltFraisFixes->ValeurParDefaut = $lgn["frais_fixes"] ;
					$this->FltFraisDossier->ValeurParDefaut = $lgn["frais_dossier"] ;
					$this->FltCommissFinex->ValeurParDefaut = $lgn["commiss_finex"] ;
					$this->FltFraisTelex->ValeurParDefaut = $lgn["frais_telex"] ;
					$this->FltTPS->ValeurParDefaut = $lgn["tps"] ;
					$this->FltDevise->ValeurParDefaut = $lgn["id_devise"] ;
					$this->FltTauxDevise->ValeurParDefaut = $lgn["taux_devise"] ;
					$this->FltTauxTaxeTransf->ValeurParDefaut = $lgn["taux_taxe_transf"] ;
					$this->FltTauxCommTransf->ValeurParDefaut = $lgn["taux_comm_transf"] ;
				}
			}
			protected function RenduDispositifBrut()
			{
				$ctn = '' ;
				if($this->AccesPossibleFormPrinc())
				{
					$this->CalculeLgnParDefaut() ;
					$ctn .= parent::RenduDispositifBrut() ;
				}
				else
				{
					$ctn .= '<div class="ui-widget ui-state-error">Cette &eacute;mission a &eacute;t&eacute; r&eacute;serv&eacute;e au moins une fois</div>' ;
				}
				return $ctn ;
			}
		}
		class ScriptAjoutReservCotationTransfDevTradPlatf extends ScriptLng1ReservCotationTransfDevTradPlatf
		{
			public $PourAjout = 1 ;
		}
		class ScriptModifReservCotationTransfDevTradPlatf extends ScriptLng1ReservCotationTransfDevTradPlatf
		{
			public $NomClasseCmdExecFormPrinc = "PvCommandeModifElement" ;
			public $PourAjout = 0 ;
			protected function InitFormPrinc()
			{
				parent::InitFormPrinc() ;
				$this->FormPrinc->InscrireCommandeExecuter = 0 ;
			}
			protected function DefinitExprs()
			{
				$this->Titre = $this->ZoneParent->FournExprs->TitrFenModifReservCotationTransfDev ;
			}
		}
		class ScriptSupprReservCotationTransfDevTradPlatf extends ScriptModifReservCotationTransfDevTradPlatf
		{
			public $NomClasseCmdExecFormPrinc = "PvCommandeSupprElement" ;
			public $FormPrincEditable = 0 ;
			protected function DefinitExprs()
			{
				$this->Titre = $this->ZoneParent->FournExprs->TitrFenSupprReservCotationTransfDev ;
			}
		}
		
		class DessinFltsBordereauDecpteTransf extends PvDessinateurRenduHtmlFiltresDonnees
		{
			public function Execute(& $script, & $composant, $parametres)
			{
				$composant->LieTousLesFiltres() ;
				$ctn = '' ;
				$ctn .= '<style type="text/css">
	#'.$composant->IDInstanceCalc.' input:disabled, .champ-calc {
		color:black ;
		background-color:white;
		border:1px solid #090909;
		padding:2px ;
	}
</style>'.PHP_EOL ;
				$ctn .= '<input type="hidden" id="'.$script->FltIdCotation->ObtientIDComposant().'" name="'.$script->FltIdCotation->ObtientNomComposant().'" value="'.htmlentities($script->FltIdCotation->Lie()).'" />' ;
				$ctn .= '<table width="100%" cellspacing="0" cellpadding="4">'.PHP_EOL ;
				$ctn .= '<tr>
<td>'.$this->RenduLibelleFiltre($script->FltContreValeurDev).'</td>
<td>'.$script->FltContreValeurDev->Rendu().'</td>
<td></td>
<td>'.$this->RenduLibelleFiltre($script->FltDevise).'</td>
<td>'.$script->FltDevise->Rendu().'</td>
<td>'.$script->FltValDevise->Rendu().'</td>
<td>'.$this->RenduLibelleFiltre($script->FltTauxDevise).'</td>
<td><div id="val_taux_devise" class="champ-calc"></div></td>
</tr>'.PHP_EOL ;
				$ctn .= '<tr>
<td>'.$this->RenduLibelleFiltre($script->FltTaxeTransf).'</td>
<td>'.$script->FltTaxeTransf->Rendu().'</td>
<td colspan="4">&nbsp;</td>
<td>'.$this->RenduLibelleFiltre($script->FltTauxTaxeTransf).'</td>
<td><div id="val_taux_taxe_transf" class="champ-calc"></div></td>
</tr>'.PHP_EOL ;
				$ctn .= '<tr>
<td>'.$this->RenduLibelleFiltre($script->FltCommissTransf).'</td>
<td>'.$script->FltCommissTransf->Rendu().'</td>
<td colspan="4">&nbsp;</td>
<td>'.$this->RenduLibelleFiltre($script->FltTauxCommTransf).'</td>
<td><div id="val_taux_commiss_transf" class="champ-calc"></div></td>
</tr>'.PHP_EOL ;
				$ctn .= '<tr>
<td>'.$this->RenduLibelleFiltre($script->FltFraisFixes).'</td>
<td>'.$script->FltFraisFixes->Rendu().'</td>
<td colspan="5">&nbsp;</td>
</tr>'.PHP_EOL ;
				$ctn .= '<tr>
<td>'.$this->RenduLibelleFiltre($script->FltFraisDossier).'</td>
<td>'.$script->FltFraisDossier->Rendu().'</td>
<td colspan="6">&nbsp;</td>
</tr>'.PHP_EOL ;
				$ctn .= '<tr>
<td>'.$this->RenduLibelleFiltre($script->FltCommissFinex).'</td>
<td>'.$script->FltCommissFinex->Rendu().'</td>
<td colspan="6">&nbsp;</td>
</tr>'.PHP_EOL ;
				$ctn .= '<tr>
<td>'.$this->RenduLibelleFiltre($script->FltFraisTelex).'</td>
<td>'.$script->FltFraisTelex->Rendu().'</td>
<td colspan="6">&nbsp;</td>
</tr>'.PHP_EOL ;
				$ctn .= '<tr>
<td>'.$this->RenduLibelleFiltre($script->FltTPS).'</td>
<td>'.$script->FltTPS->Rendu().'</td>
<td colspan="6">&nbsp;</td>
</tr>'.PHP_EOL ;
				$ctn .= '<tr>
<td>Total commissions et frais</td>
<td><div id="totalFraisCommiss" class="champ-calc">-</div></td>
<td colspan="6">&nbsp;</td>
</tr>'.PHP_EOL ;
				$ctn .= '<tr>
<td>MONTANT NET a payer</td>
<td><div id="mttNetPayer" class="champ-calc">-</div></td>
<td colspan="6">&nbsp;</td>
</tr>'.PHP_EOL ;
				$ctn .= '<tr>
<td>Co&ucirc;t du transfert</td>
<td><div id="coutTransf" class="champ-calc">-</div></td>
<td colspan="6">&nbsp;</td>
</tr>'.PHP_EOL ;
				$ctn .= '</table>' ;
				$ctn .= '<script type="text/javascript">
	function calculeTauxDevise() {
		var contreValDev = parseFloat(jQuery("#'.$script->FltContreValeurDev->ObtientIDComposant().'").val()) ;
		var valDev = parseFloat(jQuery("#'.$script->FltValDevise->ObtientIDComposant().'").val()) ;
		var tauxDevise = 0 ;
		if(! isNaN(valDev) && ! isNaN(contreValDev))
		{
			tauxDevise = valDev * contreValDev ;
			if(tauxDevise == NaN)
				tauxDevise = 0 ;
		}
		jQuery("#val_taux_devise").text(roundTo(tauxDevise, 3)) ;
		calculeTauxTaxeTransf() ;
		calculeTauxCommissTransf() ;
		calculeTotaux() ;
	}
	function calculeTotaux()
	{
		var val1 = toNumber(jQuery("#val_taux_devise").text()) ;
		var val2 = toNumber(jQuery("#val_taux_taxe_transf").text()) ;
		var val3 = toNumber(jQuery("#val_taux_commiss_transf").text()) ;
		var val4 = toNumber(jQuery("#'.$script->FltFraisFixes->ObtientIDComposant().'").val()) ;
		var val5 = toNumber(jQuery("#'.$script->FltFraisDossier->ObtientIDComposant().'").val()) ;
		var val6 = toNumber(jQuery("#'.$script->FltCommissFinex->ObtientIDComposant().'").val()) ;
		var val7 = toNumber(jQuery("#'.$script->FltFraisTelex->ObtientIDComposant().'").val()) ;
		// var val8 = toNumber(jQuery("#'.$script->FltTPS->ObtientIDComposant().'").val()) ;
		// var
		// alert((val3 + val4 + val5 + val6 + val7 * 0.1)) ;
		var fraisTPS = roundTo((val3 + val4 + val5 + val6 + val7) * 0.1, 3) ;
		// alert(val3) ;
		jQuery("#'.$script->FltTPS->ObtientIDComposant().'").val(fraisTPS) ;
		var totalFraisCommiss = roundTo(val2 + val3 + val4 + val5 + val6 + val7 + fraisTPS, 3) ;
		// alert(val4) ;
		jQuery("#totalFraisCommiss").text(totalFraisCommiss) ;
		jQuery("#mttNetPayer").text(roundTo(val1 + totalFraisCommiss, 3)) ;
		jQuery("#coutTransf").text(roundTo((val1 + totalFraisCommiss) / ((val1 > 0) ? val1 : 1), 8)) ;
	}
	function roundTo(val, decimalCount)
	{
		return +val.toFixed(decimalCount) ;
	}
	function toNumber(val)
	{
		return isNaN(parseFloat(val)) ? 0 : parseFloat(val) ;
	}
	function calculeTauxTaxeTransf() {
		var tauxDevise = parseFloat(jQuery("#val_taux_devise").text()) ;
		var valTaxeTransf = parseFloat(jQuery("#'.$script->FltTaxeTransf->ObtientIDComposant().'").val()) ;
		var valCalc = 0 ;
		if(! isNaN(tauxDevise) && ! isNaN(valTaxeTransf))
		{
			valCalc = tauxDevise * valTaxeTransf / 100 ;
		}
		jQuery("#val_taux_taxe_transf").text(roundTo(valCalc, 3)) ;
	}
	function calculeTauxCommissTransf() {
		var tauxDevise = parseFloat(jQuery("#val_taux_devise").text()) ;
		var valTauxCommTransf = parseFloat(jQuery("#'.$script->FltCommissTransf->ObtientIDComposant().'").val()) ;
		var valCalc = 0 ;
		if(! isNaN(tauxDevise) && ! isNaN(valTauxCommTransf))
		{
			valCalc = tauxDevise * valTauxCommTransf / 100 ;
			if(valCalc == NaN)
				valCalc = 0 ;
		}
		jQuery("#val_taux_commiss_transf").text(roundTo(valCalc, 3)) ;
	}
	jQuery(function() {
		jQuery("#'.$script->FltContreValeurDev->ObtientIDComposant().'").change(function () {
			calculeTauxDevise() ;
		}) ;
		jQuery("#'.$script->FltValDevise->ObtientIDComposant().'").change(function () {
			calculeTauxDevise() ;
		}) ;
		jQuery("#'.$script->FltTaxeTransf->ObtientIDComposant().'").change(function () {
			calculeTauxTaxeTransf() ;
		}) ;
		jQuery("#'.$script->FltCommissTransf->ObtientIDComposant().'").change(function () {
			calculeTauxCommissTransf() ;
		}) ;
		calculeTauxDevise() ;
	}) ;
	jQuery(function() {
		var allInputs = jQuery("#'.$composant->IDInstanceCalc.' :input") ;'.PHP_EOL ;
				if($script->PourAjout == 0)
				{
					$ctn .= '	allInputs.attr("readonly", true) ;
		allInputs.attr("disabled", true) ;
		jQuery("#'.$composant->IDInstanceCalc.' :button").attr("disabled", false) ;'.PHP_EOL ;
				}
				else
				{
					$ctn .= '	allInputs.change(function () {
		calculeTotaux() ;
	}) ;'.PHP_EOL ;
				}
				$ctn .= '}) ;' ;
				$ctn .= '</script>' ;
				return $ctn ;
			}
		}
		
		class CmdAjoutReservCotationTransfDevTradPlatf extends PvCommandeExecuterBase
		{
			public function ExecuteInstructions()
			{
				$bd = $this->ApplicationParent->BDPrincipale ;
				$form = & $this->FormulaireDonneesParent ;
				$script = & $this->ScriptParent ;
				$form->LieTousLesFiltres() ;
				$idCotisation = $script->FltIdCotation->Lie() ;
				$numOpDemandeur = $script->ZoneParent->IdMembreConnecte() ;
				$ok = $bd->RunSql('delete from bordereau_decpte_transf where id_cotation=:idCotisation and numop_demandeur=:numOpDemandeur', array('idCotisation' => $idCotisation, 'numOpDemandeur' => $numOpDemandeur)) ;
				if($ok)
				{
					$this->FormulaireDonneesParent->FournisseurDonnees->AjoutElement($this->FormulaireDonneesParent->FiltresEdition) ;
					$this->ConfirmeSucces() ;
				}
				else
				{
					$this->RenseigneErreur('Erreur SQL !!!') ;
				}
			}
		}
		
		class CritrValidCotationTransfDevTradPlatf extends PvCritereBase
		{
			public function EstRespecte()
			{
				$bd = $this->ApplicationParent->BDPrincipale ;
				$valDateValeur = $this->ScriptParent->FltDateValeur->Lie() ;
				$timestmpJour = date("U", strtotime(date("Y-m-d"))) ;
				$idCotisation = $this->ScriptParent->FltId->Lie() ;
				if(! $this->FormulaireDonneesParent->InclureElementEnCours)
				{
					$timestmpEmiss = strtotime($valDateValeur) ;
					if($timestmpJour > $timestmpEmiss)
					{
						$this->MessageErreur = 'La date de valeur ne doit pas &ecirc;tre anterieure &agrave; la date actuelle' ;
						return 0 ;
					}
				}
				/*
				$totEmissSimil = $bd->FetchSqlValue('select count(0) tot from cotation_transf_devise where id <> :idCotisation and ', array('refTransact' => $this->ScriptParent->FltRefTransact->Lie(), 'idCotisation' => $idCotisation), 'tot') ;
				if($totEmissSimil > 0)
				{
					$this->MessageErreur = 'Le num&eacute;ro de transaction a &eacute;t&eacute; utilis&eacute;' ;
					return 0 ;
				}
				*/
				return 1 ;
			}
		}
		
	}
	
?>
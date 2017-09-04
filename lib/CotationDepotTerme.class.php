<?php
	
	if(! defined('COTATION_DEPOT_TERME_TRAD_PLATF'))
	{
		define('COTATION_DEPOT_TERME_TRAD_PLATF', 1) ;
		
		class ScriptBaseCotationDepotTermeTradPlatf extends ScriptTransactBaseTradPlatf
		{
			public $OptsFenetreEdit = array("Largeur" => 450, 'Hauteur' => 325, 'Modal' => 1, "BoutonFermer" => 0) ;
			public $OptsFenetreDetail = array("Largeur" => 675, 'Hauteur' => 525, 'Modal' => 1, "BoutonFermer" => 0) ;
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

		class ScriptListCotationDepotTermeTradPlatf extends ScriptBaseCotationDepotTermeTradPlatf
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
		class ScriptEditCotationDepotTermeTradPlatf extends ScriptBaseCotationDepotTermeTradPlatf
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
		
		class Script1CotationDepotTermeTradPlatf extends ScriptListCotationDepotTermeTradPlatf
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
					$this->SousMenuConsult = $this->BarreMenu->MenuRacine->InscritSousMenuScript('consultCotationDepotTerme') ;
					$this->SousMenuConsult->CheminMiniature = "images/miniatures/consulte_achat_devise.png" ;
					$this->SousMenuConsult->Titre = "Consultation" ;
				}
				if($this->ZoneParent->PossedePrivilege('post_doc_entreprise'))
				{
					// Publication
					$this->SousMenuPublier = $this->BarreMenu->MenuRacine->InscritSousMenuScript('publierCotationDepotTerme') ;
					$this->SousMenuPublier->CheminMiniature = "images/miniatures/consulte_achat_devise.png" ;
					$this->SousMenuPublier->Titre = "Publications" ;
					// Propositions
					$this->SousMenuPropos = $this->BarreMenu->MenuRacine->InscritSousMenuScript('proposCotationDepotTerme') ;
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
		
		class ScriptPublierCotationDepotTermeTradPlatf extends Script1CotationDepotTermeTradPlatf
		{
			public $Privileges = array('post_doc_entreprise') ;
			public $CmdAjout ;
			public $LienModif ;
			public $LienSuppr ;
			public $FournDonneesPrinc ;
			public $DefColId ;
			public $DefColNumOp ;
			public $DefColDateMisePlace ;
			public $DefColDateMaturite ;
			public $DefColMontant ;
			public $DefColDevise ;
			public $FltDateDebut ;
			public $FltDateFin ;
			public $FltNumOpPubl ;
			protected function ChargeTablPrinc()
			{
				parent::ChargeTablPrinc() ;
				$bd = $this->BDPrinc() ;
				$this->FltDateDebut = $this->TablPrinc->InsereFltSelectHttpGet("dateDebut", "date_mise_place >= <self>") ;
				$this->FltDateFin = $this->TablPrinc->InsereFltSelectHttpGet("dateFin", "date_mise_place <= <self>") ;
				$this->FltNumOpPubl = $this->TablPrinc->InsereFltSelectFixe("numOpPublieur", $this->ZoneParent->IdMembreConnecte(), "numop_publieur = <self>") ;
				$this->FltDateDebut->Libelle = "Periode du" ;
				$this->FltDateDebut->DeclareComposant("PvCalendarDateInput") ;
				$this->FltDateFin->Libelle = "au" ;
				$this->FltDateFin->DeclareComposant("PvCalendarDateInput") ;
				$this->TablPrinc->SensColonneTri = "desc" ;
				$this->TablPrinc->AccepterTriColonneInvisible = 1 ;
				$this->DefColId = $this->TablPrinc->InsereDefColCachee('id') ;
				$this->DefColNumOp = $this->TablPrinc->InsereDefColCachee('numop_publieur') ;
				$this->DefColDateMisePlace = $this->TablPrinc->InsereDefCol('date_mise_place', 'Date mise en place') ;
				$this->DefColDateMisePlace->AliasDonnees = $bd->SqlDateToStrFr("date_mise_place", 0) ;
				$this->DefColDateMaturite = $this->TablPrinc->InsereDefCol('date_maturite', 'Date maturit&eacute;') ;
				$this->DefColDateMaturite->AliasDonnees = $bd->SqlDateToStrFr("date_maturite", 0) ;
				$this->DefColMontant = $this->TablPrinc->InsereDefColMoney('montant', 'Montant') ;
				$this->DefColDevise = $this->TablPrinc->InsereDefCol('code_devise', 'Devise') ;
				$this->FournDonneesPrinc->RequeteSelection = '(SELECT t1.*, d1.code_devise
FROM cotation_depot_terme t1
left join devise d1 on t1.id_devise = d1.id_devise)' ;
				$this->DefColActs = $this->TablPrinc->InsereDefColActions("Actions") ;
				$this->LienModif = $this->TablPrinc->InsereLienOuvreFenetreAction($this->DefColActs, '?appelleScript=modifCotationDepotTerme&id=${id}', 'Modifier', 'modif_emiss_obligation_${id}', 'Modifier cotation transfert de devise #${id}', $this->OptsFenetreEdit) ;
				$this->LienModif->ClasseCSS = "lien-act-001" ;
				$this->LienModif->DefinitScriptOnglActifSurFerm($this) ;
				$this->LienSuppr = $this->TablPrinc->InsereLienOuvreFenetreAction($this->DefColActs, '?appelleScript=supprCotationDepotTerme&id=${id}', 'Supprimer', 'suppr_emiss_obligation_${id}', 'Supprimer cotation transfert de devise #${id}', $this->OptsFenetreEdit) ;
				$this->LienSuppr->ClasseCSS = "lien-act-002" ;
				$this->LienSuppr->DefinitScriptOnglActifSurFerm($this) ;
				$this->CmdAjout = $this->TablPrinc->InsereCmdOuvreFenetreScript("ajoutCotationDepotTerme", '?appelleScript=ajoutCotationDepotTerme', 'Ajouter', 'ajoutCotationDepotTerme', "Poster une Cotation D&eacute;p&ocirc;t &agrave; terme", $this->OptsFenetreEdit) ;
				$this->CmdAjout->DefinitScriptOnglActifSurFerm($this) ;
			}
			protected function DefinitExprs()
			{
				$this->Titre = $this->ZoneParent->FournExprs->TitrFenPublierCotationDepotTerme ;
			}
		}
		class ScriptConsultCotationDepotTermeTradPlatf extends Script1CotationDepotTermeTradPlatf
		{
			public $Privileges = array('post_op_change') ;
			public $LienReserv ;
			public $FournDonneesPrinc ;
			public $DefColId ;
			public $DefColNumOp ;
			public $DefColLoginOp ;
			public $DefColDateMisePlace ;
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
				$this->FltDateDebut = $this->TablPrinc->InsereFltSelectHttpGet("dateDebut", "date_mise_place >= <self>") ;
				$this->FltDateFin = $this->TablPrinc->InsereFltSelectHttpGet("dateFin", "date_mise_place <= <self>") ;
				$this->FltNumOpPubl = $this->TablPrinc->InsereFltSelectFixe("numOpPublieur", $this->ZoneParent->IdMembreConnecte(), "numop_publieur <> <self>") ;
				$this->FltDateDebut->Libelle = "Periode du" ;
				$this->FltDateDebut->DeclareComposant("PvCalendarDateInput") ;
				$this->FltDateFin->Libelle = "au" ;
				$this->FltDateFin->DeclareComposant("PvCalendarDateInput") ;
				$this->TablPrinc->AccepterTriColonneInvisible = 1 ;
				$this->TablPrinc->SensColonneTri = "desc" ;
				$this->DefColId = $this->TablPrinc->InsereDefColCachee('id') ;
				$this->DefColNumOp = $this->TablPrinc->InsereDefColCachee('numop_publieur') ;
				$this->DefColLogin = $this->TablPrinc->InsereDefCol('login', 'Login') ;
				$this->DefColEntite = $this->TablPrinc->InsereDefCol('nom_entite', 'Entreprise') ;
				$this->DefColMontant = $this->TablPrinc->InsereDefColMoney('montant', 'Montant') ;
				$this->DefColDevise = $this->TablPrinc->InsereDefCol('code_devise', 'Devise') ;
				$this->DefColDateMisePlace = $this->TablPrinc->InsereDefCol('date_mise_place', 'Date mise en place') ;
				$this->DefColDateMisePlace->AliasDonnees = $bd->SqlDateToStrFr("date_mise_place", 0) ;
				$this->DefColDateMaturite = $this->TablPrinc->InsereDefCol('date_maturite', 'Date maturit&eacute;') ;
				$this->DefColDateMaturite->AliasDonnees = $bd->SqlDateToStrFr("date_maturite", 0) ;
				$this->FournDonneesPrinc->RequeteSelection = '(SELECT distinct t1.*, d1.code_devise, o1.login, t4.numop numop_repondeur, t4.id_entite, t5.name nom_entite, t3.top_active
FROM cotation_depot_terme t1
left join devise d1 on t1.id_devise = d1.id_devise
left join operateur o1 on t1.numop_publieur = o1.numop
left join rel_entreprise t3 on o1.id_entite = t3.id_entite_source
left join operateur t4 on t3.id_entite_dest = t4.id_entite
left join entite t5 on t5.id_entite = t4.id_entite)' ;
				$this->DefColActs = $this->TablPrinc->InsereDefColActions("Actions") ;
				$this->LienReserv = $this->TablPrinc->InsereLienOuvreFenetreAction($this->DefColActs, '?appelleScript=ajoutReservCotationDepotTerme&id_cotation=${id}', 'R&eacute;ponse', 'reserv_cotation_depot_terme_${id}', 'Cotation D&eacute;p&ocirc;t &agrave; terme', $this->OptsFenetreDetail) ;
				$this->LienReserv->ClasseCSS = "lien-act-004" ;
				$this->LienReserv->DefinitScriptOnglActifSurFerm($this) ;
			}
			protected function DefinitExprs()
			{
				$this->Titre = $this->ZoneParent->FournExprs->TitrFenConsultCotationDepotTerme ;
			}
		}
		class ScriptProposCotationDepotTermeTradPlatf extends Script1CotationDepotTermeTradPlatf
		{
			public $Privileges = array('post_doc_entreprise') ;
			public $LienReserv ;
			public $FournDonneesPrinc ;
			public $DefColId ;
			public $DefColNumOp ;
			public $DefColRefTransact ;
			public $DefColDateMisePlace ;
			public $DefColDateMaturite ;
			public $DefColMontant ;
			public $DefColTaux ;
			public $DefColDevise ;
			public $FltDateDebut ;
			public $FltDateFin ;
			public $FltNumOpPubl ;
			protected function ChargeTablPrinc()
			{
				parent::ChargeTablPrinc() ;
				$bd = $this->BDPrinc() ;
				$this->FltDateDebut = $this->TablPrinc->InsereFltSelectHttpGet("dateDebut", "date_mise_place >= <self>") ;
				$this->FltDateDebut->ValeurParDefaut = date("Y-m-d", date("u") - 86400 * 90) ;
				$this->FltDateFin = $this->TablPrinc->InsereFltSelectHttpGet("dateFin", "date_mise_place <= <self>") ;
				$this->FltNumOpPubl = $this->TablPrinc->InsereFltSelectFixe("numOpPublieur", $this->ZoneParent->IdMembreConnecte(), "numop_publieur = <self>") ;
				$this->FltDateDebut->Libelle = "Periode du" ;
				$this->FltDateDebut->DeclareComposant("PvCalendarDateInput") ;
				$this->FltDateFin->Libelle = "au" ;
				$this->FltDateFin->DeclareComposant("PvCalendarDateInput") ;
				$this->DefColId = $this->TablPrinc->InsereDefColCachee('id') ;
				$this->DefColNumOp = $this->TablPrinc->InsereDefColCachee('numop_publieur') ;
				$this->DefColDateMisePlace = $this->TablPrinc->InsereDefCol('date_mise_place', 'Date mise en place') ;
				$this->DefColDateMisePlace->AliasDonnees = $bd->SqlDateToStrFr("date_mise_place", 0) ;
				$this->DefColDateMaturite = $this->TablPrinc->InsereDefCol('date_maturite', 'Date maturit&eacute;') ;
				$this->DefColDateMaturite->AliasDonnees = $bd->SqlDateToStrFr("date_maturite", 0) ;
				$this->DefColMontant = $this->TablPrinc->InsereDefColMoney('montant', 'Montant') ;
				$this->DefColDevise = $this->TablPrinc->InsereDefCol('code_devise', 'Devise') ;
				$this->FournDonneesPrinc->RequeteSelection = '(select t1.*, t2.total total_reserv, d1.code_devise from cotation_depot_terme t1
inner join (select id_cotation, count(0) total from reserv_cotation_depot_terme group by id_cotation) t2
on t1.id = t2.id_cotation
left join devise d1 on t1.id_devise = d1.id_devise)' ;
				$this->DefColActs = $this->TablPrinc->InsereDefColActions("Actions") ;
				$this->LienReserv = $this->TablPrinc->InsereLienOuvreFenetreAction($this->DefColActs, '?appelleScript=listReservCotationDepotTerme&id=${id}', 'Consultation', 'list_reserv_cotation_depot_terme_${id}', 'Liste r&eacute;servations cotation depot de terme', $this->OptsFenetreDetail) ;
				$this->LienReserv->DefinitScriptOnglActifSurFerm($this) ;
				$this->LienReserv->ClasseCSS = "lien-act-004" ;
			}
			protected function DefinitExprs()
			{
				$this->Titre = $this->ZoneParent->FournExprs->TitrFenProposCotationDepotTerme ;
			}
		}
		
		class ScriptLgn1CotationDepotTermeTradPlatf extends ScriptEditCotationDepotTermeTradPlatf
		{
			public $FltId ;
			public $FltRefTransact ;
			public $FltMontant ;
			public $FltTaux ;
			public $FltDevise ;
			public $FltDateMisePlace ;
			public $CompDevise ;
			public $FltNumOp ;
			public $CompDateMisePlace ;
			public $CompDateEcheance ;
			public $NomClasseCmdExecFormPrinc = "PvCommandeAjoutElement" ;
			public $PourAjout = 1 ;
			public $PourDetail = 0 ;
			public $FormPrincEditable = 1 ;
			public $CritrNonVidePrinc ;
			public $CritrValidPrinc ;
			protected function DefinitExprs()
			{
				$this->Titre = $this->ZoneParent->FournExprs->TitrFenAjoutCotationDepotTerme ;
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
				$this->FltMontant = $this->FormPrinc->InsereFltEditHttpPost('montant', 'montant') ;
				$this->FltMontant->Libelle = "Montant" ;
				$this->FltMontant->FormatteurEtiquette = new PvFmtMonnaieEtiquetteFiltre() ;
				$this->FltDateMisePlace = $this->FormPrinc->InsereFltEditHttpPost('date_mise_place', 'date_mise_place') ;
				$this->FltDateMisePlace->Libelle = "Date mise en place" ;
				$this->FltDateMisePlace->DeclareComposant("PvCalendarDateInput") ;
				$this->FltDateMaturite = $this->FormPrinc->InsereFltEditHttpPost('date_maturite', 'date_maturite') ;
				$this->FltDateMaturite->Libelle = "Date maturit&eacute;" ;
				$this->FltDateMaturite->DeclareComposant("PvCalendarDateInput") ;
				$this->FltDevise = $this->FormPrinc->InsereFltEditHttpPost('id_devise', 'id_devise') ;
				$this->FltDevise->Libelle = "Devise" ;
				$this->CompDevise = $this->FltDevise->DeclareComposant("PvZoneBoiteSelectHtml") ;
				$this->CompDevise->FournisseurDonnees = $this->CreeFournDonneesPrinc() ;
				$this->CompDevise->FournisseurDonnees->RequeteSelection = 'devise' ;
				$this->CompDevise->NomColonneValeur = 'id_devise' ;
				$this->CompDevise->NomColonneLibelle = 'code_devise' ;
				$this->FournDonneesPrinc->RequeteSelection = "cotation_depot_terme" ;
				$this->FournDonneesPrinc->TableEdition = "cotation_depot_terme" ;
				$this->FormPrinc->MaxFiltresEditionParLigne = 1 ;
				if($this->FormPrinc->Editable == 1)
				{
					$this->CritrValidPrinc = $this->FormPrinc->CommandeExecuter->InsereNouvCritere(new CritrValidCotationDepotTermeTradPlatf()) ;
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
				$total = $bd->FetchSqlValue('select count(0) total from reserv_cotation_depot_terme t1 where id_cotation=:id', array('id' => $this->FltId->Lie()), 'total') ;
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
		class ScriptAjoutCotationDepotTermeTradPlatf extends ScriptLgn1CotationDepotTermeTradPlatf
		{
			protected function DefinitExprs()
			{
				$this->Titre = $this->ZoneParent->FournExprs->TitrFenModifCotationDepotTerme ;
			}
		}
		class ScriptModifCotationDepotTermeTradPlatf extends ScriptLgn1CotationDepotTermeTradPlatf
		{
			public $NomClasseCmdExecFormPrinc = "PvCommandeModifElement" ;
			public $PourAjout = 0 ;
			protected function DefinitExprs()
			{
				$this->Titre = $this->ZoneParent->FournExprs->TitrFenModifCotationDepotTerme ;
			}
		}
		class ScriptSupprCotationDepotTermeTradPlatf extends ScriptModifCotationDepotTermeTradPlatf
		{
			public $NomClasseCmdExecFormPrinc = "PvCommandeSupprElement" ;
			public $FormPrincEditable = 0 ;
			protected function DefinitExprs()
			{
				$this->Titre = $this->ZoneParent->FournExprs->TitrFenSupprCotationDepotTerme ;
			}
		}
		
		class ScriptDetailProposCotationDepotTermeTradPlatf extends ScriptModifCotationDepotTermeTradPlatf
		{
			public $PourDetail = 1 ;
			public $LienModifSecond ;
			public $LienSupprSecond ;
			public $TablSecond ;
			public $CmdAjoutSecond ;
			public $FltNumOpTablSecond ;
			public $FltIdTablSecond ;
			public $DefColIdTablSecond ;
			public $DefColMontantTablSecond ;
			public $DefColTauxTablSecond ;
			public $DefColActsTablSecond ;
			public function DetermineEnvironnement()
			{
				parent::DetermineEnvironnement() ;
				$this->FormPrinc->Editable = 0 ;
				$this->FormPrinc->CacherBlocCommandes = 1 ;
				$this->DetermineTableSecond() ;
			}
			protected function CreeTablSecond()
			{
				return new TableauDonneesOperationTradPlatf() ;
			}
			protected function DetermineTableSecond()
			{
				$this->TablSecond = $this->CreeTablSecond() ;
				$this->TablSecond->AdopteScript('tablSecond', $this) ;
				$this->TablSecond->ChargeConfig() ;
				$this->ChargeTablSecond() ;
			}
			protected function ChargeTablSecond()
			{
				$this->FltIdTablSecond = $this->TablSecond->InsereFltSelectHttpGet('id', 'id_cotation = <self>') ;
				$this->FltNumOpTablSecond = $this->TablSecond->InsereFltSelectFixe('numOpDemandeur', $this->ZoneParent->IdMembreConnecte(), 'numop_demandeur = <self>') ;
				$this->TablSecond->CacherFormulaireFiltres = 1 ;
				$this->DefColIdTablSecond = $this->TablSecond->InsereDefColCachee('id') ;
				$this->DefColMontantTablSecond = $this->TablSecond->InsereDefColMoney('montant') ;
				$this->DefColTauxTablSecond = $this->TablSecond->InsereDefCol('taux') ;
				$this->DefColActsTablSecond = $this->TablSecond->InsereDefColActions('Actions') ;
				$this->FournDonneesSecond = $this->CreeFournDonneesPrinc() ;
				$this->FournDonneesSecond->RequeteSelection = 'reserv_cotation_depot_terme' ;
				$this->TablSecond->FournisseurDonnees = & $this->FournDonneesSecond ;
				$this->LienModifSecond = $this->TablSecond->InsereLienOuvreFenetreAction($this->DefColActsTablSecond, '?appelleScript=modifReservCotationDepotTerme&id=${id}', 'Modifier', 'modif_reserv_emiss_obligation_${id}', 'Modifier r&eacute;serv. cotation transfert de devise ${montant} ${taux}%', $this->OptsFenetreEdit) ;
				$this->LienModifSecond->ClasseCSS = "lien-act-001" ;
				$this->LienSupprSecond = $this->TablSecond->InsereLienOuvreFenetreAction($this->DefColActsTablSecond, '?appelleScript=supprReservCotationDepotTerme&id=${id}', 'Supprimer', 'suppr_reserv_emiss_obligation_${id}', 'Supprimer r&eacute;serv. cotation transfert de devise ${montant} ${taux}%', $this->OptsFenetreEdit) ;
				$this->LienSupprSecond->ClasseCSS = "lien-act-002" ;
				$this->CmdAjoutSecond = $this->TablSecond->InsereCmdOuvreFenetreScript("ajoutReservCotationDepotTerme", '?appelleScript=ajoutReservCotationDepotTerme&id_cotation='.urlencode($this->FltIdTablSecond->Lie()), 'Ajouter', 'ajoutReservCotationDepotTerme', "R&eacute;server une cotation transfert de devise", $this->OptsFenetreEdit) ;
			}
			protected function DefinitExprs()
			{
				$this->Titre = $this->ZoneParent->FournExprs->TitrFenDetailProposCotationDepotTerme ;
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
		
		class ScriptListReservCotationDepotTermeTradPlatf extends ScriptModifCotationDepotTermeTradPlatf
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
				$this->DetermineTableSecond() ;
			}
			protected function CreeTablSecond()
			{
				return new TableauDonneesOperationTradPlatf() ;
			}
			protected function DetermineTableSecond()
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
				$this->DefColTauxTablSecond = $this->TablSecond->InsereDefColMoney('taux', "Taux") ;
				$this->DefColTaxeTransfTablSecond = $this->TablSecond->InsereDefColMoney('taxe_transfert', "Taxe transfert") ;
				/*
				$this->DefColMontantTablSecond->AlignElement = "right" ;
				$this->DefColActsTablSecond = $this->TablSecond->InsereDefColActions("Actions") ;
				$this->LienDetailsTablSecond = $this->TablSecond->InsereLienOuvreFenetreAction($this->DefColActsTablSecond, '?appelleScript=detailReservCotationDepotTerme&id=${id_cotation}&numop=${numop}', 'D&eacute;tails', 'details_reserv_emiss_obligation_${id}_${numop}', 'Details cotation transfert de devise #${login}', $this->OptsFenetreDetail) ;
				*/
				$this->FournDonneesSecond = $this->CreeFournDonneesPrinc() ;
				$this->FournDonneesSecond->RequeteSelection = '(select t1.*, t4.montant, t4.date_maturite, t4.date_mise_place, t2.numop, t2.login, t2.nomop, t2.prenomop, t3.name nom_entite, t3.code code_entite
from reserv_cotation_depot_terme t1
left join operateur t2
on t1.numop_demandeur = t2.numop
left join entite t3
on t2.id_entite = t3.id_entite
left join cotation_depot_terme t4
on t4.id = t1.id_cotation)' ;
				$this->TablSecond->FournisseurDonnees = & $this->FournDonneesSecond ;
			}
			protected function RenduDispositifBrut()
			{
				$ctn = parent::RenduDispositifBrut() ;
				if($this->FormPrinc->ElementEnCoursTrouve == 1)
				{
					$ctn .= '<div class="ui-widget ui-widget-content">' ;
					$ctn .= $this->TablSecond->RenduDispositif() ;
					// echo "mmmm" ;
					// $ctn .= print_r($this->TablSecond->FournisseurDonnees->BaseDonnees, true) ;
					// print_r($this->TablSecond->FournisseurDonnees) ;
					$ctn .= '</div>' ;
				}
				return $ctn ;
			}
			protected function DefinitExprs()
			{
				$this->Titre = $this->ZoneParent->FournExprs->TitrFenListReservCotationDepotTerme ;
			}
		}
		class ScriptDetailReservCotationDepotTermeTradPlatf extends ScriptListCotationDepotTermeTradPlatf
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
from reserv_cotation_depot_terme t1
left join operateur t2
on t1.numop_demandeur = t2.numop
left join entite t3
on t2.id_entite = t3.id_entite)' ;
			}
		}
		
		class ScriptLng1ReservCotationDepotTermeTradPlatf extends ScriptEditCotationDepotTermeTradPlatf
		{
			public $FltId ;
			public $FltIdCotation ;
			public $FltNumOp ;
			public $FltMontant ;
			public $FltDevise ;
			public $FltDateMisePlace ;
			public $FltDateMaturite ;
			public $FltTaxeTransf ;
			public $FltTaux ;
			public $NomClasseCmdExecFormPrinc = "CmdAjoutReservCotationDepotTermeTradPlatf" ;
			public $PourAjout = 1 ;
			public $FormPrincEditable = 1 ;
			protected function DefinitExprs()
			{
				$this->Titre = $this->ZoneParent->FournExprs->TitrFenAjoutReservCotationDepotTerme ;
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
				$this->FltMontant = $this->FormPrinc->InsereFltEditHttpPost('montant', '') ;
				$this->FltMontant->Libelle = "Montant" ;
				$this->FltMontant->EstEtiquette = 1 ;
				$this->FltDevise = $this->FormPrinc->InsereFltEditHttpPost('devise', '') ;
				$this->FltDevise->Libelle = "Devise" ;
				$this->FltDevise->EstEtiquette = 1 ;
				$this->FltDateMisePlace = $this->FormPrinc->InsereFltEditHttpPost('date_mise_place', '') ;
				$this->FltDateMisePlace->Libelle = "Date mise en place" ;
				$this->FltDateMisePlace->EstEtiquette = 1 ;
				$this->FltDateMaturite = $this->FormPrinc->InsereFltEditHttpPost('date_maturite', '') ;
				$this->FltDateMaturite->Libelle = "Date maturit&eacute;" ;
				$this->FltDateMaturite->EstEtiquette = 1 ;
				$this->FltTaxeTransf = $this->FormPrinc->InsereFltEditHttpPost('taxe_transfert', 'taxe_transfert') ;
				$this->FltTaxeTransf->Libelle = "Taxe de transfert" ;
				$this->FltTaxeTransf->LectureSeule = 1 ;
				$this->FltTaux = $this->FormPrinc->InsereFltEditHttpPost('taux', 'taux') ;
				$this->FltTaux->Libelle = "Taux (%)" ;
				$this->FournDonneesPrinc->RequeteSelection = "(select t1.*, t2.code_devise, t3.taux, t3.taxe_transfert from cotation_depot_terme t1
left join devise t2 on t1.id_devise = t2.id_devise
left join reserv_cotation_depot_terme t3 on t1.id = t3.id_cotation)" ;
				$this->FournDonneesPrinc->TableEdition = "reserv_cotation_depot_terme" ;
				$this->FormPrinc->MaxFiltresEditionParLigne = 1 ;
				// $this->FormPrinc->DessinateurFiltresEdition = new DessinFltsReservCotationDepotTerme() ;
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
				$bd = $this->BDPrinc() ;
				$lgn = $bd->FetchSqlRow('select t1.*, t2.code_devise, t3.taux taux_reserv from cotation_depot_terme t1 left join devise t2 on t1.id_devise = t2.id_devise left join reserv_cotation_depot_terme t3 on t1.id = t3.id_cotation where t1.id='.$bd->ParamPrefix.'id', array('id' => $idLgnEmiss)) ;
				if(! is_array($lgn) || count($lgn) == 0)
					return ;
				$this->FltMontant->ValeurParDefaut = $lgn["montant"] ;
				$this->FltDevise->ValeurParDefaut = $lgn["code_devise"] ;
				$this->FltDateMaturite->ValeurParDefaut = $lgn["date_maturite"] ;
				$this->FltDateMisePlace->ValeurParDefaut = $lgn["date_mise_place"] ;
				$this->FltTaux->ValeurParDefaut = $lgn["taux_reserv"] ;
				$lgn = $bd->FetchSqlRow('select t1.* from reserv_cotation_depot_terme t1 where t1.id_cotation='.$bd->ParamPrefix.'id and numop_demandeur='.$bd->ParamPrefix.'numop', array('numop' => $this->ZoneParent->IdMembreConnecte())) ;
				if(is_array($lgn) && count($lgn) > 0)
				{
					$this->FltTaux->ValeurParDefaut = $lgn["taux"] ;
					$this->FltTaxeTransf->ValeurParDefaut = $lgn["taxe_transfert"] ;
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
		class ScriptAjoutReservCotationDepotTermeTradPlatf extends ScriptLng1ReservCotationDepotTermeTradPlatf
		{
			public $PourAjout = 1 ;
		}
		class ScriptModifReservCotationDepotTermeTradPlatf extends ScriptLng1ReservCotationDepotTermeTradPlatf
		{
			public $NomClasseCmdExecFormPrinc = "PvCommandeModifElement" ;
			public $PourAjout = 0 ;
			protected function DefinitExprs()
			{
				$this->Titre = $this->ZoneParent->FournExprs->TitrFenModifReservCotationDepotTerme ;
			}
		}
		class ScriptSupprReservCotationDepotTermeTradPlatf extends ScriptModifReservCotationDepotTermeTradPlatf
		{
			public $NomClasseCmdExecFormPrinc = "PvCommandeSupprElement" ;
			public $FormPrincEditable = 0 ;
			protected function DefinitExprs()
			{
				$this->Titre = $this->ZoneParent->FournExprs->TitrFenSupprReservCotationDepotTerme ;
			}
		}
		
		class DessinFltsReservCotationDepotTerme extends PvDessinateurRenduHtmlFiltresDonnees
		{
			public function Execute(& $script, & $composant, $parametres)
			{
				$composant->LieTousLesFiltres() ;
				$ctn = '' ;
				$ctn .= '<table width="100%" cellspacing="0" cellpadding="4">'.PHP_EOL ;
				$ctn .= '<tr>
<td>'.$this->RenduLibelleFiltre($script->FltContreValeurDev).'</td>
<td>'.$script->FltContreValeurDev->Rendu().'</td>
<td>&nbsp;</td>
<td>'.$this->RenduLibelleFiltre($script->FltDevise).'</td>
<td>'.$script->FltDevise->Rendu().'</td>
<td>&nbsp;</td>
<td>'.$this->RenduLibelleFiltre($script->FltTauxDevise).'</td>
<td>'.$script->FltTauxDevise->Rendu().'</td>
</tr>'.PHP_EOL ;
				$ctn .= '<tr>
<td>'.$this->RenduLibelleFiltre($script->FltTaxeTransf).'</td>
<td>'.$script->FltTaxeTransf->Rendu().'</td>
<td colspan="4">&nbsp;</td>
<td>'.$this->RenduLibelleFiltre($script->FltTauxTaxeTransf).'</td>
<td>'.$script->FltTauxTaxeTransf->Rendu().'</td>
</tr>'.PHP_EOL ;
				$ctn .= '<tr>
<td>'.$this->RenduLibelleFiltre($script->FltCommissTransf).'</td>
<td>'.$script->FltCommissTransf->Rendu().'</td>
<td colspan="4">&nbsp;</td>
<td>'.$this->RenduLibelleFiltre($script->FltTauxCommTransf).'</td>
<td>'.$script->FltTauxCommTransf->Rendu().'</td>
</tr>'.PHP_EOL ;
				$ctn .= '<tr>
<td>'.$this->RenduLibelleFiltre($script->FltFraisFixes).'</td>
<td>'.$script->FltFraisFixes->Rendu().'</td>
<td colspan="6">&nbsp;</td>
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
				$ctn .= '</table>' ;
				return $ctn ;
			}
		}
		
		class CmdAjoutReservCotationDepotTermeTradPlatf extends PvCommandeExecuterBase
		{
			public function ExecuteInstructions()
			{
				$bd = $this->ApplicationParent->BDPrincipale ;
				$form = & $this->FormulaireDonneesParent ;
				$script = & $this->ScriptParent ;
				$form->LieTousLesFiltres() ;
				$idCotisation = $script->FltIdCotation->Lie() ;
				$numOpDemandeur = $script->ZoneParent->IdMembreConnecte() ;
				$ok = $bd->RunSql('delete from reserv_cotation_depot_terme where id_cotation=:idCotisation and numop_demandeur=:numOpDemandeur', array('idCotisation' => $idCotisation, 'numOpDemandeur' => $numOpDemandeur)) ;
				if($ok)
				{
					$taux = $script->FltTaux->Lie() ;
					$taxe_transfert = $script->FltTaxeTransf->Lie() ;
					$bd->InsertRow('reserv_cotation_depot_terme', array('numop_demandeur' => $numOpDemandeur, 'id_cotation' => $idCotisation, 'taux' => $taux, 'taxe_transfert' => $taxe_transfert)) ;
					$this->ConfirmeSucces() ;
				}
				else
				{
					$this->RenseigneErreur('Erreur SQL !!!') ;
				}
			}
		}
		
		class CritrValidCotationDepotTermeTradPlatf extends PvCritereBase
		{
			public function EstRespecte()
			{
				$bd = $this->ApplicationParent->BDPrincipale ;
				$valDateMisePlace = $this->ScriptParent->FltDateMisePlace->Lie() ;
				$timestmpJour = date("U", strtotime(date("Y-m-d"))) ;
				$idCotisation = $this->ScriptParent->FltId->Lie() ;
				if(! $this->FormulaireDonneesParent->InclureElementEnCours)
				{
					$timestmpEmiss = strtotime($valDateMisePlace) ;
					if($timestmpJour > $timestmpEmiss)
					{
						$this->MessageErreur = 'La date de valeur ne doit pas &ecirc;tre anterieure &agrave; la date actuelle' ;
						return 0 ;
					}
				}
				/*
				$totEmissSimil = $bd->FetchSqlValue('select count(0) tot from cotation_depot_terme where id <> :idCotisation and ', array('refTransact' => $this->ScriptParent->FltRefTransact->Lie(), 'idCotisation' => $idCotisation), 'tot') ;
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
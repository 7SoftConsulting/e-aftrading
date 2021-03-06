<?php
	
	if(! defined('EMISS_OBLIGATION_TRAD_PLATF'))
	{
		define('EMISS_OBLIGATION_TRAD_PLATF', 1) ;
		
		class DessinFltsObligationTradPlatf extends PvDessinateurRenduHtmlFiltresDonnees
		{
			public function Execute(& $script, & $composant, $parametres)
			{
				$composant->LieTousLesFiltres() ;
				return $script->ZoneParent->RemplisseurConfig->AppliqueFormObligation($script, $composant) ;
			}
		}
		class SommaireFltsObligationTradPlatf extends PvDessinateurRenduHtmlFiltresDonnees
		{
		}
		
		class DessinFltsObligationMarchSecTradPlatf extends PvDessinateurRenduHtmlFiltresDonnees
		{
			public function Execute(& $script, & $composant, $parametres)
			{
				$composant->LieTousLesFiltres() ;
				return $script->ZoneParent->RemplisseurConfig->AppliqueFormObligationMarchSec($script, $composant) ;
			}
		}
		
		class ScriptBaseEmissObligationTradPlatf extends ScriptTransactBaseTradPlatf
		{
			public $OptsFenetreEdit = array("Largeur" => 875, 'Hauteur' => 525, 'Modal' => 1, "BoutonFermer" => 0) ;
			public $OptsFenetreDetail = array("Largeur" => 875, 'Hauteur' => 525, 'Modal' => 1, "BoutonFermer" => 0) ;
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

		class ScriptListEmissObligationTradPlatf extends ScriptBaseEmissObligationTradPlatf
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
				// print_r($this->TablPrinc->FournisseurDonnees->BaseDonnees) ;
				return $ctn ;
			}
		}
		class ScriptEditEmissObligationTradPlatf extends ScriptBaseEmissObligationTradPlatf
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
		
		class Script1EmissObligationTradPlatf extends ScriptListEmissObligationTradPlatf
		{
			public $BarreMenu ;
			public $SousMenuPublier ;
			public $SousMenuConsult ;
			public $SousMenuPropos ;
			public $SousMenuLstValide ;
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
					$this->SousMenuConsult = $this->BarreMenu->MenuRacine->InscritSousMenuScript('consultEmissObligation') ;
					$this->SousMenuConsult->CheminMiniature = "images/miniatures/consulte_achat_devise.png" ;
					$this->SousMenuConsult->Titre = "Consultation" ;
				}
				if($this->ZoneParent->PossedePrivilege('post_doc_tresorier'))
				{
					// Publication
					$this->SousMenuPublier = $this->BarreMenu->MenuRacine->InscritSousMenuScript('publierEmissObligation') ;
					$this->SousMenuPublier->CheminMiniature = "images/miniatures/consulte_achat_devise.png" ;
					$this->SousMenuPublier->Titre = "Publications" ;
					// Propositions
					$this->SousMenuPropos = $this->BarreMenu->MenuRacine->InscritSousMenuScript('proposEmissObligation') ;
					$this->SousMenuPropos->CheminMiniature = "images/miniatures/consulte_achat_devise.png" ;
					$this->SousMenuPropos->Titre = "Visuel des souscriptions" ;
				}
				if($this->ZoneParent->PossedePrivilege('post_op_change'))
				{
					$this->SousMenuLstValide = $this->BarreMenu->MenuRacine->InscritSousMenuScript('lstEmissObligationValide') ;
					$this->SousMenuLstValide->CheminMiniature = "images/miniatures/consulte_achat_devise.png" ;
					$this->SousMenuLstValide->Titre = "Souscriptions valid&eacute;es" ;
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
		
		class ScriptPublierEmissObligationTradPlatf extends Script1EmissObligationTradPlatf
		{
			public $Titre = "Emission d'Obligations" ;
			public $Privileges = array('post_doc_tresorier') ;
			public $CmdAjout ;
			public $LienModif ;
			public $LienSuppr ;
			public $FournDonneesPrinc ;
			public $DefColId ;
			public $DefColNumOp ;
			public $DefColRefTransact ;
			public $DefColDateEmiss ;
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
				$this->FltDateDebut = $this->TablPrinc->InsereFltSelectHttpGet("dateDebut", "date_emission >= <self>") ;
				$this->FltDateFin = $this->TablPrinc->InsereFltSelectHttpGet("dateFin", "date_emission <= <self>") ;
				$this->FltNumOpPubl = $this->TablPrinc->InsereFltSelectFixe("numOpPublieur", $this->ZoneParent->IdMembreConnecte(), "numop_publieur = <self>") ;
				$this->FltDateDebut->Libelle = "Periode du" ;
				$this->FltDateDebut->DeclareComposant("PvCalendarDateInput") ;
				$this->FltDateFin->Libelle = "au" ;
				$this->FltDateFin->DeclareComposant("PvCalendarDateInput") ;
				$this->TablPrinc->SensColonneTri = "desc" ;
				$this->TablPrinc->AccepterTriColonneInvisible = 1 ;
				$this->DefColId = $this->TablPrinc->InsereDefColCachee('id') ;
				$this->DefColNumOp = $this->TablPrinc->InsereDefColCachee('numop_publieur') ;
				$this->DefColRefTransact = $this->TablPrinc->InsereDefCol('ref_transact', 'Ref.') ;
				$this->DefColDateEmiss = $this->TablPrinc->InsereDefCol('date_emission', 'Date &eacute;mission') ;
				$this->DefColDateEmiss->AliasDonnees = $bd->SqlDateToStrFr("date_emission", 0) ;
				$this->DefColMontant = $this->TablPrinc->InsereDefColMoney('montant', 'Montant') ;
				$this->DefColTaux = $this->TablPrinc->InsereDefCol('taux', 'Taux') ;
				$this->DefColDevise = $this->TablPrinc->InsereDefCol('code_devise', 'Devise') ;
				$this->DefColDateEcheance = $this->TablPrinc->InsereDefCol('date_echeance', 'Date &eacute;ch&eacute;ance') ;
				$this->DefColDateEcheance->NomDonnees = "date_echeance" ;
				$this->DefColDateEcheance->AliasDonnees = $bd->SqlDateToStrFr("date_echeance", 0) ;
				$this->FournDonneesPrinc->RequeteSelection = '(SELECT t1.*, d1.code_devise
FROM emission_obligation t1
left join devise d1 on t1.id_devise = d1.id_devise)' ;
				$this->DefColActs = $this->TablPrinc->InsereDefColActions("Actions") ;
				$this->LienModif = $this->TablPrinc->InsereLienOuvreFenetreAction($this->DefColActs, '?appelleScript=modifEmissObligation&id=${id}', 'Modifier', 'modif_emiss_obligation_${id}', 'Modifier &eacute;mission obligation #${ref_transact}', $this->OptsFenetreEdit) ;
				$this->LienModif->ClasseCSS = "lien-act-001" ;
				$this->LienModif->DefinitScriptOnglActifSurFerm($this) ;
				$this->LienSuppr = $this->TablPrinc->InsereLienOuvreFenetreAction($this->DefColActs, '?appelleScript=supprEmissObligation&id=${id}', 'Supprimer', 'suppr_emiss_obligation_${id}', 'Supprimer &eacute;mission obligation #${ref_transact}', $this->OptsFenetreEdit) ;
				$this->LienSuppr->ClasseCSS = "lien-act-002" ;
				$this->LienSuppr->DefinitScriptOnglActifSurFerm($this) ;
				$this->CmdAjout = $this->TablPrinc->InsereCmdOuvreFenetreScript("ajoutEmissObligation", '?appelleScript=selectPaysOblig', 'Ajouter', 'ajoutEmissObligation', "Poster une &eacute;mission obligation", $this->OptsFenetreEdit) ;
				$this->CmdAjout->DefinitScriptOnglActifSurFerm($this) ;
			}
			protected function DefinitExprs()
			{
				$this->Titre = $this->ZoneParent->FournExprs->TitrFenPublierEmissObligation ;
			}
		}
		class ScriptConsultEmissObligationTradPlatf extends Script1EmissObligationTradPlatf
		{
			public $Titre = "Consulter Emission d'Obligations" ;
			public $TitreDocument = "Consulter Emission d'Obligations" ;
			public $Privileges = array('post_op_change') ;
			public $LienReserv ;
			public $LienDetail ;
			public $FournDonneesPrinc ;
			public $DefColId ;
			public $DefColNumOp ;
			public $DefColRefTransact ;
			public $DefColDateEmiss ;
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
				$this->FltDateDebut = $this->TablPrinc->InsereFltSelectHttpGet("dateDebut", "date_emission >= <self>") ;
				$this->FltDateFin = $this->TablPrinc->InsereFltSelectHttpGet("dateFin", "date_emission <= <self>") ;
				$this->FltNumOpPubl = $this->TablPrinc->InsereFltSelectFixe("numOpPublieur", $this->ZoneParent->IdMembreConnecte(), "numop_publieur <> <self>") ;
				$this->FltDateDebut->Libelle = "Periode du" ;
				$this->FltDateDebut->DeclareComposant("PvCalendarDateInput") ;
				$this->FltDateFin->Libelle = "au" ;
				$this->FltDateFin->DeclareComposant("PvCalendarDateInput") ;
				$this->TablPrinc->AccepterTriColonneInvisible = 1 ;
				$this->TablPrinc->SensColonneTri = "desc" ;
				$this->DefColId = $this->TablPrinc->InsereDefColCachee('id') ;
				$this->DefColNumOp = $this->TablPrinc->InsereDefColCachee('numop_publieur') ;
				$this->DefColRefTransact = $this->TablPrinc->InsereDefCol('ref_transact', 'Ref.') ;
				$this->DefColDateEmiss = $this->TablPrinc->InsereDefCol('date_emission', 'Date &eacute;mission') ;
				$this->DefColDateEmiss->AliasDonnees = $bd->SqlDateToStrFr("date_emission", 0) ;
				$this->DefColMontant = $this->TablPrinc->InsereDefColMoney('montant', 'Montant') ;
				$this->DefColTaux = $this->TablPrinc->InsereDefCol('taux', 'Taux') ;
				$this->DefColDevise = $this->TablPrinc->InsereDefCol('code_devise', 'Devise') ;
				$this->DefColDateEcheance = $this->TablPrinc->InsereDefCol('date_echeance', 'Date &eacute;ch&eacute;ance') ;
				$this->DefColDateEcheance->NomDonnees = "date_echeance" ;
				$this->DefColDateEcheance->AliasDonnees = $bd->SqlDateToStrFr("date_echeance", 0) ;
				$this->FournDonneesPrinc->RequeteSelection = '(SELECT t1.*, d1.code_devise
FROM emission_obligation t1
left join devise d1 on t1.id_devise = d1.id_devise)' ;
				$this->DefColActs = $this->TablPrinc->InsereDefColActions("Actions") ;
				$this->LienDetail = $this->TablPrinc->InsereLienOuvreFenetreAction($this->DefColActs, '?appelleScript=detailEmissObligation&id=${id}', 'detail', 'detail_emiss_obligation_${id}', 'D&eacute;tails obligation #${ref_transact}', $this->OptsFenetreEdit) ;
				$this->LienDetail->ClasseCSS = "lien-act-003" ;
				$this->LienReserv = $this->TablPrinc->InsereLienOuvreFenetreAction($this->DefColActs, '?appelleScript=ajoutReservEmissObligation&id=${id}', 'Souscriptions', 'souscription_emiss_obligation_${id}', 'Souscriptions obligation #${ref_transact}', $this->OptsFenetreDetail) ;
				$this->LienReserv->ClasseCSS = "lien-act-004" ;
				$this->LienReserv->DefinitScriptOnglActifSurFerm($this) ;
			}
			protected function DefinitExprs()
			{
				$this->Titre = $this->ZoneParent->FournExprs->TitrFenConsultEmissObligation ;
			}
		}
		class ScriptProposEmissObligationTradPlatf extends Script1EmissObligationTradPlatf
		{
			public $Privileges = array('post_doc_tresorier') ;
			public $LienReserv ;
			public $FournDonneesPrinc ;
			public $DefColId ;
			public $DefColNumOp ;
			public $DefColRefTransact ;
			public $DefColDateEmiss ;
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
				$this->FltDateDebut = $this->TablPrinc->InsereFltSelectHttpGet("dateDebut", "date_emission >= <self>") ;
				$this->FltDateDebut->ValeurParDefaut = date("Y-m-d", date("U") - 86400 * 90) ;
				$this->FltDateFin = $this->TablPrinc->InsereFltSelectHttpGet("dateFin", "date_emission <= <self>") ;
				$this->FltNumOpPubl = $this->TablPrinc->InsereFltSelectFixe("numOpPublieur", $this->ZoneParent->IdMembreConnecte(), "numop_publieur = <self>") ;
				$this->FltDateDebut->Libelle = "Periode du" ;
				$this->FltDateDebut->DeclareComposant("PvCalendarDateInput") ;
				$this->FltDateFin->Libelle = "au" ;
				$this->FltDateFin->DeclareComposant("PvCalendarDateInput") ;
				$this->DefColId = $this->TablPrinc->InsereDefColCachee('id') ;
				$this->DefColNumOp = $this->TablPrinc->InsereDefColCachee('numop_publieur') ;
				$this->DefColRefTransact = $this->TablPrinc->InsereDefCol('ref_transact', 'Ref.') ;
				$this->DefColDateEmiss = $this->TablPrinc->InsereDefCol('date_emission', 'Date &eacute;mission') ;
				$this->DefColDateEmiss->AliasDonnees = $bd->SqlDateToStrFr("date_emission", 0) ;
				$this->DefColMontant = $this->TablPrinc->InsereDefColMoney('montant', 'Montant') ;
				$this->DefColTaux = $this->TablPrinc->InsereDefCol('taux', 'Taux') ;
				$this->DefColDevise = $this->TablPrinc->InsereDefCol('code_devise', 'Devise') ;
				$this->DefColDateEcheance = $this->TablPrinc->InsereDefCol('date_echeance', 'Date &eacute;ch&eacute;ance') ;
				$this->DefColDateEcheance->NomDonnees = "date_echeance" ;
				$this->DefColDateEcheance->AliasDonnees = $bd->SqlDateToStrFr("date_echeance", 0) ;
				$this->FournDonneesPrinc->RequeteSelection = '(select t1.*, t2.total total_reserv, d1.code_devise from emission_obligation t1
inner join (select id_emission, count(0) total from reserv_obligation group by id_emission) t2
on t1.id = t2.id_emission
left join devise d1 on t1.id_devise = d1.id_devise)' ;
				$this->DefColActs = $this->TablPrinc->InsereDefColActions("Actions") ;
				$this->LienReserv = $this->TablPrinc->InsereLienOuvreFenetreAction($this->DefColActs, '?appelleScript=listReservEmissObligation&id=${id}', 'D&eacute;tails', 'list_reserv_emiss_obligation_${id}', 'D&eacute;tails &eacute;mission obligation #${ref_transact}', $this->OptsFenetreDetail) ;
				$this->LienReserv->ClasseCSS = "lien-act-001" ;
				$this->LienReserv->DefinitScriptOnglActifSurFerm($this) ;
			}
			protected function DefinitExprs()
			{
				$this->Titre = $this->ZoneParent->FournExprs->TitrFenProposEmissObligation ;
			}
		}
		class ScriptLstEmissObligationValideTradPlatf extends ScriptProposEmissObligationTradPlatf
		{
			public $Privileges = array('post_op_change') ;
			protected function ChargeTablPrinc()
			{
				parent::ChargeTablPrinc() ;
				$this->FltNumOpPubl->ExpressionDonnees = "numop_demandeur = <self>" ;
				$this->FournDonneesPrinc->RequeteSelection = '(select t1.*, t2.montant montant_demandeur, t2.numop_demandeur, t2.est_valide, d1.code_devise from emission_obligation t1
inner join reserv_obligation t2
on t1.id = t2.id_emission
left join devise d1 on t1.id_devise = d1.id_devise
where t2.est_valide=1)' ;
				/*
				$this->LienReserv->ClasseCSS = "lien-act-001" ;
				$this->LienReserv->FormatURL = '?appelleScript=lstReservEmissObligationValide&id=${id}' ;
				*/
				$this->DefColActs->Visible = false ;
				$this->DefColMontantDem = $this->TablPrinc->InsereDefColMoney("montant_demandeur", "Montant Souscrit") ;
				$this->DefColMontant->AlignElement = "right" ;
				$this->DefColMontantDem->AlignElement = "right" ;
				$this->DefColValide = $this->TablPrinc->InsereDefColBool("est_valide", "Valid&eacute;") ;
				$this->DefColValide->AlignElement = "center" ;
			}
		}
		
		class ScriptLgn1EmissObligationTradPlatf extends ScriptEditEmissObligationTradPlatf
		{
			public $InclureTitreFormPrinc = 0 ;
			public $TitreFormPrinc = "Caract&eacute;ristiques Emission d'Obligations Assimilable du Tr&eacute;sor" ;
			public $FltId ;
			public $FltEmetteur ;
			public $CompEmetteur ;
			public $FltValNominaleUnit ;
			public $FltDuree ;
			public $FltDiffere ;
			public $FltPrix ;
			public $FltCodeISIN ;
			public $FltRefTransact ;
			public $FltMontant ;
			public $FltTaux ;
			public $FltDevise ;
			public $FltDateEmission ;
			public $FltDateEcheance ;
			public $CompDevise ;
			public $FltNumOp ;
			public $CompDateEmission ;
			public $CompDateEcheance ;
			public $FltPourcentMttAdjuc ;
			public $FltDateDepotSoumiss ;
			public $FltHeureDepotSoumiss ;
			public $FltIdAppDepotSoumiss ;
			public $FltLieuEtabl ;
			public $FltDateEtabl ;
			public $FltDirecteurTresor ;
			public $NomClasseCmdExecFormPrinc = "PvCommandeAjoutElement" ;
			public $PourAjout = 1 ;
			public $PourDetail = 0 ;
			public $FormPrincEditable = 1 ;
			public $InscrireCmdExecFormPrinc = 1 ;
			public $CritrNonVidePrinc ;
			public $CritrValidPrinc ;
			protected function CreeFormPrinc()
			{
				return new FormEditDocMarcheTradPlatf() ;
			}
			public function DetermineFormPrinc()
			{
				parent::DetermineFormPrinc() ;
				$this->ZoneParent->RemplisseurConfig->DeterminePaysEmetteurTransact($this) ;
			}
			protected function DefinitExprs()
			{
				$this->Titre = $this->ZoneParent->FournExprs->TitrFenAjoutEmissObligation ;
			}
			protected function InitFormPrinc()
			{
				parent::InitFormPrinc() ;
				$this->FormPrinc->NomClasseCommandeExecuter = $this->NomClasseCmdExecFormPrinc ;
				$this->FormPrinc->InclureElementEnCours = ($this->PourAjout) ? 0 : 1 ;
				$this->FormPrinc->InclureTotalElements = ($this->PourAjout) ? 0 : 1 ;
				$this->FormPrinc->Editable = $this->FormPrincEditable ;
				$this->FormPrinc->InscrireCommandeExecuter = $this->InscrireCmdExecFormPrinc ;
				$this->FormPrinc->DessinateurFiltresEdition = new DessinFltsObligationTradPlatf() ;
			}
			protected function ChargeFormPrinc()
			{
				parent::ChargeFormPrinc() ;
				$this->FltId = $this->FormPrinc->InsereFltLgSelectHttpGet('id', 'id = <self>') ;
				$this->FltNumOp = $this->FormPrinc->InsereFltEditFixe('numop', $this->ZoneParent->IdMembreConnecte(), 'numop_publieur') ;
				$this->FltEmetteur = $this->FormPrinc->InsereFltEditHttpPost('emetteur', 'emetteur') ;
				$this->FltEmetteur->Libelle = "Emetteur" ;
				if($this->FormPrinc->InclureElementEnCours == 0)
				{
					$this->FltEmetteur->ValeurParDefaut = _GET_def("idPays") ;
				}
				$this->FltEmetteur->EstEtiquette = 1 ;
				$this->CompEmetteur = $this->FltEmetteur->DeclareComposant("PvZoneBoiteSelectHtml") ;
				$this->CompEmetteur->FournisseurDonnees = $this->CreeFournDonneesPrinc() ;
				$this->CompEmetteur->FournisseurDonnees->RequeteSelection = "(select * from pays where id_region=1)" ;
				$this->CompEmetteur->NomColonneLibelle = "libpays" ;
				$this->CompEmetteur->NomColonneValeur = "idpays" ;
				$this->FltRefTransact = $this->FormPrinc->InsereFltEditHttpPost('ref_transact', 'ref_transact') ;
				$this->FltRefTransact->Libelle = "No Reference" ;
				$this->FltMontant = $this->FormPrinc->InsereFltEditHttpPost('montant', 'montant') ;
				$this->FltMontant->Libelle = "Montant" ;
				$this->FltMontant->FormatteurEtiquette = new PvFmtMonnaieEtiquetteFiltre() ;
				$this->FltValNominaleUnit = $this->FormPrinc->InsereFltEditHttpPost('val_nominale_unit', 'val_nominale_unit') ;
				$this->FltValNominaleUnit->Libelle = "Valeur nominale unitaire" ;
				$this->FltValNominaleUnit->FormatteurEtiquette = new PvFmtMonnaieEtiquetteFiltre() ;
				if($this->FormPrinc->InclureElementEnCours)
				{
					$this->FltDuree = $this->FormPrinc->InsereFltEditHttpPost('duree_emission', 'duree_emission') ;
					$this->FltDuree->Libelle = "Dur&eacute;e" ;
				}
				$this->FltTaux = $this->FormPrinc->InsereFltEditHttpPost('taux', 'taux') ;
				$this->FltTaux->Libelle = "Taux int&eacute;r&ecirc;t" ;
				$this->FltDiffere = $this->FormPrinc->InsereFltEditHttpPost('differe', 'differe') ;
				$this->FltDiffere->Libelle = "Differ&eacute;" ;
				$this->FltPrix = $this->FormPrinc->InsereFltEditHttpPost('prix', 'prix') ;
				$this->FltPrix->Libelle = "Prix" ;
				$this->FltDevise = $this->FormPrinc->InsereFltEditHttpPost('id_devise', 'id_devise') ;
				$this->FltDevise->Libelle = "Devise" ;
				$this->CompDevise = $this->FltDevise->DeclareComposant("PvZoneBoiteSelectHtml") ;
				$this->CompDevise->FournisseurDonnees = $this->CreeFournDonneesPrinc() ;
				$this->CompDevise->FournisseurDonnees->RequeteSelection = 'devise' ;
				$this->CompDevise->NomColonneValeur = 'id_devise' ;
				$this->CompDevise->NomColonneLibelle = 'code_devise' ;
				$this->FltDateEmission = $this->FormPrinc->InsereFltEditHttpPost('date_emission', 'date_emission') ;
				$this->FltDateEmission->Libelle = "Date valeur" ;
				$this->CompDateEmission = $this->FltDateEmission->DeclareComposant("PvCalendarDateInput") ;
				$this->FltDateEmission->DefinitFmtLbl(new PvFmtLblDateFr()) ;
				$this->FltDateEcheance = $this->FormPrinc->InsereFltEditHttpPost('date_echeance', 'date_echeance') ;
				$this->FltDateEcheance->Libelle = "Date &eacute;cheance" ;
				$this->CompDateEcheance = $this->FltDateEcheance->DeclareComposant("PvCalendarDateInput") ;
				$this->FltDateEcheance->DefinitFmtLbl(new PvFmtLblDateFr()) ;
				$this->FltCodeISIN = $this->FormPrinc->InsereFltEditHttpPost('code_isin', 'code_isin') ;
				$this->FltCodeISIN->Libelle = "Code ISIN" ;
				// $this->FltPourcentMttAdjuc->ValeurParDefaut = ' % DU MONTANT MIS EN ADJUCATION EST OFFERT SOUS FORME D\'OFFRES NON COMPETITIVES (ONC) AUX SPECIALISTES EN VALEUR DU TRESOR (SVT) HABILIT&Eacute; DE L\'EMETTEUR' ;
				$this->FltPourcentMttAdjuc = $this->FormPrinc->InsereFltEditHttpPost('pourcent_mtt_adjuc', 'pourcent_mtt_adjuc') ;
				$this->CompPourcentMttAdjuc = $this->FltPourcentMttAdjuc->DeclareComposant("PvZoneMultiligneHtml") ;
				$this->CompPourcentMttAdjuc->TotalLignes = 4 ;
				$this->CompPourcentMttAdjuc->TotalColonnes = 90 ;
				$this->CompPourcentMttAdjuc->StyleCSS = "background:none; border:1px solid white; padding:4px; text-align:center; font-size:12px; font-weight:bold;" ;
				$this->FltPourcentMttAdjuc->Libelle = "Pourcentage montant adjucation" ;
				$this->FltDateDepotSoumiss = $this->FormPrinc->InsereFltEditHttpPost('date_depot_soumiss', 'date_depot_soumiss') ;
				$this->FltDateDepotSoumiss->Libelle = "Date depot soumission" ;
				$this->CompDateDepotSoumiss = $this->FltDateDepotSoumiss->DeclareComposant("PvCalendarDateInput") ;
				$this->FltDateDepotSoumiss->DefinitFmtLbl(new PvFmtLblDateFr()) ;
				$this->FltHeureDepotSoumiss = $this->FormPrinc->InsereFltEditHttpPost('heure_depot_soumiss', 'heure_depot_soumiss') ;
				$this->FltHeureDepotSoumiss->Libelle = "Heure depot soumission" ;
				$this->CompHeureDepotSoumiss = $this->FltHeureDepotSoumiss->DeclareComposant("PvTimeInput") ;
				$this->FltIdAppSoumiss = $this->FormPrinc->InsereFltEditHttpPost('id_app_depot_soumiss', 'id_app_depot_soumiss') ;
				$this->FltIdAppSoumiss->Libelle = "Application soumission" ;
				$this->FltLieuEtabl = $this->FormPrinc->InsereFltEditHttpPost('lieu_etabl', 'lieu_etabl') ;
				$this->FltLieuEtabl->Libelle = "Lieu etablissement" ;
				$this->FltDateEtabl = $this->FormPrinc->InsereFltEditHttpPost('date_etabl', 'date_etabl') ;
				$this->FltDateEtabl->Libelle = "Date etablissement" ;
				$this->CompDateEtabl = $this->FltDateEtabl->DeclareComposant("PvCalendarDateInput") ;
				$this->FltDateEtabl->DefinitFmtLbl(new PvFmtLblDateFr()) ;
				$this->FltDirecteurTresor = $this->FormPrinc->InsereFltEditHttpPost('directeur_tresor', 'directeur_tresor') ;
				$this->FltDirecteurTresor->Libelle = "Directeur tresor" ;
				$this->FltLieuSignature = $this->FormPrinc->InsereFltEditHttpPost('lieu_signature', 'lieu_signature') ;
				$this->FltLieuSignature->Libelle = "Lieu signature" ;
				$this->FltDateSignature = $this->FormPrinc->InsereFltEditHttpPost('date_signature', 'date_signature') ;
				$this->FltDateSignature->Libelle = "Date signature" ;
				$this->CompDateSignature = $this->FltDateSignature->DeclareComposant("PvCalendarDateInput") ;
				$this->FltDateSignature->DefinitFmtLbl(new PvFmtLblDateFr()) ;
				$this->FournDonneesPrinc->RequeteSelection = "(select t1.*, DATEDIFF(date_echeance, date_emission) duree_emission from emission_obligation t1)" ;
				$this->FournDonneesPrinc->TableEdition = "emission_obligation" ;
				$this->FormPrinc->MaxFiltresEditionParLigne = 1 ;
				if($this->FormPrinc->Editable == 1)
				{
					$this->CritrValidPrinc = $this->FormPrinc->CommandeExecuter->InsereNouvCritere(new CritrValidEmissObligationTradPlatf()) ;
					$this->CritrNonVidePrinc = $this->FormPrinc->CommandeExecuter->InsereNouvCritere(new PvCritereNonVide()) ;
					$this->CritrNonVidePrinc->FiltresCibles = array(&$this->FltRefTransact, &$this->FltMontant)  ;
				}
			}
			protected function AccesPossibleFormPrinc()
			{
				$ok = 0 ;
				if($this->PourAjout || $this->PourDetail)
					return 1 ;
				$bd = $this->BDPrinc() ;
				$total = $bd->FetchSqlValue('select count(0) total from reserv_obligation t1 where id_emission=:id', array('id' => $this->FltId->Lie()), 'total') ;
				if(is_numeric($total))
				{
					if($total == 0)
					{
						$ok = 1 ;
					}
				}
				return $ok ;
			}
			public function RenduSpecifique()
			{
				return $this->FormPrinc->RenduDispositif() ;
			}
			protected function RenduDispositifBrut()
			{
				$ctn = '' ;
				if($this->AccesPossibleFormPrinc())
				{
					if($this->InclureTitreFormPrinc)
					{
						$ctn .= '<div align="center" class="ui-widget ui-widget-content ui-state-active ui-corner-all">'.$this->TitreFormPrinc.'</div>'.PHP_EOL ;
						$ctn .= '<br />' ;
					}
					// $ctn .= $this->ZoneParent->RemplisseurConfig->AppliqueScriptObligation($this) ;
					$ctn .= $this->FormPrinc->RenduDispositif() ;
				}
				else
				{
					$ctn .= '<div class="ui-widget ui-state-error">Cette &eacute;mission a &eacute;t&eacute; r&eacute;serv&eacute;e au moins une fois</div>' ;
				}
				return $ctn ;
			}
		}
		class ScriptAjoutEmissObligationTradPlatf extends ScriptLgn1EmissObligationTradPlatf
		{
			protected function DefinitExprs()
			{
				$this->Titre = $this->ZoneParent->FournExprs->TitrFenModifEmissObligation ;
			}
		}
		class ScriptModifEmissObligationTradPlatf extends ScriptLgn1EmissObligationTradPlatf
		{
			public $NomClasseCmdExecFormPrinc = "PvCommandeModifElement" ;
			public $PourAjout = 0 ;
			protected function DefinitExprs()
			{
				$this->Titre = $this->ZoneParent->FournExprs->TitrFenModifEmissObligation ;
			}
		}
		class ScriptSupprEmissObligationTradPlatf extends ScriptModifEmissObligationTradPlatf
		{
			public $NomClasseCmdExecFormPrinc = "PvCommandeSupprElement" ;
			public $FormPrincEditable = 0 ;
			protected function DefinitExprs()
			{
				$this->Titre = $this->ZoneParent->FournExprs->TitrFenSupprEmissObligation ;
			}
		}
		class ScriptDetailEmissObligationTradPlatf extends ScriptModifEmissObligationTradPlatf
		{
			public $PourDetail = 1 ;
			public $FormPrincEditable = 0 ;
			public $InscrireCmdExecFormPrinc = 0 ;
		}
		
		class ScriptDetailProposEmissObligationTradPlatf extends ScriptModifEmissObligationTradPlatf
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
				$this->FltIdTablSecond = $this->TablSecond->InsereFltSelectHttpGet('id', 'id_emission = <self>') ;
				$this->FltNumOpTablSecond = $this->TablSecond->InsereFltSelectFixe('numOpDemandeur', $this->ZoneParent->IdMembreConnecte(), 'numop_demandeur = <self>') ;
				$this->TablSecond->CacherFormulaireFiltres = 1 ;
				$this->DefColIdTablSecond = $this->TablSecond->InsereDefColCachee('id') ;
				$this->DefColMontantTablSecond = $this->TablSecond->InsereDefColMoney('montant') ;
				$this->DefColTauxTablSecond = $this->TablSecond->InsereDefCol('taux') ;
				$this->DefColActsTablSecond = $this->TablSecond->InsereDefColActions('Actions') ;
				$this->FournDonneesSecond = $this->CreeFournDonneesPrinc() ;
				$this->FournDonneesSecond->RequeteSelection = 'reserv_obligation' ;
				$this->TablSecond->FournisseurDonnees = & $this->FournDonneesSecond ;
				$this->LienModifSecond = $this->TablSecond->InsereLienOuvreFenetreAction($this->DefColActsTablSecond, '?appelleScript=modifReservEmissObligation&id=${id}', 'Modifier', 'modif_reserv_emiss_obligation_${id}', 'Modifier r&eacute;serv. &eacute;mission obligation ${montant} ${taux}%', $this->OptsFenetreEdit) ;
				$this->LienModifSecond->ClasseCSS = "lien-act-001" ;
				$this->LienSupprSecond = $this->TablSecond->InsereLienOuvreFenetreAction($this->DefColActsTablSecond, '?appelleScript=supprReservEmissObligation&id=${id}', 'Supprimer', 'suppr_reserv_emiss_obligation_${id}', 'Supprimer r&eacute;serv. &eacute;mission obligation ${montant} ${taux}%', $this->OptsFenetreEdit) ;
				$this->LienSupprSecond->ClasseCSS = "lien-act-002" ;
				$this->CmdAjoutSecond = $this->TablSecond->InsereCmdOuvreFenetreScript("ajoutReservEmissObligation", '?appelleScript=ajoutReservEmissObligation&id_emission='.urlencode($this->FltIdTablSecond->Lie()), 'Ajouter', 'ajoutReservEmissObligation', "R&eacute;server une &eacute;mission obligation", $this->OptsFenetreEdit) ;
			}
			protected function DefinitExprs()
			{
				$this->Titre = $this->ZoneParent->FournExprs->TitrFenDetailProposEmissObligation ;
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
		
		class ScriptListReservEmissObligationTradPlatf extends ScriptModifEmissObligationTradPlatf
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
			public $ActMajStatut ;
			public $DefColActs ;
			public function DetermineEnvironnement()
			{
				parent::DetermineEnvironnement() ;
				$this->FormPrinc->Editable = 0 ;
				$this->FormPrinc->CacherBlocCommandes = 1 ;
				$this->DetermineActMajStatut() ;
				$this->DetermineTableSecond() ;
			}
			protected function DetermineActMajStatut()
			{
				$this->ActMajStatut = $this->InsereActionAvantRendu("MajStatut", new ActValidReservEmissObligationTradPlatf()) ;
				$this->ActMajStatut->ChargeConfig() ;
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
				$this->FltIdTablSecond = $this->TablSecond->InsereFltSelectHttpGet('id', 'id_emission = <self>') ;
				$this->TablSecond->CacherFormulaireFiltres = 1 ;
				$this->DefColIdTablSecond = $this->TablSecond->InsereDefColCachee('id') ;
				$this->DefColNumOpTablSecond = $this->TablSecond->InsereDefColCachee('id') ;
				$this->DefColIdEmissTablSecond = $this->TablSecond->InsereDefColCachee('id_emission') ;
				$this->DefColNumOpTablSecond = $this->TablSecond->InsereDefColCachee('numop') ;
				$this->DefColLoginTablSecond = $this->TablSecond->InsereDefCol('login', "Login") ;
				$this->DefColLoginTablSecond->AlignElement = "center" ;
				$this->DefColCodeEntiteTablSecond = $this->TablSecond->InsereDefCol('code_entite', "Code entit&eacute;") ;
				$this->DefColCodeEntiteTablSecond->AlignElement = "center" ;
				$this->DefColEntiteTablSecond = $this->TablSecond->InsereDefCol('nom_entite', "Entit&eacute;") ;
				$this->DefColMontantTablSecond = $this->TablSecond->InsereDefColMoney('montant', "Montant") ;
				$this->DefColMontantTablSecond->AlignElement = "right" ;
				$this->DefColStatut = $this->TablSecond->InsereDefColChoix('est_valide', 'Statut', '', array("<span style='color:blue'>N/A</span>", "<span style='color:green'>Accept&eacute;</span>", "<span style='color:red'>Refus&eacute;</span>")) ;
				$this->DefColStatut->AlignElement = "center" ;
				$this->DefColStatut->StyleCSS = "" ;
				$this->DefColActs = $this->TablSecond->InsereDefColActions('Actions') ;
				$this->LienAccepter = $this->TablSecond->InsereLienAction($this->DefColActs, $this->ActMajStatut->ObtientUrlFmt(array("idReserv" => '${id}'), array("id" => $this->FltId->Lie(), "estValide" => 1)), "Accepter") ;
				$this->LienAccepter->ClasseCSS = "lien-act-003" ;
				$this->LienRefuser = $this->TablSecond->InsereLienAction($this->DefColActs, $this->ActMajStatut->ObtientUrlFmt(array("idReserv" => '${id}'), array("id" => $this->FltId->Lie(), "estValide" => 2)), "Refuser") ;
				$this->LienRefuser->ClasseCSS = "lien-act-002" ;
				/*
				$this->DefColActsTablSecond = $this->TablSecond->InsereDefColActions("Actions") ;
				$this->LienDetailsTablSecond = $this->TablSecond->InsereLienOuvreFenetreAction($this->DefColActsTablSecond, '?appelleScript=detailReservEmissObligation&id=${id_emission}&numop=${numop}', 'D&eacute;tails', 'details_reserv_emiss_obligation_${id}_${numop}', 'Details &eacute;mission obligation #${login}', $this->OptsFenetreDetail) ;
				*/
				$this->FournDonneesSecond = $this->CreeFournDonneesPrinc() ;
				$this->FournDonneesSecond->RequeteSelection = '(select t1.*, t2.numop, t2.login, t2.nomop, t2.prenomop, t3.name nom_entite, t3.code code_entite
from reserv_obligation t1
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
					if($this->ActMajStatut->MsgResultat != '')
					{	
						$ctn .= '<div class="ui-widget ui-widget-content ui-state-highlight">'.$this->ActMajStatut->MsgResultat.'</div>'.PHP_EOL ;
						$ctn .= '<div>&nbsp;</div>'.PHP_EOL ;
					}
					$ctn .= '<div class="ui-widget ui-widget-content">' ;
					$ctn .= $this->TablSecond->RenduDispositif() ;
					// print_r($this->TablSecond->FournisseurDonnees) ;
					$ctn .= '</div>' ;
				}
				return $ctn ;
			}
			protected function DefinitExprs()
			{
				$this->Titre = $this->ZoneParent->FournExprs->TitrFenListReservEmissObligation ;
			}
		}
		class ScriptDetailReservEmissObligationTradPlatf extends ScriptListEmissObligationTradPlatf
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
				$this->FltId = $this->TablPrinc->InsereFltSelectHttpGet('id', 'id_emission = <self>') ;
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
from reserv_obligation t1
left join operateur t2
on t1.numop_demandeur = t2.numop
left join entite t3
on t2.id_entite = t3.id_entite)' ;
			}
		}
		
		class ScriptLstReservEmissObligationValideTradPlatf extends ScriptListReservEmissObligationTradPlatf
		{
			protected function ChargeTablSecond()
			{
				parent::ChargeTablSecond() ;
				$this->LienDetailsTablSecond->FormatURL = '?appelleScript=dtlReservEmissObligationValide&id=${id_emission}&numop=${numop}' ;
				$this->LienDetailsTablSecond->FormatIdOnglet = 'dtls_reserv_emiss_obligation_${id}_${numop}_valide';
				$this->FournDonneesSecond->RequeteSelection = '(select t1.*, t2.numop, t2.login, t2.nomop, t2.prenomop, t3.name nom_entite
from reserv_obligation t1
left join operateur t2
on t1.numop_demandeur = t2.numop
left join entite t3
on t2.id_entite = t3.id_entite
where t1.est_valide = 1
group by t2.login, t1.id_emission)' ;
			}
		}
		class ScriptDtlReservEmissObligationValideTradPlatf extends ScriptDetailReservEmissObligationTradPlatf
		{
			protected function DetermineTablPrinc()
			{
				parent::DetermineTablPrinc() ;
				$this->DefColEntite->Visible = 0 ;
				$this->DefColLogin->Visible = 0 ;
				$this->DefColActs->Visible = 0 ;
				$this->FournDonneesPrinc->RequeteSelection = '(select t1.*, t2.numop, t2.login, t2.nomop, t2.prenomop, t3.name nom_entite
from reserv_obligation t1
left join operateur t2
on t1.numop_demandeur = t2.numop
left join entite t3
on t2.id_entite = t3.id_entite
where est_valide=1)' ;
			}
		}
		class ScriptLng1ReservEmissObligationTradPlatf extends ScriptEditEmissObligationTradPlatf
		{
			public $FltId ;
			public $FltIdEmission ;
			public $FltTaux ;
			public $FltMontant ;
			public $FltNumOp ;
			public $NomClasseCmdExecFormPrinc = "PvCommandeAjoutElement" ;
			public $PourAjout = 1 ;
			public $FormPrincEditable = 1 ;
			protected function DefinitExprs()
			{
				$this->Titre = $this->ZoneParent->FournExprs->TitrFenAjoutReservEmissObligation ;
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
				$this->FltIdEmission = $this->FormPrinc->InsereFltEditHttpGet('id_emission', 'id_emission') ;
				$this->FltIdEmission->LectureSeule = 1 ;
				$this->FltNumOp = $this->FormPrinc->InsereFltEditFixe('numop', $this->ZoneParent->IdMembreConnecte(), 'numop_demandeur') ;
				$this->FltMontant = $this->FormPrinc->InsereFltEditHttpPost('montant', 'montant') ;
				$this->FltMontant->Libelle = "Montant" ;
				$this->FltTaux = $this->FormPrinc->InsereFltEditHttpPost('taux', 'taux') ;
				$this->FltTaux->Libelle = "Taux" ;
				$this->FournDonneesPrinc->RequeteSelection = "reserv_obligation" ;
				$this->FournDonneesPrinc->TableEdition = "reserv_obligation" ;
				$this->FormPrinc->MaxFiltresEditionParLigne = 1 ;
			}
			protected function AccesPossibleFormPrinc()
			{
				$ok = 1 ;
				return $ok ;
			}
			protected function CalculeMontantParDefaut()
			{
				if(! $this->PourAjout)
					return ;
				$idLgnEmiss = $this->FltIdEmission->Lie() ;
				// print 'MM : '.$idLgnEmiss ;
				$bd = $this->BDPrinc() ;
				$montant = $bd->FetchSqlValue('select montant from emission_obligation where id='.$bd->ParamPrefix.'id', array('id' => $idLgnEmiss), 'montant') ;
				$this->FltMontant->ValeurParDefaut = $montant ;
			}
			protected function RenduDispositifBrut()
			{
				$ctn = '' ;
				if($this->AccesPossibleFormPrinc())
				{
					$this->CalculeMontantParDefaut() ;
					$ctn .= parent::RenduDispositifBrut() ;
				}
				else
				{
					$ctn .= '<div class="ui-widget ui-state-error">Cette &eacute;mission a &eacute;t&eacute; r&eacute;serv&eacute;e au moins une fois</div>' ;
				}
				return $ctn ;
			}
		}
		class ScriptAjoutReservEmissObligationTradPlatf extends ScriptModifEmissObligationTradPlatf
		{
			public $FltIdEmission ;
			public $PourDetail = 1 ;
			public $LgnReserv = array() ;
			public function DetermineEnvironnement()
			{
				parent::DetermineEnvironnement() ;
				$this->DetermineFormSecond() ;
			}
			protected function ChargeFormPrinc()
			{
				parent::ChargeFormPrinc() ;
				$this->FormPrinc->Editable = 0 ;
				$this->FormPrinc->CacherBlocCommandes = 1 ;
			}
			protected function DetermineLgnReserv()
			{
				$this->LgnsReserv = $this->BDPrinc()->FetchSqlRows('select * from reserv_obligation where id_emission=:idEmiss and numop_demandeur=:numOp', array('idEmiss' => $this->FltIdEmission->Lie(), 'numOp' => $this->ZoneParent->IdMembreConnecte())) ; 
			}
			protected function DetermineFormSecond()
			{
				$this->FormSecond = $this->CreeFormPrinc() ;
				$this->InitFormSecond() ;
				$this->FormSecond->AdopteScript('formSecond', $this) ;
				$this->FormSecond->ChargeConfig() ;
				$this->ChargeFormSecond() ;
			}
			protected function InitFormSecond()
			{
				$this->FormSecond->NomClasseCommandeExecuter = "CmdAjoutReservObligationTradPlatf" ;
				$this->FormSecond->NomClasseCommandeAnnuler = "PvCmdFermeFenetreActiveAdminDirecte" ;
				$this->FormSecond->InclureElementEnCours = 0 ;
				$this->FormSecond->InclureTotalElements = 0 ;
			}
			protected function ChargeFormSecond()
			{
				$this->FournDonneesSecond = $this->CreeFournDonneesPrinc() ;
				$this->FormSecond->FournisseurDonnees = & $this->FournDonneesSecond ;
				$this->FournDonneesSecond->RequeteSelection = "reserv_obligation" ;
				$this->FournDonneesSecond->TableEdition = "reserv_obligation" ;
				$this->FormSecond->InclureTotalElements = 0 ;
				$this->FormSecond->InclureElementEnCours = 0 ;
				$this->FltIdEmission = $this->FormSecond->InsereFltEditHttpGet('id', 'id_emission') ;
				$this->FltIdEmission->LectureSeule = 1 ;
				$this->DetermineLgnReserv() ;
				$this->FltMontant1 = $this->FormSecond->InsereFltEditHttpPost('mtt', '') ;
				$this->FltMontant1->ValeurParDefaut = (isset($this->LgnsReserv[0]["montant"])) ? $this->LgnsReserv[0]["montant"] : '' ;
				$this->FltMontant1->Libelle = "Montant propos&eacute;" ;
			}
			protected function RenduDispositifBrut()
			{
				$ctn = parent::RenduDispositifBrut() ;
				if(count($this->LgnsReserv) == 0 || $this->LgnsReserv[0]["est_valide"] == 0)
				{
					$ctn .= $this->FormSecond->RenduDispositif() ;
				}
				else
				{
					$ctn .= '<div class="ui-widget ui-widget-content ui-state-error">Vous ne pouvez plus modifier le montant propos&eacute; : '.format_money($this->LgnsReserv[0]["montant"]).'</div>' ;
				}
				return $ctn ;
			}
		}
		class ScriptModifReservEmissObligationTradPlatf extends ScriptLng1ReservEmissObligationTradPlatf
		{
			public $NomClasseCmdExecFormPrinc = "PvCommandeModifElement" ;
			public $PourAjout = 0 ;
			protected function DefinitExprs()
			{
				$this->Titre = $this->ZoneParent->FournExprs->TitrFenModifReservEmissObligation ;
			}
		}
		class ScriptSupprReservEmissObligationTradPlatf extends ScriptModifReservEmissObligationTradPlatf
		{
			public $NomClasseCmdExecFormPrinc = "PvCommandeSupprElement" ;
			public $FormPrincEditable = 0 ;
			protected function DefinitExprs()
			{
				$this->Titre = $this->ZoneParent->FournExprs->TitrFenSupprReservEmissObligation ;
			}
		}
		
		class ActValidReservEmissObligationTradPlatf extends PvActionBaseZoneWebSimple
		{
			protected $LgnDetail ;
			protected $ValParamId ;
			protected $ValParamIdReserv ;
			public $MsgResultat ;
			public function Execute()
			{
				$this->TraiteLgnDetail() ;
			}
			protected function TraiteLgnDetail()
			{
				$this->ValParamId = _GET_def("id") ;
				$this->ValParamIdReserv = _GET_def("idReserv") ;
				$this->ValParamEstValide = intval(_GET_def("estValide")) ;
				// print_r($_GET) ;
				$bd = $this->ScriptParent->ApplicationParent->BDPrincipale ;
				$this->LgnDetail = $bd->FetchSqlRow('select t1.* from reserv_obligation t1
inner join emission_obligation t2 on t1.id_emission = t2.id
where t1.id=:idReserv and t1.id_emission=:idEmiss and t2.numop_publieur=:idMembre',
array("idReserv" => $this->ValParamIdReserv, "idEmiss" => $this->ValParamId, "idMembre" => $this->ZoneParent->IdMembreConnecte())) ;
				// print_r($bd) ;
				if(is_array($this->LgnDetail) && count($this->LgnDetail) > 0)
				{
					$ok = $bd->UpdateRow("reserv_obligation", array("est_valide" => $this->ValParamEstValide), 'id = :id', array("id" => $this->LgnDetail["id"])) ;
					if($ok)
					{
						$this->MsgResultat = "D&eacute;tail mis &agrave; jour." ;
					}
					else
					{
						$this->MsgResultat = "Exception lors de la mise &grave; jour" ;
					}
				}
				else
				{
					$this->MsgResultat = "Vous n'avez pas acc&egrave;s &agrave; ce d&eacute;tail" ;
				}
			}
		}
		
		class CmdAjoutReservObligationTradPlatf extends PvCommandeExecuterBase
		{
			public function ExecuteInstructions()
			{
				$bd = $this->ApplicationParent->BDPrincipale ;
				$form = & $this->FormulaireDonneesParent ;
				$script = & $this->ScriptParent ;
				$form->LieTousLesFiltres() ;
				$idEmiss = $script->FltIdEmission->Lie() ;
				$numOpDemandeur = $script->ZoneParent->IdMembreConnecte() ;
				$ok = $bd->RunSql('delete from reserv_obligation where id_emission=:idEmiss and numop_demandeur=:numOpDemandeur', array('idEmiss' => $idEmiss, 'numOpDemandeur' => $numOpDemandeur)) ;
				if($ok)
				{
					$montant = $script->FltMontant1->Lie() ;
					$bd->InsertRow('reserv_obligation', array('numop_demandeur' => $numOpDemandeur, 'id_emission' => $idEmiss, 'montant' => $montant)) ;
					$this->ConfirmeSucces() ;
				}
				else
				{
					$this->RenseigneErreur('Erreur SQL !!!') ;
				}
			}
		}
		
		class CritrValidEmissObligationTradPlatf extends PvCritereBase
		{
			public function EstRespecte()
			{
				$bd = $this->ApplicationParent->BDPrincipale ;
				$valDateEmiss = $this->ScriptParent->FltDateEmission->Lie() ;
				$valDateEcheance = $this->ScriptParent->FltDateEcheance->Lie() ;
				$timestmpJour = date("U", strtotime(date("Y-m-d"))) ;
				$idEmiss = $this->ScriptParent->FltId->Lie() ;
				if(! $this->FormulaireDonneesParent->InclureElementEnCours)
				{
					$timestmpEmiss = strtotime($valDateEmiss) ;
					$timestmpEcheance = strtotime($valDateEcheance) ;
					if($timestmpJour > $timestmpEmiss || $timestmpEmiss > $timestmpEcheance)
					{
						$this->MessageErreur = 'La date d\'&eacute;ch&eacute;ance ne doit pas &ecirc;tre anterieure &agrave; la date de valeur' ;
						return 0 ;
					}
				}
				$totEmissSimil = $bd->FetchSqlValue('select count(0) tot from emission_obligation where upper(ref_transact)=upper(:refTransact) and id <> :idEmiss', array('refTransact' => $this->ScriptParent->FltRefTransact->Lie(), 'idEmiss' => $idEmiss), 'tot') ;
				if($totEmissSimil > 0)
				{
					$this->MessageErreur = 'Le num&eacute;ro de transaction a &eacute;t&eacute; utilis&eacute;' ;
					return 0 ;
				}
				return 1 ;
			}
		}
		
	}
	
?>
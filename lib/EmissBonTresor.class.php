<?php
	
	if(! defined('EMISS_BON_TRESOR_TRAD_PLATF'))
	{
		define('EMISS_BON_TRESOR_TRAD_PLATF', 1) ;
		
		class ScriptBaseEmissBonTresorTradPlatf extends ScriptTransactBaseTradPlatf
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

		class ScriptListEmissBonTresorTradPlatf extends ScriptBaseEmissBonTresorTradPlatf
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
				return new TableauDonneesBaseTradPlatf() ;
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
		class ScriptEditEmissBonTresorTradPlatf extends ScriptBaseEmissBonTresorTradPlatf
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
		
		class Script1EmissBonTresorTradPlatf extends ScriptListEmissBonTresorTradPlatf
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
					$this->SousMenuConsult = $this->BarreMenu->MenuRacine->InscritSousMenuScript('consultEmissBonTresor') ;
					$this->SousMenuConsult->CheminMiniature = "images/miniatures/consulte_achat_devise.png" ;
					$this->SousMenuConsult->Titre = "Consultation" ;
				}
				if($this->ZoneParent->PossedePrivilege('post_doc_tresorier'))
				{
					// Publication
					$this->SousMenuPublier = $this->BarreMenu->MenuRacine->InscritSousMenuScript('publierEmissBonTresor') ;
					$this->SousMenuPublier->CheminMiniature = "images/miniatures/consulte_achat_devise.png" ;
					$this->SousMenuPublier->Titre = "Publications" ;
					// Propositions
					$this->SousMenuPropos = $this->BarreMenu->MenuRacine->InscritSousMenuScript('proposEmissBonTresor') ;
					$this->SousMenuPropos->CheminMiniature = "images/miniatures/consulte_achat_devise.png" ;
					$this->SousMenuPropos->Titre = "R&eacute;servations" ;
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
		
		class ScriptPublierEmissBonTresorTradPlatf extends Script1EmissBonTresorTradPlatf
		{
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
				$this->DefColId = $this->TablPrinc->InsereDefColCachee('id') ;
				$this->DefColNumOp = $this->TablPrinc->InsereDefColCachee('numop_publieur') ;
				$this->DefColRefTransact = $this->TablPrinc->InsereDefCol('ref_transact', 'Ref.') ;
				$this->DefColDateEmiss = $this->TablPrinc->InsereDefCol('date_emission', 'Date &eacute;mission') ;
				$this->DefColDateEmiss->AliasDonnees = $bd->SqlDateToStrFr("date_emission", 0) ;
				$this->DefColMontant = $this->TablPrinc->InsereDefColMoney('montant', 'Montant') ;
				$this->DefColDevise = $this->TablPrinc->InsereDefCol('code_devise', 'Devise') ;
				$this->DefColDateEcheance = $this->TablPrinc->InsereDefCol('date_echeance', 'Date &eacute;ch&eacute;ance') ;
				$this->DefColDateEcheance->NomDonnees = "date_echeance" ;
				$this->DefColDateEcheance->AliasDonnees = $bd->SqlDateToStrFr("date_echeance", 0) ;
				$this->FournDonneesPrinc->RequeteSelection = '(SELECT t1.*, d1.code_devise
FROM emission_bon_tresor t1
left join devise d1 on t1.id_devise = d1.id_devise)' ;
				$this->DefColActs = $this->TablPrinc->InsereDefColActions("Actions") ;
				$this->LienModif = $this->TablPrinc->InsereLienOuvreFenetreAction($this->DefColActs, '?appelleScript=modifEmissBonTresor&id=${id}', 'Modifier', 'modif_emiss_bon_tresor_${id}', 'Modifier &eacute;mission bon de tr&eacute;sor #${ref_transact}', $this->OptsFenetreEdit) ;
				$this->LienSuppr = $this->TablPrinc->InsereLienOuvreFenetreAction($this->DefColActs, '?appelleScript=supprEmissBonTresor&id=${id}', 'Supprimer', 'suppr_emiss_bon_tresor_${id}', 'Supprimer &eacute;mission bon de tr&eacute;sor #${ref_transact}', $this->OptsFenetreEdit) ;
				$this->CmdAjout = $this->TablPrinc->InsereCmdOuvreFenetreScript("ajoutEmissBonTresor", '?appelleScript=ajoutEmissBonTresor', 'Ajouter', 'ajoutEmissBonTresor', "Poster une &eacute;mission bon de tr&eacute;sor", $this->OptsFenetreEdit) ;
			}
			protected function DefinitExprs()
			{
				$this->Titre = $this->ZoneParent->FournExprs->TitrFenPublierEmissBonTresor ;
			}
		}
		class ScriptConsultEmissBonTresorTradPlatf extends Script1EmissBonTresorTradPlatf
		{
			public $Privileges = array('post_op_change') ;
			public $LienReserv ;
			public $FournDonneesPrinc ;
			public $DefColId ;
			public $DefColNumOp ;
			public $DefColRefTransact ;
			public $DefColDateEmiss ;
			public $DefColMontant ;
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
				$this->DefColId = $this->TablPrinc->InsereDefColCachee('id') ;
				$this->DefColNumOp = $this->TablPrinc->InsereDefColCachee('numop_publieur') ;
				$this->DefColRefTransact = $this->TablPrinc->InsereDefCol('ref_transact', 'Ref.') ;
				$this->DefColDateEmiss = $this->TablPrinc->InsereDefCol('date_emission', 'Date &eacute;mission') ;
				$this->DefColDateEmiss->AliasDonnees = $bd->SqlDateToStrFr("date_emission", 0) ;
				$this->DefColMontant = $this->TablPrinc->InsereDefColMoney('montant', 'Montant') ;
				$this->DefColDevise = $this->TablPrinc->InsereDefCol('code_devise', 'Devise') ;
				$this->DefColDateEcheance = $this->TablPrinc->InsereDefCol('date_echeance', 'Date &eacute;ch&eacute;ance') ;
				$this->DefColDateEcheance->NomDonnees = "date_echeance" ;
				$this->DefColDateEcheance->AliasDonnees = $bd->SqlDateToStrFr("date_echeance", 0) ;
				$this->FournDonneesPrinc->RequeteSelection = '(SELECT t1.*, d1.code_devise
FROM emission_bon_tresor t1
left join devise d1 on t1.id_devise = d1.id_devise)' ;
				$this->DefColActs = $this->TablPrinc->InsereDefColActions("Actions") ;
				$this->LienReserv = $this->TablPrinc->InsereLienOuvreFenetreAction($this->DefColActs, '?appelleScript=detailProposEmissBonTresor&id=${id}', 'Details', 'detail_emiss_bon_tresor_${id}', 'D&eacute;tails &eacute;mission bon de tr&eacute;sor #${ref_transact}', $this->OptsFenetreDetail) ;
			}
			protected function DefinitExprs()
			{
				$this->Titre = $this->ZoneParent->FournExprs->TitrFenConsultEmissBonTresor ;
			}
		}
		class ScriptProposEmissBonTresorTradPlatf extends Script1EmissBonTresorTradPlatf
		{
			public $Privileges = array('post_doc_tresorier') ;
			public $LienReserv ;
			public $FournDonneesPrinc ;
			public $DefColId ;
			public $DefColNumOp ;
			public $DefColRefTransact ;
			public $DefColDateEmiss ;
			public $DefColMontant ;
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
				$this->FltDateDebut->ValeurParDefaut = date("Y-m-d", date("u") - 86400 * 90) ;
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
				$this->DefColDevise = $this->TablPrinc->InsereDefCol('code_devise', 'Devise') ;
				$this->DefColDateEcheance = $this->TablPrinc->InsereDefCol('date_echeance', 'Date &eacute;ch&eacute;ance') ;
				$this->DefColDateEcheance->NomDonnees = "date_echeance" ;
				$this->DefColDateEcheance->AliasDonnees = $bd->SqlDateToStrFr("date_echeance", 0) ;
				$this->FournDonneesPrinc->RequeteSelection = '(select t1.*, t2.total total_reserv, d1.code_devise from emission_bon_tresor t1
inner join (select id_emission, count(0) total from reserv_bon_tresor group by id_emission) t2
on t1.id = t2.id_emission
left join devise d1 on t1.id_devise = d1.id_devise)' ;
				$this->DefColActs = $this->TablPrinc->InsereDefColActions("Actions") ;
				$this->LienReserv = $this->TablPrinc->InsereLienOuvreFenetreAction($this->DefColActs, '?appelleScript=listReservEmissBonTresor&id=${id}', 'R&eacute;servations', 'list_reserv_emiss_bon_tresor_${id}', 'Liste r&eacute;servations &eacute;mission bon de tr&eacute;sor #${ref_transact}', $this->OptsFenetreDetail) ;
			}
			protected function DefinitExprs()
			{
				$this->Titre = $this->ZoneParent->FournExprs->TitrFenProposEmissBonTresor ;
			}
		}
		
		class ScriptLgn1EmissBonTresorTradPlatf extends ScriptEditEmissBonTresorTradPlatf
		{
			public $FltId ;
			public $FltRefTransact ;
			public $FltMontant ;
			public $FltDevise ;
			public $FltDateEmission ;
			public $FltDateEcheance ;
			public $CompDevise ;
			public $FltNumOp ;
			public $CompDateEmission ;
			public $CompDateEcheance ;
			public $NomClasseCmdExecFormPrinc = "PvCommandeAjoutElement" ;
			public $PourAjout = 1 ;
			public $PourDetail = 0 ;
			public $FormPrincEditable = 1 ;
			public $CritrValidPrinc ;
			protected function DefinitExprs()
			{
				$this->Titre = $this->ZoneParent->FournExprs->TitrFenAjoutEmissBonTresor ;
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
				$this->FltRefTransact = $this->FormPrinc->InsereFltEditHttpPost('ref_transact', 'ref_transact') ;
				$this->FltRefTransact->Libelle = "No Reference" ;
				$this->FltMontant = $this->FormPrinc->InsereFltEditHttpPost('montant', 'montant') ;
				$this->FltMontant->Libelle = "Montant emission" ;
				$this->FltDevise = $this->FormPrinc->InsereFltEditHttpPost('id_devise', 'id_devise') ;
				$this->FltDevise->Libelle = "Devise" ;
				$this->CompDevise = $this->FltDevise->DeclareComposant("PvZoneBoiteSelectHtml") ;
				$this->CompDevise->FournisseurDonnees = $this->CreeFournDonneesPrinc() ;
				$this->CompDevise->FournisseurDonnees->RequeteSelection = 'devise' ;
				$this->CompDevise->NomColonneValeur = 'id_devise' ;
				$this->CompDevise->NomColonneLibelle = 'lib_devise' ;
				$this->FltDateEmission = $this->FormPrinc->InsereFltEditHttpPost('date_emission', 'date_emission') ;
				$this->FltDateEmission->Libelle = "Date �mission" ;
				$this->CompDateEmission = $this->FltDateEmission->DeclareComposant("PvCalendarDateInput") ;
				$this->FltDateEcheance = $this->FormPrinc->InsereFltEditHttpPost('date_echeance', 'date_echeance') ;
				$this->FltDateEcheance->Libelle = "Date echeance" ;
				$this->CompDateEcheance = $this->FltDateEcheance->DeclareComposant("PvCalendarDateInput") ;
				$this->FournDonneesPrinc->RequeteSelection = "emission_bon_tresor" ;
				$this->FournDonneesPrinc->TableEdition = "emission_bon_tresor" ;
				$this->FormPrinc->MaxFiltresEditionParLigne = 1 ;
				if($this->FormPrinc->Editable == 1)
				{
					$this->CritrValidPrinc = $this->FormPrinc->CommandeExecuter->InsereNouvCritere(new CritrValidEmissBonTresorTradPlatf()) ;
				}
			}
			protected function AccesPossibleFormPrinc()
			{
				$ok = 0 ;
				if($this->PourAjout || $this->PourDetail)
					return 1 ;
				$bd = $this->BDPrinc() ;
				$total = $bd->FetchSqlValue('select count(0) total from reserv_bon_tresor t1 where id_emission=:id', array('id' => $this->FltId->Lie()), 'total') ;
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
		class ScriptAjoutEmissBonTresorTradPlatf extends ScriptLgn1EmissBonTresorTradPlatf
		{
			protected function DefinitExprs()
			{
				$this->Titre = $this->ZoneParent->FournExprs->TitrFenModifEmissBonTresor ;
			}
		}
		class ScriptModifEmissBonTresorTradPlatf extends ScriptLgn1EmissBonTresorTradPlatf
		{
			public $NomClasseCmdExecFormPrinc = "PvCommandeModifElement" ;
			public $PourAjout = 0 ;
			protected function DefinitExprs()
			{
				$this->Titre = $this->ZoneParent->FournExprs->TitrFenModifEmissBonTresor ;
			}
		}
		class ScriptSupprEmissBonTresorTradPlatf extends ScriptModifEmissBonTresorTradPlatf
		{
			public $NomClasseCmdExecFormPrinc = "PvCommandeSupprElement" ;
			public $FormPrincEditable = 0 ;
			protected function DefinitExprs()
			{
				$this->Titre = $this->ZoneParent->FournExprs->TitrFenSupprEmissBonTresor ;
			}
		}
		
		class ScriptDetailProposEmissBonTresorTradPlatf extends ScriptModifEmissBonTresorTradPlatf
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
				return new TableauDonneesBaseTradPlatf() ;
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
				$this->FournDonneesSecond->RequeteSelection = 'reserv_bon_tresor' ;
				$this->TablSecond->FournisseurDonnees = & $this->FournDonneesSecond ;
				$this->LienModifSecond = $this->TablSecond->InsereLienOuvreFenetreAction($this->DefColActsTablSecond, '?appelleScript=modifReservEmissBonTresor&id=${id}', 'Modifier', 'modif_reserv_emiss_bon_tresor_${id}', 'Modifier r&eacute;serv. &eacute;mission bon de tr&eacute;sor ${montant} ${taux}%', $this->OptsFenetreEdit) ;
				$this->LienSupprSecond = $this->TablSecond->InsereLienOuvreFenetreAction($this->DefColActsTablSecond, '?appelleScript=supprReservEmissBonTresor&id=${id}', 'Supprimer', 'suppr_reserv_emiss_bon_tresor_${id}', 'Supprimer r&eacute;serv. &eacute;mission bon de tr&eacute;sor ${montant} ${taux}%', $this->OptsFenetreEdit) ;
				$this->CmdAjoutSecond = $this->TablSecond->InsereCmdOuvreFenetreScript("ajoutReservEmissBonTresor", '?appelleScript=ajoutReservEmissBonTresor&id_emission='.urlencode($this->FltIdTablSecond->Lie()), 'Ajouter', 'ajoutReservEmissBonTresor', "R&eacute;server une &eacute;mission bon de tr&eacute;sor", $this->OptsFenetreEdit) ;
			}
			protected function DefinitExprs()
			{
				$this->Titre = $this->ZoneParent->FournExprs->TitrFenDetailProposEmissBonTresor ;
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
		
		class ScriptListReservEmissBonTresorTradPlatf extends ScriptModifEmissBonTresorTradPlatf
		{

			public $PourDetail = 1 ;
			public $TablSecond ;
			public $FltNumOpTablSecond ;
			public $FltIdTablSecond ;
			public $DefColIdTablSecond ;
			public $DefColEntiteTablSecond ;
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
				return new TableauDonneesBaseTradPlatf() ;
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
				$this->DefColEntiteTablSecond = $this->TablSecond->InsereDefCol('nom_entite') ;
				$this->DefColMontantTablSecond = $this->TablSecond->InsereDefColMoney('montant') ;
				$this->DefColTauxTablSecond = $this->TablSecond->InsereDefCol('taux') ;
				$this->FournDonneesSecond = $this->CreeFournDonneesPrinc() ;
				$this->FournDonneesSecond->RequeteSelection = 'reserv_bon_tresor(select t1.*, t2.login, t2.nomop, t2.prenomop, t3.name nom_entite
from reserv_bon_tresor t1
left join operateur t2
on t1.numop_demandeur = t2.numop
left join entite t3
on t2.id_entite = t3.id_entite
group by t1.numop_demandeur)' ;
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
				$this->Titre = $this->ZoneParent->FournExprs->TitrFenListReservEmissBonTresor ;
			}
		}
		
		class ScriptLng1ReservEmissBonTresorTradPlatf extends ScriptEditEmissBonTresorTradPlatf
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
				$this->Titre = $this->ZoneParent->FournExprs->TitrFenAjoutReservEmissBonTresor ;
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
				$this->FournDonneesPrinc->RequeteSelection = "reserv_bon_tresor" ;
				$this->FournDonneesPrinc->TableEdition = "reserv_bon_tresor" ;
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
				$montant = $bd->FetchSqlValue('select montant from emission_bon_tresor where id='.$bd->ParamPrefix.'id', array('id' => $idLgnEmiss), 'montant') ;
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
		class ScriptAjoutReservEmissBonTresorTradPlatf extends ScriptLng1ReservEmissBonTresorTradPlatf
		{
		}
		class ScriptModifReservEmissBonTresorTradPlatf extends ScriptLng1ReservEmissBonTresorTradPlatf
		{
			public $NomClasseCmdExecFormPrinc = "PvCommandeModifElement" ;
			public $PourAjout = 0 ;
			protected function DefinitExprs()
			{
				$this->Titre = $this->ZoneParent->FournExprs->TitrFenModifReservEmissBonTresor ;
			}
		}
		class ScriptSupprReservEmissBonTresorTradPlatf extends ScriptLng1ReservEmissBonTresorTradPlatf
		{
			public $NomClasseCmdExecFormPrinc = "PvCommandeSupprElement" ;
			public $FormPrincEditable = 0 ;
			protected function DefinitExprs()
			{
				$this->Titre = $this->ZoneParent->FournExprs->TitrFenSupprReservEmissBonTresor ;
			}
		}
		
		class CritrValidEmissBonTresorTradPlatf extends PvCritereBase
		{
			public function EstRespecte()
			{
				$valDateEmiss = $this->ScriptParent->FltDateEmission->Lie() ;
				$valDateEcheance = $this->ScriptParent->FltDateEcheance->Lie() ;
				$timestmpJour = date("U", strtotime(date("Y-m-d"))) ;
				$timestmpEmiss = strtotime($valDateOper) ;
				$timestmpEcheance = strtotime($valDateValeur) ;
				if($timestmpJour > $timestmpEmiss || $timestmpEmiss > $timestmpEcheance)
				{
					$this->MessageErreur = 'La date d\'&eacute;ch&eacute;ance ne doit pas &ecirc;tre inferieure &agrave; la date de valeur ou la date actuelle' ;
					return 0 ;
				}
				return 1 ;
			}
		}
		
	}
	
?>
<?php
	
	if(! defined('RACHAT_BON_TRESOR_TRAD_PLATF'))
	{
		define('RACHAT_BON_TRESOR_TRAD_PLATF', 1) ;
		
		class ScriptBaseRachatBonTresorTradPlatf extends ScriptTransactBaseTradPlatf
		{
			public $OptsFenetreEdit = array("Largeur" => 875, 'Hauteur' => 825, 'Modal' => 1, "BoutonFermer" => 0) ;
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

		class ScriptListRachatBonTresorTradPlatf extends ScriptBaseRachatBonTresorTradPlatf
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
		class ScriptEditRachatBonTresorTradPlatf extends ScriptBaseRachatBonTresorTradPlatf
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
		
		class Script1RachatBonTresorTradPlatf extends ScriptListRachatBonTresorTradPlatf
		{
			public $BarreMenu ;
			public $SousMenuPublier ;
			public $SousMenuConsult ;
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
					$this->SousMenuConsult = $this->BarreMenu->MenuRacine->InscritSousMenuScript('consultRachatBonTresor') ;
					$this->SousMenuConsult->CheminMiniature = "images/miniatures/consulte_achat_devise.png" ;
					$this->SousMenuConsult->Titre = "Consultation" ;
				}
				if($this->ZoneParent->PossedePrivileges(array('post_doc_tresorier', 'post_op_change')))
				{
					// Publication
					$this->SousMenuPublier = $this->BarreMenu->MenuRacine->InscritSousMenuScript('publierRachatBonTresor') ;
					$this->SousMenuPublier->CheminMiniature = "images/miniatures/consulte_achat_devise.png" ;
					$this->SousMenuPublier->Titre = "Publication" ;
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
		
		class ScriptPublierRachatBonTresorTradPlatf extends Script1RachatBonTresorTradPlatf
		{
			public $TitreDocument = "Rachat Bon du Tr&eacute;sor" ;
			public $Titre = "Rachat Bon du Tr&eacute;sor" ;
			public $Privileges = array('post_doc_tresorier', 'post_op_change') ;
			public $CmdAjout ;
			public $LienModif ;
			public $LienSuppr ;
			public $FournDonneesPrinc ;
			public $DefColId ;
			public $DefColNumOp ;
			public $DefColRefTransact ;
			public $DefColDateRachat ;
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
				$this->TablPrinc->SensColonneTri = "desc" ;
				$this->TablPrinc->AccepterTriColonneInvisible = 1 ;
				$this->DefColId = $this->TablPrinc->InsereDefColCachee('id') ;
				$this->DefColNumOp = $this->TablPrinc->InsereDefColCachee('numop_publieur') ;
				$this->DefColRefTransact = $this->TablPrinc->InsereDefCol('ref_transact', 'Ref.') ;
				$this->DefColDateRachat = $this->TablPrinc->InsereDefCol('date_emission', 'Date &Eacute;mission') ;
				$this->DefColDateRachat->AliasDonnees = $bd->SqlDateToStrFr("date_emission", 0) ;
				$this->DefColMontant = $this->TablPrinc->InsereDefColMoney('montant', 'Montant') ;
				$this->DefColDevise = $this->TablPrinc->InsereDefCol('code_devise', 'Devise') ;
				$this->DefColDateEcheance = $this->TablPrinc->InsereDefCol('date_echeance', 'Date &eacute;ch&eacute;ance') ;
				$this->DefColDateEcheance->NomDonnees = "date_echeance" ;
				$this->DefColDateEcheance->AliasDonnees = $bd->SqlDateToStrFr("date_echeance", 0) ;
				$this->FournDonneesPrinc->RequeteSelection = '(SELECT t1.*, d1.code_devise
FROM rachat_bon_tresor t1
left join devise d1 on t1.id_devise = d1.id_devise)' ;
				$this->DefColActs = $this->TablPrinc->InsereDefColActions("Actions") ;
				$this->LienModif = $this->TablPrinc->InsereLienOuvreFenetreAction($this->DefColActs, '?appelleScript=modifRachatBonTresor&id=${id}', 'Modifier', 'modif_emiss_bon_tresor_${id}', 'Modifier Rachat Bon du Tr&eacute;sor #${ref_transact}', $this->OptsFenetreEdit) ;
				$this->LienModif->ClasseCSS = "lien-act-001" ;
				$this->LienModif->DefinitScriptOnglActifSurFerm($this) ;
				$this->LienSuppr = $this->TablPrinc->InsereLienOuvreFenetreAction($this->DefColActs, '?appelleScript=supprRachatBonTresor&id=${id}', 'Supprimer', 'suppr_emiss_bon_tresor_${id}', 'Supprimer Rachat Bon du Tr&eacute;sor #${ref_transact}', $this->OptsFenetreEdit) ;
				$this->LienSuppr->ClasseCSS = "lien-act-002" ;
				$this->LienSuppr->DefinitScriptOnglActifSurFerm($this) ;
				$this->CmdAjout = $this->TablPrinc->InsereCmdOuvreFenetreScript("ajoutRachatBonTresor", '?appelleScript=ajoutRachatBonTresor', 'Ajouter', 'ajoutRachatBonTresor', "Rachat Bon du Tr&eacute;sor", $this->OptsFenetreEdit) ;
				$this->CmdAjout->DefinitScriptOnglActifSurFerm($this) ;
			}
			protected function DefinitExprs()
			{
				$this->Titre = $this->ZoneParent->FournExprs->TitrFenPublierRachatBonTresor ;
			}
		}
		class ScriptConsultRachatBonTresorTradPlatf extends Script1RachatBonTresorTradPlatf
		{
			public $TitreDocument = "Consulter rachat Bon du Tr&eacute;sor" ;
			public $Titre = "Consulter rachat Bon du Tr&eacute;sor" ;
			public $Privileges = array('post_op_change') ;
			public $LienDetail ;
			public $FournDonneesPrinc ;
			public $DefColId ;
			public $DefColNumOp ;
			public $DefColRefTransact ;
			public $DefColDateRachat ;
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
				$this->TablPrinc->AccepterTriColonneInvisible = 1 ;
				$this->TablPrinc->SensColonneTri = "desc" ;
				$this->DefColId = $this->TablPrinc->InsereDefColCachee('id') ;
				$this->DefColNumOp = $this->TablPrinc->InsereDefColCachee('numop_publieur') ;
				$this->DefColRefTransact = $this->TablPrinc->InsereDefCol('ref_transact', 'Ref.') ;
				$this->DefColDateRachat = $this->TablPrinc->InsereDefCol('date_emission', 'Date valeur') ;
				$this->DefColDateRachat->AliasDonnees = $bd->SqlDateToStrFr("date_emission", 0) ;
				$this->DefColMontant = $this->TablPrinc->InsereDefColMoney('montant', 'Montant') ;
				$this->DefColDevise = $this->TablPrinc->InsereDefCol('code_devise', 'Devise') ;
				$this->DefColDateEcheance = $this->TablPrinc->InsereDefCol('date_echeance', 'Date &eacute;ch&eacute;ance') ;
				$this->DefColDateEcheance->NomDonnees = "date_echeance" ;
				$this->DefColDateEcheance->AliasDonnees = $bd->SqlDateToStrFr("date_echeance", 0) ;
				$this->FournDonneesPrinc->RequeteSelection = '(SELECT t1.*, d1.code_devise
FROM rachat_bon_tresor t1
left join devise d1 on t1.id_devise = d1.id_devise)' ;
				$this->DefColActs = $this->TablPrinc->InsereDefColActions("Actions") ;
				$this->LienDetail = $this->TablPrinc->InsereLienOuvreFenetreAction($this->DefColActs, '?appelleScript=detailRachatBonTresor&id=${id}', 'd&eacute;tails', 'detail_emiss_bon_tresor_${id}', 'D&eacute;tails Rachat Bon du Tr&eacute;sor #${ref_transact}', $this->OptsFenetreEdit) ;
				$this->LienDetail->ClasseCSS = "lien-act-003" ;
			}
			protected function DefinitExprs()
			{
				$this->Titre = $this->ZoneParent->FournExprs->TitrFenConsultRachatBonTresor ;
			}
		}
		
		class ScriptLgn1RachatBonTresorTradPlatf extends ScriptEditRachatBonTresorTradPlatf
		{
			public $InclureTitreFormPrinc = 1 ;
			public $TitreFormPrinc = "Caract&eacute;ristiques Rachat bon du tr&eacute;sor par Adjudication" ;
			public $Privileges = array('post_doc_tresorier', 'post_op_change') ;
			public $FltId ;
			public $FltEmetteur ;
			public $CompEmetteur ;
			public $FltValNominaleUnit ;
			public $FltDuree ;
			public $FltCodeISIN ;
			public $FltTauxInteret ;
			public $FltRefTransact ;
			public $FltMontant ;
			public $FltDevise ;
			public $FltDateEmission ;
			public $FltDateEcheance ;
			public $FltPourcentMttAdjuc ;
			public $FltDateDepotSoumiss ;
			public $FltHeureDepotSoumiss ;
			public $FltIdAppDepotSoumiss ;
			public $FltLieuEtabl ;
			public $FltDateEtabl ;
			public $FltDirecteurTresor ;
			public $CompDevise ;
			public $FltNumOp ;
			public $CompDateRachat ;
			public $CompDateEcheance ;
			public $NomClasseCmdExecFormPrinc = "PvCommandeAjoutElement" ;
			public $PourAjout = 1 ;
			public $PourDetail = 0 ;
			public $FormPrincEditable = 1 ;
			public $InscrireCmdExecFormPrinc = 1 ;
			public $CritrNonVidePrinc ;
			public $CritrValidPrinc ;
			protected function DefinitExprs()
			{
				$this->Titre = $this->ZoneParent->FournExprs->TitrFenAjoutRachatBonTresor ;
			}
			protected function InitFormPrinc()
			{
				parent::InitFormPrinc() ;
				$this->FormPrinc->NomClasseCommandeExecuter = $this->NomClasseCmdExecFormPrinc ;
				$this->FormPrinc->InclureElementEnCours = ($this->PourAjout) ? 0 : 1 ;
				$this->FormPrinc->InclureTotalElements = ($this->PourAjout) ? 0 : 1 ;
				$this->FormPrinc->Editable = $this->FormPrincEditable ;
				$this->FormPrinc->InscrireCommandeExecuter = $this->InscrireCmdExecFormPrinc ;
				$this->FormPrinc->DessinateurFiltresEdition = new DessinFltsBonTresorMarchSecTradPlatf() ;
			}
			protected function ChargeFormPrinc()
			{
				parent::ChargeFormPrinc() ;
				$this->FltId = $this->FormPrinc->InsereFltLgSelectHttpGet('id', 'id = <self>') ;
				$this->FltNumOp = $this->FormPrinc->InsereFltEditFixe('numop', $this->ZoneParent->IdMembreConnecte(), 'numop_publieur') ;
				$this->FltEmetteur = $this->FormPrinc->InsereFltEditHttpPost('emetteur', 'emetteur') ;
				$this->FltEmetteur->Libelle = "Emetteur" ;
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
				$this->FltTauxInteret = $this->FormPrinc->InsereFltEditHttpPost('taux_interet', 'taux_interet') ;
				$this->FltTauxInteret->Libelle = "Taux int&eacute;r&ecirc;t" ;
				$this->FltDevise = $this->FormPrinc->InsereFltEditHttpPost('id_devise', 'id_devise') ;
				$this->FltDevise->Libelle = "Devise" ;
				$this->CompDevise = $this->FltDevise->DeclareComposant("PvZoneBoiteSelectHtml") ;
				$this->CompDevise->FournisseurDonnees = $this->CreeFournDonneesPrinc() ;
				$this->CompDevise->FournisseurDonnees->RequeteSelection = 'devise' ;
				$this->CompDevise->NomColonneValeur = 'id_devise' ;
				$this->CompDevise->NomColonneLibelle = 'code_devise' ;
				$this->FltDateEmission = $this->FormPrinc->InsereFltEditHttpPost('date_emission', 'date_emission') ;
				$this->FltDateEmission->Libelle = "Date valeur" ;
				$this->CompDateRachat = $this->FltDateEmission->DeclareComposant("PvCalendarDateInput") ;
				$this->FltDateEcheance = $this->FormPrinc->InsereFltEditHttpPost('date_echeance', 'date_echeance') ;
				$this->FltDateEcheance->Libelle = "Date &eacute;cheance" ;
				$this->CompDateEcheance = $this->FltDateEcheance->DeclareComposant("PvCalendarDateInput") ;
				$this->FltCodeISIN = $this->FormPrinc->InsereFltEditHttpPost('code_isin', 'code_isin') ;
				$this->FltCodeISIN->Libelle = "Code ISIN" ;
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
				$this->FournDonneesPrinc->RequeteSelection = "(select t1.*, DATEDIFF(date_echeance, date_emission) duree_emission from rachat_bon_tresor t1)" ;
				$this->FournDonneesPrinc->TableEdition = "rachat_bon_tresor" ;
				$this->FormPrinc->MaxFiltresEditionParLigne = 1 ;
				if($this->FormPrinc->Editable == 1)
				{
					$this->CritrValidPrinc = $this->FormPrinc->CommandeExecuter->InsereNouvCritere(new CritrValidRachatBonTresorTradPlatf()) ;
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
				return 1 ;
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
					// $ctn .= $this->ZoneParent->RemplisseurConfig->AppliqueScriptBonTresorMarchSec($this) ;
					$ctn .= $this->FormPrinc->RenduDispositif() ;
				}
				else
				{
					$ctn .= '<div class="ui-widget ui-state-error">Ce rachat a &eacute;t&eacute; r&eacute;serv&eacute;e au moins une fois</div>' ;
				}
				return $ctn ;
			}
		}
		class ScriptAjoutRachatBonTresorTradPlatf extends ScriptLgn1RachatBonTresorTradPlatf
		{
			protected function DefinitExprs()
			{
				$this->Titre = $this->ZoneParent->FournExprs->TitrFenModifRachatBonTresor ;
			}
		}
		class ScriptModifRachatBonTresorTradPlatf extends ScriptLgn1RachatBonTresorTradPlatf
		{
			public $NomClasseCmdExecFormPrinc = "PvCommandeModifElement" ;
			public $PourAjout = 0 ;
			protected function DefinitExprs()
			{
				$this->Titre = $this->ZoneParent->FournExprs->TitrFenModifRachatBonTresor ;
			}
		}
		class ScriptSupprRachatBonTresorTradPlatf extends ScriptModifRachatBonTresorTradPlatf
		{
			public $NomClasseCmdExecFormPrinc = "PvCommandeSupprElement" ;
			public $FormPrincEditable = 0 ;
			protected function DefinitExprs()
			{
				$this->Titre = $this->ZoneParent->FournExprs->TitrFenSupprRachatBonTresor ;
			}
		}
		class ScriptDetailRachatBonTresorTradPlatf extends ScriptModifRachatBonTresorTradPlatf
		{
			public $PourDetail = 1 ;
			public $FormPrincEditable = 0 ;
			public $InscrireCmdExecFormPrinc = 0 ;
		}

		class CritrValidRachatBonTresorTradPlatf extends PvCritereBase
		{
			public function EstRespecte()
			{
				$bd = $this->ApplicationParent->BDPrincipale ;
				$valDateRachat = $this->ScriptParent->FltDateEmission->Lie() ;
				$valDateEcheance = $this->ScriptParent->FltDateEcheance->Lie() ;
				$timestmpJour = date("U", strtotime(date("Y-m-d"))) ;
				$idRachat = $this->ScriptParent->FltId->Lie() ;
				if(! $this->FormulaireDonneesParent->InclureElementEnCours)
				{
					$timestmpRachat = strtotime($valDateRachat) ;
					$timestmpEcheance = strtotime($valDateEcheance) ;
					if($timestmpJour > $timestmpRachat || $timestmpRachat > $timestmpEcheance)
					{
						$this->MessageErreur = 'La date d\'&eacute;ch&eacute;ance ne doit pas &ecirc;tre anterieure &agrave; la date de valeur' ;
						return 0 ;
					}
				}
				$totRachatSimil = $bd->FetchSqlValue('select count(0) tot from rachat_bon_tresor where upper(ref_transact)=upper(:refTransact) and id <> :idRachat', array('refTransact' => $this->ScriptParent->FltRefTransact->Lie(), 'idRachat' => $idRachat), 'tot') ;
				if($totRachatSimil > 0)
				{
					$this->MessageErreur = 'Le num&eacute;ro de transaction a &eacute;t&eacute; utilis&eacute;' ;
					return 0 ;
				}
				return 1 ;
			}
		}
		
	}
	
?>
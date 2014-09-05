<?php
	
	if(! defined('OP_CHANGE_TRAD_PLATF'))
	{
		define('OP_CHANGE_TRAD_PLATF', 1) ;
		
		class FormulaireDonneesBaseTradPlatf extends PvFormulaireDonneesHtml
		{
			public $LibelleCommandeAnnuler = "Fermer" ;
		}
		class TableauDonneesBaseTradPlatf extends PvTableauDonneesAdminDirecte
		{
			public $ToujoursAfficher = 1 ;
			public $TitreBoutonSoumettreFormulaireFiltres = "Valider" ;
		}
		
		class ScriptListBaseOpChange extends PvScriptWebSimple
		{
			public $Tableau ;
			public $BarreMenu ;
			public $TypeOpChange = 1 ;
			public $Privileges = array('post_op_change') ;
			public $NecessiteMembreConnecte = 1 ;
			protected function CreeBarreMenu()
			{
				$barreMenu = new PvTablMenuHoriz() ;
				$barreMenu->NomClasseCSSCellSelect = "ui-widget ui-widget-header ui-state-focus" ;
				return $barreMenu ;
			}
			public function TypeOpChangeOppose()
			{
				return ($this->TypeOpChange == 1) ? 2 : 1 ;
			}
			protected function CreeTableau()
			{
				return new TableauDonneesBaseTradPlatf() ;
			}
			protected function DetermineBarreMenu()
			{
				$this->BarreMenu = $this->CreeBarreMenu() ;
				$this->BarreMenu->AdopteScript("barreMenu", $this) ;
				$this->BarreMenu->ChargeConfig() ;
				$smConsult = $this->BarreMenu->MenuRacine->InscritSousMenuScript(($this->TypeOpChange == 1) ? "listeAchatsDevise" : "listeVentesDevise") ;
				$smConsult->CheminMiniature = "images/miniatures/consulte_opchange.png" ;
				$smConsult->Titre = "Consultation" ;
				$smEdition = $this->BarreMenu->MenuRacine->InscritSousMenuScript(($this->TypeOpChange == 1) ? "editAchatsDevise" : "editVentesDevise") ;
				$smEdition->CheminMiniature = "images/miniatures/edit_opchange.png" ;
				$smEdition->Titre = "Publication" ;
				$smReserv = $this->BarreMenu->MenuRacine->InscritSousMenuScript(($this->TypeOpChange == 1) ? "reservAchatsDevise" : "reservVentesDevise") ;
				$smReserv->CheminMiniature = "images/miniatures/reserv_opchange.png" ;
				$smReserv->Titre = "R&eacute;servation" ;
			}
			protected function DetermineTableau()
			{
				$this->Tableau = $this->CreeTableau() ;
				$this->Tableau->AdopteScript("tableau", $this) ;
				$this->Tableau->ChargeConfig() ;
			}
			public function DetermineEnvironnement()
			{
				$this->DetermineBarreMenu() ;
				$this->DetermineTableau() ;
			}
			public function RenduSpecifique()
			{
				$ctn = '' ;
				$ctn .= '<div class="Titre">'.$this->Titre.'</div>'.PHP_EOL ;
				if($this->ZoneParent->InclureJQueryUi)
				{
					$ctn .= '<script language="javascript">
	jQuery(function() {
		jQuery(".Titre")
			.addClass("ui-widget ui-widget-header ui-state-active") ;
	}) ;
</script>' ;
				}
				$ctn .= $this->BarreMenu->RenduDispositif() ;
				$ctn .= $this->Tableau->RenduDispositif() ;
				// print_r($this->Tableau->FournisseurDonnees->BaseDonnees) ;
				return $ctn ;
			}
		}
		
		class TablConsultOpChangeTradPlatf extends TableauDonneesBaseTradPlatf
		{
			public $DefColPeutModif ;
			public $DefColPeutRep ;
			public $DefColId ;
			public $DefColEmetteur ;
			public $DefColBanque ;
			public $DefColMontant ;
			public $DefColLibDevise ;
			public $DefColDatePublic ;
			public $DefColDateValeur ;
			public $DefColDateOp ;
			public $DefColTaux ;
			public $DefColActions ;
			public $FmtModif ;
			public $FmtPostuls ;
			public $FltDateDebut ;
			public $FltDateFin ;
			public $FltTypeChange ;
			public $FltAcquis ;
			public $FltNumOp ;
			public $FltEntiteOp ;
			public $FltAuteurTransact ;
			public $FltPourAutres ;
			public $FltColValide ;
			public $CmdAjout ;
			public $RestrOps = 1 ;
			public $MsgConsultInterdit = '<div class="ui-state-error">Vous ne pouvez pas voir les demandes en cours. Veuillez poster <b>${nomOffre}</b> avant.</div>' ;
			protected function PeutVoirOps()
			{
				if($this->ZoneParent->PossedePrivilege('admin_members'))
				{
					return 1 ;
				}
				$bd = & $this->ApplicationParent->BDPrincipale ;
				$sql = 'select * from ('.TXT_SQL_SELECT_ACHAT_DEVISE_SOUMIS.') t1 where numop='.$bd->ParamPrefix.'numOp and type_change='.$bd->ParamPrefix.'typeChange' ;
				$row = $bd->FetchSqlRow($sql, array('numOp' => $this->ZoneParent->IdMembreConnecte(), "typeChange" => $this->ScriptParent->TypeOpChangeOppose())) ;
				return (count($row) > 0) ;
			}
			public function ChargeConfig()
			{
				$this->ChargeConfigBase() ;
				parent::ChargeConfig() ;
				$this->ChargeConfigSuppl() ;
			}
			protected function ChargeDefCols()
			{
				$bd = $this->ApplicationParent->BDPrincipale ;
				$this->DefColPeutModif = $this->InsereDefColInvisible("peut_modif") ;
				$this->DefColPeutRep = $this->InsereDefColInvisible("peut_repondre") ;
				$this->DefColId = new PvDefinitionColonneDonnees() ;
				$this->DefColId->Visible = 0 ;
				$this->DefColId->NomDonnees = "num_op_change" ;
				$this->DefinitionsColonnes[] = & $this->DefColId ;
				$this->DefColEmetteur = new PvDefinitionColonneDonnees() ;
				$this->DefColEmetteur->Libelle = "Auteur" ;
				$this->DefColEmetteur->NomDonnees = "loginop" ;
				$this->DefColEmetteur->Largeur = "8%" ;
				$this->DefColEmetteur->AlignElement = "center" ;
				$this->DefinitionsColonnes[] = & $this->DefColEmetteur ;
				$this->DefColBanque = new PvDefinitionColonneDonnees() ;
				$this->DefColBanque->Libelle = "Banque" ;
				$this->DefColBanque->NomDonnees = "nom_entite" ;
				$this->DefColBanque->Largeur = "15%" ;
				$this->DefColBanque->AlignElement = "center" ;
				$this->DefinitionsColonnes[] = & $this->DefColBanque ;
				$this->DefColDatePublic = new PvDefinitionColonneDonnees() ;
				$this->DefColDatePublic->Libelle = "Publi&eacute; le" ;
				$this->DefColDatePublic->NomDonnees = "date_change" ;
				$this->DefColDatePublic->AliasDonnees = $bd->SqlDateToStrFr("date_change", 1) ;
				$this->DefColDatePublic->Largeur = "12%" ;
				$this->DefColDatePublic->AlignElement = "center" ;
				$this->DefinitionsColonnes[] = & $this->DefColDatePublic ;
				$this->DefColDateOp = new PvDefinitionColonneDonnees() ;
				$this->DefColDateOp->Libelle = "Date Op." ;
				$this->DefColDateOp->NomDonnees = "date_operation" ;
				$this->DefColDateOp->AliasDonnees = $bd->SqlDateToStrFr("date_operation") ;
				$this->DefColDateOp->Largeur = "12%" ;
				$this->DefColDateOp->AlignElement = "center" ;
				$this->DefinitionsColonnes[] = & $this->DefColDateOp ;
				$this->DefColDateValeur = new PvDefinitionColonneDonnees() ;
				$this->DefColDateValeur->Libelle = "Date valeur" ;
				$this->DefColDateValeur->NomDonnees = "date_valeur" ;
				$this->DefColDateValeur->AliasDonnees = $bd->SqlDateToStrFr("date_valeur") ;
				$this->DefColDateValeur->Largeur = "12%" ;
				$this->DefColDateValeur->AlignElement = "center" ;
				$this->DefinitionsColonnes[] = & $this->DefColDateValeur ;
				$this->DefColMontant = new PvDefinitionColonneDonnees() ;
				$this->DefColMontant->Libelle = "Montant" ;
				$this->DefColMontant->NomDonnees = "montant_change" ;
				$this->DefColMontant->AliasDonnees = $bd->SqlToInt("montant_change") ;
				$this->DefColMontant->Largeur = "6%" ;
				$this->DefColMontant->AlignElement = "right" ;
				$this->DefinitionsColonnes[] = & $this->DefColMontant ;
				$this->DefColLibDevise = new PvDefinitionColonneDonnees() ;
				$this->DefColLibDevise->Libelle = "Devise" ;
				$this->DefColLibDevise->NomDonnees = "devise_change" ;
				$this->DefColLibDevise->Largeur = "12%" ;
				$this->DefColLibDevise->AlignElement = "center" ;
				$this->DefinitionsColonnes[] = & $this->DefColLibDevise ;
				$this->DefColTaux = new PvDefinitionColonneDonnees() ;
				$this->DefColTaux->Libelle = "Taux" ;
				$this->DefColTaux->NomDonnees = "taux_transact" ;
				$this->DefColTaux->AliasDonnees = $bd->SqlToInt("taux_transact") ;
				$this->DefColTaux->Largeur = "12%" ;
				$this->DefColTaux->AlignElement = "center" ;
				$this->DefinitionsColonnes[] = & $this->DefColTaux ;
				$this->DefColActions = new PvDefinitionColonneDonnees() ;
				$this->DefColActions->Libelle = "Actions" ;
				$this->DefColActions->TriPossible = 0 ;
				$this->DefColActions->Largeur = "*" ;
				$this->DefColActions->AlignElement = "center" ;
				$this->DefColActions->DeclareFormatteurLiens() ;
				$this->FmtModif = new PvConfigFormatteurColonneOuvreFenetre() ;
				$this->FmtModif->NomDonneesValid = "peut_modif" ;
				$this->FmtModif->FormatLibelle = "Modifier" ;
				$this->FmtModif->OptionsOnglet["Modal"] = 1 ;
				$this->FmtModif->OptionsOnglet["Largeur"] = 600 ;
				$this->FmtModif->OptionsOnglet["Hauteur"] = 535 ;
				$this->FmtModif->FormatTitreOnglet = ($this->ScriptParent->TypeOpChange == 1) ? 'Modifier achat de devise' : 'Modifier vente de devise' ;
				$this->FmtModif->FormatCheminIcone = 'images/icones/modif.png' ;
				$this->FmtModif->FormatURL = '?'.urlencode($this->ZoneParent->NomParamScriptAppele).'='.(($this->ScriptParent->TypeOpChange == 1) ? 'modifAchatDevise' : 'modifVenteDevise').'&idEnCours=${num_op_change}' ;
				$this->DefColActions->Formatteur->Liens[] = & $this->FmtModif ;
				$this->FmtPostuls = new PvConfigFormatteurColonneOuvreFenetre() ;
				$this->FmtPostuls->NomDonneesValid = "peut_modif" ;
				$this->FmtPostuls->FormatLibelle = "R&eacute;servations" ;
				$this->FmtPostuls->OptionsOnglet["Modal"] = 1 ;
				$this->FmtPostuls->OptionsOnglet["Hauteur"] = 600 ;
				$this->FmtPostuls->OptionsOnglet["Largeur"] = 750 ;
				$this->FmtPostuls->FormatTitreOnglet = ($this->ScriptParent->TypeOpChange == 1) ? 'R&eacute;servations achat de devise' : 'R&eacute;servations vente de devise' ;
				$this->FmtPostuls->FormatCheminIcone = 'images/icones/postulations.png' ;
				$this->FmtPostuls->FormatURL = '?'.urlencode($this->ZoneParent->NomParamScriptAppele).'='.(($this->ScriptParent->TypeOpChange == 1) ? 'postulsAchatDevise' : 'postulsVenteDevise').'&idEnCours=${num_op_change}' ;
				$this->DefColActions->Formatteur->Liens[] = & $this->FmtPostuls ;
				$this->FmtRepondre = new PvConfigFormatteurColonneOuvreFenetre() ;
				$this->FmtRepondre->NomDonneesValid = "peut_repondre" ;
				$this->FmtRepondre->FormatLibelle = "R&eacute;server" ;
				$this->FmtRepondre->OptionsOnglet["Modal"] = 1 ;
				$this->FmtRepondre->OptionsOnglet["Hauteur"] = 300 ;
				$this->FmtRepondre->FormatTitreOnglet = ($this->ScriptParent->TypeOpChange == 1) ? 'Repondre a l\'achat de devise' : 'Repondre a la vente de devise' ;
				$this->FmtRepondre->FormatCheminIcone = 'images/icones/repondre.png' ;
				$this->FmtRepondre->FormatURL = '?'.urlencode($this->ZoneParent->NomParamScriptAppele).'='.(($this->ScriptParent->TypeOpChange == 1) ? 'reponseAchatDevise' : 'reponseVenteDevise').'&idEnCours=${num_op_change}' ;
				$this->DefColActions->Formatteur->Liens[] = & $this->FmtRepondre ;
				$this->DefinitionsColonnes[] = & $this->DefColActions ;
			}
			protected function ChargeConfigBase()
			{
				$this->ChargeDefCols() ;
			}
			protected function ChargeFiltresSelectionStatiq()
			{
				$this->FltTypeChange = $this->CreeFiltreFixe('typeChange', $this->ScriptParent->TypeOpChange) ;
				$this->FltTypeChange->ExpressionDonnees = 'type_change = <self>' ;
				$this->FiltresSelection[] = & $this->FltTypeChange ;
				$this->FltAuteurTransact = $this->CreeFiltreFixe('auteurTransact', 0) ;
				$this->FltAuteurTransact->ExpressionDonnees = 'peut_repondre <> <self>' ;
				$this->FiltresSelection[] = & $this->FltAuteurTransact ;
				if(! $this->ZoneParent->PossedePrivilege("admin_members"))
				{
					$this->FltAcquis = $this->ScriptParent->CreeFiltreFixe(	
						'numRep',
						$this->ZoneParent->Membership->MemberLogged->Id
					) ;
					$this->FltAcquis->ExpressionDonnees = 'top_active = 1 and numrep=<self>' ;
					$this->FiltresSelection[] = & $this->FltAcquis ;
					$this->FltPourAutres = $this->ScriptParent->CreeFiltreFixe(	
						'pourAutres',
						$this->ZoneParent->Membership->MemberLogged->Id
					) ;
					$this->FltPourAutres->ExpressionDonnees = 'numop <> <self>' ;
					$this->FiltresSelection[] = & $this->FltPourAutres ;
					$this->FltEntiteOp = $this->ScriptParent->CreeFiltreFixe('entiteOp', $this->ZoneParent->Membership->MemberLogged->RawData["ID_ENTITE_MEMBRE"]) ;
					$this->FltEntiteOp->ExpressionDonnees = 'id_entite_dest = <self>' ;
					$this->FiltresSelection[] = & $this->FltEntiteOp ;
					if($this->RestrOps)
					{
						$this->FltColValide = $this->CreeFiltreFixe('valideOpChange', '1') ;
						$this->FltColValide->ExpressionDonnees = 'bool_valide = <self>' ;
						$this->FiltresSelection[] = & $this->FltColValide ;
					}
				}
				else
				{
					$this->FltAcquis = $this->ScriptParent->CreeFiltreFixe(	
						'idOperateur',
						$this->ZoneParent->Membership->MemberLogged->Id
					) ;
					$this->FltAcquis->ExpressionDonnees = '(numrep = <self> and numop <> <self>)' ;
					$this->FiltresSelection[] = & $this->FltAcquis ;
				}
			}
			protected function ObtientRequeteSelection(& $bd)
			{
				return "(select t1.*, case when t1.commiss_ou_taux = 0 then mtt_commiss when type_taux = 0 then taux_change else ecran_taux end taux_transact, ".$bd->SqlConcat(array('t2.code_devise', "' / '", 't3.code_devise'))." devise_change, t7.shortname nom_court_entite, t7.name nom_entite, t2.code_devise lib_devise1, t3.code_devise lib_devise2, t4.login loginop, t4.nomop nomop, t4.prenomop prenomop, t5.id_entite_source, t5.id_entite_dest, t5.top_active, t6.numop numrep, t6.login loginrep, case when t4.numop = t6.numop then 1 else 0 end peut_modif, case when t4.numop <> t6.numop then 1 else 0 end peut_repondre,
case when t1.num_op_change_dem = 0 then 'demande' else 'reponse' end type_message
from op_change t1
left join devise t2
on t1.id_devise1 = t2.id_devise
left join devise t3
on t1.id_devise2 = t3.id_devise
left join operateur t4
on t1.numop = t4.numop
left join oper_b_change t5
on t5.id_entite_source=t4.id_entite
left join entite t7
on t5.id_entite_source=t7.id_entite
left join operateur t6
on t5.id_entite_dest=t6.id_entite
where t5.id_entite_dest is not null and t7.id_entite is not null and t6.login is not null and t4.active_op = 1)" ;
			}
			protected function ChargeConfigSuppl()
			{
				if(! $this->RestrOps)
				{
					$this->CmdAjout = new PvCommandeOuvreFenetreAdminDirecte() ;
					$this->CmdAjout->Libelle = "Ajouter" ;
					$this->CmdAjout->NomScript = ($this->ScriptParent->TypeOpChange == 1) ? "ajoutAchatDevise" : "ajoutVenteDevise" ;
					$this->CmdAjout->OptionsOnglet = array("Largeur" => "670", "Hauteur" => "545", "Modal" => 1, "BoutonFermer" => 0, "BoutonExecuter" => 0) ;
					$this->InscritCommande("cmdAjoutDevise", $this->CmdAjout) ;
				}
				$bd = $this->ApplicationParent->BDPrincipale ;
				$this->FournisseurDonnees = new PvFournisseurDonneesSql() ;
				$this->FournisseurDonnees->BaseDonnees = $bd ;
				$this->FournisseurDonnees->RequeteSelection = $this->ObtientRequeteSelection($bd) ;
				$this->FltDateDebut = $this->ScriptParent->CreeFiltreHttpGet("dateDebut") ;
				$this->FltDateDebut->Libelle = "Date Debut" ;
				$this->FltDateDebut->ValeurParDefaut = date("Y-m-d", date("U") - 30 * 86400) ;
				$this->FltDateDebut->DeclareComposant("PvCalendarDateInput") ;
				$this->FltDateDebut->ExpressionDonnees = $bd->SqlDatePart('date_change').' >= '.$bd->SqlDatePart($bd->SqlStrToDateTime('<self>')) ;
				$this->FiltresSelection[] = & $this->FltDateDebut ;
				$this->FltDateFin = $this->ScriptParent->CreeFiltreHttpGet("dateFin") ;
				$this->FltDateFin->Libelle = "Date fin" ;
				$this->FltDateFin->DeclareComposant("PvCalendarDateInput") ;
				$this->FltDateFin->ExpressionDonnees = $bd->SqlDatePart('date_change').' <= '.$bd->SqlDatePart($bd->SqlStrToDateTime('<self>')) ;
				$this->FiltresSelection[] = & $this->FltDateFin ;
				$this->ChargeFiltresSelectionStatiq() ;
			}
			protected function RenduDispositifBrut()
			{
				$ctn = '' ;
				if($this->RestrOps && ! $this->PeutVoirOps())
				{
					$args = array('nomOffre' => ($this->ScriptParent->TypeOpChange == 1) ? 'une vente de devise' : 'un achat de devise') ;
					$ctn .= _parse_pattern($this->MsgConsultInterdit, $args) ;
				}
				else
				{
					$ctn .= parent::RenduDispositifBrut() ;
					// print_r($this->FournisseurDonnees->BaseDonnees) ;
				}
				return $ctn ;
			}
		}
		class TablEditOpChangeTradPlatf extends TablConsultOpChangeTradPlatf
		{
			public $RestrOps = 0 ;
			public function ChargeConfig()
			{
				parent::ChargeConfig() ;
				$this->DefColEmetteur->Visible = 0 ;
				$this->DefColBanque->Visible = 0 ;
				if($this->EstPasNul($this->FltPourAutres))
				{
					$this->FltPourAutres->NePasIntegrerParametre = 1 ;
				}
				$this->FltAcquis->ExpressionDonnees = 'numop = <self>' ;
				$this->FltAcquis->ValeurParDefaut = $this->ZoneParent->Membership->MemberLogged->Id ;
				$this->FltAuteurTransact->ValeurParDefaut = 1 ;
			}
		}
		class TablReservOpChangeTradPlatf extends TablEditOpChangeTradPlatf
		{
			protected function ObtientRequeteSelection(& $bd)
			{
				return "(select t1.*, t8.total_dem, case when t1.commiss_ou_taux = 0 then mtt_commiss when type_taux = 0 then taux_change else ecran_taux end taux_transact, ".$bd->SqlConcat(array('t2.code_devise', "' / '", 't3.code_devise'))." devise_change, t7.shortname nom_court_entite, t7.name nom_entite, t2.code_devise lib_devise1, t3.code_devise lib_devise2, t4.login loginop, t4.nomop nomop, t4.prenomop prenomop, t5.id_entite_source, t5.id_entite_dest, t5.top_active, t6.numop numrep, t6.login loginrep, case when t4.numop = t6.numop then 1 else 0 end peut_modif, case when t4.numop <> t6.numop then 1 else 0 end peut_repondre,
case when t1.num_op_change_dem = 0 then 'demande' else 'reponse' end type_message
from op_change t1
left join devise t2
on t1.id_devise1 = t2.id_devise
left join devise t3
on t1.id_devise2 = t3.id_devise
left join operateur t4
on t1.numop = t4.numop
left join oper_b_change t5
on t5.id_entite_source=t4.id_entite
left join entite t7
on t5.id_entite_source=t7.id_entite
left join operateur t6
on t5.id_entite_dest=t6.id_entite
left join (select num_op_change_dem, count(0) total_dem from op_change where num_op_change_dem is not null and num_op_change_dem <> 0 group by num_op_change_dem) t8
on t8.num_op_change_dem = t1.num_op_change
where t5.id_entite_dest is not null and t7.id_entite is not null and t6.login is not null and t4.active_op = 1 and t8.total_dem > 0)" ;
			}
		}
		
		class FormOpChangeBaseTradPlatf extends FormulaireDonneesBaseTradPlatf
		{
			public $InclureElementEnCours = 0 ;
			public $InclureTotalElements = 0 ;
			public $MaxFiltresEditionParLigne = 1 ;
			public $FltMontant ;
			public $FltDateValeur ;
			public $FltDateOper ;
			public $FltDevise1 ;
			public $FltDevise2 ;
			public $FltCommissOuTaux ;
			public $FltTypeTaux ;
			public $FltEcranTaux ;
			public $FltMttTaux ;
			public $FltCommentaire ;
			public $FltNumOp ;
			public $FltNumOpChange ;
			public $FltNumOpChangeRep ;
			public $FltTypeChange ;
			public $FltLibDevise ;
			public $FltTauxTransact ;
			public $CritrEcheanceInvalide ;
			public $TypeOpChange = 1 ;
			public $PourReponse = 0 ;
			public $NomClasseCommandeExecuter = "PvCommandeAjoutElement" ;
			public $NomClasseCommandeAnnuler = "PvCmdFermeFenetreActiveAdminDirecte" ;
			public $MsgReponseInterdit = '<div class="ui-state-error">Vous avez d&eacute;j&agrave; r&eacute;pondu &agrave; cette offre.</div>' ;
			protected function ReponsePossible()
			{
				$bd = & $this->ApplicationParent->BDPrincipale ;
				$sql = 'select * from op_change where num_op_change_dem='.$bd->ParamPrefix.'numOpChangeDem and numop='.$bd->ParamPrefix.'login' ;
				$row = $bd->FetchSqlRow(
					$sql,
					array(
						'numOpChangeDem' => $this->FltNumOpChange->Lie(),
						'login' => $this->ZoneParent->IdMembreConnecte()
					)
				) ;
				return (is_array($row) && count($row) == 0) ? 1 : 0 ;
			}
			public function TypeOpChangeRep()
			{
				return ($this->TypeOpChange == 1) ? 2 : 1 ;
			}
			protected function ChargeFiltresSelection()
			{
				parent::ChargeFiltresSelection() ;
				$this->FltNumOpChange = $this->ScriptParent->CreeFiltreHttpGet("idEnCours") ;
				$this->FltNumOpChange->ExpressionDonnees = 'num_op_change = <self>' ;
				$this->FiltresLigneSelection[] = & $this->FltNumOpChange ;
			}
			protected function ChargeFiltresEdition()
			{
				parent::ChargeFiltresEdition() ;
				// Lib Devise
				$this->FltLibDevise = $this->ScriptParent->CreeFiltreHttpPost("lib_devise") ;
				$this->FltLibDevise->NomParametreDonnees = 'devise_change' ;
				$this->FltLibDevise->Libelle = "Devise" ;
				$this->FiltresEdition[] = & $this->FltLibDevise ;
				// Taux Transaction
				$this->FltTauxTransact = $this->ScriptParent->CreeFiltreHttpPost("taux_transact") ;
				$this->FltTauxTransact->NomParametreDonnees = 'taux_transact' ;
				$this->FltTauxTransact->Libelle = "Taux / Commission" ;
				$this->FiltresEdition[] = & $this->FltTauxTransact ;
				// Devise 1
				$this->FltDevise1 = $this->ScriptParent->CreeFiltreHttpPost("devise1") ;
				$this->FltDevise1->DefinitColLiee("id_devise1") ;
				$this->FltDevise1->Libelle = "Devise" ;
				$this->FltDevise1->DeclareComposant("PvZoneBoiteSelectHtml") ;
				$comp = & $this->FltDevise1->Composant ;
				$comp->NomColonneLibelle = "code_devise" ;
				$comp->NomColonneValeur = "id_devise" ;
				$comp->FournisseurDonnees = new PvFournisseurDonneesSql() ;
				$comp->FournisseurDonnees->RequeteSelection = "devise" ;
				$comp->FournisseurDonnees->BaseDonnees = & $this->ApplicationParent->BDPrincipale ;
				$this->FiltresEdition[] = & $this->FltDevise1 ;
				// Devise 2
				$this->FltDevise2 = $this->ScriptParent->CreeFiltreHttpPost("devise2") ;
				$this->FltDevise2->DefinitColLiee("id_devise2") ;
				$this->FltDevise2->Libelle = "Devise" ;
				$this->FltDevise2->DeclareComposant("PvZoneBoiteSelectHtml") ;
				$comp = & $this->FltDevise2->Composant ;
				$comp->NomColonneLibelle = "code_devise" ;
				$comp->NomColonneValeur = "id_devise" ;
				$comp->FournisseurDonnees = new PvFournisseurDonneesSql() ;
				$comp->FournisseurDonnees->RequeteSelection = "devise" ;
				$comp->FournisseurDonnees->BaseDonnees = & $this->ApplicationParent->BDPrincipale ;
				$this->FiltresEdition[] = & $this->FltDevise2 ;
				// Commission ou taux
				$this->FltCommissOuTaux = $this->ScriptParent->CreeFiltreHttpPost("commiss_ou_taux") ;
				$this->FltCommissOuTaux->DefinitColLiee("commiss_ou_taux") ;
				$this->FiltresEdition[] = & $this->FltCommissOuTaux ;
				// Montant commission
				$this->FltMttComiss = $this->ScriptParent->CreeFiltreHttpPost("mtt_commiss") ;
				$this->FltMttComiss->DefinitColLiee("mtt_commiss") ;
				$this->FiltresEdition[] = & $this->FltMttComiss ;
				// Montant commission
				$this->FltTypeTaux = $this->ScriptParent->CreeFiltreHttpPost("mtt_commiss") ;
				$this->FltTypeTaux->DefinitColLiee("type_taux") ;
				$this->FiltresEdition[] = & $this->FltTypeTaux ;
				// Date commission
				$this->FltDateComiss = $this->ScriptParent->CreeFiltreHttpPost("date_commiss") ;
				$this->FltDateComiss->DefinitColLiee("date_commiss") ;
				$this->FltDateComiss->DeclareComposant("PvCalendarDateInput") ;
				$this->FiltresEdition[] = & $this->FltDateComiss ;
				// Montant
				$this->FltMontant = $this->ScriptParent->CreeFiltreHttpPost("montant") ;
				$this->FltMontant->DefinitColLiee("montant_change") ;
				$this->FltMontant->Libelle = "Montant" ;
				$this->FiltresEdition[] = & $this->FltMontant ;
				// Taux / Commission
				$this->FltMttTaux = $this->ScriptParent->CreeFiltreHttpPost("taux_change") ;
				$this->FltMttTaux->DefinitColLiee("taux_change") ;
				$this->FltMttTaux->Libelle = "Taux / Commission" ;
				$this->FltMttTaux->ValeurParDefaut = 0 ;
				$this->FltMttTaux->DeclareComposant("PvZoneTexteHtml") ;
				$this->FltMttTaux->Composant->Largeur = "24px" ;
				$this->FiltresEdition[] = & $this->FltMttTaux ;
				// Ecran Taux
				$valBase = 5 ;
				$this->FltEcranTaux = $this->ScriptParent->CreeFiltreHttpPost("ecran_taux") ;
				$this->FltEcranTaux->DefinitColLiee("ecran_taux") ;
				$this->FltEcranTaux->ValeurParDefaut = 5 ;
				$this->FltEcranTaux->DeclareComposant("PvZoneBoiteSelectHtml") ;
				$comp1 = & $this->FltEcranTaux->Composant ;
				$comp1->NomColonneLibelle = "val" ;
				$comp1->NomColonneValeur = "val" ;
				$comp1->FournisseurDonnees = new PvFournisseurDonneesDirect() ;
				$comp1->FournisseurDonnees->Valeurs["req"] = array() ;
				for($i=$valBase - 5; $i<= $valBase + 5; $i++)
				{
					$comp1->FournisseurDonnees->Valeurs["req"][] = array('val' => $i) ;
				}
				$this->FiltresEdition[] = & $this->FltEcranTaux ;
				// Date operation
				$this->FltDateOper = $this->ScriptParent->CreeFiltreHttpPost("date_operation") ;
				$this->FltDateOper->DefinitColLiee("date_operation") ;
				$this->FltDateOper->Libelle = "Date operation" ;
				$this->FltDateOper->DeclareComposant("PvCalendarDateInput") ;
				$this->FiltresEdition[] = & $this->FltDateOper ;
				// Date Valeur
				$this->FltDateValeur = $this->ScriptParent->CreeFiltreHttpPost("date_valeur") ;
				$this->FltDateValeur->DefinitColLiee("date_valeur") ;
				$this->FltDateValeur->Libelle = "Date valeur" ;
				$this->FltDateValeur->DeclareComposant("PvCalendarDateInput") ;
				$this->FiltresEdition[] = & $this->FltDateValeur ;
				// Type de change
				$this->FltTypeChange = $this->ScriptParent->CreeFiltreFixe("typeChange", $this->TypeOpChange) ;
				$this->FltTypeChange->DefinitColLiee("type_change") ;
				$this->FiltresEdition[] = & $this->FltTypeChange ;
				// Operateur responsable
				$this->FltNumOp = $this->ScriptParent->CreeFiltreMembreConnecte('numop', 'MEMBER_ID') ;
				$this->FltNumOp->DefinitColLiee("numop") ;
				$this->FiltresEdition[] = & $this->FltNumOp ;
				$this->FltCommentaire = $this->ScriptParent->CreeFiltreHttpPost("commentaire") ;
				$comp0 = $this->FltCommentaire->DeclareComposant("PvZoneMultiligneHtml") ;
				$comp0->TotalLignes = 11 ;
				$comp0->TotalColonnes = 92 ;
				$this->FltCommentaire->DefinitColLiee("commentaire") ;
				$this->FiltresEdition[] = & $this->FltCommentaire ;
				if($this->PourReponse)
				{
					$this->Editable = 0 ;
					$this->FltNumOpChangeRep = $this->ScriptParent->CreeFiltreRef("numOpChangeDem", $this->FltNumOpChange) ;
					$this->FltNumOpChangeRep->DefinitColLiee("num_op_change_dem") ;
					$this->FiltresEdition[] = & $this->FltNumOpChangeRep ;
					$this->FltDevise1->NomColonneLiee = 'id_devise2' ;
					$this->FltDevise2->NomColonneLiee = 'id_devise1' ;
				}
			}
			public function ChargeConfig()
			{
				if($this->PourReponse)
				{
					$this->NomClasseCommandeExecuter = 'CmdEnvoiRepOpChange' ;
				}
				parent::ChargeConfig() ;
				$this->FournisseurDonnees = new PvFournisseurDonneesSql() ;
				$this->FournisseurDonnees->RequeteSelection = '(select t1.*, t2.code_devise lib_devise1, t3.code_devise lib_devise2, '.$this->ApplicationParent->BDPrincipale->SqlConcat(array('t2.code_devise', "' / '", 't3.code_devise')).' devise_change, case when t1.commiss_ou_taux = 0 then mtt_commiss when type_taux = 0 then taux_change else ecran_taux end taux_transact from op_change t1 left join devise t2 on t1.id_devise1 = t2.id_devise left join devise t3 on t1.id_devise2 = t3.id_devise)' ;
				// print 				$this->FournisseurDonnees->RequeteSelection ;
				$this->FournisseurDonnees->TableEdition = "op_change" ;
				$this->FournisseurDonnees->BaseDonnees = $this->ApplicationParent->BDPrincipale ;
				if(! $this->PourReponse)
				{
					$this->CritrEcheanceInvalide = $this->CommandeExecuter->InsereNouvCritere(new CritereEcheanceInvalideOpChange()) ;
				}
			}
			public function RenduDispositifBrut()
			{
				$ctn = '' ;
				if($this->PourReponse && ! $this->ReponsePossible())
				{
					$ctn .= $this->MsgReponseInterdit ;
				}
				else
				{
					$ctn .= parent::RenduDispositifBrut() ;
				}
				return $ctn ;
			}
			protected function InitDessinateurFiltresEdition()
			{
				$this->DessinateurFiltresEdition = new DessinFiltresFormOpChange() ;
			}
		}
		
		class CmdEnvoiRepOpChange extends PvCommandeEditionElementBase
		{
			public function ExecuteInstructions()
			{
				$this->StatutExecution = 0 ;
				if($this->EstNul($this->FormulaireDonneesParent->FournisseurDonnees))
				{
					$this->RenseigneErreur("La base de donnée du formulaire n'est renseigné.") ;
					return ;
				}
				$bd = & $this->FormulaireDonneesParent->FournisseurDonnees->BaseDonnees ;
				$numOpChange = $this->FormulaireDonneesParent->FltNumOpChange->Lie() ;
				$ok = $bd->RunSql('insert into op_change (type_change, montant_change, date_change, taux_change, id_devise1, id_devise2, numop, date_valeur, date_operation, bool_valide, bool_confirme, bool_expire, num_op_change_dem, commiss_ou_taux, mtt_commiss, date_commiss, type_taux, ecran_taux)
SELECT case when t1.type_change=1 then 2 else 1 end, t1.montant_change, t1.date_change, t1.taux_change, t1.id_devise2, t1.id_devise1, '.$bd->ParamPrefix.'numOperateur, t1.date_valeur, '.$bd->SqlNow().', t1.bool_valide, t1.bool_confirme, t1.bool_expire, t1.num_op_change, t1.commiss_ou_taux, t1.mtt_commiss, t1.date_commiss, t1.type_taux, t1.ecran_taux FROM op_change t1
WHERE num_op_change = '.$bd->ParamPrefix.'numOpChange', array('numOperateur' => $this->ZoneParent->Membership->MemberLogged->Id, 'numOpChange' => $numOpChange)) ;
				if($ok)
				{
					$this->StatutExecution = 1 ;
					$this->MessageExecution = $this->MessageSuccesExecution ;
				}
				else
				{
					$this->StatutExecution = 0 ;
					$this->MessageExecution = 'Erreur SQL : '.$bd->ConnectionException ;
				}
				return ;
			}
		}
		
		class DessinFiltresFormOpChange extends PvDessinateurRenduHtmlFiltresDonnees
		{
			public function Execute(& $script, & $composant, $parametres)
			{
				$composant->LieTousLesFiltres() ;
				$ctn = '' ;
				if($composant->Editable == 1)
				{
					$ctn .= $this->ExecuteForm($script, $composant, $parametres) ;
				}
				else
				{
					$ctn .= $this->ExecuteSommaire($script, $composant, $parametres) ;
				}
				return $ctn ;
			}
			protected function ExecuteSommaire(& $script, & $composant, $parametres)
			{
				$ctn = '' ;
				$ctn .= '<table width="100%" cellspacing="0" cellpadding="2">'.PHP_EOL ;
				$ctn .= '<tr>'.PHP_EOL ;
				$ctn .= '<td width="40%">'.(($composant->FltTypeChange ->Lie() == 1) ? 'Achat devise' : 'Vente devise').'</td>'.PHP_EOL ;
				$ctn .= '<td width="*">'.htmlentities($composant->FltLibDevise->Etiquette()).'</td>'.PHP_EOL ;
				$ctn .= '</tr>'.PHP_EOL ;
				$ctn .= '<tr>'.PHP_EOL ;
				$ctn .= '<td>Date operation</td>'.PHP_EOL ;
				$ctn .= '<td>'.htmlentities($composant->FltDateOper->Etiquette()).'</td>'.PHP_EOL ;
				$ctn .= '</tr>'.PHP_EOL ;
				$ctn .= '<tr>'.PHP_EOL ;
				$ctn .= '<td>Montant</td>'.PHP_EOL ;
				$ctn .= '<td>'.htmlentities($composant->FltMontant->Etiquette()).'</td>'.PHP_EOL ;
				$ctn .= '</tr>'.PHP_EOL ;
				$ctn .= '<tr>'.PHP_EOL ;
				$ctn .= '<td>Taux/Commission</td>'.PHP_EOL ;
				$ctn .= '<td>'.htmlentities($composant->FltTauxTransact->Etiquette()).'</td>'.PHP_EOL ;
				$ctn .= '</tr>'.PHP_EOL ;
				$ctn .= '</table>'.PHP_EOL ;
				return $ctn ;
			}
			protected function ExecuteForm(& $script, & $composant, $parametres)
			{
				$ctn = '' ;
				$ctn .= '<table width="100%" cellspacing=0 cellpadding="2">'.PHP_EOL ;
				$ctn .= '<tr><th colspan="2" align="left">Transaction</th></tr>'.PHP_EOL ;
				$ctn .= '<tr>'.PHP_EOL ;
				$ctn .= '<td width="25%">Devise :</td><td width="*"><table cellspacing="0" cellpadding="0"><tr><td>'.$composant->FltDevise1->Rendu().'</td><td>&nbsp;&nbsp;Contre&nbsp;&nbsp;</td><td>'.$composant->FltDevise2->Rendu().'</td></tr></table></td>'.PHP_EOL ;
				$ctn .= '</tr>'.PHP_EOL ;
				$ctn .= '<tr>'.PHP_EOL ;
				$ctn .= '<td>Montant</td>'.PHP_EOL ;
				$ctn .= '<td>'.$composant->FltMontant->Rendu().'</td>'.PHP_EOL ;
				$ctn .= '</tr>'.PHP_EOL ;
				$ctn .= '<tr>'.PHP_EOL ;
				$ctn .= '<td>Date operation</td>'.PHP_EOL ;
				$ctn .= '<td>'.$composant->FltDateOper->Rendu().'</td>'.PHP_EOL ;
				$ctn .= '</tr>'.PHP_EOL ;
				$ctn .= '<tr>'.PHP_EOL ;
				$ctn .= '<td>Date valeur</td>'.PHP_EOL ;
				$ctn .= '<td>'.$composant->FltDateValeur->Rendu().'</td>'.PHP_EOL ;
				$ctn .= '</tr>'.PHP_EOL ;
				$ctn .= '<tr><th colspan="2" align="left">Preciser taux / commission</th></tr>'.PHP_EOL ;
				$ctn .= '<tr><td colspan="2">'.PHP_EOL ;
				$ctn .= '<div class="commissOuTaux">'.PHP_EOL ;
				$ctn .= '<div><input onchange="affichCommissOuTaux'.$composant->IDInstanceCalc.'()" type="radio" name="commiss_ou_taux" value="0" id="pourComission"'.(($composant->FltCommissOuTaux->Lie() == 0) ? ' checked' : '').' /><label for="pourComission"> Commission</label> &nbsp;&nbsp; <input onchange="affichCommissOuTaux'.$composant->IDInstanceCalc.'()" type="radio" name="commiss_ou_taux" value="1" id="pourTaux"'.(($composant->FltCommissOuTaux->Lie() == 1) ? ' checked' : '').' /><label for="pourTaux"> Taux</label></div>'.PHP_EOL ;
				$ctn .= '<div class="frm">
<table cellspacing="0" cellpadding="4">
<tr>
<td>Montant commission</td><td>'.$composant->FltMttComiss->Rendu().'</td>
</tr>
<tr>
<td>Date expiration</td><td>'.$composant->FltDateComiss->Rendu().'</td>
</tr>
</table>
</div>'.PHP_EOL ;
				$ctn .= '<div class="frm">
<table cellspacing="0" cellpadding="4">
<tr>
<td>Taux</td><td><select name="type_taux" id="type_taux" onchange="evtCommissOuTaux'.$composant->IDInstanceCalc.'[1]() ;"><option value="0">N/A</option><option value="1"'.(($composant->FltTypeTaux->Lie() == 1) ? ' selected' : '').'>Ecran</option></select></td>
</tr>
<tr>
<td>Valeur</td><td class="grpValTaux"><span>'.$composant->FltMttTaux->Rendu().'</span><span>'.$composant->FltEcranTaux->Rendu().'</span></td>
</tr>
</table>
</div>'.PHP_EOL ;
				$ctn .= '<div id="infosSupplTransact">
	<ul>
		<li><a href="#ongletCibleTransact"><span>Transaction</span></a></li>
		<li><a href="#ongletCommentTransact"><span>Commentaire</span></a></li>
	</ul>
	<div id="ongletCibleTransact">
		<table width="100%" cellspacing="0">
			<tr>
			<td><input type="radio" name="cible_transact" value="2" checked id="cible_transact_params" /></td>
			<td><label for="cible_transact_params">Envoyer aux banques parametr&eacute;es</label></td>
			</tr>
			<tr>
			<td><input type="radio" name="cible_transact" value="1" id="cible_transact_tous" /></td>
			<td><label for="cible_transact_tous">Envoyer &agrave; toutes les banques</label></td>
			</tr>
		</table>
	</div>
	<div id="ongletCommentTransact">'.$composant->FltCommentaire->Rendu().'</div>
</div>'.PHP_EOL ;
				$ctn .= '</div>'.PHP_EOL ;
				$ctn .= '</td></tr>'.PHP_EOL ;
				$ctn .= '</table>'.PHP_EOL ;
				$ctn .= '<script type="text/javascript">
	var evtCommissOuTaux'.$composant->IDInstanceCalc.' = [
		function () {},
		function () {
			var val = jQuery("#type_taux :checked").val() ;
			jQuery(".grpValTaux span").hide()
			.each(function (index, elem) {
				if(val == index)
					jQuery(this).show() ;
			}) ;
		}
	] ;
	function affichCommissOuTaux'.$composant->IDInstanceCalc.'()
	{
		var obj = jQuery(".commissOuTaux");
		var val = obj.find("input[name=\'commiss_ou_taux\']:checked").val();
		obj.find(".frm").hide() ;
		obj.find(".frm").each(function(index, elem){
			if(index == val)
			{
				jQuery(this).show() ;
				evtCommissOuTaux'.$composant->IDInstanceCalc.'[index]() ;
			}
		}) ;
	}
	jQuery(function (){
		affichCommissOuTaux'.$composant->IDInstanceCalc.'();
		jQuery("#infosSupplTransact").tabs() ;
	}) ;
</script>' ;
				return $ctn ;
			}
		}
		
		class FormAjoutAchatDeviseTradPlatf extends FormOpChangeBaseTradPlatf
		{
			public $TypeOpChange = 1 ;
		}
		class FormReponseAchatDeviseTradPlatf extends FormAjoutAchatDeviseTradPlatf
		{
			public $InclureElementEnCours = 1 ;
			public $InclureTotalElements = 1 ;
			public $PourReponse = 1 ;
		}
		class FormModifAchatDeviseTradPlatf extends FormAjoutAchatDeviseTradPlatf
		{
			public $InclureElementEnCours = 1 ;
			public $InclureTotalElements = 1 ;
			public $NomClasseCommandeExecuter = "PvCommandeModifElement" ;
		}
		class FormSupprAchatDeviseTradPlatf extends FormModifAchatDeviseTradPlatf
		{
			public $Editable = 0 ;
			public $NomClasseCommandeExecuter = "PvCommandeSupprElement" ;
		}
		
		class FormAjoutVenteDeviseTradPlatf extends FormOpChangeBaseTradPlatf
		{
			public $TypeOpChange = 2 ;
		}
		class FormReponseVenteDeviseTradPlatf extends FormAjoutVenteDeviseTradPlatf
		{
			public $InclureElementEnCours = 1 ;
			public $InclureTotalElements = 1 ;
			public $PourReponse = 1 ;
		}
		class FormModifVenteDeviseTradPlatf extends FormAjoutVenteDeviseTradPlatf
		{
			public $InclureElementEnCours = 1 ;
			public $InclureTotalElements = 1 ;
			public $NomClasseCommandeExecuter = "PvCommandeModifElement" ;
		}
		class FormSupprVenteDeviseTradPlatf extends FormModifVenteDeviseTradPlatf
		{
			public $Editable = 0 ;
			public $NomClasseCommandeExecuter = "PvCommandeSupprElement" ;
		}

		class TablAchatsDeviseBaseTradPlatf extends TablConsultOpChangeTradPlatf
		{
		}
		
		class ScriptListeAchatsDeviseTradPlatf extends ScriptListBaseOpChange
		{
			public $TypeOpChange = 1 ;
			public $Titre = "Liste achats de devise" ;
			public $TitreDocument = "Liste achats de devise" ;
			protected function CreeTableau()
			{
				return new TablAchatsDeviseBaseTradPlatf() ;
			}
		}
		class ScriptEditAchatsDeviseTradPlatf extends ScriptListeAchatsDeviseTradPlatf
		{
			public $Titre = "Publication achats de devise" ;
			public $TitreDocument = "Publication achats de devise" ;
			protected function CreeTableau()
			{
				return new TablEditOpChangeTradPlatf() ;
			}
		}
		class ScriptReservAchatsDeviseTradPlatf extends ScriptListeAchatsDeviseTradPlatf
		{
			public $Titre = "R&eacute;servations achats de devise" ;
			public $TitreDocument = "R&eacute;servations achats de devise" ;
			protected function CreeTableau()
			{
				return new TablReservOpChangeTradPlatf() ;
			}
		}
		class ScriptAjoutAchatDeviseTradPlatf extends PvScriptWebSimple
		{
			public $TitreDocument = "Nouvel achat de devise" ;
			public $Titre = "Nouvel achat de devise" ;
			public $FormOpChange ;
			protected function CreeFormOpChange()
			{
				return new FormAjoutAchatDeviseTradPlatf() ;
			}
			public function DetermineEnvironnement()
			{
				parent::DetermineEnvironnement() ;
				$this->FormOpChange = $this->CreeFormOpChange() ;
				$this->FormOpChange->AdopteScript("formOpChange", $this) ;
				$this->FormOpChange->ChargeConfig() ;
			}
			public function RenduSpecifique()
			{
				$ctn = '' ;
				$ctn .= $this->FormOpChange->RenduDispositif() ;
				// $ctn .= print_r($this->FormOpChange->FournisseurDonnees->BaseDonnees, true) ;
				return $ctn ;
			}
		}
		class ScriptModifAchatDeviseTradPlatf extends ScriptAjoutAchatDeviseTradPlatf
		{
			public $TitreDocument = "Modif. achat de devise" ;
			public $Titre = "Modif. achat de devise" ;
			protected function CreeFormOpChange()
			{
				return new FormModifAchatDeviseTradPlatf() ;
			}
		}
		class ScriptPostulsAchatDeviseTradPlatf extends ScriptModifAchatDeviseTradPlatf
		{
			public $TitreDocument = "R&eacute;servations achat de devise" ;
			public $Titre = "R&eacute;servations achat de devise" ;
			public $FltIdEnCours ;
			protected function EstConfirme()
			{
				$id = $this->FltIdEnCours->Lie() ;
				$bd = & $this->ApplicationParent->BDPrincipale ;
				$lgnConf = $bd->FetchSqlRow('select * from op_change where num_op_change_dem='.$bd->ParamPrefix.'id and bool_confirme=1', array('id' => $id)) ;
				if(! is_array($lgnConf))
				{
					die('Erreur SQL : '.$bd->ConnectionException) ;
				}
				$ok = 0 ;
				if(count($lgnConf) > 0)
				{
					$ok = 1 ;
				}
				return $ok ;
			}
			protected function DetermineTablPostuls()
			{
				$this->TablPostuls = new TableauDonneesBaseTradPlatf() ;
				$this->TablPostuls->AdopteScript("tablPostuls", $this) ;
				$this->TablPostuls->ChargeConfig() ;
				$this->FltIdEnCours = $this->TablPostuls->InsereFltSelectHttpGet('idEnCours', 'num_op_change_dem = <self>') ;
				$this->FltIdEnCours->LectureSeule = 1 ;
				$this->FltIdEnCours->Obligatoire = 1 ;
				$this->TablPostuls->DeclareFournDonneesSql($this->ApplicationParent->BDPrincipale, '('.TXT_SQL_POSTUL_OP_CHANGE_TRAD_PLATF.')') ;
				$this->TablPostuls->InsereDefColCachee('idEnCours', 'num_op_change') ;
				$this->TablPostuls->InsereDefCol('loginop', 'Login') ;
				$this->TablPostuls->InsereDefCol('nom_entite', 'Etablissement') ;
				$this->TablPostuls->InsereDefCol('date_operation', 'Date rep.', $this->ApplicationParent->BDPrincipale->SqlDateToStrFr('date_operation')) ;
				$colConfirm = $this->TablPostuls->InsereDefColBool('bool_confirme', 'Confirm&eacute;', '') ;
				$colConfirm->AlignElement = "center" ;
				$colActions = $this->TablPostuls->InsereDefColActions("Actions") ;
				$colActions->Largeur = "*" ;
				$lienConfirm = $this->TablPostuls->InsereLienAction($colActions, $this->ZoneParent->ScriptValPostulVenteDevise->ObtientUrl().'&id=${idEnCours}', 'Confimer') ;
				$lienConfirm->Visible = ! $this->EstConfirme() ;
				$this->TablPostuls->ToujoursAfficher = 1 ;
				$this->TablPostuls->CacherFormulaireFiltres = 1 ;
			}
			public function DetermineEnvironnement()
			{
				parent::DetermineEnvironnement() ;
				$this->FormOpChange->Editable = 0 ;
				$this->FormOpChange->CacherBlocCommandes = 1 ;
				$this->DetermineTablPostuls() ;
			}
			public function RenduSpecifique()
			{
				$ctn = parent::RenduSpecifique() ;
				$ctn .= $this->TablPostuls->RenduDispositif() ;
				// $ctn .= print_r($this->TablPostuls->FournisseurDonnees->BaseDonnees, true) ;
				return $ctn ;
			}
		}
		class ScriptReponseAchatDeviseTradPlatf extends ScriptAjoutAchatDeviseTradPlatf
		{
			public $TitreDocument = "Reponse achat de devise" ;
			public $Titre = "Reponse achat de devise" ;
			protected function CreeFormOpChange()
			{
				return new FormReponseAchatDeviseTradPlatf() ;
			}
		}
		class ScriptSupprAchatDeviseTradPlatf extends ScriptAjoutAchatDeviseTradPlatf
		{
			public $TitreDocument = "Suppr. achat de devise" ;
			public $Titre = "Suppr. achat de devise" ;
			protected function CreeFormOpChange()
			{
				return new FormSupprAchatDeviseTradPlatf() ;
			}
		}
		
		class ScriptListeVentesDeviseTradPlatf extends ScriptListBaseOpChange
		{
			public $TypeOpChange = 2 ;
			public $Titre = "Liste ventes de devise" ;
			public $TitreDocument = "Liste ventes de devise" ;
			protected function CreeTableau()
			{
				return new TablConsultOpChangeTradPlatf() ;
			}
		}
		class ScriptEditVentesDeviseTradPlatf extends ScriptListeVentesDeviseTradPlatf
		{
			public $Titre = "Publications ventes de devise" ;
			public $TitreDocument = "Publications ventes de devise" ;
			protected function CreeTableau()
			{
				return new TablEditOpChangeTradPlatf() ;
			}
		}
		class ScriptReservVentesDeviseTradPlatf extends ScriptListeVentesDeviseTradPlatf
		{
			public $Titre = "R&eacute;servations ventes de devise" ;
			public $TitreDocument = "R&eacute;servations ventes de devise" ;
			protected function CreeTableau()
			{
				return new TablReservOpChangeTradPlatf() ;
			}
		}
		class ScriptAjoutVenteDeviseTradPlatf extends PvScriptWebSimple
		{
			public $TitreDocument = "Nouvel vente de devise" ;
			public $Titre = "Nouvel vente de devise" ;
			public $FormOpChange ;
			protected function CreeFormOpChange()
			{
				return new FormAjoutVenteDeviseTradPlatf() ;
			}
			public function DetermineEnvironnement()
			{
				parent::DetermineEnvironnement() ;
				$this->FormOpChange = $this->CreeFormOpChange() ;
				$this->FormOpChange->AdopteScript("formOpChange", $this) ;
				$this->FormOpChange->ChargeConfig() ;
			}
			public function RenduSpecifique()
			{
				$ctn = '' ;
				$ctn .= $this->FormOpChange->RenduDispositif() ;
				// $ctn .= print_r($this->FormOpChange->FournisseurDonnees->BaseDonnees, true) ;
				return $ctn ;
			}
		}
		class ScriptModifVenteDeviseTradPlatf extends ScriptAjoutVenteDeviseTradPlatf
		{
			public $TitreDocument = "Modif. vente de devise" ;
			public $Titre = "Modif. vente de devise" ;
			protected function CreeFormOpChange()
			{
				return new FormModifVenteDeviseTradPlatf() ;
			}
		}
		class ScriptPostulsVenteDeviseTradPlatf extends ScriptPostulsAchatDeviseTradPlatf
		{
			public $TitreDocument = "R&eacute;servations vente de devise" ;
			public $TypeOpChange = 2 ;
			public $Titre = "R&eacute;servations vente de devise" ;
		}
		class ScriptReponseVenteDeviseTradPlatf extends ScriptAjoutVenteDeviseTradPlatf
		{
			public $TitreDocument = "Reponse vente de devise" ;
			public $Titre = "Reponse vente de devise" ;
			protected function CreeFormOpChange()
			{
				return new FormReponseVenteDeviseTradPlatf() ;
			}
		}
		class ScriptSupprVenteDeviseTradPlatf extends ScriptAjoutVenteDeviseTradPlatf
		{
			public $TitreDocument = "Suppr. vente de devise" ;
			public $Titre = "Suppr. vente de devise" ;
			protected function CreeFormOpChange()
			{
				return new FormSupprVenteDeviseTradPlatf() ;
			}
		}
		class ScriptValPostulVenteDeviseTradPlatf extends PvScriptWebSimple
		{
			public $MsgSucces = 'La postulation a ete accept&eacute;e' ;
			public $MsgErreur = 'Impossible de confirmer la transaction actuelle.' ;
			public $MsgNonAutorise = 'Vous ne pouvez pas acceder a cette transaction' ;
			public $MsgExec = '' ;
			public $LgnOpChangeSelect = array() ;
			public function DetermineEnvironnement()
			{
				$bd = $this->ApplicationParent->BDPrincipale ;
				$id = (isset($_GET["id"])) ? $_GET["id"] : 0 ;
				$this->LgnOpChangeSelect = $bd->FetchSqlRow('select t1.*, t2.numop numop_dem, t2.type_change type_change_dem,
t2.id_devise1 id_devise1_dem, t2.id_devise2 id_devise2_dem,
t2.montant_change montant_change_dem, t2.taux_change taux_change_dem,
t2.date_operation date_operation_dem, t2.date_valeur date_valeur_dem
from op_change t1 inner join op_change t2
on t1.num_op_change_dem=t2.num_op_change
where t1.num_op_change='.$bd->ParamPrefix.'id and t2.numop='.$bd->ParamPrefix.'numOp', array(
					'id' => $id,
					'numOp' => $this->ZoneParent->Membership->MemberLogged->Id
				)) ;
				if(count($this->LgnOpChangeSelect) > 0)
				{
					$succes = $bd->RunSql('update op_change set bool_confirme=1 where num_op_change='.$bd->ParamPrefix.'id', array('id' => $id)) ;
					if($succes)
					{
						$this->MsgExec = $this->MsgSucces ;
					}
					else
					{
						$this->MsgExec = $this->MsgErreur ;
					}
				}
				else
				{
					$this->MsgExec = $this->MsgNonAutorise ;
				}
			}
			public function RenduSpecifique()
			{
				$ctn = '<p>'.$this->MsgExec.'</p>' ;
				if(count($this->LgnOpChangeSelect) > 0)
				{
					$typeChange = $this->LgnOpChangeSelect["type_change_dem"] ;
					$nomScript = ($typeChange == 1) ? "postulsAchatDevise" : "postulsVenteDevise" ;
					$ctn .= '<p><a href="?'.urlencode($this->ZoneParent->NomParamScriptAppele).'='.urlencode($nomScript).'&idEnCours='.urlencode($this->LgnOpChangeSelect["num_op_change_dem"]).'">Retour a la transaction</a></p>' ;
				}
				return $ctn ;
			}
		}
		
		class CritereEcheanceInvalideOpChange extends PvCritereBase
		{
			public $FormatMessageErreur = 'La date d\'&eacute;ch&eacute;ance ne doit pas &ecirc;tre inferieure &agrave; la date de valeur' ;
			public function EstRespecte()
			{
				$estSelect = $this->FormulaireDonneesParent->FltCommissOuTaux->Lie() ;
				$valDateEcheance = $this->FormulaireDonneesParent->FltDateComiss->Lie() ;
				$valDateValeur = $this->FormulaireDonneesParent->FltDateValeur->Lie() ;
				if($estSelect == 1)
					return 1 ;
				if($valDateEcheance < $valDateValeur)
				{
					$this->MessageErreur = $this->FormatMessageErreur ;
					return 0 ;
				}
				return 1 ;
			}
		}
	}
	
?>
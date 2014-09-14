<?php
	
	if(! defined('OP_INTER_TRAD_PLATF'))
	{
		define('OP_INTER_TRAD_PLATF', 1) ;
		
		class ScriptListBaseOpInter extends PvScriptWebSimple
		{
			public $Tableau ;
			public $BarreMenu ;
			public $TypeOpInter = 1 ;
			public $Privileges = array('post_op_change') ;
			public $NecessiteMembreConnecte = 1 ;
			protected function CreeBarreMenu()
			{
				$barreMenu = new PvTablMenuHoriz() ;
				$barreMenu->NomClasseCSSCellSelect = "ui-widget ui-widget-header ui-state-focus" ;
				return $barreMenu ;
			}
			public function TypeOpInterOppose()
			{
				return ($this->TypeOpInter == 1) ? 2 : 1 ;
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
				$smConsult = $this->BarreMenu->MenuRacine->InscritSousMenuScript(($this->TypeOpInter == 1) ? "listePlacements" : "listeEmprunts") ;
				$smConsult->CheminMiniature = "images/miniatures/consulte_opchange.png" ;
				$smConsult->Titre = "Consultation" ;
				$smEdition = $this->BarreMenu->MenuRacine->InscritSousMenuScript(($this->TypeOpInter == 1) ? "editPlacements" : "editEmprunts") ;
				$smEdition->CheminMiniature = "images/miniatures/edit_opchange.png" ;
				$smEdition->Titre = "Publication" ;
				$smReserv = $this->BarreMenu->MenuRacine->InscritSousMenuScript(($this->TypeOpInter == 1) ? "reservPlacements" : "reservEmprunts") ;
				$smReserv->CheminMiniature = "images/miniatures/reserv_opchange.png" ;
				$smReserv->Titre = "Reservation" ;
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
		
		class TablConsultOpInterTradPlatf extends TableauDonneesBaseTradPlatf
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
			protected function ObtientRequeteSelection(& $bd)
			{
				return "(select t1.*, case when t1.commiss_ou_taux = 0 then mtt_commiss when type_taux = 0 then taux_change else ecran_taux end taux_transact, ".$bd->SqlConcat(array('t2.code_devise', "' / '", 't3.code_devise'))." devise_change, t7.shortname nom_court_entite, t7.name nom_entite, t2.code_devise lib_devise1, t3.code_devise lib_devise2, t4.login loginop, t4.nomop nomop, t4.prenomop prenomop, t5.id_entite_source, t5.id_entite_dest, t5.top_active, t6.numop numrep, t6.login loginrep, case when t4.numop = t6.numop then 1 else 0 end peut_modif, case when t4.numop <> t6.numop then 1 else 0 end peut_repondre,
case when t1.num_op_inter_dem = 0 then 'demande' else 'reponse' end type_message
from op_inter t1
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
			protected function PeutVoirOps()
			{
				if($this->ZoneParent->PossedePrivilege('admin_members'))
				{
					return 1 ;
				}
				$bd = & $this->ApplicationParent->BDPrincipale ;
				$sql = 'select * from ('.TXT_SQL_SELECT_PLACEMENT_SOUMIS.') t1 where numop='.$bd->ParamPrefix.'numOp and type_change='.$bd->ParamPrefix.'typeChange' ;
				$row = $bd->FetchSqlRow($sql, array('numOp' => $this->ZoneParent->IdMembreConnecte(), "typeChange" => $this->ScriptParent->TypeOpInterOppose())) ;
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
				$this->DefColId->NomDonnees = "num_op_inter" ;
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
				$this->DefColDatePublic->Largeur = "16%" ;
				$this->DefColDatePublic->AlignElement = "center" ;
				$this->DefinitionsColonnes[] = & $this->DefColDatePublic ;
				$this->DefColDateOp = new PvDefinitionColonneDonnees() ;
				$this->DefColDateOp->Libelle = "Date Op." ;
				$this->DefColDateOp->NomDonnees = "date_operation" ;
				$this->DefColDateOp->AliasDonnees = $bd->SqlDateToStrFr("date_operation") ;
				$this->DefColDateOp->Largeur = "16%" ;
				$this->DefColDateOp->AlignElement = "center" ;
				$this->DefinitionsColonnes[] = & $this->DefColDateOp ;
				$this->DefColMontant = new PvDefinitionColonneDonnees() ;
				$this->DefColMontant->Libelle = "Montant" ;
				$this->DefColMontant->NomDonnees = "montant_change" ;
				$this->DefColMontant->AliasDonnees = $bd->SqlToInt("montant_change") ;
				$this->DefColMontant->Largeur = "16%" ;
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
				$this->DefColTaux->Largeur = "0%" ;
				$this->DefColTaux->AlignElement = "center" ;
				$this->DefColTaux->Visible = 0 ;
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
				$this->FmtModif->FormatTitreOnglet = ($this->ScriptParent->TypeOpInter == 1) ? 'Modifier placement' : 'Modifier emprunt' ;
				$this->FmtModif->FormatCheminIcone = 'images/icones/modif.png' ;
				$this->FmtModif->FormatURL = '?'.urlencode($this->ZoneParent->NomParamScriptAppele).'='.(($this->ScriptParent->TypeOpInter == 1) ? 'modifPlacement' : 'modifEmprunt').'&idEnCours=${num_op_inter}' ;
				$this->DefColActions->Formatteur->Liens[] = & $this->FmtModif ;
				$this->FmtPostuls = new PvConfigFormatteurColonneOuvreFenetre() ;
				$this->FmtPostuls->NomDonneesValid = "peut_modif" ;
				$this->FmtPostuls->FormatLibelle = "R&eacute;servatiions" ;
				$this->FmtPostuls->OptionsOnglet["Modal"] = 1 ;
				$this->FmtPostuls->OptionsOnglet["Hauteur"] = 600 ;
				$this->FmtPostuls->OptionsOnglet["Largeur"] = 750 ;
				$this->FmtPostuls->FormatTitreOnglet = ($this->ScriptParent->TypeOpInter == 1) ? 'R&eacute;servatiions placement' : 'R&eacute;servatiions emprunt' ;
				$this->FmtPostuls->FormatCheminIcone = 'images/icones/postulations.png' ;
				$this->FmtPostuls->FormatURL = '?'.urlencode($this->ZoneParent->NomParamScriptAppele).'='.(($this->ScriptParent->TypeOpInter == 1) ? 'postulsPlacement' : 'postulsEmprunt').'&idEnCours=${num_op_inter}' ;
				$this->DefColActions->Formatteur->Liens[] = & $this->FmtPostuls ;
				$this->FmtRepondre = new PvConfigFormatteurColonneOuvreFenetre() ;
				$this->FmtRepondre->NomDonneesValid = "peut_repondre" ;
				$this->FmtRepondre->FormatLibelle = "R&eacute;server" ;
				$this->FmtRepondre->OptionsOnglet["Modal"] = 1 ;
				$this->FmtRepondre->OptionsOnglet["Hauteur"] = 300 ;
				$this->FmtRepondre->FormatTitreOnglet = ($this->ScriptParent->TypeOpInter == 1) ? 'Repondre a l\'placement' : 'Repondre a la emprunt' ;
				$this->FmtRepondre->FormatCheminIcone = 'images/icones/repondre.png' ;
				$this->FmtRepondre->FormatURL = '?'.urlencode($this->ZoneParent->NomParamScriptAppele).'='.(($this->ScriptParent->TypeOpInter == 1) ? 'reponsePlacement' : 'reponseEmprunt').'&idEnCours=${num_op_inter}' ;
				$this->DefColActions->Formatteur->Liens[] = & $this->FmtRepondre ;
				$this->DefinitionsColonnes[] = & $this->DefColActions ;
			}
			protected function ChargeConfigBase()
			{
				$this->ChargeDefCols() ;
			}
			protected function ChargeFiltresSelectionStatiq()
			{
				$this->FltTypeChange = $this->CreeFiltreFixe('typeChange', $this->ScriptParent->TypeOpInter) ;
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
						$this->FltColValide = $this->CreeFiltreFixe('valideOpInter', '1') ;
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
			protected function ChargeConfigSuppl()
			{
				if(! $this->RestrOps)
				{
					$this->CmdAjout = new PvCommandeOuvreFenetreAdminDirecte() ;
					$this->CmdAjout->Libelle = "Ajouter" ;
					$this->CmdAjout->NomScript = ($this->ScriptParent->TypeOpInter == 1) ? "ajoutPlacement" : "ajoutEmprunt" ;
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
					$args = array('nomOffre' => ($this->ScriptParent->TypeOpInter == 1) ? 'un emprunt' : 'un placement') ;
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
		class TablEditOpInterTradPlatf extends TablConsultOpInterTradPlatf
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
		class TablReservOpInterTradPlatf extends TablEditOpInterTradPlatf
		{
			protected function ObtientRequeteSelection(& $bd)
			{
				return "(select t1.*, t8.total_dem, case when t1.commiss_ou_taux = 0 then mtt_commiss when type_taux = 0 then taux_change else ecran_taux end taux_transact, ".$bd->SqlConcat(array('t2.code_devise', "' / '", 't3.code_devise'))." devise_change, t7.shortname nom_court_entite, t7.name nom_entite, t2.code_devise lib_devise1, t3.code_devise lib_devise2, t4.login loginop, t4.nomop nomop, t4.prenomop prenomop, t5.id_entite_source, t5.id_entite_dest, t5.top_active, t6.numop numrep, t6.login loginrep, case when t4.numop = t6.numop then 1 else 0 end peut_modif, case when t4.numop <> t6.numop then 1 else 0 end peut_repondre,
case when t1.num_op_inter_dem = 0 then 'demande' else 'reponse' end type_message
from op_inter t1
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
left join (select num_op_inter_dem, count(0) total_dem from op_inter where num_op_inter_dem is not null and num_op_inter_dem <> 0 group by num_op_inter_dem) t8
on t8.num_op_inter_dem = t1.num_op_inter
where t5.id_entite_dest is not null and t7.id_entite is not null and t6.login is not null and t4.active_op = 1 and t8.num_op_inter_dem > 0)" ;
			}
		}
		
		class FormOpInterBaseTradPlatf extends FormulaireDonneesBaseTradPlatf
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
			public $FltNumOpInter ;
			public $FltNumOpInterRep ;
			public $FltTypeChange ;
			public $FltLibDevise ;
			public $FltTauxTransact ;
			public $TypeOpInter = 1 ;
			public $PourReponse = 0 ;
			public $NomClasseCommandeExecuter = "PvCommandeAjoutElement" ;
			public $NomClasseCommandeAnnuler = "PvCmdFermeFenetreActiveAdminDirecte" ;
			public $MsgReponseInterdit = '<div class="ui-state-error">Vous avez d&eacute;j&agrave; r&eacute;pondu &agrave; cette offre.</div>' ;
			protected function ReponsePossible()
			{
				$bd = & $this->ApplicationParent->BDPrincipale ;
				$sql = 'select * from op_inter where num_op_inter_dem='.$bd->ParamPrefix.'numOpInterDem and numop='.$bd->ParamPrefix.'login' ;
				$row = $bd->FetchSqlRow(
					$sql,
					array(
						'numOpInterDem' => $this->FltNumOpInter->Lie(),
						'login' => $this->ZoneParent->IdMembreConnecte()
					)
				) ;
				return (is_array($row) && count($row) == 0) ? 1 : 0 ;
			}
			public function TypeOpInterRep()
			{
				return ($this->TypeOpInter == 1) ? 2 : 1 ;
			}
			protected function ChargeFiltresSelection()
			{
				parent::ChargeFiltresSelection() ;
				$this->FltNumOpInter = $this->ScriptParent->CreeFiltreHttpGet("idEnCours") ;
				$this->FltNumOpInter->ExpressionDonnees = 'num_op_inter = <self>' ;
				$this->FiltresLigneSelection[] = & $this->FltNumOpInter ;
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
				$comp = & $this->FltEcranTaux->Composant ;
				$comp->NomColonneLibelle = "val" ;
				$comp->NomColonneValeur = "val" ;
				$comp->FournisseurDonnees = new PvFournisseurDonneesDirect() ;
				$comp->FournisseurDonnees->Valeurs["req"] = array() ;
				for($i=$valBase - 5; $i<= $valBase + 5; $i++)
				{
					$comp->FournisseurDonnees->Valeurs["req"][] = array('val' => $i) ;
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
				$this->FltTypeChange = $this->ScriptParent->CreeFiltreFixe("typeChange", $this->TypeOpInter) ;
				$this->FltTypeChange->DefinitColLiee("type_change") ;
				$this->FiltresEdition[] = & $this->FltTypeChange ;
				// Operateur responsable
				$this->FltNumOp = $this->ScriptParent->CreeFiltreMembreConnecte('numop', 'MEMBER_ID') ;
				$this->FltNumOp->DefinitColLiee("numop") ;
				$this->FiltresEdition[] = & $this->FltNumOp ;
				$this->FltCommentaire = $this->ScriptParent->CreeFiltreHttpPost("commentaire") ;
				$this->FltCommentaire->DefinitColLiee("commentaire") ;
				$comp = $this->FltCommentaire->DeclareComposant("PvZoneMultiligneHtml") ;
				$comp->TotalLignes = 11 ;
				$comp->TotalColonnes = 92 ;
				$this->FiltresEdition[] = & $this->FltCommentaire ;
				if($this->PourReponse)
				{
					$this->Editable = 0 ;
					$this->FltNumOpInterRep = $this->ScriptParent->CreeFiltreRef("numOpInterDem", $this->FltNumOpInter) ;
					$this->FltNumOpInterRep->DefinitColLiee("num_op_inter_dem") ;
					$this->FiltresEdition[] = & $this->FltNumOpInterRep ;
					$this->FltDevise1->NomColonneLiee = 'id_devise2' ;
					$this->FltDevise2->NomColonneLiee = 'id_devise1' ;
				}
			}
			public function ChargeConfig()
			{
				if($this->PourReponse)
				{
					$this->NomClasseCommandeExecuter = 'CmdEnvoiRepOpInter' ;
				}
				parent::ChargeConfig() ;
				$this->FournisseurDonnees = new PvFournisseurDonneesSql() ;
				$this->FournisseurDonnees->RequeteSelection = '(select t1.*, t2.code_devise lib_devise1, t3.code_devise lib_devise2, '.$this->ApplicationParent->BDPrincipale->SqlConcat(array('t2.code_devise', "' / '", 't3.code_devise')).' devise_change, case when t1.commiss_ou_taux = 0 then mtt_commiss when type_taux = 0 then taux_change else ecran_taux end taux_transact from op_inter t1 left join devise t2 on t1.id_devise1 = t2.id_devise left join devise t3 on t1.id_devise2 = t3.id_devise)' ;
				// print 				$this->FournisseurDonnees->RequeteSelection ;
				$this->FournisseurDonnees->TableEdition = "op_inter" ;
				$this->FournisseurDonnees->BaseDonnees = $this->ApplicationParent->BDPrincipale ;
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
				$this->DessinateurFiltresEdition = new DessinFiltresFormOpInter() ;
			}
		}
		
		class CmdEnvoiRepOpInter extends PvCommandeEditionElementBase
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
				$numOpInter = $this->FormulaireDonneesParent->FltNumOpInter->Lie() ;
				$ok = $bd->RunSql('insert into op_inter (type_change, montant_change, date_change, taux_change, id_devise1, id_devise2, numop, date_valeur, date_operation, bool_valide, bool_confirme, bool_expire, num_op_inter_dem, commiss_ou_taux, mtt_commiss, date_commiss, type_taux, ecran_taux)
SELECT case when t1.type_change=1 then 2 else 1 end, t1.montant_change, t1.date_change, t1.taux_change, t1.id_devise2, t1.id_devise1, '.$bd->ParamPrefix.'numOperateur, t1.date_valeur, '.$bd->SqlNow().', t1.bool_valide, t1.bool_confirme, t1.bool_expire, t1.num_op_inter, t1.commiss_ou_taux, t1.mtt_commiss, t1.date_commiss, t1.type_taux, t1.ecran_taux FROM op_inter t1
WHERE num_op_inter = '.$bd->ParamPrefix.'numOpInter', array('numOperateur' => $this->ZoneParent->Membership->MemberLogged->Id, 'numOpInter' => $numOpInter)) ;
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
		
		class DessinFiltresFormOpInter extends PvDessinateurRenduHtmlFiltresDonnees
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
				$ctn .= '<td width="40%">'.(($composant->FltTypeChange ->Lie() == 1) ? 'Placement' : 'Emprunt').'</td>'.PHP_EOL ;
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
				$ctn .= '<td width="35%">Devise transaction</td><td width="*"><table cellspacing="0" cellpadding="0"><tr><td>'.$composant->FltDevise1->Rendu().'</td><td>&nbsp;&nbsp;Contre&nbsp;&nbsp;</td><td>'.$composant->FltDevise2->Rendu().'</td></tr></table></td>'.PHP_EOL ;
				$ctn .= '</tr>'.PHP_EOL ;
				$ctn .= '<tr>'.PHP_EOL ;
				$ctn .= '<td>Montant</td>'.PHP_EOL ;
				$ctn .= '<td>'.$composant->FltMontant->Rendu().'</td>'.PHP_EOL ;
				$ctn .= '</tr>'.PHP_EOL ;
				$ctn .= '<tr>'.PHP_EOL ;
				$ctn .= '<td>Date operation</td>'.PHP_EOL ;
				$ctn .= '<td>'.$composant->FltDateOper->Rendu().'</td>'.PHP_EOL ;
				$ctn .= '</tr>'.PHP_EOL ;
				$ctn .= '<tr><td colspan="2">'.PHP_EOL ;
				$ctn .= '<div class="commissOuTaux">'.PHP_EOL ;
				$ctn .= '<div><input onchange="affichCommissOuTaux'.$composant->IDInstanceCalc.'()" type="radio" name="commiss_ou_taux" value="0" id="pourComission"'.(($composant->FltCommissOuTaux->Lie() == 0) ? ' checked' : '').' /><label for="pourComission"> Date &eacute;ch&eacute;ance</label> &nbsp;&nbsp; <input onchange="affichCommissOuTaux'.$composant->IDInstanceCalc.'()" type="radio" name="commiss_ou_taux" value="1" id="pourTaux"'.(($composant->FltCommissOuTaux->Lie() == 1) ? ' checked' : '').' /><label for="pourTaux"> Nombre de jours</label></div>'.PHP_EOL ;
				$ctn .= '<div class="frm">
<table cellspacing="0" cellpadding="4">
<td>Date ech&eacute;ance</td><td>'.$composant->FltDateComiss->Rendu().'</td>
</tr>
</table>
</div>'.PHP_EOL ;
				$ctn .= '<div class="frm">
<table cellspacing="0" cellpadding="4">
<tr>
<td>Valeur</td><td><span>'.$composant->FltMttTaux->Rendu().'</span></td>
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
		function () {}
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
		
		class FormAjoutPlacementTradPlatf extends FormOpInterBaseTradPlatf
		{
			public $TypeOpInter = 1 ;
		}
		class FormReponsePlacementTradPlatf extends FormAjoutPlacementTradPlatf
		{
			public $InclureElementEnCours = 1 ;
			public $InclureTotalElements = 1 ;
			public $PourReponse = 1 ;
		}
		class FormModifPlacementTradPlatf extends FormAjoutPlacementTradPlatf
		{
			public $InclureElementEnCours = 1 ;
			public $InclureTotalElements = 1 ;
			public $NomClasseCommandeExecuter = "PvCommandeModifElement" ;
		}
		class FormSupprPlacementTradPlatf extends FormModifPlacementTradPlatf
		{
			public $Editable = 0 ;
			public $NomClasseCommandeExecuter = "PvCommandeSupprElement" ;
		}
		
		class FormAjoutEmpruntTradPlatf extends FormOpInterBaseTradPlatf
		{
			public $TypeOpInter = 2 ;
		}
		class FormReponseEmpruntTradPlatf extends FormAjoutEmpruntTradPlatf
		{
			public $InclureElementEnCours = 1 ;
			public $InclureTotalElements = 1 ;
			public $PourReponse = 1 ;
		}
		class FormNegocEmpruntTradPlatf extends FormAjoutEmpruntTradPlatf
		{
			public $InclureElementEnCours = 1 ;
			public $InclureTotalElements = 1 ;
			public $PourReponse = 1 ;
		}
		class FormModifEmpruntTradPlatf extends FormAjoutEmpruntTradPlatf
		{
			public $InclureElementEnCours = 1 ;
			public $InclureTotalElements = 1 ;
			public $NomClasseCommandeExecuter = "PvCommandeModifElement" ;
		}
		class FormSupprEmpruntTradPlatf extends FormModifEmpruntTradPlatf
		{
			public $Editable = 0 ;
			public $NomClasseCommandeExecuter = "PvCommandeSupprElement" ;
		}

		class TablPlacementsBaseTradPlatf extends TablConsultOpInterTradPlatf
		{
		}
		
		class ScriptListePlacementsTradPlatf extends ScriptListBaseOpInter
		{
			public $TypeOpInter = 1 ;
			public $Titre = "Liste placements" ;
			public $TitreDocument = "Liste placements" ;
			protected function CreeTableau()
			{
				return new TablPlacementsBaseTradPlatf() ;
			}
		}
		class ScriptEditPlacementsTradPlatf extends ScriptListePlacementsTradPlatf
		{
			public $Titre = "Publications placements" ;
			public $TitreDocument = "Publications placements" ;
			protected function CreeTableau()
			{
				return new TablEditOpInterTradPlatf() ;
			}
		}
		class ScriptReservPlacementsTradPlatf extends ScriptListePlacementsTradPlatf
		{
			public $Titre = "R&eacute;servation placements" ;
			public $TitreDocument = "R&eacute;servation placements" ;
			protected function CreeTableau()
			{
				return new TablReservOpInterTradPlatf() ;
			}
		}
		class ScriptAjoutPlacementTradPlatf extends PvScriptWebSimple
		{
			public $TitreDocument = "Nouveau placement" ;
			public $Titre = "Nouveau placement" ;
			public $FormOpInter ;
			protected function CreeFormOpInter()
			{
				return new FormAjoutPlacementTradPlatf() ;
			}
			public function DetermineEnvironnement()
			{
				parent::DetermineEnvironnement() ;
				$this->FormOpInter = $this->CreeFormOpInter() ;
				$this->FormOpInter->AdopteScript("formOpInter", $this) ;
				$this->FormOpInter->ChargeConfig() ;
			}
			public function RenduSpecifique()
			{
				$ctn = '' ;
				$ctn .= $this->FormOpInter->RenduDispositif() ;
				// $ctn .= print_r($this->FormOpInter->FournisseurDonnees->BaseDonnees, true) ;
				return $ctn ;
			}
		}
		class ScriptModifPlacementTradPlatf extends ScriptAjoutPlacementTradPlatf
		{
			public $TitreDocument = "Modif. placement" ;
			public $Titre = "Modif. placement" ;
			protected function CreeFormOpInter()
			{
				return new FormModifPlacementTradPlatf() ;
			}
		}
		class ScriptPostulsPlacementTradPlatf extends ScriptModifPlacementTradPlatf
		{
			public $TitreDocument = "R&eacute;servatiions placement" ;
			public $Titre = "R&eacute;servatiions placement" ;
			public $FltIdEnCours ;
			protected function EstConfirme()
			{
				$id = $this->FltIdEnCours->Lie() ;
				$bd = & $this->ApplicationParent->BDPrincipale ;
				$lgnConf = $bd->FetchSqlRow('select * from op_inter where num_op_inter_dem='.$bd->ParamPrefix.'id and bool_confirme=1', array('id' => $id)) ;
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
				$this->FltIdEnCours = $this->TablPostuls->InsereFltSelectHttpGet('idEnCours', 'num_op_inter_dem = <self>') ;
				$this->FltIdEnCours->LectureSeule = 1 ;
				$this->FltIdEnCours->Obligatoire = 1 ;
				$this->TablPostuls->DeclareFournDonneesSql($this->ApplicationParent->BDPrincipale, '('.TXT_SQL_POSTUL_OP_INTER_TRAD_PLATF.')') ;
				$this->TablPostuls->InsereDefColCachee('idEnCours', 'num_op_inter') ;
				$this->TablPostuls->InsereDefCol('loginop', 'Login') ;
				$this->TablPostuls->InsereDefCol('nom_entite', 'Etablissement') ;
				$this->TablPostuls->InsereDefCol('date_operation', 'Date rep.', $this->ApplicationParent->BDPrincipale->SqlDateToStrFr('date_operation')) ;
				$colConfirm = $this->TablPostuls->InsereDefColBool('bool_confirme', 'Confirm&eacute;', '') ;
				$colConfirm->AlignElement = "center" ;
				$colActions = $this->TablPostuls->InsereDefColActions("Actions") ;
				$colActions->Largeur = "*" ;
				$lienConfirm = $this->TablPostuls->InsereLienAction($colActions, $this->ZoneParent->ScriptValPostulEmprunt->ObtientUrl().'&id=${idEnCours}', 'Confimer') ;
				$lienConfirm->Visible = ! $this->EstConfirme() ;
				$this->TablPostuls->ToujoursAfficher = 1 ;
				$this->TablPostuls->CacherFormulaireFiltres = 1 ;
			}
			public function DetermineEnvironnement()
			{
				parent::DetermineEnvironnement() ;
				$this->FormOpInter->Editable = 0 ;
				$this->FormOpInter->CacherBlocCommandes = 1 ;
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
		class ScriptReponsePlacementTradPlatf extends ScriptAjoutPlacementTradPlatf
		{
			public $TitreDocument = "Reponse placement" ;
			public $Titre = "Reponse placement" ;
			protected function CreeFormOpInter()
			{
				return new FormReponsePlacementTradPlatf() ;
			}
		}
		class ScriptNegocPlacementTradPlatf extends ScriptAjoutPlacementTradPlatf
		{
			public $TitreDocument = "Negociation placement" ;
			public $Titre = "Negociation placement" ;
			protected function CreeFormOpInter()
			{
				return new FormReponsePlacementTradPlatf() ;
			}
		}
		class ScriptSupprPlacementTradPlatf extends ScriptAjoutPlacementTradPlatf
		{
			public $TitreDocument = "Suppr. placement" ;
			public $Titre = "Suppr. placement" ;
			protected function CreeFormOpInter()
			{
				return new FormSupprPlacementTradPlatf() ;
			}
		}
		
		class ScriptListeEmpruntsTradPlatf extends ScriptListBaseOpInter
		{
			public $TypeOpInter = 2 ;
			public $Titre = "Liste emprunts" ;
			public $TitreDocument = "Liste emprunts" ;
			protected function CreeTableau()
			{
				return new TablConsultOpInterTradPlatf() ;
			}
		}
		class ScriptEditEmpruntsTradPlatf extends ScriptListeEmpruntsTradPlatf
		{
			public $Titre = "Postultation emprunts" ;
			public $TitreDocument = "Publication emprunts" ;
			protected function CreeTableau()
			{
				return new TablEditOpInterTradPlatf() ;
			}
		}
		class ScriptReservEmpruntsTradPlatf extends ScriptListeEmpruntsTradPlatf
		{
			public $Titre = "R&eacute;servation emprunts" ;
			public $TitreDocument = "R&eacute;servation emprunts" ;
			protected function CreeTableau()
			{
				return new TablReservOpInterTradPlatf() ;
			}
		}
		class ScriptAjoutEmpruntTradPlatf extends PvScriptWebSimple
		{
			public $TitreDocument = "Nouvel emprunt" ;
			public $Titre = "Nouvel emprunt" ;
			public $FormOpInter ;
			protected function CreeFormOpInter()
			{
				return new FormAjoutEmpruntTradPlatf() ;
			}
			public function DetermineEnvironnement()
			{
				parent::DetermineEnvironnement() ;
				$this->FormOpInter = $this->CreeFormOpInter() ;
				$this->FormOpInter->AdopteScript("formOpInter", $this) ;
				$this->FormOpInter->ChargeConfig() ;
			}
			public function RenduSpecifique()
			{
				$ctn = '' ;
				$ctn .= $this->FormOpInter->RenduDispositif() ;
				// $ctn .= print_r($this->FormOpInter->FournisseurDonnees->BaseDonnees, true) ;
				return $ctn ;
			}
		}
		class ScriptModifEmpruntTradPlatf extends ScriptAjoutEmpruntTradPlatf
		{
			public $TitreDocument = "Modif. emprunt" ;
			public $Titre = "Modif. emprunt" ;
			protected function CreeFormOpInter()
			{
				return new FormModifEmpruntTradPlatf() ;
			}
		}
		class ScriptPostulsEmpruntTradPlatf extends ScriptPostulsPlacementTradPlatf
		{
			public $TitreDocument = "R&eacute;servatiions emprunt" ;
			public $TypeOpInter = 2 ;
			public $Titre = "R&eacute;servatiions emprunt" ;
		}
		class ScriptReponseEmpruntTradPlatf extends ScriptAjoutEmpruntTradPlatf
		{
			public $TitreDocument = "Reponse emprunt" ;
			public $Titre = "Reponse emprunt" ;
			protected function CreeFormOpInter()
			{
				return new FormReponseEmpruntTradPlatf() ;
			}
		}
		class ScriptNegocEmpruntTradPlatf extends ScriptAjoutEmpruntTradPlatf
		{
			public $TitreDocument = "Negociation emprunt" ;
			public $Titre = "Negociation emprunt" ;
			protected function CreeFormOpInter()
			{
				return new FormReponseEmpruntTradPlatf() ;
			}
		}
		class ScriptSupprEmpruntTradPlatf extends ScriptAjoutEmpruntTradPlatf
		{
			public $TitreDocument = "Suppr. emprunt" ;
			public $Titre = "Suppr. emprunt" ;
			protected function CreeFormOpInter()
			{
				return new FormSupprEmpruntTradPlatf() ;
			}
		}
		class ScriptValPostulEmpruntTradPlatf extends PvScriptWebSimple
		{
			public $MsgSucces = 'La postulation a ete accept&eacute;e' ;
			public $MsgErreur = 'Impossible de confirmer la transaction actuelle.' ;
			public $MsgNonAutorise = 'Vous ne pouvez pas acceder a cette transaction' ;
			public $MsgExec = '' ;
			public $LgnOpInterSelect = array() ;
			public function DetermineEnvironnement()
			{
				$bd = $this->ApplicationParent->BDPrincipale ;
				$id = (isset($_GET["id"])) ? $_GET["id"] : 0 ;
				$this->LgnOpInterSelect = $bd->FetchSqlRow('select t1.*, t2.numop numop_dem, t2.type_change type_change_dem,
t2.id_devise1 id_devise1_dem, t2.id_devise2 id_devise2_dem,
t2.montant_change montant_change_dem, t2.taux_change taux_change_dem,
t2.date_operation date_operation_dem, t2.date_valeur date_valeur_dem
from op_inter t1 inner join op_inter t2
on t1.num_op_inter_dem=t2.num_op_inter
where t1.num_op_inter='.$bd->ParamPrefix.'id and t2.numop='.$bd->ParamPrefix.'numOp', array(
					'id' => $id,
					'numOp' => $this->ZoneParent->Membership->MemberLogged->Id
				)) ;
				if(count($this->LgnOpInterSelect) > 0)
				{
					$succes = $bd->RunSql('update op_inter set bool_confirme=1 where num_op_inter='.$bd->ParamPrefix.'id', array('id' => $id)) ;
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
				if(count($this->LgnOpInterSelect) > 0)
				{
					$typeChange = $this->LgnOpInterSelect["type_change_dem"] ;
					$nomScript = ($typeChange == 1) ? "postulsPlacement" : "postulsEmprunt" ;
					$ctn .= '<p><a href="?'.urlencode($this->ZoneParent->NomParamScriptAppele).'='.urlencode($nomScript).'&idEnCours='.urlencode($this->LgnOpInterSelect["num_op_inter_dem"]).'">Retour a la transaction</a></p>' ;
				}
				return $ctn ;
			}
		}
	}
	
?>
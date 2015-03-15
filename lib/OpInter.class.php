<?php
	
	if(! defined('OP_INTER_TRAD_PLATF'))
	{
		if(! defined('MDL_TRANSACT_TRAD_PLATF'))
		{
			include dirname(__FILE__)."/MdlTransact.class.php" ;
		}
		define('OP_INTER_TRAD_PLATF', 1) ;
		
		class TablConsultOpInterTradPlatf extends TableauDonneesBaseTradPlatf
		{
			public $DefColPeutModif ;
			public $DefColPeutRep ;
			public $DefColId ;
			public $DefColRefChange ;
			public $DefColEmetteur ;
			public $DefColBanque ;
			public $DefColMontant ;
			public $DefColLibDevise ;
			public $DefColDatePublic ;
			public $DefColDateOp ;
			public $DefColDateValeur ;
			public $DefColDateEcheance ;
			public $DefColTaux ;
			public $DefColActions ;
			public $FmtModif ;
			public $FmtSuppr ;
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
				$sql = 'select * from ('.TXT_SQL_SELECT_PLACEMENT_SOUMIS.') t1 where numop='.$bd->ParamPrefix.'numOp and type_change='.$bd->ParamPrefix.'typeChange' ;
				$row = $bd->FetchSqlRow($sql, array('numOp' => $this->ZoneParent->IdMembreConnecte(), "typeChange" => $this->ScriptParent->TypeOpInterOppose())) ;
				// print_r($bd) ;
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
				$this->DefColRefChange = $this->InsereDefCol("ref_change", "No Ref.") ;
				$this->DefColRefChange->AlignElement = "center" ;
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
				$this->DefColDateOp->Largeur = "8%" ;
				$this->DefColDateOp->AlignElement = "center" ;
				$this->DefinitionsColonnes[] = & $this->DefColDateOp ;
				// Date valeur
				$this->DefColDateValeur = new PvDefinitionColonneDonnees() ;
				$this->DefColDateValeur->Libelle = "Date valeur" ;
				$this->DefColDateValeur->NomDonnees = "date_valeur" ;
				$this->DefColDateValeur->AliasDonnees = $bd->SqlDateToStrFr("date_valeur") ;
				$this->DefColDateValeur->Largeur = "8%" ;
				$this->DefColDateValeur->AlignElement = "center" ;
				$this->DefinitionsColonnes[] = & $this->DefColDateValeur ;
				$this->DefColDateEcheance = new PvDefinitionColonneDonnees() ;
				$this->DefColDateEcheance->Libelle = "Date &eacute;ch&eacute;ance" ;
				$this->DefColDateEcheance->NomDonnees = "date_echeance" ;
				$this->DefColDateEcheance->AliasDonnees = $bd->SqlDateToStrFr("date_echeance") ;
				$this->DefColDateEcheance->Largeur = "8%" ;
				$this->DefColDateEcheance->AlignElement = "center" ;
				$this->DefinitionsColonnes[] = & $this->DefColDateEcheance ;
				$this->DefColMontant = new PvDefinitionColonneDonnees() ;
				$this->DefColMontant->Libelle = "Montant" ;
				$this->DefColMontant->NomDonnees = "montant_change" ;
				$this->DefColMontant->AliasDonnees = $bd->SqlToDouble("montant_change") ;
				$this->DefColMontant->Largeur = "10%" ;
				$this->DefColMontant->Formatteur = new PvFormatteurColonneMonnaie() ;
				$this->DefColMontant->AlignElement = "right" ;
				$this->DefinitionsColonnes[] = & $this->DefColMontant ;
				$this->DefColLibDevise = new PvDefinitionColonneDonnees() ;
				$this->DefColLibDevise->Libelle = "Devise" ;
				$this->DefColLibDevise->NomDonnees = "devise_change" ;
				$this->DefColLibDevise->Largeur = "8%" ;
				$this->DefColLibDevise->AlignElement = "center" ;
				$this->DefinitionsColonnes[] = & $this->DefColLibDevise ;
				$this->DefColTaux = new PvDefinitionColonneDonnees() ;
				$this->DefColTaux->Libelle = "Taux" ;
				$this->DefColTaux->NomDonnees = "taux_transact" ;
				$this->DefColTaux->AliasDonnees = $bd->SqlToDouble("taux_transact") ;
				$this->DefColTaux->Largeur = "12%" ;
				$this->DefColTaux->Visible = "0" ;
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
				$this->FmtModif->ClasseCSS = "lien-act-001" ;
				$this->FmtModif->FormatLibelle = "Modifier" ;
				$this->FmtModif->OptionsOnglet["Modal"] = 1 ;
				$this->FmtModif->OptionsOnglet["BoutonFermer"] = 0 ;
				$this->FmtModif->OptionsOnglet["Largeur"] = 600 ;
				$this->FmtModif->OptionsOnglet["Hauteur"] = 535 ;
				$this->FmtModif->FormatIdOnglet = 'modif_op_inter_${num_op_inter}' ;
				$this->FmtModif->FormatTitreOnglet = ($this->ScriptParent->TypeOpInter == 1) ? 'Modifier placement' : 'Modifier emprunt' ;
				$this->FmtModif->FormatCheminIcone = 'images/icones/modif.png' ;
				$this->FmtModif->FormatURL = '?'.urlencode($this->ZoneParent->NomParamScriptAppele).'='.(($this->ScriptParent->TypeOpInter == 1) ? 'modifPlacement' : 'modifEmprunt').'&idEnCours=${num_op_inter}' ;
				$this->DefColActions->Formatteur->Liens[] = & $this->FmtModif ;
				$this->FmtSuppr = new PvConfigFormatteurColonneOuvreFenetre() ;
				$this->FmtSuppr->NomDonneesValid = "peut_modif" ;
				$this->FmtSuppr->ClasseCSS = "lien-act-002" ;
				$this->FmtSuppr->FormatLibelle = "Supprimer" ;
				$this->FmtSuppr->OptionsOnglet["Modal"] = 1 ;
				$this->FmtSuppr->OptionsOnglet["BoutonFermer"] = 0 ;
				$this->FmtSuppr->OptionsOnglet["Largeur"] = 600 ;
				$this->FmtSuppr->OptionsOnglet["Hauteur"] = 535 ;
				$this->FmtSuppr->FormatIdOnglet = 'suppr_op_inter_${num_op_inter}' ;
				$this->FmtSuppr->FormatTitreOnglet = ($this->ScriptParent->TypeOpInter == 1) ? 'Supprimer placement' : 'Supprimer emprunt' ;
				$this->FmtSuppr->FormatCheminIcone = 'images/icones/suppr.png' ;
				$this->FmtSuppr->FormatURL = '?'.urlencode($this->ZoneParent->NomParamScriptAppele).'='.(($this->ScriptParent->TypeOpInter == 1) ? 'supprPlacement' : 'supprEmprunt').'&idEnCours=${num_op_inter}' ;
				$this->DefColActions->Formatteur->Liens[] = & $this->FmtSuppr ;
				$this->FmtPostuls = new PvConfigFormatteurColonneOuvreFenetre() ;
				$this->FmtPostuls->NomDonneesValid = "peut_modif" ;
				$this->FmtPostuls->ClasseCSS = "lien-act-004" ;
				$this->FmtPostuls->FormatLibelle = "Negociations" ;
				$this->FmtPostuls->OptionsOnglet["Modal"] = 1 ;
				$this->FmtPostuls->OptionsOnglet["BoutonFermer"] = 0 ;
				$this->FmtPostuls->OptionsOnglet["Hauteur"] = 600 ;
				$this->FmtPostuls->OptionsOnglet["Largeur"] = 750 ;
				$this->FmtPostuls->FormatIdOnglet = 'postuls_op_inter_${num_op_inter}' ;
				$this->FmtPostuls->FormatTitreOnglet = ($this->ScriptParent->TypeOpInter == 1) ? 'Negociations placement' : 'Negociations emprunt' ;
				$this->FmtPostuls->FormatCheminIcone = 'images/icones/postulations.png' ;
				$this->FmtPostuls->FormatURL = '?'.urlencode($this->ZoneParent->NomParamScriptAppele).'='.(($this->ScriptParent->TypeOpInter == 1) ? 'postulsPlacement' : 'postulsEmprunt').'&idEnCours=${num_op_inter}' ;
				$this->DefColActions->Formatteur->Liens[] = & $this->FmtPostuls ;
				$this->FmtRepondre = new PvConfigFormatteurColonneOuvreFenetre() ;
				$this->FmtRepondre->NomDonneesValid = "peut_repondre" ;
				$this->FmtRepondre->ClasseCSS = "lien-act-003" ;
				$this->FmtRepondre->FormatLibelle = $this->ZoneParent->FournExprs->LibLienDemarrNegoc ;
				$this->FmtRepondre->OptionsOnglet["Modal"] = 1 ;
				$this->FmtRepondre->OptionsOnglet["BoutonFermer"] = 0 ;
				$this->FmtRepondre->OptionsOnglet["Hauteur"] = 525 ;
				$this->FmtRepondre->FormatIdOnglet = 'negoc_op_inter_${num_op_inter}' ;
				$this->FmtRepondre->FormatTitreOnglet = ($this->ScriptParent->TypeOpInter == 1) ? $this->ZoneParent->FournExprs->TitrFenDemarrNegocPlacement : $this->ZoneParent->FournExprs->TitrFenDemarrNegocEmprunt ;
				$this->FmtRepondre->FormatCheminIcone = 'images/icones/repondre.png' ;
				$this->FmtRepondre->FormatURL = '?'.urlencode($this->ZoneParent->NomParamScriptAppele).'='.(($this->ScriptParent->TypeOpInter == 1) ? 'interetPlacement' : 'interetEmprunt').'&idEnCours=${num_op_inter}' ;
				$this->DefColActions->Formatteur->Liens[] = & $this->FmtRepondre ;
				$this->DefinitionsColonnes[] = & $this->DefColActions ;
			}
			public function ChargeConfigBase()
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
			protected function ObtientRequeteSelection(& $bd)
			{
				return "(select t1.*, case when t1.commiss_ou_taux = 0 then mtt_commiss when type_taux = 0 then taux_change else ecran_taux end taux_transact, t2.code_devise devise_change, t7.shortname nom_court_entite, t7.name nom_entite, t2.code_devise lib_devise1, t3.code_devise lib_devise2, t4.login loginop, t4.nomop nomop, t4.prenomop prenomop, t5.id_entite_source, t5.id_entite_dest, t5.top_active, t6.numop numrep, t6.login loginrep, case when t4.numop = t6.numop then 1 else 0 end peut_modif, case when t4.numop <> t6.numop then 1 else 0 end peut_repondre,
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
			public function ChargeConfigSuppl()
			{
				if(! $this->RestrOps)
				{
					$this->CmdAjout = new PvCommandeOuvreFenetreAdminDirecte() ;
					$this->CmdAjout->Libelle = "Ajouter" ;
					$this->CmdAjout->NomScript = ($this->ScriptParent->TypeOpInter == 1) ? "ajoutPlacement" : "ajoutEmprunt" ;
					$this->CmdAjout->OptionsOnglet = array("Largeur" => "670", "Hauteur" => "545", "Modal" => 1, "BoutonFermer" => 0, "LibelleFermer" => "Fermer") ;
					$this->InscritCommande("cmdAjout", $this->CmdAjout) ;
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
				// print_r($this->FournisseurDonnees->BaseDonnees) ;
				return $ctn ;
			}
		}
		class TablEditOpInterTradPlatf extends TablConsultOpInterTradPlatf
		{
			public $RestrOps = 0 ;
			public $CacherNegocs = 1 ;
			public $FltCacherNegocs ;
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
				$this->FmtPostuls->Visible = 0 ;
				$this->FltCacherNegocs = $this->InsereFltSelectFixe("cacherNegoc", 0) ;
				$this->FltCacherNegocs->ExpressionDonnees = ($this->CacherNegocs) ? "num_op_inter_dem = 0" : "num_op_inter_dem <> 0" ;
			}
		}
		class TablSoumissOpInterTradPlatf extends TablEditOpInterTradPlatf
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
where t5.id_entite_dest is not null and t7.id_entite is not null and t6.login is not null and t4.active_op = 1 and t8.total_dem > 0)" ;
			}
			public function ChargeConfig()
			{
				parent::ChargeConfig() ;
				$this->CmdAjout->Visible = 0 ;
				$this->FmtModif->Visible = 0 ;
				$this->FmtSuppr->Visible = 0 ;
				$this->FmtPostuls->Visible = 1 ;
			}
		}
		class TablPostulsOpInterTradPlatf extends TableauDonneesBaseTradPlatf
		{
			protected function ObtientNomClsCSSElem($index, & $elem)
			{
				$nomClsCSS = parent::ObtientNomClsCSSElem($index, $elem) ;
				if($elem["bool_confirme"] == 1)
				{
					$nomClsCSS .= ' ui-state-disabled' ;
				}
				return $nomClsCSS ;
			}
		}
		
		class TablReservOpInterTradPlatf extends TableauDonneesBaseTradPlatf
		{
			public $FltNumOpSoumis ;
			public $FltTypeChange ;
			public $FltDatePubl ;
			public $FltMontant ;
			public $DefColTri ;
			public $DefColId ;
			public $DefColLoginDem ;
			public $DefColBanqueDem ;
			public $DefColDatePubl ;
			public $DefColTypeChange ;
			public $DefColMontantDem ;
			public $DefColMontantSoumis ;
			public $DefColTauxSoumis ;
			public $DefColConfirm ;
			public $DefColActions ;
			public $LienModif ;
			public $FltEstConfirme ;
			public $ValeurConfirme = 1 ;
			public function ChargeConfig()
			{
				parent::ChargeConfig() ;
				$this->ChargeDefCols() ;
				$this->ChargeDefColActions() ;
				$this->ChargeFlts() ;
				$this->ChargeFournDonnees() ;
			}
			protected function ChargeDefCols()
			{
				$bd = & $this->ApplicationParent->BDPrincipale ;
				$this->DefColTri = $this->InsereDefColCachee("date_change") ;
				$this->DefColId = $this->InsereDefColCachee("num_op_inter") ;
				$this->DefColPeutAjust = $this->InsereDefColCachee("peut_ajuster") ;
				$this->DefColDatePubl = $this->InsereDefCol("date_change", 'Date publication', $bd->SqlDateToStrFr('date_change')) ;
				$this->DefColLoginDem = $this->InsereDefCol("login_dem", 'Demandeur') ;
				$this->DefColBanqueDem = $this->InsereDefCol("nom_entite_dem", 'Banque') ;
				$this->DefColMontantDem = $this->InsereDefColMoney("montant_change", 'Montant') ;
				$this->DefColMontantSoumis = $this->InsereDefColMoney("montant_soumis", 'Montant possible') ;
				$this->DefColTauxSoumis = $this->InsereDefCol("taux_soumis", 'Taux possible') ;
				// $this->DefColTauxDem = $this->InsereDefCol("taux_dem", 'Taux', 'case when commiss_ou_taux = 0 then mtt_commiss when type_taux = 0 then taux_change else ecran_taux end') ;
				// $this->DefColConfirm = $this->InsereDefColBool("bool_confirme", 'Confirme') ;
			}
			protected function ChargeDefColActions()
			{
				$this->DefColActions = $this->InsereDefColActions('Actions') ;
				$this->LienModif = $this->InsereLienOuvreFenetreAction(
					$this->DefColActions,'?appelleScript=modifOpInterSoumis&idEnCours=${num_op_inter}',
					$this->ZoneParent->FournExprs->LibLienAjustNegoc, 'modif_op_inter_soumis_${num_op_inter}',
					$this->ZoneParent->FournExprs->TitrFenAjustNegoc, 
					array('Modal' => 1, 'BoutonFermer' => 0, 'Largeur' => 450, 'Hauteur' => 525)
				) ;
				$this->LienModif->NomDonneesValid = "peut_ajuster" ;
				if($this->ValeurConfirme == 1)
				{
					$this->DefColActions->Visible = 0 ;
				}
			}
			protected function ChargeFlts()
			{
				$this->FltNumOpSoumis = $this->InsereFltSelectFixe('numop', $this->ZoneParent->IdMembreConnecte(), 'numop = <self>') ;
				$this->FltEstSoumis = $this->InsereFltSelectFixe('num_op_inter_dem', 0, 'num_op_inter_dem <> <self>') ;
				$this->FltEstConfirme = $this->InsereFltSelectFixe('bool_confirme', $this->ValeurConfirme, 'bool_confirme = <self>') ;
				$this->FltTypeChange = $this->InsereFltSelectFixe('type_change_dem', $this->ScriptParent->TypeOpInterOppose(), 'type_change = <self>') ;
			}
			protected function ChargeFournDonnees()
			{
				$bd = & $this->ApplicationParent->BDPrincipale ;
				$this->FournisseurDonnees = new PvFournisseurDonneesSql() ;
				$this->FournisseurDonnees->BaseDonnees = & $bd ;
				$this->FournisseurDonnees->RequeteSelection = '(select t1.*, case when t1.bool_confirme = 0 then 1 else 0 end peut_ajuster, t3.login login_dem, t4.name nom_entite_dem from op_inter t1 inner join op_inter t2 on t1.num_op_inter_dem = t2.num_op_inter left join operateur t3 on t2.numop = t3.numop left join entite t4 on t3.id_entite = t4.id_entite where t1.bool_valide=1)' ;
			}
		}
		class TablNegocEnvoyOpInterTradPlatf extends TablReservOpInterTradPlatf
		{
			public $ValeurConfirme = 0 ;
		}
		
		class FormOpInterBaseTradPlatf extends FormulaireDonneesBaseTradPlatf
		{
			public $Largeur = "100%" ;
			public $InclureElementEnCours = 0 ;
			public $InclureTotalElements = 0 ;
			public $MaxFiltresEditionParLigne = 1 ;
			public $FltMontant ;
			public $FltIdCtrl ;
			public $FltRefChange ;
			public $FltDateOper ;
			public $FltDateValeur ;
			public $FltDateEcheance ;
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
			public $FltMttSoumis ;
			public $FltTauxSoumis ;
			public $CritrEcheanceInvalide ;
			public $CritrDejaPostee ;
			public $PourReponse = 0 ;
			public $PourNegoc = 0 ;
			public $PourAjust = 0 ;
			public $NomClasseCommandeExecuter = "CmdAjoutOpInterTradPlatf" ;
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
				// ID de control
				$this->FltIdCtrl = $this->InsereFltEditFixe("idCtrl", uniqid(), "id_ctrl") ;
				// Ref Change
				$this->FltRefChange = $this->InsereFltEditHttpPost("refChange", "ref_change") ;
				$this->FltRefChange->Libelle = "Ref." ;
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
				$this->ZoneParent->RemplisseurConfig->AppliqueCompMttComiss($this->FltMttComiss) ;
				$this->FiltresEdition[] = & $this->FltMttComiss ;
				// Type taux ou commission ?
				$this->FltTypeTaux = $this->ScriptParent->CreeFiltreHttpPost("type_taux") ;
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
				$this->ZoneParent->RemplisseurConfig->AppliqueCompValeurTaux($this->FltMttTaux) ;
				$this->FiltresEdition[] = & $this->FltMttTaux ;
				// Ecran Taux
				$this->FltEcranTaux = $this->ScriptParent->CreeFiltreHttpPost("ecran_taux") ;
				$this->FltEcranTaux->DefinitColLiee("ecran_taux") ;
				$this->ZoneParent->RemplisseurConfig->AppliqueCompEcranTaux($this->FltEcranTaux) ;
				$this->FiltresEdition[] = & $this->FltEcranTaux ;
				// Date operation
				$this->FltDateOper = $this->ScriptParent->CreeFiltreHttpPost("date_operation") ;
				$this->FltDateOper->DefinitColLiee("date_operation") ;
				$this->FltDateOper->Libelle = "Date operation" ;
				$this->FltDateOper->ValeurParDefaut = date("Y-m-d") ;
				$this->FltDateOper->DeclareComposant("PvCalendarDateInput") ;
				$this->FiltresEdition[] = & $this->FltDateOper ;
				// Date valeur
				$this->FltDateValeur = $this->ScriptParent->CreeFiltreHttpPost("date_valeur") ;
				$this->FltDateValeur->DefinitColLiee("date_valeur") ;
				$this->FltDateValeur->Libelle = "Date valeur" ;
				$this->FltDateValeur->ValeurParDefaut = date("Y-m-d") ;
				$this->FltDateValeur->DeclareComposant("PvCalendarDateInput") ;
				$this->FiltresEdition[] = & $this->FltDateValeur ;
				// Date echeance
				$this->FltDateEcheance = $this->ScriptParent->CreeFiltreHttpPost("date_echeance") ;
				$this->FltDateEcheance->DefinitColLiee("date_echeance") ;
				$this->FltDateEcheance->Libelle = "Date echeance" ;
				$this->FltDateEcheance->EcheanceParDefaut = date("Y-m-d") ;
				$this->FltDateEcheance->DeclareComposant("PvCalendarDateInput") ;
				$this->FiltresEdition[] = & $this->FltDateEcheance ;
				// Type de change
				$this->FltTypeChange = $this->ScriptParent->CreeFiltreFixe("typeChange", $this->TypeOpInter) ;
				$this->FltTypeChange->DefinitColLiee("type_change") ;
				$this->FiltresEdition[] = & $this->FltTypeChange ;
				// Operateur responsable
				$this->FltNumOp = $this->ScriptParent->CreeFiltreMembreConnecte('numop', 'MEMBER_ID') ;
				$this->FltNumOp->DefinitColLiee("numop") ;
				$this->FiltresEdition[] = & $this->FltNumOp ;
				// Montant soumis
				$this->FltMttSoumis = $this->InsereFltEditHttpPost('montant_soumis', 'montant_soumis') ;
				$this->FltMttSoumis->NePasIntegrerParametre = 1 ;
				// Taux soumis
				$this->FltTauxSoumis = $this->InsereFltEditHttpPost('taux_soumis', 'taux_soumis') ;
				$this->FltTauxSoumis->NePasIntegrerParametre = 1 ;
				// Commentaire
				$this->FltCommentaire = $this->ScriptParent->CreeFiltreHttpPost("commentaire") ;
				$comp0 = $this->FltCommentaire->DeclareComposant("PvZoneMultiligneHtml") ;
				$comp0->TotalLignes = 11 ;
				$comp0->TotalColonnes = 92 ;
				$this->FltCommentaire->DefinitColLiee("commentaire") ;
				$this->FiltresEdition[] = & $this->FltCommentaire ;
				if($this->PourReponse || $this->PourNegoc)
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
				if($this->PourReponse || $this->PourNegoc)
				{
					$this->NomClasseCommandeExecuter = 'CmdEnvoiRepOpInterTradPlatf' ;
				}
				parent::ChargeConfig() ;
				$this->FournisseurDonnees = new PvFournisseurDonneesSql() ;
				$this->FournisseurDonnees->RequeteSelection = '(select t1.*, t2.code_devise lib_devise1, t3.code_devise lib_devise2, '.$this->ApplicationParent->BDPrincipale->SqlConcat(array('t2.code_devise', "' / '", 't3.code_devise')).' devise_change, case when t1.commiss_ou_taux = 0 then mtt_commiss when type_taux = 0 then taux_change else ecran_taux end taux_transact from op_inter t1 left join devise t2 on t1.id_devise1 = t2.id_devise left join devise t3 on t1.id_devise2 = t3.id_devise)' ;
				if($this->PourNegoc == 1 && $this->PourAjust == 1)
				{
					$this->FournisseurDonnees->RequeteSelection = '(select t1.*, t4.num_op_inter num_op_inter_soumis, t4.montant_soumis montant_change_soumis, t4.taux_soumis taux_change_soumis, t2.code_devise lib_devise1, t3.code_devise lib_devise2, '.$this->ApplicationParent->BDPrincipale->SqlConcat(array('t2.code_devise', "' / '", 't3.code_devise')).' devise_change, case when t1.commiss_ou_taux = 0 then t1.mtt_commiss when t1.type_taux = 0 then t1.taux_change else t1.ecran_taux end taux_transact from op_inter t4 inner join op_inter t1 on t4.num_op_inter_dem=t1.num_op_inter left join devise t2 on t1.id_devise1 = t2.id_devise left join devise t3 on t1.id_devise2 = t3.id_devise)' ;
					// echo $this->FournisseurDonnees->RequeteSelection ;
				}
				// print 				$this->FournisseurDonnees->RequeteSelection ;
				$this->FournisseurDonnees->TableEdition = "op_inter" ;
				$this->FournisseurDonnees->BaseDonnees = $this->ApplicationParent->BDPrincipale ;
				if(! $this->PourReponse && ! $this->PourNegoc && $this->Editable)
				{
					$this->CritrEcheanceInvalide = $this->CommandeExecuter->InsereNouvCritere(new CritereEcheanceInvalideOpInter()) ;
					$this->CritrDejaPostee = $this->CommandeExecuter->InsereNouvCritere(new CritrOpInterDejaPostee()) ;
				}
				if($this->PourNegoc && $this->PourAjust)
				{
					$this->FltNumOpInter->ExpressionDonnees = 'num_op_inter_soumis = <self>' ;
				}
			}
			public function CalculeElementsRendu()
			{
				parent::CalculeElementsRendu() ;
				// print_r($this->ApplicationParent->BDPrincipale) ;
				if(! count($this->ElementEnCours))
				{
					return ;
				}
				if($this->PourNegoc == 1)
				{
					$typeTaux = $this->ZoneParent->RemplisseurConfig->ObtientTypeTaux($this->ElementEnCours) ;
					$valTaux = $this->ZoneParent->RemplisseurConfig->ObtientValeurTaux($this->ElementEnCours) ;
					if($this->PourAjust == 0)
					{
						$this->ZoneParent->RemplisseurConfig->AppliqueCompComissOuTaux($this->FltTauxSoumis, $this->ElementEnCours) ;
						$this->FltMttSoumis->ValeurParDefaut = $this->ElementEnCours["montant_change"] ;
						$this->FltTauxSoumis->ValeurParDefaut = $valTaux ;
						// print_r($this->ElementEnCours) ;
						$this->FltMttSoumis->NePasIntegrerParametre = 0 ;
						$this->FltTauxSoumis->NePasIntegrerParametre = 0 ;
					}
					else
					{
						$this->FltMontant->NePasIntegrerParametre = 0 ;
						$this->FltMttSoumis->DefinitColLiee("montant_change_soumis") ;
						$this->FltTauxSoumis->DefinitColLiee("taux_change_soumis") ;
					}
				}
			}
			protected function EditionPossible()
			{
				if($this->InclureElementEnCours == 0 || ($this->Editable == 0 && $this->CacherBlocCommandes))
				{
					return 1 ;
				}
				$numOpInter = $this->FltNumOpInter->Lie() ;
				$bd = & $this->FournisseurDonnees->BaseDonnees ;
				$total = $bd->FetchSqlValue('select count(0) total from op_inter where num_op_inter_dem = '.$bd->ParamPrefix.'numOpInter', array('numOpInter' => $numOpInter), 'total') ;
				if($total === null || $total > 0)
				{
					return 0 ;
				}
				return 1 ;
			}
			protected function RenduBloque()
			{
				$ctn = parent::RenduBloque() ;
				if($ctn != '')
				{
					return $ctn ;
				}
				if(! $this->EditionPossible())
				{
					$this->Bloque = 1 ;
					return 'Vous ne pouvez plus modifier ou supprimer cette op&eacute;ration' ;
				}
				return '' ;
			}
			protected function InitDessinateurFiltresEdition()
			{
				$this->DessinateurFiltresEdition = new DessinFiltresFormOpInter() ;
			}
		}
		
		class CmdAjoutOpInterTradPlatf extends PvCommandeAjoutElement
		{
			public function ExecuteInstructions()
			{
				parent::ExecuteInstructions() ;
				if($this->StatutExecution == 0)
					return ;
				$bd = & $this->FormulaireDonneesParent->FournisseurDonnees->BaseDonnees ;
				$idCtrl = $this->FormulaireDonneesParent->FltIdCtrl->Lie() ;
				$lgn = $bd->FetchSqlRow('select * from op_inter where id_ctrl='.$bd->ParamPrefix.'idCtrl', array('idCtrl' => $idCtrl)) ;
				if(! is_array($lgn))
					return ;
				$refChange = (($this->FormulaireDonneesParent->TypeOpInter == 1) ? 'P' : 'E').date('dmy').str_repeat('0', 4 - strlen(strval($lgn["num_op_inter"]))).$lgn["num_op_inter"] ;
				$sql = 'update op_inter set ref_change = '.$bd->ParamPrefix.'refChange where id_ctrl='.$bd->ParamPrefix.'idCtrl' ;
				$ok = $bd->RunSql($sql, array('refChange' => $refChange, 'idCtrl' => $idCtrl)) ;
			}
		}
		
		class CmdEnvoiRepOpInterTradPlatf extends PvCommandeEditionElementBase
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
		
		class CmdAjustOpInterTradPlatf extends PvCommandeEditionElementBase
		{
			public $Mode = 2 ;
			public $MessageSuccesExecution = "Votre demande a &eacute;t&eacute; enregistr&eacute;e" ;
			public function ExecuteInstructions()
			{
				parent::ExecuteInstructions() ;
				// print_r($this->FormulaireDonneesParent->FournisseurDonnees->BaseDonnees) ;
				if($this->StatutExecution == 1)
				{
					$this->FormulaireDonneesParent->CacherFormulaireFiltres = 1 ;
				}
			}
		}
		class CmdNegocOpInterTradPlatf extends CmdAjustOpInterTradPlatf
		{
			public $Mode = 1 ;
			protected function FixeTauxSoumis()
			{
				if($this->FormulaireDonneesParent->InclureElementEnCours || $this->FormulaireDonneesParent->CommissOuTaux == 0)
				{
					return ;
				}
				$form = & $this->FormulaireDonneesParent ;
				$typeTaux = $form->FltTypeTaux->Lie() ;
				if($typeTaux == 0)
				{
					$form->FltTauxSoumis->ValeurParDefaut = intval($form->FltValeurTaux->Lie()) ;
				}
				else
				{
					$form->FltTauxSoumis->ValeurParDefaut = intval($form->FltEcranTaux->Lie()) ;
				}
				$form->FltTauxSoumis->DejaLie = 0 ;
				$form->FltTauxSoumis->Lie() ;
			}
			public function ExecuteInstructions()
			{
				$this->FixeTauxSoumis() ;
				parent::ExecuteInstructions() ;
				// print_r($this->FormulaireDonneesParent->FournisseurDonnees) ;
			}
		}
		class CmdSupprOpInterTradPlatf extends PvCommandeSupprElement
		{
			public $CacherFormulaireFiltresSiSucces = 1 ;
			public $MessageSuccesExecution = "L'op&eacute;ration a &eacute;t&eacute; supprim&eacute;e." ;
			public function ExecuteInstructions2()
			{
				$bd = & $this->FormulaireDonneesParent->FournisseurDonnees->BaseDonnees ;
				$numOpInter = $this->FormulaireDonneesParent->FltNumOpInter->Lie() ;
				$ok = $bd->RunSql('update op_inter set bool_valide = 0 where num_op_inter='.$bd->ParamPrefix.'numOpInter', array('numOpInter' => $numOpInter)) ;
				if(! $ok)
				{
					$this->RenseigneErreur("Erreur SQL : ".$bd->ConnectionException) ;
				}
				else
				{
					$this->ConfirmeSucces() ;
				}
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
				/*
				elseif($composant->PourNegoc == 1)
				{
					$ctn .= $this->ExecuteNegoc($script, $composant, $parametres) ;
				}
				*/
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
				$ctn .= '<td width="40%">Ref.</td>'.PHP_EOL ;
				$ctn .= '<td width="*">'.htmlentities($composant->FltRefChange->Etiquette()).'</td>'.PHP_EOL ;
				$ctn .= '</tr>'.PHP_EOL ;
				$ctn .= '<tr>'.PHP_EOL ;
				$ctn .= '<td>'.(($composant->FltTypeChange ->Lie() == 1) ? 'Placement' : 'Emprunt').'</td>'.PHP_EOL ;
				$ctn .= '<td>'.htmlentities($composant->FltLibDevise->Etiquette()).'</td>'.PHP_EOL ;
				$ctn .= '</tr>'.PHP_EOL ;
				$ctn .= '<tr>'.PHP_EOL ;
				$ctn .= '<td>Date operation</td>'.PHP_EOL ;
				$ctn .= '<td>'.htmlentities($composant->FltDateOper->Etiquette()).'</td>'.PHP_EOL ;
				$ctn .= '</tr>'.PHP_EOL ;
				$ctn .= '<tr>'.PHP_EOL ;
				$ctn .= '<td>Montant Demand&eacute;</td>'.PHP_EOL ;
				$ctn .= '<td>'.format_money($composant->FltMontant->Etiquette(), 3, 1).'</td>'.PHP_EOL ;
				$ctn .= '</tr>'.PHP_EOL ;
				return $ctn ;
			}
			protected function ExecuteNegoc(& $script, & $composant, $parametres)
			{
				// $auteurDem = ($this->FltIdEnCours->Lie() == $composant->)
				$renduMttTransact = ($composant->PourAjust == 0) ? $composant->FltMontant->Etiquette() : $composant->FltMontant->Rendu() ;
				$renduTauxTransact = ($composant->PourAjust == 0) ? $composant->FltTauxTransact->Etiquette() : $composant->FltTauxTransact->Rendu() ;
				$renduMttSoumis = ($composant->PourAjust == 0) ? $composant->FltMttSoumis->Rendu() : $composant->FltMttSoumis->Etiquette() ;
				$renduTauxSoumis = ($composant->PourAjust == 0) ? $composant->FltTauxSoumis->Rendu() : $composant->FltTauxSoumis->Etiquette() ;
				$ctn = '' ;
				$ctn .= '<table width="100%" cellspacing="0" cellpadding="2">'.PHP_EOL ;
				$ctn .= '<tr>'.PHP_EOL ;
				$ctn .= '<td width="60%">'.(($composant->FltTypeChange ->Lie() == 1) ? 'Placement' : 'Emprunt').'</td>'.PHP_EOL ;
				$ctn .= '<td width="*">'.htmlentities($composant->FltLibDevise->Etiquette()).'</td>'.PHP_EOL ;
				$ctn .= '</tr>'.PHP_EOL ;
				$ctn .= '<tr>'.PHP_EOL ;
				$ctn .= '<td>Date operation</td>'.PHP_EOL ;
				$ctn .= '<td>'.htmlentities($composant->FltDateOper->Etiquette()).'</td>'.PHP_EOL ;
				$ctn .= '</tr>'.PHP_EOL ;
				$ctn .= '<tr>'.PHP_EOL ;
				$ctn .= '<td>Montant Demand&eacute;</td>'.PHP_EOL ;
				$ctn .= '<td>'.$renduMttTransact.'</td>'.PHP_EOL ;
				$ctn .= '</tr>'.PHP_EOL ;
				$ctn .= '<tr>'.PHP_EOL ;
				$ctn .= '<td>Taux/Commission demand&eacute;</td>'.PHP_EOL ;
				$ctn .= '<td>'.$renduTauxTransact.'</td>'.PHP_EOL ;
				$ctn .= '</tr>'.PHP_EOL ;
				$ctn .= '<tr>'.PHP_EOL ;
				$ctn .= '<td>Montant possible</td>'.PHP_EOL ;
				$ctn .= '<td>'.$renduMttSoumis.'</td>'.PHP_EOL ;
				$ctn .= '</tr>'.PHP_EOL ;
				$ctn .= '<tr>'.PHP_EOL ;
				$ctn .= '<td>Taux/Commission possible</td>'.PHP_EOL ;
				$ctn .= '<td>'.$renduTauxSoumis.'</td>'.PHP_EOL ;
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
				$ctn .= '<td width="25%">Devise :</td><td width="*"><table cellspacing="0" cellpadding="0"><tr><td>'.$composant->FltDevise1->Rendu().'</td></tr></table></td>'.PHP_EOL ;
				$ctn .= '</tr>'.PHP_EOL ;
				$ctn .= '<tr>'.PHP_EOL ;
				$ctn .= '<td>Montant</td>'.PHP_EOL ;
				$ctn .= '<td>'.$composant->FltMontant->Rendu().'</td>'.PHP_EOL ;
				$ctn .= '</tr>'.PHP_EOL ;
				$ctn .= '<tr>'.PHP_EOL ;
				$ctn .= '<td>Date valeur</td>'.PHP_EOL ;
				$ctn .= '<td>'.$composant->FltDateValeur->Rendu().'</td>'.PHP_EOL ;
				$ctn .= '</tr>'.PHP_EOL ;
				$ctn .= '<tr>'.PHP_EOL ;
				$ctn .= '<tr>'.PHP_EOL ;
				$ctn .= '<td>Date &eacute;cheance</td>'.PHP_EOL ;
				$ctn .= '<td>'.$composant->FltDateEcheance->Rendu().'</td>'.PHP_EOL ;
				$ctn .= '</tr>'.PHP_EOL ;
				$ctn .= '<tr>'.PHP_EOL ;
				$ctn .= '<td>Date op&eacute;ration</td>'.PHP_EOL ;
				$ctn .= '<td>'.date("d/m/Y").'</td>'.PHP_EOL ;
				$ctn .= '</tr>
</table>
</div>'.PHP_EOL ;
				/*
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
				*/
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
		
		class DessinFiltresAjustOpInter extends PvDessinateurRenduHtmlFiltresDonnees
		{
			public function Execute(& $script, & $composant, $parametres)
			{
				$composant->LieTousLesFiltres() ;
				$ctn = '' ;
				$ctn .= '<table width="100%" cellspacing="0" cellpadding="2">'.PHP_EOL ;
				$ctn .= '<colgroup><col width="40%" /><col width="*" /></colgroup>'.PHP_EOL ;
				$ctn .= '<tr><th class="ui-widget ui-widget-header" colspan="2">Emetteur</th></tr>'.PHP_EOL ;
				$ctn .= '<tr>' ;
				$ctn .= '<td><label for="'.$composant->FltRefChange->ObtientIDElementHtmlComposant().'">Reference :</label></td>' ;
				$ctn .= '<td>'.$composant->FltRefChange->Etiquette().'</td>' ;
				$ctn .= '</tr>'.PHP_EOL ;
				$ctn .= '<tr>' ;
				$ctn .= '<td><label for="'.$composant->FltLoginDem->ObtientIDElementHtmlComposant().'">Login</label></td>' ;
				$ctn .= '<td>'.$composant->FltLoginDem->Rendu().'</td>' ;
				$ctn .= '</tr>'.PHP_EOL ;
				$ctn .= '<tr>' ;
				$ctn .= '<td><label for="'.$composant->FltCodeEntiteDem->ObtientIDElementHtmlComposant().'">Code Banque</label></td>' ;
				$ctn .= '<td>'.$composant->FltCodeEntiteDem->Rendu().'</td>' ;
				$ctn .= '</tr>'.PHP_EOL ;
				$ctn .= '<tr>' ;
				$ctn .= '<td><label for="'.$composant->FltNomEntiteDem->ObtientIDElementHtmlComposant().'">Nom Banque</label></td>' ;
				$ctn .= '<td>'.$composant->FltNomEntiteDem->Rendu().'</td>' ;
				$ctn .= '</tr>'.PHP_EOL ;
				$ctn .= $this->SectionDemandeur($script, $composant, $parametres).PHP_EOL ;	
				$ctn .= '<tr><th colspan="2" class="ui-widget ui-widget-header">N&eacute;gociateur</th></tr>'.PHP_EOL ;
				$ctn .= '<tr>' ;
				$ctn .= '<td><label for="'.$composant->FltLoginSoumis->ObtientIDElementHtmlComposant().'">Login</label></td>' ;
				$ctn .= '<td>'.$composant->FltLoginSoumis->Rendu().'</td>' ;
				$ctn .= '</tr>'.PHP_EOL ;
				$ctn .= '<tr>' ;
				$ctn .= '<td><label for="'.$composant->FltCodeEntiteSoumis->ObtientIDElementHtmlComposant().'">Code Banque</label></td>' ;
				$ctn .= '<td>'.$composant->FltCodeEntiteSoumis->Rendu().'</td>' ;
				$ctn .= '</tr>'.PHP_EOL ;
				$ctn .= '<tr>' ;
				$ctn .= '<td><label for="'.$composant->FltNomEntiteSoumis->ObtientIDElementHtmlComposant().'">Nom Banque</label></td>' ;
				$ctn .= '<td>'.$composant->FltNomEntiteSoumis->Rendu().'</td>' ;
				$ctn .= '</tr>'.PHP_EOL ;
				$ctn .= $this->SectionRepondeur($script, $composant, $parametres).PHP_EOL ;
				$ctn .= '</table>' ;
				return $ctn ;
			}
			protected function RenduFiltreMonnaie(& $filtre)
			{
				$ctn = '' ;
				if($filtre->EstEtiquette)
				{
					$ctn .= format_money($filtre->Rendu(), 3, 2) ;
				}
				else
				{
					$ctn .= $filtre->Rendu() ;
				}
				return $ctn ;
			}
			protected function SectionDemandeur(& $script, & $composant, $parametres)
			{
				$ctn = '' ;
				$ctn .= '<tr>' ;
				$ctn .= '<td><label for="'.$composant->FltDevise->ObtientIDElementHtmlComposant().'">'.$composant->FltDevise->ObtientLibelle().'</label></td>' ;
				$ctn .= '<td>'.$composant->FltDevise->Rendu().'</td>' ;
				$ctn .= '</tr>'.PHP_EOL ;
				$ctn .= '<tr>' ;
				$ctn .= '<td><label for="'.$composant->FltMontantDem->ObtientIDElementHtmlComposant().'">'.$composant->FltMontantDem->ObtientLibelle().'</label></td>' ;
				$ctn .= '<td>'.$this->RenduFiltreMonnaie($composant->FltMontantDem).'</td>' ;
				$ctn .= '</tr>'.PHP_EOL ;
				$ctn .= '<tr>' ;
				$ctn .= '<td><label for="'.$composant->FltTauxDem->ObtientIDElementHtmlComposant().'">'.$composant->FltTauxDem->ObtientLibelle().'</label></td>' ;
				$ctn .= '<td>'.$composant->FltTauxDem->Rendu().'</td>' ;
				$ctn .= '</tr>'.PHP_EOL ;
				return $ctn ;
			}
			protected function SectionRepondeur(& $script, & $composant, $parametres)
			{
				$ctn = '' ;
				$ctn .= '<tr>' ;
				$ctn .= '<td><label for="'.$composant->FltMontantSoumis->ObtientIDElementHtmlComposant().'">'.$composant->FltMontantSoumis->ObtientLibelle().'</label></td>' ;
				$ctn .= '<td>'.$this->RenduFiltreMonnaie($composant->FltMontantSoumis).'</td>' ;
				$ctn .= '</tr>'.PHP_EOL ;
				$ctn .= '<tr>' ;
				$ctn .= '<td><label for="'.$composant->FltTauxSoumis->ObtientIDElementHtmlComposant().'">'.$composant->FltTauxSoumis->ObtientLibelle().'</label></td>' ;
				$ctn .= '<td>'.$composant->FltTauxSoumis->Rendu().'</td>' ;
				$ctn .= '</tr>'.PHP_EOL ;
				return $ctn ;
			}
		}
		class DessinFiltresInteretOpInter extends DessinFiltresAjustOpInter
		{
			public function Execute(& $script, & $composant, $parametres)
			{
				$ctn = '' ;
				$ctn .= '<p>' ;
				if($script->TypeOpInter == 1)
					$ctn .= $script->ZoneParent->FournExprs->MsgInteretPlacement ;
				else
					$ctn .= $script->ZoneParent->FournExprs->MsgInteretEmprunt ;
				$ctn .= '</p>' ;
				$ctn .= '<table width="100%" cellspacing="0" cellpadding="2">'.PHP_EOL ;
				$ctn .= '<colgroup><col width="40%" /><col width="*" /></colgroup>'.PHP_EOL ;
				$ctn .= '<tr><th class="ui-widget ui-widget-header" colspan="2">Emetteur</th></tr>'.PHP_EOL ;
				$ctn .= '<tr>' ;
				$ctn .= '<tr>' ;
				$ctn .= '<td><label for="'.$composant->FltRefChange->ObtientIDElementHtmlComposant().'">Reference :</label></td>' ;
				$ctn .= '<td>'.$composant->FltRefChange->Etiquette().'</td>' ;
				$ctn .= '</tr>'.PHP_EOL ;
				$ctn .= '<td><label for="'.$composant->FltLoginDem->ObtientIDElementHtmlComposant().'">Login</label></td>' ;
				$ctn .= '<td>'.$composant->FltLoginDem->Rendu().'</td>' ;
				$ctn .= '</tr>'.PHP_EOL ;
				$ctn .= '<tr>' ;
				$ctn .= '<td><label for="'.$composant->FltCodeEntiteDem->ObtientIDElementHtmlComposant().'">Code Banque</label></td>' ;
				$ctn .= '<td>'.$composant->FltCodeEntiteDem->Rendu().'</td>' ;
				$ctn .= '</tr>'.PHP_EOL ;
				$ctn .= '<tr>' ;
				$ctn .= '<td><label for="'.$composant->FltNomEntiteDem->ObtientIDElementHtmlComposant().'">Nom Banque</label></td>' ;
				$ctn .= '<td>'.$composant->FltNomEntiteDem->Rendu().'</td>' ;
				$ctn .= '</tr>'.PHP_EOL ;
				$ctn .= $this->SectionDemandeur($script, $composant, $parametres) ;
				$ctn .= '</table>' ;
				return $ctn ;
			}
		}
		class DessinFiltresNegocOpInter extends DessinFiltresAjustOpInter
		{
			protected function SectionRepondeur(& $script, & $composant, & $parametres)
			{
				$ctn = '' ;
				if($composant->CommissOuTaux == 0)
				{
					return parent::SectionRepondeur($script, $composant, $parametres) ;
				}
				$ctn .= '<tr>' ;
				$ctn .= '<td><label for="'.$composant->FltMontantSoumis->ObtientIDElementHtmlComposant().'">'.$composant->FltMontantSoumis->ObtientLibelle().'</label></td>' ;
				$ctn .= '<td>'.$composant->FltMontantSoumis->Rendu().'</td>' ;
				$ctn .= '</tr>'.PHP_EOL ;
				$ctn .= '<tr>
				<td valign="top">Taux :</td>
				<td>
<table cellspacing="0" cellpadding="4">
<tr>
<td>Type</td><td><select name="type_taux" id="type_taux" onchange="selectEditeurTauxChange(this.value)" ;"><option value="0">N/A</option><option value="1"'.(($composant->FltTypeTaux->Lie() == 1) ? ' selected' : '').'>Ecran</option></select></td>
</tr>
<tr>
<td>Valeur</td><td class="grpValTaux"><span>'.$composant->FltValeurTaux->Rendu().'</span><span>'.$composant->FltEcranTaux->Rendu().'</span></td>
</tr>
</table>
</td>
</tr>' ;
				$ctn .= '<script type="text/javascript">
	function selectEditeurTauxChange(val)
	{
		jQuery(".grpValTaux span").each(function(index, elem) {
			if(index == val)
				jQuery(elem).show() ;
			else
				jQuery(elem).hide() ;
		}) ;
	}
	jQuery(function() {
		selectEditeurTauxChange('.json_encode($composant->FltTypeTaux->Lie()).') ;
	}) ;
</script>' ;
				return $ctn ;
			}
		}
		
		class FormAjoutPlacementTradPlatf extends FormOpInterBaseTradPlatf
		{
			public $TypeOpInter = 1 ;
		}
		
		class FormAjustPlacementTradPlatf extends FormulaireDonneesBaseTradPlatf
		{
			public $Largeur = "100%" ;
			public $InclureElementEnCours = 1 ;
			public $InclureTotalElements = 1 ;
			public $NomClasseCommandeAnnuler = "PvCmdFermeFenetreActiveAdminDirecte" ;
			public $NomClasseCommandeExecuter = "CmdAjustOpInterTradPlatf" ;
			public $FltIdEnCours ;
			public $FltRefChange ;
			public $FltLimitOpInter ;
			public $FltTypeChange ;
			public $FltLoginDem ;
			public $FltNomEntiteDem ;
			public $FltCodeEntiteDem ;
			public $FltDevise ;
			public $FltMontantDem ;
			public $FltTauxDem ;
			public $FltMontantSoumis ;
			public $FltNomEntiteSoumis ;
			public $FltCodeEntiteSoumis ;
			public $FltTauxSoumis ;
			public $ModeAccesMembre = 0 ;
			public $CommissOuTaux = 0 ;
			public $MaxFiltresEditionParLigne = 1 ;
			public $LigneOpInterDem = array() ;
			public $MsgReponseInterdit = '<div class="ui-state-error">Vous avez d&eacute;j&agrave; r&eacute;pondu &agrave; cette offre.</div>' ;
			protected function CreeDessinFltsEdit()
			{
				return new DessinFiltresAjustOpInter() ;
			}
			protected function ReponsePossible()
			{
				$bd = & $this->ApplicationParent->BDPrincipale ;
				$sql = 'select * from op_inter where num_op_inter_dem='.$bd->ParamPrefix.'numOpInterDem and numop='.$bd->ParamPrefix.'login' ;
				$row = $bd->FetchSqlRow(
					$sql,
					array(
						'numOpInterDem' => $this->FltIdEnCours->Lie(),
						'login' => $this->ZoneParent->IdMembreConnecte()
					)
				) ;
				return (is_array($row) && count($row) == 0) ? 1 : 0 ;
			}
			public function EstAccessible()
			{
				$ok = parent::EstAccessible() ;
				if(! $ok)
					return $ok ;
				$idMembre = $this->ZoneParent->IdMembreConnecte() ;
				$bd = & $this->ApplicationParent->BDPrincipale ;
				$ligne = array() ;
				if($this->InclureElementEnCours)
				{
					$idEnCours = $this->FltIdEnCours->Lie() ;
					$ligne = $bd->FetchSqlRow('select t1.* from op_inter t1
	inner join op_inter t2 on t1.num_op_inter_dem = t2.num_op_inter
	where t1.num_op_inter='.$bd->ParamPrefix.'idEnCours and (t1.numop = '.$bd->ParamPrefix.'idMembre or t2.numop = '.$bd->ParamPrefix.'idMembre)', array('idEnCours' => $idEnCours, 'idMembre' => $idMembre)) ;
				}
				else
				{
					$ligne = $this->LigneOpInterDem ;
				}
				$ok = (is_array($ligne) && count($ligne) > 0) ;
				if($ok)
				{
					$ligne["commiss_ou_taux"] = $ligne["id_devise1"] == ID_EURO_TRAD_PLATF ? 0 : 1 ;
					$this->CommissOuTaux = $ligne["commiss_ou_taux"] ;
					$this->ModeAccesMembre = ($ligne["numop"] == $idMembre) ? 1 : 0 ;
					$this->ZoneParent->RemplisseurConfig->AppliqueCompComissOuTaux($this->FltTauxDem, $ligne, $this->InclureElementEnCours, 1) ;
					$this->ZoneParent->RemplisseurConfig->AppliqueCompComissOuTaux($this->FltTauxSoumis, $ligne, 0) ;
					if($this->InclureElementEnCours)
					{
						if($this->ModeAccesMembre == 1)
						{
							$this->FltTauxDem->EstEtiquette = 1 ;
							$this->FltTauxDem->NePasLierColonne = 1 ;
							$this->FltMontantDem->EstEtiquette = 1 ;
							$this->FltMontantDem->NePasLierColonne = 1 ;
						}
						else
						{
							$this->FltTauxSoumis->EstEtiquette = 1 ;
							$this->FltTauxSoumis->NePasLierColonne = 1 ;
							$this->FltMontantSoumis->EstEtiquette = 1 ;
							$this->FltMontantSoumis->NePasLierColonne = 1 ;
						}
					}
					else
					{
						$this->FltTauxDem->EstEtiquette = 1 ;
						$this->FltMontantDem->EstEtiquette = 1 ;
					}
				}
				return $ok ;
			}
			public function ChargeConfig()
			{
				parent::ChargeConfig() ;
				$this->ChargeFournDonneesSpec() ;
				$this->DessinateurFiltresEdition = $this->CreeDessinFltsEdit() ;
			}
			protected function ChargeFournDonneesSpec()
			{
				$fourn = new PvFournisseurDonneesSql() ;
				$fourn->BaseDonnees = & $this->ApplicationParent->BDPrincipale ;
				$fourn->RequeteSelection = '(select t1.*, t3.lib_devise lib_devise1, t4.lib_devise code_devise2, case when t3.code_devise is not null then  t3.code_devise else t4.code_devise end lib_devise, t5.login login_soumis, t6.login login_dem, t7.code code_entite_soumis, t7.name nom_entite_soumis, t8.code code_entite_dem, t8.name nom_entite_dem from op_inter t1 left join op_inter t2 on t1.num_op_inter_dem = t2.num_op_inter left join devise t3 on t1.id_devise1 = t3.id_devise left join devise t4 on t1.id_devise2 = t4.id_devise left join operateur t5 on t1.numop = t5.numop left join operateur t6 on t2.numop = t6.numop left join entite t7 on t5.id_entite = t7.id_entite left join entite t8 on t6.id_entite = t8.id_entite)' ;
				$fourn->TableEdition = 'op_inter' ;
				$this->FournisseurDonnees = & $fourn ;
			}
			protected function ChargeFiltresSelection()
			{
				$this->FltIdEnCours = $this->InsereFltLgSelectHttpGet("idEnCours", 'num_op_inter = <self>') ;
				$this->FltLimitOpInter = $this->InsereFltLgSelectFixe("limitOpInter", 0, 'num_op_inter_dem <> <self>') ;
			}
			protected function ChargeOpInterDem()
			{
				$bd = & $this->ApplicationParent->BDPrincipale ;
				if(! $this->InclureElementEnCours)
				{
					$idEnCours = $this->FltIdEnCours->Lie() ;
					$ligne = $bd->FetchSqlRow('select t1.*, '.$bd->SqlDateToStr('t1.date_operation').' date_operation_str, '.$bd->SqlDateToStr('t1.date_valeur').' date_valeur_str, t3.lib_devise lib_devise1, t4.lib_devise code_devise2, '.$bd->SqlConcat(array('t3.code_devise', "' / '", 't4.code_devise')).' lib_devise, \'\' login_soumis, t6.login login_soumis, \'\' code_entite_soumis, \'\' nom_entite_soumis, t6.login login_dem, t8.code code_entite_dem, t8.name nom_entite_dem from op_inter t1 left join devise t3 on t1.id_devise1 = t3.id_devise left join devise t4 on t1.id_devise2 = t4.id_devise left join operateur t6 on t1.numop = t6.numop left join entite t8 on t6.id_entite = t8.id_entite where t1.num_op_inter='.$bd->ParamPrefix.'idEnCours', array('idEnCours' => $idEnCours)) ;
					if(count($ligne) > 0)
					{
						$flts = array() ;
						$this->LigneOpInterDem = $ligne ;
						foreach($ligne as $nom => $val)
						{
							if(in_array($nom, array("num_op_inter", "montant_soumis", "taux_soumis", "montant_change", "taux_change", "mtt_commiss", "ecran_taux", "date_valeur_str", "date_operation_str")))
							{
								continue ;
							}
							$valLiee = $val ;
							if($nom == "type_change")
								$valLiee = ($valLiee == 1) ? 2 : 1 ;
							elseif($nom == "num_op_inter_dem")
								$valLiee = $ligne["num_op_inter"] ;
							elseif($nom == "numop")
								$valLiee = $this->ZoneParent->IdMembreConnecte() ;
							elseif($nom == "date_valeur")
								$valLiee = $ligne["date_valeur_str"] ;
							elseif($nom == "date_operation")
								$valLiee = $ligne["date_operation_str"] ;
							$flts[$nom] = $this->CreeFiltreFixe($nom, $valLiee) ;
							$nomColLiee = $nom ;
							if($nom == "id_devise1")
							{
								$nomColLiee = "id_devise2" ;
							}
							elseif($nom == "id_devise2")
							{
								$nomColLiee = "id_devise1" ;
							}
							if($nom == "bool_valide")
							{
								$flts[$nom]->ValeurParDefaut = 0 ;
							}
							$flts[$nom]->DefinitColLiee($nomColLiee) ;
							if($nom == "date_valeur" || $nom == "date_operation")
							{
								$flts[$nom]->ExpressionColonneLiee = $bd->SqlStrToDate('<self>') ;
							}
							$this->FiltresEdition[] = & $flts[$nom] ;
						}
						$memberLogged = & $this->ZoneParent->Membership->MemberLogged ;
						$this->FltLoginDem->ValeurParDefaut = $ligne["login_dem"] ;
						$this->FltCodeEntiteDem->ValeurParDefaut = $ligne["code_entite_dem"] ;
						$this->FltNomEntiteDem->ValeurParDefaut = $ligne["nom_entite_dem"] ;
						$this->FltLoginSoumis->ValeurParDefaut = $memberLogged->Login ;
						$this->FltCodeEntiteSoumis->ValeurParDefaut = $memberLogged->RawData["CODE_ENTITE"] ;
						$this->FltNomEntiteSoumis->ValeurParDefaut = $memberLogged->RawData["NOM_ENTITE_MEMBRE"] ;
						$this->FltDevise->ValeurParDefaut = $ligne["lib_devise1"] ;
						$this->FltMontantDem->ValeurParDefaut = $ligne["montant_change"] ;
						$this->FltTauxDem->ValeurParDefaut = $this->ZoneParent->RemplisseurConfig->ObtientValeurTaux($ligne) ;
						$this->FltMontantSoumis->ValeurParDefaut = $this->FltMontantDem->ValeurParDefaut ;
						$this->FltTauxSoumis->ValeurParDefaut = $this->FltTauxDem->ValeurParDefaut ;
						$this->FltRefChange->ValeurParDefaut = $ligne["ref_change"] ;
						$this->ReinitParametres() ;
					}
				}
			}
			protected function ChargeFiltresEdition()
			{
				$this->FltDevise = $this->InsereFltEditHttpPost("lib_devise", "lib_devise") ;
				$this->FltDevise->Libelle = "Devise" ;
				$this->FltDevise->EstEtiquette = 1 ;
				$this->FltLoginDem = $this->InsereFltEditHttpPost("login_dem", "login_dem") ;
				$this->FltLoginDem->Libelle = "Login emetteur" ;
				$this->FltLoginDem->EstEtiquette = 1 ;
				$this->FltCodeEntiteDem = $this->InsereFltEditHttpPost("code_entite_dem", "code_entite_dem") ;
				$this->FltCodeEntiteDem->Libelle = "Code banque emettrice" ;
				$this->FltCodeEntiteDem->EstEtiquette = 1 ;
				$this->FltNomEntiteDem = $this->InsereFltEditHttpPost("nom_entite_dem", "nom_entite_dem") ;
				$this->FltNomEntiteDem->Libelle = "Nom banque emettrice" ;
				$this->FltNomEntiteDem->EstEtiquette = 1 ;
				$this->FltLoginSoumis = $this->InsereFltEditHttpPost("login_soumis", "login_soumis") ;
				$this->FltLoginSoumis->Libelle = "Login" ;
				$this->FltLoginSoumis->EstEtiquette = 1 ;
				$this->FltCodeEntiteSoumis = $this->InsereFltEditHttpPost("nom_entite_soumis", "nom_entite_soumis") ;
				$this->FltCodeEntiteSoumis->Libelle = "Code banque emettrice" ;
				$this->FltCodeEntiteSoumis->EstEtiquette = 1 ;
				$this->FltNomEntiteSoumis = $this->InsereFltEditHttpPost("nom_entite_soumis", "nom_entite_soumis") ;
				$this->FltNomEntiteSoumis->Libelle = "Nom banque emettrice" ;
				$this->FltNomEntiteSoumis->EstEtiquette = 1 ;
				$this->FltMontantDem = $this->InsereFltEditHttpPost("montant_dem", "montant_change") ;
				$this->FltMontantDem->Libelle = "Montant demand&eacute;" ;
				$this->FltTauxDem = $this->InsereFltEditHttpPost("taux_dem", "taux_change") ;
				$this->FltTauxDem->Libelle = "Taux demand&eacute;" ;
				$this->FltMontantSoumis = $this->InsereFltEditHttpPost("montant_soumis", "montant_soumis") ;
				$this->FltMontantSoumis->Libelle = "Montant possible" ;
				$this->FltTauxSoumis = $this->InsereFltEditHttpPost("taux_soumis", "taux_soumis") ;
				$this->FltTauxSoumis->Libelle = "Taux possible" ;
				$this->FltRefChange = $this->InsereFltEditHttpPost("refChange", "ref_change") ;
				$this->FltRefChange->Libelle = "Ref. Change" ;
				$this->FltRefChange->NePasLierColonne = 1 ;
				$this->ChargeOpInterDem() ;
				if($this->InclureElementEnCours)
				{
					$this->FltValideOp = $this->InsereFltEditFixe("bool_valide", 1, "bool_valide") ;
				}
			}
			public function CalculeElementsRendu()
			{
				parent::CalculeElementsRendu() ;
				// print_r($this->FournisseurDonnees->BaseDonnees) ;
			}
			public function RenduDispositif()
			{
				$ok = 1 ;
				if($this->InclureElementEnCours == 0)
					$ok = $this->ReponsePossible() ;
				$ctn = '' ;
				if(! $ok)
				{
					$ctn .= $this->MsgReponseInterdit ;
				}
				else
				{
					$ctn .= parent::RenduDispositif() ;
				}
				// print_r($this->FournisseurDonnees->BaseDonnees) ;
				return $ctn ;
			}
		}
		class FormNegocPlacementTradPlatf extends FormAjustPlacementTradPlatf
		{
			public $InclureElementEnCours = 0 ;
			public $InclureTotalElements = 0 ;
			public $NomClasseCommandeExecuter = "CmdNegocOpInterTradPlatf" ;
			public $FltTypeTaux ;
			public $FltValeurTaux ;
			public $FltEcranTaux ;
			protected function ChargeFiltresEdition()
			{
				parent::ChargeFiltresEdition() ;
				$this->FltTypeTaux = $this->InsereFltEditHttpPost("type_taux", "type_taux") ;
				$this->FltTypeTaux->ValeurParDefaut = 0 ;
				$this->FltValeurTaux = $this->InsereFltEditHttpPost("taux_change", "") ;
				$this->ZoneParent->RemplisseurConfig->AppliqueCompValeurTaux($this->FltValeurTaux) ;
				$this->FltEcranTaux = $this->InsereFltEditHttpPost("ecran_taux", "") ;
				$this->ZoneParent->RemplisseurConfig->AppliqueCompEcranTaux($this->FltEcranTaux) ;
			}
			public function ChargeConfig()
			{
				parent::ChargeConfig() ;
			}
			protected function CreeDessinFltsEdit()
			{
				return new DessinFiltresNegocOpInter() ;
			}
		}
		class FormInteretPlacementTradPlatf extends FormNegocPlacementTradPlatf
		{
			public $InclureElementEnCours = 0 ;
			public $InclureTotalElements = 0 ;
			protected function CreeDessinFltsEdit()
			{
				return new DessinFiltresInteretOpInter() ;
			}
			public function ChargeConfig()
			{
				parent::ChargeConfig() ;
				// $this->FltValideOp->ValeurParDefaut = 0 ;
				$this->NeLiePasParamFiltresEdition() ;
			}
		}
		class FormReponsePlacementTradPlatf extends FormNegocPlacementTradPlatf
		{
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
			public $NomClasseCommandeExecuter = "CmdSupprOpInterTradPlatf" ;
			public $LibelleCommandeExecuter = "Confirmer" ;
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
		class FormAjustEmpruntTradPlatf extends FormAjustPlacementTradPlatf
		{
		}
		class FormNegocEmpruntTradPlatf extends FormNegocPlacementTradPlatf
		{
		}
		class FormInteretEmpruntTradPlatf extends FormNegocPlacementTradPlatf
		{
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
			public $NomClasseCommandeExecuter = "CmdSupprOpInterTradPlatf" ;
			public $LibelleCommandeExecuter = "Confirmer" ;
		}
		
		class TablPlacementsBaseTradPlatf extends TablConsultOpInterTradPlatf
		{
			public $FltTypeMessage ;
			public function ChargeConfig()
			{
				parent::ChargeConfig() ;
				$this->FltTypeMessage = $this->InsereFltSelectFixe('typeMessage', 'demande') ;
				$this->FltTypeMessage->ExpressionDonnees = 'type_message = <self>' ;
			}
		}
		class TablEmpruntsBaseTradPlatf extends TablPlacementsBaseTradPlatf
		{
		}
		
		class ScriptSoumissPlacementTradPlatf extends ScriptListBaseOpInter
		{
			public $TablPrinc ;
			public $TablSecond ;
			public $TypeOpInter = 1 ;
			protected function DetermineTablPrinc()
			{
				$this->TablPrinc = new TablSoumissOpInterTradPlatf() ;
				$this->TablPrinc->AdopteScript("tablPrinc", $this) ;
				$this->TablPrinc->ChargeConfig() ;
			}
			protected function DetermineTablSecond()
			{
				$this->TablSecond = new TablNegocEnvoyOpInterTradPlatf() ;
				$this->TablSecond->AdopteScript("tablSecond", $this) ;
				$this->TablSecond->ChargeConfig() ;
			}
			public function DetermineEnvironnement()
			{
				parent::DetermineEnvironnement() ;
				$this->DetermineTablPrinc() ;
				$this->DetermineTablSecond() ;
			}
			public function RenduSpecifique()
			{
				$ctn = '' ;
				$ctn .= $this->BarreMenu->RenduDispositif() ;
				$ctn .= '<div id="tabs-'.$this->IDInstanceCalc.'">'.PHP_EOL ;
				$ctn .= '<ul>' ;
				$ctn .= '<li><a href="#tab-1-'.$this->IDInstanceCalc.'">Publications</a></li>' ;
				$ctn .= '<li><a href="#tab-2-'.$this->IDInstanceCalc.'">Consultations</a></li>' ;
				$ctn .= '</ul>' ;
				$ctn .= '<div id="tab-1-'.$this->IDInstanceCalc.'">' ;
				$ctn .= $this->TablPrinc->RenduDispositif() ;
				$ctn .= '</div>' ;
				$ctn .= '<div id="tab-2-'.$this->IDInstanceCalc.'">' ;
				$ctn .= $this->TablSecond->RenduDispositif() ;
				$ctn .= '</div>' ;
				$ctn .= '</div>' ;
				$ctn .= $this->ZoneParent->RenduContenuJsInclus('jQuery(function() { jQuery("#tabs-'.$this->IDInstanceCalc.'").tabs({active : '.((isset($_GET[$this->TablSecond->IDInstanceCalc.'_Commande'])) ? 1 : 0).'}) ; } ) ;') ;
				return $ctn ;
			}
		}
		class ScriptModifOpInterSoumisTradPlatf extends ScriptFormTransactBaseTradPlatf
		{
			public $FormPrinc ;
			protected function DetermineFormPrinc()
			{
				$this->FormPrinc = new FormAjustPlacementTradPlatf() ;
				$this->FormPrinc->AdopteScript("formPrinc", $this) ;
				$this->FormPrinc->ChargeConfig() ;
			}
			public function DetermineEnvironnement()
			{
				$this->DetermineFormPrinc() ;
			}
			public function RenduSpecifique()
			{
				$ctn = '' ;
				$ctn .= $this->FormPrinc->RenduDispositif() ;
				return $ctn ;
			}
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
		class ScriptReservPlacementsTradPlatf extends ScriptListePlacementsTradPlatf
		{
			public $Titre = "R&eacute;servations placements" ;
			public $TitreDocument = "R&eacute;servations placements" ;
			protected function CreeTableau()
			{
				return new TablReservOpInterTradPlatf() ;
			}
		}
		class ScriptAjoutPlacementTradPlatf extends ScriptFormTransactBaseTradPlatf
		{
			public $TitreDocument = "Nouveau placement" ;
			public $Titre = "Nouveau placement" ;
			public $FormOpInter ;
			public $NecessiteMembreConnecte = 1 ;
			public $TypeOpInter = 1 ;
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
			public $TitreDocument = "Negociations placement" ;
			public $Titre = "Negociations placement" ;
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
				$this->TablPostuls = new TablPostulsOpInterTradPlatf() ;
				$this->TablPostuls->AdopteScript("tablPostuls", $this) ;
				$this->TablPostuls->ChargeConfig() ;
				$this->FltIdEnCours = $this->TablPostuls->InsereFltSelectHttpGet('idEnCours', 'num_op_inter_dem = <self>') ;
				$this->FltIdEnCours->LectureSeule = 1 ;
				$this->FltIdEnCours->Obligatoire = 1 ;
				$this->TablPostuls->DeclareFournDonneesSql($this->ApplicationParent->BDPrincipale, '('.TXT_SQL_POSTUL_OP_INTER_TRAD_PLATF.')') ;
				$this->TablPostuls->InsereDefColCachee('idEnCours', 'num_op_inter') ;
				$this->TablPostuls->InsereDefColCachee('peut_ajuster', 'peut_ajuster') ;
				$this->TablPostuls->InsereDefCol('loginop', 'Login') ;
				$this->TablPostuls->InsereDefCol('nom_entite', 'Etablissement') ;
				$this->TablPostuls->InsereDefCol('date_operation', 'Date rep.', $this->ApplicationParent->BDPrincipale->SqlDateToStrFr('date_operation')) ;
				$colConfirm = $this->TablPostuls->InsereDefColBool('bool_confirme', 'Confirm&eacute;', '') ;
				$colConfirm->AlignElement = "center" ;
				$colActions = $this->TablPostuls->InsereDefColActions("Actions") ;
				$colActions->Largeur = "*" ;
				// $lienAjuster = $this->TablPostuls->InsereLienAction($colActions, $this->ZoneParent->ScriptAjustEmprunt->ObtientUrl().'&idEnCours=${idEnCours}', 'Ajuster') ;
				$lienAjuster = $this->TablPostuls->InsereLienOuvreFenetreAction($colActions, $this->ZoneParent->ScriptAjustEmprunt->ObtientUrl().'&idEnCours=${idEnCours}', 'N&eacute;gocier', 'ajuster_${idEnCours}', 'N&eacute;gocier', array('Modal' => 1, 'Largeur' => '450', 'Hauteur' => 525, 'BoutonFermer' => 0)) ;
				$lienAjuster->NomDonneesValid = "peut_ajuster" ;
				$lienConfirm = $this->TablPostuls->InsereLienAction($colActions, $this->ZoneParent->ScriptValPostulEmprunt->ObtientUrl().'&id=${idEnCours}', 'Confimer') ;
				$lienConfirm->NomDonneesValid = "peut_ajuster" ;
				// $lienConfirm->Visible = ! $this->EstConfirme() ;
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
		class ScriptInteretPlacementTradPlatf extends ScriptAjoutPlacementTradPlatf
		{
			public $TitreDocument = "N&eacute;gociation placement" ;
			public $Titre = "N&eacute;gociation placement" ;
			protected function CreeFormOpInter()
			{
				return new FormInteretPlacementTradPlatf() ;
				// return new FormAjustPlacementTradPlatf() ;
			}
		}
		class ScriptNegocPlacementTradPlatf extends ScriptAjoutPlacementTradPlatf
		{
			public $TitreDocument = "N&eacute;gociation placement" ;
			public $Titre = "N&eacute;gociation placement" ;
			protected function CreeFormOpInter()
			{
				return new FormNegocPlacementTradPlatf() ;
				// return new FormAjustPlacementTradPlatf() ;
			}
		}
		class ScriptAjustPlacementTradPlatf extends ScriptAjoutPlacementTradPlatf
		{
			public $TitreDocument = "Ajustement placement" ;
			public $Titre = "Ajustement placement" ;
			protected function CreeFormOpInter()
			{
				return new FormAjustPlacementTradPlatf() ;
			}
		}
		class ScriptSupprPlacementTradPlatf extends ScriptAjoutPlacementTradPlatf
		{
			public $TitreDocument = "Suppr. placement" ;
			public $Titre = "Suppr. placement" ;
			public $Description = "Vous vous appr&ecirc;tez &agrave; supprimer cet placement :" ;
			protected function CreeFormOpInter()
			{
				return new FormSupprPlacementTradPlatf() ;
			}
			protected function RenduDispositifBrut()
			{
				$ctn = '' ;
				$ctnForm = parent::RenduDispositifBrut() ;
				if(count($this->FormOpInter->ElementEnCours) > 0 && ! $this->FormOpInter->PossedeCommandeSelectionnee())
					$ctn .= '<p>'.$this->Description.'</p>' ;
				$ctn .= $ctnForm ;
				return $ctn ;
			}
		}
		
		class ScriptSoumissEmpruntTradPlatf extends ScriptSoumissPlacementTradPlatf
		{
			public $TypeOpInter = 2 ;
			public $NomScriptEdit = "editEmprunts" ;
			public $NomScriptReserv = "reservEmprunts" ;
			public $NomScriptSoumiss = "soumissEmprunt" ;
		}
		class ScriptListeEmpruntsTradPlatf extends ScriptListBaseEmprunt
		{
			public $TypeOpInter = 2 ;
			public $Titre = "Liste emprunts" ;
			public $TitreDocument = "Liste emprunts" ;
			protected function CreeTableau()
			{
				return new TablEmpruntsBaseTradPlatf() ;
			}
		}
		class ScriptReservEmpruntsTradPlatf extends ScriptListeEmpruntsTradPlatf
		{
			public $Titre = "R&eacute;servations emprunts" ;
			public $TitreDocument = "R&eacute;servations emprunts" ;
			protected function CreeTableau()
			{
				return new TablReservOpInterTradPlatf() ;
			}
		}
		class ScriptAjoutEmpruntTradPlatf extends ScriptFormTransactBaseTradPlatf
		{
			public $TitreDocument = "Nouvel emprunt" ;
			public $Titre = "Nouvel emprunt" ;
			public $FormOpInter ;
			public $TypeOpInter = 2 ;
			public $NecessiteMembreConnecte = 1 ;
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
			public $TitreDocument = "Negociations emprunt" ;
			public $TypeOpInter = 2 ;
			public $Titre = "Negociations emprunt" ;
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
		class ScriptModifEmpruntSoumisTradPlatf extends ScriptAjoutEmpruntTradPlatf
		{
			public $TypeOpInter = 1 ;
		}
		class ScriptInteretEmpruntTradPlatf extends ScriptAjoutEmpruntTradPlatf
		{
			public $TitreDocument = "Negociation emprunt" ;
			public $Titre = "Negociation emprunt" ;
			protected function CreeFormOpInter()
			{
				return new FormInteretEmpruntTradPlatf() ;
			}
		}
		class ScriptNegocEmpruntTradPlatf extends ScriptAjoutEmpruntTradPlatf
		{
			public $TitreDocument = "Negociation emprunt" ;
			public $Titre = "Negociation emprunt" ;
			protected function CreeFormOpInter()
			{
				return new FormNegocEmpruntTradPlatf() ;
			}
		}
		class ScriptAjustEmpruntTradPlatf extends ScriptAjoutEmpruntTradPlatf
		{
			public $TitreDocument = "Ajustement emprunt" ;
			public $Titre = "Ajustement emprunt" ;
			protected function CreeFormOpInter()
			{
				return new FormAjustEmpruntTradPlatf() ;
			}
		}
		class ScriptSupprEmpruntTradPlatf extends ScriptAjoutEmpruntTradPlatf
		{
			public $TitreDocument = "Suppr. emprunt" ;
			public $Titre = "Suppr. emprunt" ;
			public $Description = "Vous vous appr&ecirc;tez &agrave; supprimer cette emprunt :" ;
			protected function RenduDispositifBrut()
			{
				$ctn = '' ;
				$ctnForm = parent::RenduDispositifBrut() ;
				if(count($this->FormOpInter->ElementEnCours) > 0 && ! $this->FormOpInter->PossedeCommandeSelectionnee())
					$ctn .= '<p>'.$this->Description.'</p>' ;
				$ctn .= $ctnForm ;
				return $ctn ;
			}
			protected function CreeFormOpInter()
			{
				return new FormSupprEmpruntTradPlatf() ;
			}
		}
		
		class ScriptValPostulEmpruntTradPlatf extends ScriptFormTransactBaseTradPlatf
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
					$ctn .= '<script type="text/javascript">
	jQuery(function() {
		if(window.parent.jQuery && window.parent.jQuery("#soumissOpInter iframe").length)
		{
			window.parent.jQuery("#soumissOpInter iframe")[0].contentWindow.location= window.parent.jQuery("#soumissOpInter iframe")[0].contentWindow.location ;
		}
	}) ;
</script>' ;
					$ctn .= '<p><a href="?'.urlencode($this->ZoneParent->NomParamScriptAppele).'='.urlencode($nomScript).'&idEnCours='.urlencode($this->LgnOpInterSelect["num_op_inter_dem"]).'">Retour a la transaction</a></p>' ;
				}
				return $ctn ;
			}
		}
		
		class ScriptConsultEmpruntsTradPlatf extends ScriptListeEmpruntsTradPlatf
		{
			public $NomScriptEdit = "editPlacements" ;
			public $NomScriptReserv = "reservPlacements" ;
			public $NomScriptSoumiss = "soumissPlacement" ;
		}
		class ScriptConsultPlacementsTradPlatf extends ScriptListePlacementsTradPlatf
		{
			public $NomScriptEdit = "editEmprunts" ;
			public $NomScriptReserv = "reservEmprunts" ;
			public $NomScriptSoumiss = "soumissEmprunt" ;
		}
		
		class TablNegocOpInterTradPlatf extends TableauDonneesBaseTradPlatf
		{
			public $DefColTypeTransact ;
			public $DefColId ;
			public $DefColDevise ;
			public $DefColConfirm ;
			public $DefColRefChange ;
			public $DefColLoginOp ;
			public $DefColNomEntiteOp ;
			public $DefColDateOp ;
			public $DefColDateEcheance ;
			public $DefColDateValeur ;
			public $DefColMontant ;
			public $DefColTaux ;
			public $DefColActions ;
			public $LienNegocConsult ;
			public $LienConfirmPubl ;
			public $LienNegocPubl ;
			public $FltNumOp ;
			public $FltConfirme ;
			public function ChargeConfig()
			{
				parent::ChargeConfig() ;
				$this->ChargeDefCols() ;
				$this->ChargeFlts() ;
				$this->ChargeFournDonnees() ;
			}
			protected function ChargeFlts()
			{
				$bd = $this->ApplicationParent->BDPrincipale ;
				$this->FltNumOp = $this->InsereFltSelectFixe('num_operateur', $this->ZoneParent->IdMembreConnecte(), '(id_emetteur=<self> or (id_repondeur=<self> and bool_valide=1))') ;
				$this->FltConfirme = $this->InsereFltSelectFixe('est_confirme', 0, 'bool_confirme=<self>') ;
				$this->FltConfirme->EstObligatoire = 1 ;
			}
			protected function ChargeDefCols()
			{
				$bd = $this->ApplicationParent->BDPrincipale ;
				$this->InsereDefsColCachee("date_change", "num_op_inter", "id_emetteur", "id_devise1", "id_devise2", "lib_devise1", "lib_devise2", "bool_confirme", "bool_valide") ;
				$this->DefColConfirm = $this->InsereDefColCachee('bool_confirme') ;
				$this->DefColRefChange = $this->InsereDefCol('ref_change', 'Ref change') ;
				$this->DefColDevise = $this->InsereDefColHtml('${lib_devise1}', 'Devise') ;
				$this->DefColLoginOp = $this->InsereDefCol('login_operateur', 'Auteur') ;
				$this->DefColNomEntiteOp = $this->InsereDefCol('nom_entite_operateur', 'Banque') ;
				$this->DefColDateOp = $this->InsereDefCol('date_operation', 'Date Op.', $bd->SqlDateToStrFr('date_operation')) ;
				$this->DefColDateValeur = $this->InsereDefCol('date_valeur', 'Date valeur', $bd->SqlDateToStrFr('date_valeur')) ;
				$this->DefColDateEcheance = $this->InsereDefCol('date_operation', 'Date &eacute;ch&eacute;ance', $bd->SqlDateToStrFr('date_echeance')) ;
				$this->DefColMontant = $this->InsereDefColMoney('montant_operateur', 'Montant') ;
				$this->DefColTaux = $this->InsereDefCol('taux_transact', 'Taux') ;
				$this->DefColActions = $this->InsereDefColActions('Actions') ;
				$this->ChargeDefColActions() ;
			}
			protected function ChargeDefColActions()
			{
				// Lien Négociation
				$this->LienNegocConsult = $this->InsereLienOuvreFenetreAction(
					$this->DefColActions,'?appelleScript=modifOpInterSoumis&idEnCours=${num_op_inter}',
					$this->ZoneParent->FournExprs->LibLienAjustNegocOpInter, 'modif_op_inter_soumis_${num_op_inter}',
					$this->ZoneParent->FournExprs->TitrFenAjustNegocOpInter, 
					array('Modal' => 1, 'BoutonFermer' => 0, 'Largeur' => 450, 'Hauteur' => 525)
				) ;
				$this->LienNegocConsult->RafraichOnglActifSurFerm = 1 ;
				// Lien confirmation
				$this->LienConfirmConsult = $this->InsereLienOuvreFenetreAction(
					$this->DefColActions, $this->ZoneParent->ScriptValPostulEmprunt->ObtientUrl().'&id=${num_op_inter}',
					$this->ZoneParent->FournExprs->LibLienConfirmNegoc, 'val_postul_op_inter_soumis_${num_op_inter}',
					$this->ZoneParent->FournExprs->TitrFenAjustNegocOpInter, 
					array('Modal' => 1, 'BoutonFermer' => 0, 'Largeur' => 450, 'Hauteur' => 300)
				) ;
				$this->LienConfirmConsult->DefinitValidite("id_emetteur", $this->ZoneParent->IdMembreConnecte()) ;
			}
			protected function ChargeFournDonnees()
			{
				$bd = $this->ApplicationParent->BDPrincipale ;
				$this->FournisseurDonnees = new PvFournisseurDonneesSql() ;
				$this->FournisseurDonnees->BaseDonnees = $bd ;
				$this->FournisseurDonnees->RequeteSelection = "(
	select d1.code_devise lib_devise1,
		d2.code_devise lib_devise2,
		t1.id_devise1,
		t1.id_devise2,
		case when t1.commiss_ou_taux = 0 then t1.taux_soumis when t1.type_taux = 0 then t1.taux_change else t1.ecran_taux end taux_transact,
		t2.numop id_emetteur,
		t3.login login_emetteur,
		t4.id_entite id_entite_emetteur,
		t4.name nom_entite_emetteur,
		t1.numop id_repondeur,
		e1.login login_repondeur,
		e1.id_entite id_entite_repondeur,
		e2.name nom_entite_repondeur,
		t1.num_op_inter,
		t1.num_op_inter_dem,
		t1.ref_change,
		t1.date_valeur,
		t1.date_echeance,
		t1.date_operation,
		t1.montant_change,
		t1.montant_soumis,
		t1.date_change,
		t1.commiss_ou_taux,
		t1.taux_change,
		t1.taux_soumis,
		t1.ecran_taux,
		t1.bool_valide,
		t1.bool_confirme,
		case when t1.numop = t2.numop then t1.montant_change else t1.montant_soumis end montant_operateur,
		case when t1.numop = t2.numop then t2.numop else e1.numop end id_operateur,
		case when t1.numop = t2.numop then t3.login else e1.login end login_operateur,
		case when t1.numop = t2.numop then t4.name else e2.name end nom_entite_operateur
	from op_inter t1
	inner join op_inter t2 ON t2.num_op_inter = t1.num_op_inter_dem
	inner join operateur t3 ON t3.numop = t2.numop
	inner join entite t4 ON t3.id_entite = t4.id_entite
	inner join operateur e1 ON t1.numop = e1.numop
	inner join entite e2 ON e2.id_entite = e1.id_entite
	left join devise d1 on d1.id_devise = t1.id_devise1
	left join devise d2 on d2.id_devise = t1.id_devise2
)" ;
			}
		}

		class ScriptEditEmpruntsTradPlatf extends ScriptListeEmpruntsTradPlatf
		{
			public $Titre = "Publications emprunts" ;
			public $TitreDocument = "Publications emprunts" ;
			protected function CreeTableau()
			{
				return new TablEditOpInterTradPlatf() ;
			}
		}
		class ScriptEditPlacementsTradPlatf extends ScriptListePlacementsTradPlatf
		{
			public $Titre = "Publication placements" ;
			public $TitreDocument = "Publication placements" ;
			protected function CreeTableau()
			{
				return new TablEditOpInterTradPlatf() ;
			}
		}

		class ScriptSoumissOpInterTradPlatf extends ScriptListBaseOpInter
		{
			protected function DetermineTablPrinc()
			{
				$this->TablPrinc = new TablNegocOpInterTradPlatf() ;
				$this->TablPrinc->AdopteScript("tablPrinc", $this) ;
				$this->TablPrinc->ChargeConfig() ;
			}
			public function DetermineEnvironnement()
			{
				parent::DetermineEnvironnement() ;
				$this->DetermineTablPrinc() ;
			}
			public function RenduSpecifique()
			{
				$ctn = '' ;
				$ctn .= $this->TablPrinc->RenduDispositif() ;
				// print_r($this->TablPrinc->FournisseurDonnees->BaseDonnees) ;
				return $ctn ;
			}

		}
		
		class CritrOpInterDejaPostee extends PvCritereBase
		{
			public $FormatMessageErreur = 'Vous avez d&eacute;j&agrave; post&eacute; cette op&eacute;ration' ;
			public function EstRespecte()
			{
				$montant = $this->FormulaireDonneesParent->FltMontant->Lie() ;
				$id_devise1 = $this->FormulaireDonneesParent->FltDevise1->Lie() ;
				$id_devise2 = $this->FormulaireDonneesParent->FltDevise2->Lie() ;
				$montant = $this->FormulaireDonneesParent->FltMontant->Lie() ;
				$numOp = $this->ZoneParent->Membership->MemberLogged->Id ;
				$bd = & $this->FormulaireDonneesParent->FournisseurDonnees->BaseDonnees ;
				$sql = 'select * from op_inter where numop='.$bd->ParamPrefix.'numOp and montant_change='.$bd->ParamPrefix.'montant and '.$bd->SqlDatePart($bd->SqlNow()).' = '.$bd->SqlDatePart('date_change').' and id_devise1 = '.$bd->ParamPrefix.'id_devise1 and id_devise2 = '.$bd->ParamPrefix.'id_devise2' ;
				$lgn = $bd->FetchSqlRow($sql, array('montant' => $montant, 'id_devise1' => $id_devise1, 'id_devise2' => $id_devise2, 'numOp' => $numOp)) ;
				if(! is_array($lgn) || count($lgn) > 0)
				{
					$this->MessageErreur = $this->FormatMessageErreur ;
					return 0 ;
				}
				return 1 ;
			}
		}
		class CritereEcheanceInvalideOpInter extends PvCritereBase
		{
			public $FormatMessageErreur = 'La date d\'&eacute;ch&eacute;ance ne doit pas &ecirc;tre anterieure &agrave; la date actuelle' ;
			public function EstRespecte()
			{
				$valDateOper = $this->FormulaireDonneesParent->FltDateOper->Lie() ;
				$timestmpJour = date("U", strtotime(date("Y-m-d"))) ;
				$timestmpOper = strtotime($valDateOper) ;
				if($timestmpJour > $timestmpOper)
				{
					$this->MessageErreur = $this->FormatMessageErreur ;
					return 0 ;
				}
				return 1 ;
			}
		}
	}
	
?>
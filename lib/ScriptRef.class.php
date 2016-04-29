<?php
	
	if(! defined('SCRIPT_REF_TRAD_PLATF'))
	{
		if(! defined('FORM_REF_TRAD_PLATF'))
		{
			include dirname(__FILE__)."/FormPubl.class.php" ;
		}
		define('SCRIPT_REF_TRAD_PLATF', 1) ;
		
		define('VW_OP_CHANGE_ACCESSIBLE', '(select `t1`.`num_op_change` AS `num_op_change`,`t1`.`type_change` AS `type_change`,`t1`.`id_ctrl` AS `id_ctrl`,`t1`.`ref_change` AS `ref_change`,`t1`.`montant_change` AS `montant_change`,`t1`.`date_change` AS `date_change`,`t1`.`taux_change` AS `taux_change`,`t1`.`id_devise1` AS `id_devise1`,`t1`.`id_devise2` AS `id_devise2`,`t1`.`numop` AS `numop`,`t1`.`date_valeur` AS `date_valeur`,`t1`.`date_operation` AS `date_operation`,`t1`.`bool_valide` AS `bool_valide`,`t1`.`bool_confirme` AS `bool_confirme`,`t1`.`bool_expire` AS `bool_expire`,`t1`.`num_op_change_dem` AS `num_op_change_dem`,`t1`.`commiss_ou_taux` AS `commiss_ou_taux`,`t1`.`mtt_commiss` AS `mtt_commiss`,`t1`.`date_commiss` AS `date_commiss`,`t1`.`type_taux` AS `type_taux`,`t1`.`ecran_taux` AS `ecran_taux`,`t1`.`commentaire` AS `commentaire`,`t1`.`montant_soumis` AS `montant_soumis`,`t1`.`taux_soumis` AS `taux_soumis`,(case when (`t1`.`commiss_ou_taux` = 0) then `t1`.`mtt_commiss` when (`t1`.`type_taux` = 0) then `t1`.`taux_change` else `t1`.`ecran_taux` end) AS `taux_transact`,`t7`.`shortname` AS `nom_court_entite`,`t7`.`name` AS `nom_entite`,`t2`.`code_devise` AS `lib_devise1`,`t3`.`code_devise` AS `lib_devise2`,`t4`.`login` AS `loginop`,`t4`.`nomop` AS `nomop`,`t4`.`prenomop` AS `prenomop`,`t5`.`id_entite_source` AS `id_entite_source`,`t5`.`id_entite_dest` AS `id_entite_dest`,`t5`.`top_active` AS `top_active`,`t6`.`numop` AS `numrep`,`t6`.`login` AS `loginrep` from ((((((`op_change` `t1` left join `devise` `t2` on((`t1`.`id_devise1` = `t2`.`id_devise`))) left join `devise` `t3` on((`t1`.`id_devise2` = `t3`.`id_devise`))) left join `operateur` `t4` on((`t1`.`numop` = `t4`.`numop`))) left join `oper_b_change` `t5` on((`t5`.`id_entite_source` = `t4`.`id_entite`))) left join `entite` `t7` on((`t5`.`id_entite_source` = `t7`.`id_entite`))) left join `operateur` `t6` on((`t5`.`id_entite_dest` = `t6`.`id_entite`))) where ((`t5`.`id_entite_dest` is not null) and (`t7`.`id_entite` is not null) and (`t6`.`login` is not null) and (`t5`.`top_active` = 1) and (`t4`.`active_op` = 1) and (`t1`.`num_op_change_dem` = 0) and (`t1`.`numop` <> `t6`.`numop`)))') ;
		
		define('VW_OP_INTER_ACCESSIBLE', '(select `t1`.`num_op_inter` AS `num_op_inter`,`t1`.`type_change` AS `type_change`,`t1`.`id_ctrl` AS `id_ctrl`,`t1`.`ref_change` AS `ref_change`,`t1`.`montant_change` AS `montant_change`,`t1`.`date_change` AS `date_change`,`t1`.`taux_change` AS `taux_change`,`t1`.`id_devise1` AS `id_devise1`,`t1`.`id_devise2` AS `id_devise2`,`t1`.`numop` AS `numop`,`t1`.`date_valeur` AS `date_valeur`,`t1`.`date_operation` AS `date_operation`,`t1`.`bool_valide` AS `bool_valide`,`t1`.`bool_confirme` AS `bool_confirme`,`t1`.`bool_expire` AS `bool_expire`,`t1`.`num_op_inter_dem` AS `num_op_inter_dem`,`t1`.`commiss_ou_taux` AS `commiss_ou_taux`,`t1`.`mtt_commiss` AS `mtt_commiss`,`t1`.`date_commiss` AS `date_commiss`,`t1`.`type_taux` AS `type_taux`,`t1`.`ecran_taux` AS `ecran_taux`,`t1`.`commentaire` AS `commentaire`,`t1`.`montant_soumis` AS `montant_soumis`,`t1`.`taux_soumis` AS `taux_soumis`,(case when (`t1`.`commiss_ou_taux` = 0) then `t1`.`mtt_commiss` when (`t1`.`type_taux` = 0) then `t1`.`taux_change` else `t1`.`ecran_taux` end) AS `taux_transact`,`t7`.`shortname` AS `nom_court_entite`,`t7`.`name` AS `nom_entite`,`t2`.`code_devise` AS `lib_devise1`,`t3`.`code_devise` AS `lib_devise2`,`t4`.`login` AS `loginop`,`t4`.`nomop` AS `nomop`,`t4`.`prenomop` AS `prenomop`,`t5`.`id_entite_source` AS `id_entite_source`,`t5`.`id_entite_dest` AS `id_entite_dest`,`t5`.`top_active` AS `top_active`,`t6`.`numop` AS `numrep`,`t6`.`login` AS `loginrep` from ((((((`op_inter` `t1` left join `devise` `t2` on((`t1`.`id_devise1` = `t2`.`id_devise`))) left join `devise` `t3` on((`t1`.`id_devise2` = `t3`.`id_devise`))) left join `operateur` `t4` on((`t1`.`numop` = `t4`.`numop`))) left join `oper_b_change` `t5` on((`t5`.`id_entite_source` = `t4`.`id_entite`))) left join `entite` `t7` on((`t5`.`id_entite_source` = `t7`.`id_entite`))) left join `operateur` `t6` on((`t5`.`id_entite_dest` = `t6`.`id_entite`))) where ((`t5`.`id_entite_dest` is not null) and (`t7`.`id_entite` is not null) and (`t6`.`login` is not null) and (`t5`.`top_active` = 1) and (`t4`.`active_op` = 1) and (`t1`.`num_op_inter_dem` = 0) and (`t1`.`numop` <> `t6`.`numop`)))') ;
		
		class ActAlerteNouvPublBaseTradPlatf extends PvActionBaseZoneWebSimple
		{
			public $Resultat ;
			protected function CalculeResultat()
			{
			}
			protected function AfficheResultat()
			{
				// Header("Content-type:text/json; charset=utf-8") ;
				echo svc_json_encode($this->Resultat) ;
				exit ;
			}
			public function Execute()
			{
				$this->CalculeResultat() ;
				$this->AfficheResultat() ;
			}
			protected function ObtientBD()
			{
				return $this->ZoneParent->ApplicationParent->BDPrincipale ;
			}
		}
		class ActAlerteNouvAchatDeviseTradPlatf extends ActAlerteNouvPublBaseTradPlatf
		{
			public $TypeChange = 1 ;
			protected function CalculeResultat()
			{
				$bd = $this->ObtientBD() ;
				$this->Resultat = -1 ;
				$lgn = $bd->FetchSqlRow("select count(0) total from vw_op_change_accessible t1
left join accuse_op_change t2
on t1.num_op_change = t2.num_op_change
where t2.num_op_change is null and numrep=:numOp and t1.type_change=".$this->TypeChange, array("numOp" => $this->ZoneParent->IdMembreConnecte())) ;
				if(is_array($lgn))
				{
					$this->Resultat = $lgn["total"] ;
				}
			}
		}
		class ActAlerteNouvVenteDeviseTradPlatf extends ActAlerteNouvAchatDeviseTradPlatf
		{
			public $TypeChange = 2 ;
		}
		
		class ActAlerteTransactsTradPlatf extends ActAlerteNouvPublBaseTradPlatf
		{
			public $ReqsAlerte = array() ;
			public function ObtientResulat()
			{
				$this->CalculeReqs() ;
				$bd = $this->ObtientBD() ;
				$resultat = new stdClass ;
				$this->CalculeReqs() ;
				$sql = '' ;
				foreach($this->ReqsAlerte as $nomReq => $reqAlerte)
				{
					if($sql != '')
						$sql .= ' union ' ;
					$sql .= $reqAlerte->Contenu ;
				}
				$lgns = $bd->FetchSqlRows($sql, array("numOp" => $this->ZoneParent->IdMembreConnecte())) ;
				// echo '/* '.$this->ZoneParent->IdMembreConnecte().' */' ;
				foreach($lgns as $i => $lgn)
				{
					$idReq = $lgn["id_req"] ;
					$resultat->$idReq = $lgn["total"] ;
				}
				return $resultat ;
			}
			protected function CalculeReqs()
			{
				$this->ZoneParent->ArchiveAncTransacts() ;
				$this->ReqsAlerte["negoc_op_change"] = new ReqAlerteTradPlatf("select 'negoc_op_change' id_req, t1.total + t2.total total from 
(
	select 1 cle, count(0) total from (
		select t1.*, t2.numop numop_dem
		from op_change t1
		inner join op_change t2 on t1.num_op_change_dem = t2.num_op_change
		where t1.num_op_change_dem <> 0 and t1.bool_confirme=0
	) t1
	left join (select * from accuse_op_change) t2
	on t1.num_op_change = t2.num_op_change and t1.numop = t2.numop
	where t2.num_op_change is null and t1.numop=:numOp
) t1
inner join
(
	select 1 cle, count(0) total from (
		select t1.*, t2.numop numop_dem
		from op_change t1
		inner join op_change t2 on t1.num_op_change_dem = t2.num_op_change
		where t1.num_op_change_dem <> 0 and t1.bool_confirme=0
	) t1
	left join (select * from accuse_op_change) t2
	on t1.num_op_change = t2.num_op_change and t1.numop_dem = t2.numop
	where t2.num_op_change is null and t1.numop_dem=:numOp
) t2
on t1.cle = t2.cle", array("numOp" => $this->ZoneParent->IdMembreConnecte())) ;
				$this->ReqsAlerte["negoc_op_inter"] = new ReqAlerteTradPlatf("select 'negoc_op_inter' id_req, t1.total + t2.total total from 
(
	select 1 cle, count(0) total from (
		select t1.*, t2.numop numop_dem
		from op_inter t1
		inner join op_inter t2 on t1.num_op_inter_dem = t2.num_op_inter
		where t1.num_op_inter_dem <> 0 and t1.bool_confirme=0
	) t1
	left join (select * from accuse_op_inter) t2
	on t1.num_op_inter = t2.num_op_inter and t1.numop = t2.numop
	where t2.num_op_inter is null and t1.numop=:numOp
) t1
inner join
(
	select 1 cle, count(0) total from (
		select t1.*, t2.numop numop_dem
		from op_inter t1
		inner join op_inter t2 on t1.num_op_inter_dem = t2.num_op_inter
		where t1.num_op_inter_dem <> 0 and t1.bool_confirme=0
	) t1
	left join (select * from accuse_op_inter) t2
	on t1.num_op_inter = t2.num_op_inter and t1.numop_dem = t2.numop
	where t2.num_op_inter is null and t1.numop_dem=:numOp
) t2
on t1.cle = t2.cle", array("numOp" => $this->ZoneParent->IdMembreConnecte())) ;
				$this->ReqsAlerte["achat_devise"] = new ReqAlerteTradPlatf("select 'achat_devise' id_req, count(0) total from ".VW_OP_CHANGE_ACCESSIBLE." t1
left join accuse_op_change t2
on t1.num_op_change = t2.num_op_change
where t2.num_op_change is null and numrep=:numOp and t1.type_change=1", array("numOp" => $this->ZoneParent->IdMembreConnecte())) ;
				$this->ReqsAlerte["vente_devise"] = new ReqAlerteTradPlatf("select 'vente_devise' id_req, count(0) total from ".VW_OP_CHANGE_ACCESSIBLE." t1
left join accuse_op_change t2
on t1.num_op_change = t2.num_op_change
where t2.num_op_change is null and numrep=:numOp and t1.type_change=2", array("numOp" => $this->ZoneParent->IdMembreConnecte())) ;
				$this->ReqsAlerte["placement"] = new ReqAlerteTradPlatf("select 'placement' id_req, count(0) total from ".VW_OP_INTER_ACCESSIBLE." t1
left join accuse_op_inter t2
on t1.num_op_inter = t2.num_op_inter
where t2.num_op_inter is null and numrep=:numOp and t1.type_change=1", array("numOp" => $this->ZoneParent->IdMembreConnecte())) ;
				$this->ReqsAlerte["emprunt"] = new ReqAlerteTradPlatf("select 'emprunt' id_req, count(0) total from ".VW_OP_INTER_ACCESSIBLE." t1
left join accuse_op_inter t2
on t1.num_op_inter = t2.num_op_inter
where t2.num_op_inter is null and numrep=:numOp and t1.type_change=2", array("numOp" => $this->ZoneParent->IdMembreConnecte())) ;
			}
			protected function CalculeResultat()
			{
				$this->Resultat = $this->ObtientResulat() ;
			}
		}
		class ReqAlerteTradPlatf
		{
			public $Contenu ;
			public $Params = array() ;
			public function __construct($contenu, $params=array())
			{
				$this->Contenu = $contenu ;
				$this->Params = $params ;
			}
		}
		
		class ScriptListeTypesEntiteTradPlatf extends PvScriptWebSimple
		{
			public $TitreDocument = "Liste des types d'entit&eacute;" ;
			public $Titre = "Liste des types d'entit&eacute;" ;
			public $TablTypesEntites ;
			public $NecessiteMembreConnecte = 1 ;
			public $Privileges = array('admin_members') ;
			public function DetermineEnvironnement()
			{
				// Création du tableau
				$this->TablTypesEntites = new TableauDonneesBaseTradPlatf() ;
				// Initialisation des propriétés
				$this->TablTypesEntites->AdopteScript("tableTypes", $this) ;
				$this->TablTypesEntites->Largeur = "600" ;
				$this->ChargeConfig() ;
				// Renseigner la source de données
				$this->TablTypesEntites->FournisseurDonnees = new PvFournisseurDonneesSql() ;
				$this->TablTypesEntites->FournisseurDonnees->BaseDonnees = $this->ApplicationParent->BDPrincipale ;
				// Requête de sélection
				$this->TablTypesEntites->FournisseurDonnees->RequeteSelection = "type_entite" ;
				// Définition des colonnes
				$col = new PvDefinitionColonneDonnees() ;
				$col->NomDonnees = "idtype_entite" ;
				$col->Libelle = "ID" ;
				$this->TablTypesEntites->DefinitionsColonnes[] = $col ;
				$col = new PvDefinitionColonneDonnees() ;
				$col->NomDonnees = "lib_type_entite" ;
				$col->Libelle = "Libelle" ;
				$this->TablTypesEntites->DefinitionsColonnes[] = $col ;
				$optsOnglet = array("Hauteur" => "200", 'Modal' => 1, 'BoutonFermer' => 0) ;
				$colActs = $this->TablTypesEntites->InsereDefColActions("Actions") ;
				$lienModif = $this->TablTypesEntites->InsereLienOuvreFenetreAction($colActs, '?appelleScript=modifTypeEntite&idEnCours=${idtype_entite}', 'Modifier', 'modif_type_entite_${idtype_entite}', 'Modifier type entite', $optsOnglet) ;
				$lienModif->ClasseCSS = "lien-act-001" ;
				/*
				$lienSuppr = $this->TablTypesEntites->InsereLienOuvreFenetreAction($colActs, '?appelleScript=supprTypeEntite&idEnCours=${idtype_entite}', 'Supprimer', 'suppr_type_entite_${idtype_entite}', 'Supprimer type entite', $optsOnglet) ;
				$lienSuppr->ClasseCSS = "lien-act-002" ;
				*/
				$this->TablTypesEntites->InsereCmdOuvreFenetreScript("cmdAjoutTypeEntite", "?appelleScript=ajoutTypeEntite", "Ajouter", "ajout_type_entite", "Ajouter type entite", $optsOnglet) ;
			}
			public function RenduSpecifique()
			{
				$ctn = '' ;
				$ctn .= $this->TablTypesEntites->RenduDispositif() ;
				return $ctn ;
			}
		}
		class ScriptAjoutTypeEntiteTradPlatf extends PvFormulaireAjoutDonneesSimple
		{
			public $TitreDocument = "Ajout de type d'entit&eacute;" ;
			public $Titre = "Ajout de type d'entit&eacute;" ;
			public $NecessiteMembreConnecte = 1 ;
			public $Privileges = array('admin_members') ;
			public function DetermineEnvironnement()
			{
				parent::DetermineEnvironnement() ;
				$this->ZoneParent->RemplisseurConfig->AppliqueFormTypeEntite($this->ComposantFormulaireDonnees) ;
			}
		}
		class ScriptModifTypeEntiteTradPlatf extends PvFormulaireModifDonneesSimple
		{
			public $TitreDocument = "Modif. de type d'entit&eacute;" ;
			public $Titre = "Modif. de type d'entit&eacute;" ;
			public $NecessiteMembreConnecte = 1 ;
			public $Privileges = array('admin_members') ;
			public function DetermineEnvironnement()
			{
				parent::DetermineEnvironnement() ;
				$this->ZoneParent->RemplisseurConfig->AppliqueFormTypeEntite($this->ComposantFormulaireDonnees) ;
			}
		}
		class ScriptSupprTypeEntiteTradPlatf extends PvFormulaireSupprDonneesSimple
		{
			public $TitreDocument = "Suppr. de type d'entit&eacute;" ;
			public $Titre = "Suppr. de type d'entit&eacute;" ;
			public $NecessiteMembreConnecte = 1 ;
			public $Privileges = array('admin_members') ;
			public function DetermineEnvironnement()
			{
				parent::DetermineEnvironnement() ;
				$this->ZoneParent->RemplisseurConfig->AppliqueFormTypeEntite($this->ComposantFormulaireDonnees) ;
			}
		}
		
		class ScriptListeMeresEntiteTradPlatf extends PvScriptWebSimple
		{
			public $TitreDocument = "Liste des types d'entit&eacute;" ;
			public $Titre = "Liste des types d'entit&eacute;" ;
			public $TablTypesEntites ;
			public $NecessiteMembreConnecte = 1 ;
			public $Privileges = array('admin_members') ;
			public function DetermineEnvironnement()
			{
				// Création du tableau
				$this->TablTypesEntites = new TableauDonneesBaseTradPlatf() ;
				// Initialisation des propriétés
				$this->TablTypesEntites->AdopteScript("tableTypes", $this) ;
				$this->TablTypesEntites->Largeur = "600" ;
				$this->ChargeConfig() ;
				// Renseigner la source de données
				$this->TablTypesEntites->FournisseurDonnees = new PvFournisseurDonneesSql() ;
				$this->TablTypesEntites->FournisseurDonnees->BaseDonnees = $this->ApplicationParent->BDPrincipale ;
				// Requête de sélection
				$this->TablTypesEntites->FournisseurDonnees->RequeteSelection = "mere_entite" ;
				// Définition des colonnes
				$col = new PvDefinitionColonneDonnees() ;
				$col->NomDonnees = "id" ;
				$col->Libelle = "ID" ;
				$this->TablTypesEntites->DefinitionsColonnes[] = $col ;
				$col = new PvDefinitionColonneDonnees() ;
				$col->NomDonnees = "libelle" ;
				$col->Libelle = "Libelle" ;
				$this->TablTypesEntites->DefinitionsColonnes[] = $col ;
				$optsOnglet = array("Hauteur" => "200", 'Modal' => 1, 'BoutonFermer' => 0) ;
				$colActs = $this->TablTypesEntites->InsereDefColActions("Actions") ;
				$lienModif = $this->TablTypesEntites->InsereLienOuvreFenetreAction($colActs, '?appelleScript=modifMereEntite&idEnCours=${id}', 'Modifier', 'modif_mere_entite_${id}', 'Modifier m&egrave;re entite', $optsOnglet) ;
				$lienModif->ClasseCSS = "lien-act-001" ;
				/*
				$lienSuppr = $this->TablTypesEntites->InsereLienOuvreFenetreAction($colActs, '?appelleScript=supprMereEntite&idEnCours=${idmere_entite}', 'Supprimer', 'suppr_mere_entite_${idmere_entite}', 'Supprimer type entite', $optsOnglet) ;
				$lienSuppr->ClasseCSS = "lien-act-002" ;
				*/
				$this->TablTypesEntites->InsereCmdOuvreFenetreScript("cmdAjoutMereEntite", "?appelleScript=ajoutMereEntite", "Ajouter", "ajout_mere_entite", "Ajouter m&egrave;re entite", $optsOnglet) ;
			}
			public function RenduSpecifique()
			{
				$ctn = '' ;
				$ctn .= $this->TablTypesEntites->RenduDispositif() ;
				return $ctn ;
			}
		}
		class ScriptAjoutMereEntiteTradPlatf extends PvFormulaireAjoutDonneesSimple
		{
			public $TitreDocument = "Ajout de m&egrave;re d'entit&eacute;" ;
			public $Titre = "Ajout de m&egrave;re d'entit&eacute;" ;
			public $NecessiteMembreConnecte = 1 ;
			public $Privileges = array('admin_members') ;
			public function DetermineEnvironnement()
			{
				parent::DetermineEnvironnement() ;
				$this->ZoneParent->RemplisseurConfig->AppliqueFormMereEntite($this->ComposantFormulaireDonnees) ;
			}
		}
		class ScriptModifMereEntiteTradPlatf extends PvFormulaireModifDonneesSimple
		{
			public $TitreDocument = "Modif. de m&egrave;re d'entit&eacute;" ;
			public $Titre = "Modif. de m&egrave;re d'entit&eacute;" ;
			public $NecessiteMembreConnecte = 1 ;
			public $Privileges = array('admin_members') ;
			public function DetermineEnvironnement()
			{
				parent::DetermineEnvironnement() ;
				$this->ZoneParent->RemplisseurConfig->AppliqueFormMereEntite($this->ComposantFormulaireDonnees) ;
			}
		}
		class ScriptSupprMereEntiteTradPlatf extends PvFormulaireSupprDonneesSimple
		{
			public $TitreDocument = "Suppr. de m&egrave;re d'entit&eacute;" ;
			public $Titre = "Suppr. de m&egrave;re d'entit&eacute;" ;
			public $NecessiteMembreConnecte = 1 ;
			public $Privileges = array('admin_members') ;
			public function DetermineEnvironnement()
			{
				parent::DetermineEnvironnement() ;
				$this->ZoneParent->RemplisseurConfig->AppliqueFormMereEntite($this->ComposantFormulaireDonnees) ;
			}
		}
		
		class ScriptListeDevisesTradPlatf extends PvScriptWebSimple
		{
			public $TitreDocument = "Liste des devises" ;
			public $Titre = "Liste des devises" ;
			public $TablPrinc ;
			public $NecessiteMembreConnecte = 1 ;
			public $Privileges = array('admin_members') ;
			public function DetermineEnvironnement()
			{
				// Création du tableau
				$this->TablPrinc = new TableauDonneesBaseTradPlatf() ;
				// Initialisation des propriétés
				$this->TablPrinc->AdopteScript("tablePrinc", $this) ;
				$this->TablPrinc->Largeur = "600" ;
				$this->ChargeConfig() ;
				// Renseigner la source de données
				$this->TablPrinc->FournisseurDonnees = new PvFournisseurDonneesSql() ;
				$this->TablPrinc->FournisseurDonnees->BaseDonnees = $this->ApplicationParent->BDPrincipale ;
				// Requête de sélection
				$this->TablPrinc->FournisseurDonnees->RequeteSelection = "devise" ;
				$optsOnglet = array("Hauteur" => "300", 'Modal' => 1, 'BoutonFermer' => 0) ;
				$this->TablPrinc->InsereDefColCachee("id_devise") ;
				$defCol1 = $this->TablPrinc->InsereDefCol("code_devise", "Code") ;
				$defCol1->Largeur = "25%" ;
				$defCol2 = $this->TablPrinc->InsereDefCol("lib_devise", "Libelle") ;
				$defCol2->Largeur = "40%" ;
				$colActs = $this->TablPrinc->InsereDefColActions("Actions") ;
				$colActs->Largeur = "*" ;
				$lienModif = $this->TablPrinc->InsereLienOuvreFenetreAction($colActs, '?appelleScript=modifDevise&idEnCours=${id_devise}', 'Modifier', 'modif_devise_${id_devise}', 'Modifier devise', $optsOnglet) ;
				$lienModif->ClasseCSS = "lien-act-001" ;
				$lienSuppr = $this->TablPrinc->InsereLienOuvreFenetreAction($colActs, '?appelleScript=supprDevise&idEnCours=${id_devise}', 'Supprimer', 'suppr_devise_${id_devise}', 'Supprimer devise', $optsOnglet) ;
				$lienSuppr->ClasseCSS = "lien-act-002" ;
				$this->TablPrinc->InsereCmdOuvreFenetreScript("cmdAjoutDevise", "?appelleScript=ajoutDevise", "Ajouter", "ajout_devise", "Ajouter devise", $optsOnglet) ;
			}
			public function RenduSpecifique()
			{
				$ctn = '' ;
				$ctn .= $this->TablPrinc->RenduDispositif() ;
				return $ctn ;
			}
		}
		class ScriptAjoutDeviseTradPlatf extends PvFormulaireAjoutDonneesSimple
		{
			public $TitreDocument = "Ajouter une devise" ;
			public $Titre = "Ajouter une devise" ;
			public $NecessiteMembreConnecte = 1 ;
			public $Privileges = array('admin_members') ;
			public function DetermineEnvironnement()
			{
				parent::DetermineEnvironnement() ;
				$this->ZoneParent->RemplisseurConfig->AppliqueFormDevise($this->ComposantFormulaireDonnees) ;
			}
		}
		class ScriptModifDeviseTradPlatf extends PvFormulaireModifDonneesSimple
		{
			public $TitreDocument = "Modif. une devise" ;
			public $Titre = "Modif. une devise" ;
			public $NecessiteMembreConnecte = 1 ;
			public $Privileges = array('admin_members') ;
			public function DetermineEnvironnement()
			{
				parent::DetermineEnvironnement() ;
				$this->ZoneParent->RemplisseurConfig->AppliqueFormDevise($this->ComposantFormulaireDonnees) ;
			}
		}
		class ScriptSupprDeviseTradPlatf extends PvFormulaireSupprDonneesSimple
		{
			public $TitreDocument = "Suppr. une devise" ;
			public $Titre = "Suppr. une devise" ;
			public $NecessiteMembreConnecte = 1 ;
			public $Privileges = array('admin_members') ;
			public function DetermineEnvironnement()
			{
				parent::DetermineEnvironnement() ;
				$this->ZoneParent->RemplisseurConfig->AppliqueFormDevise($this->ComposantFormulaireDonnees) ;
			}
		}
		
		class ScriptListePaysTradPlatf extends PvScriptWebSimple
		{
			public $TitreDocument = "Liste des pays" ;
			public $Titre = "Liste des pays" ;
			public $TablPrinc ;
			public $NecessiteMembreConnecte = 1 ;
			public $Privileges = array('admin_members') ;
			public function DetermineEnvironnement()
			{
				// Création du tableau
				$this->TablPrinc = new TableauDonneesBaseTradPlatf() ;
				// Initialisation des propriétés
				$this->TablPrinc->AdopteScript("tablePrinc", $this) ;
				$this->TablPrinc->Largeur = "600" ;
				$this->ChargeConfig() ;
				// Renseigner la source de données
				$this->TablPrinc->FournisseurDonnees = new PvFournisseurDonneesSql() ;
				$this->TablPrinc->FournisseurDonnees->BaseDonnees = $this->ApplicationParent->BDPrincipale ;
				// Requête de sélection
				$this->TablPrinc->FournisseurDonnees->RequeteSelection = "(select t1.*, t2.libelle libelle_region from pays t1 left join region_pays t2 on t1.id_region = t2.id)" ;
				$optsOnglet = array("Hauteur" => "300", 'Modal' => 1, 'BoutonFermer' => 0) ;
				$this->TablPrinc->InsereDefColCachee("idpays") ;
				$defCol1 = $this->TablPrinc->InsereDefCol("codepays", "Code") ;
				$defCol1->Largeur = "20%" ;
				$defCol2 = $this->TablPrinc->InsereDefCol("libpays", "Libelle") ;
				$defCol2->Largeur = "30%" ;
				$defCol3 = $this->TablPrinc->InsereDefCol("libelle_region", "Zone") ;
				$defCol3->Largeur = "30%" ;
				$colActs = $this->TablPrinc->InsereDefColActions("Actions") ;
				$colActs->Largeur = "*" ;
				$lienModif = $this->TablPrinc->InsereLienOuvreFenetreAction($colActs, '?appelleScript=modifPays&idEnCours=${idpays}', 'Modifier', 'modif_pays_${idpays}', 'Modifier pays', $optsOnglet) ;
				$lienModif->ClasseCSS = "lien-act-001" ;
				$lienSuppr = $this->TablPrinc->InsereLienOuvreFenetreAction($colActs, '?appelleScript=supprPays&idEnCours=${idpays}', 'Supprimer', 'suppr_pays_${idpays}', 'Supprimer pays', $optsOnglet) ;
				$lienSuppr->ClasseCSS = "lien-act-002" ;
				$this->TablPrinc->InsereCmdOuvreFenetreScript("cmdAjoutPays", "?appelleScript=ajoutPays", "Ajouter", "ajout_pays", "Ajouter pays", $optsOnglet) ;
			}
			public function RenduSpecifique()
			{
				$ctn = '' ;
				$ctn .= $this->TablPrinc->RenduDispositif() ;
				return $ctn ;
			}
		}
		class ScriptAjoutPaysTradPlatf extends PvFormulaireAjoutDonneesSimple
		{
			public $TitreDocument = "Ajouter un pays" ;
			public $Titre = "Ajouter un pays" ;
			public $NecessiteMembreConnecte = 1 ;
			public $Privileges = array('admin_members') ;
			public function DetermineEnvironnement()
			{
				parent::DetermineEnvironnement() ;
				$this->ZoneParent->RemplisseurConfig->AppliqueFormPays($this->ComposantFormulaireDonnees) ;
			}
		}
		class ScriptModifPaysTradPlatf extends PvFormulaireModifDonneesSimple
		{
			public $TitreDocument = "Modif. un pays" ;
			public $Titre = "Modif. un pays" ;
			public $NecessiteMembreConnecte = 1 ;
			public $Privileges = array('admin_members') ;
			public function DetermineEnvironnement()
			{
				parent::DetermineEnvironnement() ;
				$this->ZoneParent->RemplisseurConfig->AppliqueFormPays($this->ComposantFormulaireDonnees) ;
			}
		}
		class ScriptSupprPaysTradPlatf extends PvFormulaireSupprDonneesSimple
		{
			public $TitreDocument = "Suppr. un pays" ;
			public $Titre = "Suppr. un pays" ;
			public $NecessiteMembreConnecte = 1 ;
			public $Privileges = array('admin_members') ;
			public function DetermineEnvironnement()
			{
				parent::DetermineEnvironnement() ;
				$this->ZoneParent->RemplisseurConfig->AppliqueFormPays($this->ComposantFormulaireDonnees) ;
			}
		}
		
		class ScriptListeZonesPaysTradPlatf extends PvScriptWebSimple
		{
			public $TitreDocument = "Liste des zones de pays" ;
			public $Titre = "Liste des zones de pays" ;
			public $TablPrinc ;
			public $NecessiteMembreConnecte = 1 ;
			public $Privileges = array('admin_members') ;
			public function DetermineEnvironnement()
			{
				// Création du tableau
				$this->TablPrinc = new TableauDonneesBaseTradPlatf() ;
				// Initialisation des propriétés
				$this->TablPrinc->AdopteScript("tablePrinc", $this) ;
				$this->TablPrinc->Largeur = "600" ;
				$this->ChargeConfig() ;
				// Renseigner la source de données
				$this->TablPrinc->FournisseurDonnees = new PvFournisseurDonneesSql() ;
				$this->TablPrinc->FournisseurDonnees->BaseDonnees = $this->ApplicationParent->BDPrincipale ;
				// Requête de sélection
				$this->TablPrinc->FournisseurDonnees->RequeteSelection = "region_pays" ;
				$optsOnglet = array("Hauteur" => "150", 'Modal' => 1, "BoutonFermer" => 0) ;
				$this->TablPrinc->InsereDefColCachee("id") ;
				$defCol1 = $this->TablPrinc->InsereDefCol("libelle", "Libell&eacute;") ;
				$defCol1->Largeur = "60%" ;
				$colActs = $this->TablPrinc->InsereDefColActions("Actions") ;
				$colActs->Largeur = "*" ;
				$lienModif = $this->TablPrinc->InsereLienOuvreFenetreAction($colActs, '?appelleScript=modifZonePays&idEnCours=${id}', 'Modifier', 'modif_zone_devise_${id}', 'Modifier zone de pays', $optsOnglet) ;
				$lienModif->ClasseCSS = "lien-act-001" ;
				/*
				$lienSuppr = $this->TablPrinc->InsereLienOuvreFenetreAction($colActs, '?appelleScript=supprZonePays&idEnCours=${id}', 'Supprimer', 'suppr_region_pays_${id}', 'Supprimer zone de pays', $optsOnglet) ;
				$lienSuppr->ClasseCSS = "lien-act-002" ;
				*/
				$this->TablPrinc->InsereCmdOuvreFenetreScript("cmdAjoutZonePays", "?appelleScript=ajoutZonePays", "Ajouter", "ajout_region_pays", "Ajouter zone de pays", $optsOnglet) ;
			}
			public function RenduSpecifique()
			{
				$ctn = '' ;
				$ctn .= $this->TablPrinc->RenduDispositif() ;
				return $ctn ;
			}
		}
		class ScriptAjoutZonePaysTradPlatf extends PvFormulaireAjoutDonneesSimple
		{
			public $TitreDocument = "Ajouter une zone de pays" ;
			public $Titre = "Ajouter une zone de pays" ;
			public $NecessiteMembreConnecte = 1 ;
			public $Privileges = array('admin_members') ;
			public function DetermineEnvironnement()
			{
				parent::DetermineEnvironnement() ;
				$this->ZoneParent->RemplisseurConfig->AppliqueFormZonePays($this->ComposantFormulaireDonnees) ;
			}
		}
		class ScriptModifZonePaysTradPlatf extends PvFormulaireModifDonneesSimple
		{
			public $TitreDocument = "Modif. une zone de pays" ;
			public $Titre = "Modif. une zone de pays" ;
			public $NecessiteMembreConnecte = 1 ;
			public $Privileges = array('admin_members') ;
			public function DetermineEnvironnement()
			{
				parent::DetermineEnvironnement() ;
				$this->ZoneParent->RemplisseurConfig->AppliqueFormZonePays($this->ComposantFormulaireDonnees) ;
			}
		}
		class ScriptSupprZonePaysTradPlatf extends PvFormulaireSupprDonneesSimple
		{
			public $TitreDocument = "Suppr. une zone de pays" ;
			public $Titre = "Suppr. une zone de pays" ;
			public $NecessiteMembreConnecte = 1 ;
			public $Privileges = array('admin_members') ;
			public function DetermineEnvironnement()
			{
				parent::DetermineEnvironnement() ;
				$this->ZoneParent->RemplisseurConfig->AppliqueFormZonePays($this->ComposantFormulaireDonnees) ;
			}
		}
		
		class ScriptAccueilStatsTradPlatf extends PvScriptWebSimple
		{
			public $NecessiteMembreConnecte = 1 ;
			public $Titre = "Statistiques" ;
		}
		class CfgAlerteTransactTradPlatf
		{
			public $Nom ;
			public $FormatMsg ;
			public $NomScript ;
			public function __construct($nom='', $formatMsg='', $nomScript='')
			{
				$this->Nom = $nom ;
				$this->FormatMsg = $formatMsg ;
				$this->NomScript = $nomScript ;
			}
		}
		class ScriptListeAlerteTransactsTradPlatf extends PvScriptWebSimple
		{
			public $NecessiteMembreConnecte = 1 ;
			protected $CfgsAlerte = array() ;
			public function ChargeConfig()
			{
				$this->ChargeCfgsAlerte() ;
			}
			protected function ChargeCfgsAlerte()
			{
				$this->CfgsAlerte["achat_devise"] = new CfgAlerteTransactTradPlatf("achat_devise", "Vous avez \${0} achat de devises non lus", "consultAchatsDevise") ;
				$this->CfgsAlerte["vente_devise"] = new CfgAlerteTransactTradPlatf("vente_devise", "Vous avez \${0} vente de devises non lues", "consultVentesDevise") ;
				$this->CfgsAlerte["placement"] = new CfgAlerteTransactTradPlatf("placement", "Vous avez \${0} placements non lus", "consultPlacements") ;
				$this->CfgsAlerte["emprunt"] = new CfgAlerteTransactTradPlatf("emprunt", "Vous avez \${0} emprunts non lus", "consultEmprunts") ;
				$this->CfgsAlerte["negoc_op_change"] = new CfgAlerteTransactTradPlatf("emprunt", "Vous avez \${0} n&eacute;gociations de change non lues", "soumissOpChange") ;
				$this->CfgsAlerte["negoc_op_inter"] = new CfgAlerteTransactTradPlatf("negoc_op_inter", "Vous avez \${0} n&eacute;gociations internationales non lues", "soumissOpInter") ;
			}
			public function RenduSpecifique()
			{
				$ctn = '' ;
				$alerteTransacts = $this->ZoneParent->ActAlerteTransacts->ObtientResulat() ;
				$ctn .= '<div class="ui-widget">'.PHP_EOL ;
				$alerteTrouvee = 0 ;
				// $ctn .= '<div class="ui-widget ui-widget-header">Alertes</div>'.PHP_EOL ;
				foreach($alerteTransacts as $i => $total)
				{
					$alerte = $this->CfgsAlerte[$i] ;
					if($total > 0)
					{
						$ctn .= '<div class="ui-widget ui-widget-content ui-state-active">'.PHP_EOL ;
						$ctn .= '<a href="javascript:parent.'.htmlentities($this->ZoneParent->ContenuJsOuvreOngletScript($alerte->NomScript)).';">'._parse_pattern($alerte->FormatMsg, array($total)).'</a>'.PHP_EOL ;
						$ctn .= '</div>'.PHP_EOL ;
						$alerteTrouvee = 1 ;
					}
				}
				if(! $alerteTrouvee)
				{
					$ctn .= '<div class="ui-widget ui-widget-content">-- Aucune alerte trouv&eacute;e --</div>'.PHP_EOL ;
				}
				$ctn .= '</div>' ;
				// $ctn .= $sess->GetUrl($this->ZoneParent->ActAlerteTransacts->ObtientUrl()) ;
				/*
				*/
				return $ctn ;
			}
		}
	}
	
?>
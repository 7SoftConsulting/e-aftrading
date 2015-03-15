<?php
	
	if(! defined('FORM_PUBL_TRAD_PLATF'))
	{
		define('FORM_PUBL_TRAD_PLATF', 1) ;
		
		class FormMdlTransactsTradPlatf extends FormulaireDonneesBaseTradPlatf
		{
			public $InscrireCommandeAnnuler = 0 ;
			public $LibelleCommandeExecuter = "Actualiser" ;
			public $MdlTransactSelect ;
			public $FltMdlTransact ;
			public $FltPaysDoc ;
			public $IdMdlTransact = 1 ;
			public function ChargeConfig()
			{
				$this->DetecteMdlTransactSelect() ;
				$this->ChargeConfigBase() ;
				parent::ChargeConfig() ;
			}
			protected function ChargeConfigBase()
			{
				$this->Titre = "Rattachements" ;
				$this->InclureTotalElements = 0 ;
				$this->InclureElementEnCours = 0 ;
				$this->InscrireCommandeAnnuler = 0 ;
				$this->LibelleCommandeExecuter = "Actualiser" ;
				$this->FltPaysDoc = $this->ScriptParent->CreeFiltreHttpPost("paysDoc") ;
				$this->FltPaysDoc->Libelle = "Pays" ;
				$this->FltPaysDoc->DeclareComposant("PvZoneBoiteSelectHtml") ;
				$comp = & $this->FltPaysDoc->Composant ;
				$comp->FournisseurDonnees = new PvFournisseurDonneesSql() ;
				$comp->FournisseurDonnees->BaseDonnees = & $this->ApplicationParent->BDPrincipale ;
				$comp->FournisseurDonnees->RequeteSelection = "pays" ;
				$comp->NomColonneValeur = "idpays" ;
				$comp->NomColonneLibelle = "libpays" ;
				/*
				$comp->InclureElementHorsLigne = 1 ;
				$comp->ValeurElementHorsLigne = 0 ;
				$comp->NomElementHorsLigne = "-- Tous --" ;
				*/
				$this->FiltresEdition[] = & $this->FltPaysDoc ;
				$this->FltMdlTransact = $this->ScriptParent->CreeFiltreFixe("mdlDoc", $this->IdMdlTransact) ;
				$this->FltMdlTransact->Libelle = "Transaction" ;
				$this->FltMdlTransact->DeclareComposant("PvZoneEtiquetteHtml") ;
				$comp = & $this->FltMdlTransact->Composant ;
				$comp->Libelle = $this->MdlTransactSelect->Titre ;
				$this->FiltresEdition[] = & $this->FltMdlTransact ;
				// $this->FltPaysSelectRef ;
			}
			public function DetecteMdlTransactSelect()
			{
				$this->MdlTransactSelect = $this->ApplicationParent->ObtientMdlTransact($this->IdMdlTransact) ;
			}
		}
		
		class FormLiaisonEntiteTradPlatf extends FormulaireDonneesBaseTradPlatf
		{
			public $InscrireCommandeAnnuler = 0 ;
			public $FltMdlTransactRef ;
			public $FltIdEntiteRef ;
			public $FltPaysSelectRef ;
			public $FltEntitesPossibles ;
			public $CmdActiveRegion ;
			public $CmdDesactiveRegion ;
			public function ChargeConfig()
			{
				// print get_class($this->ScriptParent->FormEntite->FiltresLigneSelection[0]) ;
				$this->FltMdlTransactRef = $this->ScriptParent->CreeFiltreHttpPost("mdlDoc") ;
				$this->FltMdlTransactRef->ValeurParDefaut = $this->ScriptParent->FormMdlTransacts->FltMdlTransact->ValeurParametre ;
				$this->FltMdlTransactRef->LectureSeule = 1 ;
				$this->FiltresEdition[] = & $this->FltMdlTransactRef ;
				$this->FltPaysDocRef = $this->ScriptParent->CreeFiltreHttpPost("paysDoc") ;
				$this->FltPaysDocRef->ValeurParDefaut = $this->ScriptParent->FormMdlTransacts->FltMdlTransact->ValeurParametre ;
				$this->FltPaysDocRef->LectureSeule = 1 ;
				$this->FiltresEdition[] = & $this->FltPaysDocRef ;
				$this->FltEntitesPossibles = $this->ScriptParent->CreeFiltreHttpPost("entitesPossible") ;
				$this->FltEntitesPossibles->Libelle = "Entit&eacute; possibles" ;
				$this->FltEntitesPossibles->DeclareComposant("PvZoneBoiteOptionsCocherHtml") ;
				$comp = & $this->FltEntitesPossibles->Composant ;
				$comp->NomColonneLibelle = "name" ;
				$comp->InclureLienSelectTous = 1 ;
				$comp->InclureLienSelectAucun = 1 ;
				$comp->NomColonneValeur = "id_entite" ;
				$comp->NomColonneValeurParDefaut = "top_active" ;
				$this->FltPaysSelectRef = $this->ScriptParent->CreeFiltreRef("idPaysRef", $this->ScriptParent->FormMdlTransacts->FltPaysDoc) ;
				$this->FltPaysSelectRef->ValeurParDefaut = 0 ;
				$this->FltPaysSelectRef->ExpressionDonnees = "idpays = <self>" ;
				$comp->FiltresSelection[] = & $this->FltPaysSelectRef ;
				$this->FltIdEntiteRef = $this->ScriptParent->CreeFiltreRef("idEntite", $this->ScriptParent->FormEntite->FiltresLigneSelection[0]) ;
				$this->FltIdEntiteRef->ExpressionDonnees = 'id_entite_source = <self>' ;
				$comp->FiltresSelection[] = & $this->FltIdEntiteRef ;
				$comp->FournisseurDonnees = new PvFournisseurDonneesSql() ;
				$comp->FournisseurDonnees->RequeteSelection = $this->ScriptParent->FormMdlTransacts->MdlTransactSelect->RequeteSelection ;
				$comp->FournisseurDonnees->BaseDonnees = & $this->ApplicationParent->BDPrincipale ;
				$this->FiltresEdition[] = & $this->FltEntitesPossibles ;
				$this->LibelleCommandeExecuter = "Appliquer" ;
				parent::ChargeConfig() ;
				$this->FournisseurDonnees = new PvFournisseurDonneesSql() ;
				$this->FournisseurDonnees->BaseDonnees = $this->ApplicationParent->BDPrincipale ;
				$this->FournisseurDonnees->RequeteSelection = $this->ScriptParent->FormMdlTransacts->MdlTransactSelect->RequeteSelection ;
				$this->CommandeExecuter->InscritNouvActCmd(new ActCmdAjoutEntitesLiees()) ;
				$this->CommandeExecuter->MessageSuccesExecution = "Les liaisons ont &eacute;t&eacute; &eacute;tablies avec succ&egrave;s." ;
				$this->CmdActiveRegion = new PvCommandeExecuterBase() ;
				$this->InscritCommande("active_region", $this->CmdActiveRegion) ;
				$this->CmdActiveRegion->ChargeConfig() ;
				$this->CmdActiveRegion->Libelle = "Lier la zone" ;
				$this->CmdActiveRegion->MessageSuccesExecution = "Les banques de la zone ont &eacute;t&eacute; activ&eacute;es" ;
				$this->CmdActiveRegion->InscritNouvActCmd(new ActCmdAjoutEntitesRegion()) ; ;
				$this->CmdDesactiveRegion = new PvCommandeExecuterBase() ;
				$this->InscritCommande("desactive_region", $this->CmdDesactiveRegion) ;
				$this->CmdDesactiveRegion->ChargeConfig() ;
				$this->CmdDesactiveRegion->Libelle = "Detacher la zone" ;
				$this->CmdDesactiveRegion->MessageSuccesExecution = "Les banques de la zone ont &eacute;t&eacute; d&eacute;sactiv&eacute;es" ;
				$this->CmdDesactiveRegion->InscritNouvActCmd(new ActCmdSupprEntitesRegion()) ; ;
			}
			public function RenduDispositif()
			{
				if($this->ScriptParent->FormMdlTransacts->FltPaysDoc->Lie() == '')
				{
					return '<p>'.htmlentities('-- Veuillez selectionner un modèle de transaction --').'</p>' ;
				}
				$ctn = parent::RenduDispositif() ;
				// print_r($this->FournisseurDonnees->BaseDonnees) ;
				return $ctn ;
			}
		}
		
		class ActCmdAjoutEntitesLiees extends PvActCmdBase
		{
			protected function SqlSupprEntitesLiees($lstEntites)
			{
				$sql = 'delete from '.$this->ScriptParent->FormMdlTransacts->MdlTransactSelect->NomTableLiaison.' where id_entite_source = '.$this->FormulaireDonneesParent->FournisseurDonnees->BaseDonnees->ParamPrefix.'idEntiteSrc and id_entite_dest in ('.$lstEntites.')' ;
				return $sql ;
			}
			protected function SqlInsereEntitesLiees($lstEntites)
			{
				$sql = 'insert into '.$this->ScriptParent->FormMdlTransacts->MdlTransactSelect->NomTableLiaison.' (id_entite_source, id_entite_dest, top_active) select '.$this->FormulaireDonneesParent->FournisseurDonnees->BaseDonnees->ParamPrefix.'idEntiteSrc, id_entite, 0 from entite where id_entite in ('.$lstEntites.')' ;
				return $sql ;
			}
			public function Execute()
			{
				$bd = $this->FormulaireDonneesParent->FournisseurDonnees->BaseDonnees ;
				$idEntiteEnCours = $this->FormulaireDonneesParent->FltIdEntiteRef->Lie() ;
				$idPaysDoc = $this->FormulaireDonneesParent->FltPaysDocRef->Lie() ;
				$listeEntites = array() ;
				$chaineEntites = '' ;
				$lignes = $bd->FetchSqlRows('select * from entite where idpays='.$bd->ParamPrefix.'idPays', array('idPays' => $idPaysDoc)) ;
				foreach($lignes as $i => $ligne)
				{
					if($i > 0)
					{
						$chaineEntites .= ', ' ;
					}
					$cle = "idEntiteDest".format_number_size($i, strlen(strval(count($lignes)))) ;
					$listeEntites[$cle] = $ligne["id_entite"] ;
					$chaineEntites .= $bd->ParamPrefix.$cle ;
				}
				if(count($listeEntites) == 0)
				{
					return 1 ;
				}
				$ligEntite = array_merge(array('idEntiteSrc' => $idEntiteEnCours), $listeEntites) ;
				$sql = $this->SqlSupprEntitesLiees($chaineEntites) ;
				$ok = $bd->RunSql($sql, $ligEntite) ;
				if(! $ok)
				{
					$this->RenseignErrBD() ;
					return 0 ;
				}
				$sql = $this->SqlInsereEntitesLiees($chaineEntites) ;
				$ok = $bd->RunSql($sql, $ligEntite) ;
				if(! $ok)
				{
					$this->RenseignErrBD() ;
					return 0 ;
				}
				$this->FormulaireDonneesParent->FltEntitesPossibles->Lie() ;
				$valeursSelect = $this->FormulaireDonneesParent->FltEntitesPossibles->ValeurBrute ;
				if($valeursSelect != null)
				{
					foreach($valeursSelect as $i => $idEntiteSelect)
					{
						if(! in_array($idEntiteSelect, $listeEntites))
						{
							continue ;
						}
						$ok = $bd->UpdateRow(
							$this->ScriptParent->FormMdlTransacts->MdlTransactSelect->NomTableLiaison,
							array(
								"top_active" => 1,
							),
							"id_entite_source = ".$bd->ParamPrefix."idEntiteSrc and id_entite_dest = ".$bd->ParamPrefix."idEntiteDest",
							array(
								"idEntiteSrc" => $idEntiteEnCours,
								"idEntiteDest" => $idEntiteSelect,
							)
						) ;
					}
				}
				return 1 ;
			}
			protected function RenseignErrBD()
			{
				$this->CommandeParent->MessageExecution = $this->FormulaireDonneesParent->FournisseurDonnees->BaseDonnees->LastSqlText.'<br />Erreur SQL : '.$this->FormulaireDonneesParent->FournisseurDonnees->BaseDonnees->ConnectionException ;
			}
		}
		class ActCmdAjoutEntitesRegion extends PvActCmdBase
		{
			public $ActiveLiaison = 1 ;
			protected function RecupIdRegion($idEntite)
			{
				$bd = & $this->ApplicationParent->BDPrincipale ;
				$idRegion = $bd->FetchSqlValue('select id_region from entite t1 left join pays t2 on t1.idpays = t2.idpays where id_entite = '.$bd->ParamPrefix.'idEntite', array('idEntite' => $idEntite), 'id_region') ;
				// print_r($bd) ;
				return $idRegion ;
			}
			protected function SqlSupprEntitesLiees($lstEntites)
			{
				$sql = 'delete from '.$this->ScriptParent->FormMdlTransacts->MdlTransactSelect->NomTableLiaison.' where id_entite_source = '.$this->FormulaireDonneesParent->FournisseurDonnees->BaseDonnees->ParamPrefix.'idEntiteSrc and id_entite_dest in ('.$lstEntites.')' ;
				return $sql ;
			}
			protected function SqlInsereEntitesLiees($lstEntites)
			{
				$sql = 'insert into '.$this->ScriptParent->FormMdlTransacts->MdlTransactSelect->NomTableLiaison.' (id_entite_source, id_entite_dest, top_active) select '.$this->FormulaireDonneesParent->FournisseurDonnees->BaseDonnees->ParamPrefix.'idEntiteSrc, id_entite, '.intval($this->ActiveLiaison).' from entite where id_entite in ('.$lstEntites.')' ;
				return $sql ;
			}
			public function Execute()
			{
				$bd = $this->FormulaireDonneesParent->FournisseurDonnees->BaseDonnees ;
				$idEntiteEnCours = $this->FormulaireDonneesParent->FltIdEntiteRef->Lie() ;
				$idRegion = $this->RecupIdRegion($idEntiteEnCours) ;
				$listeEntites = array() ;
				$chaineEntites = '' ;
				$lignes = $bd->FetchSqlRows('select t1.* from entite t1 left join pays t2 on t1.idpays = t2.idpays where id_region='.$bd->ParamPrefix.'idRegion', array('idRegion' => $idRegion)) ;
				// print_r($bd) ;
				foreach($lignes as $i => $ligne)
				{
					if($i > 0)
					{
						$chaineEntites .= ', ' ;
					}
					$cle = "idEntiteDest".format_number_size($i, strlen(strval(count($lignes)))) ;
					$listeEntites[$cle] = $ligne["id_entite"] ;
					$chaineEntites .= $bd->ParamPrefix.$cle ;
				}
				if(count($listeEntites) == 0)
				{
					return 1 ;
				}
				$ligEntite = array_merge(array('idEntiteSrc' => $idEntiteEnCours), $listeEntites) ;
				$sql = $this->SqlSupprEntitesLiees($chaineEntites) ;
				$ok = $bd->RunSql($sql, $ligEntite) ;
				if(! $ok)
				{
					$this->RenseignErrBD() ;
					return 0 ;
				}
				$sql = $this->SqlInsereEntitesLiees($chaineEntites) ;
				$ok = $bd->RunSql($sql, $ligEntite) ;
				if(! $ok)
				{
					$this->RenseignErrBD() ;
					return 0 ;
				}
				return 1 ;
			}
			protected function RenseignErrBD()
			{
				$this->CommandeParent->MessageExecution = $this->FormulaireDonneesParent->FournisseurDonnees->BaseDonnees->LastSqlText.'<br />Erreur SQL : '.$this->FormulaireDonneesParent->FournisseurDonnees->BaseDonnees->ConnectionException ;
			}
		}
		class ActCmdSupprEntitesRegion extends ActCmdAjoutEntitesRegion
		{
			public $ActiveLiaison = 0 ;
		}
		
		class CmdAjoutEntite extends PvCommandeAjoutElement
		{
			public function ExecuteInstructions()
			{
				parent::ExecuteInstructions() ;
				if($this->StatutExecution == 1)
				{
					$bd = & $this->FormulaireDonneesParent->FournisseurDonnees->BaseDonnees ;
					$ok = $bd->RunSql('insert into oper_b_change (id_entite_source, id_entite_dest, top_active)
select distinct t1.id_src, t1.id_dest, 0 from (select t1.id_entite id_src, t2.id_entite id_dest from entite t1, entite t2) t1 left join oper_b_change t2
on t1.id_src = t2.id_entite_source and t1.id_dest = t2.id_entite_dest
where t2.id_entite_source is null') ;
					$ok = $bd->RunSql('insert into oper_b_inter (id_entite_source, id_entite_dest, top_active)
select distinct t1.id_src, t1.id_dest, 0 from (select t1.id_entite id_src, t2.id_entite id_dest from entite t1, entite t2) t1 left join oper_b_inter t2
on t1.id_src = t2.id_entite_source and t1.id_dest = t2.id_entite_dest
where t2.id_entite_source is null') ;
				}
			}
		}
	}
	
?>
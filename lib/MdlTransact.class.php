<?php
	
	if(! defined('MDL_TRANSACT_TRAD_PLATF'))
	{
		define('MDL_TRANSACT_TRAD_PLATF', 1) ;
		
		define("TXT_SQL_SELECT_LIAISON_BANQ_TRAD_PLATF", "(SELECT t1.*, t2.*
FROM entite t1
left join oper_b_change t2 on t1.id_entite = t2.id_entite_dest
left join entite t3 on t2.id_entite_source = t3.id_entite)") ;
		
		define("TXT_SQL_SELECT_LIAISON_OP_INTER_TRAD_PLATF", "(SELECT t1.*, t2.*
FROM entite t1
left join oper_b_inter t2 on t1.id_entite = t2.id_entite_dest
left join entite t3 on t2.id_entite_source = t3.id_entite)") ;
		define("TXT_SQL_SELECT_TOUS_ACHAT_DEVISE_TRAD_PLATF", "select t1.*, t2.lib_devise lib_devise1, t3.lib_devise lib_devise2, t4.login loginop, t4.nomop nomop, t4.prenomop prenomop, t5.id_entite_source, t5.id_entite_dest, t5.top_active, t6.numop numrep, t6.login loginrep, case when t4.numop = t6.numop then 1 else 0 end peut_modif, case when t4.numop <> t6.numop then 1 else 0 end peut_repondre
from op_change t1
left join devise t2
on t1.id_devise1 = t2.id_devise
left join devise t3
on t1.id_devise2 = t3.id_devise
left join operateur t4
on t1.numop = t4.numop
left join oper_b_change t5
on t5.id_entite_source=t4.id_entite
left join operateur t6
on t5.id_entite_dest=t6.id_entite
where t5.id_entite_dest is not null and t6.login is not null and t1.num_op_change_dem = 0") ;
		define("TXT_SQL_SELECT_OP_CHANGE_TRAD_PLATF", "(select t1.*, t2.lib_devise lib_devise1 from op_change t1 left join devise t2 on t1.id_devise1 = t2.id_devise)") ;
		
		
		class FormulaireDonneesBaseTradPlatf extends PvFormulaireDonneesHtml
		{
			public $LibelleCommandeAnnuler = "Fermer" ;
		}
		class TableauDonneesBaseTradPlatf extends PvTableauDonneesAdminDirecte
		{
			public $ToujoursAfficher = 1 ;
			public $TitreBoutonSoumettreFormulaireFiltres = "Valider" ;
		}
		
		class MdlTransactBaseTradPlatf
		{
			public $Id = 0 ;
			public $Titre = "" ;
			public $NomTableLiaison = "" ;
			public $RequeteSelection = "" ;
			public $IdsTypeEntiteSource = array() ;
			public $IdsTypeEntiteDest = array() ;
			public function ObtientValeurs()
			{
				return array(
					"id" => $this->Id,
					"titre" => $this->Titre,
				) ;
			}
			public function RemplitFiltresSelect(& $form)
			{
				foreach($this->IdsTypeEntiteDest as $i => $idTypeEntite)
				{
					$filtre = $this->CreeFiltreFixe("idTypeEntite_".$i, $idTypeEntite) ;
					$filtre->ExpressionDonnees = 'idtype_entite  = <self>' ;
				}
			}
			public function ExtraitExprTypeEntiteDest(& $bd)
			{
				$expr = new PvExpressionFiltre() ;
				foreach($this->IdsTypeEntiteDest as $i => $idEntite)
				{
					$nomParam = 'idTypeEntiteDest'.$i ;
					if($i > 0)
						$expr->Texte .= ', ' ;
					$expr->Texte .= $bd->ParamPrefix.$nomParam ;
					$expr->Parametres[$nomParam] = $idEntite ;
				}
				if(count($expr->Parametres) > 0)
				{
					$expr->Texte = 'idtype_entite in ('.$expr->Texte.')' ;
				}
				return $expr ;
			}
		}
		
		class MdlOpChangeTradPlatf extends MdlTransactBaseTradPlatf
		{
			public $Id = 1 ;
			public $Titre = "Operation de change" ;
			public $NomTableLiaison = "oper_b_change" ;
			public $RequeteSelection = TXT_SQL_SELECT_LIAISON_BANQ_TRAD_PLATF ;
			public $IdsTypeEntiteSource = array(1, 2) ;
			public $IdsTypeEntiteDest = array(1, 2) ;
			public $NomScriptRattach = 'rattachEntite' ;
			public $NomScriptLiaisons = 'liaisonsEntite' ;
		}
		
		class MdlOpInterTradPlatf extends MdlTransactBaseTradPlatf
		{
			public $Id = 2 ;
			public $Titre = "Demande de cotation" ;
			public $NomTableLiaison = "oper_b_inter" ;
			public $RequeteSelection = TXT_SQL_SELECT_LIAISON_OP_INTER_TRAD_PLATF ;
			public $IdsTypeEntiteSource = array(1, 2) ;
			public $IdsTypeEntiteDest = array(1, 2) ;
			public $NomScriptRattach = 'rattachOpInter' ;
			public $NomScriptLiaisons = 'liaisonsOpInter' ;
		}
		
		class ScriptTransactBaseTradPlatf extends PvScriptWebSimple
		{
			protected function ArchiveAncTransacts()
			{
				$bd = $this->ApplicationParent->BDPrincipale ;
				$condArch = '('.$bd->SqlDatePart('date_change').' < '.$bd->SqlDatePart($bd->SqlNow()).')' ;
				$sql1 = 'insert into arch_op_change select op_change.*, '.$bd->SqlNow().' from op_change where '.$condArch ;
				$sql2 = 'delete from op_change where '.$condArch ;
				// echo $sql1 ;
				$bd->RunSql($sql1) ;
				$bd->RunSql($sql2) ;
			}
			protected function EstPeriodeTransact()
			{
				// echo "Heure : ".gmdate("G") ;
				return gmdate("G") >= 8 && gmdate("G") <= 17 ;
			}
			public function RenduPeriodeIndisponible()
			{
				return '<div class="ui-state-error">Les transactions sont interdites dans cette p&eacute;riode.</div>' ;
			}
			public function RenduDispositif()
			{
				$this->ArchiveAncTransacts() ;
				if($this->EstPeriodeTransact())
				{
					return parent::RenduDispositif() ;
				}
				else
				{
					return $this->RenduPeriodeIndisponible() ;
				}
			}
		}
		
		class ScriptListTransactBaseTradPlatf extends ScriptTransactBaseTradPlatf
		{
		}
		class ScriptFormTransactBaseTradPlatf extends ScriptTransactBaseTradPlatf
		{
		}
		
		class ScriptListBaseOpChange extends ScriptListTransactBaseTradPlatf
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
				// Consultation
				$smConsult = $this->BarreMenu->MenuRacine->InscritSousMenuScript(($this->TypeOpChange == 1) ? "listeAchatsDevise" : "listeVentesDevise") ;
				$smConsult->CheminMiniature = "images/miniatures/consulte_".(($this->TypeOpChange == 1) ? "achat_devise" : "vente_devise").".png" ;
				$smConsult->Titre = "Consultation ".(($this->TypeOpChange == 1) ? "Achat" : "Vente") ;
				// Consultation oppose
				$smConsultOpp = $this->BarreMenu->MenuRacine->InscritSousMenuScript(($this->TypeOpChange == 2) ? "listeAchatsDevise" : "listeVentesDevise") ;
				$smConsultOpp->CheminMiniature = "images/miniatures/consulte_".(($this->TypeOpChange == 2) ? "achat_devise" : "vente_devise").".png" ;
				$smConsultOpp->Titre = "Consultation ".(($this->TypeOpChange == 2) ? "Achat" : "Vente") ;
				// Edition
				$smEdition = $this->BarreMenu->MenuRacine->InscritSousMenuScript(($this->TypeOpChange == 1) ? "editAchatsDevise" : "editVentesDevise") ;
				$smEdition->CheminMiniature = "images/miniatures/edit_opchange.png" ;
				$smEdition->Titre = "Publication" ;
				$smReserv = $this->BarreMenu->MenuRacine->InscritSousMenuScript(($this->TypeOpChange == 1) ? "reservAchatsDevise" : "reservVentesDevise") ;
				$smReserv->CheminMiniature = "images/miniatures/reserv_opchange.png" ;
				$smReserv->Titre = "R&eacute;servation" ;
				$smSoumiss = $this->BarreMenu->MenuRacine->InscritSousMenuScript(($this->TypeOpChange == 1) ? "soumissAchatDevise" : "soumissVenteDevise") ;
				$smSoumiss->CheminMiniature = "images/miniatures/soumiss_opchange.png" ;
				$smSoumiss->Titre = "Negociations" ;
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
		
	}
	
?>
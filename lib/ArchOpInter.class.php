<?php
	
	if(! defined('ARCH_OP_INTER_TRAD_PLATF'))
	{
		define('ARCH_OP_INTER_TRAD_PLATF', 1) ;
		
		class ScriptConsultArchOpInterTradPlatf extends PvScriptWebSimple
		{
			public $HauteurCadre = 350 ;
			public function RenduDispositifBrut()
			{
				$ctn = '' ;
				$ctn .= '
	<div class="ui-widget ui-widget-content ui-state-active">Archives</div>
	<br />
				<div id="archives">
	<ul>
		<li><a href="#achat-devise">Placements</a></li>
		<li><a href="#vente-devise">Emprunts</a></li>
	</ul>
	<div id="achat-devise">
		<iframe src="?appelleScript=consultArchPlacement" style="width:100%" height="'.$this->HauteurCadre.'"  frameborder="0"></iframe>
	</div>
	<div id="vente-devise">
		<iframe src="?appelleScript=consultArchEmprunt" style="width:100%" height="'.$this->HauteurCadre.'" frameborder="0"></iframe>
	</div>
</div>
<script language="javascript">
	jQuery(function() {
		jQuery("#archives").tabs() ;
	}) ;
</script>' ;
				return $ctn ;
			}
		}
		
		class ScriptConsultArchElemOpInterTradPlatf extends PvScriptWebSimple
		{
			public $IdTypeChange = 0 ;
			public $TablPrinc ;
			public $FltDateDebut ;
			public $FltDateFin ;
			public $FltDevise ;
			public $FltNumOp ;
			public $DefColTri ;
			public $DefColId ;
			public $DefColRefChange ;
			public $DefColDateOp ;
			public $DefColDevise ;
			public $DefColNomEntiteOp ;
			public $DefColLoginOp ;
			public $DefColMontant ;
			public $DefColTaux ;
			public $DefColDateArch ;
			public $DefColActions ;
			public $LienDetails ;
			public function DetermineEnvironnement()
			{
				$this->DetermineTablPrinc() ;
			}
			protected function DetermineTablPrinc()
			{
				$bd = $this->ApplicationParent->BDPrincipale ;
				$this->TablPrinc = new TableauDonneesBaseTradPlatf() ;
				$this->TablPrinc->AdopteScript('tablPrinc', $this) ;
				$this->TablPrinc->ChargeConfig() ;
				// $this->DefColTri = $this->TablPrinc->InsereDefColCachee('date_change') ;
				$this->TablPrinc->InsereDefsColCachee("id_arch", "date_change", "num_op_inter", "id_emetteur", "id_devise1", "id_devise2", "lib_devise1", "lib_devise2", "bool_confirme", "bool_valide") ;
				$this->DefColRefChange = $this->TablPrinc->InsereDefCol('ref_change', 'Ref change') ;
				$this->DefColDevise = $this->TablPrinc->InsereDefColHtml('${lib_devise2}', 'Devise') ;
				$this->DefColLoginOp = $this->TablPrinc->InsereDefCol('login_operateur', 'Auteur') ;
				$this->DefColNomEntiteOp = $this->TablPrinc->InsereDefCol('nom_entite_operateur', 'Banque') ;
				$this->DefColDateOp = $this->TablPrinc->InsereDefCol('date_operation', 'Date Op.', $bd->SqlDateToStrFr('date_operation')) ;
				$this->DefColDateValeur = $this->TablPrinc->InsereDefCol('date_valeur', 'Date Valeur', $bd->SqlDateToStrFr('date_valeur')) ;
				$this->DefColMontant = $this->TablPrinc->InsereDefColMoney('montant_operateur', 'Montant') ;
				$this->DefColTaux = $this->TablPrinc->InsereDefCol('taux_transact', 'Taux') ;
				if(! $this->ZoneParent->MembreSuperAdminConnecte() && ! $this->ZoneParent->PossedeTousPrivileges())
				{
					$this->FltNumOp = $this->TablPrinc->InsereFltSelectFixe('num_operateur', $this->ZoneParent->IdMembreConnecte(), '(id_emetteur=<self> or (id_repondeur=<self> and bool_valide=1))') ;
				}
				$this->FltConfirme = $this->TablPrinc->InsereFltSelectFixe('est_confirme', 1, 'bool_confirme=<self>') ;
				$this->FltTypeChange = $this->TablPrinc->InsereFltSelectFixe('type_change_accepte', $this->IdTypeChange, 'type_change=<self>') ;
				$this->FltDateDebut = $this->TablPrinc->InsereFltSelectHttpGet('date_debut', 'date_change >= <self>') ;
				$this->FltDateFin = $this->TablPrinc->InsereFltSelectHttpGet('date_fin', 'date_change <= <self>') ;
				$this->FltDateDebut->ValeurParDefaut = date("Y-m-d", date("U") - 86400 * 30) ;
				$this->FltDateDebut->Libelle = "Periode du" ;
				$this->FltDateDebut->DeclareComposant("PvCalendarDateInput") ;
				$this->FltDateFin->Libelle = "au" ;
				$this->FltDateFin->DeclareComposant("PvCalendarDateInput") ;
				$this->DefColActions = $this->TablPrinc->InsereDefColActions('Actions') ;
				$this->LienDetails = $this->TablPrinc->InsereLienOuvreFenetreAction(
					$this->DefColActions,'?appelleScript=detailArchOpInter&idEnCours=${id_arch}',
					"Details", 'detail_arch_op_inter_${id_arch}',
					"Details archive operation de change", 
					array('Modal' => 1, 'BoutonFermer' => 0, 'Largeur' => 450, 'Hauteur' => 400)
				) ;
				$this->LienDetails->NomCadreConteneur = "top" ;
				$this->TablPrinc->FournisseurDonnees = new PvFournisseurDonneesSql() ;
				$this->TablPrinc->FournisseurDonnees->BaseDonnees = $bd ;
				$this->TablPrinc->FournisseurDonnees->RequeteSelection = "(
	select t1.id_arch,
		d1.code_devise lib_devise1,
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
        t1.type_change,
        t1.mtt_commiss_soumis,
        t1.date_valeur_soumis,
		case when t1.numop = t2.numop then t1.montant_change else t1.montant_soumis end montant_operateur,
		case when t1.numop = t2.numop then t2.numop else e1.numop end id_operateur,
		case when t1.numop = t2.numop then t3.login else e1.login end login_operateur,
		case when t1.numop = t2.numop then t4.name else e2.name end nom_entite_operateur
	from arch_op_inter t1
	inner join arch_op_inter t2 ON t2.num_op_inter = t1.num_op_inter_dem
	inner join operateur t3 ON t3.numop = t2.numop
	inner join entite t4 ON t3.id_entite = t4.id_entite
	inner join operateur e1 ON t1.numop = e1.numop
	inner join entite e2 ON e2.id_entite = e1.id_entite
	left join devise d1 on d1.id_devise = t1.id_devise1
	left join devise d2 on d2.id_devise = t1.id_devise2
	where date(t1.date_change) = date(t2.date_change)
)" ;
			}
			protected function RenduDispositifBrut()
			{
				$ctn = '' ;
				$ctn .= $this->TablPrinc->RenduDispositif() ;
				// $ctn .= print_r($this->TablPrinc->FournisseurDonnees, true) ;
				return $ctn ;
			}

		}
		
		class ScriptConsultArchPlacementTradPlatf extends ScriptConsultArchElemOpInterTradPlatf
		{
			public $IdTypeChange = 1 ;
		}
		class ScriptConsultArchEmpruntTradPlatf extends ScriptConsultArchElemOpInterTradPlatf
		{
			public $IdTypeChange = 2 ;
		}
		
		class ScriptDetailArchOpInterTradPlatf extends PvScriptWebSimple
		{
			public $FormPrinc ;
			public $FltIdEnCours ;
			public function ChargeConfig()
			{
				$this->ChargeFormPrinc() ;
			}
			protected function RenduDispositifBrut()
			{
				$ctn = '' ;
				$ctn .= $this->FormPrinc->RenduDispositif() ;
				// $ctn .= print_r($this->FormPrinc->FournisseurDonnees) ;
				return $ctn ;
			}
			protected function ChargeFormPrinc()
			{
				$bd = $this->ApplicationParent->BDPrincipale ;
				$this->FormPrinc = new FormulaireDonneesBaseTradPlatf() ;
				$this->FormPrinc->Largeur = "100%" ;
				$this->FormPrinc->AdopteScript("formPrinc", $this) ;
				$this->FormPrinc->InclureElementEnCours = 1 ;
				$this->FormPrinc->InclureTotalElements = 1 ;
				$this->FormPrinc->DessinateurFiltresEdition = new DessinFltEditArchOpInterTradPlatf() ;
				$this->FormPrinc->InscrireCommandeExecuter = 0 ;
				$this->FormPrinc->NomClasseCommandeAnnuler = "PvCmdFermeFenetreActiveAdminDirecte" ;
				$this->FormPrinc->ChargeConfig() ;
				$this->FormPrinc->CommandeAnnuler->NomCadreConteneur = "top" ;
				
				$this->FltIdEnCours = $this->FormPrinc->InsereFltSelectHttpGet("idEnCours", "id_arch=<self>") ;
				$this->FltIdEnCours->Obligatoire = 1 ;
				if(! $this->ZoneParent->MembreSuperAdminConnecte() && ! $this->ZoneParent->PossedeTousPrivileges())
				{
					$this->FltAuteur = $this->FormPrinc->InsereFltSelectFixe("membre", $this->ZoneParent->IdMembreConnecte(), "id_emetteur=<self> or id_soumis = <self>") ;
				}
				
				$this->FltDevise = $this->FormPrinc->InsereFltEditHttpPost("lib_devise", "lib_devise") ;
				$this->FltDevise->Libelle = "Devise" ;
				$this->FltDevise->EstEtiquette = 1 ;
				$this->FltTypeChange = $this->FormPrinc->InsereFltEditHttpPost("type_change", "type_change") ;
				$this->FltDateOper = $this->FormPrinc->InsereFltEditHttpPost("date_operation", "date_operation") ;
				$this->FltDateValeur = $this->FormPrinc->InsereFltEditHttpPost("date_valeur", "date_valeur") ;
				$this->FltMontant = $this->FormPrinc->InsereFltEditHttpPost("montant_soumis", "montant_soumis") ;
				$this->FltLoginDem = $this->FormPrinc->InsereFltEditHttpPost("login_emetteur", "login_emetteur") ;
				$this->FltLoginDem->Libelle = "Login emetteur" ;
				$this->FltLoginDem->EstEtiquette = 1 ;
				$this->FltCodeEntiteDem = $this->FormPrinc->InsereFltEditHttpPost("code_entite_emetteur", "code_entite_emetteur") ;
				$this->FltCodeEntiteDem->Libelle = "Code banque emettrice" ;
				$this->FltCodeEntiteDem->EstEtiquette = 1 ;
				$this->FltNomEntiteDem = $this->FormPrinc->InsereFltEditHttpPost("nom_entite_emetteur", "nom_entite_emetteur") ;
				$this->FltNomEntiteDem->Libelle = "Nom banque emettrice" ;
				$this->FltNomEntiteDem->EstEtiquette = 1 ;
				$this->FltLoginSoumis = $this->FormPrinc->InsereFltEditHttpPost("login_soumis", "login_soumis") ;
				$this->FltLoginSoumis->Libelle = "Login" ;
				$this->FltLoginSoumis->EstEtiquette = 1 ;
				$this->FltCodeEntiteSoumis = $this->FormPrinc->InsereFltEditHttpPost("code_entite_soumis", "code_entite_soumis") ;
				$this->FltCodeEntiteSoumis->Libelle = "Code banque emettrice" ;
				$this->FltCodeEntiteSoumis->EstEtiquette = 1 ;
				$this->FltNomEntiteSoumis = $this->FormPrinc->InsereFltEditHttpPost("nom_entite_soumis", "nom_entite_soumis") ;
				$this->FltNomEntiteSoumis->Libelle = "Nom banque emettrice" ;
				$this->FltNomEntiteSoumis->EstEtiquette = 1 ;
				$this->FltMontantDem = $this->FormPrinc->InsereFltEditHttpPost("montant_change", "montant_change") ;
				$this->FltMontantDem->Libelle = "Montant demand&eacute;" ;
				$this->FltTauxDem = $this->FormPrinc->InsereFltEditHttpPost("taux_dem", "taux_change") ;
				$this->FltTauxDem->Libelle = "Taux demand&eacute;" ;
				$this->FltMontantSoumis = $this->FormPrinc->InsereFltEditHttpPost("montant_soumis", "montant_soumis") ;
				$this->FltMontantSoumis->Libelle = "Montant possible" ;
				$this->FltTauxSoumis = $this->FormPrinc->InsereFltEditHttpPost("taux_soumis", "taux_soumis") ;
				$this->FltTauxSoumis->Libelle = "Taux possible" ;
				$this->FltRefChange = $this->FormPrinc->InsereFltEditHttpPost("refChange", "ref_change") ;
				$this->FltRefChange->Libelle = "Ref. Change" ;
				$this->FltRefChange->NePasLierColonne = 1 ;
				$this->FltValideOp = $this->FormPrinc->InsereFltEditFixe("bool_valide", 1, "bool_valide") ;
				
				$this->FormPrinc->FournisseurDonnees = new PvFournisseurDonneesSql() ;
				$this->FormPrinc->FournisseurDonnees->BaseDonnees = $bd ;
				$this->FormPrinc->FournisseurDonnees->RequeteSelection = "(select t1.id_arch,
	d1.code_devise lib_devise1,
	d2.code_devise lib_devise2,
	d2.code_devise lib_devise,
	t1.id_devise1,
	t1.id_devise2,
	case when t1.commiss_ou_taux = 0 then t1.taux_soumis when t1.type_taux = 0 then t1.taux_change else t1.ecran_taux end taux_transact,
	t2.numop id_emetteur,
	t3.login login_emetteur,
	t4.id_entite id_entite_emetteur,
	t4.code code_entite_emetteur,
	t4.name nom_entite_emetteur,
	t1.numop id_soumis,
	e1.login login_soumis,
	e1.id_entite id_entite_soumis,
	e2.code code_entite_soumis,
	e2.name nom_entite_soumis,
	t1.num_op_inter,
	t1.num_op_inter_dem,
	t1.ref_change,
	t1.date_valeur,
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
	t1.mtt_commiss_soumis,
	t1.date_valeur_soumis,
	t2.type_change
from arch_op_inter t1
inner join arch_op_inter t2 ON t2.num_op_inter = t1.num_op_inter_dem
inner join operateur t3 ON t3.numop = t2.numop
inner join entite t4 ON t3.id_entite = t4.id_entite
inner join operateur e1 ON t1.numop = e1.numop
inner join entite e2 ON e2.id_entite = e1.id_entite
left join devise d1 on d1.id_devise = t1.id_devise1
left join devise d2 on d2.id_devise = t1.id_devise2
where date(t1.date_change) = date(t2.date_change)
)" ;
			}
		}
		class DessinFltEditArchOpInterTradPlatf extends PvDessinateurRenduHtmlFiltresDonnees
		{
			public function Execute(& $script, & $composant, $parametres)
			{
				$composant->LieTousLesFiltres() ;
				$ctn = '' ;
				$ctn .= '<table width="100%" cellspacing="0" cellpadding="2">'.PHP_EOL ;
				$ctn .= '<colgroup><col width="40%" /><col width="*" /></colgroup>'.PHP_EOL ;
				$ctn .= '<tr><th class="ui-widget ui-widget-header" colspan="2">Emetteur</th></tr>'.PHP_EOL ;
				$ctn .= '<tr>' ;
				$ctn .= '<td><label for="'.$script->FltRefChange->ObtientIDElementHtmlComposant().'">Reference :</label></td>' ;
				$ctn .= '<td>'.$script->FltRefChange->Etiquette().'</td>' ;
				$ctn .= '</tr>'.PHP_EOL ;
				$ctn .= '<tr>' ;
				$ctn .= '<td><label for="'.$script->FltLoginDem->ObtientIDElementHtmlComposant().'">Login</label></td>' ;
				$ctn .= '<td>'.$script->FltLoginDem->Etiquette().'</td>' ;
				$ctn .= '</tr>'.PHP_EOL ;
				$ctn .= '<tr>' ;
				$ctn .= '<td><label for="'.$script->FltCodeEntiteDem->ObtientIDElementHtmlComposant().'">Code Banque</label></td>' ;
				$ctn .= '<td>'.$script->FltCodeEntiteDem->Etiquette().'</td>' ;
				$ctn .= '</tr>'.PHP_EOL ;
				$ctn .= '<tr>' ;
				$ctn .= '<td><label for="'.$script->FltNomEntiteDem->ObtientIDElementHtmlComposant().'">Nom Banque</label></td>' ;
				$ctn .= '<td>'.$script->FltNomEntiteDem->Etiquette().'</td>' ;
				$ctn .= '</tr>'.PHP_EOL ;
				$ctn .= $this->SectionDemandeur($script, $composant, $parametres).PHP_EOL ;	
				$ctn .= '<tr><th colspan="2" class="ui-widget ui-widget-header">N&eacute;gociateur</th></tr>'.PHP_EOL ;
				$ctn .= '<tr>' ;
				$ctn .= '<td><label for="'.$script->FltLoginSoumis->ObtientIDElementHtmlComposant().'">Login</label></td>' ;
				$ctn .= '<td>'.$script->FltLoginSoumis->Etiquette().'</td>' ;
				$ctn .= '</tr>'.PHP_EOL ;
				$ctn .= '<tr>' ;
				$ctn .= '<td><label for="'.$script->FltCodeEntiteSoumis->ObtientIDElementHtmlComposant().'">Code Banque</label></td>' ;
				$ctn .= '<td>'.$script->FltCodeEntiteSoumis->Etiquette().'</td>' ;
				$ctn .= '</tr>'.PHP_EOL ;
				$ctn .= '<tr>' ;
				$ctn .= '<td><label for="'.$script->FltNomEntiteSoumis->ObtientIDElementHtmlComposant().'">Nom Banque</label></td>' ;
				$ctn .= '<td>'.$script->FltNomEntiteSoumis->Etiquette().'</td>' ;
				$ctn .= '</tr>'.PHP_EOL ;
				$ctn .= $this->SectionRepondeur($script, $composant, $parametres).PHP_EOL ;
				$ctn .= '</table>' ;
				return $ctn ;
			}
			protected function RenduFiltreMonnaie(& $filtre)
			{
				$ctn = '' ;
				$ctn .= format_money($filtre->Etiquette(), 3, 2) ;
				return $ctn ;
			}
			protected function SectionDemandeur(& $script, & $composant, $parametres)
			{
				$ctn = '' ;
				$ctn .= '<tr>' ;
				$ctn .= '<td><label for="'.$script->FltDevise->ObtientIDElementHtmlComposant().'">'.$script->FltDevise->ObtientLibelle().'</label></td>' ;
				$ctn .= '<td>'.$script->FltDevise->Etiquette().'</td>' ;
				$ctn .= '</tr>'.PHP_EOL ;
				$ctn .= '<tr>' ;
				$ctn .= '<td><label for="'.$script->FltMontantDem->ObtientIDElementHtmlComposant().'">'.$script->FltMontantDem->ObtientLibelle().'</label></td>' ;
				$ctn .= '<td>'.$this->RenduFiltreMonnaie($script->FltMontantDem).'</td>' ;
				$ctn .= '</tr>'.PHP_EOL ;
				$ctn .= '<tr>' ;
				$ctn .= '<td><label for="'.$script->FltTauxDem->ObtientIDElementHtmlComposant().'">'.$script->FltTauxDem->ObtientLibelle().'</label></td>' ;
				$ctn .= '<td>'.$script->FltTauxDem->Etiquette().'</td>' ;
				$ctn .= '</tr>'.PHP_EOL ;
				return $ctn ;
			}
			protected function SectionRepondeur(& $script, & $composant, $parametres)
			{
				$ctn = '' ;
				$ctn .= '<tr>' ;
				$ctn .= '<td><label for="'.$script->FltMontantSoumis->ObtientIDElementHtmlComposant().'">'.$script->FltMontantSoumis->ObtientLibelle().'</label></td>' ;
				$ctn .= '<td>'.$this->RenduFiltreMonnaie($script->FltMontantSoumis).'</td>' ;
				$ctn .= '</tr>'.PHP_EOL ;
				$ctn .= '<tr>' ;
				$ctn .= '<td><label for="'.$script->FltTauxSoumis->ObtientIDElementHtmlComposant().'">'.$script->FltTauxSoumis->ObtientLibelle().'</label></td>' ;
				$ctn .= '<td>'.$script->FltTauxSoumis->Etiquette().'</td>' ;
				$ctn .= '</tr>'.PHP_EOL ;
				return $ctn ;
			}

		}
	}
	
?>
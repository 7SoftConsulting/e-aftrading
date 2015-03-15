<?php
	
	if(! defined('SCRIPT_PUBL_TRAD_PLATF'))
	{
		if(! defined('FORM_PUBL_TRAD_PLATF'))
		{
			include dirname(__FILE__)."/FormPubl.class.php" ;
		}
		if(! defined('SCRIPT_REF_TRAD_PLATF'))
		{
			include dirname(__FILE__)."/ScriptRef.class.php" ;
		}
		define('SCRIPT_PUBL_TRAD_PLATF', 1) ;
		
		define("TXT_SQL_SELECT_ENTITE_TRAD_PLATF", "(select t1.*, t2.lib_type_entite nom_type_entite, t3.libpays nom_pays from entite t1 left join type_entite t2 on t1.idtype_entite = t2.idtype_entite left join pays t3 on t1.idpays = t3.idpays)") ;
		
		class ScriptListeEntitesTradPlatf extends PvScriptWebSimple
		{
			public $TitreDocument = "Entit&eacute;s financi&egrave;res" ;
			public $CheminIcone = "images/icones/listeEtabFinanc.png" ;
			public $Titre = "Entit&eacute;s financi&egrave;res" ;
			public $NecessiteMembreConnecte = 1 ;
			public $Privileges = array("admin_members") ;
			public $TablEntites = null ;
			public $FltNom = null ;
			public $FltCode = null ;
			public $FltPays = null ;
			public $FltRegion = null ;
			public $FltTypeEntite = null ;
			public $InclureChoixTypeEntite = 1 ;
			public $IdTypeEntiteParDefaut = 1 ;
			public $DefColId = null ;
			public $DefColCode = null ;
			public $DefColNom = null ;
			public $DefColPays = null ;
			public $DefColEntite = null ;
			public $DefColActions = null ;
			public $CmdLienAjout = null ;
			public $CmdLienExportExcel = null ;
			public $FmtLienModif = null ;
			public $FmtLienRattach = null ;
			public $FmtLienLiaisons = null ;
			public $FmtLienSuppr = null ;
			public $BDEntites = null ;
			public $PourLiaison = 0 ;
			public $IdMdlTransact = 1 ;
			public $MdlTransact ;
			public function DetermineEnvironnement()
			{
				$this->MdlTransact = $this->ApplicationParent->ObtientMdlTransact($this->IdMdlTransact) ;
				$this->BDEntites = $this->ApplicationParent->BDPrincipale ;
				$this->TablEntites = new TableauDonneesBaseTradPlatf() ;
				$this->TablEntites->InclureCmdRafraich = ($this->PourLiaison) ? 0 : 1 ;
				$this->TablEntites->AdopteScript("tableEntites", $this) ;
				$this->TablEntites->FournisseurDonnees = new PvFournisseurDonneesSql() ;
				$this->TablEntites->FournisseurDonnees->BaseDonnees = $this->BDEntites ;
				$this->TablEntites->FournisseurDonnees->RequeteSelection = TXT_SQL_SELECT_ENTITE_TRAD_PLATF ;
				$this->DefColId = new PvDefinitionColonneDonnees() ;
				$this->DefColId->Visible = 0 ;
				$this->DefColId->NomDonnees = "id_entite" ;
				$this->TablEntites->DefinitionsColonnes[] = & $this->DefColId ;
				$this->DefColCode = new PvDefinitionColonneDonnees() ;
				$this->DefColCode->NomDonnees = "code" ;
				$this->DefColCode->Libelle = "Code" ;
				$this->DefColCode->Largeur = "16%" ;
				$this->TablEntites->DefinitionsColonnes[] = & $this->DefColCode ;
				$this->DefColNom = new PvDefinitionColonneDonnees() ;
				$this->DefColNom->NomDonnees = "name" ;
				$this->DefColNom->Libelle = "Nom" ;
				$this->DefColNom->Largeur = "25%" ;
				$this->TablEntites->DefinitionsColonnes[] = & $this->DefColNom ;
				$this->DefColPays = new PvDefinitionColonneDonnees() ;
				$this->DefColPays->NomDonnees = "nom_pays" ;
				$this->DefColPays->Libelle = "Pays" ;
				$this->DefColPays->Largeur = "13%" ;
				$this->TablEntites->DefinitionsColonnes[] = & $this->DefColPays ;
				$this->DefColEntite = new PvDefinitionColonneDonnees() ;
				$this->DefColEntite->NomDonnees = "nom_type_entite" ;
				$this->DefColEntite->Libelle = "Type Entit&eacute;" ;
				$this->DefColEntite->Largeur = "13%" ;
				$this->TablEntites->DefinitionsColonnes[] = & $this->DefColEntite ;
				$this->DefColActions = new PvDefinitionColonneDonnees() ;
				$this->DefColActions->Largeur = "*" ;
				$this->DefColActions->Libelle = "Actions" ;
				$this->DefColActions->TriPossible = 0 ;
				$this->DefColActions->AlignElement = "center" ;
				$this->DefColActions->Formatteur = new PvFormatteurColonneLiens() ;
				if($this->PourLiaison)
				{
					$this->FmtLienRattach = new PvConfigFormatteurColonneOuvreFenetre() ;
					$this->FmtLienRattach->FormatLibelle = "Rattacher" ;
					$this->FmtLienRattach->OptionsOnglet["Largeur"] = 750 ;
					$this->FmtLienRattach->OptionsOnglet["Hauteur"] = 600 ;
					$this->FmtLienRattach->OptionsOnglet["Modal"] = 1 ;
					$this->FmtLienRattach->FormatTitreOnglet = 'Liaisons ${nom_type_entite} ${code}' ;
					$this->FmtLienRattach->FormatCheminIcone = 'images/icones/liaisons.png' ;
					$this->FmtLienRattach->FormatURL = '?'.urlencode($this->ZoneParent->NomParamScriptAppele).'='.urlencode($this->MdlTransact->NomScriptRattach).'&idEnCours=${id_entite}' ;
					$this->FmtLienRattach->ClasseCSS = 'lien-act-003' ;
					$this->DefColActions->Formatteur->Liens[] = & $this->FmtLienRattach ;
					$this->FmtLienLiaisons = new PvConfigFormatteurColonneOuvreFenetre() ;
					$this->FmtLienLiaisons->FormatLibelle = "Consultation" ;
					$this->FmtLienLiaisons->OptionsOnglet["Largeur"] = 750 ;
					$this->FmtLienLiaisons->OptionsOnglet["Hauteur"] = 600 ;
					$this->FmtLienLiaisons->OptionsOnglet["Modal"] = 1 ;
					$this->FmtLienLiaisons->FormatTitreOnglet = 'Liaisons ${nom_type_entite} ${code}' ;
					$this->FmtLienLiaisons->FormatCheminIcone = 'images/icones/liaisons.png' ;
					$this->FmtLienLiaisons->FormatURL = '?'.urlencode($this->ZoneParent->NomParamScriptAppele).'='.urlencode($this->MdlTransact->NomScriptLiaisons).'&idEnCours=${id_entite}' ;
					$this->FmtLienLiaisons->ClasseCSS = 'lien-act-004' ;
					$this->DefColActions->Formatteur->Liens[] = & $this->FmtLienLiaisons ;
				}
				else
				{
					$this->FmtLienModif = new PvConfigFormatteurColonneOuvreFenetre() ;
					$this->FmtLienModif->FormatLibelle = "Modifier" ;
					$this->FmtLienModif->FormatIdOnglet = 'modif_entite_${id_entite}' ;
					$this->FmtLienModif->FormatTitreOnglet = 'Modifier ${nom_type_entite} ${code}' ;
					$this->FmtLienModif->FormatCheminIcone = 'images/icones/modif.png' ;
					$this->FmtLienModif->ClasseCSS = 'lien-act-001' ;
					$this->FmtLienModif->OptionsOnglet = array('Hauteur' => '300', 'Modal' => 1, 'BoutonFermer' => 0) ;
					$this->FmtLienModif->FormatURL = '?'.urlencode($this->ZoneParent->NomParamScriptAppele).'=modifEntite&idEnCours=${id_entite}' ;
					$this->DefColActions->Formatteur->Liens[] = & $this->FmtLienModif ;
					$this->FmtLienSuppr = new PvConfigFormatteurColonneOuvreFenetre() ;
					$this->FmtLienSuppr->FormatIdOnglet = 'suppr_entite_${id_entite}' ;
					$this->FmtLienSuppr->FormatLibelle = "Supprimer" ;
					$this->FmtLienSuppr->FormatTitreOnglet = 'Supprimer ${nom_type_entite} ${code}' ;
					$this->FmtLienSuppr->OptionsOnglet = array('Hauteur' => '300', 'Modal' => 1, 'BoutonFermer' => 0) ;
					$this->FmtLienSuppr->FormatCheminIcone = 'images/icones/suppr.png' ;
					$this->FmtLienSuppr->ClasseCSS = 'lien-act-002' ;
					$this->FmtLienSuppr->FormatURL = '?'.urlencode($this->ZoneParent->NomParamScriptAppele).'=supprEntite&idEnCours=${id_entite}' ;
					$this->DefColActions->Formatteur->Liens[] = & $this->FmtLienSuppr ;
				}
				$this->TablEntites->DefinitionsColonnes[] = & $this->DefColActions ;
				$this->FltNom = $this->CreeFiltreHttpGet("rechParNom") ;
				$this->FltNom->Libelle = "Nom" ;
				$this->FltNom->ExpressionDonnees = $this->BDEntites->SqlIndexOf("name", "<self>")." > 0" ;
				$this->TablEntites->FiltresSelection[] = & $this->FltNom ;
				$this->FltCode = $this->CreeFiltreHttpGet("rechParCode") ;
				$this->FltCode->Libelle = "Code" ;
				$this->FltCode->ExpressionDonnees = $this->BDEntites->SqlIndexOf("code", "<self>")." > 0" ;
				$this->TablEntites->FiltresSelection[] = & $this->FltCode ;
				$this->FltPays = $this->CreeFiltreHttpGet("rechParPays") ;
				$this->FltPays->Libelle = "Pays" ;
				$this->FltPays->ExpressionDonnees = "idpays=<self>" ;
				$this->ZoneParent->RemplisseurConfig->AppliqueCompListePays($this->FltPays) ;
				$this->TablEntites->FiltresSelection[] = & $this->FltPays ;
				if($this->InclureChoixTypeEntite)
				{
					$this->FltTypeEntite = $this->CreeFiltreHttpGet('idTypeEntite') ;
					$this->FltTypeEntite->Libelle = "Type entit&eacute;" ;
				}
				else
				{
					$this->FltTypeEntite = $this->CreeFiltreFixe('idTypeEntite', $this->IdTypeEntiteParDefaut) ;
				}
				$this->FltTypeEntite->ExpressionDonnees = 'idtype_entite = <self>' ;
				$this->ZoneParent->RemplisseurConfig->AppliqueCompListeTypeEntite($this->FltTypeEntite) ;
				$this->TablEntites->FiltresSelection[] = $this->FltTypeEntite ;
				if(! $this->PourLiaison)
				{
					$this->CmdLienAjout = new PvCommandeOuvreFenetreAdminDirecte() ;
					$this->CmdLienAjout->Libelle = "Ajouter" ;
					$this->CmdLienAjout->NomScript = "ajoutEntite" ;
					$this->CmdLienAjout->TitreOnglet = "Ajout entite" ;
					if(! $this->InclureChoixTypeEntite)
					{
						$this->CmdLienAjout->Parametres = array("idTypeEntite" => $this->IdTypeEntiteParDefaut) ;
					}
					$this->CmdLienAjout->OptionsOnglet = array("Hauteur" => "245", "Modal" => 1, "BoutonFermer" => 0, "BoutonExecuter" => 0) ;
					$this->TablEntites->InscritCommande("cmdAjoutEntite", $this->CmdLienAjout) ;
				}
			}
			protected function RenduDispositifBrut()
			{
				$ctn = $this->TablEntites->RenduDispositif() ;
				return $ctn ;
			}
		}
		class ScriptParamOpChangeTradPlatf extends ScriptListeEntitesTradPlatf
		{
			public $PourLiaison = 1 ;
			public $CheminIcone = "images/icones/paramEtabFinanc.png" ;
		}
		class ScriptParamOpInterTradPlatf extends ScriptParamOpChangeTradPlatf
		{
			public $IdMdlTransact = 2 ;
		}
		
		class ScriptListeBanquesTradPlatf extends ScriptListeEntitesTradPlatf
		{
			public $InclureChoixTypeEntite = 0 ;
			public $IdTypeEntiteParDefaut = 1 ;
		}
		class ScriptListeEtabsFinancTradPlatf extends ScriptListeEntitesTradPlatf
		{
			public $TitreDocument = 'Etablissements financiers' ;
			public $Titre = "Etablissements financiers" ;
			public $InclureChoixTypeEntite = 0 ;
			public $IdTypeEntiteParDefaut = 2 ;
		}
		class ScriptListeCiesAssuranceTradPlatf extends ScriptListeEntitesTradPlatf
		{
			public $TitreDocument = 'Compagnies d\'assurance' ;
			public $InclureChoixTypeEntite = 0 ;
			public $IdTypeEntiteParDefaut = 3 ;
		}
		class ScriptListeGdEntreprisesTradPlatf extends ScriptListeEntitesTradPlatf
		{
			public $TitreDocument = 'Grandes entreprises' ;
			public $InclureChoixTypeEntite = 0 ;
			public $IdTypeEntiteParDefaut = 4 ;
		}
		class ScriptListeTresorsPublTradPlatf extends ScriptListeEntitesTradPlatf
		{
			public $TitreDocument = 'Tr&eacute;sors publiques' ;
			public $InclureChoixTypeEntite = 0 ;
			public $IdTypeEntiteParDefaut = 5 ;
		}
		
		class ScriptAjoutEntiteTradPlatf extends PvScriptWebSimple
		{
			public $FormEntite = null ;
			public $TitreDocument = "Ajout d'entit&eacute; financ." ;
			public $Titre = "Ajout d'entit&eacute; financ." ;
			public $PourLigneEntite = 0 ;
			public $EditerLigneEntite = 1 ;
			public $CmdExecFormEntite = "CmdAjoutEntite" ;
			public $MsgSuccesExecFormEntite = "L'entit&eacute; financ. a &eacute;t&eacute; ajout&eacute;e" ;
			public $InclureChoixTypeEntite = 0 ;
			public $IdTypeEntiteParDefaut = 1 ;
			public $NecessiteMembreConnecte = 1 ;
			public $Privileges = array("admin_operator") ;
			protected function DetermineFormEntite()
			{
				$this->FormEntite = new FormulaireDonneesBaseTradPlatf() ;
				$this->FormEntite->InclureElementEnCours = $this->PourLigneEntite ;
				$this->FormEntite->InclureTotalElements = $this->PourLigneEntite ;
				$this->FormEntite->Editable = $this->EditerLigneEntite ;
				$this->FormEntite->NomClasseCommandeExecuter = $this->CmdExecFormEntite ;
				$this->FormEntite->AdopteScript("formEntite", $this) ;
				$this->ZoneParent->RemplisseurConfig->AppliqueFormEntite($this->FormEntite) ;
				$this->FormEntite->CommandeExecuter->MessageSuccesExecution = $this->MsgSuccesExecFormEntite ;
			}
			public function DetermineEnvironnement()
			{
				$this->DetermineFormEntite() ;
			}
			protected function RenduDispositifBrut()
			{
				$ctn = $this->FormEntite->RenduDispositif() ;
				// print_r($this->FormEntite->FournisseurDonnees) ;
				return $ctn ;
			}
		}
		class ScriptModifEntiteTradPlatf extends ScriptAjoutEntiteTradPlatf
		{
			public $TitreDocument = "Modification entit&eacute; financ." ;
			public $Titre = "Modification entit&eacute; financ." ;
			public $PourLigneEntite = 1 ;
			public $EditerLigneEntite = 1 ;
			public $CmdExecFormEntite = "PvCommandeModifElement" ;
			public $MsgSuccesExecFormEntite = "L'entit&eacute; financ. a &eacute;t&eacute; modifi&eacute;e" ;
		}
		class ScriptSupprEntiteTradPlatf extends ScriptAjoutEntiteTradPlatf
		{
			public $TitreDocument = "Suppression entit&eacute; financ." ;
			public $Titre = "Suppression entit&eacute; financ." ;
			public $PourLigneEntite = 1 ;
			public $EditerLigneEntite = 0 ;
			public $CmdExecFormEntite = "PvCommandeSupprElement" ;
			public $MsgSuccesExecFormEntite = "L'entit&eacute; financ. a &eacute;t&eacute; supprim&eacute;e" ;
		}
		class ScriptRattachEntiteTradPlatf extends ScriptModifEntiteTradPlatf
		{
			public $TitreDocument = "Rattachements entit&eacute;s financ." ;
			public $Titre = "Rattachements entit&eacute;s financ." ;
			public $FormMdlTransacts ;
			public $FormEditLiaisons ;
			public $FltEntitesPossibles ;
			public $FltPaysSelectRef ;
			public $FltMdlDocRef ;
			protected function DetermineFormEntite()
			{
				$this->FormEntite = new FormulaireDonneesBaseTradPlatf() ;
				$this->FormEntite->InclureElementEnCours = $this->PourLigneEntite ;
				$this->FormEntite->InclureTotalElements = $this->PourLigneEntite ;
				$this->FormEntite->Editable = $this->EditerLigneEntite ;
				$this->FormEntite->NomClasseCommandeExecuter = $this->CmdExecFormEntite ;
				$this->FormEntite->AdopteScript("formEntite", $this) ;
				$this->ZoneParent->RemplisseurConfig->AppliqueSommEntite($this->FormEntite) ;
				if($this->FormEntite->EstPasNul($this->FormEntite->CommandeExecuter))
				{
					$this->FormEntite->CommandeExecuter->MessageSuccesExecution = $this->MsgSuccesExecFormEntite ;
				}
			}
			public function DetermineEnvironnement()
			{
				$this->DetermineFormEntite() ;
				$this->InitFormMdlTransacts() ;
				$this->InitFormEditLiaisons() ;
			}
			protected function CreeFormMdlTransact()
			{
				return new FormMdlTransactsTradPlatf() ;
			}
			protected function InitFormMdlTransacts()
			{
				$this->FormMdlTransacts = $this->CreeFormMdlTransact() ;
				$this->FormMdlTransacts->AdopteScript("formMdlDocs", $this) ;
				$this->FormMdlTransacts->ChargeConfig() ;
			}
			protected function InitFormEditLiaisons()
			{
				$this->FormEditLiaisons = new FormLiaisonEntiteTradPlatf() ;
				$this->FormEditLiaisons->AdopteScript("formLiaisons", $this) ;
				$this->FormEditLiaisons->ChargeConfig() ;
			}
			protected function RenduDispositifBrut()
			{
				$ctn = parent::RenduDispositifBrut() ;
				if($this->FormEntite->ElementEnCoursTrouve)
				{
					$ctn .= '<div>&nbsp;</div>' ;
					$ctn .= $this->FormMdlTransacts->RenduDispositif() ;
					$ctn .= '<div>&nbsp;</div>' ;
					$ctn .= $this->FormEditLiaisons->RenduDispositif() ;
				}
				return $ctn ;
			}
		}
		class ScriptRattachOpInterTradPlatf extends ScriptRattachEntiteTradPlatf
		{
			public $TitreDocument = "Rattachements operations inter." ;
			public $Titre = "Rattachements operations inter" ;
			protected function CreeFormMdlTransact()
			{
				$form = new FormMdlTransactsTradPlatf() ;
				$form->IdMdlTransact = 2 ;
				return $form ;
			}
		}
		class ScriptLiaisonsEntiteTradPlatf extends ScriptModifEntiteTradPlatf
		{
			public $TitreDocument = "Consultation operations de change" ;
			public $Titre = "Consultation operations de change" ;
			public $TablLiaisons ;
			public $FltNomEntite ;
			public $FltPays ;
			public $FltTypeEntite ;
			public $DefColNomEntite ;
			public $DefColNomTypeEntite ;
			public $DefColNomPays ;
			public $FormEntite ;
			public $IdMdlTransact = 1 ;
			protected $MdlTransact ;
			protected function DetecteMdlTransact()
			{
				$this->MdlTransact = $this->ApplicationParent->ObtientMdlTransact($this->IdMdlTransact) ;
			}
			public function DetermineEnvironnement()
			{
				parent::DetermineEnvironnement() ;
				$this->DetecteMdlTransact() ;
				if($this->EstNul($this->MdlTransact))
				{
					die("ID de mdl transaction invalide !!!") ;
				}
				$this->DetermineTablLiaisons() ;
			}
			protected function DetermineFormEntite()
			{
				$this->FormEntite = new FormulaireDonneesBaseTradPlatf() ;
				$this->FormEntite->InclureElementEnCours = 1 ;
				$this->FormEntite->InclureTotalElements = 1 ;
				$this->FormEntite->Editable = 0 ;
				$this->FormEntite->InscrireCommandeExecuter = 0 ;
				$this->FormEntite->InscrireCommandeAnnuler = 0 ;
				$this->FormEntite->AdopteScript("formEntite", $this) ;
				$this->ZoneParent->RemplisseurConfig->AppliqueSommEntite($this->FormEntite) ;
			}
			protected function DetermineTablLiaisons()
			{
				$this->TablLiaisons = new TableauDonneesBaseTradPlatf() ;
				$this->TablLiaisons->InclureCmdRafraich = 0 ;
				$this->TablLiaisons->AdopteScript("tablLiaisons", $this) ;
				$this->TablLiaisons->ChargeConfig() ;
				$this->FltNomEntite = $this->CreeFiltreHttpGet('nomEntiteLiaison') ;
				$this->FltNomEntite->ExpressionDonnees = $this->ApplicationParent->BDPrincipale->SqlIndexOf('name', '<self>').' >= 1' ;
				$this->FltNomEntite->Libelle = 'Banque' ;
				$this->TablLiaisons->FiltresSelection[] = & $this->FltNomEntite ;
				$this->FltTypeEntite = $this->TablLiaisons->InsereFltSelectHttpGet('idTypeEntiteLiaison', 'idtype_entite = <self>') ;
				$this->FltTypeEntite->Libelle = 'Type' ;
				$this->ZoneParent->RemplisseurConfig->AppliqueCompListeTypeEntite($this->FltTypeEntite) ;
				$this->FltPaysEntite = $this->TablLiaisons->InsereFltSelectHttpGet('idPaysEntiteLiaison', 'idpays = <self>') ;
				$this->FltPaysEntite->Libelle = 'Pays' ;
				$this->ZoneParent->RemplisseurConfig->AppliqueCompListePays($this->FltPaysEntite) ;
				$flt = $this->TablLiaisons->InsereFltSelectHttpGet('idEnCours', 'id_entite_source=<self>') ;
				$flt->LectureSeule = 1 ;
				$this->DefColNomEntite = $this->TablLiaisons->InsereDefCol("name", "Banque") ;
				$this->DefColNomTypeEntite = $this->TablLiaisons->InsereDefCol("nom_type_entite", "Type entite") ;
				$this->DefColNomPays = $this->TablLiaisons->InsereDefCol("nom_pays", "Pays") ;
				$this->TablLiaisons->FournisseurDonnees = new PvFournisseurDonneesSql() ;
				$this->TablLiaisons->FournisseurDonnees->BaseDonnees = & $this->ApplicationParent->BDPrincipale ;
				$this->TablLiaisons->FournisseurDonnees->RequeteSelection = '(select t1.id_entite_source, t2.*, t3.lib_type_entite nom_type_entite, t4.libpays nom_pays
from '.$this->MdlTransact->NomTableLiaison.' t1
inner join entite t2 on t1.id_entite_dest = t2.id_entite
left join type_entite t3 on t2.idtype_entite = t3.idtype_entite
left join pays t4 on t4.idpays = t2.idpays where top_active=1)' ;
			}
			public function RenduDispositifBrut()
			{
				$ctn = parent::RenduDispositifBrut() ;
				$ctn .= $this->TablLiaisons->RenduDispositif() ;
				// $ctn .= print_r($this->TablLiaisons->FournisseurDonnees->BaseDonnees, true) ;
				return $ctn ;
			}
		}
		class ScriptLiaisonsOpInterTradPlatf extends ScriptLiaisonsEntiteTradPlatf
		{
			public $TitreDocument = "Consultation operations inter." ;
			public $Titre = "Consultation operations inter." ;
			public $IdMdlTransact = 2 ;
		}
		
		class ScriptActivationMembrePublTradPlatf extends PvScriptWebSimple
		{
			public $Titre = 'Activation tr&eacute;sorier' ;
			public $TitreDocument = 'Activation tr&eacute;sorier' ;
			public $TablMembres ;
			public $DefColId ;
			public $DefColLogin ;
			public $DefColNom ;
			public $DefColPrenom ;
			public $DefColStatut ;
			public $DefColBanque ;
			public $DefColActions ;
			public $FltLogin ;
			public $FltStatut ;
			public $FltBanque ;
			public $LienChangeStatut ;
			public $LienActiver ;
			public $LienDesactiver ;
			public $NecessiteMembreConnecte = 1 ;
			public $Privileges = array("admin_members") ;
			public function DetermineEnvironnement()
			{
				parent::DetermineEnvironnement() ;
				$this->TablMembres = new TableauDonneesBaseTradPlatf() ;
				$this->TablMembres->InclureCmdRafraich = 1 ;
				$this->TablMembres->AdopteScript("specifique", $this) ;
				$this->TablMembres->ChargeConfig() ;
				$this->DetermineTablMembres() ;
			}
			protected function DetermineTablMembres()
			{
				$this->TablMembres->FournisseurDonnees = new PvFournisseurDonneesSql() ;
				$this->TablMembres->FournisseurDonnees->BaseDonnees = $this->ApplicationParent->BDPrincipale ;
				$this->TablMembres->FournisseurDonnees->RequeteSelection = "(".$this->ZoneParent->RemplisseurConfigMembership->SqlTousLesMembres($this->TablMembres).")" ;
				$this->DefColId = $this->TablMembres->InsereDefColInvisible("MEMBER_ID") ;
				$this->DefColLogin = $this->TablMembres->InsereDefCol("MEMBER_LOGIN", "Login") ;
				$this->DefColNom = $this->TablMembres->InsereDefCol("MEMBER_LAST_NAME", "Nom") ;
				$this->DefColPrenom = $this->TablMembres->InsereDefCol("MEMBER_FIRST_NAME", "Prenom") ;
				$this->DefColBanque = $this->TablMembres->InsereDefCol("NOM_ENTITE", "Banque") ;
				$this->DefColStatut = new PvDefinitionColonneDonnees() ;
				$this->DefColStatut->Libelle = "Actif" ;
				$this->DefColStatut->AlignElement = "center" ;
				$this->DefColStatut->NomDonnees = "MEMBER_ENABLE" ;
				$this->DefColStatut->Formatteur = new PvFormatteurColonneBooleen() ;
				$this->TablMembres->DefinitionsColonnes[] = & $this->DefColStatut ;
				$this->DefColActions = $this->TablMembres->InsereDefColActions("Actions") ;
				/*
				$this->LienChangeStatut = $this->TablMembres->InsereLienOuvreFenetreAction($this->DefColActions, '?'.urlencode($this->ZoneParent->NomParamScriptAppele).'=changeStatutMembre&idEnCours=${MEMBER_ID}', 'Activer / Desactiver', 'ch_statut_membre_${MEMBER_ID}', 'Changer le statut de ${MEMBER_LOGIN}', array('Hauteur' => 300, 'Modal' => 1, 'Largeur' => 300)) ;
				*/
				$this->LienActiver = $this->TablMembres->InsereLienOuvreFenetreAction($this->DefColActions, '?'.urlencode($this->ZoneParent->NomParamScriptAppele).'=changeStatutMembre&idEnCours=${MEMBER_ID}', 'Activer', 'ch_statut_membre_${MEMBER_ID}', 'Changer le statut de ${MEMBER_LOGIN}', array('Hauteur' => 300, 'Modal' => 1, 'Largeur' => 300)) ;
				$this->LienActiver->NomDonneesValid = "MEMBER_ENABLE" ;
				$this->LienActiver->ValeurVraiValid = 0 ;
				$this->LienActiver->ClasseCSS = "lien-act-003" ;
				$this->LienDesactiver = $this->TablMembres->InsereLienOuvreFenetreAction($this->DefColActions, '?'.urlencode($this->ZoneParent->NomParamScriptAppele).'=changeStatutMembre&idEnCours=${MEMBER_ID}', 'D&eacute;sactiver', 'ch_statut_membre_${MEMBER_ID}', 'Changer le statut de ${MEMBER_LOGIN}', array('Hauteur' => 300, 'Modal' => 1, 'Largeur' => 300)) ;
				$this->LienDesactiver->ClasseCSS = "lien-act-002" ;
				$this->LienDesactiver->NomDonneesValid = "MEMBER_ENABLE" ;
				$this->FltStatut = $this->TablMembres->InsereFltSelectHttpGet('fltStatut', 'MEMBER_ENABLE = <self>', 'PvZoneBoiteSelectHtml') ;
				$this->FltStatut->Libelle = "Actif" ;
				$this->FltStatut->ValeurParDefaut = 1 ;
				$comp = & $this->FltStatut->Composant ;
				$comp->FournisseurDonnees = new PvFournisseurDonneesBool() ;
				$comp->FournisseurDonnees->ChargeConfig() ;
				$comp->NomColonneLibelle = $comp->FournisseurDonnees->NomAttributLibelle ;
				$comp->NomColonneValeur = $comp->FournisseurDonnees->NomAttributValeur ;
				$this->FltLogin = $this->TablMembres->InsereFltSelectHttpGet("fltLogin", "MEMBER_LOGIN = <self>") ;
				$this->FltLogin->Libelle = "Login" ;
				$this->FltBanque = $this->TablMembres->InsereFltSelectHttpGet('fltBanque', 'ID_ENTITE = <self>', 'PvZoneBoiteSelectHtml') ;
				$this->FltBanque->Libelle = "Banque" ;
				$comp = & $this->FltBanque->Composant ;
				$comp->FournisseurDonnees = new PvFournisseurDonneesSql() ;
				$comp->FournisseurDonnees->BaseDonnees = $this->ApplicationParent->BDPrincipale ;
				$comp->FournisseurDonnees->RequeteSelection = "(select * from entite)" ;
				$comp->InclureElementHorsLigne = 1 ;
				$comp->Largeur = "250px" ;
				$comp->NomColonneValeur = "id_entite" ;
				$comp->NomColonneLibelle = "name" ;
			}
			public function RenduSpecifique()
			{
				$ctn = $this->TablMembres->RenduDispositif() ;
				return $ctn ;
			}
		}
		
		class ScriptChStatutMembreTradPlatf extends PvScriptWebSimple
		{
			public $SommMembre ;
			public $FltIdMembre ;
			public $FltLoginMembre ;
			public $FltActiveMembre ;
			public function DetermineEnvironnement()
			{
				parent::DetermineEnvironnement() ;
				$this->DetermineSommMembre() ;
			}
			protected function DetermineSommMembre()
			{
				$this->SommMembre = new PvFormulaireModifDonneesHtml() ;
				$this->SommMembre->AdopteScript("sommMembre", $this) ;
				$this->SommMembre->NomClasseCommandeExecuter = "CmdChStatutMembre" ;
				$this->SommMembre->LibelleCommandeExecuter = "Appliquer" ;
				$this->SommMembre->InscrireCommandeAnnuler = "0" ;
				$this->SommMembre->Editable = 0 ;
				array_splice($this->SommMembre->DispositionComposants, 1, 0, 4) ;
				$this->SommMembre->MaxFiltresEditionParLigne = 1 ;
				$this->SommMembre->ChargeConfig() ;
				$somm = & $this->SommMembre ;
				$this->FltIdMembre = $somm->InsereFltLgSelectHttpGet("idEnCours", "numop = <self>") ;
				$this->FltIdMembre->Obligatoire = 1 ;
				$this->FltLoginMembre = $somm->InsereFltEditHttpPost("loginMembre", "", "PvZoneEtiquetteHtml") ;
				$this->FltLoginMembre->NomParametreDonnees = "login" ;
				$this->FltLoginMembre->Libelle = "Login" ;
				$this->FltActiveMembre = $somm->InsereFltEditHttpPost("ActiveMembre", "", "PvZoneBoiteSelectHtml") ;
				$comp = & $this->FltActiveMembre->Composant ;
				$comp->FournisseurDonnees = new PvFournisseurDonneesBool() ;
				$comp->FournisseurDonnees->ChargeConfig() ;
				$comp->NomColonneLibelle = $comp->FournisseurDonnees->NomAttributLibelle ;
				$comp->NomColonneValeur = $comp->FournisseurDonnees->NomAttributValeur ;
				$this->FltActiveMembre->Libelle = "Actif" ;
				$this->FltActiveMembre->NomParametreDonnees = "active_op" ;
				$somm->FournisseurDonnees = new PvFournisseurDonneesSql() ;
				$somm->FournisseurDonnees->BaseDonnees = & $this->ApplicationParent->BDPrincipale ;
				$somm->FournisseurDonnees->RequeteSelection = "operateur" ;
				$somm->FournisseurDonnees->TableEdition = "operateur" ;
			}
			public function RenduSpecifique()
			{
				$ctn = '' ;
				$ctn .= '<p>Souhaitez-vous changer le statut de ce membre ?</p>' ;
				$ctn .= $this->SommMembre->RenduDispositif() ;
				return $ctn ;
			}
		}
		class CmdChStatutMembre extends PvCommandeExecuterBase
		{
			public $MessageSuccesExecution = 'Le statut du membre a été modifié' ;
			protected function ExecuteInstructions()
			{
				$idMembre = $this->ScriptParent->FltIdMembre->Lie() ;
				$bd = & $this->FormulaireDonneesParent->FournisseurDonnees->BaseDonnees ;
				$ok = $bd->RunSql(
					'update operateur set active_op = case when active_op=0 then 1 else 0 end where numop='.$bd->ParamPrefix.'idEnCours',
					array(
						'idEnCours' => $idMembre,
					)
				) ;
				if(! $ok)
				{
					$this->RenseigneErreur('Erreur SQL : '.$bd->ConnectionException) ;
					return ;
				}
				$this->ConfirmeSucces() ;
				return 1 ;
			}
		}
		class ScriptChStatutMembreOldTradPlatf extends PvScriptWebSimple
		{
			public $FltIdMembre ;
			public $LgnMembreEnCours ;
			public $MsgExec = '' ;
			public $MsgSucces = 'Le statut du membre ${login} a chang&eacute;' ;
			public $MsgEchec = 'Membre inconnu !!!' ;
			public function DetermineEnvironnement()
			{
				parent::DetermineEnvironnement() ;
				$this->MsgExec = $this->MsgEchec ;
				$this->FltIdMembre = $this->CreeFiltreHttpGet('idEnCours') ;
				$bd = $this->ApplicationParent->BDPrincipale ;
				$this->LgnMembreEnCours = $bd->FetchSqlRow('select t1.*, t1.active_op est_actif from operateur t1 where numop='.$bd->ParamPrefix.'idEnCours', array('idEnCours' => $this->FltIdMembre->Lie())) ;
				// print_r($this->LgnMembreEnCours) ;
				if(count($this->LgnMembreEnCours) > 0)
				{
					$ok = $bd->RunSql(
						"update operateur
set active_op=case when active_op=1 then 0 else 1 end
where numop = ".$bd->ParamPrefix."idEnCours",
						array("idEnCours" => $this->LgnMembreEnCours["numop"])
					) ;
					if($ok)
					{
						$this->MsgExec = _parse_pattern($this->MsgSucces, array_map('htmlentities', $this->LgnMembreEnCours)) ;
					}
					else
					{
						$this->MsgExec = $bd->ConnectionException ;
					}
				}
			}
			public function RenduSpecifique()
			{
				$ctn = '<p align="center">'.$this->MsgExec.'</p>' ;
				return $ctn ;
			}
		}
	}
	
?>
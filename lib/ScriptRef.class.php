<?php
	
	if(! defined('SCRIPT_REF_TRAD_PLATF'))
	{
		if(! defined('FORM_REF_TRAD_PLATF'))
		{
			include dirname(__FILE__)."/FormPubl.class.php" ;
		}
		define('SCRIPT_REF_TRAD_PLATF', 1) ;
		
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
				$lienSuppr = $this->TablTypesEntites->InsereLienOuvreFenetreAction($colActs, '?appelleScript=supprTypeEntite&idEnCours=${idtype_entite}', 'Supprimer', 'suppr_type_entite_${idtype_entite}', 'Supprimer type entite', $optsOnglet) ;
				$lienSuppr->ClasseCSS = "lien-act-002" ;
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
				$this->TablPrinc->Largeur = "450" ;
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
				$lienSuppr = $this->TablPrinc->InsereLienOuvreFenetreAction($colActs, '?appelleScript=supprZonePays&idEnCours=${id}', 'Supprimer', 'suppr_region_pays_${id}', 'Supprimer zone de pays', $optsOnglet) ;
				$lienSuppr->ClasseCSS = "lien-act-002" ;
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
		
	}
	
?>
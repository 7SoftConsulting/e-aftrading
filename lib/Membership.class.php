<?php
	
	if(! defined('MEMBERSHIP_TRAD_PLATF'))
	{
		define('MEMBERSHIP_TRAD_PLATF', 1) ;
		
		class RemplisseurConfigMembershipTradPlatf extends PvRemplisseurConfigMembershipAdminDirecte
		{
			public $FiltreVilleOp = null ;
			public $FiltreTypePieceOp = null ;
			public $FiltreNumPieceOp = null ;
			public $FiltreNationaliteOp = null ;
			public $FiltreProfessionOp = null ;
			public $FiltreTelBureauOp = null ;
			public $FiltreTelFixeOp = null ;
			public $FiltreFonctionOp = null ;
			public $FiltreFaxOp = null ;
			public $FiltreIdEntiteOp = null ;
			public $DefColFonctionOp ;
			public $NomClasseLienModifTableauMembre = "PvConfigFormatteurColonneOuvreFenetre" ;
			public $NomClasseLienChangeMPTableauMembre = "PvConfigFormatteurColonneOuvreFenetre" ;
			public $NomClasseLienSupprTableauMembre = "PvConfigFormatteurColonneOuvreFenetre" ;
			public $NomClasseLienModifTableauRole = "PvConfigFormatteurColonneOuvreFenetre" ;
			public $NomClasseLienSupprTableauRole = "PvConfigFormatteurColonneOuvreFenetre" ;
			public $NomClasseLienModifTableauProfil = "PvConfigFormatteurColonneOuvreFenetre" ;
			public $NomClasseLienSupprTableauProfil = "PvConfigFormatteurColonneOuvreFenetre" ;
			public $OptsOngletMembre = array('Largeur' => 750, 'Hauteur' => 372, 'Modal' => 1, "BoutonFermer" => 0) ;
			public $OptsOngletProfil = array('Largeur' => 420, 'Hauteur' => 372, 'Modal' => 1, "BoutonFermer" => 0) ;
			public $OptsOngletRole = array('Largeur' => 420, 'Hauteur' => 372, 'Modal' => 1, "BoutonFermer" => 0) ;
			public $CmdAjoutMembre ;
			public $DefColEntiteMembre ;
			public $DefColFonctionMembre ;
			public function RemplitFiltresEditionFormMembre(& $form)
			{
				parent::RemplitFiltresEditionFormMembre($form) ;
				$membership = $form->ZoneParent->Membership ;
				$this->FiltreVilleOp = $form->ScriptParent->CreeFiltreHttpPost("villeOp") ;
				$this->FiltreVilleOp->Libelle = "Ville" ;
				$this->FiltreVilleOp->NomColonneLiee = $membership->CityMemberColumn ;
				$this->FiltreVilleOp->NomParametreDonnees = $membership->CityMemberColumn ;
				$form->FiltresEdition[] = & $this->FiltreVilleOp ;
				$this->FiltreTypePieceOp = $form->ScriptParent->CreeFiltreHttpPost("typePieceOp") ;
				$this->FiltreTypePieceOp->Libelle = "Type de Pi&egrave;ce" ;
				$this->FiltreTypePieceOp->NomColonneLiee = $membership->IdentityTypeMemberColumn ;
				$this->FiltreTypePieceOp->NomParametreDonnees = $membership->IdentityTypeMemberColumn ;
				$form->FiltresEdition[] = & $this->FiltreTypePieceOp ;
				$this->FiltreNumPieceOp = $form->ScriptParent->CreeFiltreHttpPost("numPieceOp") ;
				$this->FiltreNumPieceOp->Libelle = "Num&eacute;ro de la Pi&egrave;ce" ;
				$this->FiltreNumPieceOp->NomColonneLiee = $membership->IdentityCodeMemberColumn ;
				$this->FiltreNumPieceOp->NomParametreDonnees = $membership->IdentityCodeMemberColumn ;
				$form->FiltresEdition[] = & $this->FiltreNumPieceOp ;
				$this->FiltreNationaliteOp = $form->ScriptParent->CreeFiltreHttpPost("nationaliteOp") ;
				$this->FiltreNationaliteOp->Libelle = "Nationalit&eacute;" ;
				$this->FiltreNationaliteOp->NomColonneLiee = $membership->NationalityMemberColumn ;
				$this->FiltreNationaliteOp->NomParametreDonnees = $membership->NationalityMemberColumn ;
				$form->FiltresEdition[] = & $this->FiltreNationaliteOp ;
				$this->FiltreTelMobileOp = $form->ScriptParent->CreeFiltreHttpPost("telMobileOp") ;
				$this->FiltreTelMobileOp->Libelle = "Tel. Mobile" ;
				$this->FiltreTelMobileOp->NomColonneLiee = $membership->MobilePhoneMemberColumn ;
				$this->FiltreTelMobileOp->NomParametreDonnees = $membership->MobilePhoneMemberColumn ;
				$form->FiltresEdition[] = & $this->FiltreTelMobileOp ;
				$this->FiltreTelDomicileOp = $form->ScriptParent->CreeFiltreHttpPost("telDomicileOp") ;
				$this->FiltreTelDomicileOp->Libelle = "Tel. Domicile" ;
				$this->FiltreTelDomicileOp->NomColonneLiee = $membership->HomePhoneMemberColumn ;
				$this->FiltreTelDomicileOp->NomParametreDonnees = $membership->HomePhoneMemberColumn ;
				$form->FiltresEdition[] = & $this->FiltreTelDomicileOp ;
				$this->FiltreTelBureauOp = $form->ScriptParent->CreeFiltreHttpPost("telBureauOp") ;
				$this->FiltreTelBureauOp->Libelle = "Tel. Bureau" ;
				$this->FiltreTelBureauOp->NomColonneLiee = $membership->BusinessPhoneMemberColumn ;
				$this->FiltreTelBureauOp->NomParametreDonnees = $membership->BusinessPhoneMemberColumn ;
				$form->FiltresEdition[] = & $this->FiltreTelBureauOp ;
				$this->FiltreFonctionOp = $form->ScriptParent->CreeFiltreHttpPost("fonctionOp") ;
				$this->FiltreFonctionOp->Libelle = "Fonction" ;
				$this->FiltreFonctionOp->DefinitColLiee($membership->FunctionMemberColumn) ;
				$form->FiltresEdition[] = & $this->FiltreFonctionOp ;
				$this->FiltreFaxOp = $form->ScriptParent->CreeFiltreHttpPost("faxOp") ;
				$this->FiltreFaxOp->Libelle = "Fax" ;
				$this->FiltreFaxOp->DefinitColLiee($membership->FaxMemberColumn) ;
				$form->FiltresEdition[] = & $this->FiltreFaxOp ;
				if(! $form->ZoneParent->PossedePrivilege('admin_members') && $form->ZoneParent->ValeurParamScriptAppele != "inscription")
				{
					$this->FiltreEntiteOp = $form->ScriptParent->CreeFiltreFixe("entiteOp", $membership->MemberLogged->RawData["ID_ENTITE_MEMBRE"]) ;
					$fltProfilEdit = $form->ScriptParent->CreeFiltreFixe('idProfilEdit', 1) ;
					$fltProfilEdit->ExpressionDonnees = $membership->ProfileMemberForeignKey.' not in (<self>, 1)' ;
					$form->FiltreProfilMembre->Composant->FiltresSelection[] = & $fltProfilEdit ;
					$form->FiltreActiverMembre->Invisible = 1 ;
					$form->FiltreActiverMembre->ValeurParDefaut = 0 ;
				}
				else
				{
					$this->FiltreEntiteOp = $form->ScriptParent->CreeFiltreHttpPost("entiteOp") ;
					$this->FiltreEntiteOp->Libelle = "Entit&eacute;" ;
					$this->FiltreEntiteOp->DeclareComposant("PvZoneBoiteSelectHtml") ;
					$this->FiltreEntiteOp->Composant->FournisseurDonnees = new PvFournisseurDonneesSql() ;
					$this->FiltreEntiteOp->Composant->FournisseurDonnees->BaseDonnees = $form->ApplicationParent->BDPrincipale ;
					$this->FiltreEntiteOp->Composant->Largeur = "250px" ;
					$this->FiltreEntiteOp->Composant->FournisseurDonnees->RequeteSelection = "entite" ;
					$this->FiltreEntiteOp->Composant->NomColonneValeur = "id_entite" ;
					$this->FiltreEntiteOp->Composant->NomColonneLibelle = "name" ;
				}
				$this->FiltreEntiteOp->NomColonneLiee = $membership->ColIdEntiteMembre ;
				$this->FiltreEntiteOp->NomParametreDonnees = $membership->ColIdEntiteMembre ;
				$form->FiltresEdition[] = & $this->FiltreEntiteOp ;
				$form->DessinateurFiltresEdition = new PvDessinateurRenduHtmlFiltresDonnees() ;
				$form->DessinateurFiltresEdition->MaxFiltresParLigne = 2 ;
				$form->RemplaceCommandeAnnuler("PvCmdFermeFenetreActiveAdminDirecte") ;
				$form->CommandeAnnuler->Libelle = "Fermer" ;
				$critrTemp = new PvCritereNonVide() ;
				$form->CommandeExecuter->InscritCritere($critrTemp) ;
				$critrTemp->FiltresCibles = array(&$this->FiltreFonctionOp, &$this->FiltreTelBureauOp)  ;
			}
			public function SqlTousLesMembres(& $table)
			{
				$sql = 'select t1.*, t2.id_entite ID_ENTITE, t3.name NOM_ENTITE from ('.$table->ZoneParent->Membership->SqlAllMembers().') t1 inner join operateur t2 on t1.MEMBER_ID=t2.numop left join entite t3 on t2.id_entite = t3.id_entite' ;
				// $sql = $table->ZoneParent->Membership->SqlAllMembers() ;
				return $sql ;
			}
			public function InitTableauMembre(& $table)
			{
				$membership = $table->ZoneParent->Membership ;
				$table->ToujoursAfficher = 1 ;
				$table->FournisseurDonnees->BaseDonnees = $membership->Database ;
				$table->FournisseurDonnees->RequeteSelection = '('.$this->SqlTousLesMembres($table).')' ;
				$table->TitreBoutonSoumettreFormulaireFiltres = "Valider" ;
			}
			public function InitTableauProfil(& $table)
			{
				$table->ToujoursAfficher = 1 ;
				$table->TitreBoutonSoumettreFormulaireFiltres = "Valider" ;
				parent::InitTableauProfil($table) ;
			}
			public function InitTableauRole(& $table)
			{
				$table->ToujoursAfficher = 1 ;
				$table->TitreBoutonSoumettreFormulaireFiltres = "Valider" ;
				parent::InitTableauRole($table) ;
			}
			public function RemplitDefinitionsColonneTableauMembre(& $table)
			{
				parent::RemplitDefinitionsColonneTableauMembre($table) ;
				$membership = $table->ZoneParent->Membership ;
				$this->DefColEntiteMembre = $table->InsereDefCol('NOM_ENTITE_MEMBRE', 'Entite') ;
				$this->DefColEntiteMembre->Largeur = "12%" ;
				$this->DefColFonctionMembre = $table->InsereDefCol('FONCTION_MEMBRE', 'Fonction') ;
				$this->DefColFonctionMembre->Largeur = "10%" ;
			}
			public function RemplitFiltresTableauMembre(& $table)
			{
				parent::RemplitFiltresTableauMembre($table) ;
				$membership = $table->ZoneParent->Membership ;
				if(! $table->ZoneParent->PossedePrivilege('admin_members'))
				{
					if($table->ZoneParent->PossedePrivilege('admin_operator'))
					{
						$table->InsereFltSelectFixe("idEntiteRestr", $membership->MemberLogged->RawData["ID_ENTITE_MEMBRE"], 'id_entite=<self>') ;
					}
				}
			}
			public function RemplitDefinitionColActionsTableauMembre(& $table)
			{
				parent::RemplitDefinitionColActionsTableauMembre($table) ;
				$indiceColActs = count($table->DefinitionsColonnes) - 1 ;
				foreach($table->DefinitionsColonnes[$indiceColActs]->Formatteur->Liens as $i => $lienTemp)
				{
					$lien = & $table->DefinitionsColonnes[$indiceColActs]->Formatteur->Liens[$i] ;
					$lien->OptionsOnglet = array_merge($lien->OptionsOnglet, $this->OptsOngletMembre) ;
				}
				$table->DefinitionsColonnes[$indiceColActs]->Formatteur->Liens[0]->ClasseCSS = "lien-act-001" ;
				$table->DefinitionsColonnes[$indiceColActs]->Formatteur->Liens[1]->ClasseCSS = "lien-act-005" ;
				$table->DefinitionsColonnes[$indiceColActs]->Formatteur->Liens[1]->FormatLibelle = "Mot de passe" ;
				$table->DefinitionsColonnes[$indiceColActs]->Formatteur->Liens[count($table->DefinitionsColonnes[$indiceColActs]->Formatteur->Liens) - 1]->Visible = 0 ;
				$this->CmdAjoutMembre = new PvCommandeOuvreFenetreAdminDirecte() ;
				$this->CmdAjoutMembre->Libelle = "Ajouter" ;
				$this->CmdAjoutMembre->Url = $table->ZoneParent->ObtientUrlScript("ajoutMembre") ;
				$this->CmdAjoutMembre->IdOnglet = "ajout_membre" ;
				$this->CmdAjoutMembre->TitreOnglet = "Ajouter un tr&eacute;sorier" ;
				$this->CmdAjoutMembre->OptionsOnglet = array(
					"Largeur" => 720,
					"Hauteur" => 350,
					"Modal" => 1,
					"BoutonFermer" => 0,
				) ;
				$table->InscritCommande("ajoutMembre", $this->CmdAjoutMembre) ;
				$table->InscritCmdRafraich("Actualiser", "images/icones/actualiser.png") ;
			}
			public function RemplitDefinitionColActionsTableauProfil(& $table)
			{
				parent::RemplitDefinitionColActionsTableauProfil($table) ;
				$indiceColActs = count($table->DefinitionsColonnes) - 1 ;
				foreach($table->DefinitionsColonnes[$indiceColActs]->Formatteur->Liens as $i => $lienTemp)
				{
					$lien = & $table->DefinitionsColonnes[$indiceColActs]->Formatteur->Liens[$i] ;
					$lien->OptionsOnglet = array_merge($lien->OptionsOnglet, $this->OptsOngletProfil) ;
				}
			}
			public function RemplitDefinitionColActionsTableauRole(& $table)
			{
				parent::RemplitDefinitionColActionsTableauRole($table) ;
				$indiceColActs = count($table->DefinitionsColonnes) - 1 ;
				foreach($table->DefinitionsColonnes[$indiceColActs]->Formatteur->Liens as $i => $lienTemp)
				{
					$lien = & $table->DefinitionsColonnes[$indiceColActs]->Formatteur->Liens[$i] ;
					$lien->OptionsOnglet = array_merge($lien->OptionsOnglet, $this->OptsOngletRole) ;
				}
			}
			public function InitFormulaireMembre(& $form)
			{
				parent::InitFormulaireMembre($form) ;
				$form->RemplaceCommandeAnnuler("PvCmdFermeFenetreActiveAdminDirecte") ;
			}
			public function InitFormulaireRole(& $form)
			{
				parent::InitFormulaireRole($form) ;
				$form->RemplaceCommandeAnnuler("PvCmdFermeFenetreActiveAdminDirecte") ;
			}
			public function InitFormulaireProfil(& $form)
			{
				parent::InitFormulaireProfil($form) ;
				$form->RemplaceCommandeAnnuler("PvCmdFermeFenetreActiveAdminDirecte") ;
			}
		}
		
		class MembershipTradPlatf extends AkSqlMembership
		{
			public $MemberTable = "operateur" ;
			public $IdMemberColumn = "numop" ;
			public $LoginMemberColumn = "login" ;
			public $PasswordMemberColumn = "motpasse" ;
			public $PasswordMemberExpr = "PASSWORD" ;
			public $EmailMemberColumn = "email_op" ;
			public $FirstNameMemberColumn = "nomop" ;
			public $LastNameMemberColumn = "prenomop" ;
			public $AddressMemberColumn = "adresspostop" ;
			public $ContactMemberColumn = "" ;
			public $MobilePhoneMemberColumn = "tel_cellop" ;
			public $HomePhoneMemberColumn = "tel_domop" ;
			public $BusinessPhoneMemberColumn = "tel_burop" ;
			public $NationalityMemberColumn = "nationaliteop" ;
			public $IdentityTypeMemberColumn = "typepieceop" ;
			public $IdentityCodeMemberColumn = "numpieceop" ;
			public $CityMemberColumn = "villeop" ;
			public $FunctionMemberColumn = "fonction" ;
			public $FaxMemberColumn = "fax" ;
			public $ColIdEntiteMembre = "id_entite" ;
			public $ADActivatedMemberColumn = "" ;
			public $ADActivatedMemberTrueValue = "1" ;
			public $ADUserMemberColumn = '' ;
			public $ADUserMemberAlias = '' ;
			public $ADDomainMemberDefaultValue = '' ;
			public $ADDomainMemberColumn = '' ;
			public $ADDomainMemberAlias = '' ;
			public $EnableMemberColumn = "active_op" ;
			public $EnableMemberAlias = "" ;
			public $EnableMemberTrueValue = "1" ;
			public $MustChangePasswordMemberColumn = "" ;
			public $MustChangePasswordMemberTrueValue = "1" ;
			public $ProfileMemberColumn = "Type_op" ;
			public $ProfileMemberForeignKey = "AUTH_PROFIL_ID" ;
			public $ProfileTable = "auth_profil" ;
			public $IdProfileColumn = "AUTH_PROFIL_ID" ;
			public $TitleProfileColumn = "AUTH_PROFIL_TITLE" ;
			public $DescriptionProfileColumn = "AUTH_PROFIL_DESC" ;
			public $EnableProfileColumn = "AUTH_PROFIL_ENABLED" ;
			public $EnableProfileTrueValue = "1" ;
			public $PrivilegeTable = "auth_action" ;
			public $IdPrivilegeColumn = "AUTH_ACTION_ID" ;
			public $EnablePrivilegeColumn = "AUTH_ACTION_ENABLED" ;
			public $EnablePrivilegeTrueValue = "1" ;
			public $ProfilePrivilegeColumn = "AUTH_ACTION_PROFIL_ID" ;
			public $ProfilePrivilegeForeignKey = "AUTH_PROFIL_ID" ;
			public $RolePrivilegeColumn = "AUTH_ACTION_PRIVILEGE_ID" ;
			public $RolePrivilegeForeignKey = "AUTH_PRIVILEGE_ID" ;
			public $RoleTable = "auth_privilege" ;
			public $IdRoleColumn = "AUTH_PRIVILEGE_ID" ;
			public $NameRoleColumn = "AUTH_PRIVILEGE_NAME" ;
			public $TitleRoleColumn = "AUTH_PRIVILEGE_TITLE" ;
			public $DescriptionRoleColumn = "AUTH_PRIVILEGE_DESC" ;
			public $EnableRoleColumn = "AUTH_PRIVILEGE_ENABLED" ;
			public $EnableRoleTrueValue = "1" ;
			public $MemberClassName = "MembreTradTradf" ;
			public $SessionTimeout = 5 ;
			protected function InitConfig(& $parent)
			{
				parent::InitConfig($parent) ;
				$this->Database = & $parent->ApplicationParent->BDPrincipale ;
			}
			protected function ExtraColsAllMembers()
			{
				$sql = '' ;
				$sql .= ', MEMBER_TABLE.fonction FONCTION_MEMBRE' ;
				$sql .= ', MEMBER_TABLE.id_entite ID_ENTITE_MEMBRE' ;
				$sql .= ', TABLE_ENTITE.idtype_entite ID_TYPE_ENTITE_MEMBRE' ;
				$sql .= ', TABLE_ENTITE.name NOM_ENTITE_MEMBRE' ;
				$sql .= ', TABLE_ENTITE.code CODE_ENTITE' ;
				/*
				*/
				return $sql ;
			}
			protected function ExtraExprAllMembers()
			{
				$sql = '' ;
				$sql .= ' LEFT JOIN entite TABLE_ENTITE ON MEMBER_TABLE.id_entite = TABLE_ENTITE.id_entite' ;
				return $sql ;
			}
		}
		class MembreTradTradf extends AkMember
		{
		}
	}
	
?>
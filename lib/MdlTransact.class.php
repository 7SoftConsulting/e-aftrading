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
		
		define("TXT_SQL_SELECT_LIAISON_ENTREPRISE_TRAD_PLATF", "(SELECT t1.*, t2.*
FROM entite t1
left join rel_entreprise t2 on t1.id_entite = t2.id_entite_dest
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
		
		class FmtMonnaieEtiqTradPlatf extends PvFmtMonnaieEtiquetteFiltre
		{
			public $MaxDecimals = 0 ;
		}
		class ZoneMonnaieTradPlatf extends PvZoneTexteHtml
		{
			public $AttrsSupplHtml = array('autocomplete' => 'off') ;
		}
		
		class ActDicussChatTransactTradPlatf extends PvActionRenduPageWeb
		{
			protected $ModeleTransact = "transact_base" ;
			protected $UseTable = 0 ;
			protected $LgnTransact = array() ;
			public $IdTransact = "0" ;
			protected $Discuss ;
			public function __construct()
			{
				$this->InstallePreReqs() ;
			}
			protected function ObtientChemFicDiscuss()
			{
				return dirname(__FILE__)."/../donnees/chat/".$this->ModeleTransact."/".$this->IdTransact.".dat" ;
			}
			protected function InstallePreReqs()
			{
				$this->IdTransact = (isset($_GET["idEnCours"])) ? $_GET["idEnCours"] : 0 ;
				$this->Discuss = new DiscussTransactTradPlatf() ;
			}
			protected function ChargeDiscuss()
			{
				$chemFic = $this->ObtientChemFicDiscuss() ;
				if(file_exists($chemFic))
				{
					$ctnBrut = '' ;
					$fh = fopen($chemFic, "r") ;
					while(! feof($fh))
					{
						$ctnBrut .= fgets($fh) ;
					}
					fclose($fh) ;
					if($ctnBrut != '')
					{
						try { $this->Discuss = unserialize($ctnBrut) ; }
						catch(Exception $ex) { }
					}
				}
			}
			protected function SauveDiscuss()
			{
				$chemFic = $this->ObtientChemFicDiscuss() ;
				$fh = fopen($chemFic, "w") ;
				if($fh !== false)
				{
					fputs($fh, serialize($this->Discuss)) ;
					fclose($fh) ;
				}
			}
			protected function PosteMsgRecu()
			{
				if(! isset($_POST["msg"]) || ! isset($_POST["emetteur"]) || ! isset($_POST["dest"]))
				{
					return ;
				}
				$ctn = $_POST["msg"] ;
				$emetteur = $_POST["emetteur"] ;
				$dest = $_POST["dest"] ;
				$msg = new MsgDiscussTransactTradPlatf() ;
				$msg->Dest = $dest ;
				$msg->Emetteur = $emetteur ;
				$msg->Contenu = $ctn ;
				$this->Discuss->Messages[] = $msg ;
				$this->SauveDiscuss() ;
			}
			public function Execute()
			{
				$this->ChargeDiscuss() ;
				$this->PosteMsgRecu() ;
				$this->AfficheEntetes() ;
				parent::Execute() ;
			}
			protected function AfficheEntetes()
			{
				Header("Pragma: public") ;
				Header("Expires: 0") ;
				Header("Cache-Control: must-revalidate, post-check=0, pre-check=0") ;
			}
			protected function RenduCorpsDoc()
			{
				echo '<!doctype html><html><head><meta charset="utf-8"></head>' ;
				echo '<style type="text/css">body { font-family:arial; font-size:12px }</style>' ;
				echo '<script language="javascript">function defileEnBas() { window.scrollTo(0, document.body.scrollHeight || document.documentElement.scrollHeight); }</script>' ;
				echo '<body onload="defileEnBas()">' ;
				if(count($this->Discuss->Messages) > 0)
				{
					foreach($this->Discuss->Messages as $i => $msg)
					{
						echo '<p><b>'.htmlentities($msg->Emetteur).'</b> : '.htmlentities($msg->Contenu).'</p>' ;
					}
				}
				else
				{
					echo "<p>(Aucun message post&eacute;)</p>" ;
				}
				echo '</body></html>' ;
			}
		}
		class DiscussTransactTradPlatf
		{
			public $Messages = array() ;
		}
		class MsgDiscussTransactTradPlatf
		{
			public $Emetteur ;
			public $Dest ;
			public $Contenu ;
			public $TimestampCrea ;
		}
		
		class ScriptBaseTradPlatf extends PvScriptWebSimple
		{
			protected function BDPrinc()
			{
				return $this->ApplicationParent->BDPrincipale ;
			}
			protected function & CreeFournDonneesPrinc()
			{
				$fourn = new PvFournisseurDonneesSql() ;
				$fourn->BaseDonnees = $this->ApplicationParent->BDPrincipale ;
				return $fourn ;
			}
			protected function & CreeFournBDPrinc()
			{
				$fourn = $this->CreeFournDonneesPrinc() ;
				return $fourn ;
			}
		}
		class ScriptLstBaseTradPlatf extends ScriptBaseTradPlatf
		{
			protected $TablPrinc ;
			protected function CreeTablPrinc()
			{
				return new TableauDonneesBaseTradPlatf() ;
			}
			protected function InitTablPrinc()
			{
			}
			protected function ChargeTablPrinc()
			{
			}
			public function DetermineEnvironnement()
			{
				parent::DetermineEnvironnement() ;
				$this->DetermineTablPrinc() ;
			}
			protected function DetermineTablPrinc()
			{
				$this->TablPrinc = $this->CreeTablPrinc() ;
				$this->InitTablPrinc() ;
				$this->TablPrinc->AdopteScript("tablPrinc", $this) ;
				$this->TablPrinc->ChargeConfig() ;
				$this->ChargeTablPrinc() ;
			}
			protected function RenduDispositifBrut()
			{
				$ctn = '' ;
				$ctn .= $this->TablPrinc->RenduDispositif() ;
				return $ctn ;
			}
		}
		class ScriptEditBaseTradPlatf extends ScriptBaseTradPlatf
		{
			protected $FormPrinc ;
			protected function CreeFormPrinc()
			{
				return new FormulaireDonneesBaseTradPlatf() ;
			}
			protected function InitFormPrinc()
			{
			}
			protected function ChargeFormPrinc()
			{
			}
			public function DetermineEnvironnement()
			{
				parent::DetermineEnvironnement() ;
				$this->DetermineFormPrinc() ;
			}
			protected function DetermineFormPrinc()
			{
				$this->FormPrinc = $this->CreeFormPrinc() ;
				$this->InitFormPrinc() ;
				$this->FormPrinc->AdopteScript("formPrinc", $this) ;
				$this->FormPrinc->ChargeConfig() ;
				$this->ChargeFormPrinc() ;
			}
			protected function RenduDispositifBrut()
			{
				$ctn = '' ;
				$ctn .= $this->FormPrinc->RenduDispositif() ;
				return $ctn ;
			}
		}
		
		class FormulaireDonneesBaseTradPlatf extends PvFormulaireDonneesHtml
		{
			public $LibelleCommandeAnnuler = "Fermer" ;
			public $LibelleCommandeExecuter = "Valider" ;
		}
		class TableauDonneesBaseTradPlatf extends PvTableauDonneesAdminDirecte
		{
			public $ToujoursAfficher = 1 ;
			public $TitreBoutonSoumettreFormulaireFiltres = "Valider" ;
		}
		class TableauDonneesOperationTradPlatf extends TableauDonneesBaseTradPlatf
		{
			public $InclureCmdRafraich = 0 ;
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
		
		class MdlRelEntrepriseTradPlatf extends MdlTransactBaseTradPlatf
		{
			public $Id = 3 ;
			public $Titre = "Entreprise" ;
			public $NomTableLiaison = "rel_entreprise" ;
			public $RequeteSelection = TXT_SQL_SELECT_LIAISON_ENTREPRISE_TRAD_PLATF ;
			public $IdsTypeEntiteSource = array(4) ;
			public $IdsTypeEntiteDest = array(1, 2) ;
			public $NomScriptRattach = 'rattachRelEntreprise' ;
			public $NomScriptLiaisons = 'liaisonsRelEntreprise' ;
		}
		
		class ScriptTransactBaseTradPlatf extends PvScriptWebSimple
		{
			protected function BDPrinc()
			{
				return $this->ApplicationParent->BDPrincipale ;
			}
			protected function CreeFournDonneesPrinc()
			{
				$fourn = new PvFournisseurDonneesSql() ;
				$fourn->BaseDonnees = $this->ApplicationParent->BDPrincipale ;
				return $fourn ;
			}
			protected function ArchiveAncTransacts()
			{
				// echo $sql1 ;
				$this->ZoneParent->ArchiveAncTransacts() ;
			}
			protected function EstPeriodeTransact()
			{
				// echo "Heure : ".gmdate("G") ;
				return true ;
				// return gmdate("G") >= 6 && gmdate("G") <= 23 ;
			}
			public function RenduPeriodeIndisponible()
			{
				return '<div class="ui-state-error">Les transactions sont interdites dans cette p&eacute;riode.</div>' ;
			}
			public function RenduDispositif()
			{
				// $this->ArchiveAncTransacts() ;
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
			protected function NotifieAccuseLecture($nomTable, $nomColId="num_op_change")
			{
				$bd = $this->ApplicationParent->BDPrincipale ;
				$bd->DeleteRow(
					$nomTable,
					$nomColId.'=:'.$nomColId.' and numop=:numop',
					array(
						$nomColId => intval(_GET_def('idEnCours')),
						'numop' => $this->ZoneParent->IdMembreConnecte()
					)
				) ;
				$bd->InsertRow(
					$nomTable,
					array(
						$nomColId => intval(_GET_def('idEnCours')),
						'numop' => $this->ZoneParent->IdMembreConnecte()
					)
				) ;
				// print_r($bd) ;
			}
		}
		class ScriptChatTransactTradPlatf extends ScriptFormTransactBaseTradPlatf
		{
			public $FormPrinc ;
			protected $ActDicussChat ;
			protected $DelaiRafraichDiscuss = DELAI_RAFRAICH_CHAT_TRAD_PLATF ;
			protected $NomColLoginEmetteur = "login_soumis" ;
			protected $NomParamIdEnCours = "idEnCours" ;
			protected function DetermineActDicussChat()
			{
				$this->ActDicussChat = $this->InsereActionAvantRendu("chat", $this->CreeActDiscussChat()) ;
				$this->ActDicussChat->ChargeConfig() ;
			}
			public function DetermineEnvironnement()
			{
				$this->DetermineActDicussChat() ;
				$this->DetermineFormPrinc() ;
			}
			protected function DetermineFormPrinc()
			{
				$this->FormPrinc = $this->CreeFormPrinc() ;
				$this->FormPrinc->AdopteScript("formPrinc", $this) ;
				$this->FormPrinc->ChargeConfig() ;
			}
			protected function CreeFormPrinc()
			{
				return new PvFormulaireDonneesHtml() ;
			}
			protected function CreeActDiscussChat()
			{
				return new ActDicussChatTransactTradPlatf() ;
			}
			public function RenduSpecifique()
			{
				$ctn = '' ;
				$ctn .= '<table width="100%" cellpadding="2" cellspacing="0">'.PHP_EOL ;
				$ctn .= '<tr>' ;
				$ctn .= '<td width="50%" valign="top">' ;
				$ctn .= $this->FormPrinc->RenduDispositif() ;
				$ctn .= '</td>'.PHP_EOL ;
				$ctn .= '<td width="*" valign="top">'.PHP_EOL ;
				$ctn .= $this->RenduChat().PHP_EOL ;
				$ctn .= '</td>'.PHP_EOL ;
				$ctn .= '</tr>'.PHP_EOL ;
				$ctn .= '</table>' ;
				return $ctn ;
			}
			protected function RenduChat()
			{
				$ctn = '' ;
				$loginEmetteur = $this->ZoneParent->LoginMembreConnecte() ;
				$loginDest = $this->FormPrinc->ElementEnCours[$this->NomColLoginEmetteur] ;
				$urlChat = $this->ActDicussChat->ObtientUrl(array($this->NomParamIdEnCours => _GET_def($this->NomParamIdEnCours))) ;
				$ctn .= '<table width="100%" cellspacing="0" cellpadding="0">' ;
				$ctn .= '<tr>' ;
				$ctn .= '<td class="ui-widget ui-widget-content ui-state-default">Chat</td>' ;
				$ctn .= '</tr>'.PHP_EOL ;
				$ctn .= '<tr>' ;
				$ctn .= '<td>' ;
				$ctn .= '<form action="'.$urlChat.'" method="post" target="discuss_chat">
<input type="hidden" name="emetteur" value="'.htmlentities($loginEmetteur).'" />
<input type="hidden" name="dest" value="'.htmlentities($loginDest).'" />
<table width=100% cellspacing="0" cellpadding="0">
<tr>
<td>
<textarea name="msg" value="" cols="45" rows="4"></textarea>
</td>
<td>
<input id="btn-soumet-chat" class="ui-widget ui-widget-content ui-state-active" type="button" value="poster" onclick="posteMsgDiscuss(this)" />
<p></p>
<input id="btn-rafraich-chat" class="ui-widget ui-widget-content ui-state-active" type="button" value="actualiser" onclick="rafraichitDiscuss(this)" />
</td>
</tr>
</table>
</form>' ;
				$ctn .= '<br/></td>'.PHP_EOL ;
				$ctn .= '</tr>'.PHP_EOL ;
				$ctn .= '<tr>'.PHP_EOL ;
				$ctn .= '<td class="ui-widget ui-widget-content">' ;
				// echo $urlChat ;
				$delaiRafraichDiscuss = $this->DelaiRafraichDiscuss * 1000 ;
				$ctn .= '<iframe name="discuss_chat" src="'.$urlChat.'" style="width:99%; height:270px" frameborder="0"></iframe>'.PHP_EOL ;
				$ctn .= '<script type="text/javascript">
	var idRafraich ;
	function rafraichitDiscuss()
	{
		if(idRafraich > 0)
		{
			clearTimeout(idRafraich) ;
		}
		var frame = document.getElementsByName("discuss_chat")[0] ;
		frame.src = "'.$urlChat.'&tid=" + (new Date().getTime()) + "" ;
		idRafraich = setTimeout("rafraichitDiscuss()", '.$delaiRafraichDiscuss.') ;
	}
	function posteMsgDiscuss(btn)
	{
		btn.form.submit() ;
		document.getElementsByName("msg")[0].value = "" ;
	}
	jQuery(function() {
		rafraichitDiscuss() ;
	}) ;
</script>' ;
				$ctn .= '</td>'.PHP_EOL ;
				$ctn .= '</tr>'.PHP_EOL ;
				$ctn .= '</table>'.PHP_EOL ;
				return $ctn ;
			}
		}
		
		class ScriptListBaseOpChange extends ScriptListTransactBaseTradPlatf
		{
			public $Tableau ;
			public $BarreMenu ;
			public $TypeOpChange = 1 ;
			public $Privileges = array('post_op_change') ;
			public $NecessiteMembreConnecte = 1 ;
			public $NomScriptOp1 = "listeAchatsDevise" ;
			public $NomScriptOp2 = "consultVentesDevise" ;
			public $NomScriptEdit = "editAchatsDevise" ;
			public $NomScriptReserv = "reservAchatsDevise" ;
			public $NomScriptSoumiss = "soumissAchatDevise" ;
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
				// Consultation achat
				$smConsult = $this->BarreMenu->MenuRacine->InscritSousMenuScript($this->NomScriptOp1) ;
				$smConsult->CheminMiniature = "images/miniatures/consulte_achat_devise.png" ;
				$smConsult->Titre = "Consultation Achat" ;
				// Consultation vente
				$smConsultOpp = $this->BarreMenu->MenuRacine->InscritSousMenuScript($this->NomScriptOp2) ;
				$smConsultOpp->CheminMiniature = "images/miniatures/consulte_vente_devise.png" ;
				$smConsultOpp->Titre = "Consultation Vente" ;
				// Edition
				$smEdition = $this->BarreMenu->MenuRacine->InscritSousMenuScript($this->NomScriptEdit) ;
				$smEdition->CheminMiniature = "images/miniatures/edit_opchange.png" ;
				$smEdition->Titre = "Publication" ;
				$smReserv = $this->BarreMenu->MenuRacine->InscritSousMenuScript($this->NomScriptReserv) ;
				$smReserv->CheminMiniature = "images/miniatures/reserv_opchange.png" ;
				$smReserv->Titre = "R&eacute;servation" ;
				/*
				$smSoumiss = $this->BarreMenu->MenuRacine->InscritSousMenuScript($this->NomScriptSoumiss) ;
				$smSoumiss->CheminMiniature = "images/miniatures/soumiss_opchange.png" ;
				$smSoumiss->Titre = "Negociations" ;
				*/
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
		class ScriptListBaseVenteDevise extends ScriptListBaseOpChange
		{
			public $NomScriptEdit = "editVentesDevise" ;
			public $NomScriptReserv = "reservVentesDevise" ;
			public $NomScriptSoumiss = "soumissVenteDevise" ;
			public $NomScriptOp1 = "consultAchatsDevise" ;
			public $NomScriptOp2 = "listeVentesDevise" ;
		}
		class ScriptListBaseOpInter extends ScriptListBaseOpChange
		{
			public $Privileges = array('post_op_change') ;
			public $NomScriptEdit = "editPlacements" ;
			public $NomScriptReserv = "reservPlacements" ;
			public $NomScriptSoumiss = "soumissPlacement" ;
			public $TypeOpInter = 1 ;
			protected function DetermineBarreMenu()
			{
				$this->BarreMenu = $this->CreeBarreMenu() ;
				$this->BarreMenu->AdopteScript("barreMenu", $this) ;
				$this->BarreMenu->ChargeConfig() ;
				// Consultation achat
				$smConsult = $this->BarreMenu->MenuRacine->InscritSousMenuScript(($this->NomScriptEdit == "editPlacements") ? "listePlacements" : "consultPlacements") ;
				$smConsult->CheminMiniature = "images/miniatures/consulte_placement.png" ;
				$smConsult->Titre = "Consultation Placement" ;
				// Consultation emprunt
				$smConsultOpp = $this->BarreMenu->MenuRacine->InscritSousMenuScript(($this->NomScriptEdit == "editEmprunts") ? "listeEmprunts" : "consultEmprunts") ;
				$smConsultOpp->CheminMiniature = "images/miniatures/consulte_emprunt.png" ;
				$smConsultOpp->Titre = "Consultation Emprunt" ;
				// Edition
				$smEdition = $this->BarreMenu->MenuRacine->InscritSousMenuScript($this->NomScriptEdit) ;
				$smEdition->CheminMiniature = "images/miniatures/edit_opinter.png" ;
				$smEdition->Titre = "Publication" ;
				$smReserv = $this->BarreMenu->MenuRacine->InscritSousMenuScript($this->NomScriptReserv) ;
				$smReserv->CheminMiniature = "images/miniatures/reserv_opinter.png" ;
				$smReserv->Titre = "R&eacute;servation" ;
				/*
				$smSoumiss = $this->BarreMenu->MenuRacine->InscritSousMenuScript($this->NomScriptSoumiss) ;
				$smSoumiss->CheminMiniature = "images/miniatures/soumiss_opinter.png" ;
				$smSoumiss->Titre = "Negociations" ;
				*/
			}
			public function TypeOpInterOppose()
			{
				return $this->TypeOpInter == 1 ? 2 : 1 ;
			}
		}
		class ScriptListBaseEmprunt extends ScriptListBaseOpInter
		{
			public $TypeOpInter = 2 ;
			public $NomScriptEdit = "editEmprunts" ;
			public $NomScriptReserv = "reservEmprunts" ;
			public $NomScriptSoumiss = "soumissEmprunt" ;
		}
		
		class DessinEditDocMarcheBaseTradPlatf
		{
			protected function RenduJsScriptBonTresor(& $script)
			{
				$ctn = '' ;
				$ctn .= '<script type="text/javascript">
	jQuery(function() {
		jQuery(".FormulaireFiltres").css("background", "none") ;
	}) ;
</script>' ;
				return $ctn ;
			}
			protected function RenduJsScriptObligation(& $script)
			{
				$ctn = '' ;
				$ctn .= '<script type="text/javascript">
	jQuery(function() {
		jQuery(".FormulaireFiltres").css("background", "none") ;
	}) ;
</script>' ;
				return $ctn ;
			}
			protected function RenduEnteteScriptBonTresor(& $script)
			{
				$ctn = '' ;
				return $ctn ;
			}
			protected function RenduPiedScriptBonTresor(& $script)
			{
				$ctn = '' ;
				return $ctn ;
			}
			protected function RenduEnteteScriptObligation(& $script)
			{
				$ctn = '' ;
				return $ctn ;
			}
			protected function RenduPiedScriptObligation(& $script)
			{
				$ctn = '' ;
				return $ctn ;
			}
			protected function RenduFormBonTresorSpec(& $script, & $composant)
			{
				return '' ;
			}
			public function RenduFormBonTresor(& $script, & $composant)
			{
				$ctn = '' ;
				$ctn .= $this->RenduFormBonTresorSpec($script, $composant) ;
				$ctn .= $this->RenduJsScriptBonTresor($script) ;
				return $ctn ;
			}
			protected function RenduFormObligationSpec(& $script, & $composant)
			{
				return '' ;
			}
			public function RenduFormObligation(& $script, & $composant)
			{
				$ctn = '' ;
				$ctn .= $this->RenduFormObligationSpec($script, $composant) ;
				$ctn .= $this->RenduJsScriptObligation($script) ;
				return $ctn ;
			}
			protected function RenduFiltre(& $composant, & $filtre)
			{
				$ctn = '' ;
				if($composant->Editable)
				{
					// $ctn .= $filtre->Lie() ;
					$ctn .= $filtre->Rendu() ;
				}
				else
				{
					$ctn .= $filtre->Etiquette() ;
				}
				return $ctn ;
			}
			public function RenduScriptBonTresor(& $script)
			{
				$ctn = '' ;
				$ctn .= $this->RenduEnteteScriptBonTresor($script) ;
				$ctn .= $script->RenduSpecifique() ;
				$ctn .= $this->RenduPiedScriptBonTresor($script) ;
				$ctn .= $this->RenduJsScriptBonTresor($script) ;
				return $ctn ;
			}
			public function RenduScriptObligation(& $script)
			{
				$ctn = '' ;
				$ctn .= $this->RenduEnteteScriptObligation($script) ;
				$ctn .= $script->RenduSpecifique() ;
				$ctn .= $this->RenduPiedScriptObligation($script) ;
				$ctn .= $this->RenduJsScriptObligation($script) ;
				return $ctn ;
			}
		}
		class DessinEditUEMOABaseTradPlatf extends DessinEditDocMarcheBaseTradPlatf
		{
			public $CheminImgEnteteBonTresor = "" ;
			public $CheminImgCorpsBonTresor = "" ;
			public $CheminImgPiedBonTresor = "" ;
			public $CheminImgEnteteObligation = "" ;
			public $CheminImgCorpsObligation = "" ;
			public $CheminImgPiedObligation = "" ;
			protected $LargeurDoc = "800" ;
			protected $Texte1 = "" ;
			protected $Texte1Pluriel = 1 ;
			protected $LargeurForm = "" ;
			protected $LargeurEnteteDoc = "464" ;
			public $CheminImgEnteteFormBonTresor = "images/marches/bf-entete1-bon-tresor.png" ;
			protected $CouleurBg1 = "#ff0000" ;
			protected $CouleurBg2 = "#ffda00" ;
			protected $CouleurBg3 = "#ff0000" ;
			protected $CouleurBg4 = "#ff0000" ;
			protected $CouleurBg5 = "#ffda00" ;
			protected $VilleSignature = "Dakar" ;
			protected function RenduFormBonTresorSpec(& $script, & $composant)
			{
				$remplCfg = & $script->ZoneParent->RemplisseurConfig ;
				$ctn = '' ;
				$ctn .= '<div align="center"><table width="'.$this->LargeurDoc.'" cellspacing="0" cellpadding="2" align="center">'.PHP_EOL ;
				$ctn .= '<tr>
<td>
<p><b style="font-size:14px">'.$this->Texte1.'</b><br />
'.(($this->Texte1Pluriel) ? 'PORTENT' : 'PORTE').' A LA CONNAISSANCE DU PUBLIC QU\'ILS ORGANISENT UN APPEL D\'OFFRES POUR LA SESSION DE BONS DE TR&Eacute;SOR<br />DONT LES TERMES SONT LES SUIVANTS</p>
</td>
</tr>'.PHP_EOL ;
				$ctn .= '<tr>
<td align="center">
	<span style="background:'.$this->CouleurBg1.'; padding:4px; font-size:20px; color:white; font-weight:bold;">CARACTERISTIQUES DE L\'OFFRE</span>
</td>
</tr>'.PHP_EOL ;
				$ctn .= '<tr>
<td align="center">
<br />
<table width="'.$this->LargeurForm.'" cellspacing="0" cellpadding="4">
<tr>
<td>'.$script->FltEmetteur->ObtientLibelle().'</td>
<td>'.$this->RenduFiltre($composant, $script->FltEmetteur).'</td>
</tr>
<tr>
<td>'.$script->FltValNominaleUnit->ObtientLibelle().'</td>
<td>'.$this->RenduFiltre($composant, $script->FltValNominaleUnit).'</td>
</tr>
<tr>
<td>'.$script->FltCodeISIN->ObtientLibelle().'</td>
<td>'.$this->RenduFiltre($composant, $script->FltCodeISIN).'</td>
</tr>
<tr>
<td>'.$script->FltTauxInteret->ObtientLibelle().'</td>
<td>'.$this->RenduFiltre($composant, $script->FltTauxInteret).'</td>
</tr>
<tr>
<td>'.$script->FltRefTransact->ObtientLibelle().'</td>
<td>'.$this->RenduFiltre($composant, $script->FltRefTransact).'</td>
</tr>
<tr>
<td>'.$script->FltMontant->ObtientLibelle().'</td>
<td>'.$this->RenduFiltre($composant, $script->FltMontant).'</td>
</tr>
<tr>
<td>'.$script->FltDevise->ObtientLibelle().'</td>
<td>'.$this->RenduFiltre($composant, $script->FltDevise).'</td>
</tr>
<tr>
<td>'.$script->FltDateEmission->ObtientLibelle().'</td>
<td>'.$this->RenduFiltre($composant, $script->FltDateEmission).'</td>
</tr>
<tr>
<td>'.$script->FltDateEcheance->ObtientLibelle().'</td>
<td>'.$this->RenduFiltre($composant, $script->FltDateEcheance).'</td>
</tr>
</table>
</td>
</tr>'.PHP_EOL ;
				$ctn .= '<tr>
<td align="center" style="background:'.$this->CouleurBg2.'; padding:4px; font-size:14px; font-weight:bold;">'.$this->RenduFiltre($composant, $script->FltPourcentMttAdjuc).'</td>
</tr>'.PHP_EOL ;
				$ctn .= '<tr><td>&nbsp;</td></tr>'.PHP_EOL ;
				$ctn .= '<tr>
<td align="center">
	<span style="background:'.$this->CouleurBg3.'; padding:4px; font-size:20px; color:white; font-weight:bold;">DEPOT DES SOUMISSIONS</span>
</td>
</tr>'.PHP_EOL ;
				$ctn .= '<tr><td>&nbsp;</td></tr>'.PHP_EOL ;
				$ctn .= '<tr>
<td align="center" style="background:'.$this->CouleurBg4.'; padding:4px; font-size:16px; color:white; font-weight:bold;">
<table align="center" cellspacing="0" cellpadding="2">
<tr>
<td>Date</td>
<td>'.$this->RenduFiltre($composant, $script->FltDateDepotSoumiss).'</td>
</tr>
<tr>
<td>Heure limite</td>
<td>'.$this->RenduFiltre($composant, $script->FltHeureDepotSoumiss).'</td>
</tr>
<tr>
<td colspan="2">Les offres sont re&ccedil;ues &agrave; travers l\'application e-AFTrading</td>
</tr>
</table>
</td>
</tr>'.PHP_EOL ;
				$ctn .= '<tr><td>&nbsp;</td></tr>'.PHP_EOL ;
				$ctn .= '<tr>
<td align="center">
<p align="left">'.nl2br(htmlentities($remplCfg->LgnEmetteurSelect["remarque"])).'</p>
<table width="100%" cellspacing="0" cellpadding="2">
<tr>
<td>
<p>'.$this->RenduFiltre($composant, $script->FltLieuSignature).', le '.$this->RenduFiltre($composant, $script->FltDateSignature).'</p>
<p>Le Directeur de l\'agence UEMOA-Titres<br />
<b>'.htmlentities($remplCfg->LgnEmetteurSelect["directeur_agence_uemoa"]).'</b>
</p>
</td>
<td align="right">
<p>Le Directeur G&eacute;n&eacute;ral du Tr&eacute;sor et de la Comptabilit&eacute; Publique<br />
'.$this->RenduFiltre($composant, $script->FltDirecteurTresor).'
</p>
</td>
</tr>
</table>
<div style="font-size:10px; font-style:italic; font-weight:bold;">Cette &eacute;mission est organis&eacute;e avec le concours de la Banque Centrale des Etats de l\'Afrique de l\'Ouest (BCEAO)</div>
</td>
</tr>
<tr>
<td align="center">
<p style="background:'.$this->CouleurBg5.'; color:white; font-size:14px"><b>Pour plus d\'informations, merci de contacter l\'agence UEMOA-Titre :</b><br />
Email : '.htmlentities($remplCfg->LgnEmetteurSelect["email"]).' / Tel : '.htmlentities($remplCfg->LgnEmetteurSelect["telephone"]).' / Fax : '.htmlentities($remplCfg->LgnEmetteurSelect["fax"]).'
</p>
</td>
</tr>'.PHP_EOL ;
				$ctn .= '</table></div>'.PHP_EOL ;
				return $ctn ;
			}
			protected function RenduFormObligationSpec(& $script, & $composant)
			{
				$remplCfg = & $script->ZoneParent->RemplisseurConfig ;
				$ctn = '' ;
				$ctn .= '<div align="center"><table width="'.$this->LargeurDoc.'" cellspacing="0" cellpadding="2" align="center">'.PHP_EOL ;
				$ctn .= '<tr>
<td>
<p><b style="font-size:14px">'.$this->Texte1.'</b><br />
'.(($this->Texte1Pluriel) ? 'PORTENT' : 'PORTE').' A LA CONNAISSANCE DU PUBLIC QU\'ILS ORGANISENT UN APPEL D\'OFFRES POUR LA CESSION D\'OBLIGATIONS DU TRESOR<br /> DONT LES TERMES SONT LES SUIVANTS</p>
</td>
</tr>'.PHP_EOL ;
				$ctn .= '<tr>
<td align="center">
	<span style="background:'.$this->CouleurBg1.'; padding:4px; font-size:20px; color:white; font-weight:bold;">CARACTERISTIQUES DE L\'OFFRE</span>
</td>
</tr>'.PHP_EOL ;
				$ctn .= '<tr>
<td align="center">
<br />
<table width="'.$this->LargeurForm.'" cellspacing="0" cellpadding="4">
<tr>
<td>'.$script->FltEmetteur->ObtientLibelle().'</td>
<td>'.$this->RenduFiltre($composant, $script->FltEmetteur).'</td>
</tr>
<tr>
<td>'.$script->FltValNominaleUnit->ObtientLibelle().'</td>
<td>'.$this->RenduFiltre($composant, $script->FltValNominaleUnit).'</td>
</tr>
<tr>
<td>'.$script->FltCodeISIN->ObtientLibelle().'</td>
<td>'.$this->RenduFiltre($composant, $script->FltCodeISIN).'</td>
</tr>
<tr>
<td>'.$script->FltTaux->ObtientLibelle().'</td>
<td>'.$this->RenduFiltre($composant, $script->FltTaux).'</td>
</tr>
<tr>
<td>'.$script->FltRefTransact->ObtientLibelle().'</td>
<td>'.$this->RenduFiltre($composant, $script->FltRefTransact).'</td>
</tr>
<tr>
<td>'.$script->FltMontant->ObtientLibelle().'</td>
<td>'.$this->RenduFiltre($composant, $script->FltMontant).'</td>
</tr>
<tr>
<td>'.$script->FltDevise->ObtientLibelle().'</td>
<td>'.$this->RenduFiltre($composant, $script->FltDevise).'</td>
</tr>
<tr>
<td>'.$script->FltDateEmission->ObtientLibelle().'</td>
<td>'.$this->RenduFiltre($composant, $script->FltDateEmission).'</td>
</tr>
<tr>
<td>'.$script->FltDateEcheance->ObtientLibelle().'</td>
<td>'.$this->RenduFiltre($composant, $script->FltDateEcheance).'</td>
</tr>
</table>
</td>
</tr>'.PHP_EOL ;
				$ctn .= '<tr>
<td align="center" style="background:'.$this->CouleurBg2.'; padding:4px; font-size:14px; font-weight:bold;">'.$this->RenduFiltre($composant, $script->FltPourcentMttAdjuc).'</td>
</tr>'.PHP_EOL ;
				$ctn .= '<tr><td>&nbsp;</td></tr>'.PHP_EOL ;
				$ctn .= '<tr>
<td align="center">
	<span style="background:'.$this->CouleurBg3.'; padding:4px; font-size:20px; color:white; font-weight:bold;">DEPOT DES SOUMISSIONS</span>
</td>
</tr>'.PHP_EOL ;
				$ctn .= '<tr><td>&nbsp;</td></tr>'.PHP_EOL ;
				$ctn .= '<tr>
<td align="center" style="background:'.$this->CouleurBg4.'; padding:4px; font-size:16px; color:white; font-weight:bold;">
<table align="center" cellspacing="0" cellpadding="2">
<tr>
<td>Date</td>
<td>'.$this->RenduFiltre($composant, $script->FltDateDepotSoumiss).'</td>
</tr>
<tr>
<td>Heure limite</td>
<td>'.$this->RenduFiltre($composant, $script->FltHeureDepotSoumiss).'</td>
</tr>
<tr>
<td colspan="2">Les offres sont re&ccedil;ues &agrave; travers l\'application e-AFTrading</td>
</tr>
</table>
</td>
</tr>'.PHP_EOL ;
				$ctn .= '<tr><td>&nbsp;</td></tr>'.PHP_EOL ;
				$ctn .= '<tr>
<td align="center">
<p align="left">'.nl2br(htmlentities($remplCfg->LgnEmetteurSelect["remarque"])).'</p>
<table width="100%" cellspacing="0" cellpadding="2">
<tr>
<td>
<p>'.$this->RenduFiltre($composant, $script->FltLieuSignature).', le '.$this->RenduFiltre($composant, $script->FltDateSignature).'</p>
<p>Le Directeur de l\'agence UEMOA-Titres<br />
<b>'.htmlentities($remplCfg->LgnEmetteurSelect["directeur_agence_uemoa"]).'</b>
</p>
</td>
<td align="right">
<p>Le Directeur G&eacute;n&eacute;ral du Tr&eacute;sor et de la Comptabilit&eacute; Publique<br />
'.$this->RenduFiltre($composant, $script->FltDirecteurTresor).'
</p>
</td>
</tr>
</table>
<div style="font-size:10px; font-style:italic; font-weight:bold;">Cette &eacute;mission est organis&eacute;e avec le concours de la Banque Centrale des Etats de l\'Afrique de l\'Ouest (BCEAO)</div>
</td>
</tr>
<tr>
<td align="center">
<p style="background:'.$this->CouleurBg5.'; color:white; font-size:14px"><b>Pour plus d\'informations, merci de contacter l\'agence UEMOA-Titre :</b><br />
Email : '.htmlentities($remplCfg->LgnEmetteurSelect["email"]).' / Tel : '.htmlentities($remplCfg->LgnEmetteurSelect["telephone"]).' / Fax : '.htmlentities($remplCfg->LgnEmetteurSelect["fax"]).'
</p>
</td>
</tr>'.PHP_EOL ;
				$ctn .= '</table></div>'.PHP_EOL ;
				return $ctn ;
			}
		}
		class DessinEditMarcheBeninTradPlatf extends DessinEditUEMOABaseTradPlatf
		{
			public $CheminImgEnteteBonTresor = "images/marches/benin-entete-bon-tresor.png" ;
			public $CheminImgCorpsBonTresor = "images/marches/benin-form-bon-tresor.png" ;
			public $CheminImgPiedBonTresor = "images/marches/benin-pied-bon-tresor.png" ;
			public $CheminImgEnteteObligation = "images/marches/benin-entete-obligation.png" ;
			public $CheminImgCorpsObligation = "images/marches/benin-form-obligation.png" ;
			public $CheminImgPiedObligation = "images/marches/benin-pied-obligation.png" ;
			public $CheminImgEnteteFormBonTresor = "images/marches/benin-entete1-bon-tresor.png" ;
			public $CheminImgEnteteFormObligation = "images/marches/benin-entete1-obligation.png" ;
			protected $Texte1 = "L'agence UEMOA-Titre et le Tr&eacute;sor B&eacute;ninois" ;
			protected $CouleurBg1 = "#ff0000" ;
			protected $CouleurBg2 = "#ffda00" ;
			protected $CouleurBg3 = "#ff0000" ;
			protected $CouleurBg4 = "#ff0000" ;
			protected $CouleurBg5 = "#009900" ;
		}
		class DessinEditMarcheBFTradPlatf extends DessinEditUEMOABaseTradPlatf
		{
			public $CheminImgEnteteBonTresor = "images/marches/bf-entete-bon-tresor.png" ;
			public $CheminImgCorpsBonTresor = "images/marches/bf-form-bon-tresor.png" ;
			public $CheminImgPiedBonTresor = "images/marches/bf-pied-bon-tresor.png" ;
			public $CheminImgEnteteObligation = "images/marches/bf-entete-obligation.png" ;
			public $CheminImgCorpsObligation = "images/marches/bf-form-obligation.png" ;
			public $CheminImgPiedObligation = "images/marches/bf-pied-obligation.png" ;
			public $CheminImgEnteteFormBonTresor = "images/marches/bf-entete1-bon-tresor.png" ;
			public $CheminImgEnteteFormObligation = "images/marches/bf-entete1-obligation.png" ;
			protected $Texte1 = "L'agence UEMOA-Titre et le Tr&eacute;sor Burkinab&eacute;" ;
			protected $CouleurBg1 = "#ff0000" ;
			protected $CouleurBg2 = "#ffda00" ;
			protected $CouleurBg3 = "#ff0000" ;
			protected $CouleurBg4 = "#ff0000" ;
			protected $CouleurBg5 = "#008001" ;
		}
		class DessinEditMarcheCIVTradPlatf extends DessinEditUEMOABaseTradPlatf
		{
			public $CheminImgEnteteBonTresor = "images/marches/ci-entete-bon-tresor.png" ;
			public $CheminImgCorpsBonTresor = "images/marches/ci-form-bon-tresor.png" ;
			public $CheminImgPiedBonTresor = "images/marches/ci-pied-bon-tresor.png" ;
			public $CheminImgEnteteObligation = "images/marches/ci-entete-obligation.png" ;
			public $CheminImgCorpsObligation = "images/marches/ci-form-obligation.png" ;
			public $CheminImgPiedObligation = "images/marches/ci-pied-obligation.png" ;
			public $CheminImgEnteteFormBonTresor = "images/marches/ci-entete1-bon-tresor.png" ;
			public $CheminImgEnteteFormObligation = "images/marches/ci-entete1-obligation.png" ;
			protected $Texte1 = "L'agence UEMOA-Titre et le Tr&eacute;sor Ivoirien" ;
			protected $CouleurBg1 = "#017f01" ;
			protected $CouleurBg2 = "#ffda00" ;
			protected $CouleurBg3 = "#017f01" ;
			protected $CouleurBg4 = "#017f01" ;
			protected $CouleurBg5 = "#ffa808" ;
		}
		class DessinEditMarcheGBTradPlatf extends DessinEditUEMOABaseTradPlatf
		{
			public $CheminImgEnteteBonTresor = "images/marches/gb-entete-bon-tresor.png" ;
			public $CheminImgCorpsBonTresor = "images/marches/gb-form-bon-tresor.png" ;
			public $CheminImgPiedBonTresor = "images/marches/gb-pied-bon-tresor.png" ;
			public $CheminImgEnteteObligation = "images/marches/gb-entete-obligation.png" ;
			public $CheminImgCorpsObligation = "images/marches/gb-form-obligation.png" ;
			public $CheminImgPiedObligation = "images/marches/gb-pied-obligation.png" ;
			public $CheminImgEnteteFormBonTresor = "images/marches/gb-entete1-bon-tresor.png" ;
			public $CheminImgEnteteFormObligation = "images/marches/gb-entete1-obligation.png" ;
			protected $Texte1 = "L'agence UEMOA-Titre et le Tr&eacute;sor Bissau Guin&eacute;en" ;
			protected $CouleurBg1 = "#008001" ;
			protected $CouleurBg2 = "#ffda00" ;
			protected $CouleurBg3 = "#008001" ;
			protected $CouleurBg4 = "#008001" ;
			protected $CouleurBg5 = "#fe0000" ;
		}
		class DessinEditMarcheMaliTradPlatf extends DessinEditUEMOABaseTradPlatf
		{
			public $CheminImgEnteteBonTresor = "images/marches/mali-entete-bon-tresor.png" ;
			public $CheminImgCorpsBonTresor = "images/marches/mali-form-bon-tresor.png" ;
			public $CheminImgPiedBonTresor = "images/marches/mali-pied-bon-tresor.png" ;
			public $CheminImgEnteteObligation = "images/marches/mali-entete-obligation.png" ;
			public $CheminImgCorpsObligation = "images/marches/mali-form-obligation.png" ;
			public $CheminImgPiedObligation = "images/marches/mali-pied-obligation.png" ;
			public $CheminImgEnteteFormBonTresor = "images/marches/mali-entete1-bon-tresor.png" ;
			public $CheminImgEnteteFormObligation = "images/marches/mali-entete1-obligation.png" ;
			protected $Texte1 = "L'agence UEMOA-Titre et le Tr&eacute;sor Malien" ;
			protected $CouleurBg1 = "#008001" ;
			protected $CouleurBg2 = "#ffda00" ;
			protected $CouleurBg3 = "#008001" ;
			protected $CouleurBg4 = "#008001" ;
			protected $CouleurBg5 = "#fe0000" ;
		}
		class DessinEditMarcheNigerTradPlatf extends DessinEditUEMOABaseTradPlatf
		{
			public $CheminImgEnteteBonTresor = "images/marches/niger-entete-bon-tresor.png" ;
			public $CheminImgCorpsBonTresor = "images/marches/niger-form-bon-tresor.png" ;
			public $CheminImgPiedBonTresor = "images/marches/niger-pied-bon-tresor.png" ;
			public $CheminImgEnteteObligation = "images/marches/niger-entete-obligation.png" ;
			public $CheminImgCorpsObligation = "images/marches/niger-form-obligation.png" ;
			public $CheminImgPiedObligation = "images/marches/niger-pied-obligation.png" ;
			public $CheminImgEnteteFormBonTresor = "images/marches/niger-entete1-bon-tresor.png" ;
			public $CheminImgEnteteFormObligation = "images/marches/niger-entete1-obligation.png" ;
			protected $Texte1 = "L'agence UEMOA-Titre et le Tr&eacute;sor Nigerien" ;
			protected $CouleurBg1 = "#ffa808" ;
			protected $CouleurBg2 = "#ffda00" ;
			protected $CouleurBg3 = "#ffa808" ;
			protected $CouleurBg4 = "#ffa808" ;
			protected $CouleurBg5 = "#008001" ;
		}
		class DessinEditMarcheSenegalTradPlatf extends DessinEditUEMOABaseTradPlatf
		{
			public $CheminImgEnteteBonTresor = "images/marches/senegal-entete-bon-tresor.png" ;
			public $CheminImgCorpsBonTresor = "images/marches/senegal-form-bon-tresor.png" ;
			public $CheminImgPiedBonTresor = "images/marches/senegal-pied-bon-tresor.png" ;
			public $CheminImgEnteteObligation = "images/marches/senegal-entete-obligation.png" ;
			public $CheminImgCorpsObligation = "images/marches/senegal-form-obligation.png" ;
			public $CheminImgPiedObligation = "images/marches/senegal-pied-obligation.png" ;
			public $CheminImgEnteteFormBonTresor = "images/marches/senegal-entete1-bon-tresor.png" ;
			public $CheminImgEnteteFormObligation = "images/marches/senegal-entete1-obligation.png" ;
			protected $Texte1 = "L'agence UEMOA-Titre et le Tr&eacute;sor S&eacute;n&eacute;galais" ;
			protected $CouleurBg1 = "#009900" ;
			protected $CouleurBg2 = "#ffda00" ;
			protected $CouleurBg3 = "#009900" ;
			protected $CouleurBg4 = "#009900" ;
			protected $CouleurBg5 = "#feda00" ;
		}
		class DessinEditMarcheTogoTradPlatf extends DessinEditUEMOABaseTradPlatf
		{
			public $CheminImgEnteteBonTresor = "images/marches/togo-entete-bon-tresor.png" ;
			public $CheminImgCorpsBonTresor = "images/marches/togo-form-bon-tresor.png" ;
			public $CheminImgPiedBonTresor = "images/marches/togo-pied-bon-tresor.png" ;
			public $CheminImgEnteteObligation = "images/marches/togo-entete-obligation.png" ;
			public $CheminImgCorpsObligation = "images/marches/togo-form-obligation.png" ;
			public $CheminImgPiedObligation = "images/marches/togo-pied-obligation.png" ;
			public $CheminImgEnteteFormBonTresor = "images/marches/togo-entete1-bon-tresor.png" ;
			public $CheminImgEnteteFormObligation = "images/marches/togo-entete1-obligation.png" ;
			protected $Texte1 = "L'agence UEMOA-Titre et le Tr&eacute;sor Togolais" ;
			protected $CouleurBg1 = "#fe0000" ;
			protected $CouleurBg2 = "#ffda00" ;
			protected $CouleurBg3 = "#fe0000" ;
			protected $CouleurBg4 = "#fe0000" ;
			protected $CouleurBg5 = "#feda00" ;
		}
		
		class DessinEditMarchSecTradPlatf extends DessinEditUEMOABaseTradPlatf
		{
			public $CheminImgEnteteBonTresor = "images/marches/marchesec-entete-bon-tresor.png" ;
			public $CheminImgCorpsBonTresor = "images/marches/marchesec-form-bon-tresor.png" ;
			public $CheminImgPiedBonTresor = "images/marches/marchesec-pied-bon-tresor.png" ;
			public $CheminImgEnteteObligation = "images/marches/marchesec-entete-obligation.png" ;
			public $CheminImgCorpsObligation = "images/marches/marchesec-form-obligation.png" ;
			public $CheminImgPiedObligation = "images/marches/marchesec-pied-obligation.png" ;
			public $CheminImgEnteteFormBonTresor = "images/marches/marchesec-entete1-bon-tresor.png" ;
			public $CheminImgEnteteFormObligation = "images/marches/marchesec-entete1-obligation.png" ;
			protected $Texte1 = "L'AGENCE UEMOA" ;
			protected $Texte1Pluriel = 0 ;
			protected $CouleurBg1 = "#1c88ae" ;
			protected $CouleurBg2 = "#ffda00" ;
			protected $CouleurBg3 = "#1c88ae" ;
			protected $CouleurBg4 = "#1c88ae" ;
			protected $CouleurBg5 = "#1c88ae" ;
		}
		class DessinEditMarchSec2TradPlatf extends DessinEditUEMOABaseTradPlatf
		{
			public $CheminImgEnteteBonTresor = "images/marches/marchesec-entete-bon-tresor.png" ;
			public $CheminImgCorpsBonTresor = "images/marches/marchesec-form-bon-tresor.png" ;
			public $CheminImgPiedBonTresor = "images/marches/marchesec-pied-bon-tresor.png" ;
			public $CheminImgEnteteObligation = "images/marches/marchesec-entete-obligation.png" ;
			public $CheminImgCorpsObligation = "images/marches/marchesec-form-obligation.png" ;
			public $CheminImgPiedObligation = "images/marches/marchesec-pied-obligation.png" ;
			public $CheminImgEnteteFormBonTresor = "images/marches/marchesec-entete2-bon-tresor.png" ;
			public $CheminImgEnteteFormObligation = "images/marches/marchesec-entete2-obligation.png" ;
			protected $Texte1 = "L'AGENCE UEMOA" ;
			protected $Texte1Pluriel = 0 ;
			protected $CouleurBg1 = "#1c88ae" ;
			protected $CouleurBg2 = "#ffda00" ;
			protected $CouleurBg3 = "#1c88ae" ;
			protected $CouleurBg4 = "#1c88ae" ;
			protected $CouleurBg5 = "#1c88ae" ;
		}
		
		class FormEditDocMarcheTradPlatf extends FormulaireDonneesBaseTradPlatf
		{
		}
	}
	
?>
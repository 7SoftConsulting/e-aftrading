<?php
	
	if(! defined('APPLICATION_TRAD_PLATF'))
	{
		if(! defined('PV_APPLICATION'))
		{
			include dirname(__FILE__)."/../../_PVIEW/Pv/Base.class.php" ;
		}
		if(! defined('PV_IHM_ADMIN_DIRECTE'))
		{
			include dirname(__FILE__)."/../../_PVIEW/Pv/IHM/AdminDirecte.class.php" ;
		}
		if(! defined('CONSTS_TRAD_PLATF'))
		{
			include dirname(__FILE__)."/Consts.class.php" ;
		}
		if(! defined('VUE_SQL_TRAD_PLATF'))
		{
			include dirname(__FILE__)."/VuesSql.class.php" ;
		}
		if(! defined('MDL_TRANSACT_TRAD_PLATF'))
		{
			include dirname(__FILE__)."/MdlTransact.class.php" ;
		}
		if(! defined('ZONE_PUBL_TRAD_PLATF'))
		{
			include dirname(__FILE__)."/ZonePubl.class.php" ;
		}
		define('APPLICATION_TRAD_PLATF', 1) ;
		define('ID_EURO_TRAD_PLATF', 3) ;
		
		class BDPrincipaleTradPlatf extends MysqlDB
		{
			public function InitConnectionParams()
			{
				parent::InitConnectionParams() ;
				$this->ConnectionParams["server"] = HOTE_BD_PRINC_TRAD_PLATF ;
				$this->ConnectionParams["user"] = USER_BD_PRINC_TRAD_PLATF ;
				$this->ConnectionParams["password"] = PWD_BD_PRINC_TRAD_PLATF ;
				$this->ConnectionParams["schema"] = SCHEMA_BD_PRINC_TRAD_PLATF ;
			}
		}
		
		class ApplicationTradPlatf extends PvApplication
		{
			public $BDPrincipale = null ;
			public $ZonePubl = null ;
			public $MdlTransacts = array() ;
			protected function ChargeBasesDonnees()
			{
				$this->BDPrincipale = new BDPrincipaleTradPlatf() ;
				$this->InscritBaseDonnees("principale", $this->BDPrincipale) ;
				$this->ChargeMdlTransacts() ;
			}
			protected function ChargeIHMs()
			{
				$this->ZonePublTradPlatf = new ZonePublTradPlatf() ;
				$this->ZonePublTradPlatf->CheminFichierRelatif = CHEM_REL_ZONE_PUBL_TRAD_PLATF ;
				$this->InscritIHM("zonePublique", $this->ZonePublTradPlatf) ;
			}
			protected function ChargeMdlTransacts()
			{
				$this->MdlTransacts[] = new MdlOpChangeTradPlatf() ;
				$this->MdlTransacts[] = new MdlOpInterTradPlatf() ;
				$this->MdlTransacts[] = new MdlRelEntrepriseTradPlatf() ;
			}
			public function & ObtientMdlTransact($id)
			{
				$mdl = null ;
				for($i = 0; $i < count($this->MdlTransacts); $i++)
				{
					if($this->MdlTransacts[$i]->Id == $id)
					{
						$mdl = & $this->MdlTransacts[$i] ;
						break ;
					}
				}
				return $mdl ;
			}
			public function CreeFournMdlTransacts()
			{
				$donnees = array() ;
				$fourn = new PvFournisseurDonneesDirect() ;
				// $fourn->Valeurs = array("")
				foreach($this->MdlTransacts as $i => $mdlTransact)
				{
					$donnees[] = $mdlTransact->ObtientValeurs() ;
				}
				$fourn->Valeurs["modeles"] = & $donnees ;
				return $fourn ;
			}
		}
	}
	
?>
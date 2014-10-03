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
				$this->ConnectionParams["server"] = "localhost" ;
				$this->ConnectionParams["user"] = "root" ;
				$this->ConnectionParams["password"] = "" ;
				$this->ConnectionParams["schema"] = "trading_platform_v2" ;
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
				$this->ZonePublTradPlatf->CheminFichierRelatif = "trading-platform-v2/index.php" ;
				$this->InscritIHM("zonePublique", $this->ZonePublTradPlatf) ;
			}
			protected function ChargeMdlTransacts()
			{
				$this->MdlTransacts[] = new MdlOpChangeTradPlatf() ;
				$this->MdlTransacts[] = new MdlOpInterTradPlatf() ;
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
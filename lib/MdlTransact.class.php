<?php
	
	if(! defined('MDL_TRANSACT_TRAD_PLATF'))
	{
		if(! defined('OP_CHANGE_TRAD_PLATF'))
		{
			include dirname(__FILE__)."/OpChange.class.php" ;
		}
		if(! defined('OP_INTER_TRAD_PLATF'))
		{
			include dirname(__FILE__)."/OpInter.class.php" ;
		}
		
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
		
	}
	
?>
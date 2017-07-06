<?php
	
	if(! defined('SCRIPT_STATS_TRAD_PLATF'))
	{
		define('SCRIPT_STATS_TRAD_PLATF', 1) ;
		
		class InfoStat1TradPlatf
		{
			public $NomDevise ;
			public $CumulOper = 0 ;
			public $CommissElevee = 0 ;
			public $CommissBasse = 0 ;
			public $TauxEleve = 0 ;
			public $TauxBas = 0 ;
		}
		
		class ScriptStats1TradPlatf extends ScriptBaseTradPlatf
		{
			public $TitreDocument = "Statistiques op&eacute;ration de change" ;
			public $Titre = "Statistiques op&eacute;ration de change" ;
			public $IdsDevise = array(3, 2, 14) ;
			public $StatsDevise = array() ;
			public function DetermineEnvironnement()
			{
				parent::DetermineEnvironnement() ;
				$this->DetermineStatsDevise() ;
			}
			protected function DetermineStatsDevise()
			{
				$bd = $this->ApplicationParent->BDPrincipale ;
				$params = array() ;
				foreach($this->IdsDevise as $i => $idDevise)
				{
					$infoStat = new InfoStat1TradPlatf() ;
					$this->StatsDevise[$idDevise] = $infoStat ;
					$params["id_devise_".$i] = $idDevise ;
				}
				$sql = 'select t1.id_devise2, sum(t1.montant_soumis) cumul_oper, min(t1.mtt_commiss) commiss_basse, max(t1.mtt_commiss) commiss_elevee
, min(t1.taux_soumis) taux_bas, max(t1.taux_soumis) taux_eleve
from op_change t1 left join devise t2 on t1.id_devise2=t2.id_devise
where t1.num_op_change_dem > 0
and t1.id_devise2 in (:'.join(', :', array_keys($params)).')
group by t1.id_devise2' ;
				$lgns1 = $bd->FetchSqlRows($sql, $params) ;
				$lgns2 = $bd->FetchSqlRows('select * from devise where id_devise in(:'.join(', :', array_keys($params)).')', $params) ;
				foreach($lgns2 as $i => $lgn)
				{
					if(! isset($this->StatsDevise[$lgn["id_devise"]]))
					{
						continue ;
					}
					$this->StatsDevise[$lgn["id_devise"]]->NomDevise = $lgn["code_devise"] ;
				}
				foreach($lgns1 as $i => $lgn)
				{
					if(! isset($this->StatsDevise[$lgn["id_devise2"]]))
					{
						continue ;
					}
					$this->StatsDevise[$lgn["id_devise2"]]->CumulOper = $lgn["cumul_oper"] ;
					$this->StatsDevise[$lgn["id_devise2"]]->CommissBasse = $lgn["commiss_basse"] ;
					$this->StatsDevise[$lgn["id_devise2"]]->CommissElevee = $lgn["commiss_elevee"] ;
					$this->StatsDevise[$lgn["id_devise2"]]->TauxBas = $lgn["taux_bas"] ;
					$this->StatsDevise[$lgn["id_devise2"]]->TauxEleve = $lgn["taux_eleve"] ;
				}
			}
			public function RenduSpecifique()
			{
				$ctn = '' ;
				$ctnLiens = '' ;
				$ctnCorps = '' ;
				foreach($this->StatsDevise as $idDevise => $infoStat)
				{
					$ctnLiens .= '<li><a href="#info-stat-'.$idDevise.'">'.htmlentities($infoStat->NomDevise).'</a></li>'.PHP_EOL ;
					$ctnCorps .= '<div id="info-stat-'.$idDevise.'">
<table width="100%" cellspacing="0" cellpadding="8" class="ui-widget ui-widget-content">
<tr>
<th width="40%" class="ui-widget-header">Cumul des op&eacute;rations confirm&eacute;es</th>'.PHP_EOL ;
					if($idDevise == 3)
					{
						$ctnCorps .= '<th class="ui-widget-header" width="30%">Commission de change la plus &eacute;l&eacute;v&eacute;e</th>
<th width="*" class="ui-widget-header">Commission de change la plus basse</th>'.PHP_EOL ;
					}
					else
					{
						$ctnCorps .= '<th width="30%" class="ui-widget-header">Taux de change le plus &eacute;l&eacute;v&eacute;</th>
<th width="*" class="ui-widget-header">Taux de change le plus bas</th>'.PHP_EOL ;
					}
					$ctnCorps .= '</tr>
<tr>
<td class="ui-widget-content" align="center">'.htmlentities($infoStat->CumulOper).'</td>'.PHP_EOL ;
					if($idDevise == 3)
					{
						$ctnCorps .= '<td class="ui-widget-content" align="center">'.htmlentities($infoStat->CommissElevee).'</td>
<td class="ui-widget-content" align="center">'.htmlentities($infoStat->CommissBasse).'</td>'.PHP_EOL ;
					}
					else
					{
						$ctnCorps .= '<td class="ui-widget-content" align="center">'.htmlentities($infoStat->TauxEleve).'</td>
<td class="ui-widget-content" align="center">'.htmlentities($infoStat->TauxBas).'</td>'.PHP_EOL ;
					}
					$ctnCorps .= '</tr>
</table>'.PHP_EOL ;
					$ctnCorps .= '</div>'.PHP_EOL ;
				}
				$ctn .= '<div class="tabs barre-stats">'.PHP_EOL ;
				$ctn .= '<ul>'.PHP_EOL ;
				$ctn .= $ctnLiens.PHP_EOL ;
				$ctn .= '</ul>'.PHP_EOL ;
				$ctn .= $ctnCorps.PHP_EOL ;
				$ctn .= '</div>'.PHP_EOL ;
				$ctn .= $this->ZoneParent->RenduContenuJsInclus('jQuery(function() { jQuery(".barre-stats").tabs() ; }) ;') ;
				return $ctn ;
			}
		}
	}
	
?>
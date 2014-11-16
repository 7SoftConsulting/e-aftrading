<?php
	
	if(! defined('VUE_SQL_TRAD_PLATF'))
	{
		define('VUE_SQL_TRAD_PLATF', 1) ;
		
		define("TXT_SQL_CONSULT_OP_CHANGE_TRAD_PLATF", "(select t1.*, case when t1.commiss_ou_taux = 0 then mtt_commiss when type_taux = 0 then taux_change else ecran_taux end taux_transact, t7.shortname nom_court_entite, t7.name nom_entite, t2.lib_devise lib_devise1, t3.lib_devise lib_devise2, t4.login loginop, t4.nomop nomop, t4.prenomop prenomop, t5.id_entite_source, t5.id_entite_dest, t5.top_active, t6.numop numrep, t6.login loginrep, case when t4.numop = t6.numop then 1 else 0 end peut_modif, case when t4.numop <> t6.numop then 1 else 0 end peut_repondre,
case when t1.num_op_change_dem = 0 then 'demande' else 'reponse' end type_message
from op_change t1
left join devise t2
on t1.id_devise1 = t2.id_devise
left join devise t3
on t1.id_devise2 = t3.id_devise
left join operateur t4
on t1.numop = t4.numop
left join oper_b_change t5
on t5.id_entite_source=t4.id_entite
left join entite t7
on t5.id_entite_source=t7.id_entite
left join operateur t6
on t5.id_entite_dest=t6.id_entite
where t5.id_entite_dest is not null and t7.id_entite is not null and t6.login is not null and t4.active_op = 1)") ;
		define("TXT_SQL_EDIT_OP_CHANGE_TRAD_PLATF", "select t1.*, case when t1.commiss_ou_taux = 0 then mtt_commiss when type_taux = 0 then taux_change else ecran_taux end taux_transact, case when t2.total_rep is null then 0 else t2.total_rep end total_rep from op_change t1
left join (select num_op_change_dem num_op_change, count(0) total_rep from op_change t2 where num_op_change_dem <> 0 and type_change is not null group by num_op_change_dem) t2
on t1.num_op_change = t2.num_op_change") ;
		define("TXT_SQL_POSTUL_OP_CHANGE_TRAD_PLATF", "select t1.*, case when t1.bool_confirme = 1 then 0 else 1 end peut_ajuster, case when t1.commiss_ou_taux = 0 then t1.mtt_commiss when t1.type_taux = 0 then t1.taux_change else t1.ecran_taux end taux_transact, t2.login loginop, t2.nomop, t2.prenomop, t4.id_entite, t4.code code_entite, t4.shortname nom_court_entite, t4.name nom_entite
from op_change t1
left join operateur t2
on t1.numop = t2.numop
left join op_change t3
on t1.num_op_change_dem = t3.num_op_change
left join entite t4
on t2.id_entite = t4.id_entite") ;
		define("TXT_SQL_REP_OP_CHANGE_TRAD_PLATF", "select t1.*, case when t1.commiss_ou_taux = 0 then mtt_commiss when type_taux = 0 then taux_change else ecran_taux end taux_transact from op_change t1
left join operateur t2
on t1.numop = t2.numop
left join op_change t3
on t1.num_op_change_dem = t3.num_op_change") ;
		define("TXT_SQL_CONSULT_OP_INTER_TRAD_PLATF", "(select t1.*, case when t1.commiss_ou_taux = 0 then mtt_commiss when type_taux = 0 then taux_change else ecran_taux end taux_transact, t7.shortname nom_court_entite, t7.name nom_entite, t2.lib_devise lib_devise1, t3.lib_devise lib_devise2, t4.login loginop, t4.nomop nomop, t4.prenomop prenomop, t5.id_entite_source, t5.id_entite_dest, t5.top_active, t6.numop numrep, t6.login loginrep, case when t4.numop = t6.numop then 1 else 0 end peut_modif, case when t4.numop <> t6.numop then 1 else 0 end peut_repondre,
case when t1.num_op_inter_dem = 0 then 'demande' else 'reponse' end type_message
from op_inter t1
left join devise t2
on t1.id_devise1 = t2.id_devise
left join devise t3
on t1.id_devise2 = t3.id_devise
left join operateur t4
on t1.numop = t4.numop
left join oper_b_change t5
on t5.id_entite_source=t4.id_entite
left join entite t7
on t5.id_entite_source=t7.id_entite
left join operateur t6
on t5.id_entite_dest=t6.id_entite
where t5.id_entite_dest is not null and t7.id_entite is not null and t6.login is not null and t4.active_op = 1)") ;
		define("TXT_SQL_EDIT_OP_INTER_TRAD_PLATF", "select t1.*, case when t1.commiss_ou_taux = 0 then mtt_commiss when type_taux = 0 then taux_change else ecran_taux end taux_transact, case when t2.total_rep is null then 0 else t2.total_rep end total_rep from op_inter t1
left join (select num_op_inter_dem num_op_inter, count(0) total_rep from op_inter t2 where num_op_inter_dem <> 0 and type_change is not null group by num_op_inter_dem) t2
on t1.num_op_inter = t2.num_op_inter") ;
		define("TXT_SQL_POSTUL_OP_INTER_TRAD_PLATF", "select t1.*, case when t1.bool_confirme = 1 then 0 else 1 end peut_ajuster, case when t1.commiss_ou_taux = 0 then t1.mtt_commiss when t1.type_taux = 0 then t1.taux_change else t1.ecran_taux end taux_transact, t2.login loginop, t2.nomop, t2.prenomop, t4.id_entite, t4.code code_entite, t4.shortname nom_court_entite, t4.name nom_entite
from op_inter t1
left join operateur t2
on t1.numop = t2.numop
left join op_inter t3
on t1.num_op_inter_dem = t3.num_op_inter
left join entite t4
on t2.id_entite = t4.id_entite") ;
		define("TXT_SQL_REP_OP_INTER_TRAD_PLATF", "select t1.*, case when t1.commiss_ou_taux = 0 then mtt_commiss when type_taux = 0 then taux_change else ecran_taux end taux_transact from op_inter t1
left join operateur t2
on t1.numop = t2.numop
left join op_inter t3
on t1.num_op_inter_dem = t3.num_op_inter") ;
		define("TXT_SQL_SELECT_ACHAT_DEVISE_SOUMIS", "select t1.*, case when t1.commiss_ou_taux = 0 then mtt_commiss when type_taux = 0 then taux_change else ecran_taux end taux_transact from op_change t1 where bool_confirme=0 and num_op_change_dem = 0") ;
		define("TXT_SQL_SELECT_PLACEMENT_SOUMIS", "select t1.*, case when t1.commiss_ou_taux = 0 then mtt_commiss when type_taux = 0 then taux_change else ecran_taux end taux_transact from op_inter t1 where bool_confirme=0 and num_op_inter_dem = 0") ;
	}
	
?>
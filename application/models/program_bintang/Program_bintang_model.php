<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Program_bintang_model extends CI_Model
{
    private $postgres = NULL;

    public function __construct()
    {
        parent::__construct();
        $this->postgres = $this->load->database('postgres', TRUE);
    }

    public function get_datas($month, $category, $area)
    {
        $get_data_by_category = [
            'PS/RE' => [
                'WITEL' => (object) [
                    'datas' => $this->psre($month, 'WITEL'),
                ],
                'DATEL' => (object) [
                    'datas' => $this->psre($month, 'DATEL'),
                ],
                'HERO' => (object) [
                    'datas' => $this->psre($month, 'HERO'),
                ],
            ],
            'C3MR ALL BILLING' => [
                'WITEL' => (object) [
                    'datas' => $this->c3mr_all_bill($month, 'WITEL'),
                ],
                'DATEL' => (object) [
                    'datas' => $this->c3mr_all_bill($month, 'DATEL'),
                ],
                'HERO' => (object) [
                    'datas' => $this->c3mr_all_bill($month, 'HERO'),
                ],
            ],
            'C3MR BILLING PERDANA' => [
                'WITEL' => (object) [
                    'datas' => $this->c3mr_billper($month, 'WITEL'),
                ],
                'DATEL' => (object) [
                    'datas' => $this->c3mr_billper($month, 'DATEL'),
                ],
                'HERO' => (object) [
                    'datas' => $this->c3mr_billper($month, 'HERO'),
                ],
            ],
            'COLLECTION NON POTS' => [
                'WITEL' => (object) [
                    'datas' => $this->collection_non_pots_witel($month),
                ]
            ],
            'COMBAT THE CHURN' => [
                'WITEL' => (object) [
                    'datas' => $this->combat_the_churn($month),
                ]
            ],
            'INDIBIZ SALES' => [
                'WITEL' => (object) [
                    'datas' => $this->indibiz_sales($month, 'WITEL'),
                ],
                'DATEL' => (object) [
                    'datas' => $this->indibiz_sales($month, 'DATEL'),
                ],
                'HERO' => (object) [
                    'datas' => $this->indibiz_sales($month, 'HERO'),
                ],
            ],
            'VISITING & PROFILING' => [
                'WITEL' => (object) [
                    'datas' => $this->visiting_profiling($month, 'WITEL'),
                ],
                'DATEL' => (object) [
                    'datas' => $this->visiting_profiling($month, 'DATEL'),
                ],
                'HERO' => (object) [
                    'datas' => $this->visiting_profiling($month, 'HERO'),
                ],
            ],
            'EKOSISTEM BISNIS' => [
                'WITEL' => (object) [
                    'datas' => $this->ekosistem_bisnis($month, 'WITEL'),
                ],
                'DATEL' => (object) [
                    'datas' => $this->ekosistem_bisnis($month, 'DATEL'),
                ],
                'HERO' => (object) [
                    'datas' => $this->ekosistem_bisnis($month, 'HERO'),
                ],
            ],
        ];

        // print('<pre>' . print_r($category . ' -- ' . $area) . '</pre>');
        // print('<pre>' . print_r($get_data_by_category[$category][$area], true) . '</pre>');
        // exit;

        return $get_data_by_category[$category][$area];
    }

    public function c3mr_all_bill($month, $viewed_by)
    {
        $accumulate = "case when sum(lis_total) = 0 or sum(lis_bill) = 0 then 0 else round((sum(lis_total)/sum(lis_bill))*100,2) end as reals,
        98 as tgt,
        case when sum(lis_total) = 0 or sum(lis_bill) = 0 then 0 else round(((round((sum(lis_total)/sum(lis_bill))*100,2))/98)*100,2) end as ach";

        if ($viewed_by === 'WITEL') {
            $mapping1 = "x.shows as viewed,";
            $mapping2 = "witel as shows";
            $clause_mapping = "";
            $join = "on x.shows = datas.witel";
            $grouping = "group by viewed";
            $ordering = "order by ach desc, viewed asc";
            $clause_main_where = "and x.shows is not null";
        } elseif ($viewed_by === 'DATEL') {
            $mapping1 = "x.witel, x.shows as viewed,";
            $mapping2 = "witel, datel as shows";
            $clause_mapping = "";
            $join = "on x.shows = datas.datel";
            $grouping = "group by x.witel, viewed";
            $ordering = "order by ach desc, x.witel asc, viewed asc";
            $clause_main_where = "and x.witel is not null";
        } else {
            $mapping1 = "x.witel, x.datel, x.shows as viewed,";
            $mapping2 = "witel, datel, sto_desc, hero as shows";
            $clause_mapping = "and hero is not null";
            $join = "on x.sto_desc = datas.sto_name and x.datel = datas.datel and x.witel = datas.witel";
            $grouping = "group by x.witel, x.datel, viewed";
            $ordering = "order by ach desc, x.witel asc, x.datel asc, viewed asc";
            $clause_main_where = "and x.witel is not null";
        }

        $query = "
        select $mapping1
            $accumulate
        from program_9_bintang.c3mr_billper as datas
        join (select distinct $mapping2 from program_9_bintang.mapping_data where divre='DIVRE 5' $clause_mapping) as x
        $join
        where bulan = '$month' $clause_main_where
        $grouping
        $ordering";

        return (object) [
            "query" => $query,
            "data" => $this->postgres->query($query)->result(),
            "category" => "C3MR ALL BILLING",
        ];
    }

    public function c3mr_billper($month, $viewed_by)
    {
        $accumulate = "case when sum(lis_total) = 0 or sum(lis_bill) = 0 then 0 else round((sum(lis_total)/sum(lis_bill))*100,2) end as reals, 
        99.5 as tgt, 
        case when sum(lis_total) = 0 or sum(lis_bill) = 0 then 0 else round(((round((sum(lis_total)/sum(lis_bill))*100,2))/99.5)*100,2) end as ach";

        if ($viewed_by === 'WITEL') {
            $mapping1 = "x.shows as viewed,";
            $mapping2 = "witel as shows";
            $clause_mapping = "";
            $join = "on x.shows = datas.witel";
            $grouping = "group by viewed";
            $ordering = "order by ach desc, viewed asc";
            $clause_main_where = "and x.shows is not null";
        } elseif ($viewed_by === 'DATEL') {
            $mapping1 = "x.witel, x.shows as viewed,";
            $mapping2 = "witel, datel as shows";
            $clause_mapping = "";
            $join = "on x.shows = datas.datel";
            $grouping = "group by x.witel, viewed";
            $ordering = "order by ach desc, x.witel asc, viewed asc";
            $clause_main_where = "and x.witel is not null";
        } else {
            $mapping1 = "x.witel, x.datel, x.shows as viewed,";
            $mapping2 = "witel, datel, sto_desc, hero as shows";
            $clause_mapping = "and hero is not null";
            $join = "on x.sto_desc = datas.sto_name and x.datel = datas.datel and x.witel = datas.witel";
            $grouping = "group by x.witel, x.datel, viewed";
            $ordering = "order by ach desc, x.witel asc, x.datel asc, viewed asc";
            $clause_main_where = "and x.witel is not null";
        }

        $query = "select $mapping1
            $accumulate
        from program_9_bintang.c3mr_billper as datas
        join (select distinct $mapping2 from program_9_bintang.mapping_data where divre='DIVRE 5' $clause_mapping) as x
        $join
        where bulan = '$month' $clause_main_where
        $grouping
        $ordering";

        return (object) [
            "query" => $query,
            "data" => $this->postgres->query($query)->result(),
            "category" => "C3MR BILLING PERDANA",
        ];
    }

    public function collection_non_pots_witel($month)
    {
        $query = "select x.witel as viewed, 
            case when cl_cash = 0 or (bill_total-bill_bjt+cash_bjt) = 0 then 0 else round((cl_cash/(bill_total-bill_bjt+cash_bjt))*100,2) end as reals,
            98 as tgt,
            case when cl_cash = 0 or (bill_total-bill_bjt+cash_bjt) = 0 then 0 else round((round((cl_cash/(bill_total-bill_bjt+cash_bjt))*100,2)/98)*100,2) end as ach
        from program_9_bintang.c3mr_non_pots as datas
        join (select distinct witel from program_9_bintang.mapping_data where divre='DIVRE 5') as x
        on x.witel = datas.witel
        where datas.bulan = '$month'
        order by ach desc, viewed asc";

        return (object) [
            "query" => $query,
            "data" => $this->postgres->query($query)->result(),
            "category" => "COLLECTION NON POTS",
        ];
    }

    public function psre($month, $viewed_by)
    {
        $clause_main_where = "where x.witel is not null";

        if ($viewed_by === 'WITEL') {
            $mapping1 = "witel";
            $mapping2 = "witel";
            $clause_mapping = "";
            $accumulate = "x.witel as viewed, case when coalesce(reals_ps,0) = 0 or coalesce(reals_ps,0) = 0 then 0 else round((coalesce(reals_ps,0)/coalesce(reals_re,0))*100,2) end as reals, 92 as tgt, case when coalesce(reals_ps,0) = 0 or coalesce(reals_re,0) = 0 then 0 else round((round((reals_ps/reals_re)*100,2)/92)*100,2) end as ach";
            $join1 = "on x.witel = ps.witel";
            $join2 = "on x.witel = re.witel";
            $grouping = "";
            $ordering = "order by ach desc, x.witel asc";
        } elseif ($viewed_by === 'DATEL') {
            $mapping1 = "witel, datel";
            $mapping2 = "witel, datel";
            $clause_mapping = "";
            $accumulate = "x.witel, x.datel as viewed, case when coalesce(reals_ps,0) = 0 or coalesce(reals_re,0) = 0 then 0 else round((coalesce(reals_ps,0)/coalesce(reals_re,0))*100,2) end as reals, 92 as tgt, case when coalesce(reals_ps,0) = 0 or coalesce(reals_ps,0) = 0 then 0 else round((round((reals_ps/reals_re)*100,2)/92)*100,2) end as ach";
            $join1 = "on x.witel = ps.witel and x.datel = ps.datel";
            $join2 = "on x.witel = re.witel and x.datel = re.datel";
            $grouping = "";
            $ordering = "order by ach desc, x.witel asc, x.datel asc";
        } else {
            $mapping1 = "witel, datel, sto";
            $mapping2 = "witel, datel, kode_sto, hero";
            $clause_mapping = "and hero is not null";
            $accumulate = "x.witel, x.datel, x.hero as viewed, case when coalesce(sum(reals_ps),0) = 0 or coalesce(sum(reals_re),0) = 0 then 0 else round((coalesce(sum(reals_ps),0)/coalesce(sum(reals_re),0))*100,2) end as reals, 92 as tgt, case when coalesce(sum(reals_ps),0) = 0 or coalesce(sum(reals_re),0) = 0 then 0 else round((round((coalesce(sum(reals_ps))/coalesce(sum(reals_re)))*100,2)/92)*100,2) end as ach";
            $join1 = "on x.witel = ps.witel and x.datel = ps.datel and x.kode_sto = ps.sto";
            $join2 = "on x.witel = re.witel and x.datel = re.datel and x.kode_sto = re.sto";
            $grouping = "group by x.witel, x.datel, x.hero";
            $ordering = "order by ach desc, x.witel asc, x.datel asc, x.hero asc";
        }

        $query = "with ps_datas as (
            select $mapping1, count(*)::numeric as reals_ps
            from program_9_bintang.xpro_ps_selfie 
            where to_char(order_date, 'yyyymm')='$month' and regional = '5'
            group by $mapping1
        ), re_datas as (
            select $mapping1, count(*)::numeric as reals_re
            from program_9_bintang.xpro_re_selfie 
            where to_char(order_date, 'yyyymm')='$month' and regional = '5'
            group by $mapping1
        )
        select $accumulate
        from (select distinct $mapping2 from program_9_bintang.mapping_data where divre='DIVRE 5' $clause_mapping) as x 
        full join ps_datas as ps
        $join1
        full join re_datas as re
        $join2 
        $clause_main_where
        $grouping
        $ordering";

        return (object) [
            "query" => $query,
            "data" => $this->postgres->query($query)->result(),
            "category" => "PS/RE",
        ];
    }

    public function combat_the_churn($month)
    {
        $query = "with ct0_krg_6 as (
            select witel, count(*)::numeric as ct0_krg_6 
            from program_9_bintang.ct0_bright 
            where regional_bill = 'DIVRE 5' and group_usia_ps in ('<= 3 Bulan','4 - 5 Bulan') and nper = '$month'
            group by witel
        ), ct0 as (
            select witel, count(*)::numeric jml_ct0
            from program_9_bintang.ct0_bright
            where regional_bill = 'DIVRE 5' and nper = '$month'
            group by witel
        )
        select x.witel as viewed, 
            round((ct0_krg_6/jml_ct0)*100,2) as reals,
            20 as tgt,
            round((20/round((ct0_krg_6/jml_ct0)*100,2))*100,2) as ach
        from (select distinct witel from program_9_bintang.mapping_data where divre='DIVRE 5') as x
        join ct0_krg_6 as datas_a
        on x.witel = datas_a.witel
        join ct0 as datas_b
        on x.witel = datas_b.witel
        order by ach desc";

        return (object) [
            "query" => $query,
            "data" => $this->postgres->query($query)->result(),
            "category" => "COMBAT THE CHURN",
        ];
    }

    public function indibiz_sales($month, $viewed_by)
    {
        $clause_main_where = "where x.witel is not null";

        if ($viewed_by === 'WITEL') {
            $mapping1 = "witel";
            $mapping2 = "witel";
            $accumulate = "x.witel as viewed, coalesce(tgt,0) as tgt, coalesce(reals,0) as reals, case when coalesce(tgt,0) = 0 or coalesce(reals,0) = 0 then 0 else round((coalesce(reals,0)/coalesce(tgt,0))*100,2) end as ach";
            $join1 = "on x.witel = indibiz.witel";
            $join2 = "on x.witel = tgt.witel";
            $grouping = "";
            $clause_mapping = "";
        } elseif ($viewed_by === 'DATEL') {
            $mapping1 = "witel, datel";
            $mapping2 = "witel, datel";
            $accumulate = "x.witel, x.datel as viewed, coalesce(tgt,0) as tgt, coalesce(reals,0) as reals, case when coalesce(tgt,0) = 0 or coalesce(reals,0) = 0 then 0 else round((coalesce(reals,0)/coalesce(tgt,0))*100,2) end as ach";
            $join1 = "on x.witel = indibiz.witel and x.datel = indibiz.datel";
            $join2 = "on x.witel = tgt.witel and x.datel = tgt.viewed";
            $grouping = "";
            $clause_mapping = "";
        } else {
            $mapping1 = "witel, datel, sto";
            $mapping2 = "witel, datel, kode_sto, hero";
            $accumulate = "x.witel, x.datel, x.hero as viewed, coalesce(round(avg(tgt),0),0) as tgt, coalesce(round(sum(reals),0),0) as reals, case when coalesce(round(avg(tgt),0),0) = 0 or coalesce(round(sum(reals),0),0) = 0 then 0 else round((coalesce(round(sum(reals),0),0)/coalesce(round(avg(tgt),0),0))*100,2) end as ach";
            $join1 = "on x.witel = indibiz.witel and x.datel = indibiz.datel and x.kode_sto = indibiz.sto";
            $join2 = "on x.witel = tgt.witel and x.hero = tgt.viewed";
            $grouping = "group by x.witel, x.datel, x.hero";
            $clause_mapping = "and hero is not null";
        }

        $query = "with indibiz as (
            select $mapping1, count(*) as reals from program_9_bintang.hsi_bright where period='$month' and treg = 'DIVRE 5' and produk in ('HSI B2B', 'HSI RESELLER') group by $mapping1
        ), tgt_indibiz as (
            select proportion.witel, viewed, round((target*(proportion)),0) as tgt
            from program_9_bintang.proportion_tgt_indibiz as proportion 
            join (select * from program_9_bintang.target_indibiz_sales) as tgt
            on proportion.witel = tgt.witel
            where bulan = '$month' and viewed_by = '$viewed_by' and jenis_target = 'RACING'
        )
        select $accumulate
        from (select distinct $mapping2 from program_9_bintang.mapping_data where divre='DIVRE 5' $clause_mapping) as x
        full join indibiz
        $join1
        full join tgt_indibiz as tgt
        $join2 
        $clause_main_where
        $grouping
        order by ach desc";

        return (object) [
            "query" => $query,
            "data" => $this->postgres->query($query)->result(),
            "category" => "INDIBIZ SALES",
        ];
    }

    public function visiting_profiling($month, $viewed_by)
    {
        $clause_main_where = "where x.witel is not null";

        if ($viewed_by === 'WITEL') {
            $mapping1 = "witel as viewed";
            $grouping = "witel";
        } elseif ($viewed_by === 'DATEL') {
            $mapping1 = "witel, datel as viewed";
            $grouping = "witel, datel";
        } else {
            $mapping1 = "witel, datel, hero as viewed";
            $grouping = "witel, datel, hero";
        }

        $query = "select $mapping1, round(avg(reals),0) as reals, round(avg(tgt)) as tgt, round((avg(reals)/avg(tgt))*100,2) as ach
        from program_9_bintang.visiting_profiling where month='$month'
        group by $grouping";

        return (object) [
            "query" => $query,
            "data" => $this->postgres->query($query)->result(),
            "category" => "VISITING & PROFILING",
        ];
    }

    public function ekosistem_bisnis($month, $viewed_by)
    {
        $clause_main_where = "where x.witel is not null";

        if ($viewed_by === 'WITEL') {
            $mapping1 = "witel as viewed";
            $grouping = "witel";
        } elseif ($viewed_by === 'DATEL') {
            $mapping1 = "witel, datel as viewed";
            $grouping = "witel, datel";
        } else {
            $mapping1 = "witel, datel, hero as viewed";
            $grouping = "witel, datel, hero";
        }

        $query = "select $mapping1, round(avg(reals),0) as reals, round(avg(tgt)) as tgt, round((avg(reals)/avg(tgt))*100,2) as ach
        from program_9_bintang.ekosistem_bisnis where month='$month'
        group by $grouping";

        return (object) [
            "query" => $query,
            "data" => $this->postgres->query($query)->result(),
            "category" => "EKOSISTEM BISNIS",
        ];
    }
}
/* End of file filename.php */

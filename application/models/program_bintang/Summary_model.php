<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Summary_model extends CI_Model
{
    private $postgres = NULL;

    public function __construct()
    {
        parent::__construct();
        $this->postgres = $this->load->database('postgres', TRUE);
        $this->load->model('program_bintang/Program_bintang_model', 'progbin');
    }

    private function query_builder($query, $area)
    {
        $mapping_with = "with ";
        $join = "";
        $select = "";
        $total_ach = "round((";

        for ($i = 0; $i < count($query); $i++) {
            if ($i === 0) {
                $mapping_with .= "datas_" . $i . " as (\n";
                $mapping_with .= $query[$i] . "\n)";
            } else {
                $mapping_with .= ", datas_" . $i . " as (";
                $mapping_with .= $query[$i];
                $mapping_with .= "\n)";
            }

            $select .= "round(avg(coalesce(datas_" . $i . ".ach,0)),2) as ach_" . $i . ",\n";

            if ($i === count($query) - 1) {
                $delimiter = ")/" . count($query) . ",2) as total_ach_all";
                if ($area === 'WITEL') {
                    $join .= "full join datas_" . $i . "\n on x.witel = datas_" . $i . ".viewed";
                } elseif ($area === 'DATEL') {
                    $join .= "full join datas_" . $i . "\n on x.witel = datas_" . $i . ".witel and x.datel = datas_" . $i . ".viewed";
                } else {
                    $join .= "full join datas_" . $i . "\n on x.witel = datas_" . $i . ".witel and x.datel = datas_" . $i . ".datel and x.hero = datas_" . $i . ".viewed";
                }
            } else {
                $delimiter = "+";
                if ($area === 'WITEL') {
                    $join .= "full join datas_" . $i . "\n on x.witel = datas_" . $i . ".viewed\n";
                } elseif ($area === 'DATEL') {
                    $join .= "full join datas_" . $i . "\n on x.witel = datas_" . $i . ".witel and x.datel = datas_" . $i . ".viewed\n";
                } else {
                    $join .= "full join datas_" . $i . "\n on x.witel = datas_" . $i . ".witel and x.datel = datas_" . $i . ".datel and x.hero = datas_" . $i . ".viewed\n";
                }
            }
            $total_ach .= "avg(coalesce(datas_" . $i . ".ach,0))" . $delimiter;
        }
        $mapping_with .= "\n";

        if ($area === 'WITEL') {
            $show = "x.witel as viewed,";
            $grouping = "group by x.witel";
            $mapping_name = "witel";
            $clause_mapping = "";
        } elseif ($area === 'DATEL') {
            $show = "x.witel, x.datel as viewed,";
            $grouping = "group by x.witel, x.datel";
            $mapping_name = "witel, datel";
            $clause_mapping = "";
        } else {
            $show = "x.witel, x.datel, x.hero as viewed,";
            $grouping = "group by x.witel, x.datel, x.hero";
            $mapping_name = "witel, datel, hero";
            $clause_mapping = "and hero is not null";
        }

        $main_query = $mapping_with .
            "select $show $select $total_ach\nfrom (select distinct $mapping_name from program_9_bintang.mapping_data where divre='DIVRE 5' $clause_mapping) as x
        $join
        where x.witel is not null
        $grouping
        order by total_ach_all desc";

        $resp = $this->postgres->query($main_query)->result();

        // print('<pre>' . print_r($resp, true) . '</pre>');
        // print('<pre>' . print_r($main_query, true) . '</pre>');
        // exit;

        return $resp;
    }

    public function get_datas($month, $area)
    {
        $get_data_by_category = [
            'WITEL' => [
                'queries' => [
                    $this->progbin->psre($month, 'WITEL')->query,
                    $this->progbin->c3mr_all_bill($month, 'WITEL')->query,
                    $this->progbin->c3mr_billper($month, 'WITEL')->query,
                    $this->progbin->collection_non_pots_witel($month)->query,
                    $this->progbin->combat_the_churn($month)->query,
                    $this->progbin->indibiz_sales($month, 'WITEL')->query,
                    $this->progbin->visiting_profiling($month, 'WITEL')->query,
                    $this->progbin->ekosistem_bisnis($month, 'WITEL')->query,
                ],
                'categories' => [
                    $this->progbin->psre($month, 'WITEL')->category,
                    $this->progbin->c3mr_all_bill($month, 'WITEL')->category,
                    $this->progbin->c3mr_billper($month, 'WITEL')->category,
                    $this->progbin->collection_non_pots_witel($month)->category,
                    $this->progbin->combat_the_churn($month)->category,
                    $this->progbin->indibiz_sales($month, 'WITEL')->category,
                    $this->progbin->visiting_profiling($month, 'WITEL')->category,
                    $this->progbin->ekosistem_bisnis($month, 'WITEL')->category,
                ],
            ],
            'DATEL' => [
                'queries' => [
                    $this->progbin->psre($month, 'DATEL')->query,
                    $this->progbin->c3mr_all_bill($month, 'DATEL')->query,
                    $this->progbin->c3mr_billper($month, 'DATEL')->query,
                    $this->progbin->indibiz_sales($month, 'DATEL')->query,
                    $this->progbin->visiting_profiling($month, 'DATEL')->query,
                    $this->progbin->ekosistem_bisnis($month, 'DATEL')->query,
                ],
                'categories' => [
                    $this->progbin->psre($month, 'DATEL')->category,
                    $this->progbin->c3mr_all_bill($month, 'DATEL')->category,
                    $this->progbin->c3mr_billper($month, 'DATEL')->category,
                    $this->progbin->indibiz_sales($month, 'DATEL')->category,
                    $this->progbin->visiting_profiling($month, 'DATEL')->category,
                    $this->progbin->ekosistem_bisnis($month, 'DATEL')->category,
                ],
            ],
            'HERO' => [
                'queries' => [
                    $this->progbin->psre($month, 'HERO')->query,
                    $this->progbin->c3mr_all_bill($month, 'HERO')->query,
                    $this->progbin->c3mr_billper($month, 'HERO')->query,
                    $this->progbin->indibiz_sales($month, 'HERO')->query,
                    $this->progbin->visiting_profiling($month, 'HERO')->query,
                    $this->progbin->ekosistem_bisnis($month, 'HERO')->query,
                ],
                'categories' => [
                    $this->progbin->psre($month, 'HERO')->category,
                    $this->progbin->c3mr_all_bill($month, 'HERO')->category,
                    $this->progbin->c3mr_billper($month, 'HERO')->category,
                    $this->progbin->indibiz_sales($month, 'HERO')->category,
                    $this->progbin->visiting_profiling($month, 'HERO')->category,
                    $this->progbin->ekosistem_bisnis($month, 'HERO')->category,
                ],
            ],
        ];

        // print('<pre>' . print_r(count($get_data_by_category[$area]), true) . '</pre>');
        // print('<pre>' . print_r($get_data_by_category[$area]['categories'], true) . '</pre>');
        // exit;

        $response = $this->query_builder($get_data_by_category[$area]['queries'], $area);
        // print('<pre>' . print_r($response, true) . '</pre>');
        // exit;

        return (object) [
            'categories' => $get_data_by_category[$area]['categories'],
            'datas' => $response,
            'counted_categories' => count($get_data_by_category[$area]['queries']),
        ];
    }
}
/* End of file filename.php */

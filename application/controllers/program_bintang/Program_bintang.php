<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Program_bintang extends BaseController
{
    private $categories = [];
    private $area = [];

    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('program_bintang/Program_bintang_model', 'progbin');
        $this->load->model('program_bintang/Summary_model', 'summary');
        $this->load->library('form_validation');

        $this->metadata->sidebar->parent_active = 'Program 9 Bintang';
    }

    public function ajax_post_get_data_summary()
    {
        $month = $this->input->post('month') ?? date('Y-m');
        $category = $this->input->post('category') ?? "";
        $area = $this->input->post('show') ?? "WITEL";

        $formating_month = date('Ym', strtotime($month . '-01'));
        $response = $this->summary->get_datas($formating_month, $area);

        return $this->response(200, [
            "message" => "Successfully get data.",
            "data" => $response->datas,
            "header" => $response->categories,
            "count_categories" => $response->counted_categories,
            "filter" => [
                'month' => $formating_month,
                'area' => $area,
                'category' => $category,
                'date' => date('Y-m-d'),
            ]
        ]);
    }

    private function summary_page_view()
    {
        $this->metadata->pageView = 'program_bintang/summary';

        $this->global['data'] = [
            'filter' => [
                'month' => date('Y-m'),
                'area' => "WITEL",
            ],
            'filter_data' => (object) [
                'categories' => $this->categories,
                'area' => $this->area,
            ],
        ];

        $this->loadViews("includes/main", NULL, $this->global, NULL);
    }

    public function summary()
    {
        $this->metadata->sidebar->item_active = 'SUMMARY';
        $this->metadata->sidebar->category_active = 'SUMMARY';
        $this->categories = ['SUMMARY'];
        $this->area = [
            'WITEL',
            'DATEL',
            'HERO',
        ];

        return $this->summary_page_view();
    }

    public function ajax_post_get_data()
    {
        $month = $this->input->post('month') ?? date('Y-m');
        $category = $this->input->post('category') ?? "";
        $area = $this->input->post('show') ?? "WITEL";

        $formating_month = date('Ym', strtotime($month . '-01'));
        $response = $this->progbin->get_datas($formating_month, $category, $area);

        return $this->response(200, [
            "message" => "Successfully get data.",
            "data" => $response->datas->data,
            "filter" => [
                'month' => $formating_month,
                'area' => $area,
                'category' => $category,
                'date' => date('Y-m-d'),
            ]
        ]);
    }

    private function page_view()
    {
        $this->metadata->pageView = 'program_bintang/program_sembilan_bintang';

        $this->global['data'] = [
            'filter' => [
                'month' => date('Y-m'),
                'area' => "WITEL",
            ],
            'filter_data' => (object) [
                'categories' => $this->categories,
                'area' => $this->area,
            ],
        ];

        $this->loadViews("includes/main", NULL, $this->global, NULL);
    }

    public function c3mr_all_billing()
    {
        $this->metadata->sidebar->item_active = 'C3MR ALL BILLING';
        $this->metadata->sidebar->category_active = 'C3MR ALL BILLING';
        $this->categories = ['C3MR ALL BILLING'];
        $this->area = [
            'WITEL',
            'DATEL',
            'HERO',
        ];

        return $this->page_view();
    }

    public function c3mr_billing_perdana()
    {
        $this->metadata->sidebar->item_active = 'C3MR BILLING PERDANA';
        $this->metadata->sidebar->category_active = 'C3MR BILLING PERDANA';
        $this->categories = ['C3MR BILLING PERDANA'];
        $this->area = [
            'WITEL',
            'DATEL',
            'HERO',
        ];

        return $this->page_view();
    }

    public function collection_non_pots()
    {
        $this->metadata->sidebar->item_active = 'COLLECTION NON POTS';
        $this->metadata->sidebar->category_active = 'COLLECTION NON POTS';
        $this->categories = ['COLLECTION NON POTS'];
        $this->area = [
            'WITEL',
        ];

        return $this->page_view();
    }

    public function psre()
    {
        $this->metadata->sidebar->item_active = 'PS/RE';
        $this->metadata->sidebar->category_active = 'PS/RE';
        $this->categories = ['PS/RE'];
        $this->area = [
            'WITEL',
            'DATEL',
            'HERO',
        ];

        return $this->page_view();
    }

    public function combat_the_churn()
    {
        $this->metadata->sidebar->item_active = 'COMBAT THE CHURN';
        $this->metadata->sidebar->category_active = 'COMBAT THE CHURN';
        $this->categories = ['COMBAT THE CHURN'];
        $this->area = [
            'WITEL',
        ];

        return $this->page_view();
    }

    public function indibiz_sales()
    {
        $this->metadata->sidebar->item_active = 'INDIBIZ SALES';
        $this->metadata->sidebar->category_active = 'INDIBIZ SALES';
        $this->categories = ['INDIBIZ SALES'];
        $this->area = [
            'WITEL',
            'DATEL',
            'HERO',
        ];

        return $this->page_view();
    }

    public function visiting_profiling()
    {
        $this->metadata->sidebar->item_active = 'VISITING & PROFILING';
        $this->metadata->sidebar->category_active = 'VISITING & PROFILING';
        $this->categories = ['VISITING & PROFILING'];
        $this->area = [
            'WITEL',
            'DATEL',
            'HERO',
        ];

        return $this->page_view();
    }

    public function ekosistem_bisnis()
    {
        $this->metadata->sidebar->item_active = 'EKOSISTEM BISNIS';
        $this->metadata->sidebar->category_active = 'EKOSISTEM BISNIS';
        $this->categories = ['EKOSISTEM BISNIS'];
        $this->area = [
            'WITEL',
            'DATEL',
            'HERO',
        ];

        return $this->page_view();
    }
}

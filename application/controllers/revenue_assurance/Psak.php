<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Psak extends BaseController
{
    private $categories = [];

    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('revenue_assurance/Psak_model', 'psak');
        $this->load->library('form_validation');

        $this->metadata->sidebar->parent_active = 'Revenue Assurance';
        $this->metadata->sidebar->category_active = 'PSAK';
    }

    /**
     * This function to show the view of PSAK
     */
    public function ajax_post_get_data()
    {
        $month = $this->input->post('month') ?? date('Y-m');
        $category = $this->input->post('category') ?? "";
        $area = $this->input->post('show') ?? "REGIONAL";

        if ($category === "PSAK 72 MCT") {
            $table = "psak_72_mct.confirmation_detail";
        } elseif ($category === "PSAK 72 NON MCT") {
            $table = "psak_72_non_mct.step_one_to_four";
        } else {
            $table = "psak_73.lessee";
        }

        $formating_month = date('Ym', strtotime($month . '-01'));
        $get_max_week_on_month = $this->psak->get_max_week($table, $formating_month);
        $get_max_week_on_month = empty($get_max_week_on_month->week_num) ? '0' : $get_max_week_on_month->week_num;
        $week = !empty($this->input->post('week')) ? $this->input->post('week') : $get_max_week_on_month;

        $response = $this->psak->get_datas($formating_month, $category, $area, $week);
        // print('<pre>' . print_r($response, true) . '</pre>');
        // exit;

        return $this->response(200, [
            "message" => "Successfully get data.",
            "data" => $response,
            "filter" => [
                'month' => $formating_month,
                'area' => $area,
                'category' => $category,
                'date' => date('Y-m-d'),
            ]
        ]);
    }

    public function ajax_post_get_data_week()
    {
        $request = (object) $this->input->post();
        $formating_month = date('Ym', strtotime($request->month . '-01'));

        if ($request->category === "PSAK 72 MCT") {
            $table = "psak_72_mct.confirmation_detail";
        } elseif ($request->category === "PSAK 72 NON MCT") {
            $table = "psak_72_non_mct.step_one_to_four";
        } else {
            $table = "psak_73.lessee";
        }

        $response = $this->psak->getDataWeeks($table, $formating_month);
        // print('<pre>' . print_r($response, true) . '</pre>');
        // exit;

        return $this->response(200, [
            "message" => "Successfully get data.",
            "data" => $response,
        ]);
    }

    private function page_view()
    {
        $area = [
            'REGIONAL',
            'WITEL',
        ];

        $regional = [
            'ALL',
            // 'REG-1',
            // 'REG-2',
            // 'REG-3',
            // 'REG-4',
            'REG-5',
            // 'REG-6',
            // 'REG-7',
        ];

        $this->global['data'] = [
            'filter' => [
                'month' => date('Y-m'),
                'area' => "REGIONAL",
                'regional' => "REG-5",
            ],
            'filter_data' => (object) [
                'categories' => $this->categories,
                'area' => $area,
                'regional' => $regional,
            ],
        ];

        $this->loadViews("includes/main", NULL, $this->global, NULL);
    }

    public function psak_72_mct()
    {
        $this->metadata->sidebar->item_active = 'PSAK 72 MCT';
        $this->metadata->pageView = 'revenue_assurance/psak/psak_72_mct';
        $this->categories = ['PSAK 72 MCT'];

        return $this->page_view();
    }

    public function psak_72_non_mct()
    {
        $this->metadata->sidebar->item_active = 'PSAK 72 NON MCT';
        $this->metadata->pageView = 'revenue_assurance/psak/psak_72_non_mct';

        return $this->page_view();
    }

    public function psak_73()
    {
        $this->metadata->sidebar->item_active = 'PSAK 73';
        $this->metadata->pageView = 'revenue_assurance/psak/psak_73';

        return $this->page_view();
    }
}

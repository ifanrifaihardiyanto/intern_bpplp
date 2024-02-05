<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Khs extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('logistic/Khs_model', 'log_khs');
    }

    public function index()
    {
        $this->metadata->sidebar->parent_active = 'Logistic';
        $this->metadata->sidebar->category_active = 'KHS';
        $this->metadata->sidebar->item_active = 'KHS';
        $this->metadata->pageView = 'logistic/khs';

        $this->global['data'] = [
            'filter' => [
                'month' => date('Y-m'),
                'date' => date('Y-m-d'),
            ],
        ];

        $this->loadViews("includes/main", NULL, $this->global, NULL);
    }

    public function ajax_post_get_data()
    {
        $month = $this->input->post('month') ?? date('Y-m');
        $formating_month = date('Ym', strtotime($month . '-01'));

        $response = $this->log_khs->get_datas($formating_month);
        echo json_encode($response);
    }

    public function ajax_post_get_data_filter()
    {
        $month = $this->input->post('month') ?? date('Y-m');
        $formating_month = date('Ym', strtotime($month . '-01'));

        $response = $this->log_khs->get_count_datas($formating_month);
        if ($response->amount <= 0) {
            $datas = (object) [
                "btn_text" => 'Ambil Data',
            ];
        } else {
            $datas = (object) [
                "btn_text" => 'Perbarui Data',
            ];
        }

        return $this->response(200, [
            "message" => "Successfully get data.",
            "btnScrape" => $datas->btn_text,
        ]);
    }
}

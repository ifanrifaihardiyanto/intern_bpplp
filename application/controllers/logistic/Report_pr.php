<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Report_pr extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('logistic/Report_pr_model', 'pr');
    }

    public function index()
    {
        $this->metadata->sidebar->parent_active = 'Logistic';
        $this->metadata->sidebar->category_active = 'Report PR';
        $this->metadata->sidebar->item_active = 'Report PR';
        $this->metadata->pageView = 'logistic/report_pr';

        $response = $this->pr->get_date();
        $get_maxDate = $this->pr->get_max_date();

        $this->global['data'] = [
            'filter' => [
                'month' => date('Y-m'),
                'date' => date('Y-m-d'),
                'tgl_posisi_data' => $response,
            ],
            'filter_data' => [
                'max_posisi_data' => $get_maxDate->max_date,
            ]
        ];

        $this->loadViews("includes/main", NULL, $this->global, NULL);
    }

    public function ajax_post_get_data()
    {
        $get_maxDate = $this->pr->get_max_date();
        $datePosition = $this->input->post('datePosition') ?? $get_maxDate->max_date;
        $wbsSelection = empty($this->input->post('wbsSelection')) ? "%" : $this->input->post('wbsSelection');
        $prdateSelection = empty($this->input->post('prdateSelection')) ? "%" : $this->input->post('prdateSelection');

        $response = $this->pr->get_datas($datePosition, $wbsSelection, $prdateSelection);

        return $this->response(200, [
            "message" => "Successfully get data.",
            "result" => $response,
        ]);
    }

    public function ajax_post_get_data_wbs_element()
    {
        $datePosition = $this->input->post('datePosition');

        $responseWBS = $this->pr->get_wbs_element($datePosition);
        $responsePRDate = $this->pr->get_pr_date($datePosition);

        return $this->response(200, [
            "message" => "Successfully get data.",
            "responseWBS" => $responseWBS,
            "responsePRDate" => $responsePRDate,
        ]);
    }
}

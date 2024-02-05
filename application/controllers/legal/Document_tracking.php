<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Document_tracking extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('legal/Tracking_model', 'tracking');
        $this->load->library('form_validation');

        $this->metadata->sidebar->parent_active = 'Legal';
        $this->metadata->sidebar->category_active = 'Document Tracking';
    }

    /**
     * This function to show the view of PSAK
     */
    public function ajax_post_get_data()
    {
        // $month = $this->input->post('month') ?? date('Y-m');
        // $category = $this->input->post('category') ?? "";
        // $area = $this->input->post('show') ?? "REGIONAL";

        // $formating_month = date('Ym', strtotime($month . '-01'));

        $response = $this->tracking->get_datas();
        // print('<pre>' . print_r($response, true) . '</pre>');
        // exit;

        return $this->response(200, [
            "message" => "Successfully get data.",
            "data" => $response,
        ]);
    }

    public function insert_doc_name()
    {
        $request = (object) $this->input->post();
        $contractDate = date('Y-m-d H:i:s', strtotime($request->contractDate));

        $datas = [
            'contract_name' => $request->contractTitle,
            'contract_num' => $request->contractNum,
            'contract_date' => $contractDate,
            'contract_amount' => $request->contractAmount,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'active' => '1',
        ];

        $insert_doc_name = $this->tracking->insert_doc_name($datas);

        if ($insert_doc_name) {
            return $this->response(200, [
                "message" => "Successfully insert data.",
                "data" => $datas,
            ]);
        } else {
            return $this->response(500, [
                "message" => "Data sudah ada di dalam sistem!",
            ]);
        }
    }

    public function insert_detail_review()
    {
        $request = (object) $this->input->post();
        $FilesUpload = $_FILES['document_upload']['name'];
        $date = date('Y-m-d', strtotime($request->entryDate));

        print('<pre>' . print_r($request) . '</pre>');
        print('<pre>' . print_r($FilesUpload) . '</pre>');
        exit;

        $db_table = $this->check_status_date($request->dateCategory);

        if (empty($request->userPIC)) {
            return $this->response(500, [
                "message" => "Inputan PIC harus di isi!",
            ]);
        }

        if (empty($request->explanation)) {
            return $this->response(500, [
                "message" => "Inputan keterangan harus di isi!",
            ]);
        }

        $datas = [
            'date' => $date,
            'explanation' => $request->explanation,
            'name_of_takes' => $request->userPIC,
            'contract_doc_id' => $request->idDocument,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        // $insert_detail_review = $this->tracking->insert_detail_review_doc($datas, $db_table);

        // if ($insert_detail_review) {
        //     return $this->response(200, [
        //         "message" => "Successfully insert data.",
        //         "data" => $datas,
        //     ]);
        // } else {
        //     return $this->response(500, [
        //         "message" => "Data sudah ada di dalam sistem!",
        //     ]);
        // }

        return $this->response(200, [
            "message" => "Successfully insert data.",
            "data" => $datas,
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
            'REG-1',
            'REG-2',
            'REG-3',
            'REG-4',
            'REG-5',
            'REG-6',
            'REG-7',
        ];

        $this->global['data'] = [
            'filter' => [
                'month' => date('Y-m'),
                'area' => "REGIONAL",
                'regional' => "REG-5",
                'date' => date('Y-m-d'),
            ],
            'filter_data' => (object) [
                'area' => $area,
                'regional' => $regional,
            ],
        ];

        $this->loadViews("includes/main", NULL, $this->global, NULL);
    }

    public function index()
    {
        $this->metadata->sidebar->item_active = 'Document Tracking';
        $this->metadata->pageView = 'legal/document_tracking';

        return $this->page_view();
    }

    public function get_doc_name()
    {
        $response = $this->tracking->get_doc_name();

        return $this->response(200, [
            "message" => "Successfully get data.",
            "data" => $response,
        ]);
    }

    public function ajax_get_detail_review()
    {
        $request = (object) $this->input->get();

        $response = $this->tracking->get_detail_review($request->idDocName);

        return $this->response(200, [
            "message" => "Successfully get data.",
            "data" => $response->review,
            "doc_name" => $response->document,
        ]);
    }

    public function ajax_delete_document_name()
    {
        $request = (object) $this->input->post();

        $response = $this->tracking->delete_doc_name($request->idDocName);

        return $this->response(200, [
            "message" => "Successfully get data.",
            "data" => $response,
        ]);
    }

    public function ajax_delete_detail_review_document()
    {
        $request = (object) $this->input->post();
        // print('<pre>' . print_r($request, true) . '</pre>');
        // exit;

        $db_table = $this->check_status_date($request->status);

        $response = $this->tracking->delete_detail_review_doc_name($request->idDocName, $db_table);

        return $this->response(200, [
            "message" => "Successfully get data.",
            "data" => $response,
        ]);
    }

    private function check_status_date()
    {
        if ($request->dateCategory === 'Tanggal Masuk') {
            $db_table = "entry_review_details";
        } elseif ($request->dateCategory === 'Tanggal Kembali') {
            $db_table = "back_review_details";
        } elseif ($request->dateCategory === 'Tanggal Selesai') {
            $db_table = "exit_review_details";
        } else {
            return $this->response(500, [
                "message" => "Opsi kategori tanggal harus dipilih!",
            ]);
        }

        return $db_table;
    }
}

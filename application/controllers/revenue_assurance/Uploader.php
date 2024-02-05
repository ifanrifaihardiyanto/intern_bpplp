<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';
require 'vendor/autoload.php';

class Uploader extends BaseController
{

    private $categories = [];
    private $sub_categories = [];

    public function __construct()
    {
        parent::__construct();
        $this->load->model('revenue_assurance/Uploader_model', 'uploader');
    }

    public function index()
    {
        $this->metadata->sidebar->parent_active = 'Uploader';
        $this->metadata->sidebar->category_active = 'Revenue Assurance Uploader';
        $this->metadata->sidebar->item_active = "Revenue Assurance Uploader";
        $this->metadata->pageView = 'revenue_assurance/uploader/uploader_revenue_assurance';

        $this->categories = (object) [
            'name' => 'PSAK 72 MCT', 'PSAK 72 Non MCT', 'PSAK 73'
        ];

        $this->global['data'] = [
            'categories' => $this->categories,
            "filter" => (object) [
                'date' => date('Y-m-d'),
            ]
        ];

        $this->loadViews("includes/main", NULL, $this->global, NULL);
    }

    private function date_format($dateString)
    {
        // Extracting the date and time components using regular expressions
        if (preg_match('/(\w{3}) (\w{3}) (\d{2}) (\d{4}) (\d{2}):(\d{2}):(\d{2}) GMT(\+\d{4}) \(([\w\s]+)\)/', $dateString, $matches)) {
            $dayOfWeek = $matches[1];
            $month = $matches[2];
            $day = $matches[3];
            $year = $matches[4];
            $hour = $matches[5];
            $minute = $matches[6];
            $second = $matches[7];
            $timezoneOffset = $matches[8];
            $timezone = $matches[9];

            // Create a DateTime object using the extracted components
            $dateTimeString = "$year-$month-$day $hour:$minute:$second $timezoneOffset";
            $dateTime = DateTime::createFromFormat('Y-M-d H:i:s P', $dateTimeString);

            if ($dateTime !== false) {
                // Set the desired timezone
                $newTimeZone = new DateTimeZone('Asia/Jakarta');
                $dateTime->setTimezone($newTimeZone);

                // Format the date to Ymd
                $newDateFormat = $dateTime->format('Y-m-d');
                return $newDateFormat; // Output: 2023-12-06
            } else {
                return "Failed to create DateTime object.";
            }
        } else {
            return "Failed to match the date string.";
        }
    }

    private function getWeekNumber($dateString)
    {
        $date = new DateTime($dateString);

        // Get the month and year from the date
        $month = $date->format('m');
        $year = $date->format('Y');

        // Find the first day of the month
        $firstDayOfMonth = new DateTime("$year-$month-01");

        // Calculate the week number for the specified date within the month
        $weekNumberInMonth = ceil(($date->format('j') + $firstDayOfMonth->format('N')) / 7);

        // ====================== date range on week ======================

        // Calculate the start of the week (Sunday)
        $startDate = date('Y-m-01', strtotime($dateString));
        $startOfWeek = clone $date;
        $changeStartOfWeek = $startOfWeek->format('Y-m-d');
        $dateOnName = date('D', strtotime($changeStartOfWeek));
        if ($dateOnName === 'Sun') {
            $startOfWeek->modify('sunday');
        } else {
            $startOfWeek->modify('last sunday');
        }

        $dateStartOfWeek = $startOfWeek->format('Y-m-d');
        if ($dateStartOfWeek < $startDate) {
            $dateStartOfWeek = $startDate;
        } else {
            $dateStartOfWeek = $dateStartOfWeek;
        }

        // Calculate the end of the week (Saturday)
        $endDate = date('Y-m-t', strtotime($dateString));
        $endOfWeek = clone $date;
        $endOfWeek->modify('saturday');
        $dateEndOfWeek = $endOfWeek->format('Y-m-d');
        if ($dateEndOfWeek > $endDate) {
            $dateEndOfWeek = $endDate;
        } else {
            $dateEndOfWeek = $dateEndOfWeek;
        }

        return (object) [
            'weekNumberInMonth' => $weekNumberInMonth,
            'dateStartOfWeek' => $dateStartOfWeek,
            'dateEndOfWeek' => $dateEndOfWeek,
        ];
    }

    public function ajax_upload_post_request()
    {
        $request = (object) $this->input->post();
        $formating_month = date('Ym', strtotime($request->month));

        $date = date('Y-m-d', strtotime($request->month));
        $getWeekNum = $this->getWeekNumber($date);

        // print('<pre>' . print_r($->weekNumberInMonthgetWeekNum, true) . '</pre>');
        // print('<pre>' . print_r($date, true) . '</pre>');
        // exit;

        if ($request->category_name === "PSAK 72 MCT") {
            $schema = "psak_72_mct";
        } elseif ($request->category_name === "PSAK 72 Non MCT") {
            $schema = "psak_72_non_mct";
        } else {
            $schema = "psak_73";
        }

        try {
            foreach ($request->body_columns as $value) {
                if ($request->category_name === "PSAK 72 MCT") {
                    if ($request->sub_category_name === 'DETAIL KONFIRMASI') {
                        // confirmation detail
                        $insert_data = (object) [
                            "contract_num" => $value[0],
                            "total_amount_contract" => $value[1],
                            "tibs_value" => $value[2] === "" ? '0' : $value[2],
                            "divisi" => $value[3],
                            "segmen" => $value[4],
                            "treg" => $value[5],
                            "cust_name" => $value[6],
                            "contract_desc" => $value[7],
                            "order" => $value[8],
                            "sid" => $value[9],
                            "ordersid" => $value[10],
                            "crowe_confirm" => $value[11],
                            "confirm_status" => $value[12],
                            "remark" => $value[13],
                            "delivery_date" => $value[14],
                            "review_of_date" => $value[15],
                            "data_collection" => $value[16],
                            "assessor" => $value[17],
                            "agent_principal_conclusion" => $value[18],
                            "pending_prioritas_top_thirty" => $value[19],
                            "respon_segmen" => $value[20],
                            "respon_crowe" => $value[21],
                            "status" => strtoupper($value[22]),
                            "date_respon" => $this->date_format($value[23]),
                            "created_at" => date('Y-m-d H:i:s'),
                            "updated_at" => date('Y-m-d H:i:s'),
                            "month" => $formating_month,
                            "week_num" => $getWeekNum->weekNumberInMonth,
                        ];
                        $db_table = $schema . ".confirmation_detail";
                    } else {
                        // data pending
                        $insert_data = (object) [
                            "contract_num" => $value[0],
                            "total_amount_contract" => $value[1],
                            "tibs_value" => $value[2] === "" ? '0' : $value[2],
                            "divisi" => $value[3],
                            "segmen" => $value[4],
                            "treg" => $value[5],
                            "unit" => $value[6],
                            "cust_name" => $value[7],
                            "contract_desc" => $value[8],
                            "order" => $value[9],
                            "sid" => $value[10],
                            "ordersid" => $value[11],
                            "data_req" => $value[12],
                            "document_status" => $value[13],
                            "pending_status" => $value[14],
                            "remark_crowe" => $value[15],
                            "population" => $value[16],
                            "data_collection" => $value[17],
                            "assessor" => $value[18],
                            "agent_principal_conclusion" => $value[19],
                            "pending_prioritas_top_thirty" => $value[20],
                            "status_of_contract" => $value[21],
                            "respon_segmen" => $value[22],
                            "respon_crowe" => $value[23],
                            "status" => strtoupper($value[24]),
                            "date_respon" => $this->date_format($value[25]),
                            "created_at" => date('Y-m-d H:i:s'),
                            "updated_at" => date('Y-m-d H:i:s'),
                            "month" => $formating_month,
                            "week_num" => $getWeekNum->weekNumberInMonth,
                        ];
                        $db_table = $schema . ".data_pending";
                    }
                } elseif ($request->category_name === "PSAK 72 Non MCT") {
                    // print('<pre>' . print_r($value, true) . '</pre>');
                    if ($request->area === "REGIONAL") {
                        if ($request->sub_category_name === 'STEP 1-4') {
                            // step 1-4
                            $insert_data = (object) [
                                "status" => strtoupper($value[0]),
                                "sid" => $value[1],
                                "order" => $value[2],
                                "ubis" => $value[3],
                                "divisi" => $value[4],
                                "segmen" => $value[5],
                                "flag_populasi" => $value[6],
                                "contract_num" => $value[7],
                                "cust_name" => $value[8],
                                "work_name" => $value[9],
                                "tibs_value" => $value[10],
                                "kb_status" => $value[11],
                                "kb_doc_accept_result" => $value[12],
                                "kb_pre_status" => $value[13],
                                "kb_pre_doc_accept_result" => $value[14],
                                "ba_splitting_status" => $value[15],
                                "ba_splitting_doc_accept_result" => $value[16],
                                "p_one_status" => $value[17],
                                "p_one_doc_accept_result" => $value[18],
                                "kl_status" => $value[19],
                                "kl_doc_accept_result" => $value[20],
                                "wo_status" => $value[21],
                                "wo_doc_accept_result" => $value[22],
                                "accept_status_step_one_to_four_exc_confirm" => $value[23],
                                "remark_accept_status_step_one_to_four_exc_confirm" => $value[24],
                                "pending_kb_detail" => $value[25],
                                "pending_preceeding_kb_detail" => $value[26],
                                "pending_ba_splitting_detail" => $value[27],
                                "p_one_pending_detail" => $value[28],
                                "kl_pending_detail" => $value[29],
                                "wo_pending_detail" => $value[30],
                                "non_sda_population" => $value[31],
                                "sda_population" => $value[32],
                                "segment_shift" => $value[33],
                                "cy_py_conclusion" => $value[34],
                                "agent_principal_conclusion" => $value[35],
                                "created_at" => date('Y-m-d H:i:s'),
                                "updated_at" => date('Y-m-d H:i:s'),
                                "month" => $formating_month,
                                "week_num" => $getWeekNum->weekNumberInMonth,
                            ];
                            $db_table = $schema . ".step_one_to_four";
                        } elseif ($request->sub_category_name === 'STEP 5') {
                            // step 5
                            $insert_data = (object) [
                                "status" => strtoupper($value[0]),
                                "sid" => $value[1],
                                "order" => $value[2],
                                "ubis" => $value[3],
                                "divisi" => $value[4],
                                "segmen" => $value[5],
                                "flag_population" => $value[6],
                                "contract_num" => $value[7],
                                "cust_name" => $value[8],
                                "work_name" => $value[9],
                                "tibs_value" => $value[10],
                                "baso_status" => $value[11],
                                "baso_doc_accept_result" => $value[12],
                                "bast_bapp_ba_rekon_status" => $value[13],
                                "bast_bapp_ba_rekon_doc_accept_result" => $value[14],
                                "accept_status_step_five_after_cleansing" => $value[15],
                                "remark_accept_status_step_five_exc_confirm" => $value[16],
                                "baso_pending_detail" => $value[17],
                                "bast_bapp_ba_rekon_pending_detail" => $value[18],
                                "flagging_status" => $value[19],
                                "segment_shift" => $value[20],
                                "cy_py_conclusion" => $value[21],
                                "agent_principal_conclusion" => $value[22],
                                "created_at" => date('Y-m-d H:i:s'),
                                "updated_at" => date('Y-m-d H:i:s'),
                                "month" => $formating_month,
                                "week_num" => $getWeekNum->weekNumberInMonth,
                            ];
                            $db_table = $schema . ".step_five";
                        } elseif ($request->sub_category_name === 'LIST KONFIRMASI') {
                            // confirmation_list
                            $insert_data = (object) [
                                "sid" => $value[0],
                                "order" => $value[1],
                                "ordersid" => $value[2],
                                "flag_population" => $value[3],
                                "ubis" => $value[4],
                                "divisi" => $value[5],
                                "segmen" => $value[6],
                                "contract_num" => $value[7],
                                "cust_name" => $value[8],
                                "work_name" => $value[9],
                                "tibs_value" => $value[10],
                                "problem_explan_from_bdo" => $value[11],
                                "segment_confirm_answer" => $value[12],
                                "bdo_response" => $value[13],
                                "final_status_substantive_contract_confirm" => strtoupper($value[14]),
                                "remark_substantive_contract_confirm" => $value[15],
                                "flaging_confirm_step_one_to_four" => $value[16],
                                "flaging_confirm_step_five" => $value[17],
                                "cy_py_conclusion" => $value[18],
                                "non_sda_population" => $value[19],
                                "sda_population" => $value[20],
                                "conn_service_only" => $value[21],
                                "ssuk_sskk_pending" => $value[22],
                                "pending_confirm_late_active_billing" => $value[23],
                                "service_pending_confirm_late_active_billing" => $value[24],
                                "pending_nature_of_service" => $value[25],
                                "pending_nature_for_service" => $value[26],
                                "pending_tarif_confirm" => $value[27],
                                "pending_tarif_confirm_for_service" => $value[28],
                                "pending_order_sid" => $value[29],
                                "pending_order_sid_for_service" => $value[30],
                                "pending_ba_typo_doc_contract" => $value[31],
                                "remark_ba_explain_doc_contract" => $value[32],
                                "renewal_template_inconsistency" => $value[33],
                                "service_list_template_inconsistency" => $value[34],
                                "confirm_answer_doc_contract" => $value[35],
                                "final_status_doc_contract" => strtoupper($value[36]),
                                "pending_lpl_bapl" => $value[37],
                                "kl_and_vendor_information_pending_lpl_bapl" => $value[38],
                                "pending_bast_partner" => $value[39],
                                "kl_and_vendor_information_pending_bast_partner" => $value[40],
                                "pending_ba_typo_doc_partner" => $value[41],
                                "remark_ba_explain_doc_partner" => $value[42],
                                "confirm_answer_doc_partner" => $value[43],
                                "final_status_doc_partner" => strtoupper($value[44]),
                                "created_at" => date('Y-m-d H:i:s'),
                                "updated_at" => date('Y-m-d H:i:s'),
                                "month" => $formating_month,
                                "week_num" => $getWeekNum->weekNumberInMonth,
                            ];
                            $db_table = $schema . ".confirmation_list";
                        } elseif ($request->sub_category_name === 'UNIDENTIFIED KB') {
                            // unidentified_kb
                            $insert_data = (object) [
                                "status" => $value[0],
                                "population" => $value[1],
                                "sid" => $value[2],
                                "order" => $value[3],
                                "tibs_value" => $value[4],
                                "agreenum" => $value[5],
                                "division" => $value[6],
                                "segment" => $value[7],
                                "contract_num" => $value[8],
                                "status_doc_reception_result" => strtoupper($value[9]),
                                "contract_num_if_recieved" => $value[10],
                                "contract_value" => $value[11],
                                "remark" => $value[12],
                                "already_upload_gdrive" => $value[13],
                                "segment_shift" => $value[14],
                                "created_at" => date('Y-m-d H:i:s'),
                                "updated_at" => date('Y-m-d H:i:s'),
                                "month" => $formating_month,
                                "week_num" => $getWeekNum->weekNumberInMonth,
                            ];
                            $db_table = $schema . ".unidentified_kb";
                        } elseif ($request->sub_category_name === 'CR VARIABLE') {
                            // cr_variable
                            $insert_data = (object) [
                                "population" => $value[0],
                                "sid" => $value[1],
                                "order" => $value[2],
                                "tibs_value" => $value[3],
                                "agreenum" => $value[4],
                                "division" => $value[5],
                                "segment" => $value[6],
                                "contract_num" => $value[7],
                                "remark" => $value[8],
                                "status_doc_reception_result" => strtoupper($value[9]),
                                "contract_value" => $value[10],
                                "already_upload_gdrive" => $value[11],
                                "segment_shift" => $value[12],
                                "created_at" => date('Y-m-d H:i:s'),
                                "updated_at" => date('Y-m-d H:i:s'),
                                "month" => $formating_month,
                                "week_num" => $getWeekNum->weekNumberInMonth,
                            ];
                            $db_table = $schema . ".cr_variable";
                        } else {
                            // confirmation_split_bill
                            $insert_data = (object) [
                                "prev_contract_periode" => $value[0],
                                "sid" => $value[1],
                                "order" => $value[2],
                                "division" => $value[3],
                                "segment" => $value[4],
                                "billing_period" => $value[5],
                                "tibs_value" => $value[6],
                                "internal_adjustment_under_ordersid" => $value[7],
                                "contract_extention_under_ordersid" => $value[8],
                                "representative_order_amendment" => $value[9],
                                "final_status" => strtoupper($value[10]),
                                "remark" => $value[11],
                                "flagging_ryn" => $value[12],
                                "contract_extention_under_ordersid_flagging_ryn" => $value[13],
                                "created_at" => date('Y-m-d H:i:s'),
                                "updated_at" => date('Y-m-d H:i:s'),
                                "month" => $formating_month,
                                "week_num" => $getWeekNum->weekNumberInMonth,
                            ];
                            $db_table = $schema . ".confirm_split_bill";
                        }
                    } else {
                        $insert_data = (object) [
                            "categories" => $value[0],
                            "segmen" => $value[1],
                            "contract_num" => $value[2],
                            "cust_name" => $value[3],
                            "work_name" => $value[4],
                            "tibs_value" => $value[5],
                            "status" => strtoupper($value[6]),
                            "witel" => $value[7],
                            "created_at" => date('Y-m-d H:i:s'),
                            "updated_at" => date('Y-m-d H:i:s'),
                            "month" => $formating_month,
                            "week_num" => $getWeekNum->weekNumberInMonth,
                        ];
                        $db_table = $schema . ".witel_datas_psak";
                    }
                } else {
                    if ($request->sub_category_name === "LESSEE") {
                        $insert_data = (object) [
                            "population_contract_num" => $value[0],
                            "population_contract_num_manner" => $value[1],
                            "fcbp" => $value[2],
                            "treg" => $value[3],
                            "ubis_division" => $value[4],
                            "segmen" => $value[5],
                            "sap_business_area" => $value[6],
                            "population_source" => $value[7],
                            "contract_id_pending_data" => $value[8],
                            "po_num" => $value[9],
                            "wbs_element" => $value[10],
                            "doc_req_period" => $value[11],
                            "service_contract_num_with_supplier" => $value[12],
                            "kl_project_name" => $value[13],
                            "mitra_name" => $value[14],
                            "subcription_contract_num" => $value[15],
                            "kb_project_name" => $value[16],
                            "cust_name" => $value[17],
                            "kl_status" => $value[18],
                            "kl_bootcamp_status" => $value[19],
                            "kl_preceeding_status" => $value[20],
                            "kl_preceeding_bootcamp_status" => $value[21],
                            "ba_splitting_kl_status" => $value[22],
                            "ba_splitting_kl_bootcamp_status" => $value[23],
                            "p_one_status" => $value[24],
                            "p_one_bootcamp_status" => $value[25],
                            "kb_status" => $value[26],
                            "kb_bootcamp_status" => $value[27],
                            "kb_preceeding_status" => $value[28],
                            "kb_preceeding_bootcamp_status" => $value[29],
                            "bast_mitra_status" => $value[30],
                            "bast_mitra_bootcamp_status" => $value[31],
                            "bast_pelanggan_status" => $value[32],
                            "bast_pelanggan_bootcamp_status" => $value[33],
                            "final_status" => strtoupper($value[34]),
                            "remarks_status" => $value[35],
                            "remarks_doc_kl" => $value[36],
                            "ref_num_kl" => $value[37],
                            "remarks_doc_kb" => $value[38],
                            "ref_num_kb" => $value[39],
                            "remarks_doc_baso_bast_mitra" => $value[40],
                            "aset_baso_bast_mitra" => $value[41],
                            "created_at" => date('Y-m-d H:i:s'),
                            "updated_at" => date('Y-m-d H:i:s'),
                            "month" => $formating_month,
                            "week_num" => $getWeekNum->weekNumberInMonth,
                        ];
                        $db_table = $schema . ".lessee";
                    } else {
                        $insert_data = (object) [
                            "population_contract_num" => $value[0],
                            "population_contract_num_manner" => $value[1],
                            "fcbp" => $value[2],
                            "treg" => $value[3],
                            "ubis_division" => $value[4],
                            "segmen" => $value[5],
                            "sap_business_area" => $value[6],
                            "population_source" => $value[7],
                            "contract_id_pending_data" => $value[8],
                            "po_num" => $value[9],
                            "wbs_element" => $value[10],
                            "doc_req_period" => $value[11],
                            "subcription_contract_num" => $value[12],
                            "kb_project_name" => $value[13],
                            "cust_name" => $value[14],
                            "service_contract_num_with_supplier" => $value[15],
                            "kl_project_name" => $value[16],
                            "mitra_name" => $value[17],
                            "kb_status" => $value[18],
                            "kb_bootcamp_status" => $value[19],
                            "kb_preceeding_status" => $value[20],
                            "kb_preceeding_bootcamp_status" => $value[21],
                            "ba_splitting_status" => $value[22],
                            "ba_splitting_bootcamp_status" => $value[23],
                            "p_one_status" => $value[24],
                            "p_one_bootcamp_status" => $value[25],
                            "kl_status" => $value[26],
                            "kl_bootcamp_status" => $value[27],
                            "kl_preceeding_status" => $value[28],
                            "kl_preceeding_bootcamp_status" => $value[29],
                            "ba_splitting_kl_status" => $value[30],
                            "ba_splitting_kl_bootcamp_status" => $value[31],
                            "baso_pelanggan_status" => $value[32],
                            "baso_pelanggan_bootcamp_status" => $value[33],
                            "bast_pelanggan_status" => $value[34],
                            "bast_pelanggan_bootcamp_status" => $value[35],
                            "final_status" => strtoupper($value[36]),
                            "remarks_status_bootcamp" => $value[37],
                            "remarks_doc_kb" => $value[38],
                            "ref_num_kb_preceeding" => $value[39],
                            "remarks_doc_kl" => $value[40],
                            "service_needed_kl" => $value[41],
                            "ref_num_kl_preceeding" => $value[42],
                            "remarks_doc_baso_bast_cust" => $value[43],
                            "asset_needed_baso_bast_cust" => $value[44],
                            "created_at" => date('Y-m-d H:i:s'),
                            "updated_at" => date('Y-m-d H:i:s'),
                            "month" => $formating_month,
                            "week_num" => $getWeekNum->weekNumberInMonth,
                        ];
                        $db_table = $schema . ".lessor";
                    }
                }
                // print('<pre>' . print_r($insert_data, true) . '</pre>');
                $this->uploader->insert_values($insert_data, $db_table);
            }
        } catch (Exception $e) {
            return $this->response(500, [
                "message" => "Sorry! somethine wen't wrong, please try again later"
            ]);
        }

        return $this->response(200, [
            // "formatted_fields" => $formatted_fields,
            // "validated_fields" => $validated_fields,
            // "inserted" => $inserted,
            // "date" => $date
        ]);
    }

    public function get_sub_category()
    {
        $request = (object) $this->input->post();

        $this->sub_categories = [
            'PSAK 72 MCT' => ['DETAIL KONFIRMASI', 'PENDING DATA'],
            'PSAK 72 Non MCT' => ['STEP 1-4', 'STEP 5', 'LIST KONFIRMASI', 'UNIDENTIFIED KB', 'CR VARIABLE', 'KONFIRMASI SPLIT BILL'],
            'PSAK 73' => ['LESSEE', 'LESSOR']
        ];

        return $this->response(200, [
            "result" => $this->sub_categories[$request->category],
        ]);
    }
}

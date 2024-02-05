<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Psak_model extends CI_Model
{
    private $postgres = NULL;

    public function __construct()
    {
        parent::__construct();
        $this->postgres = $this->load->database('postgres', TRUE);
    }

    public function getDataWeeks($table, $month)
    {
        $query = "select distinct week_num from $table where month='$month' order by week_num asc";

        return $this->postgres->query($query)->row();
    }

    public function get_max_week($table, $month)
    {
        $query = "select distinct week_num from $table where month='$month' order by week_num desc limit 1";

        return $this->postgres->query($query)->row();
    }

    public function get_datas($month, $category, $area, $week)
    {
        $get_data_by_category = [
            'PSAK 72 MCT' => [
                'REGIONAL' => (object) [
                    'data_pending' => $this->data_pending($month, $week),
                    'confirmation_detail' => $this->confirmation_detail($month, $week)
                ]
            ],
            'PSAK 72 NON MCT' => [
                'REGIONAL' => (object) [
                    'step_1_to_4' => $this->step_1_to_4($month, $week),
                    'step_5' => $this->step_5($month, $week),
                    'confirmation_list' => $this->confirmation_list($month, $week),
                    'unidentified_kb' => $this->unidentified_kb($month, $week),
                    'cr_variable' => $this->cr_variable($month, $week),
                    'confirm_split_bill' => $this->confirm_split_bill($month, $week),
                ],
                'WITEL' => (object) [
                    'step_1_to_4' => $this->step_1_to_4_witel($month, $week),
                    'step_5' => $this->step_5_witel($month, $week),
                    'confirmation_list' => $this->confirmation_list_witel($month, $week),
                    'unidentified_kb' => [],
                    'cr_variable' => [],
                    'confirm_split_bill' => [],
                ]
            ],
            'PSAK 73' => [
                'REGIONAL' => (object) [
                    'lessee' => $this->lessee($month, $week),
                    'lessor' => $this->lessor($month, $week)
                ]
            ]
        ];

        // print('<pre>' . print_r($area) . '</pre>');
        // print('<pre>' . print_r($get_data_by_category[$category][$area], true) . '</pre>');
        // exit;

        return $get_data_by_category[$category][$area];
    }


    // Start PSAK 72 NON MCT - WITEL
    private function step_1_to_4_witel($month, $week)
    {
        $query = "with total as (
            select witel as segmen, count(contract_num) as total_pending, sum(tibs_value) total_tibs_value from psak_72_non_mct.witel_datas_psak where month = '$month' and week_num='$week' and segmen = 'REG-5' and categories = '1. STEP1_4' group by witel
        ), closed as (
            select witel as segmen, count(contract_num) as total_closed, sum(tibs_value) closed_tibs_value from psak_72_non_mct.witel_datas_psak where month = '$month' and week_num='$week' and segmen = 'REG-5' and categories = '1. STEP1_4' and status = 'CLOSED' group by witel
        ), not_closed as (
            select witel as segmen, count(contract_num) as total_not_closed, sum(tibs_value) not_closed_tibs_value from psak_72_non_mct.witel_datas_psak where month = '$month' and week_num='$week' and segmen = 'REG-5' and categories = '1. STEP1_4' and status = 'NOT CLOSED' group by witel
        ), mapping_segment as (
            select distinct some_segment_name, segment_name from psak_72_non_mct.mapping_segment where areas = 'WITEL'
        )
        select ms.segment_name, 
            coalesce(sum(total_pending),0) as total_pending, coalesce(sum(total_tibs_value),0) as total_tibs_value,
            coalesce(sum(total_closed),0) as total_closed, coalesce(sum(closed_tibs_value),0) as closed_tibs_value,
            coalesce(sum(total_not_closed),0) as total_not_closed, coalesce(sum(not_closed_tibs_value),0) as not_closed_tibs_value,
            case when coalesce(sum(total_pending),0) = 0 or coalesce(sum(total_closed),0) = 0 
                then 0
                else round((coalesce(sum(total_closed),0)/coalesce(sum(total_pending),0))*100,2)
            end as persentase_contract,
            case when coalesce(sum(total_tibs_value),0) = 0 or coalesce(sum(closed_tibs_value),0) = 0 
                then 0
                else round((coalesce(sum(closed_tibs_value),0)/coalesce(sum(total_tibs_value),0))*100,2)
            end as persentase_rev
        from mapping_segment as ms
        full outer join total as total
        on ms.some_segment_name = total.segmen
        full outer join closed as closed
        on ms.some_segment_name = closed.segmen
        full outer join not_closed as nc
        on ms.some_segment_name = nc.segmen
        group by 1 order by 1";

        return $this->postgres->query($query)->result();
    }

    private function step_5_witel($month, $week)
    {
        $query = "with total as (
            select witel as segmen, count(contract_num) as total_pending, sum(tibs_value) total_tibs_value from psak_72_non_mct.witel_datas_psak where month = '$month' and week_num='$week' and segmen = 'REG-5' and categories = '2. STEP5' group by witel
        ), closed as (
            select witel as segmen, count(contract_num) as total_closed, sum(tibs_value) closed_tibs_value from psak_72_non_mct.witel_datas_psak where month = '$month' and week_num='$week' and segmen = 'REG-5' and categories = '2. STEP5' and status = 'CLOSED' group by witel
        ), not_closed as (
            select witel as segmen, count(contract_num) as total_not_closed, sum(tibs_value) not_closed_tibs_value from psak_72_non_mct.witel_datas_psak where month = '$month' and week_num='$week' and segmen = 'REG-5' and categories = '2. STEP5' and status = 'NOT CLOSED' group by witel
        ), mapping_segment as (
            select distinct some_segment_name, segment_name from psak_72_non_mct.mapping_segment where areas = 'WITEL'
        )
        select ms.segment_name, 
            coalesce(sum(total_pending),0) as total_pending, coalesce(sum(total_tibs_value),0) as total_tibs_value,
            coalesce(sum(total_closed),0) as total_closed, coalesce(sum(closed_tibs_value),0) as closed_tibs_value,
            coalesce(sum(total_not_closed),0) as total_not_closed, coalesce(sum(not_closed_tibs_value),0) as not_closed_tibs_value,
            case when coalesce(sum(total_pending),0) = 0 or coalesce(sum(total_closed),0) = 0 
                then 0
                else round((coalesce(sum(total_closed),0)/coalesce(sum(total_pending),0))*100,2)
            end as persentase_contract,
            case when coalesce(sum(total_tibs_value),0) = 0 or coalesce(sum(closed_tibs_value),0) = 0 
                then 0
                else round((coalesce(sum(closed_tibs_value),0)/coalesce(sum(total_tibs_value),0))*100,2)
            end as persentase_rev
        from mapping_segment as ms
        full outer join total as total
        on ms.some_segment_name = total.segmen
        full outer join closed as closed
        on ms.some_segment_name = closed.segmen
        full outer join not_closed as nc
        on ms.some_segment_name = nc.segmen
        group by 1 order by 1";

        return $this->postgres->query($query)->result();
    }

    private function confirmation_list_witel($month, $week)
    {
        $query = "with total as (
            select witel as segmen, count(contract_num) as total_pending, sum(tibs_value) total_tibs_value from psak_72_non_mct.witel_datas_psak where month = '$month' and week_num='$week' and segmen = 'REG-5' and categories = '3. LIST_KONFIRM' group by witel
        ), closed as (
            select witel as segmen, count(contract_num) as total_closed, sum(tibs_value) closed_tibs_value from psak_72_non_mct.witel_datas_psak where month = '$month' and week_num='$week' and segmen = 'REG-5' and categories = '3. LIST_KONFIRM' and status = 'CLOSED' group by witel
        ), not_closed as (
            select witel as segmen, count(contract_num) as total_not_closed, sum(tibs_value) not_closed_tibs_value from psak_72_non_mct.witel_datas_psak where month = '$month' and week_num='$week' and segmen = 'REG-5' and categories = '3. LIST_KONFIRM' and status = 'NOT CLOSED' group by witel
        ), mapping_segment as (
            select distinct some_segment_name, segment_name from psak_72_non_mct.mapping_segment where areas = 'WITEL'
        )
        select ms.segment_name, 
            coalesce(sum(total_pending),0) as total_pending, coalesce(sum(total_tibs_value),0) as total_tibs_value,
            coalesce(sum(total_closed),0) as total_closed, coalesce(sum(closed_tibs_value),0) as closed_tibs_value,
            coalesce(sum(total_not_closed),0) as total_not_closed, coalesce(sum(not_closed_tibs_value),0) as not_closed_tibs_value,
            case when coalesce(sum(total_pending),0) = 0 or coalesce(sum(total_closed),0) = 0 
                then 0
                else round((coalesce(sum(total_closed),0)/coalesce(sum(total_pending),0))*100,2)
            end as persentase_contract,
            case when coalesce(sum(total_tibs_value),0) = 0 or coalesce(sum(closed_tibs_value),0) = 0 
                then 0
                else round((coalesce(sum(closed_tibs_value),0)/coalesce(sum(total_tibs_value),0))*100,2)
            end as persentase_rev
        from mapping_segment as ms
        full outer join total as total
        on ms.some_segment_name = total.segmen
        full outer join closed as closed
        on ms.some_segment_name = closed.segmen
        full outer join not_closed as nc
        on ms.some_segment_name = nc.segmen
        where total.segmen is not null
        group by 1 order by 1";

        return $this->postgres->query($query)->result();
    }
    // End PSAK 72 NON MCT - WITEL

    // Start PSAK 72 MCT
    private function data_pending($month, $week)
    {
        $query = "with get_newest_date as (
            select distinct to_char(date_respon, 'yyyy-mm-dd') as newest_date from psak_72_mct.data_pending where month = '$month' and week_num='$week' order by newest_date desc limit 1
        ), total as (
            select segmen, count(*) as total_pending, sum(tibs_value::numeric) as total_tibs_value from psak_72_mct.data_pending where month = '$month' and week_num='$week' and to_char(date_respon, 'yyyy-mm-dd') = (select * from get_newest_date) group by segmen
        ), closed as (
            select segmen, count(*) as total_closed, sum(tibs_value::numeric) as closed_tibs_value from psak_72_mct.data_pending where month = '$month' and week_num='$week' and to_char(date_respon, 'yyyy-mm-dd') = (select * from get_newest_date) and status = 'CLOSED' group by segmen
        ), not_closed as (
            select segmen, count(*) as total_not_closed, sum(tibs_value::numeric) as not_closed_tibs_value from psak_72_mct.data_pending where month = '$month' and week_num='$week' and to_char(date_respon, 'yyyy-mm-dd') = (select * from get_newest_date) and status = 'NOT CLOSED' group by segmen
        ), under_review as (
            select segmen, count(*) as total_under_review, sum(tibs_value::numeric) as under_review_tibs_value from psak_72_mct.data_pending where month = '$month' and week_num='$week' and to_char(date_respon, 'yyyy-mm-dd') = (select * from get_newest_date) and status = 'UNDER REVIEW' group by segmen
        ), mapping_segment as (
            select some_segment_name, segment_name from psak_72_non_mct.mapping_segment where areas = 'REGIONAL'
        )
        select ms.segment_name, 
            coalesce(sum(total_closed),0) as total_closed, 
            case 
                when coalesce(sum(total_closed),0) = 0 or coalesce(sum(total_pending),0) = 0 
                then 0 
                else round((coalesce(sum(total_closed),0)/coalesce(sum(total_pending),0))*100,2)
            end as persentase_closed,
            coalesce(sum(total_under_review),0) as total_under_review,
            case 
                when coalesce(sum(total_under_review),0) = 0 or coalesce(sum(total_pending),0) = 0 
                then 0 
                else round((coalesce(sum(total_under_review),0)/coalesce(sum(total_pending),0))*100,2)
            end as persentase_under_review,
            coalesce(sum(total_not_closed),0) as total_not_closed, 
            case 
                when coalesce(sum(total_not_closed),0) = 0 or coalesce(sum(total_pending),0) = 0 
                then 0 
                else round((coalesce(sum(total_not_closed),0)/coalesce(sum(total_pending),0))*100,2)
            end as persentase_under_review,
            coalesce(sum(total_pending),0) as persentase_not_closed,
            coalesce(sum(total_closed),0) + coalesce(sum(total_under_review),0) + coalesce(sum(total_not_closed),0) as total,
            case 
                when coalesce(sum(total_closed),0) = 0 or coalesce(sum(total_pending),0) = 0 
                then 0 
                else round((coalesce(sum(total_closed),0)/coalesce(sum(total_pending),0))*100,2)
            end +
            case 
                when coalesce(sum(total_under_review),0) = 0 or coalesce(sum(total_pending),0) = 0 
                then 0 
                else round((coalesce(sum(total_under_review),0)/coalesce(sum(total_pending),0))*100,2)
            end +
            case 
                when coalesce(sum(total_not_closed),0) = 0 or coalesce(sum(total_pending),0) = 0 
                then 0 
                else round((coalesce(sum(total_not_closed),0)/coalesce(sum(total_pending),0))*100,2)
            end as persentase_total
        from mapping_segment as ms
        full outer join total as total
        on ms.some_segment_name = total.segmen
        full outer join closed as closed
        on ms.some_segment_name = closed.segmen
        full outer join not_closed as nc
        on ms.some_segment_name = nc.segmen
        full outer join under_review as ur
        on ms.some_segment_name = ur.segmen
        where ms.segment_name is not null
        group by 1 order by 1";

        return $this->postgres->query($query)->result();
    }

    private function confirmation_detail($month, $week)
    {
        $query = "with get_newest_date as (
            select distinct to_char(date_respon, 'yyyy-mm-dd') as newest_date from psak_72_mct.confirmation_detail where month = '$month' and week_num='$week' order by newest_date desc limit 1
        ), total as (
            select segmen, count(*) as total_pending, sum(tibs_value::numeric) as total_tibs_value from psak_72_mct.confirmation_detail where month = '$month' and week_num='$week' and to_char(date_respon, 'yyyy-mm-dd') = (select * from get_newest_date) group by segmen
        ), closed as (
            select segmen, count(*) as total_closed, sum(tibs_value::numeric) as closed_tibs_value from psak_72_mct.confirmation_detail where month = '$month' and week_num='$week' and to_char(date_respon, 'yyyy-mm-dd') = (select * from get_newest_date) and status = 'CLOSED' group by segmen
        ), not_closed as (
            select segmen, count(*) as total_not_closed, sum(tibs_value::numeric) as not_closed_tibs_value from psak_72_mct.confirmation_detail where month = '$month' and week_num='$week' and to_char(date_respon, 'yyyy-mm-dd') = (select * from get_newest_date) and status = 'NOT CLOSED' group by segmen
        ), under_review as (
            select segmen, count(*) as total_under_review, sum(tibs_value::numeric) as under_review_tibs_value from psak_72_mct.confirmation_detail where month = '$month' and week_num='$week' and to_char(date_respon, 'yyyy-mm-dd') = (select * from get_newest_date) and status = 'UNDER REVIEW' group by segmen
        ), mapping_segment as (
            select some_segment_name, segment_name from psak_72_non_mct.mapping_segment where areas = 'REGIONAL'
        )
        select ms.segment_name, 
            coalesce(sum(total_closed),0) as total_closed, 
            case 
                when coalesce(sum(total_closed),0) = 0 or coalesce(sum(total_pending),0) = 0 
                then 0 
                else round((coalesce(sum(total_closed),0)/coalesce(sum(total_pending),0))*100,2)
            end as persentase_closed,
            coalesce(sum(total_under_review),0) as total_under_review,
            case 
                when coalesce(sum(total_under_review),0) = 0 or coalesce(sum(total_pending),0) = 0 
                then 0 
                else round((coalesce(sum(total_under_review),0)/coalesce(sum(total_pending),0))*100,2)
            end as persentase_under_review,
            coalesce(sum(total_not_closed),0) as total_not_closed, 
            case 
                when coalesce(sum(total_not_closed),0) = 0 or coalesce(sum(total_pending),0) = 0 
                then 0 
                else round((coalesce(sum(total_not_closed),0)/coalesce(sum(total_pending),0))*100,2)
            end as persentase_under_review,
            coalesce(sum(total_pending),0) as persentase_not_closed,
            coalesce(sum(total_closed),0) + coalesce(sum(total_under_review),0) + coalesce(sum(total_not_closed),0) as total,
            case 
                when coalesce(sum(total_closed),0) = 0 or coalesce(sum(total_pending),0) = 0 
                then 0 
                else round((coalesce(sum(total_closed),0)/coalesce(sum(total_pending),0))*100,2)
            end +
            case 
                when coalesce(sum(total_under_review),0) = 0 or coalesce(sum(total_pending),0) = 0 
                then 0 
                else round((coalesce(sum(total_under_review),0)/coalesce(sum(total_pending),0))*100,2)
            end +
            case 
                when coalesce(sum(total_not_closed),0) = 0 or coalesce(sum(total_pending),0) = 0 
                then 0 
                else round((coalesce(sum(total_not_closed),0)/coalesce(sum(total_pending),0))*100,2)
            end as persentase_total
        from mapping_segment as ms
        full outer join total as total
        on ms.some_segment_name = total.segmen
        full outer join closed as closed
        on ms.some_segment_name = closed.segmen
        full outer join not_closed as nc
        on ms.some_segment_name = nc.segmen
        full outer join under_review as ur
        on ms.some_segment_name = ur.segmen
        where ms.segment_name is not null
        group by 1 order by 1";

        return $this->postgres->query($query)->result();
    }
    // End PSAK 72 MCT

    // Start PSAK 72 NON MCT
    private function step_1_to_4($month, $week)
    {
        $query = "with total as (
            select segmen, count(*) as total_pending, sum(tibs_value::numeric) as total_tibs_value from psak_72_non_mct.step_one_to_four where month = '$month' and week_num='$week' and divisi = 'Regional' group by segmen
        ), closed as (
            select segmen, count(*) as total_closed, sum(tibs_value::numeric) as closed_tibs_value from psak_72_non_mct.step_one_to_four where month = '$month' and week_num='$week' and divisi = 'Regional' and accept_status_step_one_to_four_exc_confirm = '5. Closed' group by segmen
        ), closed_with_notes as (
            select segmen, count(*) as total_closed_with_notes, sum(tibs_value::numeric) as closed_with_notes_tibs_value from psak_72_non_mct.step_one_to_four where month = '$month' and week_num='$week' and divisi = 'Regional' and accept_status_step_one_to_four_exc_confirm = '6. Closed with Exception' group by segmen
        ), not_closed as (
            select segmen, count(*) as total_not_closed, sum(tibs_value::numeric) as not_closed_tibs_value from psak_72_non_mct.step_one_to_four where month = '$month' and week_num='$week' and divisi = 'Regional' and accept_status_step_one_to_four_exc_confirm in ('1. Belum dilakukan pembahasan','7. Not Closed','8. Pending WO') group by segmen
        ), on_check as (
            select segmen, count(*) as total_on_check, sum(tibs_value::numeric) as on_check_tibs_value from psak_72_non_mct.step_one_to_four where month = '$month' and week_num='$week' and divisi = 'Regional' and accept_status_step_one_to_four_exc_confirm like '%On Check%' group by segmen
        ), mapping_segment as (
            select some_segment_name, segment_name from psak_72_non_mct.mapping_segment where areas = 'REGIONAL'
        )
        select ms.segment_name, 
            coalesce(sum(total_pending),0) as total_pending, coalesce(sum(total_tibs_value),0) as total_tibs_value,
            coalesce(sum(total_closed),0) as total_closed, coalesce(sum(closed_tibs_value),0) as closed_tibs_value,
            coalesce(sum(total_not_closed),0) as total_not_closed, coalesce(sum(not_closed_tibs_value),0) as not_closed_tibs_value,
            coalesce(sum(total_on_check),0) as total_on_check, coalesce(sum(on_check_tibs_value),0) as on_check_tibs_value,
            -- round((coalesce(sum(total_closed),0)/coalesce(sum(total_pending),0))*100,2) as persetase_closed
            case 
                when coalesce(sum(total_closed),0) = 0 and coalesce(sum(total_pending),0) = 0 
                then 0 
                else round((coalesce(sum(total_closed),0)/coalesce(sum(total_pending),0))*100,2)
            end as persetase_closed
        from mapping_segment as ms
        full outer join total as total
        on ms.some_segment_name = total.segmen
        full outer join closed as closed
        on ms.some_segment_name = closed.segmen
        full outer join not_closed as nc
        on ms.some_segment_name = nc.segmen
        full outer join on_check as oc
        on ms.some_segment_name = oc.segmen
        where ms.segment_name is not null
        group by 1 order by 1";

        return $this->postgres->query($query)->result();
    }

    private function step_5($month, $week)
    {
        $query = "with total as (
            select segmen, count(*) as total_pending, sum(tibs_value::numeric) as total_tibs_value from psak_72_non_mct.step_five where month = '$month' and week_num='$week' and divisi = 'Regional' group by segmen
        ), closed as (
            select segmen, count(*) as total_closed, sum(tibs_value::numeric) as closed_tibs_value from psak_72_non_mct.step_five where month = '$month' and week_num='$week' and divisi = 'Regional' and accept_status_step_five_after_cleansing = '5. Closed' group by segmen
        ), closed_with_notes as (
            select segmen, count(*) as total_closed_with_notes, sum(tibs_value::numeric) as closed_with_notes_tibs_value from psak_72_non_mct.step_five where month = '$month' and week_num='$week' and divisi = 'Regional' and accept_status_step_five_after_cleansing = '6. Closed with Exception' group by segmen
        ), not_closed as (
            select segmen, count(*) as total_not_closed, sum(tibs_value::numeric) as not_closed_tibs_value from psak_72_non_mct.step_five where month = '$month' and week_num='$week' and divisi = 'Regional' and accept_status_step_five_after_cleansing in ('1. Belum dilakukan pembahasan','7. Not Closed','8. Pending WO') group by segmen
        ), on_check as (
            select segmen, count(*) as total_on_check, sum(tibs_value::numeric) as on_check_tibs_value from psak_72_non_mct.step_five where month = '$month' and week_num='$week' and divisi = 'Regional' and accept_status_step_five_after_cleansing like '%On Check%' group by segmen
        ), mapping_segment as (
            select some_segment_name, segment_name from psak_72_non_mct.mapping_segment where areas = 'REGIONAL'
        )
        select ms.segment_name, 
            coalesce(sum(total_pending),0) as total_pending, coalesce(sum(total_tibs_value),0) as total_tibs_value,
            coalesce(sum(total_closed),0) as total_closed, coalesce(sum(closed_tibs_value),0) as closed_tibs_value,
            coalesce(sum(total_not_closed),0) as total_not_closed, coalesce(sum(not_closed_tibs_value),0) as not_closed_tibs_value,
            coalesce(sum(total_on_check),0) as total_on_check, coalesce(sum(on_check_tibs_value),0) as on_check_tibs_value,
            -- round((coalesce(sum(total_closed),0)/coalesce(sum(total_pending),0))*100,2) as persetase_closed
            case 
                when coalesce(sum(total_closed),0) = 0 and coalesce(sum(total_pending),0) = 0 
                then 0 
                else round((coalesce(sum(total_closed),0)/coalesce(sum(total_pending),0))*100,2)
            end as persetase_closed
        from mapping_segment as ms
        full outer join total as total
        on ms.some_segment_name = total.segmen
        full outer join closed as closed
        on ms.some_segment_name = closed.segmen
        full outer join not_closed as nc
        on ms.some_segment_name = nc.segmen
        full outer join on_check as oc
        on ms.some_segment_name = oc.segmen
        where ms.segment_name is not null
        group by 1 order by 1";

        return $this->postgres->query($query)->result();
    }

    private function confirmation_list($month, $week)
    {
        $query = "with total as (
            select segmen, count(*) as total_pending, sum(tibs_value::numeric) as total_tibs_value from psak_72_non_mct.confirmation_list where month = '$month' and week_num='$week' and divisi = 'Regional' group by segmen
        ), closed as (
            select segmen, count(*) as total_closed, sum(tibs_value::numeric) as closed_tibs_value from psak_72_non_mct.confirmation_list where month = '$month' and week_num='$week' and divisi = 'Regional' and final_status_substantive_contract_confirm like 'CLOSED%' and final_status_doc_contract like 'CLOSED%' and final_status_doc_partner like 'CLOSED%' group by segmen
        ), not_closed as (
            select segmen, count(*) as total_not_closed, sum(tibs_value::numeric) as not_closed_tibs_value from psak_72_non_mct.confirmation_list where month = '$month' and week_num='$week' and divisi = 'Regional' and final_status_substantive_contract_confirm not like 'CLOSED%' and final_status_doc_contract not like 'CLOSED%' and final_status_doc_partner not like 'CLOSED%' group by segmen
        ), on_check as (
            select segmen, count(*) as total_on_check, sum(tibs_value::numeric) as on_check_tibs_value from psak_72_non_mct.confirmation_list where month = '$month' and week_num='$week' and divisi = 'Regional' and final_status_substantive_contract_confirm not like 'ON CHECK%' and final_status_doc_contract not like 'ON CHECK%' and final_status_doc_partner not like 'ON CHECK%' group by segmen
        ), mapping_segment as (
            select some_segment_name, segment_name from psak_72_non_mct.mapping_segment where areas = 'REGIONAL'
        )
        select ms.segment_name, 
            coalesce(sum(total_pending),0) as total_pending, coalesce(sum(total_tibs_value),0) as total_tibs_value,
            coalesce(sum(total_closed),0) as total_closed, coalesce(sum(closed_tibs_value),0) as closed_tibs_value,
            coalesce(sum(total_not_closed),0) as total_not_closed, coalesce(sum(not_closed_tibs_value),0) as not_closed_tibs_value,
            coalesce(sum(total_on_check),0) as total_on_check, coalesce(sum(on_check_tibs_value),0) as on_check_tibs_value,
            -- round((coalesce(sum(total_closed),0)/coalesce(sum(total_pending),0))*100,2) as persetase_closed
            case 
                when coalesce(sum(total_closed),0) = 0 and coalesce(sum(total_pending),0) = 0 
                then 0 
                else round((coalesce(sum(total_closed),0)/coalesce(sum(total_pending),0))*100,2)
            end as persetase_closed
        from mapping_segment as ms
        full outer join total as total
        on ms.some_segment_name = total.segmen
        full outer join closed as closed
        on ms.some_segment_name = closed.segmen
        full outer join not_closed as nc
        on ms.some_segment_name = nc.segmen
        full outer join on_check as oc
        on ms.some_segment_name = oc.segmen
        where ms.segment_name is not null
        group by 1 order by 1";

        return $this->postgres->query($query)->result();
    }

    private function unidentified_kb($month, $week)
    {
        $query = "with total as (
            select segment as segmen, count(*) as total_pending, sum(tibs_value::numeric) as total_tibs_value from psak_72_non_mct.unidentified_kb where month = '$month' and week_num='$week' and division = 'Regional' group by segmen
        ), closed as (
            select segment as segmen, count(*) as total_closed, sum(tibs_value::numeric) as closed_tibs_value from psak_72_non_mct.unidentified_kb where month = '$month' and week_num='$week' and division = 'Regional' and status_doc_reception_result = '5. Closed' group by segmen
        ), not_closed as (
            select segment as segmen, count(*) as total_not_closed, sum(tibs_value::numeric) as not_closed_tibs_value from psak_72_non_mct.unidentified_kb where month = '$month' and week_num='$week' and division = 'Regional' and status_doc_reception_result != '5. Closed' group by segmen
        ), mapping_segment as (
            select some_segment_name, segment_name from psak_72_non_mct.mapping_segment where areas = 'REGIONAL'
        )
        select ms.segment_name, 
            coalesce(sum(total_pending),0) as total_pending, coalesce(sum(total_tibs_value),0) as total_tibs_value,
            coalesce(sum(total_closed),0) as total_closed, coalesce(sum(closed_tibs_value),0) as closed_tibs_value,
            coalesce(sum(total_not_closed),0) as total_not_closed, coalesce(sum(not_closed_tibs_value),0) as not_closed_tibs_value,
            case 
                when coalesce(sum(total_closed),0) = 0 or coalesce(sum(total_pending),0) = 0 
                then 0 
                else round((coalesce(sum(total_closed),0)/coalesce(sum(total_pending),0))*100,2) 
            end as persetase_closed
        from mapping_segment as ms
        full outer join total as total
        on ms.some_segment_name = total.segmen
        full outer join closed as closed
        on ms.some_segment_name = closed.segmen
        full outer join not_closed as nc
        on ms.some_segment_name = nc.segmen
        where ms.segment_name is not null
        group by 1 order by 1";

        return $this->postgres->query($query)->result();
    }

    private function cr_variable($month, $week)
    {
        $query = "with total as (
            select segment as segmen, count(*) as total_pending, sum(tibs_value::numeric) as total_tibs_value from psak_72_non_mct.cr_variable where month = '$month' and week_num='$week' and division = 'Regional' group by segmen
        ), closed as (
            select segment as segmen, count(*) as total_closed, sum(tibs_value::numeric) as closed_tibs_value from psak_72_non_mct.cr_variable where month = '$month' and week_num='$week' and division = 'Regional' and status_doc_reception_result = '5. Closed' group by segmen
        ), not_closed as (
            select segment as segmen, count(*) as total_not_closed, sum(tibs_value::numeric) as not_closed_tibs_value from psak_72_non_mct.cr_variable where month = '$month' and week_num='$week' and division = 'Regional' and status_doc_reception_result != '5. Closed' group by segmen
        ), mapping_segment as (
            select some_segment_name, segment_name from psak_72_non_mct.mapping_segment where areas = 'REGIONAL'
        )
        select ms.segment_name, 
            coalesce(sum(total_pending),0) as total_pending, coalesce(sum(total_tibs_value),0) as total_tibs_value,
            coalesce(sum(total_closed),0) as total_closed, coalesce(sum(closed_tibs_value),0) as closed_tibs_value,
            coalesce(sum(total_not_closed),0) as total_not_closed, coalesce(sum(not_closed_tibs_value),0) as not_closed_tibs_value,
            case 
                when coalesce(sum(total_closed),0) = 0 or coalesce(sum(total_pending),0) = 0 
                then 0 
                else round((coalesce(sum(total_closed),0)/coalesce(sum(total_pending),0))*100,2) 
            end as persetase_closed
        from mapping_segment as ms
        full outer join total as total
        on ms.some_segment_name = total.segmen
        full outer join closed as closed
        on ms.some_segment_name = closed.segmen
        full outer join not_closed as nc
        on ms.some_segment_name = nc.segmen
        where ms.segment_name is not null
        group by 1 order by 1";

        return $this->postgres->query($query)->result();
    }

    private function confirm_split_bill($month, $week)
    {
        $query = "with total as (
            select segment as segmen, count(*) as total_pending, sum(tibs_value::numeric) as total_tibs_value from psak_72_non_mct.confirm_split_bill where month = '$month' and week_num='$week' and division = 'Regional' group by segmen
        ), closed as (
            select segment as segmen, count(*) as total_closed, sum(tibs_value::numeric) as closed_tibs_value from psak_72_non_mct.confirm_split_bill where month = '$month' and week_num='$week' and division = 'Regional' and (final_status like 'Closed%' or final_status like 'CLOSED%') group by segmen
        ), not_closed as (
            select segment as segmen, count(*) as total_not_closed, sum(tibs_value::numeric) as not_closed_tibs_value from psak_72_non_mct.confirm_split_bill where month = '$month' and week_num='$week' and division = 'Regional' and (final_status not like 'Closed%' or final_status not like 'CLOSED%') group by segmen
        ), mapping_segment as (
            select some_segment_name, segment_name from psak_72_non_mct.mapping_segment where areas = 'REGIONAL'
        )
        select ms.segment_name, 
            coalesce(sum(total_pending),0) as total_pending, coalesce(sum(total_tibs_value),0) as total_tibs_value,
            coalesce(sum(total_closed),0) as total_closed, coalesce(sum(closed_tibs_value),0) as closed_tibs_value,
            coalesce(sum(total_not_closed),0) as total_not_closed, coalesce(sum(not_closed_tibs_value),0) as not_closed_tibs_value,
            case 
                when coalesce(sum(total_closed),0) = 0 or coalesce(sum(total_pending),0) = 0 
                then 0 
                else round((coalesce(sum(total_closed),0)/coalesce(sum(total_pending),0))*100,2) 
            end as persetase_closed
        from mapping_segment as ms
        full outer join total as total
        on ms.some_segment_name = total.segmen
        full outer join closed as closed
        on ms.some_segment_name = closed.segmen
        full outer join not_closed as nc
        on ms.some_segment_name = nc.segmen
        where ms.segment_name is not null
        group by 1 order by 1";

        return $this->postgres->query($query)->result();
    }
    // End PSAK 72 NON MCT


    // Start PSAK 73
    private function lessor($month, $week)
    {
        $query = "with total as (
            select treg as segmen, count(*) as total_request from psak_73.lessor where month = '$month' and week_num='$week' group by treg
        ), closed as (
            select treg as segmen, count(*) as total_closed from psak_73.lessor where month = '$month' and week_num='$week' and (final_status = 'CLOSED' or final_status = 'Closed' or final_status = 'closed') group by treg
        ), not_closed as (
            select treg as segmen, count(*) as total_not_closed from psak_73.lessor where month = '$month' and week_num='$week' and (final_status = 'NOT CLOSED' or final_status = 'Not Closed' or final_status = 'not closed') group by treg
        ), sirkulir as (
            select treg as segmen, count(*) as total_sirkulir from psak_73.lessor where month = '$month' and week_num='$week' and (final_status = 'SIRKULIR' or final_status = 'Sirkulir' or final_status = 'sirkulir') group by treg
        ), mapping_segment as (
            select some_segment_name, segment_name from psak_72_non_mct.mapping_segment where areas = 'REGIONAL'
        )
        select ms.segment_name, 
            coalesce(sum(total_request),0) as total_pending, 
            coalesce(sum(total_closed),0) as total_closed, 
            coalesce(sum(total_not_closed),0) as total_not_closed, 
            coalesce(sum(total_sirkulir),0) as total_sirkulir, 
            case 
                when coalesce(sum(total_closed),0) = 0 or coalesce(sum(total_request),0) = 0 
                then 0 
                else round((coalesce(sum(total_closed),0)/coalesce(sum(total_request),0))*100,2) 
            end as persentase_closed
        from mapping_segment as ms
        full outer join total as total
        on ms.some_segment_name = total.segmen
        full outer join closed as closed
        on ms.some_segment_name = closed.segmen
        full outer join not_closed as nc
        on ms.some_segment_name = nc.segmen
        full outer join sirkulir as s
        on ms.some_segment_name = s.segmen
        where ms.segment_name is not null
        group by 1 order by 1";

        return $this->postgres->query($query)->result();
    }

    private function lessee($month, $week)
    {
        $query = "with total as (
            select treg as segmen, count(*) as total_request from psak_73.lessee where month = '$month' and week_num='$week' group by treg
        ), closed as (
            select treg as segmen, count(*) as total_closed from psak_73.lessee where month = '$month' and week_num='$week' and (final_status = 'CLOSED' or final_status = 'Closed' or final_status = 'closed') group by treg
        ), not_closed as (
            select treg as segmen, count(*) as total_not_closed from psak_73.lessee where month = '$month' and week_num='$week' and (final_status = 'NOT CLOSED' or final_status = 'Not Closed' or final_status = 'not closed') group by treg
        ), sirkulir as (
            select treg as segmen, count(*) as total_sirkulir from psak_73.lessee where month = '$month' and week_num='$week' and (final_status = 'SIRKULIR' or final_status = 'Sirkulir' or final_status = 'sirkulir') group by treg
        ), mapping_segment as (
            select some_segment_name, segment_name from psak_72_non_mct.mapping_segment where areas = 'REGIONAL'
        )
        select ms.segment_name, 
            coalesce(sum(total_request),0) as total_pending, 
            coalesce(sum(total_closed),0) as total_closed, 
            coalesce(sum(total_not_closed),0) as total_not_closed, 
            coalesce(sum(total_sirkulir),0) as total_sirkulir, 
            case 
                when coalesce(sum(total_closed),0) = 0 or coalesce(sum(total_request),0) = 0 
                then 0 
                else round((coalesce(sum(total_closed),0)/coalesce(sum(total_request),0))*100,2) 
            end as persentase_closed
        from mapping_segment as ms
        full outer join total as total
        on ms.some_segment_name = total.segmen
        full outer join closed as closed
        on ms.some_segment_name = closed.segmen
        full outer join not_closed as nc
        on ms.some_segment_name = nc.segmen
        full outer join sirkulir as s
        on ms.some_segment_name = s.segmen
        where ms.segment_name is not null
        group by 1 order by 1";

        return $this->postgres->query($query)->result();
    }
    // End PSAK 73
}
/* End of file filename.php */

<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tracking_model extends CI_Model
{
    private $postgres = NULL;
    private $schema = NULL;

    public function __construct()
    {
        parent::__construct();
        $this->postgres = $this->load->database('postgres', TRUE);
        $this->schema = "legal_track_doc";
    }

    public function get_datas()
    {
        $query = "select id, contract_name, contract_num, to_char(contract_date, 'dd-MM-YYYY') as contract_date, contract_amount, created_at, updated_at
        from " . $this->schema . ".contract_documents where active = 1
        order by updated_at desc";

        return $this->postgres->query($query)->result();
    }

    public function insert_doc_name($datas)
    {
        $checkDocName = $this->check_doc_name($datas);
        if (empty($checkDocName)) {
            $this->postgres->insert($this->schema . '.contract_documents', $datas);

            return true;
        } else {
            return false;
        }
    }

    private function check_doc_name($datas)
    {
        $query = "select * from " . $this->schema . ".contract_documents where contract_name = '" . $datas['contract_name'] . "' and contract_num = '" . $datas['contract_num'] . "' and active = 1";

        return $this->postgres->query($query)->row();
    }

    public function insert_detail_review_doc($datas, $db_table)
    {
        $this->postgres->insert($this->schema . '.' . $db_table, $datas);

        return true;
    }

    public function get_doc_name()
    {
        $query = "select id, concat(contract_name, ' || ', contract_num) as option_name
        from " . $this->schema . ".contract_documents where active = 1
        order by updated_at desc
        limit 50";

        return $this->postgres->query($query)->result();
    }

    public function get_detail_review($idDocName)
    {
        $query_review = "with detail_review as (
            select * from
            (
                select id, date, explanation, name_of_takes, contract_doc_id, 'Tanggal Masuk' as status, created_at, updated_at from " . $this->schema . ".entry_review_details where contract_doc_id = $idDocName
                union all
                select id, date, explanation, name_of_takes, contract_doc_id, 'Tanggal Kembali' as status, created_at, updated_at from " . $this->schema . ".back_review_details where contract_doc_id = $idDocName
                union all
                select id, date, explanation, name_of_takes, contract_doc_id, 'Tanggal Keluar' as status, created_at, updated_at from " . $this->schema . ".exit_review_details where contract_doc_id = $idDocName
            )x
        )
        select dr.id as dr_id, concat(to_char(dr.date, 'dd Mon yyyy'), ' ', to_char(dr.created_at, 'HH24:MI')) as review_date, dr.created_at as create_review_date, explanation, name_of_takes, cd.id as document_id, concat(contract_name, ' || ', contract_num) as document_name, status
        from " . $this->schema . ".contract_documents as cd
        join detail_review as dr
        on cd.id = dr.contract_doc_id
        where cd.id = $idDocName and cd.active = 1
        order by dr.date desc";

        $query_document = "select id, concat(contract_name, ' || ', contract_num) as contract_name
        from " . $this->schema . ".contract_documents where id = $idDocName";

        return (object) [
            'document' => $this->postgres->query($query_document)->row(),
            'review' => $this->postgres->query($query_review)->result(),
        ];
    }

    public function delete_doc_name($idDocName)
    {
        $updated_data = [
            'active' => 0,
        ];

        $this->postgres->update($this->schema . '.contract_documents', $updated_data, [
            'id' => $idDocName,
        ]);

        return true;
    }

    public function delete_detail_review_doc_name($idDocName, $db_table)
    {
        $this->postgres->delete($this->schema . $db_table, [
            'id' => $idDocName,
        ]);

        // $this->postgres->update($this->schema . '.contract_documents', $updated_data, [
        //     'id' => $idDocName,
        // ]);

        return true;
    }
}
/* End of file filename.php */

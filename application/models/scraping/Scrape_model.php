<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Scrape_model extends CI_Model
{
    private $postgres = NULL;

    public function __construct()
    {
        parent::__construct();
        $this->postgres = $this->load->database('postgres', TRUE);
        $this->table = "logistic.khs_datas";
    }

    public function insert_values($datas, $crawling_month)
    {
        $response_check = $this->check_certificate($datas['certificate_number'], $crawling_month);

        if (empty($response_check)) {
            $this->postgres->insert("logistic.khs_datas", $datas);
        } else {
            $this->postgres->update($this->table, $datas, [
                'certificate_number' => $datas['certificate_number'],
                'crawling_month' => $crawling_month,
            ]);
        }
    }

    private function check_certificate($certificate_num, $crawling_month)
    {
        $query = "select * from " . $this->table . " where certificate_number='$certificate_num' and crawling_month='$crawling_month'";

        return $this->postgres->query($query)->row();
    }
}
/* End of file filename.php */

<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Khs_model extends CI_Model
{
    private $postgres = NULL;

    public function __construct()
    {
        parent::__construct();
        $this->postgres = $this->load->database('postgres', TRUE);
    }

    public function get_datas($month)
    {
        $query = "select * from logistic.khs_datas where crawling_month = '$month' order by valid_until desc, company_name asc";

        return $this->postgres->query($query)->result();
    }

    public function get_count_datas($month)
    {
        $query = "select count(*) amount from logistic.khs_datas where crawling_month = '$month'";

        return $this->postgres->query($query)->row();
    }
}
/* End of file filename.php */

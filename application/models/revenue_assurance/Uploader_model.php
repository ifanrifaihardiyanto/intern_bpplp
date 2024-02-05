<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Uploader_model extends CI_Model
{
    private $postgres = NULL;
    private $categories = [];

    public function __construct()
    {
        parent::__construct();
        $this->postgres = $this->load->database('postgres', TRUE);
    }

    public function insert_values($datas, $db_table)
    {
        $check_data = $this->check_Datas($db_table, $datas->month, $datas->week_num);
        if (empty($check_data)) {
            $this->postgres->insert($db_table, $datas);
        } else {
            $this->postgres->update($db_table, $datas, [
                'month' => $datas->month,
                'week_num' => $datas->week_num,
            ]);
        }
    }

    private function check_Datas($db_table, $month, $week_num)
    {
        $query = "select * from $db_table where month = '$month' and week_num = '$week_num'";

        return $this->postgres->query($query)->row();
    }
}
/* End of file filename.php */

<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Report_pr_model extends CI_Model
{
    private $postgres = NULL;

    public function __construct()
    {
        parent::__construct();
        $this->postgres = $this->load->database('postgres', TRUE);
    }

    public function get_datas($datePosition, $wbsSelection, $prdateSelection)
    {
        $query = "select sort, mapp.witel, 
        	count(pr_number) as lop_pr, sum(doc_total_amount_pr) as nilai_pr,
        	count(po_number) as lop_po, sum(doc_total_amount_po) as nilai_po,
        	count(no_gr) as lop_gr, sum(local_amount_gr) as nilai_gr,
        	count(no_ir) as lop_ir, sum(local_amount_ir) as nilai_ir,
        	round((count(po_number)::numeric/count(pr_number)::numeric)*100,2) as persentase_pr_po,
        	round((count(no_gr)::numeric/count(po_number)::numeric)*100,2) as persentase_gr_po,
        	round((count(no_ir)::numeric/count(no_gr)::numeric)*100,2) as persentase_gr_ir,
        	(count(po_number)-count(no_gr)) as sisa_lop,
        	(sum(doc_total_amount_po)-sum(local_amount_gr)) belum_po
        from logistic.pr_po_gr_datas as datas
        join logistic.mapping_witel as mapp
        on datas.plant = mapp.plant
        where to_char(download_date,'yyyy-mm-dd') = '$datePosition' and wbs_element like '$wbsSelection' and pr_date like '$prdateSelection'
        group by witel, sort
        order by sort";

        return $this->postgres->query($query)->result();
    }

    public function get_date()
    {
        $query = "select distinct to_char(download_date, 'yyyy-mm-dd') as tanggal_posisi
        from logistic.pr_po_gr_datas";

        return $this->postgres->query($query)->row();
    }

    public function get_max_date()
    {
        $query = "select to_char(max(download_date), 'yyyy-mm-dd') as max_date
        from logistic.pr_po_gr_datas";

        return $this->postgres->query($query)->row();
    }

    public function get_wbs_element($datePosition)
    {
        $query = "select distinct wbs_element
        from logistic.pr_po_gr_datas
        where to_char(download_date,'yyyy-mm-dd') = '$datePosition'
        order by wbs_element asc";

        return $this->postgres->query($query)->result();
    }

    public function get_pr_date($datePosition)
    {
        $query = "select distinct pr_date
        from logistic.pr_po_gr_datas
        where to_char(download_date,'yyyy-mm-dd') = '$datePosition'
        order by pr_date asc";

        return $this->postgres->query($query)->result();
    }
}
/* End of file filename.php */

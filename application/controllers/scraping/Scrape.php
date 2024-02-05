<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Scrape extends BaseController
{
    private $main_url = 'https://telkomtesthouse.co.id/Devclient';
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('scraping/Scrape_model', 'scraping');
    }

    public function index()
    {
        $request = (object) $this->input->post();
        $formating_month = date('Ym', strtotime($request->month . '-01'));

        $respon_get_page = $this->get_max_page();

        if (!empty($respon_get_page)) {
            for ($i = 1; $i <= $respon_get_page; $i++) {
                $data = $this->scrapeData($this->main_url . "?search=&page=$i");
                $response = $this->parsing_data($data, $formating_month);
            }
        }

        return $this->response(200, [
            "messages" => "Successfully get data!",
        ]);
    }

    public function get_max_page()
    {
        $data = $this->scrapeData($this->main_url);
        $resp_parse = explode('<table class="table table-striped table-bordered table-hover table-full-width dataTable no-footer" id="sample-table-1" style="font-size: smaller;">', $data);
        $get_resp_parse = explode("</table>", $resp_parse[1]);

        $get_page = explode("</table>", $get_resp_parse[1]);
        $parse_page = explode("<ul", $get_page[0]);
        $parse_page = explode("</ul>", $parse_page[1]);
        $parse_page = explode('</a>', $parse_page[0]);
        $parse_page = $parse_page[8];
        $parse_page = explode('">', $parse_page);
        $max_page = $parse_page[1];

        return $max_page;
    }

    public function parsing_data($data, $month)
    {
        $resp_parse = explode('<table class="table table-striped table-bordered table-hover table-full-width dataTable no-footer" id="sample-table-1" style="font-size: smaller;">', $data);
        $get_resp_parse = explode("</table>", $resp_parse[1]);

        $get_page = explode("</table>", $get_resp_parse[0]);
        $parse_page = explode("</tr>", $get_page[0]);

        for ($a = 1; $a < count($parse_page) - 1; $a++) {
            $data = explode("</td>", $parse_page[$a]);

            $certificate_number = explode('<td class="">', $data[0]);
            $certificate_number = $this->cleaning($certificate_number[1]);
            $company_name = $this->cleaning($data[1]);
            $device_name = $this->cleaning($data[2]);
            $brand_name = $this->cleaning($data[3]);
            $made_in = $this->cleaning($data[4]);
            $type = $this->cleaning($data[5]);
            $details = $this->cleaning($data[6]);
            $test_reference = $this->cleaning($data[7]);
            $tkdn_certif_num = $this->cleaning($data[8]);
            $tkdn_value = $this->cleaning($data[9]);
            $valid_until = $this->cleaning($data[10]);

            $data = [
                'certificate_number' => $certificate_number,
                'company_name' => $company_name,
                'device_name' => $device_name,
                'brand_name' => $brand_name,
                'made_in' => $made_in,
                'type' => $type,
                'details' => $details,
                'test_reference' => $test_reference,
                'tkdn_certif_num' => $tkdn_certif_num,
                'tkdn_value' => $tkdn_value,
                'valid_until' => $valid_until,
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
                "crawling_month" => date('Ym'),
            ];

            $this->scraping->insert_values($data, $month);
        }
    }

    private function cleaning($data)
    {
        return rtrim(ltrim(str_replace(",", "", str_replace("\r", "", str_replace("\n", "", str_replace("\t", "", strip_tags($data)))))));
    }

    private function scrapeData($url)
    {
        // Initialisation cURL
        $ch = curl_init();

        // Set option cURL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36');

        // Excecute cURL and get result
        $result = curl_exec($ch);

        // Check error
        if (curl_errno($ch)) {
            echo 'Error: ' . curl_error($ch);
        }

        // Close cURL session
        curl_close($ch);

        return $result;
    }
}

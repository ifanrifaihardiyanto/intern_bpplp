<?php defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . '/libraries/CacheModel.php';

class BaseController extends CI_Controller
{
    use CacheModel;

    protected $role = '';
    protected $vendorId = '';
    protected $name = '';
    protected $roleText = '';
    protected $global = array();
    protected $metadata = Null;

    public function __construct()
    {
        parent::__construct();
        // $this->load->model('login_model', 'login');

        // Load cache module
        $this->instance_cache();

        // if (!empty($this->input->get_request_header('Authorization'))) {
        //     $request_token = str_replace('Bearer ', '', $this->input->get_request_header('Authorization'));
        //     $response = $this->login->check_token($request_token);
        //     if (empty($response)) {
        //         redirect('/');
        //     }
        // } else {
        //     $user = $this->session->userdata('user');
        //     if (empty($user)) {
        //         redirect('/');
        //     }
        // }


        $this->metadata = (object) [
            'pageTitle' => NULL,
            'pageLink' => NULL,
            'pageView' => NULL,
            'sidebar' => (object) [
                'parent_active' => NULL,
                'category_active' => NULL,
                'item_active' => NULL,
            ],
        ];
    }

    public function permission($roles)
    {
        $user = $this->session->userdata('user');
        if (empty($user) || !in_array($user->role, $roles)) {
            redirect('/index.php/dashboard');
        }
    }


    /**
     * Takes mixed data and optionally a status code, then creates the response
     *
     * @access public
     * @param array|NULL $data
     *        	Data to output to the user
     *        	running the script; otherwise, exit
     */
    public function response($status_code, $data = NULL)
    {
        $this->output
            ->set_status_header($status_code)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }

    /**
     * This function used to check the user is logged in or not
     */
    function isLoggedIn()
    {
        $isLoggedIn = $this->session->userdata('isLoggedIn');

        if (!isset($isLoggedIn) || $isLoggedIn != TRUE) {
            redirect('login');
        } else {
            $this->role = $this->session->userdata('role');
            $this->vendorId = $this->session->userdata('userId');
            $this->name = $this->session->userdata('name');
            $this->roleText = $this->session->userdata('roleText');

            $this->global['name'] = $this->name;
            $this->global['role'] = $this->role;
            $this->global['role_text'] = $this->roleText;
        }
    }

    /**
     * This function is used to check the access
     */
    function isAdmin()
    {
        if ($this->role != ROLE_ADMIN) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * This function is used to check the access
     */
    function isTicketter()
    {
        if ($this->role != ROLE_ADMIN || $this->role != ROLE_MANAGER) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * This function is used to load the set of views
     */
    function loadThis()
    {
        $this->global['pageTitle'] = 'CodeInsect : Access Denied';

        $this->load->view('includes/header', $this->global);
        $this->load->view('access');
        $this->load->view('includes/footer');
    }

    /**
     * This function is used to logged out user from system
     */
    function logout()
    {
        $this->session->sess_destroy();

        redirect('login');
    }

    /**
     * This function used to load views
     * @param {string} $viewName : This is view name
     * @param {mixed} $headerInfo : This is array of header information
     * @param {mixed} $pageInfo : This is array of page information
     * @param {mixed} $footerInfo : This is array of footer information
     * @return {null} $result : null
     */
    function loadViews($viewName = "", $headerInfo = NULL, $pageInfo = NULL, $footerInfo = NULL)
    {
        $parent = $this->metadata->sidebar->parent_active;
        $category = str_replace(" &", "", strtolower($this->metadata->sidebar->category_active));
        $item = ucwords($this->metadata->sidebar->item_active);

        $pageInfo['pageTitle'] = "MetaBright : {$item}";
        $pageInfo['pageLink'] = 'index.php/rewards_regional/data/' . str_replace(" ", "_", strtolower($category)) . '/' . $this->metadata->pageLink;
        $pageInfo['pageView'] = $this->metadata->pageView;
        $pageInfo['sidebar'] = (array) $this->metadata->sidebar;

        // $this->load->view('includes/header', $headerInfo);
        $this->load->view($viewName, $pageInfo);
        // $this->load->view('includes/footer', $footerInfo);
    }

    /**
     * This function used provide the pagination resources
     * @param {string} $link : This is page link
     * @param {number} $count : This is page count
     * @param {number} $perPage : This is records per page limit
     * @return {mixed} $result : This is array of records and pagination data
     */
    function paginationCompress($link, $count, $perPage = 10)
    {
        $this->load->library('pagination');

        $config['base_url'] = base_url() . $link;
        $config['total_rows'] = $count;
        $config['uri_segment'] = SEGMENT;
        $config['per_page'] = $perPage;
        $config['num_links'] = 5;
        $config['full_tag_open'] = '<nav><ul class="pagination">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['first_tag_open'] = '<li class="arrow">';
        $config['first_link'] = 'First';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = 'Previous';
        $config['prev_tag_open'] = '<li class="arrow">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li class="arrow">';
        $config['next_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="arrow">';
        $config['last_link'] = 'Last';
        $config['last_tag_close'] = '</li>';

        $this->pagination->initialize($config);
        $page = $config['per_page'];
        $segment = $this->uri->segment(SEGMENT);

        return array(
            "page" => $page,
            "segment" => $segment
        );
    }
}

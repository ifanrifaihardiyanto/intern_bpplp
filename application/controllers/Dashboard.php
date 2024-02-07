<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Dashboard extends BaseController
{
    /**
     * Index Page for this controller.
     */
    public function index()
    {
        redirect('index.php/frontend/dashboard/index', 'refresh');
        // redirect('index.php/dashboard');
        // $this->load->view('/dashboard');

        // $this->metadata->pageView = '/dashboard';

        // $this->loadViews("includes/main", NULL, $this->global, NULL);
    }
}

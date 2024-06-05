<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Dashboard extends BaseController
{
    /**
     * Index Page for this controller.
     */
    public function index()
    {
        redirect('index.php/dashboard/front_page');
    }

    public function front_page()
    {
        $this->metadata->pageView = '/dashboard';

        $this->loadViews("includes/main", NULL, $this->global, NULL);
    }
}

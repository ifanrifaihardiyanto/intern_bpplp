<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Frontend extends BaseController
{
    /**
     * Index Page for this controller.
     */
    public function index()
    {
        $this->metadata->sidebar->parent_active = 'Frontend';
        $this->metadata->sidebar->category_active = 'Frontend';
        $this->metadata->sidebar->item_active = "Frontend";
        $this->metadata->pageView = 'frontend/index';

        $this->loadViews("includes/main", NULL, $this->global, NULL);
    }
}

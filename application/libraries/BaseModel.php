<?php defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . '/libraries/CacheModel.php';

/**
 * BaseModel is used to connecting CI_Model with plugin
 * 
 * @author Rifky Sultan Karisma A <rifkysultanka@gmail.com>
 */
class BaseModel extends CI_Model
{
    // Use cache module
    use CacheModel;

    public function __construct()
    {
        // Load cache module
        $this->instance_cache();
    }
}

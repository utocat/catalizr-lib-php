<?php

namespace Catalizr;

/**
 * Description of Pagination
 *
 * @author codati
 */
class Pagination {
    /**
     *
     * @var integer
     */
    public $page;
    /**
     *
     * @var integer
     */
    public $per_page;
    /**
     *
     * @var string
     */
    public $order_by;
   /**
    *
    * @var string
    */
    public $sort;
    
    
    public function __construct($config = null) {
        if(isset($config['page']))
        {
          $this->page = $config['page'];
        }
        if(isset($config['per_page']))
        {
          $this->per_page = $config['per_page'];

        }
        if(isset($config['order_by']))
        {
          $this->order_by = $config['order_by'];
        }
        if(isset($config['sort']))
        {
          $this->sort = $config['sort'];
        }
    }
}

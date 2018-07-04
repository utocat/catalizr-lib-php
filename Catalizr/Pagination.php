<?php

namespace Catalizr;

/**
 * Description of Pagination
 *
 * @author codati
 */
class Pagination {

    const DEFAULT_PAGE = 1;
    const DEFAULT_PER_PAGE = 20;

    /**
     * @var array
     */
    public $items;

    /**
     *
     * @var string
     */
    public $order_by;

    /**
     *
     * @var int
     */
    public $page;

    /**
     *
     * @var int
     */
    public $per_page;

    /**
    *
    * @var string
    */
    public $sort;

    /**
     * @var int
     */
    public $total_items;

    /**
     * Pagination constructor.
     * @param array|null $config
     */
    public function __construct($config = null)
    {
        $this->page = self::DEFAULT_PAGE;
        $this->per_page = self::DEFAULT_PER_PAGE;

        if (isset($config['page'])) {
          $this->page = $config['page'];
        }
        if (isset($config['per_page'])) {
          $this->per_page = $config['per_page'];
        }
        if (isset($config['order_by'])) {
          $this->order_by = $config['order_by'];
        }
        if (isset($config['sort'])) {
          $this->sort = $config['sort'];
        }
    }
}

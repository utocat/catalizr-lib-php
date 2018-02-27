<?php

namespace Catalizr;

/**
 * Description of newPHPClass
 *
 * @author codati
 */
class Api {
    /**
     *
     * @var \Catalizr\Lib\Config
     */
    public $config;
    
    /**
     *
     * @var \Catalizr\Api\Banks
     */
    public $banks;
        
    /**
     *
     * @var \Catalizr\Api\Investors
     */
    public $investors;
    
    /**
     *
     * @var \Catalizr\Api\Companies
     */
    public $companies;
    
    /**
     *
     * @var \Catalizr\Api\Fundraisings
     */
    public $fundraisings;
        
    /**
     *
     * @var \Catalizr\Api\Investments
     */
    public $investments;
    
    /**
     *
     * @var \Catalizr\Api\Documents
     */
    public $documents;
    
    /**
     *
     * @var \Catalizr\Lib\HelperRequest
     */
    public $helperRequest;
    
    public function __construct($config = null) {

        $this->config        = new Lib\Config($config);
        $this->helperRequest = new Lib\HelperRequest($this);
        
        $this->banks     = new Api\Banks($this);
        $this->investors = new Api\Investors($this);
        $this->companies = new Api\Companies($this);
        $this->fundraisings = new Api\Fundraisings($this);
        $this->investments = new Api\Investments($this);
        $this->documents = new Api\Documents($this);
        
    }
    
}

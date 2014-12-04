<?php
class Zenfox_WebAnalytics_GoogleAnalytics
{
/**
 * 
 *  @author Wojciech Gancarczyk <gancarczyk@gmail.com>
 */
    const CLIENTLOGIN_URL = 'https://www.google.com/accounts/ClientLogin';
    const ACCOUNT_FEED_URL = 'http://www.google.com/analytics/feeds/accounts/default';
    const DATA_FEED_URL = 'https://www.google.com/analytics/feeds/data';
    const SERVICE_NAME = 'analytics';
 
    /**
     * @var int
     */
    protected $_ga;
    
    /**
     * @var int
     */
    protected $_trackerId;
 
    /**
     * Class counstructor. It accepts only array as a parameter. It then
     * checks, if the array keys correspond to the setters of this class
     * and if they do, it sets them. After that it is trying to perform
     * authentication.
     *
     * @param array $params
     * @throws Exception
     */
    public function __construct($params = array())
    {
    	if (!is_array($params))
            throw new Exception(
                'Constructor accepts only an array as a parameter');
 
        if (!empty($params)) 
        {
            $methods = get_class_methods($this);
 
            foreach ($params as $key => $value) 
            {
                $method = 'set' . ucfirst($key);
                if (in_array($method, $methods))
                    $this->$method($value);
            }
        }
    }
 

    /**
     * Setter for ga.
     *
     * @param integer $ga
     */
    public function setGa($ga)
    {
        $this->_ga = (int) $ga;
    }
 
    /**
     * Getter for ga.
     *
     * @return integer
     */
    public function getGa()
    {
        return $this->_ga;
    }
    
	/**
     * Setter for trackerId.
     *
     * @param integer $ga
     */
    public function setTrackerId($trackerId)
    {
        $this->_trackerId = (int) $trackerId;
    }
    /**
     * Getter for trackerId.
     *
     * @return integer
     */
    public function getTrackerId()
    {
        return $this->_trackerId;
    }
}

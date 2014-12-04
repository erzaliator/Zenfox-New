<?php
class Zenfox_WebAnalytics_API_GoogleAnalytics
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
     * @var string
     */
    protected $_auth;
 
    /**
     * @var string
     */
    protected $_applicationName = 'MyApp-MyDesc-0.1';
 
    /**
     * @var string
     */
    protected $_username;
 
    /**
     * @var string
     */
    protected $_password;
 
    /**
     * @var int
     */
    protected $_ga;
 
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
 
        if (!empty($params)) {
            $methods = get_class_methods($this);
 
            foreach ($params as $key => $value) {
                $method = 'set' . ucfirst($key);
                if (in_array($method, $methods))
                    $this->$method($value);
            }
            $this->authenticate();
        }
    }
 
    /**
     * Performs authentication. It has to be calles before any data
     * can be received, because auth is neccassary for each call.
     *
     * @param string $username
     * @param string $password
     * @throws Exception
     */
    public function authenticate($username = null, $password = null)
    {
        if (null === $username && null === $this->getUsername())
            throw new Exception(
                'Username is necessary to perform authentication');
 
        if (null === $password && null === $this->getPassword())
            throw new Exception(
                'Password is necessary to perform authentication');
 
        if (is_string($username))
            $this->setUsername($username);
 
        if (is_string($password))
            $this->setPassword($password);
            
        $client = new Zend_Http_Client(self::CLIENTLOGIN_URL);
        $client->setMethod(Zend_Http_Client::POST);
 
        $client->setParameterPost(array(
		'Email'       => $this->getUsername(),
		'Passwd'      => $this->getPassword(),
                'AccountType' => 'GOOGLE',
                'service'     => self::SERVICE_NAME,
                'source'      => $this->getApplicationName(),
        ));
        $response = $client->request('POST');
 		echo $response->getMessage();
        if ($response->getStatus() != '200')
            throw new Exception(
                'Authentication failed. Status returned: ' .
                $response->getStatus());
 		
        $return = explode('=', $response->getBody());
        $this->setAuth($return[3]);
    }
 
    /**
     * Recieves the account feed.
     *
     * @return string XML stream
     * @throws Exception
     */
    public function getAccountFeed()
    {
        if (null === $this->getAuth())
            throw new Exception(
                'Account Feed cannot retrieve any results, ' .
                'because the client was not authenticated');
 
        $client = new Zend_Http_Client(self::ACCOUNT_FEED_URL);
        $client->setMethod(Zend_Http_Client::GET);
        $client->setParameterGet('start-index', '1');
        $client->setParameterGet('max-results', '2');
        $client->setParameterGet('prettyprint', 'true');
        $client->setHeaders('Authorization', 'GoogleLogin auth=' . $this->getAuth());
        $response = $client->request('GET');
 
        if ($response->getStatus() != '200')
            throw new Exception(
                'Authentication failed. Status returned: ' .
                $response->getStatus());
 
        return $response->getBody();
    }
 
    /**
     * Performs data feed.
     *
     * @return string XML stream
     * @throws Exception
     */
    public function getDataFeed()
    {
        if (null === $this->getAuth())
            throw new Exception(
                'Account Feed cannot retrieve any results, ' .
                'because the client was not authenticated');
 
        if (null === $this->getGa())
            throw new Exception(
                'Account ID was not provided');
 
        $client = new Zend_Http_Client(self::DATA_FEED_URL);
        $client->setMethod(Zend_Http_Client::GET);
        $client->setParameterGet('ids', 'ga:' . $this->getGa());
        $client->setParameterGet('dimensions', 'ga:source,ga:medium');
        $client->setParameterGet('metrics', 'ga:visits,ga:bounces');
        $client->setParameterGet('sort', '-ga:visits');
        $client->setParameterGet('start-date', '2009-08-01');
        $client->setParameterGet('end-date', '2009-08-31');
        $client->setParameterGet('start-index', '10');
        $client->setParameterGet('max-results', '100');
        $client->setHeaders('Authorization', 'GoogleLogin auth=' . $this->getAuth());
        $response = $client->request('GET');
 
        if ($response->getStatus() != '200')
            throw new Exception(
                'Authentication failed. Status returned: ' .
                $response->getStatus());
 
        return $response->getBody();
    }
 
    /**
     * Setter for username.
     *
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->_username = (string) $username;
    }
 
    /**
     * Getter for username.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->_username;
    }
 
    /**
     * Setter for password.
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->_password = (string) $password;
    }
 
    /**
     * Getter for password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->_password;
    }
 
    /**
     * Setter for auth.
     *
     * @param string $auth
     */
    public function setAuth($auth)
    {
        $this->_auth = (string) $auth;
    }
 
    /**
     * Getter for getAuth.
     *
     * @return string
     */
    public function getAuth()
    {
        return $this->_auth;
    }
 
    /**
     * Setter for applicationName.
     *
     * @param string applicationName
     */
    public function setApplicationName($name)
    {
        $this->_applicationName = (string) $name;
    }
 
    /**
     * Getter for applicationName.
     *
     * @return string
     */
    public function getApplicationName()
    {
        return $this->_applicationName;
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
}

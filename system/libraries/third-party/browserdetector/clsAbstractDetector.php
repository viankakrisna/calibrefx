<?PHP
/**
 * Easy Browser Detection
 *
 * @author      Muneeb <m4munib@hotmail.com>
 * @copyright   Muneeb <m4munib@hotmail.com>
 * @twitter     http://twitter.com/#!/muhammadmunib
 */
abstract class clsAbstractDetector
{
    protected $_user_agent = '';
    protected $_browsers =  array('ie', 'msie', 'firefox', 'chrome', 'safari', 'webkit', 'opera', 'netscape','konqueror', 'gecko', 'flock');
    
    protected $_is_detected = false;

    protected $_detected_value = 'unknown';
    protected $_version = '0.0.0';
 
    protected $_is_init = false;
    
    public function setBrowsers($browsers)
    {
        $this->_browsers = array_merge($this->_browsers, (array)$browsers);
    }
    
    /**
     * Constructor - User agent will be fetched from Globals if not provided
     * @param type $user_agent 
     */
    public function __construct($user_agent='')
    {
        if($user_agent == '')
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
        
        $this->_user_agent = strtolower($user_agent);
    }
    
    /**
     *
     * @param type $type
     * @example $oDetect = new clsDetect();
     * try{
     *  if($oDetect->Detect()->isDetected())
        {
            echo "Detected";
        }
        else
        {
            echo "Not Detected";
        }
     * }catch(Exception $ex){ echo $ex->getMessage(); }
     * @return $this 
     */
    public final function Detect()
    {
  
        $this->_is_detected = false;
        $this->_is_init = true;
        
        $this->_Detect();
        
        return $this; // for Method Chaining :)
    }
    
    private $_keys = null;
    private function getKeys()
    {
        if($this->_keys == null)
        {
            $this->_keys = array_keys($this->_codes);
        }
        
        return $this->_keys;
    }
    

    /**
     * @abstract Abstract Method
     * @return void
     */
    protected abstract function _Detect();
       
    public function getDetectedValue()
    {
        return $this->_detected_value;
    }
    
    public function isDetected()
    {
        return $this->_is_detected;
    }
    
    /**
     * Wrapper method to support this class naming conventions
     * @return string
     */
    public function getBrowser()
    {
        return $this->getDetectedValue();
    }
    
    /**
     * Get Browser Version
     * @return string
     */
    public function getVersion()
    {
        return $this->_version;
    }
    
   
    
     /**
     *
     * @param type $method
     * @param type $args
     * @return bool
     * @usage isIE() or isChrome or isFirefox  
     */
    public function __call($method, $args)
    {
        $method = strtolower($method);
        
        $this->_is_valid = (strpos($method, 'is') !== false) && (substr($method, 0, 2) == 'is');
         
        if($this->_is_valid == false)
        {
            throw new Exception("Invalid operation - Method ".$method." doesn't exist");
        }
        
        //if this method is run directly - Run Detection routine to get results
        if($this->_is_init == false)
        {
            $this->Detect(); 
        }
        
        $explode = explode('is', $method);
        
        $browser = strtolower($explode[1]);
        
        return ($this->_detected_value == $browser);
    }
}
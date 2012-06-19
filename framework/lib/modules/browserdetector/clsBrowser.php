<?PHP
/**
 * Easy Browser Detection
 *
 * @author      Muneeb <m4munib@hotmail.com>
 * @copyright   Muneeb <m4munib@hotmail.com>
 * @twitter     http://twitter.com/#!/muhammadmunib
 */
include"clsAbstractDetector.php";
class clsBrowser extends clsAbstractDetector
{
    protected function _Detect()
    {
        foreach($this->_browsers as $key => $browser)
        {
            if (preg_match("#($browser)[/ ]?([0-9.]*)#", $this->_user_agent, $match))
            {
                $this->_is_detected = true;
                $this->_detected_value = $match[1] ;
                $this->_version = $match[2] ;
                break ;
            }
        }
    }
}
?>
<?php
/**
 * Class Minify_Controller_Files  
 * @package Minify
 */

require_once 'Minify/Controller/Base.php';

/**
 * Controller class for minifying a set of files
 *
 * @package Minify
 * @author Ivan Kristianto <ivan@calibreworks.com>
 */
class Minify_Controller_CalibrefxMin extends Minify_Controller_Base {
    
    /**
     * Set up file sources
     * 
     * @param array $options controller and Minify options
     * @return array Minify options
     * 
     * Controller options:
     * 
     * 'files': (required) array of complete file paths, or a single path
     */
    public function setupSources($options) {
        // strip controller options
        
        $files = $options['files'];
        // if $files is a single object, casting will break it
        if (is_object($files)) {
            $files = array($files);
        } elseif (! is_array($files)) {
            $files = (array)$files;
        }
        unset($options['files']);
        
        $sources = array();
        foreach ($files as $file) {
            if ($file instanceof Minify_Source) {
                $sources[] = $file;
                continue;
            }
            
            if(!file_exists(CALIBREFX_CACHE_URI . '/' . md5($file))){
                $data = file_get_contents($file);
                $file = calibrefx_write_cache(CALIBREFX_CACHE_URI . '/' . md5($file),  $data);
            }else{
                $file = CALIBREFX_CACHE_URI . '/' . md5($file);
            }
            
            if (0 === strpos($file, '//')) {
                $file = $_SERVER['DOCUMENT_ROOT'] . substr($file, 1);
            }
            $realPath = realpath($file);
            if (is_file($realPath)) {
                $sources[] = new Minify_Source(array(
                    'filepath' => $realPath
                ));    
            } else {
                $this->log("The path \"{$file}\" could not be found (or was not a file)");
                return $options;
            }
        }
        if ($sources) {
            $this->sources = $sources;
        }
        return $options;
    }

}


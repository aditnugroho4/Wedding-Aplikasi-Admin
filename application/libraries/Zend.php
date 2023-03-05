<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
 
class CI_Zend
{
    /*
     * Constructor..
     *
     */
    function __construct($class = null)
    {
        // Inisialisasi folder
        ini_set('include_path',
        ini_get('include_path') . PATH_SEPARATOR . APPPATH . 'third_party');
 
        if ($class)
        {
            require_once (string) $class . EXT;
            log_message('debug', "Zend class $class loaded");
        }
        else
        {
            log_message('debug', "Zend class initialized");
        }
 
    }
 
    /*
     * Zend class loader
     *
     */
    function load($class)
    {
        require_once (string) $class . EXT;
        log_message('debuq', "Zend class $class loaded");
    }
}
 
/* End of File: Zend.php */
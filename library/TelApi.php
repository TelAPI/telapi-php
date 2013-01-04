<?php

if( floatval(phpversion()) < 5.2) {
    trigger_error(sprintf(
        "Your PHP version %s is not valid. In order to run TelAPI helper you will need to have at least PHP 5.2 or above.", 
         phpversion() 
    ));
}


/** @see TelApi_Exception */
require_once 'TelApi/Exception.php';

/** @see TelApi_Schemas */
require_once 'TelApi/Schemas.php';

/** @see TelApi_InboundXML **/
require_once 'TelApi/InboundXML.php';

/** @see TelApi_Helpers **/
require_once 'TelApi/Helpers.php';

/** @see TelApi_Connector **/
require_once 'TelApi/Connector.php';

/** @see TelApi_Related **/
require_once 'TelApi/Related.php';

/** @see TelApi_Client **/
require_once 'TelApi/Client.php';

/** @see TelApi_Client **/
require_once 'TelApi/Connect.php';

/**
 * 
 * TelAPI singleton instance to the wrapper
 * 
 * --------------------------------------------------------------------------------
 * 
 * @category  TelApi Wrapper
 * @package   TelApi
 * @author    Nevio Vesic <nevio@telapi.com>
 * @license   http://creativecommons.org/licenses/MIT/ MIT
 * @copyright (2012) TelTech Systems, Inc. <info@telapi.com>
 */

final class TelApi extends TelApi_Related
{
    /**
     * Singleton instance container
     * @var self|null 
     */
    protected static $_instance = null;
    
    /**
     * Singleton access method to TelAPI. This is THE ONLY PROPER WAY to
     * access the TelAPI wrapper!
     * 
     * @return self
     */
    static function getInstance() {
        if(is_null(self::$_instance)) self::$_instance = new self();
        return self::$_instance;
    }
}

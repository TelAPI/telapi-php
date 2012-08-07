<?php

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

/**
 * 
 * TelAPI singleton instance to the wrapper itself
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
     * Singleton access method to TelAPI. This is THE ONLY PROPER WAY how to
     * access TelAPI wrapper itself.
     * 
     * @return self
     */
    static function getInstance() {
        if(is_null(self::$_instance)) self::$_instance = new self();
        return self::$_instance;
    }
}
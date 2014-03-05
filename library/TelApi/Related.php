<?php

/**
 * 
 * Related logic to TelAPI wrapper. This file is the parent of "all"
 * 
 * --------------------------------------------------------------------------------
 * 
 * @category  TelApi Wrapper
 * @package   TelApi
 * @author    Nevio Vesic <nevio@telapi.com>
 * @license   http://creativecommons.org/licenses/MIT/ MIT
 * @copyright (2012) TelTech Systems, Inc. <info@telapi.com>
 */

abstract class TelApi_Related
{
    
    /** Wrapper to return TelAPI response as JSON */
    CONST WRAPPER_JSON         = 'json';
    
   
    /** Wrapper to return TelAPI response as XML */
    CONST WRAPPER_XML          = 'xml';
    
    
    /** BASE TELAPI URI */
    CONST API_URL              = 'https://api.telapi.com/';
    
    /** BASE TELAPI API VERSION */
    CONST API_VERSION          = 'v1';
    
    
    /** 
     * Beginning component of the API request url. This will be built into the
     * url, so please avoid changing this if you want the wrapper to work! 
     */
    CONST API_START_COMPONENT  = 'Accounts';
    
    /**
     * Available TelAPI REST endpoint versions are:
     * 
     * @var array
     */
    protected $_availableVersions = array( '2011-07-01', 'v1' );


    /**
     * All available options which can be set for the wrapper itself.
     * All the listed options are required as well.
     * 
     * @var array
     */
    protected static $_options = array(
        'account_sid'       => null,
        'auth_token'        => null,
        'wrapper_type'      => self::WRAPPER_JSON,
        'response_to_array' => false,
        'api_version'       => self::API_VERSION
    );
    
    
    /**
     * All existing and available TelAPI components that can be accessed by
     * this wrapper
     * 
     * @var array
     */
    private $_components = array(
        'accounts'                =>  null, # Accounts is already defined in url from the start.  
        'calls'                   => 'Calls',
        'conferences'             => 'Conferences',
        'sms_messages'            => 'SMS/Messages',
        'recordings'              => 'Recordings',
        'transcriptions'          => 'Transcriptions',
        'notifications'           => 'Notifications',
        'available_phone_numbers' => 'AvailablePhoneNumbers',
        'incoming_phone_numbers'  => 'IncomingPhoneNumbers',
        'carrier'                 => 'Lookups/Carrier',
        'cnam'                    => 'Lookups/Cnam',
        'bna'                     => 'Lookups/Bna',
        'applications'            => 'Applications',
        'fraud'                   => 'Fraud',
        'usages'                  => 'Usages',
    	'rates'                   => 'Rates',
		'connect'                 => 'Connect',
        'faxes'                   => 'Faxes'
    );
    
    
    /**
     * Current component key which will be passed out to the Connector class
     * when the time comes
     * 
     * @var string|null
     */
    private $_component = null;
    
    /**
     * Client token. When generated, it will be "saved" here
     * 
     * @var array
     */
    protected $_clientToken = array();
    
    
    /**
     * Generated headers (credentials) which came from successful authorisation
     *
     * @var array
     */
    protected static $_connectHeaders = array();
    
    
    /** *********** OPTION RELATED METHODS ************** **/


    /**
     * Set a list of options all at once.
     * 
     * @param  array $options 
     * @return void
     */
    function setOptions(Array $options) {
        foreach($options as $key => $value) $this->setOption($key, $value);
    }
    
    /**
     * Set a single option for the TelAPI wrapper. If option key doesn't exist it will
     * throw that the key itself is not available and therefore cannot be found.
     * 
     * @param  string $key
     * @param  mixed  $value
     * @throws TelApi_Exception 
     * @return void
     */
    function setOption($key, $value) {
        if(!array_key_exists(strtolower($key), self::$_options)) {
            throw new TelApi_Exception("Provided option '{$key}' cannot be found");
        }
        self::$_options[strtolower($key)] = $value;
    }
    
    
    /**
     * Get singular option value. If value is not set, null will be returned
     * 
     * @param  string $key
     * @return mixed
     */
    function option($key) {
        return isset(self::$_options[strtolower($key)]) 
               ? self::$_options[strtolower($key)] : null;
    }
    
    
    /** *********** QUERY RELATED METHODS ************** **/
    
    
    /**
     * Get resource by component and component SID
     * 
     * @param  string|array $component
     * @param  array        $parameters 
     * @return TelApi_Connector
     */
    function get($component, Array $parameters=array()) {
        return new TelApi_Connector($this->_execute(
            rtrim($this->_buildBaseUrl() . $this->_buildUrl($component, $parameters), '/') . '.' . self::WRAPPER_JSON
            .
            $this->_buildParameters($parameters)
         ), $this->option('response_to_array'), $this->_component);
    }
    
    
    /**
     * POSTING (Creating) new documents for desired resources, such as sending new
     * SMS messages
     * 
     * @param  string|array $component
     * @param  array        $data
     * @return TelApi_Connector 
     */
    function create($component, Array $data) {
        $creation_url = rtrim($this->_buildBaseUrl() . $this->_buildUrl($component, array()), '/') . '.' . self::WRAPPER_JSON;
        $post_params  = $this->_buildPostParameters($data);
        return new TelApi_Connector($this->_execute($creation_url, 'POST', $post_params), $this->option('response_to_array'), $this->_component);
    }
    
    /**
     * POSTING (Updating) documents for desired resources, such as sending new
     * SMS messages
     * 
     * @param  string|array $component
     * @param  array        $data
     * @return TelApi_Connector 
     */
    function update($component, Array $data) {
        $creation_url = rtrim($this->_buildBaseUrl() . $this->_buildUrl($component, array()), '/') . '.' . self::WRAPPER_JSON;
        $post_params  = $this->_buildPostParameters($data);
        return new TelApi_Connector($this->_execute($creation_url, 'POST', $post_params), $this->option('response_to_array'), $this->_component);
    }
    
    
    /**
     * DELETING resources such as recordings.
     * You cannot add query parameters to this resource and it is very limited (deleting)
     * so please consult REST documentation on the telapi site.
     * 
     * @param  string|array $component 
     * @param  array        $data
     * @return TelApi_Connector 
     */
    function delete($component) {
        $creation_url = rtrim($this->_buildBaseUrl() . $this->_buildUrl($component, array()), '/') . '.' . self::WRAPPER_JSON;
        return new TelApi_Connector($this->_execute($creation_url, 'DELETE', ''), $this->option('response_to_array'), $this->_component);
    }
    
    /** *********** CLIENT RELATED METHODS ************** **/
    
    
    /**
     * Return an instance of the TelAPI Client class
     * 
     * @return Class <TelApi_Client, self, NULL>
     */
    function getClient() {
    	return TelApi_Client::getInstance();
    }
    
    /**
     * Return an instance of the TelAPI Connect class
     *
     * @return Class <TelApi_Connect, self, NULL>
     */
    function getConnect() {
    	return TelApi_Connect::getInstance();
    }
    
    /** *********** INTERNAL METHODS ************** **/
    
    
    /**
     * Building base URL of TelAPI wrapper. This will set 
     * https://{url}/{version}/accounts/account_sid
     * as main and base url.
     * 
     * @return string
     * @throws TelApi_Exception 
     */
    private function _buildBaseUrl() {

        $return_url = self::API_URL . $this->_getBaseVersion() . '/';
        
        if(is_null($this->option('account_sid'))) {
            throw new TelApi_Exception(
                "Please set account_sid option. You need to pass account_sid option as 
                auth_token in order to authenticate and/or use TelAPI wrapper"
            );
        }
        
        $return_url .= self::API_START_COMPONENT . '/' . $this->option('account_sid') . '/';
        return $return_url;
    }
    
    /**
     * Get base version of the TelAPI REST API endpoint.
     * 
     * @return string
     * @throws TelApi_Exception  If invalid api_version applied
     */
    private function _getBaseVersion() {
        $base_version = strtolower($this->option('api_version'));
        
        if(!in_array($base_version, $this->_availableVersions)) {
            $base_versions = implode(', ', $this->_availableVersions);
            throw new TelApi_Exception("Defined version '{$base_version}' does not exist. Please use one of following versions: '{$base_versions}'");
        }
        
        $this->setOption('api_version', $base_version);
        return $this->option('api_version');
    }


    
    /**
     * This will build URL of TelAPI wrapper after the AccountSid with or without
     * possible GET parameters like ?PageSize=20
     * 
     * @param  array|string $component
     * @param  array $parameters
     * @return string
     * @throws TelApi_Exception
     */
    private function _buildUrl($component, Array $parameters=array()) {
        $return_url = '';
        
        $schemas = TelApi_Schemas::getInstance();
        
        if(is_array($component)) {
            
            $is_component = $schemas->isRestComponent(strtolower($component[0])); 
            
            if(!$is_component) {
                $available_components = implode(", ", array_keys((array)$schemas->getAvailableRestComponents()));
                throw new TelApi_Exception(
                    "Component you've requested '{$component[0]}' cannot be found. Available components are: '{$available_components}'"
                );
            }
            
            if(is_null($schemas->getRestComponentName(strtolower($component[0])))) {
                throw new TelApi_Exception("First resource argument in array cannot be null!");
            }
            
            $this->_component = strtolower($component[0]);
            
            $return_url = str_ireplace($component[0], $this->_components[strtolower($component[0])], implode('/', $component));
            
        } else {
            
            $is_component = $schemas->isRestComponent(strtolower($component)); 

            if(!$is_component) {
                $available_components = implode(", ", array_keys((array)$schemas->getAvailableRestComponents()));
                throw new TelApi_Exception(
                    "Component you've requested '{$component}' cannot be found. Available components are: '{$available_components}'"
                );
            }
            
            $this->_component = strtolower($component);
            
            if(!is_null($this->_components[strtolower($component)]))
                $return_url .= $this->_components[strtolower($component)] . '/';
            
        }

        return $return_url;
    }
    
    
    /**
     * Building GET query parameters will return blank if there are no parameters
     * 
     * @param  array  $parameters
     * @return string 
     */
    private function _buildParameters(Array $parameters=array()) {
        $return_params = '';
        
        if(count($parameters) > 0) {
            $return_params = '?';
            
            foreach($parameters as $parameter => $value) {
                if(is_array($value)) {
                    foreach($value as $subvalue) {
                        $return_params .= $parameter.'='.$subvalue.'&';
                    }
                } else {
                    $return_params .= $parameter.'='.$value.'&';
                }
            }
            
            $return_params = rtrim($return_params, '&');
        }
        
        return $return_params;
    }
    
    
    /**
     * Building GET query parameters will return blank if there are no parameters
     * 
     * @param  array  $parameters
     * @return string 
     */
    private function _buildPostParameters(Array $parameters=array()) {
        $return_params = '';
        
        if(count($parameters) > 0) {
            foreach($parameters as $parameter => $value) {
                if(is_array($value)) {
                    foreach($value as $subvalue) {
                        $return_params .= $parameter.'='.urlencode($subvalue).'&';
                    }
                } else {
                    $return_params .= $parameter.'='.urlencode($value).'&';
                }
            }
            $return_params = rtrim($return_params, '&');
        }
        
        return $return_params;
    }


    
    /**
     * Do the actual curl request
     * 
     * @param  string  $url
     * @param  string  $type
     * @param  string  $params
     * @return array 
     */
    private function _execute($url, $type='GET', $params=null){
        $type = strtoupper($type);
        $account_sid = $this->option('account_sid');
        $auth_token  = $this->option('auth_token');
        $response    = array();
        
        if(substr($url, 0, 4) == 'http') $curl_port = 80;
        if(substr($url, 0, 5) == 'https') $curl_port = 443;
        
        if($resource = curl_init()) {
            $curl_opts = array(
                CURLOPT_URL            => $url,
                CURLOPT_PORT           => $curl_port,
                CURLOPT_HEADER         => FALSE,
                CURLOPT_RETURNTRANSFER => TRUE,
                CURLOPT_TIMEOUT        => 0,
                CURLOPT_SSL_VERIFYPEER => FALSE,
                CURLOPT_USERPWD        => "{$account_sid}:{$auth_token}",
            );
                
            if($type == 'DELETE') {
                $curl_opts[CURLOPT_CUSTOMREQUEST] = 'DELETE';
            }
            
            if($type == 'POST') {
                $curl_opts[CURLOPT_POST] = 1;
                $curl_opts[CURLOPT_POSTFIELDS] = $params;
            }
            
            if($this->getConnect()->getStatus() === true) {
	            if(count(self::$_connectHeaders) > 0) {
	            	$curl_opts[CURLOPT_HTTPHEADER] = self::$_connectHeaders;
	            }
            }
            
            if(curl_setopt_array($resource, $curl_opts)) {
                $response['exec']  = curl_exec($resource);
                $response['error'] = curl_error($resource);
                $response['errno'] = curl_errno($resource);
                $response['info']  = curl_getinfo($resource);
            }
        }
        return $response;
    }
}

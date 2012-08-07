<?php

/**
 * 
 * How to view the inbound SMS messages to your TelAPI numbers
 * 
 * --------------------------------------------------------------------------------
 * 
 * 
 * @category  TelApi Wrapper
 * @package   TelApi
 * @author    Nevio Vesic <nevio@telapi.com>
 * @license   http://creativecommons.org/licenses/MIT/ MIT
 * @copyright (2012) TelTech Systems, Inc. <info@telapi.com>
 */


# A 36 character long AccountSid is always required. It can be described
# as the username for your account
$account_sid = '{AccountSid}';

# A 34 character long AuthToken is always required. It can be described
# as your account's password
$auth_token  = '{AuthToken}';

# If you want the response decoded into an Array instead of an Object, set
# response_to_array to TRUE otherwise, leave it as-is
$response_to_array = false;


# First we must import the actual TelAPI library
require_once '../library/TelApi.php';

# Now what we need to do is to instanciate library and set required options
$telapi = TelApi::getInstance();

# This is a best approach on how to setup multiple options recursively
# Take note that you cannot set non-existing options
$telapi -> setOptions(array( 
    'account_sid'       => $account_sid, 
    'auth_token'        => $auth_token,
    'response_to_array' => $response_to_array
));

# If an error occurs, TelApi_Exception will be raised. Due to same logic
# it's best to always do try/catch block while doing any querying against TelAPI
try {
    
    # ARRAY as first argument is here due to mutliple sub-nesting inside of resource uri
    # when for example, you need to get instance of some resource or in this case, SMS Message.
    $sms_message = $telapi->get(array( 'sms_messages', '{SMSMessageSid}' ));
    
    # If you wish to get back the SMS/Message SID then use:
    print_r($sms_message->sid);
    
    # If you wish to get back the full response object/array use:
    print_r($sms_message->getResponse());
    
} catch (TelApi_Exception $e) {
    echo "Error occured: " . $e->getMessage() . "\n";
    exit;
}
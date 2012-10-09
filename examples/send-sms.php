<?php

/**
 * 
 * How to send an SMS with TelAPI
 * 
 * --------------------------------------------------------------------------------
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
# response_to_array to TRUE, otherwise, leave it as-is
$response_to_array = false;


# First we must import the actual TelAPI library
require_once '../library/TelApi.php';

# Now what we need to do is instantiate the library and set the required options defined above
$telapi = TelApi::getInstance();

# This is the best approach to setting multiple options recursively
# Take note that you cannot set non-existing options
$telapi -> setOptions(array( 
    'account_sid'       => $account_sid, 
    'auth_token'        => $auth_token,
    'response_to_array' => $response_to_array
));

# If an error occurs, TelApi_Exception will be raised. Due to this,
# it's a good idea to always do try/catch blocks while querying TelAPI
try {
    
    # NOTICE: The code below will send a new SMS message.
    
    # TelApi_Helpers::filter_e164 is a internal wrapper helper to help you work with phone numbers and their formatting
    # For more information about E.164, please visit: http://en.wikipedia.org/wiki/E.164
    
    $sms_message = $telapi->create('sms_messages', array(
        'From' => '(XXX) XXX-XXXX',
        'To'   => '(XXX) XXX-XXXX',
        'Body' => "This is an SMS message sent from the TelAPI PHP wrapper! Easy as 1, 2, 3!"
    ));
    
    # If you wish to get back the SMS/Message SID just created then use:
    print_r($sms_message->sid);
    
    # If you wish to get back the full response object/array then use:
    print_r($sms_message->getResponse());
    
} catch (TelApi_Exception $e) {
    echo "Error occured: " . $e->getMessage() . "\n";
    exit;
}
<?php

/**
 * 
 * How to list your TelAPI phone numbers
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
    
    # Code bellow will fetch IncomingPhoneNumbers details with 5 records per page (PageSize).
    $incoming_numbers = $telapi->get('incoming_phone_numbers', array(
        'PageSize' => 5
    ));

    # Iteration over incoming phone numbers
    foreach($incoming_numbers->items() as $number) {
        print_r($number);
    }
    
} catch (TelApi_Exception $e) {
    echo "Error occured: " . $e->getMessage() . "\n";
    exit;
}
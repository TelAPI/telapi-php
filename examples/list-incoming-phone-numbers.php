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
    
    # The code below will fetch IncomingPhoneNumbers details with 5 records per page (PageSize).
    $incoming_numbers = $telapi->get('incoming_phone_numbers', array(
        'PageSize' => 5
    ));

    # Iterate over incoming phone numbers
    foreach($incoming_numbers->items() as $number) {
        print_r($number);
    }
    
} catch (TelApi_Exception $e) {
    echo "Error occured: " . $e->getMessage() . "\n";
    exit;
}
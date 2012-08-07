<?php

/**
 * 
 * How to list available phone numbers
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
    
    # AvailablePhoneNumbers resource is here to help you with purchase of the phone number.
    # With this resource you can list ALL available phone numbers based on the phone type and the country code
    
    # Country Code of phone number. 2 digit country code required. 
    # Always use uppercase letters such as 'US' instead of 'us'
    $country_code = strtoupper('US');
    
    # Type of the phone number. At the moment we only support Local phone numbers. 
    # Soon we'll support Tollfree numbers as well.
    $phone_number_type = 'Local';
    
    # Way how you can reach to available phone numbers page limited to 5 records per page.
    # array( 'available_phone_numbers', $country_code, $phone_number_type ) will create:
    # AvailablePhoneNumbers/US/Local.json for you!
    $available_numbers = $telapi->get(array( 'available_phone_numbers', $country_code, $phone_number_type ), array(
        'PageSize' => 5
    ));

    # Iteration over available phone numbers
    foreach($available_numbers->items() as $number) {
        print_r($number);
    }
    
} catch (TelApi_Exception $e) {
    echo "Error occured: " . $e->getMessage() . "\n";
    exit;
}
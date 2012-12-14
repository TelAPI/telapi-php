<?php

/**
 * 
 * How to generate a TelAPI Client token for an existing TelAPI Application
 * 
 * --------------------------------------------------------------------------------
 * 
 * @category  TelApi Wrapper
 * @package   TelApi
 * @author    Nevio Vesic <nevio@telapi.com>
 * @license   http://creativecommons.org/licenses/MIT/ MIT
 * @copyright (2012) TelAPI, Inc. <info@telapi.com>
 */


# A 36 character long AccountSid is always required. It can be described
# as the username for your account

$account_sid = '{AccountSid}';

# A 34 character long AuthToken is always required. It can be described
# as your account's password

$auth_token  = '{AuthToken}';

# If you want the response decoded into an Array instead of an Object, set
# response_to_array to TRUE; otherwise, leave it as-is

$response_to_array = false;

# First we must import the actual TelAPI library

require_once '../library/TelApi.php';

# Then instantiate the library and set the required options defined above

$telapi = TelApi::getInstance();

# This is the best approach to setting multiple options recursively
# Take note that you cannot set non-existing options

$telapi -> setOptions(array( 
    'account_sid'       => $account_sid, 
    'auth_token'        => $auth_token,
    'response_to_array' => $response_to_array
));

# Now get the client class

$telapi_client = $telapi->getClient();

# Lastly, generate the client token
# In order to do so, you will need to have a valid Application and Application SID created via REST API 
# or website: https://www.telapi.com/numbers/applications/

$application_sid = '{ApplicationSid}';

# In the even this wrapper enounters an error, this exception will be thrown. Always use exceptions to catch and view errors
try {
	$telapi_client -> generateToken($application_sid);
} catch(Exception $e) {
	die( sprintf("We could not generate token due to : %s \n", $e->getMessage()) );
}

# If the token is created successfully, it will be printed below

echo sprintf("Client Token for Application '%s' is: '%s' \n", $application_sid, $telapi_client->getToken($application_sid));






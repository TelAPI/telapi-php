## Run Instructions

In order to run files located under this path you will need to follow few easy steps. Runing them is very easy :) 

Once you choose desired example you will need to:


#### Step 1 - Change credentials

Every example file contains following block of the code:

```php
# A 36 character long AccountSid is always required. It can be described
# as the username for your account
$account_sid = '{AccountSid}';

# A 34 character long AuthToken is always required. It can be described
# as your account's password
$auth_token  = '{AuthToken}';
```

`{AccountSid}` and `{AuthToken}` must be changed with real credentials which you can find under [TelAPI dashboard](https://www.telapi.com/dashboard)


#### Step 2 - Change parameters ( if needed )

In case that choosen example is [Send SMS](https://github.com/TelAPI/telapi-php/blob/master/examples/send-sms.php) you will need to update following block of the code:

```php
$sms_message = $telapi->create('sms_messages', array(
    'From' => '(XXX) XXX-XXXX',
    'To'   => '(XXX) XXX-XXXX',
    'Body' => "This is an SMS message sent from the TelAPI PHP wrapper! Easy as 1, 2, 3!"
));
```

where `From` and `To` must be real numbers.
    
    
#### Step 3 - Run the code!

There are many ways how code can be run. We will show you here how to run it under the terminal:

**You must have PHP 5.3 or greater installed in order to run any example!**

```shell
cd telapi-php/examples
php send-sms.php
```
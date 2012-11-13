telapi-php
==========

This PHP library is an open source tool built to simplify interaction with the [TelAPI](http://telapi.com) telephony platform. TelAPI makes adding voice and SMS to applications fun and easy.

For this libraries full documentation visit: http://telapi.github.com/telapi-php

For more information about TelAPI visit:  [telapi.com/features](http://www.telapi.com/features) or [telapi.com/docs](http://www.telapi.com/docs)

---

Installation
============

#### Via Pear

At the moment we don't support the PEAR package but will in the near future!

##### PHP 5.2+ Required (5.3+ recommended)

#### Via GitHub clone

Access terminal and run the following code:

```shell
  $ cd ~
  $ git clone https://github.com/TelAPI/telapi-php.git
  $ cd telapi-php
```

#### Via Download

##### Step 1

Download the [.zip file](https://github.com/telapi/telapi-php/zipball/master).

##### Step 2

Once the .zip download is complete, extract it and get started with the examples below.


---

Usage
======

### REST

[TelAPI REST API documentation](http://www.telapi.com/docs/api/rest/) 

##### Send SMS Example

```php
<?php
require_once '../library/TelApi.php';

// Set up your TelAPI credentials
$telapi = TelApi::getInstance();
$telapi -> setOptions(array(
    'account_sid'       => '{AccountSid}',
    'auth_token'        => '{AuthToken}',
));

// Send the SMS
$sms_message = $telapi->create('sms_messages', array(
    'From' => '+12223334444',
    'To'   => '+15550001212',
    'Body' => "This is an SMS message sent from the TelAPI PHP wrapper! Easy as 1, 2, 3!"
));

print_r($sms_message);
```

### InboundXML

InboundXML is an XML dialect which enables you to control phone call flow. For more information please visit the [TelAPI InboundXML documentation](http://www.telapi.com/docs/api/inboundxml/)

##### <Say> Example

```php
<?php

require_once('library/TelApi/InboundXML.php');

$inbound_xml = new TelApi_InboundXML();

$inbound_xml->say('Welcome to TelAPI. This is a sample InboundXML document.', array('voice' => 'man'));

echo $inbound_xml;
```

will render

```xml
<?xml version="1.0" encoding="UTF-8"?>
<Response>
  <Say voice="man">Welcome to TelAPI. This is a sample InboundXML document.</Say>
</Response>
```

Just host that PHP file somewhere, buy a phone number in your [TelAPI Account Dashboard](https://www.telapi.com/dashboard/) and assign the URL of that PHP page to your new number. Whenever you dial that number, the InboundXML this page generates will be executed and you'll hear our text-to-speech engine say welcome.

---

Documentation
=============
http://telapi.github.com/telapi-php

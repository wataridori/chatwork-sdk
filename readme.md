Chatwork SDK for PHP
==========
##### [API Docs](http://wataridori.github.io/chatwork-sdk/api/index.html)
##### Remember that this SDK is non-official. It may not work when Chatwork update their APIs in the feature.
##### (However, I will try to cover all the changes from Chatwork. If something goes wrong, please let me know)

[![StyleCI](https://styleci.io/repos/28799105/shield)](https://styleci.io/repos/28799105)
[![Build Status](https://travis-ci.org/wataridori/chatwork-sdk.svg)](https://travis-ci.org/wataridori/chatwork-sdk)
[![Latest Stable Version](https://poser.pugx.org/wataridori/chatwork-sdk/v/stable.svg)](https://packagist.org/packages/wataridori/chatwork-sdk)
[![Total Downloads](https://poser.pugx.org/wataridori/chatwork-sdk/downloads)](https://packagist.org/packages/wataridori/chatwork-sdk)
[![Latest Unstable Version](https://poser.pugx.org/wataridori/chatwork-sdk/v/unstable.svg)](https://packagist.org/packages/wataridori/chatwork-sdk)
[![License](https://poser.pugx.org/wataridori/chatwork-sdk/license.svg)](https://packagist.org/packages/wataridori/chatwork-sdk)

## Requirement
* PHP >= 5.4
* PHP cURL

## Install

You can install and manage Chatwork SDK for PHP by using `Composer`

```
composer require wataridori/chatwork-sdk
```

Or add `wataridori/chatwork-sdk` into the require section of your `composer.json` file then run `composer update`

## Versions
| Chatwork API | Chatwork-SDK |
|:------------:|:------------:|
| v1 | 0.1.x |
| v2 | 0.2.x |

## Usage

##### Firstly, to use Chatwork API, you must register an API Key.
##### Pass your key to `ChatworkSDK` class.
```php
ChatworkSDK::setApiKey($apiKey);
```

If you have problems with the SSL Certificate Verification, you can turn it off by the following setting.
```php
// Not recommend. Only do this when you have problems with the request
ChatworkSDK::setSslVerificationMode(false);
```

Now you can easily use many functions to access [Chatwork API Endpoints](http://developer.chatwork.com/ja/endpoints.html).

##### ChatworkSDK's Classes

ChatworkAPI: This is the class that contains base API. You can use it to send request to Chatwork and receive the response in array.
```php
ChatworkSDK::setApiKey($apiKey);
$api = new ChatworkApi();
// Get user own information
$api->me();

// Get user own statics information
$api->getMyStatus();

// Get user rooms list
$api->getRooms();
```

##### ChatworkSDK also provides many others class that help you to work in more object oriented way.
* ChatworkRoom: Use for store Room Information, with many functions to work with Room
* ChatworkUser: Use for store User Information.
* ChatworkMessage: Use for store Message Information.

```php
ChatworkSDK::setApiKey($apiKey);
$room = new ChatworkRoom($roomId);
// The following function will return an array of ChatworkUser
$members = $room->getMembers();
foreach ($members as $member) {
    // Print out User Information
    print_r($member->toArray());
}

// Send Message to All Members in the Room
$room->sendMessageToAll('Test Message');

// Send Message to list of members in the room
$room->sendMessageToList([$member_1, $member_2], 'Another Test Message');
```

The 3 classes above are extended from the `ChatworkBase` class. `ChatworkBase` provides you some useful function to work with messages.
You can easily build a TO message, REPLY or QUOTE message.
```php
ChatworkSDK::setApiKey($apiKey);
$room = new ChatworkRoom($roomId);
$messages = $room->getMessages();
if ($messages & !empty($messages[0])) {
    $lastMessage = $messages[0];
    // Reset Message to null string
    $room->resetMessage();
    // Append the REPLY text to current message
    $room->appendReplyInRoom($lastMessage);
    // Append the QUOTE text to current message
    $room->appendQuote($lastMessage);
    // Append the Information Text to the current message
    $room->appendInfo('Test Quote, Reply, Info text', 'Test from Chatwork-SDK');
    // Send current message into the Room
    $room->sendMessage();
}
```

##### Check ChatworkSDK functions list [here](http://wataridori.github.io/chatwork-sdk/api/class-wataridori.ChatworkSDK.ChatworkApi.html) for further details and usages.

## Run test
* Create a file named `config.json` inside the `tests/fixtures/` folder.
* Input your API Key, and a test Room into `config.json` file. It should look like this:
```json
{
  "apiKey": "YOUR-API-KEY-HERE",
  "roomId": "YOUR-TEST-ROOM-HERE"
}
```
* Then run `phpunit` to start testing.

## Contribution
View contribution guidelines [here](./CONTRIBUTING.md)


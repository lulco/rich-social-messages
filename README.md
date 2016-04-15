# Rich social messages
Library for parsing and improving mesages from social networks.

## Installation

### Composer
The fastest way to install Rich social messages is to add it to your project using Composer (http://getcomposer.org/).
1. Install Composer:
    ```
    curl -sS https://getcomposer.org/installer | php
    ```
1. Require Rich social messages as a dependency using Composer:
    ```
    php composer.phar require lulco/rich-social-messages
    ```
1. Install Rich social messages:
    ```
    php composer.phar update
    ```

## Usage
If you have some Twitter tweets, Facebook statuses or Instagram posts as plaintext, you can get more information about them using this library.

### Twitter
```
$message = new \RichSocialMessages\Message\Tweet("My tweet with #tag1 and #tag2 and @user1 and @user2 and http://example.com");
$message->getTags();    // will return ['tag1', 'tag2']
$message->getUsers();    // will return ['user1', 'user2']
$message->getLinks();    // will return ['http://example.com']
```

### Instagram
```
$message = new \RichSocialMessages\Message\InstagramPost("My instagram post with #tag1 and #tag2 and @user1 and @user2 and http://example.com");
$message->getTags();    // will return ['tag1', 'tag2']
$message->getUsers();    // will return ['user1', 'user2']
$message->getLinks();    // will return ['http://example.com']
```

### Facebook
```
$message = new \RichSocialMessages\Message\FacebookStatus("My facebook status with Name #tag1 and #tag2 and http://example.com");
$message->getTags();    // will return ['tag1', 'tag2']
$message->getUsers();    // will return []
$message->getLinks();    // will return ['http://example.com']
```
Unfortunatelly, Facebook statuses don't contain users with some identifiers as Twitter and Instagram does (@user) so it is not possible to parse users automatically. But if you somehow know which parts of Facebook status mention Facebook users, you can identify them in second parameter of FacebookStatus constructor:
```
$message = new \RichSocialMessages\Message\FacebookStatus("My facebook status with Name #tag1 and #tag2 and http://example.com", [4 => 'my_username']);    // 4 is index of word which contains user (Name) and my_username is user's username on Faceboook
$message->getTags();    // will return ['tag1', 'tag2']
$message->getUsers();    // will return [4 => 'name_surname']
$message->getLinks();    // will return ['http://example.com']
```

## Transformation
Second part of this library allows you to create richer message from plaintext message, for example from tweet `My tweet with #tag1 and #tag2 and @user1 and @user2 and http://example.com`, you can get this: `My tweet with <a href="https://twitter.com/hashtag/tag1" target="_blank">#tag1</a> and <a href="https://twitter.com/hashtag/tag2" target="_blank">#tag2</a> and <a href="http://twitter.com/user1" target="_top">@user1</a> and <a href="http://twitter.com/user2" target="_top">@user2</a> and <a href="http://example.com" target="_blank">http://example.com</a>`

How to do it?

First you have to setup your Transformer:
```
$transformer = new \RichSocialMessages\Transformer\TwitterTransformer();
$transformer->setUserLinkTarget('_top');
$transformer->setTagLinkTarget('_blank');
$transformer->setLinkLinkTarget('_blank');
```
And then you can pass the message to the transformer:
```
$transformer->transform(new \RichSocialMessages\Message\Tweet("My tweet with #tag1 and #tag2 and @user1 and @user2 and http://example.com"));
```

The same way you can use for transforming Facebook statuses and Instagram posts. You just need to setup FacebookTransformer and InstagramTransformer instead of TwitterTransformer.

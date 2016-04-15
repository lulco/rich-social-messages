<?php

namespace RichSocialMessages\Tests\Message;

use PHPUnit_Framework_TestCase;
use RichSocialMessages\Message\Tweet;

class TweetTest extends PHPUnit_Framework_TestCase
{
    public function testSimpleTweet()
    {
        $message = new Tweet('Simple tweet with no tags and users');
        $this->assertEquals([], $message->getTags());
        $this->assertEquals([], $message->getUsers());
        $this->assertEquals([], $message->getLinks());
    }
    
    public function testTweetWithOneTag()
    {
        $message = new Tweet('Tweet with one #tag');
        $this->assertEquals(['tag'], $message->getTags());
        $this->assertEquals([], $message->getUsers());
        $this->assertEquals([], $message->getLinks());
    }
    
    public function testTweetWithWithDotAfterTag()
    {
        $message = new Tweet('Tweet with dot after #tag.');
        $this->assertEquals(['tag'], $message->getTags());
        $this->assertEquals([], $message->getUsers());
        $this->assertEquals([], $message->getLinks());
    }
    
    public function testTweetWithMoreTags()
    {
        $message = new Tweet('#Tweet with #more #tags and something at the end');
        $this->assertEquals(['Tweet', 'more', 'tags'], $message->getTags());
        $this->assertEquals([], $message->getUsers());
        $this->assertEquals([], $message->getLinks());
    }
    
    public function testTweetWithOneUser()
    {
        $message = new Tweet('Tweet with one @user');
        $this->assertEquals([], $message->getTags());
        $this->assertEquals(['user'], $message->getUsers());
        $this->assertEquals([], $message->getLinks());
    }
    
    public function testTweetWithMoreUsers()
    {
        $message = new Tweet('@user Tweet with more @user1 @user2.');
        $this->assertEquals([], $message->getTags());
        $this->assertEquals(['user', 'user1', 'user2'], $message->getUsers());
        $this->assertEquals([], $message->getLinks());
    }
    
    public function testTweetWithTagsAndUsers()
    {
        $message = new Tweet('#Tweet with @user1 and @user2.');
        $this->assertEquals(['Tweet'], $message->getTags());
        $this->assertEquals(['user1', 'user2'], $message->getUsers());
        $this->assertEquals([], $message->getLinks());
    }
    
    public function testTweetWithLinks()
    {
        $message = new Tweet('Tweet with link https://google.com');
        $this->assertEquals([], $message->getTags());
        $this->assertEquals([], $message->getUsers());
        $this->assertEquals(['https://google.com'], $message->getLinks());
    }
    
    public function testTweetWithTagsUsersAndLinks()
    {
        $message = new Tweet('#Tweet with @user1 and @user2 and http://link.com');
        $this->assertEquals(['Tweet'], $message->getTags());
        $this->assertEquals(['user1', 'user2'], $message->getUsers());
        $this->assertEquals(['http://link.com'], $message->getLinks());
    }
    
    public function testTweetWithMultipleTagsUsersAndLinks()
    {
        $message = new Tweet('Multiple #tag with @user1 http://link.com and @user1 http://link.com #tag');
        $this->assertEquals(['tag'], $message->getTags());
        $this->assertEquals(['user1'], $message->getUsers());
        $this->assertEquals(['http://link.com'], $message->getLinks());
    }
}

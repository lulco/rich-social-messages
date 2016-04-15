<?php

namespace RichSocialMessages\Tests\Message;

use PHPUnit_Framework_TestCase;
use RichSocialMessages\Message\FacebookStatus;

class FacebookStatusTest extends PHPUnit_Framework_TestCase
{
    public function testSimpleFacebookStatus()
    {
        $message = new FacebookStatus('Simple facebook status');
        $this->assertEquals([], $message->getTags());
        $this->assertEquals([], $message->getUsers());
        $this->assertEquals([], $message->getLinks());
    }
    
    public function testFacebookStatusWithOneTag()
    {
        $message = new FacebookStatus('Facebook status with one #tag');
        $this->assertEquals(['tag'], $message->getTags());
        $this->assertEquals([], $message->getUsers());
        $this->assertEquals([], $message->getLinks());
    }
    
    public function testFacebookStatusWithWithDotAfterTag()
    {
        $message = new FacebookStatus('Facebook status with dot after #tag.');
        $this->assertEquals(['tag'], $message->getTags());
        $this->assertEquals([], $message->getUsers());
        $this->assertEquals([], $message->getLinks());
    }
    
    public function testFacebookStatusWithMoreTags()
    {
        $message = new FacebookStatus('#Facebook status with #more #tags and something at the end');
        $this->assertEquals(['Facebook', 'more', 'tags'], $message->getTags());
        $this->assertEquals([], $message->getUsers());
        $this->assertEquals([], $message->getLinks());
    }
    
    public function testFacebookStatusWithOneUser()
    {
        $message = new FacebookStatus('Facebook status with one User', [4 => 'user']);
        $this->assertEquals([], $message->getTags());
        $this->assertEquals([4 => 'user'], $message->getUsers());
        $this->assertEquals([], $message->getLinks());
    }
    
    public function testFacebookStatusWithMoreWordsUser()
    {
        $message = new FacebookStatus('Facebook status with user Name Surname', [5 => 'name_surname', 6 => 'name_surname']);
        $this->assertEquals([], $message->getTags());
        $this->assertEquals(['5,6' => 'name_surname'], $message->getUsers());
        $this->assertEquals([], $message->getLinks());
    }
    
    public function testFacebookStatusWithMoreUsers()
    {
        $message = new FacebookStatus('@user facebook status with more User1 User2.', [0 => 'user', 5 => 'user1', 6 => 'user2']);
        $this->assertEquals([], $message->getTags());
        $this->assertEquals([0 => 'user', 5 => 'user1', 6 => 'user2'], $message->getUsers());
        $this->assertEquals([], $message->getLinks());
    }
    
    public function testFacebookStatusWithTagsAndUsers()
    {
        $message = new FacebookStatus('#Facebook status with User1 and User2.', [3 => 'user1', 5 => 'user2']);
        $this->assertEquals(['Facebook'], $message->getTags());
        $this->assertEquals([3 => 'user1', 5 => 'user2'], $message->getUsers());
        $this->assertEquals([], $message->getLinks());
    }
    
    public function testFacebookStatusWithLinks()
    {
        $message = new FacebookStatus('FacebookStatus with link https://google.com');
        $this->assertEquals([], $message->getTags());
        $this->assertEquals([], $message->getUsers());
        $this->assertEquals(['https://google.com'], $message->getLinks());
    }
    
    public function testFacebookStatusWithTagsUsersAndLinks()
    {
        $message = new FacebookStatus('#Facebook status with User1 and User2 and http://link.com', [3 => 'user1', 5 => 'user2']);
        $this->assertEquals(['Facebook'], $message->getTags());
        $this->assertEquals([3 => 'user1', 5 => 'user2'], $message->getUsers());
        $this->assertEquals(['http://link.com'], $message->getLinks());
    }
    
    public function testTweetWithMultipleTagsUsersAndLinks()
    {
        $message = new FacebookStatus('Multiple #tag with User1 http://link.com and User1 http://link.com #tag', [3 => 'user1', 6 => 'user1']);
        $this->assertEquals(['tag'], $message->getTags());
        $this->assertEquals(['3,6' => 'user1'], $message->getUsers());
        $this->assertEquals(['http://link.com'], $message->getLinks());
    }
}

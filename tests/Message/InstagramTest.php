<?php

namespace RichSocialMessages\Tests\Message;

use PHPUnit_Framework_TestCase;
use RichSocialMessages\Message\InstagramPost;

class InstagramPostTest extends PHPUnit_Framework_TestCase
{
    public function testSimpleInstagramPost()
    {
        $message = new InstagramPost('Simple instagram post with no tags and users');
        $this->assertEquals([], $message->getTags());
        $this->assertEquals([], $message->getUsers());
        $this->assertEquals([], $message->getLinks());
    }
    
    public function testInstagramPostWithOneTag()
    {
        $message = new InstagramPost('Instagram post with one #tag');
        $this->assertEquals(['tag'], $message->getTags());
        $this->assertEquals([], $message->getUsers());
        $this->assertEquals([], $message->getLinks());
    }
    
    public function testInstagramPostWithWithDotAfterTag()
    {
        $message = new InstagramPost('Instagram post with dot after #tag.');
        $this->assertEquals(['tag'], $message->getTags());
        $this->assertEquals([], $message->getUsers());
        $this->assertEquals([], $message->getLinks());
    }
    
    public function testInstagramPostWithMoreTags()
    {
        $message = new InstagramPost('#Instagram post with #more #tags and something at the end');
        $this->assertEquals(['Instagram', 'more', 'tags'], $message->getTags());
        $this->assertEquals([], $message->getUsers());
        $this->assertEquals([], $message->getLinks());
    }
    
    public function testInstagramPostWithOneUser()
    {
        $message = new InstagramPost('Instagram post with one @user');
        $this->assertEquals([], $message->getTags());
        $this->assertEquals(['user'], $message->getUsers());
        $this->assertEquals([], $message->getLinks());
    }
    
    public function testInstagramPostWithMoreUsers()
    {
        $message = new InstagramPost('@user Instagram post with more @user1 @user2.');
        $this->assertEquals([], $message->getTags());
        $this->assertEquals(['user', 'user1', 'user2'], $message->getUsers());
        $this->assertEquals([], $message->getLinks());
    }
    
    public function testInstagramPostWithTagsAndUsers()
    {
        $message = new InstagramPost('#Instagram post with @user1 and @user2.');
        $this->assertEquals(['Instagram'], $message->getTags());
        $this->assertEquals(['user1', 'user2'], $message->getUsers());
        $this->assertEquals([], $message->getLinks());
    }
    
    public function testInstagramPostWithLinks()
    {
        $message = new InstagramPost('Instagram post with link https://google.com');
        $this->assertEquals([], $message->getTags());
        $this->assertEquals([], $message->getUsers());
        $this->assertEquals(['https://google.com'], $message->getLinks());
    }
    
    public function testInstagramPostWithTagsUsersAndLinks()
    {
        $message = new InstagramPost('#Instagram post with @user1 and @user2 and http://link.com');
        $this->assertEquals(['Instagram'], $message->getTags());
        $this->assertEquals(['user1', 'user2'], $message->getUsers());
        $this->assertEquals(['http://link.com'], $message->getLinks());
    }
    
    public function testInstagramPostWithMultipleTagsUsersAndLinks()
    {
        $message = new InstagramPost('Multiple #tag with @user1 http://link.com and @user1 http://link.com #tag');
        $this->assertEquals(['tag'], $message->getTags());
        $this->assertEquals(['user1'], $message->getUsers());
        $this->assertEquals(['http://link.com'], $message->getLinks());
    }
}

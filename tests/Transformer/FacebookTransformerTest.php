<?php

namespace RichSocialMessages\Tests\Transformer;

use PHPUnit_Framework_TestCase;
use RichSocialMessages\Message\FacebookStatus;
use RichSocialMessages\Transformer\FacebookTransformer;

class FacebookTransformerTest extends PHPUnit_Framework_TestCase
{
    public function testSimpleFacebookStatusTransform()
    {
        $transformer = new FacebookTransformer();
        $message = new FacebookStatus('Simple tweet with no tags and users');
        $this->assertEquals('Simple tweet with no tags and users', $transformer->transform($message));
    }

    public function testTransformUserAndTagDefaultUrlsWithNoUsersSet()
    {
        $transformer = new FacebookTransformer();
        $message = new FacebookStatus('Facebook status with User and #myTag');
        $this->assertEquals('Facebook status with User and <a href="https://www.facebook.com/hashtag/myTag">#myTag</a>', $transformer->transform($message));
    }
    
    public function testTransformUserAndTagDefaultUrls()
    {
        $transformer = new FacebookTransformer();
        $message = new FacebookStatus('Facebook status with User and #myTag', [3 => 'user']);
        $this->assertEquals('Facebook status with <a href="https://www.facebook.com/user">User</a> and <a href="https://www.facebook.com/hashtag/myTag">#myTag</a>', $transformer->transform($message));
    }
    
    public function testTransformUserAndTagUrls()
    {
        $transformer = new FacebookTransformer();
        $transformer->setUserUrlPattern('http://test.com/?user=$1');
        $transformer->setUserLinkTarget('_top');
        $transformer->setTagUrlPattern('http://test.com/tag/$1');
        
        $message = new FacebookStatus('Facebook status with User and #myTag', [3 => 'user']);
        $this->assertEquals('Facebook status with <a href="http://test.com/?user=user" target="_top">User</a> and <a href="http://test.com/tag/myTag">#myTag</a>', $transformer->transform($message));
    }
    
    public function testTransformAllUrlsAndAllTargets()
    {
        $transformer = new FacebookTransformer();
        $transformer->setUserUrlPattern('http://test.com/?user=$1');
        $transformer->setTagUrlPattern('http://test.com/tag/$1');
        $transformer->setAllLinksTarget('_blank');
        
        $message = new FacebookStatus('Facebook status with Name Surname and #myTag and http://link.com/asdf Name', [3 => 'user', 4 => 'user', 9 => 'user']);
        $this->assertEquals('Facebook status with <a href="http://test.com/?user=user" target="_blank">Name</a> <a href="http://test.com/?user=user" target="_blank">Surname</a> and <a href="http://test.com/tag/myTag" target="_blank">#myTag</a> and <a href="http://link.com/asdf" target="_blank">http://link.com/asdf</a> <a href="http://test.com/?user=user" target="_blank">Name</a>', $transformer->transform($message));
    }
}

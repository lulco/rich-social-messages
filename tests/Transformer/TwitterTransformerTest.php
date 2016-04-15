<?php

namespace RichSocialMessages\Tests\Transformer;

use PHPUnit_Framework_TestCase;
use RichSocialMessages\Message\Tweet;
use RichSocialMessages\Transformer\TwitterTransformer;

class TwitterTransformerTest extends PHPUnit_Framework_TestCase
{
    public function testSimpleTweetTransform()
    {
        $transformer = new TwitterTransformer();
        $message = new Tweet('Simple tweet with no tags and users');
        $this->assertEquals('Simple tweet with no tags and users', $transformer->transform($message));
    }

    public function testTransformUserAndTagDefaultUrls()
    {
        $transformer = new TwitterTransformer();
        $message = new Tweet('Tweet with @user and #myTag');
        $this->assertEquals('Tweet with <a href="http://twitter.com/user">@user</a> and <a href="https://twitter.com/hashtag/myTag">#myTag</a>', $transformer->transform($message));
    }
    
    public function testTransformUserAndTagUrls()
    {
        $transformer = new TwitterTransformer();
        $transformer->setUserUrlPattern('http://test.com/?user=$1');
        $transformer->setUserLinkTarget('_top');
        $transformer->setTagUrlPattern('http://test.com/tag/$1');
        
        $message = new Tweet('Tweet with @user and #myTag');
        $this->assertEquals('Tweet with <a href="http://test.com/?user=user" target="_top">@user</a> and <a href="http://test.com/tag/myTag">#myTag</a>', $transformer->transform($message));
    }
    
    public function testTransformAllUrlsAndAllTargets()
    {
        $transformer = new TwitterTransformer();
        $transformer->setUserUrlPattern('http://test.com/?user=$1');
        $transformer->setTagUrlPattern('http://test.com/tag/$1');
        $transformer->setAllLinksTarget('_blank');
        
        $message = new Tweet('Tweet with @user and #myTag and http://link.com/asdf');
        $this->assertEquals('Tweet with <a href="http://test.com/?user=user" target="_blank">@user</a> and <a href="http://test.com/tag/myTag" target="_blank">#myTag</a> and <a href="http://link.com/asdf" target="_blank">http://link.com/asdf</a>', $transformer->transform($message));
    }
}

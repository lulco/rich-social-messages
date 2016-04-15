<?php

namespace RichSocialMessages\Tests\Transformer;

use PHPUnit_Framework_TestCase;
use RichSocialMessages\Message\InstagramPost;
use RichSocialMessages\Transformer\InstagramTransformer;

class InstagramTransformerTest extends PHPUnit_Framework_TestCase
{
    public function testSimpleInstagramPostTransform()
    {
        $transformer = new InstagramTransformer();
        $message = new InstagramPost('Simple instagram post with no tags and users');
        $this->assertEquals('Simple instagram post with no tags and users', $transformer->transform($message));
    }

    public function testTransformUserAndTagDefaultUrls()
    {
        $transformer = new InstagramTransformer();
        $message = new InstagramPost('Instagram post with @user and #myTag');
        $this->assertEquals('Instagram post with <a href="https://www.instagram.com/user/">@user</a> and <a href="https://www.instagram.com/explore/tags/myTag/">#myTag</a>', $transformer->transform($message));
    }
    
    public function testTransformUserAndTagUrls()
    {
        $transformer = new InstagramTransformer();
        $transformer->setUserUrlPattern('http://test.com/?user=$1');
        $transformer->setUserLinkTarget('_top');
        $transformer->setTagUrlPattern('http://test.com/tag/$1');
        
        $message = new InstagramPost('Instagram post with @user and #myTag');
        $this->assertEquals('Instagram post with <a href="http://test.com/?user=user" target="_top">@user</a> and <a href="http://test.com/tag/myTag">#myTag</a>', $transformer->transform($message));
    }
    
    public function testTransformAllUrlsAndAllTargets()
    {
        $transformer = new InstagramTransformer();
        $transformer->setUserUrlPattern('http://test.com/?user=$1');
        $transformer->setTagUrlPattern('http://test.com/tag/$1');
        $transformer->setAllLinksTarget('_blank');
        
        $message = new InstagramPost('Instagram post with @user and #myTag and http://link.com/asdf');
        $this->assertEquals('Instagram post with <a href="http://test.com/?user=user" target="_blank">@user</a> and <a href="http://test.com/tag/myTag" target="_blank">#myTag</a> and <a href="http://link.com/asdf" target="_blank">http://link.com/asdf</a>', $transformer->transform($message));
    }
}

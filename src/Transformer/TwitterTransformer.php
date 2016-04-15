<?php

namespace RichSocialMessages\Transformer;

use RichSocialMessages\Message\MessageInterface;

class TwitterTransformer extends AbstractTransformer
{
    protected $userUrlPattern = 'http://twitter.com/$1';
    
    protected $tagUrlPattern = 'https://twitter.com/hashtag/$1';
    
    /**
     * {@inheritdoc}
     */
    public function transform(MessageInterface $message)
    {
        $text = $this->transformLinks($message->getMessage());
        
        $replacement = '<a href="' . $this->userUrlPattern . '"' . ($this->userLinkTarget ? ' target="' . $this->userLinkTarget . '"' : '') . '>@$1</a>';
        $text = preg_replace('/@(\w+)/', $replacement, $text);
        
        $replacement = '<a href="' . $this->tagUrlPattern . '"' . ($this->tagLinkTarget ? ' target="' . $this->tagLinkTarget . '"' : '') . '>#$1</a>';
        $text = preg_replace('/#(\w+)/', $replacement, $text);
        
        return $text;
    }
}

<?php

namespace RichSocialMessages\Transformer;

use RichSocialMessages\Message\MessageInterface;

class FacebookTransformer extends AbstractTransformer
{
    protected $userUrlPattern = 'https://www.facebook.com/$1';
    
    protected $tagUrlPattern = 'https://www.facebook.com/hashtag/$1';
    
    /**
     * {@inheritdoc}
     */
    public function transform(MessageInterface $message)
    {
        $text = $this->transformUsers($message);
        
        $replacement = '<a href="' . $this->tagUrlPattern . '"' . ($this->tagLinkTarget ? ' target="' . $this->tagLinkTarget . '"' : '') . '>#$1</a>';
        $text = preg_replace('/#(\w+)/', $replacement, $text);

        $text = $this->transformLinks($text);
        
        return $text;
    }
    
    private function transformUsers(MessageInterface $message)
    {
        $text = $message->getMessage();
        if (!$message->getUsers()) {
            return $text;
        }
        $words = explode(' ', $text);
        foreach ($message->getUsers() as $indexes => $user) {
            foreach (explode(',', $indexes) as $index) {
                if (isset($words[$index])) {
                    $words[$index] = '<a href="' . str_replace('$1', $user, $this->userUrlPattern) . '"' . ($this->userLinkTarget ? ' target="' . $this->userLinkTarget . '"' : '') . '>' . $words[$index] . '</a>';
                }
            }
        }
        return implode(' ', $words);
    }
}

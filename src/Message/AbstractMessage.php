<?php

namespace RichSocialMessages\Message;

abstract class AbstractMessage implements MessageInterface
{
    protected $message;
    
    protected $tags;
    
    protected $users;
    
    protected $links;
    
    public function __construct($message)
    {
        $this->message = $message;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getMessage()
    {
        return $this->message;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getTags()
    {
        if ($this->tags === null) {
            preg_match_all('/#(\w+)/', $this->message, $matches);
            $this->tags = isset($matches[1]) ? array_unique($matches[1]) : [];
        }
        return $this->tags;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getLinks()
    {
        if ($this->links === null) {
            preg_match_all('@(https?://([-\w\.]+)+(/([\w/_\.]*(\?\S+)?(#\S+)?)?)?)@', $this->message, $matches);
            $this->links = isset($matches[1]) ? array_unique($matches[1]) : [];
        }
        return $this->links;
    }
}

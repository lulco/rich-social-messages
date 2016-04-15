<?php

namespace RichSocialMessages\Message;

class Tweet extends AbstractMessage
{
    /**
     * {@inheritdoc}
     */
    public function getUsers()
    {
        if ($this->users === null) {
            preg_match_all('/@(\w+)/', $this->message, $matches);
            $this->users = isset($matches[1]) ? array_unique($matches[1]) : [];
        }
        return $this->users;
    }
}

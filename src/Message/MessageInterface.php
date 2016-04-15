<?php

namespace RichSocialMessages\Message;

interface MessageInterface
{
    /**
     * @return string original message text
     */
    public function getMessage();
    
    /**
     * @return array list of tags used in message
     */
    public function getTags();
    
    /**
     * @return array list of users used in message
     */
    public function getUsers();
    
    /**
     * @return array list of links used in message
     */
    public function getLinks();
}

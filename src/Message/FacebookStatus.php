<?php

namespace RichSocialMessages\Message;

class FacebookStatus extends AbstractMessage
{
    private $facebookUsers = [];
    
    public function __construct($message, array $users = [])
    {
        parent::__construct($message);
        $this->facebookUsers = $users;
    }

    /**
     * {@inheritdoc}
     */
    public function getUsers()
    {
        $users = [];
        if ($this->users === null) {
            foreach ($this->facebookUsers as $index => $facebookUser) {
                $users[$facebookUser][] = $index;
            }
            $this->users = [];
            foreach ($users as $user => $indexes) {
                $this->users[implode(',', $indexes)] = $user;
            }
        }
        return $this->users;
    }
}

<?php

namespace RichSocialMessages\Transformer;

use RichSocialMessages\Message\MessageInterface;

interface TransformerInterface
{
    /**
     * transforms text from message, replace users, tags and links with <a> elements
     * @param MessageInterface $message
     */
    public function transform(MessageInterface $message);
}

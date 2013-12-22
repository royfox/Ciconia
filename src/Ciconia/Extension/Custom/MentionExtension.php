<?php

namespace Ciconia\Extension\Custom;

use Ciconia\Common\Text;
use Ciconia\Extension\ExtensionInterface;
use Router;

class MentionExtension implements ExtensionInterface
{

    /**
     * {@inheritdoc}
     */
    public function register(\Ciconia\Markdown $markdown)
    {
        $markdown->on('inline', [$this, 'processMentions']);
    }

    /**
     * @param Text $text
     */
    public function processMentions(Text $text)
    {
        // Turn @username into [@username](http://example.com/user/username)
        $text->replace('/(?:^|[^a-zA-Z0-9.])@([A-Za-z]+[A-Za-z0-9]+)/', function (Text $w, Text $username) {
            return ' [@' . $username . ']('.Router::url('/', true).'users/handle/' . $username . ')';
        });
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'mention';
    }
}
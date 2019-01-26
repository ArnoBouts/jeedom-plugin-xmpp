<?php

namespace Norgul\Xmpp\Xml\Stanzas;

use Norgul\Xmpp\Xml\AbstractXml;

class Message extends AbstractXml
{
    protected $xmlRootName = 'message';

    public function sendMessage(string $body, string $to, string $type = "chat")
    {
        $root = $this->instance->createElement($this->xmlRootName);
        $root->setAttribute('to', $to);
        $root->setAttribute('type', $type);

        $bodyNode = $this->instance->createElement('body', $body);
        $root->appendChild($bodyNode);

        return $this->instance->saveXML($root);
    }
}
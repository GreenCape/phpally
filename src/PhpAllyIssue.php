<?php

namespace CidiLabs\PhpAlly;

use DOMElement;

class PhpAllyIssue implements \JsonSerializable {
    protected $ruleId;
    protected $type;
    protected $element;
    protected $previewElement;

    public function __construct($ruleId, $type, DOMElement $element, DOMElement $previewElement = null)
    {
        $this->ruleId = $ruleId;
        $this->type = $type;
        $this->element = $element;

        if (!empty($previewElement)) {
            $this->previewElement = $previewElement;
        }
        else {
            $this->previewElement = $this->element->parentNode;        
        }
    }

    public function getElement()
    {
        return $this->element;
    }

    public function getPreviewElement()
    {
        return $this->previewElement;
    }

    public function getRuleId() 
    {
        return $this->ruleId;
    }

    public function getHtml()
    {
        return $this->element->ownerDocument->saveXML($this->element);
    }

    public function getPreview()
    {
        return $this->element->ownerDocument->saveXML($this->previewElement);
    }

    public function getType()
    {
        return $this->type;
    }

    public function toArray()
    {
        return [
            'ruleId' => $this->ruleId,
            'type' => $this->type,
            'html' => $this->getHtml(),
            'preview' => $this->getPreview(),
        ];
    }
    
    public function __toString()
    {
        return \json_encode($this->toArray());
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
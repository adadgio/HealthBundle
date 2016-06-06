<?php

namespace Adadgio\HealthBundle\Component\CIM10;

use Symfony\Component\DomCrawler\Crawler;
use Adadgio\HealthBundle\Component\CIM10\CIM10Tree;

class CIM10ClamParser
{
    const TREE = true;
    const JSON = true;
    const CIM10_CODE = true;

    private $items;

    public function __construct($xmlClam)
    {
        $this->items = array();

        $crawler = new Crawler($xmlClam);
        $crawler = $crawler->filterXPath('//*/Class');

        foreach ($crawler as $domElement) {
            // find node code
            $code = $domElement->getAttribute('code');
            // find the node label
            $label = $domElement->getElementsByTagName('Rubric')->item(0)->getElementsByTagName('Label')->item(0)->nodeValue;

            // get parent code...
            $parentElement = $domElement->getElementsByTagName('SuperClass')->item(0);
            if (null !== $parentElement) {
                $parent = $parentElement->getAttribute('code');
            } else {
                $parent = null;
            }

            $this->items[$code] = array(
                'code' => $code,
                'parent' => $parent,
                'label' => $label,
            );
        }
    }

    public function getItems($tree = false, $json = false)
    {
        if ($tree === static::TREE) {
            $tree = new CIM10Tree($this->items);
            $this->items = $tree->getTree();
        }
        
        if ($json === static::JSON) {
            return json_encode($this->items);
        } else {
            return $this->items;
        }
    }
}

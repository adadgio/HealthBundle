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

            // find the node label <Rubric ... kind="preferred">
            $rubricElements = $domElement->getElementsByTagName('Rubric');

            $label = null;
            $definition = null;
            $inclusions = array();
            
            foreach ($rubricElements as $rubricNode) {
                $kind = $rubricNode->getAttribute('kind');

                if ($kind === 'preferred') {

                    $labelNode = $rubricNode->getElementsByTagName('Label')->item(0);
                    $label = $labelNode->nodeValue;

                } else if ($kind === 'inclusion') {

                    $fragmentNodes = $rubricNode->getElementsByTagName('Label');
                    // <Fragment ...> tags do not always exist ! only when related to another code.
                    // $fragA = $fragmentNodes->item(0)->nodeValue;
                    // $fragB = $fragmentNodes->item(1)->nodeValue;
                    $inclusions[] = array(
                        'label' => $fragmentNodes->item(0)->nodeValue
                    );

                } else if ($kind === 'definition') {

                    $definitionNodes = $rubricNode->getElementsByTagName('Label');
                    $definition = $definitionNodes->item(0)->nodeValue;

                } else {
                    // unhandled kind...
                }
            }

            // find parent code...
            $parentElement = $domElement->getElementsByTagName('SuperClass')->item(0);

            if (null !== $parentElement) {
                $parent = $parentElement->getAttribute('code');
            } else {
                $parent = null;
            }

            $this->items[$code] = array(
                'code'   => $code,
                'parent' => $parent,
                'label'  => $label,
                'inclusions' => $inclusions,
                'definition' => $definition,
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

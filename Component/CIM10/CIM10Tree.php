<?php

namespace Adadgio\HealthBundle\Component\CIM10;

class CIM10Tree
{
    public function __construct(array $items = array())
    {
        $this->tree = $this->map($items);
    }

    public function getTree()
    {
        return $this->tree;
    }

    public function map(array $items = array(), $parent = null)
    {
        $tree = array();
        foreach ($items as $k => $item) {
            if ($item['parent'] !== $parent) {
                continue;
            }

            $item['children'] = array();
            $item['children'] = $this->map($items, $k);

            $tree[$k] = $item;
        }
        
        // asort($tree);
        return array_values($tree);
    }
}

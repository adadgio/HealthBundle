<?php

namespace Adadgio\HealthBundle\Component\CIM10;

/**
 * An object representing the official OMS CIM-10
 * classification. Also known as ICD-10.
 *
 * Official source {@link http://apps.who.int/classifications/icd10/browse/2008/fr#/XXII}
 * CSV source example {@link http://www.santepublique.eu/telecharger-cim10-francai/}
 * @todo Move to a different namespace
 */
class CIM10Code
{
    /**
     * @var string CIM 10 official code
     */
    private $code;

    /**
     * @var string The label (label) to be translated
     */
    private $label;

    /**
     * Get code.
     *
     * @return string CIM 10 official code
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set code.
     *
     * @param  string CIM 10 official code
     * @return object \CIM10Code
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get label.
     *
     * @return string CIM 10 label
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set label.
     *
     * @param  string CIM 10 label
     * @return object \CIM10Code
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Applies a callback on each word and return the result.
     *
     * @param  function Callback function
     * @return array Words after callback did something
     */
    public function foreachWord($callback)
    {
        $result = array();
        $words = explode(' ', $this->label);

        // remove words less the 3 chars (3 included)
        $words = array_filter($words, function ($word) {
            return (strlen($word) >= 3);
        });

        foreach ($words as $word) {
            $result[] = $callback($word);
        }

        return $result;
    }
}

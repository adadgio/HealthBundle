<?php

namespace Adadgio\HealthBundle;

/**
 * An object representing the official OMS CIM-10
 * classification. Also known as ICD-10.
 * 
 * Official source {@link http://apps.who.int/classifications/icd10/browse/2008/fr#/XXII}
 * CSV source example {@link http://www.santepublique.eu/telecharger-cim10-francai/}
 */
class CIM10Code
{
    /**
     * @var string CIM 10 official code
     */
    private $code;

    /**
     * @var string The slug (label) to be translated
     */
    private $slug;

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
        return $this->code;
    }

    /**
     * Get slug.
     *
     * @return string CIM 10 label
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set slug.
     *
     * @param  string CIM 10 label
     * @return object \CIM10Code
     */
    public function setSlug($slug)
    {
        return $this->slug;
    }
}

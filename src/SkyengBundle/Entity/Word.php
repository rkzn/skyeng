<?php

namespace SkyengBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Word
 */
class Word
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $eng;

    /**
     * @var string
     */
    private $rus;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set eng
     *
     * @param string $eng
     * @return Word
     */
    public function setEng($eng)
    {
        $this->eng = $eng;

        return $this;
    }

    /**
     * Get eng
     *
     * @return string 
     */
    public function getEng()
    {
        return $this->eng;
    }

    /**
     * Set rus
     *
     * @param string $rus
     * @return Word
     */
    public function setRus($rus)
    {
        $this->rus = $rus;

        return $this;
    }

    /**
     * Get rus
     *
     * @return string 
     */
    public function getRus()
    {
        return $this->rus;
    }
}

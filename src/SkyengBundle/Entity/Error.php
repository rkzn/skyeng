<?php

namespace SkyengBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Error
 */
class Error
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $answer;

    /**
     * @var integer
     */
    private $quantity = 0;

    /**
     * @var \SkyengBundle\Entity\Word
     */
    private $word;


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
     * Set answer
     *
     * @param string $answer
     * @return Error
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;

        return $this;
    }

    /**
     * Get answer
     *
     * @return string 
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     * @return Error
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set word
     *
     * @param \SkyengBundle\Entity\Word $word
     * @return Error
     */
    public function setWord(\SkyengBundle\Entity\Word $word = null)
    {
        $this->word = $word;

        return $this;
    }

    /**
     * Get word
     *
     * @return \SkyengBundle\Entity\Word 
     */
    public function getWord()
    {
        return $this->word;
    }
}

<?php

namespace Foggyline\PaymentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Card
 *
 * @ORM\Table(name="card")
 * @ORM\Entity(repositoryClass="Foggyline\PaymentBundle\Repository\CardRepository")
 */
class Card
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="card_type", type="string", length=255)
     */
    private $cardType;

    /**
     * @var string
     *
     * @ORM\Column(name="card_number", type="string", length=255)
     */
    private $cardNumber;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expiry_date", type="date")
     */
    private $expiryDate;

    /**
     * @var string
     *
     * @ORM\Column(name="security_code", type="string", length=255)
     */
    private $securityCode;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set cardType
     *
     * @param string $cardType
     *
     * @return Card
     */
    public function setCardType($cardType)
    {
        $this->cardType = $cardType;

        return $this;
    }

    /**
     * Get cardType
     *
     * @return string
     */
    public function getCardType()
    {
        return $this->cardType;
    }

    /**
     * Set cardNumber
     *
     * @param string $cardNumber
     *
     * @return Card
     */
    public function setCardNumber($cardNumber)
    {
        $this->cardNumber = $cardNumber;

        return $this;
    }

    /**
     * Get cardNumber
     *
     * @return string
     */
    public function getCardNumber()
    {
        return $this->cardNumber;
    }

    /**
     * Set expiryDate
     *
     * @param \DateTime $expiryDate
     *
     * @return Card
     */
    public function setExpiryDate($expiryDate)
    {
        $this->expiryDate = $expiryDate;

        return $this;
    }

    /**
     * Get expiryDate
     *
     * @return \DateTime
     */
    public function getExpiryDate()
    {
        return $this->expiryDate;
    }

    /**
     * Set securityCode
     *
     * @param string $securityCode
     *
     * @return Card
     */
    public function setSecurityCode($securityCode)
    {
        $this->securityCode = $securityCode;

        return $this;
    }

    /**
     * Get securityCode
     *
     * @return string
     */
    public function getSecurityCode()
    {
        return $this->securityCode;
    }
}


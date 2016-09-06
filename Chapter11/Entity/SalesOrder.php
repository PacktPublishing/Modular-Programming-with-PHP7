<?php

namespace Foggyline\SalesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SalesOrder
 *
 * @ORM\Table(name="sales_order")
 * @ORM\Entity(repositoryClass="Foggyline\SalesBundle\Repository\SalesOrderRepository")
 */
class SalesOrder
{
    const STATUS_PROCESSING = 'processing';
    const STATUS_COMPLETE = 'complete';
    const STATUS_CANCELED = 'canceled';
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Foggyline\CustomerBundle\Entity\Customer")
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     */
    private $customer;

    /**
     * @var string
     *
     * @ORM\Column(name="items_price", type="decimal", precision=10, scale=4)
     */
    private $itemsPrice;

    /**
     * @var string
     *
     * @ORM\Column(name="shipment_price", type="decimal", precision=10, scale=4)
     */
    private $shipmentPrice;

    /**
     * @var string
     *
     * @ORM\Column(name="total_price", type="decimal", precision=10, scale=4)
     */
    private $totalPrice;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="payment_method", type="string", length=255)
     */
    private $paymentMethod;

    /**
     * @var string
     *
     * @ORM\Column(name="shipment_method", type="string", length=255)
     */
    private $shipmentMethod;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modified_at", type="datetime")
     */
    private $modifiedAt;

    /**
     * @var string
     *
     * @ORM\Column(name="customer_email", type="string", length=255)
     */
    private $customerEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="customer_first_name", type="string", length=255)
     */
    private $customerFirstName;

    /**
     * @var string
     *
     * @ORM\Column(name="customer_last_name", type="string", length=255)
     */
    private $customerLastName;

    /**
     * @var string
     *
     * @ORM\Column(name="address_first_name", type="string", length=255)
     */
    private $addressFirstName;

    /**
     * @var string
     *
     * @ORM\Column(name="address_last_name", type="string", length=255)
     */
    private $addressLastName;

    /**
     * @var string
     *
     * @ORM\Column(name="address_country", type="string", length=255)
     */
    private $addressCountry;

    /**
     * @var string
     *
     * @ORM\Column(name="address_state", type="string", length=255, nullable=true)
     */
    private $addressState;

    /**
     * @var string
     *
     * @ORM\Column(name="address_city", type="string", length=255)
     */
    private $addressCity;

    /**
     * @var string
     *
     * @ORM\Column(name="address_postcode", type="string", length=255)
     */
    private $addressPostcode;

    /**
     * @var string
     *
     * @ORM\Column(name="address_street", type="string", length=255)
     */
    private $addressStreet;

    /**
     * @var string
     *
     * @ORM\Column(name="address_telephone", type="string", length=255)
     */
    private $addressTelephone;

    /**
     * @ORM\OneToMany(targetEntity="SalesOrderItem", mappedBy="salesOrder")
     */
    private $items;

    public function __construct() {
        $this->items = new \Doctrine\Common\Collections\ArrayCollection();
    }


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
     * Set customer
     *
     * @param integer $customer
     *
     * @return SalesOrder
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return int
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set itemsPrice
     *
     * @param string $itemsPrice
     *
     * @return SalesOrder
     */
    public function setItemsPrice($itemsPrice)
    {
        $this->itemsPrice = $itemsPrice;

        return $this;
    }

    /**
     * Get itemsPrice
     *
     * @return string
     */
    public function getItemsPrice()
    {
        return $this->itemsPrice;
    }

    /**
     * Set shipmentPrice
     *
     * @param string $shipmentPrice
     *
     * @return SalesOrder
     */
    public function setShipmentPrice($shipmentPrice)
    {
        $this->shipmentPrice = $shipmentPrice;

        return $this;
    }

    /**
     * Get shipmentPrice
     *
     * @return string
     */
    public function getShipmentPrice()
    {
        return $this->shipmentPrice;
    }

    /**
     * Set totalPrice
     *
     * @param string $totalPrice
     *
     * @return SalesOrder
     */
    public function setTotalPrice($totalPrice)
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    /**
     * Get totalPrice
     *
     * @return string
     */
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Set paymentMethod
     *
     * @param string $paymentMethod
     *
     * @return SalesOrder
     */
    public function setPaymentMethod($paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

    /**
     * Get paymentMethod
     *
     * @return string
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * Set shipmentMethod
     *
     * @param string $shipmentMethod
     *
     * @return SalesOrder
     */
    public function setShipmentMethod($shipmentMethod)
    {
        $this->shipmentMethod = $shipmentMethod;

        return $this;
    }

    /**
     * Get shipmentMethod
     *
     * @return string
     */
    public function getShipmentMethod()
    {
        return $this->shipmentMethod;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return SalesOrder
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set modifiedAt
     *
     * @param \DateTime $modifiedAt
     *
     * @return SalesOrder
     */
    public function setModifiedAt($modifiedAt)
    {
        $this->modifiedAt = $modifiedAt;

        return $this;
    }

    /**
     * Get modifiedAt
     *
     * @return \DateTime
     */
    public function getModifiedAt()
    {
        return $this->modifiedAt;
    }

    /**
     * Set customerEmail
     *
     * @param string $customerEmail
     *
     * @return SalesOrder
     */
    public function setCustomerEmail($customerEmail)
    {
        $this->customerEmail = $customerEmail;

        return $this;
    }

    /**
     * Get customerEmail
     *
     * @return string
     */
    public function getCustomerEmail()
    {
        return $this->customerEmail;
    }

    /**
     * Set customerFirstName
     *
     * @param string $customerFirstName
     *
     * @return SalesOrder
     */
    public function setCustomerFirstName($customerFirstName)
    {
        $this->customerFirstName = $customerFirstName;

        return $this;
    }

    /**
     * Get customerFirstName
     *
     * @return string
     */
    public function getCustomerFirstName()
    {
        return $this->customerFirstName;
    }

    /**
     * Set customerLastName
     *
     * @param string $customerLastName
     *
     * @return SalesOrder
     */
    public function setCustomerLastName($customerLastName)
    {
        $this->customerLastName = $customerLastName;

        return $this;
    }

    /**
     * Get customerLastName
     *
     * @return string
     */
    public function getCustomerLastName()
    {
        return $this->customerLastName;
    }

    /**
     * Set addressFirstName
     *
     * @param string $addressFirstName
     *
     * @return SalesOrder
     */
    public function setAddressFirstName($addressFirstName)
    {
        $this->addressFirstName = $addressFirstName;

        return $this;
    }

    /**
     * Get addressFirstName
     *
     * @return string
     */
    public function getAddressFirstName()
    {
        return $this->addressFirstName;
    }

    /**
     * Set addressLastName
     *
     * @param string $addressLastName
     *
     * @return SalesOrder
     */
    public function setAddressLastName($addressLastName)
    {
        $this->addressLastName = $addressLastName;

        return $this;
    }

    /**
     * Get addressLastName
     *
     * @return string
     */
    public function getAddressLastName()
    {
        return $this->addressLastName;
    }

    /**
     * Set addressCountry
     *
     * @param string $addressCountry
     *
     * @return SalesOrder
     */
    public function setAddressCountry($addressCountry)
    {
        $this->addressCountry = $addressCountry;

        return $this;
    }

    /**
     * Get addressCountry
     *
     * @return string
     */
    public function getAddressCountry()
    {
        return $this->addressCountry;
    }

    /**
     * Set addressState
     *
     * @param string $addressState
     *
     * @return SalesOrder
     */
    public function setAddressState($addressState)
    {
        $this->addressState = $addressState;

        return $this;
    }

    /**
     * Get addressState
     *
     * @return string
     */
    public function getAddressState()
    {
        return $this->addressState;
    }

    /**
     * Set addressCity
     *
     * @param string $addressCity
     *
     * @return SalesOrder
     */
    public function setAddressCity($addressCity)
    {
        $this->addressCity = $addressCity;

        return $this;
    }

    /**
     * Get addressCity
     *
     * @return string
     */
    public function getAddressCity()
    {
        return $this->addressCity;
    }

    /**
     * Set addressPostcode
     *
     * @param string $addressPostcode
     *
     * @return SalesOrder
     */
    public function setAddressPostcode($addressPostcode)
    {
        $this->addressPostcode = $addressPostcode;

        return $this;
    }

    /**
     * Get addressPostcode
     *
     * @return string
     */
    public function getAddressPostcode()
    {
        return $this->addressPostcode;
    }

    /**
     * Set addressStreet
     *
     * @param string $addressStreet
     *
     * @return SalesOrder
     */
    public function setAddressStreet($addressStreet)
    {
        $this->addressStreet = $addressStreet;

        return $this;
    }

    /**
     * Get addressStreet
     *
     * @return string
     */
    public function getAddressStreet()
    {
        return $this->addressStreet;
    }

    /**
     * Set addressTelephone
     *
     * @param string $addressTelephone
     *
     * @return SalesOrder
     */
    public function setAddressTelephone($addressTelephone)
    {
        $this->addressTelephone = $addressTelephone;

        return $this;
    }

    /**
     * Get addressTelephone
     *
     * @return string
     */
    public function getAddressTelephone()
    {
        return $this->addressTelephone;
    }
}


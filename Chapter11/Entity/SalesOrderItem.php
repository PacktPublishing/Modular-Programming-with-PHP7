<?php

namespace Foggyline\SalesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SalesOrderItem
 *
 * @ORM\Table(name="sales_order_item")
 * @ORM\Entity(repositoryClass="Foggyline\SalesBundle\Repository\SalesOrderItemRepository")
 */
class SalesOrderItem
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
     * @ORM\ManyToOne(targetEntity="SalesOrder", inversedBy="items")
     * @ORM\JoinColumn(name="sales_order_id", referencedColumnName="id")
     */
    private $salesOrder;

    /**
     * @ORM\ManyToOne(targetEntity="Foggyline\CatalogBundle\Entity\Product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private $product;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var int
     *
     * @ORM\Column(name="qty", type="integer")
     */
    private $qty;

    /**
     * @var string
     *
     * @ORM\Column(name="unit_price", type="decimal", precision=10, scale=4)
     */
    private $unitPrice;

    /**
     * @var string
     *
     * @ORM\Column(name="total_price", type="decimal", precision=10, scale=4)
     */
    private $totalPrice;

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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set salesOrder
     *
     * @param integer $salesOrder
     *
     * @return SalesOrderItem
     */
    public function setSalesOrder($salesOrder)
    {
        $this->salesOrder = $salesOrder;

        return $this;
    }

    /**
     * Get salesOrder
     *
     * @return int
     */
    public function getSalesOrder()
    {
        return $this->salesOrder;
    }

    /**
     * Set product
     *
     * @param integer $product
     *
     * @return SalesOrderItem
     */
    public function setProduct($product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return int
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return SalesOrderItem
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set qty
     *
     * @param integer $qty
     *
     * @return SalesOrderItem
     */
    public function setQty($qty)
    {
        $this->qty = $qty;

        return $this;
    }

    /**
     * Get qty
     *
     * @return int
     */
    public function getQty()
    {
        return $this->qty;
    }

    /**
     * Set unitPrice
     *
     * @param string $unitPrice
     *
     * @return SalesOrderItem
     */
    public function setUnitPrice($unitPrice)
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }

    /**
     * Get unitPrice
     *
     * @return string
     */
    public function getUnitPrice()
    {
        return $this->unitPrice;
    }

    /**
     * Set totalPrice
     *
     * @param string $totalPrice
     *
     * @return SalesOrderItem
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return SalesOrderItem
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
     * @return SalesOrderItem
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
}


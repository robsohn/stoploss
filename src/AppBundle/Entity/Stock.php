<?php
/**
 * Created by PhpStorm.
 * User: rraszczynski
 * Date: 15/12/15
 * Time: 12:59
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="stock")
 */
class Stock
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=16)
     */
    private $code;

    /**
     * @var decimal
     *
     * @ORM\Column(name="price", type="decimal", precision=4, scale=2)
     */
    private $price;

    /**
     * @var decimal
     *
     * @ORM\Column(name="stop_loss_price", type="decimal", precision=4, scale=2)
     */
    private $stopLossPrice;

    /**
     * @var integer
     *
     * @ORM\Column(name="stop_loss_margin", type="integer")
     */
    private $stopLossMargin;

    /**
     * @var decimal
     *
     * @ORM\Column(name="stop_loss__base", type="decimal", precision=4, scale=2)
     */
    private $stopLossBase;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * Set code
     *
     * @param string $code
     *
     * @return Stock
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set stopLossPrice
     *
     * @param string $stopLossPrice
     *
     * @return Stock
     */
    public function setStopLossPrice($stopLossPrice)
    {
        $this->stopLossPrice = $stopLossPrice;

        return $this;
    }

    /**
     * Get stopLossPrice
     *
     * @return string
     */
    public function getStopLossPrice()
    {
        return $this->stopLossPrice;
    }

    public function setUpdatedAt()
    {
        // WILL be saved in the database
        $this->updatedAt = new \DateTime("now");
    }

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
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Stock
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set stopLossMargin
     *
     * @param integer $stopLossMargin
     *
     * @return Stock
     */
    public function setStopLossMargin($stopLossMargin)
    {
        $this->stopLossMargin = $stopLossMargin;

        return $this;
    }

    /**
     * Get stopLossMargin
     *
     * @return integer
     */
    public function getStopLossMargin()
    {
        return $this->stopLossMargin;
    }

    /**
     * Set stopLossBase
     *
     * @param string $stopLossBase
     *
     * @return Stock
     */
    public function setStopLossBase($stopLossBase)
    {
        $this->stopLossBase = $stopLossBase;

        return $this;
    }

    /**
     * Get stopLossBase
     *
     * @return string
     */
    public function getStopLossBase()
    {
        return $this->stopLossBase;
    }

    public function increaseStopLoss($price)
    {
        $this->setStopLossBase($price);
        $stopLoss = $price - ($price * ($this->getStopLossMargin()/100));
        $this->setStopLossPrice($stopLoss);
    }
}

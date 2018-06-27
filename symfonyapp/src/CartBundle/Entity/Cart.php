<?php

namespace CartBundle\Entity;

class Cart
{
    /**
     * @var array
     */
    private $products;

    /**
     * @var array
     */
    private $quantity = [];

    /**
     * @var int
     */
    private $total = 0;

    public function addProduct(Product $product, $quantity = 1)
    {
        if ($quantity<1){
            throw new \Exception('quantity less than 1');
            
        }
        if ($this->hasProduct($product)){
            $this->setProduct($product);
    }
        $this->setQuantity($product, $quantity);

        return $this;
    }
    /**
     * @param Product $product
     * @param int $quantity
     * @return $this
     */
    public function setQuantity(Product $product, int $quantity)
    {
        $this->quantity[$product->getId()] +=$quantity;
        return $this;
    }

    /**
     * @param Product $product
     * @return $this
     */
    public function setProduct(Product $product)
    {
    $this->products[$product->getId()] = $product;
    $this->quantity[$product->getId()] = 0;

    return $this;
    }
    /**
     * @param Product $product
     * @return bool
     */
    public function hasProduct(Product $product)
    {
        return isset($this->products[$product->getId()]);
    }
    /**
     * @return array
     */
    public function getProducts()
    {
        return $this->products;
    }


    /**
     * @return array
     */
    public function getQuantity()
    {
        return $this->quantity;
    }


    /**
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param int $total
     * @return Cart
     */
    public function setTotal($total)
    {
        $this->total = $total;
        return $this;
    }


}
<?php declare(strict_types=1);

namespace MaxT\MaxTLoyaltyProgram\Core\Checkout\Order\Aggregate\OrderPoint;

use Shopware\Core\Checkout\Customer\CustomerEntity;
use Shopware\Core\Checkout\Order\OrderEntity;
use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;

class OrderPointEntity extends Entity
{
    use EntityIdTrait;

    /**
     * @var string
     */
    protected string $orderId;

    /**
     * @var string
     */
    protected string $customerId;

    /**
     * @var int
     */
    protected int $pointsEarned;

    /**
     * @var OrderEntity
     */
    protected OrderEntity $order;

    /**
     * @var CustomerEntity
     */
    protected CustomerEntity $customer;

    /**
     * @return string
     */
    public function getOrderId(): string
    {
        return $this->orderId;
    }

    /**
     * @param string $orderId
     */
    public function setOrderId(string $orderId): void
    {
        $this->orderId = $orderId;
    }

    /**
     * @return string
     */
    public function getCustomerId(): string
    {
        return $this->customerId;
    }

    /**
     * @param string $customerId
     */
    public function setCustomerId(string $customerId): void
    {
        $this->customerId = $customerId;
    }

    /**
     * @return int
     */
    public function getPointsEarned(): int
    {
        return $this->pointsEarned;
    }

    /**
     * @param int $pointsEarned
     */
    public function setPointsEarned(int $pointsEarned): void
    {
        $this->pointsEarned = $pointsEarned;
    }

    /**
     * @return OrderEntity
     */
    public function getOrder(): OrderEntity
    {
        return $this->order;
    }

    /**
     * @param OrderEntity $order
     */
    public function setOrder(OrderEntity $order): void
    {
        $this->order = $order;
    }

    /**
     * @return CustomerEntity
     */
    public function getCustomer(): CustomerEntity
    {
        return $this->customer;
    }

    /**
     * @param CustomerEntity $customer
     */
    public function setCustomer(CustomerEntity $customer): void
    {
        $this->customer = $customer;
    }
}

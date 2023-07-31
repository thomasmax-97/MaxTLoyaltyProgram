<?php declare(strict_types=1);

namespace MaxT\MaxTLoyaltyProgram\Core\Content\Product\Aggregate\ProductReviewPoint;

use Shopware\Core\Checkout\Customer\CustomerEntity;
use Shopware\Core\Content\Product\Aggregate\ProductReview\ProductReviewEntity;
use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;

class ProductReviewPointEntity extends Entity
{
    use EntityIdTrait;

    /**
     * @var string
     */
    protected string $productReviewId;

    /**
     * @var string
     */
    protected string $customerId;

    /**
     * @var int
     */
    protected int $pointsEarned;

    /**
     * @var ProductReviewEntity
     */
    protected ProductReviewEntity $productReview;

    /**
     * @var CustomerEntity
     */
    protected CustomerEntity $customer;

    /**
     * @return string
     */
    public function getProductReviewId(): string
    {
        return $this->productReviewId;
    }

    /**
     * @param string $productReviewId
     */
    public function setProductReviewId(string $productReviewId): void
    {
        $this->productReviewId = $productReviewId;
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
     * @return ProductReviewEntity
     */
    public function getProductReview(): ProductReviewEntity
    {
        return $this->productReview;
    }

    /**
     * @param ProductReviewEntity $productReview
     */
    public function setProductReview(ProductReviewEntity $productReview): void
    {
        $this->productReview = $productReview;
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

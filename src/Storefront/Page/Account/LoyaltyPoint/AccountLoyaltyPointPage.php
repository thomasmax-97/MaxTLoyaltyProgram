<?php declare(strict_types=1);

namespace MaxT\MaxTLoyaltyProgram\Storefront\Page\Account\LoyaltyPoint;

use Shopware\Storefront\Page\Page;

class AccountLoyaltyPointPage extends Page
{
    /**
     * @var int
     */
    private int $orderPointsTotal;

    /**
     * @var int
     */
    private int $reviewPointsTotal;

    /**
     * @var int
     */
    private int $pointsTotal;

    /**
     * @return int
     */
    public function getOrderPointsTotal(): int
    {
        return $this->orderPointsTotal;
    }

    /**
     * @param int $orderPointsTotal
     */
    public function setOrderPointsTotal(int $orderPointsTotal): void
    {
        $this->orderPointsTotal = $orderPointsTotal;
    }

    /**
     * @return int
     */
    public function getReviewPointsTotal(): int
    {
        return $this->reviewPointsTotal;
    }

    /**
     * @param int $reviewPointsTotal
     */
    public function setReviewPointsTotal(int $reviewPointsTotal): void
    {
        $this->reviewPointsTotal = $reviewPointsTotal;
    }

    /**
     * @return int
     */
    public function getPointsTotal(): int
    {
        return $this->pointsTotal;
    }

    /**
     * @param int $pointsTotal
     */
    public function setPointsTotal(int $pointsTotal): void
    {
        $this->pointsTotal = $pointsTotal;
    }
}

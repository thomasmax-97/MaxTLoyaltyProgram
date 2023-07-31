<?php declare(strict_types=1);

namespace MaxT\MaxTLoyaltyProgram\Service;

use Shopware\Core\Checkout\Order\OrderEntity;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\System\SystemConfig\SystemConfigService;

class OrderLoyaltyProgramService
{
    /**
     * @var SystemConfigService
     */
    private SystemConfigService $configService;

    /**
     * @var EntityRepositoryInterface
     */
    private EntityRepositoryInterface $orderPointRepository;

    /**
     * @param SystemConfigService $configService
     * @param EntityRepositoryInterface $orderPointRepository
     */
    public function __construct(
        SystemConfigService $configService,
        EntityRepositoryInterface $orderPointRepository
    ) {
        $this->configService = $configService;
        $this->orderPointRepository = $orderPointRepository;
    }

    /**
     * @param OrderEntity $order
     * @param Context $context
     * @return void
     */
    public function calculateAndStoreLoyaltyPoints(OrderEntity $order, Context $context)
    {
        // Get the loyalty points conversion rate from the configuration
        $conversionRate = (int)$this->configService->get('MaxTLoyaltyProgram.config.pointsPerEuroSpent');

        // Calculate the loyalty points based on the order total amount
        $orderAmountTotal = $order->getAmountTotal();
        $loyaltyPointsEarned = (int)($orderAmountTotal * $conversionRate);

        //Store the points into the Database
        $this->storeOrderLoyaltyPoints($order->getId(), $order->getOrderCustomer()->getCustomerId(),
            $loyaltyPointsEarned,
            $context);
    }

    /**
     * @param string $orderId
     * @param string $customerId
     * @param int $loyaltyPointsEarned
     * @param Context $context
     * @return void
     */
    private function storeOrderLoyaltyPoints(
        string $orderId,
        string $customerId,
        int $loyaltyPointsEarned,
        Context $context
    ): void {
        $this->orderPointRepository->create([
            [
                'orderId' => $orderId,
                'customerId' => $customerId,
                'pointsEarned' => $loyaltyPointsEarned,
            ]
        ], $context);
    }
}

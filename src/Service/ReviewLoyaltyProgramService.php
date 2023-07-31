<?php declare(strict_types=1);

namespace MaxT\MaxTLoyaltyProgram\Service;

use Shopware\Core\Content\Product\Aggregate\ProductReview\ProductReviewEntity;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\System\SystemConfig\SystemConfigService;

class ReviewLoyaltyProgramService
{
    /**
     * @var SystemConfigService
     */
    private SystemConfigService $configService;

    /**
     * @var EntityRepositoryInterface
     */
    private EntityRepositoryInterface $productReviewPointRepository;

    /**
     * @param SystemConfigService $configService
     * @param EntityRepositoryInterface $productReviewPointRepository
     */
    public function __construct(
        SystemConfigService $configService,
        EntityRepositoryInterface $productReviewPointRepository
    ) {
        $this->configService = $configService;
        $this->productReviewPointRepository = $productReviewPointRepository;
    }

    /**
     * @param ProductReviewEntity $productReview
     * @param Context $context
     * @return void
     */
    public function calculateAndStoreLoyaltyPoints(ProductReviewEntity $productReview, Context $context)
    {
        // Get the loyalty points conversion rate from the configuration
        $conversionRate = (float)$this->configService->get('MaxTLoyaltyProgram.config.pointsPerProductComment');

        // Calculate the loyalty points based on the fixed rate for product reviews
        $loyaltyPointsEarned = (int)($conversionRate);

        // Store the points into the Database
        $this->storeReviewLoyaltyPoints($productReview->getId(), $productReview->getCustomerId(), $loyaltyPointsEarned,
            $context);
    }

    /**
     * @param string $productReviewId
     * @param string|null $customerId
     * @param int $loyaltyPointsEarned
     * @param Context $context
     * @return void
     */
    private function storeReviewLoyaltyPoints(
        string $productReviewId,
        string $customerId,
        int $loyaltyPointsEarned,
        Context $context
    ): void {
        $data = [
            'productReviewId' => $productReviewId,
            'customerId' => $customerId,
            'pointsEarned' => $loyaltyPointsEarned,
        ];

        $this->productReviewPointRepository->create([$data], $context);
    }
}

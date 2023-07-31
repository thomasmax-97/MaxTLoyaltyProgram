<?php declare(strict_types=1);

namespace MaxT\MaxTLoyaltyProgram\Subscriber;

use MaxT\MaxTLoyaltyProgram\Service\ReviewLoyaltyProgramService;
use Shopware\Core\Framework\Api\Context\SalesChannelApiSource;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\EntityWriteResult;
use Shopware\Core\Framework\DataAbstractionLayer\Event\EntityWrittenEvent;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ProductReviewSubscriber implements EventSubscriberInterface
{
    /**
     * @var ReviewLoyaltyProgramService
     */
    private ReviewLoyaltyProgramService $reviewLoyaltyProgramService;

    /**
     * @var EntityRepositoryInterface
     */
    private EntityRepositoryInterface $productReviewRepository;

    /**
     * @param ReviewLoyaltyProgramService $reviewLoyaltyProgramService
     * @param EntityRepositoryInterface $productReviewRepository
     */
    public function __construct(
        reviewLoyaltyProgramService $reviewLoyaltyProgramService,
        EntityRepositoryInterface $productReviewRepository
    ) {
        $this->reviewLoyaltyProgramService = $reviewLoyaltyProgramService;
        $this->productReviewRepository = $productReviewRepository;
    }

    /**
     * @return string[]
     */
    public static function getSubscribedEvents()
    {
        return [
            'product_review.written' => 'onProductWritten'
        ];
    }

    /**
     * @param EntityWrittenEvent $event
     * @return void
     */
    public function onProductWritten(EntityWrittenEvent $event)
    {
        $writeResults = $event->getWriteResults();
        $source = $event->getContext()->getSource();
        $context = $event->getContext();

        foreach ($writeResults as $writeResult) {
            if ($writeResult->getOperation() == EntityWriteResult::OPERATION_INSERT && $source instanceof SalesChannelApiSource && isset($writeResult->getPayload()['id'])) {
                $id = $writeResult->getPayload()['id'];
                $productReview = $this->productReviewRepository->search(new Criteria([$id]), $context)->first();

                if ($productReview) {
                    $this->reviewLoyaltyProgramService->calculateAndStoreLoyaltyPoints($productReview, $context);
                }
            }
        }
    }
}

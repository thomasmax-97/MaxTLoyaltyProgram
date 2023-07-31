<?php declare(strict_types=1);

namespace MaxT\MaxTLoyaltyProgram\Storefront\Page\Account\LoyaltyPoint;

use MaxT\MaxTLoyaltyProgram\Core\Checkout\Order\Aggregate\OrderPoint\OrderPointEntity;
use MaxT\MaxTLoyaltyProgram\Core\Content\Product\Aggregate\ProductReviewPoint\ProductReviewPointEntity;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Storefront\Page\GenericPageLoaderInterface;
use Symfony\Component\HttpFoundation\Request;

class AccountLoyaltyPointPageLoader
{
    /**
     * @var GenericPageLoaderInterface
     */
    private GenericPageLoaderInterface $genericPageLoader;

    /**
     * @var EntityRepositoryInterface
     */
    private EntityRepositoryInterface $orderPointRepository;

    /**
     * @var EntityRepositoryInterface
     */
    private EntityRepositoryInterface $productReviewPointRepository;

    /**
     * @param GenericPageLoaderInterface $genericPageLoader
     * @param EntityRepositoryInterface $orderPointRepository
     * @param EntityRepositoryInterface $productReviewPointRepository
     */
    public function __construct(
        GenericPageLoaderInterface $genericPageLoader,
        EntityRepositoryInterface $orderPointRepository,
        EntityRepositoryInterface $productReviewPointRepository
    ) {
        $this->genericPageLoader = $genericPageLoader;
        $this->orderPointRepository = $orderPointRepository;
        $this->productReviewPointRepository = $productReviewPointRepository;
    }

    /**
     * @param Request $request
     * @param SalesChannelContext $salesChannelContext
     * @return object
     */
    public function load(Request $request, SalesChannelContext $salesChannelContext): object
    {
        $page = $this->genericPageLoader->load($request, $salesChannelContext);
        $page = AccountLoyaltyPointPage::createFrom($page);

        $customer = $salesChannelContext->getCustomer();

        if ($customer) {
            $orderPointsTotal = $this->calculateOrderPointsTotal($customer->id, $salesChannelContext->getContext());
            $page->setOrderPointsTotal($orderPointsTotal);

            $reviewPointsTotal = $this->calculateReviewPointsTotal($customer->id, $salesChannelContext->getContext());
            $page->setReviewPointsTotal($reviewPointsTotal);

            $pointsTotal = $orderPointsTotal + $reviewPointsTotal;
            $page->setPointsTotal($pointsTotal);
        }

        return $page;
    }

    /**
     * @param string $customerId
     * @param Context $context
     * @return int
     */
    public function calculateOrderPointsTotal(string $customerId, Context $context): int
    {
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('customerId', $customerId));

        $orderPointsTotal = $this->orderPointRepository->search($criteria, $context)->map(function (
            OrderPointEntity $orderPointEntity
        ) {
            return $orderPointEntity->getPointsEarned();
        });

        return (int)array_sum($orderPointsTotal);
    }

    /**
     * @param string $customerId
     * @param Context $context
     * @return int
     */
    public function calculateReviewPointsTotal(string $customerId, Context $context): int
    {
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('customerId', $customerId));

        $reviewPointsTotal = $this->productReviewPointRepository->search($criteria, $context)->map(function (
            ProductReviewPointEntity $productReviewPointEntity
        ) {
            return $productReviewPointEntity->getPointsEarned();
        });

        return (int)array_sum($reviewPointsTotal);
    }
}

<?php

namespace MaxT\MaxTLoyaltyProgram\Administration\Controller;

use MaxT\MaxTLoyaltyProgram\Storefront\Page\Account\LoyaltyPoint\AccountLoyaltyPointPageLoader;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @RouteScope(scopes={"api"})
 */
class ApiController extends AbstractController
{
    /**
     * @var AccountLoyaltyPointPageLoader
     */
    private AccountLoyaltyPointPageLoader $accountLoyaltyPointPageLoader;

    /**
     * @param AccountLoyaltyPointPageLoader $accountLoyaltyPointPageLoader
     */
    public function __construct(AccountLoyaltyPointPageLoader $accountLoyaltyPointPageLoader)
    {
        $this->accountLoyaltyPointPageLoader = $accountLoyaltyPointPageLoader;
    }

    /**
     * @Route("/api/loyalty-points/{customerId}", name="api.custom_bonus_points", methods={"GET"})
     */
    public function getLoyaltyPoints(string $customerId, Context $context): JsonResponse
    {
        $orderPointsTotal = $this->accountLoyaltyPointPageLoader->calculateOrderPointsTotal($customerId, $context);
        $reviewPointsTotal = $this->accountLoyaltyPointPageLoader->calculateReviewPointsTotal($customerId, $context);

        $pointsTotal = $orderPointsTotal + $reviewPointsTotal;

        return new JsonResponse([
            'orderPointsTotal' => $orderPointsTotal,
            'reviewPointsTotal' => $reviewPointsTotal,
            'pointsTotal' => $pointsTotal
        ]);
    }
}

<?php declare(strict_types=1);

namespace MaxT\MaxTLoyaltyProgram\Storefront\Controller;

use MaxT\MaxTLoyaltyProgram\Storefront\Page\Account\LoyaltyPoint\AccountLoyaltyPointPageLoader;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Storefront\Controller\StorefrontController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route(defaults={"_routeScope"={"storefront"}})
 */
class AccountLoyaltyPointController extends StorefrontController
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
     * @Route("/example", name="frontend.example.example", methods={"GET"})
     */
    public function loyaltyPointOverview(Request $request, SalesChannelContext $context): Response
    {
        $page = $this->accountLoyaltyPointPageLoader->load($request, $context);

        return $this->renderStorefront('@SwagBasicExample/storefront/page/account/loyalty-point/index.html.twig', [
            'page' => $page
        ]);
    }
}

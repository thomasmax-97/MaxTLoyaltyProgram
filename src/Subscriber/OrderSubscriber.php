<?php declare(strict_types=1);

namespace MaxT\MaxTLoyaltyProgram\Subscriber;

use MaxT\MaxTLoyaltyProgram\Service\OrderLoyaltyProgramService;
use Shopware\Core\Checkout\Cart\Event\CheckoutOrderPlacedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class OrderSubscriber implements EventSubscriberInterface
{
    /**
     * @var OrderLoyaltyProgramService
     */
    private OrderLoyaltyProgramService $orderLoyaltyProgramService;

    /**
     * @param OrderLoyaltyProgramService $orderLoyaltyProgramService
     */
    public function __construct(OrderLoyaltyProgramService $orderLoyaltyProgramService)
    {
        $this->orderLoyaltyProgramService = $orderLoyaltyProgramService;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            CheckoutOrderPlacedEvent::class => 'onOrderPlaced',
        ];
    }

    /**
     * @param CheckoutOrderPlacedEvent $event
     * @return void
     */
    public function onOrderPlaced(CheckoutOrderPlacedEvent $event): void
    {
        //Only create points if it isn't a guest order
        if ($event->getOrder()->getOrderCustomer()->getCustomerId()) {
            $this->orderLoyaltyProgramService->calculateAndStoreLoyaltyPoints($event->getOrder(),
                $event->getContext());
        }
    }
}

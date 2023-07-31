<?php declare(strict_types=1);

namespace MaxT\MaxTLoyaltyProgram\Core\Checkout\Order\Aggregate\OrderPoint;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;

/**
 * @method void              add(OrderPointEntity $entity)
 * @method void              set(string $key, OrderPointEntity $entity)
 * @method OrderPointEntity[]    getIterator()
 * @method OrderPointEntity[]    getElements()
 * @method OrderPointEntity|null get(string $key)
 * @method OrderPointEntity|null first()
 * @method OrderPointEntity|null last()
 */
class OrderPointCollection extends EntityCollection
{
    /**
     * @return string
     */
    protected function getExpectedClass(): string
    {
        return OrderPointEntity::class;
    }
}

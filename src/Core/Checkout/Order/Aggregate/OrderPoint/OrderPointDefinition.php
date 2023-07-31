<?php declare(strict_types=1);

namespace MaxT\MaxTLoyaltyProgram\Core\Checkout\Order\Aggregate\OrderPoint;

use Shopware\Core\Checkout\Customer\CustomerDefinition;
use Shopware\Core\Checkout\Order\OrderDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\FkField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\ApiAware;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IdField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IntField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ManyToOneAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\OneToOneAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;

class OrderPointDefinition extends EntityDefinition
{
    public const ENTITY_NAME = 'maxt_loyalty_order_point';

    /**
     * @return string
     */
    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    /**
     * @return string
     */
    public function getEntityClass(): string
    {
        return OrderPointEntity::class;
    }

    /**
     * @return string
     */
    public function getCollectionClass(): string
    {
        return OrderPointCollection::class;
    }

    /**
     * @return FieldCollection
     */
    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new IdField('id', 'id'))->addFlags(new PrimaryKey(), new Required()),
            (new FkField('order_id', 'orderId', OrderDefinition::class))->addFlags(new ApiAware(), new Required()),
            (new FkField('customer_id', 'customerId', CustomerDefinition::class))->addFlags(new ApiAware(),
                new Required()),
            (new IntField('points_earned', 'pointsEarned'))->addFlags(new ApiAware(), new Required()),

            new OneToOneAssociationField('order', 'order_id', 'id', OrderDefinition::class, false),
            new ManyToOneAssociationField('customer', 'customer_id', CustomerDefinition::class, 'id', false),
        ]);
    }
}

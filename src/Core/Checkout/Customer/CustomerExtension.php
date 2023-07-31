<?php declare(strict_types=1);

namespace MaxT\MaxTLoyaltyProgram\Core\Checkout\Customer;

use MaxT\MaxTLoyaltyProgram\Core\Checkout\Order\Aggregate\OrderPoint\OrderPointDefinition;
use Shopware\Core\Checkout\Customer\CustomerDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\EntityExtension;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Inherited;
use Shopware\Core\Framework\DataAbstractionLayer\Field\OneToManyAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;

class CustomerExtension extends EntityExtension
{
    public function extendFields(FieldCollection $collection): void
    {
        $collection->add(
            (new OneToManyAssociationField(
                'orderPoints',
                OrderPointDefinition::class,
                'customer_id',
                'id'
            ))->addFlags(new Inherited())
        );
    }

    /**
     * @return string
     */
    public function getDefinitionClass(): string
    {
        return CustomerDefinition::class;
    }
}

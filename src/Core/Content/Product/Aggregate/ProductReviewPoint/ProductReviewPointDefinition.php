<?php declare(strict_types=1);

namespace MaxT\MaxTLoyaltyProgram\Core\Content\Product\Aggregate\ProductReviewPoint;

use Shopware\Core\Checkout\Customer\CustomerDefinition;
use Shopware\Core\Content\Product\Aggregate\ProductReview\ProductReviewCollection;
use Shopware\Core\Content\Product\Aggregate\ProductReview\ProductReviewDefinition;
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

class ProductReviewPointDefinition extends EntityDefinition
{
    public const ENTITY_NAME = 'maxt_loyalty_product_review_point';

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
        return ProductReviewPointEntity::class;
    }

    /**
     * @return string
     */
    public function getCollectionClass(): string
    {
        return ProductReviewPointCollection::class;
    }

    /**
     * @return FieldCollection
     */
    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new IdField('id', 'id'))->addFlags(new PrimaryKey(), new Required()),
            (new FkField('product_review_id', 'productReviewId', ProductReviewDefinition::class))->addFlags(new ApiAware(), new Required()),
            (new FkField('customer_id', 'customerId', CustomerDefinition::class))->addFlags(new ApiAware(),
                new Required()),
            (new IntField('points_earned', 'pointsEarned'))->addFlags(new ApiAware(), new Required()),

            new OneToOneAssociationField('productReview', 'product_review_id', 'id', ProductReviewDefinition::class, false),
            new ManyToOneAssociationField('customer', 'customer_id', CustomerDefinition::class, 'id', false),
        ]);
    }
}

<?php declare(strict_types=1);

namespace MaxT\MaxTLoyaltyProgram\Core\Content\Product\Aggregate\ProductReviewPoint;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;

/**
 * @method void              add(ProductReviewPointEntity $entity)
 * @method void              set(string $key, ProductReviewPointEntity $entity)
 * @method ProductReviewPointEntity[]    getIterator()
 * @method ProductReviewPointEntity[]    getElements()
 * @method ProductReviewPointEntity|null get(string $key)
 * @method ProductReviewPointEntity|null first()
 * @method ProductReviewPointEntity|null last()
 */
class ProductReviewPointCollection extends EntityCollection
{
    /**
     * @return string
     */
    protected function getExpectedClass(): string
    {
        return ProductReviewPointEntity::class;
    }
}

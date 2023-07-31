<?php declare(strict_types=1);

namespace MaxT\MaxTLoyaltyProgram\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1690723420CreateLoyaltyProductReviewPointTable extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1690723420;
    }

    public function update(Connection $connection): void
    {
        $sql = <<<SQL
            CREATE TABLE IF NOT EXISTS `maxt_loyalty_product_review_point` (
                `id` BINARY(16) NOT NULL,
                `product_review_id` BINARY(16) NOT NULL,
                `customer_id` BINARY(16) NOT NULL,
                `points_earned` INT NOT NULL,
                `created_at` DATETIME(3) NOT NULL,
                `updated_at` DATETIME(3) NULL,
                PRIMARY KEY (`id`),
                KEY `idx_product_review_id` (`product_review_id`),
                KEY `idx_customer_id` (`customer_id`),
                CONSTRAINT `fk_product_review_loyalty_points_product_review`
                    FOREIGN KEY (`product_review_id`) REFERENCES `product_review` (`id`) ON DELETE CASCADE,
                CONSTRAINT `fk_product_review_loyalty_points_customer`
                    FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        SQL;

        $connection->executeStatement($sql);
    }

    public function updateDestructive(Connection $connection): void
    {
        // Drop both foreign keys
        $sql = <<<SQL
            ALTER TABLE `maxt_loyalty_product_review_point`
                DROP FOREIGN KEY `fk_product_review_loyalty_points_product_review`;

            ALTER TABLE `maxt_loyalty_product_review_point`
                DROP FOREIGN KEY `fk_product_review_loyalty_points_customer`;
        SQL;

        $connection->executeStatement($sql);


        $sql = <<<SQL
            DROP TABLE IF EXISTS `maxt_loyalty_product_review_point`;
        SQL;

        $connection->executeStatement($sql);
    }
}

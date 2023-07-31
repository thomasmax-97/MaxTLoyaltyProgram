<?php declare(strict_types=1);

namespace MaxT\MaxTLoyaltyProgram\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1690633666CreateLoyaltyOrderPointTable extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1690633666;
    }

    public function update(Connection $connection): void
    {
        $sql = <<<SQL
            CREATE TABLE IF NOT EXISTS `maxt_loyalty_order_point` (
                `id` BINARY(16) NOT NULL,
                `order_id` BINARY(16) NOT NULL,
                `customer_id` BINARY(16) NOT NULL,
                `points_earned` INT NOT NULL,
                `created_at` DATETIME(3) NOT NULL,
                `updated_at` DATETIME(3) NULL,
                PRIMARY KEY (`id`),
                KEY `idx_order_id` (`order_id`),
                KEY `idx_customer_id` (`customer_id`),
                CONSTRAINT `fk_max_t_loyalty_purchase_order`
                    FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE CASCADE,
                CONSTRAINT `fk_max_t_loyalty_purchase_customer`
                    FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        SQL;

        $connection->executeStatement($sql);
    }

    public function updateDestructive(Connection $connection): void
    {
        $sql = <<<SQL
            ALTER TABLE `maxt_loyalty_order_point`
                DROP FOREIGN KEY `fk_max_t_loyalty_purchase_order`;
            ALTER TABLE `maxt_loyalty_order_point`
                DROP FOREIGN KEY `fk_max_t_loyalty_purchase_customer`;
            ALTER TABLE `maxt_loyalty_product_review_point`
                DROP FOREIGN KEY `fk_product_review_loyalty_points_product_review`;
            ALTER TABLE `maxt_loyalty_product_review_point`
                DROP FOREIGN KEY `fk_product_review_loyalty_points_customer`;
        SQL;

        $connection->executeStatement($sql);

        // Drop the table
        $sql = <<<SQL
            DROP TABLE IF EXISTS `maxt_loyalty_order_point`;
        SQL;

        $connection->executeStatement($sql);
    }
}

<?php declare(strict_types=1);

namespace MaxT\MaxTLoyaltyProgram;

use Doctrine\DBAL\Connection;
use Exception;
use Shopware\Core\Framework\Plugin;
use Shopware\Core\Framework\Plugin\Context\UninstallContext;

class MaxTLoyaltyProgram extends Plugin
{
    /**
     * @param UninstallContext $uninstallContext
     * @return void
     * @throws Exception
     */
    public function uninstall(UninstallContext $uninstallContext): void
    {
        parent::uninstall($uninstallContext);

        $connection = $this->container->get(Connection::class);

        // Drop the constraints
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

        // Drop the tables
        $sql = <<<SQL
            DROP TABLE IF EXISTS `maxt_loyalty_order_point`;
            DROP TABLE IF EXISTS `maxt_loyalty_product_review_point`;
        SQL;

        $connection->executeStatement($sql);
    }
}

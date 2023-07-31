<?php declare(strict_types=1);

namespace MaxT\MaxTLoyaltyProgram\Test\Feature\Subscriber;

use Doctrine\DBAL\Connection;
use MaxT\MaxTLoyaltyProgram\Core\Content\Product\Aggregate\ProductReviewPoint\ProductReviewPointEntity;
use PHPUnit\Framework\TestCase;
use Shopware\Core\Checkout\Test\Cart\Promotion\Helpers\Traits\PromotionIntegrationTestBehaviour;
use Shopware\Core\Checkout\Test\Cart\Promotion\Helpers\Traits\PromotionTestFixtureBehaviour;
use Shopware\Core\Content\Product\Aggregate\ProductVisibility\ProductVisibilityDefinition;
use Shopware\Core\Defaults;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\Test\TestCaseBase\IntegrationTestBehaviour;
use Shopware\Core\Framework\Test\TestCaseBase\MailTemplateTestBehaviour;
use Shopware\Core\Framework\Test\TestCaseBase\SalesChannelApiTestBehaviour;
use Shopware\Core\Framework\Test\TestDataCollection;
use Shopware\Core\Framework\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

class ReviewLoyaltyProgramServiceTest extends TestCase
{
    use IntegrationTestBehaviour;
    use SalesChannelApiTestBehaviour;


    use MailTemplateTestBehaviour;
    use PromotionTestFixtureBehaviour;
    use PromotionIntegrationTestBehaviour;

    private KernelBrowser $browser;

    private TestDataCollection $ids;

    protected function setUp(): void
    {
        $this->ids = new TestDataCollection();

        $this->createData();

        $this->browser = $this->createCustomSalesChannelBrowser([
            'id' => $this->ids->create('sales-channel'),
        ]);

        $this->setVisibilities();
    }

    public function testCreate(): void
    {
        $customerId = $this->login($this->browser);

        $this->assertReviewCount(0);

        $this->browser->request('POST', $this->getUrl(), [
            'title' => 'Lorem ipsum dolor sit amet',
            'content' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna',
        ]);

        $response = $this->browser->getResponse();
        $content = json_decode($this->browser->getResponse()->getContent(), true);

        static::assertEquals(204, $response->getStatusCode(), print_r($content, true));

        $this->assertReviewCount(1);

        /** @var EntityRepositoryInterface $productReviewPointRepository */
        $productReviewPointRepository = $this->getContainer()->get('maxt_loyalty_product_review_point.repository.inner');

        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('customerId', $customerId));

        /** @var ProductReviewPointEntity $productReviewPoint */
        $productReviewPoint = $productReviewPointRepository->search($criteria, Context::createDefaultContext())->first();
        $this->assertNotNull($productReviewPoint);

        $configService = $this->getContainer()->get('Shopware\Core\System\SystemConfig\SystemConfigService');
        $points = $configService->get('MaxTLoyaltyProgram.config.pointsPerProductComment');

        $this->assertSame($points, $productReviewPoint->getPointsEarned());
    }

    private function assertReviewCount(int $expected): void
    {
        $count = $this->getContainer()
            ->get(Connection::class)
            ->fetchOne('SELECT COUNT(*) FROM product_review WHERE product_id = :id',
                ['id' => Uuid::fromHexToBytes($this->ids->get('product'))]);

        static::assertEquals($expected, $count);
    }

    private function createData(): void
    {
        $product = [
            'id' => $this->ids->create('product'),
            'manufacturer' => ['id' => $this->ids->create('manufacturer-'), 'name' => 'test-'],
            'productNumber' => $this->ids->get('product'),
            'name' => 'test',
            'stock' => 10,
            'price' => [
                ['currencyId' => Defaults::CURRENCY, 'gross' => 15, 'net' => 10, 'linked' => false],
            ],
            'tax' => ['name' => 'test', 'taxRate' => 15],
            'active' => true,
        ];

        $this->getContainer()->get('product.repository')
            ->create([$product], Context::createDefaultContext());
    }

    private function setVisibilities(): void
    {
        $update = [
            [
                'id' => $this->ids->get('product'),
                'visibilities' => [
                    [
                        'salesChannelId' => $this->ids->get('sales-channel'),
                        'visibility' => ProductVisibilityDefinition::VISIBILITY_ALL
                    ],
                ],
            ],
        ];
        $this->getContainer()->get('product.repository')
            ->update($update, Context::createDefaultContext());
    }

    private function getUrl()
    {
        return '/store-api/product/' . $this->ids->get('product') . '/review';
    }
}

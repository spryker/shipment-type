<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\ShipmentType\Business\Plugin\Product;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\ProductConcreteCollectionRequestTransfer;
use Generated\Shared\Transfer\ProductConcreteCollectionResponseTransfer;
use Generated\Shared\Transfer\ProductConcreteTransfer;
use Generated\Shared\Transfer\ShipmentTypeTransfer;
use Spryker\Zed\ShipmentType\Communication\Plugin\Product\ShipmentTypeExistsProductConcreteCollectionCreateValidatorPlugin;
use SprykerTest\Zed\ShipmentType\ShipmentTypeBusinessTester;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Zed
 * @group ShipmentType
 * @group Business
 * @group Plugin
 * @group Product
 * @group ShipmentTypeExistsProductConcreteCollectionCreateValidatorPluginTest
 *
 * Add your own group annotations below this line
 */
class ShipmentTypeExistsProductConcreteCollectionCreateValidatorPluginTest extends Unit
{
    protected const string UNKNOWN_UUID = '00000000-0000-0000-0000-000000000000';

    protected const string PRODUCT_SKU = 'concrete-sku';

    protected ShipmentTypeBusinessTester $tester;

    public function testValidateReturnsErrorWhenShipmentTypeUuidDoesNotExist(): void
    {
        // Arrange
        $productConcreteCollectionRequestTransfer = $this->createRequestWithShipmentTypeUuid(static::UNKNOWN_UUID);

        // Act
        $productConcreteCollectionResponseTransfer = (new ShipmentTypeExistsProductConcreteCollectionCreateValidatorPlugin())->validate(
            $productConcreteCollectionRequestTransfer,
            new ProductConcreteCollectionResponseTransfer(),
        );

        // Assert
        $this->assertCount(1, $productConcreteCollectionResponseTransfer->getErrors());
        $this->assertSame(static::PRODUCT_SKU, $productConcreteCollectionResponseTransfer->getErrors()->offsetGet(0)->getEntityIdentifier());
    }

    public function testValidatePassesWhenShipmentTypeUuidExists(): void
    {
        // Arrange
        $shipmentTypeTransfer = $this->tester->haveShipmentType();
        $this->assertNotNull($shipmentTypeTransfer->getUuid());

        $productConcreteCollectionRequestTransfer = $this->createRequestWithShipmentTypeUuid((string)$shipmentTypeTransfer->getUuid());

        // Act
        $productConcreteCollectionResponseTransfer = (new ShipmentTypeExistsProductConcreteCollectionCreateValidatorPlugin())->validate(
            $productConcreteCollectionRequestTransfer,
            new ProductConcreteCollectionResponseTransfer(),
        );

        // Assert
        $this->assertCount(0, $productConcreteCollectionResponseTransfer->getErrors());
    }

    public function testValidatePassesWhenNoShipmentTypeUuidsProvided(): void
    {
        // Arrange
        $productConcreteCollectionRequestTransfer = (new ProductConcreteCollectionRequestTransfer())
            ->addProduct((new ProductConcreteTransfer())->setSku(static::PRODUCT_SKU));

        // Act
        $productConcreteCollectionResponseTransfer = (new ShipmentTypeExistsProductConcreteCollectionCreateValidatorPlugin())->validate(
            $productConcreteCollectionRequestTransfer,
            new ProductConcreteCollectionResponseTransfer(),
        );

        // Assert
        $this->assertCount(0, $productConcreteCollectionResponseTransfer->getErrors());
    }

    protected function createRequestWithShipmentTypeUuid(string $uuid): ProductConcreteCollectionRequestTransfer
    {
        return (new ProductConcreteCollectionRequestTransfer())
            ->addProduct(
                (new ProductConcreteTransfer())
                    ->setSku(static::PRODUCT_SKU)
                    ->addShipmentType((new ShipmentTypeTransfer())->setUuid($uuid)),
            );
    }
}

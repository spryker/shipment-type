<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace Spryker\Zed\ShipmentType\Communication\Plugin\Product;

use Generated\Shared\Transfer\ProductConcreteCollectionRequestTransfer;
use Generated\Shared\Transfer\ProductConcreteCollectionResponseTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\ProductExtension\Dependency\Plugin\ProductConcreteCollectionUpdateValidatorPluginInterface;

/**
 * @method \Spryker\Zed\ShipmentType\Business\ShipmentTypeBusinessFactory getBusinessFactory()
 */
class ShipmentTypeExistsProductConcreteCollectionUpdateValidatorPlugin extends AbstractPlugin implements ProductConcreteCollectionUpdateValidatorPluginInterface
{
    /**
     * {@inheritDoc}
     * - Validates the shipment type UUIDs referenced in `ProductConcreteTransfer.shipmentTypes`.
     * - Resolves all referenced UUIDs of the collection with a single query.
     * - Adds an error per concrete product referencing a shipment type UUID that does not exist.
     * - Returns the response unchanged when no concrete product references a shipment type.
     *
     * @api
     */
    public function validate(
        ProductConcreteCollectionRequestTransfer $productConcreteCollectionRequestTransfer,
        ProductConcreteCollectionResponseTransfer $productConcreteCollectionResponseTransfer
    ): ProductConcreteCollectionResponseTransfer {
        return $this->getBusinessFactory()
            ->createProductShipmentTypeValidator()
            ->validateProductConcreteCollection($productConcreteCollectionRequestTransfer, $productConcreteCollectionResponseTransfer);
    }
}

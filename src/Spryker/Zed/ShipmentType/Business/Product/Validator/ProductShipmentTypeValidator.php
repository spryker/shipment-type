<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace Spryker\Zed\ShipmentType\Business\Product\Validator;

use Generated\Shared\Transfer\ErrorTransfer;
use Generated\Shared\Transfer\ProductConcreteCollectionRequestTransfer;
use Generated\Shared\Transfer\ProductConcreteCollectionResponseTransfer;
use Generated\Shared\Transfer\ShipmentTypeConditionsTransfer;
use Generated\Shared\Transfer\ShipmentTypeCriteriaTransfer;
use Spryker\Zed\ShipmentType\Persistence\ShipmentTypeRepositoryInterface;

class ProductShipmentTypeValidator implements ProductShipmentTypeValidatorInterface
{
    public function __construct(
        protected readonly ShipmentTypeRepositoryInterface $shipmentTypeRepository,
    ) {
    }

    public function validateProductConcreteCollection(
        ProductConcreteCollectionRequestTransfer $productConcreteCollectionRequestTransfer,
        ProductConcreteCollectionResponseTransfer $productConcreteCollectionResponseTransfer
    ): ProductConcreteCollectionResponseTransfer {
        $uuidsByEntity = [];

        foreach ($productConcreteCollectionRequestTransfer->getProducts() as $productConcreteTransfer) {
            $sku = (string)$productConcreteTransfer->getSku();
            foreach ($productConcreteTransfer->getShipmentTypes() as $shipmentTypeTransfer) {
                $uuid = $shipmentTypeTransfer->getUuid();

                if ($uuid !== null && $uuid !== '') {
                    $uuidsByEntity[$sku][$uuid] = true;
                }
            }
        }

        if ($uuidsByEntity === []) {
            return $productConcreteCollectionResponseTransfer;
        }

        $knownUuids = $this->getKnownUuids($this->flattenUuids($uuidsByEntity));

        foreach ($uuidsByEntity as $sku => $uuids) {
            foreach (array_diff(array_keys($uuids), $knownUuids) as $unknownUuid) {
                $productConcreteCollectionResponseTransfer->addError($this->createError((string)$sku, (string)$unknownUuid));
            }
        }

        return $productConcreteCollectionResponseTransfer;
    }

    /**
     * @param array<string, array<string, true>> $uuidsByEntity
     *
     * @return list<string>
     */
    protected function flattenUuids(array $uuidsByEntity): array
    {
        $uuids = [];

        foreach ($uuidsByEntity as $entityUuids) {
            $uuids = array_merge($uuids, array_keys($entityUuids));
        }

        return array_values(array_unique($uuids));
    }

    /**
     * @param list<string> $uuids
     *
     * @return list<string>
     */
    protected function getKnownUuids(array $uuids): array
    {
        $shipmentTypeCriteriaTransfer = (new ShipmentTypeCriteriaTransfer())
            ->setShipmentTypeConditions(
                (new ShipmentTypeConditionsTransfer())->setUuids($uuids),
            );

        $knownUuids = [];

        foreach ($this->shipmentTypeRepository->getShipmentTypeCollection($shipmentTypeCriteriaTransfer)->getShipmentTypes() as $shipmentTypeTransfer) {
            $uuid = $shipmentTypeTransfer->getUuid();

            if ($uuid !== null) {
                $knownUuids[] = $uuid;
            }
        }

        return $knownUuids;
    }

    protected function createError(?string $entityIdentifier, string $unknownUuid): ErrorTransfer
    {
        return (new ErrorTransfer())
            ->setEntityIdentifier($entityIdentifier)
            ->setMessage(sprintf('Shipment type with UUID "%s" does not exist.', $unknownUuid));
    }
}

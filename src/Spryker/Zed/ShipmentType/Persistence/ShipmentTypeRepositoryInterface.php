<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ShipmentType\Persistence;

use Generated\Shared\Transfer\ShipmentTypeCollectionTransfer;
use Generated\Shared\Transfer\ShipmentTypeCriteriaTransfer;

interface ShipmentTypeRepositoryInterface
{
    public function getShipmentTypeCollection(
        ShipmentTypeCriteriaTransfer $shipmentTypeCriteriaTransfer
    ): ShipmentTypeCollectionTransfer;

    /**
     * @param array<int> $shipmentTypeIds
     *
     * @return array<int, \Generated\Shared\Transfer\StoreRelationTransfer>
     */
    public function getShipmentTypeStoreRelationsIndexedByIdShipmentType(array $shipmentTypeIds): array;

    /**
     * @param array<int> $shipmentMethodIds
     *
     * @return array<int, array<int>>
     */
    public function getShipmentMethodIdsGroupedByIdShipmentType(array $shipmentMethodIds): array;

    /**
     * @param array<string> $shipmentTypeUuids
     * @param string $storeName
     *
     * @return array<int>
     */
    public function getShipmentMethodIdsByShipmentTypeConditions(array $shipmentTypeUuids, string $storeName): array;
}

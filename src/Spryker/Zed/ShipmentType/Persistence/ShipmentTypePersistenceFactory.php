<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ShipmentType\Persistence;

use Orm\Zed\Shipment\Persistence\Base\SpyShipmentMethodQuery;
use Orm\Zed\ShipmentType\Persistence\SpyShipmentTypeQuery;
use Orm\Zed\ShipmentType\Persistence\SpyShipmentTypeStoreQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;
use Spryker\Zed\ShipmentType\Persistence\Propel\Mapper\ShipmentTypeMapper;
use Spryker\Zed\ShipmentType\ShipmentTypeDependencyProvider;

/**
 * @method \Spryker\Zed\ShipmentType\ShipmentTypeConfig getConfig()
 * @method \Spryker\Zed\ShipmentType\Persistence\ShipmentTypeRepositoryInterface getRepository()
 * @method \Spryker\Zed\ShipmentType\Persistence\ShipmentTypeEntityManagerInterface getEntityManager()
 */
class ShipmentTypePersistenceFactory extends AbstractPersistenceFactory
{
    public function createShipmentTypeQuery(): SpyShipmentTypeQuery
    {
        return SpyShipmentTypeQuery::create();
    }

    public function createShipmentTypeStoreQuery(): SpyShipmentTypeStoreQuery
    {
        return SpyShipmentTypeStoreQuery::create();
    }

    public function createShipmentTypeMapper(): ShipmentTypeMapper
    {
        return new ShipmentTypeMapper();
    }

    public function getShipmentMethodPropelQuery(): SpyShipmentMethodQuery
    {
        return $this->getProvidedDependency(ShipmentTypeDependencyProvider::PROPEL_QUERY_SHIPMENT_METHOD);
    }
}

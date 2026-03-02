<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ShipmentType;

use Orm\Zed\Shipment\Persistence\SpyShipmentMethodQuery;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\ShipmentType\Dependency\Facade\ShipmentTypeToStoreFacadeBridge;

/**
 * @method \Spryker\Zed\ShipmentType\ShipmentTypeConfig getConfig()
 */
class ShipmentTypeDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const FACADE_STORE = 'FACADE_STORE';

    /**
     * @var string
     */
    public const PROPEL_QUERY_SHIPMENT_METHOD = 'PROPEL_QUERY_SHIPMENT_METHOD';

    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);
        $container = $this->addStoreFacade($container);

        return $container;
    }

    public function providePersistenceLayerDependencies(Container $container): Container
    {
        $container = parent::providePersistenceLayerDependencies($container);
        $container = $this->addShipmentMethodPropelQuery($container);

        return $container;
    }

    protected function addStoreFacade(Container $container): Container
    {
        $container->set(static::FACADE_STORE, function (Container $container) {
            return new ShipmentTypeToStoreFacadeBridge($container->getLocator()->store()->facade());
        });

        return $container;
    }

    protected function addShipmentMethodPropelQuery(Container $container): Container
    {
        $container->set(static::PROPEL_QUERY_SHIPMENT_METHOD, $container->factory(function () {
            return SpyShipmentMethodQuery::create();
        }));

        return $container;
    }
}

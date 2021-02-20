<?php

namespace WebDev\ShipmentBatches\Plugin;

use Magento\Framework\Serialize\Serializer\Json;
use Magento\Sales\Api\Data\OrderExtensionFactory;
use Magento\Sales\Api\Data\OrderSearchResultInterface;
use Magento\Sales\Api\Data\ShipmentInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Api\ShipmentRepositoryInterface;

class ShipmentRepositoryPlugin
{
    const BATCH_DETAIL = 'batch_detail';

    /**
     * @var OrderExtensionFactory
     */
    protected $extensionFactory;
    /**
     * @var Json
     */
    protected $json;

    /**
     * ShipmentRepositoryPlugin constructor
     *
     * @param OrderExtensionFactory $extensionFactory
     * @param Json $json
     */
    public function __construct(OrderExtensionFactory $extensionFactory, Json $json)
    {
        $this->extensionFactory = $extensionFactory;
        $this->json = $json;
    }

    /**
     * @param ShipmentRepositoryInterface $subject
     * @param ShipmentInterface $resultShipment
     * @return array
     */
    public function beforeSave(ShipmentRepositoryInterface $subject, ShipmentInterface $resultShipment)
    {
        $items = $resultShipment->getItems();
        foreach ($items as $item) {
            $attributes = $item->getExtensionAttributes();
            $item->setExtensionAttributes($attributes);
            $batchDetail = $attributes->getBatchDetail();
            if ($batchDetail) {
                if (is_array($batchDetail)) {
                    $data = [];
                    foreach ($batchDetail as $batch) {
                        $data[] = $batch->getBatchData();
                    }
                    $item->setData(self::BATCH_DETAIL, $this->json->serialize($data));
                } else {
                    $item->setData(self::BATCH_DETAIL, $batchDetail);
                }
            }
        }
        return [$resultShipment];
    }

    /**
     * Add "batch_detail" extension attribute to shipment data object
     * to make it accessible in API data of shipment record
     *
     * @param ShipmentRepositoryInterface $subject
     * @param ShipmentInterface $shipment
     * @return ShipmentInterface
     */
    public function afterGet(ShipmentRepositoryInterface $subject, ShipmentInterface $shipment)
    {
        foreach ($shipment->getItems() as &$item) {
            $batchDetail = $item->getData(self::BATCH_DETAIL);
            $extensionAttributes = $item->getExtensionAttributes();
            $extensionAttributes = $extensionAttributes ? $extensionAttributes : $this->extensionFactory->create();
            if ($batchDetail) {
                $extensionAttributes->setBatchDetail($this->json->unserialize($batchDetail));
                $item->setExtensionAttributes($extensionAttributes);
            }
        }
        return $shipment;
    }

    /**
     * Add "batch_detail" extension attribute to shipment item data objects
     * to make it accessible in API data of all order list
     *
     * @param OrderRepositoryInterface $subject
     * @param OrderSearchResultInterface $searchResult
     * @return OrderSearchResultInterface
     */
    public function afterGetList(OrderRepositoryInterface $subject, OrderSearchResultInterface $searchResult)
    {
        foreach ($searchResult->getItems() as &$shipment) {
            foreach ($shipment->getItems() as &$item) {
                $batchDetail = $item->getData(self::BATCH_DETAIL);
                $extensionAttributes = $item->getExtensionAttributes();
                $extensionAttributes = $extensionAttributes ? $extensionAttributes : $this->extensionFactory->create();
                if ($batchDetail) {
                    $extensionAttributes->setBatchDetail($this->json->unserialize($batchDetail));
                    $item->setExtensionAttributes($extensionAttributes);
                }
            }
        }
        return $searchResult;
    }
}

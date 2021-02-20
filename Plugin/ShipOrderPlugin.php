<?php

namespace WebDev\ShipmentBatches\Plugin;

use Magento\Framework\Serialize\Serializer\Json;
use Magento\Sales\Api\ShipmentRepositoryInterface;

class ShipOrderPlugin
{
    /**
     * @var ShipmentRepositoryInterface
     */
    protected $shipmentRepository;
    /**
     * @var Json
     */
    protected $json;

    /**
     * ShipOrderPlugin constructor
     *
     * @param ShipmentRepositoryInterface $shipmentRepository
     * @param Json $json
     */
    public function __construct(ShipmentRepositoryInterface $shipmentRepository, Json $json)
    {
        $this->shipmentRepository = $shipmentRepository;
        $this->json = $json;
    }

    /**
     * @param $subject
     * @param callable $proceed
     * @param $orderId
     * @param array $items
     * @param bool $notify
     * @param bool $appendComment
     * @param \Magento\Sales\Api\Data\ShipmentCommentCreationInterface|null $comment
     * @param array $tracks
     * @param array $packages
     * @param \Magento\Sales\Api\Data\ShipmentCreationArgumentsInterface|null $arguments
     * @return int|null
     */
    public function aroundExecute(
        $subject,
        callable $proceed,
        $orderId,
        array $items = [],
        $notify = false,
        $appendComment = false,
        \Magento\Sales\Api\Data\ShipmentCommentCreationInterface $comment = null,
        array $tracks = [],
        array $packages = [],
        \Magento\Sales\Api\Data\ShipmentCreationArgumentsInterface $arguments = null
    ) {
        $shipmentId = $proceed($orderId, $items, $notify, $appendComment, $comment, $tracks, $packages, $arguments);
        $shipment = $this->shipmentRepository->get($shipmentId);
        foreach ($shipment->getItems() as $key => $item) {
            $itemAttributes = $items[$key]->getExtensionAttributes();
            if ($itemAttributes) {
                $batch = $itemAttributes->getBatchDetail();
                $attributes = $item->getExtensionAttributes();
                if (is_array($batch)) {
                    $data = [];
                    foreach ($batch as $b) {
                        $data[] = $b->getBatchData();
                    }
                    $attributes->setBatchDetail($this->json->serialize($data));
                } else {
                    $attributes->setBatchDetail($batch);
                }
                $item->setExtensionAttributes($attributes);
            }
        }
        $this->shipmentRepository->save($shipment);
        return $shipment->getEntityId();
    }
}

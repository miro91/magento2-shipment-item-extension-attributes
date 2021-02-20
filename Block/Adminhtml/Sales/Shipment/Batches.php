<?php

namespace WebDev\ShipmentBatches\Block\Adminhtml\Sales\Shipment;

use Magento\Sales\Block\Adminhtml\Items\Renderer\DefaultRenderer;
use Magento\Sales\Model\Shipment\Item;

class Batches extends DefaultRenderer
{
    /**
     * @return array
     */
    public function getBatches()
    {
        $attributes = $this->getItem()->getExtensionAttributes();
        if ($attributes && $attributes->getBatchDetail()) {
            return $attributes->getBatchDetail();
        }
        return [];
    }
}

<?php

namespace WebDev\ShipmentBatches\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use WebDev\ShipmentBatches\Api\Data\BatchInterface;

class Batch extends AbstractExtensibleModel implements BatchInterface
{
    /**
     * Return array with batch information to save as JSON
     *
     * @return array
     */
    public function getBatchData()
    {
        return [
            self::BATCH_NUMBER => $this->getData(self::BATCH_NUMBER),
            self::BATCH_EXPIRY => $this->getData(self::BATCH_EXPIRY)
        ];
    }

    /**
     * @inheritDoc
     */
    public function getBatchDetail()
    {
        return $this->getData(self::BATCH_DETAIL);
    }

    /**
     * @inheritDoc
     */
    public function setBatchDetail($batch)
    {
        return $this->setData(self::BATCH_DETAIL, $batch);
    }

    /**
     * @inheritDoc
     */
    public function getBatchNumber()
    {
        return $this->getData(self::BATCH_NUMBER);
    }

    /**
     * @inheritDoc
     */
    public function getBatchExpiry()
    {
        return $this->getData(self::BATCH_EXPIRY);
    }

    /**
     * @inheritDoc
     */
    public function setBatchNumber($batch)
    {
        return $this->setData(self::BATCH_NUMBER, $batch);
    }

    /**
     * @inheritDoc
     */
    public function setBatchExpiry($batch)
    {
        return $this->setData(self::BATCH_EXPIRY, $batch);
    }
}

<?php

namespace WebDev\ShipmentBatches\Api\Data;

interface BatchInterface
{
    const BATCH_DETAIL = 'batch_detail';
    const BATCH_NUMBER = 'batch_number';
    const BATCH_EXPIRY = 'batch_expiry';

    /**
     * @return mixed
     */
    public function getBatchDetail();

    /**
     * @return string
     */
    public function getBatchNumber();

    /**
     * @return string
     */
    public function getBatchExpiry();

    /**
     * @param array $batch
     * @return mixed
     */
    public function setBatchDetail($batch);

    /**
     * @param $batch
     * @return mixed
     */
    public function setBatchNumber($batch);

    /**
     * @param $batch
     * @return mixed
     */
    public function setBatchExpiry($batch);
}

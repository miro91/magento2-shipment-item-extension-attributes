# Magento 2 Module WebDev ShipmentBatches

    ``webdev/module-shipmentbatches``

 - [Main Functionalities](#markdown-header-main-functionalities)
 - [Installation](#markdown-header-installation)


## Main Functionalities

Simple module showing how to extend shpiment item interface with extension attributes in Magento 2.

Extend REST API endpoint https://magento.redoc.ly/2.4.1-admin/tag/orderorderIdship with extension_attributes for ship items 

Extend Shipment Item interface with extension_attribute: **batch_detail**

Extend shipment view page in admin with new column for **"batch information"**

## Installation

 - Unzip the zip file in `app/code/WebDev/ShipmentBatches`
 - Enable the module by running `php bin/magento module:enable WebDev_ShipmentBatches`
 - Apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`

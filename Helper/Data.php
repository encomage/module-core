<?php

namespace Encomage\Core\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\ProductMetadataInterface;

class Data extends AbstractHelper
{
    /**
     * @var ProductMetadataInterface
     */
    private $productMetadata;

    /**
     * @param Context $context
     * @param ProductMetadataInterface $productMetadata
     */
    public function __construct(
        Context                  $context,
        ProductMetadataInterface $productMetadata
    )
    {
        $this->productMetadata = $productMetadata;
        parent::__construct($context);
    }

    /**
     * @return string
     */
    public function getMagentoVersion()
    {
        return $this->productMetadata->getVersion();
    }
}

<?php
namespace Encomage\Core\Plugin;

use Magento\Framework\App\ProductMetadataInterface;

/**
 * Class RemoveEmptyItems
 *
 * @package Encomage\Core\Plugin
 */
class RemoveEmptyItems
{
    /**
     * @var \Magento\Framework\App\ProductMetadataInterface
     */
    protected $productMetadata;

    /**
     * RemoveEmptyItems constructor.
     *
     * @param \Magento\Framework\App\ProductMetadataInterface $productMetadata
     */
    public function __construct(ProductMetadataInterface $productMetadata)
    {
        $this->productMetadata = $productMetadata;
    }

    /**
     * @return string
     */
    public function getMagentoVersion()
    {
        return $this->productMetadata->getVersion();
    }

    /**
     * @param \Magento\Backend\Block\Menu $object
     * @param \Magento\Backend\Model\Menu $menu
     * @param int $level
     * @param int $limit
     * @param array $colBrakes
     * @return array
     */
    public function beforeRenderNavigation(\Magento\Backend\Block\Menu $object, \Magento\Backend\Model\Menu $menu, $level = 0, $limit = 0, $colBrakes = [])
    {
        if (!$level && $this->getMagentoVersion() == '2.3.0') {
            /** @var \Magento\Backend\Model\Menu\Item $menuItem */
            foreach ($menu->getArrayCopy() as $menuItem) {
                if ($menuItem->getId() == 'Encomage_Core::menu' && (!$menuItem->hasChildren() || count($menuItem->getChildren()) < 2)) {
                    $child = $menuItem->getChildren()->getFirstAvailable();
                    if (!$child->hasChildren()) {
                        $menu->remove($menuItem->getId());
                    }
                }
            }
        }

        return [$menu, $level, $limit, $colBrakes];
    }
}
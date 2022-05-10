<?php

namespace Encomage\Core\Plugin;

use Encomage\Core\Helper\Data as Helper;
use Magento\Backend\Model\Menu\Item;
use Magento\Backend\Block\Menu as MenuBlock;
use Magento\Backend\Model\Menu as MenuModel;

/**
 * Class RemoveEmptyItems
 *
 * @package Encomage\Core\Plugin
 */
class RemoveEmptyItems
{
    private const MINIMAL_MAGENTO_VERSION = "2.3.0";
    private const MENU_ELEMENT_ID = "Encomage_Core::menu";

    /**
     * @var Helper
     */
    protected $helper;

    /**
     * @param Helper $helper
     */
    public function __construct(Helper $helper)
    {
        $this->helper = $helper;
    }

    /**
     * @param MenuBlock $object
     * @param MenuModel $menu
     * @param $level
     * @param $limit
     * @param $colBrakes
     * @return array
     */
    public function beforeRenderNavigation(MenuBlock $object, MenuModel $menu, $level = 0, $limit = 0, $colBrakes = [])
    {
        if (!$level && version_compare($this->helper->getMagentoVersion(), self::MINIMAL_MAGENTO_VERSION) >= 0) {
            /** @var Item $menuItem */
            foreach ($menu->getArrayCopy() as $menuItem) {
                if ($menuItem->getId() == self::MENU_ELEMENT_ID && (!$menuItem->hasChildren() || count($menuItem->getChildren()) < 2)) {
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

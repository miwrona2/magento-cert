<?php
declare(strict_types=1);

namespace Cert\CustomizingMagentoBusinessLogic\Block\Cart;

use Magento\Checkout\Block\Cart\Item\Renderer;

class CustomRenderer extends Renderer
{
    protected function _toHtml()
    {
        $parentHtml = parent::_toHtml();
        $html = $parentHtml . "<p>Custom content</p>";
        return $html;
    }

}

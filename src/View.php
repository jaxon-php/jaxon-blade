<?php

namespace Jaxon\Blade;

use Jaxon\App\View\ViewInterface;
use Jaxon\App\View\Store;
use Jenssegers\Blade\Blade;

use function trim;

class View implements ViewInterface
{
    /**
     * @var Blade
     */
    private Blade $xRenderer;

    /**
     * The constructor
     */
    public function __construct()
    {
        $this->xRenderer = new Blade(__DIR__ . '/../views', __DIR__ . '/../cache');

        // Directives for Jaxon custom attributes
        $this->xRenderer->directive('jxnHtml', function($expression) {
            return '<?php echo Jaxon\attr()->html(' . $expression . '); ?>';
        });
        $this->xRenderer->directive('jxnBind', function($expression) {
            return '<?php echo Jaxon\attr()->bind(' . $expression . '); ?>';
        });
        $this->xRenderer->directive('jxnPagination', function($expression) {
            return '<?php echo Jaxon\attr()->pagination(' . $expression . '); ?>';
        });
        $this->xRenderer->directive('jxnOn', function($expression) {
            return '<?php echo Jaxon\attr()->on(' . $expression . '); ?>';
        });
        $this->xRenderer->directive('jxnClick', function($expression) {
            return '<?php echo Jaxon\attr()->click(' . $expression . '); ?>';
        });
        $this->xRenderer->directive('jxnEvent', function($expression) {
            return '<?php echo Jaxon\attr()->event(' . $expression . '); ?>';
        });
        $this->xRenderer->directive('jxnTarget', function($expression) {
            return '<?php echo Jaxon\attr()->target(' . $expression . '); ?>';
        });

        // Directives for Jaxon Js and CSS codes
        $this->xRenderer->directive('jxnCss', function() {
            return '<?php echo Jaxon\jaxon()->css(); ?>';
        });
        $this->xRenderer->directive('jxnJs', function() {
            return '<?php echo Jaxon\jaxon()->js(); ?>';
        });
        $this->xRenderer->directive('jxnScript', function($expression) {
            return '<?php echo Jaxon\jaxon()->script(' . $expression . '); ?>';
        });
    }

    /**
     * @inheritDoc
     */
    public function addNamespace(string $sNamespace, string $sDirectory, string $sExtension = '')
    {
        if(($sNamespace) && ($sDirectory))
        {
            $this->xRenderer->addNamespace($sNamespace, $sDirectory);
            /*if(($sExtension) && $sExtension != 'blade.php')
            {
                $this->xRenderer->addExtension($sExtension, 'blade');
            }*/
        }
    }

    /**
     * @inheritDoc
     */
    public function render(Store $store): string
    {
        $sNamespace = $store->getNamespace();
        $sViewName = !$sNamespace ? $store->getViewName() :
            $sNamespace . '::' . $store->getViewName();

        // Render the template
        return trim($this->xRenderer->render($sViewName, $store->getViewData()), " \t\n");
    }
}

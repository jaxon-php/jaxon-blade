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

        // Directives for Jaxon Js and CSS codes
        $this->xRenderer->directive('jxnCss', fn() => '<?= Jaxon\jaxon()->css(); ?>');
        $this->xRenderer->directive('jxnJs', fn() => '<?= Jaxon\jaxon()->js(); ?>');
        $this->xRenderer->directive('jxnScript', fn($expr) => "<?= Jaxon\jaxon()->script($expr); ?>");

        // Directives for Jaxon custom attributes
        $this->xRenderer->directive('jxnBind', fn($expr) => "<?= Jaxon\attr()->bind($expr); ?>");
        $this->xRenderer->directive('jxnHtml', fn($expr) => "<?= Jaxon\attr()->html($expr); ?>");
        $this->xRenderer->directive('jxnPagination', fn($expr) => "<?= Jaxon\attr()->pagination($expr); ?>");
        $this->xRenderer->directive('jxnOn', fn($expr) => "<?= Jaxon\attr()->on($expr); ?>");
        $this->xRenderer->directive('jxnClick', fn($expr) => "<?= Jaxon\attr()->click($expr); ?>");
        $this->xRenderer->directive('jxnEvent', fn($expr) => "<?= Jaxon\Blade\setJxnEvent($expr); ?>");
        $this->xRenderer->directive('jxnPackage', fn($expr) => "<?= Jaxon\attr()->package($expr); ?>");
    }

    /**
     * @inheritDoc
     */
    public function addNamespace(string $sNamespace, string $sDirectory, string $sExtension = ''): void
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

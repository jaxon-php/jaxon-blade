<?php

namespace Jaxon\Blade;

use Jaxon\Contracts\View as ViewContract;
use Jaxon\Ui\View\Store;

use Jenssegers\Blade\Blade as Renderer;

class View implements ViewContract
{
    public function __construct()
    {
        $this->xRenderer = new Renderer(__DIR__ . '/../views', __DIR__ . '/../cache');
    }

    /**
     * Add a namespace to this view renderer
     *
     * @param string        $sNamespace         The namespace name
     * @param string        $sDirectory         The namespace directory
     * @param string        $sExtension         The extension to append to template names
     *
     * @return void
     */
    public function addNamespace($sNamespace, $sDirectory, $sExtension = '')
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
     * Render a view
     *
     * @param Store         $store        A store populated with the view data
     *
     * @return string        The string representation of the view
     */
    public function render(Store $store)
    {
        $sViewName = $store->getViewName();
        $sNamespace = $store->getNamespace();
        // In this view renderer, the namespace must always be prepended to the view name.
        if(substr($sViewName, 0, strlen($sNamespace) + 2) != $sNamespace . '::')
        {
            $sViewName = $sNamespace . '::' . $sViewName;
        }

        // Render the template
        return trim($this->xRenderer->render($sViewName, $store->getViewData()), " \t\n");
    }
}

<?php

namespace Jaxon\Blade;

use function is_array;
use function Jaxon\attr;
use function Jaxon\jaxon;

jaxon()->di()->getViewRenderer()
    ->addRenderer('blade', fn() => new View());

/**
 * Set event handlers
 *
 * @param array $events
 *
 * @return string
 */
function setJxnEvent(array $events): string
{
    return isset($events[0]) && is_array($events[0]) ?
        attr()->events($events) : attr()->event($events);
}

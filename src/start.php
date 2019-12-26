<?php

jaxon()->di()->getViewManager()->addRenderer('blade', function () {
    return new Jaxon\Blade\View();
});

<?php

jaxon()->sentry()->addViewRenderer('blade', function () {
    return new Jaxon\Blade\View();
});

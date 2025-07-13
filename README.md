Jaxon View for Blade
====================

Render Blade templates in Jaxon applications.

Installation
------------

Install this package with Composer.

```json
"require": {
    "jaxon-php/jaxon-blade": "^5.0"
}
```

Usage
-----

For each directory containing Blade templates, add an entry to the `app.views` section in the configuration.

```php
    'app' => [
        'views' => [
            'demo' => [
                'directory' => '/path/to/demo/views',
                'extension' => '.blade.php',
                'renderer' => 'blade',
            ],
        ],
    ],
```

In the following example, the DOM element with id `content-id` is assigned the value of the `/path/to/demo/views/sub/dir/file.blade.php` template.

```php
class MyClass extends \Jaxon\App\FuncComponent
{
    public function action()
    {
        $this->response->html('content-id', $this->view()->render('demo::/sub/dir/file'));
    }
}
```

Blade directives
----------------

This extension registers the following Blade directives to insert Jaxon js and css codes in the pages that need to show Jaxon related content.

```php
// /path/to/demo/views/sub/dir/file.blade.php

<!-- In page header -->
@jxnCss()
</head>

<body>

<!-- Page content here -->

</body>

<!-- In page footer -->
@jxnJs()

@jxnScript()
```

Call factories
--------------

This extension registers the following Blade directives for Jaxon [call factories](https://www.jaxon-php.org/docs/v5x/ui-features/call-factories.html) functions.

> [!NOTE]
> In the following examples, the `$rqAppTest` template variable is set to the value `rq(Demo\Ajax\App\AppTest::class)`.

The `jxnBind` directive attaches a UI component to a DOM element, while the `jxnHtml` directive displays a component HTML code in a view.

```php
    <div class="col-md-12" @jxnBind($rqAppTest)>
        @jxnHtml($rqAppTest)
    </div>
```

The `jxnPagination` directive displays pagination links in a view.

```php
    <div class="col-md-12" @jxnPagination($rqAppTest)>
    </div>
```

The `jxnOn` directive binds an event on a DOM element to a Javascript call defined with a `call factory`.

```php
    <select class="form-select"
        @jxnOn('change', $rqAppTest->setColor(jq()->val()))>
        <option value="black" selected="selected">Black</option>
        <option value="red">Red</option>
        <option value="green">Green</option>
        <option value="blue">Blue</option>
    </select>
```

The `jxnClick` directive is a shortcut to define a handler for the `click` event.

```php
    <button type="button" class="btn btn-primary"
        @jxnClick($rqAppTest->sayHello(true))>Click me</button>
```

The `jxnEvent` directive defines a set of events handlers on the children of a DOM element, using `jQuery` selectors.

```php
    <div class="row" @jxnEvent([
        ['.app-color-choice', 'change', $rqAppTest->setColor(jq()->val())]
        ['.ext-color-choice', 'change', $rqExtTest->setColor(jq()->val())]
    ])>
        <div class="col-md-12">
            <select class="form-control app-color-choice">
                <option value="black" selected="selected">Black</option>
                <option value="red">Red</option>
                <option value="green">Green</option>
                <option value="blue">Blue</option>
            </select>
        </div>
        <div class="col-md-12">
            <select class="form-control ext-color-choice">
                <option value="black" selected="selected">Black</option>
                <option value="red">Red</option>
                <option value="green">Green</option>
                <option value="blue">Blue</option>
            </select>
        </div>
    </div>
```

The `jxnEvent` directive takes as parameter an array in which each entry is an array with a `jQuery` selector, an event and a `call factory`.

Contribute
----------

- Issue Tracker: github.com/jaxon-php/jaxon-blade/issues
- Source Code: github.com/jaxon-php/jaxon-blade

License
-------

The package is licensed under the BSD license.

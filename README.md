# Lang4JS

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Total Downloads][ico-downloads]][link-downloads]

Localization, one of the core features of Laravel, separates language strings from views, so as to serve a robust foundation for multilingual projects. However, `trans()`, `trans_choice()` or the newly-introduced  `__()`, supported by Blade template engine of different version of Laravel, are not usable in Javascript. This issue is definitely inevitable for developing any serious multilingual projects and just what Lang4JS is addressing. When Lang4JS is installed as a package in your Laravel application, you are able to use `trans()`, `trans_choice()` and `__()` in Javascript with the same syntax just as in Blade templates, the language strings defined in files under `resources/lang` folder are retrieved correspondently and displayed right to the users. Lang4JS is very easy to use and lightweight, merely a 3Kb controller file and a 4Kb minified JS file.

## Compatability

Lang4JS is compatible with Laravel 4.2+.

## Installation

1) Via Composer

``` bash
$ composer require drewneon/lang4js
```

2) Then add the service provider in `config/app.php`:

```php
DrewNeon\Lang4JS\Lang4JSServiceProvider::class,
```

3) And publish the asset file, i.e. `lang4js.min.js`:

``` bash
$ php artisan vendor:publish --tag=public --force
```

4) Finally, add a route in `routes/web.php`:

```php
Route::post('/lang4js', ['as' => 'post', 'uses' => '\DrewNeon\Lang4JS\Lang4JSController@lang4js']);
```

## Usage

1) Language Strings

Lang4JS retrieves language strings directly from your language files resides in `resources/lang` folder. Please add lines supposed to be used in your Javascript as those for your view blades.

2) Load Javascript Libraries

Lang4JS requires _[jQuery] (http://jquery.com)_ library, you have to load it before the `lang4js.min.js`. So in any view blades you want to apply multilingual strings in Javascript, please insert these two lines:

```html
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="/vendor/lang4js/lang4js.min.js"></script>
```

__3) Absolute Path__

Both `post('/lang4js',` in route and `src="/vendor/lang4js/lang4js.min.js"` in view uses absolute path for the convenience to include the script from any URL. This means you have to point your domain to the `public` folder in your project, instead of the root folder, otherwise, a 404 error will occur or modify the paths according to your own environment.

__4) CSRF Token__

Lang4JS utilizes Ajax requests to retrieve language strings, and this requires CSRF Token in Laravel. There are two ways to set CSRF Token in your webpages.

1. If the webpage contains a form, you may have probably had the line `{{ csrf_field() }}` in there. If not, add the line somewhere between `<form>...</form>`.
2. If the webpage is not for form submission, please add `<meta name="csrf-token" content="{{ csrf_token() }}">` into `<head>...</head>`.

In terms of security of you website, it's a good practice to always have CSRF Token presented in all webpages, which can be easily done by adding the meta tag for CSRF Token in the head sub-view for all views.

5) Use Language Keys in Javascript

Now in your Javascript, feel free to use `trans()`, `trans_choice()` as well as `__()` newly introduced in Laravel 5.4. Please refer to the Localization document according to your Laravel version for more information. For example:

* `trans('messages.welcome')` or `__('messages.welcome')` translates to the string defined in the line `'welcome' => ''` of the file `resources/lang/[locale]/messages.php`;
* `trans_choice('messages.apples', 10)` translates to the plural part of the line `'apples' => '|'` in `resources/lang/[locale]/messages.php`.

__The only difference in syntax__

When using the place-holder feature of `trans()` or `__()`, the syntax `['name' => 'dayle']` does __NOT__ work, please write `{'name' : 'dayle'}` instead.

__Two More Issues__

1. `trans()`, `trans_choice()` or `__()` in your Javascript does __NOT__ work before the DOM is ready, and will halt your entire Javascript. Please use them in functions.
2. It's also a fatal error when there's no `trans()` nor `trans_choice()` nor `__()` at all in your Javascript. To fix this, just remove `<script src="/vendor/lang4js/lang4js.min.js"></script>` from you view.

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email drewneon@gmail.com instead of using the issue tracker.

## Credits

- [Drew Neon][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/drewneon/lang4js.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/drewneon/lang4js/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/drewneon/lang4js.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/drewneon/lang4js.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/drewneon/lang4js.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/drewneon/lang4js
[link-travis]: https://travis-ci.org/drewneon/lang4js
[link-scrutinizer]: https://scrutinizer-ci.com/g/drewneon/lang4js/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/drewneon/lang4js
[link-downloads]: https://packagist.org/packages/drewneon/lang4js
[link-author]: https://github.com/DrewNeon
[link-contributors]: ../../contributors

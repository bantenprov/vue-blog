# Vue Blog
Laravel blog content with vuejs suport
## [TODO : ](https://github.com/bantenprov/vue-blog/blob/master/TODO.md) :

Basic Blog Package
==================
This package is under development.

## Install Laravel :
```bash
$ composer create-project --prefer-dist laravel/laravel project-name "5.4.*"
$ php artisan make:auth
```

add in layout/app.php after
```html
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
<script>  var base_url = "{{ url('/') }}";</script>
```

## Install VueJs :
```bash
$ cd my-project

$ npm install
# latest stable
$ npm install vue
```

Add the package service provider to the `providers` array on `/config/app.php`:

```php
// /config/app.php
'providers' => [

    // Blog Package
    Bantenprov\VueBlog\BlogServiceProvider::class,
    Collective\Html\HtmlServiceProvider::class,

];
'aliases' => [
    'Form' => Collective\Html\FormFacade::class,
    'Html' => Collective\Html\HtmlFacade::class,
];
```

Add the `BlogUserTrait` to your `User` model. This sets up Eloquent relationships:

```php
<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Bantenprov\VueBlog\Traits\BlogUserTrait;

class User extends Authenticatable
{
    use Notifiable;
    use BlogUserTrait;

}
```


## Artisan command :

```bash
$ php artisan vendor:publish --tag=vue_assets
$ php artisan vendor:publish --tag=vue_migrations
$ php artisan migrate
```

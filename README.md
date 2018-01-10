# Vue Blog
Laravel blog content with vuejs suport
## [TODO : ](https://github.com/bantenprov/vue-blog/blob/master/TODO.md) :

Basic Blog Package
==================
This package is under development.

## Install Laravel :
```bash
$ composer create-project --prefer-dist laravel/laravel project-name "5.4.*"
$ cd project-name
$ php artisan make:auth
```

add in layout/app.blade.php after
```html
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
<script>  var base_url = "{{ url('/') }}";</script>
@stack('script')
```

## Install VueJs :
```bash
$ npm install
# latest stable
$ npm install vue
$ npm run dev
```

## Install Vue Blog :
```bash
$ composer require bantenprov/vue-blog:"1.0.0"
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

Change app.js in resources/assets/js/app.js
```html
// Vue.component('example', require('./components/Example.vue'));
//
// const app = new Vue({
//     el: '#app'
// });
Vue.component('vue-pagination', require('./components/pagination.vue'));
```

## Artisan command :

```bash
$ php artisan vendor:publish --tag=vue_assets
$ php artisan vendor:publish --tag=vue_migrations
$ npm run dev
$ php artisan migrate
```

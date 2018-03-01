# Vue Blog

[![Join the chat at https://gitter.im/vue-blog/Lobby](https://badges.gitter.im/vue-blog/Lobby.svg)](https://gitter.im/vue-blog/Lobby?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/bantenprov/vue-blog/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bantenprov/vue-blog/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/bantenprov/vue-blog/badges/build.png?b=master)](https://scrutinizer-ci.com/g/bantenprov/vue-blog/build-status/master)
[![Latest Stable Version](https://poser.pugx.org/bantenprov/vue-blog/v/stable)](https://packagist.org/packages/bantenprov/vue-blog)
[![Total Downloads](https://poser.pugx.org/bantenprov/vue-blog/downloads)](https://packagist.org/packages/bantenprov/vue-blog)
[![Latest Unstable Version](https://poser.pugx.org/bantenprov/vue-blog/v/unstable)](https://packagist.org/packages/bantenprov/vue-blog)
[![License](https://poser.pugx.org/bantenprov/vue-blog/license)](https://packagist.org/packages/bantenprov/vue-blog)
[![Monthly Downloads](https://poser.pugx.org/bantenprov/vue-blog/d/monthly)](https://packagist.org/packages/bantenprov/vue-blog)
[![Daily Downloads](https://poser.pugx.org/bantenprov/vue-blog/d/daily)](https://packagist.org/packages/bantenprov/vue-blog)

Laravel blog content with vuejs suport
## [TODO : ](https://github.com/bantenprov/vue-blog/blob/master/TODO.md) :

Basic Blog Package
==================
This package is under development.

## Install Laravel :
```bash
$ composer create-project bantenprov/tanara:dev-dev htdocs
$ cd htdocs
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

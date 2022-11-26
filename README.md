# Random Image

[![Latest Version on Packagist](https://img.shields.io/packagist/v/emsifa/random-image.svg?style=flat-square)](https://packagist.org/packages/emsifa/random-image)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/emsifa/random-image/run-tests?label=tests)](https://github.com/emsifa/random-image/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/emsifa/random-image/Fix%20PHP%20code%20style%20issues?label=code%20style)](https://github.com/emsifa/random-image/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/emsifa/random-image.svg?style=flat-square)](https://packagist.org/packages/emsifa/random-image)

Random Image is a Laravel helper to get random image from [Unsplash](https://www.unsplash.com) and store it in your application. It is designed to be used in [model factory](https://laravel.com/docs/9.x/eloquent-factories) to seed dummy data.   

## Features

* [x] Get random image URL with search terms support.
* [x] Store random image to filesystem.
* [x] Manipulate downloaded image.
* [x] Copy downloaded image and manipulate it (for thumbnail/placeholder image generation).

## Installation

You can install the package via composer:

```bash
composer require emsifa/random-image --dev
```

> Remove `--dev` flag if you are planned to use this library in production

After that, you may want to publish the config file with:

```bash
php artisan vendor:publish --tag="random-image-config"
```

## Usage Example

### Get Random Image URL

If you just want to get unsplash random url, you can use `url` method like an example below:

```php
use Emsifa\RandomImage\RandomImage;

RandomImage::make()->url();
```

It will return `https://source.unsplash.com/random/` which will resulting different image if you use it in `<img/>` tag.

You can also specify size and search terms inside `make` method like this:

```php
RandomImage::make(200)->url();                  // "https://source.unsplash.com/random/200x200/"
RandomImage::make(300, 200)->url();             // "https://source.unsplash.com/random/300x200/"
RandomImage::make(300, 200, 'cat,dog')->url();  // "https://source.unsplash.com/random/300x200/?cat,dog"
RandomImage::make(query: 'cats')->url();        // "https://source.unsplash.com/random/?cats"
```

### Store Image

You can use `store` or `storeAs` method to download and store image into your filesystem disk.

```php
RandomImage::make()->store();           // "{random-hash-name}.jpg"
RandomImage::make()->store('images');   // "images/{random-hash-name}.jpg"
```

You can specify disk by defining `disk` parameter:

```php
RandomImage::make()->store('images', 's3'); // "images/{random-hash-name}.jpg"
RandomImage::make()->store(disk: 's3');     // "{random-hash-name}.jpg"
```

Use `storeAs` if you want to specify filename:

```php
RandomImage::make()->storeAs('my-image.jpg');        // "my-image.jpg"
RandomImage::make()->storeAs('images/my-image.jpg'); // "images/my-image.jpg"
```

You can also get stored URL just by chaining it with `url()` method like example below:

```php
RandomImage::make()->store()->url();            // "http://your-app.test/storage/{random-hash-name}.jpg"
RandomImage::make()->store('images')->url();    // "http://your-app.test/storage/images/{random-hash-name}.jpg"

RandomImage::make()->storeAs('my-image.jpg')->url();        // "http://your-app.test/storage/my-image.jpg"
RandomImage::make()->storeAs('images/my-image.jpg')->url(); // "http://your-app.test/storage/images/my-image.jpg"
```

### Usage Example in Model Factory

This package is designed to be used in the model factory, which is why the 3 methods above return a string. So to use it in the model factory you can just call the method in the example above in your model factory like this:

```php
<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Emsifa\RandomImage\RandomImage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->words(5, true),
            'body' => $this->faker->paragraphs(5, true),
            'image' => RandomImage::make(600, 400)->store('posts', 'public'),
        ];
    }
}
```

When you seed posts data using factory above, you can use `Storage::disk('public')->url($post->image)` to get the url. 

### Copy and Manipulate Downloaded Image

In most case you may want to create a thumbnail version of the same image. We wrap some APIs from [intervention/image](https://image.intervention.io/v2) to do that kind of stuff.

For example, in Post factory above, we want to define `thumbnail` field that contain a path for 300x200px version of the image:

```php
public function definition()
{
    $image = RandomImage::make(600, 400)->store('posts', 'public');
    $thumbnail = $image->copy()->fit(300, 200);

    // Resize to 300x200px and make it greyscale
    // $thumbnail = $image->copy()->fit(300, 200)->greyscale();

    // Use copyAs if you want to specify filename 
    // $thumbnail = $image->copyAs('posts/my-thumb.jpg')->fit(300, 200);

    return [
        'title' => $this->faker->words(5, true),
        'body' => $this->faker->paragraphs(5, true),
        'image' => $image,
        'thumbnail' => $thumbnail,
    ];
}
```

Here is a list of manipulation methods you can use:

* `resize(width, height)`: Resizes current image based on given width and/or height. [(intervention docs)](https://image.intervention.io/v2/api/resize)
* `crop(width, height, x, y)`: Cut out a rectangular part of the current image with given width and height. [(intervention docs)](https://image.intervention.io/v2/api/crop)
* `fit(width, height)`: Combine cropping and resizing to format image in a smart way. [(intervention docs)](https://image.intervention.io/v2/api/fit)
* `widen(width)`: Resizes the current image to new width, constraining aspect ratio. [(intervention docs)](https://image.intervention.io/v2/api/widen)
* `heighten(height)`: Resizes the current image to new height, constraining aspect ratio. [(intervention docs)](https://image.intervention.io/v2/api/heighten)
* `greyscale()`: Turns image into a greyscale version. [(intervention docs)](https://image.intervention.io/v2/api/greyscale).
* `blur()`: Apply a gaussian blur filter with a optional amount on the current image. [(intervention docs)](https://image.intervention.io/v2/api/blur)

> All methods above is available on the `ImageResult` instance which is returned from `store` method. So you can use it not only to copied image. But the original stored image too.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Muhammad Syifa](https://github.com/emsifa) (creator)
- [Unsplash](https://unsplash.com/) (image source)
- [Spatie](https://github.com/spatie/package-skeleton-laravel) (package skeleton)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

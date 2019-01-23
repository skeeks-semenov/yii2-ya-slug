Yii2 yandex slug (Semantic URL)
===================================

This solution allows you to generate good slug urls. ([slug wiki](https://en.wikipedia.org/wiki/Semantic_URL)).

Direct generation is engaged in a proven solution [cocur/slugify](https://github.com/cocur/slugify).

Transliteration yandex http://translit-online.ru/yandex.html

[![Latest Stable Version](https://img.shields.io/packagist/v/skeeks/yii2-ya-slug.svg)](https://packagist.org/packages/skeeks/yii2-ya-slug)
[![Total Downloads](https://img.shields.io/packagist/dt/skeeks/yii2-ya-slug.svg)](https://packagist.org/packages/skeeks/yii2-ya-slug)

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist skeeks/yii2-ya-slug "*"
```

or add

```
"skeeks/yii2-ya-slug": "*"
```


How to use
----------

### behavior

Attach the behavior in your model:

```php
public function behaviors()
{
    return [
        'slug' => [
            'class' => 'skeeks\yii2\yaslug\YaSlugBehavior',
            'slugAttribute' => 'slug',                      //The attribute to be generated
            'attribute' => 'name',                          //The attribute from which will be generated
            // optional params
            'maxLength' => 64,                              //Maximum length of attribute slug
            'minLength' => 3,                               //Min length of attribute slug
            'ensureUnique' => true,
        ]
    ];
}

```


### helper

```php
echo skeeks\yii2\yaslug\YaSlugBehavior::slugify("Тестовая строка");
```

Links
----------
* [Github](https://github.com/skeeks-semenov/yii2-ya-slug)
* [Changelog](https://github.com/skeeks-semenov/yii2-ya-slug/blob/master/CHANGELOG.md)
* [Issues](https://github.com/skeeks-semenov/yii2-ya-slug/issues)
* [Packagist](https://packagist.org/packages/skeeks/yii2-ya-slug)


Demo (view urls)
----------
* [https://skeeks.com](https://skeeks.com)

___

> [![skeeks!](https://skeeks.com/img/logo/logo-no-title-80px.png)](https://skeeks.com)  
<i>SkeekS CMS (Yii2) — fast, simple, effective!</i>  
[skeeks.com](https://skeeks.com) | [cms.skeeks.com](https://cms.skeeks.com)


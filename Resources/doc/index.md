SyliusBloggerBundle documentation.
=====================================

Highly flexible bundle that adds blog feature to your Symfony2 application.

In this documentation you will learn how to install and work with it. Have a nice read.

**Note!** This documentation is inspired by [FOSUserBundle docs](https://github.com/FriendsOfSymfony/FOSUserBundle/blob/master/Resources/doc/index.md).

Installation.
-------------

+ Installing dependencies.
+ Downloading the bundle.
+ Autoloader configuration.
+ Adding bundle to kernel.
+ Creating your Post class.
+ DIC configuration.
+ Importing routing cfgs.
+ Updating database schema.

### Installing dependencies.

This bundle uses Pagerfanta library and PagerfantaBundle.
The installation guide can be found [here](https://github.com/whiteoctober/WhiteOctoberPagerfantaBundle).

### Downloading the bundle.

The good practice is to download the bundle to the `vendor/bundles/Sylius/Bundle/BloggerBundle` directory.

This can be done in several ways, depending on your preference. The first
method is the standard Symfony2 method.

**Using the vendors script.**

Add the following lines in your `deps` file...

```
[SyliusBloggerBundle]
    git=git://github.com/Sylius/SyliusBloggerBundle.git
    target=bundles/Sylius/Bundle/BloggerBundle
```

Now, run the vendors script to download the bundle.

``` bash
$ php bin/vendors install
```

**Using submodules.**

If you prefer instead to use git submodules, the run the following:

``` bash
$ git submodule add git://github.com/Sylius/SyliusBloggerBundle.git vendor/bundles/Sylius/Bundle/BloggerBundle
$ git submodule update --init
```

### Autoloader configuration.

Add the `Sylius\Bundle` namespace to your autoloader.

``` php
<?php
// app/autoload.php

$loader->registerNamespaces(array(
    // ...
    'Sylius\\Bundle' => __DIR__.'/../vendor/bundles',
));
```

### Adding bundle to kernel.

Finally, enable the bundle in the kernel.

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Sylius\Bundle\BloggerBundle\SyliusBloggerBundle(),
    );
}
```
### Creating your Post class or using the default one.

If you want to quick start and test the bundle, you can use the default post class.

`Sylius\Bundle\BloggerBundle\Entity\DefaultPost`...

Next step is creating your desired Post class. Its totally up to you how your post will look like so...
What are your waiting for?

``` php
<?php
// src/Application/Bundle/BloggerBundle/Entity/Post.php

namespace Application\Bundle\BloggerBundle\Entity;

use Sylius\Bundle\BloggerBundle\Entity\Post as BasePost;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_blogger_post")
 */
class Post extends BasePost
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
}
```

### Container configuration.

Now you have to do the minimal configuration, no worries, it is not painful.

Open up your `config.yml` file and add this...

``` yaml
sylius_blogger:
    driver: ORM
    classes:
        model:
            post: Application\Bundle\BloggerBundle\Entity\Post # or the default post class.
```

`Please note, that the "ORM" is currently the only supported driver.`

### Import routing files.

Now is the time to import routing files. Open up your `routing.yml` file. Customize the prefixes or whatever you want.

``` yaml
sylius_assortment_post:
    resource: "@SyliusBloggerBundle/Resources/config/routing/frontend/post.yml"
    prefix: /blog/posts

sylius_assortment_backend_post:
    resource: "@SyliusBloggerBundle/Resources/config/routing/backend/post.yml"
    prefix: /administration/blog/posts
```

### Updating database schema.

The last thing you need to do is updating the database schema.

For "ORM" driver run the following command.

``` bash
$ php app/console doctrine:schema:update --force
```

### Post categories.

If you want to categorize posts use [SyliusCatalogBundle](http://github.com/Sylius/SyliusCatalogBundle).

Nice example can be found [here](http://blog.diweb.pl/7/easy-categorizing-with-symfony2).

### Finish.

That is all, I hope it was not so bad.
Now you can visit `/administration/posts/list` to see the list of posts.
It will be of course empty so use the "create post" link to change it!
Customize the your post class, the post form and whatever you want.

`This documentation is WIP.`

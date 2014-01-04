# Sculpin Editor Bundle

## Setup

Add this bundle in your ```sculpin.json``` file:

```json
{
    // ...
    "require": {
        // ...
        "mavimo/sculpin-editor-bundle": "@dev"
    }
}
```

and install this bundle running ```sculpin update```.

Now you can register the bundle in ```SculpinKernel``` class available on ```app/SculpinKernel.php``` file:

```php
class SculpinKernel extends \Sculpin\Bundle\SculpinBundle\HttpKernel\AbstractKernel
{
    protected function getAdditionalSculpinBundles()
    {
        return array(
           'Mavimo\Sculpin\Bundle\EditorBundle\SculpinEditorBundle'
        );
    }
}
```

## How to use

Content editor can create a new content typing:

```
sculpin editor:create "New content title"
```

this generate a new draft content using the current date on the path:

```
source/_posts/2014-01-04-new-content-title.md
```

you can also specify a different date using the format "Y-m-d", like:

```
sculpin editor:create -d 2010-06-10 "New content title"
```

that genrate file:
```
source/_posts/2010-06-10-new-content-title.md
```

You can also create a different content type (WIP, see [Sculpin PR 96](https://github.com/sculpin/sculpin/pull/96)) using the option _type_

```
sculpin editor:create -t project "New content title"
```

this generate a new draft project in the folder:

```
source/_projects/2014-01-04-new-content-title.md
```

## TODO

[_] Add better file writing procedure
[_] Add better support for content type generation after [Sculpin PR 96](https://github.com/sculpin/sculpin/pull/96) integration in sculpin core.

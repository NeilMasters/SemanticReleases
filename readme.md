## SemanticReleases

The SemanticReleases contains utilities to help maintain semantic release versions.

### Versioning()

Encapsulates functionality around bumping version numbers. `Versioning::gerIncreasedVersion()` Will accept a current 
version and increase it depending on it being a major, minor or fix change.

Example usage:

```php
$versioning = new \SemanticReleases\Util\Versioning();
$versioning->getIncreasedVersion('1.0.0'); // $increaseType defaults to major bump 2.0.0
$versioning->getIncreasedVersion('1.0.0', \SemanticReleases\Util\Versioning::MINOR); // 1.1.0
$versioning->getIncreasedVersion('1.0.0', \SemanticReleases\Util\Versioning::FIX); // 1.0.1
```

You can view the unit tests to see every possible combination you can throw at the `getIncreasedVersion()` method.

#### Bad version values

To facilitate conversion from one format to another getIncreasedVersion() will do a lot of work to try and
convert the passed version to a semantic format.

In the event that a version passed does not follow major.minor.fix or is just completely wrong, the 
getIncreasedVersion() method will fix it at best or at worst just give you back a 1.0.0 version.

Examples of non standard input:

```php
$versioning = new \SemanticReleases\Util\Versioning();
$versioning->getIncreasedVersion(1); // 2.0.0
$versioning->getIncreasedVersion(1.1); // 2.0.0
$versioning->getIncreasedVersion('a'); // 1.0.0
$versioning->getIncreasedVersion('a.b'); // 1.0.0
$versioning->getIncreasedVersion('a.b.c'); // 1.0.0
```

To summarise, you will get a correct major.minor.fix version number, regardless what you throw at it. Now, if that is
the value you wanted is a different matter.

#### Empty version

In the event of an empty version we convert it to 0 so the returned version will be 1.0.0. Useful if you are 
initialising versions.
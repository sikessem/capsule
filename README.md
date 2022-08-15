<div align="center"><a href="https://sikessem.com/" title="SIKessEm"><img src="https://github.com/sikessem/sikessem/blob/main/SIKessEm-logo.png" alt="SIKessEm logo"/></a></div>

***

# Get/set PHP class properties dynamically

Capsule allows to get/set a property thanks to the magic methods of PHP by defining the getter/setter of this property.
Capsule also allows you to perform actions before getting/setting and/or after getted/setted a property.


## Installation

Using [composer](https://getcomposer.org/), you can install Capsule with the following command:

```bash
composer require sikessem/capsule
```


## Usage

Encapsulate a property:

```php
<?php

use Sikessem\Capsule\{Encapsulable, Encapsuler};

class MyCapsule implements Encapsulable {
    use Encapsuler;

    // The property to encapsulate must be defined if it has no getter/setter method.
    private mixed $property = 'default value';

    // No need to define this method if the property to get is defined.
    public function getProperty(): mixed {
        return $this->property;
    }

    // No need to define this method if it has no action to perform before getting the property
    public function gettingProperty(): void {
        // The action to perform before getting the property
        echo 'Getting property...' . PHP_EOL;
    }

    // No need to define this method if it has no action to perform after getted the property
    public function gettedProperty(): void {
        // The action to perform after getted the property
        echo 'Getted property...' . PHP_EOL;
    }

    // No need to define this method if the property to set is defined.
    public function setProperty(mixed $value) {
        $this->property = $value;
    }

    // No need to define this method if it has no action to perform before setting the property
    public function settingProperty(mixed $value): void {
        // The action to perform before setting the property
        echo 'Setting property...' . PHP_EOL;
    }

    // No need to define this method if it has no action to perform after setted the property
    public function settedProperty(mixed $value): void {
        // The action to perform after setted the property
        echo 'Setted property...' . PHP_EOL;
    }
}
```

Get/set a property:

```php
<?php

$capsule = new MyCapsule();
echo "Property: $capsule->property" . PHP_EOL;
$capsule->property = 'new value';
echo "Property: $capsule->property" . PHP_EOL;
```

The above code will output:

```bash
Getting property...
Getted property...
default value
Setting property...
Setted property...
Getting property...
Getted property...
new value
```

## License

This library is distributed under the [![License](https://img.shields.io/badge/license-MIT-blue.svg)](https://opensource.org/licenses/MIT)


## Security Reports

Please send any sensitive issue to [opensource@sikessem.com](mailto:opensource@sikessem.com). Thanks!

<div align="center">
    <div><a href="https://sikessem.com/" title="Sikessem"><img src="https://github.com/sikessem/art/blob/HEAD/images/sikessem.svg" alt="Sikessem logo" height="256"/></a></div>
    <div>
        <a href="https://github.com/sikessem/capsule"><img alt="Capsule" src="https://img.shields.io/badge/Capsule-enabled-brightgreen.svg?style=flat"/></a>
        <a href="https://github.com/sikessem/capsule/blob/HEAD/LICENSE"><img src="https://img.shields.io/badge/license-MIT-blue.svg" alt="Capsule is released under the MIT license."/></a>
        <a href="https://github.com/sikessem/capsule/actions"><img alt="GitHub Workflow Status (main)" src="https://github.com/sikessem/capsule/workflows/Tests/badge.svg"/></a>
        <a href="https://packagist.org/packages/sikessem/capsule"><img alt="Total Downloads" src="https://img.shields.io/packagist/dt/sikessem/capsule"/></a>
        <a href="https://packagist.org/packages/sikessem/capsule"><img alt="Latest Version" src="https://img.shields.io/packagist/v/sikessem/capsule"/></a>
        <a href="https://github.com/sikessem/.github/blob/HEAD/CONTRIBUTING.md"><img src="https://img.shields.io/badge/PRs-welcome-brightgreen.svg" alt="PRs welcome!"/></a>
        <a href="https://twitter.com/intent/follow?screen_name=sikessem_tweets"><img src="https://img.shields.io/twitter/follow/sikessem_tweets.svg?label=Follow%20@sikessem_tweets" alt="Follow @sikessem_tweets"/></a>
    </div>
</div>

***

# Get/set PHP class properties dynamically

Capsule allows you to get/set a property and add methods to an object and/or a class dynamically thanks to the magic methods of PHP by defining the getter/setter of the property and/or the method to add.

## 🔖 Contents

- [Get/set PHP class properties dynamically](#getset-php-class-properties-dynamically)
  - [🔖 Contents](#-contents)
  - [📋 Requirements](#-requirements)
  - [⚡️ Installation](#️-installation)
  - [🧑‍💻 Usage](#-usage)
  - [🔐 Security Reports](#-security-reports)

## 📋 Requirements

> - **Requires [PHP 8.1+](https://php.net/releases/)** (at least 8.1.14 recommended to avoid potential bugs).
> - **Requires [Composer v2+](https://getcomposer.org/)** to manage PHP dependencies.

## ⚡️ Installation

Install [Capsule](https://packagist.org/packages/sikessem/capsule) using [Composer](https://getcomposer.org/):

- By adding the `sikessem/capsule` dependency to your `composer.json` file:

    ```json
    {
        "require" : {
            "sikessem/capsule": "^0.4"
        }
    }
    ```

- Or by including the dependency:

    ```bash
    composer require sikessem/capsule --no-dev
    ```

## 🧑‍💻 Usage

- Define your custom capsule using Capsule's interface and traits:

    ```php
    <?php

    use Sikessem\Capsule\Interfaces\Accessible;
    use Sikessem\Capsule\Interfaces\Modifiable;
    use Sikessem\Capsule\Interfaces\Resolvable;
    use Sikessem\Capsule\Traits\Accessor;
    use Sikessem\Capsule\Traits\Modifier;
    use Sikessem\Capsule\Traits\Resolver;

    class Capsule implements Accessible, Modifiable, Resolvable
    {
        use Accessor, Modifier, Resolver;

        // The Capsule code...
    }
    ```

- Or you can use Base Capsule or Base Getter/Setter/Caller:

    ```php
    <?php

    use Sikessem\Capsule\Bases\BaseCapsule;

    class Capsule extends BaseCapsule
    {
        // The Capsule code...
    }
    ```

    ```php
    <?php

    use Sikessem\Capsule\Bases\BaseGetter;

    class Getter extends BaseGetter
    {
        // The Getter code...
    }
    ```

    ```php
    <?php

    use Sikessem\Capsule\Bases\BaseSetter;

    class Setter extends BaseSetter
    {
        // The Setter code...
    }
    ```

    ```php
    <?php

    use Sikessem\Capsule\Bases\BaseCaller;

    class Setter extends BaseCaller
    {
        // The Setter code...
    }
    ```

1. Consider the Capsule below:

    ```php
    <?php

    namespace App;

    use Sikessem\Capsule\Interfaces\Accessible;
    use Sikessem\Capsule\Interfaces\Modifiable;
    use Sikessem\Capsule\Interfaces\Resolvable;
    use Sikessem\Capsule\Traits\Accessor;
    use Sikessem\Capsule\Traits\Modifier;
    use Sikessem\Capsule\Traits\Resolver;

    class Capsule implements Accessible, Modifiable, Resovable
    {
        use Accessor, Modifier, Resolver;

        public function getName(): string
        {
            return 'capsule';
        }

        protected mixed $value = null;

        public function setValue(mixed $value = null): void
        {
            if (isset($value)) {
                $this->value = $value;
            } else {
                unset($this->value);
            }
            
        }
    }
    ```

2. You can use the capsule as below:

    ```php
    <?php

    use App\Capsule;

    $capsule = new Capsule();

    isset($capsule->name); // Returns true

    echo $capsule->name; // Prints "capsule"

    unset($capsule->name); // Does nothing

    isset($capsule->name); // Returns true

    $capsule->name = 'value'; // Throws an exception

    $capsule->value = 'value'; // Set value to "value"

    echo $capsule->value; // Prints "value"

    unset($capsule->value); // Remove the value

    isset($capsule->value); // Returns false

    $capsule->on('hello', function (?string $name = null) {
        return 'Hello '.($name ?? 'Sikessem').'!';
    });

    echo $capsule->hello(); //Prints "Hello Sikessem!"
    ```

## 🔐 Security Reports

If you discover a security vulnerability within Capsule, please email [SIGUI Kessé Emmanuel](https://github.com/SIGUIKE) at [ske@sikessem.com](mailto:ske@sikessem.com). All security vulnerabilities will be promptly addressed.

***

Capsule was developed by [Sikessem](https://sikessem.com).

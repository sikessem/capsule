<div align="center">

[![sikessem-logo]][sikessem-link]

<br/>

[![php-icon]][php-link]
[![packagist-version-icon]][packagist-version-link]
[![packagist-download-icon]][packagist-download-link]
[![license-icon]][license-link]
[![enabled-icon]][enabled-link]
[![actions-icon]][actions-link]
[![pr-icon]][pr-link]
[![twitter-icon]][twitter-link]

</div>

[sikessem-logo]: https://github.com/sikessem/art/blob/HEAD/images/sikessem.svg
[sikessem-link]: https://github.com/sikessem "Sikessem"

[enabled-icon]: https://img.shields.io/badge/Capsule-enabled-brightgreen.svg?style=flat
[enabled-link]: https://github.com/sikessem/capsule "Capsule enabled"

[actions-icon]: https://github.com/sikessem/capsule/workflows/Tests/badge.svg
[actions-link]: https://github.com/sikessem/capsule/actions "Capsule status"

[php-icon]: https://img.shields.io/badge/PHP-ccc.svg?style=flat&logo=php
[php-link]: https://github.com/sikessem/capsule/search?l=php "PHP code"

[packagist-version-icon]: https://img.shields.io/packagist/v/sikessem/capsule
[packagist-version-link]: https://packagist.org/packages/sikessem/capsule "Capsule Releases"

[packagist-download-icon]: https://img.shields.io/packagist/dt/sikessem/capsule
[packagist-download-link]: https://packagist.org/packages/sikessem/capsule "Capsule Downloads"

[pr-icon]: https://img.shields.io/badge/PRs-welcome-brightgreen.svg?color=brightgreen
[pr-link]: [contrib-link] "PRs welcome!"

[twitter-icon]: https://img.shields.io/twitter/follow/sikessem.svg?label=@sikessem_tweets
[twitter-link]: https://twitter.com/intent/follow?screen_name=sikessem_tweets "Ping Sikessem"

[license-icon]: https://img.shields.io/badge/license-MIT-blue.svg
[license-link]: https://github.com/sikessem/capsule/blob/HEAD/LICENSE "Capsule License"
[conduct-link]: https://github.com/sikessem/capsule/blob/HEAD/CODE_OF_CONDUCT.md
[contrib-link]: https://github.com/sikessem/.github/blob/HEAD/CONTRIBUTING.md
[discuss-link]: https://github.com/orgs/sikessem/discussions
[docs-link]: https://github.com/sikessem/capsule#readme "Capsule Documentation"

***

# An Efficient Dependency Injector and Encapsulator

Capsule is a library that uses a Container to manage dependencies and objects in an organized and centralized way, thus facilitating encapsulation.

## 🔖 Contents

- [An Efficient Dependency Injector and Encapsulator](#an-efficient-dependency-injector-and-encapsulator)
  - [🔖 Contents](#-contents)
  - [📖 Documentation](#-documentation)
  - [📋 Requirements](#-requirements)
  - [🎉 Getting Started](#-getting-started)
    - [⚡️ Installation](#️-installation)
    - [🧑‍💻 Usage](#-usage)
  - [🧪 Testing and debugging](#-testing-and-debugging)
  - [👏 Contribution](#-contribution)
    - [👷 Code of Conduct](#-code-of-conduct)
    - [👥 Contributing Guide](#-contributing-guide)
    - [🔒️ Good First Issues](#️-good-first-issues)
    - [💬 Discussions](#-discussions)
  - [🔐 Security Reports](#-security-reports)
  - [📄 License](#-license)


## 📖 Documentation

The full documentation for the Sikessem Capsule can be found on [this address][docs-link].

## 📋 Requirements

> - **Requires [PHP 8.1+](https://php.net/releases/)** (at least 8.1.19 recommended to avoid potential bugs).
> - **Requires [Composer v2+](https://getcomposer.org/)** to manage PHP dependencies.

## 🎉 Getting Started

### ⚡️ Installation

Install [Capsule](https://packagist.org/packages/sikessem/capsule) using [Composer](https://getcomposer.org/):

- By adding the `sikessem/capsule` dependency to your `composer.json` file:

    ```json
    {
        "require" : {
            "sikessem/capsule": "^0.5"
        }
    }
    ```

- Or by including the dependency:

    ```shell
    composer require sikessem/capsule --no-dev
    ```

### 🧑‍💻 Usage

1. Define your custom components using Capsule's interfaces and traits:

    ```php
    <?php

    namespace Sikessem\Capsule\Sample;

    use Sikessem\Capsule\IsEncapsulated;

    interface CustomInterface extends IsEncapsulated
    {
        public function getName(): string;

        public function setName(string $name): void;
    }
    ```

    ```php
    <?php

    namespace Sikessem\Capsule\Sample;

    final class CustomClass implements CustomInterface
    {
        use CustomTrait;

        public function __construct(string $name = 'World')
        {
            $this->setName($name);
        }
    }
    ```

    ```php
    <?php

    namespace Sikessem\Capsule\Sample;

    use Sikessem\Capsule\HasEncapsulator;

    trait CustomTrait
    {
        use HasEncapsulator;

        protected string $name;

        public function getName(): string
        {
            return $this->name;
        }

        public function setName(string $name): void
        {
            $this->name = $name;
        }
    }
    ```

2. You can use your components as below:

    ```php
    <?php

    use Sikessem\Capsule\Sample\CustomClass;

    $capsule = new CustomClass('Sikessem');

    isset($capsule->name); // Returns true

    echo $capsule->name; // Prints "Sikessem"

    unset($capsule->name); // Does nothing

    isset($capsule->name); // Returns true

    $capsule->value = 'value'; // Throws an exception

    $capsule->name = 'value'; // Set name to "value"

    echo $capsule->name; // Prints "value"

    $capsule->on('hello', function (?string $name = null) {
        return 'Hello '.($name ?? 'Sikessem').'!';
    });

    echo $capsule->hello(); //Prints "Hello Sikessem!"
    ```

## 🧪 Testing and debugging

🧹 Keep a modern codebase with **Pint**:

```shell
composer lint
```

⚗️ Run static analysis:

- Using **PHPStan**:

```shell
composer analyse
```

- Using **Psalm**:

```shell
composer inspect
```

✅ Run unit tests using **PEST**

```shell
composer test
```

🐛 Check all code bugs:

```shell
composer debug
```

🚀 Fix the entire code:

```shell
composer fix
```

## 👏 Contribution

The main purpose of this repository is to continue evolving Sikessem. We want to make contributing to this project as easy and transparent as possible, and we are grateful to the community for contributing bug fixes and improvements. Read below to learn how you can take part in improving Sikessem.

### [👷 Code of Conduct][conduct-link]

Sikessem has adopted a Code of Conduct that we expect project participants to adhere to.
Please read the [full text][conduct-link] so that you can understand what actions will and will not be tolerated.

### 👥 [Contributing Guide][contrib-link]

Read our [**Contributing Guide**][contrib-link] to learn about our development process, how to propose bugfixes and improvements, and how to build and test your changes to Sikessem.

### 🔒️ Good First Issues

We have a list of [good first issues][gfi] that contain bugs which have a relatively limited scope. This is a great place to get started, gain experience, and get familiar with our contribution process.

[gfi]: https://github.com/sikessem/capsule/labels/good%20first%20issue

### 💬 Discussions

Larger discussions and proposals are discussed in [**Sikessem's GitHub discussions**][discuss-link].

## 🔐 Security Reports

If you discover a security vulnerability within [Sikessem][sikessem-link], please email [SIGUI Kessé Emmanuel](https://sigui.ci) at [contact@sigui.ci](mailto:contact@sigui.ci). All security vulnerabilities will be promptly addressed.

## 📄 License

The Sikessem Capsule is open-sourced software licensed under the  [MIT License](https://opensource.org/licenses/MIT) - see the [LICENSE][license-link] file for details.

***

<div align="center"><sub>Made with ❤︎ by <a href="https://twitter.com/intent/follow?screen_name=siguici" style="content:url(https://img.shields.io/twitter/follow/siguici.svg?label=@siguici);margin-bottom:-6px">@siguici</a>.</sub></div>

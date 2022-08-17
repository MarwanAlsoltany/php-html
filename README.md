<!-- add a logo here if there is any, a <br/> after the image is recommended -->

<h1 align="center">PHP-HTML</h1>

<div align="center">

A fluent interface for creating HTML using PHP.

<!-- variable are defined at the end of the file -->

[![PHP Version][php-icon]][php-href]
[![Latest Version on Packagist][version-icon]][version-href]
[![Total Downloads][downloads-icon]][downloads-href]
[![License][license-icon]][license-href]
[![Maintenance][maintenance-icon]][maintenance-href]
[![Documentation][documentation-icon]][documentation-href]
<br>
[![GitHub Continuous Integration][github-ci-icon]][github-ci-href]
[![GitHub Continuous Deployment][github-cd-icon]][github-cd-href]
[![Codecov][codecov-icon]][codecov-href]
<!-- [![Codacy Coverage][codacy-coverage-icon]][codacy-coverage-href] -->
<!-- [![Codacy Grade][codacy-grade-icon]][codacy-grade-href] -->

[![Open in Visual Studio Code][vscode-icon]][vscode-href]

[![Tweet][tweet-icon]][tweet-href] [![Star][github-stars-icon]][github-stars-href]

<details>
<summary>Table of Contents</summary>
<p>

[About](#about)<br/>
[Installation](#installation)<br/>
[Examples](#examples)<br/>
[More](#more)<br/>
[Changelog](./CHANGELOG.md)

</p>
</details>

<br/>

<sup>If you like this project and would like to support its development, giving it a :star: would be appreciated!</sup>

<!-- add an image here if there is any, a <br/> before the image is recommended -->

</div>


---

## Installation

#### Using Composer:

Install PHP-HTML through Composer using:

```sh
composer require marwanalsoltany/php-html
```

<!-- add as many installation methods here as needed -->


---


## Why Does This Exist?

Why not?

This is something that I exclusively created for myself. The real reason why this exist is, I really hate writing HTML within PHP code (especially in classes). If it is more than one line and it is not a template, it looks really ugly and it doesn't feel like it belongs to the code although it does. This package provides a fluent interface for the sole reason of not writing raw HTML in PHP. It also indents and validates the generated HTML and provides IDE-IntelliSense for all HTML elements to make it as easy as it gets.


---



## Examples

Here is an example of how it works:

```php

// on the fly
echo MAKS\PhpHtml\HTML::div('This is a div!', ['class' => 'container']);

// the whole deal
echo (new \MAKS\PhpHtml\HTML())
    ->element('h1', 'HTML Forms', ['class' => 'title'])
    ->open('form', ['method' => 'POST'])
        ->comment('SIMPLE FORM')
        ->h2('Example', ['class' => 'subtitle'])
        ->p('This is an example form.')
        ->br()
        ->if(isset($variable))->div('$variable is set')
        ->open('fieldset')
            ->legend('Form 1', ['style' => 'color: #333;'])
            ->label('Message: ', ['class' => 'text'])
            ->input(['type' => 'text', 'required'])
            ->entity('nbsp')
            ->input(['type' => 'submit', 'value' => 'Submit'])
        ->close()
        ->open('ul', ['class' => 'errors'])
            ->do(function () {
                $errors = ['Error 1', 'Error 2', 'Error 3'];

                foreach ($errors as $error) {
                    $this->li($error);
                }
            })
        ->close()
    ->close()
->render();

```

The generated HTML would look like this:

```html
<!-- on the fly -->
<div class="container">This is a div!</div>

<!-- the whole deal -->
<h1 class="title">HTML Forms</h1>
<form method="POST">
    <!-- SIMPLE FORM -->
    <h2 class="subtitle">Example</h2>
    <p>This is an example form.</p>
    <br />
    <fieldset>
        <legend style="color: #333;">Form 1</legend>
        <label class="text">Message: </label>
        <input type="text" required />
        &nbsp;
        <input type="submit" value="Submit" />
    </fieldset>
    <ul class="errors">
        <li>Error 1</li>
        <li>Error 2</li>
        <li>Error 3</li>
    </ul>
</form>
```


---


## License

PHP-HTML is an open-source project licensed under the [**MIT**](./LICENSE) license.
<br/>
Copyright (c) 2022 Marwan Al-Soltany. All rights reserved.
<br/>










<!-- edit icons as needed -->
[php-icon]: https://img.shields.io/badge/php-%3E=8.0-yellow?style=flat&logo=php
[version-icon]: https://img.shields.io/packagist/v/MarwanAlsoltany/php-html.svg?style=flat&logo=packagist
[downloads-icon]: https://img.shields.io/packagist/dt/MarwanAlsoltany/php-html.svg?style=flat&logo=packagist
[license-icon]: https://img.shields.io/badge/license-MIT-red.svg?style=flat&logo=github
[maintenance-icon]: https://img.shields.io/badge/maintained-yes-orange.svg?style=flat&logo=github
[documentation-icon]: https://img.shields.io/website-up-down-blue-red/http/MarwanAlsoltany.github.io/php-html.svg
<!-- GitHub Actions native badges -->
[github-ci-icon]: https://github.com/MarwanAlsoltany/php-html/actions/workflows/ci.yml/badge.svg
[github-cd-icon]: https://github.com/MarwanAlsoltany/php-html/actions/workflows/cd.yml/badge.svg
<!-- [github-ci-icon]: https://img.shields.io/github/workflow/status/MarwanAlsoltany/php-html/CI?style=flat&logo=github -->
<!-- [github-cd-icon]: https://img.shields.io/github/workflow/status/MarwanAlsoltany/php-html/CD?style=flat&logo=github -->
[codecov-icon]: https://codecov.io/gh/MarwanAlsoltany/php-html/branch/master/graph/badge.svg?token=FNU3ZNCHTN
<!-- [codacy-coverage-icon]: https://app.codacy.com/project/badge/Coverage/YOUR_CODACY_PROJECT_TOKEN -->
<!-- [codacy-grade-icon]: https://app.codacy.com/project/badge/Grade/YOUR_CODACY_PROJECT_TOKEN -->
[vscode-icon]: https://img.shields.io/static/v1?logo=visualstudiocode&label=&message=Open%20in%20VS%20Code&labelColor=2c2c32&color=007acc&logoColor=007acc
[tweet-icon]: https://img.shields.io/twitter/url/http/shields.io.svg?style=social
[github-stars-icon]: https://img.shields.io/github/stars/MarwanAlsoltany/php-html.svg?style=social&label=Star

<!-- edit urls as needed -->
[php-href]: https://github.com/MarwanAlsoltany/php-html/search?l=php
[version-href]: https://packagist.org/packages/MarwanAlsoltany/php-html
[downloads-href]: https://packagist.org/packages/MarwanAlsoltany/php-html/stats
[license-href]: ./LICENSE
[maintenance-href]: https://github.com/MarwanAlsoltany/php-html/graphs/commit-activity
[documentation-href]: https://MarwanAlsoltany.github.io/php-html
[github-ci-href]: https://github.com/MarwanAlsoltany/php-html/actions
[github-cd-href]: https://github.com/MarwanAlsoltany/php-html/actions
[codecov-href]: https://codecov.io/gh/MarwanAlsoltany/php-html
<!-- [codacy-coverage-href]: https://app.codacy.com/project/badge/Coverage/YOUR_CODACY_PROJECT_TOKEN -->
<!-- [codacy-grade-href]: https://app.codacy.com/project/badge/Grade/YOUR_CODACY_PROJECT_TOKEN -->
[vscode-href]: https://open.vscode.dev/MarwanAlsoltany/php-html
[tweet-href]: https://twitter.com/intent/tweet?url=https%3A%2F%2Fgithub.com%2FMarwanAlsoltany%2Fphp-html&text=Check%20out%MarwanAlsoltany%2Fphp-html%20on%20GitHub%21%20%23PHP
[github-stars-href]: https://github.com/MarwanAlsoltany/php-html/stargazers

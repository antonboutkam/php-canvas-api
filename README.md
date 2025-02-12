# Canvas API SDK for PHP

[![Latest Stable Version](https://poser.pugx.org/hurah/canvas-api/v/stable)](https://packagist.org/packages/hurah/canvas-api)
[![License](https://poser.pugx.org/hurah/canvas-api/license)](https://packagist.org/packages/hurah/canvas-api)
[![CircleCI Build](https://poser.pugx.org/hurah/php-canvas-api/circleci)](https://packagist.org/packages/hurah/php-canvas-api)


---
This library is a PHP SDK for the Instructure Canvas API, designed to simplify 
communication with Canvas by providing statically typed classes for most API 
endpoints. It supports both collection and single entity operations. The SDK is 
still in development but is already being used in small production environments.

---

## Features
- **Statically Typed Classes**: Provides typed classes for most API endpoints.
- **Collections and Entities**: Easily handle both collections and single entities.
- **Centralized Communication**: All communication goes through an instance of the `Canvas` object.
- **Symfony Console Commands**: Includes commands for manual communication with the API, offering examples and testing tools.

---

## Installation

Install the package via Composer:

```bash
composer require hurah/canvas-api
```

# Usage
## Basic Setup
Create an instance of the Canvas object and authenticate with your API credentials:

```php
use Hurah\CanvasApi\Canvas;

$canvas = new Canvas('your-api-url', 'your-access-token');
```

## Fetching Data

## Example: fetch a collection
```php
use Hurah\CanvasApi\Canvas;

$oCourseCollection = $canvas->getCourses();
foreach ($oCourseCollection as $oCourse) {
    echo $oCourse->getName();
}
```
## Example: Single Entity
```php
$oCourse = $canvas->getCourse(123);
echo $course->getName();
```

## Example: Create a new Entity
```php
$oCourse = new Course();
$oCourse->setName('Some name');
$oCourse->setDescription('Some description');
$oCourse->setSomeOtherProperty('...')
$oCourse = $canvas->createCourse($oCourse);

// The same object is returned containing the course
// id and other default properties.
$oCourse->getId() 

```


## Contributing
Contributions and feedback are welcome! Please keep in mind that this software is in beta and comes as is. Use it at your own risk.

1. Fork the repository.
2. Create your feature branch: git checkout -b feature/my-new-feature.
3. Commit your changes: git commit -m 'Add some feature'.
4. Push to the branch: git push origin feature/my-new-feature.
5. Open a pull request.

***
## Links
* [Packagist Page](https://packagist.org/hurah/canvas-api)
* [Instructure Canvas API Documentation](https://canvas.instructure.com/doc/api/)

***
## Author
[Anton Boutkam](https://antonboutkam.nl) - Teacher Software Development at [ROC Amstelland](https://www.rocva.nl/MBO-onderwijs/MBO-Colleges/MBO-College-Amstelland)

## CicleCI build status
[![CircleCI](https://dl.circleci.com/status-badge/img/gh/antonboutkam/php-canvas-api/tree/main.svg?style=svg)](https://dl.circleci.com/status-badge/redirect/gh/antonboutkam/php-canvas-api/tree/main)

v1.0.3 added Quiz
v1.0.5 updated Quiz
v1.0.6 updated QuizQuestionGroup

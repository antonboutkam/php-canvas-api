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

- **Statically typed classes**: Provides typed classes for most API endpoints.
- **Collections and entities**: Easily handle both collections and single entities in a clean object-oriented manner
  implementing php's Iterator and ArrayAccess interfaces.
- **Centralized communication**: All communication goes through an instance of the `Canvas` object.
- **[Symfony Console](https://symfony.com/doc/current/components/console.html) Commands**: Includes commands
  for manual communication with the API, offering
  examples, [excellent](https://symfony.com/doc/current/components/console.html)
  documentation and
  testing tools.

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

## Example: Create a new Course
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

* [Packagist Page](https://packagist.org/packages/hurah/canvas-api)
* [Instructure Canvas API Documentation](https://canvas.instructure.com/doc/api/)

***
## Author
[Anton Boutkam](https://antonboutkam.nl) - Teacher Software Development at [ROC Amstelland](https://www.rocva.nl/MBO-onderwijs/MBO-Colleges/MBO-College-Amstelland)

## CicleCI build status
[![CircleCI](https://dl.circleci.com/status-badge/img/gh/antonboutkam/php-canvas-api/tree/main.svg?style=svg)](https://dl.circleci.com/status-badge/redirect/gh/antonboutkam/php-canvas-api/tree/main)

- v1.0.22 upgrade dependencies
- v1.0.21 initialized frozenAttributes in Assignment, was breaking unit testing.
- v1.0.20 upgraded various dependencies
- v1.0.18 improved README.md
- v1.0.17 removed Account part due to insufficient privileges on my Canvas account.
- v1.0.16 added Assignments, AssignmentGroups, CourseCommands, CourseSubmissionCommands, PageCommands, QuizQuestionCommands
- v1.0.15 bugfix Added missing properties to Assignment endpoint
- v1.0.13 bugfix Made setters nullable
- v1.0.12 added Lots of endpoints
- v1.0.11 added Canvas::getUserCourses(int $iCanvasId):CourseCollection
- v1.0.10 added QuizQuestionGetCommand, QuizQuestionListCommand
- v1.0.9 added QuizQuestion
- v1.0.8 updated QuizQuestion
- v1.0.7 updated QuizQuestionGroup
- v1.0.6 updated QuizQuestionGroup
- v1.0.5 updated Quiz
- v1.0.3 added Quiz

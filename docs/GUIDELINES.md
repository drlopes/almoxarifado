This document covers language, commentaries, documentation, OOP, testing, style and versioning. These guidelines are intended to be simple and easy to follow, to ensure that the codebase is maintainable, scalable and new developers can quickly get up to speed with the project. Please read it in its entirety before contributing to the project.

## Summary

1. [READ THE DOCS!](#read-the-docs)
2. [Language](#language)
3. [Commentaries](#commentaries)
4. [OOP](#oop)
5. [Testing](#testing)
6. [Style](#style)
7. [Documentation](#documentation)
8. [Versioning](#versioning)
9. [Log All Changes](#log-all-changes)

## Guidelines

### READ THE DOCS!

This template was developed using the following technologies:

- [Laravel](https://laravel.com/)
- [Tailwind CSS](https://tailwindcss.com/)
- [Alpine.js](https://alpinejs.dev/)
- [Livewire](https://livewire.laravel.com/)
- [Filament](https://filamentphp.com/)

>The [developer documentation](/docs/DEVELOPERS.md) assumes that you are familiar with the patterns employed by the technologies used in this template. If you're new to any of them, it is very important to read their documentation to understand how they work and how to use them effectivelly and idiomatically. Adhereing to the standards and best practices of each technology will ensure that the codebase is understandable by anyone working on the project.

### Language

#### **All code should be written in English**

All code should be written in English. This includes variable names, function names, comments, and documentation.

##### User facing text

User facing text should be written in English and follow the translation capabilities of the framework. This will make it easier to maintain and update the codebase, as well as ensure that the application is accessible to users from different countries.

✅Do this:

```html
<p>__('Good Morning!')</p> <!-- The framework will handle the translation -->
```

❌Not this:

```html
<p>Guten Morgen!</p>
```

##### Variable names

Variable names should be descriptive of the value they hold.

✅Do this:

```php
$lastName = 'Lopes';

$phoneNumbers = User::where('last_name', $lastName)
    ->pluck('phone_number')
    ->toArray();

foreach ($phoneNumbers as $phone) {
    // Code here
}
```

❌Not this:

```php
$Nome = 'John';

$arr = User::where('name', '!=', 'John')->get();

foreach ($arr as $value) {
    // Code here
}
```

##### Function names

Function names should be descriptive of the action they perform.

✅Do this:

```php
function findUserById($id) : User
{
    // Code here
}
```

❌Not this:

```php
function Usuario($id) : User
{
    // Code here
}
```

### Commentaries

#### **Comments should be written in English**

All comments should be written in English to ensure consistency throughout the codebase. This will make it easier for other developers to understand the code and avoid confusion.

#### **Comments should explain the WHY, not the WHAT** 

Explain the purpose of the code, not what the code does. The code should be self-explanatory, but the comments should explain why the code is written in a certain way.

✅Do this:

```php
// Currently, the value of 'a' is always 1 because of reason X.
// This is important because of Y and untill Z
// condition is met, 'a' should always be 1
$a = 1;
```

❌Not this:

```php
// Create variable 'a' and set it to 1
$a = 1;
```

#### **Comments should contain links to relevant literature or documentation when necessary**

If the code tackles a complex issue, is based on a specific algorithm, design pattern or best practice, is a fix or workaround for a known issue outside of the application, include a link to the relevant literature or documentation. This will help other developers understand the context of the code and avoid introducing new bugs as well as provide a reference for further reading.

✅Do this:

```php
// This code is based on the XYZ algorithm as described in [XYZ](https://example.com/xyz)
```

❌Not this:

```php
// This code is based on the XYZ algorithm
```

### OOP

The project follows the principles of Object-Oriented Programming (OOP) to ensure that the code is organized, maintainable, and scalable. The codebase is divided into classes and objects that interact with each other to perform specific tasks. The following guidelines should be followed when writing OOP code:

#### **Classes should have a single responsibility**

Each class should have a single responsibility. This will make the code easier to understand, maintain, and test. If a class has multiple responsibilities, consider refactoring it into multiple classes.

✅Do this:

```php
class UserService
{
    public function createUser($data)
    {
        // Code here
    }

    public function updateUser($id, $data)
    {
        // Code here
    }
}
```

❌Not this:

```php

class UserService
{
    public function createUser($data)
    {
        // Code here
    }

    public function updateUser($id, $data)
    {
        // Code here
    }

    public function sendEmail($to, $subject, $message)
    {
        // Code here
    }
}
```

#### **Classes should be small and focused**

Classes should be small and focused on a specific task. They should not be too long or contain too many methods. If a class is too long or contains too many methods, consider refactoring it.

#### **Methods should be short and focused**

Methods should be short and focused on a specific task. They should not be too long or contain too many lines of code. If a method is too long or contains too many lines of code, consider refactoring it into multiple methods.

#### **Use private properties. Provide public accessors and mutators**

Properties of a class should be private to encapsulate the data and prevent direct access from outside the class. Public accessors and mutators should be provided to allow other classes to read and modify the data.

✅Do this:

```php
class User
{
    private $name;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
}
```

❌Not this:

```php
class User
{
    public $name;
}
```

#### **Program to an interface, not an implementation**

Classes should depend on interfaces, not concrete implementations. This will make the code more flexible, maintainable, and testable. If a class depends on a concrete implementation, consider refactoring it to depend on an interface.

### Testing

#### **All non-trivial code should be tested**

All non-trivial code should be tested to ensure that it works as expected and does not introduce bugs. This includes classes, methods, and functions that perform complex logic or interact with external systems. Tests should follow PHPUnit conventions and be written in English.

#### **Adhere to TDD principles**

Test-Driven Development (TDD) should be used to write tests before writing the code. This will ensure that the code is testable, maintainable, and scalable. The tests should be written in English and follow PHPUnit conventions.

#### **Follow the AAA pattern**

Tests should follow the Arrange-Act-Assert (AAA) pattern to ensure that they are easy to read, understand, and maintain. The test should be divided into three sections: arrange the data, act on the data, and assert the result.

#### **Use descriptive test names**

Test names should be descriptive of the test case and explain what is being tested. This will make it easier for other developers to understand the purpose of the test and the expected result.

### Style

Code formatting tools have freed developers from the burden of manually formatting their code. However, it is still important to follow some basic style guidelines to ensure that the code is consistent and readable during development. Its a good practice to adhere to the style the rest of the team/project is using.  
That said, this template employs the recommendations of the psr-1 standard, which is a good starting point for most PHP projects.
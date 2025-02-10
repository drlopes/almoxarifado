## This application relies on the following technologies:

- [Laravel](https://laravel.com/)
- [Tailwind CSS](https://tailwindcss.com/)
- [Alpine.js](https://alpinejs.dev/)
- [Livewire](https://livewire.laravel.com/)
- [Filament](https://filamentphp.com/)

## Author

- Name: Daniel Lopes
- GitHub: [drlopes](https://github.com/drlopes)
- Email: dalopes@id-logistics.com
- Phone: +55 (35) 9 9882-6872

## Requirements

- PHP 8.2 or higher
- Composer
- Node.js
- NPM

## Installation

1. On GitHub, click on the "Use this template" button
2. Create a new repository
3. Clone the repository
4. Run `composer update` & `composer install`
5. Run `npm install`
6. Configure the `.env` file
7. Setup the database as configured in the `.env` file
8. Run `php artisan migrate --seed`
9. Run `php artisan key:generate`

On any environment other than `production`, a default user is created with the following credentials:  

Email: `developer@id-logistics.com`  
Password: `developer`  
Name: `Developer`  
Role: `developer`  

OBS: Other default models such as roles and permissions are created during the seed process.

# **READ THE GUIDELINES!**

**A set of [guidelines](/docs/GUIDELINES.md) has been provided to ensure a consistent and readable codebase, allow for easier maintenance and scalability, and help new developers quickly get up to speed with the project. Please read them before contributing.**

# Documentation

The documentation is expected to be updated as the project evolves. It is divided into two parts: user documentation and developer documentation.

### User Documentation

The [user documentation](/docs/USERS.md) describes how to use the application. It is not intended to be read as is, but rather to be used as a reference when creating user guides, tutorials, and other user-oriented material. It should be updated whenever new features are added or existing features are changed, featuring screenshots and examples to make it easier for users to understand how to use the application.

### Developer Documentation

The [developer documentation](/docs/DEVELOPERS.md) is intended for developers who will work on the project. It explains how the project is structured, how to set up the development environment, and how to contribute to the project. It should be updated whenever new features are added or existing features are changed, to ensure that new developers can quickly get up to speed with the project. Deviations from broadly accepted practices should be discussed extensively.

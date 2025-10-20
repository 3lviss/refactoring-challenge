[![Tests](https://github.com/3lviss/refactoring-challenge/actions/workflows/tests.yml/badge.svg)](https://github.com/3lviss/refactoring-challenge/actions/workflows/tests.yml)

# Improved

* Request: input prep + validation.

* Controller: orchestration only (no business logic/persistence)

* Service encapsulates permission rules.

* Repository (interface) abstracts persistence concerns.

* DTOs.

* Centralized JSON error handling (404/422)

# Potential next steps 

* Move permissions into sepatrate entity 

* Add Eloquent AccessToken model 

* Add caching for permissions per token

# Installation
```shell
$ composer install
$ php artisan migrate
$ php artisan db:seed --class=AccessTokenSeeder
```

# Testing
```shell
$ composer run test
```

# PHPTodo

Library to plan retirement of code that warns at runtime, instead of only using annotations.

## Installation

* Install: Using [Composer](https://getcomposer.org): `composer require star/todo`

## Usage

You only need to invoke any methods of the [Todo](/src/Todo.php) class to register tasks to be done.

### Supported cases

#### Until date

The basic case is when you wish to trigger a todo warning when some piece of code is
 executed past a certain date.

```php
// in your code base
Star\Component\Todo\Todo::untilDate('2000-01-01', 'This will start warning on January 1st, 2000 and after.');
```

#### Tear down
 
The `Todo::tearDown()` method is used to trigger the collected todo during the execution of your script. Based on the
 provided configuration, the system will trigger your collected warnings.

```php
// At the end of your base script
Star\Component\Todo\Todo::tearDown(); // uses the default strategy to output
```

## Configuration

You may provide behaviors at the beginning of your script using:

```php
Star\Component\Todo\Todo::setup();
```

### Failure strategy

The failure strategy is what the system will do with tasks that are expired.

* [AlwaysTriggerErrors](/src/Evaluation/AlwaysTriggerErrors.php): Will trigger a `E_USER_DEPRECATED` for each
 expired tasks.
* [ThrowExceptionOnFailure](/src/Evaluation/ThrowExceptionOnFailure.php): Will throw an exception `EvaluationFailure`
 at the first encounter of an expired task.
* [FailureStrategy](/src/Evaluation/FailureStrategy.php): You may customize what to do by passing a class implementing
 the `FailureStrategy` interface.

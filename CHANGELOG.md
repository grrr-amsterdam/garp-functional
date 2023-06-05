# Changelog

Note: I'm not mentioning the plethora of functions that I'm adding with every minor version bump. [Take a look at the full function list](https://github.com/grrr-amsterdam/garp-functional/tree/master/library/Garp/Functional). This changelog will only list breaking changes.

## `main`

- Dropped support for PHP 7.1
- Test compatibility with PHP 8.1 and 8.2
- Added type hints to a lot of functions

## 5.0.0

- Alas! `match` is a reserved keyword in PHP8, so our `match` function had to be renamed to the more verbose `match_regex`. This is a breaking change: make sure to update your references to this function!

## 4.0.0

- Moved TypeClasses to namespace `Garp\Functional\Types\TypeClasses`, to not confuse the terms.

## 3.1.1

- All functions also publish a constant by the same name. This allows you to pass around the function as if you had a reference to it.

## 3.1.0

- Noticed function `subtract` contained a typo: it was called `substract`. Added deprecation notice to the old one and added a new, correctly spelled, `subtract`.

## 3.0.0

- Bumped PHP dependency to 7.1. The library now declares strict types and uses the iterable type to validate arguments.
- Moved all functions to the root folder `functions` and renamed their files to reflect the actual function: from camelCase to snake_case. This shouldn't affect you if you use Composer to load files, but on the off-chance you're manually including these files, note that it will break.
- Not a breaking change, but a significant change nonetheless: slowly but surely typeclasses will be added to the library.

## 2.0.0

- I've changed `flatten` in a backward-incompatible way: it won't unpack associative arrays any further
- Also, I'm starting to introduce PHP 7 features into the library. It is time. I will be revisiting the entire library to see if I can add stricter type checking and other PHP 7 features that're long overdue.


## 1.0.0

- A minor breaking change: `sort_by` no longer accepts a string as its first parameter, but instead wants a function argument.
  You can achieve the same result by using `sort_by(prop('my_prop'), $my_collection)`.


## 0.0.0

- Some awesome things transpired.

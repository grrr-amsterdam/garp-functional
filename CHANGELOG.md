# Changelog

Note: I'm not mentioning the plethora of functions that I'm adding with every minor version bump. [Take a look at the full function list](https://github.com/grrr-amsterdam/garp-functional/tree/master/library/Garp/Functional). This changelog will only list breaking changes.

## 2.0.0

- I've changed `flatten` in a backward-incompatible way: it won't unpack associative arrays any further
- Also, I'm starting to introduce PHP 7 features into the library. It is time. I will be revisiting the entire library to see if I can add stricter type checking and other PHP 7 features that're long overdue.


## 1.0.0

- A minor breaking change: `sort_by` no longer accepts a string as its first parameter, but instead wants a function argument.
  You can achieve the same result by using `sort_by(prop('my_prop'), $my_collection)`.


## 0.0.0

- Some awesome things transpired.
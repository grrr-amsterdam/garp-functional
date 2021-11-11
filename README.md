[![PHPUnit](https://github.com/grrr-amsterdam/garp-functional/actions/workflows/phpunit.yml/badge.svg)](https://github.com/grrr-amsterdam/garp-functional/actions/workflows/phpunit.yml) [![PHPCS](https://github.com/grrr-amsterdam/garp-functional/actions/workflows/phpcs.yml/badge.svg)](https://github.com/grrr-amsterdam/garp-functional/actions/workflows/phpcs.yml)

# Garp Functional

Utility library embracing functional programming paradigms.

[Documentation](https://grrr-amsterdam.github.io/garp-functional/)

## Developed with ❤️ by [GRRR](https://grrr.nl)

- GRRR is a [B Corp](https://grrr.nl/en/b-corp/)
- GRRR has a [tech blog](https://grrr.tech/)
- GRRR is [hiring](https://grrr.nl/en/jobs/)
- [@GRRRTech](https://twitter.com/grrrtech) tweets

## Philosophy

`Garp\Functional` is a practical functional library that strives to embrace functional paradigms.

- Functions are pure, referentially transparent, without side-effects.
- Data immutability is favored over mutating existing properties of given parameters.
- In general, functions are curried. Almost all of the functions in the library can be called
    partially applied, to a point where this makes sense.
- Function parameters are ordered to promote currying. Data is usually the last thing to go in,
    making every function a fine candidate to pass to native `array_map`, `array_filter` and the
    like, without having to create a closure around the call.
- Higher-order functions are provided to fill the gaps. Functions like `compose`, `partial`,
    `partial_right` or `not` are legos for you to use in your own implementation.
- Nothing is type-hinted too strictly. I don't care if you pass a
    string or an array to `prop`, as long as it allows accessing members thru bracket syntax `[]`,
    I'll allow it. Nothing irks me more about PHP than not being able to toss a `Traversable` 
    object into the native `array_map`. 
- Typeclasses are added, broadening the applicability of the functions. Next to primitives, they will 
    now work with your objects as well, so long as they implement the right interface.

## Usage

Installation:

```
composer require grrr-amsterdam/garp-functional
```

That'll do, all functions are available to you.

[Read the docs for a complete
reference](https://grrr-amsterdam.github.io/garp-functional/)


## Thanks

This library is inspired by beautiful languages like [Haskell](https://www.haskell.org/) and [Clojure](https://clojure.org/),  
as well as the awesome [RamdaJS](https://ramdajs.com/) library.


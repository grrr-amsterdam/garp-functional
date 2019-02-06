# Documentation

- [Philosophy](#philosophy)
- [Function index](#function-index)

## Philosophy

`Garp\Functional` is a practical functional library that strives to embrace functional paradigms.

The functions are written to be pure – meaning side-effect free with repeatable output given the same input. We generally don't mutate data, but instead create copies of given data.

All functions are curried and data-last to encourage function composition.

### On data-last

An important aspect of this library is that functions generally take the data upon which they act as last argument.  
This is very different from how most libraries do it. It promotes a [Point-free](https://en.wikipedia.org/wiki/Tacit_programming) style of programming, which is an elegant way of doing function composition without naming the argument explicitly all the time.  
This helps keep the function abstract, not needing a specifically named parameter that would otherwise bind the function to a certain problem domain, and of course it's one less thing for typos to end up in.

Probably more important, a data-last, curried library enables you to write like this:

```php
$toName = f\map(f\prop('name'));
$users = [
  ['name' => 'Bob', 'age' => 30, 'occupation' => 'Taxi driver'],
  ['name' => 'Alice', /* etc... */ ]
];
$names = $toName($users); // ['Bob', 'Alice', ...]
```

Or go totally crazy:

```php
$getInitials = f\compose(f\join(' '), f\map(f\compose(f\concat_right('.'), f\prop(0))), f\split(' '));
$getInitials('Miles Davis'); // M. D.
```

Sure, that line is cuckoo, but the idea of composing functions without having to stop at every step to consider the control flow structures, what the parameters are going to be named, and how to return it is pretty powerful.  

## Function index

- [add](#add)
- [always](#always)
- [autocurry](#autocurry)
- [binary](#binary)
- [both](#both)
- [call](#call)
- [compose](#compose) 
- [concat](#concat)
- [concat_right](#concat_right)
- [concat_with](#concat_with)
- [contains](#contains)
- [count](#count)
- [divide](#divide)
- [drop](#drop)
- [drop_while](#drop_while)
- [either](#either)
- [entries](#entries)
- [equals](#equals)
- [every](#every) 
- [filter](#filter)
- [find](#find)
- [find_index](#find_index)
- [flatten](#flatten) 
- [flip](#flip)
- [group_by](#group_by)
- [gt](#gt)
- [gte](#gte)
- [head](#head)
- [id](#id)
- [index_by](#index_by)
- [instance](#instance)
- [is_assoc](#is_assoc)
- [join](#join) 
- [keys](#keys)
- [keys_where](#keys_where)
- [last](#last)
- [lt](#lt)
- [lte](#lte)
- [map](#map)
- [match](#match)
- [merge_after](#merge_after)
- [merge_at](#merge_at)
- [modulo](#modulo)
- [multiply](#multiply)
- [none](#none)
- [not](#not) 
- [omit](#omit)
- [once](#once)
- [partial](#partial)
- [partial_right](#partial_right)
- [pick](#pick) 
- [pipe](#pipe) 
- [prop_equals](#prop_equals)
- [prop](#prop)
- [prop_in](#prop_in)
- [prop_of](#prop_of)
- [publish](#publish)
- [reduce](#reduce) 
- [reduce_assoc](#reduce_assoc) 
- [reindex](#reindex)
- [reject](#reject)
- [rename_keys](#rename_keys)
- [repeat](#repeat)
- [replace](#replace)
- [some](#some)
- [sort](#sort) 
- [sort_by](#sort_by) 
- [sort_by_map](#sort_by_map) 
- [split](#split)
- [subtract](#subtract)
- [tail](#tail)
- [take](#take)
- [take_while](#take_while)
- [tap](#tap)
- [truthy](#truthy)
- [unary](#unary)
- [unique](#unique)
- [usort](#usort)
- [when](#when)
- [zip](#zip)

_Note: code examples assume the library is loaded with `use Garp\Functional as f;`_

_Also note: list functions are generally designed to work with both numerically indexed and associative arrays, iterable objects and strings._

### add

Adds two numbers.

```php
f\add(10, 20); // 30
f\add(10)(20); // 30
```

### always

Returns a function that always returns the given argument.  

```php
$alwaysMiles = f\always('Miles Davis');
$alwaysMiles(1, 2, 3); // 'Miles Davis'
``` 

### autocurry

`autocurry` keeps partially applying a function until you give it enough arguments, after which it will resolve.  
This is used heavily by `Garp\Functional` internally, but it might be useful to you too.

Note: you have to provide the function's arity manually, to avoid Reflection API lookups.

```php
$foo = function ($a, $b, $c, $d) {
    return $a . $b . $c . $d;
};
$curried = autocurry($foo, 4);
$first = $curried('a');
$second = $first('b');
$third = $second('c');
$fourth = $third('d'); // "abcd"
```

### binary

Returns a function that accepts just two arguments.

```php
$countArgs = function () {
    return count(func_get_args());
};
$countArgs(1, 2, 3); // 3
f\binary($countArgs)(1, 2, 3); // 2
```

See also [Unary](#unary).

### both

Returns true if both arguments are truthy.

```php
f\both(123, 456); // true
f\both(true, false); // false
f\both(array(), 123); // false
f\both('cheese', 'ham'); // true
```

When either of the arguments is a function, `both` returns a new function waiting for arguments to
pass to the given function.

```php
$isMediumNumber = f\both(f\gt(50), f\lt(200));
$isMediumNumber(67); // true
$isMediumNumber(199); // true
$isMediumNumber(10); // false
$isMediumNumber(600); // false
```

### call

Call a method on an object.

```php
// Image an array of active records, containing a `getName` method.
$users = $database->fetchUsers();
$names = f\map(f\call('getName'), $users); // array of names
```

### compose

Compose functions together. Execution order is right to left, as is traditional.
It mimics a manual approach. e.g. `compose(foo, bar, baz)($args)` equals `foo(bar(baz($args)))`.

Let's look at the crazy example from the intro of this page:

```php
$getInitials = f\compose(f\join(' '), f\map(f\compose(f\concat_right('.'), f\prop(0))), f\split(' '));
$getInitials('Miles Davis'); // M. D.
```

If you start at the right side you can follow along with the path your arguments will travel through 
the functional pipeline.

### concat

Concatenate two lists. (strings are also lists)

```php
f\concat('foo', 'bar'); // 'foobar'

$a = [1, 2, 3];
$b = [4, 5, 6];
f\concat($a, $b); // [1, 2, 3, 4, 5, 6] 
```

Note, the right side overrides the left side:

```php
$a = [
    'first_name' => 'Miles',
    'last_name' => 'Davis'
];
$b = [ 'first_name' => 'John' ];
f\concat($a, $b); // ['first_name' => 'John', 'last_name' => 'Davis']
```

### concat_right

Same as `concat`, but flips the order in which the arguments are concatenated.  
Especially interesting when dealing with associative arrays: this function lets the left side
override the right side:

```php
$a = [
    'first_name' => 'Miles',
    'last_name' => 'Davis'
];
$b = [ 'first_name' => 'John' ];
f\concat_right($a, $b); // ['first_name' => 'Miles', 'last_name' => 'Davis'] 
```

### concat_with

This merges two or more arrays, using the given functions to determine how to merge values together.

Examples:

```php
$a = ['total' => 100, 'amount' => 4];
$b = ['total' => 50, 'amount' => 5];
f\concat_with('Garp\Functional\add', $a, $b); // ['total' => 150, 'amount' => 9]

$c = ['name' => 'Foo'];
$d = ['name' => 'Bar'];
f\concat_with('Garp\Functional\concat', $c, $d); // ['name' => 'FooBar']
```

### contains

Checks for existence of a needle in a haystack. When given an array, it performs `in_array`. 
On strings, it will use `strpos`. Any object implementing `Traversable` will be checked as if it were an array.

```php
f\contains('hello', ['hello', 'world']); // true
f\contains(42, [12, 24, 42]); // true
```

### count

Counts strings (chars) and arrays:

```php
f\count(['a', 'b', 'c']); // 3
f\count('foobar'); // 6
f\count(new ClassWithToStringMethod('foo')); // 3
```

### divide

Divides two numbers.

```php
f\divide(2, 10); // 5
f\divide(5)(20); // 4
```

### drop

Drop the first `$n` items of a collection.

```php
f\drop(2, ['foo', 'bar', 'baz']); // ['baz']
f\drop(6, 'Miles Davis'); // ['D', 'a', 'v', 'i', 's']
```

### drop_while

Drop items from the front of a collection until the predicate function returns false.  
Note that the function stops dropping when it finds a falsey result, so you may end up with items in
the array that do not match your predicate function:

```php
$numbers = array(-1, -30, 5, 932, -2, 13);
$positiveNumbers = f\drop_while(f\lte(0), $numbers);

/**
 * Result:
 * array(5, 932, -2, 13);
 */
```

See also [take](#take) and [take_while](#take_while).

### either

Returns the left argument if truthy, otherwise the right argument.  
Can be used for default values:

```php
$name = f\either(f\prop('name', $user), 'Anonymous');
```

If either the left or the right argument is a function, a new function will be returned. Arguments
passed to this function will first be pushed thru the given function(s) and its return
value(s) will be compared.

```php
$users = [
    ['name' => 'Hank', 'role' => 'admin'],
    ['name' => 'Julia', 'role' => 'basic'],
    ['name' => 'Lisa', 'role' => 'admin'],
    ['name' => 'Gerald']
);
$getBasicUsers = f\filter(
    f\either(
        f\not(f\prop('role')),
        f\prop_equals('role', 'basic')
    )
); // [['name' => 'Julia', 'role' => 'basic'], ['name' => 'Gerald']]
```

(see also: [both](#both) and [when](#when))

### entries

Inspired by Javascript's `Array.entries` function, this will return a collection of tuples containing key/value pairs from your iterable:

```php
f\entries(['foo', 'bar', 'baz']); // [[0, 'foo'], [1, 'bar'], [2, 'baz']]

f\entries(['foo' => 123, 'bar' => 456]); // [['foo', 123], ['bar', 456]]
```

Helpful when you need the keys when, for instance, mapping over a collection.

### equals

Equality check in function form.

```php
f\equals(1, 2); // false
f\equals('Hello', 'Hello'); // true
f\equals('1', 1); // false
```

### every

Returns true if all items in the list match the predicate function.

```php
$numbers = [12, 40, 23, 90];
f\every('is_int', $numbers); // true
f\every(f\gt(50), $numbers); // false
```

### filter

Curried version of `array_filter`.
Note that this version of filter reindexes numeric arrays. It's closer to array filtering found in
other languages, where this often is the case.  
And frankly, it drives me up the walls to filter an array in PHP and getting back a mutant array 
with keys starting at 5 with large gaps in between.  
So this an opinionated version of `array_filter`, I guess.

```php
$names = ['Miles Davis', 'John Coltrane'];
f\filter(f\equals('Miles Davis'), $names); // ['Miles Davis']

// I will preserve string indexes:
$numbers = ['hundred' => 100, 'three' => 3, 'fiftytwo' => 52];
f\filter(f\gt(50), $numbers); // ['hundred' => 100, 'fiftytwo' => 52]
``` 

### find

Basically combines `filter` with a `prop(0)` call: it filters a collection and returns the first
match.

```php
$numbers = [40, 15, 23, 90, 29];
f\find(f\gt(20), $numbers); // 23
f\find(f\gt(200), $numbers); // null
``` 

### find_index

Finds the index of the first item that matches the predicate function.

```php
$numbers = [20, 10, 50, 21, 90];
f\find_index(f\lt(20), $numbers); // 1
f\find_index(f\gt(50), $numbers); // 5
```

### flatten

Flatten an array of arrays into a single array.

```php
$data = [1, 2, [3, 4, 5, [6, 7], 8], 9, [], 10];
f\flatten($data); // [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
```

Note: associative arrays are considered their own little unit and not unpacked further.  
You can use `array_values` for that.

### flip

Flip the order of the first two arguments of a function.

```php
$concat = function ($a, $b) {
    return $a . $b;
};
$concat('Hello', 'world'); // 'Helloworld'
f\flip($concat)('Hello', 'world'); // 'worldHello'
```

### group_by

Returns an array from the given collection, keyed by the given index.
If index is callable, the collection is keyed by the result of
calling the function with the given item in the collection.

```php
$musicians = array(
    array('name' => 'Miles Davis', 'instrument' => 'trumpet'),
    array('name' => 'John Coltrane', 'instrument' => 'saxophone'),
    array('name' => 'Freddy Hubbard', 'instrument' => 'trumpet'),
    array('name' => 'Herbie Hancock', 'instrument' => 'piano'),
    array('name' => 'Thelonious Monk', 'instrument' => 'piano')
);
f\group_by('instrument', $musicians); 

/**
 * Result: 
 *
 * array(
 *     'trumpet' => array(
 *         array('name' => 'Miles Davis', 'instrument' => 'trumpet'),
 *         array('name' => 'Freddy Hubbard', 'instrument' => 'trumpet'),
 *     ),
 *     'saxophone' => array(
 *         array('name' => 'John Coltrane', 'instrument' => 'saxophone'),
 *     ),
 *     'piano' => array(
 *         array('name' => 'Herbie Hancock', 'instrument' => 'piano'),
 *         array('name' => 'Thelonious Monk', 'instrument' => 'piano')
 *     )
 * )
 */
```

Using a function:

```php
$strings = array('a', 'as', 'asd', 'aa', 'asdf', 'qwer');
f\group_by('strlen', $strings);

/**
 * Result:
 * array(
 *     1 => array('a'),
 *     2 => array('as', 'aa'),
 *     3 => array('asd'),
 *     4 => array('asdf', 'qwer')
 * )
 */
```

### gt

Returns true if the given value is greater than the predicate.

```php
f\gt(10, 100); // true
f\gt(10, 5); // false
```

### gte

Returns true if the given value is greater than or equal to the predicate.

```php
f\gte(10, 100); // true
f\gte(10, 10); // true
f\gte(10, 9); // false
```

### head

Get the head of a list.

```php
$spices = ['nutmeg', 'clove', 'cinnamon'];
f\head($spices); // 'nutmeg'
f\head('Miles'); // 'M'
```

See also [last](#last) and [tail](#tail).

### id

Identity function, returns what it's given.   
Useful in places that expect a callback function but you don't want to mutate anything. For instance
in a [`when`](#when) application.

```php
123 === f\id(123); // true
$spices = ['clove', 'nutmeg', 'allspice', 'cumin'];
$spices === f\id($spices); // true
``` 

### index_by

Creates an array where items of the given collection are indexed by passing them through the given index function.
Note that the _last_ item is preserved, duplicates are purged. If you want to keep all items resulting in the same index, use [group_by](#group_by).

```php
$strings = array('a', 'as', 'asd', 'aa', 'asdf', 'qwer');
f\index_by('strlen', $strings);

/**
 * Result:
 * array(
 *     1 => 'a',
 *     2 => 'aa',
 *     3 => 'asd',
 *     4 => 'qwer'
 * )
 */
```

See also: [group_by](#group_by).


### instance

Makes the PHP language a little more expressive.
PHP 5.4 allows chaining of new instances like so;

```php
(new Instance())->doSomething();
```

This function sort of brings this to earlier versions of PHP:

```php
instance(new Instance())->doSomething();
``` 

Also accepts strings:

```php
instance('Foo_Bar_Baz'); // new Foo_Bar_Baz()
```

### is_assoc

Checks wether an iterable is associative.

```php
is_assoc([]); // false
is_assoc([1, 2, 3]); // false
is_assoc(['foo' => 'bar']); // true
is_assoc(['foo' => 'bar', 1, 2, 3]); // true
```

Note that mixed numeric indexes with associative indexes will be considered an associative array.

### join

Join a collection, and add a separator between the items.

```php
$spices = ['nutmeg', 'clove', 'cinnamon'];
f\join('_', $spices); // 'nutmeg_clove_cinnamon'
```

### keys

Returns the keys of a collection. Works with iterable object as well, contrary to the native
`array_keys`.

```php
f\keys(['a', 'b', 'c']); // [0, 1, 2]
f\keys(['foo' => 123, 'bar' => 456]); // ['foo', 'bar]
```

### keys_where

Returns the keys of a collection where its values match a given predicate function.

```php
$fruits = [
    ['name' => 'apple', 'color' => 'red'],
    ['name' => 'banana', 'color' => 'yellow'],
    ['name' => 'kiwi', 'color' => 'green'],
    ['name' => 'lime', 'color' => 'green'],
    ['name' => 'lemon', 'color' => 'yellow']
];

f\keys_where(f\prop_equals('color', 'green'), $fruits) // [2, 3]
```

### last

Returns the last item in a collection.

```php
f\last(['foo', 'bar', 'baz']); // 'baz'
f\last('Miles Davis'); // 's'
```

### lt

Returns true if the given value is less than the predicate.

```php
f\lt(10, 5); // true
f\lt(10, 100); // false
```

### lte

Returns true if the given value is less than or equal to the predicate.

```php
f\lte(10, 5); // true
f\lte(10, 10); // true
f\lte(10, 100); // false
```

### map

Curried version of `array_map`. 

```php
$names = ['Miles Davis', 'John Coltrane'];
f\map(f\split(' '), $names); // [['Miles', 'Davis'], ['John', 'Coltrane']]
```

### match

Returns the matches if the given value matches the regular expression:

```php
f\match('/^\d+$/', '12345'); // ['12345']
f\match('/([a-zA-Z]+) world/', 'Hello world'); // ['Hello world', 'Hello']
f\filter(f\match('/^\d+$/'), ['123', 'abc', '456']); // ['123', '456']
```

### merge_after

Like [merge_at](#merge_at), but will add the given item _after_ the specified index.

### merge_at

This is `array_splice` on steroids. For starters it won't mutate the given array, but returns a new results.  

Furthermore, it's designed to accept a plethora of input and deal especially with PHP's awkward sorted associative arrays.  

Examples will make this a thousand times more clear:

#### Splice a value into a numeric array

```php 
$numericArray = ['foo', 'bar', 'baz'];
f\merge_at('cux', 2, $numericArray); // ['foo', 'bar', 'cux', 'baz']
```

#### Splice a value into an associative array

```php
$assoc = [
    'foo' => 123,
    'baz' => 789
];
f\merge_at(['bar' => 456], 'baz', $assoc);

// Will return:
// [
//     'foo' => 123,
//     'bar' => 456,
//     'baz' => 789
// ]
```

Note the way we splice an associative construct into the array – by passing an array with a single `[key => value]` construction.
**This will work only when the target is an associative array already!**

#### Combine numeric keys with associative targets
You can use numeric indexes with associative arrays, for instance to move an item to the top.

```php
$assoc = [
    'foo' => 123,
    'baz' => 789
];
f\merge_at(['bar' => 456], 0, $assoc);

// Will return:
// [
//     'bar' => 456,
//     'foo' => 123,
//     'baz' => 789
// ]
```

#### Use predicate functions to determine the target

```php
$jazz = [
    'Miles' => [
        'name' => 'Miles Davis',
        'instrument' => 'trumpet'
    ],
    'John' => [
        'name' => 'John Coltrane',
        'instrument' => 'saxophone'
    ],
    'Herbie' => [
        'name' => 'Herbie Hancock',
        'instrument' => 'piano'
    ]
];
$withThelonious = f\merge_at(
    ['Thelonious' => ['name' => 'Thelonious Monk', 'instrument' => 'piano']],
    f\prop_equals('instrument', 'piano'),
    $jazz
);

// Will return:
// [
//   'Miles' => [
//       'name' => 'Miles Davis',
//       'instrument' => 'trumpet'
//   ],
//   'John' => [
//       'name' => 'John Coltrane',
//       'instrument' => 'saxophone'
//   ],
//   'Thelonious' => [
//       'name' => 'Thelonious Monk',
//       'instrument' => 'piano'
//   ],
//   'Herbie' => [
//       'name' => 'Herbie Hancock',
//       'instrument' => 'piano'
//   ]
// ];
```


### multiply

Multiplies two numbers.

```php
f\multiply(2, 10); // 20
f\multiply(5)(20); // 100
```

### modulo

Modulo of two numbers.

```php
f\modulo(3, 10); // 1
f\modulo(4)(6); // 2
```

### none

Returns true when none of the items in the list match the predicate function.

```php
$numbers = [12, 40, 23, 90];
f\none('is_string', $numbers); // true
f\none(f\gt(50), $numbers); // false
```

### not

Create a new function that negates the outcome of the given function.

```php
$noString = f\not('is_string');
$noString('Hello world'); // false
$noString(123); // true
```

### omit

Create a copy of the given array omitting the specified keys.  
This is the opposite of [pick](#pick).

```php
$miles = ['first' => 'Miles', 'last' => 'Davis', 'instrument' => 'Trumpet'];
f\omit(['instrument'], $miles); // ['first' => 'Miles', 'last' => 'Davis']
```

### once

Impure but very powerful: returns a function that guards the given function from being executed more than once.


```php
$addOne = function ($x) { return $x + 1; };
$addOneOnce = f\once($addOne); 
$addOneOnce(10); // 11
$addOneOnce(50); // 11
```

Subsequent calls will return the result of the first invocation.

### partial

Partially apply a function from the left side.

```php
$splitOnSpace = f\partial('explode', ' ');
$splitOnSpace('Hello World'); // ['Hello', 'World']
```

### partial_right

Partially apply a function from the right side.

```php
$isTraversableObject = f\partial_right('is_a', 'Traversable');
$isTraversableObject([1, 2, 3]); // false
```

### pick

Create an array from a subset of properties from the given object.

```php
$spices = ['nutmeg', 'clove', 'cinnamon'];
f\pick([1, 2], $spices); // [1 => 'clove', 2 => 'cinnamon']

$musician = ['first_name' => 'Miles', 'last_name' => 'Davis', 'instrument' => 'trumpet'];
f\pick(['first_name', 'instrument'], $musician); // ['first_name' => 'Miles', 'instrument' => 'trumpet']
```

### pipe

Compose functions together. Execution order is left to right.
It's the inverse of [compose](#compose). e.g. `pipe(foo, bar, baz)($args)` equals `baz(bar(foo($args)))`.

```php
$getInitials = f\pipe(
  f\split(' '),
  f\map(f\pipe(f\prop(0), f\concat_right('.'))),
  f\join(' ')
);
$getInitials('Miles Davis'); // M. D.

```

If you start at the right side you can follow along with the path your arguments will travel through 
the functional pipeline.

### prop_equals

Check equality with an object property.

```php
$musician = ['first_name' => 'Miles', 'last_name' => 'Davis'];
f\prop_equals('first_name', 'Miles', $musician); // true
```

It's curried as usual, making this an excellent predicate function for `filter`.

```php
$trumpetPlayers = f\filter(f\prop_equals('instrument', 'trumpet'), $musicians);
```

### prop

Take a property from a collection.  
Accepts objects, arrays, even stings.

```php
$miles = ['first_name' => 'Miles', 'last_name' => 'Davis'];
f\prop('first_name', $miles); // 'Miles'
f\prop('last_name', $miles); // 'Davis'
f\prop('date_of_birth', $miles); // null

$foo = new Foo();
$foo->bar = 'baz';
f\prop('bar', $foo); // 'baz'
f\prop('bin', $foo); // null

$name = 'Miles';
f\prop(0, $name); // 'M'
f\prop(3, $name); // 'e'
```

### prop_in

Inspired by Clojure's [get-in](https://clojuredocs.org/clojure.core/get-in), this function takes a
bunch of props and returns a value from a nested associative structure matching the given keys.

Doing `prop_in(["author", "comments", 0, "body"], $post)` would be the same as writing the
following, but safe since it won't blow up on missing properties:

```php
$post->author->comments[0]->body;
```

### prop_of

Take a property from a collection. This is the same function as [prop](#prop) but with its arguments
flipped. The use-case is common enough to warrant its own function.

```php
$miles = ['first_name' => 'Miles', 'last_name' => 'Davis'];
f\prop_of($miles, 'first_name'); // 'Miles'
f\prop_of($miles, 'last_name'); // 'Davis'
f\prop_of($miles, 'date_of_birth'); // null

$foo = new Foo();
$foo->bar = 'baz';
f\prop_of($foo, 'bar'); // 'baz'
f\prop_of($foo, 'bin'); // null

$name = 'Miles';
f\prop_of($name, 0); // 'M'
f\prop_of($name, 3); // 'e'
```

An interesting symmetry exists between PHP's native array access (using square brackets) and this
function. For example:

```php
$data = [
  'name' => 'spaghetti',
  'type' => 'pasta',
];

$food = f\prop_of($data);

$food('type'); // 'pasta'
$data['type']; // 'pasta'
```

So using a curried version of `prop_of` allows to stay close to the familiar way of accessing array
indices. The moment you access an undefined index however, our version turns out to be superior:

```php
$data['origin']; // Notice: Undefined index: origin
$food('origin'); // null
```

### prop_set

Returns a new object with the given `$key` set to the given `$value`:

```php
$data = [
    'name' => 'spaghetti',
    'type' => 'pasta',
];

$data2 = f\prop_set(
    'cook',
    'Mario',
    $data
);

// $data2: ['name' => 'spaghetti', 'type' => 'pasta', 'cook' => 'Mario']
// $data remains untouched: ['name' => 'spaghetti', 'type' => 'pasta'] 
```

### publish

This sounds bananas but this function basically publishes any private method.  
This wraps [Closure::bindTo](http://php.net/manual/en/closure.bindto.php), and exists mostly to be able to pass private methods to `map` and `filter`.

```php
class Foo {

    public function filterNumbers(array $collection) {
        // This is going to throw an exception:
        return f\map([$this, 'isInt'], $collection);
    }

    private function isInt($n) {
        return is_int($n);
    }

}
```

The above will generate an error because `isInt` is a private method.
`publish` can be used here to publish the create a closure scoped to the object and therefore able to reach the private method:

```php
public function filterNumbers(array $collection) {
    return f\map(f\publish('isInt', $this), $collection);
} 
```

Note: an alternative in PHP 7.1 would be `Closure::fromCallable()`, which is scoped to the current object automatically.

### reduce

Curried version of `array_reduce`:

```php
$numbers = [20, 43, 15, 12];
$sum = f\reduce('Garp\Functional\add', 0, $numbers); // 90
```

### reduce_assoc

Version of `reduce` tailored to associative datastructures. The key will be the third argument to the callback function.

```php
$assoc = [
    'foo' => [1, 2, 3],
    'bar' => [4],
    'baz' => []
];
$counts = f\reduce_assoc(
    function ($acc, $cur, $key) {
        return f\prop_set(
            $key, count($cur), $acc
        );
    },
    [],
    $assoc
); // Returns ["foo" => 3, "bar" => 1, "baz" => 0]
```

### reindex

Alias for the native `array_values`.  
I tend to use `array_values` a lot after `array_filter`, but the name `array_values` does not really
convey my intent to my fellow developers. Hopefully `reindex` does.

Note that [filter](#filter) has this built-in.

```php
$data = [123, 'abc', true, [], 'def'];
$strings = array_filter('is_string', $data); // [1 => 'abc', 4 => 'def']
f\reindex($strings); // [0 => 'abc', 1 => 'def'] 
``` 

### reject

Opposite of `filter`:

```php
$stuff = ['abc', 123, false, 'def', 456, true];
f\reject('is_int', $stuff); // ['abc', false, 'def', true]
f\reject('is_bool', $stuff); // ['abc', 123, 'def', 456]
```

### rename_keys

Rename keys in an array:

```php
$a = [
  'foo' => 123,
  'bar' => 456
];

f\rename_keys(
  ['foo' => 'baz', 'bar' => 'qud'],
  $a
); // ['baz' => 123, 'qud' => 456]
```

Of course it also accepts a transformer function:

```php
$a = [
  'foo' => 123,
  'bar' => 456
];

f\rename_keys('strrev', $a); // ['oof' => 123, 'rab' => 456]
```

### repeat

Repeats the given function a fixed number of times, returning an array of the accumulated results.

```php
$fiveRandomIds = f\repeat(5, 'uniqid')();
```

### replace

Curried `preg_replace`, basically:

```php
f\replace('/(hello)/', 'goodbye', 'hello world'); // 'goodbye world'
f\map(f\replace('/(\d)/', 'x'), ['123', 'abc', '456', ['90']]); // ['xxx', 'abc', 'xxx', ['90']] 
```

### some

Returns true if some of the items in the list match the predicate function.

```php
$numbers = [12, 40, 23, 90];
f\some('is_int', $numbers); // true
f\some(f\gt(50), $numbers); // true
f\some('is_string', $numbers); // false
```

### sort

Sort an array. A pure version of the native `sort`.  
Does not mutate the original array.

```php
$spices = ['Nutmeg', 'Clove', 'Cinnamon'];
$sortedSpices = f\sort($spices); // ['Cinnamon', 'Clove', 'Nutmeg']
$spices; // ['Nutmeg', 'Clove', 'Cinnamon']
```

### sort_by

Use the given function to sort a collection of objects.  
To sort by a certain key, use `f\prop()`:

```php
$musicians = [
    ['first_name' => 'Louis', 'last_name' => 'Armstrong', 'instrument' => 'trumpet'],
    ['first_name' => 'Miles', 'last_name' => 'Davis', 'instrument' => 'trumpet'],
    ['first_name' => 'John', 'last_name' => 'Coltrane', 'instrument' => 'saxophone'],
);
f\sort_by(f\prop('first_name'), $musicians);

/**
 * Result:
 *
 * [
 *  ['first_name' => 'John', 'last_name' => 'Coltrane', 'instrument' => 'saxophone'],
 *  ['first_name' => 'Louis', 'last_name' => 'Armstrong', 'instrument' => 'trumpet'],
 *  ['first_name' => 'Miles', 'last_name' => 'Davis', 'instrument' => 'trumpet'],
 * ]
 */
```

But another application could be to sort by length:

```php
$groups = [
    [1, 2, 3, 4, 5],
    [1, 2],
    [1, 2, 3]
];
f\sort_by('count', $groups);

/**
 * Result:
 *
 * [
 *  [1, 2],
 *  [1, 2, 3]
 *  [1, 2, 3, 4, 5],
 * ]
 */
 ```

### sort_by_map

Sort a given array by using a reference array:

```php
$roygbiv = ['red', 'orange', 'yellow', 'green', 'blue', 'indigo', 'violet'];
$colors = ['blue', 'orange', 'red', 'indigo'];
f\sort_by_map($roygbiv, $colors); // ['red', 'orange', 'blue', 'indigo']
```

Works with associative as well as numerically indexed arrays:

```php
$person = [
    'dob' => new DateTime('1985-02-11'),
    'nationality' => 'Nl',
    'name' => 'Harmen'
];
f\sort_by_map(
    ['name', 'nationality', 'dob'],
    $person
); // ['name' => 'Harmen', 'nationality' => 'Nl', 'dob' => new DateTime(...)]
```

### split

Split a string into an array.

```php
$musician = 'Miles Davis';
f\split(' ', $musician); // ['Miles', 'Davis']
```

### subtract

Subtracts the left argument from the right argument.

```php
f\subtract(10, 30); // 20
f\subtract(10)(30); // 20
```

### tail

Get the tail of a list.

```php
$spices = ['nutmeg', 'clove', 'cinnamon'];
f\tail($spices); // ['clove', 'cinnamon']
f\tail('Miles'); // 'iles'
```

### take

Take `$n` items of a collection:

```php
f\take(2, ['foo', 'bar', 'baz']); // ['foo', 'bar']
f\take(5, 'Miles Davis'); // ['M', 'i', 'l', 'e', 's']
```

### take_while

Perhaps more interesting than `take` is `take_while`. It keeps taking items from the front of a
collection until the predicate function returns `false` for the given item.  
It's like `filter` but could be faster if your collection is ordered, since `take_while` will stop
after the first falsey result.

```php
$diary = array(
    array('month' => 1, 'day' => 1, 'entry' => '...'),
    array('month' => 1, 'day' => 14, 'entry' => '...'),
    array('month' => 2, 'day' => 27, 'entry' => '...'),
    array('month' => 3, 'day' => 1, 'entry' => '...'),
    array('month' => 3, 'day' => 5, 'entry' => '...'),
    array('month' => 4, 'day' => 2, 'entry' => '...')
);
$janFebEntries = f\take_while(f\compose(f\lte(2), f\prop('month')), $diary);

/**
 * Result:
 *  array(
 *      array('month' => 1, 'day' => 1, 'entry' => '...'),
 *      array('month' => 1, 'day' => 14, 'entry' => '...'),
 *      array('month' => 2, 'day' => 27, 'entry' => '...'),
 *  )
 */
```

See also [drop](#drop) and [drop_while](#drop_while).

### tap

`tap` is a higher-order function that's helpful to include side-effects in a chain.  
It returns a function which calls the given callback but discards its return value and returns the original value.

You can use it to debug a function composition. Consider the following:

```php
$composition = f\compose($functionA, $functionB, $functionC); 
```

If something goes wrong in `$functionB`, you might want to log the intermediate value, which can be difficult in a composition like this.  
One solution would be:

```php
$composition = f\compose($functionA, function($x) { myLoggingFunction($x); return X; }, $functionB, $functionC); 
```

But that's a bit cumbersome. This is exactly where `tap()` comes in:

```php
$composition = f\compose($functionA, f\tap('myLoggingFunction'), $functionB, $functionC); 
```

An explicit example:

```php
function log($var) {
  var_dump($var);
}

$thing = f\tap('log')('my thing'); // dumps "my thing", and stores its value in $thing
``` 

### truthy

Returns wether the given argument is truthy.

```php
f\truthy(12345); // true
f\truthy(false); // false
f\truthy(''); // false
f\truthy([1, 2, 3]); // true
```

If given a function, it'll return a new function waiting for input. The funciton's return value will
be checked for truthiness.

```php
$isArray = f\truthy('is_array');
$isArray(array()); // true
$isArray(123); // false
```

### unary

Creates a new function that passes only the first argument thru to the given function.

```php
$countArgs = function () {
    return count(func_get_args());
};
$countArgs(1, 2, 3); // 3
f\unary($countArgs)(1, 2, 3); // 1 
```

This is helpful in situations where giving a function too many arguments explicitly triggers an
error, but you have no control over the amount of arguments passed to the function.  
An example is the native `is_array`, which accepts one
argument and one argument only. Our `some` function however, gives the predicate function both the
item in the collection and its index.

This would cause an error:

```php
$hasArray = f\some('is_array');
$stuff = array('abc', array(), 123, true);
$hasArray($stuff); // Warning: is_array() expects exactly 1 parameter, 2 given
```

`unary` can fix this for you:

```php
$hasArray = f\some(f\unary('is_array'));
$stuff = array('abc', array(), 123, true);
$hasArray($stuff); // true
``` 

### unique

A version of the native `array_unique` which works with multi-dimensional arrays.

```php
$musicians = [
    ['first_name' => 'Miles', 'last_name' => 'Davis', 'instrument' => 'trumpet'],
    ['first_name' => 'Miles', 'last_name' => 'Davis', 'instrument' => 'trumpet'],
    ['first_name' => 'Louis', 'last_name' => 'Armstrong', 'instrument' => 'trumpet'],
    ['first_name' => 'John', 'last_name' => 'Coltrane', 'instrument' => 'saxophone'],
    ['first_name' => 'Miles', 'last_name' => 'Davis', 'instrument' => 'trumpet'],
    ['first_name' => 'John', 'last_name' => 'Coltrane', 'instrument' => 'saxophone'],
    ['first_name' => 'Louis', 'last_name' => 'Armstrong', 'instrument' => 'trumpet'],
];
f\unique($musicians);

/**
 * Result:
 * 
 * [
 *   ['first_name' => 'Miles', 'last_name' => 'Davis', 'instrument' => 'trumpet'],
 *   ['first_name' => 'Louis', 'last_name' => 'Armstrong', 'instrument' => 'trumpet'],
 *   ['first_name' => 'John', 'last_name' => 'Coltrane', 'instrument' => 'saxophone']
 * ]
 */ 
```

### usort

Same as `sort`, but is a version of the native `usort`.

```php
$spices = ['clove', 'nutmeg', 'allspice', 'cumin'];
f\usort(
    function ($a, $b) {
        return strlen($a) - strlen($b);
    },
    $spices
); // ['clove', 'cumin', 'nutmeg', 'allspice']
```

### when

It's a ternary operator in function form.

Given three scalar values, it's truly a ternary operation:

```php
f\when(true, 'yep', 'nope'); // 'yep'
f\when(false, 'yep', 'nope'); // 'nope'
```

But given functions, it gets a little more interesting:

```php
$givePoints = f\when(
    f\prop_equals('type', 'superuser'),
    f\concat(['points' => 100]),
    f\concat(['points' => 50])
);
$customer = ['name' => 'Joe', 'type' => 'regular'];
$givePoints($customer); // ['name' => 'Joe', 'type' => 'regular', 'points' => 50];
$superCustomer = ['name' => 'Hank', 'type' => 'superuser'];
$givePoints($superCustomer); // ['name' => 'Hank', 'type' => 'superuser', 'points' => 100]; 
``` 

The fourth argument is passed into all the given functions.

### zip

Creates a new array by pairing up indexes from the supplied arrays.  
Takes two or more arguments.

```php
f\zip([1, 2, 3], ['a', 'b', 'c']); // [[1, 'a'], [2, 'b'], [3, 'c']]
```

`null` will be provided for missing indexes:

```php
$miles = array('first' => 'Miles', 'last' => 'Davis', 'instrument' => 'Trumpet');
$john = array('first' => 'John', 'last' => 'Coltrane');
f\zip($miles, $john); // [
                      //   'first' => ['Miles', 'John'],
                      //   'last' => ['Davis', 'Coltrane'],
                      //   'instrument' => ['Trumpet', null]
                      // ]
```

## Typeclasses

`Garp\Functional` implements various typeclasses, following [The Fantasyland Specification](https://github.com/fantasyland/fantasy-land).  
Implementing these takes time, which means this list won't be complete for a while. Pull Requests are very welcome.

A typeclass is an algebraic datatype that adheres to some laws.  
The specific implementation is up to you, as long as the laws are obeyed, the object can be used with functions in this library, and objects can be composed to form new functionality.

Read the [Fantasyland Specification](https://github.com/fantasyland/fantasy-land) for in-depth details, and [Tom Harding's Fantas, Eel, And Specification](http://www.tomharding.me/fantasy-land/) for concrete implementations (in Javascript) of these types and why they're so incredibly useful.

### Test traits

This library offers only interfaces, very little concrete implementations of the types.  
You have to implement the classes yourself. How will you know you've implemented them correctly?

`Garp\Functional` offers traits that can be used to test your objects. The list below includes examples of how to use the traits to test whether your objects obey the algebraic laws defined for the given type.

### Full list of implemented types

All types are in the `Garp\Functional\Types` namespace. So the fully qualified name of `Setoid` for instance would be `Garp\Functional\Types\Setoid`.

#### Setoid

Encapsulates equality. 

##### Methods

```
public function equals(Setoid $that);
```

##### Testing

```
use Garp\Functional\Types\Traits\TestsSetoidLaws;

$this->assertObeysSetoidLaws($setoid1, $setoid2, $setoid3);
```

Pass it 3 of your Setoid-implementing instances and the Setoid laws will be checked against your class.

##### Works with functions

- [equals](#equals)

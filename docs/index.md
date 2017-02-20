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

- [Add](#add)
- [Always](#always)
- [Both](#both)
- [Call](#call)
- [Compose](#compose) 
- [Concat](#concat)
- [ConcatRight](#concatright)
- [Either](#either)
- [Equals](#equals)
- [Every](#every) 
- [Filter](#filter)
- [Find](#find)
- [Flatten](#flatten) 
- [Flip](#flip)
- [Gt](#gt)
- [Gte](#gte)
- [Head](#head)
- [Id](#id)
- [Instance](#instance)
- [Join](#join) 
- [Keys](#keys)
- [Lt](#lt)
- [Lte](#lte)
- [Map](#map)
- [Match](#match)
- [None](#none)
- [Not](#not) 
- [Omit](#omit)
- [Partial](#partial)
- [PartialRight](#partialright)
- [Pick](#pick) 
- [PropEquals](#propequals)
- [Prop](#prop)
- [Reduce](#reduce) 
- [Reindex](#reindex)
- [Replace](#replace)
- [Some](#some)
- [Sort](#sort) 
- [Split](#split)
- [Subtract](#subtract)
- [Tail](#tail)
- [Truthy](#truthy)
- [Unary](#unary)
- [Usort](#usort)
- [When](#when)
- [Zip](#zip)

_Note: code examples assume the library is loaded with `use Garp\Functional as f;`_

_Also note: list functions are generally designed to work with both numerically indexed and associative arrays, iterable objects and strings._

### Add

Adds two numbers.

```php
f\add(10, 20); // 30
f\add(10)(20); // 30
```

### Always

Returns a function that always returns the given argument.  

```php
$alwaysMiles = f\always('Miles Davis');
$alwaysMiles(1, 2, 3); // 'Miles Davis'
``` 

### Both

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

### Call

Call a method on an object.

```php
// Image an array of active records, containing a `getName` method.
$users = $database->fetchUsers();
$names = f\map(f\call('getName'), $users); // array of names
```

### Compose

Compose functions together. Execution order is right to left, as is traditional.
It mimics a manual approach. e.g. `compose(foo, bar, baz)($args)` equals `foo(bar(baz($args)))`.

Let's look at the crazy example from the intro of this page:

```php
$getInitials = f\compose(f\join(' '), f\map(f\compose(f\concat_right('.'), f\prop(0))), f\split(' '));
$getInitials('Miles Davis'); // M. D.
```

If you start at the right side you can follow along with the path your arguments will travel through 
the functional pipeline.

### Concat

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

### ConcatRight

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

### Either

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

### Equals

Equality check in function form.

```php
f\equals(1, 2); // false
f\equals('Hello', 'Hello'); // true
f\equals('1', 1); // false
```

### Every

Returns true if all items in the list match the predicate function.

```php
$numbers = [12, 40, 23, 90];
f\every('is_int', $numbers); // true
f\every(f\gt(50), $numbers); // false
```

### Filter

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

### Find

Basically combines `filter` with a `prop(0)` call: it filters a collection and returns the first
match.

```php
$numbers = [40, 15, 23, 90, 29];
f\find(f\gt(20), $numbers); // 23
f\find(f\gt(200), $numbers); // null
``` 

### Flatten

Flatten an array of arrays into a single array.

```php
$data = [1, 2, [3, 4, 5, [6, 7], 8], 9, [], 10];
f\flatten($data); // [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
```

### Flip

Flip the order of the first two arguments of a function.

```php
$concat = function ($a, $b) {
    return $a . $b;
};
$concat('Hello', 'world'); // 'Helloworld'
f\flip($concat)('Hello', 'world'); // 'worldHello'
```

### Gt

Returns true if the given value is greater than the predicate.

```php
f\gt(10, 100); // true
f\gt(10, 5); // false
```

### Gte

Returns true if the given value is greater than or equal to the predicate.

```php
f\gte(10, 100); // true
f\gte(10, 10); // true
f\gte(10, 9); // false
```

### Head

Get the head of a list.

```php
$spices = ['nutmeg', 'clove', 'cinnamon'];
f\head($spices); // 'nutmeg'
f\head('Miles'); // 'M'
```

### Id

Identity function, returns what it's given.   
Useful in places that expect a callback function but you don't want to mutate anything. For instance
in a [`when`](#when) application.

```php
123 === f\id(123); // true
$spices = ['clove', 'nutmeg', 'allspice', 'cumin'];
$spices === f\id($spices); // true
``` 

### Instance

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

### Join

Join a collection, and add a separator between the items.

```php
$spices = ['nutmeg', 'clove', 'cinnamon'];
f\join('_', $spices); // 'nutmeg_clove_cinnamon'
```

### Keys

Returns the keys of a collection. Works with iterable object as well, contrary to the native
`array_keys`.

```php
f\keys(['a', 'b', 'c']); // [0, 1, 2]
f\keys(['foo' => 123, 'bar' => 456]); // ['foo', 'bar]
```

### Lt

Returns true if the given value is less than the predicate.

```php
f\lt(10, 5); // true
f\lt(10, 100); // false
```

### Lte

Returns true if the given value is less than or equal to the predicate.

```php
f\lte(10, 5); // true
f\lte(10, 10); // true
f\lte(10, 100); // false
```

### Map

Curried version of `array_map`. 

```php
$names = ['Miles Davis', 'John Coltrane'];
f\map(f\split(' '), $names); // [['Miles', 'Davis'], ['John', 'Coltrane']]
```

### Match

Returns the matches if the given value matches the regular expression:

```php
f\match('/^\d+$/', '12345'); // ['12345']
f\match('/([a-zA-Z]+) world/', 'Hello world'); // ['Hello world', 'Hello']
f\filter(f\match('/^\d+$/'), ['123', 'abc', '456']); // ['123', '456']
```

### None

Returns true when none of the items in the list match the predicate function.

```php
$numbers = [12, 40, 23, 90];
f\none('is_string', $numbers); // true
f\none(f\gt(50), $numbers); // false
```

### Not

Create a new function that negates the outcome of the given function.

```php
$noString = f\not('is_string');
$noString('Hello world'); // false
$noString(123); // true
```

### Omit

Create a copy of the given array omitting the specified keys.  
This is the opposite of [pick](#pick).

```php
$miles = ['first' => 'Miles', 'last' => 'Davis', 'instrument' => 'Trumpet'];
f\omit(['instrument'], $miles); // ['first' => 'Miles', 'last' => 'Davis']
```

### Partial

Partially apply a function from the left side.

```php
$splitOnSpace = f\partial('explode', ' ');
$splitOnSpace('Hello World'); // ['Hello', 'World']
```

### PartialRight

Partially apply a function from the right side.

```php
$isTraversableObject = f\partial_right('is_a', 'Traversable');
$splitHelloWorld([1, 2, 3]); // false
```

### Pick

Create an array from a subset of properties from the given object.

```php
$spices = ['nutmeg', 'clove', 'cinnamon'];
f\pick([1, 2], $spices); // [1 => 'clove', 2 => 'cinnamon']

$musician = ['first_name' => 'Miles', 'last_name' => 'Davis', 'instrument' => 'trumpet'];
f\pick(['first_name', 'instrument'], $musician); // ['first_name' => 'Miles', 'instrument' => 'trumpet']
```

### PropEquals

Check equality with an object property.

```php
$musician = ['first_name' => 'Miles', 'last_name' => 'Davis'];
f\prop_equals('first_name', 'Miles', $musician); // true
```

It's curried as usual, making this an excellent predicate function for `filter`.

```php
$trumpetPlayers = f\filter(f\prop_equals('instrument', 'trumpet'), $musicians);
```

### Prop

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

### Reduce

Curried version of `array_reduce`:

```php
$numbers = [20, 43, 15, 12];
$sum = f\reduce('f\add', 0, $numbers); // 90
```

### Reindex

Alias for the native `array_values`.  
I tend to use `array_values` a lot after `array_filter`, but the name `array_values` does not really
convey my intent to my fellow developers. Hopefully `reindex` does.

Note that [filter](#filter) has this built-in.

```php
$data = [123, 'abc', true, [], 'def'];
$strings = array_filter('is_string', $data); // [1 => 'abc', 4 => 'def']
f\reindex($strings); // [0 => 'abc', 1 => 'def'] 
``` 

### Replace

Curried `preg_replace`, basically:

```php
f\replace('/(hello)/', 'goodbye', 'hello world'); // 'goodbye world'
f\map(f\replace('/(\d)/', 'x'), ['123', 'abc', '456', ['90']]); // ['xxx', 'abc', 'xxx', ['90']] 
```

### Some

Returns true if some of the items in the list match the predicate function.

```php
$numbers = [12, 40, 23, 90];
f\some('is_int', $numbers); // true
f\some(f\gt(50), $numbers); // true
f\some('is_string', $numbers); // false
```

### Sort

Sort an array. A pure version of the native `sort`.  
Does not mutate the original array.

```php
$spices = ['Nutmeg', 'Clove', 'Cinnamon'];
$sortedSpices = f\sort($spices); // ['Cinnamon', 'Clove', 'Nutmeg']
$spices; // ['Nutmeg', 'Clove', 'Cinnamon']
```

### Split

Split a string into an array.

```php
$musician = 'Miles Davis';
f\split(' ', $musician); // ['Miles', 'Davis']
```

### Subtract

Subtracts the left argument from the right argument.

```php
f\subtract(10, 30); // 20
f\subtract(10)(30); // 20
```

### Tail

Get the tail of a list.

```php
$spices = ['nutmeg', 'clove', 'cinnamon'];
f\tail($spices); // ['clove', 'cinnamon']
f\tail('Miles'); // 'iles'
```

### Truthy

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

### Unary

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

### Usort

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

### When

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

### Zip

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

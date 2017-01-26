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

[Lists](#lists)

- [Map](#map)
- [Filter](#filter)
- [Reduce](#reduce) 
- [Every](#every) 
- [Some](#some)
- [None](#none)
- [Find](#find)
- [Prop](#prop)
- [Pick](#pick) 
- [Join](#join) 
- [Split](#split)
- [Concat](#concat)
- [ConcatRight](#concat-right)
- [Flatten](#flatten) 
- [Sort](#sort) 
- [Usort](#usort)
- [Reindex](#reindex)

[Functional](#functional)

- [Compose](#compose) 
- [Partial](#partial)
- [PartialRight](#partial-right)
- [Not](#not) 
- [Unary](#unary)
- [Call](#call)
- [Flip](#flip)
- [Id](#id)
- [Instance](#instance)

[Logical](#logical)

- [When](#when)
- [Equals](#equals)
- [PropEquals](#prop-equals)
- [Either](#either)
- [Gt](#gt)
- [Lt](#lt)

[Math](#math)
- [Add](#add)
- [Subtract](#subtract)

_Note: code examples assume the library is loaded with `use Garp\Functional as f;`_

### Lists

_Note: list functions are generally designed to work with both numerically indexed and associative arrays, iterable objects and strings._

#### Map

Curried version of `array_map`. 

```php
$names = ['Miles Davis', 'John Coltrane'];
f\map(f\split(' '), $names); // [['Miles', 'Davis'], ['John', 'Coltrane']]
```

#### Filter

Curried version of `array_filter`.

```php
$names = ['Miles Davis', 'John Coltrane'];
f\filter(f\equals('Miles Davis'), $names); // ['Miles Davis']
```

(see also: [find](#find))

#### Reduce

Curried version of `array_reduce`:

```php
$numbers = [20, 43, 15, 12];
$sum = f\reduce('f\add', 0, $numbers); // 90
```

#### Every

Returns true if all items in the list match the predicate function.

```php
$numbers = [12, 40, 23, 90];
f\every('is_int', $numbers); // true
f\every(f\gt(50), $numbers); // false
```

#### Some

Returns true if some of the items in the list match the predicate function.

```php
$numbers = [12, 40, 23, 90];
f\some('is_int', $numbers); // true
f\some(f\gt(50), $numbers); // true
f\some('is_string', $numbers); // false
```

#### None

Returns true when none of the items in the list match the predicate function.

```php
$numbers = [12, 40, 23, 90];
f\none('is_string', $numbers); // true
f\none(f\gt(50), $numbers); // false
```

#### Find

### Math

#### Add

Adds two numbers.

```php
f\add(10, 20); // 30
f\add(10)(20); // 30
```

#### Subtract

Subtracts the left argument from the right argument.

```php
f\subtract(10, 30); // 20
f\subtract(10)(30); // 20
```



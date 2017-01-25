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
$getInitials = f\compose(f\join(' '), f\map(f\compose(f\concat_right('.'), f\prop(0))), f\split(' '));
$getInitials('Miles Davis'); // M. D.
```

Sure, that line is cuckoo, but the idea of composing functions without having to stop at every step to consider the control flow structures, what the parameters are going to be named, and how to return it is pretty powerful.  


## Function index

[Mathematical](#mathematical)
- [Add](#add)
- [Subtract](#subtract)

_Note: code examples assume the library is loaded with `use Garp\Functional as f;`_

### Mathematical

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



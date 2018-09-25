# hashlib
Hashlib是一个小型PHP库，可以从数字中生成类似YouTube的ID，当您不想将数据库ID暴露给用户时使用它。

**hashlib** is small PHP library to generate YouTube-like ids from numbers. Use it when you don't want to expose your database ids to the user: [http://hashids.org/php](http://hashids.org/php)

## Getting started

Require this package, with [Composer](https://getcomposer.org), in the root directory of your project.

```bash
$ composer require zhujinkui/hashlib
```

Then you can import the class into your application:

```php
use think\Hashlib;

$hashlib = new Hashlib();

$hashlib->encode(1);
```

## Quick Example

```php
use think\Hashlib;

$hashlib = new Hashlib();

$id = $hashlib->encode(1, 2, 3); // o2fXhV
$numbers = $hashlib->decode($id); // [1, 2, 3]
```

## More Options

**A few more ways to pass to `encode()`:**

```php
use think\Hashlib;

$hashlib = new Hashlib();

$hashlib->encode(1, 2, 3); // o2fXhV
$hashlib->encode([1, 2, 3]); // o2fXhV
$hashlib->encode('1', '2', '3'); // o2fXhV
$hashlib->encode(['1', '2', '3']); // o2fXhV
```

**Make your ids unique:**

Pass a project name to make your ids unique:

```php
use think\Hashlib;

$hashlib = new Hashlib('My Project');
$hashlib->encode(1, 2, 3); // Z4UrtW

$hashlib = new Hashlib('My Other Project');
$hashlib->encode(1, 2, 3); // gPUasb
```

**Use padding to make your ids longer:**

Note that ids are only padded to fit **at least** a certain length. It doesn't mean that your ids will be *exactly* that length.

```php
use think\Hashlib;

$hashlib = new Hashlib(); // no padding
$hashlib->encode(1); // jR

$hashlib = new Hashlib('', 10); // pad to length 10
$hashlib->encode(1); // VolejRejNm
```

**Pass a custom alphabet:**

```php
use think\Hashlib;

$hashlib = new Hashlib('', 0, 'abcdefghijklmnopqrstuvwxyz'); // all lowercase
$hashlib->encode(1, 2, 3); // mdfphx
```

**Encode hex instead of numbers:**

Useful if you want to encode [Mongo](https://www.mongodb.com)'s ObjectIds. Note that *there is no limit* on how large of a hex number you can pass (it does not have to be Mongo's ObjectId).

```php
use think\Hashlib;

$hashlib = new Hashlib();

$id = $hashlib->encodeHex('507f1f77bcf86cd799439011'); // y42LW46J9luq3Xq9XMly
$hex = $hashlib->decodeHex($id); // 507f1f77bcf86cd799439011
```

## Pitfalls

1. When decoding, output is always an array of numbers (even if you encode only one number):

	```php
	use think\Hashlib;

	$hashlib = new Hashlib();

	$id = $hashlib->encode(1);

	$hashlib->decode($id); // [1]
	```

2. Encoding negative numbers is not supported.
3. If you pass bogus input to `encode()`, an empty string will be returned:

	```php
	use think\Hashlib;

	$hashlib = new Hashlib();

	$id = $hashlib->encode('123a');

	$id === ''; // true
	```

4. Do not use this library as a security tool and do not encode sensitive data. This is **not** an encryption library.

# Randomness

The primary purpose of Hashids is to obfuscate ids. It's not meant or tested to be used as a security or compression tool. Having said that, this algorithm does try to make these ids random and unpredictable:

No repeating patterns showing there are 3 identical numbers in the id:

```php
use think\Hashlib;

$hashlib = new Hashlib();

$hashlib->encode(5, 5, 5); // A6t1tQ
```

Same with incremented numbers:

```php
use think\Hashlib;

$hashlib = new Hashlib();

$hashlib->encode(1, 2, 3, 4, 5, 6, 7, 8, 9, 10); // wpfLh9iwsqt0uyCEFjHM

$hashlib->encode(1); // jR
$hashlib->encode(2); // k5
$hashlib->encode(3); // l5
$hashlib->encode(4); // mO
$hashlib->encode(5); // nR
```

## Curses! #$%@

This code was written with the intent of placing created ids in visible places, like the URL. Therefore, the algorithm tries to avoid generating most common English curse words by generating ids that never have the following letters next to each other:

```
c, f, h, i, s, t, u
```

## License

MIT License. See the [LICENSE](LICENSE) file. You can use Hashids in open source projects and commercial products. Don't break the Internet. Kthxbye.

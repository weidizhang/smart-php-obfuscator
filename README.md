# smart-php-obfuscator

Created by Weidi Zhang

## License

Please read LICENSE.md to learn about what you can and cannot do with this source code.

Selling commercial licenses, create an issue on github.

## Description

A smart, advanced, yet simple obfuscator for PHP.


**How is it _special_?**


While the end result looks like a simple eval with base64_decode on the original code, it's much more than that.
It's deceptive in how protected the code really is, and that can be seen in the source code. The classic replace 
eval with echo trick to view obfuscated code will result in a huge (and complex) yuck that will give people headaches
when you use smart-php-obfuscator. Try it yourself!

## Popular Deobfuscator Tests

- UnPHP.net - **Failed to Deobfuscate** - As of July 20, 2016
- JonhBurn2.FreeHostia.com - **Failed to Deobfuscate** - As of July 20, 2016
- FailBoat.org (Project VoidWalker) - **Failed to Deobfuscate** - As of July 20, 2016
- DDecode.com (PHP Decoder) - **Failed to Deobfuscate** - As of July 20, 2016

## Requirements

PHP 7.0+

## Usage

See example.php
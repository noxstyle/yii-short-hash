Yii-Short-Hash
==============

Description
--------------
Yii-short-hash is a wrapper for KevBurnsJr's PseudoCrypt class. It is used to generate short hashes from natural numbers.

From KevBurns:
*This is a minimum security technique.
Keep your primes a secret and limit the number of hashes a user can get his hands on to make it harder for script kiddies to reverse engineer your algo. This is a thin rotation and base re-encoding obfuscation algorithm, not an encryption algorithm. Don’t use this to crypt sensitive info. Use it to obfuscate integer IDs.*

Original class can be found at: http://blog.kevburnsjr.com/php-unique-hash

Installation
--------------
Clone or download the repo and extract extensions/yii-short-hash to
	`protected/extensions/`

Add the extension to your configuration:
	`'components' => array(
		*...*
		'shortHash' => array(
			'class' => 'ext.yii-short-hash.ShortHash',
			'length' => 5,
		),
		*...*
	)`

**Note:** If 'length' param is passed, it will be used as the default length for hashes. Defaults to 5.

*Some tests are included.*

Usage
--------------
To hash an integer:
	`Yii::app()->shortHash->hash($number);`
Optionally you may pass in custom length:
	`Yii::app()->shortHash->hash($number, $length);`

To unhash an integer:
	`Yii::app()->shortHash->unhash($hash);`

Info
--------------

Hash lengths are as following:
*Hash length: x, maxium number allowed: x^length*

E.g:
- Hash length: 2, numbers up to 62² (3844)
- Hash length: 5, numbers up to 62⁵ (916132832)
- etc...

Maximum length that can be used is **10**.


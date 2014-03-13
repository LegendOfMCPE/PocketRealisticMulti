Guidelines for Contrinuting for PocketRealisticMulti (PRM)
===

##To be a collaborator...
I (@PEMapModder) will invite you if I want to.

##To contribute code…
Code not in this format may not be merged. Format of code here:
* Remove all spaces unless:
 * they are in quotes (`""`)
 * removing them would cause syntax errors.
 * the spaces are in a `$bool ? $true : $false` style.
* If an `if` or `for` or `while` statement only has one block of code, move that into a new line. Example:

```php
if(2<3)
(\t)return "yes";
```

* For indents, ALWAYS use horizontal tabs (`\t`)
* For block statements, ALWAYS put the open curly braces at the same line of the conditional/keyword line.
* If the parameters in a function (including function `array()`) are too long, split them into multiple lines. THE LINES WITH UNCLOSED BRACKETS MUST INDENT TWICE. Example:

```php
$me=array(
(\t)(\t)"key0"=>array(
(\t)(\t)(\t)(\t)"very long code"
(\t)(\t))
);
```

* Do not use namespaces.
* All keywords (non-constant) should be in lowercase.
* All built-in functions should use case from reference at http://php.net
* All constants other than `true`, `false` and `null` should use uppercase.
* Variable names, function names and class names should use the conventional style of naming, i.e. `ClassName::functionName($varName)`
* Do not contain your own name in the commit.
* For complicated mathematical code, you should add comments, and optionally split the variables into multiple lines of declaring variables. Also add comments for TODOs.
* Do not contain non-ASCII characters in PHP code. You may create raw text files/config files at /PocketRealisticMulti/code/assets that contain multi-byte characters.
* Create files only and directly at  PocketRealisticMulti/code/classes.
* Only create files when there is a new class.
* All functions and constants should either start with PRM_ xor prm_, or be contained in a class.
* Only create pull requests with base branch as PEMapModder/master.

##To create issues…
* Don't duplicate issues.


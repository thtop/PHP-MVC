# Advanced routing: add simpler but more powerful routes

## Introduction to advanced routing using route variables

The router

Objective: get a **controller** and **action** based on the **route**:

- `daveh.io/posts?page=2` -> Router -> Controller -> Action

Simple route matching

- Current routing table has an entry for **each route**:

| Route            | Controller  | Action |
| ---------------- | ----------- | ------ |
| `/`              | Home        | index  |
| `/posts`         | Posts       | index  |
| `/show_post`     | Posts       | show   |
| `/admin/users`   | Admin\Users | index  |
| `/products/list` | Products    | list   |

Advanced route matching

- Advanced route matching

| Route                 | Controller  | Action |
| --------------------- | ----------- | ------ |
|                       | Home        | index  |
|                       | Posts       | index  |
| `controller / action` | Posts       | show   |
|                       | Admin\Users | index  |
|                       | Products    | list   |

---

## How to do comples string comparisons: an introduction to regular expressions

Simple string comparisons

```php
$name = "Dave";

if ($name == "Dave") {
  $likes_chocolate = true;
}
```

Simple string replacement

```php
str_replace("blue", "red", "Roses are blue");

// result: Roses are red

```

Simmple string matching

```php
$pos = strpos("Dave likes chocolate", "choc");

if ($pos ==== false) {
  $found_choc = false;
}
```

Fixed string comparison

- Comparing to a **fixed** string:
  - `if ($name == "Dave") { ...`
  - `str_replace("blue", "red", "Roses are blue");`
  - `strpos("Dave likes chocolate", "choc");`
- More complicated comparisons?

Regular **expressions**

- A regulare expression describes as a **pattern** of characters.
- Can match **part of a string**.
- Can be used for advanced **matching** and **replacing**:
  - e.g. match or replace **just numbers** in a string;
  - see if a string contains a **valid email address**, etc.

Regular expression matching in PHP

Instead of a **fixed string** comparison:

- `if ($name == "Dave") { ...`

The comparison is with a **pattern**.

- `if (preg_match("/Dave/", $name)) { ...`

### Simple character matching

- Everything is a character: **letters, numbers, punctuation** etc.:

| Regular expression | String   | Match? |
| ------------------ | -------- | :----: |
| /abc/              | abc      |   ✅   |
|                    | abcdef   |   ✅   |
|                    | bcde     |   ❌   |
| /2:3/              | 12:34:56 |   ✅   |

### Metacharacters

- Used to match a **specific type of character**:

|     |                                              |
| --- | -------------------------------------------- |
| \d  | any digit from 0 to 9                        |
| \w  | any character from a to z, A to Z and 0 to 9 |
| \s  | any whitespace character (space, tab etc.)   |

| Regular expression | String | Match? |
| ------------------ | ------ | :----: |
| /ab\d/             | ab23   |   ✅   |
| /abc\d/            | ab23   |   ❌   |
| /\d\d/             | ab23   |   ✅   |
| /\w\s\d/           | ab 34  |   ✅   |

- [https://www.phpliveregex.com/](https://www.phpliveregex.com/)

---

## Using special characters in regular expressions: advanced pattern matching

### The start and end of the string

|     |                              |
| --- | ---------------------------- |
| `^` | the **start** fo the string; |
| `$` | the **end** of the string:   |

| Regular expression | String | Match? |
| ------------------ | ------ | :----: |
| /`^abc`/           | abc    |   ✅   |
|                    | abcdef |   ✅   |
|                    | 123abc |   ❌   |
| /`abc$`/           | 123abc |   ✅   |
| /`^abc$`/          | abc    |   ✅   |
| /`^abc$`/          | abcdef |   ❌   |

### Repetition

|     |               |
| --- | ------------- |
| `*` | zero ro more; |
| `+` | one or more:  |

| Regular expression | String  | Match? |
| ------------------ | ------- | :----: |
| /`a*bc`/           | abc     |   ✅   |
|                    | bc      |   ✅   |
| /`a+bc`/           | bc      |   ❌   |
|                    | aaaaabc |   ✅   |

### Wildcards

|     |                                                                 |
| --- | --------------------------------------------------------------- |
| `.` | match any **single** character: latter, number, whitespace etc. |

| Regular expression | String | Match? |
| ------------------ | ------ | :----: |
| /`ab.de`/          | abcde  |   ✅   |
|                    | ab4de  |   ✅   |
|                    | ab de  |   ✅   |
|                    | abde   |   ❌   |
| /`abc.*`/          | abcdef |   ✅   |
|                    | abc    |   ✅   |

### Escaping

- `\` = match metacharacters by escaping them

| Regular expression | String | Match? |
| ------------------ | ------ | :----: |
| /`abc.`/           | abcd   |   ✅   |
| /`abc\.`/          | abcd   |   ❌   |
|                    | abc.   |   ✅   |

### Case sensitive modifier

- Patterns are **case sensitive**. Adding the `i` modifier after the regular expression makes it **case insensitive**:

| Regular expression | String | Match? |
| ------------------ | ------ | :----: |
| /`abc`/            | abc    |   ✅   |
|                    | Abc    |   ❌   |
| /`abc`/i           | Abc    |   ✅   |

---

## Write even more powerful regular expressions: use character sets and ranges

- `[]` Match **one** of any of the characters in the brackets, e.g. `[abc]` will match `a`, `b` or `c` and nothing else:

| Regular expression | String   | Match? |
| ------------------ | -------- | :----: |
| /`a[123]b`/        | a2b      |   ✅   |
|                    | a3b      |   ✅   |
|                    | a4b      |   ❌   |
| /`a[123]+b`/       | a321322b |   ✅   |

### Character ranges

- `[ - ]` specify a **range of characters** inside a character set, e.g. `[0-9]` will match a **single** digit between 0 and 9, and nothing else:

| Regular expression | String      | Match? |
| ------------------ | ----------- | :----: |
| /`a[1-5]b`/        | a2b         |   ✅   |
|                    | a3b         |   ✅   |
|                    | a6b         |   ❌   |
| /`[a-z0-9 ]+`/     | hello there |   ✅   |

### Negated character sets

- `[^ ]` = nagate the character class: match any one character **except** for the characters specified, including ranges:

| Regular expression | String | Match? |
| ------------------ | ------ | :----: |
| /`a[^123]b`/       | a2b    |   ❌   |
|                    | a4b    |   ✅   |
| /`[^a-z]+`/        | hello  |   ❌   |
|                    | HELLO  |   ✅   |

---

## Extract parts of strings using regular expression capture groups

### Regular expression matching in PHP

- `preg_match($reg_exp, $string)`
- `preg_match("/[a-z]+/", "abcd")` -> 1 (Match)
- `preg_match("/[a-z]+/", "1234")` -> 0 (No Match)

Array result of the Match

- `preg_match($reg_exp, $string, $matches)`
- `preg_match("/[a-z]+/", "abcd", $matches)`
- `$matches` -> `["abcd"]`

### Capture groups in regular expressions

- `()` = capture the regular expression inside the parentheses (the subpattern) to a **capture group**.
- `preg_match($reg_exp, $string, $matches)`

| \$reg_exp                      | \$string | \$matches                                     |
| ------------------------------ | -------- | :-------------------------------------------- |
| /`a[123]+b`/                   | a222b    | `[0 => "a222b" ]`                             |
|                                |          |                                               |
| /`a([123]+)b`/                 | a222b    | `[0 => "a222b", 1 => "222" ]`                 |
|                                |          |                                               |
| /`([a-zA-Z]+) (\d+)`/ Jan 1992 |          | `[ 0 => "Jan 1992", 1 => "Jan", 2 => "1992"]` |

### Named capture groups

- `(?<name>regex)` = give the capture group a **name**:

- `preg_match($reg_exp, $string, $matches)`

| \$reg_exp                                       | \$string | \$matches                                                                         |
| ----------------------------------------------- | -------- | :-------------------------------------------------------------------------------- |
| /`([a-zA-Z]+) (\d+)`/ Jan 1992                  |          | `[ 0 => "Jan 1992", 1 => "Jan", 2 => "1992"]`                                     |
|                                                 |          |                                                                                   |
| /`(?<month>)([a-zA-Z]+) (?<year>\d+)`/ Jan 1992 |          | `[ 0 => "Jan 1992", 1 => "Jan", 2 => "1992"], "month" => "Jan", "year" => "1992"` |

- `$string` = Jan 1992

---

## Get the controller and action from a URL with a fixed structure

### Matching routes with patterns

Instead of a simple **string comparison**:

- `if ($url == $route) { ...`

match to a **pattern**:

- `if (preg_match($reg_exp, $url)) { ...`

### Simple fixed URL structure

- `daveh.oi/controller/action`
- daveh.io/posts/index
- daveh.io/posts/new
- daveh.io/blog/index
- daveh.io/products/list

### A regular expression for a simple URL structure

- `daveh.io/controller/action`

- `/^([a-z-]+)\/([a-z-]+)$/`

Result 1:

```php
preg_match($reg_exp, "posts/index", $matches);

/*

[
  1 => "posts",
  2 => "index"
]

*/
```

- `/^(?P<controller>[a-z-]+)\/(?P<action>[a-z-]+)$/`

Result 2:

```php
preg_match($reg_exp, "posts/index", $matches);

/*

[
  "controller" => "posts",
  "action" => "index"
]

*/
```

Router.php

```php
    public function match($url)
    {
      // foreach ($this->routes as $route => $params) {
      //   if ($url == $route) {
      //     $this->params = $params;
      //     return true;
      //   }
      // }


      // Match to the fiexed URL format /controller/action
      $reg_exp = "/^(?P<controller>[a-z-]+)\/(?P<action>[a-z-]+)$/";

      if (preg_match($reg_exp, $url, $matches)) {
        // Get named capture group values
        $params = [];

        foreach ($matches as $key => $match) {
          if (is_string($key)) {
            $params[$key] = $match;
          }
        }

        $this->params = $params;
        return true;
      }

      return false;
    }
```

---

## Replace parts of strings using regular expressions

### Regular expression replacing in PHP

- `$result = preg_replace($reg_exp, $replacement, $string)`

- **Searches** `$string` for matches to `$reg_exp` and replaces them with `$replacement`.

```php
$reg_exp      $replacement      $string     result
/abc/         def               abc         => def
/\d+/         --                abc123def   => abc--def
/\s+/         ,                 a b   c   d => a,b,c,d
```

Backreferences to capture groups

- Refer to the text in a **capture group** using `\1`, `\2` and so on:

- `$result = preg_replace($reg_exp, $replacement, $string)`

```php
$reg_exp            $replacement      $string         result
/ab(c)/             \1de              abc             => cde
/(\w+) and (\w+)/   \1 or \2          Jack and Jill   Jack or Jill
```

---

## Get the controller and action from a URL with a variable structure

---

## Add custom variables of any format to the URL

---

<?php
declare(strict_types=1); // strict requirement

// ============================================
// SECTION 1: COMMENTS
// ============================================

# I am testing comments in PHP
// This is also a comment
/* This is a 
   multi-line comment */

# echo "Hello, world!<br>";
# echo "<br>";

# I don't need to close the PHP tag because I am not using any HTML after this, 
# and it's a good practice to keep the PHP tag open.


// ============================================
// SECTION 2: VARIABLES - BASICS
// ============================================

/* $my_first_variable = "Hello, world!";
echo $my_first_variable;
echo "<br>"; */

// Testing var_dump with different types
/* var_dump($my_first_variable);
echo "<br>";

var_dump(25);
echo "<br>";
var_dump(10.5);
echo "<br>";
var_dump(true);
echo "<br>";
var_dump(false);
echo "<br>";
var_dump(null);
echo "<br>"; */


// ============================================
// SECTION 3: VARIABLES - SCOPE (Global/Local)
// ============================================

# $x = 5;  // Global variable
# $y = 10; // Global variable

// Example: Using $GLOBALS array to modify global variables from function
/* function modify_globals() {
  $GLOBALS['y'] = $GLOBALS['x'] + $GLOBALS['y'];
} 

modify_globals();
echo "Y after function: " . $y . "<br>";  // outputs 15 */


// ============================================
// SECTION 4: VARIABLES - STATIC
// ============================================

/* function get_data() {
  static $data = null;
  
  if ($data === null) {
    echo "Loading data...<br>";
    $data = "Important data";
  }
  
  return $data;
} */

# echo get_data();  // "Loading data..." + "Important data" - first call: the program recognizes $data variable as null, because it was declared at the beginning of the function as null. Therefore, the if statement returns true and runs the script inside it. That is, it displays on the screen "Loading data, break row", and sets the $data variable as "Important data". At the end, it returns $data. Now, because it is static, it saves the previous value set to $data and keeps it, instead of deleting the memory of this variable.
# echo "<br>";
# echo get_data();  // just "Important data" (no loading!) - second call: $data = still 'Important data' because the program reads it as 'already initialized' and does not (re)declare it again. Since data isn't the same as null, the script in the if statement is skipped. $data is still returned at the end of the function.
# echo "<br>";
# echo get_data();  // just "Important data" (no loading!) - third call: same as above
# echo "<br><br>";


// Real-world example: Caching database queries
/* function get_membership_levels() {
  static $levels = null;
  
  if ($levels === null) {
    // Only query database ONCE
    global $wpdb;
    $levels = $wpdb->get_results("SELECT * FROM memberships");
  }
  
  return $levels;
} */

// Called 100 times in one page load
// Only queries database ONCE

# get_membership_levels(); // the variable is null, so the if statement runs the script inside it. Oh, nice, now we're using native wp variables, I remember seeing $wpdb in many codes and places. Let's see.... we can use this variable inside the function by setting the 'global' keyword before invoking it. Then, we'll set the $levels variable to one of the methods inside this other $wpdb variable. It is then returned at the end of the function, fetching the results for whoever is calling it, whatever/'wherever' they want

# get_membership_levels(); // simple. $levels is not null anymore, so the if statement doesn't run. The function still returns the variable, for which the user can manipulate it as conveniently

// ============================================
// SECTION 3: ECHO AND PRINT
// ============================================

/* $name = "oiler";

echo $name;

print '<h1>Hello $name</h1>'; // it will be considered as one single string and displays 'Hello $name', instead of 'Hello, oiler', since we need to separate variables when using single quotes
print "<h1> Hello" . $name . "</h1>"; // when using double quotes we don't need to concatenate texts and strings/variables. It is possible, but it is a waste of time and will produce weird results if you don't put <br> into each block */

# $result = print "Hello";  // Outputs "Hello", $result = 1

// Used in expression:
/* if (print "$name") {
  // This runs because print returns 1 (truthy)

  print "Ronaldo";
} /*

# $result = echo "test";  // ERROR - can't do this (Parse error: syntax error, unexpected token "echo")


/* Real talk: This is almost never used in practice. It's a weird PHP quirk.
99% of the time: Use echo - it's faster and clearer.
When to use print: Basically never, unless you have a very specific edge case. */

// ============================================
// SECTION 4: DATA TYPES
// ============================================

// Basic types
/* var_dump("Hello");
echo "<br>";
var_dump(42);
echo "<br>";
var_dump(3.14);
echo "<br>";
var_dump(12e12);
echo "<br>";
var_dump(true);
echo "<br>";
var_dump(null);
echo "<br><br>"; */

// Exponential notation = always float
/* var_dump(2.5e3);       // float(2500)
echo "<br>";
var_dump(1.8e-2);      // float(0.018)
echo "<br><br>"; */

// Casting - change data types
/* $x = 5;
var_dump((string) $x); // "5"
echo "<br>";
var_dump((float) $x);  // 5.0
echo "<br>";
var_dump((bool) $x);   // true
echo "<br><br>"; */

// Casting converts the type, not the notation. The value stays the same.
/* var_dump(12e12);
echo "<br>";
var_dump((int) 12e12);
echo "<br>"; */

// ============================================
// SECTION 5: STRINGS
// ============================================

/* Testing this exercise on w3schools, I have no f. idea what will be output:

What will be the result of $z in the following code example:
$x = 5;
$y = 10;
$z = $x . $y; */

/* $x = 5;
$y = 10;
$z = $x . $y;

echo $z; // 510. interesting...
echo "<br><br>";

// ============================================
// STRING EXAMPLES
// ============================================

// Slicing with substr()
$text = "Hello, world!";
echo "Original: $text<br>";
echo "substr(\$text, 5): " . substr($text, 5) . "<br>";  // ", world!"
echo "substr(\$text, -5): " . substr($text, -5) . "<br>";  // "orld!"
echo "substr(\$text, 7, 5): " . substr($text, 7, 5) . "<br><br>";  // "world"

// Explode - split string into array
$plugins = "MemberPress,Pretty Links,ThirstyAffiliates";
$list = explode(",", $plugins);
echo "Explode result and show the best plugins with the best support in WP:<br>";
print_r($list);
echo "<br><br>";

// Escape characters
echo "Quotes: \"Vikings\" from the north<br>";
echo "Path: C:\\Users\\Files<br>";
echo "Newline next:\nSee?<br>";
echo "<pre>Newline next:\nSee?</pre><br>";
echo "<pre>Tab:\there<br></pre><br>";

// nl2br() - converts \n to <br> for HTML
$multiline = "Line 1\nLine 2\nLine 3";
echo "Without nl2br(): $multiline<br>";
echo "With nl2br(): " . nl2br($multiline) . "<br><br>";

// Common string functions
$sample = "  Pretty Links  ";
echo "Original: '$sample'<br>";
echo "trim(): '" . trim($sample) . "'<br>";
echo "strlen(): " . strlen($sample) . "<br>";
echo "strtoupper(): " . strtoupper($sample) . "<br>";
echo "str_replace(): " . str_replace("Links", "URLs", $sample) . "<br>";
*/

// ============================================
// SECTION 6: NUMBERS
// ============================================

// Integers vs Floats
/* $int = 42;
$float = 3.14;
var_dump($int);    // int(42)
echo "<br>";
var_dump($float);  // float(3.14)
echo "<br><br>";

// Float operand rule - result becomes float if ANY operand is float
var_dump(4 * 2.5);  // float(10) - not int!
echo "<br>";
var_dump(4 * 2);    // int(8)
echo "<br><br>";

// Type checking functions
$x = 5985;
var_dump(is_int($x));       // bool(true)
echo "<br>";
var_dump(is_float($x));     // bool(false)
echo "<br>";
var_dump(is_numeric($x));   // bool(true)
echo "<br><br>";

// Number strings
$num_string = "123";
var_dump(is_numeric($num_string));  // bool(true)
echo "<br>";
$result = $num_string + 100;
var_dump($result);  // int(223) - PHP auto-converts!
echo "<br><br>";

// Integer limits - exceeding converts to float
$max_int = 9223372036854775807;  // PHP_INT_MAX
var_dump($max_int);              // int
echo "<br>";
$exceed = 9223372036854775808;   // One more
var_dump($exceed);               // float! (too big for int)
echo "<br><br>";

// Infinity - numbers too big
$inf = 1.9e411;
var_dump($inf);           // float(INF)
echo "<br>";
var_dump(is_infinite($inf));  // bool(true)
echo "<br><br>";

// NaN - invalid math operations
$nan = acos(8);  // Invalid: acos only works for -1 to 1
var_dump($nan);  // float(NAN)
echo "<br>";
var_dump(is_nan($nan));  // bool(true)
echo "<br>"; */

// ============================================
// SECTION 7: CASTING
// ============================================

// Cast to string
/* $a = 5;
$b = 5.34;
$c = true;
var_dump((string) $a);  // "5"
echo "<br>";
var_dump((string) $b);  // "5.34"
echo "<br>";
var_dump((string) $c);  // "1"
echo "<br><br>";

// Cast to int - PHP tries to extract numbers
var_dump((int) "25 plugins");  // 25 (starts with number)
echo "<br>";
var_dump((int) "plugins 25");  // 0 (starts with text)
echo "<br>";
var_dump((int) true);          // 1
echo "<br>";
var_dump((int) NULL);          // 0
echo "<br><br>";

// Cast to float
var_dump((float) "25.9 hours");  // 25.9
echo "<br>";
var_dump((float) "42");         // 42.0
echo "<br><br>";

// Cast to bool - 0, "", false, NULL = false, everything else = true
var_dump((bool) 0);      // false
echo "<br>";
var_dump((bool) "");     // false
echo "<br>";
var_dump((bool) -1);     // true (even negative!)
echo "<br>";
var_dump((bool) "hello"); // true
echo "<br><br>";

// Cast to array
$x = 42;
$arr = (array) $x;
var_dump($arr);  // [0 => 42]
echo "<br><br>";

// Cast array to object
$tools = ["MemberPress", "Pretty Links", "ThirstyAffiliates"];
$obj = (object) $tools;
var_dump($obj);
echo "<br><br>";

// What if we try to cast other data types to object?
$obj_test = 42;
$newobjtest = (object) $obj_test;
var_dump($newobjtest);
echo "<br><br>";

// Cast associative array to object
$assoc = ["name" => "MemberPress", "active" => true];
$obj2 = (object) $assoc;
var_dump($obj2);
echo "<br><br>";

// Note: (unset) cast was removed in PHP 7.2+
// To set to NULL, just assign: $x = null; */


// ============================================
// SECTION 8: MATH
// ============================================

/* // pi() - mathematical constant
echo "pi(): " . pi() . "<br><br>";
echo (pi());
echo "<br><br>";

// min() and max() - find smallest/largest
echo "min(0, 150, 30, 20, -8, -200): " . min(0, 150, 30, 20, -8, -200) . "<br>";
echo "max(0, 150, 30, 20, -8, -200): " . max(0, 150, 30, 20, -8, -200) . "<br><br>";

// abs() - absolute value (removes negative sign)
echo "abs(-6.7): " . abs(-6.7) . "<br>";
echo "abs(42): " . abs(42) . "<br><br>";

// sqrt() - square root
echo "sqrt(64): " . sqrt(64) . "<br>";
echo "sqrt(25): " . sqrt(25) . "<br><br>";

// round() - rounds to nearest integer
echo "round(0.60): " . round(0.60) . "<br>";
echo "round(0.49): " . round(0.49) . "<br>";
echo "round(3.7): " . round(3.7) . "<br><br>";

// rand() - random number generation
echo "rand(): " . rand() . "<br>";
echo "rand(10, 100): " . rand(10, 100) . "<br>"; */


// ============================================
// SECTION 9: CONSTANTS
// ============================================

// Using define() - can be used anywhere
/* define("PLUGIN_NAME", "Pretty Links");
echo PLUGIN_NAME . "<br>";

// Using const - must be top-level
const COMPANY = "CaseProof";
echo COMPANY . "<br><br>";

// Constant arrays (PHP 7+)
define("PRODUCTS", [
  "MemberPress",
  "Pretty Links",
  "ThirstyAffiliates"
]);
echo PRODUCTS[0] . "<br><br>";

// Constants are global - accessible in functions
define("SUPPORT_EMAIL", "support@caseproof.com");
function getSupportContact() {
  echo SUPPORT_EMAIL;
}
getSupportContact();
echo "<br><br>";

// Built-in PHP constants
echo "PHP_VERSION: " . PHP_VERSION . "<br>";
echo "PHP_INT_MAX: " . PHP_INT_MAX . "<br><br>";

// ============================================
// MAGIC CONSTANTS
// ============================================

// __LINE__ - current line number
echo "Current line: " . __LINE__ . "<br>";

// __FILE__ - full path and filename
echo "File: " . __FILE__ . "<br>";

// __DIR__ - directory of current file
echo "Directory: " . __DIR__ . "<br><br>";

// __FUNCTION__ - function name
function myFunction() {
  echo "Function: " . __FUNCTION__ . "<br>";
}
myFunction();

// __CLASS__ and __METHOD__ - class context
class MemberPressTools {
  public function versionCheck() {
    echo "Class: " . __CLASS__ . "<br>";
    echo "Method: " . __METHOD__ . "<br>";
  }
}

$tools = new MemberPressTools();
$tools->versionCheck();
echo "<br>";

// ClassName::class - full class name
echo "Full class name: " .MemberPressTools::class. "<br>";

*/

// ============================================
// SECTION 10: OPERATORS
// ============================================

// Arithmetic: +, -, /, %, **
/* echo "2 + 3 = " . (2 + 3) . "<br>";
echo "2 ** 3 = " . (2 ** 3) . "<br><br>";

// Assignment: +=, -=, *=
$total = 100;
$total += 20;  // $total = $total + 20
echo "Initial value \$total = 100. After \$total += 20: $total<br><br>";

// Comparison: ==, ===, <, >=, <=>
var_dump(10 === 10);  // true
echo "<br>";
echo "Spaceship (10 <=> 15): " . (10 <=> 15) . "<br><br>";  // -1

// Increment/Decrement: ++, --
$counter = 5;
echo "Pre-increment: " . (++$counter) . "<br>";  // 6
echo "Post-increment: " . ($counter++) . "<br><br>";  // 6, then becomes 7

// Logical: &&, ||, !
var_dump(true && false);  // false
echo "<br>";
var_dump(true || false);  // true
echo "<br><br>";

// String: ., .=
$name = "MemberPress";
$message = "Welcome to " . $name;
$message .= " support!";
echo $message . "<br><br>";

// Array: + (union)
$a = ["plugin" => "Pretty Links"];
$b = ["version" => "4.0.0"];
var_dump($a + $b);
echo "<br><br>";

// Conditional: ternary (?:), null coalescing (??)
$plan = "Pro";
$msg = ($plan === "Pro") ? "Pro user!" : "Upgrade";
echo $msg . "<br>";
$username = $_GET['user'] ?? 'Guest';
echo "Username: $username<br>";
*/


// Exercise 1: done
// Exercise 2: debug a support ticket

/* $membership_price = "99.99";
$discount = 10;
$final_price = $membership_price - $discount;
echo "Final price: " . $final_price; */

// Ok, even though it has set the first variable as a string while it should be a number, PHP automatically detects it in the $final_price operation and convert the result to a number. We'd probably need to fix $membership_price but I don't see big issues here... Am I wrong?

/* Exercise 3: Write a helper function
Create a function that:
Takes a membership level name (string)
Checks if it's empty
Returns "No level" if empty, otherwise returns "Level: [name]"
Uses a ternary operator */

/* function myfirstfunctionfromscratch($level) {
return empty($level)? "No level" : "Level: $level";

}

 echo myfirstfunctionfromscratch("Premium");
echo "<br>";
echo myfirstfunctionfromscratch("");

# OR:

$message1 = myfirstfunctionfromscratch("Premium");
echo $message1;

echo "<br>";

$message2 = myfirstfunctionfromscratch('');
echo $message2; */

// ============================================
// SECTION 11: CONDITIONALS (if/else/elseif)
// ============================================

// Simple if statement
/* $is_active = true;
if ($is_active) {
  echo "User has an active subscription.<br>";
}

// if...else
$clicks = 75;
if ($clicks > 50) {
  echo "URL performing well!<br>";
} else {
  echo "Needs more promotion.<br>";
}

// if...elseif...else
$status = 'paused';
if ($status == 'active') {
  echo "User can access content.<br>";
} elseif ($status == 'paused') {
  echo "User needs to renew soon.<br>";
} else {
  echo "User has no access.<br>";
}

// Logical operators (&&, ||)
$user_role = 'admin';
$has_license = true;
if ($user_role == 'admin' && $has_license) {
  echo "Access granted.<br>";
}

// Ternary operator (shorthand)
$clicks = 100;
$msg = ($clicks > 50) ? "Nice traffic!" : "Needs promotion.";
echo $msg . "<br>";

// Nested ifs
$member = true;
if ($member) {
  echo "User found.";
  $is_active = true;
  if ($is_active) {
    echo " Subscription is active.<br>";
  } else {
    echo " Subscription is inactive.<br>";
  }
}
*/


// ============================================
// SECTION 12: SWITCH
// ============================================

/* Syntax
switch (expression) {
  case label1:
    //code block
    break;
  case label2:
    //code block;
    break;
  case label3:
    //code block
    break;
  default:
    //code block
} */

# Example 1: Create a variable that holds the current hour. Use it as the expression for the switch parameter, then add three possible cases: 'good morning', 'good afternoon' or 'good night'

# echo date_default_timezone_get(); - outputs the server timezone
/* date_default_timezone_set('America/Sao_Paulo'); # let's first set the timezone to be the same as mine
$hours = date('H'); # it holds current hour (00-24 format) */
# echo $current_hours;

/* switch ($hours) { // but you could (perhaps should) use switch (true), since we are always comparing boolean values here
  
  case ($hours >= 0 and  $hours < 5):
    echo "Boa madruga fi";
    break;

  case ($hours >= 5 and $hours < 12):
    echo "Bom dia fi!";
    break;

  case ($hours >= 12 and $hours < 18):
    echo "Boa tarde meu fi";
    break;

  case ($hours >= 18 and $hours < 24):
    echo "Boa noite zé";
    break;

  # default is optional, we don't need to set it if we don't... need it, at all [?]
} */

// Example 2 - More than one case for each code block:

/*$d = -6;

# but let's convert it to 6 and display case 6
$d = abs($d);

switch ($d) {
  case 1:
  case 2:
  case 3:
  case 4:
  case 5:  
    echo "The weeks feels so long!";
    break;
  case 6:
  case 0:
    echo "Weekends are the best!";
    break;
  default:
    echo "Something is wrong and weird here";
} */


// Example 3: switch($variable) — when you want to match fixed values
/* $status = 'draft';

 switch ($status) {
  case 'draft':
    echo "This post is still being written.";
    break;
  case 'pending':
    echo "Waiting for review.";
    break;
  case 'published':
    echo "The post is live!";
    break;
  default:
    echo "Unknown post status.";
} */

// Example 4: switch(true) — when you want to evaluate conditions

/*
switch (true) {
  case is_admin():
    echo "You’re in the dashboard!";
    break;
  case is_page('pricing'):
    echo "Welcome to the pricing page.";
    break;
  case is_user_logged_in():
    echo "Hi there, member!";
    break;
  default:
    echo "Hello, visitor!";
} */

// ============================================
// SECTION 13: STAY IN THE LOOP MF!!!!!!!!!!!!!
// ============================================

# 13.1 WHILE

// Exercise 1 — Count from 1 to 5. Print the numbers 1 through 5, one per line. This is the most classic while-loop pattern: initialize → check condition → increment.


/* $x = 1;

while ($x < 6) {

  echo $x;
  $x++;
  
} */

// Exercise 2 — Count down from 10 to 1. Start at 10 and count backwards to 1.

/* $x = 10;

while ($x > 0) {

  echo $x;
  $x--;
} */



// Exercise 3 — Skip a specific number. Count from 1 to 10, but skip the number 4 using continue.

/* $i = 0;
while ($i < 6) {
  $i++;
  if ($i == 3) continue;  
  echo $i;
} */

// Exercise 4 and 5 - also practice break; and endwhile;

// which is the best number? Break on before it

/* $e = 0;

while ($e <= 12) {
  if ($e == 12) {
    echo $e;
    echo "<< ¡that's the BEST NUMBER EVER!. 13 sucks";    
    break;
  }
  echo $e;
  $e++;
}

*/

// try to use endwhile somehow....

/*$l = 10;
while ($l <= 100) : echo $l; $l+=10;

  endwhile; */

  # Exercise A — Fix the infinite loop. This code is broken. Fix it:
  
  /*  $a = 1;

    while ($a < 20) {
      if ($a == 10) : $a++; continue; endif;
      echo $a;
      $a++;
    } */



  # Exercise B — Use endwhile to loop backwards. Count from 50 down to 5, stepping by 5, using: while, endwhile and no for

/*    $uai = 50;
    while ($uai >= 5) :
      echo $uai;
      $uai = $uai - 5;

    endwhile;
*/

  # 13.2 DO... WHILE


  # Exercise 1 — Count up at least once. Write a do…while loop that: starts $x at 10, prints $x, increments $x and stops when $x is greater than 12. Even though the condition fails after a few steps, the code must run at least once.

  /*  $e = 10;

    do {
      echo $e;
      $e++;
    }
    while ($e <= 12); */



  # Exercise 2 — Retry until success. Simulate a "retry an API call" loop: Create $success = false, inside the loop, randomly set $success to true (hint: rand(1, 5) == 3). Print “Trying…”. Stop once $success becomes true. It MUST run once even if it succeeds immediately.

/*    $success = false;

    do {
      print "Trying...";
      $number = rand(0, 12);
      if ($number == 12) {
        $success = true;
      }
    }
    while ($success == false); */


# Exercise 3 — Skip a specific number. Use continue inside a do…while: Count from 1 to 7, but skip printing number 4. Still continue the loop normally. MUST increment before continue.

/* $e = 0;
do {
  echo $e;
  if ($e == 4) {
    $e++;
    continue;
    
  }
  $e++;
} while ($e <= 7); */

// SMALL BREAK FOR print_r x var_dump section

/* $data = array(
    'name' => 'John Doe',
    'age' => 30,
    'hobbies' => array('reading', 'hiking', 'coding')
);

echo "<h1>var_dump()</h1>";
echo "<pre>"; // Optional: for better formatting in a browser
var_dump($data);
echo "</pre>";


echo "<h1>print_r()</h1>";
echo "<pre>"; // Optional: for better formatting in a browser
print_r($data);
echo "</pre>";

$output_string = print_r($data, true);
echo "The output as a string: " . $output_string;
?> */

  # 13.3 FOR

  # Exercise 1 — Count Only Even Numbers. Print all even numbers between 2 and 20 using a for loop. Requirements: Use a for, only print even numbers and no if allowed inside the loop


 /* for ($e = 2; $e <= 20; $e+=2) {
    echo "$e <br>";
  } */

  # Exercise 2 — Stop at the First “Forbidden” Number. Simulate scanning link IDs from 1 to 15, but stop completely if you hit ID 9.
  
  /* Output example idea:
  Checking ID: 1
  Checking ID: 2
  ...
  Checking ID: 9 ← loop stops here
  
  Requirements:
  
  Use for
  
  Use break
  
  Print each step */

  /* for ($e = 1; $e <= 15; $e++) {

    if ($e > 9) {
      break;
    }
    echo "Checking ID: $e <br>";
    
  } */

  # Exercise 3 — Skip One, Process the Rest. Loop from 1 to 12, but skip number 7 and do NOT print it. Everything else should print normally.

  /* for ($e = 1; $e <= 12; $e++) {

    if ($e == 7) {
      continue;
    }
    print $e;
  } */

  # 13.4 FOR EACH

  // Exercise 1 — Sum Values of an Array. Given an array of numbers, loop through it with foreach and echo the total sum. Array: $nums = [10, 20, 5, 3, 2];

  /* $nums = [10, 20, 5, 3, 2];
  $e = 0;

  foreach ($nums as $x) {
    
    $e++;
  }

  echo $e; */

 // Exercise 2 — Skip One Value. Loop through: $colors = ["red", "green", "blue", "yellow"]; But do not print “blue”. Use continue.

 /* $colors = ["red", "green", "blue", "yellow"];

 foreach ($colors as $x) {
  if ($x == 'blue') {
    continue;
  }
  echo "$x <br>";
 } */

// Exercise 3 — Change One Value By Reference. Given: $statuses = ["active", "expired", "trial", "active"]; Change “trial” to “pending” using foreach by reference, then print the modified array.


/* $statuses = ["active", "expired", "trial", "active"];




// without byref
foreach ($statuses as $x) {
  if ($x == "trial") {
    $x = 'pending';
  }
}


var_dump($statuses);

echo "<br>";

// byref
foreach ($statuses as &$x) {
  if ($x == "trial") {
    $x = 'pending';
  }
}

var_dump($statuses);
# unset($x); - use unset() to break the reference from the previous byref foreach */

/* Exercise 1 — Find the First Active Membership

You have:

$memberships = [
  ['id' => 1, 'status' => 'expired'],
  ['id' => 2, 'status' => 'pending'],
  ['id' => 3, 'status' => 'active'],
  ['id' => 4, 'status' => 'active'],
];


Task:
Loop through and print only the ID of the first active membership, then stop immediately using break.

(If you’re doing it right, you should never even touch ID 4.) */

/* $memberships = [
  ['id' => 1, 'status' => 'expired'],
  ['id' => 2, 'status' => 'pending'],
  ['id' => 3, 'status' => 'active'],
  ['id' => 4, 'status' => 'active'],
];


foreach ($memberships as $item) {
  
  echo "Membership ID: {$item['id']}, Membership Status: {$item['status']} <br>";
  if ($item['status'] == 'active') {
    break;
  }
} */



/* curiosity: the following won't work because PHP doesn't know how to echo an array directly

foreach ($memberships as $x => $y) {
  echo "$x : $y";
} 


another example:
$test_array = array('1', '2', '3', '4');
echo $test_array;



To make this work:

// Option 1: Use print_r() inside the loop (quick debugging style)
/*foreach ($memberships as $x => $y) {
  echo "$x : ";
  print_r($y);
  echo "<br>";
}*/

// Option 2: Echo individual values (cleaner for real output)

/* foreach ($memberships as $item) {
   echo "ID: {$item['id']} - Status {$item['status']} <br>";
}
*/


/* Exercise 2 — Skip Non-Pretty Links

Given:

$links = ["google.com", "/go/course", "https://github.com", "/go/deals"];


Think of /go/... as Pretty Links.

Task:
Loop through the array and print only the Pretty Links.
Use continue to skip anything that does not start with /go/. */
 
/* $links = ["google.com", "/go/course", "https://github.com", "/go/deals"];

foreach ($links as $e) {
  if (substr($e, 0, 4) != '/go/') {
    continue;
  }  */
  /*or
  if (substr($e, 0, 4) != '/go/') {
    continue;
  }
  }
  echo $e;
} */


// ============================================
// SECTION 14: FUNCTIONS
// ============================================

# Exercise 1 - first ultra-simple exercise:
/* Create a function called sayHello() that returns the string "Hello, Euler!"
—not echo, RETURNS.
Then call the function and echo the result.
So your final output on the page should show:
Hello, Euler!

Try to write it now (and feel free to add your Canadian accent version if you want — “Hello, Euler, eh?”). */

/* function sayHelloTo ($name) {
  $e = "Hello $name, eh?";
  return $e;
}

echo sayHelloTo("Euler"); */

# Exercise 2 - default parameter values

/* 

Write a function called calcDiscount() that:

accepts one parameter: $amount
accepts one optional parameter: $rate (default 0.10 → 10% discount)
returns the discounted price

*/

/* function calcDiscount ($amount, $rate = 0.10) {
  $discountedPrice = $amount - ($amount * $rate);
  return $discountedPrice;
}

echo calcDiscount(100) . "<br>";
echo calcDiscount(100, 0.6); */

# Exercise 3 - parameter type hints

/* 

Create a function where:

name: square
accepts one integer
returns an integer (use : int after the function)
just returns the number squared

Then call it twice:

With 4 → should print 16
With "5" → should throw a TypeError because of strict types (that’s the point)

*/

/* function square(int $x) : int {
  $e = $x ** 2;
  return $e;
}

echo square(4);
echo square("5"); */

# Exercise 4 - pass-by-reference (&)

/*

Make a function called applyCoupon(). It receives a price by reference. It subtracts 20 from it. It returns nothing (just modifies the original)

Then echo the price outside to confirm the change

*/

/* function applyCoupon (&$price) {
  $price = $price - 20;
  return;
} 


$price = 32;
applyCoupon ($price);

echo $price;
*/

# Exercise 5 - strict types + multiple arguments + a clean return type

/*

Create a function called calcTotal() that:

expects two floats (price and tax)
returns a float
strict_types must be turned on
inside, calculate: total = price + (price * tax)
return that total

Call the function twice and echo the results

*/


/* function calcTotal(float $price, float $tax) : float {

  $total = $price + ($price * $tax);
  return $total;

}

echo calcTotal(10, 0.10);
echo "<br>";
echo calcTotal(120.12, 0.3);
*/

# Exercise 6 - variadic functions, but in the chill “Euler pace”, nothing dramatic


/*

Create a function called addAll() that:

accepts any number of numbers using ...$nums
sums all of them
returns the total

*/

/* function addAll(...$nums) {

  $e = 0;
  
  foreach ($nums as $x) {
    $e = $e + $x;
  }

  return $e;
}

echo addAll(1, 2, 3);
echo "<br>";
echo addAll(12, 100, 8);
*/

# Exercise 7 - mixed parameters + variadic


/*

Create a function called greetGroup() that takes:

a normal first argument: $greeting (like "Hello" or "Hey"),
then a variadic list: ...$names

Inside the function, build and return one single string that includes the greeting for each name.

*/

/* function greetGroup($greeting, ...$names) {

  $single_message = '';

  foreach ($names as $x) {
    $single_message = "$single_message $greeting, $x! ";
  }

  return $single_message;
}

echo greetGroup("Hello", "Euler", "Letícia", "Luma"); */


# Exercise 8 - FINAL substantial exercise

/* 

Create processMembers() with strict_types.

Parameters:
- int $minYear (default 2020)
- bool $addEligibleFlag (default false)  
- array &...$members (variadic, by reference)

Return: array

Filter members where status = 'active' AND joined >= $minYear.
If $addEligibleFlag is true, add 'eligible' => true to matched members (modifies originals).
Return array of filtered members.

Test data:
$member1 = ['name' => 'Alice', 'status' => 'active', 'joined' => 2021];
$member2 = ['name' => 'Bob', 'status' => 'inactive', 'joined' => 2022];
$member3 = ['name' => 'Carol', 'status' => 'active', 'joined' => 2019];
$member4 = ['name' => 'Dave', 'status' => 'active', 'joined' => 2023];


*/


/* $m1 = ['name' => 'Alice', 'status' => 'active', 'joined' => 2021];
$m2 = ['name' => 'Bob', 'status' => 'inactive', 'joined' => 2022];
$m3 = ['name' => 'Carol', 'status' => 'active', 'joined' => 2019];
$m4 = ['name' => 'Dave', 'status' => 'active', 'joined' => 2023];

function processMembers(int $minYear = 2020, bool $addEligibleFlag = false, &...$members) : array {

  $results = [];

  foreach ($members as &$member) {
    if ($member['status'] == 'active' && $member['joined'] >= $minYear) {
      if ($addEligibleFlag === true) {

        $member['eligible'] = true;        

      }
    $results[] = $member;
    }
  }

  return $results;

}

$test = processMembers(2020, false, $m1, $m2, $m3, $m4);

echo "<pre>";
print_r($test); 
echo "</pre>";
*/

// ============================================
// SECTION 15: ARRAYS
// ============================================

// intro

# Exercise 1 - arrays meet loops, a love story

/*
Create an array called $memberships with these statuses as strings:
"active", "expired", "active", "cancelled", "active", "pending"

Then:
1. Use count() to echo the total number of memberships
2. Create a variable $activeCount and manually count how many are "active" 
   using a foreach loop (check each one with an if statement)
3. Echo the active count
*/


/* $memberships = array("active", "expired", "active", "cancelled", "active", "pending");

#1

echo count($memberships);
echo "<br>";

#2

$activeCount = 0;

foreach ($memberships as $x) {
  if ($x == 'active') {
    $activeCount++ ;
  }

}

#3

echo $activeCount; */


# Exercise 2 - the gap filler

/*
Create an indexed array with these specific indexes and values:
$plugins[2] = "MemberPress"
$plugins[5] = "Pretty Links"  
$plugins[9] = "Affiliate Royale"

Then:
1. Echo the value at index 5
2. Use array_push() to add "Easy Affiliate" to the array
3. Use var_dump() to see the entire array and find what index "Easy Affiliate" got
4. Manually add a new plugin at index 15: "Popup Domination"
5. Use count() to see how many items are in the array (spoiler: it's NOT 16)
*/

/* $plugins[2] = "MemberPress";
$plugins[5] = "Pretty Links";  
$plugins[9] = "Affiliate Royale";

#1

echo $plugins[5];
echo "<br>";

#2

array_push($plugins, "Easy Affiliate");

#3

var_dump($plugins);
echo "<br>";

#4

$plugins[15] = "Popup Domination";

#5

echo count($plugins);
echo "<br>";
print_r($plugins); */

# Exercise 3 - the membership profile (welcome to real WordPress data)

/*
Create an associative array called $member with these keys and values:
'user_id' => 4729
'email' => 'euler@caseproof.com'
'status' => 'active'
'plan' => 'Pro Annual'
'expires' => '2025-12-31'

Then:
1. Echo just the email
2. Change the status to 'expired'
3. Add a new key 'last_login' with value '2024-11-28'
4. Loop through the entire array and display each key-value pair like:
   "user_id: 4729"
   "email: euler@caseproof.com"
   etc.
*/

/* $membership_profile = array("user_id" => 4729, "email" => "euler@caseproof.com", "status" => "active", "plan" => "Pro Annual", "expires" => "2024-11-28");

#1

echo $membership_profile["email"];
echo "<br>";
#2

$membership_profile["status"] = 'expired';

// print_r($membership_profile);

#3

$membership_profile["last_login"] = "2024-11-28";

// print_r($membership_profile);

#4

foreach ($membership_profile as $x => $y) {
  echo "$x : $y"; 
  echo "<br>";
} */

# Exercise 4 - mini dashboard

/*
Create three different arrays to simulate MemberPress dashboard data:

1. Indexed array called $recent_actions with these values:
   "login", "viewed account page", "updated profile"

2. Associative array called $mepr_settings with:
   "currency" => "USD"
   "taxes_enabled" => true
   "default_plan" => "Basic Monthly"

3. Start with an empty array called $debug_log, then manually add:
   index 0: "no errors"
   index 1: "all good here"  
   index 2: "still running"

Finally, display all three arrays cleanly using:
echo "<pre>";
print_r($recent_actions);
print_r($mepr_settings);
print_r($debug_log);
echo "</pre>";
*/

/* $recent_actions = ["login", "viewed account page", "updated profile"];

$mepr_settings = ["currency" => "usd", "taxes_enabled" => true, "default_plan" => "Basic Monthly"];

$debug_log = [];

$debug_log[0] = "no errors";
$debug_log[1] = "all good here";
$debug_log[2] = "still running";

echo "<pre>";
print_r($recent_actions);
print_r($mepr_settings);
print_r($debug_log);
echo "</pre>";
*/

# Exercise 5 - data extractor

/*
Create an associative array called $transaction with:
"id" => "txn_47291"
"amount" => 99.00
"status" => "completed"
"user_id" => 4729
"date" => "2024-11-28"

Then:
1. Echo only the transaction status
2. Echo only the amount
3. Change the syntax: access the user_id using single quotes instead of double quotes
4. Create an indexed array called $logs with three strings:
   "Payment processed", "Email sent", "Database updated"
5. Echo the second log entry (remember: counting starts at 0)
6. Loop through $transaction and display each key-value pair formatted as:
   "id: txn_47291"
   "amount: 99"
   etc.
*/

/* $transaction = [
  "id" => "txn_47291",
  "amount" => 99.00,
  "status" => "completed",
  "user_id" => 4729,
  "date" => "2024-11-28"

];

#1

echo $transaction["status"];
echo "<br>";

#2

echo $transaction["amount"];
echo "<br>";

#3

$e = $transaction['user_id'];
echo $e;
echo "<br>";

#4

$logs = ["Payment processed", "Email sent", "Database updated"];

#5

echo $logs[1];
echo "<br>";

#6

foreach ($transaction as $x => $y) {
  echo "$x : $y";
  echo "<br>";
} */


# Exercise 6 - unset disaster

/*
Create an array: $statuses = ["active", "pending", "cancelled"]

1. Change "pending" to "expired" (without a loop)
2. Use a foreach loop with & to convert all items to uppercase
3. DON'T use unset($x) after the loop (we're breaking it on purpose)
4. After the loop, do: $x = "CORRUPTED"
5. Use print_r() in <pre> tags to see how the last item got destroyed

This shows why unset() matters after reference loops.
*/

/* $status = ["active", "pending", "cancelled"];

#1

$status[1] = "expired";

#2

foreach ($status as &$x) {
  $x = strtoupper($x);
}

#3 don't use unset($x) to see how things behave. Use it afterwards

#4

 $x = "CORRUPTED";

#5

 echo "<pre>";
print_r($status);
echo "</pre>";
echo "<br>";

#6 using unset:

unset($x);
print_r($status);

$x = "CORRUPTED";

echo "<br>";
var_dump($status); */

# Exercise 7 - affiliate link hoarder

/* 
You are building a system for Pretty Links that stores recently created affiliate links.

1. Create an indexed array called $links with three items:
   "amazon", "shopify", "udemy"

2. Add one more item using []:
   "clickbank"

3. Add THREE more items at once using array_push():
   "walmart", "ebay", "aliexpress"

4. Create an associative array called $meta with:
   "count" => 4
   "type"  => "affiliate"

5. Add TWO more key/value items using += :
   "generated_by" => "EulerBot9000"
   "version"      => 1.0

6. Print BOTH arrays using print_r() wrapped in <pre> tags.
*/

/* 
#1

$links = ["amazon", "shopify", "udemy"];

#2

$links[] = "clickbank";

// print_r($links);

#3

array_push($links, "walmart", "ebay", "aliexpress");

#4

$meta = ["count" => 4,"type" => "affiliate"];

#5

$meta += ["generated_by" => "EulerBot9000", "version" => 1.0];

#6

echo "<pre>";

print_r($links);
echo "<br>";
print_r($meta);

echo "</pre>"; */

# Exercise 8.0 - ticket cleanup

/*
Create: $tickets = ["bug-report", "feature-request", "billing-issue", "refund-request", "login-problem"]

1. Remove index 1 with unset()
2. Remove first item with array_shift()
3. Remove last item with array_pop()
4. Print final array in <pre> tags
*/

/* $tickets = ["bug-report", "feature-request", "billing-issue", "refund-request", "login-problem"];


#1

unset($tickets [1]);

#2

array_shift($tickets);

#3

array_pop($tickets);

#4

echo "<pre>";
print_r($tickets);
echo "</pre>";

*/

# Exercise 8.1 - splice and multi-unset (position-based removal)

/*
Create: $members = ["Alice", "Bob", "Carol", "Dave", "Eve", "Frank"]

1. Use array_splice() to remove 2 items starting at index 2
2. Print the array to see it got reindexed (no gaps)
3. Use unset() to remove indexes 0 and 2 in one line
4. Print the array again to see the gaps this time
5. Use print_r() in <pre> tags for both outputs
*/

/* $members = ["Alice", "Bob", "Carol", "Dave", "Eve", "Frank"];

#1

array_splice($members, 2, 2);

#2

echo "<pre>";
print_r($members);
echo "</pre>";
echo "<br>";

#3

unset($members[0], $members[2]);

#4

echo "<pre>";
print_r($members);
echo "</pre>";
echo "<br>"; */

# Exercise 8.2 - value filtering and associative cleanup (content-based removal)

/*
Create: $statuses = ["active", "expired", "active", "cancelled", "pending", "active"]

1. Use array_diff() to remove all "active" and "expired" values
2. Print the result in <pre> tags (notice the original indexes remain)

Create: $user = ["name" => "Euler", "email" => "euler@test.com", "role" => "admin", "temp_token" => "xyz123"]

3. Use unset() to remove the "temp_token" key
4. Print the $user array in <pre> tags
*/

/* $statuses = ['active', 'expired', 'active', 'cancelled', 'pending', 'active'];

#1

$new_statuses = array_diff($statuses, ['active', 'expired']);

#2

echo "<pre>";
print_r($new_statuses);
echo "</pre>";
echo "<br>";

$user = [
  'name' => 'Euler',
  'email' => 'euler@test.com',
  'role' => 'admin',
  'temp_token' => 'xyz123'
];

unset($user['temp_token']);

echo "<pre>";
print_r($user);
echo "</pre>";
echo "<br>";

// now let's see what happens when we use array_splice() to remove items from associative arrays

array_splice($user, 1, 1);

print_r($user);

// nothing special, apparently */

# Exercise 9 - sorting challenge

/*
Create two arrays:

$prices = [99, 49, 199, 29, 149]
$members = ["alice" => 3, "euler" => 15, "bob" => 7, "carol" => 1]

Tasks:
1. Sort $prices ascending with sort() and print it
2. Sort $prices descending with rsort() and print it
3. Sort $members by value (signup count) ascending with asort() and print
4. Sort $members by value descending with arsort() and print
5. Sort $members by key (name) ascending with ksort() and print
6. Sort $members by key descending with krsort() and print

Use print_r() in <pre> tags for all outputs.
Notice how associative sorts preserve key-value pairs.
*/

/* $prices = [99, 49, 199, 29, 149];

$members = [
  'alice' => 3,
  'euler' => 15,
  'bob' => 7,
  'carol' => 1,

];

#1

sort($prices);

echo "<pre>";
print_r($prices);
echo "</pre>";
echo "<br>";

#2

rsort($prices);

echo "<pre>";
print_r($prices);
echo "</pre>";
echo "<br>";

#3

asort($members);

echo "<pre>";
print_r($members);
echo "</pre>";
echo "<br>";

#4

arsort ($members);

echo "<pre>";
print_r($members);
echo "</pre>";
echo "<br>";

#5

ksort($members);
/
echo "<pre>";
print_r($members);
echo "</pre>";
echo "<br>";

#6

krsort($members);

echo "<pre>";
print_r($members);
echo "</pre>";
echo "<br>";
*/

# Exercise 10 - nested member data (real WordPress structure)

/*
Create a multidimensional associative array called $subscriptions:

$subscriptions = [
  ['user' => 'Alice', 'plan' => 'Pro', 'price' => 99, 'status' => 'active'],
  ['user' => 'Bob', 'plan' => 'Basic', 'price' => 29, 'status' => 'expired'],
  ['user' => 'Carol', 'plan' => 'Pro', 'price' => 99, 'status' => 'active']
];

Tasks:
1. Echo Bob's plan (access second array, 'plan' key)
2. Change Carol's status to 'cancelled'
3. Loop through all subscriptions with foreach and display:
   "Alice is on Pro plan - active"
   "Bob is on Basic plan - expired"
   etc.
4. Use a nested foreach to calculate total revenue from 'active' subscriptions only
*/
/*
$subscriptions = [

  ['user' => 'Alice',
   'plan' => 'Pro',
   'price' => 99,
   'status' => 'active',
  ],

  ['user' => 'Bob',
   'plan' => 'Basic',
   'price' => 29,
   'status' => 'expired',
  ],

  ['user' => 'Carol',
   'plan' => 'Pro',
   'price' => 99,
   'status' => 'active',
],

];
*/

#1
/*
echo $subscriptions[1]['plan'];
echo "<br>";

#2

$subscriptions[2]['status'] = 'cancelled';*/

#3

/* foreach ($subscriptions as $subscription){

  echo $subscription['user'] . " is on " . $subscription['plan'] . " plan - " . $subscription['status'];
  echo "<br>";

}; */

#4

/* $total_revenue = 0;

foreach ($subscriptions as $subscription) {

  foreach ($subscription as $key => $value){
    if ($value == 'active'){
      $total_revenue = $total_revenue + $subscription['price'];
    }
  }

  
}

echo $total_revenue; */


# Exercise 11 - filtering active memberships

/*
You're helping a customer debug their member list. They want to show only 
active memberships on the account dashboard.

Create an array called $memberships with this data:

$memberships = [
    ['id' => 1, 'name' => 'Basic Plan', 'status' => 'active', 'price' => 29],
    ['id' => 2, 'name' => 'Pro Plan', 'status' => 'expired', 'price' => 99],
    ['id' => 3, 'name' => 'Premium Plan', 'status' => 'active', 'price' => 149],
    ['id' => 4, 'name' => 'Trial Plan', 'status' => 'cancelled', 'price' => 0],
    ['id' => 5, 'name' => 'Enterprise Plan', 'status' => 'active', 'price' => 299]
];

Tasks:
1. Use array_filter() to create a new array called $active_only that contains 
   only memberships where status is 'active'
2. Use print_r() to display the filtered array
3. Use count() to echo how many active memberships there are

Hint: array_filter() needs a callback function. You can use an anonymous 
function like: function($item) { return */


# it makes more sense call it as $subscriptions, not $memberships
/* $subscriptions = [
  ['id' => 1, 'name' => 'Basic Plan', 'status' => 'active', 'price' => 29],
  ['id' => 2, 'name' => 'Pro Plan', 'status' => 'expired', 'price' => 99],
  ['id' => 3, 'name' => 'Premium Plan', 'status' => 'active', 'price' => 149],
  ['id' => 4, 'name' => 'Trial Plan', 'status' => 'cancelled', 'price' => 0],
  ['id' => 5, 'name' => 'Enterprise Plan', 'status' => 'active', 'price' => 299]
];


#1

$active_only = array_filter($subscriptions, function ($e) {
  return $e['status'] === 'active';
}) ;

#2

echo "<pre>";
print_r($active_only);
echo "</pre>";

#3

$count = count($active_only);

echo "<pre>";
echo "The number of active memberships are $count";
echo "</pre>"; */


# Exercise 12 - extracting user emails for bulk actions

/*
A customer needs to send a promotional email to all Pro plan members. 
You need to extract just the email addresses from the user data.

Create an array called $users with this data:

$users = [
    ['id' => 101, 'name' => 'Alice', 'email' => 'alice@example.com', 'plan' => 'Pro'],
    ['id' => 102, 'name' => 'Bob', 'email' => 'bob@example.com', 'plan' => 'Basic'],
    ['id' => 103, 'name' => 'Carol', 'email' => 'carol@example.com', 'plan' => 'Pro'],
    ['id' => 104, 'name' => 'Dan', 'email' => 'dan@example.com', 'plan' => 'Enterprise'],
    ['id' => 105, 'name' => 'Eve', 'email' => 'eve@example.com', 'plan' => 'Pro']
];

Tasks:
1. First, use array_filter() to create $pro_users containing only users where 
   plan is 'Pro'
2. Then, use array_column() to extract just the 'email' values from $pro_users 
   into a new array called $pro_emails
3. Use print_r() to display the $pro_emails array
4. Use implode() to convert the array into a comma-separated string and echo it

Hint: array_column($array, 'column_name') pulls out a single column from a 
multi-dimensional array. implode(', ', $array) joins array elements with a separator.
*/

/* $users = [
  ['id' => 101, 'name' => 'Alice', 'email' => 'alice@example.com', 'plan' => 'Pro'],
  ['id' => 102, 'name' => 'Bob', 'email' => 'bob@example.com', 'plan' => 'Basic'],
  ['id' => 103, 'name' => 'Carol', 'email' => 'carol@example.com', 'plan' => 'Pro'],
  ['id' => 104, 'name' => 'Dan', 'email' => 'dan@example.com', 'plan' => 'Enterprise'],
  ['id' => 105, 'name' => 'Eve', 'email' => 'eve@example.com', 'plan' => 'Pro']
];

#1

$pro_users = array_filter($users, function($e){
  return $e['plan'] === 'Pro';
});

#2

$pro_emails = array_column($pro_users, 'email');

#3

echo "<pre>";
print_r($pro_emails);
echo "</pre>";
echo "<br>";

#4

echo implode(', ' , $pro_emails);
*/

# Exercise 13 - calculating revenue from active subscriptions

/*
The customer wants a monthly revenue report showing total income from active 
subscriptions only. You need to filter, calculate, and display the data.

Create an array called $subscriptions with this data:

$subscriptions = [
    ['user' => 'Alice', 'plan' => 'Pro', 'price' => 99, 'status' => 'active'],
    ['user' => 'Bob', 'plan' => 'Basic', 'price' => 29, 'status' => 'expired'],
    ['user' => 'Carol', 'plan' => 'Enterprise', 'price' => 299, 'status' => 'active'],
    ['user' => 'Dan', 'plan' => 'Pro', 'price' => 99, 'status' => 'cancelled'],
    ['user' => 'Eve', 'plan' => 'Premium', 'price' => 149, 'status' => 'active'],
    ['user' => 'Frank', 'plan' => 'Basic', 'price' => 29, 'status' => 'active']
];

Tasks:
1. Use array_filter() to get only subscriptions where status is 'active'
2. Use array_column() to extract just the 'price' values from active subscriptions
3. Use array_sum() to calculate the total monthly revenue
4. Use count() on the filtered array to see how many active subscriptions there are
5. Echo a nice summary like: "Total monthly revenue: $576 from 4 active subscriptions"

Hint: You can chain operations - filter first, then extract column from the 
filtered result. array_sum() adds up all numbers in an array.
*/


/* $subscriptions = [
  ['user' => 'Alice', 'plan' => 'Pro', 'price' => 99, 'status' => 'active'],
  ['user' => 'Bob', 'plan' => 'Basic', 'price' => 29, 'status' => 'expired'],
  ['user' => 'Carol', 'plan' => 'Enterprise', 'price' => 299, 'status' => 'active'],
  ['user' => 'Dan', 'plan' => 'Pro', 'price' => 99, 'status' => 'cancelled'],
  ['user' => 'Eve', 'plan' => 'Premium', 'price' => 149, 'status' => 'active'],
  ['user' => 'Frank', 'plan' => 'Basic', 'price' => 29, 'status' => 'active']
];

#1

$active_subscriptions = array_filter($subscriptions, function($e){
  return $e['status'] === 'active'; 
});

#2

$active_subs_prices = array_column($active_subscriptions, 'price');

#3

$month_revenue = array_sum($active_subs_prices);

#4

$count_active_subs = count($active_subscriptions);

#5

echo "Total monthly revenue: $" . number_format($month_revenue, 2) . " from $count_active_subs active subscriptions"; */


// PUTTING EVERYTHING TOGETHER


# Exercise 14 - membership level access control with switch

/*
A customer wants to display different content based on membership levels.
You need to use a switch statement to determine what features each level gets.

Create an array called $members with this data:

$members = [
    ['name' => 'Alice', 'level' => 'free'],
    ['name' => 'Bob', 'level' => 'basic'],
    ['name' => 'Carol', 'level' => 'pro'],
    ['name' => 'Dan', 'level' => 'enterprise'],
    ['name' => 'Eve', 'level' => 'basic']
];

Tasks:
1. Loop through the $members array using foreach
2. For each member, use a switch statement on their 'level' to determine their access
3. Display output like: "Alice (free) has access to: Public content only"
4. Each level should have different access:
   - free: "Public content only"
   - basic: "Public content, Basic tutorials"
   - pro: "Public content, Basic tutorials, Premium videos"
   - enterprise: "Public content, Basic tutorials, Premium videos, Priority support"
5. Add a default case for unknown levels: "Unknown membership level"

Hint: Use switch($member['level']) inside your foreach loop. Each case should 
echo the member's name and their access level.
*/

/* $members = [
  ['name' => 'Alice', 'level' => 'free'],
  ['name' => 'Bob', 'level' => 'basic'],
  ['name' => 'Carol', 'level' => 'pro'],
  ['name' => 'Dan', 'level' => 'enterprise'],
  ['name' => 'Eve', 'level' => 'basic'],
  ['name' => 'Euler', 'level' => 'unknown'],
];

#1

foreach ($members as $index => $member) {

#2, 3 and 4

  switch ($member['level']) {

    case 'free':
      echo "{$member['name']} ({$member['level']}) has access to: Public content only<br>";
      break;

    case 'basic':
      echo $member['name'] . "(" . $member['level'] . ")" . " has access to: Public content, Basic tutorials";
      echo "<br>";
      break;

    case 'pro':
      echo $member['name'] . "(" . $member['level'] . ")" . " has access to: Public content, Basic tutorials, Premium videos";
      echo "<br>";
      break;
    
    case 'enterprise':
      echo $member['name'] . "(" . $member['level'] . ")" . " has access to: Public content, Basic tutorials, Premium videos, Priority support";
      echo "<br>";
      break;
    
    #5
    default:
      echo "{$member['name']} ({$member['level']}) - Unknown membership level";
      break;

  }    

} */


# Exercise 15 - nested loops with subscription reports

/*
A customer wants a report showing all their subscription plans and the users 
subscribed to each plan. You need to use nested loops to display this data.

Create a multidimensional array called $plans with this structure:

$plans = [
    'Basic' => [
        ['user' => 'Alice', 'status' => 'active'],
        ['user' => 'Bob', 'status' => 'expired'],
        ['user' => 'Charlie', 'status' => 'active']
    ],
    'Pro' => [
        ['user' => 'Diana', 'status' => 'active'],
        ['user' => 'Eve', 'status' => 'active']
    ],
    'Enterprise' => [
        ['user' => 'Frank', 'status' => 'active'],
        ['user' => 'Grace', 'status' => 'cancelled'],
        ['user' => 'Henry', 'status' => 'active']
    ]
];

Tasks:
1. Use a foreach loop to iterate through each plan (Basic, Pro, Enterprise)
2. For each plan, echo the plan name as a header
3. Use a nested foreach loop to iterate through the subscribers of that plan
4. Display each subscriber with format: "- Alice (active)"
5. After each plan's subscribers, echo a blank line for spacing

Expected output:
Basic Plan:
- Alice (active)
- Bob (expired)
- Charlie (active)

Pro Plan:
- Diana (active)
- Eve (active)

Enterprise Plan:
- Frank (active)
- Grace (cancelled)
- Henry (active)

Hint: The outer loop gives you $plan_name => $subscribers, and the inner loop 
goes through each $subscriber in $subscribers array.
*/

/* $plans = [
  'Basic' => [
      ['user' => 'Alice', 'status' => 'active'],
      ['user' => 'Bob', 'status' => 'expired'],
      ['user' => 'Charlie', 'status' => 'active']
  ],
  'Pro' => [
      ['user' => 'Diana', 'status' => 'active'],
      ['user' => 'Eve', 'status' => 'active']
  ],
  'Enterprise' => [
      ['user' => 'Frank', 'status' => 'active'],
      ['user' => 'Grace', 'status' => 'cancelled'],
      ['user' => 'Henry', 'status' => 'active']
  ]
];

#1 and #2

foreach ($plans as $plan => $subscribers) {
  echo "{$plan} Plan:<br>";

  #3 and 4

  foreach ($subscribers as $subscriber) {
    echo "{$subscriber['user']} ({$subscriber['status']}) <br>";
  }

  #5
  echo "<br>";

} 

*/

// smal aside for globals

/* echo "<pre>";
print_r($GLOBALS);
echo "</pre>"; */

# Exercise 16 - functions that return filtered arrays

/*
You need to create reusable functions to process membership data. Instead of 
writing the same filtering code over and over, you'll create functions that 
can be called anytime you need that specific filter.

Create this array of transactions:

$transactions = [
    ['id' => 1, 'amount' => 99, 'status' => 'complete', 'type' => 'subscription'],
    ['id' => 2, 'amount' => 29, 'status' => 'pending', 'type' => 'one-time'],
    ['id' => 3, 'amount' => 149, 'status' => 'complete', 'type' => 'subscription'],
    ['id' => 4, 'amount' => 99, 'status' => 'failed', 'type' => 'subscription'],
    ['id' => 5, 'amount' => 299, 'status' => 'complete', 'type' => 'one-time'],
    ['id' => 6, 'amount' => 99, 'status' => 'complete', 'type' => 'subscription']
];

Tasks:
1. Create a function called get_complete_transactions($transactions) that:
   - Takes an array of transactions as parameter
   - Uses array_filter() to return only transactions where status is 'complete'
   - Returns the filtered array

2. Create a function called get_subscription_transactions($transactions) that:
   - Takes an array of transactions as parameter
   - Uses array_filter() to return only transactions where type is 'subscription'
   - Returns the filtered array

3. Create a function called calculate_total($transactions) that:
   - Takes an array of transactions as parameter
   - Uses array_column() to extract all 'amount' values
   - Uses array_sum() to calculate the total
   - Returns the total amount

4. Test your functions:
   - Call get_complete_transactions() and display the count
   - Call get_subscription_transactions() and display the count
   - Combine both filters: get complete subscription transactions only
   - Calculate the total of complete subscription transactions

Hint: You can pass the result of one function into another function, like:
calculate_total(get_complete_transactions($transactions))
*/

/* $transactions = [
  ['id' => 1, 'amount' => 99, 'status' => 'complete', 'type' => 'subscription'],
  ['id' => 2, 'amount' => 29, 'status' => 'pending', 'type' => 'one-time'],
  ['id' => 3, 'amount' => 149, 'status' => 'complete', 'type' => 'subscription'],
  ['id' => 4, 'amount' => 99, 'status' => 'failed', 'type' => 'subscription'],
  ['id' => 5, 'amount' => 299, 'status' => 'complete', 'type' => 'one-time'],
  ['id' => 6, 'amount' => 99, 'status' => 'complete', 'type' => 'subscription']
];

#1

function get_complete_transactions($transactions) {

  return array_filter($transactions, function($e){
    return $e['status'] === 'complete';}) ;
}

#2

function get_subscriptions_transactions($transactions) {
  return array_filter($transactions, function($e){
    return $e['type'] === 'subscription';}) ;
}

#3

function calculate_total($transactions) {

  $amount_values = array_column($transactions, 'amount');
  return array_sum($amount_values);

}

/* echo count(get_complete_transactions($transactions));
echo "<br>";

echo count(get_subscriptions_transactions($transactions));
echo "<br>";

echo count(get_complete_transactions(get_subscriptions_transactions($transactions)));
echo "<br>"; */



# Exercise 17 - complex data processing with multiple operations

/*
A customer needs a detailed membership report. You'll need to process their 
data using multiple operations: filtering, sorting, calculating, and formatting.

Create this array of members:

$members = [
    ['name' => 'Alice', 'level' => 'pro', 'joined' => '2023-01-15', 'revenue' => 297],
    ['name' => 'Bob', 'level' => 'basic', 'joined' => '2023-06-20', 'revenue' => 87],
    ['name' => 'Carol', 'level' => 'enterprise', 'joined' => '2023-02-10', 'revenue' => 897],
    ['name' => 'Dan', 'level' => 'basic', 'joined' => '2023-08-05', 'revenue' => 58],
    ['name' => 'Eve', 'level' => 'pro', 'joined' => '2023-03-12', 'revenue' => 396],
    ['name' => 'Frank', 'level' => 'enterprise', 'joined' => '2023-01-30', 'revenue' => 1197],
    ['name' => 'Grace', 'level' => 'basic', 'joined' => '2023-09-18', 'revenue' => 29]
];

Tasks:
1. Filter to get only 'pro' and 'enterprise' level members (exclude 'basic')
   Hint: use array_filter() with a condition that checks if level is NOT 'basic'

2. Sort the filtered members by revenue (highest to lowest)
   Hint: use usort() with a custom comparison function

3. Get the top 3 highest revenue members from the sorted list
   Hint: use array_slice()

4. Calculate the total revenue from these top 3 members
   Hint: use array_column() and array_sum()

5. Display the results:
   - Echo "Top 3 Premium Members:"
   - Loop through and display: "Alice (pro) - $297"
   - Echo total: "Combined revenue: $XXX"

Expected output:
Top 3 Premium Members:
Frank (enterprise) - $1197
Carol (enterprise) - $897
Eve (pro) - $396
Combined revenue: $2490
*/

/* $members = [
  ['name' => 'Alice', 'level' => 'pro', 'joined' => '2023-01-15', 'revenue' => 297],
  ['name' => 'Bob', 'level' => 'basic', 'joined' => '2023-06-20', 'revenue' => 87],
  ['name' => 'Carol', 'level' => 'enterprise', 'joined' => '2023-02-10', 'revenue' => 897],
  ['name' => 'Dan', 'level' => 'basic', 'joined' => '2023-08-05', 'revenue' => 58],
  ['name' => 'Eve', 'level' => 'pro', 'joined' => '2023-03-12', 'revenue' => 396],
  ['name' => 'Frank', 'level' => 'enterprise', 'joined' => '2023-01-30', 'revenue' => 1197],
  ['name' => 'Grace', 'level' => 'basic', 'joined' => '2023-09-18', 'revenue' => 29]
];

#1

$vip_members = array_filter($members, function($e) {
  return $e['level'] !== 'basic';
  });

echo "<pre>";
print_r($vip_members);
echo "</pre>";

#2.0
#2.1
function revenue_parameter($a, $b) {
  return $b['revenue'] - $a['revenue'];
}

usort($vip_members, "revenue_parameter");


#2.2
or you could also do


usort($vip_members, function ($a, $b) {
  return $b['revenue'] - $a['revenue'];
});

echo "<pre>";
print_r($vip_members);
echo "</pre>";

#3

$top_vip_members = array_slice($vip_members, 0, 3);

 echo "<pre>";
print_r($top_vip_members);
echo "</pre>";

#4

$revenue_top = array_sum(array_column($top_vip_members, 'revenue'));

// echo $revenue_top;

#5 

echo "<h1>Top 3 Premium Members:</h1><br>";

foreach ($top_vip_members as $top_members) {

  echo "{$top_members['name']} ({$top_members['level']}) - {$top_members['revenue']}";
  echo "<br>";

}

echo "Combined revenue: $" . $revenue_top; */

# Exercise 18 - membership upgrade eligibility checker

/*
Check which basic members are eligible for upgrade offers based on their activity.

$basic_members = [
    ['name' => 'Alice', 'months_active' => 8, 'logins' => 45],
    ['name' => 'Bob', 'months_active' => 3, 'logins' => 12],
    ['name' => 'Carol', 'months_active' => 12, 'logins' => 78],
    ['name' => 'Dan', 'months_active' => 6, 'logins' => 30],
    ['name' => 'Eve', 'months_active' => 2, 'logins' => 8]
];

Tasks:
1. Filter members who are eligible (months_active >= 6 AND logins >= 30)
2. Count how many are eligible
3. Get just their names using array_column()
4. Display: "3 members eligible: Alice, Carol, Dan"

Hint: Use && in your filter condition. Use implode(', ', $names) to join names.
*/

/* $basic_members = [
  ['name' => 'Alice', 'months_active' => 8, 'logins' => 45],
  ['name' => 'Bob', 'months_active' => 3, 'logins' => 12],
  ['name' => 'Carol', 'months_active' => 12, 'logins' => 78],
  ['name' => 'Dan', 'months_active' => 6, 'logins' => 30],
  ['name' => 'Eve', 'months_active' => 2, 'logins' => 8]
];

#1

function eligible_members($e) {
  return ($e['months_active'] >= 6 && $e['logins'] >= 30);
}

$eligible_members = array_filter($basic_members, 'eligible_members');

echo "<pre>";
print_r($eligible_members);
echo "</pre>";

#2

$number_of_eligible_members = count($eligible_members);

#3

$eligible_names = implode(', ', array_column($eligible_members, 'name'));


#4

echo "$number_of_eligible_members members eligible: $eligible_names"; */

# Exercise 19 - complete membership analytics dashboard

/*
Build a comprehensive report combining ALL the concepts you've learned.

$all_members = [
    ['name' => 'Alice', 'level' => 'pro', 'status' => 'active', 'revenue' => 297, 'joined' => 2023],
    ['name' => 'Bob', 'level' => 'basic', 'status' => 'expired', 'revenue' => 87, 'joined' => 2022],
    ['name' => 'Carol', 'level' => 'enterprise', 'status' => 'active', 'revenue' => 897, 'joined' => 2023],
    ['name' => 'Dan', 'level' => 'basic', 'status' => 'active', 'revenue' => 58, 'joined' => 2024],
    ['name' => 'Eve', 'level' => 'pro', 'status' => 'cancelled', 'revenue' => 396, 'joined' => 2023],
    ['name' => 'Frank', 'level' => 'enterprise', 'status' => 'active', 'revenue' => 1197, 'joined' => 2022],
    ['name' => 'Grace', 'level' => 'basic', 'status' => 'active', 'revenue' => 29, 'joined' => 2024],
    ['name' => 'Henry', 'level' => 'pro', 'status' => 'active', 'revenue' => 198, 'joined' => 2024]
];

Tasks:
1. Filter active members only
2. Group them by level (basic, pro, enterprise) - use a foreach with switch
3. For each level, calculate total revenue and member count
4. Display formatted report with ALL level stats
5. Show grand total revenue from all active members

Expected output format:
=== MEMBERSHIP ANALYTICS ===

BASIC Level:
- Members: 2
- Revenue: $87

PRO Level:
- Members: 2  
- Revenue: $495

ENTERPRISE Level:
- Members: 2
- Revenue: $2094

GRAND TOTAL: $2676 from 6 active members

Hint: Create empty arrays for each level, then use switch to push members into 
the right array. Then loop through each to calculate stats.
*/

/* $all_members = [
  ['name' => 'Alice', 'level' => 'pro', 'status' => 'active', 'revenue' => 297, 'joined' => 2023],
  ['name' => 'Bob', 'level' => 'basic', 'status' => 'expired', 'revenue' => 87, 'joined' => 2022],
  ['name' => 'Carol', 'level' => 'enterprise', 'status' => 'active', 'revenue' => 897, 'joined' => 2023],
  ['name' => 'Dan', 'level' => 'basic', 'status' => 'active', 'revenue' => 58, 'joined' => 2024],
  ['name' => 'Eve', 'level' => 'pro', 'status' => 'cancelled', 'revenue' => 396, 'joined' => 2023],
  ['name' => 'Frank', 'level' => 'enterprise', 'status' => 'active', 'revenue' => 1197, 'joined' => 2022],
  ['name' => 'Grace', 'level' => 'basic', 'status' => 'active', 'revenue' => 29, 'joined' => 2024],
  ['name' => 'Henry', 'level' => 'pro', 'status' => 'active', 'revenue' => 198, 'joined' => 2024]
];

#1

function active_members($e) {
  return $e['status'] === 'active';
}

$active_members = array_filter($all_members, 'active_members');
$n_active_members = count($active_members);

#2

$basic_level = [];
$pro_level = [];
$enterprise_level = [];

foreach ($active_members as $members) {

  switch ($members['level']) {

    case 'basic':
      array_push($basic_level, $members);
    break;

    case 'pro':
      array_push($pro_level, $members);
    break;

    case 'enterprise':
      array_push($enterprise_level, $members);
    break;

    default:
     echo "No valid plan found";
    break;

  }   
}


#3

$n_basic = count($basic_level);
$n_pro = count($pro_level);
$n_enterprise = count($enterprise_level);

$r_basic = array_sum(array_column($basic_level, 'revenue'));
$r_pro = array_sum(array_column($pro_level, 'revenue'));
$r_enterprise = array_sum(array_column($enterprise_level, 'revenue'));

#4

echo "<pre>";

echo "<h1> === MEMBERSHIP ANALYTICS ===</h1>";

echo "BASIC Level:<br>";
echo "Members: $n_basic <br>";
echo "Revenue: $" . $r_basic . "<br>";
echo "<br>";

echo "PRO Level:<br>";
echo "Members: $n_pro <br>";
echo "Revenue: $" . $r_pro . "<br>";
echo "<br>";

echo "ENTERPRISE Level:<br>";
echo "Members: $n_enterprise <br>";
echo "Revenue: $" . $r_enterprise . "<br>";
echo "<br>";

echo "</pre>";


#5

$total_revenue = array_sum(array_column($active_members, 'revenue'));

echo "<pre>";
echo "GRAND TOTAL: $" . $total_revenue . " from " . $n_active_members . " active members.";
echo "</pre>"; */

// ============================================
// Exercise 20: analyze switch pattern (A1)
// ============================================

// Sample transaction data (array-based, not objects)
/* $transaction = [
  'id' => 12345,
  'amount' => 99.00,
  'status' => 'complete',
  'user' => 'john_doe'
];

// Pattern: Using switch to route based on status
switch ($transaction['status']) {
  case 'complete':
      $badge = '<span class="badge-green">Completed</span>';
      $allow_refund = true;
      break;

  // adds a green badge to the status info (assuming we have this CSS class set at some place), and set a 'refund possibility flag' as true
      
  case 'pending':
      $badge = '<span class="badge-yellow">Pending Payment</span>';
      $allow_refund = false;
      break;

  // adds a yellow badge to the status info (assuming we have this CSS class set at some place), and set a 'refund possibility flag' as false

      
  case 'failed':
      $badge = '<span class="badge-red">Failed</span>';
      $allow_refund = false;
      break;

   // adds a red badge to the status info (assuming we have this CSS class set at some place), and set a 'refund possibility flag' as false

  
  case 'refunded':
      $badge = '<span class="badge-gray">Refunded</span>';
      $allow_refund = false;
      break;

   // adds a gray badge to the status info (assuming we have this CSS class set at some place), and set a 'refund possibility flag' as false

      
  default:
      $badge = '<span class="badge-blue">Unknown</span>';
      $allow_refund = false;
      break;

  // adds a blue badge to the status info (assuming we have this CSS class set at some place), and set a 'refund possibility flag' as false

}

echo "<h3>Exercise 20: Switch Analysis</h3>";
echo "Transaction #{$transaction['id']}: {$badge}<br>";
echo "Refund allowed: " . ($allow_refund ? 'Yes' : 'No') . "<br>";



1 What happens if you remove the break from the 'complete' case?
2 Why does the code set TWO variables inside each case ($badge and $allow_refund)?
3 What would happen if $transaction['status'] was 'cancelled'?


1 - It falls through and run immediately the next case. The system automatically sets it to Pending and breaks the switch statement properly after that, making the transaction as 'pending payment' and no refund allowed. Interesting

2 - Because it wants to use them afterwars to echo the transaction status and if it is eligible to refund or not

3 - Something like this as output:

Transaction #12345: Unknown
Refund allowed: No

*/

// ============================================
// Exercise 21: build your own switch (B1)
// ============================================

// Member data
/* $member = [
  'id' => 567,
  'name' => 'Sarah Connor',
  'level' => 'free'
];

// YOUR TASK: Create a switch statement based on $member['level']
// For each level, set these THREE variables:
// - $level_name (display name as string)
// - $access_level (number 1-5)
// - $color (badge color as string)

// Handle these membership levels:
// 'free' → 'Free Member', access: 1, color: 'gray'
// 'basic' → 'Basic Member', access: 2, color: 'blue'
// 'pro' → 'Pro Member', access: 4, color: 'green'
// 'enterprise' → 'Enterprise Member', access: 5, color: 'gold'
// default → 'Unknown Level', access: 0, color: 'red'

// YOUR SWITCH STATEMENT HERE

switch ($member['level']) {

  case 'free':
    $level_name = 'Free Member';
    $access_level = 1;
    $color = 'gray';
    break;

  case 'basic':
    $level_name = 'Basic Member';
    $access_level = 2;
    $color = 'blue';
    break;

  case 'pro':
    $level_name = 'Pro Member';
    $access_level = 4;
    $color = 'green';
    break;

  case 'enterprise':
    $level_name = 'Enterprise Member';
    $access_level = 5;
    $color = 'gold';
    break;

  default:
    $level_name = 'Unknown Level';
    $access_level = 0;
    $color = 'red';
    break;

}


// Display results
echo "
<style>
    .badge-green { color: white; background-color: green; padding: 2px 5px; border-radius: 3px; }
    .badge-yellow { color: black; background-color: #ffcc00; padding: 2px 5px; border-radius: 3px; }
    .badge-red { color: white; background-color: red; padding: 2px 5px; border-radius: 3px; }
    .badge-gray { color: white; background-color: #888; padding: 2px 5px; border-radius: 3px; }
    .badge-blue { color: white; background-color: blue; padding: 2px 5px; border-radius: 3px; }
    .badge-gold { color: black; background-color: gold; padding: 2px 5px; border-radius: 3px; }
</style>
";
echo "<h3>Exercise 21: Membership Level Display</h3>";
echo "Member: {$member['name']}<br>";
echo "Level: <span class='badge-{$color}'>{$level_name}</span><br>";
echo "Access Level: {$access_level}/5<br>"; */

// ============================================
// Exercise 22: analyze foreach pattern (A2)
// ============================================

// Sample list of transactions for a specific member
/* $member_transactions = [
  ['amount' => 50.00, 'type' => 'payment', 'status' => 'complete'],
  ['amount' => 25.00, 'type' => 'payment', 'status' => 'complete'],
  ['amount' => 10.00, 'type' => 'refund',  'status' => 'complete'],
  ['amount' => 50.00, 'type' => 'payment', 'status' => 'pending'],
  ['amount' => 30.00, 'type' => 'payment', 'status' => 'complete'],
  #3 Yes, it updates correctly
  ['amount' => 100.00, 'type' => 'payment', 'status' => 'complete'],
];

$total_revenue = 0;
#2 We need to declare this variable outside the loop otherwise it'll always reset the value of the variable, instead of summing every transaction to the total_revenue
$successful_payments_count = 0;

foreach ($member_transactions as $txn) {
  // Only process 'complete' transactions
  if ($txn['status'] === 'complete') {
      
      if ($txn['type'] === 'payment') {
          $total_revenue += $txn['amount'];
          $successful_payments_count++;
      } elseif ($txn['type'] === 'refund') {
          $total_revenue -= $txn['amount'];
          #1 For the third item in the array, it encounters this block of code (type = refund). Instead of summing it up, the amount is substracted according to the refunded value
      }
      
  }
}

echo "<h3>Exercise 22: Member Activity Report</h3>";
echo "Total Revenue: \${$total_revenue}<br>";
echo "Successful Payments: {$successful_payments_count}<br>";

#4 The final value would be the last $txn['amount'], basically. ps: I have confirmed this output on the screen

*/

// ============================================
// Exercise 23: build your own foreach (B2.0)
// ============================================

/* $users = [
  ['name' => 'Alice',   'status' => 'active',   'days_since_login' => 2],
  ['name' => 'Bob',     'status' => 'inactive', 'days_since_login' => 45],
  ['name' => 'Charlie', 'status' => 'active',   'days_since_login' => 1],
  ['name' => 'David',   'status' => 'inactive', 'days_since_login' => 60],
  ['name' => 'Eve',     'status' => 'active',   'days_since_login' => 5],
];

// YOUR TASK: 
// 1. Initialize an empty string variable $inactive_list
// 2. Initialize a counter variable $inactive_count at 0
// 3. Loop through $users using foreach
// 4. If a user's status is 'inactive':
//    - Add 1 to $inactive_count
//    - Append the user's name and days since login to $inactive_list
//      (e.g. "- Bob (45 days ago)<br>")

// YOUR CODE HERE

#1

$inactive_list = '';

#2

$inactive_count = 0;

#3

foreach ($users as $user) {
  
  #4

  if ($user['status'] === 'inactive') {

    $inactive_count++;
    $inactive_list .= $user['name'] . " (" . $user['days_since_login'] . " days ago) <br>";
  }

}


echo "<h3>Exercise 23: Inactive Members Report</h3>";
echo "Total Inactive: $inactive_count<br>";
echo "List:<br>$inactive_list"; */

// ============================================
// Exercise 24: analyze nested patterns (A3.0)
// ============================================

/* $membership_data = [
  [
      'user' => 'john_doe',
      'subscriptions' => [
          ['id' => 'SUB-1', 'status' => 'active'],
          ['id' => 'SUB-2', 'status' => 'cancelled']
      ]
  ],
  [
      'user' => 'jane_smith',
      'subscriptions' => [
          ['id' => 'SUB-3', 'status' => 'active']
      ]
  ]
];

echo "<h3>Exercise 24: Nested Data Report</h3>";

foreach ($membership_data as $member) {
  echo "<strong>Member: " . $member['user'] . "</strong><br>";
  
  // Nested loop to process the inner array
  foreach ($member['subscriptions'] as $sub) {
      $status_color = ($sub['status'] === 'active') ? 'green' : 'red';
      echo "- ID: " . $sub['id'] . " (<span style='color:$status_color'>" . $sub['status'] . "</span>)<br>";
  }
  echo "<br>";
}


#1 The first foreach is looping through each element of the $membership_data array as a $member. That is, each array of $membership_array is represented by $member. So, $member['user'] and $member['subscriptions']. The second foreach takes $member['subscriptions'], looping through each element of it as $sub. Basically... 

#2 I guess it'll just show its name, like 'Member: fulano' and nothing ahead

#3 As explained in the first question, it is a variable that represents the arrays inside $members[subscriptions]. Not sure what you meant with 'safe', but ig it is probably because this variable wasn't declared before in any places

#4 To separate each member and its info */

// ============================================
// Exercise 25: build your own nested report (B3.0)
// ============================================

/* $report_data = [
  [
      'member' => 'Alice',
      'payments' => [20.00, 50.00, 20.00] // simple list of numbers
  ],
  [
      'member' => 'Bob',
      'payments' => [100.00, 10.00]
  ],
  [
      'member' => 'Charlie',
      'payments' => [] // No payments
  ]
];

// YOUR TASK:
// 1. Loop through $report_data
// 2. Display the member's name
// 3. Initialize a variable $total_spent = 0 inside the first loop (but before the second)
// 4. Create a second loop to iterate through the 'payments' array
// 5. Add each payment to $total_spent
// 6. After the second loop ends, echo the total for that member
//    (e.g. "Total Spent: $90")

// YOUR CODE HERE

echo "<h3>Exercise 25: Final Subscription Report</h3>";

#1
 
foreach ($report_data as $data) {
  #2
  echo $data['member'] . "<br>";

  #3
  $total_spent = 0;
  
  #4
  foreach ($data['payments'] as $payment) {
    #5
    $total_spent += $payment;
    
  }

  #6
  echo "Total Spent: $" . $total_spent . "<br>";
  echo "<br>";


}

*/


// ============================================
// SECTION 16: SUPERGLOBALS AND $GLOBALS
// Exercise 26: global scope basics
// ============================================

// A global variable defined in the main scope
/* $app_name = 'MemberPress App';

// YOUR TASK:
// 1. Create a function called show_app_name()
//    - Inside the function, echo the value of $app_name
//    - Use $GLOBALS to access it
//
// 2. Create a function called set_app_version()
//    - Inside the function, create a global variable called $app_version
//    - Do this by assigning into $GLOBALS
//
// 3. Call both functions below
//
// 4. After calling set_app_version(),
//    - Echo $app_version
//
// NOTES:
// - Do NOT use the `global` keyword
// - Use $GLOBALS only
// - No conditionals or loops needed

// YOUR CODE HERE


echo "<h3>Exercise 26: Superglobals and \$GLOBALS</h3>";



#1

function show_app_name() {
  echo $GLOBALS['app_name'];  
  echo "<br>";
}

#2

function set_app_version($version) {
  $GLOBALS['app_version'] = $version;
}

#3

show_app_name();
set_app_version(1.0);

#4

echo number_format($app_version, 1); */


// ============================================
// Exercise 27: $GLOBALS vs global
// ============================================

// A global variable defined in the main scope
/* $plugin_name = 'MemberPress';

// YOUR TASK:
// 1. Create a function called show_plugin_name_with_global()
//    - Inside the function, use: global $plugin_name;
//    - Echo $plugin_name
//
// 2. Create a function called show_plugin_name_with_globals()
//    - Inside the function, echo $GLOBALS['plugin_name']
//
// 3. Call both functions below
//
// NOTES:
// - Do not mix the two approaches inside the same function
// - This exercise exists only to compare the two mechanisms

// YOUR CODE HERE


echo "<h3>Exercise 27: global keyword vs \$GLOBALS</h3>";


#1

function show_plugin_name_with_global() {
  global $plugin_name;
  echo $plugin_name . "<br>";
}

#2

function show_plugin_name_with_globals() {
  echo $GLOBALS['plugin_name'];
}

#3

show_plugin_name_with_global();
show_plugin_name_with_globals();
*/

// ============================================
// SECTION 17: $_SERVER
// Exercise 28: $_SERVER - request and script info
// ============================================

// YOUR TASK:
// 1. Echo the current request method (GET or POST)
// 2. Echo the current script name
// 3. Echo whether the request is using HTTPS or not
//
// NOTES:
// - Use $_SERVER only
// - This exercise is about observing what the server provides

// YOUR CODE HERE


/* echo "<h3>Exercise 28: \$_SERVER basics</h3>";

#1

echo $_SERVER['REQUEST_METHOD'];
echo "<br>";

#2

echo $_SERVER['SCRIPT_FILENAME'];
echo "<br>";
//or shorter
echo " {$_SERVER['PHP_SELF']} <br>";

#3

if (isset($_SERVER['HTTPS'])) {
  echo 'HTTPS exists (but we cannot say it is enabled)';
} else {
  echo 'HTTPS key not present';
} */  


// ============================================
// SECTION 18: $_REQUEST
// Exercise 29: $_REQUEST - handling form data
// ============================================

// Simulate form data (uncomment to test):
// $_REQUEST['member_id'] = '4729';
// $_REQUEST['plan'] = 'Pro';

// YOUR TASK:
// 1. Check if 'member_id' exists in $_REQUEST
//    - If yes: echo "Searching for member: [value]"
//    - If no: echo "No member ID provided"
//
// 2. Check if 'plan' exists in $_REQUEST
//    - If yes: echo "Filtering by plan: [value]"
//    - If no: echo "No plan filter applied"

// YOUR CODE HERE

/* echo "<h3>Exercise 29: \$_REQUEST basics</h3>";

if (isset($_REQUEST['member_id'])) {
  echo "Searching for member: ... {$_REQUEST['member_id']} <br>";
} else {
  echo "No member ID provided <br>";
}

if (isset($_REQUEST['plan'])) {
  echo "Filtering by plan: {$_REQUEST['plan']}";
} else {
  echo "No plan filter applied";
} */

// ============================================
// SECTION 18: $_REQUEST
// Exercise 30: member search tool with real inputs
// ============================================

// SCENARIO:
// You're building a simple member search form for the MemberPress dashboard.
// The form will submit data and you'll use $_REQUEST to handle it.

// YOUR TASK:
// 1. Create an HTML form with method="GET" and action="" (submits to itself)
// 2. Add a text input for "member_id" with a label
// 3. Add a text input for "email" with a label
// 4. Add a submit button
// 5. Below the form, use PHP to check if the form was submitted
//    - If 'member_id' exists in $_REQUEST, echo "Searching for member ID: [value]"
//    - If 'email' exists in $_REQUEST, echo "Email: [value]"
//    - If neither exists, echo "Fill out the form above to search"
//
// NOTES:
// - Use $_REQUEST (works with both GET and POST)
// - The form will reload the page when submitted
// - You'll see the values in the URL: ?member_id=123&email=test@test.com

/* 1, 2, 3 and 4 - HTML FORM HERE

<form method="get" action="">
  
   <input id="member_id" type="text" name="member_id">
   <label for ="member_id">Member ID</label></br></br>
   <input id="email" type="text" name="email">
   <label for ="email">Email</label></br></br>
   <input type="submit">
</form> */

// YOUR PHP LOGIC HERE TO DISPLAY RESULTS

/* echo "<h3>Exercise 30: member search tool</h3>";

#5

if (isset($_REQUEST['member_id'])) {
  echo "Searching for member ID: {$_REQUEST['member_id']} <br>";
}

if (isset($_REQUEST['email'])) {
  echo "Email: {$_REQUEST['email']} <br><br>";
}

if (empty($_REQUEST['member_id']) && empty($_REQUEST['email'])) {
  echo "<strong><span style='color:red'>Fill out the form above to search</span></strong>";
} */


// ============================================
// SECTION 19: $_POST
// Exercise 31: login form with POST method
// ============================================

// SCENARIO:
// You're building a login form for MemberPress. Login forms should use POST 
// (not GET) because passwords shouldn't appear in the URL.

// YOUR TASK:
// 1. Create an HTML form with method="POST" and action="" (submits to itself)
// 2. Add a text input for "username" with a label
// 3. Add a password input for "password" with a label
// 4. Add a submit button with text "Log In"
// 5. Below the form, check if the form was submitted:
//    - If 'username' exists in $_POST, echo "Logging in as: [username]"
//    - If 'password' exists in $_POST, echo "Password received: [show length only, not the actual password]"
//      Hint: use strlen() to show password length like "Password received (8 characters)"
//    - If neither exists, echo "Enter your credentials above"
//
// NOTES:
// - Now using $_POST specifically (since we're learning POST method)
// - Notice how the URL stays clean when you submit (no ?user

?>

<form method="post" action ="">
  <input type="text" name="username">
  <label for="username">Username</label><br>
  <input type="password" name="password">
  <label for="password">Password</label><br>
  <input type="submit" value="Log in"><br>
  

</form>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  if (!empty($_POST['username'])) {
    $username = htmlspecialchars($_POST['username']);
    echo "Logging in as: $username <br>";
  } else {
    echo "No username provided <br>";
  }

  if (!empty($_POST['password'])) {
    $pwd_lenght = strlen($_POST['password']);
    echo "Password received ($pwd_lenght characters) <br>";
  } else {
    echo "No password entered <br>";
  }

  if (empty ($_POST['username']) && empty ($_POST['password'])) {
    echo 'Enter your credentials above';
  }
}
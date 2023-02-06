# Unit Testing In PHP

## Overview
Exercises for unit testing. This is a Symfony project, run on php 8. You should only focus on testing CalculatorController. 
Tests should be written in `tests/Calculator/CalculatorControllerTest.php`, where `tests/Calculator/CalculatorControllerSolvedTest.php`
is here if you get really stuck. You should be able to reach  94% coverage. More than that should not really possible in this controller.
But that's okay, as long as we get at least 80%. Note that you will have to make changes to the controller. 

## xdebug
If you want to see code coverage, i highly suggest installing xdebug. This will display to you (un)covered lines.
1. Install xdebug: `$ pecl install xdebug`
2. Open your `php.ini` file mine was in `/usr/local/etc/php/8.0/php.ini`
3. Find `[xdebug]` -> if it's not there, just add it
4. Also add following lines under `[xdebug]`: `zend_extension="xdebug.so"`, `xdebug.mode="coverage"`

## Running tests
I ran tests via PhpStorm IDE. I used local interpreter: `/usr/local/Cellar/php@8.0/8.0.23_1/bin/php`. Right click on tests and select 
`run with code coverage`.

<?php

namespace space_1\space_33;
  function getmsg(){
    echo "123";
  }

class Animals{
  public $obj = 'dog';
}

namespace space_2;
  function getmsg(){
    echo " 456";
  }

class Animals{
  public $obj = 'pig';
}

use space_1\space_33;//引入空间

space_33\getmsg();
//
// $animals = new Animals();
//
// echo $animals -> obj;

$animals = new space_33\Animals();

echo $animals -> obj;

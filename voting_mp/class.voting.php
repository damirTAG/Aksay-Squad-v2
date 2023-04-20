<?php
// Script Voting - http://coursesweb.net/
class Voting {
  // properties
  public $conn = false;  // stores the connection to mysql
  protected $voter ='';  // the user who vote, or its IP
  protected $nrvot =0;  // if it is 1, the user can vote only one item in a day, 0 for multiple items
  public $votitems ='votitems';  // Table to store items that are voted
  public $votusers ='votusers';  // Table that stores the users who voted
  protected $time;  // will store the current Timestamp

  // constructor
  public function __construct($conn){
    if(defined('NRVOT')) $this->nrvot = NRVOT;
    if(defined('USRVOTE') && USRVOTE ===0) { if(defined('VOTER')) $this->voter = VOTER; }
    else if(isset($_COOKIE['voter']) && strlen($_COOKIE['voter']) >1) $this->voter = $_COOKIE['voter'];
    else {
      $this->voter = $_SERVER['REMOTE_ADDR'];
      setcookie('voter', $this->voter, NEXTV); // sets cookie with voter ip /name
    }
    $this->time = time();
    $this->conn = $conn;
  }

  // returns JSON string with item:['v_plus', 'v_minus', voted] for each element in $items array 
  public function getVoting($items, $vote ='') {
    $votstdy = $this->votstdyDb($items);     // gets array with items voted by the user

    // if $vote not empty, perform to register the vote, $items contains one item to vote
    if(!empty($vote)) {
      // if $voter empty means user not loged
      if($this->voter ==='') return "alert('Vote Not registered.\\nYou must be logged in to can vote')";

      // if already voted, returns JSON from which JS alert message and will reload the page
      // else, accesses the method to add the new vote
      if(in_array($items[0], $votstdy) || ($this->nrvot ===1 && count($votstdy) >0)) return json_encode([$items[0]=>['v_plus'=>0, 'v_minus'=>0, 'voted'=>3]]);
      else $this->setVotDb($items, $vote, $votstdy);  // add the new vote in mysql

      array_push($votstdy, $items[0]);  // adds curent item as voted
    }

    // if $nrvot is 1, and $votstdy has item, set $setvoted=1 (user already voted today)
    // else, user can vote multiple items, after Select is checked if already voted the existend $item
    $setvoted = ($this->nrvot === 1 && count($votstdy) > 0) ? 1 : 0;

    // get array with items and their votings
    $votitems = $this->getVotDb($items, $votstdy, $setvoted);

    return json_encode($votitems);
  }

  // insert /update rating item in #votitems, delete rows in $votusers which are not from today, insert $voter in $votusers
  protected function setVotDb($items, $vote, $votstdy){
    $v_plus = $vote>0 ?1 :0;
    $v_minus = $vote<0 ?1 :0;
    $this->conn->sqlExec("INSERT INTO `$this->votitems` (id, v_plus, v_minus) VALUES ('".$items[0]."', $v_plus, $v_minus) ON DUPLICATE KEY UPDATE v_plus=v_plus+$v_plus, v_minus=v_minus+$v_minus");

    $this->conn->sqlExec("DELETE FROM `$this->votusers` WHERE `nextv`<$this->time");

    $this->conn->sqlExec("INSERT INTO `$this->votusers` (`nextv`, `voter`, `item`) VALUES (". NEXTV .", '$this->voter', '".$items[0]."')");
  }

  // select 'vote' and 'nvotes' of each element in $items, $votstdy stores items voted by the user
  // returns array with item:['vote', 'nvotes', voted] for each element in $items array
  protected function getVotDb($items, $votstdy, $setvoted) {
    $re = array_fill_keys($items, ['v_plus'=>0, 'v_minus'=>0 ,'voted'=>$setvoted]);    // makes each value of $items as key with an array(0,0,0)

    function addSlhs($elm){return "'".$elm."'";}      // function to be used in array_map(), adds "'" to each $elm
    $resql = $this->conn->sqlExec("SELECT * FROM `$this->votitems` WHERE `id` IN(".implode(',', array_map('addSlhs', $items)).")");
    $num_rows = $this->conn->num_rows;
    if($num_rows >0){
      for($i=0; $i<$num_rows; $i++) {
        $voted = in_array($resql[$i]['id'], $votstdy) ? $setvoted +1 : $setvoted;  // add 1 if the item was voted by the user today
        $re[$resql[$i]['id']] = ['v_plus'=>$resql[$i]['v_plus'], 'v_minus'=>$resql[$i]['v_minus'], 'voted'=>$voted];
      }
    }

    return $re;
  }

  // returns from mysql an array with items voted by the user today
  protected function votstdyDb() {
    $votstdy =[];
    $resql = $this->conn->sqlExec("SELECT `item` FROM `$this->votusers` WHERE `nextv`>$this->time AND `voter`='$this->voter'");
    $num_rows = $this->conn->num_rows;
    if($num_rows >0) {
      for($i=0; $i<$num_rows; $i++) {
        $votstdy[] = $resql[$i]['item'];
      }
    }

    return $votstdy;
  }
}
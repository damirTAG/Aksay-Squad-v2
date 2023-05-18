<?php
// Script Voting - http://coursesweb.net/
class Voting {
  
  public $conn = false;  
  protected $voter ='';  
  protected $nrvot =0; 
  public $votitems ='votitems';  
  public $votusers ='votusers'; 
  protected $time; 

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

  
  public function getVoting($items, $vote ='') {
    $votstdy = $this->votstdyDb($items);

   
    if(!empty($vote)) {
     
      if($this->voter ==='') return "alert('Vote Not registered.\\nYou must be logged in to can vote')";

      
      if(in_array($items[0], $votstdy) || ($this->nrvot ===1 && count($votstdy) >0)) return json_encode([$items[0]=>['v_plus'=>0, 'v_minus'=>0, 'voted'=>3]]);
      else $this->setVotDb($items, $vote, $votstdy);  

      array_push($votstdy, $items[0]);  
    }

    
    $setvoted = ($this->nrvot === 1 && count($votstdy) > 0) ? 1 : 0;

    
    $votitems = $this->getVotDb($items, $votstdy, $setvoted);

    return json_encode($votitems);
  }

  
  protected function setVotDb($items, $vote, $votstdy){
    $v_plus = $vote>0 ?1 :0;
    $v_minus = $vote<0 ?1 :0;
    $this->conn->sqlExec("INSERT INTO `$this->votitems` (id, v_plus, v_minus) VALUES ('".$items[0]."', $v_plus, $v_minus) ON DUPLICATE KEY UPDATE v_plus=v_plus+$v_plus, v_minus=v_minus+$v_minus");

    $this->conn->sqlExec("DELETE FROM `$this->votusers` WHERE `nextv`<$this->time");

    $this->conn->sqlExec("INSERT INTO `$this->votusers` (`nextv`, `voter`, `item`) VALUES (". NEXTV .", '$this->voter', '".$items[0]."')");
  }

 
  protected function getVotDb($items, $votstdy, $setvoted) {
    $re = array_fill_keys($items, ['v_plus'=>0, 'v_minus'=>0 ,'voted'=>$setvoted]);    

    function addSlhs($elm){return "'".$elm."'";}      
    $resql = $this->conn->sqlExec("SELECT * FROM `$this->votitems` WHERE `id` IN(".implode(',', array_map('addSlhs', $items)).")");
    $num_rows = $this->conn->num_rows;
    if($num_rows >0){
      for($i=0; $i<$num_rows; $i++) {
        $voted = in_array($resql[$i]['id'], $votstdy) ? $setvoted +1 : $setvoted;  
        $re[$resql[$i]['id']] = ['v_plus'=>$resql[$i]['v_plus'], 'v_minus'=>$resql[$i]['v_minus'], 'voted'=>$voted];
      }
    }

    return $re;
  }

 
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

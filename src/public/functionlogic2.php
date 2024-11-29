<?php
echo "<b>5-6</b><br/>";
echo "課題１: 2月の支出<br/>";

class Database{
  //db info
  private $dbUserName = "root";
  private $dbPassword = "password";
  private $pdo;

  public function __construct(){
    $this->pdo = new PDO("mysql:host=mysql; dbname=tq_quest; charset=utf8", $this->dbUserName, $this->dbPassword);
  }

  public function getConnection() {
    return $this->pdo;
  }

}

class FebSpendings{
  private $pdo;
  private $select;
  private $statement;
  private $spendings;
  private $febspendings;


  public function __construct($pdo){
    $this->pdo = $pdo;
    //defined to select data from spendings table
    $this->select = "SELECT * FROM spendings";
    //prepare sql statement by using pdo()
    $this->statement = $this->pdo->prepare($this->select);
    //push query to DB and run the code
    $this->statement->execute();
    //fetch all datas form spendings table
    $this->spendings = $this->statement->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getFebSpendings(){
    foreach ($this->spendings as $spend) {
      $date = explode("-", $spend["accrual_date"]);
      $month = abs($date[1]);
      if($month == 2){
        echo $spend["name"] . ": " . $spend["amount"];
        echo "<br/>";
      }
    }
  }
}
$db = new Database();
$pdo = $db->getConnection();
$result = new FebSpendings($pdo);
$result->getFebSpendings();


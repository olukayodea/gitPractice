<php
class sample {
  //create random strings
  function createRandomPassword() { 
			$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890"; 
			srand((double)microtime()*1000000); 
			$i = 0; 
			$pass = '' ; 
			$count = strlen($chars);
			while ($i <= $len) { 
				$num = rand() % $count; 
				$tmp = substr($chars, $num, 1); 
				$pass = $pass . $tmp; 
				$i++; 
			} 
			return $pass; 
		}
    
    //confirm if the code created already exist
    //i will be using a database for this example
		function confirmUnique($key) {
			global $db;
			try {
        //this can be any database or array of data to check from
				$sql = $db->prepare("SELECT `ref` FROM `transactions` WHERE `transaction_id` = :key");
				$sql->execute(array(':key' => $key));
			} catch(PDOException $ex) {
				echo "An Error occured! ".$ex->getMessage(); //user friendly message
			}
			
			if ($sql->rowCount() == 0) {
				return $key;
			} else {
				return $this->confirmUnique($this->createRandomPassword());
			}
		}
}
$sample = new sample;
echo $sample->confirmUnique($sample->createRandomPassword());
?>

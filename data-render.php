<?php
include 'config.php';

$data = $alldata = json_decode(file_get_contents('./sales.json'));

// Get JSON file and decode contents into PHP arrays/values
$jsonFile = './sales.json';
$jsonData = json_decode(file_get_contents($jsonFile), true);
$tableqry = 'CREATE TABLE IF NOT EXISTS `sales` (
  `id` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `sale_id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_mail` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` float NOT NULL,
  `sale_date` date NOT NULL
)';
mysqli_query($con, $tableqry);
print_r(mysqli_error($con));
// Iterate through JSON and build INSERT statements
foreach ($jsonData as $id=>$row) {
    $insertPairs = array();
    foreach ($row as $key=>$val) {
        $insertPairs[addslashes($key)] = addslashes($val);
    }
    $insertKeys = '`' . implode('`,`', array_keys($insertPairs)) . '`';
    $insertVals = '"' . implode('","', array_values($insertPairs)) . '"';
 
    ## Fetch records
    $saleQuery = "INSERT INTO `sales` ({$insertKeys}) VALUES ({$insertVals});";
    $saleRecords = mysqli_query($con, $saleQuery);

} 
if($saleRecords){
    echo "Data imported successfully!<br>";
    echo "<a href='./'>Go Back</a>";
}

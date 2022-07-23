<?php 
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$link = mysqli_connect("localhost", "voseji", "2wsxzaQ1!s", "jamiya");
// Check connection
if($link === false){
die("ERROR: Could not connect. " . mysqli_connect_error());
}
$email=$_GET['email'];
$qid=$_GET['QuizId'];

$sql="SELECT DISTINCT jamiya.zcmrq_ariquizstatistics.StatisticsInfoId, zcmrq_ariquizstatisticsinfo.UserId, zcmrq_users.name, zcmrq_users.username, zcmrq_users.email, zcmrq_ariquiz.QuizName, zcmrq_ariquizstatisticsinfo.MaxScore, SUM(jamiya.zcmrq_ariquizstatistics.Score) as Score2 FROM jamiya.zcmrq_ariquizstatisticsinfo
                JOIN jamiya.zcmrq_ariquizstatistics ON jamiya.zcmrq_ariquizstatistics.StatisticsInfoId=jamiya.zcmrq_ariquizstatisticsinfo.StatisticsInfoId
                JOIN jamiya.zcmrq_users ON jamiya.zcmrq_ariquizstatisticsinfo.UserId=jamiya.zcmrq_users.id
                JOIN jamiya.zcmrq_ariquiz ON jamiya.zcmrq_ariquizstatisticsinfo.QuizId=jamiya.zcmrq_ariquiz.QuizId
                WHERE jamiya.zcmrq_ariquizstatisticsinfo.QuizId='".$qid."'
                
                GROUP BY zcmrq_ariquizstatistics.StatisticsInfoId
                
                ";


$result = $link->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    // echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";

$username=$row['username'];
$name=$row['name'];
$subject=$row['QuizName'];
// $id=$row['id'];
$html = "
<table border='1' width='100%' style='border-collapse: collapse;'>
<tr>
<td><img src='http://localhost/var/www/html/var/cbt/Blooms_Logo.jpeg' /></td>
</tr>        
<tr>
        <td>Student ID</td><td>$username</td>
        </tr>
        <tr>
        <td>Student Name</td><td>$name</td>
        </tr>
        <tr>
        <td>Test Name</td><td>$subject</td>
        </tr>
        </table>
        
        ";
    }
} else {
  echo "0 results";
}
$link->close();
// include autoloader
require_once 'dompdf/autoload.inc.php';

// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();

$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

$output = $dompdf->output();
$filename="{$username}{$qid}.pdf";
// $dir = __DIR__ . "/results"; 
file_put_contents("results/"."$filename", $output);
// echo $aa;
?>
<?php
include_once ("./socketlabs-php-main/InjectionApi/src/includes.php");
//or if using composer: include_once ('./vendor/autoload.php');

use Socketlabs\SocketLabsClient;
use Socketlabs\Message\BasicMessage;
use Socketlabs\Message\EmailAddress;

$serverId = 36540;
$injectionApiKey = "Sp85Ngd6DGo7x3XBj9b4";

$client = new SocketLabsClient($serverId, $injectionApiKey);
// $email=$_GET['email'];
$message = new BasicMessage();

$message->subject = "Blooms Academy Abuja - Student Assessment Result";
$message->htmlBody = "<html>Please find result for your child/ward $name below.</html>";
$message->plainTextBody = "This is the Plain Text Body of my message.";

$message->from = new EmailAddress("vctroseji@gmail.com");
$message->addToAddress($email);
$att = \Socketlabs\Message\Attachment::createFromPath( "results/"."/$filename");
$message->attachments[] = $att;
$response = $client->send($message);

echo "A PDF version of this result has been successfully sent!<a href='#'> Click Her To Go Back To Previous Page</a>"

?>
<?php
// $zz= "results/$filename";
// $unlink("results/"."$zz");
$dir="results";
unlink($dir.'/'.$filename);
?>
<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "jamiya";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$score=$_GET['s'];
$sid=$_GET['sid'];
$fullname=$_GET['fullname'];
$subject=$_GET['subject'];
$qid=$_GET['QuizId'];
$username=$_GET['username'];


$htm="<h4>Student Name:&nbsp;".$fullname."</h4>
<h4>Student ID:&nbsp;".$username."</h4>
<h4>Subject:&nbsp;".$subject."</h4>
<h4>Score:&nbsp;".$score."</h4>"
;

$sql = "SELECT DISTINCTROW zcmrq_ariquizquestionversion.Question, zcmrq_ariquizquestionversion.Data as Data, zcmrq_ariquizstatistics.StatisticsId, zcmrq_ariquizstatisticsinfo.UserId FROM zcmrq_ariquizstatistics 
JOIN zcmrq_ariquizquestionversion ON zcmrq_ariquizquestionversion.QuestionId=zcmrq_ariquizstatistics.QuestionId
JOIN zcmrq_ariquizstatisticsinfo ON zcmrq_ariquizstatistics.StatisticsInfoId=zcmrq_ariquizstatisticsinfo.StatisticsInfoId
WHERE zcmrq_ariquizstatistics.StatisticsInfoId='".$sid."'";
$result = $conn->query($sql);

$i="1";
$numbring="1";
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
    $que=$row["Question"];
    $data=$row["Data"];
    
$xml = $data;

$dom = new \DOMDocument('1.0');
$dom->preserveWhiteSpace = false;
$dom->formatOutput = true;
$dom->loadXML($xml);
$xml_pretty = $dom->saveXML();

$xml_data = simplexml_load_string($xml) or 
die("Error: Object Creation failure");
$opt=A;

$html2 .=

"<p>".$i++.".&nbsp;".$que."</p>";
foreach ($xml_data->children() as $data2)
{
//$oop .=$data2;

"<p>".$opt."&nbsp;".$data2."</p>";
}


      
    }
} else {
    echo "0 results";
}







$conn->close();
// include autoloader
require_once 'dompdf/autoload.inc.php';

// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();
$band="{$htm}{$html2}";
$dompdf->loadHtml($band);

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
 $email=$_GET['email'];
$message = new BasicMessage();

$message->subject = "Blooms Academy Abuja - Student Assessment Result";
$message->htmlBody = "<html>Please find result for your child/ward $name below.</html>";
$message->plainTextBody = "This is the Plain Text Body of my message.";

$message->from = new EmailAddress("info@bloomsacademy.com");
$message->addToAddress($email);
$att = \Socketlabs\Message\Attachment::createFromPath( "results/"."/$filename");
$message->attachments[] = $att;
$response = $client->send($message);

echo "<p><img src='images/Blooms_Logo.jpg' width='10%'/></p>";
echo "<p>A PDF version of this result has been successfully sent to: $email, the official email address of $fullname's parents/guardians.<a href='rez.php'> <br/>Click Her To Go Back To Previous Page</a></p>"

?>
<?php
// $zz= "results/$filename";
// $unlink("results/"."$zz");
$dir="results";
unlink($dir.'/'.$filename);
?>
<?php
$sql4 = "UPDATE jamiya.zcmrq_ariquizstatisticsinfo SET emailed='1' WHERE WHERE jamiya.zcmrq_ariquizstatisticsinfo.QuizId='".$qid."'";

if ($conn->query($sql4) === TRUE) {
//   echo "Record updated successfully";
} else {
//   echo "Error updating record: " . $conn->error;
}
?>

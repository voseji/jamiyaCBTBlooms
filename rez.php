
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.1.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.html5.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">


<?php
                /* Attempt MySQL server connection. Assuming you are running MySQL
                server with default setting (user 'root' with no password) */
                $link = mysqli_connect("localhost", "root", "root", "jamiya");
                // Check connection
                if($link === false){
                die("ERROR: Could not connect. " . mysqli_connect_error());
                }

                $i=1;
                
                $a=$_POST['QuizId'];
                $sql="SELECT DISTINCT jamiya.zcmrq_ariquizstatistics.StatisticsInfoId, zcmrq_ariquizstatisticsinfo.UserId, zcmrq_users.name, zcmrq_users.username, zcmrq_ariquiz.QuizName, zcmrq_ariquizstatisticsinfo.MaxScore, SUM(jamiya.zcmrq_ariquizstatistics.Score) as Score2 FROM jamiya.zcmrq_ariquizstatisticsinfo
                JOIN jamiya.zcmrq_ariquizstatistics ON jamiya.zcmrq_ariquizstatistics.StatisticsInfoId=jamiya.zcmrq_ariquizstatisticsinfo.StatisticsInfoId
                JOIN jamiya.zcmrq_users ON jamiya.zcmrq_ariquizstatisticsinfo.UserId=jamiya.zcmrq_users.id
                JOIN jamiya.zcmrq_ariquiz ON jamiya.zcmrq_ariquizstatisticsinfo.QuizId=jamiya.zcmrq_ariquiz.QuizId
                WHERE jamiya.zcmrq_ariquizstatisticsinfo.QuizId='".$a."'
                
                GROUP BY zcmrq_ariquizstatistics.StatisticsInfoId
                
                ";

                // $sql="select DISTINCT jamiya.zcmrq_ariquizstatistics.StatisticsInfoId, SUM(jamiya.zcmrq_ariquizstatistics.Score) as Score2 from jamiya.zcmrq_ariquizstatistics WHERE StatisticsinfoId='".$a."'";
                if($result = mysqli_query($link, $sql)){
                if(mysqli_num_rows($result) > 0){
                    
$sql2 = "SELECT * FROM zcmrq_ariquiz WHERE QuizId='".$a."'";
$result2=mysqli_query($link,$sql2);
$row2=mysqli_fetch_assoc($result2);
$QuizName=$row2["QuizName"];


                    
									echo "<div class='table-wrap mt-40'>";
									echo  "<div class='table-responsive example-print'><br/>";
                                    echo "<h3 align='center'>Subject: ".$QuizName."</h3>";
									echo "<table border='1' id='example2' style='border-collapse:collapse;' align='center' width='50%' class='table table-striped table-bordered mb-0'>";
									echo "<thead>";
                                    echo "<tr>";
									echo "<th>&nbsp;&nbsp;SN</th>";
                                    echo "<th>&nbsp;&nbsp;REGISTRATION NUMBER</th>";
                                    echo "<th>&nbsp;&nbsp;STUDENT NAME</th>";
                                   echo "<th>&nbsp;&nbsp;SCORE</th>";
								
                                   echo "</tr>";
                                   echo "</thead>";
									while($row = mysqli_fetch_array($result)){
                                        //include "count_one_sale.php";
                                      
                                      //if ($row['payment_status']=='1') { $stat2= "<b style='color:green'>PAID</b>";} else if ($row['payment_status']=='0') { $stat2= "<b style='color:red'>UNPAID</b>";}     
                                     
										
									echo "<tr>";
									echo "<td>  &nbsp;&nbsp;" .$i++."</td>";
                                    echo "<td>  &nbsp;&nbsp;" .$row['username']."</td>";
                                    echo "<td>  &nbsp;&nbsp;" .$row['name']."</td>";
                                    echo "<td>  &nbsp;&nbsp;<b>" .$row['Score2']."</b>/".$row['MaxScore']."</td>";
								    echo "</tr>";
								}
		
								echo "</table>";



                echo "</div>";
              echo "</div>";
                // Free result set
                mysqli_free_result($result);
                }
                else{
                echo "No records matching your query were found.";
                }
                } else{
                echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                }
                // Close connection

                mysqli_close($link);

                ?>        <script>
$(document).ready(function() {
    $('#example2').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]
    } );
} );
</script>

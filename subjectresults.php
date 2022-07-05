<?php
$con=mysqli_connect("localhost","root","root","jamiya");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
?>
<h2 align="center">Blooms Academy <br/>CBT Result Exporter</h2>
<table border='1' align='center' width='80%' style="border-collapse:collapse;" class='table table-striped table-bordered mb-0'>
                    <form method="post" action="rez.php">
                        
                        
                   
                    <input class="form-control" value="<?php echo $loc_name ?>" type="hidden" name="loc_name"/>
                        
                       <tr>
                        <td>
                   <label>Subject Selector:</label>
                    </td>
                            <td colspan="2">
<select class="form-control" name="QuizId">
    <?php $result = mysqli_query($con,"SELECT * FROM jamiya.zcmrq_ariquiz ORDER BY zcmrq_ariquiz.QuizName asc");
 while($row = mysqli_fetch_array($result)) 
   echo "<option value='" . $row['QuizId'] . "'>" .$row['QuizName'] ." </option>";
 ?> 
								</select>
						   </td>

						</tr>
                       
  <tr>
      <td></td>
 <td colspan="0" align="left">
                             <input class="form-control" type="submit" value="Load Exam Result" style="background-color:green !important; color:white; width:30%"/>
                            </td>
                        </tr>
                        
                    
                      </form> 
                    </table>

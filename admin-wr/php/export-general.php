<?php 
    include "config.php";
    error_reporting(0);
    // query 
    $querywr="SELECT *,month_attended.employee_id as id, employee.name as name, SEC_TO_TIME(month_attended.totaltime) as totaltime, SEC_TO_TIME(month_attended.overtime) as overtime, month_attended.attended as attended FROM month_attended INNER JOIN employee ON month_attended.employee_id=employee.id WHERE month_attended.date = '".date("Y-m-1",mktime(0,0,0,$_GET['month'],1,$_GET['year']))."'";

    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename= Working Report ".date("F Y",mktime(0,0,0,$_GET['month'],1,$_GET['year'])).".xls");
?>
<html>
    <body>
        <h3>General Working Report Data <?php echo date("F Y",mktime(0,0,0,$_GET['month'],1,$_GET['year'])); ?> </h3>
        <table border="1">
            <tr>
                <th>Employee ID</th>
                <th>Employee Name</th>
                <th>TotalTime</th>
                <th>OverTime</th>
                <th>Total Attend</th>
                <th>Customer Name</th>
                <th>Project Name</th>
                <th>WO Number</th>
            </tr>
            <?php
            $query=mysqli_query($conn,$querywr);
            while ($result = mysqli_fetch_array($query)) { ?>
            <tr>    
                <td><?php echo $result['id']; ?></td>
                <td><?php echo $result['name']; ?></td>
                <td style="background-color:#FFFCCC"><?php echo $result['totaltime']; ?></td>
                <td style="background-color:#FFFCCC"><?php echo $result['overtime']; ?></td>
                <td style="background-color:#FFFCCC"><?php echo $result['attended']; ?></a></td>
                <td><?php echo $result['customer_name']; ?></td>
                <td><?php echo $result['project_name']; ?></td>
                <td><?php echo $result['wo_number']; ?></td>
            </tr>
            <?php } ?>
        </table>
    </body>
</html>
<?php
    /*
        purpose: frontend to view sales
    */
    session_start();
    if (empty($_SESSION['id']) || $_SESSION['role'] != "Management"){
        header("location:index.php");
        exit;
    }
    require_once "../database/connect_db.php";
    require_once "generate_report.php";
?>
<!doctype html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sales Record</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

        <!-- custom -->
        <link href="leftmenu.css" rel="stylesheet">
        <link rel="stylesheet" href="template_style.css">

        <!-- chart -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.1.2/chart.min.js" integrity="sha512-fYE9wAJg2PYbpJPxyGcuzDSiMuWJiw58rKa9MWQICkAqEO+xeJ5hg5qPihF8kqa7tbgJxsmgY0Yp51+IMrSEVg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <!-- datepicker -->
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

        <!-- font awesome v5 -->
        <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc" crossorigin="anonymous"></script>
        
        <style>
            .input-group-append {
                cursor: pointer;
            }
        </style>
    </head>
    <body>
        <!-- navigation -->
        <?php include("leftmenu.php"); ?>

        <div class="content">
            <header><h2>Product Sales</h2></header>
            <!-- get duration -->
            <section>
                <h4>Duration</h4>
                <div class="card bg-light"><div class="card-body">
                    <form action="monitorsales.php" method="post" class="row">
                        <label for="date" class="col-1 col-form-label">From</label>
                        <div class="col-3">
                            <div class="input-group date" id="date">
                                <input type="text" class="form-control" id="fromdate" name="fromdate" required>
                                <span class="input-group-append"><span class="input-group-text bg-light d-block"><i class="far fa-calendar-alt"></i></span></span>
                            </div>
                        </div>
                        <label for="date" class="col-1 col-form-label">To</label>
                        <div class="col-3">
                            <div class="input-group date" id="date">
                                <input type="text" class="form-control" id="todate" name="todate" disabled>
                                <span class="input-group-append"><span class="input-group-text bg-light d-block"><i class="far fa-calendar-alt"></i></span></span>
                            </div>
                        </div>
                        <input type="submit" class="btn btn-dark col-md-1" name="get_date" value="Submit" hidden>
                    </form>
                </div></div>
            </section>
            <!-- show report -->
            <?php if(!empty($sales)):
                    echo "<section class='mt-3'>";
                    echo "    <h3 class='page-header text-center'>Sales Quantity </h3>";
                    if(!empty($startdate)):
                        echo "<center><h5>From ".$startdate." to ".$enddate."</h5></center>";
                    endif;
                    echo "    <canvas id='chartjs_bar' height='150'></canvas>";
                    echo "</section>";
                endif;
                if(!empty($subtotal)):
                    echo "<section class='mt-3'>";
                    echo "    <h3 class='page-header text-center'>Sales Amount</h3>";
                    if(!empty($startdate)):
                        echo "<center><h5>From ".$startdate." to ".$enddate."</h5></center>";
                    endif;
                    echo "    <canvas id='amount_bar' height='150'></canvas>";
                    echo "</section>";
                endif;
            ?>                       
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    </body>
</html>
<script>
    $(document).ready(function(){
        $('#fromdate').datepicker({
            onSelect: function(date) { 
                $("#todate").prop("disabled",false);
                $("#todate").datepicker('option','minDate',date); 
            },
            dateFormat: 'yy-mm-dd'
        });
        $('#todate').datepicker({
            onSelect: function(date) {  
                $(".btn-dark").prop("hidden",false); 
                $(".btn-dark").prop("required",true); 
            },
            dateFormat: 'yy-mm-dd'     
        });
    });
    var ctx = document.getElementById("chartjs_bar");
    var ctx1 = document.getElementById("amount_bar");

    var config = {
        type:'bar',
        data:{
            labels: <?= json_encode($productname);?>,
            datasets: [
                {
                label: '',
                data: <?= json_encode($sales);?>,
                backgroundColor: <?= json_encode($bgcolor); ?>
                }
            ]
        },
        options:{
            legend: {display: false}
        }
    }
    // daily sales
    var config1 = {
        type:'line',
        data:{
            labels: <?= json_encode($productname_sales);?>,
            datasets: [
                {
                label: '',
                data: <?= json_encode($subtotal);?> ,
                backgroundColor: <?= json_encode($bgcolor); ?>
                }
            ]
        },
        options:{
            legend: {display: false},
            scales:{
                yAxes:[{
                    ticks:{
                        beginAtZero: true
                    }
                }]
            }
        }
    }
    var quantitychart = new Chart(ctx,config);
    var amountchart = new Chart(ctx1,config1);
</script>
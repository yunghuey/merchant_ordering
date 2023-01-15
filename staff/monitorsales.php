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
            <header><h2>Report</h2></header>
            <!-- overall chart -->
            <section class="card m-3">
                <h4 class="card-header p-3"><strong>Overall Sales</strong></h4>
                <div class="card-body">    
                    <div class="card-text">
                        <h5>Duration</h5>
                        <p>Select duration to view the selected result of total quantity sold and total sales amount</p>
                    </div>
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
                        <input type="submit" class="btn btn-dark btn-dark1 col-md-1" name="get_date" value="Submit" hidden>
                        </form>
                    </div></div>
                    <?php 
                    if(!empty($sales)):
                        echo "<section class='mt-5'>";
                        echo "    <h5 class='page-header text-center'>Sales Quantity </h5>";
                        if(!empty($overall_startdate)):
                            echo "<center><h5>From ".$overall_startdate." to ".$overall_enddate."</h5></center>";
                        endif;
                        echo "    <div style='position: relative; height:70vh;'><canvas id='chartjs_bar' height='150'></canvas></div>";
                        echo "</section>";
                    endif;
                    if(!empty($subtotal)):
                        echo "<section class='mt-5'>";
                        echo "    <h5 class='page-header text-center'>Sales Amount</h5>";
                        if(!empty($overall_startdate)):
                            echo "<center><h5>From ".$overall_startdate." to ".$overall_enddate."</h5></center>";
                        endif;
                        echo "    <div style='position: relative; height:60vh;'><canvas id='amount_bar'></canvas></div>";
                        echo "</section>";
                    endif;
                    ?>                    
                </div> 
            </section>

            <!-- product chart -->
            <section class="card m-3">
                <h4 class="card-header p-3"><strong>Product Sales</strong></h4>
                <div class="card-body">
                    <form action="monitorsales.php" method="post">
                        <div class="card-text row">
                            <h5 class="col-2">Category</h5>
                            <div class="col-3">
                                <select class="form-select" name="category">
                                    <option value="" selected>All</option>
                                    <option value="butter" <?php if($product_category == 'butter') echo 'selected' ?>>Butter</option>
                                    <option value="milk" <?php if($product_category == 'milk') echo 'selected' ?>>Milk</option>
                                    <option value="cheese" <?php if($product_category == 'cheese') echo 'selected' ?>>Cheese</option>
                                    <option value="yogurt" <?php if($product_category == 'yogurt') echo 'selected' ?>>Yogurt</option>
                                </select>
                            </div>
                        </div>
                        <div class="card bg-light"><div class="card-body row">
                        <label for="date" class="col-1 col-form-label">From</label>
                        <div class="col-3">
                            <div class="input-group date" id="date">
                                <input type="text" class="form-control" id="fromdate_rank" name="fromdate_rank" >
                                <span class="input-group-append"><span class="input-group-text bg-light d-block"><i class="far fa-calendar-alt"></i></span></span>
                            </div>
                        </div>
                        <label for="date" class="col-1 col-form-label">To</label>
                        <div class="col-3">
                            <div class="input-group date" id="date">
                                <input type="text" class="form-control" id="todate_rank" name="todate_rank" disabled>
                                <span class="input-group-append"><span class="input-group-text bg-light d-block"><i class="far fa-calendar-alt"></i></span></span>
                            </div>
                        </div>
                        <input type="submit" class="btn btn-dark btn-dark2 col-md-1" name="get_ranking" value="Submit" >
                    </div></div>
                        
                    </form>
                    <?php 
                        if(!empty($ranking_enddate)):
                            echo "<center><h5>From ".$ranking_startdate." to ".$ranking_enddate."</h5></center>";
                        elseif(!empty($productCategory)):
                            echo "<center><h5>For ".$productCategory." category</h5></center>";
                        endif;

                        echo "<div class='row mt-3'>";
                        if(!empty($top_productname)):
                        echo "  <div class='col-6'>";
                        echo "      <h5 class='page-header text-center '>Top 4 Product</h5>";
                        echo "      <canvas id='top_ranking' width='600' height='450'></canvas>";
                        echo "  </div>";
                        endif;

                        if(!empty($last_productname)):
                            echo "  <div class='col-6'>";
                            echo "    <h5 class='page-header text-center'>Last 4 Product</h5>";
                            echo "    <canvas id='last_ranking' width='600' height='450'></canvas>";
                            echo "  </div>";
                        endif;
                        echo "</div>";
                    ?> 
                </div>
            </section>

            <!-- yearly sales chart -->
            <section class="card m-3">
                <h4 class="card-header p-3"><strong>Monthly Product Sales</strong></h4>
                <div class="card-body">
                    <?php if(!empty($year_ringgit)):
                        echo "<section class='mt-3'>";
                        echo "    <div style='position: relative; height:60vh;'><canvas id='year_sales'></canvas></div>";
                        echo "</section>";
                    endif; ?>       
                </div>
            </section>
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
        $('#fromdate_rank').datepicker({
            onSelect: function(date) { 
                $("#todate_rank").prop("disabled",false);
                $("#todate_rank").datepicker('option','minDate',date); 
            },
            dateFormat: 'yy-mm-dd'
        });
        $('#todate').datepicker({
            onSelect: function(date) {  
                $(".btn-dark1").prop("hidden",false); 
                $(".btn-dark1").prop("required",true); 
            },
            dateFormat: 'yy-mm-dd'     
        });
        $('#todate_rank').datepicker({
            dateFormat: 'yy-mm-dd'     
        });
    });
    var ctx1 = document.getElementById("chartjs_bar");
    var ctx2 = document.getElementById("amount_bar");
    var ctx3 = document.getElementById("top_ranking");
    var ctx4 = document.getElementById("last_ranking");
    var ctx5 = document.getElementById("year_sales");

    var qty_config = {
        type:'bar',
        data:{
            labels: <?= json_encode($productname);?>,
            datasets: [
                {
                label: 'Total quantity',
                data: <?= json_encode($sales);?>,
                backgroundColor: <?= json_encode($bgcolor); ?>
                }
            ]
        },
        options:{
            plugins:{
                legend: {display: false}
            },
            scales:{
                y:{
                    beginAtZero:true,
                    ticks:{
                        stepSize: 5
                    },
                    title:{
                        display:true,
                        text: "Total quantity (unit)"
                    }
                },
                x:{
                    title: {
                        display:true,
                        text: "Product Name"
                    }
                }
            }
        }
    }

    var sales_config = {
        type:'line',
        data:{
            labels: <?= json_encode($productname_sales);?>,
            datasets: [
                {
                label: 'Amount of sales in RM',
                data: <?= json_encode($subtotal);?> ,
                backgroundColor: <?= json_encode($bgcolor); ?>
                }
            ]
        },
        options:{
            plugins:{
                legend: {display: false}
            },    
            scales:{
                y:{
                    beginAtZero:true,
                    ticks:{
                        stepSize: 15,
                        callback:function(value, index, ticks) { return value+'.00'; },
                    },
                    title:{
                        display:true,
                        text: "Total sales amount (RM)"
                    }
                },
                x:{
                    title: {
                        display:true,
                        text: "Date"
                    }
                }
            }
        }
    }

    var top_rank_config = {
        type:'pie',
        data:{
            labels: <?= json_encode($top_productname);?>,
            datasets: [
                {
                label: 'Total quantity',
                data: <?= json_encode($top_qty);?>,
                backgroundColor: <?= json_encode($rank_bgcolor); ?>
                }
            ]
        },
        options:{
            responsive: false,
            plugins:{
                legend: {display: true, position:'right'}
            }
        }
    }

    var last_rank_config = {
        type:'pie',
        data:{
            labels: <?= json_encode($last_productname);?>,
            datasets: [
                {
                label: 'Total quantity',
                data: <?= json_encode($last_qty);?>,
                backgroundColor: <?= json_encode($rank_bgcolor); ?>
                }
            ]
        },
        options:{
            responsive: false,
            plugins:{
                legend: {display: true, position:'right'}
            }
        }
    }

    var year_sales_config = {
        type:'line',
        data:{
            labels: <?= json_encode($year_month);?>,
            datasets: [
                {
                label: 'Amount of sales in RM',
                data: <?= json_encode($year_ringgit);?> ,
                backgroundColor: <?= json_encode($bgcolor_year); ?>
                }
            ]
        },
        options:{
            plugins:{
                legend: {display: false}
            },    
            scales:{
                y:{
                    beginAtZero:true,
                    ticks:{
                        stepSize: 20,
                        callback:function(value, index, ticks) { return value+'.00'; },
                    },
                    title:{
                        display:true,
                        text: "Total sales amount (RM)"
                    }
                },
                x:{
                    title: {
                        display:true,
                        text: "Month"
                    }
                }
            }
        }
    }
    Chart.defaults.font.size = 15;
    var chart1 = new Chart(ctx1,qty_config);
    var chart2 = new Chart(ctx2,sales_config);
    var chart3 = new Chart(ctx3,top_rank_config);
    var chart4 = new Chart(ctx4,last_rank_config);
    var chart5 = new Chart(ctx5,year_sales_config);
</script>
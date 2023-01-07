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
    require "generate_report.php";
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
        <script src="//code.jquery.com/jquery-1.9.1.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>

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

        <?php 
           
        ?>
        <div class="content">
            <header><h2>Product Sales</h2></header>
            <section>
                <!-- get duration -->
                <h4>Duration</h4>
                <div class="card bg-light"><div class="card-body">
                    <form action="monitorsales.php" method="post" class="row">
                        <label for="date" class="col-1 col-form-label">From</label>
                        <div class="col-3">
                            <div class="input-group date" id="date">
                                <input type="text" class="form-control" id="fromdate" name="fromdate">
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
                        <input type="submit" class="btn btn-dark col-md-1" name="get_date">
                    </form>
                </div></div>
            </section>

            <h3>From <?= $startdate; ?></h3>
            <h3>To <?= $enddate; ?></h3>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    </body>
</html>
<script>
    $(document).ready(function(){
        var start_date;
        $('#fromdate').datepicker({
            onSelect: function(date) { 
                $("#todate").prop("disabled",false);
                $("#todate").datepicker('option','minDate',date);                                        },
            dateFormat: 'yy-mm-dd'
        });
        $('#todate').datepicker({
            dateFormat: 'yy-mm-dd'
        });
    });
</script>
<?php
    /*
        purpose: frontend report regarding staff
    */
    session_start();
    if($_SESSION['role'] != "Management" && $_SESSION['role'] != "Admin"){
        header("location:index.php");
        exit;
    }
    require_once "generate_report.php";
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Staff Report</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        
        <!-- custom -->
        <link href="leftmenu.css" rel="stylesheet">
        <link rel="stylesheet" href="template_style.css">
        
        <!-- chart -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.1.2/chart.min.js" integrity="sha512-fYE9wAJg2PYbpJPxyGcuzDSiMuWJiw58rKa9MWQICkAqEO+xeJ5hg5qPihF8kqa7tbgJxsmgY0Yp51+IMrSEVg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <!-- font awesome v5 -->
        <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc" crossorigin="anonymous"></script>
    </head>
    <body>
        <!-- navigation -->
        <?php include("leftmenu.php"); ?>
        <div class="content">
            <header><h2>Staff Summary</h2></header>
            <section class="card-group">
                <div class="card col-3 m-3">
                    <div class="card-header"><strong>Total number of staff</strong></div>
                    <div class="card-body">
                        <?= $totalstaff ?>
                    </div>
                </div>
                <div class="card col-3 m-3">
                    <div class="card-header"><strong>Department available</strong></div>
                    <div class="card-body">
                        <?php 
                            foreach ($role_list as $role)
                                echo $role."<br>";
                        ?>
                    </div>
                </div>
            </section>
            
            <!-- gender -->
                <div class="card m-3">
                    <h4 class="card-header p-3"><strong>Staff Gender Summary</strong></h4>
                    <div class="card-body">
                        <?php if(!empty($gender_label)):
                            echo "<section class='mt-3'>";
                            echo "    <div style='position: relative; height: 60vh;'><canvas id='gender_chart'></canvas></div>";
                            echo "</section>";
                        endif; ?>       
                    </div>
                </div>
                <div class="card m-3">
                    <h4 class="card-header p-3"><strong>Staff in department</strong></h4>
                    <div class="card-body">
                        <?php if(!empty($role_label)):
                            echo "<section class='mt-3'>";
                            echo "    <div style='position: relative; height: 60vh;'><canvas id='role_chart'></canvas></div>";
                            echo "</section>";
                        endif; ?>       
                    </div>
                </div>            
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    </body>
</html>
<script>
    var ctx1 = document.getElementById("gender_chart");
    var ctx2 = document.getElementById("role_chart");

    var gender_config = {
        type:'bar',
        data:{
            labels: <?= json_encode($gender_label);?>,
            datasets: [
                {
                label: 'Total person',
                data: <?= json_encode($gender_list);?>,
                backgroundColor: <?= json_encode($bgcolor); ?>
                }
            ]
        },
        options:{
            plugins:{
                legend: {
                    display: false
                }
            },
            scales:{
                y:{
                    beginAtZero:true,
                    ticks:{
                        stepSize: 2
                    },
                    title:{
                        display:true,
                        text: "Total quantity (person)"
                    }
                },
                x:{
                    title: {
                        display:true,
                        text: "Gender"
                    }
                }
            }
        }
    }
    var dept_config = {
        type:'bar',
        data:{
            labels: <?= json_encode($role_label);?>,
            datasets: [
                {
                label: 'Total person',
                data: <?= json_encode($role_data);?>,
                backgroundColor: <?= json_encode($role_bgcolor); ?>
                }
            ]
        },
        options:{
            plugins:{
                legend: {
                    display: false
                }
            },
            scales:{
                y:{
                    beginAtZero:true,
                    ticks:{
                        stepSize: 2
                    },
                    title:{
                        display:true,
                        text: "Total quantity (person)"
                    }
                },
                x:{
                    title: {
                        display:true,
                        text: "Department"
                    }
                }
            }
        }
    }

    Chart.defaults.font.size = 15;
    var chart1 = new Chart(ctx1,gender_config);
    var chart2 = new Chart(ctx2,dept_config);
</script>
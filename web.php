<?php
    //ket noi
    include("config.php");
    //doc du lieu
    $SampR = $_POST["rate"];
    $Digital = $_POST["dlpf"];
    $ACC = $_POST["AccFS"];
    $Gyro = $_POST["GFS"];
    $Int = $_POST["INT"];

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        //gui xuong database
        $sql = "update thietlap set Sample=$SampR,DLPF=$Digital,Accelorometer=$ACC,Gyroscope=$Gyro,Interrupt=$Int";
        //$sql = "insert into thuthap(Sample,DLPF,Accelorometer,Gyroscope,Interrupt) values ($SampR,$Digital,$ACC,$Gyro,$Int);";
        mysqli_query($conn,$sql);
        mysqli_close($conn); 
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CONTROL MPU6050</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
	<style>
        body{ font: 15px sans-serif; }
        .wrapper{ float: left; width: 35%; padding: 20px; margin: 20px; height: 900px;}
		.box{ margin: auto; width: 60%; height: 70%;}
		.table_size{margin: auto; width: 70%;}
        .kichthuoc{width: 85%; padding: 1%; height: 20%;}
        .nutnhan{width: 100px}
        .wrapper2{position: absolute; bottom:90px; right:550px;text-align: right;}
    </style>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css">
    <style>
        body{ font: 15px sans-serif; }
        .wrapper1{ float: right; width: 60%; padding: 20px; margin: 20px; height: 600px; }
        .xuatgtr{ width: 200%; padding: 20px; margin: 20px; height: 60%; }
        .box1{ margin: auto; width: 90%;}
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.2.0/chart.min.js"> </script>
</head>
<body>
    <div class="wrapper border border-2 rounded border-primary">
        <h3 style="color: green;"><b> SETTING MPU6050 </b></h3>
        <br>
        <img src="https://blog.mecsu.vn/wp-content/uploads/2022/02/mo-dun-gia-toc-ke-mpu6050-va-con-quay-hoi-chuyen-2.png" width="420" height="300">
        <br>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"  method="POST">
            <div class="form-group kichthuoc">
                <h6>
                    <label class="form-label"><b>Sample Rate (Hz) :</b></label> 
                    <input type="text" name="rate" id="sample_rate" class="form-control">
                </h6>
            </div>
            <div class="mb-3 kichthuoc">
                <h6><label class="form-label"><b>Digital Low Pass Filter : </b></label>
                    <select aria-label="Default select example" id="DLPF" class="form-select" name="dlpf">
                        <option selected>Choose mode DLPF</option>
                        <option value="260">260 HZ</option>
                        <option value="184">184 HZ</option>
                        <option value="94">94 HZ</option>
                        <option value="44">44 HZ</option>
                        <option value="21">21 HZ</option>
                        <option value="10">10 HZ</option>   
                        <option value="5">5 HZ</option>
                        <option value="3">RESERVED</option>
                    </select>
                </h6>
            </div>
            <div class="mb-3 kichthuoc">
                <h6>
                    <label class="form-label"><b> Accelorometer Full Scale : </b></label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-label" type="radio" id="Acc1" name="AccFS" value="2">
                        <label class="form-check-label" for=""Acc1>+-2g</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-label" type="radio" id="Acc2" name="AccFS" value="4">
                        <label class="form-check-label" for=""Acc1>+-4g</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-label" type="radio" id="Acc3" name="AccFS" value="8">
                        <label class="form-check-label" for=""Acc1>+-8g</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-label" type="radio" id="Acc4" name="AccFS" value="16">
                        <label class="form-check-label" for=""Acc1>+-16g</label>
                    </div>
                </h6>
            </div>
            <div class="mb-3 kichthuoc">
                <h6>
                    <label class="form-label"><b>Gyroscope Full Scale : </b></label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-label" type="radio" id="GF1" name="GFS" value="250">
                        <label class="form-check-label" for=""Acc1>+-250</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-label" type="radio" id="GF2" name="GFS" value="500">
                        <label class="form-check-label" for=""Acc1>+-500</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-label" type="radio" id="GF3" name="GFS" value="1000">
                        <label class="form-check-label" for=""Acc1>+-1000</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-label" type="radio" id="GF4" name="GFS" value="2000">
                        <label class="form-check-label" for=""Acc1>+-2000</label>
                    </div>
                </h6>
            </div>
            <div class="mb-3 kichthuoc">
                <h6>
                    <label class="form-label"><b>Ready Interrupts : </b></label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-label" type="radio" id="I1" name="INT" value="0">
                        <label class="form-check-label" for=""Acc1>No</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-label" type="radio" id="I2" name="INT" value="1">
                        <label class="form-check-label" for=""Acc1>Yes</label>
                    </div>
                </h6>
            </div>
            <div class="mb-3">
                <input type="submit" class="btn btn-primary nutnhan" value="Apply">
            </div>
        </form>
    </div>  
    <div class="wrapper1 border border-2 rounded border-primary">
        <center>
            <h5 style="color: darkblue;"><b> CHART OF MPU6050 </b></h5>
        </center>
        <canvas id="myChart"></canvas>
        <br>
    </div>
    <script >
        // Tao bien trong chua noi dung cua do thi
        var label = [];
        var roll = [];
        var pitch = [];
        
        // Data trong do thi
        const chartdata = {
            labels: label,
            datasets: [{
                label: 'roll',
                backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(255, 99, 132)',
                data: roll
            },
            {
                label: 'pitch',
                backgroundColor: 'rgb(99, 255, 132)',
                borderColor: 'rgb(99, 255, 132)',
                data: pitch
            }
        
            ]
        };
        ///
        const config = {
            type: 'line',
            data: chartdata,
            options: {
                animation:false,
                scales: {xAxes: { title: { display: true, text: 'Number of sampling times',font: {size: 15}}},
                         yAxes: { title: { display: true, text: 'Values of Accelerometer Measurements',font: {size: 15}}}}
            }
        };

        /// Ve do thi
        var myChart = new Chart(
            document.getElementById('myChart'),
            config
        );

        // load data tu database
        $(document).ready(function(){
            updateChart(); /// Ve khung do thi
            updateTable(); /// Cap nhat bang
        });
        setInterval(updateChart,1000);
        function updateChart(){
            // gui request xuong database de lay data
            $.post('readData.php',function(data){

                // Reset bien moi lan dc goi - tranh truong hop data bi don them
                var label = [];
                var roll = [];
                var pitch = [];
                var r = [];
                var p =[];

                for(var i in data){
                    label.push(data[i].stt); //them phan tu vao trong chuoi
                    roll.push(data[i].roll);
                    pitch.push(data[i].pitch);
                    r.push(data[i].roll);
                    p.push(data[i].pitch);
                }
                // console.log(data1);
                myChart.data.labels = label;
                myChart.data.datasets[0].data = roll;

                // Cap nhat data lien tuc -> dua len doc gia tri tren web
                if(myChart.data.datasets[0].data = roll) 
                {
                    document.getElementById("r").innerHTML = r[i];
                }
                myChart.data.datasets[1].data = pitch;
                if(myChart.data.datasets[1].data = pitch)
                {
                    document.getElementById("p").innerHTML = p[i];
                }
                myChart.update();
            })
        } 

    </script>  
     <div class="wrapper2">
        <br><br><br>
        <center class="xuatgtr">
            <h5 style="color: darkblue;"><b>VALUES OF ROLL AND PITCH</b></h5>
        
            <table class="table table-hover table-striped">
                <tr>
                    <th scope="col">Roll : </th> 
                    <td id="r">  </td>   
                </tr>
                <tr>
                    <th scope="col">Pitch : </th> 
                    <td id="p">  </td>   
                </tr>
            </table>
        </center>
    </div>
</body>
</html>

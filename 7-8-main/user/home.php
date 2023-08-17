<!DOCTYPE html>
<html lang="en">
     <head>
          <title>Home</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="../style/style.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <?php 
          session_start();
          require('../conn/db_conn.php');
        ?>
     </head>    
      
     <script>
          function increaseValue($number) {
               var value = parseInt(document.getElementById($number).value, 10);
               value = isNaN(value) ? 0 : value;
               value++;
               document.getElementById($number).value = value;
          }

          function decreaseValue($number) {
               var value = parseInt(document.getElementById($number).value, 10);
               value = isNaN(value) ? 0 : value;
               value < 1 ? value = 1 : '';
               value--;
               document.getElementById($number).value = value;
          }

          function cal($wnumber, $hnumber){
               $bmi = $wnumber/($hnumber*$hnumber);    
          }
     </script>

     <style>
          .cal-btn{
               padding: 5px 10px;
               color: white;
               background-color: #097770;
               border: 1px solid #097770;
               border-radius: 15px;
               font-size: 22px;
          }

          .bmi-modal{
               background-color: white;
               border: none;
               width: 100%;
               height: auto;
          }

          .b-content{
               position: relative;
               background-color: #dff0e8;
               padding: 0px;
               border: 1px solid #888;
               border-radius: 15px;
               width: 100%;
               height: auto;
               color: #097770;
               font-weight: bold;
               font-size: 20px;
               box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
          }

          .bmi{
               font-size: 34px;
               color: #ffb82e;
               margin-top: 2px;
               font-weight: bold;
          }

          .cmt{
               font-size: 16px;
               font-weight: normal;
               color: black;
          }

          .innum::placeholder{
               color: #097770;
          }

          .innum:focus{
               outline: none;
          }

          .innum:focus::placeholder{
               color: white;
          }

          .save{
               position: static;
               float: right;
               padding: 10px 15px;
               background-color: #097770;
               color: white;
               border-radius: 15px;
          }
     </style>

     <body>
          <?php
               require('header.html');
          ?>
               <div class="row justify-content-center" style="width: 65%;">
                    <h1 style="font-size: 30px; margin-top: 50px;color: #097770; font-weight: bold">Công cụ tính BMI</h1>
                    <div class="sub-heading" style="text-align: center; font-size: 16px; margin-bottom: 30px;color: #097770">Tính chỉ số BMI để biết tình trạng sức khỏe của bạn</div><br>
                    
                    <div class="row" style="text-align: center;">
                         <div class="col-lg-6 col-md-6 col--sm-12 col-12">
                              <form action="home.php" method="post" style="text-align: center; margin: 0; padding: 0; border: none; width: 100%">
                                   <div style="margin: 10px;">
                                        <p class="title" style="color: #097770;">Chiều cao (cm)</p>
                                        <div class="div_inum">
                                             <div class="value-button" id="decrease" onclick="decreaseValue('hnumber')" value="Decrease Value">-</div>
                                             <input class="innum" type="number" id="hnumber" name="hnumber" placeholder="0" min="100" max="251"/>
                                             <div class="value-button" id="increase" onclick="increaseValue('hnumber')" value="Increase Value">+</div> 
                                        </div>
                                   </div>
                                   
                                   <div style="margin: 10px;" >
                                        <p class="title" style="color: #097770">Cân nặng (kg)</p>
                                        <div class="div_inum">
                                             <div class="value-button" id="decrease" onclick="decreaseValue('wnumber')" value="Decrease Value">-</div>
                                             <input class="innum" type="number" id="wnumber" name="wnumber" placeholder="0"/>
                                             <div class="value-button" id="increase" onclick="increaseValue('wnumber')" value="Increase Value">+</div>
                                        </div> 
                                   </div>
                                   <div style="width: 100%;">
                                        <div>
                                             <button type="submit" class="cal-btn" value="calculate">Tính toán</button>
                                        </div>
                                   </div>
                              </form>
                         </div>
                              <div class="col-6 col-md-6">
                                   <form style="width: 100%; border: 0; padding: 0; outline: 0">
                                        <?php 
                                             include('../conn/db_conn.php');

                                             if(isset($_POST['hnumber']) && isset($_POST['wnumber'])){
                                                  $hnumber = $_POST['hnumber'];
                                                  $wnumber = $_POST['wnumber'];
                                                  
                                                  if( empty($hnumber) || empty($wnumber)){
                                                       echo '<script language="javascript">alert("Hãy điền đẩy đủ thông tin"); window.location="home.php";</script>';
                                                  }else{
                                                       $Mweight = ($hnumber-100);
                                                       $mweight = ($hnumber-100)*0.8;
                                                       $iweight = ($hnumber-100)*0.9; 
                                                       $bmi = round($wnumber/($hnumber/100 * $hnumber/100) ,2);
                                                       
                                                       if(isset($_POST['save'])){
                                                            $sql = "INSERT INTO bmidata (height, weight, bmi) VALUES ('$hnumber', '$wnumber', '$bmi') WHERE user_name = '$_SESSION[user_name]'";
                                                            $result = mysqli_query($conn, $ins) or die(mysqli_error($conn));
                                                       }

                                                       ?>  <div class="bmi-modal" id="bmi-modal">
                                                                 <div class="b-content"> 
                                                                      <div style="margin-top: 20px;">
                                                                                Chỉ số BMI của bạn là: 
                                                                           <div class="bmi">
                                                                                <?php echo $bmi;?>
                                                                      </div>     
                                                                           <?php if($bmi <= 18.5){ ?><p class="cmt">Thiếu cân</p>
                                                                           <?php }elseif($bmi > 18.5 && $bmi <= 24.9){ ?><p class="cmt">Bình thường</p>
                                                                           <?php }elseif($bmi > 24.9 && $bmi <= 29.9){ ?><p class="cmt">Tiền béo phì</p>
                                                                           <?php }elseif($bmi > 29.9 && $bmi <= 34.9){ ?><p class="cmt">Béo phì độ I</p>
                                                                           <?php }elseif($bmi > 34.5 && $bmi <= 39.9){ ?><p class="cmt">Béo phì độ II</p>
                                                                           <?php }elseif($bmi > 39.9){ ?><p class="cmt">Béo phì độ III</p><?php } ?>
                                                                      </div>

                                                                      <div style="margin-top: 2px;">
                                                                           Cân nặng lý tưởng của bạn là:
                                                                           <div class="bmi">
                                                                                <?php echo $iweight;?>
                                                                           </div>
                                                                           <p class="cmt">Kilogram</p>
                                                                      </div>

                                                                      <div style="margin-top: 2px;">
                                                                           Cân nặng tối đa của bạn là:
                                                                           <div class="bmi">
                                                                                <?php echo $Mweight;?>
                                                                           </div>
                                                                           <p class="cmt">Kilogram</p>
                                                                      </div>

                                                                      <div style="margin-top: 2px;">
                                                                           Cân nặng tối thiểu của bạn là:
                                                                           <div class="bmi">
                                                                                <?php echo $mweight;?>
                                                                           </div>
                                                                           <p class="cmt">Kilogram</p>     
                                                                      </div>
                                                                      <input type="submit" name="save" id="save" value="Lưu" class="save"/>
                                                                 </div> 
                                                            </div> 
                                                       <?php
                                                  }
                                             }   
                                        ?>
                                   </form>   
                              </div>
                         </div>
                    </div>
     </body>
</html>


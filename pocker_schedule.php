<html>
  <head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  </head>
  <body>

<?php
/**
 * Plugin Name: Get Pocker Schedule Details
 * Plugin URI: Kaushik
 * Description: Get Pocker Schedule Details Using API
 * Version: 1.0
 * Author: Your Name
 * Author URI: Kaushik
 */


function getPokerDetails( $atts ) {
    $atts = shortcode_atts(
        array(
            'this_week' => false,
            'this_month' => false,
            'store' => "All"
        ), $atts, 'get_pocker_details');
?>
<form action="" method="get">
    <div id="ticket">
        <div class="container-xs">
            <div class="row">
            <div class="col-sm-12">
                <div class="ticket_content">
                <div class="title">
                    <h3>ポーカースケジュール</h3>
                </div><!-- title -->
                <?php

                  $ch = curl_init();
                  $getUrl = "https://pokerguild.jp/api/v1/get-schedule";
                  $venue = $_GET['venue'];
                  $start_date_from = $_GET['start_date_from'];
                  $start_date_to = $_GET['start_date_to'];
                  $game = $_GET['game'];
                  $limit = $_GET['limit'];
                  $exclude = 1;
                  if(isset($_GET['exclude'])) {
                    $exclude = $_GET['exclude'];
                  }
                  $dataArray = array();
                  if(!empty($venue)) {
                    $dataArray['venue'] = $venue;
                  }
                  if(!empty($start_date_from)) {
                    $dataArray['start_date_from'] = $start_date_from;
                  }
                  if(!empty($start_date_to)) {
                    $dataArray['start_date_to'] = $start_date_to;
                  }
                  if(!empty($game)) {
                    $dataArray['game'] = $game;
                  }
                  if(!empty($limit)) {
                    $dataArray['limit'] = $limit;
                  }
                  if(!empty($exclude)) {
                    $dataArray['exclude'] = $exclude;
                  }

                  if(!empty($dataArray)) {
                    $data = http_build_query($dataArray);
                   $getUrl = $getUrl."?".$_SERVER['QUERY_STRING'];
                  }
                  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
                  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                  curl_setopt($ch, CURLOPT_URL, $getUrl);
                  curl_setopt($ch, CURLOPT_TIMEOUT, 80);
                  $response = json_decode(curl_exec($ch));
                  if(curl_error($ch)){
                      echo 'Request Error:' . curl_error($ch);
                  }else{
                      //echo $response;
                  }
                  curl_close($ch); 
                  ?>

                  <div class="form-wrapper"> <!--  form-wrapper -->
                <div class="row cus-form1">

                    <div class="col-sm-6">
                    <h6>店舗</h6>
                    <select name="venue" class="form-select" id="TourneyVenue"> <option value=""><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">all</font></font></option> 
                    <?php foreach($response->venues as $key => $venueName):   ?>
                      <option class="cus-option"  <?php if($venue == $key) : ?> selected <?php endif; ?> value="<?php echo $key;?>"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"><?php echo $venueName;?></font></font></option>
                      <?php endforeach; ?>
                      </select>
                    </div><!-- col-sm-6 -->

                    <div class="col-sm-6 right_form cus-eventdate">
                    <h6>開催日</h6>
                    <div class="col-sm-6">
                        <input type="date" value="<?php echo $start_date_from;?>" name="start_date_from" class="form-control">
                    </div><!-- col-sm-6 -->
                    <div class="col-sm-6 cus-form0">
                        <input type="date" value="<?php echo $start_date_to;?>" name="start_date_to" class="form-control">
                    </div><!-- col-sm-6-->
                    </div><!-- col-sm-6 -->
                </div><!-- row -->

                <div class="row cus-form2">
                  <div class="col-sm-6 right_form">
                    <h6>リミット</h6>
                    <select name="limit" class="form-select" id="TourneyLimit"> 
                      <option value=""><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">all</font></font></option> 
                      <?php foreach($response->limits as $key => $limitName):   ?>
                      <option <?php if($limit == $key) : ?> selected <?php endif; ?> value="<?php echo $key;?>"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"><?php echo $limitName;?></font></font></option> 
                      <?php endforeach; ?>
                      </select>
                    </div><!-- col-sm-6  -->
                    
                    <div class="col-sm-6 cus-game">
                    <h6>ゲーム</h6>
                    <select name="game" class="form-select" id="TourneyGame"> 
                      <option value=""><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">all</font></font></option> 
                      <?php foreach($response->games as $key => $gameName):   ?>
                      <option <?php if($game == $key) : ?> selected <?php endif; ?> value="<?php echo $key;?>"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"><?php echo $gameName;?></font></font></option> 
                      <?php endforeach; ?>
                    </select>
                    </div><!-- col-sm-6 -->
                   
                </div><!-- row -->
                </div>

                <div class="form-group form-check cus-from-check">
                <input type="hidden" name="exclude" id="TourneyExclude_" value="0">
                    <input type="checkbox" class="form-check-input" <?php if($exclude == 1): ?> checked  <?php endif;?> name="exclude" value="1"   id="TourneyExclude">
                    <p>シットアンドゴー除外</p>
                    <p>※新しいトーナメントから最大50件を表示します</p>
                </div>
                <button class="btn" type="submit"><span class="search"></span>探す</button>
                </div><!-- ticket_content -->
            </div><!-- col-sm-12 -->
            </div><!-- row -->
        </div><!-- container-sm -->
    </div> <!-- ticket -->



    <div id="schedule">
      <div class="container-xs">
        <div class="row">
          <div class="schedule_content">
            <div class="title">
              <h3>POKER SCHEDULE</h3>
            </div><!-- title -->

            <div class="cus-table-wrapper">
            <div  class="table-responsive text-nowrap cus-schedule-table"> <!-- cus-table table style -->
              <table id="t01">
                <tr>
                  <th>開催日</th>
                  <th>トーナメント</th> 
                  <th>店舗</th>
                </tr>

                <?php 
                if(!empty($response->tourneys)) {
                  foreach($response->tourneys as $key => $tourney):  
                ?>
                <tr>
                  <td> 
                   <span class="block time cus-table-font"><?php echo date('H:i', strtotime($tourney->Tourney->start_date)); ?> </span>
                  </td>
                  <td>
                    <span class="red spade cus-table-font"><a target="_blank" href="https://pokerguild.jp/tourneys/<?php echo $tourney->Tourney->id; ?>"><?php echo $tourney->Tourney->tourneyname;?></a></span><Br />
                    <span class="block poppins"><?php echo $tourney->Tourney->Description; ?> </span>
                  </td>
                  <td>
                      <span class="red red2 cus-table-font"><a target="_blank" href="https://pokerguild.jp/venues/<?php echo $tourney->Venue->id; ?>">
                      <?php echo $tourney->Venue->name; ?></a></span><br />
                    <span class="block map"><?php echo $tourney->Tourney->place; ?></span>
                  </td>
                </tr>
                 
                    <?php endforeach;
                }
                    ?> 
              </table>
            </div>
            </div>

          </div><!-- schedule_content -->
        </div><!-- row -->
      </div><!-- container-sm -->
    </div><!-- schedule -->
    
</form>

<?php  
}
add_shortcode( 'get_pocker_details', 'getPokerDetails' );

?>
  </body>
</html>
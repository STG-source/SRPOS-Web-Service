<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>New Schedule Document</title>
</head>

<body>
    <div>      
      <div class="toolBotton">           
        <a id="Savebtn" class="imgbtn" href="javascript:void(0);">                
          <span class="Save"  title="Save the calendar">Save(<u>S</u>)
          </span>          
        </a>                           
        <?php if(isset($event)){ ?>
        <a id="Deletebtn" class="imgbtn" href="javascript:void(0);">                    
          <span class="Delete" title="Cancel the calendar">Delete(<u>D</u>)
          </span>                
        </a>             
        <?php } ?>            
        <a id="Closebtn" class="imgbtn" href="javascript:void(0);">                
          <span class="Close" title="Close the window" >Close
          </span></a>            
        </a>        
      </div>                  
      <div style="clear: both">         
      </div>        
      <div class="infocontainer">            
        <form action="php/datafeed.php?method=adddetails<?php echo isset($event)?"&id=".$event->Id:""; ?>" class="fform" id="fmEdit" method="post">                 
          <label>                    
            <span>                        *Subject:              
            </span>                    
          <div id="calendarcolor">
            </div>
            <input MaxLength="200" class="required safe" id="Subject" name="Subject" style="width:85%;" type="text" value="<?php echo isset($event)?$event->Subject:"" ?>" />                     
            <input id="colorvalue" name="colorvalue" type="hidden" value="<?php echo isset($event)?$event->Color:"" ?>" />                
          </label>                 
          <label>                    
            <span>*Time:
            </span>                    
            <div>  
              <?php
                $all_day_event=false;
                if(isset($event)){
                  $sarr = explode(" ", php2JsTime(mySql2PhpTime($event->StartTime)));
                  $earr = explode(" ", php2JsTime(mySql2PhpTime($event->EndTime)));
                  $all_day_event=$event->IsAllDayEvent;
                }
                elseif(isset($_GET['start']) && $_GET['start']!=-360){
                    $sarr = explode(" ",$_GET['start']);
                    $earr = explode(" ",$_GET['end']);
                    $all_day_event=($sarr[1]=="00:00" && $earr[1]=="00:00");
                  }
                ?>
              <input MaxLength="10" class="required date" id="stpartdate" name="stpartdate" style="padding-left:2px;width:90px;" type="text" value="<?php echo isset($sarr[0])?$sarr[0]:""; ?>" />
              <input MaxLength="5" class="required time" id="stparttime" name="stparttime" style="width:40px;" type="text" value="<?php echo isset($sarr[1])?$sarr[1]:""; ?>" />To
              <input MaxLength="10" class="required date" id="etpartdate" name="etpartdate" style="padding-left:2px;width:90px;" type="text" value="<?php echo isset($earr[0])?$earr[0]:""; ?>" />
              <input MaxLength="50" class="required time" id="etparttime" name="etparttime" style="width:40px;" type="text" value="<?php echo isset($earr[1])?$earr[1]:""; ?>" />
              <label class="checkp"> 
                <input id="IsAllDayEvent" name="IsAllDayEvent" type="checkbox" value="1" <?php if($all_day_event) {echo "checked";} ?>/>          All Day Event
              </label>                    
            </div>                
          </label>                 
          <label>                    
            <span>                        Location:
            </span>                    
            <input MaxLength="200" id="Location" name="Location" style="width:95%;" type="text" value="<?php echo isset($event)?$event->Location:""; ?>" />                 
          </label>                 
          <label>                    
            <span>                        Remark:
            </span>                    
            <textarea cols="20" id="Description" name="Description" rows="2" style="width:95%; height:70px">
            <?php echo isset($event)?$event->Description:""; ?>
            </textarea>
          </label>                
          <input id="timezone" name="timezone" type="hidden" value="" />           
        </form>         
      </div>    
    </div>
</body>
</html>
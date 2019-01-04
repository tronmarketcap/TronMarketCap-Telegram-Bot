<?php
 
$botToken = "BOT_TOKEN";
$website = "https://api.telegram.org/bot".$botToken;
 
$update = file_get_contents('php://input');
$update = json_decode($update, TRUE);
 
 
$chatId = $update["message"]["chat"]["id"];
$date = $update["message"]["date"];
$mid = $update["message"]["message_id"];
$mid1 = ($update["message"]["message_id"] + 1);
$message = $update["message"]["text"];


$servername = "SERVER";
$username = "USERNAME";
$password = "PASSWORD";
$dbname = "DBNAME";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM chanakyacoin ";
$result = mysqli_query($conn, $sql);

$data1 = array(); 

$i = 0;
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        
        
     $data1[$i] .=   "\n" .$row["symbol"]."\n  Price " .$row["price"]."\n   Market Cap: ".($row["price"]*$row["supply"])."\n   Volume: ".$row["volume"]."\n   Social: ".$row["social"]."\n   Explorer: ".$row["explorer"]."\n   Website: ".$row["website"];
        
     $i++;
     
     
 
    }
    
     $array =  implode("\n", $data1);
     
     /*Single Currency Data Fetch */
    /*  Keyword "/" Data fetch with suitable conditions Starts*/
        if($message[0] == "/")
     {


/*   Condition to display all Single Currency Data Ends*/

          if( strpos($message, "/p" ) !== false) {
$message1 = str_replace('/p ', '', $message);

$sql1 = "SELECT symbol,price FROM chanakyacoin WHERE symbol='$message1'";
$result1 = mysqli_query($conn, $sql1);
if (mysqli_num_rows($result1) > 0) {
    $row1 = mysqli_fetch_assoc($result1);
    $data2 =  $row1["symbol"] ;
    $datas2 = "\n" .'Price: '.$row1["price"];
    
}
    
    else {
    //$data2 = "No results";
}
}

else if( strpos($message, "/m" ) !== false){
$message1 = str_replace('/m ', '', $message);

$sql1 = "SELECT symbol,price,supply FROM chanakyacoin WHERE symbol='$message1'";
$result1 = mysqli_query($conn, $sql1);
if (mysqli_num_rows($result1) > 0) {
    $row1 = mysqli_fetch_assoc($result1);
    $data2 =  $row1["symbol"] ;
    $datas2 = "\n" .'Market Cap: '.($row1["price"]*$row1["supply"]);
    
}
    
    else {
    //$data2 = "No results";
}
}

else if( strpos($message, "/v" ) !== false){
$message1 = str_replace('/v ', '', $message);

$sql1 = "SELECT symbol,volume FROM chanakyacoin WHERE symbol='$message1'";
$result1 = mysqli_query($conn, $sql1);
if (mysqli_num_rows($result1) > 0) {
    $row1 = mysqli_fetch_assoc($result1);
    $data2 =  $row1["symbol"] ;
    $datas2 = "\n" .'Volume: '.$row1["volume"];
    
}
    
    
}

else if( strpos($message, "/i" ) !== false){
$message1 = str_replace('/i ', '', $message);

$sql1 = "SELECT symbol,explorer,whitepaper,social,website FROM chanakyacoin WHERE symbol='$message1'";
$result1 = mysqli_query($conn, $sql1);
if (mysqli_num_rows($result1) > 0) {
    $row1 = mysqli_fetch_assoc($result1);
    $data2 =  $row1["symbol"] ;
    
    
    
    $datas2 .=   "\n\n  Explorer: ".$row1["explorer"]."\n\n   Whitepaper: ".$row1["whitepaper"]."\n\n   Social: ".$row1["social"]."\n\n   Website: ".$row1["website"];
      
    
}
    
  
}


    
     }
     
     
     /*  Keyword "/" Data fetch with suitable conditions*/
     
      else if($message[0] == "#"){
          
          if( strpos($message, "#autobuy" ) !== false) {
$message1 = str_replace('#autobuy ', '', $message);

//Trims the string after space
$message2=substr($message1, 0, strrpos($message1, ' '));
}

else if( strpos($message, "#autosell" ) !== false){
$message1 = str_replace('#autosell ', '', $message);

//Trims the string after space
$message2=substr($message1, 0, strrpos($message1, ' '));

}
          
    
       $sql1 = "SELECT * FROM black_tokens WHERE BINARY blacklist='$message2'";
       $result1 = mysqli_query($conn, $sql1);
       
       if (mysqli_num_rows($result1) > 0) {
    // output data of each row
    $row1 = mysqli_fetch_assoc($result1);
     $warn = "Warning, this token is part of the blacklist";
      $data2 = $warn.' '.'           '. $row1["blacklist"];
    

}   
          
          
      }
     
     
     
     
     
     
    switch($message) {
        
        case "/":
                sendMessage($chatId, "Please type the correct keyword");
                break;          
        case "/p":
                sendMessage($chatId, $array);
                break;
       case "/p $message1":
                sendMessage($chatId, $data2.$datas2);
                break;
       case "/m $message1":
                sendMessage($chatId, $data2.$datas2);
                break;
       case "/v $message1":
                sendMessage($chatId, $data2.$datas2);
                break;
       case "/i $message1":
                sendMessage($chatId, $data2.$datas2);
                break;                 
       case "#autobuy $message1":
                sendMessage($chatId, $data2);
                break;  
       case "#autosell $message1":
                sendMessage($chatId, $data2);
                break;                 
        /*default:
                sendMessage($chatId, "default");
       */
}
    function sendMessage ($chatId, $message) {
       
        $url = $GLOBALS[website]."/sendMessage?chat_id=".$chatId."&text=".urlencode($message);
        file_get_contents($url);

       
}
   
 
?>















<!---->
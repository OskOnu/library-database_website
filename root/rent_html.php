<?php
session_start();
?>
<?php
class logging{

    private $db; 
    private $host; 
    private $user; 
    private $pass; 
    
    public function __construct() {
        $this->host = "mysql:dbname=library;host=localhost";
        $this->user = "root";
        $this->pass = "";
        $this->db = new PDO($this->host, $this->user, $this->pass);
    }
    
    public function logout($mail) {
         $select = "UPDATE `users` SET `logged`='0' WHERE `mail`='$mail'";
         $res = $this->db->query($select);
         return '1';
    }

public function books() {
        $select="SELECT * FROM `books`";
        $res = $this->db->query($select);
        $wynik=$res->fetchAll();
        foreach($wynik as $w){ 
            
            echo '<div class="book">';
                echo '<div class="book_image">';
                    echo '<img src='.'../'.$w['img1'].'/'.$w['img2'].'>';
                echo '</div>';
                echo '<div class="book_text">';
                 echo '<form class="take" action="rent.php" method="POST" >';
                    echo '<input type="text" name="bname" value="'.$w['bname'].'"/></br>';
                    echo '<input type="text" name="author" value="'.$w['author'].'"/></br>';
                    echo '<input type="text" name="isbn" value="'.$w['isbn'].'"/></br>';
                    echo '<input class="submit" type="submit" name="rent" value="rent">';
                     echo '</form>';
                echo '</div>';
                echo '<div class="book_amount">';
                    echo '</br>dostepnych: ' .$w['amount'];
                    echo '</div>';
               
                    // echo'<input type="text" name="eaf" value=""/>';
                    
               
                
            echo '</div>'; 
        }
                            }
                            
        }
 class permit{
    private $db; 
    private $host; 
    private $user; 
    private $pass; 
    
    public function __construct() {
        $this->host = "mysql:dbname=library;host=localhost";
        $this->user = "root";
        $this->pass = "";
        $this->db = new PDO($this->host, $this->user, $this->pass);
    }
    
    public function access($mail) {
       $select = "SELECT `logged`, `access` FROM `users` WHERE `mail`='$mail'";
       $res = $this->db->query($select);
       $wynik=$res->fetchAll();
       
       foreach($wynik as $w){
            if(($w['logged']=='1')&&($w['access']=='1')){
                return '1';
            }else if(($w['logged']=='1')&&($w['access']=='2')) {
                return '2';
            }else {
                return '0';
            }      
        }
         
    }
}
?>
<?php 
$access=new permit;
$permit=$access->access($_SESSION["mail"]);
if($permit=='1'){?>
<?php 
    $logging=new logging();
    if(isset($_POST['logout'])){
            $logging->logout($_SESSION["mail"]);
            header("Location: ../index.php"); 
        }
    ?> 

<html>
    <head>
        <!-- tutaj dodamy skrypty i css-->
        <link rel="stylesheet" type="text/css" href="../script/style2.css"/>
        <link rel="stylesheet" type="text/css" href="../script/style.css"/>
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>

    </head>
    <body>
        <div class="content">
            <!-- Górna część serwisu -->
            <div class="top">
                <!-- logo serwisu -->
                <div class="logo">

                </div>
                <!-- lewa część górna serwisu -->
                <div class="top_left">
                    <!--Wyszukiwarka serwisu -->
                    <div class="wyszukiwarka">
                        <span id="login">
                            <div class="login">
                                 <form action="" method="POST">                                       
                                     <label>Welcome! You`r logged. Status: user.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input class="submit" type="submit" name="logout" value="LOGOUT"> 
                </form>
            </div>
                        </span>
                        <span id="koszyk"></span>
                    </div>

                    <!-- Menu serwisu -->
                    <div class="menu">
                        <ul>
                            <li><a href="logged_user.php">Home</a></li>
                            <li><a href="rent_html.php">Rent Book</a></li>
                            <li><a href="contact.php">Contact</a></li>
                            <div class="info" style="display:none;" title="php info">
               <span> Zamknij okno</span>
            </div>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- koniec góry serwisu -->
            <div class="clear"></div>
            <!-- Środek serwisu -->
            <div class="center">
                <div class="center_left"></div>
                <div class="center_middle">
                    <div class="center_middle">
                    <div id="add_book">
                        <form action="rent.php" method="POST">
                    <fieldset><legend>BOOKS RENTAL</legend>
                    <label>BOOK NAME:</label><input type="text" name="bname" value=""/><br/>
                    <label>AUTHOR:</label><input type="text" name="author" value=""/><br/>
                    <label>ISBN:</label><input type="text" name="isbn" value=""/><br/>
                    <input type="submit" name="rent" value="rent"/>
                    <input type="reset" value="CLEAN">
                    </fieldset>
                </form>
            </div>
                        <div class="catalog">
                            <?php
                        $catalog=new logging;
                        $catalog->books();
                    ?>
                        </div>
                </div>
                </div>
                <div class="center_right"></div>
            </div>
            <!-- koniec środkowej części serwisu -->
            <div class="clear"></div>
            <!-- dolna część serwisu -->
            <div class="bottom">
                <div class="sitemap"></div>
                <div class="stopka"></div>
            </div>
            
        </div>
    </body>
</html>
<?php

}else{
    print 'NO ACCESS!!!!NO ACCESS!!!!NO ACCESS!!!!NO ACCESS!!!!NO ACCESS!!!!</br>
           NO ACCESS!!!!NO ACCESS!!!!NO ACCESS!!!!NO ACCESS!!!!NO ACCESS!!!!</br>';
}
?>
<?php
    $logging=new logging();
    if(isset($_POST['logout'])){
            $logging->logout($_SESSION["mail"]);
            header("Location: ../index.php"); 
        }
    ?> 


    
  

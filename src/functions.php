<?php

        $mysqli = new mysqli("db","root","example","company1");/* Bağlantıyı Kontrol Et */
            if ($mysqli->connect_error){
                /* Bağlantı Başarısız İse */
                echo "Bağlantı Başarısız. Hata: " . $mysqli->connect_error;
                $q = new mysqli("db","root","example","");
                mysqli_query($q,"CREATE DATABASE `company1`") or die(mysqli_error($q));
                exit;
            }

    class gorev{

        function __construct(){
            $mysqli = new mysqli("db","root","example","company1");/* Bağlantıyı Kontrol Et */
            if ($mysqli->connect_error){
                /* Bağlantı Başarısız İse */
                echo "Bağlantı Başarısız. Hata: " . $mysqli->connect_error;
                exit;
            }
        }

        function items($mysqli){
            
            $result=$mysqli->query("select * from products");
            while($data=$result->fetch_assoc()):
                echo '
                    <div class="card mx-2" style="width: 18rem;">
                        <img src="'.$data["image"].'" class="card-img-top" alt="'.$data["name"].'">
                        <div class="card-body">
                            <h5 class="card-title">'.$data["name"].'</h5>
                            <p class="card-text">£'.$data["price"].'</p>
                            <a href="#" class="btn btn-primary">See</a>
                        </div>
                    </div>
                ';
            endwhile;
            if($result==null){
                mysqli_query($mysqli,"CREATE TABLE `products` (
                    `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    `name` text NOT NULL,
                    `image` text NOT NULL,
                    `price` float NOT NULL
                  ) ENGINE='InnoDB'") or die(mysqli_error($mysqli));
            }
            
        }

        function add($site,$mysqli){
                require('simple_html_dom.php');
                $html = file_get_html($site);
                $tags = get_meta_tags($site);
                $name = $tags['title'];
                
                $x = explode("/",$site);
                $id = $x[5];
                $s = explode("|",$name);
                $name = $s[0];

                foreach($html->find('p') as $a){
                    if ($a->getAttribute('class')=="wt-text-title-03 wt-mr-xs-2"){
                        $m = explode("£",$a);
                        $money = $m[1];
                        $money = floatval($money);
                    }
                }
                $ai = array();
                foreach($html->find('img') as $a){
                    if ($a->getAttribute('class')=="wt-max-width-full wt-horizontal-center wt-vertical-center carousel-image wt-rounded"){
                        $image = $a->getAttribute('data-src-zoom-image');
                        break;
                    }
                }
                mysqli_query($mysqli,"INSERT INTO products (`name`,`image`,`price`) VALUES ('$name','$image','$money')") or die(mysqli_error($mysqli));
        }
    }

?>
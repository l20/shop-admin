<?php 

	// require_once './lib/image.func.php';
    // require_once 'lib/mysql.func.php';
    // require_once './core/admin.inc.php';

    // define("ROOT", "/Users/nerc/Desktop".dirname(__FILE__));

    // set_include_path(ROOT."/lib");
   /* require_once 'include.php';
    // echo ROOT;
    $username = 'admin';
    $password = 'admin';

    $link = connet();

        $sql = "select * from admin where username='{$username}' and password='{$password}'";
        $res = fetchOne($sql, $link);
        var_dump($res); */

        // $str = "./images_50/test.png";
        $destination = "../images_50/c6098ba92dd2e348c0d46bd34b71b1e8.png";
        if ($destination != null) {
            $dirs = explode("/", $destination);
            $item1 = count($dirs);
            $filen = explode(".", $dirs[$item1-1]);
            $item2 = count($filen);

            $destination = dirname($destination);
           /* for ($i=0; $i < $item1-1; $i++) { 
                $destination .= $dirs[$i]."/";
            }*/
            $destination .= "/".$filen[0]."_"."50"."x"."50".".".$filen[$item2-1];


            // $destination .= "_".$dst_w."×".$dst_h.".".$dirs[$item-1];
        }

                echo unlink($destination);
        // echo $destination;
      /* $renames = Array ( Array ( 
                    "name_50"  => "../images_50/c6098ba92dd2e348c0d46bd34b71b1e8_50x50.png",
                    "name_220" => "./images_220/c6098ba92dd2e348c0d46bd34b71b1e8_220x220.png",
                    "name_350" => "./images_350/c6098ba92dd2e348c0d46bd34b71b1e8_350x350.png",
                    "name_800" => "./images_800/c6098ba92dd2e348c0d46bd34b71b1e8_800x800.png"
                ) ,
                 Array ( 
                    "name_50"  => "./images_50/37d16f6383b1c5c7fc8b0d88951c538d_50x50.pngs",
                    "name_220" => "./images_220/37d16f6383b1c5c7fc8b0d88951c538d_220x220.pngs",
                    "name_350" => "./images_350/37d16f6383b1c5c7fc8b0d88951c538d_350x350.pngs",
                    "name_800" => "./images_800/37d16f6383b1c5c7fc8b0d88951c538d_800x800.pngs"
                ) 
             );
            foreach ($renames as $key => $rename) {
                if (file_exists($rename['name_50'] )) {echo $rename['name_50'] ; unlink($rename['name_50'] );}
                if (file_exists($rename['name_220'])) {echo $rename['name_220']; unlink($rename['name_220']);}
                if (file_exists($rename['name_350'])) {echo $rename['name_350']; unlink($rename['name_350']);}
                if (file_exists($rename['name_800'])) {echo $rename['name_800']; unlink($rename['name_800']);}
                echo "string";
            }
*/
            // echo dirname($renames[0]["name_50"]);
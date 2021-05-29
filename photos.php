<?php
    $ch = curl_init("https://api.pexels.com/v1/search?query=".$_GET['search']);
    $headers = [
        'Authorization: 563492ad6f91700001000001d34eefc097244530b27253436baaa10a'
    ];

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $server_output = curl_exec ($ch);
    curl_close ($ch);
    $data = json_decode($server_output,true);
    $photos = $data['photos'];
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="photos.css">
    <title>tinypixel - photos</title>
</head>
<body>
    <p style="display: none;" class="hidden">compressing</p>
    <form class="header" action="photos.php">
        <a href="index.php"><h1>tinypixel</h1></a>
        <div class="search">
            <input type="text" name="search">
            <button>
                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="search" class="svg-inline--fa fa-search fa-w-16 search-icon" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"></path></svg>
            </button>
        </div>
    </form>
    <table>
        <?php
            for ($i = 0, $j = 0; $i < count($photos); $i++) {
                if ($j == 0) {
                    echo "<tr>";
                }
                    echo '<td class="container"><img class="image" src="'.$photos[$i]['src']['large'].'"><div class="middle">
                    <a href="process.php?query='.$_GET['search'].'&pos='.$i.'&original='.$photos[$i]['src']['original'].'" class="text" onclick="document.getElementsByClassName(\'overlay\')[0].style.display=\'block\'">compress & download</a>
                  </div></td>';
               
                $j+=1;
                if ($j == 4) {
                    echo "<tr>";
                    $j = 0;
                }
            }
        ?>
    </table>
    <div class="overlay">
        <div class="overlay__inner">
            <div class="overlay__content"><span class="spinner"></span>
            </div>
        </div>
    </div>
    <script>
    setInterval(function(){
        value_or_null = (document.cookie.match(/^(?:.*;)?\s*fileLoading\s*=\s*([^;]+)(?:.*)?$/)||[,null])[1];
        if (value_or_null) {
            // alert("Downloaded");
            let name = "fileLoading";
            document.cookie = name +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
            document.getElementsByClassName('overlay')[0].style.display='none';
        }
    },1000);
    </script>
</body>
</html>

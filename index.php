<?php
error_reporting(2);
//TODO: Add Authentication
//check if lang is already set
if(isset($_POST["system_sent_post"])) {
    //If POST_REQUEST
    echo $_POST["system_lang_sent"];
    $fp = fopen(__DIR__."/json/user_sub/". round(microtime(true) * 1000).".".$_POST["system_lang_sent"].".json","w");
    fwrite($fp, json_encode($_POST, JSON_UNESCAPED_UNICODE));
    fclose($fp);
}
if(isset($_GET["from"]) && isset($_GET["to"])) {
    //TODO: Remove Debugging
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Translate | SaveYourInternet Translator</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="/lib/css/main.css" />
    <!--Ja, ich nutze hier css-->
</head>
<body>
    <!-- Put it in Table; Easy CSS -->
    <table class="translate_tbl">
        <tr>
            <th><?=get_long_lang($_GET["from"])?></th>
            <th><?=get_long_lang($_GET["to"])?></th>
        <form action="" method="post">
        <input type="hidden" name="system_sent_post" value="1">
        <input type="hidden" name="system_lang_sent" value="<?=$_GET["to"]?>">
        </tr>
        <?php
        //Load GET JSONS
        $from_json = file_get_contents('./json/'.$_GET["from"].'.json');
        $to_json = file_get_contents('./json/'.$_GET["to"].'.json');

        //Decode the JSONs
        $from_json_data = json_decode($from_json,true);
        $to_json_data = json_decode($to_json,true);

        //ForEach in from_json
        foreach ($from_json_data as $key => $value) {
            //KEY
        ?>
        <tr>
            <td><?=$value?></td>
            <?php
                $to_value = $to_json_data[$key];
            ?>
            <td>
            <textarea name="<?=$key?>" id="<?=$key?>" cols="30" rows="10"><?=$to_value?></textarea>
        </tr>
        <?php
        }
        ?>
    </table>
    <input type="submit" value="Submit" class="submit_100">
    </form>
</body>
</html>
<?php
} else {
require __DIR__."/choose.php"; //Just a 2nd File to shrink filesize (Could ofc be reduced to this file)
}

function get_long_lang($lang) {
    //Timesaver
    $lang = strtolower($lang);
    switch ($lang) {
        case 'de':
            return "Deutsch";
            break;
        case 'fr':
            return "Français";
            break;
        case 'it':
            return "Italia";
            break;
        case 'pt':
            return "Português";
            break;
        default:
            return "English";
            break;
    }
}
?>
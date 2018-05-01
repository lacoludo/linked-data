<?php
    require 'vendor/autoload.php';
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css" integrity="sha256-tKn8A2U9uuN5rPr3gh4A9FYMJkarrzLVyks7aS/ZfBU=" crossorigin="anonymous">
    </head>
    <body>
        <nav class="light-blue lighten-1" role="navigation">
            <div class="nav-wrapper container">
                <a href="#" class="brand-logo">Linked data</a>
            </div>
        </nav>
        <div class="section no-pad-bot">
            <div class="container">
                <br>
                <br>
                <h1 class="header center orange-text">DOI</h1>
                <div class="row center">
                    <h5 class="header col s12 light">Search the metadata of 96,490,364 journal articles, books, standards, datasets & more</h5>
                </div>
                <div class="row center">
                    <form action="" method="post">
                        <div class="input-field orange-text">
                            <i class="material-icons prefix">search</i>
                            <input id="icon_prefix" type="text" class="validate" name="doi">
                            <label for="icon_prefix">Search</label>
                            <input type="submit" name="submit" style="display: none;">
                        </div>
                    </form>
                </div>
                <div class="row center">
                    <?php
                        $_POST["submit"];
                        $doi = $_POST['doi'];
                        $url = 'http://dx.doi.org/'.$doi;
                        $curl = curl_init();
                        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
                        curl_setopt($curl, CURLOPT_HTTPHEADER, array('accept: text/turtle'));
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($curl, CURLOPT_URL, $url);
                        $result = curl_exec($curl);
                        curl_close($curl);
                        $data = new EasyRdf_Graph($url, $result, 'turtle');
                        $title = $data->get($url, "dcterms:title", "literal", null);
                        $authors = $data->all($url, "dcterms:creator", "resource", null);
                        $date = $data->get($url, "dcterms:date", "literal", null);
                        echo '<h4><a href="'.$url.'" target="_blank">'.$title.'</a></h4>';
                        echo '<h5>Authors :</h5>';
                        echo '<ul>';
                        foreach ($authors as $author)
                        {
                            echo '<li>'.$author->label().'</li>';
                        }
                        echo '</ul>';
                        echo '<h6>'.$date.'</h6>';
                    ?>
                </div>
                <br>
                <br>
            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js" integrity="sha256-W9FML0cw6SfScX3k0Z8iTWhaZGSEUrR3R3KWfRA6lnI=" crossorigin="anonymous"></script>
    </body>
</html>
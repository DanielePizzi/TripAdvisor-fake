<?php

/* prendo l'id di riferimento del ristorante e creo il percorso per il decode
  in modo tale da non decodificare di nuovo tutti i file json ma solo quelli interessati */
/* prendo il valore id del ristorante */
$id = intval($_GET['id']);
/* prendo il valore rec della recensione per usarlo se necessario */
$rec = intval($_GET['rec']);
?>

<?php

/* funzione che stampa il contenuto della pagina */

function PrintRestaurantPage($id, $rec) {
    /* decodifico il file json interessato */
    $datastr = file_get_contents("data/r" . $id . ".json");
    $restaurant = json_decode($datastr, true);
    /* imposto il page title */
    global $pageTitle;
    $pageTitle = $restaurant['nome'];
    include("header.php");
    echo '<div class="container">';
    echo '<div class="presentation">';
    echo '<a href=/index.php> Back </a>';
    /* stampo e prendo l'id del ristorante e il nome */
    echo '<h1>' . $restaurant['nome'] . '</h1>';
    /* stampo immagine votazione */
    echo '<img src=img/rate-' . $restaurant['voto'] * 10 . '.png alt=""/>';
    /* stampo numero di votazioni */
    echo '<span class="review">' . count($restaurant['rev']) . ' review' . '</span>';
    /* stampa tipo cucina */
    echo '<br>';
    echo '<span>Cucina:</span>';
    foreach ($restaurant['cucina'] as $cooktype) {
        echo '<span class="coooktype">' . " $cooktype" . '</span>';
    }
    echo '<br>';
    /* stampo immaigine casuale */
    $photos = array_rand($restaurant['foto']);
    $photo = $restaurant['foto'][$photos];
    echo '<img class="image2" src=' . $photo . ' alt=""/>';
    echo '<br>';
    echo '</div>';
}

/* funzione che stampa i primi 5 commenti */

function PrintCommentPage($id, $rec) {
    /* decodifico il file json interessato */
    $datastr = file_get_contents("data/r" . $id . ".json");
    $restaurant = json_decode($datastr, true);
    if (count($restaurant['rev']) <= 4) {
        for ($i = $rec; $i < count($restaurant['rev']); $i++) {
            echo '<div class = "comment">';
            echo '<h2>' . '"' . $restaurant['rev'][$i]['titolo'] . '"' . '</h2>';
            echo '<img src=img/rate-' . $restaurant['rev'][$i]['voto'] * 10 . '.png alt=""/>';
            echo '<span>' . $restaurant['rev'][$i]['data'] . '</span>' . '<br>';
            echo '<span class="user">' . $restaurant['rev'][$i]['user'] . '</span>' . '<br>';
            echo '<p>' . $restaurant['rev'][$i]['note'] . '</p>';
            echo '</div>';
        }
     }else {
        for ($i = $rec; $i < $rec+5 ; $i++) {
            if(($restaurant['rev'][$i])!= null ){
            echo '<div class = "comment">';
            echo '<h2>' . '"' . $restaurant['rev'][$i]['titolo'] . '"' . '</h2>';
            echo '<img src=img/rate-' . $restaurant['rev'][$i]['voto'] * 10 . '.png alt=""/>';
            echo '<span>' . $restaurant['rev'][$i]['data'] . '</span>' . '<br>';
            echo '<span class="user">' . $restaurant['rev'][$i]['user'] . '</span>' . '<br>';
            echo '<p>' . $restaurant['rev'][$i]['note'] . '</p>' . '</p>';
            echo '</div>';
            }
        }
    }
    echo'</div>';
}

/* reindirizzamento alla pagina */
$pageValue = glob("data/r" . $id . ".json");
if ($pageValue) {
    if (isset($rec)) {
        PrintRestaurantPage($id, $rec);
        PrintCommentPage($id, $rec);
    } else {
        PrintRestaurantPage($id, 0);
        PrintCommentPage($id, 0);
    }
} else {
    $randomPages = glob("data/*.json");
    $randomPage = array_rand($randomPages);
    $file = $randomPages[$randomPage];
    $datastr = file_get_contents($file);
    $pageValue = json_decode($datastr, true);
    echo '<h1>ERROR 404:RISTORANTE NON TROVATO</h1>';
    echo '<h2><a href=/index.php> Torna alla HomePage </a></h2>';
    PrintRestaurantPage($pageValue['id'], $rec);
    PrintCommentPage($pageValue['id'], 0);
}
?>

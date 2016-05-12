<?php
global $pageTitle;
$pageTitle = "Main Page";
?>
<div class="container"> 
    <?php
    /* decodifica dei file json */
    $data_file = glob("data/*.json");
    foreach ($data_file as $restaurantfile) {
        $datastr = file_get_contents($restaurantfile);
        $data = json_decode($datastr, true);
        ?>
        <div class="row">
            <!-- immagine ristorante -->
            <img class="image" src= <?php echo $data['thumb'] ?> alt=""/>
            <div class="content">
                <!-- stampo e prendo l'id del ristorante e il nome -->
                <h1><a href="/index.php?id=<?php echo $data['id'] ?>" > <?php echo $data['nome'] ?> </a></h1>


                <!-- stampo immagine votazione -->
                <span>
                    <img src=<?php echo 'img/rate-' . $data['voto'] * 10 . '.png' ?> alt="" />

                    <!-- stampo numero di votazioni -->
                    <span class="review"><?php echo count($data['rev']) . ' review' ?> </span> </span>


                <?php
                /* stampa commenti casuali */
                $reviews = array_rand($data['rev'], 2);
                foreach ($reviews as $review) {
                    ?>  <ul>
                        <li><a href="/index.php?id=<?php echo $data['id'] ?>&rec=<?php echo $review ?>" > <?php echo '"' . $data['rev'][$review]['titolo'] . '"' ?> </a>
                            <?php echo $data['rev'][$review]['data']; ?></li>
                    </ul>
                    <?php
                }
                ?>

                <!-- stampa tipo cucina -->
                <span> Cucina:</span>
                <?php
                foreach ($data['cucina'] as $cooktype) {
                    ?>
                    <span class="coooktype"> <?php echo "$cooktype"; ?> </span>
                    <?php
                }
                ?>
            </div>
        </div>
        <?php
    }
    ?>
</div>

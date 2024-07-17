<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>

<body>

    <div class="search-container">
        <input type="text" placeholder="kacang hijau" name="search" id="search-input">
        <button id="search_btn"><span class="material-symbols-outlined">search</span></button>
    </div>
    <div class="card_container container" id="search_results"></div>
    <?php 
    print_r($data_page);
    die;
    ?>

    <div class="card_container container">
        <?php foreach ($data_page['result']['data'] as $p) : ?>
            <div class="card_produk">
                <div class="card">
                    <!-- <img src="/img/pitek.jpg" alt="" /> -->
                    <div class="card_text">
                        <p><?php echo  $p['product']; ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="container pagination">
        <?php if (!empty($data_page['result']['pagination']['prev'])) {
            $num = $data_page['result']['pagination']['prev']; ?>
            <a href="/tes?page=<?= $num; ?>">&laquo;</a>
        <?php }  ?>
        <?php for ($i = 1; $i <= $data_page['result']['pagination']['jumlah_page']; $i++) { ?>
            <a class="paginat" href="/tes?page=<?= $i; ?>"><?php echo $i ?></a>
        <?php } ?>
        <?php if (!empty($data_page['result']['pagination']['next'])) {
            $num = $data_page['result']['pagination']['next']; ?>
            <a href="/tes?page=<?= $num; ?>">&raquo;</a>
        <?php }  ?>
    </div>

    
</body>

</html>
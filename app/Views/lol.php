<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="lol.php" method="post">
        <ul>
            <label for="username">Username: </label>
            <input type="text" name="username" id="password">
            <br><br>
            <label for="password">Password: </label>
            <input type="password" name="password" id="password">
            <br><br>
            <button type="submit" name="submit">Login</button>
        </ul>
    </form>

    <form action="" method="post">
        <input type="text" name="search">
        <button type="button" id="search-button">gas</button>
    </form>
    <?php

    if (isset($_POST["search-button"])) {
        // $value = $_POST["search-button"];
        $search = $_POST['search'];
        header("Location: http://localhost:8080/lol?search=" . $value);
    }

    ?>

    <div class="card_container container">
        <?php foreach ($data_page['result']['data'] as $p) : ?>
            <div class="card_produk">
                <div class="card">
                    <img src="/img/pitek.jpg" alt="" />
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
            <a href="/lol?page=<?= $num; ?>">&laquo;</a>
        <?php }  ?>
        <?php for ($i = 1; $i <= $data_page['result']['pagination']['jumlah_page']; $i++) { ?>
            <a class="paginat" href="/lol?page=<?= $i; ?>"><?php echo $i ?></a>
        <?php } ?>
        <?php if (!empty($data_page['result']['pagination']['next'])) {
            $num = $data_page['result']['pagination']['next']; ?>
            <a href="/lol?page=<?= $num; ?>">&raquo;</a>
        <?php }  ?>
    </div>
</body>

</html>
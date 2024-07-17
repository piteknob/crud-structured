<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>
    <div class="container d-flex flex-column">
        <div class="">
            <button type="button" class="float-end btn btn-danger m-1 "><a href="/admin" class="text-light pt-1" style="text-decoration: none;">&#128473;</a></button>
        </div>
        <?php //print_r($data_edit); die;  ?>
        <?php $data_edit = $data_edit['result']['data']; ?>

        <?php foreach ($data_edit as $key => $value) { ?>

            <div class="row">
                <div class="col-md-12 overflow-hidden">
                    <h2 class="text-center">Edit Produk</h2>
                    <hr>
                    <?php 
                    $id = $_GET;
                    $id = $id['id'];
                    ?>
                    <form action="postData" method="post">
                        <input type="hidden" id="id" name="id" value="<?= $id; ?>">
                        <div class="mb-3">
                            <label for="namaProduk" class="form-label">Nama Produk</label>  
                            <input type="text" class="form-control" id="namaProduk" name="namaProduk" value="<?= $value['product']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="harga_beli" class="form-label">Harga Beli</label>
                            <input type="number" class="form-control" id="category" name="category" autocomplete="off" value="<?= $value['id_category']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="harga_beli" class="form-label">Harga Jual</label>
                            <input type="number" class="form-control" id="unit" name="unit" autocomplete="off" value="<?= $value['id_unit']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="stock" class="form-label">Stock</label>
                            <input type="number" class="form-control" id="stock" name="stock" autocomplete="off" value="<?= $value['stock']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="stock" class="form-label">Stock</label>
                            <input type="number" class="form-control" id="buy" name="buy" autocomplete="off" value="<?= $value['price_buy']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="stock" class="form-label">Stock</label>
                            <input type="number" class="form-control" id="sell" name="sell" autocomplete="off" value="<?= $value['price_sell']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="stock" class="form-label">Created at</label>
                            <p class="fs-5"><?= $value['created_at']; ?></p>
                        </div>
                        <div class="mb-3">
                            <label for="stock" class="form-label">Updated at</label>
                            <p class="fs-5"><?= $value['updated_at']; ?></p>
                        </div>
                        <div class="footer" style="height: 70px;">
                            <footer class="footer py-3 bg-light" style="position: fixed; left: 0;bottom: 0;width: 100%; ">
                                <div class="container text-center">
                                    <button type="submit" class="btn btn-primary px-5 ">Simpan</button>
                                    <button type="button" class="btn btn-danger px-5 "><a href="/admin" class="text-light" style="text-decoration: none;">Kembali</a></button>
                                </div>
                            </footer>
                        </div>
                    </form>
                <?php } ?>
                </div>
            </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
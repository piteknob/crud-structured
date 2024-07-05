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

    <script>
        function search() {
            $("#search_results").html("");
            $.ajax({
                url: "https://pitekapi.000webhostapp.com/listpublic/listproduct",
                type: "get",
                dataType: "json",
                data: {
                    'pagination': 'true',
                    'search': $("#search-input").val(), //meminta jquery untuk mengambil inputan dari html dengan id search-input dan val() adalah ambil apa saja 
                },
                success: function(result) {
                    if (result.Response == "True") {
                        let produk = result.Search;
                        $.each(produk, function(data) {
                            $("#search_results").append(
                                ` 
        <div class="card_produk"> 
                div class="card"> 
                <img src="/img/pitek.jpg" alt="" /> 
                <div class="card_text"> 
                    <p>` + data.product + `</p> 
                </div> 
            </div> 
        </div> 
              `
                            );
                        });

                        $("#search-input").val("");
                    } else {
                        $("#search_results").html(
                            ` 
              <h1 class="text-center">` +
                            result.error +
                            `</h1> 
          `
                        );
                    }
                },
            });
        }

        $("#search_btn").on("click", function() {
            search();
        });

        $('#search-input').on('keyup', function(e) {
            if (e.keyCode === 13) {
                search();
            }
        });
    </script>
</body>

</html>
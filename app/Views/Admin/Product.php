<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title>Navigation Bar With Scroll Every Section</title>
    <link rel="stylesheet" href="/css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

</head>

<body>
    <nav>
        <div class="navbar">
            <div class="sideBar">
                <div class="logoNiga"><a href="#"><span class="material-symbols-outlined"><button class="btn text-light " type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">side_navigation</button></span></a></div>
            </div>
            <div class="linkNavbar">
                <ul class="menu">
                    <li><a href="#">Product</a></li>
                    <li><a href="#">Category</a></li>
                    <li><a href="#">Unit</a></li>
                    <li><a href="#">Customer</a></li>
                    <li><a href="#">Transaction</a></li>
                </ul>
                <ul>
            </div>
            <div class="logOut">
                <li><a href="#">Log out</a></li>
            </div>
            </ul>
        </div>
    </nav>
    </div>


    <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">Enable both scrolling & backdrop</button>

    <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasWithBothOptionsLabel">Backdrop with scrolling</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <p>Try scrolling the rest of the page to see this option in action.</p>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
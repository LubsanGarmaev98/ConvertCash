<!DOCTYPE html>
<!-- Coding By Codequs - youtube.com/codequs -->

<?php
?>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Currency Converter App in JavaScript | Codequs</title>
    <link rel="stylesheet" href="style/convert.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- FontAweome CDN Link for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
</head>
<body>
<div class="wrapper">
    <header>Currency Converter</header>
    <form method="POST" action="http://localhost/convert">
        <div class="amount">
            <p>Enter Amount</p>
            <input type="text" name="value" value="1">
        </div>
        <div class="drop-list">
            <div class="from">
                <p>From</p>
                <div class="select-box">
                    <select name="charCodeL">
                        <option value="RUB" selected>RUB</option>
                        <?php
                            /** @var \App\Entity\Currency $valute */
                        foreach ($valutes as $valute)
                            {
                                if($valute->getCharCode() !== "RUB")
                                {
                                    echo '<option value=' . $valute->getCharCode() . '>' . $valute->getCharCode() . '</option>';
                                }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="icon"><i class="fas fa-exchange-alt"></i></div>
            <div class="to">
                <p>To</p>
                <div class="select-box">

                    <select name="charCodeR">
                        <option value="USD" selected>USD</option>
                        <?php
                            /** @var \App\Entity\Currency $valute */
                            foreach ($valutes as $valute)
                            {
                                if($valute->getCharCode() !== "USD")
                                {
                                    echo '<option value=' . $valute->getCharCode() . '>' . $valute->getCharCode() . '</option>';
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="exchange-rate">Getting exchange rate...</div>
        <button>Get Exchange Rate</button>
    </form>
    <div class="amount">

        <?php
            if(!empty($result))
            {
                echo '<p>Result</p>';
                echo '<input type="text" name="value" value="' . $result . '">';
            }
        ?>
    </div>
    <br>
    <button class="w-100 btn btn-lg btn-primary" type="submit">Sign out</button>
</div>

</body>
</html>
<?php

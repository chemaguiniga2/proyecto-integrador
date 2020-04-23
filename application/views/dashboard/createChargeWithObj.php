<html>
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    </head>
    <body>
    <form action="/Billing/chargeWithObject" method="post">
        <label for="card_number">Card:</label><br>
        <input type="text" id="card_number" name="card_number"><br>
        <label for="cvv">CVV</label><br>
        <input type="text" id="cvv" name="cvv"><br><br>
        <label for="mm">mm</label><br>
        <input type="text" id="mm" name="mm"><br><br>
        <label for="aa">aa</label><br>
        <input type="text" id="aa" name="aa"><br><br>
        <input type="submit" value="Submit">
    </form>
        
    </body>

    <script>
        //document.getElementById("needs-validation").submit();

    </script>
</html>
<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.6.0/dist/solar/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

    <title>New Sale creation</title>

    <style>
    </style>

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>

<body>
<p class="h2 text-center"> New Sale Creation </p>
<div style="text-align:center;">
    <iframe width="740" height="550"  src="<?php echo $paymentUrl;?>"></iframe>
</div>


    <input type="Submit" name="show" id="show" class="btn btn-success" value="Payment">
    <input type="hidden" name="code" id="code" class="btn btn-success" value="<?php echo $code;?>">

<div class="tableToggle" style="display:none;" >

    <table id="sale" class="table table-bordered table-striped table-hover">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Sale Number </th>
            <th scope="col">Description</th>
            <th scope="col">Amount</th>
            <th scope="col">Currency</th>
            <th scope="col">Payment Link</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function() {
        let request;

        $("#show").click(function (event) {
            event.preventDefault();
            let code = $('#code').val();
            request = $.ajax({
                url: './api/show-sale',
                type: "get",
                data: {'code': code}
            });

            // Disable Submit Till Ajax Returns
            $(':input[type="submit"]').prop('disabled', true);

            request.done(function (response){
                      $('.tableToggle').show();
                    let row = $("<tr><td>"+response.id
                        +"</td><td>" + code
                        +"</td><td>" + response.description
                        +"</td><td>" + response.amonut
                        +"</td><td>" + response.currency
                        +"</td><td>" + response.url
                        +"</td>");

                    $("#sale > tbody").append(row);
            });

            // Callback handler that will be called on failure
            request.fail(function (jqXHR, textStatus, errorThrown){
                // Log the error to the console
                console.error(
                    "The following error occurred: "+
                    textStatus, errorThrown
                );
            });

            // Enable Submit button back
            request.always(function() {
                $(':input[type="submit"]').prop('disabled', false);
            });
        });
    });
</script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <title>CHARD | Portal</title>
    <link rel="shortcut icon" type="image/x-icon" href="./img/ChardLogo.png">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="Evan Kim">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="./css/bootstrap/bootstrap.css">
    <script src="./js//bootstrap/bootstrap.js"></script>

    <script src="./js/jquery-3.4.1.min.js"></script>

	<link rel="stylesheet" href="./css/style.css">
</head>

<body>
<noscript>You need to enable JavaScript to run this app.</noscript>

<div class='root' style='display:block;'>
    <div class='container'>
        <div class="row header">
            <div class="col">
                <span class="navbar-brand mb-0 h6"><h3>CHARD</h3></span>
            </div>
        </div>

        <div id='create'class="row body">
            <div class="col">
                <form>
                    <div class="form-group">
                        <label for="name">New List Name</label>
                        <input style='margin-bottom:1em;' type="text" class="form-control" id="newListName" placeholder="Name" maxlength="30">
                    </div>
                </form>
                <div class="alert border-warning alert-warning warning alert-dismissible error-box" id='create-error-box'>
                    <a class="close" aria-label="close">&times;</a>
                    <strong></strong>
                    <h6></h6>
                </div>
                <div class='row' style='padding-left:15px;padding-right:15px;margin-bottom:1em;'>
                      <div class='col'>
                          <div id='createList' class="btn btn-primary btn-block ld-ext-right">
                            Create List
                            <div class="ld ld-ring ld-spin"></div>
                        </div>
                      </div>
                      <div class='col'>
                          <div id='cancel' class="btn btn-secondary btn-block ld-ext-right">
                            Cancel
                            <div class="ld ld-ring ld-spin"></div>
                        </div>
                      </div>
                  </div>
            </div>
        </div>
    </div>
</div>

<script src="./js/create.js"></script>
</body>
</html>
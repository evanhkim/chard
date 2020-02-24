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
        <div id='index' class="row body">
            <div class="col">
                <div class="alert warning border-warning alert-dismissible error-box" id='google-error-box'>
                    <a class="close" aria-label="close">&times;</a>
                    <strong></strong>
                    <h6></h6>
                </div>
                <form>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" aria-describedby="emailHelp"
                               placeholder="Enter email">
                    </div>
                </form>
                <form>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Password">
                    </div>
                </form>
                <div class="alert border-warning alert-warning warning alert-dismissible error-box"
                     id='index-error-box'>
                    <a class="close" aria-label="close">&times;</a>
                    <strong></strong>
                    <h6></h6>
                </div>
                <div class="alert border-success alert-success success alert-dismissible error-box"
                     id='index-success-box'>
                    <a class="close" aria-label="close">&times;</a>
                    <strong></strong>
                    <h6></h6>
                </div>
                <div class='row' style='padding-left:15px;padding-right:15px;'>
                    <div class='col'>
                        <div id='login' class="btn btn-primary btn-block ld-ext-right">
                            Login
                            <div class="ld ld-ring ld-spin"></div>
                        </div>
                    </div>
                    <div class='col'>
                        <div id='create' class="btn btn-secondary btn-block ld-ext-right">
                            Create Account
                            <div class="ld ld-ring ld-spin"></div>
                        </div>
                    </div>
                </div>
                <button id='forgot' type="button" class="btn btn-link">Forgot Password?</button>
            </div>
        </div>

        <div id='admin'class="row body">
            <div class="col">
                <h5 class='text-center' id='user'>User</h5>
                <div class='divide'></div>
                <div class="alert border-warning alert-warning warning alert-dismissible error-box" id='admin-error-box'>
                    <a class="close" aria-label="close">&times;</a>
                    <strong></strong>
                    <h6></h6>
                </div>
                <div class="alert border-success alert-success success alert-dismissible error-box" id='admin-success-box'>
                    <a class="close" aria-label="close">&times;</a>
                    <strong></strong>
                    <h6></h6>
                </div>
                <form>
					<div class="form-group">
						<label for="listNames">Card Sets</label>
						<select id='listNames' class="form-control" size='9'>
						</select>
					</div>
				</form>		
                  <div id='createList' class="btn btn-primary btn-block ld-ext-right">
                    Create New List
                    <div class="ld ld-ring ld-spin"></div>
                  </div>
                  
                  <div class="btn-group btn-block" role="group">
                    <div id='editList' class="btn btn-outline-primary ld-ext-right" style="width:50%">
                        Edit List
                        <div class="ld ld-ring ld-spin"></div>
                    </div>
                    <div id='remList' class="btn btn-outline-secondary ld-ext-right" style="width:50%">
                        Remove List
                        <div class="ld ld-ring ld-spin"></div>
                    </div>
                   </div>
                    
                <div id='practiceList' class="btn btn-secondary btn-block ld-ext-right">
                       Practice
                    <div class="ld ld-ring ld-spin"></div>
                </div>

                  <div class='divide'></div>

                <div id='logOut' class="btn btn-outline-danger btn-block ld-ext-right">
                    Log Out
                    <div class="ld ld-ring ld-spin"></div>
                </div>
            </div>
        </div>

        <div id='reset'class="row body">
            <div class="col">
                <form>
                    <div class="form-group">
                        <label for="email"></label>
                        <input type="email" style='margin-bottom:1em;' class="form-control" id="emailReset" aria-describedby="emailHelp" placeholder="Enter email">
                    </div>
                </form>
                <div class="alert border-warning alert-warning warning alert-dismissible error-box" id='reset-error-box'>
                    <a class="close" aria-label="close">&times;</a>
                    <strong></strong>
                    <h6></h6>
                </div>
                <div class='row' style='padding-left:15px;padding-right:15px;margin-bottom:1em;'>
                      <div class='col'>
                          <div id='resetPwd' class="btn btn-primary btn-block ld-ext-right">
                            Reset Password
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

<script src="./js/portal.js"></script>
</body>
</html>
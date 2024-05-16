<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticketing System</title>
    <link rel="stylesheet" href="./CSS/styles.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>
  <div class="wrapper">
    <form class="form-signin" id = "login-form" method = "post">       
      <h2 class="form-signin-heading">Please login</h2>
      <input type="text" class="form-control" id="username" placeholder="Username" required="" autofocus="" />
      <br/>
      <input type="password" class="form-control" id="password" placeholder="Password" required=""/>      
      <label class="checkbox">
        <input type="checkbox" value="remember-me" id="rememberMe" name="rememberMe"> Remember me
      </label>
      <button class="btn btn-lg btn-primary btn-block" type="submit" id="login-form-submit">Login</button>   
    </form>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script>

    var data = {data:[{"username":"bokadm","password":"1f9d719130be748bb754990b73a4a7f3"}]};

    console.log(data);
    $(document).ready(function(){
      $.ajax({
          url:"http://localhost/TESTPHP/User/loginUser.php",
          type: "POST",          
          dataType: "json",
          contentType: "application/json;charset=utf-8",
          data : JSON.stringify(data),
          success:function(result){
            console.log(result);
          },
          error: function(result){
            console.log(result);
          }
      })
    })
  </script>
</body>
</html>
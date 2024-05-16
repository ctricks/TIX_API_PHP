const loginForm = document.getElementById("login-form");
const loginButton = document.getElementById("login-form-submit");

loginButton.addEventListener("click", (e) => {
    e.preventDefault();
  
    const username = loginForm.username.value;
    const password = loginForm.password.value;
    const objParam = {data: [{username: username, password: password}]};

    $.post("http://localhost/TESTPHP/User/loginUser.php", objParam, function(data){
		console.log(data);
	});
 
})


# TIX_API_PHP
Ticketing API created on PHP and MySQL Database

# API Information

User Queries
1. Create User
POST->http://localhost/TESTPHP/User/createUser.php
Payload:     
{  
    "data": [
        {
        "username": "<Username Here>",
        "password": "<Password Here>",
        "RoleID": <Id from table role here (numeric)>,      
        "Remarks": "<Remarks here (optional) or Blank>"
        }
    ]
}
2. List User/s
POST->http://localhost/TESTPHP/User/listUser.php
-No payload if list all
-Make Parameter in URL if(filter by id or Username)
Ex. http://localhost/TESTPHP/User/listUser.php?id=1
3. Update User -> nothing to modify here but I add this for my sample template
POST->http://localhost/TESTPHP/User/udpateUser.php?id=1
Payload:
{
  "data": [
    {
      "username": "",
      "Remarks": "<Cannot be change the username>"
    }
  ],
  "conditions": [
    {
      "on": "id",
      "type": "=",
      "value": "1"
    }
  ]
}
4. De/active User no need to delete records
POST->http://localhost/TESTPHP/ActivateUser.php
POST->http://localhost/TESTPHP/deActivateUser.php
-No payload if list all
-Make Parameter in URL if(filter by id or Username)

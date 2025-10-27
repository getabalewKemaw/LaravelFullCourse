-to get the csrf token u can use the  csrf_token() helper function 

- or in the request function

$token=$request->session()->token(); these is for the getetign  the token for  the logged in users 


-> when  we do paymnet integrations   form a provdier  we do not include  the csrf token if use that  we weill get an error becusse the laravel csrf token can no tknow that 
-> so to secure the paymnet applicstins  u can use 
-in the app.php we can exclude the routes for that  payment provider  using the  $except array method in the app.php in side the bootstarp folder
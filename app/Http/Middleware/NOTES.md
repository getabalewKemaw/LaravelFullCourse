a middleware is  a small layers b/n  the http requerst atnd the application
   - it can inspect the request (is the user is logged in)
   -stop the  request and send the reponse 
   -let it continue using $next($request)

   - defing the middlwware using the artisan is 
   php artisan make:middleware AuthMiddleware


    2-> register the middleawre in  app.php in the bootstrap folder  -the porpose of these is   when the app runned allways these middleaware executes





##all about the request http request
it gives u acess to the data that comes with the requesr




it is the wrapper for the current 

It gives you a fluent, object-oriented API to read:

query string (GET) data,

request body (POST / JSON / form-data),

files,

headers & cookies,

route params,

client metadata (IP, scheme),

session and flashed input helpers

 -> when the controlelr use that request and when we use in the injection methdos 
 first  -> 4 request first anf after that we can add adional parametrs  then route parameters are automatically ng injected after resolving the requests 

    
a middleware is  a small layers b/n  the http requerst atnd the application
   - it can inspect the request (is the user is logged in)
   -stop the  request and send the reponse 
   -let it continue using $next($request)

   - defing the middlwware using the artisan is 
   php artisan make:middleware AuthMiddleware


    2-> register the middleawre in  app.php in the bootstrap folder  -the porpose of these is   when the app runned allways these middleaware executes



    
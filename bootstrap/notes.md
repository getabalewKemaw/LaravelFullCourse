all service providers extend 

Illuminate\Support\ServiceProvider
-as u know most service providers contaib a register and a  boot  method
1 the register method do bind things to the service conainer 
event listeners,routes can not be registerd in these methods

-to generate a  new  provider using the php artisan 
the command is  
php artisan make:provider providername 
then laravel authomically regsiter the new to the provider.php files 

2 the boot method is perform action that require other actions

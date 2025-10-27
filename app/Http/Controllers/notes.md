-> u can declare multiple  methods in a single controller abd finanly we cam use in the group routes 

like 
Route::controller('controllername')->group(function(){
    Route::get('/','index');
    Route::post('/','store');
});


-> we  can a use a single action controler when we need to perform  only one task in side a one controller  

-> the next thing is resource controllers it is used for when we want  crud opration  to my app 
  when we create those with --recourse method it genrates  the follwing defualt function those are 

  index()     → Show all products
create()    → Show form to create new product
store()     → Save new product
show($id)   → Show one product
edit($id)   → Show edit form
update()    → Update product
destroy()   → Delete product

-> in these if u donot need all of them u can use  only and execpt methode  when we defines a routes


-> nested resources

-> singleton resources controllers   
   it is used  where u only have one instance per user 
that is shared across your entire application. For example, you might be building an API that returns a user's profile information.


-> and when we create  a resource routes in the route files

Route:resoure('products,yourresourecontrllaerclass name)

-> when we do these laravel craete all 7 routs automaically the routes are the follwing



📜 The 7 auto-created routes:
HTTP Method	URI	Controller Method	Purpose
GET	/products	index()	Show all products
GET	/products/create	create()	Show form to create a new product
POST	/products	store()	Save new product
GET	/products/{product}	show()	Show single product
GET	/products/{product}/edit	edit()	Show edit form
PUT/PATCH	/products/{product}	update()	Update product
DELETE	/products/{product}	destroy()	Delete

 product

 we can replace the products with what ever th what ever u want
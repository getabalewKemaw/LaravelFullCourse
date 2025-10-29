

to get the sesion  id of the current logged in user  using the sessionkey method is 

$value=$request->session()->get('key');

and also we can pass the defualt value for that is the  key does not exist
 so after get('key','defualtvalue')


 -> using the global session  handler it is used for retriving the session data from the db and from anywhre

-> if u  wanna  retrive all the session data u can use the all methodws

$data=$request->session()->all();



-> and also when we want to retrive a portion  or some parst from the session  data we can use the only and  execept methods it is like

$data=$request->session()->only(['name','email']);

and if u wanna exclude some session date with execept

$data=$request->session()->except(['name','email'])-> these means all the session date are retrived ececept the name and email ;


### determinig if an item existe with in a session 

-> thre are three methodes to check these 
1 using the has() methods and it returns true if the item is present and and it is not 
-> usage

if($request->session()->has('key)){

}

-> the secound method is the exists() method it returns true if the item is present and in contrast to the has method it returs true id the values is just null;



if($request->session()->exists('key){
    do sth
}

-> the thirs method  is the missing method the use  of thes e method isn for the porpose of checkign if the specific  sesion data is not present if not present it returns true else false;

if($request->session()->missing('key')){
    do sth;
}

### storing data in to session 

-> in these there  are also two methods the first one  via request instance and via  the global session handler functions


-> in the first using the request instance we use put method(with key and values)

$request->session()->put('key','value');


-> the secound method is using the global session handler

session(['key'=>'value'])

-> to  push an item in to the sessions u  can use the  push method

just like

$request->session()->push('users',['john','doe']);


### retriving  and deletign an item using the pull method in the sessins

-> this method will return the value of the specified key and then delete it from the session

$value=$request->session-()->pull('key',defualt methods if it is not exixsts)

### Flash data

->flash data is use full when we 
want to store the items in the session for the next request ,and it is avalible for the subsequent requests 
but after these subsequent requests the flash data will be deleted automatically

-< the main porpose > of flash data is for short liived data messsages


example

$request->session()->flash('status',"task completed succsuful")

so these will be removed afeter the next request 
so i  u wanna persist it u can use the reflash methods

$request->session()->reflash();

$request->session()->keep(['status','error']); //these will keep the status and error messages
 if u  wanan for the current request only u  can the use now() methods

 $requesr->session()->now('stus','message)




 ### Deleting Data
The forget method will remove a piece of data from the session. If you would like to remove all data from the session, you may use the flush method:

// Forget a single key...
$request->session()->forget('name');
 
// Forget multiple keys...
$request->session()->forget(['name', 'status']);
 
$request->session()->flush()

if u wann regernerate the session id
$request->session()->regenerate();
and if u wanna  regenearte the session id and wanna remove the s session in a a single statement

$request->session()->invalidate();



#3# Session catche
 -is used for catching tnhe session data for the specific user unlike the global cache methods
 >  and remember it is used for  catching the session data in the same session (the same user (sepecific user))


$discount = $request->session()->cache()->get('discount');
 
$request->session()->cache()->put(
    'discount', 10, now()->addMinutes(5)
)
<?php
use App\Work;
use App\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| creating resource for the Controller it gives basic urls
|--------------------------------------------------------------------------
|
*/

Route::resource('post','PostController');
// Route::get('/post/{id}', 'PostController@index'); // It is use to create url for the resource for separate

/*
|--------------------------------------------------------------------------
| creating urls that are create as manual function
|--------------------------------------------------------------------------
|
*/
Route::get('/contact', 'PostController@contact');
Route::get('/show/{id}/{name}','PostController@show_post');


/*
|--------------------------------------------------------------------------
| Database access using querys
|--------------------------------------------------------------------------
|
*/

//Insert
Route::get('/insert', function (){
  DB::insert('insert into works(name, user_id, design, is_admin) values(?, ?, ?, ?)', ['Krishoth', 1, 'Software Developer', 0]);
});

//Selet
Route::get('/read', function (){
  $results = DB::select('select * from works where id =?', [1]);
  foreach ($results as $result) {
    return $result-> design. ", ".$result-> name;
  }
  // return result; //It will print row as array json
  // return var_dump(result); // It will print row as array class index reference
});

//Update
Route::get('/update', function (){
  $updated = DB::update('update works set name = ? where id = ?',["Krishoth Kumar", 1]);
  return $updated;
});

//Delete
Route::get('/delete', function (){
  $delete = DB::delete('delete from works where id = ?',[2]);
  return $delete;
});



/*
|--------------------------------------------------------------------------
| Basic return
|--------------------------------------------------------------------------
|
*/

Route::get('/about', function () {
    return "I am Krishoth";
});

Route::get('/contact', function () {
    return "+91 7299070171";
});

/*
|--------------------------------------------------------------------------
| Getting value from urls
|--------------------------------------------------------------------------
|
*/

Route::get('/get/{id}', function($id){
  return "This id number is ".$id;
});

/*
|--------------------------------------------------------------------------
| assigning Name for the Url
|--------------------------------------------------------------------------
|
*/

Route::get('/admin/krishoth', array('as'=>'admin.home', function(){
  $url =route('admin.home');
  return $url;
  }));

/*
|--------------------------------------------------------------------------
|ELOQUENT ORM
|--------------------------------------------------------------------------
|
*/
Route::get('/all', function(){
  $works = Work::all();
  foreach ($works as $work) {
    // code...
    return $work ->design;
  }
});

Route::get('/find', function(){
  $work = Work::find(1);
  return $work->name;
});

Route::get('/findwhere', function(){
  //first()  or firstOrFail() it git 404 error
  $work = Work::where('id', 1)->get(); // ->orderBy('id', desc) it order the result ->take(1) it take one
  return $work;
});

Route::get('/basicinsert',function(){
  $work = new Work;

  $work-> name = 'Pradeep';
  $work-> design= 'Software Developer';
  $work-> is_admin= 0;

  $work->save();
});

Route::get('/basicupdate',function(){
  $work = Work::find(1);

  $work-> name = 'Krishoth Kumar';
  $work-> design= 'Software Developer';
  $work-> is_admin= 1;

  $work->save();
});

//mass assignment
Route::get('/create', function(){
  Work::create(['name'=>"Jayanth", 'user_id'=>2, 'design'=> 'S.Software Developer', 'is_admin'=> 0]);
});

//update function
Route::get('/updates', function(){
  Work::where('id',1)->where('is_admin', 1)->update(['name'=>"Krishoth Kumar M", 'is_admin'=> 1]);
});

Route::get('/deleted', function(){
  $work = Work::find(3);
  $work->delete();
});

Route::get('/del', function(){
  Work::destroy(8);  // destroy([3,4]);

  // Works::where('is_admin', 0)->delete(); //delete with condition
});



Route::get('/softdelete', function(){
  Work::find(6)->delete();

});

Route::get('/readsoftdelete', function(){
  // return Works::find(4); // softdelete will not showing
  return Work::withTrashed()->where('is_admin',0)->get(); // it will show softdelete items with condition without condition all
  // return Works::onlyTrashed()->get(); // it will give only softdelete items or may give conditions

});

Route::get('/restoresoft', function(){
 return Work::withTrashed()->where('is_admin',0)->restore();
});

// Route::get('/perdel', function(){
//   Work::onlyTrashed()->where('is_admin',0)->forceDelete();
// });


/*
|--------------------------------------------------------------------------
|ELOQUENT Relationship
|--------------------------------------------------------------------------
|
*/

//one to one Relationship
Route::get('/user/work/{id}', function($id){
  return User::find($id)->work->design;
});

Route::get('/work/user/{id}', function($id){
  return Work::find($id)->user;
});


// Route::get('/user/many/{id}', function($id){
//   $user = User::find($id);
//   foreach ($user->works as $des) {
//     // code...
//     echo $des->design."<br>";
//   }
// });
Route::get('/user/many/{id}', function($id){
  $user = User::find($id)->works;
  // return $user;
  foreach ($user->design as $des) {
    // code...
    echo $des."<br>";
  }
});

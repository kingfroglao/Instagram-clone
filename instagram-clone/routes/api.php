<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

use MongoDB\Laravel\Document;

use App\Models\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/*
   Send a ping to our MongoDB cluster to see if our connection settings are correct
*/
Route::get('/test_mongodb/', function (Request $request) {

    $connection = DB::connection('mongodb');
    $msg = 'MongoDB is accessible!';
    try {
        $connection->command(['ping' => 1]);
    } catch (\Exception $e) {
        $msg =  'MongoDB is not accessible. Error: ' . $e->getMessage();
    }

    return ['msg' => $msg];
});

/*
    Create a new "customer" in our SQL database
    This is just to show the code looks identical to the MongoDB version
*/
Route::get('/create_eloquent_mongo/', function (Request $request) {
    try {
        $success = User::create([
            'id'        => '0',
            'username'  => 'John',
            'email'       => 'j.doe@gmail.com',
            'password'     => '123456'
        ]);
        $msg = "OK";
    }
    catch (\Exception $e) {
        $msg =  'Create user via Eloquent MongoDB model. Error: ' . $e->getMessage();
        //$msg = 'MongoDB operation failed'. $e->getTraceAsString();
    }

    return ['status' => 'executed', 'data' => $msg];
});

Route::get('/test_mongo', function () {
    try {
        // $collection = DB::connection('mongodb')->collection('users');
        // $result = $collection->insert([
        //     'username' => 'John',
        //     'email' => 'j.doe@gmail.com',
        //     'password' => '123456'
        // ]);
        $result = DB::connection('mongodb')->collection('users')->get();
        return response()->json(['success' => $result]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()]);
    }
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

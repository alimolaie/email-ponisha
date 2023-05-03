<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Webklex\IMAP\Facades\Client;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $oClient = Client::account('default');
        $oClient->connect();
        $oFolder = $oClient->getFolder('Inbox');
       $aMessages = $oFolder->query()->all()->get();
        return view('home',compact('aMessages'));
    }
}

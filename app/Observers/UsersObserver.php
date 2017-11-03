<?php
/**
 * Created by PhpStorm.
 * User: smith
 * Date: 10/30/17
 * Time: 6:26 PM
 */

namespace App\Observers;


use GuzzleHttp\Psr7\Request;

class UsersObserver
{

    protected $request;

    public function __construct(Request $request)
    {
        $this->request=$request;
    }

    public function updated(Request $request){
        $this
    }


}
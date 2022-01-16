<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * BaseController is controlling the routing 
 *
 */  
class BaseController extends Controller
{
    /**
     * route the user to desirec action file 
     * 
     * @param Request $request The request received.
     * @param string  $action  The Action file.
     */
    public function route( Request $request, $action )
    {
        $class_fqns = 'App\\Actions\\'.ucfirst( $action ).'Action';
        if ( !class_exists( $class_fqns ) )
        {
           return '404 - Action ' . $action . ' not found.';
        }

        $class = new $class_fqns();

        if ( $class->method() !== $request->method() )
        {
            return 'invalid method!';
        }

        $validation = Validator::make( $request->all(), $class->validation());

        if ( $validation->fails() )
        {
            return $validation->errors();
        }

        return $class->render();
    }
}

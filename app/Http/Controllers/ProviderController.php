<?php

namespace App\Http\Controllers;

use App\Provider;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    /**
     * show book providers
     * @return mixed
     */

    public function show()
    {
        $provider = Provider::select('providerName')->get();

        return $provider;
    }
}

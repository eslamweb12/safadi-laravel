<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Services\CurrencyConverter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class CurrencyConverterController extends Controller
{

   public function store(Request $request){
    $request->validate([
        'currency_code'=>'required|string|size:3',

    ]);
    $baseCurrencyCode=config('app.currency');
    $currencyCode=$request->input('currency_code');

    $cahceKey='currency_rate_'.$currencyCode;

    $rate=Cache::get($cahceKey,0); 
    if(!$rate){
        $converter = new CurrencyConverter(config('services.currency_converter.api_key'));
        $rate=$converter->convert($baseCurrencyCode,$currencyCode);
        Cache::put($cahceKey,$rate,now()->addMinute(60));



    }

    Session::put('currency_code',$currencyCode);
    return redirect()->back();
   }
}

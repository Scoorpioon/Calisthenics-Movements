<?php

namespace App\Http\Controllers;

use App\Calisthenic;
use App\Service\CreateOfCalisthenics;
use App\Service\ManageCookies;
use Illuminate\Http\Request;

class CalisthenicsController extends Controller
{


    public function lastCreated()
    {
        ManageCookies::destroyCookieLastMovement();

        return view('calisthenics.lastMovement');
    }

    public function index(Request $request)
    {
        $calisthenics = Calisthenic::all();
        $calisthenic = array();

        $index = 0;
        foreach($calisthenics as $element){
            $calisthenic[$index] = $element;
            $index++;
        }

        $message = $request->session()->get('message');

        return view('calisthenics.index',compact('calisthenics','calisthenic','message'));
    }

    public function create()
    {
        return view('calisthenics.create');
    }

    public function store(Request $request, CreateOfCalisthenics $createOfCalisthenics)
    {
        $calisthenic = $createOfCalisthenics->createCalisthenics($request);

        if(!($calisthenic instanceof Calisthenic))
            $request->session()->flash("message", $calisthenic);
        else
            ManageCookies::createCookieLastMovement($calisthenic);

        return redirect()->route('index');
    }

    public function show($id)
    {
        //
    }

    public function edit(Request $request, Calisthenic $calisthenic, CreateOfCalisthenics $updateOfCalisthenics)
    {
        $calisthenic = $updateOfCalisthenics->updateCalisthenics($request, $calisthenic);

        if(!($calisthenic instanceof Calisthenic))
            $request->session()->flash("message", $calisthenic);
        else
            $calisthenic->save();

        return redirect()->route('index');
    }

    public function update(Request $request, Calisthenic $calisthenic)
    {
        return view('calisthenics.create',compact('calisthenic'));
    }

    public function destroy(Calisthenic $calisthenic)
    {
        $calisthenic->delete();
        return redirect()->route('index');
    }


}

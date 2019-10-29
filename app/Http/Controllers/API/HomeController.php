<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function getAllForMakers(){
        $beer = DB::table("beer as b")
            ->leftJoin("BeerTypes as t", "b.typeID", "t.id")
            ->leftJoin("BeerMakers as m", "b.makerID", "m.id")
            ->select("b.name as name", "b.description as desc", "t.name as type", "m.name as maker")
            ->get();
        return response()->json(compact('beer'));
    }

    public function getAllForTypes(){
        $beer = DB::table("beertypes as t")
            ->join("beer as b", "b.typeID", "t.id")
            ->leftJoin("BeerMakers as m", "b.makerID", "m.id")
            ->select("b.name as name", "b.description as desc", "t.name as type", "m.name as maker")
            ->get();
        return response()->json(compact('beer'));
    }

    public function getAvailableMakersAndTypes(){
        $res = [DB::table("BeerMakers as b")->get(), DB::table("BeerTypes")->get()];
        return response()->json(compact('res'));
    }

    public function getMakers(){
        $makers = DB::table("BeerMakers as b")
            ->get()
            ->transform(function ($item) {
                $item->isUpdate = False;
                return $item;
            });
        return response()->json(compact('makers'));
    }

    public function addMaker(Request $request){
        $last = array('id' => DB::table("BeerMakers")->insertGetId(['name' => $request->name]),
            'name' => $request->name, 'isUpdate' => False);
        return response()->json(compact('last'));
    }

    public function updateMaker(Request $request){
        DB::table("BeerMakers")
            ->where('id', $request->data["id"])
            ->update(['name' => $request->data["name"]]);
    }

    public function deleteMaker(Request $request){
        DB::table("beer")
            ->where('makerID', $request->id)
            ->delete();
        DB::table("BeerMakers")
            ->where('id', $request->id)
            ->delete();
    }

    public function getTypes(){
        $types = DB::table("BeerTypes")
            ->get()
            ->transform(function ($item) {
                $item->isUpdate = False;
                return $item;
            });
        return response()->json(compact('types'));
    }

    public function addType(Request $request){
        $last = array('id' => DB::table("BeerTypes")->insertGetId(['name' => $request->name]),
            'name' => $request->name, 'isUpdate' => False);
        return response()->json(compact('last'));
    }

    public function updateType(Request $request){
        DB::table("BeerTypes")
            ->where('id', $request->data["id"])
            ->update(['name' => $request->data["name"]]);
    }

    public function deleteType(Request $request){
        DB::table("beer")
            ->where('typeID', $request->id)
            ->delete();
        DB::table("BeerTypes")
            ->where('id', $request->id)
            ->delete();
    }


    public function getBeer(){
        $beer = DB::table("beer as b")
            ->leftJoin("BeerMakers as m","b.makerID", "m.id")
            ->leftJoin("BeerTypes as t","b.typeID", "t.id")
            ->select("b.id as id", "b.name as name", "b.description as desc", "b.typeID", "b.makerID", "m.name as maker", "t.name as type")
            ->get()
            ->transform(function ($item) {
                $item->isUpdate = False;
                $item->newType = ["id" => $item->typeID, "name" => $item->type];
                $item->newMaker = ["id" => $item->makerID, "name" => $item->maker];
                return $item;
            });
        return response()->json(compact('beer'));
    }

    public function addBeer(Request $request){
        $last = array(
            'id' => DB::table("beer")->insertGetId(
                ['name' => $request->data['name'], 'description' => $request->data['desc'],
                 'typeID' => $request->data['type']['id'],
                 'makerID' => $request->data['maker']['id']]),
            'name' => $request->data['name'],
            'desc' => $request->data['desc'],
            'typeID' => $request->data['type']['id'],
            'type' => $request->data['type']['name'],
            'makerID' => $request->data['maker']['id'],
            'maker' => $request->data['maker']['name'],
            'isUpdate' => False,
            'newType' => ['id' => $request->data['type']['id'],
                            'name' => $request->data['type']['name']],
            'newMaker' => ['id' => $request->data['maker']['id'],
                        'name' => $request->data['maker']['name']]
        );
        return response()->json(compact('last'));
    }

    public function updateBeer(Request $request){
        DB::table("beer")
            ->where('id', $request->data["id"])
            ->update(['name' => $request->data["name"], 'description' => $request->data["desc"],
                'typeID' => $request->data["newType"]["id"], 'makerID' => $request->data["newMaker"]["id"]]);
    }

    public function deleteBeer(Request $request){
        DB::table("beer")
            ->where('id', $request->id)
            ->delete();
    }

}

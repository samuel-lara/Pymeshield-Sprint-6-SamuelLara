<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;


class InventoryController extends Controller
{
    /**
     * método que recoje todos los dispositivos y
     * los datos de los dispositivos filtrando por el company_id
     *
     * @return void
     */
    public function index(){
        if(auth()->user()->type == 'client'){
            return Device::where('company_id', '=', auth()->user()->company_id)->get();
        }
        else{
            return Device::all();
        }
    }


    // public function listInventaryAPI($id){
    //     // $idUser = 1;//Aquí es possara la variable de sessió que contingui el id de la sessió
    //     return Device::findOrFail($id)->get();
    // }

    public function listInventary(Request $request){
        $idUser = 3;//Aquí es possara la variable de sessió que contingui el id de la sessió

        $filtro = $request->buscar;

        $dispositivosInventario = Device::where('company_id', $idUser)
                                    ->where(function ($query) use ($filtro) {
                                        $query->where('brand', 'LIKE', '%'.$filtro.'%')
                                            ->orWhere('model', 'LIKE', '%'.$filtro.'%')
                                            ->orWhere('mac_ethernet', 'LIKE', '%'.$filtro.'%')
                                            ->orWhere('mac_wifi', 'LIKE', '%'.$filtro.'%')
                                            ->orWhere('type_device_id', 'LIKE', '%'.$filtro.'%')
                                            ->orWhere('description', 'LIKE', '%'.$filtro.'%')
                                            ->orWhere('state', 'LIKE', '%'.$filtro.'%')
                                            ->orWhere('serial_number', 'LIKE', '%'.$filtro.'%');
                                        })
                                        ->paginate(3);

        return response()->json($dispositivosInventario, 200);
    }
}

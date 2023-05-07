<?php

namespace App\Http\Controllers;
use App\Models\Computer;
use App\Models\hasPc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ComputerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getIdPc($id_user){
        $pcs = DB::select('SELECT C.id, C.pc_name, C.description, C.user
        ,U.name
        ,P.Processorbranding, P.Model, P.CoresThreads, P.Base, P.TDPCPU, P.PriceCPU, P.BrandCPU 
        ,M.socket_cpu, M.modelMotherboard, M.chipset, M.priceMotherboard, M.maxram, M.ram, M.ramslots
        ,G.modelGPU, G.launch, G.priceGPU, G.memory, G.TDPGPU, G.brandGPU
        ,S.type_storage, S.quantity  
        ,PS.power
        FROM computers C, allcpus P , motherboards M, graficas G, storages S, psus PS, users U
        WHERE P.id = C.cpu AND M.id = C.motherboard AND G.id = C.gpu AND S.id = C.storage 
        AND PS.id = C.psu 
        AND U.id = '.$id_user.' AND C.user = '.$id_user);
        $rams = DB::select('SELECT R.type_ram, R.quantity, C.id
        FROM ram_used RU, rams R, computers C
        WHERE RU.id_pc = C.id AND RU.id_ram = R.id
        AND C.user = '.$id_user);

        $games = DB::select('SELECT id_pc, id_videogame
        FROM assigned_videogame');

        // return response()->json($pcs);
        $computers = array();
        foreach ($pcs as $pc) {
           array_push($computers, array(
            'id'=>$pc->id,
            'pc_name'=>$pc->pc_name,
            'description'=>$pc->description,
            'user'=>array(
                'id'=>$pc->user,
                'name'=>$pc->name,
            ),
            'cpu'=>array(
                'Processorbranding'=>$pc->Processorbranding,
                'Model'=>$pc->Model,
                'CoresThreads'=>$pc->CoresThreads,
                'Base'=>$pc->Base,
                'TDPCPU'=>$pc->TDPCPU,
                'PriceCPU'=>$pc->PriceCPU,
                'BrandCPU'=>$pc->BrandCPU,
            ),
            'motherboard'=>array(
                'socket_cpu'=>$pc->socket_cpu,
                'modelMotherboard'=>$pc->modelMotherboard,
                'chipset'=>$pc->chipset,
                'priceMotherboard'=>$pc->priceMotherboard,
                'maxram'=>$pc->maxram,
                'ram'=>$pc->ram,
                'ramslots'=>$pc->ramslots,
            ),
            'gpu'=>array(
                'modelGPU'=>$pc->modelGPU,
                'launch'=>$pc->launch,
                'priceGPU'=>$pc->priceGPU,
                'memory'=>$pc->memory,
                'TDPGPU'=>$pc->TDPGPU,
                'brandGPU'=>$pc->brandGPU,
            ),
            'storage'=>array(
                'type_storage'=>$pc->type_storage,
                'quantity'=>$pc->quantity,
            ),
            'psu'=>array(
                'power'=>$pc->power,
            ),
            'pcRam'=>array(
            ),
            'pcVideogames'=>array(
            )
           ));
        }

        foreach ($computers as $key => $pc) {
            foreach ($games as $game) {
                if($pc['id'] == $game->id_pc){
                    array_push($computers[$key]['pcVideogames'], array(
                        'id_videogame'=>$game->id_videogame,
                    ));
                }
            }
        }
        foreach ($computers as $key => $pc) {
            foreach ($rams as $ram) {
                if($pc['id'] == $ram->id){
                    array_push($computers[$key]['pcRam'], array(
                        'type_ram'=>$ram->type_ram,
                        'quantity'=>$ram->quantity
                    ));
                }
            }
        }



        return response()->json($computers);
    }

    public function index()
    {
        $pcs = DB::select('SELECT C.id, C.pc_name, C.description, C.user
        ,U.name
        ,P.Processorbranding, P.Model, P.CoresThreads, P.Base, P.TDPCPU, P.PriceCPU, P.BrandCPU 
        ,M.socket_cpu, M.modelMotherboard, M.chipset, M.priceMotherboard, M.maxram, M.ram, M.ramslots
        ,G.modelGPU, G.launch, G.priceGPU, G.memory, G.TDPGPU, G.brandGPU
        ,S.type_storage, S.quantity  
        ,PS.power
        FROM computers C, allcpus P , motherboards M, graficas G, storages S, psus PS, users U
        WHERE P.id = C.cpu AND M.id = C.motherboard AND G.id = C.gpu AND S.id = C.storage 
		  AND PS.id = C.psu
          AND U.id = C.user');
        $rams = DB::select('SELECT R.type_ram, R.quantity, C.id
        FROM ram_used RU, rams R, computers C
        WHERE RU.id_pc = C.id AND RU.id_ram = R.id');

        $games = DB::select('SELECT id_pc, id_videogame
        FROM assigned_videogame');

        // return response()->json($pcs);
        $computers = array();
        foreach ($pcs as $pc) {
           array_push($computers, array(
            'id'=>$pc->id,
            'pc_name'=>$pc->pc_name,
            'description'=>$pc->description,
            'user'=>array(
                'id'=>$pc->user,
                'name'=>$pc->name,
            ),
            'cpu'=>array(
                'Processorbranding'=>$pc->Processorbranding,
                'Model'=>$pc->Model,
                'CoresThreads'=>$pc->CoresThreads,
                'Base'=>$pc->Base,
                'TDPCPU'=>$pc->TDPCPU,
                'PriceCPU'=>$pc->PriceCPU,
                'BrandCPU'=>$pc->BrandCPU,
            ),
            'motherboard'=>array(
                'socket_cpu'=>$pc->socket_cpu,
                'modelMotherboard'=>$pc->modelMotherboard,
                'chipset'=>$pc->chipset,
                'priceMotherboard'=>$pc->priceMotherboard,
                'maxram'=>$pc->maxram,
                'ram'=>$pc->ram,
                'ramslots'=>$pc->ramslots,
            ),
            'gpu'=>array(
                'modelGPU'=>$pc->modelGPU,
                'launch'=>$pc->launch,
                'priceGPU'=>$pc->priceGPU,
                'memory'=>$pc->memory,
                'TDPGPU'=>$pc->TDPGPU,
                'brandGPU'=>$pc->brandGPU,
            ),
            'storage'=>array(
                'type_storage'=>$pc->type_storage,
                'quantity'=>$pc->quantity,
            ),
            'psu'=>array(
                'power'=>$pc->power,
            ),
            'pcRam'=>array(
            ),
            'pcVideogames'=>array(
            )
           ));
        }

        foreach ($computers as $key => $pc) {
            foreach ($rams as $ram) {
                if($pc['id'] == $ram->id){
                    array_push($computers[$key]['pcRam'], array(
                        'type_ram'=>$ram->type_ram,
                        'quantity'=>$ram->quantity
                    ));
                }
            }
        }

        foreach ($computers as $key => $pc) {
            foreach ($games as $game) {
                if($pc['id'] == $game->id_pc){
                    array_push($computers[$key]['pcVideogames'], array(
                        'id_videogame'=>$game->id_videogame,
                    ));
                    
                }
            }
        }

        return response()->json($computers);
        }
        // $record = DB::table('has_pcs')
        // ->where('id_user', '=', $callSid)
        // ->get();
        // $pc = DB::select()
        // return $record;

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pc = Computer::find($id);
        return response()->json($pc);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

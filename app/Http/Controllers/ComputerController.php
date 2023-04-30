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
        // $pcs = hasPc::select('id_pc')
        // ->where('id_user', '=', $id_user)
        // ->get();
        $pcs = DB::select('SELECT C.name, C.description, 
        P.Processorbranding, P.Model, P.CoresThreads, P.Base, P.TDP, P.Price, P.Brand 
        ,M.socket_cpu, M.model, M.chipset, M.price, M.maxram, M.ram, M.ramslots
        ,G.model, G.launch, G.price, G.price, G.memory, G.TDP, G.brand
        ,S.type_storage, S.quantity  
        ,PS.power
        ,R.type_ram, R.quantity
        FROM computers C, allcpus P , motherboards M, graficas G, storages S, psus PS, ram_used RU, rams R
        WHERE P.id = C.cpu AND M.id = C.motherboard AND G.id = C.gpu AND S.id = C.storage 
		  AND PS.id = C.psu 
		  AND RU.id_pc = C.id AND RU.id_ram = R.id
		  AND C.user = '.$id_user);
        return response()->json($pcs);
    }

    public function index()
    {
        // $Computer = Computer::all();
        // return response()->json($Computer);

        // $record = DB::table('has_pcs')
        // ->where('id_user', '=', $callSid)
        // ->get();
        // $pc = DB::select()
        // return $record;
    }

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

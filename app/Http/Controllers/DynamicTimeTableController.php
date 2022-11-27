<?php

namespace App\Http\Controllers;

use App\Http\Requests\DynamicTimeTableValidation;
use App\Http\Controllers\Controller;
use App\Repositories\DynamicTimeTableRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DynamicTimeTableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $cebr;
    public function __construct(DynamicTimeTableRepository $cebr)
    {
        $this->cebr = $cebr;
    }
    public function index()
    {
        return view("dynamictimetable.create");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DynamicTimeTableValidation $request)
    {   
        $bi_nNoOfDays = !empty($request->bi_nNoOfDays) ? $this->cebr->filterInput($request->bi_nNoOfDays) : NULL;
        $bi_nNoOfSubject = !empty($request->bi_nNoOfSubject) ? $this->cebr->filterInput($request->bi_nNoOfSubject) : NULL;
        $bi_nTotalSubject = !empty($request->bi_nTotalSubject) ? $this->cebr->getUpperCaseText($this->cebr->filterInput($request->bi_nTotalSubject)) : NULL;
        $bi_nTotalHours = !empty($request->bi_nTotalHours) ? $this->cebr->filterInput($request->bi_nTotalHours) : NULL;
        
        $res = $this->cebr->addDynamicTimeTable(
            $bi_nNoOfDays,
            $bi_nNoOfSubject,
            $bi_nTotalSubject,
            $bi_nTotalHours
        );
        if ($res['status'] == "1") {
            return redirect()
            ->route("dynamictimetable.edit",$res['id'])
                ->with("result", $res);
        } else {
            return redirect()
            ->route("dynamictimetable.create")
                ->with("result", $res)
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $resultTimeTable = $this->cebr->getOneData($id);
        if ($resultTimeTable['status'] == "1") {
            $result = $resultTimeTable['data'];
            $editdata = [
                "result" => $result,
            ];
            return view("dynamictimetable.edit",$editdata);
        }else{
            return redirect()
            ->route("dynamictimetable.create")
                ->with("result", $resultTimeTable)
                ->withInput();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

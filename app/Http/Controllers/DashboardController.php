<?php

namespace App\Http\Controllers;


use App\Models\Maze;
use App\Models\Player;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{
    //====================================================>
    public function index()
    {
        $this->seo()->setTitle('Dashboard Home');
        return view('dashboard.index');
    }

    //====================================================>
    public function leader()
    {

        $this->seo()->setTitle('Leader Board');
        return view('dashboard.leader', ['quiz' => null]);
    }

    //====================================================>
    public function leaderAjax(Request $request)
    {
        if ($request->ajax()) {
/*
            $data = Quiz::select(['id', 'player_id', 'score', 'duration'])->with([
                'Player' => function ($q) {
                    $q->select('id', 'name','phone','uuid');
                },
                'QuizAnswer'
            ])->orderBy('score', 'desc')->where('status',true)->get();
*/

            $data = Maze::select(['id', 'group_id', 'duration'])->with([
                'Group' => function ($q) {
                    $q->with(['Player' => function ($x) {
                        $x->select('id', 'name', 'group_id');
                    }]);

                }
            ])->orderBy('duration', 'asc')->where('status', true)->get()->unique('group_id');



            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('duration', function ($row) {
                    $minutes = floor($row->duration / 60);
                    $remainingSeconds = $row->duration % 60;
                    return sprintf('%02d:%02d', $minutes, $remainingSeconds);
                    //return $row->duration;
                })
                ->editColumn('name', function ($row) {
                    $names = '';
                    foreach ($row->Group->Player ?? [] as $player) {
                        $names = $names . Str::words($player->name, 2, '') . ', ';
                    }
                    return $names;
                })
                ->editColumn('code', function ($row) {
                    return $row->Group->uuid ?? '';
                })


                ->make(true);
        }
        return '';
    }
    //====================================================>
    public function players()
    {

        $this->seo()->setTitle('Players');
        return view('dashboard.players');
    }

    //====================================================>
    public function playersAjax(Request $request)
    {
        if ($request->ajax()) {

            $data = Player::with([
                'Group' => function($q){
                    $q->with(['Maze','maxScore']);
                }
            ]);//->get();

            return Datatables::of($data)

                ->filter(function ($query){
                    if (request()->has('search')) {
                        $query->where(function ($wQuery) {
                            $wQuery->where('name', 'like', '%' . request('search')['value'] . '%');
                            $wQuery->orWhere('phone', "%" . request('search')['value'] . "%");
                            $wQuery->orWhere('email', "%" . request('search')['value'] . "%");
                        });
                    }
                })



                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return $row->Group->uuid ?? 'NULL';
                })
                ->rawColumns(['action'])

                ->addColumn('max_score', function ($row) {
                    if($row->Group->maxScore == null){
                        return '00:00';
                    }
                    $minutes = floor($row->Group->maxScore->duration / 60);
                    $remainingSeconds = $row->Group->maxScore->duration % 60;
                    return sprintf('%02d:%02d', $minutes, $remainingSeconds);

                })
                ->addColumn('quiz_count', function ($row) {
                   return count($row->Group->Maze) ?? 0;
                })
                ->make(true);
        }
        return '';
    }
    //====================================================>
    public function deleteAll(Request $request)
    {
        //$returnArray['success'] = false;

        Maze::truncate();
        //Player::truncate();

        $returnArray['success'] = true;
        return Response::json($returnArray);
    }
    //====================================================>

    //====================================================>


}

<?php

namespace App\Http\Controllers;


use App\Http\Requests\Player\LoginRequest;
use App\Http\Requests\Player\RegisterRequest;
use App\Models\Group;
use App\Models\Maze;
use App\Models\Player;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Yajra\DataTables\Facades\DataTables;


class PlayerController extends Controller
{

    //====================================================>
    public function login(Request $request)
    {
        $this->seo()->setTitle('Login And Start');
        return view('quiz.login');
    }

    //====================================================>
    public function doLogin(LoginRequest $request)
    {
        $request->validated();
        //---->
        $currentTime = Carbon::now();
        $tenMinutesAgo = $currentTime->subMinutes(10);
        $last10MinCount = Maze::where('status', false)->where('start_datetime', '>', $tenMinutesAgo)->with('Group.Player')->count();
        if ($last10MinCount > 0) {
            return back()->withErrors(['group_id' => 'Wait until Player finished']);
        }
        //---->
        try {
            DB::beginTransaction();

            $groupModel = Group::where('uuid', $request->input('group_id'))->firstOrFail();

            $mazModel = new Maze;
            $mazModel->group_id = $groupModel->id;
            $mazModel->hash = Str::replace('-', '', Str::uuid());
            $mazModel->start_datetime = Carbon::now();
            $mazModel->status = false;
            $mazModel->saveOrFail();

            DB::commit();
            return redirect()->route('maze.index', $mazModel->hash);
            //return view('quiz.duration', ['model' => $mazModel]);
        } catch (ModelNotFoundException $e) {
            report($e);
            DB::rollBack();
            return back()->withErrors(['group_id' => 'The entered code is invalid. Please contact the registration']);
        } catch (\Throwable $e) {
            report($e);
            DB::rollBack();
            Log::error($e->getMessage());
            return back()->withErrors(['group_id' => 'Error Try Another Time']);
        }
    }

    //====================================================>
    public function mazeLogout(Request $request,$hash = null)
    {
        $hashValues = [
            '7211650b9d0a518528d1c149700c437b'=>'TRPUW',
            '8d377f8599728e4f89afe25ab318a202'=>'QRBUY',
            'fc1396239affb649c1a625e636d85833'=>'CRQUM',
            'f331f6625283241b978d07a7439e3ebb'=>'MRXUV'
        ];

        if($hash != null && !array_key_exists($hash,$hashValues)){
            abort(404);
        }

        $this->seo()->setTitle('Maze Finish');
        return view('quiz.logout');
    }

    //====================================================>
    public function doMazeLogout(Request $request,$hash = null)
    {
        /*
             7211650b9d0a518528d1c149700c437b = TRPUW
             8d377f8599728e4f89afe25ab318a202 = QRBUY
             fc1396239affb649c1a625e636d85833 = CRQUM
             f331f6625283241b978d07a7439e3ebb = MRXUV
         */
        $hashValues = [
            '7211650b9d0a518528d1c149700c437b'=>'TRPUW',
            '8d377f8599728e4f89afe25ab318a202'=>'QRBUY',
            'fc1396239affb649c1a625e636d85833'=>'CRQUM',
            'f331f6625283241b978d07a7439e3ebb'=>'MRXUV'
        ];

        if($hash !== null && !array_key_exists($hash,$hashValues)){
            abort(404);
        }

        $validator = Validator::make($request->all(), [
            'secret_code' => 'required',
        ], [], [
            'secret_code' => 'Secret Code',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }


        if($hash === null){
            if (strtolower($request->input('secret_code')) != 'fraud') {
                return back()->withErrors(['secret_code' => 'Invalid Secret Code'])->with('error_code', '');
            }
        }else{
            $isTrue = strtoupper(trim($request->input('secret_code'))) == $hashValues[$hash];
            if (!$isTrue) {
                return back()->withErrors(['secret_code' => 'Invalid Secret Code'])->with('error_code', '');
            }
        }

        try {
            DB::beginTransaction();
            $mazes = Maze::where('status', false)->get();

            foreach ($mazes as $maze) {
                $maze->end_datetime = Carbon::now();
                $duration = $maze->end_datetime->diffInSeconds($maze->start_datetime);
                if ($duration >= 600)
                    $maze->duration = 600;
                else
                    $maze->duration = $duration;
                $maze->status = true;
                $maze->saveOrFail();
            }
            DB::commit();
            if($hash === null) {
                return redirect()->route('maze.logout')->with('success', '');
            }else{
                return redirect()->route('maze.logout_hash',['hash' => $hash])->with('success', '');
            }
        } catch (\Exception|\Throwable $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            abort(500);
        }
    }

    //====================================================>
    public function mazeRoom(Request $request, $id)
    {
        $this->seo()->setTitle('Maze Room');

        $title = "";
        $room_title = "";
        $hint = "";
        $pass = "";

        if ($id == 1) {
            $title = '<p class="message">Protect your <strong>________</strong></p><img src="' . asset('images/code.jpg') . '" width="100%">';
            //$room_title = "";
            $hint = "Your first letter of your secret code is <strong>F</strong>";
            $pass = "IDENTITY";
        } elseif ($id == 3) {
            $title = '<p class="message">Decrypted Message: ________</p>';
            //$room_title = "";
            $hint = "Your third letter of your secret code is <strong>A</strong>";
            $pass = "CYBER SMART";
        } else {
            abort(404);
        }

        return view('quiz.room-blank', ['title' => $title, 'room_title' => $room_title, 'hint' => $hint, 'pass' => $pass]);
    }

    //====================================================>
    public function doMazeRoom(Request $request, $id)
    {


        $title = "Form Title";
        $pass = 'NULL';
        if ($id == 1) {
            $title = "Protect Your";
            $pass = "identity";

        } elseif ($id == 3) {
            $title = "Decrypted Message";
            $pass = "cyber smart";
        } else {
            abort(404);
        }


        $validator = Validator::make($request->all(), [
            'secret_code' => 'required',
        ], [], [
            'secret_code' => $title,
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if (strtolower($request->input('secret_code')) != $pass) {
            return back()->withErrors(['secret_code' => 'Invalid Value'])->with('error_code', '');
        }

        return redirect()->route('maze.room', $id)->with('success', '');

    }

    //====================================================>
    public function mazeCurrentSession(Request $request)
    {
        try {
            $currentTime = Carbon::now();
            $tenMinutesAgo = $currentTime->subMinutes(10);


            $mazes = Maze::where('status', false)->where('start_datetime', '>', $tenMinutesAgo)->with('Group.Player')->firstOrFail();

            $currentTimeLater = Carbon::now();
            $tenMinutesLater = $mazes->start_datetime->copy()->addMinutes(10);


            $secondsToTenMinutes = $currentTimeLater->diffInSeconds($tenMinutesLater);
            $minutes = floor($secondsToTenMinutes / 60);
            $remainingSeconds = $secondsToTenMinutes % 60;
            $left = sprintf('%02d:%02d', $minutes, $remainingSeconds);

            $names = '';
            foreach ($mazes->Group->Player ?? [] as $player) {
                $names = $names . Str::words($player->name, 2, '') . ', ';
            }


            return response()->json([
                'success' => true,
                'data' => [
                    'players' => $names,
                    'timer' => $left,
                ],
                'errors' => []
            ], 200);
        } catch (ModelNotFoundException  $e) {
            return response()->json([
                'success' => true,
                'data' => [
                    'players' => 'No Player',
                    'timer' => '10:00',
                ],
                'errors' => []
            ], 200);
        }
    }

    //====================================================>
    public function mazeCountdown(Request $request)
    {
        $this->seo()->setTitle('Countdown Maze');
        return view('quiz.countdown');
    }

    //====================================================>
    public function mazeSession(Request $request, $hash)
    {
        $this->seo()->setTitle('Countdown Maze');
        try {
            $maze = Maze::where('hash', $hash)->with('Group.Player')->where('status', false)->firstOrFail();
            return view('quiz.duration', compact('maze'));
        } catch (ModelNotFoundException  $e) {
            abort(404);
        }
    }

    //====================================================>
    public function mazeSessionFinish(Request $request, $hash)
    {
        try {
            DB::beginTransaction();
            $maze = Maze::where('hash', $hash)->with('Group.Player')->where('status', false)->firstOrFail();
            /*
                        $maze->end_datetime = Carbon::now();
                        $duration = $maze->end_datetime->diffInSeconds($maze->start_datetime);

                        if ($duration >= 600)
                            $maze->duration = 600;
                        else
                            $maze->duration = $duration;
            */
            $maze->duration = 600;
            $maze->status = true;

            $maze->saveOrFail();
            DB::commit();
            return redirect()->route('player.login');
        } catch (ModelNotFoundException  $e) {
            DB::rollBack();
            return redirect()->route('player.login');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            abort(500);
        }
    }

    //====================================================>

    public function playerRegister()
    {
        $this->seo()->setTitle('Player Register');
        return view('quiz.register');
    }

    //====================================================>
    public function playerDoRegister(RegisterRequest $request)
    {
        try {
            DB::beginTransaction();
            $request->validated();

            $model = new Player;
            $model->name = $request->input('name');
            $model->phone = $request->input('phone');
            $model->email = $request->input('email');

            if ($request->has('group_code') && $request->input('group_code') != null) {
                $group = Group::where('uuid', $request->input('group_code'))->firstOrFail();
                $model->group_id = $group->id;
                $uuid = $group->uuid;
            } else {
                $groupModel = new Group;
                $groupModel->uuid = $this->generateUniqueCode();
                $groupModel->saveOrFail();
                $model->group_id = $groupModel->id;
                $uuid = $groupModel->uuid;
            }

            $model->saveOrFail();
            DB::commit();
            return view('quiz.done', ['code' => $uuid]);
        } catch (ModelNotFoundException|\Throwable  $e) {
            DB::rollBack();
            //dump($request->input());
            //dd($e);
            Log::error($e->getMessage());
            return back()->withErrors(['name' => 'Error Try Another Time']);
        }
    }

    //====================================================>
    public function register(Request $request)
    {
        $this->seo()->setTitle('Register');
        return view('dashboard.player_form');
    }

    //====================================================>
    public function doRegister(RegisterRequest $request)
    {
        try {
            DB::beginTransaction();
            $request->validated();

            $model = new Player;
            $model->name = $request->input('name');
            $model->phone = $request->input('phone');
            $model->email = $request->input('email');
            if ($request->has('group_code') && $request->input('group_code') != null) {
                $group = Group::where('uuid', $request->input('group_code'))->firstOrFail();
                $model->group_id = $group->id;
                $uuid = $group->uuid;
            } else {
                $groupModel = new Group;
                $groupModel->uuid = $this->generateUniqueCode();
                $groupModel->saveOrFail();
                $model->group_id = $groupModel->id;
                $uuid = $groupModel->uuid;
            }

            $model->saveOrFail();
            DB::commit();
            return view('dashboard.player_code', ['code' => $uuid]);
        } catch (ModelNotFoundException|\Throwable  $e) {
            DB::rollBack();
            return back()->withErrors(['name' => 'Error Try Another Time']);
        }

    }

    //====================================================>
    private function generateUniqueCode()
    {
        $existingCodes = Group::pluck('uuid')->toArray();
        $code = null;

        for ($i = 0; $i < 1000; $i++) {
            $code = random_int(1004, 9999);
            if (!in_array($code, $existingCodes)) {
                break;
            }
        }

        if (in_array($code, $existingCodes)) {
            throw new \Exception("Failed to generate a unique code after multiple attempts.");
        }

        return $code;

    }

    //====================================================>
    public function export()
    {
        abort(404);
        try {

            $data = Quiz::with(['Player', 'QuizAnswer'])->orderBy('score', 'desc')->get();


            $spreadsheet = new Spreadsheet();
            $spreadsheet->getProperties()->setCreator('Ahmed Elsayed Ali  +201015884959 ')
                ->setLastModifiedBy('Ahmed Elsayed Ali  +201015884959 ')
                ->setTitle('Ahmed Elsayed Ali  +201015884959 ')
                ->setSubject('Ahmed Elsayed Ali  +201015884959 ')
                ->setDescription('Ahmed Elsayed Ali  +201015884959 ')
                ->setKeywords('Ahmed Elsayed Ali  +201015884959 ')
                ->setCategory('Ahmed Elsayed Ali  +201015884959 ');


            $xlsIndex1 = $spreadsheet->setActiveSheetIndex(0);

            $xlsIndex1->setTitle('Players');

            $headerStyle = [
                'font' => [
                    'bold' => true,
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'outline' => [
                        'borderStyle' => Border::BORDER_THIN,
                    ],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'color' => [
                        'rgb' => '808080',
                    ],
                ],
            ];


            $rowStyle = [
                'font' => [
                    'bold' => true,
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'outline' => [
                        'borderStyle' => Border::BORDER_THIN,
                    ],
                ],
            ];

            $rowErrorStyle = [
                'font' => [
                    'bold' => true,
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'outline' => [
                        'borderStyle' => Border::BORDER_THIN,
                    ],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'color' => [
                        'argb' => 'ffff000a',
                    ],
                ],
            ];

            $xlsIndex1->setCellValue('A1', 'Player')
                ->setCellValue('B1', 'Phone')
                ->setCellValue('C1', 'Quiz Date')
                ->setCellValue('D1', 'Score')
                ->setCellValue('E1', 'Duration')
                ->setCellValue('F1', 'Answers 1')
                ->setCellValue('G1', 'Answers 2')
                ->setCellValue('H1', 'Answers 3')
                ->setCellValue('I1', 'Answers 4')
                ->setCellValue('J1', 'Answers 4')
                ->setCellValue('K1', 'Status');

            $xlsIndex1->getStyle('A1')->applyFromArray($headerStyle);
            $xlsIndex1->getStyle('B1')->applyFromArray($headerStyle);
            $xlsIndex1->getStyle('C1')->applyFromArray($headerStyle);
            $xlsIndex1->getStyle('D1')->applyFromArray($headerStyle);
            $xlsIndex1->getStyle('E1')->applyFromArray($headerStyle);

            $xlsIndex1->getStyle('F1')->applyFromArray($headerStyle);
            $xlsIndex1->getStyle('G1')->applyFromArray($headerStyle);
            $xlsIndex1->getStyle('H1')->applyFromArray($headerStyle);
            $xlsIndex1->getStyle('I1')->applyFromArray($headerStyle);
            $xlsIndex1->getStyle('J1')->applyFromArray($headerStyle);
            $xlsIndex1->getStyle('K1')->applyFromArray($headerStyle);

            $index = 2;
            foreach ($data as $row) {
                $xlsIndex1->setCellValue('A' . $index, $row->Player->name ?? 'NULL');
                $xlsIndex1->setCellValue('B' . $index, $row->Player->phone ?? 'NULL');
                $xlsIndex1->setCellValue('C' . $index, $row->created_at->format('Y-m-d-H:i:s') ?? 'NULL');
                $xlsIndex1->setCellValue('D' . $index, $row->score ?? 'NULL');
                $xlsIndex1->setCellValue('E' . $index, $row->duration ?? 'NULL');

                foreach ($row->QuizAnswer as $ans) {

                    $boolC = false;
                    $cAns = 'INCORRECT';
                    $LET = 'F';
                    if ($ans->is_correct) {
                        $cAns = 'CORRECT';
                        $boolC = true;

                    }
                    switch ($ans->inc) {
                        case 1:
                            $LET = 'F';
                            break;
                        case 2:
                            $LET = 'G';
                            break;

                        case 3:
                            $LET = 'H';
                            break;

                        case 4:
                            $LET = 'I';
                            break;

                        case 5:
                            $LET = 'J';
                            break;
                        default:
                    }

                    $xlsIndex1->setCellValue($LET . $index, $cAns);
                    if ($boolC)
                        $xlsIndex1->getStyle($LET . $index)->applyFromArray($rowStyle);
                    else
                        $xlsIndex1->getStyle($LET . $index)->applyFromArray($rowErrorStyle);
                }

                $xlsIndex1->setCellValue('K' . $index, $row->status ? 'completed' : 'incomplete');

                $xlsIndex1->getStyle('A' . $index)->applyFromArray($rowStyle);
                $xlsIndex1->getStyle('B' . $index)->applyFromArray($rowStyle);
                $xlsIndex1->getStyle('C' . $index)->applyFromArray($rowStyle);
                $xlsIndex1->getStyle('D' . $index)->applyFromArray($rowStyle);
                $xlsIndex1->getStyle('E' . $index)->applyFromArray($rowStyle);


                if ($row->status) {
                    $xlsIndex1->getStyle('K' . $index)->applyFromArray($rowStyle);
                } else {
                    $xlsIndex1->getStyle('K' . $index)->applyFromArray($rowErrorStyle);
                }


                $index++;
            }

            $spreadsheet->setActiveSheetIndex(0);
            $spreadsheet->getDefaultStyle()->getNumberFormat()->setFormatCode('#');
            $sheet = $spreadsheet->getActiveSheet();
            foreach ($sheet->getColumnIterator() as $column) {
                $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
            }

            $filename = 'Players_' . date("Y/m/d") . '.xlsx';
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
            header('Cache-Control: max-age=1');
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
            header('Cache-Control: cache, must-revalidate');
            header('Pragma: public');

            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');


        } catch (Exception $e) {
            abort(500);
        }
    }

    //====================================================>
    public function playerLeaderboard()
    {
        $this->seo()->setTitle('Leader Board');
        return view('home.leader', ['quiz' => null]);
    }

    //====================================================>
    public function playerLeaderboardAjax(Request $request)
    {
        if ($request->ajax()) {
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
                ->make(true);
        }
        return '';
    }
    //====================================================>


}

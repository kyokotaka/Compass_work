<?php

namespace App\Http\Controllers\Authenticated\Shifts;

use App\Http\Controllers\Controller;
use Goodby\CSV\Import\Standard\LexerConfig;
use Goodby\CSV\Import\Standard\Lexer;
use Goodby\CSV\Import\Standard\Interpreter;
use Illuminate\Http\Request;
use App\Models\Shifts\Shift;
use App\Models\Users\User;
use Auth;

class ShiftsController extends Controller
{
    public function scheduleShow(){
        $adminUserIds = User::where('role', 4)->pluck('id');

        // adminユーザーIDを除外したシフトを取得
        $shifts = Shift::whereNotIn('user_id', $adminUserIds)->with('user')->get();
    
        return view('authenticated.shifts.schedule', compact('shifts'));
    }

    public function shiftInput(){
        return view('authenticated.shifts.input');
    }

    public function importCSV(Request $request){
        $tmpName = mt_rand() . "." . $request->file('csvFile')->guessExtension();
        $path = $request->file('csvFile')->storeAs('tmp', $tmpName);
        $tmpPath = storage_path('app/' . $path);

        //Goodby CSVのconfig設定
        $config = new LexerConfig();
        $interpreter = new Interpreter();
        $lexer = new Lexer($config);

        //CharsetをUTF-8に変換、CSVのヘッダー行を無視
        $config->setToCharset("UTF-8");
        $config->setFromCharset("UTF-8");
        $config->setIgnoreHeaderLine(true);

        $dataList = [];

        // 新規Observerとして、$dataList配列に値を代入
        $interpreter->addObserver(function (array $row) use (&$dataList){//行を読みっとたらコールバックする。
            // 各列のデータを取得
            $dataList[] = $row;
        });

        // CSVデータをパース
        $lexer->parse($tmpPath, $interpreter);

        // TMPファイル削除
        unlink($tmpPath);

        // 登録処理
        $count = 0;
        foreach($dataList as $row){
            Shift::insert([
                'user_id'         => Auth::user()->id,
                'date'            => $row[0],
                'school_category' => $row[1],
                'start_time'      => $row[2] !== '' ? $row[2] : null,
                'end_time'        => $row[3] !== '' ? $row[3] : null,
                'location'        => $row[4] !== '' ? $row[4] : null,
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
            $count++;
        }
        return redirect()->route('schedule.input')->with('success', 'シフトを登録しました。');
    }
}
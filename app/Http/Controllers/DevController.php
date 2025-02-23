<?php
/**
 * Created by PhpStorm.
 * User: kiven
 * Date: 2025/2/23
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\SqlLog;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SqlResultExport;

class DevController extends Controller
{
    public function index()
    {
        return view('dev.index');
    }

    public function execute(Request $request)
    {
        $sql = $request->input('sql');
        $user = Auth::user();

        if (!str_starts_with(strtoupper(trim($sql)), 'SELECT')) {
            return response()->json(['error' => 'Only SELECT statements are allowed.']);
        }

        try {
            $results = DB::select($sql);
            SqlLog::create([
                'user_id' => $user->id,
                'sql' => $sql,
                'error' => null
            ]);
            return response()->json(['results' => $results]);
        } catch (\Exception $e) {
            SqlLog::create([
                'user_id' => $user->id,
                'sql' => $sql,
                'error' => $e->getMessage()
            ]);
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function exportExcel(Request $request)
    {
        $sql = $request->input('sql');
        if (!str_starts_with(strtoupper(trim($sql)), 'SELECT')) {
            return response()->json(['error' => 'Only SELECT statements are allowed.']);
        }
        return Excel::download(new SqlResultExport($sql), 'sql_result.xlsx');
    }

    public function exportJson(Request $request)
    {
        $sql = $request->input('sql');
        if (!str_starts_with(strtoupper(trim($sql)), 'SELECT')) {
            return response()->json(['error' => 'Only SELECT statements are allowed.']);
        }
        try {
            $results = DB::select($sql);
            $fileName = 'sql_result.json';
            $fileContent = json_encode($results, JSON_PRETTY_PRINT);
            return response($fileContent)
                ->header('Content-Type', 'application/json')
                ->header('Content-Disposition', "attachment; filename={$fileName}");
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
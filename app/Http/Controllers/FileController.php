<?php
namespace App\Http\Controllers;
use App\Traits\AllFunction; 
use Illuminate\Http\Request;

class FileController extends Controller
{
    use AllFunction; 

    public function delete_file(Request $request) {
        $data = [
            'table'=>$request['table'],
            'table_id'=>$request['table_id'],
            'table_id_value'=>$request['table_id_value'],
            'table_field'=>$request['table_field'],
            'file_name'=>$request['file_name'],
            'file_path'=>$request['file_path'],
        ];
        AllFunction::delete_file($data);
        echo json_encode(array(
            'status'  => 'success',
            'message' => view('common_files.file')->with('data',$data)->render()
        ));
        exit;
    }
} 

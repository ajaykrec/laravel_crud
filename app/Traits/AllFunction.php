<?php
namespace App\Traits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

//=== for image resize : composer require intervention/image
// use "intervention/image": "^2.7" in composer.json "require"
// run comand : composer update

use Intervention\Image\Facades\Image as ResizeImage;

trait AllFunction {

    static function upload_image($data) {
        
        $file               = $data['file'] ?? '';
        $destination_path   = $data['destination_path'] ?? '';
        $width              = $data['width'] ?? '';
        $height             = $data['height'] ?? '';
     
        //Display File Name
        $file_name = time(). '-vs-' .$file->getClientOriginalName();       
     
        //Display File Extension
        $file_extension = $file->getClientOriginalExtension();        
     
        //Display File Real Path       
        $file_real_path = $file->getRealPath();
     
        //Display File Size
        $file_size = $file->getSize();       
     
        //Display File Mime Type
        $file_mime_type = $file->getMimeType();  
        
        if($width && $height){
            
            $destination_path = 'storage/'.$destination_path;            
            !is_dir($destination_path) &&
            mkdir($destination_path, 0777, true);

            ResizeImage::make($file)
            ->resize($width,$height, function ($constraint) {
                $constraint->aspectRatio();
            })
            ->save($destination_path .'/'. $file_name);           
        }
        else{
            //Move Uploaded File       
            $file->storeAs($destination_path,$file_name);
        }
        return $file_name;
       
     }
     static function delete_file($data) {
        $table          = $data['table'] ?? '';
        $table_id       = $data['table_id'] ?? '';
        $table_id_value = $data['table_id_value'] ?? '';
        $table_field    = $data['table_field'] ?? '';
        $file_name      = $data['file_name'] ?? '';
        $file_path      = $data['file_path'] ?? '';
        $file_full_path = $file_path.'/'.$file_name;

        
        //=== delete file
        if(Storage::disk('public')->exists($file_full_path)){ 
            Storage::delete($file_full_path);     
        }           
        
        //=== update table
        if($table && $table_id && $table_id_value && $table_field){ 
            $tableRow = DB::table($table)->where($table_id, '=', $table_id_value)->get();
            if($tableRow){
                $affected = DB::table($table)
                ->where($table_id, $table_id_value)
                ->update([$table_field => '']);         
            }          
        }
     }

    static function mail_with_sendgrid($data){  
        
        $email      = isset($data['email']) ? $data['email'] : '';  
        $name       = isset($data['name']) ? $data['name'] : '';     
        $from_email = isset($data['from_email']) ? $data['from_email'] : '';     
        $from_email_name  = isset($data['from_email_name']) ? $data['from_email_name'] : '';
        $subject    = isset($data['subject']) ? $data['subject'] : '';        
        $content    = isset($data['content']) ? $data['content'] : '';     

        $url = 'https://api.sendgrid.com/v3/mail/send';        
        $ch  = curl_init($url);

        // Setup request to send json via POST        
        $array_data = array(
            'personalizations' => [[
                'to'=> array(
                    ['name'=>$name,'email'=>$email]            
                )
            ]],
            'from' => ['name'=>$from_email_name,'email'=>$from_email],
            'subject' => $subject,
            'content' => [['type'=>'text/html','value'=>$content]]
        );
        //$payload = json_encode($array_data,JSON_UNESCAPED_SLASHES);
        $payload = json_encode($array_data);
        // Attach encoded JSON string to the POST fields
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

        // Set the content type to application/json
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type:application/json',
            'Authorization: Bearer '.env('SENDGRID_API_KEY').''
        ));

        // Return response instead of outputting
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute the POST request
        $result = curl_exec($ch);

        // Close cURL resource
        curl_close($ch);
    }

    static function replace_null($array) {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $array[$key] = AllFunction::replace_null($value);
            } else {
                if (is_null($value)) {
                    $array[$key] = "";
                }
            }
        }
        return $array;
    }
    
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

abstract class Controller
{
    public $userId = null;

    public function __construct(Request $request)
    {

        if (!empty(Auth::user()) && !empty(Auth::user()->id)) {
            $this->userId = Auth::user()->id;
        }

    }

    public function generateSeoURL($string, $withoutTimestamp = 0, $wordLimit = 0)
    {
        $separator = '-';

        if ($wordLimit != 0) {
            $wordArr = explode(' ', $string);
            $string = implode(' ', array_slice($wordArr, 0, $wordLimit));
        }

        $quoteSeparator = preg_quote($separator, '#');

        $trans = array(
            '&.+?;' => '',
            '[^\w\d _-]' => '',
            '\s+' => $separator,
            '(' . $quoteSeparator . ')+' => $separator
        );

        $string = strip_tags($string);
        foreach ($trans as $key => $val) {
            $string = preg_replace('#' . $key . '#iu', $val, $string);
        }

        $string = strtolower($string);

        if (!empty($withoutTimestamp)) {
            $slug = trim(trim($string, $separator));
        } else {
            $slug = trim(trim($string, $separator)) . '-' . time();
        }

        return $slug;
    }


    public function dbInsertTime($dateTime = null)
    {
        if (!empty($dateTime)) {
            $now = date('Y-m-d H:i:s', strtotime($dateTime));
        } else {
            $now = date('Y-m-d H:i:s', time());
        }

        return $now;
    }


    public function generateUUId($res = [])
    {
        if (!empty($res)) {
            $screen = !empty($res['screen']) ? $res['screen'] : 'temp';
            $id = !empty($res['id']) ? $res['id'] : rand(0, 99999999);
            $uuId = sha1($screen . $id . time());
        } else {
            $uuId = sha1(rand(0, 99999999) . rand(0, 99999999) . rand(0, 99999999));
        }

        return $uuId;
    }


    public function commonImageUpload($req, $folder = '', $isPng = false)
    {

        $status = 'error';
        $file_name = '';

        $folder = !empty($folder) ? $folder . '/' : '';

        $image_data = $req->image;
        $image_array_1 = explode(';', $image_data);
        $image_array_2 = explode(',', $image_array_1[1]);
        $data = base64_decode($image_array_2[1]);
        $image_name = !empty($isPng) ? time() . '.png' : time() . '_temp.png';
        $upload_path = public_path('assets/common/images/' . $folder . $image_name);
        file_put_contents($upload_path, $data);

        if (!empty($isPng)) {
            $file_name = $image_name;
            $status = 'Image Uploaded!';

        } else {

            if (file_exists($upload_path)) {

                $file_name = time() . '.jpg';
                $file_name_with_path = public_path('assets/common/images/' . $folder . $file_name);
                $image = imagecreatefrompng($upload_path);
                imagejpeg($image, $file_name_with_path, 90);
                imagedestroy($image);

                unlink($upload_path);
                $status = 'Image Uploaded!';
            }
        }


        $out = [
            'status' => $status,
            'file_name' => $file_name,
        ];
        return $out;
    }

    public function categoryStatus($getStatus)
    {

        $status = 'Inactive';
        $statusClass = 'bg-warning';

        if ($getStatus == 1) {
            $status = 'Active';
            $statusClass = 'bg-success';
        }

        return (object)[
            'text' => $status,
            'class' => $statusClass,
        ];
    }

    public function sendMail($data)
    {

        $subject = $data['subject'];
        $toMail = $data['to_mail'];
        $toName = $data['to_name'];
        $body = $data['body'];

        $apiKey = env('BREVO_API_KEY');
        $respose = Http::withHeaders([
            'api-key' => $apiKey,
            'Content-Type' => 'application/json',
        ])->post('https://api.brevo.com/v3/smtp/email', [
            'sender' => [
                'name' => 'Siyota Enterprises (pvt) Ltd',
                'email' => 'info@siyota.lk',
            ],
            'to' => [
                ['name' => $toName, 'email' => $toMail]
            ],
            'subject' => $subject,
            'htmlContent' => $body,
        ]);

        if ($respose->successful()) {
            return response()->json(['message' => 'success'], 200);
        } else {
            return response()->json(['message' => 'error'], 200);
        }
    }
}

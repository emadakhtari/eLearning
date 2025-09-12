<?php

namespace App\Modules\Setting\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CoreCommon;
use App\Http\Requests\SettingRequest;
use App\Modules\Contents\Admin\Models\Contents;
use App\Modules\Setting\Admin\Models\Setting;
use Illuminate\Support\Facades\Auth;

class SettingManager extends Controller
{

    public function GetPreView()
    {
        $dd           = CoreCommon::osD();
        $manifestJson = file_get_contents(__DIR__ . $dd . '..' . $dd . '..' . $dd . 'Manifest.json', "r");
        $manifest     = json_decode($manifestJson, true);
        $moduleName   = $manifest['title'];
        if (substr(strrchr(__DIR__, "Admin" . $dd), 6)) {
            $side = 'Admin';
        }

        $preView = $moduleName . '_' . $side . '::';
        return $preView;
    }
    //Return Edit Views
    public function EditView($id)
    {

        $id                       = Setting::findOrFail($id);
        $path                     = str_replace("public/", "", asset(""));
        $userId                   = Auth::user()->id;


        return view($this->GetPreView() . 'Edit', compact('path', 'userId'))->with(['data' => $id]);
    }
    //Edit Data
    public function Edit(SettingRequest $request, $id)
    {
        $Setting = Setting::where('id', "1")
            ->first();

        if ($_FILES["login_image"]["size"] > 0) {
            $filenamelogin_image = 'login_image' . time() . '_' . $_FILES["login_image"]["name"];
            $pathimage= str_replace('\\', '/', public_path('upload/setting/' . $filenamelogin_image));
            $pathimage = str_replace("main-laravel/public", "public_html/emad", $pathimage);
            $pathimage= str_replace('\\', '/', $pathimage);

            @move_uploaded_file($_FILES["login_image"]["tmp_name"], $pathimage);
            $login_imageFinal = $filenamelogin_image;
        } else {
            $login_imageFinal = $request->originallogin_image;
        }

        if ($_FILES["top_menu_image"]["size"] > 0) {
            $filenametop_menu_image = 'top_menu_image' . time() . '_' . $_FILES["top_menu_image"]["name"];
            $pathimage= str_replace('\\', '/', public_path('upload/setting/' . $filenametop_menu_image));
            $pathimage = str_replace("main-laravel/public", "public_html/emad", $pathimage);
            $pathimage= str_replace('\\', '/', $pathimage);
            @move_uploaded_file($_FILES["top_menu_image"]["tmp_name"], $pathimage);
            $top_menu_imageFinal = $filenametop_menu_image;
        } else {
            $top_menu_imageFinal = $request->originaltop_menu_image;
        }

        if ($_FILES["signature_image"]["size"] > 0) {
            $filenamesignature_image = 'signature_image' . time() . '_' . $_FILES["signature_image"]["name"];
            $pathimage= str_replace('\\', '/', public_path('upload/setting/' . $filenamesignature_image));
            $pathimage = str_replace("main-laravel/public", "public_html/emad", $pathimage);
            $pathimage= str_replace('\\', '/', $pathimage);
            @move_uploaded_file($_FILES["signature_image"]["tmp_name"], $pathimage);
            $signature_imageFinal = $filenamesignature_image;
        } else {
            $signature_imageFinal = $request->originalsignature_image;
        }

        $image_fields = $request->except('login_image','top_menu_image','signature_image');
        $image_fields['login_image'] = $login_imageFinal;
        $image_fields['top_menu_image'] = $top_menu_imageFinal;
        $image_fields['signature_image'] = $signature_imageFinal;

        $Setting->update($image_fields);

        return redirect()->back()->with('successSettingEdit',
            'ویرایش با موفقیت انجام شد.'
        )->withInput();
    }
}

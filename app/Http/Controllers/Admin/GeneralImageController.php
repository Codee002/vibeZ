<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGeneralImageRequest;
use App\Models\GeneralImage;
use Illuminate\Support\Facades\Storage;

class GeneralImageController extends Controller
{
    public function index()
    {
        $general = GeneralImage::first();
        // dd($general);
        return view("admin.general.index", [
            "general" => $general,
        ]);
    }

    public function storeImage(GeneralImage $general, $image, $type)
    {
        if ($general->$type) {
            // Xóa ảnh cũ
            Storage::delete($general->$type);
        }
        // Tạo ảnh mới
        return Storage::put("general", $image);
    }

    public function store(StoreGeneralImageRequest $request)
    {
        // dd($request->all());
        $data    = [];
        $general = GeneralImage::first();
        if (! $general) {
            $data['banner']      = Storage::put("general", $request['banner']);
            $data['logo_header'] = Storage::put("general", $request['logo_header']);
            $data['logo_footer'] = Storage::put("general", $request['logo_footer']);
            $data['login']       = Storage::put("general", $request['login']);
            $data['register']    = Storage::put("general", $request['register']);

            $general = GeneralImage::create($data);
            return view("admin.general.index", [
                "general" => $general,
            ]);
        }

        if ($request['banner']) {
            $data['banner'] = $this->storeImage($general, $request['banner'], "banner");
        }
        if ($request['logo_header']) {
            $data['logo_header'] = $this->storeImage($general, $request['logo_header'], "logo_header");
        }

        if ($request['logo_footer']) {
            $data['logo_footer'] = $this->storeImage($general, $request['logo_footer'], "logo_footer");
        }

        if ($request['login']) {
            $data['login'] = $this->storeImage($general, $request['login'], "login");
        }

        if ($request['register']) {
            $data['register'] = $this->storeImage($general, $request['register'], "register");
        }

        $general->update($data);

        return view("admin.general.index", [
            "general" => $general,
        ]);
    }

}

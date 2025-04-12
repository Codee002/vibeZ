<?php
namespace App\Http\Controllers\member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view("pages.components.contact");
    }

    public function handleContact(Request $request)
    {
        $validated = $request->validate([
            'type'    => 'required',
            'content' => 'required|max:200',
        ], [
            "type.required"    => "Vui lòng chọn nội dung",
            "content.required" => "Nội dung không được trống",
            "content.max"      => "Nội dung không được quá 200 ký tự",
        ]);

        $user = Auth::user();

        if ($user['email_active'] != 1)
        {
            return redirect()->back()->with("danger", "Vui lòng kích hoạt email để thực hiện chức năng này!");
        }

        $adminUser = env("MAIL_FROM_ADDRESS");
        $subject   = $request['type'];
        $data      = [
            'content' => $request['content'],
        ];

        try {
            Mail::send('auth.components.emailContactView', $data, function ($message) use ($user, $adminUser, $subject) {
                $message->from($user['email'], $user['email'] . " - " . $user['name']);
                $message->replyTo($user['email'], $user['name']); // Người dùng để trả lời lại
                $message->to($adminUser);
                $message->subject($subject);
            });
            return redirect()->back()->with("success", "Cảm ơn các bạn đã liên hệ! Chúng tôi sẽ phản hồi sớm nhất");
        } catch (\Throwable $th) {
            return redirect()->back()->with("danger", $th->getMessage())->withInput();
        }

    }
}

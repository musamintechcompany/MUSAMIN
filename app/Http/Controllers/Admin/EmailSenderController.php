<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailSenderController extends Controller
{
    public function index()
    {
        $templates = EmailTemplate::active()->get();
        return view('management.portal.admin.email-sender.index', compact('templates'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'template_id' => 'required|exists:email_templates,id',
            'recipient_type' => 'required|in:single,all,filtered',
            'email' => 'required_if:recipient_type,single|email',
            'user_ids' => 'required_if:recipient_type,filtered|array',
            'variables' => 'array'
        ]);

        $template = EmailTemplate::findOrFail($request->template_id);
        $variables = $request->variables ?? [];

        if ($request->recipient_type === 'single') {
            $this->sendToEmail($template, $request->email, $variables);
        } elseif ($request->recipient_type === 'all') {
            $users = User::all();
            foreach ($users as $user) {
                $this->sendToUser($template, $user, $variables);
            }
        } else {
            $users = User::whereIn('id', $request->user_ids)->get();
            foreach ($users as $user) {
                $this->sendToUser($template, $user, $variables);
            }
        }

        return back()->with('success', 'Emails sent successfully!');
    }

    private function sendToEmail($template, $email, $variables)
    {
        $subject = $this->replaceVariables($template->subject, $variables);
        $body = $this->buildEmailContent($template, $variables);

        Mail::html($body, function ($message) use ($email, $subject) {
            $message->to($email)->subject($subject);
        });
    }

    private function sendToUser($template, $user, $variables)
    {
        $userVariables = array_merge($variables, [
            'name' => $user->name,
            'email' => $user->email,
            'username' => $user->username ?? $user->name
        ]);

        $this->sendToEmail($template, $user->email, $userVariables);
    }

    private function buildEmailContent($template, $variables)
    {
        $header = $this->replaceVariables($template->header ?? '', $variables);
        $body = $this->replaceVariables($template->body, $variables);
        $footer = $this->replaceVariables($template->footer ?? '', $variables);

        $html = '<div style="max-width: 600px; margin: 0 auto; font-family: Arial, sans-serif;">';
        
        if ($template->header_image) {
            $html .= '<div style="text-align: center; margin-bottom: 20px;">';
            $html .= '<img src="' . asset('storage/' . $template->header_image) . '" alt="Header" style="max-width: 100%; height: auto;">';
            $html .= '</div>';
        }

        if ($header) {
            $html .= '<div style="margin-bottom: 20px;">' . nl2br($header) . '</div>';
        }

        $html .= '<div style="margin-bottom: 20px;">' . nl2br($body) . '</div>';

        if ($footer) {
            $html .= '<div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #eee;">' . nl2br($footer) . '</div>';
        }

        if ($template->footer_image) {
            $html .= '<div style="text-align: center; margin-top: 20px;">';
            $html .= '<img src="' . asset('storage/' . $template->footer_image) . '" alt="Footer" style="max-width: 100%; height: auto;">';
            $html .= '</div>';
        }

        $html .= '</div>';

        return $html;
    }

    private function replaceVariables($content, $variables)
    {
        foreach ($variables as $key => $value) {
            $content = str_replace('{{' . $key . '}}', $value, $content);
        }
        return $content;
    }
}
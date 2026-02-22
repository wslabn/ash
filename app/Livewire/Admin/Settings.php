<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Setting;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Settings extends Component
{
    public $sendgrid_api_key;
    public $mail_from_address;
    public $mail_from_name;
    public $twilio_account_sid;
    public $twilio_auth_token;
    public $twilio_phone_number;
    public $discord_community_invite;
    public $discord_feedback_webhook;

    public function mount()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $this->sendgrid_api_key = Setting::get('sendgrid.api_key', '');
        $this->mail_from_address = Setting::get('mail.from.address', config('mail.from.address'));
        $this->mail_from_name = Setting::get('mail.from.name', config('mail.from.name'));
        $this->twilio_account_sid = Setting::get('twilio.account_sid', '');
        $this->twilio_auth_token = Setting::get('twilio.auth_token', '');
        $this->twilio_phone_number = Setting::get('twilio.phone_number', '');
        $this->discord_community_invite = Setting::get('discord.community_invite', '');
        $this->discord_feedback_webhook = Setting::get('discord.feedback_webhook', '');
    }

    public function save()
    {
        $this->validate([
            'mail_from_address' => 'required|email',
            'mail_from_name' => 'required|string|max:255',
        ]);

        Setting::set('sendgrid.api_key', $this->sendgrid_api_key, true);
        Setting::set('mail.from.address', $this->mail_from_address);
        Setting::set('mail.from.name', $this->mail_from_name);
        Setting::set('twilio.account_sid', $this->twilio_account_sid, true);
        Setting::set('twilio.auth_token', $this->twilio_auth_token, true);
        Setting::set('twilio.phone_number', $this->twilio_phone_number);
        Setting::set('discord.community_invite', $this->discord_community_invite);
        Setting::set('discord.feedback_webhook', $this->discord_feedback_webhook, true);

        session()->flash('message', 'Settings saved successfully!');
    }

    public function render()
    {
        return view('livewire.admin.settings');
    }
}

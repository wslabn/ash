<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\On;

class FeedbackModal extends Component
{
    public $showModal = false;
    public $type = 'bug'; // bug or feature
    public $title = '';
    public $description = '';

    #[On('openFeedbackModal')]
    public function openModal($type = 'bug')
    {
        $this->type = $type;
        $this->showModal = true;
        $this->reset(['title', 'description']);
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function submit()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
        ]);

        $webhookUrl = Setting::get('discord.feedback_webhook');
        
        if ($webhookUrl) {
            try {
                $emoji = $this->type === 'bug' ? '🐛' : '💡';
                $color = $this->type === 'bug' ? 15158332 : 3447003; // Red for bugs, blue for features
                
                Http::post($webhookUrl, [
                    'embeds' => [[
                        'title' => $emoji . ' ' . ($this->type === 'bug' ? 'Bug Report' : 'Feature Request'),
                        'description' => "**{$this->title}**\n\n{$this->description}",
                        'color' => $color,
                        'fields' => [
                            [
                                'name' => 'Submitted by',
                                'value' => auth()->user()->name . ' (' . auth()->user()->email . ')',
                                'inline' => false
                            ]
                        ],
                        'timestamp' => now()->toIso8601String()
                    ]]
                ]);
            } catch (\Exception $e) {
                // Silently fail if webhook doesn't work
            }
        }

        session()->flash('message', 'Thank you for your feedback!');
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.feedback-modal');
    }
}

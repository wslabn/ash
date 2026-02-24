<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;

class DiscordNotificationService
{
    public static function sendMilestone($user, $type, $message)
    {
        $webhookUrl = Setting::get('discord.feedback_webhook');
        
        if (!$webhookUrl) return;

        try {
            $emoji = match($type) {
                'sales' => '💰',
                'customers' => '👥',
                'recruiting' => '🎉',
                default => '🎊'
            };

            Http::post($webhookUrl, [
                'embeds' => [[
                    'title' => $emoji . ' Milestone Achieved!',
                    'description' => $message,
                    'color' => 5763719, // Gold
                    'fields' => [
                        [
                            'name' => 'Consultant',
                            'value' => $user->name,
                            'inline' => true
                        ]
                    ],
                    'timestamp' => now()->toIso8601String()
                ]]
            ]);
        } catch (\Exception $e) {
            // Silently fail
        }
    }

    public static function sendLowStockAlert($user, $product, $quantity)
    {
        $webhookUrl = Setting::get('discord.feedback_webhook');
        
        if (!$webhookUrl) return;

        try {
            Http::post($webhookUrl, [
                'embeds' => [[
                    'title' => '⚠️ Low Stock Alert',
                    'description' => "**{$product->name}** is running low!",
                    'color' => 15105570, // Orange
                    'fields' => [
                        [
                            'name' => 'Consultant',
                            'value' => $user->name,
                            'inline' => true
                        ],
                        [
                            'name' => 'Current Stock',
                            'value' => $quantity . ' remaining',
                            'inline' => true
                        ]
                    ],
                    'timestamp' => now()->toIso8601String()
                ]]
            ]);
        } catch (\Exception $e) {
            // Silently fail
        }
    }

    public static function sendRecruitingNotification($consultant, $customer, $type)
    {
        $webhookUrl = Setting::get('discord.feedback_webhook');
        
        if (!$webhookUrl) return;

        try {
            $message = match($type) {
                'interest' => "**{$customer->full_name}** is showing interest in becoming a consultant!",
                'converted' => "🎉 **{$customer->full_name}** has been converted to a consultant!",
                default => ''
            };

            $emoji = $type === 'converted' ? '🎊' : '👀';
            $color = $type === 'converted' ? 5763719 : 3447003;

            Http::post($webhookUrl, [
                'embeds' => [[
                    'title' => $emoji . ' Recruiting Update',
                    'description' => $message,
                    'color' => $color,
                    'fields' => [
                        [
                            'name' => 'Recruiter',
                            'value' => $consultant->name,
                            'inline' => true
                        ]
                    ],
                    'timestamp' => now()->toIso8601String()
                ]]
            ]);
        } catch (\Exception $e) {
            // Silently fail
        }
    }

    public static function sendNewSubscription($user)
    {
        $webhookUrl = Setting::get('discord.feedback_webhook');
        
        if (!$webhookUrl) return;

        try {
            Http::post($webhookUrl, [
                'embeds' => [[
                    'title' => '🎉 New Subscription!',
                    'description' => "**{$user->name}** just subscribed to Ashbrooke CRM!",
                    'color' => 5763719, // Gold
                    'fields' => [
                        [
                            'name' => 'Email',
                            'value' => $user->email,
                            'inline' => true
                        ]
                    ],
                    'timestamp' => now()->toIso8601String()
                ]]
            ]);
        } catch (\Exception $e) {
            // Silently fail
        }
    }

    public static function sendNewLead($consultant, $customer)
    {
        $webhookUrl = Setting::get('discord.feedback_webhook');
        
        if (!$webhookUrl) return;

        try {
            Http::post($webhookUrl, [
                'embeds' => [[
                    'title' => '📬 New Lead from Landing Page!',
                    'description' => "**{$customer->full_name}** submitted a contact form",
                    'color' => 3447003, // Blue
                    'fields' => [
                        [
                            'name' => 'Consultant',
                            'value' => $consultant->name,
                            'inline' => true
                        ],
                        [
                            'name' => 'Email',
                            'value' => $customer->email ?: 'Not provided',
                            'inline' => true
                        ],
                        [
                            'name' => 'Phone',
                            'value' => $customer->phone ?: 'Not provided',
                            'inline' => true
                        ]
                    ],
                    'timestamp' => now()->toIso8601String()
                ]]
            ]);
        } catch (\Exception $e) {
            // Silently fail
        }
    }
}

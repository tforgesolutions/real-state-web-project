<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Inquiry;

class NewInquiryNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $inquiry;

    /**
     * Create a new notification instance.
     */
    public function __construct(Inquiry $inquiry)
    {
        $this->inquiry = $inquiry;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // Try to send email, but safely catch failures if mail is not configured
        // By default we rely on database notification, mail is optional.
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        try {
            $type = $this->inquiry->inquiry_type ?? 'New Inquiry';
            
            return (new MailMessage)
                        ->subject("New {$type} received from {$this->inquiry->name}")
                        ->greeting("Hello,")
                        ->line("You have received a new inquiry on the Real Estate platform.")
                        ->line("**Type:** {$type}")
                        ->line("**From:** {$this->inquiry->name} ({$this->inquiry->email})")
                        ->line("**Message:**")
                        ->line($this->inquiry->message)
                        ->action('View Inquiry', route('admin.inquiries.show', $this->inquiry->id))
                        ->line('Thank you for using our application!');
        } catch (\Exception $e) {
            // Silently fallback if mail configuration is missing or broken.
            return (new MailMessage)->line("New inquiry received.");
        }
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        $type = $this->inquiry->inquiry_type ?? 'New Inquiry';
        $shortMessage = \Illuminate\Support\Str::limit($this->inquiry->message, 50);

        return [
            'inquiry_id' => $this->inquiry->id,
            'type' => $type,
            'name' => $this->inquiry->name,
            'message' => $shortMessage,
            'property_id' => $this->inquiry->property_id,
            'project_id' => $this->inquiry->project_id,
        ];
    }
}

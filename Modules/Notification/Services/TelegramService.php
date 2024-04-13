<?php

namespace Modules\Notification\Services;

use GuzzleHttp\Client;
use App\Models\Company;
use Modules\ITSM\Entities\Incident;
use Modules\ITSM\Entities\WorkOrder;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\Http;

use Telegram\Bot\Laravel\Facades\Telegram;


class TelegramService
{
    protected $client;
    protected $botToken;
    protected $chatId;
    protected $active;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $user = auth()->user();
    
        // Retrieve the company data based on user_id and cid
        $company = Company::where('cid', $user->cid)
            ->first(); // Use 'first' to get a single result or null if not found
    
        if($company){
            $jsonData = json_decode($company->payload, true);
            $botToken = $jsonData['telegram']['bot_token'] ?? '';
            $chatId = $jsonData['telegram']['recipient'] ?? '';
            $active = $jsonData['telegram']['active'] ?? '';
        }
    
        $this->botToken = $botToken;
        $this->chatId = $chatId;
        $this->active = $active;
    }

    public function sendIncidentReport($id)
    {

        // Set the bot token dynamically
        Telegram::setAccessToken($this->botToken);

        $incident = Incident::where('id',$id)->first();

        $message = "<b>Incident Report</b>\n";
        $message .= "<b>====================</b>\n";
        $message .= "<b>Date: </b><code>#" . $incident->created_at->format('Ymd') . "</code>\n";
        $message .= "<b>Number: </b><code>#" . $incident->incident_number . "</code>\n";
        $message .= "<b>Title: </b><em>" . $incident->title . "</em>\n";
        $message .= "<b>Severity: </b><b>" . $incident->severity . "</b>\n";
        $message .= "<b>Timestamp: </b><em>" . $incident->created_at->format('Y-m-d H:i:s') . "</em>";
        // ... Add additional data points and formatting as needed

        $url = "https://api.telegram.org/bot{$this->botToken}/sendMessage";

        try {
            // Send message with HTML parse mode
            $response = Telegram::sendMessage([
                'chat_id' => $this->chatId,
                'parse_mode' => 'HTML',
                'text' => $message,
            ]);
    
            if (!$response->ok()) {
                throw new Exception($response->json('description'));
            }
    
            return $response->getBody();
        } catch (Exception $e) {
            // Handle errors appropriately (e.g., log the error, notify admins)
            Log::error('Telegram API error:', [$e->getMessage()]);
            return $e->getMessage(); // Or return a custom error message
        }
    }

    public function sendWorkOrder($id)
    {
        // Set the bot token dynamically
        Telegram::setAccessToken($this->botToken);

        $workorder = WorkOrder::where('id',$id)->first();

        $message = "<b>Work Order</b>\n";
        $message .= "<b>====================</b>\n";
        $message .= "<b>Date: </b><code>#" . $workorder->created_at->format('Ymd') . "</code>\n";
        $message .= "<b>Number: </b><code>#" . $workorder->workorder_number . "</code>\n";
        $message .= "<b>Priority: </b><b>" . $workorder->priority . "</b>\n";
        $message .= "<b>Timestamp: </b><em>" . $workorder->created_at->format('Y-m-d H:i:s') . "</em>\n";
        // $message .= "<b>Description: </b>\n" . $workorder->description;
        $message .= "<b>Title: </b>\n" . $workorder->subject."\n";
        $message .= "<b>Location: </b>\n" . $workorder->location."\n";
        $message .= "<b>Staff: </b>\n" . $workorder->staff[0]."\n";
        // ... Add additional data points and formatting as needed

        $url = "https://api.telegram.org/bot{$this->botToken}/sendMessage";

        try {
            // Send message with HTML parse mode
            $response = Telegram::sendMessage([
                'chat_id' => $this->chatId,
                'parse_mode' => 'HTML',
                'text' => $message,
            ]);
    
            if (!$response->ok()) {
                throw new Exception($response->json('description'));
            }
    
            return $response->getBody();
        } catch (Exception $e) {
            // Handle errors appropriately (e.g., log the error, notify admins)
            Log::error('Telegram API error:', [$e->getMessage()]);
            return $e->getMessage(); // Or return a custom error message
        }
    }

    public function sendMessage($message)
    {
        $url = "https://api.telegram.org/bot{$this->botToken}/sendMessage";

        $response = $this->client->post($url, [
            'json' => [
                'chat_id' => $this->chatId,
                'text' => $message
            ]
        ]);

        return $response->getBody();
    }

    
}

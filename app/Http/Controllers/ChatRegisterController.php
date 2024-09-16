<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

class ChatRegisterController extends Controller
{
    public function storeChatId(Request $request)
    {
        throw new \Exception("Exception is being tested");
        $chatId = $request->input('chat_id');

        if ($chatId) {
            $chatIds = Config::get('chat.chat_ids', []);

            if (in_array($chatId, $chatIds)) {
                return response()->json(['message' => sprintf("Chat ID %d already exists", $chatId)]);
            }

            $chatIds[] = $chatId;
            $this->updateChatIdsConfig($chatIds);

            return response()->json(['message' => sprintf("Chat ID %d has been successfully registered", $chatId)]);
        }

        return response()->json(['error' => 'Chat ID is required'], 400);
    }


    private function updateChatIdsConfig(array $chatIds)
    {
        $configPath = config_path('chat.php');

        if (!File::exists($configPath)) {
            File::put($configPath, "<?php\n\nreturn [\n    'chat_ids' => []\n];\n");
        }

        $content = "<?php\n\nreturn [\n    'chat_ids' => " . var_export($chatIds, true) . "\n];\n";

        File::put($configPath, $content);

        Artisan::call('config:clear');
        return $content;
    }
}

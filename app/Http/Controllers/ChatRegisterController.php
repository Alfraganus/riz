<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;

class ChatRegisterController extends Controller
{
    public function storeChatId(Request $request)
    {
        $chatIds = config('chat.php') ;
        return var_dump($chatIds);
        $chatId = $request->input('chat_id');

        if ($chatId) {
            $chatIds = Config::get('chat.chat_ids', []);

            if (!in_array($chatId, $chatIds)) {
                $chatIds[] = $chatId;

                $this->updateChatIdsConfig($chatIds);
            }
        }

        return response()->json(['result' => $chatIds]);
    }

    private function updateChatIdsConfig(array $chatIds)
    {
        $configPath = config_path('chat.php');

        $content = "<?php\n\nreturn [\n    'chat_ids' => " . var_export($chatIds, true) . "\n];\n";

        file_put_contents($configPath, $content);
    }
}

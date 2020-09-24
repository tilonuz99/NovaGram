<?php

namespace skrtdev\NovaGram;

trait Methods{

    public function getUpdates($args = [], bool $payload = false){
        $params = $args;
        return $this->APICall("getUpdates", $params, $payload);
    }
    public function setWebhook(string $url, $args = [], bool $payload = false){
        if(is_array($url)){
            $payload = $args; // 2nd param
            $params = $url;
        }
        else{
            $params = ["url" => $url] + $args;
        }
        return $this->APICall("setWebhook", $params, $payload);
    }
    public function deleteWebhook(bool $payload = false){
        $params = $args;
        return $this->APICall("deleteWebhook", $params, $payload);
    }
    public function getWebhookInfo(bool $payload = false){
        $params = $args;
        return $this->APICall("getWebhookInfo", $params, $payload);
    }
    public function getMe(bool $payload = false){
        $params = $args;
        return $this->APICall("getMe", $params, $payload);
    }
    public function sendMessage($chat_id, $text = null, $args = [], bool $payload = false){
        if(is_array($chat_id)){
            $payload = $text; // 2nd param
            $params = $chat_id;
        }
        else{
            $params = ["chat_id" => $chat_id, "text" => $text] + $args;
        }
        return $this->APICall("sendMessage", $params, $payload);
    }
    public function forwardMessage($chat_id, $from_chat_id = null, int $message_id = null, array $args = [], bool $payload = false){
        if(is_array($chat_id)){
            $payload = $from_chat_id; // 2nd param
            $params = $chat_id;
        }
        else{
            $params = ["chat_id" => $chat_id, "from_chat_id" => $from_chat_id, "message_id" => $message_id] + $args;
        }
        return $this->APICall("forwardMessage", $params, $payload);
    }
    public function sendPhoto($chat_id, $photo = null, $args = [], bool $payload = false){
        if(is_array($chat_id)){
            $payload = $photo; // 2nd param
            $params = $chat_id;
        }
        else{
            $params = ["chat_id" => $chat_id, "photo" => $photo] + $args;
        }
        return $this->APICall("sendPhoto", $params, $payload);
    }
    public function sendAudio($chat_id, $audio = null, $args = [], bool $payload = false){
        if(is_array($chat_id)){
            $payload = $audio; // 2nd param
            $params = $chat_id;
        }
        else{
            $params = ["chat_id" => $chat_id, "audio" => $audio] + $args;
        }
        return $this->APICall("sendAudio", $params, $payload);
    }
    public function sendDocument($chat_id, $document = null, $args = [], bool $payload = false){
        if(is_array($chat_id)){
            $payload = $document; // 2nd param
            $params = $chat_id;
        }
        else{
            $params = ["chat_id" => $chat_id, "document" => $document] + $args;
        }
        return $this->APICall("sendDocument", $params, $payload);
    }
    public function sendVideo($chat_id, $video = null, $args = [], bool $payload = false){
        if(is_array($chat_id)){
            $payload = $video; // 2nd param
            $params = $chat_id;
        }
        else{
            $params = ["chat_id" => $chat_id, "video" => $video] + $args;
        }
        return $this->APICall("sendVideo", $params, $payload);
    }
    public function sendAnimation($chat_id, $animation = null, $args = [], bool $payload = false){
        if(is_array($chat_id)){
            $payload = $animation; // 2nd param
            $params = $chat_id;
        }
        else{
            $params = ["chat_id" => $chat_id, "animation" => $animation] + $args;
        }
        return $this->APICall("sendAnimation", $params, $payload);
    }
    public function sendVoice($chat_id, $voice = null, $args = [], bool $payload = false){
        if(is_array($chat_id)){
            $payload = $voice; // 2nd param
            $params = $chat_id;
        }
        else{
            $params = ["chat_id" => $chat_id, "voice" => $voice] + $args;
        }
        return $this->APICall("sendVoice", $params, $payload);
    }
    public function sendVideoNote($chat_id, $video_note = null, $args = [], bool $payload = false){
        if(is_array($chat_id)){
            $payload = $video_note; // 2nd param
            $params = $chat_id;
        }
        else{
            $params = ["chat_id" => $chat_id, "video_note" => $video_note] + $args;
        }
        return $this->APICall("sendVideoNote", $params, $payload);
    }
    public function sendMediaGroup($chat_id, $media = null, $args = [], bool $payload = false){
        if(is_array($chat_id)){
            $payload = $media; // 2nd param
            $params = $chat_id;
        }
        else{
            $params = ["chat_id" => $chat_id, "media" => $media] + $args;
        }
        return $this->APICall("sendMediaGroup", $params, $payload);
    }
    public function sendLocation($chat_id, $latitude = null, float $longitude = null, array $args = [], bool $payload = false){
        if(is_array($chat_id)){
            $payload = $latitude; // 2nd param
            $params = $chat_id;
        }
        else{
            $params = ["chat_id" => $chat_id, "latitude" => $latitude, "longitude" => $longitude] + $args;
        }
        return $this->APICall("sendLocation", $params, $payload);
    }
    public function editMessageLiveLocation(float $latitude, $longitude = null, $args = [], bool $payload = false){
        if(is_array($latitude)){
            $payload = $longitude; // 2nd param
            $params = $latitude;
        }
        else{
            $params = ["latitude" => $latitude, "longitude" => $longitude] + $args;
        }
        return $this->APICall("editMessageLiveLocation", $params, $payload);
    }
    public function stopMessageLiveLocation($args = [], bool $payload = false){
        $params = $args;
        return $this->APICall("stopMessageLiveLocation", $params, $payload);
    }
    public function sendVenue($chat_id, $latitude = null, float $longitude = null, string $title = null, string $address = null, array $args = [], bool $payload = false){
        if(is_array($chat_id)){
            $payload = $latitude; // 2nd param
            $params = $chat_id;
        }
        else{
            $params = ["chat_id" => $chat_id, "latitude" => $latitude, "longitude" => $longitude, "title" => $title, "address" => $address] + $args;
        }
        return $this->APICall("sendVenue", $params, $payload);
    }
    public function sendContact($chat_id, $phone_number = null, string $first_name = null, array $args = [], bool $payload = false){
        if(is_array($chat_id)){
            $payload = $phone_number; // 2nd param
            $params = $chat_id;
        }
        else{
            $params = ["chat_id" => $chat_id, "phone_number" => $phone_number, "first_name" => $first_name] + $args;
        }
        return $this->APICall("sendContact", $params, $payload);
    }
    public function sendPoll($chat_id, $question = null, array $options = null, array $args = [], bool $payload = false){
        if(is_array($chat_id)){
            $payload = $question; // 2nd param
            $params = $chat_id;
        }
        else{
            $params = ["chat_id" => $chat_id, "question" => $question, "options" => $options] + $args;
        }
        return $this->APICall("sendPoll", $params, $payload);
    }
    public function sendDice($chat_id, $args = [], bool $payload = false){
        if(is_array($chat_id)){
            $payload = $args; // 2nd param
            $params = $chat_id;
        }
        else{
            $params = ["chat_id" => $chat_id] + $args;
        }
        return $this->APICall("sendDice", $params, $payload);
    }
    public function sendChatAction($chat_id, $action = null, bool $payload = false){
        if(is_array($chat_id)){
            $payload = $action; // 2nd param
            $params = $chat_id;
        }
        else{
            $params = ["chat_id" => $chat_id, "action" => $action] + $args;
        }
        return $this->APICall("sendChatAction", $params, $payload);
    }
    public function getUserProfilePhotos(int $user_id, $args = [], bool $payload = false){
        if(is_array($user_id)){
            $payload = $args; // 2nd param
            $params = $user_id;
        }
        else{
            $params = ["user_id" => $user_id] + $args;
        }
        return $this->APICall("getUserProfilePhotos", $params, $payload);
    }
    public function getFile(string $file_id, bool $payload = false){
        if(is_array($file_id)){
            $payload = $args; // 2nd param
            $params = $file_id;
        }
        else{
            $params = ["file_id" => $file_id] + $args;
        }
        return $this->APICall("getFile", $params, $payload);
    }
    public function kickChatMember($chat_id, $user_id = null, $args = [], bool $payload = false){
        if(is_array($chat_id)){
            $payload = $user_id; // 2nd param
            $params = $chat_id;
        }
        else{
            $params = ["chat_id" => $chat_id, "user_id" => $user_id] + $args;
        }
        return $this->APICall("kickChatMember", $params, $payload);
    }
    public function unbanChatMember($chat_id, $user_id = null, bool $payload = false){
        if(is_array($chat_id)){
            $payload = $user_id; // 2nd param
            $params = $chat_id;
        }
        else{
            $params = ["chat_id" => $chat_id, "user_id" => $user_id] + $args;
        }
        return $this->APICall("unbanChatMember", $params, $payload);
    }
    public function restrictChatMember($chat_id, $user_id = null, ChatPermissions $permissions = null, array $args = [], bool $payload = false){
        if(is_array($chat_id)){
            $payload = $user_id; // 2nd param
            $params = $chat_id;
        }
        else{
            $params = ["chat_id" => $chat_id, "user_id" => $user_id, "permissions" => $permissions] + $args;
        }
        return $this->APICall("restrictChatMember", $params, $payload);
    }
    public function promoteChatMember($chat_id, $user_id = null, $args = [], bool $payload = false){
        if(is_array($chat_id)){
            $payload = $user_id; // 2nd param
            $params = $chat_id;
        }
        else{
            $params = ["chat_id" => $chat_id, "user_id" => $user_id] + $args;
        }
        return $this->APICall("promoteChatMember", $params, $payload);
    }
    public function setChatAdministratorCustomTitle($chat_id, $user_id = null, string $custom_title = null, bool $payload = false){
        if(is_array($chat_id)){
            $payload = $user_id; // 2nd param
            $params = $chat_id;
        }
        else{
            $params = ["chat_id" => $chat_id, "user_id" => $user_id, "custom_title" => $custom_title] + $args;
        }
        return $this->APICall("setChatAdministratorCustomTitle", $params, $payload);
    }
    public function setChatPermissions($chat_id, $permissions = null, bool $payload = false){
        if(is_array($chat_id)){
            $payload = $permissions; // 2nd param
            $params = $chat_id;
        }
        else{
            $params = ["chat_id" => $chat_id, "permissions" => $permissions] + $args;
        }
        return $this->APICall("setChatPermissions", $params, $payload);
    }
    public function exportChatInviteLink($chat_id, bool $payload = false){
        if(is_array($chat_id)){
            $payload = $args; // 2nd param
            $params = $chat_id;
        }
        else{
            $params = ["chat_id" => $chat_id] + $args;
        }
        return $this->APICall("exportChatInviteLink", $params, $payload);
    }
    public function setChatPhoto($chat_id, $photo = null, bool $payload = false){
        if(is_array($chat_id)){
            $payload = $photo; // 2nd param
            $params = $chat_id;
        }
        else{
            $params = ["chat_id" => $chat_id, "photo" => $photo] + $args;
        }
        return $this->APICall("setChatPhoto", $params, $payload);
    }
    public function deleteChatPhoto($chat_id, bool $payload = false){
        if(is_array($chat_id)){
            $payload = $args; // 2nd param
            $params = $chat_id;
        }
        else{
            $params = ["chat_id" => $chat_id] + $args;
        }
        return $this->APICall("deleteChatPhoto", $params, $payload);
    }
    public function setChatTitle($chat_id, $title = null, bool $payload = false){
        if(is_array($chat_id)){
            $payload = $title; // 2nd param
            $params = $chat_id;
        }
        else{
            $params = ["chat_id" => $chat_id, "title" => $title] + $args;
        }
        return $this->APICall("setChatTitle", $params, $payload);
    }
    public function setChatDescription($chat_id, $args = [], bool $payload = false){
        if(is_array($chat_id)){
            $payload = $args; // 2nd param
            $params = $chat_id;
        }
        else{
            $params = ["chat_id" => $chat_id] + $args;
        }
        return $this->APICall("setChatDescription", $params, $payload);
    }
    public function pinChatMessage($chat_id, $message_id = null, $args = [], bool $payload = false){
        if(is_array($chat_id)){
            $payload = $message_id; // 2nd param
            $params = $chat_id;
        }
        else{
            $params = ["chat_id" => $chat_id, "message_id" => $message_id] + $args;
        }
        return $this->APICall("pinChatMessage", $params, $payload);
    }
    public function unpinChatMessage($chat_id, bool $payload = false){
        if(is_array($chat_id)){
            $payload = $args; // 2nd param
            $params = $chat_id;
        }
        else{
            $params = ["chat_id" => $chat_id] + $args;
        }
        return $this->APICall("unpinChatMessage", $params, $payload);
    }
    public function leaveChat($chat_id, bool $payload = false){
        if(is_array($chat_id)){
            $payload = $args; // 2nd param
            $params = $chat_id;
        }
        else{
            $params = ["chat_id" => $chat_id] + $args;
        }
        return $this->APICall("leaveChat", $params, $payload);
    }
    public function getChat($chat_id, bool $payload = false){
        if(is_array($chat_id)){
            $payload = $args; // 2nd param
            $params = $chat_id;
        }
        else{
            $params = ["chat_id" => $chat_id] + $args;
        }
        return $this->APICall("getChat", $params, $payload);
    }
    public function getChatAdministrators($chat_id, bool $payload = false){
        if(is_array($chat_id)){
            $payload = $args; // 2nd param
            $params = $chat_id;
        }
        else{
            $params = ["chat_id" => $chat_id] + $args;
        }
        return $this->APICall("getChatAdministrators", $params, $payload);
    }
    public function getChatMembersCount($chat_id, bool $payload = false){
        if(is_array($chat_id)){
            $payload = $args; // 2nd param
            $params = $chat_id;
        }
        else{
            $params = ["chat_id" => $chat_id] + $args;
        }
        return $this->APICall("getChatMembersCount", $params, $payload);
    }
    public function getChatMember($chat_id, $user_id = null, bool $payload = false){
        if(is_array($chat_id)){
            $payload = $user_id; // 2nd param
            $params = $chat_id;
        }
        else{
            $params = ["chat_id" => $chat_id, "user_id" => $user_id] + $args;
        }
        return $this->APICall("getChatMember", $params, $payload);
    }
    public function setChatStickerSet($chat_id, $sticker_set_name = null, bool $payload = false){
        if(is_array($chat_id)){
            $payload = $sticker_set_name; // 2nd param
            $params = $chat_id;
        }
        else{
            $params = ["chat_id" => $chat_id, "sticker_set_name" => $sticker_set_name] + $args;
        }
        return $this->APICall("setChatStickerSet", $params, $payload);
    }
    public function deleteChatStickerSet($chat_id, bool $payload = false){
        if(is_array($chat_id)){
            $payload = $args; // 2nd param
            $params = $chat_id;
        }
        else{
            $params = ["chat_id" => $chat_id] + $args;
        }
        return $this->APICall("deleteChatStickerSet", $params, $payload);
    }
    public function answerCallbackQuery(string $callback_query_id, $args = [], bool $payload = false){
        if(is_array($callback_query_id)){
            $payload = $args; // 2nd param
            $params = $callback_query_id;
        }
        else{
            $params = ["callback_query_id" => $callback_query_id] + $args;
        }
        return $this->APICall("answerCallbackQuery", $params, $payload);
    }
    public function setMyCommands($args = [], bool $payload = false){
        $params = $args;
        return $this->APICall("setMyCommands", $params, $payload);
    }
    public function getMyCommands(string $text, $args = [], bool $payload = false){
        if(is_array($text)){
            $payload = $args; // 2nd param
            $params = $text;
        }
        else{
            $params = ["text" => $text] + $args;
        }
        return $this->APICall("getMyCommands", $params, $payload);
    }
    public function editMessageText($args = [], bool $payload = false){
        $params = $args;
        return $this->APICall("editMessageText", $params, $payload);
    }
    public function editMessageCaption(InputMedia $media, $args = [], bool $payload = false){
        if(is_array($media)){
            $payload = $args; // 2nd param
            $params = $media;
        }
        else{
            $params = ["media" => $media] + $args;
        }
        return $this->APICall("editMessageCaption", $params, $payload);
    }
    public function editMessageMedia($args = [], bool $payload = false){
        $params = $args;
        return $this->APICall("editMessageMedia", $params, $payload);
    }
    public function editMessageReplyMarkup($chat_id, $message_id = null, $args = [], bool $payload = false){
        if(is_array($chat_id)){
            $payload = $message_id; // 2nd param
            $params = $chat_id;
        }
        else{
            $params = ["chat_id" => $chat_id, "message_id" => $message_id] + $args;
        }
        return $this->APICall("editMessageReplyMarkup", $params, $payload);
    }
    public function stopPoll($chat_id, $message_id = null, bool $payload = false){
        if(is_array($chat_id)){
            $payload = $message_id; // 2nd param
            $params = $chat_id;
        }
        else{
            $params = ["chat_id" => $chat_id, "message_id" => $message_id] + $args;
        }
        return $this->APICall("stopPoll", $params, $payload);
    }
    public function deleteMessage($args = [], bool $payload = false){
        $params = $args;
        return $this->APICall("deleteMessage", $params, $payload);
    }
    public function sendSticker(string $name, bool $payload = false){
        if(is_array($name)){
            $payload = $args; // 2nd param
            $params = $name;
        }
        else{
            $params = ["name" => $name] + $args;
        }
        return $this->APICall("sendSticker", $params, $payload);
    }
    public function getStickerSet(int $user_id, $png_sticker = null, bool $payload = false){
        if(is_array($user_id)){
            $payload = $png_sticker; // 2nd param
            $params = $user_id;
        }
        else{
            $params = ["user_id" => $user_id, "png_sticker" => $png_sticker] + $args;
        }
        return $this->APICall("getStickerSet", $params, $payload);
    }
    public function uploadStickerFile(int $user_id, $name = null, string $title = null, string $emojis = null, array $args = [], bool $payload = false){
        if(is_array($user_id)){
            $payload = $name; // 2nd param
            $params = $user_id;
        }
        else{
            $params = ["user_id" => $user_id, "name" => $name, "title" => $title, "emojis" => $emojis] + $args;
        }
        return $this->APICall("uploadStickerFile", $params, $payload);
    }
    public function createNewStickerSet(int $user_id, $name = null, string $emojis = null, array $args = [], bool $payload = false){
        if(is_array($user_id)){
            $payload = $name; // 2nd param
            $params = $user_id;
        }
        else{
            $params = ["user_id" => $user_id, "name" => $name, "emojis" => $emojis] + $args;
        }
        return $this->APICall("createNewStickerSet", $params, $payload);
    }
    public function addStickerToSet(string $sticker, $position = null, bool $payload = false){
        if(is_array($sticker)){
            $payload = $position; // 2nd param
            $params = $sticker;
        }
        else{
            $params = ["sticker" => $sticker, "position" => $position] + $args;
        }
        return $this->APICall("addStickerToSet", $params, $payload);
    }
    public function setStickerPositionInSet(string $sticker, bool $payload = false){
        if(is_array($sticker)){
            $payload = $args; // 2nd param
            $params = $sticker;
        }
        else{
            $params = ["sticker" => $sticker] + $args;
        }
        return $this->APICall("setStickerPositionInSet", $params, $payload);
    }
    public function deleteStickerFromSet(string $name, $user_id = null, $args = [], bool $payload = false){
        if(is_array($name)){
            $payload = $user_id; // 2nd param
            $params = $name;
        }
        else{
            $params = ["name" => $name, "user_id" => $user_id] + $args;
        }
        return $this->APICall("deleteStickerFromSet", $params, $payload);
    }
    public function setStickerSetThumb($args = [], bool $payload = false){
        $params = $args;
        return $this->APICall("setStickerSetThumb", $params, $payload);
    }
    public function answerInlineQuery($args = [], bool $payload = false){
        $params = $args;
        return $this->APICall("answerInlineQuery", $params, $payload);
    }
    public function sendInvoice(string $shipping_query_id, $ok = null, $args = [], bool $payload = false){
        if(is_array($shipping_query_id)){
            $payload = $ok; // 2nd param
            $params = $shipping_query_id;
        }
        else{
            $params = ["shipping_query_id" => $shipping_query_id, "ok" => $ok] + $args;
        }
        return $this->APICall("sendInvoice", $params, $payload);
    }
    public function answerShippingQuery(string $pre_checkout_query_id, $ok = null, $args = [], bool $payload = false){
        if(is_array($pre_checkout_query_id)){
            $payload = $ok; // 2nd param
            $params = $pre_checkout_query_id;
        }
        else{
            $params = ["pre_checkout_query_id" => $pre_checkout_query_id, "ok" => $ok] + $args;
        }
        return $this->APICall("answerShippingQuery", $params, $payload);
    }
    public function answerPreCheckoutQuery($args = [], bool $payload = false){
        $params = $args;
        return $this->APICall("answerPreCheckoutQuery", $params, $payload);
    }
    public function setPassportDataErrors($args = [], bool $payload = false){
        $params = $args;
        return $this->APICall("setPassportDataErrors", $params, $payload);
    }
    public function sendGame($args = [], bool $payload = false){
        $params = $args;
        return $this->APICall("sendGame", $params, $payload);
    }
    public function setGameScore(int $user_id, $args = [], bool $payload = false){
        if(is_array($user_id)){
            $payload = $args; // 2nd param
            $params = $user_id;
        }
        else{
            $params = ["user_id" => $user_id] + $args;
        }
        return $this->APICall("setGameScore", $params, $payload);
    }
    public function getGameHighScores($args = [], bool $payload = false){
        $params = $args;
        return $this->APICall("getGameHighScores", $params, $payload);
    }
}
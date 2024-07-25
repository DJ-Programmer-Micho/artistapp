<?php

namespace App\Http\Livewire\Artists;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class YoutubeCardLivewire extends Component
{
    public $channel_id;
    public $apiKey;
    //MAIN FUNCTIONS
    function mount()
    {
        $user_noti = array(
            'message' => 'Please Sign In Again', 
            'alert-type' => 'info'
        );


        if (!Auth::check()) {
            return redirect('/login')->with($user_noti);
        }        

        $userData = Auth::user();
        $this->channel_id =$userData->profile->youtube_channel;
        $this->apiKey = env('YOUTUBE_API_V4');
    }

    //RENDER VIEW
    public function render()
    {
        
        $apiUrl = 'https://www.googleapis.com/youtube/v3/channels?part=snippet,contentDetails,statistics,brandingSettings&id=' . $this->channel_id . '&key=' . $this->apiKey;
        $response = file_get_contents($apiUrl);
        if ($response === false) {
            die('Failed to fetch data from YouTube API.');
        }
        // dd($response);
        $data = json_decode($response, true);
        if (!isset($data['items']) || empty($data['items'])) {
            die('Invalid API response. Unable to fetch channel data.');
        }
        $channelName = $data['items'][0]['snippet']['title'];
        $thumbnails = $data['items'][0]['snippet']['thumbnails']['medium']['url'];
        $bannerImageUrl = $data['items'][0]['brandingSettings']['image']['bannerExternalUrl'];
        // dd($bannerImageUrl);
        $subscribersCount = $data['items'][0]['statistics']['subscriberCount'];
        $viewCount = $data['items'][0]['statistics']['viewCount'];
        $uploadsCount = $data['items'][0]['statistics']['videoCount'];
        $hiddenSubscriberCount = $data['items'][0]['statistics']['hiddenSubscriberCount'];
        $description = $data['items'][0]['snippet']['description'];
        $customUrl = $data['items'][0]['snippet']['customUrl'];
        $country = $data['items'][0]['snippet']['country'];

        if($hiddenSubscriberCount == true){
            $hiddenSubscriberCount = 'Yes, Is Hidden';
        } else {
            $hiddenSubscriberCount = 'No, Is Not Hidden';
        }

        return view('artists.components.youtubeCard',
        [
            'channelName' =>  $channelName, 
            'thumbnails'=> $thumbnails,
            'bannerImageUrl' => $bannerImageUrl.'=w2120-fcrop64=1,00005a57ffffa5a8-k-c0xffffffff-no-nd-rj',
            'customUrl' => $customUrl,
            'country' => $country,
            'description' => $description,
            'subscribersCount' => $subscribersCount, 
            'viewCount' => $viewCount, 
            'uploadsCount'=>$uploadsCount, 
            'hiddenSubscriberCount'=>$hiddenSubscriberCount, 
        ]);
    }
}

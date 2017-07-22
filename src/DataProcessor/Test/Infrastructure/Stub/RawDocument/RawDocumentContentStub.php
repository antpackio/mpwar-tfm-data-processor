<?php

namespace Mpwar\DataProcessor\Test\Infrastructure\Stub\RawDocument;

use Mpwar\DataProcessor\Domain\RawDocument\RawDocumentContent;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\Stub;

class RawDocumentContentStub extends Stub
{

    public static function random()
    {
        return self::create(self::factory()->text);
    }

    public static function create(string $content)
    {
        return new RawDocumentContent($content);
    }

    public static function empty()
    {
        return self::create("");
    }

    public static function validFromTwitter()
    {
        return self::create(
            self::tweetString()
        );
    }

    public static function validFromTwitterWithNullAuthor()
    {
        $content = json_decode(self::tweetString(), true);
        $content['user']['name'] = null;
        return self::create(
            json_encode($content)
        );
    }

    /**
     * @return string
     */
    private static function tweetString(): string
    {
        return "{
              \"coordinates\": null,
              \"favorited\": false,
              \"truncated\": false,
              \"created_at\": \"Mon Sep 24 03:35:21 +0000 2012\",
              \"id_str\": \"250075927172759552\",
              \"entities\": {
                \"urls\": [
        
                ],
                \"hashtags\": [
                  {
                    \"text\": \"freebandnames\",
                    \"indices\": [
                      20,
                      34
                    ]
                  }
                ],
                \"user_mentions\": [
        
                ]
              },
              \"in_reply_to_user_id_str\": null,
              \"contributors\": null,
              \"text\": \"Aggressive Ponytail #freebandnames\",
              \"metadata\": {
                \"iso_language_code\": \"en\",
                \"result_type\": \"recent\"
              },
              \"retweet_count\": 0,
              \"in_reply_to_status_id_str\": null,
              \"id\": 250075927172759552,
              \"geo\": null,
              \"retweeted\": false,
              \"in_reply_to_user_id\": null,
              \"place\": null,
              \"user\": {
                \"profile_sidebar_fill_color\": \"DDEEF6\",
                \"profile_sidebar_border_color\": \"C0DEED\",
                \"profile_background_tile\": false,
                \"name\": \"Sean Cummings\",
                \"profile_image_url\": \"http://a0.twimg.com/profile_images/2359746665/1v6zfgqo8g0d3mk7ii5s_normal.jpeg\",
                \"created_at\": \"Mon Apr 26 06:01:55 +0000 2010\",
                \"location\": \"LA, CA\",
                \"follow_request_sent\": null,
                \"profile_link_color\": \"0084B4\",
                \"is_translator\": false,
                \"id_str\": \"137238150\",
                \"entities\": {
                  \"url\": {
                    \"urls\": [
                      {
                        \"expanded_url\": null,
                        \"url\": \"\",
                        \"indices\": [
                          0,
                          0
                        ]
                      }
                    ]
                  },
                  \"description\": {
                    \"urls\": [
        
                    ]
                  }
                },
                \"default_profile\": true,
                \"contributors_enabled\": false,
                \"favourites_count\": 0,
                \"url\": null,
                \"profile_image_url_https\": \"https://si0.twimg.com/profile_images/2359746665/1v6zfgqo8g0d3mk7ii5s_normal.jpeg\",
                \"utc_offset\": -28800,
                \"id\": 137238150,
                \"profile_use_background_image\": true,
                \"listed_count\": 2,
                \"profile_text_color\": \"333333\",
                \"lang\": \"en\",
                \"followers_count\": 70,
                \"protected\": false,
                \"notifications\": null,
                \"profile_background_image_url_https\": \"https://si0.twimg.com/images/themes/theme1/bg.png\",
                \"profile_background_color\": \"C0DEED\",
                \"verified\": false,
                \"geo_enabled\": true,
                \"time_zone\": \"Pacific Time (US & Canada)\",
                \"description\": \"Born 330 Live 310\",
                \"default_profile_image\": false,
                \"profile_background_image_url\": \"http://a0.twimg.com/images/themes/theme1/bg.png\",
                \"statuses_count\": 579,
                \"friends_count\": 110,
                \"following\": null,
                \"show_all_inline_media\": false,
                \"screen_name\": \"sean_cummings\"
              },
              \"in_reply_to_screen_name\": null,
              \"source\": \"Twitter for Mac\",
              \"in_reply_to_status_id\": null
            }";
    }

    public static function validFromTwitterWithNullCreatedAt()
    {
        $content = json_decode(self::tweetString(), true);
        $content['created_at'] = null;
        return self::create(
            json_encode($content)
        );
    }

    public static function nonWellFormedTweet()
    {
        $content = json_decode(self::tweetString(), true);
        unset($content['user'], $content['text'], $content['created_at']);
        return self::create(
            json_encode($content)
        );
    }

    public static function validFromTwitterWithNullUserLocation()
    {
        $content = json_decode(self::tweetString(), true);
        $content['user']['location'] = null;
        return self::create(
            json_encode($content)
        );
    }

    public static function validFromTwitterWithNullLanguage()
    {
        $content = json_decode(self::tweetString(), true);
        $content['metadata']['iso_language_code'] = null;
        return self::create(
            json_encode($content)
        );
    }

    public static function validFromTwitterWithNullLanguageAndAuthorFields()
    {
        $content = json_decode(self::tweetString(), true);
        $content['metadata']['iso_language_code'] = null;
        $content['user']['location'] = null;
        $content['user']['name'] = null;
        return self::create(
            json_encode($content)
        );
    }
}

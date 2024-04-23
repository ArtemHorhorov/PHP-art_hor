<?php

namespace service;

use myclasses\HttpResponse;

require_once realpath($_SERVER["DOCUMENT_ROOT"]) .'/configs/config.php';

class MainService extends HttpResponse
{


    public function getHashtagList()
    {
        global $dbRespository;
        $result = $dbRespository->hashtagsList();
        if (!is_array($result)) {
            return $this->createHttpResponse(500, "cant get hashtags", null);
        } else {
            return $this->createHttpResponse(200, null, $result);
        }
    }

    public function getChannelList()
    {
        global $dbRespository;
        $result = $dbRespository->channelList();
        if (!is_array($result)) {
            return $this->createHttpResponse(500, "cant get channels", null);
        } else {
            return $this->createHttpResponse(200, null, $result);
        }
    }

    public function getHashTagListByFieldId($fieldId)
    {
        global $dbRespository;
        $result = $dbRespository->hashtagsListByFieldId($fieldId);
        if (!is_array($result)) {
            return $this->createHttpResponse(500, "cant get tags", null);
        } else {
            return $this->createHttpResponse(200, null, $result);
        }
    }

    public function getFielList()
    {
        global $dbRespository;
        $result = $dbRespository->fieldList();
        if (!is_array($result)) {
            return $this->createHttpResponse(500, "cant get hashtags", null);
        } else {
            return $this->createHttpResponse(200, null, $result);
        }
    }

    public function createPost($data, $channelId, $hashtagId, $userId, $save)
    {
        global $dbRespository;
        $result = $dbRespository->createSMS($data, $channelId, $hashtagId, $userId, $save);
        if (!is_array($result)) {
            return $this->createHttpResponse(500, "cant create post", null);
        } else {
            return $this->createHttpResponse(200, null, $result);
        }
    }

    public function getPostListByChannelIdByUserId($channelId, $userId)
    {
        global $dbRespository;
        $result = $dbRespository->smsListByChannelIdByUserId($channelId, $userId);
        if (!is_array($result)) {
            return $this->createHttpResponse(500, "cant get posts", null);
        } else {
            return $this->createHttpResponse(200, null, $result);
        }
    }
}
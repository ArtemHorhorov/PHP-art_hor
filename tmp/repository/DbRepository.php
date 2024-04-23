<?php

namespace repository;

use myclasses\Db;
use PDO;
use PDOException;

require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/configs/config.php';

class DbRepository extends Db
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = $this->getDbConnect();
    }

    public function addUser($username, $email, $password)
    {
        if (!$this->userExists($email))
        {
            $result = $this->pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $result->bindParam(1, $username);
            $result->bindParam(2, $email);
            $result->bindParam(3, $password);
            $result->execute();
            return $this->pdo->lastInsertId();
        }
        else
        {
            return false;
        }
    }

    public function getUser($email, $password)
    {
        $result = $this->pdo->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
        $result->bindParam(1, $email);
        $result->bindParam(2, $password);
        $result->execute();
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    public function userExists($email)
    {
        $result = $this->pdo->prepare("SELECT id FROM users WHERE email = :email");
        $result->bindParam(':email', $email);
        $result->execute();
        $result = $result->fetch(PDO::FETCH_ASSOC);
        return $result['id'];
    }

    public function hashtagsList()
    {
        $sth = $this->pdo->query("SELECT * FROM hashtag");
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    public function channelList()
    {
        $sth = $this->pdo->query("SELECT * FROM channel");
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fieldList()
    {
        $sth = $this->pdo->query("SELECT * FROM field");
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    public function hashtagsListByFieldId($fieldId)
    {
        $result = $this->pdo->prepare("
                    SELECT hashtag.* FROM hashtag
                     INNER JOIN table_rel tr ON tr.hashtag_id = hashtag.id
                     WHERE tr.field_id = ?
                    ");
        $result->bindParam(1, $fieldId);
        $result->execute();
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSMS($smsId)
    {
        $result = $this->pdo->prepare("SELECT * FROM sms WHERE id = ?");
        $result->bindParam(1, $smsId);
        $result->execute();
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    public function createSMS($data, $channelId, $hashtagId, $userId, $save)
    {
        try {
            $result = $this->pdo->prepare("INSERT INTO sms (data, channel_id, user_id, hashtag_id, save) VALUES (?, ?, ?, ?, ?)");
            $result->bindParam(1, $data);
            $result->bindParam(2, $channelId);
            $result->bindParam(3, $userId);
            $result->bindParam(4, $hashtagId);
            $result->bindParam(5, $save);
            $result->execute();
            return $this->getSMS($this->pdo->lastInsertId());
        } catch (PDOException $e) {
            return false;
        }
    }

    public function smsListByChannelIdByUserId($channelId, $userId)
    {
        try {
            $result = $this->pdo->prepare(
                                "SELECT sms.*, u.name AS user_name, channel.like_col AS like_col FROM `sms` 
                                    INNER JOIN users u ON u.id = sms.user_id 
                                    INNER JOIN channel ON channel.id = sms.channel_id
                                    WHERE channel_id = ? AND (user_id = ? or (user_id <> ? AND save = 0))");
            $result->bindParam(1, $channelId);
            $result->bindParam(2, $userId);
            $result->bindParam(3, $userId);
            $result->execute();
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }
}
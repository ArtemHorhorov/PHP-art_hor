<?php
require_once '../configs/config.php';

session_start();

if (!$_SESSION['logged'])
{
    header('Location: index.php');
}

if ($_GET['func'] === 'hashtagList')
{
    echo getHashtagList();
}

if ($_GET['func'] === 'fieldList') {
    echo  getFieldList();
}

if ($_GET['func'] === 'channelList') {
    echo getChannelList();
}

if ($_GET['func'] === 'hashtagListByFieldId')
{
    echo getHashtagListByFielId($_GET['field_id']);
}

if ($_POST['func'] === 'createPost') {
    $data = $_POST['data'];
    $channelId = $_POST['channel_id'];
    $hashtagId = $_POST['hashtag_id'];
    $userId = $_SESSION['id'];
    $save = $_POST['save'];
    echo createPost($data, $channelId, $hashtagId, $userId, $save);
}

if ($_POST['func'] === 'channelList') {
    $channelId = $_POST['channel_id'];
    $userId = $_SESSION['id'];
    echo getPostListByChannelId($channelId, $userId);
}

function createPost($data, $channelId, $hashtagId, $userId, $save)
{
    global $mainService;
    return $mainService->createPost($data, $channelId, $hashtagId, $userId, $save);
}

function getPostListByChannelId($channelId, $userId)
{
    global $mainService;
    return $mainService->getPostListByChannelIdByUserId($channelId, $userId);
}

function getChannelList()
{
    global $mainService;
    return $mainService->getChannelList();
}

function getHashtagListByFielId($fieldId)
{
    global $mainService;
    return $mainService->getHashTagListByFieldId($fieldId);
}

function getHashtagList()
{
    global $mainService;
    return $mainService->getHashtagList();
}

function getFieldList()
{
    global $mainService;
    return $mainService->getFielList();
}
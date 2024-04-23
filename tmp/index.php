<?php
    session_start();

//    var_dump($_SESSION);

    if ($_SESSION["logged"] !== true)
    {
        header("location: ./auth.php");
    }
    require_once "templates/header.php";
?>
    <div class="container">
        <div class="justify-content-between align-items-center d-flex">
            <div>
                <h3>Hi, <?echo $_SESSION['name'];?></h3>
            </div>
            <div class="text-center">
                <h1>Хэш сортер</h1>
            </div>
            <div>
                <button id="logout" class="btn btn-primary">Выход</button>
            </div>
        </div>


        <div class="d-flex justify-content-between mt-5">
            <div class="m-3">
                <form id="formCreatePost" class="input-group">
                    <div class="d-flex flex-column align-items-center">
                        <textarea id="textarea_post" class="form-control mb-3" placeholder="Текст" rows="3"></textarea>
                        <label for="hashtag_list" class="form-label">Хэштеги</label>
                        <select name="hashtag_list" id="hashtag_post" class="form-select optional mb-3">

                        </select>
                        <label for="channel_list" class="form-label">Знания</label>
                        <select name="channel_list" id="channel_post" class="form-select optional mb-3">

                        </select>
                        <div class="form-check form-switch mb-3">
                            <label for="check" class="form-check-label" data-color="info" tabindex="7">Сделать сообщение
                                приватным</label>
                            <input type="checkbox" name="check" id="check" class="form-check-input" value="0">
                        </div>
                        <div class="input-group-append mb-3">
                            <button id="create_post" class="btn btn-success">Добавить</button>
                        </div>

                    </div>
                </form>
            </div>
            <div class="w-75 m-3">
                <div class="d-flex flex-column align-items-center">
                    <select id="channel_select" name="chanel_list2" class="form-select optional">
                    </select>
                    <div id="smslist" class="">

                    </div>
                </div>
            </div>
        </div>

    </div>

    <script type="application/javascript">
        let cacheHashtagList;
        let userList;

        $(document).ready(function() {

            $('#check').change(function (e) {
                if ($(this).val() === "1") {
                    $(this).val("0")
                } else {
                    $(this).val("1")
                }
            });

            $.ajax({
                type: 'GET',
                url: '../controller/mainController.php',
                data: {
                    'func': 'hashtagList'
                },
                success: function (response) {
                    const responseJsonDecode = JSON.parse(response);

                    if (responseJsonDecode.code === 200) {
                        let optionalSelect = '<option selected>Выберите #...</option>'
                        cacheHashtagList = responseJsonDecode.message
                        responseJsonDecode.message.forEach((hashtagObg) => {
                            optionalSelect += '<option value="' + hashtagObg.id + '">' + hashtagObg.name + '</option>'
                        });
                        $('#hashtag_post').html(optionalSelect)
                    } else {
                        alert(responseJsonDecode.error);
                    }
                },
            });

            $('#channel_select').change(function (e) {
                e.preventDefault()
                loadSmsList($(this).val())
            });

            $.ajax({
                type: "GET",
                url: '../controller/mainController.php',
                data: {
                    'func': 'channelList'
                },
                success: function (response) {
                    const responseJsonDecode = JSON.parse(response);

                    if (responseJsonDecode.code === 200) {
                        let optionalSelect = '';
                        responseJsonDecode.message.forEach((hashtagObj) => {
                            optionalSelect += '<option value="' + hashtagObj.id +'">' + hashtagObj.name + '</option>'
                        })
                        $('#channel_post').html(optionalSelect)
                        $('#channel_select').html(optionalSelect)
                        // loadHashTag(responseJsonDecode.message[0].id)
                        loadSmsList(responseJsonDecode.message[0].id)
                    } else {
                        alert(responseJsonDecode.error)
                    }
                },
            })

            function loadSmsList(channelId) {
                $.ajax({
                    type: "POST",
                    url: "../controller/mainController.php",
                    data: {
                        'channel_id': channelId,
                        'func': 'channelList'
                    },
                    success: function (response) {
                        const responseJsonDecode = JSON.parse(response);
                        console.log(responseJsonDecode.message)
                        if (responseJsonDecode.code === 200) {
                            $('#smslist').html("")
                            responseJsonDecode.message.forEach((postObj) => {
                                postDiv = "" +
                                    "<div class='post'>" +
                                    "<div class='post_header d-flex justify-between'>" +
                                    "<div class='post_header_hashtag p-1'>#" + cacheHashtagList.find(hashtagObj => hashtagObj.id === postObj['hashtag_id']).name + "</div>" +
                                    "<div class='post_header_user p-1'>created by: " + postObj['user_name'] + "</div>" +
                                    "</div>" +
                                    "<div class='post_data'>"
                                    + postObj['data'] +
                                    "</div>"

                                if(postObj['like_col'] === 1) {
                                    postDiv += ""+
                                        "<div style='color: darkgreen'>Доверенный канал</div>" +
                                        "</div>"
                                } else {
                                    postDiv += "" +
                                        "<div style='color: red'>Непроверенный канал</div>" +
                                        "</div>"
                                }
                                $('#smslist').append(postDiv)
                            });
                        } else {
                            alert(responseJsonDecode.error)
                        }
                    },
                })
            }

            $("#formCreatePost").submit(function(e) {
                e.preventDefault()
                $.ajax({
                    type: "POST",
                    url: "../controller/mainController.php",
                    data: {
                        'data': $('#textarea_post').val(),
                        'channel_id': $('#channel_post').val(),
                        'hashtag_id': $('#hashtag_post').val(),
                        'save': $('#check').val(),
                        'func': 'createPost'
                    },
                    success: function (response) {
                        const responseJsonDecode = JSON.parse(response);
                        if (responseJsonDecode.code === 200) {
                            alert('post created')
                        } else {
                            alert(responseJsonDecode.error)
                        }
                    },
                })
            })

            $("#logout").click(function(e) {
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "../controller/authController.php",
                    data: {
                        'func': 'logout'
                    },
                    success: function(response) {
                        const responseJsonDecode = JSON.parse(response);
                        if (responseJsonDecode.code === 200) {
                            window.location.href = 'http://tmp/index.php'
                        } else {
                            alert(responseJsonDecode.error)
                        }
                    }
                })
            })
        })
    </script>
<?php
    require_once "templates/footer.php";
?>
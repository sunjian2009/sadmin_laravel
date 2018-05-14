<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <title>{{ config('app.name', 'sadmin') }}</title>
    <meta name="keywords" content="{{config('define.site.keywords')}}">
    <meta name="description" content="{{config('define.site.description')}}">
    <link rel="Bookmark" href="{{public_path()}}/favicon.ico">
    <link rel="Shortcut Icon" href="{{public_path()}}/favicon.ico"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('admins/hui/static/h-ui/css/H-ui.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('admins/hui/static/h-ui.admin/css/H-ui.admin.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('admins/hui/lib/Hui-iconfont/1.0.8/iconfont.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('admins/hui/lib/icheck/icheck.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admins/hui/static/h-ui.admin/skin/default/skin.css') }}" id="skin"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('admins/hui/static/h-ui.admin/css/style.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('admins/css/app.css') }}"/>
    <script type="text/javascript" src="{{ asset('admins/hui/lib/jquery/1.9.1/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admins/hui/lib/layer/2.4/layer.js') }}"></script>
    <!--<script src="__LIB__/layDate-v5.0.5/laydate/laydate.js"></script>-->
    <script type="text/javascript" src="{{ asset('admins/hui/lib/jquery.validation/1.14.0/jquery.validate.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admins/hui/lib/jquery.validation/1.14.0/validate-methods.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admins/hui/lib/jquery.validation/1.14.0/messages_zh.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admins/hui/static/h-ui/js/H-ui.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admins/hui/static/h-ui.admin/js/H-ui.admin.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admins/js/app.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admins/hui/lib/icheck/jquery.icheck.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admins/hui/lib/Validform/5.3.2/Validform.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admins/hui/lib/My97DatePicker/4.8/WdatePicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admins/hui/lib/webuploader/0.1.5/webuploader.min.js') }}"></script>
    <!--<script>window.UEDITOR_HOME_URL = '__LIB__/ueditor//1.4.3/'</script>-->
    <script type="text/javascript" src="{{ asset('admins/hui/lib/ueditor/1.4.3/ueditor.config.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admins/hui/lib/ueditor/1.4.3/ueditor.all.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admins/hui/lib/ueditor/1.4.3/lang/zh-cn/zh-cn.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admins/js/jquery.cxselect.js') }}"></script>

    <!--[if lt IE 9]>
    <script type="text/javascript" src="{{ asset('admins/hui/lib/html5shiv.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admins/hui/lib/respond.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admins/hui/lib/PIE_IE678.js') }}"></script>
    <![endif]-->

    <!--[if IE 6]>
    <script type="text/javascript" src="{{ asset('admin/hui/lib/app.css') }}/DD_belatedPNG_0.0.8a-min.js"></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->
@inject('common', 'App\Services\Common')
@include('admin.javascript_constant')
<!--添加文章分类的下拉菜单样式-->
    <style>
        .form-control {
            display: block;
            width: 100%;
            height: 34px;
            padding: 6px 12px;
            font-size: 14px;
            line-height: 1.42857143;
            color: #555;
            background-color: #fff;
            background-image: none;
            border: 1px solid #ccc;
            border-radius: 4px;
            -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
            -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
            -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
            transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
        }

    </style>

</head>
<body>

<script type="text/javascript">
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
    $(function () {
        $('.skin-minimal input').iCheck({
            checkboxClass: 'icheckbox-blue',
            radioClass: 'iradio-blue',
            increaseArea: '20%'
        });

        //表单验证
//                $("#form").validate({
//                    rules: {
//                        articletitle: {
//                            required: true,
//                        },
//                        articletitle2: {
//                            required: true,
//                        },
//                        articlecolumn: {
//                            required: true,
//                        },
//                        articletype: {
//                            required: true,
//                        },
//                        articlesort: {
//                            required: true,
//                        },
//                        keywords: {
//                            required: true,
//                        },
//                        abstract: {
//                            required: true,
//                        },
//                        author: {
//                            required: true,
//                        },
//                        sources: {
//                            required: true,
//                        },
//                        allowcomments: {
//                            required: true,
//                        },
//                        commentdatemin: {
//                            required: true,
//                        },
//                        commentdatemax: {
//                            required: true,
//                        },
//
//                    },
//                    onkeyup: false,
//                    focusCleanup: true,
//                    success: "valid",
//                    submitHandler: function (form) {
//                        //$(form).ajaxSubmit();
//                        var index = parent.layer.getFrameIndex(window.name);
//                        //parent.$('.btn-refresh').click();
//                        parent.layer.close(index);
//                    }
//
//                });

        $list = $("#fileList"),
            $btn = $("#btn-star"),
            state = "pending",
            uploader;

        var uploader = WebUploader.create({
            auto: true,
            swf: 'lib/webuploader/0.1.5/Uploader.swf',

            // 文件接收服务端。
            server: 'fileupload.php',

            // 选择文件的按钮。可选。
            // 内部根据当前运行是创建，可能是input元素，也可能是flash.
            pick: '#filePicker',

            // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
            resize: false,
            // 只允许选择图片文件。
            accept: {
                title: 'Images',
                extensions: 'gif,jpg,jpeg,bmp,png',
                mimeTypes: 'image/*'
            }
        });
        uploader.on('fileQueued', function (file) {
            var $li = $(
                '<div id="' + file.id + '" class="item">' +
                '<div class="pic-box"><img></div>' +
                '<div class="info">' + file.name + '</div>' +
                '<p class="state">等待上传...</p>' +
                '</div>'
                ),
                $img = $li.find('img');
            $list.append($li);

            // 创建缩略图
            // 如果为非图片文件，可以不用调用此方法。
            // thumbnailWidth x thumbnailHeight 为 100 x 100
            uploader.makeThumb(file, function (error, src) {
                if (error) {
                    $img.replaceWith('<span>不能预览</span>');
                    return;
                }

                $img.attr('src', src);
            }, thumbnailWidth, thumbnailHeight);
        });
        // 文件上传过程中创建进度条实时显示。
        uploader.on('uploadProgress', function (file, percentage) {
            var $li = $('#' + file.id),
                $percent = $li.find('.progress-box .sr-only');

            // 避免重复创建
            if (!$percent.length) {
                $percent = $('<div class="progress-box"><span class="progress-bar radius"><span class="sr-only" style="width:0%"></span></span></div>').appendTo($li).find('.sr-only');
            }
            $li.find(".state").text("上传中");
            $percent.css('width', percentage * 100 + '%');
        });

        // 文件上传成功，给item添加成功class, 用样式标记上传成功。
        uploader.on('uploadSuccess', function (file) {
            $('#' + file.id).addClass('upload-state-success').find(".state").text("已上传");
        });

        // 文件上传失败，显示上传出错。
        uploader.on('uploadError', function (file) {
            $('#' + file.id).addClass('upload-state-error').find(".state").text("上传出错");
        });

        // 完成上传完了，成功或者失败，先删除进度条。
        uploader.on('uploadComplete', function (file) {
            $('#' + file.id).find('.progress-box').fadeOut();
        });
        uploader.on('all', function (type) {
            if (type === 'startUpload') {
                state = 'uploading';
            } else if (type === 'stopUpload') {
                state = 'paused';
            } else if (type === 'uploadFinished') {
                state = 'done';
            }

            if (state === 'uploading') {
                $btn.text('暂停上传');
            } else {
                $btn.text('开始上传');
            }
        });

        $btn.on('click', function () {
            if (state === 'uploading') {
                uploader.stop();
            } else {
                uploader.upload();
            }
        });

        {{--var ue = UE.getEditor('editor', {--}}
        {{--serverUrl: '{{url('admin/upload')}}'--}}
        {{--});--}}


    });
</script>

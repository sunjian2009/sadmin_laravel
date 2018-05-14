﻿@include('admin.header')
<div class="page-container">
    <!--<p class="f-20 text-success">欢迎使用 {$Think.config.site.name} <span class="f-14">{$Think.config.site.version}</span> 后台管理系统！</p>-->
    <p>登录次数：{{$info->login_count}}</p>
    <p>当前登录IP：{{$current_login_ip}} &nbsp;&nbsp;&nbsp; 当前登录时间：{{session('current_login_time')}} &nbsp;&nbsp;&nbsp; 当前登录地点：{{$current_login_loc}}</p>
    @if (session('last_login_time'))
        <p>上次登录IP：{{$last_login_ip}} &nbsp;&nbsp;&nbsp; 上次登录时间：{{session('last_login_time')}} &nbsp;&nbsp;&nbsp; 上次登录地点：{{$last_login_loc}}</p>

    @endif
<!--    <div class="view-body think-editor-content">

        <h2>官方文档</h2>

        <p><a target="_blank" class="c-blue" href="http://doc.tpadmin.yuan1994.com">http://doc.tpadmin.yuan1994.com</a></p>

        <p class="c-red">tpadmin 官方交流群：518162472</p>

        <h2>仓库地址</h2>

        <p class="c-red">如果觉得不错就到 github 给个星哦</p>

        <p><a target="_blank" class="c-blue" href="https://github.com/yuan1994/tpadmin">https://github.com/yuan1994/tpadmin</a></p>

        <h2>使用方法</h2>

        <h3 id="composer-">composer安装：</h3>

        <p>composer create-project yuan1994/tpadmin tpadmin  --prefer-dist</p>

        <h3 id="git-">git克隆：</h3>

        <p>git clone https://github.com/yuan1994/tpadmin</p>

        <h3 id="-">直接下载：</h3>

        <p><a target="_blank" class="c-blue" href="https://github.com/yuan1994/tpadmin/archive/master.zip">https://github.com/yuan1994/tpadmin/archive/master.zip</a></p>

        <blockquote class="info">
            <p>框架的依赖需要通过 composer 下载，请在框架根目录执行 composer install ，已确保依赖的类库能下载下来</p>
        </blockquote>

        <h2>部署</h2>

        <p>参考 <a target="_blank" class="c-blue" href="http://www.kancloud.cn/manual/thinkphp5/129745">ThinkPHP5 - 部署</a></p>

        <p>部署成功后，建立新建数据库 tpadmin，导入项目根目录的 tpadmin.sql 文件，默认管理员帐号：admin，默认管理员密码：123456，然后访问 http://your-tpadmin-root-domain/admin</p>

        <h2>开发规范</h2>

        <p>请参考ThinkPHP5官方开发规范 <a href="http://www.kancloud.cn/manual/thinkphp5/118007">ThinkPHP5 - 开发规范</a></p>

        <h2>注意</h2>

        <p>为了确保代码自动生成可用，请在Linux/MacOS系统上使用项目时保证application文件夹有可写权限，本地开发可用将文件夹的权限改为777，线上部署请注意修改成安全的权限，为了更好的使用代码自动生成，请最好在Linux/MacOS系统上把Apache或php-fpm的用户修改为当前用户然后重启，可以避免权限问题</p>

        <h2>推荐</h2>

        <p>强烈推荐使用 tp-mailer 扩展类发送邮件，基于强大的 swiftmailer 开发，安装、使用非常简单，代码非常优美简便，详情请见 <a class="c-blue" href="https://github.com/yuan1994/tp-mailer" target="_blank">https://github.com/yuan1994/tp-mailer</a></p>

        <p>一款支持所有PHP框架的优美的邮件发送类，ThinkPHP系列框架开箱即用，其他框架初始化配置即可使用</p>

        <p>基于 SwiftMailer 二次开发, 为 ThinkPHP系列框架量身定制, 使 ThinkPHP 支持邮件模板、纯文本、附件邮件发送以及更多邮件功能, 邮件发送简单到只需一行代码</p>

        <p>同时了方便其他框架或者非框架使用, Tp Mailer也非常容易拓展融合到其他框架中, 欢迎大家 Fork 和 Star, 提交代码让Tp Mailer支持更多框架</p>
    </div>-->

<!--    <p class="c-red">以下为静态展示内容</p>
    <table class="table table-border table-bordered table-bg">
        <thead>
        <tr>
            <th colspan="7" scope="col">信息统计</th>
        </tr>
        <tr class="text-c">
            <th>统计</th>
            <th>资讯库</th>
            <th>图片库</th>
            <th>产品库</th>
            <th>用户</th>
            <th>管理员</th>
        </tr>
        </thead>
        <tbody>
        <tr class="text-c">
            <td>总数</td>
            <td>92</td>
            <td>9</td>
            <td>0</td>
            <td>8</td>
            <td>20</td>
        </tr>
        <tr class="text-c">
            <td>今日</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
        </tr>
        <tr class="text-c">
            <td>昨日</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
        </tr>
        <tr class="text-c">
            <td>本周</td>
            <td>2</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
        </tr>
        <tr class="text-c">
            <td>本月</td>
            <td>2</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
        </tr>
        </tbody>
    </table>-->
<!--    <table class="table table-border table-bordered table-bg mt-20">
        <thead>
        <tr>
            <th colspan="2" scope="col">服务器信息</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th width="30%">服务器计算机名</th>
            <td><span id="lbServerName">http://127.0.0.1/</span></td>
        </tr>
        <tr>
            <td>服务器IP地址</td>
            <td>192.168.1.1</td>
        </tr>
        <tr>
            <td>服务器域名</td>
            <td>www.h-ui.net</td>
        </tr>
        <tr>
            <td>服务器端口</td>
            <td>80</td>
        </tr>
        <tr>
            <td>服务器IIS版本</td>
            <td>Microsoft-IIS/6.0</td>
        </tr>
        <tr>
            <td>本文件所在文件夹</td>
            <td>D:\WebSite\HanXiPuTai.com\XinYiCMS.Web\</td>
        </tr>
        <tr>
            <td>服务器操作系统</td>
            <td>Microsoft Windows NT 5.2.3790 Service Pack 2</td>
        </tr>
        <tr>
            <td>系统所在文件夹</td>
            <td>C:\WINDOWS\system32</td>
        </tr>
        <tr>
            <td>服务器脚本超时时间</td>
            <td>30000秒</td>
        </tr>
        <tr>
            <td>服务器的语言种类</td>
            <td>Chinese (People's Republic of China)</td>
        </tr>
        <tr>
            <td>.NET Framework 版本</td>
            <td>2.050727.3655</td>
        </tr>
        <tr>
            <td>服务器当前时间</td>
            <td>2014-6-14 12:06:23</td>
        </tr>
        <tr>
            <td>服务器IE版本</td>
            <td>6.0000</td>
        </tr>
        <tr>
            <td>服务器上次启动到现在已运行</td>
            <td>7210分钟</td>
        </tr>
        <tr>
            <td>逻辑驱动器</td>
            <td>C:\D:\</td>
        </tr>
        <tr>
            <td>CPU 总数</td>
            <td>4</td>
        </tr>
        <tr>
            <td>CPU 类型</td>
            <td>x86 Family 6 Model 42 Stepping 1, GenuineIntel</td>
        </tr>
        <tr>
            <td>虚拟内存</td>
            <td>52480M</td>
        </tr>
        <tr>
            <td>当前程序占用内存</td>
            <td>3.29M</td>
        </tr>
        <tr>
            <td>Asp.net所占内存</td>
            <td>51.46M</td>
        </tr>
        <tr>
            <td>当前Session数量</td>
            <td>8</td>
        </tr>
        <tr>
            <td>当前SessionID</td>
            <td>gznhpwmp34004345jz2q3l45</td>
        </tr>
        <tr>
            <td>当前系统用户名</td>
            <td>NETWORK SERVICE</td>
        </tr>
        </tbody>
    </table>-->
</div>
<footer class="footer mt-20">
    <div class="container">
        <p></p>
<!--        <p>
            感谢jQuery、layer、laypage、Validform、UEditor、My97DatePicker、iconfont、Datatables、WebUploaded、icheck、highcharts、bootstrap-Switch、H-ui、H-ui.admin<br>
            Copyright &copy;2016 {$Think.config.site.name} {$Think.config.site.version} All Rights Reserved.<br>
            本后台系统由<a href="http://www.h-ui.net/" target="_blank" rel="nofollow" title="H-ui前端框架">H-ui前端框架</a>提供前端技术支持</p>-->
    </div>
</footer>

</body>
</html>
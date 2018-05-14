<?php $route = $common::getControllerActionName(); ?>
<script>
    window.APP_ROOT = "{{url('/')}}";
    window.APP_MODULE = "{{$route['module']}}";
    window.APP_CONTROLLER = "{{$route['controller']}}";
</script>
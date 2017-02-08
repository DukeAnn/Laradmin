{{--面包屑--}}
<div class="page-bar">
    <ul class="page-breadcrumb">
        {!! $crumbs->getCrumbs() !!}
    </ul>
</div>
{{--页面标题--}}
{!! $crumbs->getPageTitle() !!}
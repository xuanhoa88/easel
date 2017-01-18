<div id="authUserId" data-field-message="{{ Auth::guard('canvas')->user()->id }}"></div>
<script type="text/javascript">
    $(document).ready(function(){
        $("#users").bootgrid({
            css: {
                icon: 'zmdi icon',
                iconColumns: 'zmdi-view-module',
                iconDown: 'zmdi-sort-amount-desc',
                iconRefresh: 'zmdi-refresh',
                iconUp: 'zmdi-sort-amount-asc'
            },
            formatters: {
                "commands": function(column, row) {
                    var authenticatedUserId = $("#authUserId").data("field-message");
                    if (row.id === authenticatedUserId) {
                        return "<a href='{{ url('admin/profile') }}'><button type='button' class='btn btn-icon command-edit waves-effect waves-circle'><span class='zmdi zmdi-edit'></span></button></a>";
                    } else {
                        return "<a href='{{ url('admin/user') }}/" + row.id + "/edit'><button type='button' class='btn btn-icon command-edit waves-effect waves-circle'><span class='zmdi zmdi-edit'></span></button></a>";
                    }
                }
            }
        });
    });
</script>

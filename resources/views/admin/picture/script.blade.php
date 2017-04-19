<script type="text/javascript">
    var initEditables = function() {

        //set editable mode based on URL parameter
        if (App.getURLParameter('mode') == 'inline') {
            $.fn.editable.defaults.mode = 'inline';
            $('#inline').attr("checked", true);
        } else {
            $('#inline').attr("checked", false);
        }

        //global settings
        $.fn.editable.defaults.inputclass = 'form-control';
        $.fn.editable.defaults.url = '/post';
        $.fn.editable.defaults.ajaxOptions = {type: "PUT"};
        @if($set_all->count() > 0)
            @foreach($set_all as $value)
            $('#{{ $value->code }}').editable({
                success: function(response, newValue) {
                    if(response.code == 1) return response.message; //msg will be shown in editable form
                }
            });
            @endforeach
        @endif
        var countries = [];
        $.each({
            "CN": "China"
        }, function(k, v) {
            countries.push({
                id: k,
                text: v
            });
        });
    }
</script>

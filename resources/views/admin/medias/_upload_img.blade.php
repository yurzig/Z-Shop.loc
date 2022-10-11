<script>
    window.onload = function() {
        $(document).on('change','.js-img',function(){
            const files = this.files;

            if( typeof files === 'undefined' ) return;

            let fd = new FormData();
            fd.append( 'file',files[0] );

            $.ajax({
                method      : 'POST',
                url         : '{{ route('admin.media.uploadimg') }}',
                data        : fd,
                headers     : {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                dataType    : 'json',
                processData : false,
                contentType : false,

                success     : function( response ){
                    if(response.success == 1) {
                        document.getElementById('upload-img').src = response.filepath;
                    } else {
                        console.log(response.message);
                    }
                },
                error: function( response ){
                    console.log( 'AJAX error: ' + JSON.stringify(response));
                }
            });
        });
    };
</script>


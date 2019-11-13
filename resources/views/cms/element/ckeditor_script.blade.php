<script type="text/javascript">
    CKEDITOR.replace('ckeditor', {
        height: '{!! isset($height)?$height:300 !!}',
        filebrowserBrowseUrl: '/js/ckfinder/ckfinder.html',
        filebrowserImageBrowseUrl: '/js/ckfinder/ckfinder.html?type=Images',
        filebrowserUploadUrl: '/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
        filebrowserImageUploadUrl: '/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images'
    });
</script>
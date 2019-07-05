<!-- Delete button Warrning Modal -->
<div class="modal fade" id="confirmButton" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $title }}</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
            {{ $slot }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>

                <button type="button" value="Delete" class="btn btn-danger btn-modal-delete">Delete</button>
            </div>
        </div>
    </div>
</div>
<!-- Delete button Warrning Modal End-->

@section('script')
<script>
var deleteItemForm = null;

$(document).ready(function(){
    $('.btn-delete').click(function(event){
        event.preventDefault();
        
        deleteItemForm = $(this).parent().attr('id');
    });

    $('.btn-modal-delete').click(function(){
        $('#'+deleteItemForm).submit();
    });
});
</script>
@endsection
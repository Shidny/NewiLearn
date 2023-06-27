{{-- layout.main as parent --}}
@extends('layouts.main') 

{{-- for setup  --}}
  @section('title','Ilearn Portal')

  @section('content')
<div id="categories_vue"></div>

<script>
    var entities = {!! json_encode($entities) !!};
</script>

<!-- The modal -->
<div class="modal fade" id="get_item_list">
    <div class="modal-dialog modal-lg" style="width: 60%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Item List</h4>
            </div>
            <div class="modal-body">

            </div> 
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-o" data-dismiss="modal">
                    Close
                </button>
            </div>
        </div>
    </div>
</div> 
    @vite('resources/js/categories.js')
@endsection


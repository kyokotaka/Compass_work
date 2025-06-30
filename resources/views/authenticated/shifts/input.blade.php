<x-sidebar>
シフト登録画面
<div class="user_status p-3">
<form action="{{ route('schedule.import') }}" method="post" enctype="multipart/form-data">
    @csrf
    <label name="csvFile">csvファイルをアップロード</label>
    <input type="file" name="csvFile" class="" id="csvFile"/>
    <input type="submit" value="アップロード"></input>
</form>
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
</div>

</x-sidebar>
